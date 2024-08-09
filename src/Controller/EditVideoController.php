<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Domain\Helpers\StringHelper;
use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;
use Dbseller\Aluraplay\Traits\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErrorMessage('ID inválido');
            return new Response(302, [
                'Location' => "/"
            ]);
        }

        $requestBody = $request->getParsedBody();

        $url = filter_var($requestBody['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválida');
            return new Response(302, [
                'Location' => "/"
            ]);
        }

        $title = filter_var($requestBody['titulo']);
        if ($title === false || $title === null) {
            $this->addErrorMessage('É preciso informar um título');
            return new Response(302, [
                'Location' => "/"
            ]);
        }

        $video = new Video($id, $url, $title);

        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetaData('uri');
            $mimeType = $finfo->file($tmpFile);

            if (StringHelper::startsWith($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->editVideo($video);

        if ($success === false) {
            $this->addErrorMessage('Erro ao editar vídeo');
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}