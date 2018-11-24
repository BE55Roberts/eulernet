<?php
// FILE: trial18.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$starting = microtime(true);
$minimum = '01/01/1900';
$maximum = date('m/d/Y');
$one_day = 24*60*60; // one day in seconds
$day_of_week = 1;
$day_of_month = 1;
$tally = 0;
$count = 0;
$final_total = 0;

// HELP:
if ($argc > 1) {

    $options = getopt("a:b:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'd':
                $dbg = true;
                break;

            case 'm': // Set max value
                 $maximum = $value;
                 break;

            case 'n': // Set min value to use
                 $minimum = $value;
                 break;

            case 'w': // Set day of the week
                 $day_of_week = $value;
                 break;

           case 'x': // Set day of the month
                 $day_of_month = $value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -d -h -n $min -m $max -w $DOW -x $DOM'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -n sets the $minimum date (M/D/Y) to include.'.PHP_EOL;
                echo '      -m sets the $maximum date (M/D/Y) to include.'.PHP_EOL;
                echo '      -w sets the $DOW (0..6) Day of the Week (SU..SA)'.PHP_EOL;
                echo '      -x sets the $DOM (1..31) Day of the Month to match.'.PHP_EOL;
                echo 'NOTE: This counts the number of times in the date range'.PHP_EOL;
                echo '      given that the $DOW falls on the $DOM for the dates.'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Process the value
if ($dbg) {
    echo 'Finding count for dates between '.$minimum.' and '.$maximum.'.'.PHP_EOL;
}

$currently = strtotime($minimum);
$stopping = strtotime($maximum);

// Find the total of the numbers using arbitrary precision math
while ($currently <= $stopping) {
    // Is this the $day of the month required
    $dom = date('d', $currently);
    $dow = date('w', $currently);
    if ($dbg) {
        echo '# '.date('Y-m-d', $currently).' on '.$dow.' wkdy '.$dom.' mth'.PHP_EOL;
    }

    // Check for a match
    if ($dow == $day_of_week && $dom == $day_of_month) {
        // Date attributes match, so we count it
        $count++;
        if ($dbg) {
            echo 'Date '.date('Y-m-d', $currently).' falls on the '.$day_of_week.' DOW and '.$day_of_month.' DOMth.'.PHP_EOL;
        }
    }
 
    $tally++;
    $currently += $one_day;
}

// Show the final prime solution
echo "The ".$day_of_month." falls on ". $day_of_week.' exactly '.$count.' times.'.PHP_EOL;

// Show elapsed time
$finishing = microtime(true);
$elapsed = $finishing - $starting;
echo 'ANALYSIS: Checked '.$tally.' dates in '.$elapsed.' seconds.'.PHP_EOL;
exit(0);
