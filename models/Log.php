<?php

class Log {                                                                              //логирование получения пользователями страниц

    protected $db;
    public $dberror;

    function __construct() {
        $this->db = new DbAccess();
        $this->dberror = $this->db->error;
    }

    function record($userid, $uniq, $server) {
        $this->db->recordLog($userid, $uniq, $server);
    }

    static function addtofile($errdescr, $basename) {
        $file = ROOT . "/" . LOGFILE;
        $ip = healString($_SERVER['REMOTE_ADDR']);
        $logstr = date("d.m.y H:i:s") . "; " . $errdescr . "; " . $ip . "; " . $basename . "\n";
        file_put_contents($file, $logstr, FILE_APPEND | LOCK_EX);
    }

}
