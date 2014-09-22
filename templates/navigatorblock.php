<div>
<?php if ($navbar->currentpage > 1): ?>
    <a href='index.php?curpage=<?= $navbar->prevpage ?>'><-</a>
<?php endif ?>
<?php if ($navbar->pagesamount > $navbar->currentpage) : ?>
    <a href='index.php?curpage=<?= $navbar->nextpage ?>'>-></a>
    <?php
 endif ?>
</div>