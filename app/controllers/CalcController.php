<?php
namespace controllers;

use core\Controller;
use models\Calc;
use models\exceptions\CalcException;

class CalcController extends Controller
{
    public function actionCalc()
    {
        try {
            new Calc('((33--4+5)/34 + -49)-(6)');
        } catch (CalcException $e) {
            $this->_renderError($e);
        }
    }
}