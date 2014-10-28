<?php

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
