<?php

use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function ():PDO {
        $pdo = ConnectionDB::createConnection();
        return $pdo;
    },
    \League\Plates\Engine::class => function () {
        $templatePath = __DIR__ . '/../views';
        return new League\Plates\Engine($templatePath);
    }
]);
// var_dump($builder);
// die;

/** @var \Psr\Container\ContainerInterface $container */
$container = $builder->build();

return $container;
