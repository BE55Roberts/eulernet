<?php

echo 'Solving 3x5 problem for up to 1000'.PHP_EOL;

$lim = isset($argv[1]) ? $argv[1] : 1000;

$total = 0;

$ndx = 1;
echo PHP_EOL;
do {
    $val = 3 * $ndx;
    if ($val < $lim) {
        echo $val.', ';
        $total += $val;
    }

    $ndx++;
} while ($val < $lim);

$ndx = 1;
echo PHP_EOL;
do {
    $val = 5 * $ndx;
    if ($val < $lim && ($val %3 != 0)) {
        echo $val.', ';
        $total += $val;
    }

    $ndx++;
} while ($val < $lim);

echo PHP_EOL;
echo "SUM: ".$total.PHP_EOL;
exit(0);

