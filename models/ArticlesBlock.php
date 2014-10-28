<?php

interface getPosts {

    function getBlockPost($offset, $rowcount, $tag);

    function getBlockTags($postid);

    function getBlockPostByText($offset, $rowcount, $search);
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
