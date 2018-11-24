<?php
// FILE: trial14.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$starting = microtime(true);
$show = false;

$starting_value = 1;
$tally = 0;
$count = 0;
$sequence = false;
$iteration = 1;
$max_solution = 1;
$max_sequence = false;
$max_length = 1;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 's': // Set starting value for the sequence
                 $starting_value = $value;
                 break;

            case 'v':
                $show = true;
                break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -f $data -h -s $starting -v'.PHP_EOL;
                echo 'GOAL: To solve puzzle 14 at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -s sets the $starting to start with (<1M).'.PHP_EOL;
                echo '      -v turn on $show flag (periods every 100 cycles).'.PHP_EOL;
                echo 'NOTE: This finds the number with the Longest Collatz'.PHP_EOL;
                echo '      sequence - e.g. 13->40->20->10->5->16->8->4->2->1.'.PHP_EOL;
                echo 'SOLV: Collatz seq for 837799 is 525 numbers long.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}

// Find the next number in the Collatz Sequence 
// This set of iterations should always end with 1
function collatz($val = 1) {
    if ($val == 1) {
        return $val;
    }

    if ($val % 2 == 0) {
        // Even case
        $result = $val / 2;
    } else {
        // Odd case
        $result = 3 * $val + 1;
    }

    return $result;
}

// Get next sequence for a given value
function generate_collatz($val = 1) {
    // Initialize
    $iteration = $val;
    $sequence = [$val];

    while ($iteration != 1) {
        $next_value = collatz($iteration);
        $sequence[] = $next_value;
        if ($next_value == 1) {
            break;
        } else {
            $iteration = $next_value;
        }
    }

    return $sequence;
}

// Show the maximum numbers
if ($dbg) {
    echo 'Starting with ['.$starting.']'.PHP_EOL;
}

// Initialize
$counter = $starting_value;

while ($counter > 1 && $tally < 1000000) {
    // Generate the next sequence
    $sequence = generate_collatz($counter);
    if ($dbg) {
        echo 'Found seq ['.$counter.'] '.implode('.',$sequence).PHP_EOL;
    }
    if (count($sequence) > $max_length) {
        $max_solution = $counter;
        $max_sequence = $sequence;
        $max_length = count($sequence);
    }

    if ($show) { echo '.'; }
    $counter--;
    $tally++;
}

// Assess time spent
$finishing = microtime(true);
$elapsed = $finishing - $starting;

if ($dbg) {
    // Show analysis
    if ($max_sequence) {
        echo 'SOLVED: '.$max_solution.' resulted in a '.$max_length.' sequence:'.PHP_EOL;
        echo '    '.implode('->', $max_sequence).PHP_EOL;
    } else {
        echo 'FAILED to find solution for all numbers under ['.$starting_value.'].'.PHP_EOL;
    }
}

if ($show || $dbg) {
    echo '# EXECUTION: '.$elapsed.' seconds to run '.$tally.' collatz generations.'.PHP_EOL;
}

// Show the final prime solution
echo "The Longest Collatz Sequence for ".$starting_value.' is :'.$max_solution.' len '.$max_length.PHP_EOL;
exit(0);

