<?php

include_once("../config.php");
include_once(ROOT . "/models/db.php");
include_once(ROOT . "/functions/common_func.php");
$tagval = getReqGET('tagval');
$db = new MySQLdata();
if (strlen($tagval) > 2) {
    $res = $db->getTagsByPart($tagval);
    echo json_encode($res);
}
