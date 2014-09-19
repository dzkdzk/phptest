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
    $tagids = getReqPOSTbyName('tag');
    $postid = getReqPOST('postid');
    $posttitle = getReqPOST('inptitle');
    $posttext = getReqPOST('inptext');
    $files = getReqFiles('image');


    foreach ($files["error"] as $key => $error) {
        if ($files["size"][$key] > 1024 * 3 * 1024) {
            continue;
        }
        if ($error == UPLOAD_ERR_OK) {
            $newfilename = getHash(time() . rand()) . ".jpg";
            $tmp_name = $files["tmp_name"][$key];
            $name = $files["name"][$key];
            move_uploaded_file($tmp_name, ROOT . uploaddir . $newfilename);
            $filenames[] = $newfilename;
        }
    }


    if ($postid == "new") {
        $postid = $fullpost->addPost($posttitle, $posttext, $postauthorid, $hashsess, $tagids, $filenames);
    } else {
        $fullpost->editPost($postid, $posttitle, $posttext, $postauthorid, $hashsess, $tagids, $filenames);
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
    $files = $fullpost->files;
}

include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_edit.php");
include_once(ROOT . "/templates/footer.php");

