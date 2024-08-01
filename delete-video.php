<?php

use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;

require 'vendor/autoload.php';

$pdo = ConnectionDB::createConnection();

$id = $_GET['id'];

$sql = "DELETE FROM videos WHERE id = ?";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id);
$statement->execute();

if ($statement->execute() === false) {
    header('Location: /index.php?sucesso=0');
} else {
    header('Location: /index.php?sucesso=1');
}
