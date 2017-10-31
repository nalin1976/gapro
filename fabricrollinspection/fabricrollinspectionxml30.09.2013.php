<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$CompanyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="LoadPoNo")
{
	$year =$_GET["year"];
	
	$ResponseXML .="<LoadPoNo>\n";
	
	$SQL ="select distinct intPONo from purchaseorderheader where intStatus=10 AND intYear=$year;";

	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			//$ResponseXML .="<PoNo><![CDATA[".$row["intPONo"]."]]></PoNo>\n";
		$ResponseXML .="<option value=\"". $row["intPONo"] ."\">" . $row["intPONo"] ."</option>" ;
		}
	$ResponseXML .="</LoadPoNo>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadSupplier")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	
	$ResponseXML .="<LoadSupplier>\n";
	
	$SQL ="select (select strTitle from suppliers S where S.strSupplierID=POH.strSupplierID) as Supplier, POH.strSupplierID ".
		"from purchaseorderheader POH where intPONo='$PoNo' AND intYear=$year;";

	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Supplier><![CDATA[".$row["Supplier"]."]]></Supplier>\n";
			$ResponseXML .="<SupplierID><![CDATA[".$row["strSupplierID"]."]]></SupplierID>\n";
		}
	$ResponseXML .="</LoadSupplier>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadStyle")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	
	$ResponseXML .="<LoadStyleRequest>\n";
	
	$SQL ="select distinct POD.intStyleId,SP.intSRNO from purchaseorderdetails POD ".
		  "Inner Join ".
		  "specification SP ON SP.intStyleId=POD.intStyleId ".
		  "where  POD.intPoNo=$PoNo AND ".
		  "POD.intYear=$year;";
	
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<StyleID><![CDATA[".$row["intStyleId"]."]]></StyleID>\n";
			$ResponseXML .="<SRNO><![CDATA[".$row["intSRNO"]."]]></SRNO>\n";
		}
	$ResponseXML .="</LoadStyleRequest>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadBuyerPoNo")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	$StyleId =$_GET["StyleId"];
	
	$ResponseXML .="<LoadBuyerPoNo>\n";
	
	$SQL ="select Distinct POD.strBuyerPONO from purchaseorderdetails POD ".
			"where  POD.intPoNo=$PoNo AND ".
			"POD.intYear=$year AND ".
			"POD.intStyleId='$StyleId ';";
	
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<BuyerPoNo><![CDATA[".$row["strBuyerPONO"]."]]></BuyerPoNo>\n";			
		}
	$ResponseXML .="</LoadBuyerPoNo>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadDescription")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	$StyleId =$_GET["StyleId"];
	$BuyerPoNo =$_GET["BuyerPoNo"];
	$BuyerPoNo = str_replace("Main Ratio","#Main Ratio#",$BuyerPoNo);
	
	$ResponseXML .="<LoadDescription>\n";
	
	$SQL ="select Distinct POD.intMatDetailID,MIL.strItemDescription from purchaseorderdetails POD ".
		 "Inner join matitemlist MIL ON POD.intMatDetailID=MIL.intItemSerial ".
		 "where  POD.intPoNo=$PoNo AND ".
		 "POD.intYear=$year AND ".
		 "POD.intStyleId='$StyleId' AND ".
		 "POD.strBuyerPONO='$BuyerPoNo';";
	
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<MatDetailID><![CDATA[".$row["intMatDetailID"]."]]></MatDetailID>\n";			
			$ResponseXML .="<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";	
		}
	$ResponseXML .="</LoadDescription>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadColor")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	$StyleId =$_GET["StyleId"];
	$BuyerPoNo =$_GET["BuyerPoNo"];
	$BuyerPoNo = str_replace("Main Ratio","#Main Ratio#",$BuyerPoNo);	
	$MatDetailID =$_GET["MatDetailID"];
	
	$ResponseXML .="<LoadColor>\n";
	
	$SQL ="select Distinct POD.strColor from purchaseorderdetails POD ".
			"where  POD.intPoNo='$PoNo' AND ".
			"POD.intYear=$year AND ".
			"POD.intStyleId='$StyleId' AND ".
			"POD.strBuyerPONO='$BuyerPoNo' AND  ".
			"POD.intMatDetailID='$MatDetailID';";
	
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Color><![CDATA[".$row["strColor"]."]]></Color>\n";	
		}
	$ResponseXML .="</LoadColor>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadNo")
{		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
		$Sql="select intCompanyID,dblFabricRollSerialNo from syscontrol where intCompanyID='$CompanyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{	
					$rollYear = date('Y');			
					$No=$row["dblFabricRollSerialNo"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblFabricRollSerialNo='$NextNo' WHERE intCompanyID='$CompanyId';";				
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
					$ResponseXML .= "<Year><![CDATA[" . $rollYear. "]]></Year>\n";
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
elseif($RequestType=="SaveHeader")
{
	$rollSerialNo 		= $_GET["rollSerialNo"];
	$rollSerialYear	 	= $_GET["rollSerialYear"];
	$PoNo 				= $_GET["PoNo"];	
	$year			 	= $_GET["year"];
	$SupplierID 		= $_GET["SupplierID"];
	$StyleID 			= $_GET["StyleID"];
	$MatDetailID 		= $_GET["MatDetailID"];
	$Color 				= $_GET["Color"];	
	$BuyerPoNo 			= $_GET["BuyerPoNo"];
		$BuyerPoNo 		= str_replace("Main Ratio","#Main Ratio#",$BuyerPoNo);
	$SupBatchNo 		= $_GET["SupBatchNo"];		
	$CompBatchNo 		= $_GET["CompBatchNo"];
	$Remarks			= $_GET["Remarks"];
	$mainStoreID		= $_GET["mainStoreID"];
	
	$sql_header= "insert into fabricrollheader ".
		  "(intFRollSerialNO, ".
		  "intFRollSerialYear, ".
		  "intPoNo, ".
		  "intPoYear, ".
		  "strSupplierID, ".
		  "intStyleId, ".
		  "strMatDetailID, ".
		  "strColor, ".
		  "strBuyerPoNo, ".
		  "intStatus, ".
		  "intSupplierBatchNo, ".
		  "intCompanyBatchNo, ".
		  "intStoresID, ".
		  "intUserID, ".
		  "dtmDate, ".
		  "strRemarks, ". 
		  "intCompanyID) ".
		  "values ".
		  "('$rollSerialNo', ".
		  "'$rollSerialYear	',  ".
		  "'$PoNo', ".
		  "'$year', ".
		  "'$SupplierID', ".
		  "'$StyleID', ".
		  "'$MatDetailID', ".
		  "'$Color', ".
		  "'$BuyerPoNo', ".
		  "'1', ".
		  "'$SupBatchNo', ".
		  "'$CompBatchNo', ".
		  "'$mainStoreID', ".
		  "'$UserID', ".
		  "now(), ".
		  "'$Remarks', ".
		  "'$CompanyId');";

	$db->executeQuery($sql_header);
echo $sql_header;
}
elseif($RequestType=="SaveDetails")
{
	$rollSerialNo 		= $_GET["rollSerialNo"];
	$rollSerialYear	 	= $_GET["rollSerialYear"];
	$RollNo 			= $_GET["RollNo"];	
	$SuppWidth			= $_GET["SuppWidth"];
	$CompWidth 			= $_GET["CompWidth"];
	$WidthUOM 			= $_GET["WidthUOM"];
	$SuppLength 		= $_GET["SuppLength"];
	$CompLength 		= $_GET["CompLength"];	
	$LengthUOM 			= $_GET["LengthUOM"];
	$SuppWeight 		= $_GET["SuppWeight"];		
	$CompWeight 		= $_GET["CompWeight"];
	$WeighUOM			= $_GET["WeighUOM"];
	$SpecialComm		= $_GET["SpecialComm"];
	$shrink_width		= $_GET["shrink_width"];
	$shrink_length		= $_GET["shrink_length"];
	$ptrn				= $_GET["ptrn"];		
	
	$SQL= "insert into fabricrolldetails ".
	"(intFRollSerialNO, ".
	"intFRollSerialYear, ".
	"intRollNo, ".
	"dblSuppWidth, ". 
	"dblCompWidth, ".
	"strWidthUOM, ".
	"dblSuppLength, ".
	"dblCompLength, ".
	"strLengthUOM, ".
	"dblSuppWeight, ".
	"dblCompWeight, ".
	"strWeightUOM, ".
	"dblQty, ".	
	"strSpecialComments, 
	dblShrinkWidth, 
	dblShrinkLength, 
	dblPtrn) ".
	"values ".
	"('$rollSerialNo', ".
	"'$rollSerialYear', ".
	"'$RollNo', ".
	"'$SuppWidth', ". 
	"'$CompWidth', ".
	"'$WidthUOM', ".
	"'$SuppLength', ".
	"'$CompLength', ".
	"'$LengthUOM', ".
	"'$SuppWeight', ".
	"'$CompWeight', ".
	"'$WeighUOM', ".
	"'$SuppLength', ".	
	"'$SpecialComm',".
	"'$shrink_width', ".
	"'$shrink_length', ".	
	"'$ptrn'".
	");";

	$db->executeQuery($SQL);
	echo $SQL;
}
else if ($RequestType=="SaveValidate")
{
	$rollSerialNo=$_GET["rollSerialNo"];
	$rollSerialYear =$_GET["rollSerialYear"];
	$validateCount =$_GET["validateCount"];	
		
	$ResponseXML .="<SaveValidate>\n";
	
	$SQLHeder="SELECT COUNT(intFRollSerialNO) AS headerRecCount FROM fabricrollheader where intFRollSerialNO=$rollSerialNo AND intFRollSerialYear=$rollSerialYear";
	
	$resultHeader=$db->RunQuery($SQLHeder);
	
			while($row = mysql_fetch_array($resultHeader)){		
				$recCountHeader=$row["headerRecCount"];
			
				if($recCountHeader>0){
					$ResponseXML .= "<recCountHeader><![CDATA[TRUE]]></recCountHeader>\n";
				}
				else{	
					$ResponseXML .= "<recCountHeader><![CDATA[FALSE]]></recCountHeader>\n";
				}
			}	
			
	$SQLDetail="SELECT COUNT(intFRollSerialNO) AS DetailsRecCount FROM fabricrolldetails where intFRollSerialNO=$rollSerialNo AND intFRollSerialYear=$rollSerialYear";
	
	$resultDetail=$db->RunQuery($SQLDetail);
		
			while($row =mysql_fetch_array($resultDetail)){
				$recCountDetails=$row["DetailsRecCount"];
				
					if($recCountDetails==$validateCount){
						$ResponseXML .= "<recCountDetails><![CDATA[TRUE]]></recCountDetails>\n";
					}
					else{
						$ResponseXML .= "<recCountDetails><![CDATA[FALSE]]></recCountDetails>\n";
					}
			}	
	$ResponseXML .="</SaveValidate>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpReturnNo")
{

	$state=$_GET["state"];
	$year=$_GET["year"];

	$LoadPopUpReturnNoXML="<LoadPopUpReturnNo>";
	global $db;
	$SQL="SELECT DISTINCT FRH.intFRollSerialNO  ".
		 "FROM fabricrollheader AS FRH  ".		 
		 "WHERE FRH.intStatus='1' AND  FRH.intFRollSerialYear='$year';";
	
	$result=$db->RunQuery($SQL);
	
		$LoadPopUpReturnNoXML .="<option value=\"".""."\">"."Select one"."</option>";
	while($row = mysql_fetch_array($result))
	{	
		$LoadPopUpReturnNoXML .="<option value=>" . $row["intFRollSerialNO"] ."</option>\n";
	}
	$LoadPopUpReturnNoXML.="</LoadPopUpReturnNo>";
	echo $LoadPopUpReturnNoXML;
}
else if($RequestType=="LoadHeaderDetailsToMain")
{
	$No	= $_GET["No"];
		$rollNo = explode('/',$No);
$ResponseXML ="";
$ResponseXML .="<LoadHeaderDetailsToMain>\n";
$sql="";
$sql="select 
intPoNo,
intPoYear,
intSRNO,
FH.intStyleId,
intSupplierBatchNo,
intCompanyBatchNo,
strColor,
strSupplierID,
(select strTitle from suppliers S where S.strSupplierID=FH.strSupplierID)AS supplierName,
strBuyerPoNo,
strMatDetailID,
MIL.strItemDescription,
strRemarks
from fabricrollheader FH 
inner join specification SP on SP.intStyleId=FH.intStyleId
Inner JOIN matitemlist MIL on MIL.intItemSerial=FH.strMatDetailID 
where intFRollSerialNO='$rollNo[1]' and intFRollSerialYear='$rollNo[0]' ;";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .="<PoNo><![CDATA[".$row["intPoNo"]."]]></PoNo>\n";
	$ResponseXML .="<PoYear><![CDATA[".$row["intPoYear"]."]]></PoYear>\n";
	$ResponseXML .="<SRNO><![CDATA[".$row["intSRNO"]."]]></SRNO>\n";
	$ResponseXML .="<StyleID><![CDATA[".$row["intStyleId"]."]]></StyleID>\n";
	$ResponseXML .="<BuyerPoNo><![CDATA[".$row["strBuyerPoNo"]."]]></BuyerPoNo>\n";
	$ResponseXML .="<SupplierBatchNo><![CDATA[".$row["intSupplierBatchNo"]."]]></SupplierBatchNo>\n";
	$ResponseXML .="<CompanyBatchNo><![CDATA[".$row["intCompanyBatchNo"]."]]></CompanyBatchNo>\n";
	$ResponseXML .="<Color><![CDATA[".$row["strColor"]."]]></Color>\n";
	$ResponseXML .="<SupplierID><![CDATA[".$row["strSupplierID"]."]]></SupplierID>\n";
	$ResponseXML .="<SupplierName><![CDATA[".$row["supplierName"]."]]></SupplierName>\n";
	$ResponseXML .="<MatDetailID><![CDATA[".$row["strMatDetailID"]."]]></MatDetailID>\n";
	$ResponseXML .="<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
	$ResponseXML .="<Remarks><![CDATA[".$row["strRemarks"]."]]></Remarks>\n";	
}
$ResponseXML .="</LoadHeaderDetailsToMain>";
echo $ResponseXML;
}
else if($RequestType=="LoadDetailsToMainRequest")
{
	$No	= $_GET["No"];
		$rollNo = explode('/',$No);
$ResponseXML ="";
$ResponseXML .="<LoadDetailsToMainRequest>\n";
$sql="";
$sql="select * from fabricrolldetails 
where intFRollSerialNO='$rollNo[1]'
AND intFRollSerialYear='$rollNo[0]'
ORDER BY intRollNo;";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .="<RollNo><![CDATA[".$row["intRollNo"]."]]></RollNo>\n";
	$ResponseXML .="<SuppWidth><![CDATA[".$row["dblSuppWidth"]."]]></SuppWidth>\n";
	$ResponseXML .="<CompWidth><![CDATA[".$row["dblCompWidth"]."]]></CompWidth>\n";
	$ResponseXML .="<WidthUOM><![CDATA[".$row["strWidthUOM"]."]]></WidthUOM>\n";
	$ResponseXML .="<SuppLength><![CDATA[".$row["dblSuppLength"]."]]></SuppLength>\n";
	$ResponseXML .="<CompLength><![CDATA[".$row["dblCompLength"]."]]></CompLength>\n";
	$ResponseXML .="<LengthUOM><![CDATA[".$row["strLengthUOM"]."]]></LengthUOM>\n";
	$ResponseXML .="<SuppWeight><![CDATA[".$row["dblSuppWeight"]."]]></SuppWeight>\n";
	$ResponseXML .="<CompWeight><![CDATA[".$row["dblCompWeight"]."]]></CompWeight>\n";
	$ResponseXML .="<WeightUOM><![CDATA[".$row["strWeightUOM"]."]]></WeightUOM>\n";
	$ResponseXML .="<SpecialComments><![CDATA[".$row["strSpecialComments"]."]]></SpecialComments>\n";
}
$ResponseXML .="</LoadDetailsToMainRequest>";
echo $ResponseXML;
}
elseif($RequestType=="LoadPopUpRollNo")
{
	$batchNo =$_GET["batchNo"];
	$SupplierID =$_GET["SupplierID"];
	
	$ResponseXML .="<LoadPoNo>\n";
	
	$SQL = "SELECT concat(intFRollSerialYear,'/',intFRollSerialNO)AS SerialNo  from fabricrollheader where intFRollSerialNO<>0";
	if($batchNo!="")
		$SQL .= " AND intSupplierBatchNo='$batchNo'";
	if($SupplierID!="")
		$SQL .= " AND strSupplierID='$SupplierID'";
		
		$SQL .= " Order By intFRollSerialYear,intFRollSerialNO DESC";

	$result=$db->RunQuery($SQL);	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<option value=\"". $row["SerialNo"] ."\">" . $row["SerialNo"] ."</option>" ;
		}
	$ResponseXML .="</LoadPoNo>";
	echo $ResponseXML;
}
elseif($RequestType=="DeleteRow")
{
$rollSerialNo	= $_GET["rollSerialNo"];
$rollSerialNoArray	= explode('/',$rollSerialNo);
$rollNo		= $_GET["rollNo"];
$sql ="delete from fabricrolldetails where intFRollSerialNO='$rollSerialNoArray[1]' and intFRollSerialYear='$rollSerialNoArray[0]' and intRollNo='$rollNo'";
$result=$db->RunQuery($sql);
}
elseif($RequestType=="Cancel")
{
$rollSerialNo	= $_GET["rollSerialNo"];
$rollSerialNoArray	= explode('/',$rollSerialNo);
$ResponseXML ="<Cancel>\n";
	$sql ="update fabricrollheader set intStatus=10 
	where intFRollSerialNO='$rollSerialNoArray[1]'
	and intFRollSerialYear='$rollSerialNoArray[0]'";
	$result=$db->RunQuery($sql);
	$ResponseXML .="<Result><![CDATA[". $result ."]]></Result>\n";
	
$ResponseXML .= "</Cancel>\n";
echo $ResponseXML;

}
?>
