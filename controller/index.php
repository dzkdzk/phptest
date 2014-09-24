<?php

//вывод ленты со статьями с предпросмотром

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Главная страница';
$username = getCookie('username');
$userid = getCookie('userid');
$curpage = getReqGET('curpage');
$tag = getReqGET('tag');
$uniq = getCookie('uniq');
$error = getCookie('error');
$role = getCookie('role');
$searchtext = getReqGET('search');
$isflush = getReqGET('flush');

delCookie('error');                          //очищаем значение ошибки
if (!$uniq) {                                //оставляем пользователю уник. идентификатор
    $uniq = gethash(time() + rand());
    setCookie('uniq', $uniq, time() + 315000000, COOKIEPATH, DOMAIN);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);     //делаем запись о пользователе в лог
$lenta = new ArticlesBlock();
$viewtype = getCookie('viewtype');
if ($tag) {                                  //логика по различным отображениям ленты: по тегам, по поиску, подряд
    sCookie('tag', $tag);
    $viewtype = 1;
    sCookie('viewtype', 1);
} else {
    $tag = getCookie('tag');
}
if ($searchtext) {
    sCookie('search', $searchtext);
    $viewtype = 2;
    sCookie('viewtype', 2);
} else {
    $searchtext = getCookie('search');
}
if ($isflush) {
    delCookie('viewtype');
    delCookie('tag');
    delCookie('search');
    $tag = false;
    $searchtext = false;
    $viewtype = false;
}
$navbar = new navigator($curpage, $tag, $searchtext);        //расчет параметров для пагинации
if ($viewtype == 2) {                                        //вывод ленты по найденному текста
    $lenta->getBlockPostByText($navbar->POSTSONPAGE * ($navbar->currentpage - 1), $navbar->POSTSONPAGE, $searchtext);
    for ($i = 0; $i < count($lenta->title); $i++) {
        $lenta->getBlockTags($lenta->postid[$i]);
    }
} elseif ($lenta->getBlockPost($navbar->POSTSONPAGE * ($navbar->currentpage - 1), $navbar->POSTSONPAGE, $tag)) {         //вывод ленты с выборкой по тегу либо всех статей
    for ($i = 0; $i < count($lenta->title); $i++) {
        $lenta->getBlockTags($lenta->postid[$i]);
    }
}
include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_index.php");
include_once(ROOT . "/templates/footer.php");
