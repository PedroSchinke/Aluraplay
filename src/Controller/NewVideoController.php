<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Domain\Helpers\StringHelper;
use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Traits\FlashMessageTrait;
use Dbseller\AluraPlay\Infra\Repository\PdoVideoRepository;

class NewVideoController implements Controller
{
    use FlashMessageTrait;
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function processRequest(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválido');
            header('Location: /new-video');
            return;
        }

        $title = filter_input(INPUT_POST, 'titulo');
        if ($title === false) {
            $this->addErrorMessage('É preciso informar um título');
            header('Location: /new-video');
            return;
        }

        $video = new Video(null, $url, $title);

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            if (StringHelper::startsWith($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->saveVideo($video);

        if ($success === false) {
            $this->addErrorMessage('Erro ao cadastrar vídeo');
            header('Location: /new-video');
        } else {
            header('Location: /?sucesso=1');
        }
    }
}
