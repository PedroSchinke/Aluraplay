<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;

class JsonVideoListController implements Controller
{
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function processRequest(): void
    {
        $videoList = array_map(function (Video $video): array {
            return [
                    'url' => $video->getUrl(),
                    'title' => $video->getTitle(),
                    'file_path' => '/img/uploads/' . $video->getFilePath(),
            ];
        }, $this->videoRepository->getAllVideos());
        echo json_encode($videoList);
    }
}