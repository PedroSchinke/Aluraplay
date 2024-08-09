<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideoListController implements RequestHandlerInterface
{
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = array_map(function (Video $video): array {
            return [
                'url' => $video->getUrl(),
                'title' => $video->getTitle(),
                'file_path' => '/img/uploads/' . $video->getFilePath(),
            ];
        }, $this->videoRepository->getAllVideos());

        return new Response(200, [
            'Content-Type' => 'application/json'
        ], json_encode($videoList));
    }
}