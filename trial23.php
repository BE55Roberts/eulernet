<?php
// FILE: trial23.php
// GOAL: To solve this puzzle

/*
 * PROBLEM STATEMENT 23:
 * Let DIVISORS(N) be a function that returns all proper divisors of N 1..N/2
 * Let PN be a Perfect Number - i.e.
 * N = SUM(DIVISORS(N));
 *
 * Then all numbers fall into one of these categories:
 *
 * Deficient:   SUM(DIVISORS(N)) < N
 * Perfect:     SUM(DIVISORS(N)) == N
 * Abundant:    SUM(DIVISORS(N)) > N
 *
 * By Analysis, it can be shown that:
 * 12 is the smallest abundant number - i.e. 1+2+3+4+6 = 16 (abundant)
 * 24 is the smallest number that is the SUM of 2 Abundant Numbers (12+12)
 * 28123 is the limit, since all numbers above that have PAIRS that sum to them.
 *
 * OBJECTIVE: To find the set of Integers which can not be written as PAIRS of Abundant numbers.
 *            i.e. Set T = {1,2,3,...23,...,28123}
 *            Remove any element i WHERE:
 *                i >= 24
 *            &&  i has a pair of Abundant Numbers a, b such that i = a + b
 *
 * RESULT:    Determine the sum of all positive integers which CANNOT BE WRITTEN as the sum of 2 Abundant Numbers
 *
 * CAVEAT:
 * You have to keep a set while generating all of the Abundant Numbers in an $abundancy array!
 * You have to keep the numbers 1..23 in the final set!!
*/

$started = microtime(TRUE);

// Set the Timezone
date_default_timezone_set('America/New_York');

// Set the include path
set_include_path(__DIR__);


// START
$dbg      = FALSE;
$maximum  = 100;
$minimum  = 1;
$show     = FALSE;
$solution = 0;


/**
 * CLASS: abundant
 * Handles Abundant Number calculations
 */
class abundant {
    private $set;
    public $abundancy;
    public $tracing = FALSE;
    public $tally = 0;
    public $smallest_abundant = 12;
    public $largest_abundant = 28123;

    public function __construct($max = 1) {
        $this->set       = array_fill_keys(range(1, $max), 0);
        $this->abundancy = $this->findAllAbundant($max);
    }

    /**
     * Find All Divisors for a number
     *
     * @param int $val is the value to look at - i.e. 1..2.4G
     *
     * @return array containing all proper divisors or just [1] if none found
     */
    public function findDivisors($val = 1) {
        $result = [1];

        for ($i = 2; $i < $val; $i++) {
            if ($val % $i == 0) {
                $result[] = $i;
            }
        }

        if ($this->tracing) {
            echo '# ' . __METHOD__ . ':' . $val . '->' . implode(',', $result).PHP_EOL;
        }
        return $result;
    }

    /**
     * Decide whether a value is an Abundant Number or not
     *
     * @param int $val is the integer value to look at - ie. 1..2.4G
     *
     * @return bool is TRUE if the value is Abundant, FALSE otherwise
     */
    public function isAbundant($val = 1) {
        $is_a = FALSE;

        $divs = $this->findDivisors($val);

        if (array_sum($divs) > $val) {
            $is_a = TRUE;
        }
        if ($this->tracing) {
            echo '# ' . __METHOD__ . ':' . $val . ' ' . ($is_a ? 'IS' : 'IS NOT') . ' abundant.'.PHP_EOL;
        }

        return $is_a;
    }

    /**
     * Find all of the Abundant Numbers in a range 1 to $max
     *
     * @param int $max is the maximum integer to search for (inclusive)
     * CAVEAT: Always starts with 11, since 12 is the smallest abundant number
     * @return array $abundancy containing the set of abundant number 1..$max or an Empty Set
     */
    public function findAllAbundant($max = 1) {
        $this->abundancy = [];
        $ndx             = $this->getSmallestAbundant() - 1;
        $max = ($max < $this->largest_abundant) ? $max : $this->largest_abundant;
        while ($ndx <= $max) {
            if (array_sum($this->findDivisors($ndx)) > $ndx) {
                $this->abundancy[] = $ndx;
            }

            $ndx++;
        }

        if ($this->tracing) {
            echo '# ' . __METHOD__ . '(' . $max . ') found [' . count($this->abundancy) . '] numbers.'.PHP_EOL;
        }
        return $this->abundancy;
    }

    /**
     * Decide whether a $target has a pair of Abundant Numbers as a Sum or not
     *
     * @param int $target is the number to check as a target
     *
     * @return $found is TRUE if it has a pair, FALSE otherwise
     */
    public function hasAPair($target = 1) {
        $found = FALSE;
        $a     = 0;
        $b     = 0;
        $m     = count($this->abundancy);
        $this->tally++;

        while ($a < $m && $this->abundancy[$a] < $target) {

            $b = 0;
            while ($b < $m && $this->abundancy[$b] < $target) {
                if ($target == ($this->abundancy[$a] + $this->abundancy[$b])) {
                    $found = TRUE;
                    break 2;
                }

                $b++;
            }
            $a++;
        }

        if ($this->tracing) {
            echo '# ' . __METHOD__ . '(' . $target . ') ->' . ($found ? 'T' : 'F').PHP_EOL;
        }
        return $found;
    }

    // Filter the set by the Abundant Sum Pairs
    public function filterSet() {
        // Filter out all numbers that do not work
        $i = 1;
        $poss_length = count($this->set);

        while ($i < $poss_length) {
            $target = $i;
            if ($this->hasAPair(($target))) {
                unset($this->set[$i]);
            }

            $i++;
        }

        return $this->set;
    }

    /**
     * Get the final solution
     * @return int $solution is the sum of the remaining key values
     */
    public function getSolution() {

        $remaining_keys = array_keys($this->set);
        $this->solution = array_sum($remaining_keys);

        return $this->solution;
    }

    // Set the tracing flag to TRUE or FALSE
    public function setTracing($tracing) {
        $this->tracing = $tracing;
    }

    // Get the tally of values checked
    public function getTally() {
        return $this->tally;
    }

    // Get the Smallest Abundant Number possible
    public function getSmallestAbundant() {
        return $this->smallest_abundant;
    }

    // Get the Largest Abundant Number known
    public function getLargestAbundant() {
        return $this->largest_abundant;
    }

    /**
     * Get the current set of Abundant Numbers
     * @return array $abundancy
     */
    public function getAbundancy() {
        return $this->abundancy;
    }

    /**
     * Get current set of positive integers
     * @return array $set of 1..$max
     */
    public function getSet() {
        return array_keys($this->set);
    }

    /**
     * Get tally of current set of positive integers
     * @return int $tally of 0 .. $max
     */
    public function getSetTally() {
        return count($this->set);
    }
}

// HELP:
if ($argc > 1) {

    // TIP: Be sure to reset the parameters with values
    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:st:u:v:w:x:y:z:");

    foreach ($options as $option => $value) {
        switch ($option) {
            case 'd':
                $dbg = TRUE;
                break;

            case 'n':
                $minimum = (int) $value;
                break;

            case 'm':
                $maximum = (int) $value;;
                break;

            case 's':
                $show = TRUE;
                break;

            case 'h':
            default:
                echo 'HELP: ' . basename(__FILE__) . ' -d -n $min -m $max -s -h' . PHP_EOL;
                echo 'GOAL: To solve puzzle 23 at projecteuler.net using class ABUNDANT' . PHP_EOL;
                echo 'PARM: -d indicates we are debugging' . PHP_EOL;
                echo '      -f sets the $gridfile file to read for the matrix.' . PHP_EOL;
                echo '      -g sets the $matrix size.' . PHP_EOL;
                echo '      -n sets the $length of the sequence to find.' . PHP_EOL;
                echo '      -h redisplays this Help Screen' . PHP_EOL;
                echo '      -r enables reflection - i.e. sequences wrap around R->L' . PHP_EOL;
                echo 'NOTE: This finds the maximum product of the $length sequence' . PHP_EOL;
                echo '      of numbers in the matrix $gridfile in any direction.' . PHP_EOL;
                exit(0);
                break;
        }
    }
}

// ///////////////////////// MAIN CYCLE ///////////////////////////

if ($dbg) {
    echo 'Solving Abundancy Problems for ' . $minimum . '->' . $maximum . PHP_EOL;
}


// Create the Abundant Object and manipulate it
$puzzle = new \abundant($maximum);
$puzzle->setTracing($dbg);

// Filter the set by removing values that are the sum of 2 abundant numbers
$solution_set = $puzzle->filterSet();

// Show the results if requested
if ($dbg || $show) {
   echo '# After filtering, there are '.$puzzle->getSetTally().' values left.'.PHP_EOL;
   echo '# '.implode(', ', $puzzle->getSet()).PHP_EOL;
   echo '# And the solution set has '.count($solution_set).' values to sum.'.PHP_EOL;
}

// Calculate the final solution as the sum of the remaining keys in the solution set
$tally = $puzzle->getTally();

$solution = $puzzle->getSolution();
echo PHP_EOL.'SOLUTION: '.$solution.' for 1 to '.$maximum.PHP_EOL;

// Report analysis
if ($show) {
    $finished = microtime(TRUE);
    $elapsed = $finished - $started;
    echo 'ANALYSIS: '.'After '.$tally.' iterations, the solution was ';
    echo (count($solution) > 0 ? 'FOUND' : 'NOT FOUND').PHP_EOL;
    echo 'RUN TIME: This took '.$elapsed.' seconds.'.PHP_EOL;
}

exit(0);

