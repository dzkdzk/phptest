<?php

include_once("html.php");
include_once("classes.php");

class TagsPage extends HTMLPage {

    function MainText() {
        $navbar = new navigator(); //!!!!!!!теги
        $lenta = new ArticlesBlock();
        $lenta->getBlockPost($navbar->postsonpage * ($navbar->currentpage - 1), $navbar->postsonpage);

        echo <<<HTML
        <p>Добро пожаловать в Блог для Всех</p>
        <div class='lenta'>
HTML;
        $navbar->draw();
        for ($i = 0; $i < count($lenta->title); $i++) {
            echo <<<HTML
            <div>
            <div>
            <h2><a href='post.php?id={$lenta->postid[$i]}'>
            {$lenta->title[$i]}</a></h2>
            </div>
            <div>{$lenta->text[$i]}</div>
            <div>{$lenta->tail[$i]}</div>
            </div>
HTML;
        }

        echo <<<HTML
        </div>
HTML;
        $navbar->draw();
        echo <<<HTML
        <br />
        <button onClick="location.href='edit.php?id=new'">Добавить запись</button>
HTML;
    }

}

$Page = new IndexPage("Главная страница");
$Page->Write();


