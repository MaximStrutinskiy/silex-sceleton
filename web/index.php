<?php
ini_set('display_errors', 0);

require_once __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../src/app.php';
require __DIR__ . '/../config/prod.php';
require __DIR__ . '/../config/parameter.php';
require __DIR__ . '/../config/router.php';

/** Doctrine cli-config also uses this bootstrap for db etc, so don't run HTTP stuff if cli is being used **/
isset($cli) ?: $app->run();
