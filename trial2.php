<?php
// FILE: trial.php
// GOAL: To solve this puzzle

echo 'Solving Fibonacci problem up to 1000'.PHP_EOL;

$lim = isset($argv[1]) ? $argv[1] : 1000;

$total = 0;

$first = 0;
$second = 1;
$sum = 1;

echo PHP_EOL;
while ($sum < $lim) {
    $first = $second;
    $second = $sum;
    $sum = $first + $second;
    if ($sum % 2 == 0) {
        $total += $sum;
        echo $sum.', ';
    }
}

echo PHP_EOL;
echo "SUM LT ".$lim.": ".$total.PHP_EOL;
exit(0);

