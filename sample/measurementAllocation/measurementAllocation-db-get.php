<?php

include "../../Connector.php";
$requestType=$_GET['requestType'];

if($requestType=="loadGrid")
		{
			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			$ResponseXML .= "<MeasurementPoints>";
			$id=$_GET["id"];
			
			$SQL = "SELECT * FROM measurementpoint WHERE intId='$id'";

			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
    		{
				$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
			 	//$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
			}	 
			  
				$ResponseXML .= "</MeasurementPoints>";
				echo $ResponseXML;		
		}
	else if($requestType=='loadOders')
	{
		$styleName=$_GET['stylename'];
		
		$SQL="SELECT intStyleId,strOrderNo FROM orders where strStyle='$styleName' ";
		
		$result = $db->RunQuery($SQL);
		$html="<option></option>";
		while($row = mysql_fetch_array($result))
		{
		$html .= "<option value=".$row['intStyleId'].">".$row['strOrderNo']."</option>";
		}
	
		echo $html;
		
	}
		
?>