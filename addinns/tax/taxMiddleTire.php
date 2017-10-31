<?php
session_start();
include('../../Connector.php');
$RequestType = $_GET["RequestType"];
if (strcmp($RequestType,"DeleteTax") == 0)
{
	$taxID = $_GET["taxID"];
	$sql = "DELETE FROM taxtypes where strTaxTypeID =$taxID";
	//$result = $db->RunQuery($sql);
	 $result = $db->RunQuery2($sql);
 	if(gettype($result)=='string')
 	{
		echo $result;
		return;
 	}
 	echo "Deleted successfully.";
}
else if (strcmp($RequestType,"NewTax") == 0)
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$strTaxType = $_GET["taxType"];
	$dblRate= $_GET["taxRate"];
	$intStatus = $_GET["intStatus"];
	$gl	=$_GET['gl'];
	$ResponseXML .= "<RequestDetails>\n";
	$ResponseXML .= "<Result><![CDATA[". AddTaxDetails($strTaxType, $dblRate,$intStatus,$gl) ."]]></Result>\n";
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"updateTax") == 0)
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML 	.= "<RequestDetails>\n";
	$taxID 		= $_GET["taxID"];
	$strTaxType = $_GET["taxType"];
	$dblRate	= $_GET["taxRate"];
	$pTax		= $_GET['pTax'];
	$intStatus 	= $_GET["intStatus"];
	$gl			= $_GET['gl'];
	
	$SQL = "update taxtypes set strTaxType='$strTaxType', dblRate = '$dblRate', intStatus='$intStatus' ,intGLID='$gl' where strTaxTypeID ='$taxID'";
	$result = $db->RunQuery($SQL);		
	if($result == 1)
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
	}

	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"loadViewData") == 0)
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .="<loadTax>";
 $SQL = "SELECT T.strTaxTypeID,T.strTaxType,T.dblRate,T.intStatus,T.intGLId,T.intUsed,concat(G.strAccID,'',C.strCode)as glCode
FROM taxtypes T
left join glallowcation GA on GA.GLAccAllowNo=T.intGLId
left Join glaccounts G ON G.intGLAccID = GA.GLAccNo 
left join costcenters C on C.intCostCenterId=GA.FactoryCode 
order by T.strTaxType;";
 $result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
	$ResponseXML .= "<strTaxTypeID><![CDATA[".trim($row["strTaxTypeID"])  . "]]></strTaxTypeID>\n";	
	$ResponseXML .= "<strTaxType><![CDATA[".trim($row["strTaxType"])  . "]]></strTaxType>\n";	
	$ResponseXML .= "<dblRate><![CDATA[".trim($row["dblRate"])  . "]]></dblRate>\n";
	$ResponseXML .= "<intStatus><![CDATA[".trim($row["intStatus"])  . "]]></intStatus>\n";	
	$ResponseXML .= "<TAXGL><![CDATA[".trim($row["glCode"])  . "]]></TAXGL>\n";	
	$ResponseXML .= "<TAXGLID><![CDATA[".trim($row["intGLId"])  . "]]></TAXGLID>\n";	
	}
$ResponseXML .= "</loadTax>";
echo $ResponseXML;
}


function DeleteTaxDetails($taxID)
{
	global $db;
	$sql = "DELETE FROM taxtypes where strTaxTypeID =$taxID AND  intUsed != '1'";
	$db->executeQuery($sql);
	return true;
}

function AddTaxDetails($strTaxType, $dblRate,$intStatus,$gl)
{
	global $db;
	$sql = "select strTaxType from taxtypes where strTaxType = '$strTaxType'";
	$result = $db->RunQuery($sql);
	$rows = mysql_num_rows($result);
	if ($rows > 0)
	{
		return -2;
	}
	else
	{	
		$sql = "insert into taxtypes (strTaxType,dblRate,intStatus,intGLId) values ('$strTaxType',$dblRate,$intStatus,'$gl');";
		$newID = $db->AutoIncrementExecuteQuery($sql);
		return $newID;
	}
	return -2;
	
}
?>