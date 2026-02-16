<?php

namespace app\controllers;

use flight\Engine;
use app\models\BesoinVilleModel;
use Flight;

class BesoinVilleController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getBesoins() {
        $besoinVilleModel = new BesoinVilleModel(Flight::db());
        $besoins = $besoinVilleModel->getAll();
        $this->app->render('besoins', ['besoins' => $besoins]);
    }

    public function getBesoinByIdVille($id) {
        $besoinVilleModel = new BesoinVilleModel(Flight::db());
        $besoin = $besoinVilleModel->getBesoinByIdVille($id);
            $this->app->render('besoins', ['besoins' => $besoin]);
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
