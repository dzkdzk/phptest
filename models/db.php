<?php

class MySQLdata {

    protected $mysqli;
    public $error;

    function __construct() {
        $this->DB_HOST = DB_HOST;
        $this->DB_LOGIN = DB_LOGIN;
        $this->DB_PASSWORD = DB_PASSWORD;
        $this->DB_NAME = DB_NAME;
        $this->error = false;
        $this->connect();
    }

    function __destruct() {
        $this->disconnect();
    }

    function connect() {
        /* проверка соединения */
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $this->mysqli = new mysqli($this->DB_HOST, $this->DB_LOGIN, $this->DB_PASSWORD, $this->DB_NAME);
        } catch (Exception $e) {
            $this->error = "Can't connect to database: " . mysqli_connect_error();
            echo $this->error;
            exit();
        }
        if (!$this->mysqli->set_charset("utf8")) {
            $this->error = "Can't change charset utf8: " . $this->mysqli->error;
            echo $this->error;
            exit();
        }
    }

    function disconnect() {
        if (!$this->error) {
            $this->mysqli->close();
        }
    }

    function addUserGetSessionHashAndID($username, $password) {                                  //регистрация, получение новой сессии
        $username = $this->mysqli->real_escape_string($username);
        $password = $this->mysqli->real_escape_string($password);
        $sqlquery = "SELECT * FROM users WHERE LOWER(login) = LOWER('$username')";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            $credentials['error'] = 'Choose other login!';
        } else {
            $newsessionhash = getHash(time() + rand());
            $passhash = getHash($password);
            $sqlquery = "INSERT INTO users (login, passhash, sesshash) VALUES ('$username', '$passhash', '$newsessionhash')";
            $sqlresult = $this->mysqli->query($sqlquery);
            $credentials['hashsess'] = $newsessionhash;
            $credentials['userid'] = $this->mysqli->insert_id;
            $credentials['error'] = false;
        }
        return $credentials;
    }

    function getUserCredentials($username, $password) {
        $username = $this->mysqli->real_escape_string($username);                             //логин пользователя, получение новой сессии
        $password = $this->mysqli->real_escape_string($password);
        $sqlquery = "SELECT * FROM users WHERE LOWER(login) = LOWER('$username')";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            $tablerow = $sqlresult->fetch_assoc();
            if (getHash($password) == $tablerow['passhash']) {
                $newsessionhash = getHash(time() + rand());
                $sqlquery = "UPDATE users SET `sesshash` = '$newsessionhash' WHERE LOWER(login) = LOWER('$username')";
                $sqlresult = $this->mysqli->query($sqlquery);
                $credentials['hashsess'] = $newsessionhash;
                $credentials['userid'] = $tablerow['id'];
                $credentials['email'] = $tablerow['email'];
                $credentials['fullname'] = $tablerow['fullname'];
                $credentials['username'] = $tablerow['login'];
                $credentials['role'] = $tablerow['role'];
                $credentials['error'] = false;
            } else {
                $credentials['error'] = 'Wrong password!';
            }
        } else {
            $credentials['error'] = 'No such login!';
        }
        return $credentials;
    }

    function getUserInfo($userid, $hashsess) {                                            //получение расширенных данных пользователя
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $sqlquery = "SELECT * FROM users WHERE id=$userid and sesshash='$hashsess'";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            $tablerow = $sqlresult->fetch_assoc();
            $credentials['email'] = $tablerow['email'];
            $credentials['fullname'] = $tablerow['fullname'];
            $credentials['username'] = $tablerow['login'];
            $credentials['role'] = $tablerow['role'];
            $credentials['error'] = false;
        } else {
            $credentials['error'] = 'No such user!';
        }
        return $credentials;
    }

    function editUserInfo($userid, $hashsess, $fullname, $email, $newrole, $targetuserid) {     //апдейт инфо пользователя
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $fullname = $this->mysqli->real_escape_string($fullname);
        $email = $this->mysqli->real_escape_string($email);
        $targetuserid = $this->mysqli->real_escape_string($targetuserid);
        if ($newrole and $targetuserid) {
            if (($role = $this->isUserAuthent($userid, $hashsess))and ( $role == ADMIN_ROLE)) {
                $sqlquery = "UPDATE `users` SET `fullname` = '$fullname',`email` = '$email',`role`='$newrole' where id=$targetuserid";
                $sqlresult = $this->mysqli->query($sqlquery);
            }
        } else {
            $sqlquery = "UPDATE `users` SET `fullname` = '$fullname',`email` = '$email' where id=$userid and sesshash='$hashsess'";
            $sqlresult = $this->mysqli->query($sqlquery);
        }
    }

    function removeUserWithRef($userid, $hashsess, $targetuserid) {                   //удаление юзера со всеми вхождениями
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $targetuserid = $this->mysqli->real_escape_string($targetuserid);
        if (($role = $this->isUserAuthent($userid, $hashsess))and ( $role == ADMIN_ROLE)) {
            $sqlquery = "delete from `users` where id='$targetuserid'";
            $sqlresult = $this->mysqli->query($sqlquery);
            $sqlquery = "delete from `posts` where userid='$targetuserid'";
            $sqlresult = $this->mysqli->query($sqlquery);
            $sqlquery = "delete from `comments` where userid='$targetuserid'";
            $sqlresult = $this->mysqli->query($sqlquery);
        }
    }

    function destroyUserSession($userid, $hashsess) {                               //логаут
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $randomhash = getHash(time() + rand());
        $sqlquery = "UPDATE `users` SET `sesshash` = '$randomhash' where id=$userid and sesshash='$hashsess'";
        $sqlresult = $this->mysqli->query($sqlquery);
    }

    function isUserAuthent($userid, $hashsess) {                                    //воспомогательная ф-я, для проверки аутентификации
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $role = false;
        $sqlquery = "SELECT * FROM users WHERE id = '$userid' and sesshash = '$hashsess'";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            $tablerow = $sqlresult->fetch_assoc();
            $role = $tablerow['role'];
        }
        return $role;
    }

    function getUserRole($userid) {                                                 //получить права пользователя
        $userid = $this->mysqli->real_escape_string($userid);
        $role = false;
        $sqlquery = "SELECT * FROM users WHERE id = '$userid'";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            $tablerow = $sqlresult->fetch_assoc();
            $role = $tablerow['role'];
        }
        return $role;
    }

    function getUsersList($userid, $hashsess) {                                    //список всех пользователей
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);

        if (($role = $this->isUserAuthent($userid, $hashsess))and ( $role == ADMIN_ROLE)) {
            $sqlquery = "select id,login,fullname,email,role from `users`";
            if ($sqlresult = $this->mysqli->query($sqlquery)) {
                while ($row = $sqlresult->fetch_assoc()) {
                    $tablerow[] = $row;
                }
            }
        }
        return $tablerow;
    }

    function getPrePosts($offset, $rowcount, $PREVIEWLENGTH) {                         //выдача предпросмотров всех постов для ленты
        $offset = $this->mysqli->real_escape_string($offset);
        $rowcount = $this->mysqli->real_escape_string($rowcount);
        $PREVIEWLENGTH = $this->mysqli->real_escape_string($PREVIEWLENGTH);
        $sqlquery = "SELECT posts.id,login,fullname,CAST(text as char($PREVIEWLENGTH))as text,title,date FROM `posts` inner join `users` on posts.userid=users.id LIMIT $offset,$rowcount";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
        }
        if (!isset($tablerow)) {
            $tablerow = false;
        }
        return $tablerow;
    }

    function getPrePostsByTag($offset, $rowcount, $PREVIEWLENGTH, $tag) {           //выдача предпросмотров всех постов для ленты c фильтрацией по тегу
        $offset = $this->mysqli->real_escape_string($offset);
        $rowcount = $this->mysqli->real_escape_string($rowcount);
        $PREVIEWLENGTH = $this->mysqli->real_escape_string($PREVIEWLENGTH);
        $tag = $this->mysqli->real_escape_string($tag);
        $sqlquery = "SELECT posts.id,login,fullname,CAST(text as char($PREVIEWLENGTH))as text,title,date from posts inner join tagbp inner join tags inner join `users` on posts.userid=users.id and posts.id=tagbp.postid and tagbp.tagid=tags.id where tags.id=$tag LIMIT $offset,$rowcount";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
        }
        return $tablerow;
    }

    function getPrePostsByText($offset, $rowcount, $PREVIEWLENGTH, $text) {        //выдача предпросмотров всех постов для ленты с фильтрацией по части текста, заглавия,  автора и т.д.
        $offset = $this->mysqli->real_escape_string($offset);
        $rowcount = $this->mysqli->real_escape_string($rowcount);
        $PREVIEWLENGTH = $this->mysqli->real_escape_string($PREVIEWLENGTH);
        $text = $this->mysqli->real_escape_string($text);
        $sqlquery = "SELECT posts.id,login,fullname,CAST(text as char($PREVIEWLENGTH))as text,title,date from posts inner join `users` on posts.userid=users.id where `text` LIKE '%$text%' OR `title` LIKE '%$text%' OR `login` LIKE '%$text%' OR `fullname` LIKE '%$text%' LIMIT $offset,$rowcount";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
        }
        if ($sqlresult->num_rows > 0) {
            $res = $tablerow;
        } else {
            $res = false;
        }
        return $res;
    }

    function getPost($postid) {                                              //выдача отдельной статьи
        $postid = $this->mysqli->real_escape_string($postid);
        $sqlquery = "SELECT posts.id,fullname,login,text,title,date FROM `posts` inner join `users` on posts.userid=users.id WHERE posts.id=$postid";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_assoc();
        }
        return $row;
    }

    function getPostTags($postid) {                                            //выдача тегов по статье
        $postid = $this->mysqli->real_escape_string($postid);
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

    function newTag($tag) {                                                      //добавление в базу нового тега
        $tag = $this->mysqli->real_escape_string($tag);
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

    function getTagsByPart($part) {                                              //поиск тегов по части для подсказок
        $part = $this->mysqli->real_escape_string($part);
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

    function addTagsToPost($postid, $tags) {                                     //добавить новый тег в статью
        $postid = $this->mysqli->real_escape_string($postid);
        foreach ($tags as $id => $tag) {
            $id = $this->mysqli->real_escape_string($id);
            $tag = $this->mysqli->real_escape_string($tag);
            $tags[$id] = $this->mysqli->real_escape_string($tags[$id]);

            if (preg_match("/new\d+$/", $id)) {
                $newtagid = $this->newTag($tag);
                $tags[$newtagid] = $tags[$id];
                unset($tags[$id]);
            }
        }
        $sqlquery = "delete from tagbp where postid = '$postid'";
        $sqlresult = $this->mysqli->query($sqlquery);
        $sqlquery = "insert into tagbp (postid, tagid) VALUES ";
        foreach ($tags as $id => $tag) {
            $id = $this->mysqli->real_escape_string($id);
            $sqlquery = $sqlquery . "(" . $postid . "," . $id . "),";
        }
        $sqlquery = mb_substr($sqlquery, 0, -1);
        $sqlresult = $this->mysqli->query($sqlquery);
    }

    function getPostFiles($postid) {                                              //выдача изображений поста
        $postid = $this->mysqli->real_escape_string($postid);
        $res = null;
        $sqlquery = "select * from images where postid='$postid'";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            while ($row = $sqlresult->fetch_assoc()) {
                $tablerow[] = $row;
            }
            $res = $tablerow;
        }
        return $res;
    }

    function addFileToPost($postid, $files) {                                    //добаление нового изобр в пост
        $postid = $this->mysqli->real_escape_string($postid);
        $sqlquery = "insert into images (postid, filename) VALUES ";
        foreach ($files as $id => $fn) {
            $fn = $this->mysqli->real_escape_string($fn);
            $sqlquery = $sqlquery . "(" . $postid . ",'" . $fn . "'),";
        }
        $sqlquery = mb_substr($sqlquery, 0, -1);
        $sqlresult = $this->mysqli->query($sqlquery);
    }

    function delFileFromPost($postid, $userid, $hashsess, $file) {               //удаление изобр. из статьи
        $postid = $this->mysqli->real_escape_string($postid);
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $file = $this->mysqli->real_escape_string($file);
        $error = false;
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $file = basename($file);
            $sqlquery = "select * from posts where id = $postid";
            if ($sqlresult = $this->mysqli->query($sqlquery)) {
                $row = $sqlresult->fetch_assoc();
                $postsuserid = $row['userid'];
            }
            if ($userid == $postsuserid or $role == ADMIN_ROLE) {
                unlink(ROOT . uploaddir . $file);
                $sqlquery = "delete from images where postid = '$postid' and filename='$file'";
                $sqlresult = $this->mysqli->query($sqlquery);
            } else {
                $error = "Вы не можете редактировать эту статью.";
            }
        }
        return $error;
    }

    function updatePost($postid, $title, $text, $userid, $hashsess, $tags, $files) {         //редактирование статьи
        $postid = $this->mysqli->real_escape_string($postid);
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $title = $this->mysqli->real_escape_string($title);
        $text = $this->mysqli->real_escape_string($text);
        $error = false;
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $adminrole = ADMIN_ROLE;
            $now = time();
            $sqlquery = "UPDATE `posts` SET `title` = '$title', `text` = '$text', `date` = '$now' where (posts.id=$postid and (posts.userid='$userid' or $role=$adminrole))";
            if ($sqlresult = $this->mysqli->query($sqlquery)) {
                if ($tags) {
                    $this->addTagsToPost($postid, $tags);
                }
                if ($files) {
                    $this->addFileToPost($postid, $files);
                }
            } else {
                $error = 'Вы не можете редактировать эту статью.';
            }
        } else {
            $error = 'Перелогиньтесь.';
        }
        return $error;
//   большой запрос, сразу с авторизацией (как вариант)                $sqlquery = "UPDATE `posts` as tempposts inner join users as userstemp1 on userstemp1.id=tempposts.userid inner join users as userstemp2 on userstemp2.id=$userid SET `title` = '$title', `text` = '$text', `date` = '$now' where ((tempposts.userid=$userid and userstemp1.sesshash='$hashsess') or (userstemp2.role=ADMIN_ROLE and userstemp2.sesshash='$hashsess')) and tempposts.id=$postid";
    }

    function newPost($title, $text, $userid, $hashsess, $tags, $files) {         //добавление новогой статьи
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $title = $this->mysqli->real_escape_string($title);
        $text = $this->mysqli->real_escape_string($text);
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $now = time();
            $sqlquery = "insert into posts (userid,text,title,date) VALUES ('$userid','$text','$title', '$now')";
            $sqlresult = $this->mysqli->query($sqlquery);
            $res = $this->mysqli->insert_id;
            if ($tags) {
                $this->addTagsToPost($res, $tags);
            }
            if ($files) {
                $this->addFileToPost($res, $files);
            }
            return $res;
        }
//   большой запрос, сразу с авторизацией (как вариант)                $sqlquery = "insert into posts (userid,text,title,date) select users.id,'$text' as text,'$title' as title, '$now' as date from users where users.id=$userid and users.sesshash='$hashsess'";
    }

    function erasePost($postid, $userid, $hashsess) {                            //удаление статьи
        $postid = $this->mysqli->real_escape_string($postid);
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $adminrole = ADMIN_ROLE;
        $sqlquery = "select * from posts where id = $postid";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_assoc();
            $postsuserid = $row['userid'];
        }
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $sqlquery = "DELETE from `posts` where id='$postid' and (userid='$userid' or '$role'='$adminrole')";
            $sqlresult = $this->mysqli->query($sqlquery);
        }
        $sqlquery = "select * from images where postid = $postid";
        $sqlresult = $this->mysqli->query($sqlquery);
        if ($sqlresult->num_rows > 0) {
            while ($row = $sqlresult->fetch_assoc()) {
                unlink(ROOT . uploaddir . $row['filename']);
            }
        }
        if ($userid == $postsuserid or $role == ADMIN_ROLE) {
            $sqlquery = "delete from images where postid = '$postid'";
            $sqlresult = $this->mysqli->query($sqlquery);
            $sqlquery = "delete from tagbp where postid = '$postid'";
            $sqlresult = $this->mysqli->query($sqlquery);
        } else {
            $error = "Вы не можете редактировать эту статью.";
        }
        return $error;

//            $sqlquery = "DELETE from tempposts using `posts` as tempposts inner join users as userstemp1 on userstemp1.id=tempposts.userid inner join users as userstemp2 on userstemp2.id=$userid where ((tempposts.userid=$userid and userstemp1.sesshash='$hashsess') or (userstemp2.role=$adminrole and userstemp2.sesshash='$hashsess')) and tempposts.id=$postid";    //сразу одним запросом
    }

    function getPostAmount($tag, $text) {                                         //рассчет кол-ва постов для навигатора-пагинации 
        $tag = $this->mysqli->real_escape_string($tag);
        if ($tag) {
            $sqlquery = "SELECT COUNT(*) from posts inner join tagbp inner join tags inner join `users` on posts.userid=users.id and posts.id=tagbp.postid and tagbp.tagid=tags.id where tags.id='$tag'";
        } elseif ($text) {
            $sqlquery = "SELECT COUNT(*) from posts inner join `users` on posts.userid=users.id where `text` LIKE '%$text%' OR `title` LIKE '%$text%' OR `login` LIKE '%$text%' OR `fullname` LIKE '%$text%'";
        } else {
            $sqlquery = "SELECT COUNT(*) FROM posts";
        }
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_row();
        }
        $res = $row[0];
        return $res;
    }

    function recordLog($userid, $uniq, $server) {                                  //логирование посещений страниц юзерами
        $userid = $this->mysqli->real_escape_string($userid);
        $uniq = $this->mysqli->real_escape_string($uniq);
        $server['HTTP_USER_AGENT'] = $this->mysqli->real_escape_string($server['HTTP_USER_AGENT']);
        @$server["HTTP_REFERER"] = $this->mysqli->real_escape_string($server["HTTP_REFERER"]);
        $server["REMOTE_ADDR"] = $this->mysqli->real_escape_string($server["REMOTE_ADDR"]);


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

    function getCommentByPost($postid) {                                        //выдача комментов по статье
        $postid = $this->mysqli->real_escape_string($postid);
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

    function addComment($postid, $userid, $hashsess, $text) {                                //добавление нового коммента
        $postid = $this->mysqli->real_escape_string($postid);
        $userid = $this->mysqli->real_escape_string($userid);
        $hashsess = $this->mysqli->real_escape_string($hashsess);
        $text = $this->mysqli->real_escape_string($text);
        if ($role = $this->isUserAuthent($userid, $hashsess)) {
            $now = time();
            $sqlquery = "insert into comments (postid,userid,text,date) VALUES ('$postid','$userid','$text','$now')";
            $sqlresult = $this->mysqli->query($sqlquery);
            $res = $this->mysqli->insert_id;
            return $res;
        }
    }

    function getPage($pageid) {                                                   //выдача страницы
        $pageid = $this->mysqli->real_escape_string($pageid);
        $sqlquery = "SELECT * FROM `pages` WHERE id=$pageid";
        if ($sqlresult = $this->mysqli->query($sqlquery)) {
            $row = $sqlresult->fetch_assoc();
        }
        return $row;
    }

    function savePage($pageid, $title, $text, $userid, $hashsess) {                //сохранение страницы
        $pageid = $this->mysqli->real_escape_string($pageid);
        $userid = $this->mysqli->real_escape_string($userid);
        $title = $this->mysqli->real_escape_string($title);
        $text = $this->mysqli->real_escape_string($text);
        $hashsess = $this->mysqli->real_escape_string($hashsess);

        if (($role = $this->isUserAuthent($userid, $hashsess))and ( $role == ADMIN_ROLE)) {
            $sqlquery = "UPDATE `pages` SET `title` = '$title', `text` = '$text' where id='$pageid'";
            if (!$sqlresult = $this->mysqli->query($sqlquery)) {
                $error = 'Вы не можете редактировать эту статью.';
            }
        } else {
            $error = 'Перелогиньтесь.';
        }
        return $error;
    }

}
