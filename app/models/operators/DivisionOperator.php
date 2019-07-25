<?php
namespace models\operators;

use models\exceptions\CalcException;

class DivisionOperator extends BasicOperator
{
    protected $_symbol = '/';
    protected $_priority = 0;

    /**
     * @param $op1
     * @param $op2
     * @return float|int
     * @throws CalcException
     */
    public function apply($op1, $op2) {
        if (!$op2) throw new CalcException('Division by zero');
        return $op1 / $op2;
    }
}
