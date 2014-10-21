<?php

//вывод ленты со статьями с предпросмотром (JQuery)

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Главная страница';
$username = getCookie('username');
$userid = getCookie('userid');
$postcurpage = getReqPOST('curpage');
$tag = getReqGET('tag');
$uniq = getCookie('uniq');
$error = getCookie('error');
$role = getCookie('role');
$searchtext = getReqGET('search');
$isflush = getReqGET('flush');
$selpostsonpage = getReqPOST('selpostsonpage');
$cookpostsonpage = getCookie('postsonpage');
if ($selpostsonpage) {
    sCookie('postsonpage', $selpostsonpage);
} elseif ($cookpostsonpage) {
    $selpostsonpage = $cookpostsonpage;
} else {
    $selpostsonpage = POSTSONPAGE;
}
if ($error) {
    Log::addtofile($error, basename(__FILE__)); //запись в логфайл ошибки
} 
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
$cookcurpage = getCookie('curpage');
if ($cookcurpage) {
    $curpage = $cookcurpage;
}
if (!$postcurpage and ! $cookcurpage) {
    $curpage = 1;
}

if ($postcurpage) {                                               //ajax get posts
    sCookie('curpage', $postcurpage);
    $curpage = $postcurpage;

    $navbar = new navigator($curpage, $selpostsonpage, $tag, $searchtext);        //расчет параметров для пагинации
    if ($viewtype == 2) {                                        //вывод ленты по найденному текста
        $lenta->getBlockPostByText($selpostsonpage * ($curpage - 1), $selpostsonpage, $searchtext);
        for ($i = 0; $i < count($lenta->title); $i++) {
            $lenta->getBlockTags($lenta->postid[$i]);
        }
    } elseif ($lenta->getBlockPost($selpostsonpage * ($curpage - 1), $selpostsonpage, $tag)) {         //вывод ленты с выборкой по тегу либо всех статей
        for ($i = 0; $i < count($lenta->title); $i++) {
            $lenta->getBlockTags($lenta->postid[$i]);
        }
    }

    $poststruct = array('postid' => $lenta->postid, 'title' => $lenta->title, 'text' => $lenta->text, 'author' => $lenta->author, 'date' => $lenta->date, 'tags' => $lenta->tags, 'postamount' => $navbar->postamount);
    echo json_encode($poststruct);
} else {
    include_once(ROOT . "/templates/header.php");
    include_once(ROOT . "/templates/leftbarblock.php");
    include_once(ROOT . "/templates/template_index_2.php");
    include_once(ROOT . "/templates/footer.php");
}