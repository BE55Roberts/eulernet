<?php
// FILE: trial1.php
// GOAL: To solve this puzzle
$dbg          = FALSE;
$maximum      = 1000; // i.e. Maximum number of digits to produce - i.e. up to d[1000000]
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
                $maximum = (int) $value;
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
    echo '      -a shows the answers as we go' . PHP_EOL;
    echo '      -h redisplays this Help Screen' . PHP_EOL;
    echo '      -m sets the $max value (e.g. 1000)for the computation.' . PHP_EOL;
    echo '      -s shows tick marks every 100 trials.' . PHP_EOL;
    echo 'PROB: If we list all the natural numbers below 10 that are multiples of 3 or 5,' . PHP_EOL;
    echo '      then we get 3, 5, 6 and 9. The sum of these multiples is 23.' . PHP_EOL;
    echo 'TASK: Find the sum of all the multiples of 3 or 5 below 1000.' . PHP_EOL;
}


// MAIN
if ($need_help) {
    show_help();
    exit(0);
}

//////////////////////////////////   MAIN   //////////////////////////////////
echo 'Solving 3x5 problem for up to ' . $maximum . '.' . PHP_EOL;

$total = 0;

$ndx = 1;
echo PHP_EOL;
do {
    $val = 3 * $ndx;
    if ($val < $maximum) {
        echo $val . ', ';
        $total += $val;
    }

    $ndx++;
} while ($val < $maximum);

$ndx = 1;
echo PHP_EOL;
do {
    $val = 5 * $ndx;
    if ($val < $maximum && ($val % 3 != 0)) {
        echo $val . ', ';
        $total += $val;
    }

    $ndx++;
} while ($val < $maximum);

echo PHP_EOL;
echo "SUM: " . $total . PHP_EOL;
exit(0);

