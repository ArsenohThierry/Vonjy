<?php

namespace app\controllers;

use flight\Engine;
use app\models\DispatchModel;
use Flight;

class DispatchController {

    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * Affiche la page de dispatch (sans simulation lancée)
     */
    public function index() {
        $dispatchModel = new DispatchModel(Flight::db());
        
        $totalDons = $dispatchModel->getTotalDons();
        $totalBesoins = $dispatchModel->getTotalBesoins();
        $tauxCouverture = $totalBesoins > 0 ? round(($totalDons / $totalBesoins) * 100, 1) : 0;

        $this->app->render('dispatch', [
            'activePage' => 'dashboard',
            'totalDons' => $totalDons,
            'totalBesoins' => $totalBesoins,
            'tauxCouverture' => $tauxCouverture,
            'simulation' => null, // Pas encore de simulation
            'simulated' => false
        ]);
    }

    /**
     * Lance la simulation du dispatch et affiche les résultats
     * POST /dispatch/simuler
     */
    public function simuler() {
        $dispatchModel = new DispatchModel(Flight::db());
        $simulation = $dispatchModel->simulerDispatch();

        $this->app->render('dispatch', [
            'activePage' => 'dashboard',
            'totalDons' => $simulation['totaux']['total_dons'],
            'totalBesoins' => $simulation['totaux']['total_besoins'],
            'tauxCouverture' => $simulation['totaux']['taux_couverture'],
            'simulation' => $simulation,
            'simulated' => true
        ]);
    }
}
