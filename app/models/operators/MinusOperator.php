<?php
namespace models\operators;

class MinusOperator extends BasicOperator
{
    protected $_symbol = '-';
    protected $_priority = 1;

    public function apply($op1, $op2) { return $op1 - $op2; }
}
