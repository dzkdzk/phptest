<?php

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
delCookie('error');
if (!$uniq) {
    $uniq = gethash(time() + rand());
    sCookie('uniq', $uniq);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);
$navbar = new navigator($curpage, $tag);
$lenta = new ArticlesBlock();
$lenta->getBlockPost($navbar->postsonpage * ($navbar->currentpage - 1), $navbar->postsonpage, $tag);
for ($i = 0; $i < count($lenta->title); $i++) {
    $lenta->getBlockTags($lenta->postid[$i]);
}
include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_index.php");
include_once(ROOT . "/templates/footer.php");
