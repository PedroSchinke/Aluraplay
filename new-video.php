<?php

use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;
use Dbseller\Aluraplay\Domain\Model\Video;

require 'vendor/autoload.php';

$pdo = ConnectionDB::createConnection();

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /?sucesso=0');
    exit();
}
$title = filter_input(INPUT_POST, 'titulo');
if ($title === false) {
    header('Location: /?sucesso=0');
    exit();
}

$videoRepository = new PdoVideoRepository($pdo);

if ($videoRepository->saveVideo(new Video(null, $url, $title)) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}
