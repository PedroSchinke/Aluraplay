<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use PDO;
use Dbseller\Aluraplay\Controller\Controller;
use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;

class LoginController implements Controller
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectionDB::createConnection();
    }

    public function processRequest(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        var_dump($email);
        var_dump($password);

        $sql = 'SELECT email, password FROM users WHERE email = :email;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);
        $correctPassword = password_verify($password, $userData['password'] ?? '');

        if ($correctPassword) {
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}