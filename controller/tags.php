<?php
session_start();
include_once("../config.php");
include_once ('../models/autoload.php');
include_once(ROOT . "/functions/common_func.php");
$tagval = getReqGET('tagval');
$db = new DbAccess();
if (strlen($tagval) > 2) {
    $res = $db->getTagsByPart($tagval);
    echo json_encode($res);
}
