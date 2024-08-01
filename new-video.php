<?php

use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;

require 'vendor/autoload.php';

$pdo = ConnectionDB::createConnection();

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /index.php?sucesso=0');
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location: /index.php?sucesso=0');
    exit();
}

$sql = 'INSERT INTO videos (id, url, title) VALUES (?, ?, ?)';
$statement = $pdo->prepare($sql);
$statement->bindValue(2, $url);
$statement->bindValue(3, $title);
$statement->bindValue(1, 1);

if ($statement->execute() === false) {
    header('Location: /index.php?sucesso=0');
} else {
    header('Location: /index.php?sucesso=1');
}
