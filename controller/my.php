<?php                                    //личный кабинет, вывод и редактирование своих данных

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
$pagetitle = 'Кабинет пользователя';
$username = getCookie('username');
$userid = getCookie('userid');
$hashsess = getCookie('hashsess');
$error = getCookie('error');
$saveUserInfo = getReqPost('saveUserInfo');
$email = getReqPost('email');
$fullname = getReqPost('fullname');
$role = getCookie('role');
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
