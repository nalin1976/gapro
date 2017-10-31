<?php
include "../../Connector.php";

$request=$_GET['type'];

if($request=="loadstitchTypeDetails");
{
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML="<XMLstitchType>";
		$intId=$_GET['intId'];
		$SQL="SELECT *
			  FROM ws_stitchtype
			  WHERE intID='".$intId."';";
			
			$result = $db->RunQuery($SQL);	
			while($row = mysql_fetch_array($result))
				{
				    $ResponseXML .= "<ID><![CDATA[" . $row["intID"]  . "]]></ID>\n";
					$ResponseXML .= "<StitchType><![CDATA[" . $row["strStitchType"]  . "]]></StitchType>\n";
				}
		$ResponseXML .="</XMLstitchType>"; 
		echo $ResponseXML;
} 
?>

