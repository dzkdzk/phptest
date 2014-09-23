<div class="detailBox">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <div class="titleBox">
        <label>Комментарии</label>
    </div>
    <div class="actionBox">
        <ul class="commentList">
            <?php
            if ($commentblock) :
                foreach ($commentblock as $comment) :
                    ?>
                    <li>
                        <div class="commentText">
                            <div><?= nl2br($comment['text']) ?></div>
                            <span class="blog-post-meta"><?= $comment['fullname'] ?></span>
                            <span class="blog-post-meta"><?= gmdate("d-m-Y\ H:i:s\ ", $comment['date'] + timezone * 3600) ?></span>
                        </div>
                    </li>
                    <?php
                endforeach;
            endif
            ?>
        </ul>
        <?php if ($userid) : ?>
            <form class="form-inline" role="form" action="../controller/newcomment.php" method="post">
                <div class="form-group">
                    <input class="form-control" name="postid" type="hidden" value="<?= $postid ?>">
                    <input class="form-control" type="text" placeholder="Текст комментария" name="comment" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-large btn-primary">
                </div>
            </form>
        <?php endif ?>
    </div>
</div>

