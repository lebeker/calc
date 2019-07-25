<?php
namespace models;

use models\operators\BasicOperator;

class Equation
{
    protected $_op1;
    /*** @var BasicOperator _op **/
    protected $_op;
    protected $_op2;

    public function __construct($op1, BasicOperator $op, $op2)
    {
        $this->_op1 = $op1;
        $this->_op = $op;
        $this->_op2 = $op2;
    }

    public function __toString()
    {
        return $this->_op1 . $this->_op->symbol . $this->_op2;
    }

    public function exec(VariableStorage $store)
    {
        $arg1 = $store->get($this->_op1) ?? $this->_op1;
        $arg2 = $store->get($this->_op2) ?? $this->_op2;

        $arg1 = $arg1 instanceof Equation ? $arg1->exec($store) : $arg1;
        $arg2 = $arg2 instanceof Equation ? $arg2->exec($store) : $arg2;

        return $this->_op->apply($arg1, $arg2);
    }
}
