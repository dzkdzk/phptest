<?php

include_once("db.php");
include_once("auth.php");
$db = new MySQLdata();
$db->connect();

$user = new Auth();
if (isset($_GET['logout'])) {
    $user->Logout();
} else {
    if (isset($_POST['register'])) {
        $user->Register($db, $_POST['username'], $_POST['password']);
    } else {
        $user->Login($db, $_POST['username'], $_POST['password']);
    }
}

$db->disconnect();
