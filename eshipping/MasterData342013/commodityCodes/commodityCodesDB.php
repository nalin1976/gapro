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
	commoditycodes 
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


else if ($request=='getItemData')
{
{ 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$commoditycode=$_GET['commoditycode'];
	$XMLString= "<Data>";
	$XMLString .= "<Item>";
	
	$sql="SELECT strItemCode, strDescription, strCommodityCode, strRemarks, strUnit	FROM item
	WHERE strCommodityCode='$commoditycode';";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{ 
		$XMLString .= "<ItemId><![CDATA[" . $row["strItemCode"]  . "]]></ItemId>\n";
		$XMLString .= "<ItemName><![CDATA[" . $row["strDescription"]  . "]]></ItemName>\n";
		$XMLString .= "<Commoditycode><![CDATA[" . $row["strCommodityCode"]  . "]]></Commoditycode>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		
		
	}
	
	$XMLString .= "</Item>";
	$XMLString .= "</Data>";
	echo $XMLString;

}




}

else if($request=='checkdb')
{
	$commoditycode=$_GET['commoditycode'];
	$tax=$_GET['tax'];
	$sqlcheck="SELECT strCommodityCode	FROM commoditycodes WHERE strCommodityCode='$commoditycode' AND strTaxCode='$tax'";
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
	
	$sqlupdate="UPDATE commoditycodes 
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
	
	$sqlinsert="INSERT INTO commoditycodes 
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
	$sqlupdatepos="UPDATE commoditycodes 
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
	
	$sqldeletetax="DELETE FROM commoditycodes 
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
		
	$sqldeletetax="DELETE FROM commoditycodes 
	WHERE
	strCommodityCode = '$commoditycode'"; 	
	
	//die($sqldeletetax);  
	
	$deleteresult=$db->RunQuery($sqldeletetax);
	if ($deleteresult)
		echo "Record successfully deleted";
		
}

if ($request=='editItem')
{
	$itemname=	$_GET['Item'];
	$unit=	$_GET['unit'];
	$commodity=$_GET['commoditycode'];
	
	$check="select 	strItemCode 
			from 	item 
			where 	strCommodityCode='$commodity'";
	$resultcheck = $db->RunQuery($check);
	if(mysql_fetch_array($resultcheck)>1)
	{$wut="update";}
	else
	{$wut="insert";}

 if ($wut=="insert") 
	{		
		
	$sql = "INSERT INTO item ( strDescription,strCommodityCode, strRemarks,strUnit)
	VALUES ('$itemname','$commodity','xx','$unit')";
	//die($sql);
	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
	}
	else if ($wut=="update")
	{	

	$sql = "UPDATE item SET strDescription='$itemname',strCommodityCode='$commodity', 	strRemarks='$remarks', strUnit='$unit' WHERE strCommodityCode='$commodity'";
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{		
			echo "Successfully updated."; 		
		}

	}


}
?>