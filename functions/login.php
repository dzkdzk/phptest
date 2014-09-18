<?php

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/db.php");
$db = new MySQLdata();
$db->connect();
$logout = getReqGET('logout');
$register = getReqPOST('register');
$username = getReqPOST('username');
$password = getReqPOST('password');
if ($logout) {
    Logout();
} else {
    if ($register) {
        Register($db, $username, $password);
    } else {
        Login($db, $username, $password);
    }
}
$db->disconnect();
header('Location: ../controller/index.php');
exit();

function Login($db, $username, $password) {

    $sessandid = $db->getNewSessionHashAndUserID($username, $password);
    $newsesshash = $sessandid['hash'];
    $userid = $sessandid['userid'];
    if ($newsesshash == FALSE) {
        //уведомление!!!   
    } else {
        sCookie("username", $username);
        sCookie("userid", $userid);
        sCookie('hashsess', $newsesshash);
    }
}

function Logout() {
    delcookie("username");
    delcookie("userid");
    delcookie("hashsess");
}

function Register($db, $username, $password) {
    $newsesshash = $db->addUserAndGetSessionHash($username, $password);
    scookie("username", $username);
    scookie('hashsess', $newsesshash);
}
