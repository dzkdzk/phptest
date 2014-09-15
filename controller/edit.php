<?php

include_once("../config.php");   // тут общие настройки и константы которые не изменяются
include_once(ROOT . "/functions/common_func.php");
include_once(ROOT . "/models/classes.php");
$pagetitle = 'Редактирование статьи';
$username = getCookie('username');
$userid = getCookie('userid');
$postauthorid = getCookie('userid');
$postauthorname = getCookie('username');
$hashsess = getCookie('hashsess');
$ispostsave = getReqPOST('SavePost');
$delpost = getReqPOST('del_id');
$isnewpost = getReqPOST('newpost');

$fullpost = new SinglePost();

if ($delpost) {
    $postid = $delpost;
    $fullpost->delPost($postid, $postauthorid, $hashsess);
    header('Location: ../controller/index.php');
    exit();
} elseif ($ispostsave) {
    $postid = getReqPOST('postid');
    $posttitle = getReqPOST('inptitle');
    $posttext = getReqPOST('inptext');
    if ($postid == "new") {
        $postid = $fullpost->addPost($posttitle, $posttext, $postauthorid, $hashsess);
    } else {
        $fullpost->editPost($postid, $posttitle, $posttext, $postauthorid, $hashsess);
    }
    header('Location: ../controller/post.php?id=' . $postid);
    exit();
} elseif ($isnewpost) {
    $posttitle = "";
    $posttext = "";
    $postid = "new";
} else {
    $postid = getReqGET('id');
    $fullpost->getSinglePost($postid);
    $posttitle = $fullpost->title;
    $posttext = $fullpost->text;
    $postauthorname = $fullpost->tail;
}

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_edit.php");
include_once(ROOT . "/templates/footer.php");

