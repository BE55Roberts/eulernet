<?php
// FILE: trial41.php
// GOAL: To solve the Project Euler Puzzle 41

// START
$dbg = false;
$show = false;
$starting = microtime(true);
$first_to_check = 2;
$maximum = 9;
$tally = 0;
$count = 0;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:st:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'n': // Set first number to check
                 $first_to_check = (int)$value;
                 break;

            case 'm': // Set max digits to check - i.e. 1..9
                 $maximum = (int)$value;
                 break;

            case 's':
                $show = true;
                break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -n $min -m $max -s'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -f set $first_to_check number'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -n sets the $min number to check.'.PHP_EOL;
                echo '      -m sets the $max number of digits to check (1..9).'.PHP_EOL;
                echo '      -s shows all steps involved.'.PHP_EOL;
                echo 'NOTE: This finds the Largest N-Digit Pandigital Prime Number'.PHP_EOL;
                echo '      A Pandigital Prime is one that uses all of the digits'.PHP_EOL;
                echo '      1..N exactly once.'.PHP_EOL;
                echo 'EG:   N is Single Digit limit for the result.'.PHP_EOL;
                echo '      2143 is the 4-Digit pandigital that is also prime.'.PHP_EOL;
                echo '      So there are only 10 of these available.'.PHP_EOL;
                echo 'CAVEAT: Be sure to check for Prime Ness.'.PHP_EOL;
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
    global $dbg;
    $result = [1];

    for($i=2; $i<$val; $i++) {
        if ($val % $i == 0) {
            $result[] = $i;
        }
    }

    return $result;
}


// Find the triangular sum of a particular number N - i.e. SUM(1..N)
function find_triangular_sum($val = 1) {
    global $dbg;
    $result = 0;

    for($ndx = 1; $ndx <= $val ; $ndx++) {
        $result += $ndx;
    }
    
    return $result;

}

// Is it a Pan Digital Prime
function is_pan_digital_prime($value = 1) {
    global $dbg;
    $yes_it_is = false;
    if (is_prime($value)) {
        $yes_it_is = true;
    }

    return $yes_it_is;
}


// Find next number to test
function find_next_number($previous = 1, $length = 9) {
    global $dbg;
    $not_pan_digital = true;
    $limit = 10 ** $length - 1;
    $next_number = $previous + 1;
    if ($dbg) { echo '# '.__METHOD__.'('.$previous.', '.$length.') for '.$next_number.'->'.$limit.PHP_EOL; }

    do {
        $digits = str_split($next_number, 1);
        if ($dbg) { echo '# '.$next_number.' SPLIT:'.implode(',', $digits).PHP_EOL; }

        sort($digits);
        if (count($digits) == count(array_unique($digits))) {
            $not_pan_digital = false;
        }
        if ($dbg) { echo '# OBSERVATION:'.($not_pan_digital ? 'T' : 'F').PHP_EOL; }
        $next_number++; 

    } while ($next_number < $limit && $not_pan_digital);

    return $next_number > $previous ? $next_number : false;
}



/////////////////////////////   MAIN   /////////////////////////////
// $starting = microtime(true);
// $first_to_check = 2;
// $maximum = 10;


echo PHP_EOL;
$to_check = 10**($maximum-1);
$last_to_check = 10**$maximum - 1;
$solution = false;

if ($dbg) {
    echo 'Running amicable numbers '.$first_to_check.' through('.$maximum.')'.PHP_EOL;
}


// Find the Abundant numbers
while ($to_check < $last_to_check && !$solution) {
    if ($dbg) {
        echo 'Testing('.$to_check.') '.'for pan digital prime...'.PHP_EOL;
    }

    $solution_found = is_pan_digital_prime($to_check);
    if ($solution_found) {
        $solution = $to_check;
    } else {
        $to_check = find_next_number($to_check, $maximum);
    }

    // Increment values
    $tally++;

    if ($tally % 100 == 0) {echo '.';}
}




# Evaluate timing
$finished = microtime(true);
$elapsed = $finished - $starting;
echo 'TIMING: This job took '.$elapsed.' seconds to run'.$tally.' iterations.'.PHP_EOL;
exit(0);

