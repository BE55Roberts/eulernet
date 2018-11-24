<?php
// FILE: trial20.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$starting = microtime(true);
$tally = 0;
$count = 0;
$factor = '1';
$digits = 0;
$final_sum = 0;
$x = '1';

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

           case 'x': // Set x value
                 $x = $value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -n $min -m $max -w $DOW -x $DOM'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -x sets the $X value to count.'.PHP_EOL;
                echo 'NOTE: This counts the digits in $X!'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Process the value
if ($dbg) {
    echo 'Finding digits in '.$x.'!.'.PHP_EOL;
}


// Factorial using recursion
function fact($val) {
    global $dbg, $tally;

    if ($dbg) {
        echo '# Calc fact('.$val.')'.PHP_EOL;
    }
    $tally++;

    if ($val == '1') {
        $result = '1';
    } else {
        // Recurse
        $less = bcsub($val, '1');
        $result = bcmul($val, fact($less));
    }

    return $result;
}


// Calculate the X! value
$factor = fact($x);
$digits = strlen($factor);

for($i=0; $i<$digits; $i++) {
    $final_sum += (int)substr($factor, $i, 1);
}

echo "RESULT: ".$final_sum.' is the sum of '.$x." factorial, ".$digits." digits:".PHP_EOL;
echo '        '. $factor.' with '.$digits.' digits.'.PHP_EOL;

// Show elapsed time
$finishing = microtime(true);
$elapsed = $finishing - $starting;
echo 'ANALYSIS: Checked '.$tally.' dates in '.$elapsed.' seconds.'.PHP_EOL;
exit(0);
