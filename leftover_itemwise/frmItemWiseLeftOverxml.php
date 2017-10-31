<?php
include "../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="URLSetStyleNo")
{
$orderId	= $_GET["OrderId"];
	$sql="select O.strStyle from orders O where O.intStyleId='$orderId'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleNo = $row["strStyle"];
	}
echo $styleNo;
}
elseif($requestType=="URLLoadOrderNo")
{
$styleNo	= $_GET["StyleNo"];
	$sql = "select O.intStyleId,O.strOrderNo,round(sum(dblQty),2)as stockBal from stocktransactions ST inner join orders O on O.intStyleId=ST.intStyleId inner join mainstores MS on MS.strMainID=ST.strMainStoresID where MS.intCompanyId='$companyId' ";
if($styleNo!="")
	$sql .= "and O.strStyle='$styleNo' ";
	
	$sql .= "group by ST.intStyleId having stockBal>0 order by O.strOrderNo;";
	$result = $db->RunQuery($sql);
		echo "<option value =\"".""."\">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
	}
echo $styleNo;
}
elseif($requestType=="URLLoadSCNo")
{
$styleNo	= $_GET["StyleNo"];
	$sql="select O.intStyleId,S.intSRNO,sum(dblQty)as stockBal from stocktransactions ST inner join orders O on O.intStyleId=ST.intStyleId inner join mainstores MS on MS.strMainID=ST.strMainStoresID inner join specification S on S.intStyleId=O.intStyleId where MS.intCompanyId='$companyId' ";
if($styleNo!="")
	$sql .= "and O.strStyle='$styleNo' ";
		
	$sql .= "group by ST.intStyleId having stockBal>0 order by S.intSRNO desc;";
	$result = $db->RunQuery($sql);
		echo "<option value =\"".""."\">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
	}
echo $styleNo;
}
elseif($requestType=="URLLoadSubStore")
{
$MSId	= $_GET["MSId"];
	$sql="select SS.strSubID,SS.strSubStoresName from substores SS where SS.strMainID='$MSId';";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
	}
}
elseif($requestType=="URLLoadPopItems")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadPopItems>\n";
$styleId		= $_GET["StyleId"];
$mainCat		= $_GET["MainCat"];
$subCat			= $_GET["SubCat"];
$itemDesc		= $_GET["ItemDesc"];
$mainStore		= $_GET["MainStore"];
	$sql = "select MMC.strDescription,MIL.intSubCatID,MSC.StrCatName,ST.intMatDetailId,MIL.strItemDescription,ST.strBuyerPoNo,ST.strColor,ST.strSize,ST.strUnit,round(sum(dblQty),2)as stockBal,ST.intGrnNo,ST.intGrnYear,ST.strGRNType from stocktransactions ST inner join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId inner join matmaincategory MMC on MMC.intID=MIL.intMainCatID inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID where ST.intStyleId='$styleId' and ST.strMainStoresID='$mainStore' ";
	
if($mainCat!="")
	$sql .= "and MIL.intMainCatID='$mainCat' ";
if($subCat!="")
	$sql .= "and MIL.intSubCatID='$subCat' ";
if($itemDesc!="")
	$sql .= "and MIL.strItemDescription like '%$itemDesc%' ";
	
	$sql .= "group by strMainStoresID,intStyleId,intMatDetailId,strColor,strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType
having stockBal>0
order by MIL.intMainCatID,MSC.StrCatName,MIL.strItemDescription;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["strGRNType"]=='B')
			$grnType = 'Bulk';
		elseif($row["strGRNType"]=='S')
			$grnType = 'Style';
		
		$stockBal	= $row['stockBal'];
		$usedQty = GetOtherQty($styleId,$row['strBuyerPoNo'],$row['intMatDetailId'],$row['strColor'],$row['strSize'],$row['intGrnYear'],$row['intGrnNo'],$row["strGRNType"]);
		$stockBal	= $stockBal - $usedQty;
		
		$ResponseXML .= "<MainCatID><![CDATA[".$row['intMainCatID']."]]></MainCatID>\n";
		$ResponseXML .= "<Description><![CDATA[".$row['strDescription']."]]></Description>\n";
		$ResponseXML .= "<SubCatID><![CDATA[".$row['intSubCatID']."]]></SubCatID>\n";
		$ResponseXML .= "<CatName><![CDATA[".$row['StrCatName']."]]></CatName>\n";
		$ResponseXML .= "<MatDetailId><![CDATA[".$row['intMatDetailId']."]]></MatDetailId>\n";
		$ResponseXML .= "<ItemDescription><![CDATA[".$row['strItemDescription']."]]></ItemDescription>\n";
		$ResponseXML .= "<BuyerPoNo><![CDATA[".$row['strBuyerPoNo']."]]></BuyerPoNo>\n";
		$ResponseXML .= "<Color><![CDATA[".$row['strColor']."]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[".$row['strSize']."]]></Size>\n";
		$ResponseXML .= "<Unit><![CDATA[".$row['strUnit']."]]></Unit>\n";
		$ResponseXML .= "<StockBal><![CDATA[".round($stockBal,2)."]]></StockBal>\n";
		$ResponseXML .= "<GrnYear><![CDATA[".$row['intGrnYear']."]]></GrnYear>\n";
		$ResponseXML .= "<GrnNo><![CDATA[".$row['intGrnNo']."]]></GrnNo>\n";
		$ResponseXML .= "<GRNType><![CDATA[".$grnType."]]></GRNType>\n";
		$ResponseXML .= "<GRNTypeId><![CDATA[".$row['strGRNType']."]]></GRNTypeId>\n";
	}
$ResponseXML .= "</XMLLoadPopItems>\n";
echo $ResponseXML;
}
elseif($requestType=="URLGetNewSerialNo")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$No=0;
$ResponseXML = "<XMLGetNewSerialNo>\n";

	$Sql="select intCompanyID,dblItemWiseLeftOverNo from syscontrol where intCompanyID='$companyId'";		
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);	
	if ($rowcount > 0)
	{	
			while($row = mysql_fetch_array($result))
			{				
				$No=$row["dblItemWiseLeftOverNo"];
				$NextNo=$No+1;
				$ReturnYear = date('Y');
				$sqlUpdate="UPDATE syscontrol SET dblItemWiseLeftOverNo='$NextNo' WHERE intCompanyID='$companyId';";
				$db->executeQuery($sqlUpdate);
				$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
				$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
				$ResponseXML .= "<Year><![CDATA[".$ReturnYear."]]></Year>\n";
			}			
	}
	else
	{
		$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
	}	
$ResponseXML .="</XMLGetNewSerialNo>";
echo $ResponseXML;
}
elseif($requestType=="URLSaveHeader")
{
$serialNo	= $_GET["SerialNo"];
$serialYear	= $_GET["SerialYear"];

	$sql="insert into itemwiseleftover_header (intSerialNo,intSerialYear,intStatus,intUserId,intCompanyId,dtmDate)values('$serialNo','$serialYear','1','$userId','$companyId',now());";
	$result=$db->RunQuery($sql);
}
elseif($requestType=="URLSaveDetails")
{
$serialNo		= $_GET["SerialNo"];
$serialYear		= $_GET["SerialYear"];
$styleId		= $_GET["StyleID"];
$buyerPoNo		= $_GET["BuyerPoNo"];
$itemDetailId	= $_GET["ItemDetailId"];
$color			= $_GET["Color"];
$size			= $_GET["Size"];
$units			= $_GET["Units"];
$qty			= $_GET["Qty"];
$grnNo			= $_GET["GRNNo"];
$grnNoArray 	= explode('/',$grnNo);
$grnType		= $_GET["GRNType"];

	$sql="insert into itemwiseleftover_detail (intSerialNo,intSerialYear,intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblQty,intGRNNo,intGRNYear,strGRNType)values('$serialNo','$serialYear','$styleId','$buyerPoNo','$itemDetailId','$color','$size','$units','$qty','$grnNoArray[1]','$grnNoArray[0]','$grnType')";
	$result=$db->RunQuery($sql);
}
elseif($requestType=="URLSaveBinDetails")
{
$serialNo		= $_GET["SerialNo"];
$serialYear		= $_GET["SerialYear"];
$styleId		= $_GET["StyleID"];
$buyerPoNo		= $_GET["BuyerPoNo"];
$itemDetailId	= $_GET["ItemDetailId"];
$color			= $_GET["Color"];
$size			= $_GET["Size"];
$units			= $_GET["Units"];
$binQty			= $_GET["BinQty"];
$msId			= $_GET["MSId"];
$ssId			= $_GET["SSId"];
$locId			= $_GET["LocId"];
$binId			= $_GET["BinId"];
$sysYear		= date("Y");
$grnNo			= $_GET["GRNNo"];
$grnNoArray 	= explode('/',$grnNo);
$grnType		= $_GET["GRNType"];
$subCatId		= GetSubCatId($itemDetailId);

SaveBinDetails('stocktransactions',$sysYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,-$binQty,$userId,$grnNoArray,$grnType);

SaveBinDetails('stocktransactions_leftover',$sysYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$grnNoArray,$grnType);
//UpdateBinCapacity($msId,$ssId,$locId,$binId,$subCatId,$binQty);
}
elseif($requestType=="URLloadPopupSubCategory")
{
	$mainCat = $_GET["mainCat"];
	$styleID = $_GET["styleID"];
	$str = '';
	
	$str .= "<option value =\"".""."\">"."Select One"."</option>";
	$sql = "select distinct MSC.intSubCatNo,MSC.StrCatName from matsubcategory MSC 
inner join matitemlist MIL on  MIL.intSubCatID=MSC.intSubCatNo
inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial
where OD.intStyleId=$styleID ";
	if($mainCat != '')
		$sql .= " and MIL.intMainCatID = '$mainCat' ";
	$sql .= " order by MSC.StrCatName ";
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
	}	
	echo $str;
}
elseif($requestType=="load_OrderNo")
{
	
	$sql = "select distinct strOrderNo
			from orders O
			inner join itemwiseleftover_detail IWLD ON IWLD.intStyleId=O.intStyleId
			order by strOrderNo ";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['strOrderNo']."|";
				 
			}
			echo $pr_arr;	
}
function SaveBinDetails($tblName,$sysYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$grnNoArray,$grnType)
{
global $db;
	$sql="insert into $tblName(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,	intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType)	values('$sysYear','$msId','$ssId','$locId','$binId','$styleId','$buyerPoNo','$serialNo','$serialYear','$itemDetailId','$color','$size','Leftover','$units',$binQty,now(),'$userId','$grnNoArray[1]','$grnNoArray[0]','$grnType');";
	$result=$db->RunQuery($sql);
}

function GetSubCatId($matDetailID)
{
global $db;
$sql="select intSubCatID from matitemlist where intItemSerial='$matDetailID'";
$result=$db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["intSubCatID"];
}

function UpdateBinCapacity($msId,$ssId,$locId,$binId,$subCatId,$binQty)
{
global $db;
	$sql="update storesbinallocation set dblFillQty=dblFillQty + $binQty
	where strMainID='$msId' and strSubID='$ssId' and strLocID='$locId' and strBinID='$binId' and intSubCatNo='$subCatId';";
	$result=$db->RunQuery($sql);
}

function GetOtherQty($styleId,$buyerPoNo,$matDetailId,$color,$size,$grnYear,$grnNo,$grnType)
{
global $db;
$qty  = 0;
	$sql1="select round(sum(dblBalQty),2)as balQty from matrequisitiondetails where intStyleId='$styleId' and strBuyerPONO='$buyerPoNo' and strMatDetailID='$matDetailId' and strColor='$color' and strSize='$size' and intGrnNo='$grnNo' and intGrnYear='$grnYear' and strGRNType='$grnType';";
	//echo $sql1;
	$result1=$db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{
		$qty = $row1["balQty"];
	}
	return $qty;
}
?>