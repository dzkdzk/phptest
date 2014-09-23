<?php
delCookie('test');
include_once(ROOT . "/templates/menublock.php");
include_once(ROOT . "/templates/loginblock.php");
include_once(ROOT . "/templates/messageblock.php");
?>

<div>
    <form method="post" action="../controller/my.php">
        <label>Полное имя<input name="fullname" type='text' value='<?= $user->fullname ?>'></label>
        <label>E-Mail<input name="email" type='text' value='<?= $user->email ?>'></label>
        <label>Полномочия<input  disabled='yes' type='text' value='<?= ($user->role == ADMIN_ROLE) ? 'Администратор' : 'Пользователь' ?>'></label>
        <label>Логин<input disabled='yes' type='text' value='<?= $user->username ?>'></label>
        <input name="saveUserInfo" type='submit'>
    </form>
</div>