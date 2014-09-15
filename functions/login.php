<?php

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/db.php");
$db = new MySQLdata();
$db->connect();
if (isset($_GET['logout'])) {
    Logout();
} else {
    if (isset($_POST['register'])) {
        Register($db, $_POST['username'], $_POST['password']);
    } else {
        Login($db, $_POST['username'], $_POST['password']);
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
