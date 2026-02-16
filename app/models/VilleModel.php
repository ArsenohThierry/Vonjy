<?php
namespace app\models;

use PDO;

class VilleModel
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query('SELECT * FROM ville_vonjy');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM ville_vonjy WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDetailVilles()
    {
        $stmt = $this->db->query('SELECT
    v.id AS id_ville,
    v.nom_ville AS ville,
    r.nom_region AS region,
    COUNT(b.id) AS nombre_besoins,
    COALESCE(SUM(b.quantite_besoin * p.pu), 0) AS total_estime_ar
FROM ville_vonjy v
JOIN region_vonjy r ON v.id_region = r.id
LEFT JOIN besoin_ville_vonjy b ON v.id = b.id_ville
LEFT JOIN produit_vonjy p ON b.id_produit = p.id
GROUP BY v.id, v.nom_ville, r.nom_region
ORDER BY total_estime_ar DESC;');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
