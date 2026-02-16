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
}
