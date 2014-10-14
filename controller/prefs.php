<?php

//расширенные настройки (для админа)

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Кабинет пользователя';
$username = getCookie('username');
$userid = getCookie('userid');
$hashsess = getCookie('hashsess');
$error = getCookie('error');
$savePrefs = getReqPost('savePrefs');
$email = getReqPost('email');
$fullname = getReqPost('fullname');
$role = getCookie('role');

$inppagelinksamount = getReqPost('inppagelinksamount');
$inpreviewlength = getReqPost('inpreviewlength');

delCookie('error');
$postid = getReqGET('id');
$uniq = getCookie('uniq');
if (!$uniq) {                                //оставляем пользователю уник. идентификатор
    $uniq = gethash(time() + rand());
    setCookie('uniq', $uniq, time() + 315000000, COOKIEPATH, DOMAIN);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);         //делаем запись о пользователе в лог


if ($savePrefs) {                             //апдейт конфига
    if ($inppagelinksamount) {
        Conf::setConfDef('PAGELINKSAMOUNT', $inppagelinksamount, $userid, $hashsess);
    }
    if ($inpreviewlength) {
        Conf::setConfDef('PREVIEWLENGTH', $inpreviewlength, $userid, $hashsess);
    }
}

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_prefs.php");
include_once(ROOT . "/templates/footer.php");