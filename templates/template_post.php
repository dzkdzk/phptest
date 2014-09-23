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

            <div class="blog-post">
                <h2 class="blog-post-title"><a href = '../controller/post.php?id=<?= $fullpost->postid ?>'><?= $fullpost->title ?></a></h2>
                <div><?= nl2br($fullpost->text) ?></div>
                <?php
                for ($i = 0; $i < count($fullpost->files); $i++) :
                    ?>
                    <?php $filepath = uploaddir . $fullpost->files[$i]['filename'] ?>
                    <!-- Modal -->
                    <div id="myModal<?= $i ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="..<?= $filepath ?>" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>    <!-- Modal-->                              
                    <a data-toggle="modal" data-target="#myModal<?= $i ?>"><img src="..<?= $filepath ?>" class="img-responsive img-thumbnail img-small"></a>
                <?php endfor ?>
                <div class="blog-post-meta">Автор: <?= $fullpost->tail ?></div>
                <div class="blog-post-meta">Дата: <?= gmdate("d-m-Y\ H:i:s\ ", $fullpost->date + timezone * 3600) ?></div>
                <?php if ($fullpost->tags): ?>
                    <div class="blog-post-meta">Теги:
                        <?php
                        for ($i = 0; $i < count($fullpost->tags); $i++) :
                            ?>
                            <a href='../controller/index.php?tag=<?= $fullpost->tags[$i]["id"] ?>'><?= $fullpost->tags[$i]["tag"] ?></a>
                        <?php endfor ?>
                    </div>
                <?php endif ?>
                <?php if ($userid) : ?>
                    <div class="imgbrdr"></div>
                    <a href='../controller/edit.php?id=<?= $fullpost->postid ?>'><img class="icoedit" /></a>
                    <a href="../controller/index.php" onclick="return confirm('Удалить статью?') ? $.post('../controller/edit.php', {del_id: <?= $fullpost->postid ?>}) : null;"><img class="icodelete" /></a>
                    <div class="imgbrdr"></div>
                <?php endif ?>
            </div><!-- /.blog-post -->

            <?php include_once(ROOT . "/templates/commentsblock.php"); ?>

        </div><!-- /.blog-main -->
        <?php
        include_once(ROOT . "/templates/sidebarblock.php");
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->
