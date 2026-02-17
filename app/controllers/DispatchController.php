<?php

namespace app\controllers;

use flight\Engine;
use app\models\DispatchModel;
use Flight;

class DispatchController
{

    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Affiche la page de dispatch (sans simulation lancée)
     */
    public function index()
    {
        $dispatchModel = new DispatchModel(Flight::db());

        $totalDons = $dispatchModel->getTotalDons();
        $totalBesoins = $dispatchModel->getTotalBesoins();
        $tauxCouverture = $totalBesoins > 0 ? round(($totalDons / $totalBesoins) * 100, 1) : 0;
        $hasDistribution = $dispatchModel->hasDistribution();
        $canDistribute = $dispatchModel->canDistribute();
        $historique = $dispatchModel->getHistoriqueDistributions();
        $besoins = $dispatchModel->getAllBesoinsOrderByDate();

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
            'besoins' => $besoins,
            'message' => $_SESSION['dispatch_message'] ?? null,
            'error' => $_SESSION['dispatch_error'] ?? null
        ]);
        unset($_SESSION['dispatch_message'], $_SESSION['dispatch_error']);
    }

    /**
     * Lance la simulation du dispatch et affiche les résultats
     * POST /dispatch/simuler
     */
    public function simuler()
    {
        $dispatchModel = new DispatchModel(Flight::db());
        
<<<<<<< HEAD
=======
        // Récupérer le mode de dispatch depuis le formulaire
        $mode = $_POST['mode'] ?? 'date';
        if (!in_array($mode, ['date', 'petit'])) {
            $mode = 'date';
        }
        
>>>>>>> dev_aina
        // Récupérer les valeurs initiales AVANT simulation
        $totalDonsInitial = $dispatchModel->getTotalDons();
        $totalBesoinsInitial = $dispatchModel->getTotalBesoins();
        
<<<<<<< HEAD
        $simulation = $dispatchModel->simulerDispatch();
=======
        $simulation = $dispatchModel->simulerDispatch($mode);
>>>>>>> dev_aina
        $hasDistribution = $dispatchModel->hasDistribution();
        $canDistribute = $dispatchModel->canDistribute();
        $historique = $dispatchModel->getHistoriqueDistributions();

        // Calculer les valeurs APRÈS simulation (comme si le dispatch avait été effectué)
        $totalAttribue = $simulation['totaux']['total_attribue'];
        $totalDonsApresSimulation = max(0, $totalDonsInitial - $totalAttribue);
        $totalBesoinsApresSimulation = max(0, $totalBesoinsInitial - $totalAttribue);
        $tauxCouvertureApresSimulation = $totalBesoinsApresSimulation > 0 
            ? round(($totalDonsApresSimulation / $totalBesoinsApresSimulation) * 100, 1) 
            : ($totalDonsApresSimulation > 0 ? 100 : 0);

<<<<<<< HEAD
        // Récupérer les besoins pour le tableau
        $besoins = $dispatchModel->getAllBesoinsOrderByDate();
=======
        // Récupérer les besoins pour le tableau selon le mode
        $besoins = ($mode === 'petit') 
            ? $dispatchModel->getAllBesoinsOrderBySmallest() 
            : $dispatchModel->getAllBesoinsOrderByDate();
>>>>>>> dev_aina

        $this->app->render('dispatch', [
            'activePage' => 'dashboard',
            // Valeurs après simulation (affichées dans les cartes)
            'totalDons' => $totalDonsApresSimulation,
            'totalBesoins' => $totalBesoinsApresSimulation,
            'tauxCouverture' => $tauxCouvertureApresSimulation,
            // Valeurs initiales (pour le bouton "retour état initial")
            'totalDonsInitial' => $totalDonsInitial,
            'totalBesoinsInitial' => $totalBesoinsInitial,
            'tauxCouvertureInitial' => $totalBesoinsInitial > 0 ? round(($totalDonsInitial / $totalBesoinsInitial) * 100, 1) : 0,
            'simulation' => $simulation,
            'simulated' => true,
            'modeDispatch' => $mode,
            'hasDistribution' => $hasDistribution,
            'canDistribute' => $canDistribute,
            'historique' => $historique,
            'besoins' => $besoins,
            'message' => $_SESSION['dispatch_message'] ?? null,
            'error' => $_SESSION['dispatch_error'] ?? null
        ]);
        unset($_SESSION['dispatch_message'], $_SESSION['dispatch_error']);
    }

    /**
     * Distribue réellement les dons (enregistre en BDD)
     * POST /dispatch/distribuer
     */
    public function distribuer()
    {
        $dispatchModel = new DispatchModel(Flight::db());
<<<<<<< HEAD
=======
        
        // Récupérer le mode de dispatch depuis le formulaire
        $mode = $_POST['mode'] ?? 'date';
        if (!in_array($mode, ['date', 'petit'])) {
            $mode = 'date';
        }
>>>>>>> dev_aina

        try {
            $simulation = $dispatchModel->distribuerDons($mode);
            $nbAlloc = count(array_filter($simulation['allocations'], fn($a) => $a['quantite_attribuee'] > 0));
            $modeLabel = ($mode === 'petit') ? 'petit à petit' : 'par date';
            $_SESSION['dispatch_message'] = "Distribution effectuée ({$modeLabel}) ! {$nbAlloc} allocation(s) enregistrée(s).";
        } catch (\Exception $e) {
            $_SESSION['dispatch_error'] = $e->getMessage();
        }

        $this->app->redirect('/dispatch');
    }
}
