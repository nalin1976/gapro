<?php
include "../../Connector.php";

$request=$_GET['type'];

if($request=="loadThreadDetails")
{

		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        
		$threadId=$_GET['threadId'];
		
   
       $ResponseXML="<XMLthread>";
		$SQL="SELECT intID,strthread,strCode FROM ws_thread  WHERE intID='".$threadId."';";
			
			$result = $db->RunQuery($SQL);	
			while($row = mysql_fetch_array($result))
				{
					$ResponseXML .= "<ID><![CDATA[" . $row["intID"]  . "]]></ID>\n";
					$ResponseXML .= "<Description><![CDATA[" . $row["strthread"]  . "]]></Description>\n";
					$ResponseXML .= "<codeNumber><![CDATA[" . $row["strCode"]  . "]]></codeNumber>\n";	
				}
		$ResponseXML .="</XMLthread>"; 
		echo $ResponseXML;
} 
?>

