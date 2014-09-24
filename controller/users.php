<?php                                            //вывод и редактирование пользователей

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Управление пользователями';
$username = getCookie('username');
$userid = getCookie('userid');
$hashsess = getCookie('hashsess');
$error = getCookie('error');
$saveUserInfo = getReqPost('saveUserInfo');
$targetemail = getReqPost('email');
$targetuserid = getReqPOST('userid');
$targetnewrole = (getReqPost('role')) ? EDITOR_ROLE : USER_ROLE;
$targetfullname = getReqPost('fullname');
$isdeluser = getReqPost('del_id');
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
$loger->record($userid, $uniq, $server);       //делаем запись о пользователе в лог

$user = new Auth();
if ($isdeluser) {         //удалить пользователся
    $user->delUserAndRef($userid, $hashsess, $isdeluser);
}
if ($saveUserInfo) {    //Сохранить данные
    $user->updateAdvUserInfo($userid, $hashsess, $targetfullname, $targetemail, $targetnewrole, $targetuserid);
}
if ($role == ADMIN_ROLE) {   //выбираем из базы данные всех пользователей
    $user->getAllUserCred($userid, $hashsess);
} else {
    header('Location: ../controller/index.php');
    exit();
}
include_once(ROOT . "/templates/header.php" );
include_once(ROOT . "/templates/template_users.php" );
include_once(ROOT . "/templates/footer.php");
