<div class="col-sm-8 blog-main">
    <?php if ($viewtype == 1): ?><h2>Результаты поиска по тегу <a href='../controller/index_2.php?flush=1'>(Закрыть)</a></h2><?php endif ?>
    <?php if ($viewtype == 2): ?><h2>Результаты поиска: <?= $searchtext ?> <a href='../controller/index_2.php?flush=1'>(Закрыть)</a></h2><?php endif ?>
    <div id="posts_cont">

    </div>
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
                <select id="spopdefval" onchange="removeallposts();
                        getposts(1, this.value);" name="selpostsonpage">
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
    var postamount = 0;

    var pagesamount = 0;
    document.body.onload = function () {
        getposts(curpage, postsonpage);                                          //загрузка статей при обновлении стр


    };
    function getposts(curpage, postsonpage) {                                     // получение статей аяксом
        $.post("index_2.php", {curpage: curpage, selpostsonpage: postsonpage}, function (data) {
            var posts = jQuery.parseJSON(data);
            postamount = posts.postamount;
            pagesamount = Math.ceil(postamount / postsonpage);
            drawLinks(postsonpage);
            showposts(posts);
            filllinks();
        });
    }
    function drawLinks(selpostsonpage) {                                              //начальная отрисовка пагинации и при изменении параметров
        $('#spopdefval option[value="' + selpostsonpage + '"]').attr("selected", "selected"); //раскр список кол-ва постов на стр., вывод текущ. знач.
        setCookie('postsonpage', selpostsonpage);
        postsonpage = selpostsonpage;
        pagesamount = Math.ceil(postamount / postsonpage);
        var lnkcontainer = $('#navlnkscontainer');
        $('.pagelnk').remove();

        for (var i = 0; i < pagelinksamount && i < pagesamount; i++) {        //создание новых ссылок на стр
            lnkcontainer.append('<a class="pagelnk"></a>');
        }
    }

    function removeallposts() {
        $('.blog-post').remove();
    }

    function filllinks() {                                                     //отрисовка всех ссылок пагинации
        if (curpage == 1) {
            $('#navprevlnk').hide();
        } else {
            $('#navprevlnk').show();
        }
        if (curpage == pagesamount) {
            $('#navnextlnk').hide();
        } else {
            $('#navnextlnk').show();
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
        var i = 0;
        $('.pagelnk').each(function () {
            if (pagelinks[i] == curpage) {
                $(this).css("font-weight", "Bold");
            } else {
                $(this).css("font-weight", "");
            }
            $(this).append(pagelinks[i]);
            $(this).click(function () {
                removeallposts();
                curpage = this.innerHTML;
                getposts(curpage, postsonpage);
            });
            i++;
        });
    }
    function showposts(data) {                                           //отображение блоков статей (ленты)
        for (i = 0; i < data.postid.length; i++) {
            var postel = $('<div class="blog-post"></div>');
            $('#posts_cont').append(postel);
            var titleel = $("<h2 class=\"blog-post-title\"><a href='../controller/post.php?id=" + data.postid[i] + "'>" + data.title[i] + "</a></h2>");
            postel.append(titleel);
            var textel = $("<div>" + nl2br(data.text[i]) + "...</div>");
            postel.append(textel);
            var authorel = $("<div class='blog-post-meta'>Автор: " + data.author[i] + "</div>");
            postel.append(authorel);
            var dateel = $("<div class='blog-post-meta'>Дата: " + timeConv(data.date[i]) + "</div>");
            postel.append(dateel);
            if (data.tags.length > 0) {
                var tagsel = $("<div class='blog-post-meta'>Теги: </div>");
                postel.append(tagsel);
                for (j = 0; j < data.tags[i].length; j++) {
                    var tagel = $("<a href='../controller/index_2.php?tag=" + data.tags[i][j]['id'] + "'>" + data.tags[i][j]['tag'] + " </a>");
                    tagsel.append(tagel);
                }
            }
        }
    }
    function frstpage() {
        removeallposts();
        curpage = 1;
        getposts(curpage, postsonpage);
    }
    function lastpage() {
        removeallposts();
        curpage = pagesamount;
        getposts(curpage, postsonpage);
    }
    function nextpage() {
        removeallposts();
        curpage++;
        getposts(curpage, postsonpage);
    }
    function prevpage() {
        removeallposts();
        curpage--;
        getposts(curpage, postsonpage);
    }
    function timeConv(UNIX_timestamp) {
        var a = new Date(UNIX_timestamp * 1000);
        var months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var time = date + '-' + month + '-' + year + ' ' + hour + ':' + min;
        return time;
    }
    function nl2br(str) {
        return str.replace(/([^>])\n/g, '$1<br/>');
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
