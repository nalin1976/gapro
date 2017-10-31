<?php
/* Function to find the first and last day of the month from the given date.
*
* Author Binu v Pillai            binupillai2003@yahoo.com
* @Param            String             yyyy-mm-dd
*
*/
function findFirstAndLastDay($anyDate)
{
    //$anyDate            =    '2009-08-25';    // date format should be yyyy-mm-dd
    list($yr,$mn,$dt)    =    split('-',$anyDate);    // separate year, month and date
    $timeStamp            =    mktime(0,0,0,$mn,1,$yr);    //Create time stamp of the first day from the give date.
    $firstDay            =     date('D',$timeStamp);    //get first day of the given month
    list($y,$m,$t)        =     split('-',date('Y-m-t',$timeStamp)); //Find the last date of the month and separating it
    $lastDayTimeStamp    =    mktime(0,0,0,$m,$t,$y);//create time stamp of the last date of the give month
    $lastDay            =    date('D',$lastDayTimeStamp);// Find last day of the month
    $arrDay                =    array("$firstDay","$lastDay"); // return the result in an array format.
   
    return $arrDay;
}

//Usage
$dayArray=array();
$dayArray=findFirstAndLastDay('2009-02-25');
print $dayArray[0];
print $dayArray[1];
?>
