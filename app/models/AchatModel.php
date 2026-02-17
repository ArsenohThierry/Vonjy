<?php

namespace app\models;

use PDO;

class AchatModel {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Récupère le pourcentage de frais d'achat depuis la config
     */
    public function getFraisPourcent(): float {
        $stmt = $this->db->prepare("SELECT valeur FROM config_vonjy WHERE cle = :cle");
        $stmt->execute(['cle' => 'frais_achat_pourcent']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['valeur'] ?? 10);
    }

    /**
     * Met à jour le pourcentage de frais d'achat
     */
    public function setFraisPourcent(float $pourcent): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO config_vonjy (cle, valeur, description) 
             VALUES ('frais_achat_pourcent', :valeur, 'Pourcentage de frais sur les achats')
             ON DUPLICATE KEY UPDATE valeur = :valeur2"
        );
        return $stmt->execute(['valeur' => $pourcent, 'valeur2' => $pourcent]);
    }

    /**
     * Récupère le total des dons de type "Argent" (catégorie Argent)
     * Ne prend en compte que les dons dont le produit est de catégorie "Argent"
     */
    public function getTotalDonsArgent(): float {
        $sql = "SELECT COALESCE(SUM(d.quantite_don * p.pu), 0) AS total_argent
                FROM don_vonjy d
                JOIN produit_vonjy p ON d.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
                WHERE LOWER(c.nom_categorie) = 'argent'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['total_argent'] ?? 0);
    }

    /**
     * Vérifie s'il existe des achats dans le système
     */
    public function hasAchats(): bool {
        $sql = "SELECT COUNT(*) AS nb FROM achat_vonjy";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ((int) $result['nb']) > 0;
    }

    /**
     * Récupère le total des achats déjà effectués (montant_total avec frais)
     */
    public function getTotalAchatsEffectues(): float {
        $sql = "SELECT COALESCE(SUM(montant_total), 0) AS total_achats FROM achat_vonjy";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['total_achats'] ?? 0);
    }

    /**
     * Récupère l'argent disponible pour les achats
     * = Total dons argent - Total achats effectués
     */
    public function getArgentDisponible(): float {
        return max(0, $this->getTotalDonsArgent() - $this->getTotalAchatsEffectues());
    }

    /**
     * Calcule le coût d'un achat avec les frais
     * @return array ['montant_ht' => ..., 'montant_frais' => ..., 'montant_total' => ...]
     */
    public function calculerCoutAchat(int $quantite, float $prixUnitaire): array {
        $fraisPourcent = $this->getFraisPourcent();
        $montantHT = $quantite * $prixUnitaire;
        $montantFrais = $montantHT * ($fraisPourcent / 100);
        $montantTotal = $montantHT + $montantFrais;

        return [
            'quantite' => $quantite,
            'prix_unitaire' => $prixUnitaire,
            'frais_pourcent' => $fraisPourcent,
            'montant_ht' => $montantHT,
            'montant_frais' => $montantFrais,
            'montant_total' => $montantTotal
        ];
    }

    /**
     * Récupère les détails d'un besoin pour l'achat
     */
    public function getBesoinPourAchat(int $idBesoin): ?array {
        $sql = "SELECT 
                    b.id AS id_besoin,
                    b.id_ville,
                    v.nom_ville,
                    b.id_produit,
                    p.nom_produit,
                    c.nom_categorie,
                    p.pu,
                    b.quantite_besoin,
                    COALESCE(alloc.total_attribue, 0) AS quantite_dispatch,
                    COALESCE(ach.total_achete, 0) AS quantite_achetee,
                    (b.quantite_besoin - COALESCE(alloc.total_attribue, 0) - COALESCE(ach.total_achete, 0)) AS quantite_restante,
                    b.date_besoin
                FROM besoin_ville_vonjy b
                JOIN ville_vonjy v ON b.id_ville = v.id
                JOIN produit_vonjy p ON b.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_attribuee) AS total_attribue
                    FROM allocation_don_vonjy
                    GROUP BY id_besoin
                ) alloc ON alloc.id_besoin = b.id
                LEFT JOIN (
                    SELECT id_besoin, SUM(quantite_achetee) AS total_achete
                    FROM achat_vonjy
                    GROUP BY id_besoin
                ) ach ON ach.id_besoin = b.id
                WHERE b.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $idBesoin]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Vérifie si le produit du besoin est disponible dans les dons restants
     * (dons - allocations dispatch)
     */
    public function produitDisponibleEnDon(int $idProduit, int $quantite): bool {
        $sql = "SELECT 
                    (COALESCE(SUM(d.quantite_don), 0) - COALESCE(alloc.total_alloue, 0)) AS stock_disponible
                FROM don_vonjy d
                LEFT JOIN (
                    SELECT id_produit, SUM(quantite_attribuee) AS total_alloue
                    FROM allocation_don_vonjy
                    GROUP BY id_produit
                ) alloc ON alloc.id_produit = d.id_produit
                WHERE d.id_produit = :id_produit
                GROUP BY d.id_produit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_produit' => $idProduit]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stockDispo = (float) ($result['stock_disponible'] ?? 0);
        return $stockDispo >= $quantite;
    }

    /**
     * Effectue un achat
     * @throws \Exception si validation échoue
     */
    public function effectuerAchat(int $idBesoin, int $quantite): array {
        // 1. Récupérer les détails du besoin
        $besoin = $this->getBesoinPourAchat($idBesoin);
        if (!$besoin) {
            throw new \Exception("Besoin introuvable.");
        }

        // 2. Vérifier que ce n'est pas un besoin de type Argent
        if (strtolower($besoin['nom_categorie']) === 'argent') {
            throw new \Exception("On ne peut pas acheter un besoin de type Argent.");
        }

        // 3. Vérifier la quantité
        if ($quantite <= 0) {
            throw new \Exception("La quantité doit être supérieure à 0.");
        }
        if ($quantite > $besoin['quantite_restante']) {
            throw new \Exception("Quantité demandée ({$quantite}) supérieure à la quantité restante ({$besoin['quantite_restante']}).");
        }

        // 4. Vérifier si le produit existe dans les dons restants (erreur si oui)
        if ($this->produitDisponibleEnDon($besoin['id_produit'], $quantite)) {
            throw new \Exception("Ce produit est encore disponible dans les dons restants. Utilisez d'abord le dispatch avant d'acheter.");
        }

        // 5. Calculer le coût avec frais
        $cout = $this->calculerCoutAchat($quantite, $besoin['pu']);

        // 6. Vérifier l'argent disponible
        $argentDispo = $this->getArgentDisponible();
        if ($cout['montant_total'] > $argentDispo) {
            throw new \Exception(
                "Argent insuffisant. Coût: " . number_format($cout['montant_total'], 0, ',', ' ') . 
                " Ar, Disponible: " . number_format($argentDispo, 0, ',', ' ') . " Ar"
            );
        }

        // 7. Enregistrer l'achat
        $stmt = $this->db->prepare(
            "INSERT INTO achat_vonjy 
             (id_besoin, id_produit, id_ville, quantite_achetee, prix_unitaire, frais_pourcent, montant_ht, montant_frais, montant_total) 
             VALUES (:id_besoin, :id_produit, :id_ville, :quantite, :pu, :frais, :ht, :frais_montant, :total)"
        );
        $stmt->execute([
            'id_besoin' => $idBesoin,
            'id_produit' => $besoin['id_produit'],
            'id_ville' => $besoin['id_ville'],
            'quantite' => $quantite,
            'pu' => $besoin['pu'],
            'frais' => $cout['frais_pourcent'],
            'ht' => $cout['montant_ht'],
            'frais_montant' => $cout['montant_frais'],
            'total' => $cout['montant_total']
        ]);

        return [
            'besoin' => $besoin,
            'cout' => $cout,
            'argent_restant' => $argentDispo - $cout['montant_total']
        ];
    }

    /**
     * Récupère la liste des achats, filtrable par ville
     */
    public function getListeAchats(?int $idVille = null): array {
        $sql = "SELECT 
                    a.*,
                    v.nom_ville,
                    p.nom_produit,
                    c.nom_categorie
                FROM achat_vonjy a
                JOIN ville_vonjy v ON a.id_ville = v.id
                JOIN produit_vonjy p ON a.id_produit = p.id
                JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id";
        
        $params = [];
        if ($idVille !== null) {
            $sql .= " WHERE a.id_ville = :id_ville";
            $params['id_ville'] = $idVille;
        }
        
        $sql .= " ORDER BY a.date_achat DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère toutes les villes (pour le filtre)
     */
    public function getAllVilles(): array {
        $stmt = $this->db->query("SELECT id, nom_ville FROM ville_vonjy ORDER BY nom_ville");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
