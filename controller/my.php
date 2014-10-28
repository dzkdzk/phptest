<?php                                    //личный кабинет, вывод и редактирование своих данных
session_start();
include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
$pagetitle = 'Кабинет пользователя';
$username = getSession('username');
$userid = getSession('userid');
$hashsess = getSession('hashsess');
$error = getSession('error');
$saveUserInfo = getReqPost('saveUserInfo');
$email = getReqPost('email');
$fullname = getReqPost('fullname');
$role = getSession('role');
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
$loger->record($userid, $uniq, $server);         //делаем запись о пользователе в лог

$user = new Auth();
if ($saveUserInfo) {                             //апдейт данных о пользователе в базе
    $user->updateAdvUserInfo($userid, $hashsess, $fullname, $email, false, false);
}
if ($userid and $hashsess) {
    $user->getAdvUserInfo($userid, $hashsess);   //выборка всех данных о пользователе
}
include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/leftbarblock.php");
include_once(ROOT . "/templates/template_my.php");
include_once(ROOT . "/templates/footer.php");
