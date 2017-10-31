<?php	
	session_start();
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	include "../Connector.php";
	$request	= $_GET["request"];
	$companyId	= $_SESSION["FactoryID"];
	
if($request=='loadBPO')
{
$ResponseXML = "<XMLLoadBPO>";
$style	= $_GET["style"];
	$SQL = "SELECT distinct materialratio.strBuyerPONO FROM materialratio where intStyleId='".$style."' order by strBuyerPONO;";
	$result =$db->RunQuery($SQL);
	while ($row=mysql_fetch_array($result))
	{
		$BuyerPoName = $row["strBuyerPONO"];
		if($row["strBuyerPONO"] != '#Main Ratio#')
			$BuyerPoName = getBuyerPOName($style,$row["strBuyerPONO"]);		
		
		$ResponseXML .= "<option value=\"".$row["strBuyerPONO"]."\">".$BuyerPoName."</option>";
	} 
$ResponseXML .= "</XMLLoadBPO>";
echo $ResponseXML;
}
elseif($request=='loadSubStores') 
{
$ResponseXML = "<XMLloadSubStores>";
$mainStore	= $_GET["mainStore"];

	$SQL="SELECT  substores.strSubID, substores.strSubStoresName  FROM substores WHERE substores.strMainID ='$mainStore'";
	$result =$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>";
	while ($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<option value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
	}

$ResponseXML.="</XMLloadSubStores>";
echo $ResponseXML;
}
elseif($request=='loadLocatoion') 
{
$ResponseXML = "<XMLLoadLocatoion>";
$mainStore	 = $_GET["mainStore"];
$subStore	 = $_GET["subStore"];
	$SQL="SELECT storeslocations.strLocID, storeslocations.strLocName FROM `storeslocations` 
	WHERE storeslocations.strMainID ='$mainStore' AND storeslocations.strSubID =  '$subStore' AND storeslocations.intStatus =  '1'";
	$result =$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>";
	while ($row=mysql_fetch_array($result))
	{	
		$ResponseXML .= "<option value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";
	}
$ResponseXML .= "</XMLLoadLocatoion>";
echo $ResponseXML;
}
elseif($request=='loadBin') 
{	
$ResponseXML = "<XMLLoadBin>";
$mainStore	 = $_GET["mainStore"];
$subStore	 = $_GET["subStore"];
$location	 = $_GET["location"];
	$SQL="SELECT storesbins.strBinID, storesbins.strBinName FROM storesbins WHERE storesbins.strMainID =  '$mainStore' AND storesbins.strSubID =  '$subStore' AND storesbins.strLocID =  '$location' and intStatus='1' ";
	$result =$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>";
	while ($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<option value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";
	}
$ResponseXML.="</XMLLoadBin>";
echo $ResponseXML;
}
if($request=='LoadSourceBinDetails')
{
$styleId		= $_GET["styleId"];
$buyerPoNo		= $_GET["buyerPoNo"];
$mainStore		= $_GET["mainStore"];
$subStore		= $_GET["subStore"];
$location		= $_GET["location"];
$bin			= $_GET["bin"];

$ResponseXML  	= "<LoadSourceBinDetails>\n";

$sql="	SELECT SP.intSRNO,
			ST.intStyleId,
			MIL.intItemSerial as itemCode,
			MIL.strItemDescription,
			ST.strColor,
			ST.strSize,
			ST.strUnit as unit,
			sum(ST.dblQty) as TotalQty,
			O.strOrderNo,
			ST.intGrnNo,
			ST.intGrnYear,
			ST.strGRNType
			FROM
			stocktransactions ST
			Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId
			Inner Join specification SP ON SP.intStyleId= ST.intStyleId
			INNER JOIN orders O ON O.intStyleId = ST.intStyleId
			WHERE
			ST.intStyleId =  '$styleId' AND
			ST.strBuyerPoNo =  '$buyerPoNo' AND
			ST.strMainStoresID =  '$mainStore' AND
			ST.strSubStores =  '$subStore' AND
			ST.strLocation =  '$location' AND
			ST.strBin =  '$bin' 
			GROUP BY ST.intStyleId,ST.strBuyerPoNo,ST.intMatDetailId,ST.strColor,ST.strSize, O.strOrderNo,ST.intGrnNo,ST.intGrnYear,ST.strGRNType 
			having TotalQty>0";
			
	$result =$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		//$TotalQty	= $row["TotalQty"];
		//if($TotalQty>0){
		$ResponseXML .= "<ScNo><![CDATA[" . $row["intSRNO"]  . "]]></ScNo>\n";
		$ResponseXML .= "<styleNo><![CDATA[" . $row["intStyleId"]  . "]]></styleNo>\n";
		$ResponseXML .= "<styleName><![CDATA[" . $row["strOrderNo"]  . "]]></styleName>\n";
		$ResponseXML .= "<matDetailId><![CDATA[" . $row["itemCode"]  . "]]></matDetailId>\n";
		$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<stockQty><![CDATA[" . $row["TotalQty"]  . "]]></stockQty>\n";
		$ResponseXML .= "<Units><![CDATA[" . $row["unit"]  . "]]></Units>\n";
		$ResponseXML .= "<GRNno><![CDATA[" . $row["intGrnNo"]  . "]]></GRNno>\n";
		$ResponseXML .= "<GRNyear><![CDATA[" . $row["intGrnYear"]  . "]]></GRNyear>\n";
		$ResponseXML .= "<GRNTypeId><![CDATA[" . $row["strGRNType"]  . "]]></GRNTypeId>\n";
		if($row["strGRNType"]=='B')
			$grnType = 'Bulk';
		elseif($row["strGRNType"]=='S')
			$grnType = 'Style';
		$ResponseXML .= "<GRNType><![CDATA[" . $grnType . "]]></GRNType>\n";
		//}
	}
$ResponseXML   .= "</LoadSourceBinDetails>";
echo $ResponseXML;
}
if($request=="validateBinAllocation")
{
$matDetailsId		= $_GET["matDetailsId"];
$destMainStoreId	= $_GET["destMainStoreId"];
$destSubStoreId		= $_GET["destSubStoreId"];
$destLocationId		= $_GET["destLocationId"];
$destBinId			= $_GET["destBinId"];
$pub_ActiveCommonBins = $_GET["pub_ActiveCommonBins"];
$ResponseXML  		= "<validateBinAllocation>\n";

$sql_1="select intSubCatID,StrCatName,intMainCatID from matitemlist MIL
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
 where intItemSerial='$matDetailsId'";	
$result_1=$db->RunQuery($sql_1);
//echo $sql_1;
	
$row_1	= mysql_fetch_array($result_1);
	$matCatId =$row_1["intSubCatID"];
	$matCatName =$row_1["StrCatName"];
	$matMainCategoryId =$row_1["intMainCatID"];

$sql="select strMainID from storesbinallocation 
	where strMainID='$destMainStoreId'
	and strSubID='$destSubStoreId'
	and strLocID='$destLocationId'
	and strBinID='$destBinId'
	and intSubCatNo='$matCatId'";	

//echo $sql;		
	$result =$db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	//echo $rowCount;
	/*if($rowCount==0)
		$ResponseXML .= "<Validate><![CDATA[TRUE]]></Validate>\n";
	else		
		$ResponseXML .= "<Validate><![CDATA[FALSE]]></Validate>\n";*/
		
	if($rowCount==0)
	{
		
		if($pub_ActiveCommonBins == '1')
		{
			saveStorebinAllocationDetails($destMainStoreId,$destMainStoreId,$destMainStoreId,$destBinId,$matCatId);
			$ResponseXML .= "<Validate><![CDATA[FALSE]]></Validate>\n";
		}
		else
		{
			$ResponseXML .= "<Validate><![CDATA[TRUE]]></Validate>\n";
		}
	}
	else
	{
		$ResponseXML .= "<Validate><![CDATA[FALSE]]></Validate>\n";
	}
	$ResponseXML .= "<MatCatName><![CDATA[" . $matCatName . "]]></MatCatName>\n";	
	//$ResponseXML .= "<MatCatName><![CDATA[" . $matCatName . "]]></MatCatName>\n";
	$ResponseXML .= "<matMainCategoryId><![CDATA[" . $matMainCategoryId . "]]></matMainCategoryId>\n";	
$ResponseXML   .= "</validateBinAllocation>";
echo $ResponseXML;
}
elseif($request=="GetNo")
{		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
		$Sql="select intCompanyID,dblSBinToBinTransNo from syscontrol where intCompanyID='$companyId'";
		 
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{						
					$No=$row["dblSBinToBinTransNo"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblSBinToBinTransNo='$NextNo' WHERE intCompanyID='$companyId';";				
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";					
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
else if ($request=="SaveValidate")
{
	
	$no					= $_GET["no"];
	$year				= date("Y");			
	$validateCount 	= $_GET["validateCount"];	
	
	$ResponseXML ="<SaveValidate>\n";
	
		$SQL="SELECT COUNT(intDocumentNo) AS countIn FROM stocktransactions where intDocumentNo=$no AND intDocumentYear=$year and strType='BINTRIN'";	
	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$countIn=$row["countIn"];		
		 
			if($countIn==$validateCount)
			{
				$ResponseXML .= "<recCountBinInDetails><![CDATA[TRUE]]></recCountBinInDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountBinInDetails><![CDATA[FALSE]]></recCountBinInDetails>\n";
			}
	}
	
	$SQL="SELECT COUNT(intDocumentNo) AS countOut FROM stocktransactions where intDocumentNo=$no AND intDocumentYear=$year and strType='BINTROUT'";	

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$countOut=$row["countOut"];		
		
			if($countOut==$validateCount)
			{
				$ResponseXML .= "<recCountBinOutDetails><![CDATA[TRUE]]></recCountBinOutDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountBinOutDetails><![CDATA[FALSE]]></recCountBinOutDetails>\n";
			}
	}
	
	$ResponseXML .="</SaveValidate>";
	echo $ResponseXML;
}
if($request=='getCommonBin')
{

		
		$ResponseXML .= "<MainstoreBinDetails>";
	$strMainStores		= $_GET["strMainStores"];
	
	$SQL = " select intCommonBin,intAutomateCompany from mainstores where strMainID=$strMainStores  and intStatus=1 ";
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<commonbin><![CDATA[" . trim($row["intCommonBin"])  . "]]></commonbin>\n";
		 $ResponseXML .= "<autoBin><![CDATA[" . trim($row["intAutomateCompany"])  . "]]></autoBin>\n";
	}
	
	$ResponseXML .= "</MainstoreBinDetails>";
	echo $ResponseXML;
}
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}
function saveStorebinAllocationDetails($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo)
{
	global $db;
	$sql = "INSERT INTO storesbinallocation(strMainID,strSubID,strLocID,strBinID,intSubCatNo,intStatus,dblCapacityQty)
								VALUES($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo,'1','10000000')";
								
	 return $db->RunQuery($sql);
								
}

?>