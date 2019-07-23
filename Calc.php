<?php
class VariableStorage {
  protected $_variables = [];
  public function push($v, $name = null) {
      $name = $name ?: ('#' . count($this->_variables));
      $this->_variables[$name] = $v;
      return $name;
  }

  public function all() { return $this->_variables; }
  public function last() {return end($this->_variables);}
}
class Equasion {
    protected $_op1;
    protected $_op;
    protected $_op2;
    public function __construct($op1, $op, $op2) {
        $this->_op1 = $op1;
        $this->_op = $op;
        $this->_op2 = $op2;
    }
    public function __toString() {
       return $this->_op1 . $this->_op . $this->_op2;
    }

    public function exec(VariableStorage $store) {
        $arg1 = $store->all()[$this->_op1] ?? $this->_op1;
        $arg2 = $store->all()[$this->_op2] ?? $this->_op2;
        $st = (
            ($arg1 instanceof Equasion ? $arg1->exec($store) : $this->_op1)
            . $this->_op
            . ($arg2 instanceof Equasion ? $arg2->exec($store) : $this->_op2)
        );
        $st = str_replace('++', '+ +', $st);
        $st = str_replace('--', '- -', $st);
        eval('$st = ' . $st . ';');
        return ($st);
    }
}
class Calc {
  protected $_store = null;
  public $alias = null;
  protected $_operators = ['+','-','*','/'];
  public function __construct($str) {
      $this->_store = new VariableStorage();
      $str = preg_replace('/\s+/', '', $str);
      $this->_parse($str); 
  }
  protected function _split($str) {
      $reVar = '-?\#?[a-zA-Z0-9]+';
      if (preg_match("#^$reVar$#", $str))
          return $this->_store->push($str);

      preg_match_all("#($reVar)\s*([+\-*/])\s*($reVar)#", $str, $m);
      if (!$m[0]) throw new Exception ("Syntax error at: \"$str\"");

      return $this->_store->push(new Equasion($m[1][0], $m[2][0], $m[3][0]));
      $str = str_replace($m[0], $nm, $str);
      return $nm == $str;
  }
  protected function _parse($str) {
      do {
        echo "parsing... $str\n";
        preg_match_all('#\(([^()]+)\)#', $str, $m);
        for($i=0; count($m[1])>$i; $i++) {
            $sub = $m[1][$i];
            do {
                $nm = $this->_split($sub);
                $sub = str_replace($this->_store->last(), $nm, $sub);
            } while ($nm != $sub);
            $str = str_replace($m[0][$i], $sub, $str);
        }
      } while($m[1]);
echo "finaly: $str\n";
      var_dump($this->_store->all());
      if ((strpos($str, '(') !== false) || strpos($str, ')') !== false) throw new Exception('Wrong parenthesis');

      foreach($this->_store->all() as $eq) {
        echo "$eq = " . (is_string($eq) ? $eq : $eq->exec($this->_store)) . "\n";
      };
  }
}
new Calc('((33--4+5)/34 + -49)-(6)');
?>
