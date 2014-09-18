<?php

include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$userid = getCookie('userid');
$hashsess = getCookie('hashsess');
$postid = getReqPost('postid');
$commenttext = getReqPost('comment');
$comment = new Comments();
$comment->newComment($postid, $userid, $hashsess, $commenttext);
header('Location: ../controller/post.php?id=' . $postid);
exit();




