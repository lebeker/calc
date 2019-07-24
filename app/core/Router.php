<?php
namespace core;

class Router
{
    public function run() {
        $path = explode('?', $_SERVER['REQUEST_URI']);
        $path = explode('/', $path[0]);

        $controller = array_shift($path) ?: 'index';
        $method = array_shift($path) ?: 'index';
        if (!$method && 'index' != $controller) {
            $method = $controller;
            $controller = 'index';
        }

        $controller = 'controllers\\' . ucfirst($controller) . 'Controller';
        $method = 'action' . ucfirst($method);

        if (!class_exists($controller)
         || !($controller = new $controller)
         || !method_exists($controller, $method)) {
            echo "cant find route: " . var_export($path, true);
        } else {
            call_user_func_array([$controller, $method], $path);
        }
    }
}