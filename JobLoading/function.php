<?php

// get the current week of the today
function getWeeks($date, $rollover){
    $cut = substr($date, 0, 8);
    $daylen = 86400;

    $timestamp = strtotime($date);
    $first = strtotime($cut . "00");
    $elapsed = ($timestamp - $first) / $daylen;

    $weeks = 1;

    for ($i = 1; $i <= $elapsed; $i++)
    {
        $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
        $daytimestamp = strtotime($dayfind);

        $day = strtolower(date("l", $daytimestamp));

        if($day == strtolower($rollover))  $weeks ++;
    }

    return $weeks;
}

// get number of weeks of desired month
function weeks($month, $year){
    $firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
    $lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
    $count_weeks = 1 + ceil(($lastday-7+$firstday)/7);
    return $count_weeks;
} 

// get ordinal number ex. 1st, 2nd, 3rd ...
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

// check if value = 0 not empty
function notempty($var) {
    return ($var==="0"||$var);
}

?>
