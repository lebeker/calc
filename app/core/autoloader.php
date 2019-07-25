<?php
function __autoload($class)
{
    require __DIR__ . '/../' . str_replace('\\',DIRECTORY_SEPARATOR, $class). '.php';
}
