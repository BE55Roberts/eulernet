<?php
// FILE: trial25.php
// GOAL: To solve the Project Euler puzzle 24

// START
$dbg = false;
$started = microtime(true);
$show = false;
$maximum = 2;
$size_limit = 10;
$tally = 1;
$solution = 'NOT FOUND';

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

            case 'l':
                $size_limit = (int)$value;
                break;

            case 's':
                $show = true;
                break;

            case 't':
                $tactic = strtolower($value);
                break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -m $max -l $size_limit -s'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of digits 0..$max to use.'.PHP_EOL;
                echo '      $max should not be more than 9.'.PHP_EOL;
                echo '      -l sets the $size_limit for the solution.'.PHP_EOL;
                echo 'NOTE: This finds index of the Fibonacci series of $size_limit size'.PHP_EOL;
                exit(0);
                break;
        }
    }
}

// Calculate the next Fibonacci series value as a string
function bc_fibonacci($number)
{
    global $dbg;

    $fib1 = '1';
    $fib2 = '1';
    $counter = 2;

    if ($number == '0') {
        return '0';
    }
    if ($number == '1') {
        return '1';
    }
    if ($number == '2') {
        return '1';
    }

    // Count up to the next fibonacci value
    while($counter < $number) {
        $fib3 = bcadd($fib1, $fib2);
        $fib1 = $fib2;
        $fib2 = $fib3;

        $counter++;
    }

    return $fib3;
}


// MAIN //
if ($dbg) {
    echo 'Finding Fibonacci Series with size of: '.$size_limit.' digits or maximum '.$maximum.' value.'.PHP_EOL;
}

// Identify the solution
$next_value = '1';
$ndx = 1;

while (strlen($next_value) < $size_limit) {
    $next_value = bc_fibonacci($ndx);
    if (strlen($next_value) == $size_limit) {
        break;
    }
    if ($dbg) {
       echo '# Next Value has : '.strlen($next_value).' digits at index: '.$ndx.'->'.$next_value.PHP_EOL;
    }

    $ndx++;
    $tally++;
}

$solution = $next_value;

// Show the final prime solution
echo "SOLUTION: ".$ndx."th FIBONACCI value has ".$size_limit." digits: ". $next_value.PHP_EOL;

if ($show) {
    $finished = microtime(TRUE);
    $elapsed = $finished - $started;
    echo 'ANALYSIS: '.'After '.$tally.' iterations, the solution was '.PHP_EOL;
    echo $next_value.PHP_EOL;
    echo 'RUN TIME: This took '.$elapsed.' seconds.'.PHP_EOL;
}
exit(0);

