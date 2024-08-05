<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;

class VideoListController implements Controller
{
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function processRequest(): void
    {
        $videoList = $this->videoRepository->getAllVideos();
        require_once __DIR__ . '/../../views/video-list.php';
    }
}