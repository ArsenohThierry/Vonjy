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

        //estimation des besoins RESTANTS (après allocations/achats)
        $besoinVilleModel = new BesoinVilleModel(Flight::db());
        $estimations = [];
        foreach ($villes as $ville) {
            $estimations[$ville['nom_ville']] = $besoinVilleModel->getEstimationBesoinForVille($ville['id']);
        }

        //besoins total RESTANTS
        $totalBesoins = $besoinVilleModel->getTotalBesoins();

        // Récupérer les allocations RÉELLES (de la BDD, pas simulation)
        $dispatchModel = new DispatchModel(Flight::db());
        $allocationsParVille = $dispatchModel->getAllocationsReellesParVille();
        $totalAllocations = $dispatchModel->getTotalAllocationsReelles();
        $totalDons = $dispatchModel->getTotalDons();

        // Construire une structure compatible avec l'affichage
        $simulation = [
            'par_ville' => $allocationsParVille,
            'totaux' => [
                'total_attribue' => $totalAllocations,
                'total_reste' => $totalBesoins['estimation_totale_besoins'] ?? 0
            ]
        ];

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