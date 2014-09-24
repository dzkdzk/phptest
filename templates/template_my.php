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
            <form method="post" action="../controller/my.php">
                <div class="form-group">
                    <label>Полное имя<input class="form-control" name="fullname" type='text' value='<?= $user->fullname ?>'></label>
                </div>
                <div class="form-group">
                    <label>E-Mail<input class="form-control" name="email" type='text' value='<?= $user->email ?>'></label>
                </div>
                <div class="form-group">
                    <label>Полномочия<input class="form-control" disabled='yes' type='text' value='<?php
                                    if ($user->role == ADMIN_ROLE) {
                                        echo 'администратор';
                                    } elseif ($user->role == EDITOR_ROLE) {
                                        echo 'редактор';
                                    } else {
                                        echo 'пользователь';
                                    }
                                    ?>'></label>
                </div>
                <div class="form-group">
                    <label>Логин<input class="form-control" disabled='yes' type='text' value='<?= $user->username ?>'></label>
                </div>
                <input class="btn btn-primary btn-lg btn-save" name="saveUserInfo" type='submit' value="Сохранить">
            </form>
        </div><!-- /.blog-main -->
        <?php
        include_once(ROOT . "/templates/sidebarblock.php");
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->


