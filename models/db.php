<?php

class MySQLdata {

    protected $mysqli;

    function __construct() {
        $this->DB_HOST = DB_HOST;
        $this->DB_LOGIN = DB_LOGIN;
        $this->DB_PASSWORD = DB_PASSWORD;
        $this->DB_NAME = DB_NAME;
        $this->connect();
    }

    function __destruct() {
        $this->disconnect();
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

        $sessionhash = getHash(time() + rand());
        $passhash = getHash($password);
        $sqlquery = "INSERT INTO users (login, passhash, sesshash) VALUES ('$username', '$passhash', '$sessionhash')";
        $sqlresult = $this->mysqli->query($sqlquery);
        return $sessionhash;
    }

    function getNewSessionHashAndUserID($username, $password) {
        $sessionhash = getHash(time() + rand());
        $sqlquery = "SELECT * FROM users WHERE LOWER(login) = LOWER('$username')";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $tablerow = $sqlresult->fetch_assoc();
        }

        if (getHash($password) !== $tablerow['passhash']) {
            $sessionhash = FALSE;
        } else {
            $sqlquery = "UPDATE users SET `sesshash` = '$sessionhash' WHERE LOWER(login) = LOWER('$username')";
            $sqlresult = $this->mysqli->query($sqlquery);
        }
        $sessandid['hash'] = $sessionhash;
        $sessandid['userid'] = $tablerow['id'];
        return $sessandid;
    }

    function isUserAuthent($userid, $sesshash) {
        $role = false;
        $sqlquery = "SELECT * FROM users WHERE id = '$userid' and sesshash = '$sesshash'";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $tablerow = $sqlresult->fetch_assoc();
            $role = $tablerow['role'];
        }
        return $role;
    }

    function getUserRole($userid) {
        $role = false;
        $sqlquery = "SELECT * FROM users WHERE id = '$userid'";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $tablerow = $sqlresult->fetch_assoc();
            $role = $tablerow['role'];
        }
        return $role;
    }

    function getPrePosts($offset, $rowcount, $previewlength) {
        $sqlquery = "SELECT posts.id,login,CAST(text as char($previewlength))as text,title,date FROM `posts` inner join `users` on posts.userid=users.id LIMIT $offset,$rowcount";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
        }
        return $tablerow;
    }

    function getPrePostsByTag($offset, $rowcount, $previewlength, $tag) {
        $sqlquery = "SELECT posts.id,login,CAST(text as char($previewlength))as text,title,date from posts inner join tagbp inner join tags inner join `users` on posts.userid=users.id and posts.id=tagbp.postid and tagbp.tagid=tags.id where tags.id=$tag LIMIT $offset,$rowcount";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
        }
        return $tablerow;
    }

    function getPost($postid) {
        $sqlquery = "SELECT posts.id,login,text,title,date FROM `posts` inner join `users` on posts.userid=users.id WHERE posts.id=$postid";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_assoc();
        }
        return $row;
    }

    function getPostTags($postid) {
        $res = False;
        $sqlquery = "select tags.id,tags.tag from posts inner join tags inner join tagbp on tags.id=tagbp.tagid and posts.id=tagbp.postid where posts.id=$postid";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
            $res = $tablerow;
        }
        return $res;
    }

    function newTag($tag) {
        $sqlquery = "select * from tags where tag ='$tag'";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_assoc();
            $res = $row['id'];
        }
        if (!$res) {
            $sqlquery = "insert into tags (tag) VALUES ('$tag')";
            $sqlresult = $this->mysqli->query($sqlquery);
            $res = $this->mysqli->insert_id;
        }
        return $res;
    }

    function getTagsByPart($part) {
        $res = False;
        $sqlquery = "select * from tags where tag like '%$part%' limit 10";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
            $res = $tablerow;
        }
        return $res;
    }

    function addTagsToPost($postid, $tags) {
        foreach ($tags as $id => $tag) {
            if (preg_match("/new\d+$/", $id)) {
                $newtagid = $this->newTag($tag);
                $tags[$newtagid] = $arr[$id];
                unset($tags[$id]);
            }
        }
        $sqlquery = "delete from tagbp where postid = '$postid'";
        $sqlresult = $this->mysqli->query($sqlquery);
        $sqlquery = "insert into tagbp (postid, tagid) VALUES ";
        foreach ($tags as $id => $tag) {
            $sqlquery = $sqlquery . "(" . $postid . "," . $id . "),";
        }
        $sqlquery = mb_substr($sqlquery, 0, -1);
        $sqlresult = $this->mysqli->query($sqlquery);
    }

    function updatePost($postid, $title, $text, $userid, $hashsess, $tags) {
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $now = time();
            $sqlquery = "UPDATE `posts` SET `title` = '$title', `text` = '$text', `date` = '$now' where (posts.id=$postid and (posts.userid='$userid' or $role=1))";
            $sqlresult = $this->mysqli->query($sqlquery);
            $this->addTagsToPost($postid, $tags);
        }
//   большой запрос, сразу с авторизацией (как вариант)                $sqlquery = "UPDATE `posts` as tempposts inner join users as userstemp1 on userstemp1.id=tempposts.userid inner join users as userstemp2 on userstemp2.id=$userid SET `title` = '$title', `text` = '$text', `date` = '$now' where ((tempposts.userid=$userid and userstemp1.sesshash='$hashsess') or (userstemp2.role=1 and userstemp2.sesshash='$hashsess')) and tempposts.id=$postid";
    }

    function newPost($title, $text, $userid, $hashsess, $tags) {
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $now = time();
            $sqlquery = "insert into posts (userid,text,title,date) VALUES ('$userid','$text','$title', '$now')";
            $sqlresult = $this->mysqli->query($sqlquery);
            $res = $this->mysqli->insert_id;
            $this->addTagsToPost($res, $tags);
            return $res;
        }
//   большой запрос, сразу с авторизацией (как вариант)                $sqlquery = "insert into posts (userid,text,title,date) select users.id,'$text' as text,'$title' as title, '$now' as date from users where users.id=$userid and users.sesshash='$hashsess'";
    }

    function erasePost($postid, $userid, $hashsess) {
        $sqlquery = "DELETE from tempposts using `posts` as tempposts inner join users as userstemp1 on userstemp1.id=tempposts.userid inner join users as userstemp2 on userstemp2.id=$userid where ((tempposts.userid=$userid and userstemp1.sesshash='$hashsess') or (userstemp2.role=1 and userstemp2.sesshash='$hashsess')) and tempposts.id=$postid";
        $sqlresult = $this->mysqli->query($sqlquery);
    }

    function getPostAmount($tag) {
        if ($tag) {
            $sqlquery = "SELECT COUNT(*) from posts inner join tagbp inner join tags inner join `users` on posts.userid=users.id and posts.id=tagbp.postid and tagbp.tagid=tags.id where tags.id='$tag'";
        } else {
            $sqlquery = "SELECT COUNT(*) FROM posts";
        }
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_row();
        }
        $res = $row[0];
        return $res;
    }

    function recordLog($userid, $uniq, $server) {
        $now = time();

        if (!$user_agent = @$server['HTTP_USER_AGENT']) {
            $user_agent = "";
        }
        $browser = getBrowser($user_agent);
        $os = getOS($user_agent);
        if (!$from = @$server["HTTP_REFERER"]) {
            $from = "";
        }
        if (!$ip = @$server["REMOTE_ADDR"]) {
            $ip = "";
        }
        if (!$link = @$server[HTTP_HOST] . @$server[REQUEST_URI]) {
            $link = "";
        }
        if (!$userid) {
            $userid = "";
        }
        $sqlquery = "INSERT INTO log (date, ip, browser, os, url , fromurl, userid, uniq) VALUES ('$now', '$ip', '$browser', '$os', '$link', '$from', '$userid', '$uniq')";

        $sqlresult = $this->mysqli->query($sqlquery);
    }

    function getCommentByPost($postid) {
        $res = False;
        $sqlquery = "select * from comments inner join users on comments.userid=users.id where comments.postid=$postid";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
            $res = $tablerow;
        }
        return $res;
    }

    function addComment($postid, $userid, $hashsess, $text) {
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $now = time();
            $sqlquery = "insert into comments (postid,userid,text,date) VALUES ('$postid','$userid','$text','$now')";
            $sqlresult = $this->mysqli->query($sqlquery);
            $res = $this->mysqli->insert_id;
            return $res;
        }
    }

}
