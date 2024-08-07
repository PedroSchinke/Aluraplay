<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;

class VideoListController extends ControllerWithHtml implements Controller
{
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function processRequest(): void
    {
        $videoList = $this->videoRepository->getAllVideos();
        
        $this->renderTemplate(
            'video-list',
            ['videoList' => $videoList]
        );
    }
}