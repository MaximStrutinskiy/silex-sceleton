<?php

// configure your app for the production environment

$app['twig.path'] = [__DIR__ . '/../src/App/Resource/view'];
$app['twig.options'] = ['cache' => __DIR__ . '/../var/cache/twig'];
