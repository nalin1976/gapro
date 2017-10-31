<?php
session_start();

include "../../Connector.php";



$request = $_GET["request"];
header('Content-Type: text/xml'); 


if ($request == "getdata")
//die(mysql_error());	
{ 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$itemcode = $_GET["Item"];
	$XMLString= "<Data>";
	$XMLString .= "<Item>";
	
	$sql="SELECT strItemCode, strDescription, strCommodityCode, strRemarks, strUnit	FROM item
	WHERE strItemCode='$itemcode';";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{ 
		$XMLString .= "<ItemId><![CDATA[" . $row["strItemCode"]  . "]]></ItemId>\n";
		$XMLString .= "<ItemName><![CDATA[" . $row["strDescription"]  . "]]></ItemName>\n";
		$XMLString .= "<Commoditycode><![CDATA[" . $row["strCommodityCode"]  . "]]></Commoditycode>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		
		
	}
	
	$XMLString .= "</Item>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

else if ($request == "checkdb")
{	
	$itemname=$_GET["ITEMNAME"];
	$itemcode=$_GET["CODE"];

	if($itemcode)
	{
		$sql="SELECT strItemCode FROM item 
		WHERE strItemCode != '$itemcode' AND strDescription='$itemname'";

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
		$sql="SELECT strItemCode  FROM item 
			WHERE strDescription='$itemname'";
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