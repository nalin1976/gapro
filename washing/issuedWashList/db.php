<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="loadOrderNolist")
{
	$styleName = $_GET["styleName"];

	$ResponseXML = "<XMLData>\n";
	
	$sql=" select distinct wih.intStyleNo, o.strOrderNo 
		   from was_issuedtowashheader wih inner join orders o on
			wih.intStyleNo = o.intStyleId  ";
			
	if($styleName!="")
		$sql .=" where  o.strStyle = '$styleName'";
	
	$sql .= "order by strStyle ";
		
		$result=$db->RunQuery($sql);
		$str .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["intStyleNo"] ."\">".$row["strOrderNo"]."</option>\n";	
	}
	$ResponseXML .= "<orderNolist><![CDATA[" . $str . "]]></orderNolist>\n";
	$ResponseXML .= "</XMLData>\n";
	echo $ResponseXML;
}

if($RequestType=="loadIssueNolist")
{
	$cboYear = $_GET["cboYear"];

	$ResponseXML = "<XMLData>\n";
	
	$sql=" select  dblIssueNo from was_issuedtowashheader where intIssueYear=$cboYear
								order by dblIssueNo  ";
			
	$sql .= "order by dblIssueNo ";
		
	$result=$db->RunQuery($sql);
		$strNofrom .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$strNofrom .= "<option value=\"". $row["dblIssueNo"] ."\">".$row["dblIssueNo"]."</option>\n";	
	}
	
	$sqlNoTo=" select  dblIssueNo from was_issuedtowashheader where intIssueYear=$cboYear
								order by dblIssueNo  ";
			
	$sqlNoTo .= "order by dblIssueNo desc ";
		
	$resultIssue =$db->RunQuery($sqlNoTo);
		$strNoTo .= "<option value=\"". "" ."\">".""."</option>\n";
	while($rowI=mysql_fetch_array($resultIssue))
	{
		$strNoTo .= "<option value=\"". $rowI["dblIssueNo"] ."\">".$rowI["dblIssueNo"]."</option>\n";	
	}
	
	$ResponseXML .= "<issuenofrom><![CDATA[" . $strNofrom . "]]></issuenofrom>\n";
	$ResponseXML .= "<issuenoTo><![CDATA[" . $strNoTo . "]]></issuenoTo>\n";
	$ResponseXML .= "</XMLData>\n";
	echo $ResponseXML;
}

?>