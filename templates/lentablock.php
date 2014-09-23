<div class="col-sm-8 blog-main">
    <?php for ($i = 0; $i < count($lenta->title); $i++): ?>
        <div class="blog-post">
            <h2 class="blog-post-title"><a href='../controller/post.php?id=<?= $lenta->postid[$i] ?>'><?= $lenta->title[$i] ?></a></h2>
            <div><?= nl2br($lenta->text[$i]) ?></div>
            <div class="blog-post-meta">Автор: <?= $lenta->author[$i] ?></div>
            <div class="blog-post-meta">Дата: <?= gmdate("d-m-Y\ H:i:s\ ", $lenta->date[$i] + timezone * 3600) ?></div>
            <?php if ($lenta->tags[$i]): ?>
                <div class="blog-post-meta">Теги: 
                    <?php foreach ($lenta->tags[$i] as $item): ?>
                        <a href='../controller/index.php?tag=<?= $item['id'] ?>'><?= $item['tag'] ?></a>                 
                    <?php endforeach; ?>
                </div>
            <?php endif ?>
        </div><!-- /.blog-post -->
    <?php endfor; ?>
    <?php if ($userid) : ?>
        <form method="post" id="form" action="../controller/edit.php">
            <button name="newpost" value="1" onclick="$('#form').submit();">Добавить запись</button>
        </form>
    <?php endif; ?>
    <?php include_once(ROOT . "/templates/navigatorblock.php"); ?>
</div><!-- /.blog-main -->

