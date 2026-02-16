<?php
namespace app\models;

use PDO;

class BesoinVilleModel {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM v_besoins_detail_vonjy');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBesoinByIdVille($id) {
        $stmt = $this->db->prepare('SELECT * FROM v_besoins_detail_vonjy WHERE id_ville = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEstimationBesoinForVille($id){
        $stmt = $this->db->prepare('SELECT id_ville,nom_ville,SUM(montant_estime) AS estimation_totale FROM v_besoins_detail_vonjy WHERE id_ville = :id GROUP BY id_ville, nom_ville');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalBesoins(){
        $stmt = $this->db->query('SELECT COALESCE(SUM(b.quantite_besoin * p.pu), 0) AS estimation_totale_besoins FROM besoin_ville_vonjy b JOIN produit_vonjy p ON b.id_produit = p.id;');
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllVilles() {
        $stmt = $this->db->query('SELECT id, nom_ville FROM ville_vonjy ORDER BY nom_ville');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProduits() {
        $stmt = $this->db->query('SELECT p.id, p.nom_produit, p.pu, c.nom_categorie 
                                  FROM produit_vonjy p 
                                  JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id 
                                  ORDER BY c.nom_categorie, p.nom_produit');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO besoin_ville_vonjy (id_ville, id_produit, quantite_besoin, date_besoin) 
                                    VALUES (:id_ville, :id_produit, :quantite_besoin, :date_besoin)');
        
        return $stmt->execute([
            'id_ville' => $data['id_ville'],
            'id_produit' => $data['id_produit'],
            'quantite_besoin' => $data['quantite_besoin'],
            'date_besoin' => $data['date_besoin']
        ]);
    }
}
