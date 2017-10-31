<?php
include "../../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$request=$_GET['req'];
if($request=="loadgarment");
{
$ResponseXML="<XMLProducttype>";
$data=$_GET['data'];
	$SQL="SELECT intCatId,strCatName,strRemarks,intStatus FROM productcategory where intCatId='".$data."';";
	//echo $SQL;
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
		{
		$ResponseXML .= "<Descrtiption><![CDATA[" . $row["strRemarks"]  . "]]></Descrtiption>\n";
	    $ResponseXML .="<ProductName><![CDATA[" . $row["strCatName"]  . "]]></ProductName>\n";
        $ResponseXML .="<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	  			}
$ResponseXML .="</XMLProducttype>"; 
echo $ResponseXML;
} 
?>
