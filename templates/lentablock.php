<div class="col-sm-8 blog-main">
    <?php if ($viewtype==1): ?><h2>Результаты поиска по тегу <a href='../controller/index.php?flush=1'>(Закрыть)</a></h2><?php endif ?>
    <?php if ($viewtype==2): ?><h2>Результаты поиска: <?= $searchtext ?> <a href='../controller/index.php?flush=1'>(Закрыть)</a></h2><?php endif ?>
    <?php for ($i = 0; $i < count($lenta->title); $i++): ?>
        <div class="blog-post">
            <h2 class="blog-post-title"><a href='../controller/post.php?id=<?= $lenta->postid[$i] ?>'><?= $lenta->title[$i] ?></a></h2>
            <div><?= nl2br($lenta->text[$i]) ?>...</div>
            <div class="blog-post-meta">Автор: <?= $lenta->author[$i] ?></div>
            <div class="blog-post-meta">Дата: <?= gmdate("d-m-Y\ H:i:s\ ", $lenta->date[$i] + TIMEZONE * 3600) ?></div>
            <?php if ($lenta->tags[$i]): ?>
                <div class="blog-post-meta">Теги: 
                    <?php foreach ($lenta->tags[$i] as $item): ?>
                        <a href='../controller/index.php?tag=<?= $item['id'] ?>'><?= $item['tag'] ?></a>                 
                    <?php endforeach; ?>
                </div>
            <?php endif ?>
        </div><!-- /.blog-post -->
    <?php endfor; ?>
    <?php include_once(ROOT . "/templates/navigatorblock.php"); ?>
</div><!-- /.blog-main -->
