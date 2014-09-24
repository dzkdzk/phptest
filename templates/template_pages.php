<?php
delCookie('test');
include_once(ROOT . "/templates/menublock.php");
include_once(ROOT . "/templates/messageblock.php");
?>


<div class="container">
    <div class="blog-header">
        <h1 class="blog-title">Блог Для Всех</h1>
        <p class="lead blog-description">Добро пожаловать!</p>
    </div>
    <div class="row">
        <div class="col-sm-8 blog-main">
            <?php if ($isedit): ?>
                <form method="post" action="../controller/pages.php">
                    <div class="form-group">
                        <label>Заголовок<input class="form-control" name="title" type='text' value='<?= $page->title ?>'></label>
                        <input name="pageid" type='hidden' value='<?= $isedit ?>'>
                    </div>
                    <div class="form-group">
                        <label>Текст: </label><textarea class="form-control" id="inptext" rows="10" cols="60" name="text"><?= $page->text ?></textarea>
                    </div>
                    <input class="btn btn-primary btn-lg btn-save" name="PageSave" type='submit' value="Сохранить">
                </form>
            <?php endif ?>
            <?php if ($pageid): ?>
                <div class="blog-post">
                    <h2 class="blog-post-title"><?= $page->title ?></h2>
                    <div><?= nl2br($page->text) ?></div>
                </div><!-- /.blog-post -->
            <?php endif ?>
        </div><!-- /.blog-main -->
        <?php
        include_once(ROOT . "/templates/sidebarblock.php");
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->


