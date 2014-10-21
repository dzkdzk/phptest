<?php                                      //вывод и редактирование страниц (Обо мне, ссылки и т.д.)

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Редактирование страниц';
$username = getCookie('username');
$userid = getCookie('userid');
$hashsess = getCookie('hashsess');
$error = getCookie('error');
$role = getCookie('role');
$pageid = getReqGET('id');
$ispagesave = getReqPOST('PageSave');
$title = getReqPOST('title');
$text = getReqPOST('text');
$isedit = getReqGet('edit');
if ($error) {Log::addtofile($error, basename(__FILE__));} //запись в логфайл ошибки
delCookie('error');
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
        sCookie('error', $error);
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
