<?php
// FILE: trial13.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$maximum = 10;
$tally = 0;
$count = 0;
$data_file = false;
$final_total = '0';

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'f': // Set first number to check
                $data_file = $value;
                break;

            case 'm': // Set max digits to show
                 $maximum = $value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -f $data -h -m $max'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -f sets the $data file to read.'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of digits to show.'.PHP_EOL;
                echo 'NOTE: This finds the sum of the set of arbitrary precision '.PHP_EOL;
                echo '      numbers in the $data file.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Read the numbers
$numbers = [];

if (!$data_file) {
    echo '*** No Data File specified. It should be a list of numbers. ***'.PHP_EOL;
    exit(9);
}

$fh = fopen($data_file, 'r');
while (!feof($fh)) {
    $datum = fgets($fh);
    $datum = trim($datum);
    if ($dbg) {
        echo 'Number['.count($numbers).'] = '.$datum.'.'.PHP_EOL;
    }
    if (strlen($datum)) {
        $numbers[] = $datum;
    }
}


if ($dbg) {
    echo 'Read in '.count($numbers).' lines.'.PHP_EOL;
}


// Find the total of the numbers using arbitrary precision math
foreach($numbers AS $nxt_number) {
    $final_total = bcadd($final_total, $nxt_number);
}

// Show the final prime solution
echo "The Total Number is ".$final_total." for: ". count($numbers).' values.'.PHP_EOL;
exit(0);

