<?php
session_start();
include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
$userid = getSession('userid');
$hashsess = getSession('hashsess');
$postid = getReqPost('postid');
$commenttext = getReqPost('comment');
$fullpost = new SinglePost();
$fullpost->newComment($postid, $userid, $hashsess, $commenttext);
header('Location: ../controller/post.php?id=' . $postid);
exit();




