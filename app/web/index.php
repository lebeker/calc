<?php
require('../core/autoloader.php');
use core\Router;
try {
    (new Router())->run();
} catch (Exception $e) {
    echo '<h3>' . $e->getMessage() . '</h3>';
    if ($e->xdebug_message) {
        echo "<table>{$e->xdebug_message}</table>";
    }
}