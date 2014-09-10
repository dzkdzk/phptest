<?php

class MySQLdata {

    function __construct() {
        $this->DB_HOST = 'localhost';
        $this->DB_LOGIN = 'root';
        $this->DB_PASSWORD = '';
        $this->DB_NAME = 'blogdb';
    }

    function connect() {
        /* проверка соединения */
        $this->mysqli = new mysqli($this->DB_HOST, $this->DB_LOGIN, $this->DB_PASSWORD, $this->DB_NAME);
        if (mysqli_connect_errno()) {
            printf("Не удалось подключиться: %s\n", mysqli_connect_error());
            exit();
        }
        /* изменение набора символов на utf8 */
        if (!$this->mysqli->set_charset("utf8")) {
            printf("Ошибка при загрузке набора символов utf8: %s\n", $this->mysqli->error);
        }
    }

    function disconnect() {
        $this->mysqli->close();
    }

    function addUserAndGetSessionHash($username, $password) {

        $sessionhash = $this->getHash(time() + rand());
        $passhash = $this->getHash($password);
        $sqlquery = "INSERT INTO users (login, passhash, sesshash) VALUES ('$username', '$passhash', '$sessionhash')";
        $sqlresult = $this->mysqli->query($sqlquery);
        return $sessionhash;
    }

    function getNewSessionHashAndUserID($username, $password) {
        $sessionhash = $this->getHash(time() + rand());
        $sqlquery = "SELECT * FROM users WHERE LOWER(login) = LOWER('$username')";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $tablerow = $sqlresult->fetch_assoc();
        }

        if ($this->getHash($password) !== $tablerow['passhash']) {
            $sessionhash = FALSE;
        } else {
            $sqlquery = "UPDATE users SET `sesshash` = '$sessionhash' WHERE LOWER(login) = LOWER('$username')";
            $sqlresult = $this->mysqli->query($sqlquery);
        }
        $sessandid['hash'] = $sessionhash;
        $sessandid['userid'] = $tablerow['id'];
        return $sessandid;
    }

    private function getHash($target) {
        $salt = 'saltlake';
        $hash = hash(sha256, $target . $salt);
        return $hash;
    }

    function getPrePosts($offset, $rowcount, $previewlength) {
        $sqlquery = "SELECT posts.id,login,CAST(text as char($previewlength))as text,title FROM `posts` inner join `users` on posts.userid=users.id LIMIT $offset,$rowcount";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
        }
        return $tablerow;
    }

    function getPost($postid) {
        $this->connect();
        $sqlquery = "SELECT posts.id,login,text,title FROM `posts` inner join `users` on posts.userid=users.id WHERE posts.id=$postid";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_assoc();
        }
        return $row;
        $this->disconnect();
    }

    function updatePost($postid, $title, $text, $userid, $hashsess) {
        $this->connect();
        $sqlquery = "UPDATE `posts` as tempposts inner join users as userstemp1 on userstemp1.id=tempposts.userid inner join users as userstemp2 on userstemp2.id=$userid SET `title` = '$title', `text` = '$text' where ((tempposts.userid=$userid and userstemp1.sesshash='$hashsess') or (userstemp2.role=1 and userstemp2.sesshash='$hashsess')) and tempposts.id=$postid";
        $sqlresult = $this->mysqli->query($sqlquery);
        $this->disconnect();
    }

    function newPost($userid, $title, $text) {
        $this->connect();
        $sqlquery = "INSERT INTO posts (userid, title, text) VALUES ($userid, '$title', '$text')";
        $sqlresult = $this->mysqli->query($sqlquery);
        $res = $this->mysqli->insert_id;
        $this->disconnect();
        return $res;
    }

    function erasePost($postid) {
        $this->connect();
        $sqlquery = "DELETE from posts WHERE `id`= '$postid'";
        $sqlresult = $this->mysqli->query($sqlquery);
        $this->disconnect();
    }

    function getPostAmount() {
        $this->connect();

        $sqlquery = "SELECT COUNT(*) FROM posts";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_row();
        }
        $res = $row[0];
        $this->disconnect();
        return $res;
    }

}
