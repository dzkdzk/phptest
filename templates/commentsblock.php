<div>  
    <?php if ($commentblock or $userid): ?>
        Комментарии
    <?php endif ?>
    <?php
    if ($commentblock) :
        foreach ($commentblock as $comment) :
            ?>
            <div><?= gmdate("d-m-Y\ H:i:s\ ", $comment['date'] + timezone * 3600) ?></div>
            <div><?= nl2br($comment['text']) ?></div>
            <div><?= $comment['login'] ?></div>
            <?php
        endforeach;
    endif
    ?>
    <?php if ($userid) : ?>
        <form action="../controller/newcomment.php" method="post">
            <input name="postid" type="hidden" value="<?= $postid ?>">
            <textarea rows="10" cols="45" name="comment"></textarea><input type="submit">
        </form>
    <?php endif ?>
</div>