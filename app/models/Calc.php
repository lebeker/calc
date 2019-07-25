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
     * @throws CalcException
     */
    public function __construct($str)
    {
        $this->_store = new VariableStorage();
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
        $str0 = $str;
        $reVar = '-?\#?[a-zA-Z0-9]+';
        if (preg_match("#^$reVar$#", $str))
            return is_numeric($str) ? $this->_store->push($str) : $str;

        foreach ($this->_operators as $ops) {
            if (!$ops) continue;
            $symb = join('|', array_keys($ops));
            $symb = preg_replace('#([+*])#i', '\\\\$1', $symb);
            $regx = "#([a-zA-Z0-9])?($reVar)(\s*($symb)\s*)($reVar)#";
            preg_match_all($regx, $str, $m);
            if (!$m[0]) continue;

            $op = $ops[$m[4][0][0]];
            if ($m[1][0]) {
                if ($m[2][0][0] == '-') {
                    $m[2][0] = substr($m[2][0], 1);
                } else {
                    $m[2][0] = $m[1][0] . $m[2][0];
                }
            }
            $nm = $this->_store->push(new Equation($m[2][0], $op, $m[5][0]));
            $str = str_replace($m[2][0] . $m[3][0] . $m[5][0], $nm, $str);
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
            echo "parsing... $str\n";
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
                'res' => is_string($eq)
                ? $eq
                : $eq->exec($this->_store)
            ];
        };
        return $trace;
    }

    public function result() {
        return $this->_store->last()->exec($this->_store);
    }
}

?>
