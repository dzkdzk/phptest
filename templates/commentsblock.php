<div class="detailBox">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php if ($commentblock or $userid) : ?>
        <div class="titleBox">
            <label>Комментарии</label>
        </div>
    <?php endif ?>
    <div class="actionBox">
        <?php if ($commentblock) : ?>
            <ul class="commentList">
                <?php foreach ($commentblock as $comment) : ?>
                    <li>
                        <div class="commentText">
                            <div><?= nl2br($comment['text']) ?></div>
                            <span class="blog-post-meta"><?= ($comment['fullname']) ? $comment['fullname'] : $comment['login'] ?></span>
                            <span class="blog-post-meta"><?= gmdate("d-m-Y\ H:i:s\ ", $comment['date'] + TIMEZONE * 3600) ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif ?>
        <?php if ($userid) : ?>
            <form class="form-inline" role="form" action="../controller/newcomment.php" method="post">
                <div class="form-group">
                    <input class="form-control" name="postid" type="hidden" value="<?= $postid ?>">
                    <input class="form-control" type="text" placeholder="Текст комментария" name="comment" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-large btn-primary" value="отправить">
                </div>
            </form>
        <?php endif ?>
    </div>
</div>

