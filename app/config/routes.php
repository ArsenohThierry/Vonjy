<?php

use app\controllers\ApiExampleController;
use app\controllers\VillesController;
use app\controllers\BesoinVilleController;
use app\controllers\DonController;
use app\controllers\DispatchController;
use app\controllers\AchatController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	$router->get('/', function () use ($app) {
		$app->redirect('/dashboard');
	});

	$router->get('/dashboard', [VillesController::class, 'getVilles']);

	$router->get('/villes', [VillesController::class, 'getDetailVilles']);
	// routes modules dons
	// Liste des dons
	$router->get('/dons', [DonController::class, 'index']);

	// Formulaire d'ajout de don
	$router->get('/add-don', [DonController::class, 'showAddForm']);
	$router->post('/add-don', [DonController::class, 'store']);


	// Formulaire d'ajout de produit
	$router->get('/add-produit', [DonController::class, 'showAddProduitForm']);
	$router->post('/add-produit', [DonController::class, 'storeProduit']);


	// Gestion des catégories
	$router->get('/categorie', [DonController::class, 'showCategories']);

	// Gestion des produits
	$router->get('/produits', [DonController::class, 'showProduits']);

	// API Routes pour AJAX
	$router->post('/api/categorie', [DonController::class, 'storeCategorie']);
	$router->delete('/api/categorie/@id:[0-9]+', [DonController::class, 'deleteCategorie']);
	$router->get('/api/produit/@id:[0-9]+', [DonController::class, 'getProduit']);
	$router->post('/api/produit/@id:[0-9]+/update', [DonController::class, 'updateProduit']);
	$router->delete('/api/produit/@id:[0-9]+', [DonController::class, 'deleteProduit']);
	$router->get('/api/produits', [DonController::class, 'getProduits']);
	$router->get('/api/categories', [DonController::class, 'getCategories']);

	// API Routes pour les dons
	$router->get('/api/don/@id:[0-9]+', [DonController::class, 'getDon']);
	$router->post('/api/don/@id:[0-9]+/update', [DonController::class, 'updateDon']);
	$router->delete('/api/don/@id:[0-9]+', [DonController::class, 'deleteDon']);

	$router->get('/besoins', [BesoinVilleController::class, 'getBesoins']);

	$router->get('/besoins/@id', [BesoinVilleController::class, 'getBesoinByIdVille']);

	$router->get('/add-besoin', [BesoinVilleController::class, 'showAddBesoinForm']);
	$router->post('/save-besoin', [BesoinVilleController::class, 'storeBesoin']);

	// Dispatch / Simulation / Distribution
	$router->get('/dispatch', [DispatchController::class, 'index']);
	$router->post('/dispatch/simuler', [DispatchController::class, 'simuler']);
	$router->post('/dispatch/distribuer', [DispatchController::class, 'distribuer']);

	// Achats (achat de besoins via dons argent)
	$router->get('/achats', [AchatController::class, 'listeAchats']);
	$router->get('/api/achat/besoin/@id:[0-9]+', [AchatController::class, 'getBesoinInfo']);
	$router->get('/api/achat/calculer', [AchatController::class, 'calculerCout']);
	$router->post('/api/achat', [AchatController::class, 'effectuerAchat']);
	$router->get('/api/achat/argent', [AchatController::class, 'getArgentDispo']);


	// $router->get('/recapitulation', );


}, [SecurityHeadersMiddleware::class]);