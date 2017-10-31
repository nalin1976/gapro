<?php
session_start();
include "../../Connector.php";
$userid=$_SESSION["UserID"];
$userid=$_SESSION["UserID"];
$request=$_GET["request"];
$FactoryID=$_SESSION["FactoryID"];
if($request=='savedata')
{
	$styleid=$_GET["styleid"];
	$productionProcess=$_GET["productionProcess"];
	$cutdate=$_GET["date"];
	$cutdate_array=explode("/",$cutdate);
	$cutdate=$cutdate_array[2]."-".$cutdate_array[1]."-".$cutdate_array[0];
	$str_serial="select 	intNonValueSerial from syscontrol where intCompanyID='$FactoryID'";
	$result_serial=$db->RunQuery($str_serial);		
	$row_serail=mysql_fetch_array($result_serial);
	$NonValueSerial=$row_serail["intNonValueSerial"];
	
	$str="INSERT INTO production_nonvalue_header 
	(intNonValueSerial, 
	intStyleId, 
	intProcessId,
	intFactoryId, 
	dtmDate, 
	intUserId,
	dtmTimeStamp
	)
	VALUES
	('$NonValueSerial', 
	'$styleid', 
	'$productionProcess', 
	'$FactoryID', 
	'$cutdate', 
	'$userid' 
	,now());";
	$result=$db->RunQuery($str);
	if($result){	
		$str_update="update syscontrol set intNonValueSerial=intNonValueSerial+1 where intCompanyID='$FactoryID'";
		$result_update=$db->RunQuery($str_update);
		echo $NonValueSerial;
	}
	
}
if($request=='savedetail')
	{
		$id=$_GET["id"];
		$serial=$_GET["serial"];
		$qty=$_GET["qty"];
		$str="INSERT INTO production_nonvalue_detail 
	(intNonValueSerial, 
	intNonValueId, 
	dblQty
	)
	VALUES
	('$serial', 
	'$id', 
	'$qty'
	);";
		$result=$db->RunQuery($str);
		if($result)
		echo "Saved";
	}
		
 
?>