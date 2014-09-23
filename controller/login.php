<?php

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$logout = getReqGET('logout');
$register = getReqPOST('register');
$username = getReqPOST('username');
$password = getReqPOST('password');
$userid = getReqPOST('userid');
$hashsess = getReqPOST('hashsess');
$returnurl = (isset($_SERVER['HTTP_REFERER'])) ? healString($_SERVER['HTTP_REFERER']) : '../controller/index.php';
$user = new Auth();
if ($logout) {
    $user->logout($userid, $hashsess);
    delcookie("username");
    delcookie("userid");
    delcookie("hashsess");
} else {
    if ($register) {
        $error = $user->register($username, $password);
    } else {
        $error = $user->login($username, $password);
    }
    if ($error) {
        sCookie("error", $error);
    } else {
        sCookie("username", $user->username);
        sCookie("userid", $user->userid);
        sCookie('hashsess', $user->hashsess);
    }
}
header("Location: " . $returnurl);
exit();
