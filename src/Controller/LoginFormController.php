<?php

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Controller\Controller;

class LoginFormController extends ControllerWithHtml implements Controller
{
    public function processRequest(): void
    {   
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header ('Location: /');
            return;
        }

        $this->renderTemplate(
            'login-form',
        );
    }
}