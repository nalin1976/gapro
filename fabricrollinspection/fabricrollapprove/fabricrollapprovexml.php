<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$CompanyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="LoadSupplierBatch")
{
	$StyleID =$_GET["StyleID"];
	$ResponseXML="";
	
	$SQL ="select Distinct intSupplierBatchNo from fabricrollheader where intStyleId='$StyleID' Order By intSupplierBatchNo;";

	$result=$db->RunQuery($SQL);
			$ResponseXML .=	"<option value=\"".""."\">" .""."</option>";
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<option value=\"".$row["intSupplierBatchNo"]."\">".$row["intSupplierBatchNo"]."</option>\n";
		}
	
	echo $ResponseXML;
}
elseif($RequestType=="LoadSupplier")
{
	$StyleID =$_GET["StyleID"];
	$SuppBatchNo =$_GET["SuppBatchNo"];
	$ResponseXML="";
	
	$SQL ="select Distinct FRH.strSupplierID,
(select strTitle from suppliers S where S.strSupplierID=FRH.strSupplierID) AS SupplierName
from fabricrollheader FRH where intStyleId='$StyleID' AND intSupplierBatchNo='$SuppBatchNo' 
Order By SupplierName;";
	//echo $SQL;
	$result=$db->RunQuery($SQL);
			$ResponseXML .=	"<option value=\"".""."\">" .""."</option>";
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<option value=\"".$row["strSupplierID"]."\">".$row["SupplierName"]."</option>\n";
		}	
	echo $ResponseXML;
}
elseif($RequestType=="LoadRollNo")
{
	$StyleID 		= $_GET["StyleID"];
	$SuppBatchNo 	= $_GET["SuppBatchNo"];
	$SupplierID 	= $_GET["SupplierID"];
	$ResponseXML	= "";
	
	$SQL ="select  concat(intFRollSerialYear,'/',intFRollSerialNO)AS RollSerialNo from  fabricrollheader
where intStyleId='$StyleID' AND intSupplierBatchNo='$SuppBatchNo' AND strSupplierID='$SupplierID';";

	$result=$db->RunQuery($SQL);
			$ResponseXML .=	"<option value=\"".""."\">" .""."</option>";
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<option value=\"".$row["RollSerialNo"]."\">".$row["RollSerialNo"]."</option>\n";
		}	
	echo $ResponseXML;
}
elseif($RequestType=="LoadDetailsToMainTable")
{
	$StyleID 		= $_GET["StyleID"];
	$SuppBatchNo 	= $_GET["SuppBatchNo"];
	$SupplierID 	= $_GET["SupplierID"];
	$RollNo 		= $_GET["RollNo"];
		$RollNoArray	= explode('/',$RollNo);
	$ResponseXML	= "";
	$ResponseXML .="<LoadDetailsToMainTable>";
	
	$SQL ="select FRH.*,FRD.*,
	(select intSRNO from specification S Where S.intStyleId=FRH.intStyleId) AS SCNO,
	(select strItemDescription from matitemlist MIL Where MIL.intItemSerial=FRH.strMatDetailID) AS ItemDescription,
	(select strTitle from suppliers S Where S.strSupplierID=FRH.strSupplierID) AS SupplierName
	 from  fabricrollheader FRH
			Inner join fabricrolldetails FRD
			ON FRH.intFRollSerialNO=FRD.intFRollSerialNO AND FRH.intFRollSerialYear=FRD.intFRollSerialYear
			where intStyleId='$StyleID'
			AND intSupplierBatchNo ='$SuppBatchNo'
			AND strSupplierID='$SupplierID'
			AND FRH.intFRollSerialNO=$RollNoArray[1]
			AND FRH.intFRollSerialYear=$RollNoArray[0];";
	//echo $SQL;
	$result=$db->RunQuery($SQL);
		
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<RollNo><![CDATA[".$row["intRollNo"]."]]></RollNo>\n";
			$ResponseXML .="<StyleID><![CDATA[".$row["intStyleId"]."]]></StyleID>\n";
			$ResponseXML .="<SCNO><![CDATA[".$row["SCNO"]."]]></SCNO>\n";
			$ResponseXML .="<BuyerPoNo><![CDATA[".$row["strBuyerPoNo"]."]]></BuyerPoNo>\n";
				$ResponseXML .="<MatDetailID><![CDATA[".$row["strMatDetailID"]."]]></MatDetailID>\n";
			$ResponseXML .="<ItemDescription><![CDATA[".$row["ItemDescription"]."]]></ItemDescription>\n";
			$ResponseXML .="<Color><![CDATA[".$row["strColor"]."]]></Color>\n";
			$ResponseXML .="<SupplierBatchNo><![CDATA[".$row["intSupplierBatchNo"]."]]></SupplierBatchNo>\n";
			$ResponseXML .="<SupplierName><![CDATA[".$row["SupplierName"]."]]></SupplierName>\n";
			$ResponseXML .="<Inspected><![CDATA[".$row["intInspected"]."]]></Inspected>\n";
			$ResponseXML .="<Approved><![CDATA[".$row["intApproved"]."]]></Approved>\n";
			$ResponseXML .="<Qty><![CDATA[".$row["dblQty"]."]]></Qty>\n";
			$ResponseXML .="<ApprovedQty><![CDATA[".$row["dblApprovedQty"]."]]></ApprovedQty>\n";
			$ResponseXML .="<RejectedQty><![CDATA[".$row["dblRejectedQty"]."]]></RejectedQty>\n";
			$ResponseXML .="<SpecialComments><![CDATA[".$row["strSpecialComments"]."]]></SpecialComments>\n";
			
		}
	$ResponseXML .="</LoadDetailsToMainTable>";
	echo $ResponseXML;
}
elseif($RequestType=="Save")
{
	$rollSerialNo	= $_GET["rollSerialNo"];
		$rollSerialNoArray	= explode('/',$rollSerialNo);
	$rollNo			= $_GET["rollNo"];
	$inspect		= $_GET["inspect"];
	$approved		= $_GET["approved"];
	$appQty			= $_GET["appQty"];
	$rejQty			= $_GET["rejQty"];
	
	$sql="update fabricrolldetails 
		set	 
		intInspected = $inspect , 
		intApproved = $approved , 
		dblApprovedQty = $appQty ,
		dblBalQty = $appQty,  
		dblRejectedQty = $rejQty 	
		where
		intFRollSerialNO = '$rollSerialNoArray[1]' 
		and intFRollSerialYear = '$rollSerialNoArray[0]' 
		and intRollNo = '$rollNo' ;";
	
	$result=$db->RunQuery($sql);
	
}
?>
