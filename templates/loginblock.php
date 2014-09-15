<?php

if ($username) {
    echo <<<HTML
            <div>
            <p>Hello, {$username}!</p>
            <button onClick="location.href='../functions/login.php?logout=1'">Выйти</button>
            </div>
HTML;
} else {
    echo <<<HTML
            <div>
            <form action="../functions/login.php" method="post">
            <input name="username" type="text" size="20">
            <input name="password" type="password" size="40">
            <input name="loginbutton" type="submit" value="Войти">
            <label><input name="register" type="checkbox">Новый пользователь</label>
            </form>  
            </div>
HTML;
}
