<?php

include_once("html.php");
include_once("classes.php");

class PostPage extends HTMLPage {

    private $posttitle;
    private $posttext;
    private $postid;
    private $postauthorname;
    private $postauthorid;
    private $hashsess;

    function MainText() {

        $fullpost = new SinglePost();

        echo <<<HTML
        <p>Добро пожаловать в Блог для Всех</p>
        <div class='article'>
HTML;
        if (isset($_POST['del_id'])) {
            $this->postid = $_POST['del_id'];
            $fullpost->delPost($this->postid);
            header('Location: index.php');
            exit();
        } else {
            $this->postid = $_GET['id'];
        }
        $this->postauthorid = $_COOKIE['userid'];
        $this->postauthorname = $_COOKIE['username'];
        $this->hashsess = $_COOKIE['hashsess'];
        if (isset($_POST['SavePost'])) {
            $this->postid = $_POST['postid'];
            $this->posttitle = $_POST['inptitle'];
            $this->posttext = $_POST['inptext'];
            if ($this->postid == 'new') {
                $this->postid = $fullpost->addPost($this->postauthorid, $this->posttitle, $this->posttext);
            } else {
                $fullpost->editPost($this->postid, $this->posttitle, $this->posttext, $this->postauthorid, $this->hashsess);
            }
            header('Location: post.php?id=' . $this->postid);
            exit();
        } elseif ($this->postid != 'new') {
            $fullpost->getSinglePost($this->postid);
            $this->posttitle = $fullpost->title;
            $this->posttext = $fullpost->text;
            $this->postauthor = $fullpost->tail;
        }
        echo <<<HTML
        <form action="edit.php" method="post">
        <label for='inptitle'>Заголовок: </label><input name="inptitle" id="inptitle" type="text" size="2000" value='$this->posttitle'>
        <label for='inptext'>Текст: </label><input name="inptext" id="inptext" type="text" size="20000" value='$this->posttext'> 
        <input name="postid" type="hidden" value={$this->postid}>
        <label>Автор: $this->postauthorname</label>
        <br />
        <input name="SavePost" type="submit" value="Сохранить">
        </form>
        </div>
HTML;
    }

}

$Page = new PostPage("Редактирование");
$Page->Write();


