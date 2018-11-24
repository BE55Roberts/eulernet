<?php
// FILE: trial2.php
// GOAL: To solve this puzzle

$dbg          = FALSE;
$maximum      = 4000000; // i.e. Maximum number of digits to produce - i.e. up to d[1000000]
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
    echo 'PROB: Find the sum of the even valued terms in the Fibonacci' . PHP_EOL;
    echo '      series up to $max - e.g. 4000000.' . PHP_EOL;
}


// MAIN
if ($need_help) {
    show_help();
    exit(0);
}

//////////////////////////////////   MAIN   //////////////////////////////////

echo 'Finding the sum of EVEN Fibonacci numbers less than ' . $maximum . '.' . PHP_EOL;

$total = 0;

$first  = 0;
$second = 1;
$sum    = 1;

echo PHP_EOL;
while ($sum < $maximum) {
    $first  = $second;
    $second = $sum;
    if ($dbg) { echo '## '.$first.' + '.$second.' -> '.($first+$second).PHP_EOL; }
    $sum    = $first + $second;
    if ($sum % 2 == 0) {
        $total += $sum;
        if ($show_answers) {
            echo $sum . ', ';
        }
    }
}

echo PHP_EOL;
echo "SUM LT " . $maximum . ": " . $total . PHP_EOL;
exit(0);

