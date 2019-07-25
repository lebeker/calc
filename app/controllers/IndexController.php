<?php
namespace controllers;

use core\Controller;

class IndexController extends Controller {
    public function actionIndex() {
        $this->_renderView('calculator');
    }
}
