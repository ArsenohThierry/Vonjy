<?php

namespace app\models;

use flight\database\PdoWrapper;

class Produit {
    
    protected PdoWrapper $db;
    
    public function __construct(PdoWrapper $db) {
        $this->db = $db;
    }
    


    public function getAll(): array {
        $sql = "SELECT * FROM vue_produits_complets ORDER BY nom_produit ASC";
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return is_array($results) ? $results : [];
    }
    
    public function getById(int $id): ?array {
        $sql = "SELECT * FROM vue_produits_complets WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result ?: null;
    }
    

    public function getByCategorie(int $idCategorie): array {
        $sql = "SELECT * FROM produit_vonjy WHERE id_categorie = ? ORDER BY nom_produit ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idCategorie]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return is_array($results) ? $results : [];
    }

    public function create(string $nomProduit, float $pu, int $idCategorie): int {
        $sql = "INSERT INTO produit_vonjy (nom_produit, pu, id_categorie) VALUES (?, ?, ?)";
        $this->db->runQuery($sql, [$nomProduit, $pu, $idCategorie]);
        return (int) $this->db->lastInsertId();
    }
    

    public function update(int $id, string $nomProduit, float $pu, int $idCategorie): bool {
        $sql = "UPDATE produit_vonjy SET nom_produit = ?, pu = ?, id_categorie = ? WHERE id = ?";
        $this->db->runQuery($sql, [$nomProduit, $pu, $idCategorie, $id]);
        return true;
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM produit_vonjy WHERE id = ?";
        $this->db->runQuery($sql, [$id]);
        return true;
    }
    
    public function existsByName(string $nomProduit): bool {
        $sql = "SELECT COUNT(*) as count FROM produit_vonjy WHERE nom_produit = ?";
        $result = $this->db->fetchRow($sql, [$nomProduit]);
        if (!$result) {
            return false;
        }
        $data = is_array($result) ? $result : (array) $result;
        return isset($data['count']) && $data['count'] > 0;
    }
    
    /**
     * Compter le nombre de produits pour une catégorie donnée
     */
    public function countByCategorie(int $idCategorie): int {
        $sql = "SELECT COUNT(*) as count FROM produit_vonjy WHERE id_categorie = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idCategorie]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int)($result['count'] ?? 0);
    }
}
