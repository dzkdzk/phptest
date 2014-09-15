<?php

function getCookie($cook) {
    $res = FALSE;
    if (isset($_COOKIE[$cook])) {
        $res = $_COOKIE[$cook];
    }
    return $res;
}

function sCookie($cook, $val) {

    $res = setcookie($cook, $val, cookietime, cookiepath, domain);
    return $res;
}

function delCookie($cook) {

    $res = setcookie($cook, "", time() - 3600, cookiepath, domain);
    return $res;
}

function getReqPOST($post) {
    $res = FALSE;
    if (isset($_POST[$post])) {
        $res = $_POST[$post];
    }
    return $res;
}

function getReqGET($get) {
    $res = FALSE;
    if (isset($_GET[$get])) {
        $res = $_GET[$get];
    }
    return $res;
}
