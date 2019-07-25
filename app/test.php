<?php
require __DIR__ . '/core/autoloader.php';

use \models\Calc;

try{
    $data = [
        '34- -4.4*19 - 6',
        '(34-44)*19 - 6*P',
        '((33- -4+5)/34 + -49)-(6)',
        'a - 55'
    ];
    $vars = [
        'a' => 124
    ];
    foreach ($data as $ex) {

        $c = (new Calc($ex, $vars));
        foreach ($c->trace() as $t)
            echo $t['var'] . ': ' . $t['equation'] . ' = ' . $t['res'] . "\n";
        $check = null; eval('$check=' . preg_replace('#([a-z]+)#i', '$vars["$1"]', str_replace('P', M_PI, $ex)) . ';');
        $res = $c->result();
        echo "Res: $res  ~ $check\n";

        if (abs($check - $res) > 0.0001) throw new \Exception("Test Failed: $ex ~ $res != $check");
    }
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
    exit(1);
}

try{
    $data = [
        'rrtnuio',
        'b-44*19 - 6',
        '(((34-44)*19 - 6',
    ];
    $vars = [
        'a' => 124
    ];
    foreach ($data as $ex) {
        try {
            $c = (new Calc($ex, $vars));
            $res = $c->result();
            throw new \Exception("Test Failed: $ex ~ considered valid");
        } catch (\models\exceptions\CalcException $e) {
            echo "Error catched: " . $e->getMessage() . "\n";
        }
    }
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
    exit(1);
}