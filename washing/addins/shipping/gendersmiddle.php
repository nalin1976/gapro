<?php

include "../../../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$request=$_GET['req'];

if($request=="Loadgender");
{ 
$ResponseXML= "<XMLgender>";
$data=$_GET['data'];
	$SQL="SELECT intGenderId,strDescription,strGenderCode,intStatus FROM gender WHERE  intGenderId='".$data."';";
//echo $SQL;

	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<GenderCode><![CDATA[" . $row["strGenderCode"]  . "]]></GenderCode>\n";
        $ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}	
	 $ResponseXML .= "</XMLgender>";
	 echo $ResponseXML;
  } 
  
if($request == "LoadgenderCbo")
{
	$ResponseXML= "<XMLgenderAll>";	
	$SQL="SELECT intGenderId,strGenderCode FROM gender ;";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<GenderCode><![CDATA[" . $row["strGenderCode"]  . "]]></GenderCode>\n";
        $ResponseXML .= "<intGenderId><![CDATA[" . $row["intGenderId"]  . "]]></intGenderId>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}	
	 $ResponseXML .= "</XMLgenderAll>";
	 echo $ResponseXML;
}
?>
