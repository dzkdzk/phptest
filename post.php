<?php

include_once("html.php");
include_once("classes.php");

class PostPage extends HTMLPage {

    function MainText() {

        $fullpost = new SinglePost();

        echo <<<HTML
        <p>Добро пожаловать в Блог для Всех</p>
        <div class='article'>
HTML;
        $fullpost->getSinglePost($_GET['id']);
        echo <<<HTML
        <h2><a href='post.php?id=$fullpost->postid'>$fullpost->title</a></h2>
        <br />
        $fullpost->text
        <br />
        Автор: $fullpost->tail
        <br />
        Теги: 
HTML;
            for ($i=0;$i<count($fullpost->tags);$i++) {
                $tagid=$fullpost->tags[$i]["id"];
                echo "<a href=tag.php?tag=$tagid>" . $fullpost->tags[$i]["tag"] . "</a>" . " ";
            }
        
        echo <<<HTML
        <br />
        </div>
HTML;
        if (isset($_COOKIE['username'])) {
            echo <<<HTML
        <a href='edit.php?id=$fullpost->postid'>Редактировать...</a>
        <br />
        <a href='index.php' onclick='$.post( "edit.php", { del_id: $fullpost->postid } );'>Удалить</a>
             
HTML;
        }
    }

}

$Page = new PostPage("Статья");
$Page->Write();


