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
     * Récupère tous les besoins NON ENCORE COUVERTS à 100%, triés par date (anciens en premier)
     * Retourne la quantité restante à couvrir pour chaque besoin
     * Prend en compte les allocations (dispatch) ET les achats
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
                    b.quantite_besoin AS quantite_besoin_initiale,
                    COALESCE(a.total_attribue, 0) AS quantite_deja_attribuee,
                    COALESCE(ach.total_achete, 0) AS quantite_achetee,
                    (b.quantite_besoin - COALESCE(a.total_attribue, 0) - COALESCE(ach.total_achete, 0)) AS quantite_besoin,
                    p.pu,
                    ((b.quantite_besoin - COALESCE(a.total_attribue, 0) - COALESCE(ach.total_achete, 0)) * p.pu) AS montant_estime,
                    b.date_besoin
                FROM besoin_ville_vonjy b
                JOIN ville_vonjy v ON b.id_ville = v.id
                JOIN region_vonjy r ON v.id_region = r.id
                JOIN produit_vonjy p ON b.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_attribuee) AS total_attribue
                    FROM allocation_don_vonjy
                    GROUP BY id_besoin
                ) a ON a.id_besoin = b.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_achetee) AS total_achete
                    FROM achat_vonjy
                    GROUP BY id_besoin
                ) ach ON ach.id_besoin = b.id
                WHERE (b.quantite_besoin - COALESCE(a.total_attribue, 0) - COALESCE(ach.total_achete, 0)) > 0
                ORDER BY b.date_besoin ASC, b.id ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le stock DISPONIBLE de dons par produit (total - déjà alloué)
     */
    public function getStockDonsParProduit(): array {
        $sql = "SELECT 
                    d.id_produit,
                    p.nom_produit,
                    c.nom_categorie,
                    p.pu,
                    SUM(d.quantite_don) AS stock_total,
                    COALESCE(alloc.total_alloue, 0) AS stock_alloue,
                    (SUM(d.quantite_don) - COALESCE(alloc.total_alloue, 0)) AS stock_disponible
                FROM don_vonjy d
                JOIN produit_vonjy p ON d.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
                LEFT JOIN (
                    SELECT id_produit, SUM(quantite_attribuee) AS total_alloue
                    FROM allocation_don_vonjy
                    GROUP BY id_produit
                ) alloc ON alloc.id_produit = d.id_produit
                GROUP BY d.id_produit, p.nom_produit, c.nom_categorie, p.pu, alloc.total_alloue";
        
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Indexer par id_produit pour accès rapide
        $stock = [];
        foreach ($results as $row) {
            $stock[$row['id_produit']] = $row;
            // Utiliser le stock disponible au lieu du stock total
            $stock[$row['id_produit']]['stock_total'] = max(0, (float)$row['stock_disponible']);
        }
        return $stock;
    }

    /**
     * Récupère le total des dons DISPONIBLES (non encore alloués)
     */
    public function getTotalDons(): float {
        $sql = "SELECT 
                    COALESCE(SUM(d.quantite_don * p.pu), 0) - 
                    COALESCE((SELECT SUM(a.quantite_attribuee * p2.pu) 
                              FROM allocation_don_vonjy a 
                              JOIN produit_vonjy p2 ON a.id_produit = p2.id), 0) AS total_dons
                FROM don_vonjy d
                JOIN produit_vonjy p ON d.id_produit = p.id";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return max(0, (float) ($result['total_dons'] ?? 0));
    }

    /**
     * Récupère le total des besoins RESTANTS (non encore couverts par dispatch ou achat)
     */
    public function getTotalBesoins(): float {
        $sql = "SELECT COALESCE(SUM((b.quantite_besoin - COALESCE(a.total_attribue, 0) - COALESCE(ach.total_achete, 0)) * p.pu), 0) AS total_besoins
                FROM besoin_ville_vonjy b
                JOIN produit_vonjy p ON b.id_produit = p.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_attribuee) AS total_attribue
                    FROM allocation_don_vonjy
                    GROUP BY id_besoin
                ) a ON a.id_besoin = b.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_achetee) AS total_achete
                    FROM achat_vonjy
                    GROUP BY id_besoin
                ) ach ON ach.id_besoin = b.id
                WHERE (b.quantite_besoin - COALESCE(a.total_attribue, 0) - COALESCE(ach.total_achete, 0)) > 0";
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

    /**
     * Vérifie si une distribution a déjà été effectuée
     */
    public function hasDistribution(): bool {
        $stmt = $this->db->query("SELECT COUNT(*) AS nb FROM allocation_don_vonjy");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['nb'] > 0;
    }

    /**
     * Vérifie s'il y a des dons disponibles à distribuer
     */
    public function hasDonsDisponibles(): bool {
        return $this->getTotalDons() > 0;
    }

    /**
     * Vérifie s'il y a des besoins restants à couvrir
     */
    public function hasBesoinsRestants(): bool {
        return $this->getTotalBesoins() > 0;
    }

    /**
     * Peut-on distribuer ? (dons disponibles ET besoins restants)
     */
    public function canDistribute(): bool {
        return $this->hasDonsDisponibles() && $this->hasBesoinsRestants();
    }

    /**
     * Distribue les dons disponibles aux besoins restants.
     * Peut être appelé plusieurs fois tant qu'il y a des dons et des besoins.
     * Enregistre l'historique de chaque distribution.
     * 
     * @return array Résultat de la distribution (même format que simulerDispatch)
     * @throws \Exception si aucun don disponible ou aucun besoin restant
     */
    public function distribuerDons(): array {
        // Vérifier qu'on peut distribuer
        if (!$this->hasDonsDisponibles()) {
            throw new \Exception('Aucun don disponible à distribuer.');
        }
        if (!$this->hasBesoinsRestants()) {
            throw new \Exception('Tous les besoins sont déjà couverts.');
        }

        // Lancer la simulation pour obtenir les allocations
        $simulation = $this->simulerDispatch();

        // Vérifier qu'il y a quelque chose à distribuer
        $nbAllocations = 0;
        foreach ($simulation['allocations'] as $alloc) {
            if ($alloc['quantite_attribuee'] > 0) {
                $nbAllocations++;
            }
        }
        
        if ($nbAllocations === 0) {
            throw new \Exception('Aucune allocation possible avec le stock actuel.');
        }

        // Transaction pour garantir la cohérence
        $this->db->beginTransaction();
        try {
            // 1. Insérer les allocations
            $stmt = $this->db->prepare(
                "INSERT INTO allocation_don_vonjy (id_besoin, id_produit, id_ville, quantite_attribuee) 
                 VALUES (:id_besoin, :id_produit, :id_ville, :quantite_attribuee)"
            );

            $nbCouverts = 0;
            $nbPartiels = 0;
            foreach ($simulation['allocations'] as $alloc) {
                if ($alloc['quantite_attribuee'] > 0) {
                    $stmt->execute([
                        'id_besoin' => $alloc['id_besoin'],
                        'id_produit' => $alloc['id_produit'],
                        'id_ville' => $alloc['id_ville'],
                        'quantite_attribuee' => $alloc['quantite_attribuee']
                    ]);
                    
                    // Compter les couvertures
                    if ($alloc['quantite_manquante'] <= 0) {
                        $nbCouverts++;
                    } else {
                        $nbPartiels++;
                    }
                }
            }

            // 2. Enregistrer dans l'historique
            $totalDonsAvant = $simulation['totaux']['total_dons'];
            $stmtHist = $this->db->prepare(
                "INSERT INTO distribution_historique_vonjy 
                 (total_dons_disponibles, total_attribue, nb_allocations, nb_besoins_couverts, nb_besoins_partiels, commentaire) 
                 VALUES (:total_dons, :total_attribue, :nb_alloc, :nb_couverts, :nb_partiels, :commentaire)"
            );
            $stmtHist->execute([
                'total_dons' => $totalDonsAvant,
                'total_attribue' => $simulation['totaux']['total_attribue'],
                'nb_alloc' => $nbAllocations,
                'nb_couverts' => $nbCouverts,
                'nb_partiels' => $nbPartiels,
                'commentaire' => 'Distribution automatique par ordre de date de besoin'
            ]);

            $this->db->commit();
            return $simulation;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Récupère l'historique des distributions
     */
    public function getHistoriqueDistributions(): array {
        $sql = "SELECT * FROM distribution_historique_vonjy ORDER BY date_distribution DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les besoins NON couverts à 100%
     * Un besoin est considéré couvert à 100% si quantite_attribuee >= quantite_besoin
     */
    public function getBesoinsNonCouverts(): array {
        $sql = "SELECT 
                    b.id,
                    b.id_ville,
                    v.nom_ville,
                    b.id_produit,
                    p.nom_produit,
                    c.nom_categorie,
                    p.pu,
                    b.quantite_besoin,
                    COALESCE(a.total_attribue, 0) AS quantite_attribuee,
                    COALESCE(ach.total_achete, 0) AS quantite_achetee,
                    (b.quantite_besoin - COALESCE(a.total_attribue, 0) - COALESCE(ach.total_achete, 0)) AS quantite_restante,
                    b.date_besoin
                FROM besoin_ville_vonjy b
                JOIN ville_vonjy v ON b.id_ville = v.id
                JOIN produit_vonjy p ON b.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_attribuee) AS total_attribue
                    FROM allocation_don_vonjy
                    GROUP BY id_besoin
                ) a ON a.id_besoin = b.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_achetee) AS total_achete
                    FROM achat_vonjy
                    GROUP BY id_besoin
                ) ach ON ach.id_besoin = b.id
                WHERE (b.quantite_besoin - COALESCE(a.total_attribue, 0) - COALESCE(ach.total_achete, 0)) > 0
                ORDER BY b.date_besoin ASC, b.id ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
