<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Controller
{
    public function handle(ServerRequestInterface $request): ResponseInterface;
}