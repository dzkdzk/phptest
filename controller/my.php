<?php

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Кабинет пользователя';
$username = getCookie('username');
$userid = getCookie('userid');
$hashsess = getCookie('hashsess');
$error = getCookie('error');
$saveUserInfo = getReqPost('saveUserInfo');
$email = getReqPost('email');
$fullname = getReqPost('fullname');

delCookie('error');
$postid = getReqGET('id');
$uniq = getCookie('uniq');
if (!$uniq) {
    setcookie('uniq', gethash(time() + rand()), time() + 316000000);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);

$user = new Auth();
if ($saveUserInfo) {
    $user->updateAdvUserInfo($userid, $hashsess, $fullname, $email);
}
if ($userid and $hashsess) {
    $user->getAdvUserInfo($userid, $hashsess);
}
include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_my.php");
include_once(ROOT . "/templates/footer.php");
