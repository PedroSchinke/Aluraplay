<?php

use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;

require 'vendor/autoload.php';

$pdo = ConnectionDB::createConnection();

$id = $_GET['id'];

$videoRepository = new PdoVideoRepository($pdo);

if ($videoRepository->deleteVideo($id) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}
