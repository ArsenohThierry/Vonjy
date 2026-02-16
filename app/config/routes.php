<?php

use app\controllers\ApiExampleController;
use app\controllers\VillesController;
use app\controllers\BesoinVilleController;
use app\controllers\DonController;
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

	$router->get('/hello-world/@name', function ($name) {
		echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
	});

	$router->group('/api', function () use ($router) {
		$router->get('/users', [ApiExampleController::class, 'getUsers']);
		$router->get('/users/@id:[0-9]', [ApiExampleController::class, 'getUser']);
		$router->post('/users/@id:[0-9]', [ApiExampleController::class, 'updateUser']);
	});



}, [SecurityHeadersMiddleware::class]);