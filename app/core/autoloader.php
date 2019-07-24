<?php
function __autoload($class)
{
    require '../' . str_replace('\\',DIRECTORY_SEPARATOR, $class). '.php';
}