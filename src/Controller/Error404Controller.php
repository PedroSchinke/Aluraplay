<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

class Error404Controller implements Controller
{
    public function processRequest(): void
    {
        http_response_code(404);
    }
}
