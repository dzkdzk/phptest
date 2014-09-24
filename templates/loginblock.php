<?php if ($userid) : ?>
    <div class="form-group">
        <h4 class="form-signin-heading"><a href='../controller/my.php'> <?= $username ?></a></h4>
        <ul class="nav nav-pills nav-stacked">

            <li><a onClick="location.href = '../controller/login.php?logout=1'">Выйти</a></li>
            <?php if ($role == ADMIN_ROLE) : ?>
                <li><a onClick="location.href = '../controller/users.php'" type="button">Список пользователей</a></li>
                <li><a onClick="location.href = '../controller/pages.php?edit=1'" type="button">Обо мне</a></li>
                <li><a onClick="location.href = '../controller/pages.php?edit=2'" type="button">Ссылки</a></li>
            <?php endif; ?>
            <?php if ($role == EDITOR_ROLE or $role == ADMIN_ROLE) : ?>
                <li><a onClick="location.href = '../controller/edit.php'" type="button">Добавить статью</a></li>
            <?php endif ?>
        </ul>
    </div>
<?php else: ?>
    <form class="form-signin" action = "../controller/login.php" method = "post">
        <h4 class="form-signin-heading">Войдите, пожалуйста</h4>
        <input name = "username" type = "text" class="input-block-level" placeholder="ваш логин">
        <input name = "password" type = "password" class="input-block-level" placeholder="пароль">
        <input name = "loginbutton" type = "submit" class="btn btn-large btn-primary" value = "Войти">
        <label class="checkbox"><input name = "register" type = "checkbox">Новый пользователь</label>
    </form>
<?php endif ?>
