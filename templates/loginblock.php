<?php if ($userid) : ?>
    <div class="form-signin">
            <h4 class="form-signin-heading"><a href='../controller/my.php'> <?= $username ?></a></h4>
        <button class="btn btn-large btn-primary" onClick="location.href = '../controller/login.php?logout=1'">Выйти</button>
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
