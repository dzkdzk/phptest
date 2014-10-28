<?php

include_once("../config.php");
include_once(ROOT . "/models/db.php");
include_once(ROOT . "/functions/common_func.php");
$file = getReqPost('img');
$postid = getReqPost('postid');
$userid = getReqPost('userid');
$hashsess = getReqPost('hashsess');
$db = new DbAccess();
$error = $db->delFileFromPost($postid, $userid, $hashsess, $file);
if ($error) {
    echo $error;
} else {
    echo "Успешно удалено!";
}
