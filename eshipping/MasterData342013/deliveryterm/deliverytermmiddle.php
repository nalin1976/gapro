<?php
session_start();

include "../../Connector.php";


$request = $_GET["request"];
header('Content-Type: text/xml');  

if($request=="GetDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$SearchID = $_GET["SearchID"];
	$XMLString= "<Data>";
	$XMLString .= "<Delivery>";

	$sql="SELECT *  FROM deliveryterms WHERE intDeliveryID='$SearchID';";
	
	$result = $db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$XMLString .= "<deliverycode><![CDATA[" . $row["strDeliveryCode"]  . "]]></deliverycode>\n";
			$XMLString .= "<deliveryname><![CDATA[" . $row["strDeliveryName"]  . "]]></deliveryname>\n";
		}
	$XMLString .= "</Delivery>";
	$XMLString .= "</Data>";
	echo $XMLString;

}


else if($request=="checkdb")
{
	$SearchID = $_GET["SearchID"];
	$deliverycode = $_GET["deliverycode"];
	
	if($SearchID)
	{
		$sql="SELECT intDeliveryID  FROM deliveryterms 
		WHERE intDeliveryID != '$SearchID' AND strDeliveryCode='$deliverycode'";

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
		$sql="SELECT strDeliveryCode  FROM deliveryterms 
			WHERE strDeliveryCode='$deliverycode'";
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
