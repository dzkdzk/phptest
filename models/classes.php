<?php

include_once("db.php");

interface getPosts {

    function getBlockPost($offset, $rowcount, $tag);

    function getBlockTags($postid);

    function getPostsAmount($tag);
}

interface postManage {

    function getSinglePost($postid);

    function editPost($postid, $title, $text, $userid, $hashsess, $tags, $files);

    function addPost($title, $text, $userid, $hashsess, $tags, $files);

    function delPost($postid, $userid, $hashsess);
}

interface commenting {

    function newComment($postid, $userid, $sesshash, $text);

    function getBlockComments($postid);
}

class Articles {

    protected $datastruct;
    public $title;
    public $author;
    public $text;
    public $postid;
    public $tags;
    public $files;
    protected $db;
    public $dberror;

    function __construct() {
        $this->db = new MySQLdata();
        $this->dberror = $this->db->error;
    }

}

class ArticlesBlock extends Articles implements getPosts {

    function getBlockPost($offset, $rowcount, $tag) {
        if ($tag) {
            $res = $this->db->getPrePostsByTag($offset, $rowcount, previewlength, $tag);
        } else {
            $res = $this->db->getPrePosts($offset, $rowcount, previewlength);
        }
        $this->datastruct = $res;
        foreach ($this->datastruct as $item) {
            $this->title[] = $item['title'];
            $this->text[] = $item['text'];
            if ($item['fullname']) {
                $this->author[] = $item['fullname'];
            } else {
                $this->author[] = $item['login'];
            }
            $this->postid[] = $item['id'];
            $this->date[] = $item['date'];
        }
    }

    function getBlockTags($postid) {
        $this->tags[] = $this->db->getPostTags($postid);
    }

    function getPostsAmount($tag) {
        
    }

}

class SinglePost extends Articles implements postManage, commenting {

    function getSinglePost($postid) {

        $res = $this->db->getPost($postid);
        $this->title = $res['title'];
        $this->text = $res['text'];
        $this->tail = $res['login'];
        $this->postid = $res['id'];
        $this->date = $res['date'];
        $this->tags = $this->db->getPostTags($postid);
        $this->files = $this->db->getPostFiles($postid);
    }

    function editPost($postid, $title, $text, $userid, $hashsess, $tags, $files) {
        $error = $this->db->updatePost($postid, $title, $text, $userid, $hashsess, $tags, $files);
        return $error;
    }

    function addPost($title, $text, $userid, $hashsess, $tags, $files) {

        $res = $this->db->newPost($title, $text, $userid, $hashsess, $tags, $files);
        return $res;
    }

    function delPost($postid, $userid, $hashsess) {

        $this->db->erasePost($postid, $userid, $hashsess);
    }

    function newComment($postid, $userid, $sesshash, $text) {

        $this->db->addComment($postid, $userid, $sesshash, $text);
    }

    function getBlockComments($postid) {

        $res = $this->db->getCommentByPost($postid);
        return $res;
    }

}

class Navigator {

    public $currentpage;
    public $postamount;
    public $postsonpage = postsonpage;
    public $pagesamount;
    public $nextpage;
    public $prevpage;
    protected $db;
    public $dberror;

    public function __construct($curpage, $tag) {
        if ($curpage) {
            $this->currentpage = $curpage;
        } else {
            $this->currentpage = 1;
        }
        $this->db = new MySQLdata();
        $this->dberror = $this->db->error;
        $this->postamount = $this->db->getPostAmount($tag);
        $this->pagesamount = ceil($this->postamount / $this->postsonpage);
        $this->nextpage = $this->currentpage + 1;
        $this->prevpage = $this->currentpage - 1;
    }

}

class Log {

    protected $db;
    public $dberror;

    function __construct() {
        $this->db = new MySQLdata();
        $this->dberror = $this->db->error;
    }

    function record($userid, $uniq, $server) {
        $this->db->recordLog($userid, $uniq, $server);
    }

}

class Auth {

    public $userid;
    public $username;
    public $hashsess;
    public $email;
    public $fullname;
    protected $db;
    public $role;

    function __construct() {
        $this->db = new MySQLdata();
        $this->dberror = $this->db->error;
    }

    function login($username, $password) {
        $credentials = $this->db->getUserCredentials($username, $password);
        $this->userid = $credentials['userid'];
        $this->username = $credentials['username'];
        $this->hashsess = $credentials['hashsess'];
        $this->email = $credentials['email'];
        if ($credentials['fullname']) {
            $this->username = $credentials['fullname'];
        } else {
            $this->username = $credentials['username'];
        }
        return $credentials['error'];
    }

    function logout($userid, $hashsess) {
        $this->db->destroyUserSession($userid, $hashsess);
    }

    function register($username, $password) {
        $credentials = $this->db->addUserGetSessionHashAndID($username, $password);
        $this->userid = $credentials['userid'];
        $this->hashsess = $credentials['hashsess'];
        $this->username = $username;
        $this->fullname = $username;
        return $credentials['error'];
    }

    function getAdvUserInfo($userid, $hashsess) {
        $credentials = $this->db->getUserInfo($userid, $hashsess);
        $this->email = $credentials['email'];
        $this->fullname = $credentials['fullname'];
        $this->username = $credentials['username'];
        $this->role = $credentials['role'];
        $this->error = $credentials['error'];
    }

    function updateAdvUserInfo($userid, $hashsess, $fullname, $email) {
        $credentials = $this->db->editUserInfo($userid, $hashsess, $fullname, $email);
    }

}
