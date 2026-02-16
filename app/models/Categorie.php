<?php

namespace app\models;

use flight\database\PdoWrapper;

class Categorie {
    
    protected PdoWrapper $db;
    
    public function __construct(PdoWrapper $db) {
        $this->db = $db;
    }
    
    /**
     * Récupérer toutes les catégories
     */
    public function getAll(): array {
        $sql = "SELECT * FROM categorie_besoin_vonjy ORDER BY nom_categorie ASC";
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return is_array($results) ? $results : [];
    }
    
    /**
     * Récupérer une catégorie par ID
     */
    public function getById(int $id): ?array {
        $sql = "SELECT * FROM categorie_besoin_vonjy WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result ?: null;
    }
    
    /**
     * Ajouter une nouvelle catégorie
     */
    public function create(string $nomCategorie): int {
        $sql = "INSERT INTO categorie_besoin_vonjy (nom_categorie) VALUES (?)";
        $this->db->runQuery($sql, [$nomCategorie]);
        return (int) $this->db->lastInsertId();
    }
    
    /**
     * Mettre à jour une catégorie
     */
    public function update(int $id, string $nomCategorie): bool {
        $sql = "UPDATE categorie_besoin_vonjy SET nom_categorie = ? WHERE id = ?";
        $this->db->runQuery($sql, [$nomCategorie, $id]);
        return true;
    }
    
    /**
     * Supprimer une catégorie
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM categorie_besoin_vonjy WHERE id = ?";
        $this->db->runQuery($sql, [$id]);
        return true;
    }
    
    /**
     * Vérifier si une catégorie existe par nom
     */
    public function existsByName(string $nomCategorie): bool {
        $sql = "SELECT COUNT(*) as count FROM categorie_besoin_vonjy WHERE nom_categorie = ?";
        $result = $this->db->fetchRow($sql, [$nomCategorie]);
        if (!$result) {
            return false;
        }
        $data = is_array($result) ? $result : (array) $result;
        return isset($data['count']) && $data['count'] > 0;
    }
}
