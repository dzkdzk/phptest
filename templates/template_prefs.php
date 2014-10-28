<?php
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
            <form method="post" action="../controller/prefs.php">
                <div class="form-group">
                    <label>Количество ссылок в навигаторе<input class="form-control" name="inppagelinksamount" type='text' value='<?= ($inppagelinksamount) ? $inppagelinksamount : PAGELINKSAMOUNT ?>'></label>
                </div>
                <div class="form-group">
                    <label>Длина анонса поста в ленте<input class="form-control" name="inpreviewlength" type='text' value='<?= ($inpreviewlength) ? $inpreviewlength : PREVIEWLENGTH ?>'></label>
                </div>
                <input class="btn btn-primary btn-lg btn-save" name="savePrefs" type='submit' value="Сохранить">
            </form>
        </div><!-- /.blog-main -->
        <?php
        include_once(ROOT . "/templates/sidebarblock.php");
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->


