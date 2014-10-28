<?php

//редактирование статьи
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include_once("../config.php");
include_once(ROOT . "/functions/common_func.php");
include_once ('../models/autoload.php');
$pagetitle = 'Редактирование статьи';
$username = getSession('username');
$userid = getSession('userid');
$postauthorid = getSession('userid');
$postauthorname = getSession('username');
$error = getSession('error');
delSession('error');
if ($error) {
    Log::addtofile($error, basename(__FILE__));
} //запись в логфайл ошибки
$hashsess = getSession('hashsess');
$ispostsave = getReqPOST('SavePost');
$delpost = getReqPOST('del_id');
$isnewpost = getReqPOST('newpost');
$uniq = getCookie('uniq');
$role = getSession('role');
$editpost = getReqGET('id');
$filenames = false;
if (!$uniq) {                                //оставляем пользователю уник. идентификатор
    $uniq = gethash(time() + rand());
    setCookie('uniq', $uniq, time() + 315000000, COOKIEPATH, DOMAIN);
}
$server = healString($_SERVER);
$loger = new Log();
$loger->record($userid, $uniq, $server);         //делаем запись о пользователе в лог

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

    foreach ($files["error"] as $key => $error) {         //обработка полученных файлов
        $name = $files["name"][$key];
        $tmp_name = $files["tmp_name"][$key];
        list($width, $height, $type) = getimagesize($tmp_name);
        if (!$tmp_name) {                                       //если пустой
            continue;
        }
        if ($type != IMAGETYPE_GIF and $type != IMAGETYPE_JPEG and $type != IMAGETYPE_PNG) {
            $error = 'Неверный формат изображения.';               //если не изображение
            sSession('error', $error);
            continue;
        }
        if ($width < 32 or $height < 32) {                         //если мало точек
            $error = 'Размер изображения слишком мал.';
            sSession('error', $error);
            continue;
        }
        if (($files["size"][$key] > 1024 * 3 * 1024) and ( $files["size"][$key] < 1024)) {
            $error = 'Размер файл должен быть между 1 и 3000 КБ.';  //если размер файла необычный
            sSession('error', $error);
            continue;
        }
        if ($error == UPLOAD_ERR_OK) {                               //копирование из темпа в аплоад
            $newfilename = getHash(time() . rand()) . '.' . substr(strrchr($name, '.'), 1);
            move_uploaded_file($tmp_name, ROOT . UPLOADDIR . $newfilename);
            $filenames[] = $newfilename;                              //массив имен файлов для обработки
        }
    }
    if ($postid == "new") {                                       //добавление либо апдейт статьив базе
        $postid = $fullpost->addPost($posttitle, $posttext, $postauthorid, $hashsess, $tagids, $filenames);
    } else {
        $error = $fullpost->editPost($postid, $posttitle, $posttext, $postauthorid, $hashsess, $tagids, $filenames);
        if ($error) {
            sSession('error', $error);
        }
    }
    header('Location: ../controller/post.php?id=' . $postid);
    exit();
} elseif ($editpost) {                                                // при редактировании поста
    $postid = getReqGET('id');
    $fullpost->getSinglePost($postid);
    $posttitle = $fullpost->title;
    $posttext = $fullpost->text;
    $postauthorname = $fullpost->author;
    $tags = $fullpost->tags;
    $files = $fullpost->files;
} else {                                 // при нажатии "Новый пост"
    $posttitle = "";
    $posttext = "";
    $postid = "new";
}
include_once(ROOT . "/templates/header.php");
include_once(ROOT . "/templates/template_edit.php");
include_once(ROOT . "/templates/footer.php");

