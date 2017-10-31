<?php 
include "Connector.php";

$cancelDate = date("Y-m-d", strtotime("-14 day"));
	$sql = " select intTransferNo,intTransferYear from commonstock_leftoverheader where date(dtmDate)<'$cancelDate' and intStatus=0 and  intReservation=1 ";
	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		$reserveNo = $row["intTransferNo"];
		$reserveYear = $row["intTransferYear"];
		
		updateReservationStatus($reserveNo,$reserveYear);
	}
function updateReservationStatus($reserveNo,$reserveYear)
{
	global $db;
	$sql = " update commonstock_leftoverheader 
	set
	intStatus = '10' , 
	dtmCancelDate = now() , 
	strCancelReason = 'Cancel Reservation by system' 
	where
	intTransferNo = '$reserveNo' and intTransferYear = '$reserveYear' and intReservation=1 ";
	
	$result=$db->RunQuery($sql);	
}	
?>