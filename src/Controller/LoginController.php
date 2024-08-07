<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use PDO;
use Dbseller\Aluraplay\Controller\Controller;
use Dbseller\Aluraplay\Traits\FlashMessageTrait;
use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;

class LoginController implements Controller
{
    use FlashMessageTrait;
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
            if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
                $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
                $statement->bindValue(2, $userData['id']);
                $statement->execute();
            }

            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            $this->addErrorMessage('Usuário ou senha inválidos');
            header('Location: /login');
        }
    }
}