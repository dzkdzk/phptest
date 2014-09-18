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
$uniq = getCookie('uniq');
if (!$uniq) {
    sCookie('uniq', gethash(time() + rand()));
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);

$fullpost = new SinglePost();

if ($delpost) {                                          //при удалении поста
    $postid = $delpost;
    $fullpost->delPost($postid, $postauthorid, $hashsess);
    header('Location: ../controller/index.php');
    exit();
} elseif ($ispostsave) {                                 //обработка нажатия "Сохранить"
    $tags = getReqPOSTbyName('tag');
    $postid = getReqPOST('postid');
    $posttitle = getReqPOST('inptitle');
    $posttext = getReqPOST('inptext');
    if ($postid == "new") {
        $postid = $fullpost->addPost($posttitle, $posttext, $postauthorid, $hashsess, $tags);
    } else {
        $fullpost->editPost($postid, $posttitle, $posttext, $postauthorid, $hashsess, $tags);
    }
    header('Location: ../controller/post.php?id=' . $postid);
    exit();
} elseif ($isnewpost) {                                 // при нажатии "Новый пост"
    $posttitle = "";
    $posttext = "";
    $postid = "new";
} else {                                                // при редактировании поста
    $postid = getReqGET('id');
    $fullpost->getSinglePost($postid);
    $posttitle = $fullpost->title;
    $posttext = $fullpost->text;
    $postauthorname = $fullpost->tail;
    $tags = $fullpost->tags;
}

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_edit.php");
include_once(ROOT . "/templates/footer.php");

