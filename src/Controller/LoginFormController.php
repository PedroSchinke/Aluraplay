<?php

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Controller\Controller;

class LoginFormController implements Controller
{
    public function processRequest(): void
    {   
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header ('Location: /');
            return;
        }

        require_once __DIR__ . '/../../views/login-form.php';
    }
}