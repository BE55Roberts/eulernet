<?php
// FILE: trial24.php
// GOAL: To solve the Project Euler puzzle 24

// START
$dbg = false;
$started = microtime(true);
$show = false;
$maximum = 0;
$permutation = 0;
$tally = 0;
$number_set = [];
$solution = [];
$tactic = 'generator';

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:st:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'm':
                $maximum = (int)$value;
                break;

            case 'p':
                $permutation = (int)$value;
                break;

            case 's':
                $show = true;
                break;

            case 't':
                $tactic = strtolower($value);
                break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -m $max -p $which -s'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of digits 0..$max to use.'.PHP_EOL;
                echo '      $max should not be more than 9.'.PHP_EOL;
                echo '      -p sets which permutation to display - i.e. 1..10^$max.'.PHP_EOL;
                echo 'NOTE: This finds the $which permutation of the digits 0..$max'.PHP_EOL;
                exit(0);
                break;
        }
    }
}

// Generator for all permutations of the array $elements
function permutations(array $elements)
{
    if (count($elements) <= 1) {
        yield $elements;
    } else {
        foreach (permutations(array_slice($elements, 1)) as $permutation) {
            foreach (range(0, count($elements) - 1) as $i) {
                yield array_merge(
                    array_slice($permutation, 0, $i),
                    [$elements[0]],
                    array_slice($permutation, $i)
                );
            }
        }
    }
}

/**
 * Generate the next permutation of the array
 *
 * @param $digits is an array of values to manipulate
 * @param $sizer is the number of elements in $digits
 *
 * @return array|bool $digits after permutation or FALSE on reaching the end
 */
function generate_permutation($digits, $sizer) {
    // Slide down the array looking for the smaller value
    // WAS: for ($i = $sizer - 1; $digits[$i] >= $p[$i+1]; --$i) {
    for ($i = $sizer - 1; $i >= 0; --$i) {
        if (isset($digits[$i+1]) && $digits[$i] >= $digits[$i+1]) {
            break;
        }
    }

    // If this fails, then we have finished all of the permutations, so exit
    if ($i == -1) { return false; }

    // Else slide down the array looking for a bigger number to swap (if any)
// WAS:     for ($j=$sizer; $digits[$j] <= $digits[$i]; --$j) {
    for ($j=$sizer; $j > 0; --$j) {
        if (isset($digits[$j]) && $digits[$j] > $digits[$i]) {
            break;
        }
    }
//    echo '# '.__METHOD__.': sizer: '.$sizer.' digits{'.implode(',', $digits).'} I:'.$i.', J:'.$j.PHP_EOL; exit(0);


    // Now swap the array values to get the next permutation
    $tmp = $digits[$i]; $digits[$i] = $digits[$j]; $digits[$j] = $tmp;

    // Now reverse the elements in between by swapping ends
    for (++$i, $j = $sizer-1; $i < $j; ++$i, --$j) {
        $tmp = $digits[$i]; $digits[$i] = $digits[$j]; $digits[$j] = $tmp;
    }

    return $digits;
}

// MAIN //

echo PHP_EOL;
$tally = 1;
$digits = range(0, $maximum);

// Based on which tactic
switch($tactic) {
    case 'generator':
        // Use a generator function to create all of the permutations
        // CAVEAT: This runs out of memory on 10 digits
        foreach(permutations($digits) AS $next_array) {
            $number_set[] = $next_array;
            $tally++;
        }
        break;

    case 'iterator':
        $num_len = count($digits);
        $next_number = array_reverse($digits);
        $number_set[] = $next_number;

        while($next_number) {
            $next_number = generate_permutation($next_number, $num_len);
            if ($next_number) {
                $number_set[] = $next_number;
            } else {
                break;
            }
            $tally++;
        }
        break;

    default:
        foreach(permutations($digits) AS $next_array) {
            $number_set[] = $next_array;
            $tally++;
        }
        break;
}

// Sort the array
sort($number_set);

if ($dbg) {
    echo 'PERMUTATIONS: '.$maximum.' digits and selecting the '.$permutation.'th entry.'.PHP_EOL;
    print_r($number_set);
}

// Identify the solution
$solution = $number_set[$permutation-1];

// Show the final prime solution
echo "The ".$permutation."th PERMUTATION is: ". (is_array($solution) ? implode(', ',$solution) : $solution).PHP_EOL;

if ($show) {
    $finished = microtime(TRUE);
    $elapsed = $finished - $started;
    echo 'ANALYSIS: '.'After '.$tally.' iterations, the solution was ';
    echo (count($solution) > 0 ? 'FOUND' : 'NOT FOUND').PHP_EOL;
    echo 'RUN TIME: This took '.$elapsed.' seconds.'.PHP_EOL;
}
exit(0);

