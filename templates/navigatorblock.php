<ul class="pager">
<?php if ($navbar->currentpage > 1): ?>
    <li><a href='index.php?curpage=<?= $navbar->prevpage ?>'>Назад</a></li>
<?php endif ?>
<?php if ($navbar->pagesamount > $navbar->currentpage) : ?>
    <li><a href='index.php?curpage=<?= $navbar->nextpage ?>'>Вперед</a></li>
    <?php
 endif ?>
</ul>