<?php

namespace app\controllers;

use flight\Engine;
use app\models\AchatModel;
use Flight;

class AchatController {

    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * API: Récupère les infos d'un besoin pour le modal d'achat
     * GET /api/achat/besoin/@id
     */
    public function getBesoinInfo($idBesoin) {
        $achatModel = new AchatModel(Flight::db());
        
        $besoin = $achatModel->getBesoinPourAchat($idBesoin);
        if (!$besoin) {
            $this->app->json(['error' => 'Besoin introuvable'], 404);
            return;
        }

        $fraisPourcent = $achatModel->getFraisPourcent();
        $argentDispo = $achatModel->getArgentDisponible();

        // Vérifier si produit dispo en don
        $produitDispo = $achatModel->produitDisponibleEnDon($besoin['id_produit'], 1);

        $this->app->json([
            'besoin' => $besoin,
            'frais_pourcent' => $fraisPourcent,
            'argent_disponible' => $argentDispo,
            'produit_dispo_en_don' => $produitDispo
        ]);
    }

    /**
     * API: Calcule le coût d'achat
     * GET /api/achat/calculer?quantite=X&prix_unitaire=Y
     */
    public function calculerCout() {
        $quantite = (int) ($_GET['quantite'] ?? 0);
        $prixUnitaire = (float) ($_GET['prix_unitaire'] ?? 0);

        if ($quantite <= 0 || $prixUnitaire <= 0) {
            $this->app->json(['error' => 'Paramètres invalides'], 400);
            return;
        }

        $achatModel = new AchatModel(Flight::db());
        $cout = $achatModel->calculerCoutAchat($quantite, $prixUnitaire);
        $argentDispo = $achatModel->getArgentDisponible();

        $this->app->json([
            'cout' => $cout,
            'argent_disponible' => $argentDispo,
            'suffisant' => $cout['montant_total'] <= $argentDispo
        ]);
    }

    /**
     * API: Effectue un achat
     * POST /api/achat
     */
    public function effectuerAchat() {
        $idBesoin = (int) ($_POST['id_besoin'] ?? 0);
        $quantite = (int) ($_POST['quantite'] ?? 0);

        if ($idBesoin <= 0 || $quantite <= 0) {
            $this->app->json(['error' => 'Paramètres invalides'], 400);
            return;
        }

        $achatModel = new AchatModel(Flight::db());

        try {
            $result = $achatModel->effectuerAchat($idBesoin, $quantite);
            $this->app->json([
                'success' => true,
                'message' => "Achat de {$quantite} unité(s) effectué avec succès !",
                'details' => $result
            ]);
        } catch (\Exception $e) {
            $this->app->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Page: Liste des achats filtrables par ville
     * GET /achats
     */
    public function listeAchats() {
        $achatModel = new AchatModel(Flight::db());
        
        $idVille = isset($_GET['ville']) && $_GET['ville'] !== '' ? (int) $_GET['ville'] : null;
        
        $achats = $achatModel->getListeAchats($idVille);
        $villes = $achatModel->getAllVilles();
        $argentDispo = $achatModel->getArgentDisponible();
        $totalDonsArgent = $achatModel->getTotalDonsArgent();
        $totalAchats = $achatModel->getTotalAchatsEffectues();
        $fraisPourcent = $achatModel->getFraisPourcent();

        $this->app->render('achats', [
            'activePage' => 'achats',
            'achats' => $achats,
            'villes' => $villes,
            'villeSelectionnee' => $idVille,
            'argentDispo' => $argentDispo,
            'totalDonsArgent' => $totalDonsArgent,
            'totalAchats' => $totalAchats,
            'fraisPourcent' => $fraisPourcent
        ]);
    }

    /**
     * API: Récupère l'argent disponible
     */
    public function getArgentDispo() {
        $achatModel = new AchatModel(Flight::db());
        $this->app->json([
            'argent_disponible' => $achatModel->getArgentDisponible(),
            'total_dons_argent' => $achatModel->getTotalDonsArgent(),
            'total_achats' => $achatModel->getTotalAchatsEffectues(),
            'frais_pourcent' => $achatModel->getFraisPourcent()
        ]);
    }
}
