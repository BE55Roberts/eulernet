<?php
// FILE: trial11.php
// GOAL: To solve this puzzle

/*
* PROBLEM STATEMENT 9:
A 20 x 20 grid is given in the file matrix11.txt

A Sequence is defined as n values going in direction d starting at (x,y)

The objective is to find the 4 number sequence with the maximum product.

For example, at (8,6) going diagonally down!
Values: 26, 63, 78, 14
Product is 1788696

CAVEAT:
You have to allow for 6 directions! Add Diagonally UP and Diagonally DOWN!
You can go off the array!!
*/

$started = microtime(true);

// Set the Timezone
date_default_timezone_set('America/New_York');

// Set the include path
set_include_path(__DIR__);


// START
$finished = microtime(true);
$dbg = false;
$maximum = 100;
$tally = 0;
$inc_tally = 0;
$next_number = 1;
$grid = array();
$grid_size = 20;
$seq_length = 4;
$wraparound = false;
$matrixfilespec = false;
$max_product = 0;
$locus = ['x' => -1, 'y' => -1, 'values' => [], 'direction' => 'NA'];
$grid_directions = ['up', 'down', 'left', 'right', 'diagup', 'diagdown'];
    
// HELP:
if ($argc > 1) {

    // TIP: Be sure to reset the parameters with values
    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:rs:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'f':
                $matrixfilespec = $value;
                break;

            case 'g':
                $grid_size = (int)$value;
                break;

            case 'n':
                $seq_length = (int)$value;
                break;

            case 'r':
                $wraparound = true;
                break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -f $gridfile -g $matrix -h -n $length -r'.PHP_EOL;
                echo 'GOAL: To solve puzzle 11 at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -f sets the $gridfile file to read for the matrix.'.PHP_EOL;
                echo '      -g sets the $matrix size.'.PHP_EOL;
                echo '      -n sets the $length of the sequence to find.'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -r enables reflection - i.e. sequences wrap around R->L'.PHP_EOL;
                echo 'NOTE: This finds the maximum product of the $length sequence'.PHP_EOL;
                echo '      of numbers in the matrix $gridfile in any direction.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}

// Calculate the point given the index and offset
function calc_pt($ndx, $off) {
    global $grid_size, $wraparound;

    // Add together; this could put the actual point off the grid
    $actual = $ndx + $off;
    if ($actual < 0) {
        if ($wraparound) {
            // Rotate around to the other side of the grid by skewing the number
            $actual += $grid_size;
        } else {
            $actual = 0;
        }
    }

    if ($actual >= $grid_size) {
        if ($wraparound) {
            // Rotate around to the other side of the grid by skewing the number
            $actual = $actual % $grid_size;

        } else {
            $actual = $grid_size - 1;
        }
    }

    // Always return an actual value valid for the grid
    return $actual;
}

/**
 * Check the matrix for the direction given
 *
 * @param $d is the known direction to go
 * @param $n is the length of the trek
 * @param $x is the starting column
 * @param $y is the starting row
 *
 * NOTE: You can go backwards
 *
 * @return bool $valid is TRUE if we can go that direction, FALSE otherwise
 */
function is_invalid_direction($d, $n, $x, $y) {
    global $grid_size, $wraparound;

    $valid = true;

    if ($wraparound) {
        // Always a valid direction
        return $valid;
    }

    // Check to see if we will go off the end of the matrix
    switch($d) {
        case 'up':
            if ($y - $n < 0) { $valid = false;}
            break;

        case 'down':
            if ($y + $n >= $grid_size) { $valid = false;}
            break;

        case 'left':
            if ($x - $n < 0) { $valid = false;}
            break;

        case 'right':
            if ($x + $n >= $grid_size) { $valid = false;}
            break;

        case 'diagup':
            if ($y - $n < 0) { $valid = false;}
            if ($x - $n < 0) { $valid = false;}
            break;

        case 'diagdown':
            if ($y + $n >= $grid_size) { $valid = false;}
            if ($x + $n >= $grid_size) { $valid = false;}
            break;

        default:
            break;
    }

    return $valid;
}

// Get n numbers at (x,y) going in the d direction

/**
 * Get the selected sequence of numbers at (y,x) in the direction d
 *
 * @param        $n is the length of the sequence
 *               If $wraparound is TRUE, then it can go off the edge
 * @param        $y is the row to start on: 0..$grid_size
 * @param        $x is the column to start in: 0..$grid_size
 * @param string $d is a lowercase string representing the direction to scan
 *
 * @return array containing 0s on FAILURE, entries on SUCCESS
 */
function get_numbers($n, $y, $x, $d = 'right') {
    global $grid,$grid_size, $wraparound;

    $result = array_fill(0, $n, 0);

    switch($d) {
        case 'up':
            if (!is_invalid_direction($d, $n, $x, $y)) { return $result; }
            for($i=0; $i<$n; $i++) {
                $r = calc_pt($y, -1 * $i);
                $c = $x;
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'down':
            if (!is_invalid_direction($d, $n, $x, $y)) { return $result; }
            for($i=0; $i<$n; $i++) {
                $r = calc_pt($y, $i);
                $c = $x;
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'left':
            if (!is_invalid_direction($d, $n, $x, $y)) { return $result; }
            for($i=0; $i<$n; $i++) {
                $r = $y;
                $c = calc_pt($x, -1 * $i);
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'right':
            if (!is_invalid_direction($d, $n, $x, $y)) { return $result; }
            for($i=0; $i<$n; $i++) {
                $r = $y;
                $c = calc_pt($x, $i);
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'diagup':
            if (!is_invalid_direction($d, $n, $x, $y)) { return $result; }
            for($i=0; $i<$n; $i++) {
                $r = calc_pt($y, -1*$i);
                $c = calc_pt($x, $i);
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'diagdown':
            if (!is_invalid_direction($d, $n, $x, $y)) { return $result; }
            for($i=0; $i<$n; $i++) {
                $r = calc_pt($y, $i);
                $c = calc_pt($x, $i);
                $result[$i] = $grid[$r][$c];
            }
            break;

        default:
            break;
    }

    return $result;
}

// ///////////////////////// MAIN CYCLE ///////////////////////////

// Build the array from the file, which should be 20 rows of 20 numbers each
$fh = fopen($matrixfilespec, 'r');
$row = 0;

while (!feof($fh)) {
    $data = fgets($fh);
    $data = trim($data);
    if (strlen($data)) {
        $grid[$row] = explode(" ", $data);
    }

    $row++;
}

if ($dbg) {
//    echo 'GRID:'.PHP_EOL.print_r($grid, true).PHP_EOL;
//    exit(0);
}

echo 'Solving...'.PHP_EOL;

// For each row 0..$grid_size
for ($y = 0; $y <= $grid_size-1; $y++) {
    // For each column 0..$grid_size
    for($x = 0; $x <= $grid_size-1; $x++) {

        // Now check each direction, wrapping around as needed
        foreach($grid_directions AS $direction) {
            $tally++;
//            if ($dbg) { echo '# Going '.$direction.' AT ['.$y.', '.$x.']'.PHP_EOL; }
            if (!$wraparound && is_invalid_direction($direction, $seq_length, $x, $y) == false) {
                continue;
            }

            // Get the numbers from this sequence
            $number_set = get_numbers($seq_length, $y, $x, $direction);
            $product_val = array_product($number_set);
            if ($product_val > $max_product) {
                $max_product = $product_val;
                if ($dbg) { echo '# Racheting up to '.$max_product.' AT ['.$y.', '.$x.']'.PHP_EOL; }
                $locus['y'] = $y;
                $locus['x'] = $x;
                $locus['values'] = $number_set;
                $locus['direction'] = $direction;
                $inc_tally++;
            }
        }
    }
}

if ($locus['x'] == -1) {
    // No Solution was found
    echo 'NO SOLUTION could be found with that file.'.PHP_EOL;
} else {
    // Show the final prime solution
    echo "Found Maximum Product as follows: ".PHP_EOL;
    echo '    '.$max_product." at (row, col) [".$locus['x'].', '.$locus['y']."] going ".$locus['direction']. PHP_EOL;
    echo '    '.'VALUES: '.implode(', ', $locus['values']).PHP_EOL; 
    if ($dbg) {
        echo 'EXPECTED: '.'70600674'.PHP_EOL;
        echo 'ANALYSIS: '.'Incremented max_product '.$inc_tally.' times out of total '.$tally.PHP_EOL;
    } 
}

exit(0);

