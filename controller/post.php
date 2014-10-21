<?php

//вывод одиночной статьи полностью
error_reporting(E_ALL & ~E_NOTICE);
include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
$pagetitle = 'Просмотр статьи';
$username = getCookie('username');
$userid = getCookie('userid');
$error = getCookie('error');
delCookie('error');
if ($error) {
    Log::addtofile($error, basename(__FILE__));
} //запись в логфайл ошибки
$postid = getReqGET('id');
$uniq = getCookie('uniq');
$role = getCookie('role');
if (!$uniq) {                                //оставляем пользователю уник. идентификатор
    $uniq = gethash(time() + rand());
    setCookie('uniq', $uniq, time() + 315000000, COOKIEPATH, DOMAIN);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);           //делаем запись о пользователе в лог
$fullpost = new SinglePost();
$fullpost->getSinglePost($postid);                 //получаем данные статьи
$commentblock = $fullpost->getBlockComments($postid); //получаем комментарии статьи

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/leftbarblock.php");
include_once(ROOT . "/templates/template_post.php");
include_once(ROOT . "/templates/footer.php");


