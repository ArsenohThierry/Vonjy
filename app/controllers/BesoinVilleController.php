<?php

namespace app\controllers;

use flight\Engine;
use app\models\BesoinVilleModel;
use app\models\DispatchModel;
use app\models\AchatModel;
use Flight;

class BesoinVilleController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getBesoins() {
        $dispatchModel = new DispatchModel(Flight::db());
        $achatModel = new AchatModel(Flight::db());
        
        // Récupérer les besoins (avec prise en compte des achats)
        $besoins = $this->getBesoinsAvecAchats();
        
        $hasDistribution = $dispatchModel->hasDistribution();
        $hasAchats = $achatModel->hasAchats();
        $argentDispo = $achatModel->getArgentDisponible();
        $fraisPourcent = $achatModel->getFraisPourcent();
        
        $this->app->render('besoins', [
            'besoins' => $besoins, 
            'hasDistribution' => $hasDistribution,
            'hasAchats' => $hasAchats,
            'argentDispo' => $argentDispo,
            'fraisPourcent' => $fraisPourcent
        ]);
    }

    public function getBesoinByIdVille($id) {
        $dispatchModel = new DispatchModel(Flight::db());
        $achatModel = new AchatModel(Flight::db());
        
        // Récupérer les besoins filtrés par ville avec achats
        $allBesoins = $this->getBesoinsAvecAchats();
        $besoin = array_filter($allBesoins, fn($b) => $b['id_ville'] == $id);
        $besoin = array_values($besoin);
        
        $hasDistribution = $dispatchModel->hasDistribution();
        $hasAchats = $achatModel->hasAchats();
        $argentDispo = $achatModel->getArgentDisponible();
        $fraisPourcent = $achatModel->getFraisPourcent();
        
        $this->app->render('besoins', [
            'besoins' => $besoin, 
            'hasDistribution' => $hasDistribution,
            'hasAchats' => $hasAchats,
            'argentDispo' => $argentDispo,
            'fraisPourcent' => $fraisPourcent
        ]);
    }
    
    /**
     * Récupère les besoins avec prise en compte des allocations ET des achats
     */
    private function getBesoinsAvecAchats(): array {
        $db = Flight::db();
        $sql = "SELECT 
                    b.id,
                    b.id_ville,
                    v.nom_ville,
                    b.id_produit,
                    p.nom_produit,
                    c.nom_categorie,
                    p.pu,
                    b.quantite_besoin,
                    COALESCE(alloc.total_attribue, 0) AS quantite_attribuee,
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
                WHERE (b.quantite_besoin - COALESCE(alloc.total_attribue, 0) - COALESCE(ach.total_achete, 0)) > 0
                ORDER BY b.date_besoin ASC, b.id ASC";
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showAddBesoinForm() {
        $besoinVilleModel = new BesoinVilleModel(Flight::db());
        $villes = $besoinVilleModel->getAllVilles();
        $produits = $besoinVilleModel->getAllProduits();
        
        $this->app->render('add-besoin', [
            'activePage' => 'besoins',
            'villes' => $villes,
            'produits' => $produits,
            'message' => $_SESSION['message'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        
        // Nettoyer les messages de session
        unset($_SESSION['message'], $_SESSION['error']);
    }

    public function storeBesoin() {
            // Validation des données
            $id_ville = $_POST['id_ville'] ?? null;
            $id_produit = $_POST['id_produit'] ?? null;
            $quantite_besoin = $_POST['quantite_besoin'] ?? null;
            $date_besoin = $_POST['date_besoin'] ?? null;

            if (!$id_ville || !$id_produit || !$quantite_besoin || !$date_besoin) {
                throw new \Exception('Tous les champs obligatoires doivent être remplis.');
            }

            if ($quantite_besoin <= 0) {
                throw new \Exception('La quantité doit être supérieure à 0.');
            }

            // Préparer les données
            $data = [
                'id_ville' => $id_ville,
                'id_produit' => $id_produit,
                'quantite_besoin' => $quantite_besoin,
                'date_besoin' => $date_besoin
            ];

            // Insérer le besoin
            $besoinVilleModel = new BesoinVilleModel(Flight::db());
            $success = $besoinVilleModel->create($data);
            $this->app->redirect('/besoins');
    }
}
