<?php

class Articles {

    protected $datastruct;
    public $title;
    public $author;
    public $date;
    public $text;
    public $postid;
    public $tags;
    public $files;
    protected $db;
    public $dberror;

    function __construct() {
        $this->db = new DbAccess();
        $this->dberror = $this->db->error;
    }

}
