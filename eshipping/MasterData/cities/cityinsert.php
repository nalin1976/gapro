<?php
session_start();
include "../../Connector.php";

$request=$_GET['request'];
if($request=="deletedata")
{	
	
	$citycode=$_GET['city'];
	
	$sql="DELETE FROM city WHERE strCityCode='$citycode'";
	$result = $db->RunQuery($sql);
	if ($result)
		{
		echo "Successfully deleted.";
		}
}


if($request=="checkdb")
{
 $vcity=$_GET['city'];
 $vcountry=$_GET['country'];
 

	$sql="SELECT strCityCode FROM city WHERE strCountryCode = '$vcountry' AND strCityCode = '$vcity'";
	$result = $db->RunQuery($sql);
	
	if(mysql_num_rows($result)>0)
		{
			echo "update" ;		
		} 
 	else
 		{
 			echo "insert" ;		
 		}
}

if($request=="insertdb")
{
	$city=$_GET['city'];
 	$country=$_GET['country'];
 	$arg=$_GET['arg'];
 	$port=$_GET['port'];
 	$old=$_GET['old'];
	$DC=$_GET['dc'];
	$ISD=$_GET['isd'];
	$DES=$_GET['des'];
 	
 	if ($arg=='insert')
 	{
 		$sql="INSERT INTO city (strCity,strCountryCode,strPortOfLoading,strDC,strtoLocation,strDestination) VALUES('$city','$country','$port','$DC','$ISD','$DES')";
 		
		$result = $db->RunQuery($sql);
 		 if ($result)
		{
			echo"Successfully saved.";
		}	
 	}
 	
 	if ($arg=='update')
 	{
 		$sql="UPDATE city SET strCity='$city' ,strPortOfLoading='$port', strCountryCode='$country', strDC='$DC',  strtoLocation='$ISD' ,strDestination='$DES' WHERE strCityCode='$old'";
		
		$result = $db->RunQuery($sql);
		
 		 if ($result)
		 {
			echo"Successfully updated.";
		 }	 	
 	
 	}
 	
 	
}



?>
