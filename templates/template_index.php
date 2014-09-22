<?php

include_once(ROOT . "/templates/menublock.php");
include_once(ROOT . "/templates/loginblock.php");
include_once(ROOT . "/templates/messageblock.php");
echo <<<HTML
<p>Добро пожаловать в Блог для Всех</p>
HTML;
include(ROOT . "/templates/navigatorblock.php");
include_once(ROOT . "/templates/lentablock.php");
include(ROOT . "/templates/navigatorblock.php");
