<?php

use app\controllers\ApiExampleController;
use app\controllers\VillesController;
use app\controllers\BesoinVilleController;
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
	
	$router->get('/dons', function () use ($app) {
		$app->render('dons', ['message' => 'You are gonna do great things!']);
		});
		
		$router->get('/besoins', [BesoinVilleController::class, 'getBesoins']);
			
		$router->get('/besoins/@id', [BesoinVilleController::class, 'getBesoinByIdVille']);

	$router->get('/add-don', function () use ($app) {
		$app->render('add-don', ['message' => 'You are gonna do great things!']);
	});
	

	$router->get('/hello-world/@name', function ($name) {
		echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
	});

	$router->group('/api', function () use ($router) {
		$router->get('/users', [ApiExampleController::class, 'getUsers']);
		$router->get('/users/@id:[0-9]', [ApiExampleController::class, 'getUser']);
		$router->post('/users/@id:[0-9]', [ApiExampleController::class, 'updateUser']);
	});



}, [SecurityHeadersMiddleware::class]);