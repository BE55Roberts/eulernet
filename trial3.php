<?php
// FILE: trial.php
// GOAL: To solve this puzzle

$lim = isset($argv[1]) ? $argv[1] : 600851475143;

$total = 0;
$mult = 2;

$primes = [];
$remain = $lim;

echo PHP_EOL;
while (!in_array($remain, $primes) && array_product($primes) != $lim && $mult < $lim / 2) {
    if ($remain % $mult == 0) {
        $primes[] = $mult;
    }
    $mult++;
}

echo PHP_EOL;
echo "PRIME FACTORS for ".$lim.": ".print_r($primes, true).PHP_EOL;
exit(0);

