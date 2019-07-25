<?php
require __DIR__ . '/core/autoloader.php';

use \models\Calc;
use \models\exceptions\CalcException;
use \models\VariableStorage;

$handle = fopen ("php://stdin","r");
?>
Calc

To exit type 'exit' (or ^C)
You may use known constants: P (π ~ 3.14)
                             E (e ~ 2.7)
You can save result using syntax:
var = <expression>
<?php
$vars = [];
while (1) {
    $input = trim(fgets($handle));
    if ($input == 'exit') break;

    @list($var, $exp) = explode('=', $input);
    if (!$exp) {
        $exp = $var;
        $var = null;
    }
    try {
        $res = (new Calc($exp, $vars))->result();
        if ($var) $vars[$var] = $res;

        echo ($var ? "$var = " : '') . "$res\n";
    } catch (CalcException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

fclose($handle);
echo "\n";
echo "Bye...\n";
