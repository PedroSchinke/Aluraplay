<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Domain\Helpers\StringHelper;
use Dbseller\Aluraplay\Domain\Model\Video;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;
use Dbseller\Aluraplay\Traits\FlashMessageTrait;

class EditVideoController implements Controller
{
    use FlashMessageTrait;
    private PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function processRequest(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErrorMessage('Erro ao editar vídeo');
            header("Location: /edit-video?id='$id'");
            return;
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválida');
            header("Location: /edit-video?id='$id'");
            return;
        }

        $title = filter_input(INPUT_POST, 'titulo');
        if ($title === false) {
            $this->addErrorMessage('É preciso informar um título');
            header("Location: /edit-video?id='$id'");
            return;
        }

        $video = new Video($id, $url, $title);

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

        $success = $this->videoRepository->editVideo($video);

        if ($success === false) {
            $this->addErrorMessage('Erro ao editar vídeo');
            header("Location: /edit-video?id='$id'");
        } else {
            header('Location: /?sucesso=1');
        }
    }
}