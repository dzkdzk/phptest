<?php

abstract class HTMLPage {

    protected $Title = "";

    function __construct($Title) {
        $this->Title = "[Блог Для Всех] " . $Title;
    }

    function BeginHTML() {
        echo <<<HTML
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/style.css" type="text/css"> 
        <script src="jquery-2.1.1.min.js"></script>
        <title>{$this->Title}</title>
        </head>
        <body>
HTML;
    }

    function EndHTML() {
        echo <<<HTML
        </body>
        </html>
HTML;
    }

    function Logo() {
        echo "<h1>Welcome! Блог Для Всех!</h2>";
    }

    function Menu() {
        echo <<<HTML
        <div>
        <table>
        <tr>
        <td><a href = 'index.php'>Главная страница, лента</a></td>
        <td><a href = 'bio.php'>Обо мне</a></td>
        <td><a href = 'links.php'>Полезные ссылки</a></td>
        <td><a href = 'admin.php'>Админская панель</a></td>
        </tr>
        </table>
        </div>
HTML;
    }

    function Login() {
        if (isset($_COOKIE['username'])) {
            echo <<<HTML
            <div>
            <p>Hello, {$_COOKIE["username"]}!</p>
            <button onClick="location.href='login.php?logout=1'">Выйти</button>
            </div>
HTML;
        } else {
            echo <<<HTML
            <div>
            <form action="login.php" method="post">
            <input name="username" type="text" size="20">
            <input name="password" type="password" size="40">
            <input name="loginbutton" type="submit" value="Войти">
            <label><input name="register" type="checkbox">Новый пользователь</label>
            </form>  
            </div>
HTML;
        }
    }

    abstract function MainText();

    function Write() {
        $this->BeginHTML();
        $this->Logo();
        $this->Menu();
        $this->Login();
        $this->MainText();
        $this->EndHTML();
    }

}
