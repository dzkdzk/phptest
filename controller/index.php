<?php

include_once("../config.php");
include_once(ROOT . "/models/auth.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
//include_once("$ROOT/models/твой_класс2.php»);// тут все твои классы которые тебе понадобятся для реализации логики в этом контролере
// дальше пхп логика которая будет делать что-то например ставить куки  или вычислять IP адресс или сохранять всю возможную информацию про пользователя в БД
// IP, с какого сайте пришел, в какое время пришел, какой браузер какая ОС и так далее все что хочешь еще + поставить куку что-бы в следующий раз вспомнить что этот чел тут был
$pagetitle = 'Главная страница';
$username = getCookie('username');
$userid = getCookie('userid');
$curpage = getReqGET('curpage');
$tag = getReqGET('tag');
$navbar = new navigator($curpage, $tag);
$lenta = new ArticlesBlock();
$lenta->getBlockPost($navbar->postsonpage * ($navbar->currentpage - 1), $navbar->postsonpage, $tag);
for ($i = 0; $i < count($lenta->title); $i++) {
    $lenta->getBlockTags($lenta->postid[$i]);
}

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_index.php");
include_once(ROOT . "/templates/footer.php");
