<div id="sidemenu">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="../controller/index.php">Главная</a></li>
        <li><a href="../controller/pages.php?id=1">Обо мне</a></li>
        <li><a href="../controller/pages.php?id=2">Полезные ссылки</a></li>
    </ul>
</div>
<div title="Menu" id="sidemenubut"></div>

<div title="Top of page" id="topbut"></div>

<?php if ($userid) : ?>
    <div title="Log out" onClick="location.href = '../controller/login.php?logout=1'" id="logoutbut">
    </div>
<?php else : ?>
    <div title="Log in" id="loginbut">
    </div>
<?php endif ?>


<script type="text/javascript">
    $(document).ready(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 0) {
                $('#topbut').fadeIn();
            } else {
                $('#topbut').fadeOut();
            }
        });
        $('#topbut').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 400);
            return false;
        });
        $('#loginbut').click(function () {
            $('#loginusername').focus();
            return false;
        });
        $('#sidemenubut').click(function () {
            $('#sidemenu').toggle('slow');
        });
    });
</script>