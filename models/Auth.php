<?php

class Auth {

    public $userid;
    public $username;
    public $hashsess;
    public $email;
    public $fullname;
    protected $db;
    public $role;

    function __construct() {
        $this->db = new DbAccess();
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
