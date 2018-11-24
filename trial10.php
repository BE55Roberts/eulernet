<?php
// FILE: trial.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$maximum = 100;
$tally = 0;
$next_number = 1;
$total_prime = 0;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'm':
                $maximum = $value;
                break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -m $max'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of primes to identify.'.PHP_EOL;
                echo 'NOTE: This finds the Sum of the Prime Number less than $max.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Determine if a given value is a palindrome - i.e. reads same right to left
function is_prime($val = 1) {
    global $dbg;

    $prime = true;
    $lim = sqrt($val);
    $ndx = 2;

    if ($dbg) {
        echo 'Checking is_prime('.$val.')'.PHP_EOL;
    }

    while ( $ndx <= $lim) {
        if ($val % $ndx == 0) {
            $prime = false;
            break;
        } else {
            $ndx++;
        }
    }

    return $prime;
}

echo PHP_EOL;
$next_number = 5;
$tally_primes = 2;

if ($maximum > 2) { $tally_primes = 1; $total_prime = 2; }
if ($maximum > 3) { $tally_primes = 2; $total_prime = 5; }
// if ($maximum > 5) { $tally_primes = 3; $total_prime = 10; }
// if ($maximum > 7) { $tally_primes = 4; $total_prime = 17; }

while ($next_number < $maximum) {
    $to_check = $next_number;
    $tally++;

    if (is_prime($to_check) == true) {
        // To check is prime, so count it
        $total_prime += $to_check;
        $tally_primes++;
        if ($dbg) {
            echo 'Prime: '.$to_check.' is the '.$tally_primes.'th prime found'.PHP_EOL;
        }

    } else {
        // Value is NOT PRIME - show every 10th iteration
        if ($dbg && ($tally % 10 == 0)) {
            echo 'Value('.$to_check.') is NOT PRIME'.PHP_EOL;
        }
    }

    // Check next number in series of primes
    $to_check = $next_number + 2;

    if ($to_check >= $maximum) {
        break;
    }
    
    if (is_prime($to_check) == true) {
     $total_prime += $to_check;
     $tally_primes++;
        if ($dbg) {
            echo 'Prime: '.$to_check.' is the '.$tally_primes.'th prime found'.PHP_EOL;
        }
    } else {
        // Value is NOT PRIME - show every 10th iteration
        if ($dbg && ($tally % 10 == 0)) {
            echo 'Value('.$to_check.') is NOT PRIME'.PHP_EOL;
        }
    }

    // Jump by 6 to next pair of numbers to check
    $next_number += 6;
}

// Show the final prime solution
echo "Found ".$tally_primes." primes up to [".$maximum."] totalling: ". $total_prime.PHP_EOL;
exit(0);

