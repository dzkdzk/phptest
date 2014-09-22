<?php if ($userid) : ?>
    <div>
        <p>Hello,
        <a href='../controller/my.php'> <?= $username ?>!</a></p>
        <button onClick="location.href = '../controller/login.php?logout=1'">Выйти</button>
    </div>
<?php else: ?>
    <div>
        <form action = "../controller/login.php" method = "post">
            <input name = "username" type = "text" size = "20">
            <input name = "password" type = "password" size = "40">
            <input name = "loginbutton" type = "submit" value = "Войти">
            <label><input name = "register" type = "checkbox">Новый пользователь</label>
        </form>
    </div>
<?php endif ?>
