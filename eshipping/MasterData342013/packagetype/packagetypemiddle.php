<?php


include "../../Connector.php";

$request = $_GET["request"];
header('Content-Type: text/xml');  

if($request=="GetDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$SearchID = $_GET["SearchID"];
	$XMLString= "<Data>";
	$XMLString .= "<Delivery>";

	$sql="SELECT intPackageID,strPackageCode,strPackageName  FROM packagetypes WHERE intPackageID='$SearchID'";
	
	$result = $db->RunQuery($sql);

	while($row=mysql_fetch_array($result))
		{
			$XMLString .= "<packagecode><![CDATA[" . $row["strPackageCode"]  . "]]></packagecode>\n";
			$XMLString .= "<packagename><![CDATA[" . $row["strPackageName"]  . "]]></packagename>\n";
		}
	$XMLString .= "</Delivery>";
	$XMLString .= "</Data>";
	echo $XMLString;

}
 else if($request=="checkdb")
{
	$SearchID = $_GET["SearchID"];
	$packagecode = $_GET["packagecode"];
	
	if($SearchID)
	{
		$sql="SELECT intPackageID  FROM packagetypes 
		WHERE intPackageID!= '$SearchID' AND strPackageCode='$packagecode'";

		$result = $db->RunQuery($sql);
		if (mysql_num_rows($result)>0)
		{
			
			echo "cant"	;
		}
		else
		{
			echo "update" ;
			
				
		}
	}
	else 
	{
		$sql="SELECT strPackageCode  FROM packagetypes 
			WHERE strPackageCode='$packagecode'";
		$result = $db->RunQuery($sql);
		if (mysql_num_rows($result)>0)
		{
			echo "cant";	
	
		}
		else
		{
			echo "insert";
		}
		
		
	}
	
}


?>