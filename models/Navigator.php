<?php

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
        $this->db = new Db();
        $this->dberror = $this->db->error;
        $this->postamount = $this->db->getPostAmount($tag, $text);
        $this->pagesamount = ceil($this->postamount / $this->postsonpage);
        $this->nextpage = $this->currentpage + 1;
        $this->prevpage = $this->currentpage - 1;
        $startlink = $this->currentpage - floor($this->pagelinksamount / 2);
        $realpagelinksamount = ($this->pagelinksamount <= $this->pagesamount) ? $this->pagelinksamount : $this->pagesamount;
        if ($startlink > $this->pagesamount - $realpagelinksamount) {
            $startlink = $this->pagesamount - $realpagelinksamount + 1;
        }
        if ($this->currentpage - floor($realpagelinksamount / 2) <= 1) {
            $startlink = 1;
        }
        for ($i = 0; $i < $realpagelinksamount; $i++) {
            $this->pagelinks[] = $startlink + $i;
        }
    }

}