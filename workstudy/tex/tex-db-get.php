<?php
include "../../Connector.php";

$request=$_GET['type'];

if($request=="loadtex")
{
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $intId=$_GET['intID'];	
		
		$ResponseXML="<XMLtex>";
		$SQL="SELECT intID,strDescription
			  FROM ws_tex
			  WHERE intID='".$intId."';";
			//echo $SQL;
			$result = $db->RunQuery($SQL);	
			while($row = mysql_fetch_array($result))
				{
					$ResponseXML .= "<ID><![CDATA[" . $row["intID"]  . "]]></ID>\n";
					$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
					
					
				}
		$ResponseXML .="</XMLtex>"; 
		echo $ResponseXML;
} 
?>

