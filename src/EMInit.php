<?php
// bootstrap.php


namespace App;

require_once __DIR__ . "/../vendor/autoload.php";

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\ORMSetup;

// or if you prefer annotation, YAML or XML
// $config = ORMSetup::createAnnotationMetadataConfiguration(
//    paths: array(__DIR__."/src"),
//    isDevMode: true,
// );
// $config = ORMSetup::createXMLMetadataConfiguration(
//    paths: [__DIR__ . '/config/xml'],
//    isDevMode: true,
//);
// $config = ORMSetup::createYAMLMetadataConfiguration(
//    paths: array(__DIR__."/config/yaml"),
//    isDevMode: true,
// );

class EMInit
{
    public static $em;


    public function __construct()
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/Entity'],
            isDevMode: true,
        );
        $connection = DriverManager::getConnection([
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'shoping_web',
            'host'     => 'localhost',
        ], $config);
        self::$em = new EntityManager($connection, $config);
    


    }
}