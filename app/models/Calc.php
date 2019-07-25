<?php
namespace models;
use models\exceptions\CalcException;
use models\operators\DivisionOperator;
use models\operators\MinusOperator;
use models\operators\MultiplyOperator;
use models\operators\PlusOperator;

class Calc
{
    protected $_store = null;
    public $alias = null;
    protected $_operators = [];

    /**
     * Calc constructor.
     * @param $str
     * @param array $vars
     * @throws CalcException
     */
    public function __construct($str, $vars = [])
    {
        $this->_store = new VariableStorage($vars);
        $this->_operators = [[],[],[],[],[]];
        foreach ([
             new PlusOperator(),
             new MinusOperator(),
             new MultiplyOperator(),
             new DivisionOperator()
        ] as $op) {
            $this->_operators[$op->priority][$op->symbol] = $op;
        };
        // usort($this->_operators, function($a, $b) { return $a->priority <=> $b->priority;});

        $str = preg_replace('/\s+/', '', $str);
        $this->_parse($str);
    }

    /**
     * @param $str
     * @return bool|null|string
     * @throws CalcException
     */
    protected function _split($str)
    {
        $reVar = '\#?[a-zA-Z0-9\.]+';
        if (preg_match("#^$reVar$#", $str))
            return is_numeric($str) ? $this->_store->push($str) : $str;
        $str = preg_replace("#($reVar)--($reVar)#", '$1+$2', $str);
        $str = preg_replace("#($reVar)\+-($reVar)#", '$1-$2', $str);
        $str0 = $str;
        foreach ($this->_operators as $ops) {
            if (!$ops) continue;
            $symb = join('|', array_keys($ops));
            $symb = preg_replace('#([+*])#i', '\\\\$1', $symb);
            $regx = "#($reVar)(\s*($symb)\s*)($reVar)#";
            preg_match_all($regx, $str, $m);
            if (!$m[0]) continue;
            for ($i = 0; count($m[0]) > $i; $i++) {
                $op = $ops[$m[3][$i][0]];
                $nm = $this->_store->push(new Equation($m[1][$i], $op, $m[4][$i]));
                $str = str_replace($m[1][$i] . $m[3][$i] . $m[4][$i], $nm, $str);
            }
        }
        if ($str == $str0) throw new CalcException("Syntax error at: $str");
        return $this->_split($str);
    }

    /**
     * @param $str
     * @throws CalcException
     */
    protected function _parse($str)
    {
        do {
            preg_match_all('#\(([^()]+)\)#', $str, $m);
            for ($i = 0; count($m[1]) > $i; $i++) {
                $sub = $this->_split($m[1][$i]);
                $str = str_replace($m[0][$i], $sub, $str);
            }
        } while ($m[1]);
        $str = $this->_split($str);
        if ((strpos($str, '(') !== false) || strpos($str, ')') !== false) throw new CalcException('Wrong parenthesis');
    }

    public function trace()
    {
        $trace = [];
        foreach ($this->_store->all() as $k => $eq) {
            $trace[] = [
                'var' => $k,
                'equation' => "$eq",
                'res' => is_string($eq) || is_numeric($eq)
                ? $eq
                : $eq->exec($this->_store)
            ];
        };
        return $trace;
    }

    public function result() {
        return $this->_store->lastVal();
    }
}

?>
