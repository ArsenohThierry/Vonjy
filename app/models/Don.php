<?php

namespace app\models;

use flight\database\PdoWrapper;

class Don {
    
    protected PdoWrapper $db;
    
    public function __construct(PdoWrapper $db) {
        $this->db = $db;
    }
    
    public function getAll(): array {
        $sql = "SELECT * FROM vue_dons_complets ORDER BY date_don DESC, id DESC";
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return is_array($results) ? $results : [];
    }
    

    public function getById(int $id): ?array {
        $sql = "SELECT * FROM vue_dons_complets WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result ?: null;
    }

    public function getStatistics(): array {
        $sql = "SELECT * FROM vue_statistiques_dons";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$result) {
            return ['total_dons' => 0, 'montant_total' => 0, 'quantite_totale' => 0];
        }
        
        return [
            'total_dons' => (int)($result['total_dons'] ?? 0),
            'montant_total' => (float)($result['montant_total'] ?? 0),
            'quantite_totale' => (int)($result['quantite_totale'] ?? 0)
        ];
    }

    public function getStatisticsByCategory(): array {
        $sql = "SELECT * FROM vue_statistiques_par_categorie WHERE nombre_dons > 0 ORDER BY nom_categorie";
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return is_array($results) ? $results : [];
    }
    

    public function create(string $nomDonneur, int $idProduit, int $quantiteDon, string $dateDon): int {
        $sql = "INSERT INTO don_vonjy (nom_donneur, id_produit, quantite_don, date_don) 
                VALUES (?, ?, ?, ?)";
        $this->db->runQuery($sql, [$nomDonneur, $idProduit, $quantiteDon, $dateDon]);
        return (int) $this->db->lastInsertId();
    }
    

    public function update(int $id, array $data): bool {
        $sql = "UPDATE don_vonjy 
                SET nom_donneur = ?, id_produit = ?, quantite_don = ?, date_don = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_donneur'],
            $data['id_produit'],
            $data['quantite_don'] ?? $data['quantite'] ?? 0,
            $data['date_don'],
            $id
        ]);
        return true;
    }
    
    public function delete(int $id): bool {
        $sql = "DELETE FROM don_vonjy WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return true;
    }
    
    public function getRecent(int $limit = 10): array {
        $sql = "SELECT * FROM vue_dons_complets ORDER BY date_don DESC, id DESC LIMIT ?";
        $result = $this->db->fetchAll($sql, [$limit]);
        return is_array($result) ? $result : (array) $result;
    }
    

    public function getByProduit(int $idProduit): array {
        $sql = "SELECT * FROM vue_dons_complets WHERE id_produit = ? ORDER BY date_don DESC";
        $result = $this->db->fetchAll($sql, [$idProduit]);
        return is_array($result) ? $result : (array) $result;
    }
    
    /**
     * Compter le nombre de dons pour un produit donné
     */
    public function countByProduit(int $idProduit): int {
        $sql = "SELECT COUNT(*) as count FROM don_vonjy WHERE id_produit = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idProduit]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int)($result['count'] ?? 0);
    }
}
