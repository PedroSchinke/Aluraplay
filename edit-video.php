<?php

use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;

require 'vendor/autoload.php';

$pdo = ConnectionDB::createConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false) {
    header('Location: /?sucesso=0');
    exit();
}

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /?sucesso=0');
    exit();
}

$title = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location: /?sucesso=0');
    exit();
}

$videoRepository = new PdoVideoRepository($pdo);

if ($videoRepository->editVideo(new Video($id, $url, $title)) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}