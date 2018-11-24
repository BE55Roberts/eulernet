<?php
// FILE: trial9.php
// GOAL: To take notes on this idea
// WHO:  Bradley Roberts
// HISTORY:
// 08/07/2018: Created to run Trial 9

/*
* PROBLEM STATEMENT 9:
A Pythagorean triplet is a set of three natural numbers, a < b < c, for which,

a2 + b2 = c2
For example, 32 + 42 = 9 + 16 = 25 = 52.

There exists exactly one Pythagorean triplet for which a + b + c = 1000.
Find the product abc - e.g. 60.
*/

$started = microtime(true);

// Set the Timezone
date_default_timezone_set('America/New_York');

// Set the include path
set_include_path(__DIR__);


// ///////////////////////// MAIN CYCLE ///////////////////////////
$QT        = '"';
$SLASH     = '/';
$BACKSLASH = '\\';
$solution_not_found = true;
$sum_of_vars  = false;
$set_of_vars = ['a' => 0, 'b' => 0, 'c' => 0];
$tally = 0;
$solutionNdx = 0;
$solutions = [$solutionNdx => $set_of_vars];
$is_a_triplet = false;

$a = 1;
$b = 1;
$c = 1;
$max_ndx = 1;
$max_tally = 1000;

$gDebugging = FALSE;

// Banner if debugging
if ($gDebugging) {
    echo "Now running trial '.basename(__FILE__).'..." . PHP_EOL;
}

// Check for arguments (if any)
if ((php_sapi_name() == 'cli') && ($argc > 1)) {
    $options = getopt("dhs:");
    if (!$options) {
        // Get Help instead
        $options = array('h' => FALSE);
    }

    // Process option arguments
    foreach ($options as $key => $value) {
        switch ($key) {
            case 'd' : // NOTE: Set the DEBUG flag first to get debug Data throughout
                $gDebugging = TRUE;
                break;

            case 'h' :
                echo 'HELP: ' . basename(__FILE__) . ' -d -s $SUM -h' . PHP_EOL;
                echo 'GOAL: To run the Project Euler trial.' . PHP_EOL;
                echo 'PARM: -d Turns on DEBUGGING' . PHP_EOL;
                echo '      -s $SUM is the total to calculate - e.g. 1000.' . PHP_EOL;
                echo '      -h Redisplays this help screen.' . PHP_EOL;
                echo 'NOTE: No argument is required - i.e. it defaults to 1000.' . PHP_EOL;
                echo 'WEB:      https://projecteuler.net/problem=9' . PHP_EOL;
                echo 'ANAL: Pythagorean Triplet Problem'.PHP_EOL;
                echo '      A triplet is a set of 3 Natural Numbers: a, b, c, such that:'.PHP_EOL;
                echo '      Condition 1: a < b < c'.PHP_EOL;
                echo '      Condition 2: a^2 + b^2 = c^2'.PHP_EOL;
                echo '      Condition 3: a + b + c = 1000'.PHP_EOL.PHP_EOL;
                exit(0);
                break;

            case 's' : // Sum of the Pythagorean Triplet must equal
                $sum_of_vars = $value;
                break;

            default :
                echo '*** Parameter [' . $key . '] is not recognized - try -h for HELP ***' . PHP_EOL;
                exit(1);
                break;
        }
    }
}

// Set range
$starting_value = 2;
$max_tally = floor(sqrt($sum_of_vars));

// Do we have valid values
if (!$sum_of_vars) {
    echo '*** Invalid arguments - try ' . basename(__FILE__) . ' -h for help' . PHP_EOL;
    exit(2);
}

// Arguments valid, so render the new Virtual Host block
if ($gDebugging) {
    echo 'Finding Triplet where SUM = [' . $sum_of_vars . ']' . PHP_EOL;
}

/**
 * Calculate whether 3 variables represent a Pythagorean Triplet
 * @param $a is a natural number
 * @param $b is a natural number
 * @param $c is a natural number
 *
 * @return bool $triple is TRUE if the variables are a Pythagorean Triple, FALSE otherwise
 */
function is_triplet($a, $b, $c) {
    $triple = false;

    if (($a >= $b) || ($b >= $c)) {
        return $triple;
    }

    // Check for a^2 + b^2 == c^2
    if (($a * $a + $b * $b) == ($c * $c)) {
        $triple = true;
    }
    
    return $triple;
}


// Set boundary - i.e. no variable can exceed this since we are using positive natural numbers
$max_ndx = $sum_of_vars;

// Three Layer While Loops
do {
    $a = $starting_value;
    
    while ($a < $max_ndx) {
      
        $b = $a + 1;
        
        while ($b < $max_ndx) {
            $c = $b + 1;
            
            while ($c < $max_ndx) {
                // Check for solution
                $tally++;
                $is_a_triplet = is_triplet($a, $b, $c);
                if ($gDebugging) {
                    echo 'Check is_triplet(' . $a.', '.$b.', '.$c . ') -> '.($is_a_triplet ? 'T' : 'F') . PHP_EOL;
                }
                if ($is_a_triplet) {
                    if ($a + $b + $c == $sum_of_vars) {
                        $solution_not_found = false;
                        $solutions[$solutionNdx] = ['a' => $a, 'b' => $b, 'c' => $c];
                        $solutionNdx++;
                    }
                }
                
                $c++;
            }
            
            $b++;
        }
        
        $a++;
    }
} while ($tally < 3 * $sum_of_vars && $solution_not_found);

if ($solution_not_found == true) {
    echo 'SOLUTION WAS NOT FOUND!' . PHP_EOL;

} else {
    echo 'SOLUTION is : ' .print_r($solutions, true) . PHP_EOL;

}

// Report timing
$finished = microtime(true);
$elapsed = $finished - $started;

echo '# REPORT: Ran '.$tally.' iterations in '.$elapsed.' seconds.' . PHP_EOL;
exit(0);
