<?php
namespace models;

class Equation
{
    protected $_op1;
    protected $_op;
    protected $_op2;

    public function __construct($op1, $op, $op2)
    {
        $this->_op1 = $op1;
        $this->_op = $op;
        $this->_op2 = $op2;
    }

    public function __toString()
    {
        return $this->_op1 . $this->_op . $this->_op2;
    }

    public function exec(VariableStorage $store)
    {
        $arg1 = $store->all()[$this->_op1] ?? $this->_op1;
        $arg2 = $store->all()[$this->_op2] ?? $this->_op2;
        $st = (
            ($arg1 instanceof Equation ? $arg1->exec($store) : $this->_op1)
            . $this->_op
            . ($arg2 instanceof Equation ? $arg2->exec($store) : $this->_op2)
        );
        $st = str_replace('++', '+ +', $st);
        $st = str_replace('--', '- -', $st);
        eval('$st = ' . $st . ';');
        return ($st);
    }
}
