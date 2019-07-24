<?php
namespace models;


class VariableStorage
{
    protected $_variables = [];

    public function push($v, $name = null)
    {
        $name = $name ?: ('#' . count($this->_variables));
        $this->_variables[$name] = $v;
        return $name;
    }

    public function all()
    {
        return $this->_variables;
    }

    public function last()
    {
        return end($this->_variables);
    }
}