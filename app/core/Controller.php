<?php
namespace core;


abstract class Controller
{
    protected function _render($txt) {
        echo $txt;
    }

    protected function _renderJson($any) {
        echo json_encode($any);
    }

    protected function _renderView($name, $data) {
        $vname = __DIR__ . '/../views/' . $name . '.php';
        if (file_exists($vname)) {
            extract($data);
            include $vname;
        } else
            var_dump($data);
    }

    protected function _renderError(\Exception $e) {
        $this->_renderView('error',['error' => $e->getMessage()]);
    }
}