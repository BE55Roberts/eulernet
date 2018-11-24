<?php
// FILE: trial40.php
// GOAL: To solve this puzzle

/*
 * URL: https://projecteuler.net/problem=40
 *
 * An irrational decimal fraction is created by concatenating the positive integers [as a decimal faction]:

0.123456789101112131415161718192021...
-------------^
It can be seen that the 12th digit of the fractional part is 1.

If dn represents the nth digit of the fractional part, find the value of the following expression.

d1 × d10 × d100 × d1000 × d10000 × d100000 × d1000000

Wikipedia Definition: Champernowne's constant
URL: https://en.wikipedia.org/wiki/Champernowne_constant
For base 10, the number is defined by concatenating representations of successive integers together:

C10 = 0.12345678910111213141516…  (sequence A033307 in the OEIS).
Solution is:

*/

// START
$dbg          = FALSE;
$maximum      = 6; // i.e. Maximum number of digits to produce - i.e. up to d[1000000]
$need_help    = FALSE;
$grand_total  = 0;
$show_ticks   = FALSE;
$show_answers = FALSE;
$solutions    = [0 => []];

// HELP:
if ($argc > 1) {

    $options = getopt("ab:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:st:u:v:w:x:y:z:");

    foreach ($options as $option => $value) {
        switch ($option) {
            case 'd': // Always start with Debug
                $dbg = TRUE;
                break;

            case 'a':
                $show_answers = TRUE;
                break;

            case 'm':
                $maximum = (int)$value;
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
    echo 'PROB: The goal is to find the value p out of all integer right triangles' . PHP_EOL;
    echo '      such that we produce the highest number of tuples {a,b,c}' . PHP_EOL;
    echo '      where p <= $max AND p = a + b + c AND a <= b < c AND' . PHP_EOL;
    echo '      p has the highest number of solutions.' . PHP_EOL;
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
    $as_a_string = (string) $val;

    if (is_prime($as_a_string) === FALSE) {
        return FALSE;
    }

    if (strlen($val) == 1) {
        if (in_array($val, [2, 3, 5, 7])) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    // Check left
    $truncated_left = substr($as_a_string, 1);
    $matched        = matches_criteria($truncated_left);
    if ($matched === FALSE) {
        return $matched;
    }

    // Check right
    $truncated_left = substr($as_a_string, 0, -1);
    $matched        = matches_criteria($truncated_left);
    if ($matched === FALSE) {
        return $matched;
    }

    return $matched;
}

/**
 * Find the solution for a given argument
 *
 * @param int $p is the perimeter value to inspect
 */
function find_solutions($p = 1) {
    global $dbg;
    $tuples = [];
    $half   = floor($p / 2);
    if ($dbg) {
        echo '# Checking p(' . $p . ') for tuple solutions...' . PHP_EOL;
    }
    for ($a = 0; $a < $half; $a++) {
        for ($b = 0; $b < $half; $b++) {
            $c = sqrt($a * $a + $b * $b);
            if (($p == $a + $b + $c) && ($c == floor($c))) {
                $tuples[] = [$a, $b, $c];
            }
        }
    }

    return $tuples;
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
        echo 'Checking (' . $ndx . ') for a solution.' . PHP_EOL;
    }

    // Generate a solution for $maximum digits
    $solutions[$ndx] = find_solutions($ndx);

    if ($show_ticks && ($tally % 10 == 0)) {
        echo '.';
        $tally = 0;
    }

    // Bump the index by 1 until we hit the maximum (inclusively)
    $ndx++;
    $tally++;
}

// Identify the best solution
$solution = 0;
for ($i = $first; $i <= $maximum; $i++) {
    if (count($solutions[$i]) > $solution) {
        $solution = $i;
    }
}
// Summarize
if ($show_ticks || $dbg) {
    echo PHP_EOL; // Start a new line
}
echo 'SOLUTION: ' . 'Using p of [' . $solution . '] produces the maximum [' . count($solutions[$solution]) . '] tuples.' . PHP_EOL;
if ($dbg) {
    echo '# SOLUTION DETAILS: ' . print_r($solutions[$solution], true) . '' . PHP_EOL;
}
exit(0);

