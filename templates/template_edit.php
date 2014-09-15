<?php
delCookie('test');
include_once(ROOT . "/templates/menu.php");
include_once(ROOT . "/templates/loginblock.php");
?>

<p>Добро пожаловать в Блог для Всех</p>


<div class='article'>

    <form action="../controller/edit.php" method="post">
        <label for='inptitle'>Заголовок: </label><input name="inptitle" id="inptitle" type="text" size="2000" value='<?= $posttitle ?>'>
        <label for='inptext'>Текст: </label><input name="inptext" id="inptext" type="text" size="20000" value='<?= $posttext ?>'>
        <input name="postid" type="hidden" value="<?= $postid ?>">
        <label>Автор: <?= $postauthorname ?></label>
        <br />
        <input name="SavePost" type="submit" value="Сохранить">
    </form>
</div>
