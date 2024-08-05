<?php

require_once __DIR__ . '/html-start.php';

?>

<main class="container">
    <form class="container__formulario"
        method="post"
    >
        <h2 class="formulario__titulo">Envie um vídeo!</h2>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="url">Link embed</label>
                <input 
                    name="url"
                    value="<?= $video ? $video->getUrl() : null; ?>"
                    class="campo__escrita"
                    required
                    placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g"
                    id='url'
                />
            </div>

            <div class="formulario__campo">
                <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                <input name="titulo"
                    value="<?= $video ? $video->getTitle() : null; ?>"
                    class="campo__escrita"
                    required
                    placeholder="Neste campo, dê o nome do vídeo"
                    id='titulo' 
                />
            </div>

            <input class="formulario__botao" type="submit" value="Enviar" />
    </form>
</main>

<?php

require_once __DIR__ . '/html-end.php';
