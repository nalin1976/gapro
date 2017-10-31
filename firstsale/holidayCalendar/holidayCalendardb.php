<?php
session_start();
//$backwardseperator = "../../";
include "../../Connector.php";


$id=$_GET["id"];

if ($id=="saveHoliday")
{
	$holDate = $_GET["holDate"];
	$val = $_GET["val"];
	
	$chkAvailbility = checkDateAvailableInHoliday($holDate);
	
	if($chkAvailbility == '1')
		$response = updateHolidayDetails($holDate,$val);
	else
		$response = insertHolidayDetails($holDate,$val);	
	
	if($response == '1')
		echo true;
	else
		echo false;
}

if ($id=="loadHolidayDetails")
{

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$result = getHolidayDetails();
	while($row = mysql_fetch_array($result))
	{
		$responseXml .= "<dtmDate><![CDATA[" . $row["dtmdate"]  .  "]]></dtmDate>\n";
		
		$holType = $row["strStatus"];
				
				switch($holType)
				{
					case 'p':
						{
							$type = 'Poyaday';
							break;
						}
					case 'm':
						{
							$type = 'Mercantile Holiday';
							break;
						}
				}
		$responseXml .= "<holType><![CDATA[" . $type  .  "]]></holType>\n";		
	}
	
	$responseXml.='</data>';
	echo $responseXml;
}

if ($id=="deleteHoliday")
{
	$holDate = $_GET["holDate"];
	
	$sql = " delete from calendar 	where 	dtmdate = '$holDate' ";
	$response =  $db->RunQuery($sql);
	 
	 if($response == '1')
		echo true;
	else
		echo false; 
	
}
function checkDateAvailableInHoliday($holDate)
{
	global $db;
	
	$sql = "select * from calendar where dtmdate='$holDate' ";
	return $db->CheckRecordAvailability($sql);
}

function insertHolidayDetails($holDate,$val)
{
	global $db;
	
	$sql = "insert into calendar 
	(dtmdate, 
	strStatus
	)
	values
	('$holDate', 
	'$val'
	)";
	
	return $db->RunQuery($sql); 
}

function getHolidayDetails()
{
	global $db;
	
	$tdate = date('Y');
			$dfrom = $tdate.'-'.'01-01';
			$dto = $tdate.'-'.'12-31';
			
			$sql = "select * from calendar where dtmdate between '$dfrom' and '$dto' order by dtmdate ";
			return $db->RunQuery($sql); 
}

function updateHolidayDetails($holDate,$val)
{
	$sql = "update calendar 
			set
			strStatus = '$val'
			where
			dtmdate = '$holDate' ";
			
			return $db->RunQuery($sql); 
}
?>