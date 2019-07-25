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
            $eq = $this->_request->post->equation;
            $vars = $this->_request->post->variables;
            $this->_renderJson([
                'trace' => (new Calc($eq, $vars))->trace(),
                'result' => (new Calc($eq, $vars))->result()
            ]);
        } catch (CalcException $e) {
            http_response_code(405);
            $this->_renderJson([
                'error' => $e->getMessage()
            ]);
        }
    }
}
