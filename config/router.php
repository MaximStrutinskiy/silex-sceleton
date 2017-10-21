<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// User.
$app
	->match(
		'/',
		'App\Controller\User\UserController::loginAction'
	)
	->bind('login');

$app
	->match(
		'/profile',
		'App\Controller\User\UserController::profileAction'
	)
	->bind('profile');

$app
	->match(
		'/register',
		'App\Controller\User\UserController::registerAction'
	)
	->bind('register');

// Admin.
$app
	->match(
		'/admin/',
		'App\Controller\Admin\IndexController::indexAction'
	)
	->bind('admin');

// Error.
$app->error(
	function (\Exception $e, Request $request, $code) use ($app) {
		if ($app['debug']) {
			return;
		}

		// 404.html, or 40x.html, or 4xx.html, or error.html
		$templates = [
			'error/page/' . $code . '.html.twig',
			'error/page/' . substr($code, 0, 2) . 'x.html.twig',
			'error/page/' . substr($code, 0, 1) . 'xx.html.twig',
			'error/page/default.html.twig',
		];

		return new Response($app['twig']->resolveTemplate($templates)->render(['code' => $code]), $code);
	}
);
