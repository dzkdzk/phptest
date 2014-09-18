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
        <div id='tags'>
            <?php if (!isset($tags)) : $tags[]['tag'] = "";
                $tags[0]['id'] = "new";
            endif ?>
            Теги:
            <div id='tagscontainer'>
                <?php for ($i = 0; $i < count($tags); $i++) : ?>
                    <input type=text onkeyup='getcorrecttag(this.id, $(this).val());' id='tag<?= $i ?>' name='tag<?= $i ?>' value='<?= $tags[$i]["tag"] ?>'>
                    <input type=hidden id='tag<?= $i ?>x' name='tag<?= $i ?>x' value='<?= $tags[$i]["id"] ?>'>
<?php endfor ?>
            </div>
            <button type="button" onclick="$('#tagscontainer').append(newtaginput());">Еще...</button>
            <script>
                var inc = <?= $i ?>;
                function newtaginput() {
                    var res;
                    res = "<input type='text' onkeyup='getcorrecttag(this.id, $(this).val());' id='tag" + inc + "' name='tag" + inc + "'>";
                    res = res + "<input type='hidden' id='tag" + inc + "x' name='tag" + inc + "x'>";
                    inc++;
                    return res;
                }
                function getcorrecttag(inp_el, value) {
                    $("#" + inp_el + "x").val("new");
                    if (value.length > 2) {
                        $.ajax({
                            url: 'tags.php/?tagval=' + value,
                            success: function (data) {
                                var res;
                                res = json_decode(data);
                                if (!$("div").is("#choosediv")) {
                                    drawchoosediv();
                                }
                                fillchoosediv(inp_el, res);
                            }
                        });
                    }
                }
                function drawchoosediv() {
                    $('#tags').append("<div id='choosediv'></div>");
                }
                function destroychoosediv() {
                    $('#choosediv').remove();
                }
                function fillchoosediv(inp_el, data) {
                    $('#choosediv').empty();
                    var valTag;
                    for (var item in data) {
                        valTag = data[item]['tag'];
                        valId = data[item]['id'];
                        $('#choosediv').append('<p onclick="updInput(\'' + inp_el + '\',\'' + valTag + '\',\'' + valId + '\');">' + valTag + '</p>');
                    }

                }

                function updInput(inp_el, valTag, valId) {
                    $("#" + inp_el).val(valTag);
                    $("#" + inp_el + "x").val(valId);
                    destroychoosediv();
                }
                function json_decode(str_json) {
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
        </div>
        <br />
        <input name="SavePost" type="submit" value="Сохранить">
    </form>
</div>
