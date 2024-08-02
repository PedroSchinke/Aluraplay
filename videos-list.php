<?php

use Dbseller\Aluraplay\Domain\Helpers\StringHelper;
use Dbseller\Aluraplay\Infra\Persistence\ConnectionDB;
use Dbseller\Aluraplay\Infra\Repository\PdoVideoRepository;

require 'vendor/autoload.php';

$pdo = ConnectionDB::createConnection();
$videoRepository = new PdoVideoRepository($pdo);
$videoList = $videoRepository->getAllVideos();

?>
<?php require_once 'html-start.php'; ?>

<ul class="videos__container" alt="videos alura">
    <?php foreach ($videoList as $video): ?>
    <?php if (StringHelper::startsWith($video->getUrl(), 'http')): ?>
    <li class="videos__item">
        <iframe width="100%" height="72%" src="<?= $video->getUrl(); ?>"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
        <div class="descricao-video">
            <img src="./img/logo.png" alt="logo canal alura">
            <h3><?= $video->getTitle(); ?></h3>
            <div class="acoes-video">
                <a href="/edit-video?id=<?= $video->getId(); ?>">Editar</a>
                <a href="/delete-video?id=<?= $video->getId(); ?>">Excluir</a>
            </div>
        </div>
    </li>
    <?php endif; ?>
    <?php endforeach; ?>
</ul>

<?php require_once 'html-end.php'; ?>