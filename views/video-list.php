<?php

require_once __DIR__ . '/html-start.php';

?>

<ul class="videos__container">
    <?php foreach ($videoList as $video): ?>
    <li class="videos__item">
        <iframe width="100%" height="72%" src="<?= $video->getUrl(); ?>"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
        <div class="descricao-video">
            <h3><?= $video->getTitle(); ?></h3>
            <div class="acoes-video">
                <a href="/edit-video?id=<?= $video->getId(); ?>">Editar</a>
                <a href="/delete-video?id=<?= $video->getId(); ?>">Excluir</a>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ul>

<?php 

require_once __DIR__ . '/html-end.php';
