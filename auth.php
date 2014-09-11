<?php

class Auth {

    function __destruct() {
        header('Location: index.php');
        exit();
    }

    function Register($db, $username, $password) {
        $newsesshash = $db->addUserAndGetSessionHash($username, $password);
        setcookie("username", $username);
        setcookie('hashsess', $newsesshash);
    }

    function Login($db, $username, $password) {

        $sessandid = $db->getNewSessionHashAndUserID($username, $password);
        $newsesshash = $sessandid['hash'];
        $userid = $sessandid['userid'];
        if ($newsesshash == FALSE) {
            //уведомление!!!   
        } else {
            setcookie("username", $username);
            setcookie("userid", $userid);
            setcookie('hashsess', $newsesshash);
        }
    }

    function Logout() {
        setcookie("username", "", time() - 3600);
        setcookie("userid", "", time() - 3600);
        setcookie("hashsess", "", time() - 3600);
    }

}
