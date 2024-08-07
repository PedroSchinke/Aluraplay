<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Controller\Controller;

class LogoutController implements Controller
{
    public function processRequest(): void
    {
        session_destroy();
        header('Location: /login');
    }
}