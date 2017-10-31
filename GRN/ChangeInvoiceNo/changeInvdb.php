<?php 
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="loadGRN")
{
	$grnYear = $_GET["grnYear"];

	$ResponseXML = "<XMLGRNList>\n";
	
	$sql="select intGrnNo from grnheader where intGRNYear= '$grnYear' and intCompanyID= '$companyId' order by intGrnNo desc ";
	
	$result=$db->RunQuery($sql);
		$str .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["intGrnNo"] ."\">".$row["intGrnNo"]."</option>\n";	
	}
	
	$ResponseXML .= "<GRNno><![CDATA[" . $str . "]]></GRNno>\n";
	$ResponseXML .= "</XMLGRNList>\n";
	echo $ResponseXML;
}

if($RequestType=="getInvNo")
{
	$grnYear = $_GET["grnYear"];
	$grnNo = $_GET["grnNo"];

	$ResponseXML = "<XMLInvNo>\n";
	
	$invNo = getInvoiceNo($grnNo,$grnYear);
	
	$ResponseXML .= "<InvNo><![CDATA[" . $invNo . "]]></InvNo>\n";
	$ResponseXML .= "</XMLInvNo>\n";
	echo $ResponseXML;
}
if($RequestType=="updateInvDetails")
{
	$grnYear = $_GET["grnYear"];
	$grnNo = $_GET["grnNo"];
	$invNo = $_GET["invNo"];
	
	$ResponseXML = "<XMLInvNo>\n";
	
	$sql=" select * from invoiceheader where strInvoiceNo='$invNo' ";
	
	$result=$db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	
	$str = '';
	if($rowCount>0)
	{
		$str = 'Invoice number alrady available';
	}
	else
	{
		updateInvNo($invNo,$grnNo,$grnYear);
		$str = 'Invoce Number updated successfully ';
	}
	
	$ResponseXML .= "<InvNoRes><![CDATA[" . $str . "]]></InvNoRes>\n";
	$ResponseXML .= "</XMLInvNo>\n";
	echo $ResponseXML;
}

function updateInvNo($invNo,$grnNo,$grnYear)
{
	global $db;
	
	$sql = " update grnheader
			set strInvoiceNo='$invNo'
			where intGrnNo='$grnNo' and intGRNYear = '$grnYear' ";
			
	$db->RunQuery($sql);
}

function getInvoiceNo($grnNo,$grnYear)
{
	global $db;
	
	$sql = "select strInvoiceNo from grnheader where intGRNYear='$grnYear'  and intGrnNo = '$grnNo'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	$invNo = $row["strInvoiceNo"];
	
	return $invNo;
}
?>