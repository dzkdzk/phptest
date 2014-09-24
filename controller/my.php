<?php                                    //личный кабинет, вывод и редактирование своих данных

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
$role = getCookie('role');

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
include_once(ROOT . "/templates/template_my.php");
include_once(ROOT . "/templates/footer.php");
