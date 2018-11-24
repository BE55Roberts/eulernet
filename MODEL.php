<?php
// FILE: model.php
// GOAL: To solve this puzzle

// START
$dbg         = FALSE;
$maximum     = 10001;
$tally       = 0;
$solution    = ['first' => 0, 'second' => 0, 'product' => 0];
$final_prime = 1;
$need_help   = false;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach ($options as $option => $value) {
        switch ($option) {
            case 'd':
                $dbg = TRUE;
                break;

            case 'm':
                $maximum = $value;
                break;

            case 'h':
            default:
                $need_help = true;
                break;
        }
    }
}


// Determine if a given value is a palindrome - i.e. reads same right to left
function is_prime($val = 1) {
    global $dbg;

    $prime = TRUE;
    $lim   = sqrt($val);
    $ndx   = 2;

    if ($dbg) {
        echo 'Checking is_prime(' . $val . ')' . PHP_EOL;
    }

    while ($ndx <= $lim) {
        if ($val % $ndx == 0) {
            $prime = FALSE;
            break;
        }
        else {
            $ndx++;
        }
    }

    return $prime;
}

//////////////////////////////////   MAIN   //////////////////////////////////
if ($need_help) {
    echo 'HELP: ' . basename(__FILE__) . ' -d -h -m $max' . PHP_EOL;
    echo 'GOAL: To solve this puzzle at projecteuler.net' . PHP_EOL;
    echo 'PARM: -d indicates we are debugging' . PHP_EOL;
    echo '      -h redisplays this Help Screen' . PHP_EOL;
    echo '      -m sets the $max number of primes to identify.' . PHP_EOL;
    echo 'NOTE: This finds the 10001st Prime Number' . PHP_EOL;
    exit(0);
}

echo PHP_EOL;
$first     = 1;
$to_check  = 5;
$max_tally = 2;


while ($max_tally < $maximum) {
    $n = $to_check + 2;


    if (is_prime($to_check) == TRUE) {
        // To check is prime, so count it
        $final_prime = $to_check;
        $max_tally++;
        if ($dbg) {
            echo 'Prime: ' . $to_check . ' is the ' . $max_tally . 'th prime' . PHP_EOL;
        }

    }
    else {
        // Value is NOT PRIME - show every 10th iteration
        if ($dbg && ($max_tally % 10 == 0)) {
            echo 'Value(' . $to_check . ') is NOT PRIME' . PHP_EOL;
        }
    }

    if ($max_tally == $maximum) {
        break;
    }

    if (is_prime($n) == TRUE) {
        // To check is prime, so count it
        $final_prime = $n;
        $max_tally++;
        if ($dbg) {
            echo 'Prime: ' . $n . ' is the ' . $max_tally . 'th prime' . PHP_EOL;
        }

    }
    else {
        // Value is NOT PRIME - show every 10th iteration
        if ($dbg && ($max_tally % 10 == 0)) {
            echo 'Value(' . $n . ') is NOT PRIME' . PHP_EOL;
        }
    }

    $to_check += 6;
}

// Show the final prime solution
echo "The " . $maximum . "th PRIME is: " . $final_prime . PHP_EOL;
exit(0);

