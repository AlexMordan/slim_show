<?php


namespace App\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Dotenv\Dotenv;

class EntityManager
{
    protected $entityManager;
    public function __construct()
    {
        $paths = array(__DIR__."/../Model/");
        $isDevMode = false;

        $this->loadEnv();

        $dbParams = array(
            'host' => getenv('DB_HOST'),
            'driver'   => getenv('DB_DRIVE'),
            'user'     => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'dbname'   => getenv('DB_NAME'),
            'port' => getenv('DB_PORT')
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode,null, null, false);
        $this->entityManager = DoctrineEntityManager::create($dbParams, $config);
    }

    final private function loadEnv()
    {
        $dotenv = Dotenv::create(__DIR__."/../..");
        $dotenv->overload();
        $dotenv->required([
            'DB_HOST',
            'DB_NAME',
            'DB_DRIVE',
            'DB_USER',
            'DB_PASSWORD',
            'DB_PORT'
        ]);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }
}