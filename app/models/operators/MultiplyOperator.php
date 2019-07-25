<?php
namespace models\operators;

class MultiplyOperator extends BasicOperator
{
    protected $_symbol = '*';
    protected $_priority = 0;

    public function apply($op1, $op2) { return $op1 * $op2; }
}
