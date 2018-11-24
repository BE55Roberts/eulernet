<?php
// FILE: trial37.php
// GOAL: To solve this puzzle

/*
The number 3797 has an interesting property. Being prime itself, it is possible to continuously remove digits from left to right, and remain prime at each stage: 3797, 797, 97, and 7. Similarly we can work from right to left: 3797, 379, 37, and 3.

Find the sum of the only eleven primes that are both truncatable from left to right and right to left.

NOTE: 2, 3, 5, and 7 are not considered to be truncatable primes.

LIST: 2, 3, 5, 7, 23, 37, 53, 73, 313, 317, 373, 797, 3137, 3797, 739397
URL: https://en.wikipedia.org/wiki/Truncatable_prime
*/

// START
$dbg         = FALSE;
$maximum     = 800000;
$need_help   = FALSE;
$grand_total = 0;
$show_ticks  = FALSE;
$show_answers = FALSE;


// HELP:
if ($argc > 1) {

    $options = getopt("ab:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:st:u:v:w:x:y:z:");

    foreach ($options as $option => $value) {
        switch ($option) {
            case 'd': // Always start with Debug
                $dbg = TRUE;
                break;

            case 'a':
                $show_answers = true;
                break;

            case 'm':
                $maximum = $value;
                break;

            case 's':
                $show_ticks = TRUE;
                break;

            case 'h':
            default:
                $need_help = TRUE;
                break;
        }
    }
}

// Provide Help
function show_help() {
    echo 'HELP: ' . basename(__FILE__) . ' -d -h -m $max' . PHP_EOL;
    echo 'GOAL: To solve this puzzle at projecteuler.net' . PHP_EOL;
    echo 'PARM: -d indicates we are debugging' . PHP_EOL;
    echo '      -h redisplays this Help Screen' . PHP_EOL;
    echo '      -m sets the $max value (inclusive)for the computation.' . PHP_EOL;
    echo '      -s shows tick marks every 100 trials.' . PHP_EOL;
    echo 'PROB: The goal is to find the sum of all primes up to $max' . PHP_EOL;
    echo '      that are truncatable primes - i.e. truncating digits' . PHP_EOL;
    echo '      from either the LEFT or RIGHT result in numbers that ' . PHP_EOL;
    echo '      are themselves PRIME NUMBERS.' . PHP_EOL;
}

/**
 * Tests a value for primality
 * The value is PRIME if it can only be evenly divided by 1 and itself.
 * Otherwise, the number is a composite of at least 2 other prime numbers.
 * The largest known prime number is a Mersenne Prime containing 23,249,425 decimal digits.
 *
 * @param int $val is the Natural Number (i.e. positive integer) to test
 *
 * @return bool TRUE if the value is a PRIME NUMBER, FALSE otherwise
 */
function is_prime($val = 1) {
    global $dbg;
    $ruling = FALSE;

    // Gatekeepers: Not a Number, 1 or less, Evenly divisible
    if (!is_numeric($val)) {
        return $ruling;
    }
    if ($val <= 1) {
        return $ruling;
    }

    if ($val % 2 === 0) {
        return $ruling;
    }

    // Check all remaining odd numbers
    // TODO: Make this more efficient
    for ($i = 3; $i < $val; $i += 2) {
        if ($val % $i === 0) {
            return FALSE;
        }
    }

    return TRUE;
}


/**
 * Check for a Palindrome - digits are mirrored about the center
 *
 * @param string $val is a string as a number in some base
 *
 * @return bool TRUE if the value is a palindrome, FALSE otherwise
 */
function is_palindrome($val = '') {
    global $dbg;

    // RULE: Single digit numbers are treated as palindromes
    if (strlen($val) == 1) {
        return TRUE;
    }

    $reversed = strrev($val);
    $pal      = FALSE;
    $length   = floor(strlen($val) / 2);
    $ndx      = 0;

    if ($dbg) {
        echo '# Check is_palindrome(' . $val . ' <=> ' . $reversed . ') for ' . $length . ' digits' . PHP_EOL;
    }

    for ($ndx = 0; $ndx < $length; $ndx++) {
        if (substr($val, $ndx, 1) == substr($reversed, $ndx, 1)) {
            $pal = TRUE;
        }
        else {
            $pal = FALSE;
            break;
        }
    }

    return $pal;
}

/**
 * Check the given criteria to see if the value matches.
 * This is a recursive function
 *
 * @param bool $val
 *
 * @return bool $matched is TRUE if the criteria is matched, FALSE otherwise
 */
function matches_criteria($val = FALSE) {
    $matched     = TRUE;
    $as_a_string = (string)$val;

    if (is_prime($as_a_string) === FALSE) {
        return FALSE;
    }

    if (strlen($val) == 1) {
        if (in_array($val, [2,3,5,7])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // Check left
    $truncated_left = substr($as_a_string, 1);
    $matched = matches_criteria($truncated_left);
    if ($matched === FALSE) {
        return $matched;
    }

    // Check right
    $truncated_left = substr($as_a_string, 0, -1);
    $matched = matches_criteria($truncated_left);
    if ($matched === FALSE) {
        return $matched;
    }

    return $matched;
}

// MAIN
if ($need_help) {
    show_help();
    exit(0);
}
echo PHP_EOL;
$first = 1;
$ndx   = $first;
$tally = 0;

while ($ndx <= $maximum) {
    if ($dbg) {
        echo 'Checking (' . $ndx . ') against criteria.' . PHP_EOL;
    }

    // Skip all values ending in '5', since the can not be prime numbers
    if ($ndx % 5 !== 0) {
        // Check to see if the index value matches the criteria
        if (matches_criteria($ndx) == TRUE) {
            $grand_total += $ndx;
            if ($dbg) {
                echo PHP_EOL.$ndx.'--> Is a TRUNCATABLE PRIME.' . PHP_EOL;
            }
            if ($show_answers) {
                echo PHP_EOL.$ndx.' IS a TRUNCATABLE PRIME.' . PHP_EOL;
            }
        }
    }

    if ($show_ticks && ($tally % 100 == 0)) {
        echo '.';
        $tally = 0;
    }

    // Bump the index by 2 until we hit the maximum
    $ndx += 2;
    $tally++;
}

// Summarize
if ($show_ticks || $dbg) {
    echo PHP_EOL; // Start a new line
}
echo 'SOLUTION: '.'SUM is ['.$grand_total.'] for numbers 1..'.$maximum.PHP_EOL;
exit(0);

