<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Department>";

$RequestType = $_GET["Departmentload"];

	$SQL="SELECT * FROM department where intDepID='".$RequestType."';";

	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<DepCode><![CDATA[" . $row["strDepartmentCode"]  . "]]></DepCode>\n";
        $ResponseXML .= "<DepartmentName><![CDATA[" . $row["strDepartment"]  . "]]></DepartmentName>\n";
		//$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
	    $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Comid><![CDATA[" . $row["intCompayID"]  . "]]></Comid>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		$ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n"; 
	}	
	 $ResponseXML .= "</Department>";
	 echo $ResponseXML;

?>
