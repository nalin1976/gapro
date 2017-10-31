<?php
include "../../Connector.php";

$request=$_GET['type'];

if($request=="loadtex")
{
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $intId=$_GET['intID'];	
		
		$ResponseXML="<XMLSeamType>";
		$SQL="SELECT intId,strName
			  FROM ws_seamtype
			  WHERE intID='".$intId."';";
			//echo $SQL;
			$result = $db->RunQuery($SQL);	
			while($row = mysql_fetch_array($result))
				{
					$ResponseXML .= "<ID><![CDATA[" . $row["intId"]  . "]]></ID>\n";
					$ResponseXML .= "<Description><![CDATA[" . $row["strName"]  . "]]></Description>\n";
					
					
				}
		$ResponseXML .="</XMLSeamType>"; 
		echo $ResponseXML;
} 
?>

