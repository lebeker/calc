<?php
namespace models;
use models\exceptions\CalcException;

class Calc
{
    protected $_store = null;
    public $alias = null;
    protected $_operators = ['+', '-', '*', '/'];

    /**
     * Calc constructor.
     * @param $str
     * @throws CalcException
     */
    public function __construct($str)
    {
        $this->_store = new VariableStorage();
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
        $reVar = '-?\#?[a-zA-Z0-9]+';
        if (preg_match("#^$reVar$#", $str))
            return $this->_store->push($str);

        preg_match_all("#($reVar)\s*([+\-*/])\s*($reVar)#", $str, $m);
        if (!$m[0]) throw new CalcException ("Syntax error at: \"$str\"");

        return $this->_store->push(new Equation($m[1][0], $m[2][0], $m[3][0]));
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
                $sub = $m[1][$i];
                do {
                    $nm = $this->_split($sub);
                    $sub = str_replace($this->_store->last(), $nm, $sub);
                } while ($nm != $sub);
                $str = str_replace($m[0][$i], $sub, $str);
            }
        } while ($m[1]);
        echo "finaly: $str\n";
        var_dump($this->_store->all());
        if ((strpos($str, '(') !== false) || strpos($str, ')') !== false) throw new CalcException('Wrong parenthesis');


    }

    public function trace()
    {
        $trace = [];
        foreach ($this->_store->all() as $eq) {
            $trace["$eq"] = is_string($eq)
                ? $eq
                : $eq->exec($this->_store);
        };
        return $trace;
    }
}

?>
