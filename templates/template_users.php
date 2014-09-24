<?php
delCookie('test');
include_once(ROOT . "/templates/menublock.php");
include_once(ROOT . "/templates/messageblock.php");
?>


<div class="container">
    <div class="blog-header">
        <h1 class="blog-title">Блог Для Всех</h1>
        <p class="lead blog-description">Добро пожаловать!</p>
    </div>
    <div class="row">
        <div class="col-sm-8 blog-main">
            <?php if ($role == ADMIN_ROLE): ?>
                <table class="table">
                    <tr><td>Логин</td><td>Email</td><td>Права</td><td>Имя</td><td>Править</td><td>Удалить</td></tr>
                    <?php for ($i = 0; $i < count($user->username); $i++) : ?>
                        <tr>
                            <td><p><?= $user->username[$i] ?></p></td>
                            <td><p><?= $user->email[$i] ?></p></td>
                            <td><p><?php
                                    if ($user->role[$i] == ADMIN_ROLE) {
                                        echo 'администратор';
                                    } elseif ($user->role[$i] == EDITOR_ROLE) {
                                        echo 'редактор';
                                    } else {
                                        echo 'пользователь';
                                    }
                                    ?></p></td>
                            <td><p><?= $user->fullname[$i] ?></p></td>
                            <td><a onclick="fillEditFrame('<?= $user->userid[$i] ?>', '<?= $user->username[$i] ?>', '<?= $user->email[$i] ?>', '<?= $user->role[$i] ?>', '<?= $user->fullname[$i] ?>');
                                            $('#myModal').modal('show');">редактировать</a></td>
                            <td><a onclick="return confirm('Удалить пользователя и все связанные с ним материалы?') ? $.post('../controller/users.php', {del_id: <?= $user->userid[$i] ?>}, onAjaxSuccess) : null;">удалить</a></td>
                        </tr>
                    <?php endfor ?>
                </table>
            <?php endif; ?>
        </div><!-- /.blog-main -->
        <?php
        include_once(ROOT . "/templates/sidebarblock.php");
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->
<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="editUser" class="modal-body">
            </div>
        </div>
    </div>
</div>    <!-- Modal--> 
<script>
    function onAjaxSuccess(data)
    {
        window.location.replace("../controller/users.php");
    }
    function fillEditFrame(userid, username, email, role, fullname) {
        $('#editUser').empty();
        $('#editUser').append("<form action='../controller/users.php' method='post'>\n\
<input name='userid' type='hidden' value='" + userid + "'>\n\
<div class='form-group'>\n\
<label>Логин<input disabled='disabled' type='text' value='" + username + "'><label>\n\
</div>\n\
<div class='form-group'>\n\
<label>E-Mail<input name='email' type='text' value='" + email + "'><label>\n\
</div>\n\
<div class='form-group'>\n\
<label>Редактор<input autocomplete='off' name='role' type='checkbox' " + ((role == 2) ? "checked" : "") + "><label>\n\
</div>\n\
<div class='form-group'>\n\
<label>Полное имя<input name='fullname' type='text' value='" + fullname + "'>\n\
</div>\n\
<input class='btn btn-primary btn-lg' name='saveUserInfo' type='submit' value='сохранить'>\n\
</form>");

    }


</script>