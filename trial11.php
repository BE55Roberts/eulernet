<?php
// FILE: trial11.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$maximum = 100;
$tally = 0;
$inc_tally = 0;
$next_number = 1;
$grid = array();
$grid_size = 20;
$seq_length = 4;
$matrixfilespec = 'matrix11.txt';
$max_product = 0;
$locus = ['x' => -1, 'y' => -1, 'values' => [], 'direction' => 'NA'];
$grid_directions = ['up', 'down', 'left', 'right', 'diag'];
    
// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

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

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -f $gridfile -g $matrix -h -n $length'.PHP_EOL;
                echo 'GOAL: To solve puzzle 11 at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -f sets the $gridfile file to read for the matrix.'.PHP_EOL;
                echo '      -g sets the $matrix size.'.PHP_EOL;
                echo '      -n sets the $length of the sequence to find.'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo 'NOTE: This finds the maximum product of the $length sequence'.PHP_EOL;
                echo '      of numbers in the matrix $gridfile in any direction.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}

function calc_pt($row, $off) {
    global $grid_size;

    $actual = $row + $off;
    if ($actual < 0) {
        // Always rotate around to the other side of the grid
        $actual += $grid_size;
    }

    return $actual;
}
// Get n numbers at (x,y) going in the d direction
function get_numbers($n, $x, $y, $d = 'right') {
    global $grid;

    $result = array_fill(0, $n, 0);

    switch($d) {
        case 'up':
            for($i=0; $i<$n; $i++) {
                $r = calc_pt($y, -1 * $i);
                $c = $x;
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'down':
            for($i=0; $i<$n; $i++) {
                $r = calc_pt($y, $i);
                $c = $x;
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'left':
            for($i=0; $i<$n; $i++) {
                $r = $y;
                $c = calc_pt($x, -1 * $i);
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'right':
            for($i=0; $i<$n; $i++) {
                $r = $y;
                $c = calc_pt($x, $i);
                $result[$i] = $grid[$r][$c];
            }
            break;

        case 'diag':
            for($i=0; $i<$n; $i++) {
                $r = calc_pt($y, $i);
                $c = calc_pt($x, $i);
                $result[$i] = $grid[$r][$c];
            }
            break;
    }

    return $result;
}


// Build the array
$fh = fopen($matrixfilespec, 'r');
$row = 0;

while (!feof($fh)) {
    $data = fgets($fh);
    $grid[$row] = explode(" ", $data);

    $row++;
}

if (count($grid) > $grid_size) {
    unset($grid[$grid_size]);
}

if ($dbg) {
//    echo 'GRID:'.PHP_EOL.print_r($grid, true).PHP_EOL;
//    exit(0);
}

echo 'Solving...'.PHP_EOL;

// For each row 0..$grid_size
for ($y = 0; $y < $grid_size-1; $y++) {
    // For each column 0..$grid_size
    for($x = 0; $x < $grid_size-1; $x++) {

        // Now check each direction, wrapping around as needed
        foreach($grid_directions AS $direction) {
            $tally++;
            if ($dbg) { echo '# Going '.$direction.' AT ['.$y.', '.$x.']'.PHP_EOL; }
            $number_set = get_numbers($seq_length, $y, $x, $direction);
            $product_val = array_product($number_set);
            if ($product_val > $max_product) {
                $max_product = $product_val;
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
    echo "Found Maximum Product as follow: ".PHP_EOL;
    echo '    '.$max_product." at (row, col) [".$locus['y'].', '.$locus['x']."] going ".$locus['direction']. PHP_EOL;  
    echo '    '.'VALUES: '.implode(', ', $locus['values']).PHP_EOL; 
    if ($dbg) {
    echo 'ANALYSIS: '.'Incrmented max_product '.$inc_tally.' times out of total '.$tally.PHP_EOL;
    } 
}

exit(0);

