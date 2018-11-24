<?php
// FILE: trial17.php
// GOAL: To solve this puzzle

// START
$dbg = false;
$addand = false;
$maximum = false;
$tally = 0;
$count = 0;

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

            case 'm': // Set max value
                 $maximum = $value;
                 break;

            case 'h':
            default:
                echo 'HELP: '.basename(__FILE__).' -a -d -h -m $max'.PHP_EOL;
                echo 'GOAL: To solve this puzzle at projecteuler.net'.PHP_EOL;
                echo 'PARM: -a adds "and" after certain keywords.'.PHP_EOL;
                echo '      -d indicates we are debugging'.PHP_EOL;
                echo '      -h redisplays this Help Screen'.PHP_EOL;
                echo '      -m sets the $max number of 2**$max to show.'.PHP_EOL;
                echo 'NOTE: This spells out all of the numbers 1 to $max'.PHP_EOL;
                echo '      and then counts the letters (not punc).'.PHP_EOL.PHP_EOL;
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

// Process the value
if ($dbg) {
    echo 'Finding alphabetical characters for 1 to '.$maximum.' in english.'.PHP_EOL;
}

$number = 1;

while ($number <= $maximum) {

    $stringy = number_to_word($number);

    if ($dbg) { echo '# '.$number.'->'.$stringy.PHP_EOL; }
    $stringy = str_replace([' ', '-', ','], '', $stringy);
    $count += strlen($stringy);

    $number++;
}

// Show the final prime solution
echo "There are ".$count." letters in the set of numbers 1..". $maximum.' value.'.PHP_EOL;
exit(0);
