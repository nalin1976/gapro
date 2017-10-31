<?php

include "../../../Connector.php";

$RequestType = $_GET["Dryload"];

if($RequestType =="load")
{
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$RequestType = $_GET["Dryprocess"];
		
		$ResponseXML .= "<Dry>";

	$SQL="SELECT * FROM was_dryprocess where intSerialNo='".$RequestType."' order by strDescription";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<strDryProCode><![CDATA[" . $row["strDryProCode"]  . "]]></strDryProCode>\n";
		 $ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		 $ResponseXML .= "<Category><![CDATA[" . $row["strCategory"]  . "]]></Category>\n";
		 $ResponseXML .= "<FSCategory><![CDATA[" . $row["FScategory"]  . "]]></FSCategory>\n";
		 $ResponseXML .= "<strCondition><![CDATA[" . $row["strCondition"]  . "]]></strCondition>\n";
	}
	 $ResponseXML .= "</Dry>";
	 echo $ResponseXML;
}
if($RequestType == "LoadConditionDetails")
{	
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["dryprocess_cboDryProcess"];

	$ResponseXML .= "<Dry>";


	$SQL="SELECT * FROM process_termsandcondition where intProcessId='".$RequestType."' order by intTermId";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<intTermId><![CDATA[" . $row["intTermId"]  . "]]></intTermId>\n";
		 $ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
	}
	 $ResponseXML .= "</Dry>";
	 echo $ResponseXML;
}

//---------------------------------------------------
$strButton=trim($_GET["q"],' ');
if($strButton=="loadProcessId")
{
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	  
  $sql = "select MAX(intSerialNo)as intSerialNo from was_dryprocess";
 $result = $db->RunQuery($sql);
 $ResponseXML .= "<SerialNo>";	
	while($row = mysql_fetch_array($result))
	{
	 $ResponseXML .= "<intSerialNo><![CDATA[" . $row["intSerialNo"]  . "]]></intSerialNo>\n";
	}
 $ResponseXML .= "</SerialNo>";
 
 echo $ResponseXML;
}
?>
