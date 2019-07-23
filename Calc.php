<?php
class Equasion {
  public $alias = null;
}
class Calc {
  public $alias = null;
  protected $_variables = [];
  protected $_operator = null;
  public function construct($str) {
       
  }
  protected function _parse($str) {
      while(($ep = strpos(')', $str)) !== false) {
          $sp = str
      }	
      if (strpos('(', $str) !== false) throw new Exception('Wrong parenthesis');
      
  }
}
?>
