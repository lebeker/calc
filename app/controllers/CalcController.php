<?php
namespace controllers;

use core\Controller;
use models\Calc;
use models\exceptions\CalcException;

class CalcController extends Controller
{
    public function actionIndex()
    {
        try {
            // '((33--4+5)/34 + -49)-(6)'
            // (34-44)*19 - 6
            // 34-44*19 - 6
            $this->_renderJson(
                (new Calc($this->_request->post->equation))->trace()
            );
        } catch (CalcException $e) {
            http_response_code(405);
            $this->_renderJson([
                'error' => $e->getMessage()
            ]);
        }
    }
}