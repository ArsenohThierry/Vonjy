<?php

namespace app\controllers;

use flight\Engine;
use app\models\VilleModel;
use app\models\BesoinVilleModel;
use app\models\DispatchModel;
use Flight;

class VillesController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getVilles() {
        //villes
        $villeModel = new VilleModel(Flight::db());
        $villes = $villeModel->getAll();

        //estimation des besoins
        $besoinVilleModel = new BesoinVilleModel(Flight::db());
        $estimations = [];
        foreach ($villes as $ville) {
            $estimations[$ville['nom_ville']] = $besoinVilleModel->getEstimationBesoinForVille($ville['id']);
        }

        //besoins total
        $totalBesoins = $besoinVilleModel->getTotalBesoins();

        // Simulation pour obtenir les dons attribués par ville
        $dispatchModel = new DispatchModel(Flight::db());
        $simulation = $dispatchModel->simulerDispatch();
        $totalDons = $dispatchModel->getTotalDons();

        $this->app->render('dashboard', [
            'villes' => $villes, 
            'estimations' => $estimations, 
            'totalBesoins' => $totalBesoins,
            'simulation' => $simulation,
            'totalDons' => $totalDons
        ]);
    }

    public function getVilleById($id) {
        $villeModel = new VilleModel(Flight::db());
        $ville = $villeModel->getById($id);
            $this->app->render('besoins', ['ville' => $ville]);
    }

    public function getDetailVilles() {
        $villeModel = new VilleModel(Flight::db());
        $villes = $villeModel->getAllDetailVilles();
        $this->app->render('villes', ['villes' => $villes]);
    }
}