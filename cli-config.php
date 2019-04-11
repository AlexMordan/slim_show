<?php
require_once "vendor/autoload.php";
require_once "src/Core/EntityManager.php";
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap

// replace with mechanism to retrieve EntityManager in your app
$bootstrap = new \App\Core\EntityManager();

$entityManager = $bootstrap->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);