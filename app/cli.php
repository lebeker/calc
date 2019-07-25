<?php
require './core/autoloader.php';

use \models\Calc;

// '((33--4+5)/34 + -49)-(6)'
// (34-44)*19 - 6
// 34-44*19 - 6
try{
    $data = [
//        '34-44*19 - 6',
//        '(34-44)*19 - 6',
        '((33- -4+5)/34 + -49)-(6)'
    ];
    foreach ($data as $ex) {

        $c = (new Calc($ex));
        foreach ($c->trace() as $t)
            echo $t['var'] . ': ' . $t['equation'] . ' = ' . $t['res'] . "\n";

        $check; eval('$check=' . $ex . ';');
        echo "Res: " . $c->result() . '   ~ ' . $check . "\n";
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}