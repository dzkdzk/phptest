<?php

include_once("../config.php");   // тут общие настройки и константы которые не изменяются
include_once(ROOT . "/models/auth.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");  // тут все твои классы которые тебе понадобятся для реализации логики в этом контролере
//include_once("$ROOT/models/твой_класс2.php»);// тут все твои классы которые тебе понадобятся для реализации логики в этом контролере
// дальше пхп логика которая будет делать что-то например ставить куки  или вычислять IP адресс или сохранять всю возможную информацию про пользователя в БД
// IP, с какого сайте пришел, в какое время пришел, какой браузер какая ОС и так далее все что хочешь еще + поставить куку что-бы в следующий раз вспомнить что этот чел тут был
$pagetitle = 'Просмотр статьи';
$username = getCookie('username');
$userid = getCookie('userid');
$postid=$_GET['id'];

$fullpost = new SinglePost();
$fullpost->getSinglePost($postid);

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_post.php");
include_once(ROOT . "/templates/footer.php");      


