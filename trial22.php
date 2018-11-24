<?php
// FILE: trial22.php
// GOAL: To solve the Project Euler 22 puzzle

// START
$dbg = false;
$addand = false;
$maximum = false;
$tally = 0;
$count = 0;
$namelist = [];
$final_score = 0;
$datafile = false;

// HELP:
if ($argc > 1) {

    $options = getopt("ab:c:de:f:g:hi:j:k:l:m:n:o:p:q:r:s:t:u:v:w:x:y:z:");

    foreach($options as $option => $value) {
        switch($option) {
            case 'a':
                $addand = true;
                break;

            case 'd':
                $dbg = true;
                break;

            case 'f':
                $datafile = $value;
                break;

            case 'm': // Set max value
                 $maximum = $value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -a -d -h -m $max'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -a adds "and" after certain keywords.'.PHP_EOL;
                echo '      -d indicates we are debugging'.PHP_EOL;
                echo '      -f identifies the data file with CAPITAL NAMES'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of 2**$max to show.'.PHP_EOL;
                echo 'NOTE: This sorts a list of names, then scores them:'.PHP_EOL;
                echo '      $score = SUM(ord(ch)) * position(1..N).'.PHP_EOL;
                echo 'CAVEAT: Be sure to use CARDINAL POSITION, not array index'.PHP_EOL;
                exit(0);
                break;
        }
    }
}


// Add and selectively
function add_and($val) {
    $val = str_replace('hundred ', 'hundred and ', $val);

    return $val;
}

// Score a name
function score_name($name, $position) {
    global $dbg;

    $score = 0;
    $name = strtoupper($name);
    $len = strlen($name);
    for($i = 0; $i<$len; $i++) {
        $ch = substr($name, $i, 1);
        $score += ord($ch)-64;
        // if ($dbg) { echo '# CH:'.$ch.': score = '.(ord($ch)-64).'->'.$score.PHP_EOL; }
    }
 
    $score = $score * ($position+1);

    return $score;
}

// Convert a number to the english word equivalent text
// CAVEAT: NumberFormatter DOES NOT ADD "and" to the string; you have to do that yourself
function number_to_word($val = 1) {
    global $addand;

    $words = '';

    $fmt = new NumberFormatter('en', NumberFormatter::SPELLOUT);

    $words = $fmt->format($val);

    if ($addand) {
        $words = add_and($words);
    }

    return $words;
}

// Process the file
if ($dbg) {
    echo 'Scoring names in ['.$datafile.']'.PHP_EOL;
}

if ($datafile) {
    $content = file_get_contents($datafile);

    $namelist = explode(',',$content);
    $namelist = str_replace(['"'],'',$namelist);
} else {
    $namelist = ['ABLE', 'BAKER', 'CAPRA', 'DELTA'];
}

// sort the list
$sorted = sort($namelist, SORT_STRING); // OR: SORT_NATURAL
$listlength = count($namelist);

// Score the list
for($ndx = 0; $ndx < $listlength; $ndx++) {
    $scoring = score_name($namelist[$ndx], $ndx);
    $final_score += $scoring;
    if ($dbg) { echo '# '.$ndx.':'.$namelist[$ndx].'->'.$scoring.PHP_EOL; }

    $tally++;
}

// Show the final solution
echo PHP_EOL."SCORE: ".$final_score." for ". $listlength.' names.'.PHP_EOL;
exit(0);
