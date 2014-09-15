<?php

include_once("db.php");

interface getPosts {

    function getBlockPost($offset, $rowcount, $tag);

    function getBlockTags($postid);
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

    function getBlockPost($offset, $rowcount, $tag) {

        $db = new MySQLdata();
        $db->connect();
        if ($tag) {
            $res = $db->getPrePostsByTag($offset, $rowcount, previewlength, $tag);
        } else {
            $res = $db->getPrePosts($offset, $rowcount, previewlength);
        }
        $db->disconnect();
        $this->datastruct = $res;
        foreach ($this->datastruct as $item) {
            $this->title[] = $item['title'];
            $this->text[] = $item['text'];
            $this->tail[] = $item['login'];
            $this->postid[] = $item['id'];
            $this->date[] = $item['date'];
        }
    }

    function getBlockTags($postid) {
        $db = new MySQLdata();
        $this->tags[] = $db->getPostTags($postid);
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
        $this->date = $res['date'];
        $this->tags = $db->getPostTags($postid);
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
    var $postsonpage = postsonpage;
    var $pagesamount;

    public function __construct($curpage, $tag) {
        if ($curpage) {
            $this->currentpage = $curpage;
        } else {
            $this->currentpage = 1;
        }
        $db = new MySQLdata();
        $this->postamount = $db->getPostAmount($tag);
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
