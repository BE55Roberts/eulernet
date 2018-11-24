<?php
// FILE: trial16.php
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

            case 'm': // Set max digits to show
                 $maximum = $value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -m $max'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of 2**$max to show.'.PHP_EOL;
                echo 'NOTE: This finds the sum of the digits in 2**$max.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Process the value
if ($dbg) {
    echo 'Finding digits for 2**'.$maximum.' lines.'.PHP_EOL;
}


$value = bcpow('2', $maximum);

// Find the total of the numbers using arbitrary precision math
for($ndx=strlen($value); $ndx > 0; $ndx--) {
    // Add each digit
    $final_total += (int)substr($value, $ndx-1, 1);
    if ($dbg) {
        echo 'Sum(digits) for 2**'.$maximum.' is '.substr($value, $ndx-1, 1).' -> '. $final_total.PHP_EOL;
    }
}

// Show the final prime solution
echo "The Total Number is ".$final_total." for 2^". $maximum.' exponent.'.PHP_EOL;
exit(0);
