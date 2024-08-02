<?php

declare(strict_types=1);

if (!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/') {
    require_once __DIR__ . '/../videos-list.php';
} elseif ($_SERVER['PATH_INFO'] === '/new-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once __DIR__ . '/../form.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../new-video.php';
    }
} elseif ($_SERVER['PATH_INFO'] === '/edit-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once __DIR__ . '/../form.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../edit-video.php';
    }
} elseif ($_SERVER['PATH_INFO'] === '/delete-video') {
    require_once __DIR__ . '/../delete-video.php';
} else {
    http_response_code(404);
}
