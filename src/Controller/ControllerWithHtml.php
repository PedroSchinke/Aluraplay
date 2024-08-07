<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

abstract class ControllerWithHtml implements Controller
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';

    protected function renderTemplate(string $templateName, array $context = []): void
    {
        extract($context);
        require_once self::TEMPLATE_PATH . $templateName . '.php';
    }
}