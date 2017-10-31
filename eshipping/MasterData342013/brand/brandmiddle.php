<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Brand>";
//$db =new DBManager();

$RequestType = $_GET["BrandID"];

//$RequestType =$_POST["txtbankcode"];

	$SQL="SELECT * FROM brand where intId='".$RequestType."';";

	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<BrandName><![CDATA[" . $row["strBrand"]  . "]]></BrandName>\n";
	 
	}	
	 $ResponseXML .= "</Brand>";
	 echo $ResponseXML;

?>