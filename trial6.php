<?php
// FILE: trial6.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$maximum = 10;
$solution = ['first' => 0, 'second' => 0, 'product' => 0];
$max_product = 1;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'm':
                 $maximum = $value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -m $max'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max value N for the calculation.'.PHP_EOL;
                echo 'PROBLEM 6: Sum Square Difference 1..N'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


echo PHP_EOL;
$sum_of_square = 0;
$square_of_sum = 0;
$lim = $maximum;
$ndx = 1;

while ($ndx <= $lim) {
    $sum_of_square += $ndx * $ndx;
    $square_of_sum += $ndx;
    $ndx++;
}

// Be sure to square the final sum
$square_of_sum = $square_of_sum * $square_of_sum;

// Show best solution
echo "SUM SQUARE DIFFERENCE for 1..".$maximum." is: ".PHP_EOL;
echo $square_of_sum.' - '.$sum_of_square.' => '.($square_of_sum - $sum_of_square).PHP_EOL;
exit(0);

