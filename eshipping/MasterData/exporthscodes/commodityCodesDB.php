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
	dblOptRates,
	strFabric,
	strCatNo,
	strDescription
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
		
		$XMLString .= "<Fabric><![CDATA[" . $row["strFabric"]  . "]]></Fabric>\n";
		$XMLString .= "<CatNo><![CDATA[" . $row["strCatNo"]  . "]]></CatNo>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";	
				
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
	$fabric=$_GET['fabric'];
	$description=$_GET['description'];
	$catNo=$_GET['catNo'];
	
	 $sql="select 	strCommodityCode 
	from 
	excommoditycodes 
	where strCommodityCode='$commoditycode'";
	$result = $db->RunQuery($sql); 
	if (mysql_num_rows($result)<1)
	{
		echo $sqlinsert="INSERT INTO excommoditycodes 
	(strCommodityCode, 
	strTaxCode, 
	intPosition, 
	dblPercentage, 
	strRemarks, 
	intMP, 
	strTaxBase,
	dblOptRates,
	strFabric,
	strDescription,
	strCatNo
	)
	VALUES
	('$commoditycode', 
	'', 
	'0', 
	'1', 
	'$remarks', 
	'1', 
	'1',
	'1',
	'$fabric',
	'$description',
	'$catNo')";
//die ($sqlinsert);  
	$insertresult=$db->RunQuery($sqlinsert);
	if ($insertresult)
		echo "Successfully saved";
	
	
	}
	
}
if($request=='saveCategoryData')
{
	$cboCatName=$_GET['cboCatName'];
	$categoryName=$_GET['txtCatname'];
	$Catnum = $_GET['txtCatnum'];
	//echo $CountryList = $_GET['cboCountryList'];
	$country = $_GET['strCountr'];
	
	/*$sql_check="SELECT strCatNo FROM quotacat WHERE strCatNo='$categoryName';";
	$result_check=$db->RunQuery($sql_check);
	if(mysql_num_rows($result_check)==0)
	{*/
		if($cboCatName==0)
		{
			 $sql_check="SELECT strCatName,strCatNo,strContry FROM quotacat WHERE strCatName='$categoryName';";
			$result_check=$db->RunQuery($sql_check);
			if(mysql_num_rows($result_check)==0)
			{
				 $sql="INSERT INTO quotacat(strCatNo,strCatName,strContry)
						VALUES('$Catnum','$categoryName','$country')";
				$result=$db->RunQuery($sql);
				if($result)
					echo "Saved Successfully";
				else
					echo "Saving Error";
						
			}
			else
				echo "Name Exists.Try another one";
		}	
		else
		{	
			$sql="UPDATE quotacat SET strCatName='$categoryName' WHERE strCatNo='$categoryName'";
			$result=$db->RunQuery($sql);
			if($result)
				echo "Saved Successfully";
			else
				echo "Saving Error";
		}
}
if($request=='loadCategoryData')
{
	$sql="SELECT DISTINCT strCatName FROM quotacat ORDER BY strCatName;";	
	$result=$db->RunQuery($sql);
	$res="<option value=0></option>";
	while($row=mysql_fetch_array($result))
	{
		$res.="<option value=".$row['strCatName'].">".$row['strCatName']."</option>";
	}
	
	echo $res;
}



if($request=="deleteCategoryData")
{
	
	$CatNo = $_GET['cboCategory'];
	$sql_delete = "DELETE FROM quotacat WHERE intId=$CatNo"; 
	$result = $db->RunQuery($sql_delete);
	
	if($result)
		echo "Deleted Successfully";
	else	
		echo "Deleting Failed";
}	
if($request=="gatCatDet")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$catId = $_GET['catId'];
	$XMLString= "<Data>";
	$XMLString .= "<CatDet>";
	
	$sql = "SELECT
			quotacat.intId,
			quotacat.strCatNo,
			quotacat.intStatus,
			quotacat.strCatName,
			quotacat.strContry
			FROM
			quotacat WHERE intId=$catId"; 
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<CatNo><![CDATA[" . $row["strCatNo"]  . "]]></CatNo>\n";
		$XMLString .= "<CatName><![CDATA[" . $row["strCatName"]  . "]]></CatName>\n";
		$XMLString .= "<Country ><![CDATA[" . $row["strContry"]  . "]]></Country>\n";
	}
	$XMLString .= "</CatDet>";
	$XMLString .= "</Data>";
	echo $XMLString;
}	
	

?>