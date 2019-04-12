<?php

use App\Core\Bootstrap;

require '../../vendor/autoload.php';

session_start();

$configurationContainer = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$configurationView = [
    'cache' => false,
    'debug' => true
    //'cache' => __DIR__.'/../Storage/Cache'
];

$bootstrap = new Bootstrap($configurationContainer, $configurationView);
$bootstrap->run();