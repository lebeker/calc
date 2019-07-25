<?php
namespace models;


use models\exceptions\CalcException;

class VariableStorage
{
    protected $_variables = [
        'P' => M_PI,
        'E' => M_E
    ];

    /**
     * VariableStorage constructor.
     * @param $vars
     * @throws CalcException
     */
    public function __construct($vars) {
        foreach ($vars as $k => $val) {
            $this->push($val, $k);
        }
    }

    /**
     * @param $v
     * @param null $name
     * @return null|string
     * @throws CalcException
     */
    public function push($v, $name = null)
    {
        if ($name && !preg_match('#[a-z]+#i', $name)) throw new CalcException("Wrong variable name: $name; please use only latin symbols.");
        if ($name && !empty($this->_variables[$name])) throw new CalcException("Duplicate variable: $name.");

        $name = $name ?: ('#' . count($this->_variables));
        $this->_variables[$name] = $v;
        return $name;
    }

    public function get($key) {
        return $this->_variables[$key] ?? null;
    }

    public function all()
    {
        return $this->_variables;
    }

    public function lastVal()
    {
        $res = end($this->_variables);
        return $res instanceof Equation ? $res->exec($this) : $res;
    }
}
