<?php                                      //вывод и редактирование страниц (Обо мне, ссылки и т.д.)
session_start();
include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
$pagetitle = 'Редактирование страниц';
$username = getSession('username');
$userid = getSession('userid');
$hashsess = getSession('hashsess');
$error = getSession('error');
$role = getSession('role');
$pageid = getReqGET('id');
$ispagesave = getReqPOST('PageSave');
$title = getReqPOST('title');
$text = getReqPOST('text');
$isedit = getReqGet('edit');
if ($error) {Log::addtofile($error, basename(__FILE__));} //запись в логфайл ошибки
delSession('error');
$postid = getReqGET('id');
$uniq = getCookie('uniq');
if (!$uniq) {                                //оставляем пользователю уник. идентификатор
    $uniq = gethash(time() + rand());
    setCookie('uniq', $uniq, time() + 315000000, COOKIEPATH, DOMAIN);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);        //делаем запись о пользователе в лог

$page = new pages();
if ($ispagesave) {         // сохранение редактирования
    $pageid = getReqPOST('pageid');
    $error = $page->updateContent($pageid, $title, $text, $userid, $hashsess);
    if ($error) {
        sSession('error', $error);
    }
    header('Location: ../controller/pages.php?id=' . $pageid);
    exit();
} elseif ($isedit) {
    $page->getContent($isedit);   //редактирование
} else {
    $page->getContent($pageid);   //вывод
}

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/leftbarblock.php");
include_once(ROOT . "/templates/template_pages.php");
include_once(ROOT . "/templates/footer.php");
