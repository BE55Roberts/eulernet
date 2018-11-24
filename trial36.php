<?php
// FILE: trial36.php
// GOAL: To solve this puzzle

/*
 * The decimal number, 585 = 10010010012 (binary), is palindromic in both bases.

Find the sum of all numbers, less than one million, which are palindromic in base 10 and base 2.

(Please note that the palindromic number, in either base, may not include leading zeros.)
 */
// START
$dbg = false;
$maximum = 10;
$need_help = false;
$grand_total = 0;
$show_ticks = false;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:st:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'm':
                $maximum = $value;
                break;

            case 's':
                $show_ticks = true;
                break;

            case 'h':
            default:
                $need_help = true;
                break;
        }
    }
}

// Provide Help
function show_help() {
    echo 'HELP: '.basename(__FILE__).' -d -h -m $max'.PHP_EOL;
    echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
    echo 'PARM: -d indicates we are debugging'.PHP_EOL;
    echo '      -h redisplays this Help Screen'.PHP_EOL;
    echo '      -m sets the $max value for the calculation.'.PHP_EOL;
    echo '      -s shows tick marks every 100 trials.'.PHP_EOL;
    echo 'PROB: The goal is to find the sum of all numbers up to $max'.PHP_EOL;
    echo '      that are Palindromes in BOTH base 10 and base 2.'.PHP_EOL;
}

/**
 * Check for a Palindrome - digits are mirrored about the center
 * @param string $val is a string as a number in some base
 *
 * @return bool TRUE if the value is a palindrome, FALSE otherwise
 */
function is_palindrome($val = '') {
    global $dbg;

    // RULE: Single digit numbers are treated as palindromes
    if (strlen($val) == 1) {
        return true;
    }

    $reversed = strrev($val);
    $pal = false;
    $length = floor(strlen($val) / 2);
    $ndx = 0;

    if ($dbg) {
        echo '# Check is_palindrome('.$val.' <=> '.$reversed.') for '.$length.' digits'.PHP_EOL;
    }

    for ($ndx = 0; $ndx < $length; $ndx++) {
        if (substr($val, $ndx, 1) == substr($reversed, $ndx, 1)) {
            $pal = true;
        } else {
            $pal = false;
            break;
        }
    }

    return $pal;
}



// MAIN
if ($need_help) {
    show_help();
    exit(0);
}
echo PHP_EOL;
$first = 1;
$ndx = $first;

while ($ndx < $maximum) {
    if ($dbg) {
        echo 'Checking ('.$ndx.') for being a Palindrome in Base 2, 10.'.PHP_EOL;
    }

    $palin10 = (string)$ndx;
    $palin2 = (string)decbin($ndx);
    if ($dbg) {
        echo '# BASE10: ['.$palin10.'], BASE2: ['.$palin2.']'.PHP_EOL;
    }

    // Filter out leading zeroes
    $palin2 = ltrim($palin2, '0');

    // Check for palindrome
    $both_are = true;
    if (is_palindrome($palin10)) {
        if ($dbg) {
            echo '--> BASE10 Palindrome: ['.$palin10.']'.PHP_EOL;
        }

        if (is_palindrome($palin2)) {
            if ($dbg) {
                echo '--> BASE2 Palindrome: ['.$palin2.']'.PHP_EOL;
            }

            if ($show_ticks) {
                echo '-->['.$palin10.'] <=> '.$palin2.PHP_EOL;
            }
            $grand_total += $ndx;
        }
    }

    if ($show_ticks && ($ndx % 100 == 0)) {
        echo '.';
    }
    $ndx++;
}

echo PHP_EOL."TOTAL PALINDROMEs thru ".$maximum." is: [".$grand_total.'] for '.$first.' => '.$maximum.PHP_EOL;
exit(0);

