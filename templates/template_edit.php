<?php
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
            <div class="blog-post">

                <form action="../controller/edit.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Заголовок: </label>
                        <input class="form-control input-md" name="inptitle" id="inptitle" type="text" size="200" value='<?= $posttitle ?>'>
                    </div>


                    <div id="images">
                        <div><label>Изображения: </label></div>
                        <?php for ($i = 0; $i < count($fullpost->files); $i++) : ?>
                            <?php $filepath = UPLOADDIR . $fullpost->files[$i]['filename'] ?>
                            <img title="удалить?" class="img-thumbnail postimages" id="img<?= $i ?>" onclick="return confirm('Удалить рисунок?') ? delImage(this.id, $(this).attr('src')) : null;" src="../<?= $filepath ?>">
                        <?php endfor ?>
                    </div>

                    <div id="imgchooser">
                        <div class="inpfile">
                            <input autocomplete="off" onchange="cloneEl($(this).parent());
                                    pushVal($(this).next(), $(this).val());" name="image[]" type="file">
                            <p class="btn btn-info btn-mini" onclick="trigEl(this);">Еще...</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Текст: </label><textarea class="form-control" id="inptext" rows="10" cols="60" name="inptext"><?= $posttext ?></textarea>
                        <input name="postid" type="hidden" value="<?= $postid ?>"></div>
                    <div class="form-group">
                        <label>Автор: <?= $postauthorname ?></label>
                    </div>
                    <div id='tags' class="form-group">
                        <?php
                        if (!isset($tags)) : $tags[]['tag'] = "";
                            $tags[0]['id'] = "new";
                        endif
                        ?>
                        <label>Теги:</label>
                        <div id='tagscontainer'>
                            <?php for ($i = 0; $i < count($tags); $i++) : ?>
                                <input class="form-control input-md" type=text onkeyup='getcorrecttag(this.id, $(this).val());' id='tag<?= $i ?>' name='tag<?= $i ?>' value='<?= $tags[$i]["tag"] ?>'>
                                <input type=hidden id='tag<?= $i ?>x' name='tag<?= $i ?>x' value='<?= $tags[$i]["id"] ?>'>
                            <?php endfor ?>
                        </div>
                        <!-- Modal -->
                        <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div id="choosediv" class="modal-body">
                                    </div>
                                </div>
                            </div>
                        </div>    <!-- Modal-->   
                        <button type="button" class="btn btn-info btn-mini" onclick="$('#tagscontainer').append(newtaginput());">Еще...</button>
                    </div>
                    <div class="imgbrdr"></div>
                    <div>
                        <input class="btn btn-primary btn-large btn-save" name="SavePost" type="submit" value="Сохранить">
                    </div>
                </form>
            </div><!-- /.blog-post -->
        </div><!-- /.blog-main -->
        <?php
        include_once(ROOT . "/templates/sidebarblock.php");
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->

<script>
    var inc = <?= $i ?>;
    function newtaginput() {                        //динамическое добавление новых инпутов для тега
        var res;
        res = "<input class='form-control input-md' type='text' onkeyup='getcorrecttag(this.id, $(this).val());' id='tag" + inc + "' name='tag" + inc + "'>";
        res = res + "<input type='hidden' id='tag" + inc + "x' name='tag" + inc + "x'>";
        inc++;
        return res;
    }
    function getcorrecttag(inp_el, value) {         //получение из базы уже существующих тегов ля подсказки
        $("#" + inp_el + "x").val("new");
        if (value.length > 2) {
            $.ajax({
                url: '../controller/tags.php?tagval=' + value,
                success: function (data) {
                    var res;
                    res = json_decode(data);
                    if (data != 'false') {
                        fillchoosediv(inp_el, res);
                        $('#myModal').modal('show');
                    }
                }
            });
        }
    }
    function delImage(elem, file) {                 //отправляем запрос на сервер об удалении изображения поста
        $.post(
                "../controller/delimage.php",
                {
                    img: file,
                    postid: "<?= $postid ?>",
                    userid: "<?= $userid ?>",
                    hashsess: "<?= $hashsess ?>"
                }, onAjaxSuccess
                );
        function onAjaxSuccess(data)
        {
            if (data == 'Успешно удалено!') {
                $('#' + elem).fadeOut();
            } else {
                alert(data);
            }
        }
    }
    function destroychoosediv() {                  //спрятать окно подсказок тегов
        $('#myModal').modal('hide');
    }
    function fillchoosediv(inp_el, data) {         //заполнение модального окна подсказками
        $('#choosediv').empty();
        var valTag;
        for (var item in data) {
            valTag = data[item]['tag'];
            valId = data[item]['id'];
            $('#choosediv').append('<p onclick="updInput(\'' + inp_el + '\',\'' + valTag + '\',\'' + valId + '\');">' + valTag + '</p>');
        }
    }
    function updInput(inp_el, valTag, valId) {    //при выборе из подсказки тега - перенос в инпут
        $("#" + inp_el).val(valTag);
        $("#" + inp_el + "x").val(valId);
        destroychoosediv();
    }
    function trigEl(el) {                                      //костыли для стилизования инпута файлов
        if ($(el).prev().val() === '') {                       //создал рядом с инпутом элемент, который стилизован и дублирует функции инпута, а сам инпут скрыт
            $(el).prev().click();
        } else {
            $(el).parent().remove();
        }
    }
    function cloneEl(el) {
        el.clone().appendTo('#imgchooser');                    //динамическое обавление еще инпутов
        el.next().children().val('');
    }
    function pushVal(el, val) {                                //перенос имени файла из инпута в элемент
        // el.text((val.match(/[^\\/]+\.[^\\/]+$/) || []).pop());
        // [^\\/]+$
        el.text((val.match(/[^\\/]+$/) || []).pop());
    }
    function json_decode(str_json) {              //стандартная ф-ция для распарсивания json
        var json = this.window.JSON;
        if (typeof json === 'object' && typeof json.parse === 'function') {
            try {
                return json.parse(str_json);
            } catch (err) {
                if (!(err instanceof SyntaxError)) {
                    throw new Error('Unexpected error type in json_decode()');
                }
                this.php_js = this.php_js || {};
                // usable by json_last_error()
                this.php_js.last_error_json = 4;
                return null;
            }
        }
        var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
        var j;
        var text = str_json;
        cx.lastIndex = 0;
        if (cx.test(text)) {
            text = text.replace(cx, function (a) {
                return '\\u' + ('0000' + a.charCodeAt(0)
                        .toString(16))
                        .slice(-4);
            });
        }
        if ((/^[\],:{}\s]*$/)
                .test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@')
                        .replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                        .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
            j = eval('(' + text + ')');
            return j;
        }
        this.php_js = this.php_js || {};
        this.php_js.last_error_json = 4;
        return null;
    }

</script>