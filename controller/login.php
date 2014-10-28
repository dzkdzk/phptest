<?php

session_start();
include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
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
    delSession('username');
    delSession('userid');
    delSession('hashsess');
    delSession('fullname');
    delSession('role');
} else {
    if ($register) {
        $error = $user->register($username, $password);
    } else {
        $error = $user->login($username, $password);
    }
    if ($error) {
        setSession('error', $error);
    } else {
        setSession("username", $user->username);
        setSession("userid", $user->userid);
        setSession('hashsess', $user->hashsess);
        setSession('role', $user->role);
    }
}
header("Location: " . $returnurl);
exit();
