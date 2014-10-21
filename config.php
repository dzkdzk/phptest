<?php

define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '1234');
define('DB_NAME', 'blogdb');
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DOMAIN', $_SERVER['HTTP_HOST']);

define('TIMEZONE', '3');
define('COOKIEPATH', '/');
define('COOKIETIME', time() + 360000);
define('LOGFILE', "phptest.log");

define('PREVIEWLENGTH', '500');
define('POSTSONPAGE', '12');
define('PAGELINKSAMOUNT', '5');
define('SALT', 'saltlake');
define('UPLOADDIR', '/uploads/');
define('ADMIN_ROLE', 1);
define('EDITOR_ROLE', 2);
define('USER_ROLE', 3);
