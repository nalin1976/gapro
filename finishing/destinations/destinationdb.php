<?php 
include "../../Connector.php";
include "../../eshipLoginDB.php";	
$Request 	= $_GET["Request"];
$userId		= $_SESSION["UserID"];

if($Request=="getData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "";
	$ResponseXML .= "<cityData>\n";
	
	$countryID 	 = $_GET["countryID"];
	$cityID		 = $_GET["cityID"];
	
	$sql_city = "SELECT * from finishing_final_destination where intConID='$countryID'";
	if($cityID!="")
	 	$sql_city.=" and intCityID='$cityID'";
	$sql_city.=" order by strCityName"; 
	
	$result = $db->RunQuery($sql_city);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intConId><![CDATA[" . $row["intConID"]  . "]]></intConId>\n";
		$ResponseXML .= "<intCityId><![CDATA[" . $row["intCityID"]  . "]]></intCityId>\n";
		$ResponseXML .= "<cityName><![CDATA[" . $row["strCityName"]  . "]]></cityName>\n";
		$ResponseXML .= "<strport><![CDATA[" . $row["strPort"]  . "]]></strport>\n";
		$ResponseXML .= "<altCityName><![CDATA[" . $row["strAlternativeCityName"]  . "]]></altCityName>\n";
	}
	$ResponseXML .= "</cityData>\n";
	echo $ResponseXML;	
}

if($Request=="SaveData")
{
	$conID	     = $_GET["conID"];
	$cityId	     = $_GET["cityId"];
	$ciytName	 = $_GET["ciytName"];
	$port 		 = $_GET["port"];
	$Dest 		 = $_GET["Dest"];
	$boolCheck	 = checkDataAvailable($conID,$cityId);
	if($boolCheck!="true")
	{
		$sql_check="select intCityID,strCityName,strPort,strAlternativeCityName from finishing_final_destination where intCityID!='$cityId' and strCityName='$ciytName' and strPort='$port' and strAlternativeCityName='$Dest'";
		$result_check = $db->RunQuery($sql_check);
		if(mysql_num_rows($result_check)>0)
		{
			echo "cant";
		}
		else
		{
		$sql_insert ="insert into finishing_final_destination 
						( 
						  intConID, 
						  strCityName, 
						  strPort, 
						  strAlternativeCityName, 
						  intUserId, 
						  dtmDate
						)
						values
						(
						  $conID,
						 '$ciytName',
						 '$port',
						 '$Dest',
						  $userId,
						  now()
						)";
		$result_insert = $db->RunQuery($sql_insert);
		if($result_insert)
			   echo "Saved";
			 else
			   echo "Error";
		}
	}
	else
	{
	$sql_check="select intCityID,strCityName,strPort,strAlternativeCityName from finishing_final_destination where intCityID!='$cityId' and strCityName='$ciytName' and strPort='$port' and strAlternativeCityName='$Dest'";
		$result_check = $db->RunQuery($sql_check);
		if(mysql_num_rows($result_check)>0)
		{
			echo "cant";
		}
		else
		{
		$sql_update = "update finishing_final_destination 
						set
						strCityName = '$ciytName' , 
						strPort = '$port' , 
						strAlternativeCityName = '$Dest' , 
						intUserId = '$userId'
						where
						intCityID = '$cityId' and intConID = '$conID';";
		$result_update = $db->RunQuery($sql_update);
		if($result_update)
			   echo "Updated";
			 else
			   echo "Error";
		}
	}
}
if($Request=="deleteData")
{
	$conID	     = $_GET["conID"];
	$cityId	     = $_GET["cityId"];
	
	$sql_delete ="delete from finishing_final_destination where intCityID = '$cityId' and intConID = '$conID' ; ";
	$result_delete = $db->RunQuery($sql_delete);
	if($result_delete)
		echo "Deleted";
	else
		echo "Error";
}
function checkDataAvailable($conID,$cityId)
{
	global $db;
	$sql = "select intConID from finishing_final_destination where intConID='$conID' and intCityID='$cityId';";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
	 return true;
	else
	 return false;
}
?>