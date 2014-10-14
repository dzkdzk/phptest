<?php

function getCookie($cook) {
    $res = FALSE;
    if (isset($_COOKIE[$cook])) {
        $res = $_COOKIE[$cook];
    }
    return $res;
}

function sCookie($cook, $val) {

    $res = setcookie($cook, $val, COOKIETIME, COOKIEPATH, DOMAIN);
    return $res;
}

function delCookie($cook) {

    $res = setcookie($cook, "", time() - 3600, COOKIEPATH, DOMAIN);
    return $res;
}

function getReqFiles($files) {
    $res = false;
    if (isset($_FILES[$files])) {
        $res = $_FILES[$files];
    }
    //$res = healString($res);
    return $res;
}

function getReqPOST($post) {
    $res = FALSE;
    if (isset($_POST[$post])) {
        $res = $_POST[$post];
    }
    $res = healString($res);
    return $res;
}

function getReqGET($get) {
    $res = FALSE;
    if (isset($_GET[$get])) {
        $res = $_GET[$get];
    }
    $res = healString($res);
    return $res;
}

function getReqPOSTbyName($name) {
    $tag = false;
    $id = false;
    $i = 0;
    foreach ($_POST as $key => $item) {
        if (preg_match("/tag\d+$/", $key)) {
            $tag = $item;
        }
        if (preg_match("/tag\d+x$/", $key)) {
            $id = $item;
        }
        if ($tag and $id) {
            if ($id == "new") {
                $id = $id . $i;
                $i++;
            }
            $res[$id] = healString($tag);
            $tag = false;
            $id = false;
        }
    }

    return @$res;
}

function healString($val) {
    if ($val) {
        if (is_string($val)) {
            $val = strip_tags($val);
            $val = htmlspecialchars($val);
        } elseif (is_array($val)) {
            foreach ($val as $key => $item) {
                $val[$key] = healString($item);
            }
        }
    }
    return $val;
}

function getHash($target) {

    $hash = hash('sha256', $target . SALT);
    return $hash;
}

function getOS($user_agent) {
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    return $os_platform;
}

function getBrowser($user_agent) {
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }
    return $browser;
}
