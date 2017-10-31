<?php
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];

if ($request=='getData')
{ 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$commoditycode=$_GET['commoditycode'];
	

	$sql="select 	strCommodityCode, 
	strTaxCode, 
	intPosition, 
	dblPercentage, 
	strRemarks, 
	intMP, 
	strTaxBase,
	dblOptRates  
	from 
	excommoditycodes 
	where strCommodityCode='$commoditycode'ORDER BY intPosition";
	//die ($sql);
	$XMLString= "<Data>";
	$XMLString .= "<CommodityDetail>";
	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{	
	
		if(is_null($row["dblOptRates"]))
			$row["dblOptRates"]=0;
		if(is_null($row["strTaxCode"]))
			$row["strTaxCode"]='notset';
		if(is_null($row["strTaxBase"]))
			$row["strTaxBase"]='100%';
			
		
		$XMLString .= "<CommodityCode><![CDATA[" . $row["strCommodityCode"]  . "]]></CommodityCode>\n";
		$XMLString .= "<TaxCode><![CDATA[" . $row["strTaxCode"]  . "]]></TaxCode>\n";
		$XMLString .= "<Percentage ><![CDATA[" . $row["dblPercentage"]  . "]]></Percentage>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<MP><![CDATA[" . $row["intMP"]  . "]]></MP>\n";
		$XMLString .= "<TaxBase><![CDATA[" . $row["strTaxBase"]  . "]]></TaxBase>\n";
		$XMLString .= "<intPosition><![CDATA[" . $row["intPosition"]  . "]]></intPosition>\n";
		$XMLString .= "<OptRates><![CDATA[" . $row["dblOptRates"]  . "]]></OptRates>\n";	
				
	}
	
	$XMLString .= "</CommodityDetail>";
	$XMLString .= "</Data>";
	echo $XMLString;
}



else if($request=='checkdb')
{
	$commoditycode=$_GET['commoditycode'];
	$tax=$_GET['tax'];
	$sqlcheck="SELECT strCommodityCode	FROM excommoditycodes WHERE strCommodityCode='$commoditycode' AND strTaxCode='$tax'";
	//die($sqlcheck);
	$checkresult=$db->RunQuery($sqlcheck);
	if (mysql_fetch_array($checkresult)>0)
	{
	echo "update";	
	}
	else
	echo "insert";
}

else if($request=='update')
{	

	$commoditycode=$_GET['commoditycode'];
	$tax=$_GET['tax'];	
	$MP=$_GET['MP'];
	$rates=$_GET['rates'];
	$taxbase=$_GET['taxbase'];
	$position=$_GET['position'];
	$optrate=$_GET['txtRateOpt'];
	
	$sqlupdate="UPDATE excommoditycodes 
	SET
	intPosition = '$position' , 
	dblPercentage = '$rates' , 
	intMP = '$MP' , 
	strTaxBase = '$taxbase', 	
	dblOptRates='$optrate'
	WHERE
	strCommodityCode = '$commoditycode' AND 
	strTaxCode = '$tax'";
	//die ($sqlupdate);  
	$updateresult=$db->RunQuery($sqlupdate);
	if ($updateresult)
		echo "Successfully updated";
		
}
else if($request=='insert')
{


	$commoditycode=$_GET['commoditycode'];
	$tax=$_GET['tax'];	
	$MP=$_GET['MP'];
	$rates=$_GET['rates'];
	$taxbase=$_GET['taxbase'];
	$position=$_GET['position'];
	$remarks=$_GET['remarks'];
	$optrate=$_GET['txtRateOpt'];
	
	$sqlinsert="INSERT INTO excommoditycodes 
	(strCommodityCode, 
	strTaxCode, 
	intPosition, 
	dblPercentage, 
	strRemarks, 
	intMP, 
	strTaxBase,
	dblOptRates	
	)
	VALUES
	('$commoditycode', 
	'$tax', 
	'$position', 
	'$rates', 
	'$remarks', 
	'$MP', 
	'$taxbase',
	'$optrate')";
//die ($sqlinsert);  
	$insertresult=$db->RunQuery($sqlinsert);
	if ($insertresult)
		echo "Successfully saved";
		
}

else if($request=='position')
{	

	$commoditycode=$_GET['commoditycode'];
	$tax=$_GET['tax'];	
	$position=$_GET['position'];
	$sqlupdatepos="UPDATE excommoditycodes 
	SET
	intPosition = '$position'  
	WHERE
	strCommodityCode = '$commoditycode' AND 
	strTaxCode = '$tax'";
//die ($sqlupdate);  
	$updateresultpso=$db->RunQuery($sqlupdatepos);
	if ($updateresultpso)
		echo "Successfully updated";
		
}
else if($request=='delete')
{

	$commoditycode=$_GET['commoditycode'];
	$tax=$_GET['tax'];
	if ($tax=='undefined')
		$tax='';	
	$position=$_GET['position'];
	
	$sqldeletetax="DELETE FROM excommoditycodes 
	WHERE
	strCommodityCode = '$commoditycode' AND 
	strTaxCode = '$tax'";
	
	//die($sqldeletetax);  
	
	$deleteresult=$db->RunQuery($sqldeletetax);
	if ($deleteresult)
		echo "Successfully deleted";
		
}

else if($request=='deletecommodity')
{

	$commoditycode=$_GET['commoditycode'];
		
	$sqldeletetax="DELETE FROM excommoditycodes 
	WHERE
	strCommodityCode = '$commoditycode'"; 	
	
	//die($sqldeletetax);  
	
	$deleteresult=$db->RunQuery($sqldeletetax);
	if ($deleteresult)
		echo "Record successfully deleted";
		
}

else if($request=='insertHeader')
{	
	$commoditycode=$_GET['commoditycode'];
	$remarks=$_GET['remarks'];
	
	$sql="select 	strCommodityCode, 
	from 
	excommoditycodes 
	where strCommodityCode='$commoditycode'";
	$result = $db->RunQuery($sql); 
	if (mysql_num_rows($result)<1)
	{
		$sqlinsert="INSERT INTO excommoditycodes 
	(strCommodityCode, 
	strTaxCode, 
	intPosition, 
	dblPercentage, 
	strRemarks, 
	intMP, 
	strTaxBase,
	dblOptRates	
	)
	VALUES
	('$commoditycode', 
	'', 
	'0', 
	'1', 
	'$remarks', 
	'1', 
	'1',
	'1')";
//die ($sqlinsert);  
	$insertresult=$db->RunQuery($sqlinsert);
	if ($insertresult)
		echo "Successfully saved";
	
	
	}
	
}

