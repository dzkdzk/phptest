<?php

include_once("db.php");

interface getPosts {

    function getBlockPost($offset, $rowcount, $tag);

    function getBlockTags($postid);

    function getBlockPostByText($offset, $rowcount, $search);
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

    function getBlockPost($offset, $rowcount, $tag) {                //получение постов для ленты
        if ($tag) {
            $res = $this->db->getPrePostsByTag($offset, $rowcount, PREVIEWLENGTH, $tag);
        } else {
            $res = $this->db->getPrePosts($offset, $rowcount, PREVIEWLENGTH);
        }
        $noerror = true;
        if ($res) {
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
        } else {
            $noerror = false;
        }
        return $noerror;
    }

    function getBlockTags($postid) {                       //получение Тегов поста 
        $this->tags[] = $this->db->getPostTags($postid);
    }

    function getBlockPostByText($offset, $rowcount, $search) {    //получение постов для поиска
        $res = $this->db->getPrePostsByText($offset, $rowcount, PREVIEWLENGTH, $search);
        $noerror = true;
        if ($res) {
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
        } else {
            $noerror = false;
        }
        return $noerror;
    }

}

class SinglePost extends Articles implements postManage, commenting {

    function getSinglePost($postid) {                        //получение отдельной статьи
        $res = $this->db->getPost($postid);
        $this->title = $res['title'];
        $this->text = $res['text'];
        if ($res['fullname']) {
            $this->author = $res['fullname'];
        } else {
            $this->author = $res['login'];
        }
        $this->postid = $res['id'];
        $this->date = $res['date'];
        $this->tags = $this->db->getPostTags($postid);
        $this->files = $this->db->getPostFiles($postid);
    }

    function editPost($postid, $title, $text, $userid, $hashsess, $tags, $files) {               // редактирование статьи
        $error = $this->db->updatePost($postid, $title, $text, $userid, $hashsess, $tags, $files);
        return $error;
    }

    function addPost($title, $text, $userid, $hashsess, $tags, $files) {                       // добавление новой статьи
        $res = $this->db->newPost($title, $text, $userid, $hashsess, $tags, $files);
        return $res;
    }

    function delPost($postid, $userid, $hashsess) {                                          //удаление статьи
        $this->db->erasePost($postid, $userid, $hashsess);
    }

    function newComment($postid, $userid, $sesshash, $text) {                                //новый комментарий
        $this->db->addComment($postid, $userid, $sesshash, $text);
    }

    function getBlockComments($postid) {                                                     //список всех комментов по статье
        $res = $this->db->getCommentByPost($postid);
        return $res;
    }

}

class Navigator {                                                                             //навигатор - пагинация

    public $currentpage;
    public $postamount;
    public $postsonpage;
    public $pagesamount;
    public $pagelinksamount = PAGELINKSAMOUNT;
    public $pagelinks;                                                               //links array
    public $nextpage;
    public $prevpage;
    protected $db;
    public $dberror;

    public function __construct($curpage, $selpostsonpage, $tag, $text) {
        if ($curpage) {                                                                   //расчет параметров для пагинации
            $this->currentpage = $curpage;
        } else {
            $this->currentpage = 1;
        }
        $this->postsonpage = $selpostsonpage;
        $this->db = new MySQLdata();
        $this->dberror = $this->db->error;
        $this->postamount = $this->db->getPostAmount($tag, $text);
        $this->pagesamount = ceil($this->postamount / $this->postsonpage);
        $this->nextpage = $this->currentpage + 1;
        $this->prevpage = $this->currentpage - 1;
        $startlink = $this->currentpage - floor($this->pagelinksamount / 2);
        if ($startlink > $this->pagesamount - $this->pagelinksamount) {
            $startlink = $this->pagesamount - $this->pagelinksamount + 1;
        }
        if ($this->currentpage - floor($this->pagelinksamount / 2) < 1) {
            $startlink = 1;
        }
        $realpagelinksamont = ($this->pagelinksamount <= $this->pagesamount) ? $this->pagelinksamount : $this->pagesamount;
        for ($i = 0; $i < $realpagelinksamont; $i++) {
            $this->pagelinks[] = $startlink + $i;
        }
    }

}

class Log {                                                                              //логирование получения пользователями страниц

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
        $this->role = $credentials['role'];

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

    function getAdvUserInfo($userid, $hashsess) {                                                  //получение расширенных данных о пользователе
        $credentials = $this->db->getUserInfo($userid, $hashsess);
        $this->email = $credentials['email'];
        $this->fullname = $credentials['fullname'];
        $this->username = $credentials['username'];
        $this->role = $credentials['role'];
        $this->error = $credentials['error'];
    }

    function updateAdvUserInfo($userid, $hashsess, $fullname, $email, $newrole, $targetuserid) {                  //редактирование расширенных данных о пользователе
        $credentials = $this->db->editUserInfo($userid, $hashsess, $fullname, $email, $newrole, $targetuserid);
    }

    function getAllUserCred($userid, $hashsess) {                                                  //получение списка всех пользователей
        $credentials = $this->db->getUsersList($userid, $hashsess);

        foreach ($credentials as $item) {
            $this->username[] = $item['login'];
            $this->fullname[] = $item['fullname'];
            $this->email[] = $item['email'];
            $this->role[] = $item['role'];
            $this->userid[] = $item['id'];
        }
    }

    function delUserAndRef($userid, $hashsess, $targetuserid) {                            //удалить юзера со всеми вхожениями
        $this->db->removeUserWithRef($userid, $hashsess, $targetuserid);
    }

}

class Pages {                                                                     //страницы (Обо мне, ссылки, ...)

    public $title;
    public $text;
    public $error;
    protected $db;

    function __construct() {
        $this->db = new MySQLdata();
        $this->dberror = $this->db->error;
    }

    function getContent($pageid) {
        $res = $this->db->getPage($pageid);
        $this->text = $res['text'];
        $this->title = $res['title'];
    }

    function updateContent($pageid, $title, $text, $userid, $hashsess) {
        $this->error = $this->db->savePage($pageid, $title, $text, $userid, $hashsess);
        return $this->error;
    }

}

class Conf {

    private static $db = null;
    public static $dberror = null;

    static function setConfDef($par, $val, $userid, $hashsess) {
        self::$db = new MySQLdata();
        self::$dberror = self::$db->error;
        $val = preg_replace('%[^A-Za-zА-Яа-я0-9]%', '', $val);
        if (self::$db->isUserAuthent($userid, $hashsess) == ADMIN_ROLE) {
            $data = file_get_contents("..\config.php");
            $pattern = "/define *\\([^)]*" . $par . "[^)]*\\) *;/i";
            $replacement = "define('" . $par . "', '" . $val . "');";
            $data = preg_replace($pattern, $replacement, $data);
            $handle = fopen("..\config.php", "w+");
            fwrite($handle, $data);
            fclose($handle);
        }
    }

}
