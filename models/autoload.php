<?php

spl_autoload_register('autoload');

function autoload($className) {
    $fileName = ROOT . '/models/' . $className . '.php';
    include $fileName;
}
