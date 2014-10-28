<?php

class Conf {

    private static $db = null;
    public static $dberror = null;

    static function setConfDef($par, $val, $userid, $hashsess) {
        self::$db = new DbAccess();
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
