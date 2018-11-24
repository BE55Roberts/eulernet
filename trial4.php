<?php
// FILE: trial4.php
// GOAL: Find the largest palindrome made from the product of two 3-digit numbers

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
                echo '      -m sets the $max value for the calculation.'.PHP_EOL;
                echo 'A palindromic number reads the same both ways. '.PHP_EOL;
                echo 'The largest palindrome made from the product of '.PHP_EOL;
                echo 'two 2-digit numbers is 9009 = 91 × 99.'.PHP_EOL;
                echo 'Find the largest palindrome made from the product of two 3-digit numbers.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Determine if a given value is a palindrome - i.e. reads same right to left
function is_palindrome($val = '') {
    global $dbg;

    $reversed = strrev($val);
    $pal = false;
    $length = floor(strlen($val) / 2);
    $ndx = 0;

    if ($dbg) {
        echo 'is_palindrome('.$val.' <=> '.$reversed.') for '.$length.' digits'.PHP_EOL;
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

echo PHP_EOL;
$first = 10**$maximum - 1;
$lim = 10**($maximum - 1);

while ($first > $lim) {
    $second = $first - 1;
    if ($dbg) {
        echo 'Starting with('.$first.', '.$second.') for largest palindrome product over '.$lim.PHP_EOL;
    }

    while ($second > $lim) {
        $pass = is_palindrome($first * $second);

        if ($dbg) {
            echo 'Checking: '.$first.', '.$second.' => '.($pass ? 'T' : 'F').PHP_EOL;
        }

        if ($pass) {
            if ($first * $second > $solution['product']) {
                $solution['product'] = $first * $second;
                $solution['first'] = $first;
                $solution['second']= $second;
            }
        }

        $second--;
    }

    $first--;
}

// Show best solution
echo "PALINDROME for ".$maximum." is: ";
echo $solution['second'].' x '.$solution['first'].' => '.$solution['product'].PHP_EOL;
exit(0);

