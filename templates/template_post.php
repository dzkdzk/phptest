<?php
delCookie('test');
include_once(ROOT . "/templates/menublock.php");
include_once(ROOT . "/templates/loginblock.php");
include_once(ROOT . "/templates/messageblock.php");
?>

<p>Добро пожаловать в Блог для Всех</p>
<h2><a href = '../controller/post.php?id=<?= $fullpost->postid ?>'><?= $fullpost->title ?></a></h2>
<br />
<?php
for ($i = 0; $i < count($fullpost->files); $i++) :
    ?>
    <?php $filepath = uploaddir . $fullpost->files[$i]['filename'] ?>
    <img src="../<?= $filepath ?>">
<?php endfor ?>
<?= nl2br($fullpost->text) ?>
<br />
Автор: <?= $fullpost->tail ?>
<br />
Дата: <?= gmdate("d-m-Y\ H:i:s\ ", $fullpost->date + timezone * 3600) ?>
<br />
<?php if ($fullpost->tags): ?>
    Теги:
    <?php
    for ($i = 0; $i < count($fullpost->tags); $i++) :
        ?>
        <a href='../controller/index.php?tag=<?= $fullpost->tags[$i]["id"] ?>'><?= $fullpost->tags[$i]["tag"] ?></a>
    <?php
    endfor;
endif;
?>


<br />
<?php if ($userid) : ?>
    <a href='../controller/edit.php?id=<?= $fullpost->postid ?>'>Редактировать...</a>
    <br />
    <a href="../controller/index.php" onclick="$.post('../controller/edit.php', {del_id:<?= $fullpost->postid ?>})">Удалить</a>
<?php endif ?>
<?php include_once(ROOT . "/templates/commentsblock.php"); ?>

