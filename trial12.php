<?php
// FILE: trial12.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$maximum = 10;
$tally = 0;
$count = 0;
$divisors = [];
$first_to_check = 1;
$final_prime = 1;
$triangular = 1;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'f': // Set first number to check
                $first_to_check = (int)$value;
                break;

            case 'm': // Set max divisors to look for
                 $maximum = (int)$value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -f $first -h -m $max'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -f sets the $first number to check.'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of divisors to identify.'.PHP_EOL;
                echo 'NOTE: This finds the Nth Triangular Number w/$max divisors'.PHP_EOL;
                echo '      Triangular numbers are the sum of 1..N.'.PHP_EOL;
                echo '      This job finds all of the integral divisors up to $max.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Get the Greatest Common Denominator
function gcd($a, $b) {
    return $b ? gcd($b, $a % $b) : $a;
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

// Find the integers that divide evenly into a value
function find_divisors($val = 1) {
    $result = [1];

    for($i=2; $i<=$val; $i++) {
        if ($val % $i == 0) {
            $result[] = $i;
        }
    }

    return $result;
}


// Find the triangular sum of a particular number N - i.e. SUM(1..N)
function find_triangular_sum($val = 1) {
    $result = 0;

    for($ndx = 1; $ndx <= $val ; $ndx++) {
        $result += $ndx;
    }
    
    return $result;

}

echo PHP_EOL;
$to_check = $first_to_check;
$max_tally = 1000000;
if ($dbg) {
    echo 'Running triangular number through('.$maximum.')'.PHP_EOL;
}


// Find the Triangular numbers
while ($tally < $max_tally) {
    $triangular = find_triangular_sum($to_check);
    if ($dbg) {
        echo 'Triangular('.$to_check.') = '.$triangular.PHP_EOL;
    }

    $divisors = find_divisors($triangular);
    if ($dbg) {
        echo 'Divisors('.$triangular.') = '.implode(', ',$divisors).PHP_EOL;
    }
    if (count($divisors) == $maximum) {
        break;
    }

    $tally++;

    $to_check++;

    if ($tally % 100 == 0) {echo '.';}
}

// Show the final prime solution
echo "The First Triangular Number with ".$maximum." factors is: ". $triangular.PHP_EOL;
exit(0);

