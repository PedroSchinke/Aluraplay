<?php

declare(strict_types=1);

use Dbseller\Aluraplay\Controller\{
    Controller,
    DeleteVideoController,
    EditVideoController,
    Error404Controller,
    NewVideoController,
    VideoFormController,
    VideoListController
};
use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = ConnectionDB::createConnection();
$videoRepository = new PdoVideoRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    $controller = new $controllerClass($videoRepository);
} else {
    $controller = new Error404Controller();
}

/** @var Controller $controller */
$controller->processRequest();
