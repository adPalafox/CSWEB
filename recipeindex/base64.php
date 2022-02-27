<?php

function getDays($now, $sqldate){

    $datediff = $sqldate - $now;
    
    $days = abs(round($datediff / (60 * 60 * 24)));
    
    echo $days." days";
    
}

$datenow = date("Y-m-d");
$sqldate = strtotime("2022-03-05");


getDays(strtotime($datenow), $sqldate);

?>