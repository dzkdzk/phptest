
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
        <?php
        include_once(ROOT . "/templates/lentablock.php");
        ?>
        <?php
        include_once(ROOT . "/templates/sidebarblock.php");
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->

