<?php

//вывод ленты со статьями с предпросмотром (Javascript)
session_start();
include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
$pagetitle = 'Главная страница';
$username = getSession('username');
$userid = getSession('userid');
$curpage = getReqGET('curpage');
$tag = getReqGET('tag');
$uniq = getCookie('uniq');
$error = getSession('error');
$role = getSession('role');
$searchtext = getReqGET('search');
$isflush = getReqGET('flush');
$selpostsonpage = getReqPOST('selpostsonpage');
$sesspostsonpage = getSession('postsonpage');
if ($selpostsonpage) {
    sSession('postsonpage', $selpostsonpage);
} elseif ($sesspostsonpage) {
    $selpostsonpage = $sesspostsonpage;
} else {
    $selpostsonpage = POSTSONPAGE;
}
if ($error) {
    Log::addtofile($error, basename(__FILE__)); //запись в логфайл ошибки
} 
delSession('error');                          //очищаем значение ошибки
if (!$uniq) {                                //оставляем пользователю уник. идентификатор
    $uniq = gethash(time() + rand());
    setCookie('uniq', $uniq, time() + 315000000, COOKIEPATH, DOMAIN);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);     //делаем запись о пользователе в лог
$lenta = new ArticlesBlock();
$viewtype = getSession('viewtype');
if ($tag) {                                  //логика по различным отображениям ленты: по тегам, по поиску, подряд
    sSession('tag', $tag);
    $viewtype = 1;
    sSession('viewtype', 1);
} else {
    $tag = getSession('tag');
}
if ($searchtext) {
    sSession('search', $searchtext);
    $viewtype = 2;
    sSession('viewtype', 2);
} else {
    $searchtext = getSession('search');
}
if ($isflush) {
    delSession('viewtype');
    delSession('tag');
    delSession('search');
    $tag = false;
    $searchtext = false;
    $viewtype = false;
}
//$navbar = new navigator($curpage, $selpostsonpage, $tag, $searchtext);        //расчет параметров для пагинации
if ($viewtype == 2) {                                        //вывод ленты по найденному текста
    $lenta->getBlockPostByText(0, 4294967296, $searchtext);
    for ($i = 0; $i < count($lenta->title); $i++) {
        $lenta->getBlockTags($lenta->postid[$i]);
    }
} elseif ($lenta->getBlockPost(0, 4294967296, $tag)) {         //вывод ленты с выборкой по тегу либо всех статей
    for ($i = 0; $i < count($lenta->title); $i++) {
        $lenta->getBlockTags($lenta->postid[$i]);
    }
}
include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/leftbarblock.php");
include_once(ROOT . "/templates/template_index_1.php");
include_once(ROOT . "/templates/footer.php");
