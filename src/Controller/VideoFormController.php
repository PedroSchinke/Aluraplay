<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;
use Dbseller\Aluraplay\Domain\Model\Video;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
{
    private PdoVideoRepository $videoRepository;
    private Engine $templates;

    public function __construct(PdoVideoRepository $videoRepository, Engine $templates)
    {
        $this->videoRepository = $videoRepository;
        $this->templates = $templates;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $id = filter_var($queryParams['id'] ?? '', FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;

        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->getVideo($id);
        }

        return new Response(200, [], $this->templates->render(
            'video-form',
            [
                'video' => $video,
                'id' => $id
            ]
        ));
    }
}
