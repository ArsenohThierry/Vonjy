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
        $hasDistribution = $dispatchModel->hasDistribution();
        $canDistribute = $dispatchModel->canDistribute();
        $historique = $dispatchModel->getHistoriqueDistributions();

        $this->app->render('dispatch', [
            'activePage' => 'dashboard',
            'totalDons' => $totalDons,
            'totalBesoins' => $totalBesoins,
            'tauxCouverture' => $tauxCouverture,
            'simulation' => null,
            'simulated' => false,
            'hasDistribution' => $hasDistribution,
            'canDistribute' => $canDistribute,
            'historique' => $historique,
            'message' => $_SESSION['dispatch_message'] ?? null,
            'error' => $_SESSION['dispatch_error'] ?? null
        ]);
        unset($_SESSION['dispatch_message'], $_SESSION['dispatch_error']);
    }

    /**
     * Lance la simulation du dispatch et affiche les résultats
     * POST /dispatch/simuler
     */
    public function simuler() {
        $dispatchModel = new DispatchModel(Flight::db());
        $simulation = $dispatchModel->simulerDispatch();
        $hasDistribution = $dispatchModel->hasDistribution();
        $canDistribute = $dispatchModel->canDistribute();
        $historique = $dispatchModel->getHistoriqueDistributions();

        $this->app->render('dispatch', [
            'activePage' => 'dashboard',
            'totalDons' => $simulation['totaux']['total_dons'],
            'totalBesoins' => $simulation['totaux']['total_besoins'],
            'tauxCouverture' => $simulation['totaux']['taux_couverture'],
            'simulation' => $simulation,
            'simulated' => true,
            'hasDistribution' => $hasDistribution,
            'canDistribute' => $canDistribute,
            'historique' => $historique,
            'message' => $_SESSION['dispatch_message'] ?? null,
            'error' => $_SESSION['dispatch_error'] ?? null
        ]);
        unset($_SESSION['dispatch_message'], $_SESSION['dispatch_error']);
    }

    /**
     * Distribue réellement les dons (enregistre en BDD)
     * POST /dispatch/distribuer
     */
    public function distribuer() {
        $dispatchModel = new DispatchModel(Flight::db());
        
        try {
            $simulation = $dispatchModel->distribuerDons();
            $nbAlloc = count(array_filter($simulation['allocations'], fn($a) => $a['quantite_attribuee'] > 0));
            $_SESSION['dispatch_message'] = "Distribution effectuée ! {$nbAlloc} allocation(s) enregistrée(s).";
        } catch (\Exception $e) {
            $_SESSION['dispatch_error'] = $e->getMessage();
        }
        
        $this->app->redirect('/dispatch');
    }
}
