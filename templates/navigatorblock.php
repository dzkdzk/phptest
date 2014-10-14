<ul class="pager">
    <?php if ($navbar->currentpage > 1): ?>
        <li><a href='index.php?curpage=<?= $navbar->prevpage ?>'>Назад</a></li>
    <?php endif ?>
    <?php if ($navbar->pagesamount > $navbar->currentpage) : ?>
        <li><a href='index.php?curpage=<?= $navbar->nextpage ?>'>Вперед</a></li>
    <?php endif ?>
</ul>
<div>
    <a href='index.php?curpage=1'><<</a>
    <?php foreach ($navbar->pagelinks as $item) : ?>
        <?php if ($navbar->currentpage == $item) : ?>
            <?= $item ?>
        <?php else : ?>
            <a href='index.php?curpage=<?= $item ?>'><?= $item ?></a>
        <?php endif ?>
    <?php endforeach ?>
    <a href='index.php?curpage=<?= $navbar->pagesamount ?>'>>></a>
    <form action="index.php" METHOD=POST>
        <select name="selpostsonpage" onchange="this.form.submit()">
            <option>Постов на странице: <?= $navbar->postsonpage ?></option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
        </select>
    </form>
</div>