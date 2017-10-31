<?php 
session_start();
include("../../Connector.php");
$request = $_GET['request'];	
if($request=="saveData") 
{
	$mainBuyerId = $_GET['mainBuyerId'];
	$mainBuyerCode = $_GET['mainBuyerCode'];
	$mainBuyerName = $_GET['mainBuyerName'];
	
	$mainBuyerAddress1 = $_GET['mainBuyerAddress1'];
	$mainBuyerAddress2 = $_GET['mainBuyerAddress2'];
	$mainBuyerAddress3 = $_GET['mainBuyerAddress3'];
	$mainBuyerCountry = $_GET['mainBuyerCountry'];
	$mainBuyerCreditPeriod = $_GET['mainBuyerCreditPeriod'];
	
	
	$sql_check = "SELECT intMainBuyerId FROM buyers_main WHERE intMainBuyerId = $mainBuyerId";
	$result_check = $db->RunQuery($sql_check);
	
	if(mysql_num_rows($result_check)==0)
	{
		$sql_insert = "INSERT INTO buyers_main (strMainBuyerCode,strMainBuyerName,intStatus,strAddress1,strAddress2,strAddress3,strCountry,intCreditPeriod) VALUES('$mainBuyerCode','$mainBuyerName',1,'$mainBuyerAddress1','$mainBuyerAddress2','$mainBuyerAddress3','$mainBuyerCountry',$mainBuyerCreditPeriod)";
		$result_insert = $db->RunQuery($sql_insert);
		
		if($result_insert)
			echo "Saved Successfully";
		else
			echo "Saving Failed";
	}
	else
	{
		$sql_update = "UPDATE buyers_main SET strMainBuyerCode = '$mainBuyerCode', strMainBuyerName='$mainBuyerName', strAddress1='$mainBuyerAddress1', strAddress2='$mainBuyerAddress2', strAddress3='$mainBuyerAddress3', strCountry='$mainBuyerCountry', intCreditPeriod=$mainBuyerCreditPeriod  WHERE intMainBuyerId = $mainBuyerId";
		$result_update = $db->RunQuery($sql_update);
		
		if($result_update)
			echo "Successfully Updated";
		else
			echo "Updating Failed";
	}
}
if($request=='getData')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<MainBuyerData>";

	$mainBuyerId=$_GET['mainBuyerId'];
	
	$sql = "SELECT
			intMainBuyerId,
			strMainBuyerCode,
			strMainBuyerName,
			intStatus,
			strAddress1,
			strAddress2,
			strAddress3,
			strCountry,
			intCreditPeriod
			FROM buyers_main
			WHERE intMainBuyerId = $mainBuyerId";
			
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<MainBuyerCode><![CDATA[" . $row["strMainBuyerCode"]  . "]]></MainBuyerCode>\n";
		$ResponseXML .= "<MainBuyerName><![CDATA[" . $row["strMainBuyerName"]  . "]]></MainBuyerName>\n";
		$ResponseXML .= "<MainBuyerAddress1><![CDATA[" . $row["strAddress1"]  . "]]></MainBuyerAddress1>\n";
		$ResponseXML .= "<MainBuyerAddress2><![CDATA[" . $row["strAddress2"]  . "]]></MainBuyerAddress2>\n";
		$ResponseXML .= "<MainBuyerAddress3><![CDATA[" . $row["strAddress3"]  . "]]></MainBuyerAddress3>\n";
		$ResponseXML .= "<MainBuyerCountry><![CDATA[" . $row["strCountry"]  . "]]></MainBuyerCountry>\n";
		$ResponseXML .= "<MainBuyerCreditPeriod><![CDATA[" . $row["intCreditPeriod"]  . "]]></MainBuyerCreditPeriod>\n";
	}
	$ResponseXML .= "</MainBuyerData>";
	echo $ResponseXML;
}