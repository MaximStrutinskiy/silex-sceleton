<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Knp\Provider\ConsoleServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app['twig'] = $app->extend(
	'twig',
	function ($twig, $app) {
		return $twig;
	}
);
$app->register(new HttpFragmentServiceProvider());
$app->register(new \Silex\Provider\DoctrineServiceProvider());
$app->register(
	new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider(),
	[
		'orm.proxies_dir' => dirname(__DIR__) . '/var/cache/doctrine',
		'orm.proxies_namespace' => 'cache\doctrine',
		'orm.auto_generate_proxies' => true,
		'orm.em.options' => [
			"mappings" => [
				[
					"type" => "annotation",
					'path' => __DIR__ . '/../src/App/Entity',
					'namespace' => 'App\Entity',
					"use_simple_annotation_reader" => false,
				],
			],
		],
	]
);
$app->register(new Silex\Provider\SerializerServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app['encode_password'] = function ($app) {
	return $app['security.encoder.pbkdf2'];
};
$app['users'] = function ($app) {
	return $app['orm.em']->getRepository('App\Entity\User');
};
$app['security.role_hierarchy'] = [
	'ROLE_ADMIN' => [
		'ROLE_USER',
		'ROLE_ALLOWED_TO_SWITCH',
	],
];
$app['security.access_rules'] = [
	['^/', 'IS_AUTHENTICATED_ANONYMOUSLY'],
	['^/api/$', 'ROLE_USER'],
	['^/admin/$', 'ROLE_ADMIN'],
];
$app['security.firewalls'] = [
	'login' => [
		'pattern' => '^/',
		'logout' => ['logout_path' => '/logout'],
		'users' => function () use ($app) {
			return $app['users'];
		},
		'anonymous' => true,
	],
];
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new \Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), [
	'locale_fallbacks' => ['en'],
]);
$app->register(new ConsoleServiceProvider(), [
	'console.name' => 'ConsoleApp',
	'console.version' => '1.0.0',
	'console.project_directory' => __DIR__ . '/..'
]);
$app->register(new DoctrineOrmManagerRegistryProvider());

return $app;
