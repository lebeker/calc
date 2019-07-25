<?php
namespace core;

class Router
{
    /**
     * @throws \Exception
     */
    public function run() {
        $path = explode('?', $_SERVER['REQUEST_URI']);
        $path = explode('/', $path[0]);
        array_shift($path);
        $controller = array_shift($path) ?: 'index';
        $method = array_shift($path) ?: 'index';
        if (!$method && 'index' != $controller) {
            $method = $controller;
            $controller = 'index';
        }

        $controller = 'controllers\\' . ucfirst($controller) . 'Controller';
        $method = 'action' . ucfirst($method);

        if (!class_exists($controller)
         || !($controller = new $controller((object)[
                'post' => json_decode(file_get_contents('php://input')),
                'get' => $path[1] ?? null,
            ]))
         || !method_exists($controller, $method)) {
            throw new \Exception('Unknown Route');
        } else {
            call_user_func_array([$controller, $method], $path);
        }
    }
}