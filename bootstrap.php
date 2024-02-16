<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use App\Services\Container;
use App\Core\Request;
use App\Core\App;

require_once __DIR__ . '/vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/src/Models"),
    isDevMode: true,
    cache: null,
);

$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => 'db', 
    'dbname' => 'test', 
    'user' => 'root',
    'password' => 'root', 
], $config);


// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);

$container = new Container();
$container->bind(EntityManager::class, function() use($entityManager) {
    return $entityManager;
});

$container->bind(Request::class, function() {
    $request =  new Request($_SERVER);
    $request->seRequestData();
    return $request;
});

App::setContainer($container);

require "helpers.php";
