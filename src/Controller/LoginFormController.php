<?php

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Controller\Controller;
use Dbseller\Aluraplay\Traits\HtmlRendererTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface
{
    use HtmlRendererTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {   
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        return new Response(200, [], $this->renderTemplate(
            'login-form',
        ));
    }
}