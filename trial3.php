<?php
// FILE: trial3.php
// GOAL: To solve this puzzle

// START
$dbg         = FALSE;
$maximum     = 600851475143;
$tally       = 0;
$solution    = [];
$final_prime = 1;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach ($options as $option => $value) {
        switch ($option) {
            case 'd':
                $dbg = TRUE;
                break;

            case 'm':
                $maximum = $value;
                break;

            case 'h':
            default:
                echo 'HELP: ' . basename(__FILE__) . ' -d -h -m $max' . PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net' . PHP_EOL;
                echo 'PARM: -d indicates we are debugging' . PHP_EOL;
                echo '      -h redisplays this Help Screen' . PHP_EOL;
                echo '      -m sets the $max number of primes to identify.' . PHP_EOL;
                echo 'NOTE: This finds the largest prime factors of the Number ' .$maximum. PHP_EOL;
                echo 'CAVEAT: Runs best on UNIX with 64 bit integers.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Determine if a given value is a palindrome - i.e. reads same right to left
function is_prime($val = 1) {
    global $dbg;

    $prime = TRUE;
    $max   = sqrt($val);
    $ndx   = 2;

    if ($dbg) {
        echo 'Checking is_prime(' . $val . ')' . PHP_EOL;
    }

    while ($ndx <= $max) {
        if ($val % $ndx == 0) {
            $prime = FALSE;
            break;
        }
        else {
            $ndx++;
        }
    }

    return $prime;
}

//////////////////////////////////   MAIN   //////////////////////////////////

$total = 0;
$mult = 2;

$remain = $maximum;

echo PHP_EOL;
while (!in_array($remain, $solution) && (array_product($solution) != $maximum) && ($mult < $maximum / 2)) {
    if ($remain % $mult == 0) {
        if ($dbg) { echo '# Adding '.$mult.' to solution set'.PHP_EOL; }
        $solution[] = $mult;
    }
    $mult++;
}

echo PHP_EOL;
echo "PRIME FACTORS for ".$maximum.": ".print_r($solution, true).PHP_EOL;
exit(0);

