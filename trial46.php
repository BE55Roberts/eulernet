<?php
// FILE: trial46.php
// GOAL: To solve this puzzle

// START
$dbg         = FALSE;
$maximum     = 10001;
$tally       = 0;
$solution    = ['first' => 0, 'second' => 0, 'product' => 0];
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
                echo 'NOTE: Christian Goldbach proposed that every odd composite number' . PHP_EOL;
                echo '      can be written as the sum of a prime and twice a square - e.g.' . PHP_EOL;
                echo '           9 = 7 + 2×1^2' . PHP_EOL;
                echo '          15 = 7 + 2×2^2' . PHP_EOL;
                echo '          21 = 3 + 2×3^2' . PHP_EOL;
                echo '          25 = 7 + 2×3^2' . PHP_EOL;
                echo '          27 = 19 + 2×2^2' . PHP_EOL;
                echo '          33 = 31 + 2×1^2' . PHP_EOL;
                echo 'However, it turns out that the conjecture was false.' . PHP_EOL;
                echo 'TASK: Find the smallest odd composite that cannot be written as the sum of a prime and twice a square.' . PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Determine if a given value is a prime number - i.e. divisible only by 1 and itself
function is_prime($val = 1) {
    global $dbg;

    $prime = TRUE;
    $lim   = sqrt($val);
    $ndx   = 2;

    if ($dbg) {
        echo 'Checking is_prime(' . $val . ')' . PHP_EOL;
    }

    while ($ndx <= $lim) {
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

/**
 * Check to see if a given value is a composite number
 * A composite number is a positive integer that can be formed by multiplying two smaller positive integers.
 *
 * @param int $val is the number to check
 *
 * @return bool $composite is TRUE if the number is a composite, FALSE otherwise
 */
function is_composite($val = 2) {
    global $dbg;

    $composite = FALSE;
    $factor1   = 2;
    $factor2   = $val / 2;
    $lim       = $factor2 + 1;

    do {
        if ($val = $factor1 * $factor2) {
            $composite = TRUE;
        } else {
            $factor1++;
            $factor2 = $val / $factor1;
        }

    } while ($composite == FALSE && $factor1 < $lim);

    return $composite;
}

/**
 * Check the value to see if it is NOT the sum of a PRIME and TWICE A SQUARE
 *
 * @param int $val is the value to check
 *
 * @return bool $result is TRUE if the value is NOT prime and SQUARE, FALSE otherwise
 */
function is_not_prime_and_square($val = 2) {
    global $primes, $dbg;

    $result = FALSE;

    // Find solution
    $remainder = $val;
    if ($dbg) {
        echo '# Check NOT PRIME: ' . $remainder. PHP_EOL;
    }
    foreach ($primes AS $prime) {
        $remainder = $val - $prime;
        if ((sqrt($remainder) / 2 % 2) == 0) {
            $result = TRUE;
            break;
        }
    }
    return $result;
}

//////////////////////////////////   MAIN   //////////////////////////////////
echo PHP_EOL;
$first     = 1;
$to_check  = 5;
$candidate = 2;
$primes    = [2, 3, 5, 7];

// Find all prime numbers up to $maximum
for ($ndx = 9; $ndx <= $maximum; $ndx += 2) {
    if (is_prime($ndx)) {
        $primes[] = $ndx;
    }
}

// Scan for all candidates
while ($candidate < $maximum) {
    if ($dbg) {
        echo '# Candidate: ' . $candidate . ':' . PHP_EOL;
    }

    if (is_composite($candidate) == FALSE) {
        // Not a composite, so we skip it
        if ($dbg) {
            echo '# -> Not a Candidate: ' . PHP_EOL;
        }

        $candidate += 2;
        continue;
    }

    // Candidate is a composite, so factor it
    $not_prime_and_square = is_not_prime_and_square($candidate);
    if ($not_prime_and_square) {
        $solution = $candidate;
        break;
    }
    $candidate += 2;
}

// Show the final prime solution
// TODO: Find a solution
echo 'WIP'.PHP_EOL;
// echo "The smallest odd composite that fails is " . $solution . " for the range 1.." . $maximum . PHP_EOL;
exit(0);

