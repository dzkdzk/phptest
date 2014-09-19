<?php
delCookie('test');
include_once(ROOT . "/templates/menu.php");
include_once(ROOT . "/templates/loginblock.php");
?>

<p>Добро пожаловать в Блог для Всех</p>
<h2><a href = '../controller/post.php?id=<?= $fullpost->postid ?>'><?= $fullpost->title ?></a></h2>
<br />
<?php for ($i = 0; $i < count($fullpost->files); $i++) : ?>
    <?php $filepath = uploaddir . $fullpost->files[$i]['filename'] ?>
    <img src="../<?=$filepath ?>">
<?php endfor ?>
<?= nl2br($fullpost->text) ?>
<br />
Автор: <?= $fullpost->tail ?>
<br />
Дата: <?= gmdate("d-m-Y\ H:i:s\ ", $fullpost->date + timezone * 3600) ?>
<br />
Теги:

<?php for ($i = 0; $i < count($fullpost->tags); $i++) : ?>
    <a href='../controller/index.php?tag=<?= $fullpost->tags[$i]["id"] ?>'><?= $fullpost->tags[$i]["tag"] ?></a>
<?php endfor ?>

<br />
<?php if ($userid) : ?>
    <a href='../controller/edit.php?id=<?= $fullpost->postid ?>'>Редактировать...</a>
    <br />
    <a href="../controller/index.php" onclick="$.post('../controller/edit.php', {del_id:<?= $fullpost->postid ?>})">Удалить</a>
<?php endif ?>
<?php include_once(ROOT . "/templates/commentsblock.php"); ?>

