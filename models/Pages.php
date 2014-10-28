<?php

class Pages {                                                                     //страницы (Обо мне, ссылки, ...)

    public $title;
    public $text;
    public $error;
    protected $db;

    function __construct() {
        $this->db = new DbAccess();
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