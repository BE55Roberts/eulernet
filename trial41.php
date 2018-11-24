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
$solution = false;
$ndx = 0;

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

/**
 * Check to be sure the $value is pan digital
 * A Pan Digital number uses all unique digits. This checks using array unique.
 * @param int $value for the number to check
 *
 * @return bool $is_it is TRUE if the number is pan digital, FALSE otherwise
 */
function is_pan_digital($value = 1) {
    global $dbg;
    $is_it = false;

    $digits = str_split($value, 1);
    if ($dbg) { echo '# '.$value.' SPLIT:'.implode(',', $digits).PHP_EOL; }

    $uniquely = array_unique($digits);
    if (count($digits) == count($uniquely)) {
        $is_it = true;
    }

    return $is_it;
}

/**
 * Is it a Pan Digital Prime
 * @param int $value is the number to check
 *
 * @return bool is TRUE if the number is a Prime, FALSE otherwise
 */
function is_pan_digital_prime($value = 1) {
    global $dbg;
    $yes_it_is = false;
    if (is_prime($value)) {
        $yes_it_is = true;
    }

    return $yes_it_is;
}


/**
 * Find the next sequential number in the series 1..N of length $length
 * @param int $previous is the previous number in the series
 * @param int $length is the length of the number within the range
 *
 * @return bool|int $next_number or FALSE if there are no more
 */
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
        $uniquely = array_unique($digits);
        if (count($digits) == count($uniquely)) {
            $not_pan_digital = false;
        } else {
            $next_number++;
        }
        if ($dbg) { echo '# OBSERVATION:'.($not_pan_digital ? 'T' : 'F').PHP_EOL; }

    } while ($next_number < $limit && $not_pan_digital);

    return $next_number > $previous ? $next_number : false;
}


/**
 * Generate the next permutation in a series
 * @param $p is the array to permute - e.g. {1, 2, 3, 4}
 * @param $size is the size of the array - e.g. 4
 *
 * @return array $p is the next sequence of elements from $p OR FALSE at end
 */
function generate_next_permutation($p, $size) {
    global $dbg;

    if ($dbg) { echo '# P:['.implode(', ', $p).'] of size '.$size.PHP_EOL;}

    // Slide down the array looking for where we're smaller than the next guy
    for ($i = $size - 1; ($i > 0) && ($p[$i] >= $p[$i+1]); --$i) { }

    // If this does not occur, then we have finished our permutations
    // and the array is reversed - e.g. (1, 2, 3, 4) => (4, 3, 2, 1)
    if ($i == -1) { return false; }

    // Slide down the array looking for a bigger number than what we found before
    for ($j = $size; ($j > 0) && ($p[$j] <= $p[$i]); --$j) { }

    // swap them
    $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;

    // Finally, reverse the elements in between by swapping the ends
    for (++$i, $j = $size; $i < $j; ++$i, --$j) {
        $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;
    }

    return $p;
}

/////////////////////////////   MAIN   /////////////////////////////
// $maximum = 9;

echo PHP_EOL;
$digits = range(0, $maximum -1 );
$ending_digits = array_reverse($digits);
$labels = range(1, $maximum);

// pc_permute($digits);
// generate_permute($digits, $resulted);
$resulted = [];
$ndx = 0;

// Cycle through all permutations
do {
    $resulted[$ndx] = '';
    foreach ($digits as $i) {
        $resulted[$ndx] .= $labels[$i];
    }

    $resulted[$ndx] = (int)$resulted[$ndx];
    if ($dbg) {
        echo 'Testing('.$resulted[$ndx] .') '.'for pan digital prime...'.PHP_EOL;
    }

    $panness = is_pan_digital($resulted[$ndx] );
    if ($panness) {
        if ($dbg) {
            echo '# Value '.$resulted[$ndx] .' is Pan Digital - checking primeness...'.PHP_EOL;
        }
        $solution_found = is_prime($resulted[$ndx] );
        if ($solution_found && $resulted[$ndx] > $solution) {
            $solution = $resulted[$ndx] ;
            if ($dbg) {
                echo '# Found a Solution ['.$resulted[$ndx] .'] is Pan Digital AND Prime'.PHP_EOL;
            }
        }
    }

    // Increment values and index
    $tally++;
    if ($show && ($tally % 10 == 0)) {echo '.';}

    $digits = generate_next_permutation($digits, $maximum - 1);
    if ($digits == $ending_digits) {
        $digits = false;
    }
} while ($digits && ++$ndx);



# Evaluate solution and display result
if ($show) {
    echo PHP_EOL;
}
if ($solution) {
    echo 'SOLUTION: ' . $solution . PHP_EOL;
} else {
    echo '*** NO SOLUTION FOUND ***'.PHP_EOL;
}

# Evaluate timing
$finished = microtime(true);
$elapsed = $finished - $starting;
if ($show) {
    echo 'TIMING: This job took '.$elapsed.' seconds to run '.$tally.' iterations.'.PHP_EOL;
}
exit(0);

