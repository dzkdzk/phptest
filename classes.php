<?php

include_once("db.php");

interface getPosts {

    function getBlockPost($offset, $rowcount);
}

interface postManage {

    function getSinglePost($postid);

    function editPost($postid, $title, $text, $userid, $hashsess);

    function addPost($title, $text, $userid, $hashsess);

    function delPost($postid, $userid, $hashsess);
}

class Articles {

    protected $datastruct;
    public $title;
    public $tail;
    public $text;
    public $postid;
    public $tags;

}

class ArticlesBlock extends Articles implements getPosts {

    function getBlockPost($offset, $rowcount) {
        $previewlength = 500;                         //!!!!!Вынести в настройки
        $db = new MySQLdata();
        $db->connect();
        $res = $db->getPrePosts($offset, $rowcount, $previewlength);
        $db->disconnect();
        $this->datastruct = $res;
        foreach ($this->datastruct as $item) {
            $this->title[] = $item['title'];
            $this->text[] = $item['text'];
            $this->tail[] = $item['login'];
            $this->postid[] = $item['id'];
        }
    }

}

class SinglePost extends Articles implements postManage {

    function getSinglePost($postid) {
        $db = new MySQLdata();
        $res = $db->getPost($postid);
        $this->title = $res['title'];
        $this->text = $res['text'];
        $this->tail = $res['login'];
        $this->postid = $res['id'];
        $this->tags=$db->getPostTags($postid);
    }

    function editPost($postid, $title, $text, $userid, $hashsess) {
        $db = new MySQLdata();
        $db->updatePost($postid, $title, $text, $userid, $hashsess);
    }

    function addPost($title, $text, $userid, $hashsess) {
        $db = new MySQLdata();
        $res = $db->newPost($title, $text, $userid, $hashsess);
        return $res;
    }

    function delPost($postid, $userid, $hashsess) {
        $db = new MySQLdata();
        $db->erasePost($postid, $userid, $hashsess);
    }

}

class navigator {

    var $currentpage;
    var $postamount;
    var $postsonpage = 5;
    var $pagesamount;

    public function __construct() {
        if (!isset($_GET['curpage'])) {
            $this->currentpage = 1;
        } else {
            $this->currentpage = $_GET['curpage'];
        }
        $db = new MySQLdata();
        $this->postamount = $db->getPostAmount();
        $this->pagesamount = ceil($this->postamount / $this->postsonpage);
    }

    function draw() {
        $nextpage = $this->currentpage + 1;
        $prevpage = $this->currentpage - 1;
        if ($this->currentpage > 1) {
            echo "<a href='index.php?curpage={$prevpage}'><-</a>   ";
        }
        if ($this->pagesamount > $this->currentpage) {
            echo "<a href='index.php?curpage={$nextpage}'>-></a>";
        }
    }

}
