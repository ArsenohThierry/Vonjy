<?php

namespace app\models;

use PDO;

class DispatchModel {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Récupère tous les besoins non satisfaits, triés par date (anciens en premier)
     */
    public function getAllBesoinsOrderByDate(): array {
        $sql = "SELECT 
                    b.id AS id_besoin,
                    b.id_ville,
                    v.nom_ville,
                    r.nom_region,
                    b.id_produit,
                    p.nom_produit,
                    c.nom_categorie,
                    b.quantite_besoin,
                    p.pu,
                    (b.quantite_besoin * p.pu) AS montant_estime,
                    b.date_besoin
                FROM besoin_ville_vonjy b
                JOIN ville_vonjy v ON b.id_ville = v.id
                JOIN region_vonjy r ON v.id_region = r.id
                JOIN produit_vonjy p ON b.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
                ORDER BY b.date_besoin ASC, b.id ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le stock total de dons par produit
     */
    public function getStockDonsParProduit(): array {
        $sql = "SELECT 
                    d.id_produit,
                    p.nom_produit,
                    c.nom_categorie,
                    p.pu,
                    SUM(d.quantite_don) AS stock_total
                FROM don_vonjy d
                JOIN produit_vonjy p ON d.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
                GROUP BY d.id_produit, p.nom_produit, c.nom_categorie, p.pu";
        
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Indexer par id_produit pour accès rapide
        $stock = [];
        foreach ($results as $row) {
            $stock[$row['id_produit']] = $row;
        }
        return $stock;
    }

    /**
     * Récupère le total des dons en valeur estimée
     */
    public function getTotalDons(): float {
        $sql = "SELECT COALESCE(SUM(d.quantite_don * p.pu), 0) AS total_dons
                FROM don_vonjy d
                JOIN produit_vonjy p ON d.id_produit = p.id";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['total_dons'] ?? 0);
    }

    /**
     * Récupère le total des besoins en valeur estimée
     */
    public function getTotalBesoins(): float {
        $sql = "SELECT COALESCE(SUM(b.quantite_besoin * p.pu), 0) AS total_besoins
                FROM besoin_ville_vonjy b
                JOIN produit_vonjy p ON b.id_produit = p.id";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['total_besoins'] ?? 0);
    }

    /**
     * Simule le dispatch des dons aux besoins par ordre de date
     * NE MODIFIE PAS la base de données
     * 
     * Retourne un tableau avec :
     * - 'allocations' : détail de chaque allocation (besoin -> quantité attribuée)
     * - 'par_ville' : résumé par ville (total besoins, total attribué, reste)
     * - 'stock_restant' : stock restant après simulation
     */
    public function simulerDispatch(): array {
        // 1. Récupérer les besoins triés par date (priorité aux plus anciens)
        $besoins = $this->getAllBesoinsOrderByDate();
        
        // 2. Récupérer le stock disponible par produit
        $stock = $this->getStockDonsParProduit();
        
        // Copie du stock pour ne pas modifier le stock réel
        $stockDisponible = [];
        foreach ($stock as $idProduit => $s) {
            $stockDisponible[$idProduit] = (float) $s['stock_total'];
        }
        
        // 3. Tableau résultat
        $allocations = [];
        $parVille = [];
        
        // 4. Parcourir les besoins par ordre de date
        foreach ($besoins as $besoin) {
            $idProduit = $besoin['id_produit'];
            $idVille = $besoin['id_ville'];
            $nomVille = $besoin['nom_ville'];
            $nomRegion = $besoin['nom_region'];
            $quantiteDemandee = (float) $besoin['quantite_besoin'];
            $pu = (float) $besoin['pu'];
            
            // Initialiser la ville dans le résumé si pas encore fait
            if (!isset($parVille[$idVille])) {
                $parVille[$idVille] = [
                    'id_ville' => $idVille,
                    'nom_ville' => $nomVille,
                    'nom_region' => $nomRegion,
                    'total_besoins' => 0,
                    'total_attribue' => 0,
                    'reste' => 0,
                    'details' => []
                ];
            }
            
            // Montant du besoin
            $montantBesoin = $quantiteDemandee * $pu;
            $parVille[$idVille]['total_besoins'] += $montantBesoin;
            
            // Vérifier le stock disponible
            $stockProduit = $stockDisponible[$idProduit] ?? 0;
            
            // Calculer la quantité attribuée
            $quantiteAttribuee = min($quantiteDemandee, $stockProduit);
            $montantAttribue = $quantiteAttribuee * $pu;
            
            // Déduire du stock disponible
            if ($quantiteAttribuee > 0) {
                $stockDisponible[$idProduit] -= $quantiteAttribuee;
            }
            
            // Enregistrer l'allocation
            $allocation = [
                'id_besoin' => $besoin['id_besoin'],
                'id_ville' => $idVille,
                'nom_ville' => $nomVille,
                'id_produit' => $idProduit,
                'nom_produit' => $besoin['nom_produit'],
                'nom_categorie' => $besoin['nom_categorie'],
                'quantite_demandee' => $quantiteDemandee,
                'quantite_attribuee' => $quantiteAttribuee,
                'quantite_manquante' => $quantiteDemandee - $quantiteAttribuee,
                'pu' => $pu,
                'montant_besoin' => $montantBesoin,
                'montant_attribue' => $montantAttribue,
                'date_besoin' => $besoin['date_besoin']
            ];
            
            $allocations[] = $allocation;
            $parVille[$idVille]['total_attribue'] += $montantAttribue;
            $parVille[$idVille]['details'][] = $allocation;
        }
        
        // 5. Calculer le reste par ville
        foreach ($parVille as &$ville) {
            $ville['reste'] = $ville['total_besoins'] - $ville['total_attribue'];
            
            // Déterminer le statut
            if ($ville['reste'] <= 0) {
                $ville['statut'] = 'couvert';
            } elseif ($ville['total_attribue'] > 0) {
                $ville['statut'] = 'partiel';
            } else {
                $ville['statut'] = 'non-couvert';
            }
            
            // Taux de couverture
            $ville['taux_couverture'] = $ville['total_besoins'] > 0 
                ? round(($ville['total_attribue'] / $ville['total_besoins']) * 100, 1) 
                : 0;
        }
        unset($ville);
        
        // 6. Stock restant
        $stockRestant = [];
        foreach ($stock as $idProduit => $s) {
            $stockRestant[$idProduit] = [
                'nom_produit' => $s['nom_produit'],
                'nom_categorie' => $s['nom_categorie'],
                'stock_initial' => (float) $s['stock_total'],
                'stock_restant' => $stockDisponible[$idProduit] ?? 0,
                'pu' => (float) $s['pu']
            ];
        }
        
        // 7. Totaux globaux
        $totalAttribue = array_sum(array_column($parVille, 'total_attribue'));
        $totalBesoins = array_sum(array_column($parVille, 'total_besoins'));
        $totalReste = $totalBesoins - $totalAttribue;
        $tauxGlobal = $totalBesoins > 0 ? round(($totalAttribue / $totalBesoins) * 100, 1) : 0;
        
        // Compter les statuts
        $nbCouvert = count(array_filter($parVille, fn($v) => $v['statut'] === 'couvert'));
        $nbPartiel = count(array_filter($parVille, fn($v) => $v['statut'] === 'partiel'));
        $nbNonCouvert = count(array_filter($parVille, fn($v) => $v['statut'] === 'non-couvert'));
        
        return [
            'allocations' => $allocations,
            'par_ville' => $parVille,
            'stock_restant' => $stockRestant,
            'totaux' => [
                'total_dons' => $this->getTotalDons(),
                'total_besoins' => $totalBesoins,
                'total_attribue' => $totalAttribue,
                'total_reste' => $totalReste,
                'taux_couverture' => $tauxGlobal,
                'nb_couvert' => $nbCouvert,
                'nb_partiel' => $nbPartiel,
                'nb_non_couvert' => $nbNonCouvert
            ]
        ];
    }
}
