<?php

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Просмотр статьи';
$username = getCookie('username');
$userid = getCookie('userid');
$error = getCookie('error');
delCookie('error');
$postid = getReqGET('id');
$uniq = getCookie('uniq');
if (!$uniq) {
    setcookie('uniq', gethash(time() + rand()), time() + 316000000);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);
$fullpost = new SinglePost();
$fullpost->getSinglePost($postid);
$commentblock = $fullpost->getBlockComments($postid);

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_post.php");
include_once(ROOT . "/templates/footer.php");


