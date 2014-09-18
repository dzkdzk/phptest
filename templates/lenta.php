<?php $navbar->draw(); ?>
<?php for ($i = 0; $i < count($lenta->title); $i++): ?>
    <div>
        <div>
            <h2><a href='../controller/post.php?id=<?= $lenta->postid[$i] ?>'><?= $lenta->title[$i] ?></a></h2>
        </div>
        <div><?= $lenta->text[$i] ?></div>
        <div>Автор: <?= $lenta->tail[$i] ?></div>
        <div>Дата: <?= gmdate("d-m-Y\ H:i:s\ ", $lenta->date[$i] + timezone * 3600) ?></div>
        <?php if ($lenta->tags[$i]): ?>
            <div>Теги: 
                <?php foreach ($lenta->tags[$i] as $item): ?>
                    <a href='../controller/index.php?tag=<?= $item['id'] ?>'><?= $item['tag'] ?></a>                 
                <?php endforeach; ?>
            </div>
        <?php endif ?>
    </div>
<?php endfor; ?>
<?php if ($userid) : ?>
    <form method="post" id="form" action="../controller/edit.php">
        <button name="newpost" value="1" onclick="$('#form').submit();">Добавить запись</button>
    </form>
<?php endif; ?>


<?php $navbar->draw(); ?>