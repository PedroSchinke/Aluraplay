<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Domain\Helpers\StringHelper;
use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Traits\FlashMessageTrait;
use Dbseller\AluraPlay\Infra\Repository\PdoVideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {  
        $requestBody = $request->getParsedBody();

        $url = filter_var($requestBody['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválido');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $title = filter_var($requestBody['titulo']);
        if ($title === false) {
            $this->addErrorMessage('É preciso informar um título');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $video = new Video(null, $url, $title);

        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if (StringHelper::startsWith($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->saveVideo($video);

        if ($success === false) {
            $this->addErrorMessage('Erro ao cadastrar vídeo');
            return new Response(302, [
                'Location' => '/new-video'
            ]);
        } 
            
        return new Response(302, [
            'Location' => '/'
        ]);
    }
}
