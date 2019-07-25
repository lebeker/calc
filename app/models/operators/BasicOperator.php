<?php
namespace models\operators;

/**
 * Class BasicOperator
 *
 * @property string symbol
 * @property string priority
 *
 * @package models\operators
 */
abstract class BasicOperator
{
    protected $_symbol;
    protected $_priority;

    abstract public function apply($op1, $op2);

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (property_exists($this, "_$name"))
            return $this->{"_$name"};
        throw new \Exception('Unknown property: ' . __CLASS__ . " $name");
    }
}
