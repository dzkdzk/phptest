<?php include_once("config.php"); ?>
<?php
$pagetitle = 'Install DB';
include_once(ROOT . "/templates/header.php");
?>
<?php
if (isset($_POST['start'])) {
    $DB_HOST = DB_HOST;
    $DB_LOGIN = DB_LOGIN;
    $DB_PASSWORD = DB_PASSWORD;
    $DB_NAME = DB_NAME;
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $mysqli = new mysqli($DB_HOST, $DB_LOGIN, $DB_PASSWORD);
    } catch (Exception $e) {
        $error = "Can't connect to database: " . mysqli_connect_error();
        echo $error;
        exit();
    }
    if (!$mysqli->set_charset("utf8")) {
        $error = "Can't change charset utf8: " . $mysqli->error;
        echo $error;
        exit();
    }

    $sqlquery = "CREATE DATABASE IF NOT EXISTS `$DB_NAME` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
    if ($sqlresult = $mysqli->query($sqlquery)) {
        echo 'create db: done<br />';
    }

    $mysqli->select_db($DB_NAME);

    $sqlquery = file_get_contents($_FILES['q_file']['tmp_name']);
    $sqlquery = explode(";\n", $sqlquery);
    foreach ($sqlquery as $key => $value) {
        $value = trim($value);
        if ($value != '') {
            if ($sqlresult = $mysqli->query($value)) {
                echo 'query: done<br />';
            } else {
                echo $mysqli->error + "<br />";
            }
        }
    }
    if (preg_match("/linux|unix|macos|hpux|bsd/i", php_uname("s"))) {
        chmod ( ROOT . UPLOADDIR, '0777' );
    } 
    unlink("demo.sql");
    unlink("empty.sql");
    unlink("install.php");
    echo 'Installing done!';
    exit;
}
?>

<div class="container">
    <div class="blog-header">
        <h1 class="blog-title">Блог Для Всех</h1>
        <p class="lead blog-description">Установка базы.</p>
    </div>
    <div class="row">
        <div class="col-sm-8 blog-main">
            <form enctype='multipart/form-data' action='install.php' method='post'>
                <div class="form-group">
                    <label>Choose database file: <input accept=".sql" class="btn" type='file' name='q_file'></label>
                </div>

                <input class="btn btn-primary btn-lg" name="start" type='submit' value="Start">
            </form>
        </div><!-- /.blog-main -->
    </div><!-- /.row -->
</div><!-- /.container -->
<?php include_once(ROOT . "/templates/footer.php"); ?>
