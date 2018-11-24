<?php
// FILE: trial39.php
// GOAL: To solve the Project Euler Puzzle 39

// START
$dbg = false;
$show = false;
$starting = microtime(true);
$first_to_check = 2;
$last_to_check = 28123;
$maximum = 10;
$tally = 0;
$count = 0;
$divisors = [];
$amicables = [];
$amicablesums = [];
$final_sum = 0;
$amicable_pairs = '';
$abundant = [];

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:st:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'n': // Set first number to check
                 $first_to_check = (int)$value;
                 break;

            case 'm': // Set max divisors to look for
                 $maximum = (int)$value;
                 break;

            case 's':
                $show = true;
                break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -n $min -m $max -s'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -f set $first_to_check number'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -n sets the $min number to check.'.PHP_EOL;
                echo '      -m sets the $max number to check (inclusive).'.PHP_EOL;
                echo '      -s shows all steps involved.'.PHP_EOL;
                echo 'NOTE: This finds the Sum of the all the Numbers under $max'.PHP_EOL;
                echo '      that cannot be written as the sum of two'.PHP_EOL;
                echo '      Abundant Numbers, for example:'.PHP_EOL;
                echo 'EG:   N is Abundant when the sum of proper divisors > N'.PHP_EOL;
                echo '      12 is abundant, since 1+2+3+4+6 = 16, and 16 > 12'.PHP_EOL;
                echo '      In fact, 12 is the smallest and 28123 is the largest.'.PHP_EOL;
                echo 'CAVEAT: Watch out for Perfect Numbers where d(n) = n.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Get the Greatest Common Denominator
function gcd($a, $b) {
    return $b ? gcd($b, $a % $b) : $a;
}

// Determine if a given value is a palindrome - i.e. reads same right to left
function is_prime($val = 1) {
    global $dbg;

    $prime = true;
    $lim = sqrt($val);
    $ndx = 2;

    if ($dbg) {
        echo 'Checking is_prime('.$val.')'.PHP_EOL;
    }

    while ( $ndx <= $lim) {
        if ($val % $ndx == 0) {
            $prime = false;
            break;
        } else {
            $ndx++;
        }
    }

    return $prime;
}

// Find the integers that divide evenly into a value
function find_divisors($val = 1) {
    $result = [1];

    for($i=2; $i<$val; $i++) {
        if ($val % $i == 0) {
            $result[] = $i;
        }
    }

    return $result;
}


// Find the triangular sum of a particular number N - i.e. SUM(1..N)
function find_triangular_sum($val = 1) {
    $result = 0;

    for($ndx = 1; $ndx <= $val ; $ndx++) {
        $result += $ndx;
    }
    
    return $result;

}

/////////////////////////////   MAIN   /////////////////////////////
// $starting = microtime(true);
// $first_to_check = 2;
// $maximum = 10;


echo PHP_EOL;
$to_check = $first_to_check;

if ($dbg) {
    echo 'Running amicable numbers '.$first_to_check.' through('.$maximum.')'.PHP_EOL;
}


// Find the Abundant numbers
while ($to_check < $maximum) {
    if ($dbg) {
        echo 'Testing('.$to_check.') '.'for amicability...'.PHP_EOL;
    }

    // Skip if already done
    if ($amicables[$to_check]) { 
        $to_check++;
        continue; 
    }

    $divisors1 = find_divisors($to_check);
    $sum1 = array_sum($divisors1);
    if ($dbg) {
        echo 'Divisors('.$to_check.') = '.implode(', ',$divisors1).'->'.$sum1.PHP_EOL;
    }

    $divisors2 = find_divisors($sum1);
    $sum2 = array_sum($divisors2);
    if ($sum2 >= $maximum) { 
        $to_check++;
        continue; 
    }
    if ($dbg) {
        echo 'Divisors('.$sum1.') = '.implode(', ',$divisors2).'->'.$sum2.PHP_EOL;
    }

    if ($to_check == $sum2 && $to_check !== $sum1) {
        // Found amicable numbers, so record the fact for both
        $amicable_pairs .= (strlen($amicable_pairs) ? ';' : '').$to_check.':'.$sum1;
        $amicables[$to_check] = 1;
        $amicablesum[$to_check] = $sum1;
        $amicables[$sum1] = 1;
        $amicablesum[$sum1] = $sum2;
        $count++;
        if ($dbg) {
            echo 'Found Amicable Pair('.$to_check.', '.$sum1.') -> FLAGGED'.PHP_EOL;
        }
    }

    $tally++;

    $to_check++;

    if ($tally % 100 == 0) {echo '.';}
}

// Show the final amicable solution
$actual_sum = array_sum($amicablesum);
echo PHP_EOL;
for ($i = 1; $i<=$maximum; $i++) {
    if ($amicables[$i]) {
        $final_sum += $i;
        if ($show) { echo $i.', '; }
    }
}
echo PHP_EOL.'SOLUTION: '.$final_sum.' is the sum for '.$count.' amicable numbers found.'.PHP_EOL;
if ($dbg) {
    echo 'DETAILS:'.PHP_EOL; 
    echo 'Pairs: '.$amicable_pairs.PHP_EOL;
    for ($i=1; $i<=$maximum; $i++) {
        if ($amicables[$i]) { echo $i.': '.$amicablesum[$i].PHP_EOL; }
    }
    echo 'TOTAL(amicable_sums): '.$actual_sum.PHP_EOL;
}


# Evaluate timing
$finished = microtime(true);
$elapsed = $finished - $starting;
echo 'TIMING: This job took '.$elapsed.' seconds to run'.$tally.' iterations.'.PHP_EOL;
exit(0);

