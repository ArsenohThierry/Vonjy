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
}