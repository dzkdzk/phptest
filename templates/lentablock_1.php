<div class="col-sm-8 blog-main">
    <?php if ($viewtype == 1): ?><h2>Результаты поиска по тегу <a href='../controller/index_1.php?flush=1'>(Закрыть)</a></h2><?php endif ?>
    <?php if ($viewtype == 2): ?><h2>Результаты поиска: <?= $searchtext ?> <a href='../controller/index_1.php?flush=1'>(Закрыть)</a></h2><?php endif ?>
    <?php for ($i = 0; $i < count($lenta->title); $i++): ?>
        <div id="<?= $i ?>" class="blog-post">
            <h2 class="blog-post-title"><a href='../controller/post.php?id=<?= $lenta->postid[$i] ?>'><?= $lenta->title[$i] ?></a></h2>
            <div><?= nl2br($lenta->text[$i]) ?>...</div>
            <div class="blog-post-meta">Автор: <?= $lenta->author[$i] ?></div>
            <div class="blog-post-meta">Дата: <?= gmdate("d-m-Y\ H:i:s\ ", $lenta->date[$i] + TIMEZONE * 3600) ?></div>
            <?php if ($lenta->tags[$i]): ?>
                <div class="blog-post-meta">Теги: 
                    <?php foreach ($lenta->tags[$i] as $item): ?>
                        <a href='../controller/index_1.php?tag=<?= $item['id'] ?>'><?= $item['tag'] ?></a>                 
                    <?php endforeach; ?>
                </div>
            <?php endif ?>
        </div><!-- /.blog-post -->
    <?php endfor; ?>
    <ul class="pager">
        <li><a id="navprevlnk" onclick="prevpage();">Назад</a></li>
        <li><a id="navnextlnk" onclick="nextpage();">Вперед</a></li>
    </ul>
    <div>
        <a id="navfrstlnk" onclick="frstpage();"><<</a>
        <span id="navlnkscontainer"></span>
        <a id="navlastlnk" onclick="lastpage();">>></a>
        <form>
            <label>Постов на странице:
                <select id="spopdefval" onchange="redraw(this.value);" name="selpostsonpage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                </select>
            </label>
        </form>
    </div>
</div><!-- /.blog-main -->
<script type="text/javascript">
    var curpage = 1;
    var pagelinksamount = <?= PAGELINKSAMOUNT ?>;
    var postsonpage = 5;
    if (typeof (getCookie('postsonpage')) != "undefined") {
        postsonpage = getCookie('postsonpage');
    }
    var postamount = document.getElementsByClassName('blog-post').length;
    var pagesamount = Math.ceil(postamount / postsonpage);
    document.body.onload = function () {
        redraw(postsonpage);
    }
    function redraw(selpostsonpage) {                                              //начальная отрисовка пагинации и при изменении параметров
        var spopdefval = document.getElementById('spopdefval');                    //раскр список кол-ва постов на стр
        for (var childItem in spopdefval.childNodes) {                             //вывод текущ. знач.
            if (spopdefval.childNodes[childItem].nodeType == 1 && spopdefval.childNodes[childItem].value == selpostsonpage)
                spopdefval.childNodes[childItem].setAttribute('selected', 'selected')
        }

        setCookie('postsonpage', selpostsonpage);
        postsonpage = selpostsonpage;
        pagesamount = Math.ceil(postamount / postsonpage);
        curpage = 1;
        var lnkcontainer = document.getElementById('navlnkscontainer');       //очистка нум. ссылок на страницы
        while (lnkcontainer.childNodes[0]) {
            lnkcontainer.removeChild(lnkcontainer.childNodes[0]);
        }
        for (var i = 0; i < pagelinksamount && i < pagesamount; i++) {        //создание новых ссылок на стр
            var lnk = document.createElement('a')
            lnk.className = 'pagelnk';
            lnk.id = 'lnk' + (i + 1);
            lnkcontainer.appendChild(lnk)
        }
        hideallposts();
        showposts(postsonpage * (curpage - 1), postsonpage);
    }
    function hideallposts() {
        var postdivs = document.getElementsByClassName('blog-post');
        for (var i = 0; i < postdivs.length; i++)
            postdivs[i].style.display = 'none';
    }
    function drawlinks() {                                                     //отрисовка всех ссылок пагинации
        if (curpage == 1) {
            var prevEl = document.getElementById('navprevlnk');
            prevEl.style.display = 'none';
        } else {
            var prevEl = document.getElementById('navprevlnk');
            prevEl.style.display = '';
        }
        if (curpage == pagesamount) {
            var prevEl = document.getElementById('navnextlnk');
            prevEl.style.display = 'none';
        } else {
            var prevEl = document.getElementById('navnextlnk');
            prevEl.style.display = '';
        }

        var startlink = curpage - Math.floor(pagelinksamount / 2);
        var realpagelinksamount = (pagelinksamount <= pagesamount) ? pagelinksamount : pagesamount;
        if (startlink > pagesamount - realpagelinksamount) {
            startlink = pagesamount - realpagelinksamount + 1;
        }
        if (curpage - Math.floor(realpagelinksamount / 2) <= 1) {
            startlink = 1;
        }
        var pagelinks = [];
        for (i = 0; i < realpagelinksamount; i++) {
            pagelinks.push(startlink + i);
        }

        var navlnk = document.getElementsByClassName('pagelnk');
        for (var i = 0; i < navlnk.length; i++) {
            if (pagelinks[i] == curpage) {
                navlnk[i].style.fontWeight = "bold"
            } else {
                navlnk[i].style.fontWeight = ""
            }
            navlnk[i].innerHTML = pagelinks[i];
            navlnk[i].onclick = function () {
                hideallposts();
                curpage = this.innerHTML;
                showposts(postsonpage * (this.innerHTML - 1), postsonpage);
            }
        }
    }
    function showposts(start, amount) {
        var postdivs = document.getElementsByClassName('blog-post');
        count = 0;
        for (var i = start; i < postdivs.length && count < amount; i++) {
            count++;
            if (postdivs[i].getAttribute('id') == i) {
                postdivs[i].style.display = '';
            }
        }
        drawlinks();                                       //перерисовка ссылок пагинации
    }
    function frstpage() {
        hideallposts();
        curpage = 1;
        showposts(0, postsonpage);
    }
    function lastpage() {
        hideallposts();
        curpage = pagesamount;
        showposts(postsonpage * (curpage - 1), postsonpage);
    }
    function nextpage() {
        hideallposts();
        curpage++;
        showposts(postsonpage * (curpage - 1), postsonpage);
    }
    function prevpage() {
        hideallposts();
        curpage--;
        showposts(postsonpage * (curpage - 1), postsonpage);
    }

    function setCookie(name, value, options) {
        options = options || {};
        var expires = options.expires;
        if (typeof expires == "number" && expires) {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }
        value = encodeURIComponent(value);
        var updatedCookie = name + "=" + value;
        for (var propName in options) {
            updatedCookie += "; " + propName;
            var propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }
        document.cookie = updatedCookie;
    }
    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
</script>  
