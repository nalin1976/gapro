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
	$sql = "select MMC.strDescription,MIL.intSubCatID,MSC.StrCatName,ST.intMatDetailId,MIL.strItemDescription,ST.strBuyerPoNo,
ST.strColor,ST.strSize,ST.strUnit,
round(sum(dblQty),2)- coalesce((select round(sum(dblBalQty),2)as balQty 
from matrequisitiondetails MRD INNER JOIN matrequisition MRH ON MRH.intMatRequisitionNo=MRD.intMatRequisitionNo AND MRH.intMRNYear=MRD.intYear
 where MRD.intStyleId=ST.intStyleId and MRD.strBuyerPONO=ST.strBuyerPoNo and MRD.strMatDetailID=ST.intMatDetailId and MRD.strColor=ST.strColor 
and MRD.strSize=ST.strSize and MRD.intGrnNo=ST.intGrnNo  and MRD.intGrnYear=ST.intGrnYear and MRD.strGRNType=ST.strGRNType 
AND ST.strMainStoresID = MRH.strMainStoresID),0) -
coalesce((SELECT ABS(SUM(STT.dblQty)) AS GPqty FROM stocktransactions_temp STT 
WHERE STT.strMainStoresID=ST.strMainStoresID AND STT.intStyleId=ST.intStyleId AND STT.strBuyerPoNo=ST.strBuyerPoNo
AND STT.intMatDetailId = ST.intMatDetailId AND STT.strColor = ST.strColor AND STT.strSize = ST.strSize AND 
STT.intGrnNo = ST.intGrnNo AND STT.intGrnYear = ST.intGrnYear AND STT.strGRNType = ST.strGRNType AND STT.strType='SGatePass'),0) -
coalesce((SELECT SUM(ITD.dblQty) AS InterjobQty 
FROM itemtransferdetails ITD 
INNER JOIN itemtransfer IT ON IT.intTransferId = ITD.intTransferId AND IT.intTransferYear = ITD.intTransferYear
WHERE IT.intStyleIdFrom=ST.intStyleId AND ITD.strBuyerPoNo =ST.strBuyerPoNo AND ITD.intMatDetailId =ST.intMatDetailId
 AND ITD.strColor=ST.strColor AND ITD.strSize=ST.strSize AND ITD.intGrnNo= ST.intGrnNo AND ITD.intGrnYear=ST.intGrnYear
 AND ITD.strGRNType=ST.strGRNType AND IT.intMainStoreID = ST.strMainStoresID AND IT.intStatus IN (0,1,2)),0) 
 as stockBal,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType
from stocktransactions ST inner join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId
inner join matmaincategory MMC on MMC.intID=MIL.intMainCatID
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
where ST.intStyleId='$styleId' and ST.strMainStoresID='$mainStore' ";
	
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
		/*$usedQty = GetOtherQty($styleId,$row['strBuyerPoNo'],$row['intMatDetailId'],$row['strColor'],$row['strSize'],$row['intGrnYear'],$row['intGrnNo'],$row["strGRNType"]);
		$stockBal	= $stockBal - $usedQty;*/
		
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

	$Sql="select intCompanyID,dblLiabilityNo from syscontrol where intCompanyID='$companyId'";		
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);	
	if ($rowcount > 0)
	{	
			while($row = mysql_fetch_array($result))
			{				
				$No=$row["dblLiabilityNo"];
				$NextNo=$No+1;
				$ReturnYear = date('Y');
				$sqlUpdate="UPDATE syscontrol SET dblLiabilityNo='$NextNo' WHERE intCompanyID='$companyId';";
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
$mainstoreId = $_GET["mainstoreId"];

deleteLiabiltyHeaderDetails($serialNo,$serialYear);
deleteLiabilityDetails($serialNo,$serialYear);
//deleteLiabilityBinDetails($serialNo,$serialYear);

	$sql = " insert into itemwiseliability_header (intSerialNo,intSerialYear,intStatus,intCompanyId,intMainStoreID,intUserId,dtmDate)
values 	('$serialNo','$serialYear','1','$companyId','$mainstoreId','$userId',now()) ";
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

	$sql="insert into itemwiseliability_detail (intSerialNo,intSerialYear,intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblQty,intGRNNo,intGRNYear,strGRNType)values('$serialNo','$serialYear','$styleId','$buyerPoNo','$itemDetailId','$color','$size','$units','$qty','$grnNoArray[1]','$grnNoArray[0]','$grnType')";
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
SaveBinDetails('stocktransactions_liability',$sysYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$grnNoArray,$grnType);
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

elseif($requestType=="URLgetSavedHeaderDetails")
{
	$liabilityNo = $_GET["liabilityNo"];
	$liabilityYear = $_GET["liabilityYear"];
	
	$sql = " select intMainStoreID from itemwiseliability_header where intSerialNo='$liabilityNo' and intSerialYear='$liabilityYear' ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	echo $row["intMainStoreID"];
}
elseif($requestType=="URLgetSavedLiabilityDetails")
{
	$liabilityNo = $_GET["liabilityNo"];
	$liabilityYear = $_GET["liabilityYear"];
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
	$ResponseXML = "<XMLGetLiabilityDetails>\n";
	
	$SQL = "select ILD.intMatDetailId, MIL.strItemDescription,O.strOrderNo,ILD.intStyleId,ILD.strBuyerPoNo,ILD.dblQty,
ILD.strColor,ILD.strSize,ILD.strUnit,ILD.intGrnNo,ILD.intGrnYear,ILD.strGRNType,
coalesce((SELECT ROUND(SUM(ST.dblQty),2) FROM stocktransactions ST WHERE ST.intStyleId=ILD.intStyleId AND ST.strBuyerPoNo=ILD.strBuyerPoNo AND 
ST.intMatDetailId=ILD.intMatDetailId AND ST.strColor=ILD.strColor AND ST.strSize=ILD.strSize AND ST.intGrnNo=ILD.intGRNNo
 AND ST.intGrnYear=ILD.intGRNYear AND ST.strGRNType=ILD.strGRNType AND ILH.intMainStoreID=ST.strMainStoresID),0)-
coalesce((select round(sum(dblBalQty),2)as balQty 
from matrequisitiondetails MRD INNER JOIN matrequisition MRH ON MRH.intMatRequisitionNo=MRD.intMatRequisitionNo AND MRH.intMRNYear=MRD.intYear
 where MRD.intStyleId=ILD.intStyleId and MRD.strBuyerPONO=ILD.strBuyerPoNo and MRD.strMatDetailID=ILD.intMatDetailId and MRD.strColor=ILD.strColor 
and MRD.strSize=ILD.strSize and MRD.intGrnNo=ILD.intGrnNo  and MRD.intGrnYear=ILD.intGrnYear 
and MRD.strGRNType=ILD.strGRNType 
AND ILH.intMainStoreID= MRH.strMainStoresID),0) -
coalesce((SELECT ABS(SUM(STT.dblQty)) AS GPqty FROM stocktransactions_temp STT 
WHERE STT.strMainStoresID=ILH.intMainStoreID AND STT.intStyleId=ILD.intStyleId AND STT.strBuyerPoNo=ILD.strBuyerPoNo
AND STT.intMatDetailId = ILD.intMatDetailId AND STT.strColor = ILD.strColor AND STT.strSize =ILD.strSize AND 
STT.intGrnNo = ILD.intGrnNo AND STT.intGrnYear = ILD.intGrnYear AND STT.strGRNType = ILD.strGRNType AND STT.strType='SGatePass'),0) -
coalesce((SELECT SUM(ITD.dblQty) AS InterjobQty 
FROM itemtransferdetails ITD 
INNER JOIN itemtransfer IT ON IT.intTransferId = ITD.intTransferId AND IT.intTransferYear = ITD.intTransferYear
WHERE IT.intStyleIdFrom=ILD.intStyleId AND ITD.strBuyerPoNo =ILD.strBuyerPoNo AND ITD.intMatDetailId =ILD.intMatDetailId
 AND ITD.strColor=ILD.strColor AND ITD.strSize=ILD.strSize AND ITD.intGrnNo= ILD.intGrnNo AND ITD.intGrnYear=ILD.intGrnYear
 AND ITD.strGRNType=ILD.strGRNType AND IT.intMainStoreID = ILH.intMainStoreID AND IT.intStatus IN (0,1,2)),0)
 AS stockBal
FROM itemwiseliability_detail ILD 
INNER JOIN itemwiseliability_header ILH ON ILH.intSerialNo = ILD.intSerialNo AND ILH.intSerialYear = ILD.intSerialYear
INNER JOIN matitemlist MIL ON MIL.intItemSerial = ILD.intMatDetailId
INNER JOIN orders O ON O.intStyleId = ILD.intStyleId
WHERE ILH.intSerialNo='$liabilityNo' AND ILH.intSerialYear='$liabilityYear'";
	$result=$db->RunQuery($SQL);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<intStyleId><![CDATA[".$row["intStyleId"]."]]></intStyleId>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[".$row["strOrderNo"]."]]></strOrderNo>\n";
		$ResponseXML .= "<intMatDetailId><![CDATA[".$row["intMatDetailId"]."]]></intMatDetailId>\n";
		$ResponseXML .= "<strItemDescription><![CDATA[".$row["strItemDescription"]."]]></strItemDescription>\n";
		$ResponseXML .= "<strBuyerPoNo><![CDATA[".$row["strBuyerPoNo"]."]]></strBuyerPoNo>\n";
		$ResponseXML .= "<strUnit><![CDATA[".$row["strUnit"]."]]></strUnit>\n";
		$ResponseXML .= "<strColor><![CDATA[".$row["strColor"]."]]></strColor>\n";
		$ResponseXML .= "<strSize><![CDATA[".$row["strSize"]."]]></strSize>\n";
		$ResponseXML .= "<GrnNo><![CDATA[".$row["intGrnYear"].'/'.$row["intGrnNo"]."]]></GrnNo>\n";
		//$ResponseXML .= "<intGrnYear><![CDATA[".$row["intGrnYear"]."]]></intGrnYear>\n";
		$grnTypeId = $row["strGRNType"];
		if($grnTypeId == 'S')
			$strGRNType = 'Style';
		if($grnTypeId == 'B')
			$strGRNType = 'Bulk';	
		$ResponseXML .= "<grnTypeId><![CDATA[".$grnTypeId."]]></grnTypeId>\n";
		$ResponseXML .= "<strGRNType><![CDATA[".$strGRNType."]]></strGRNType>\n";
		$ResponseXML .= "<dblQty><![CDATA[".$row["dblQty"]."]]></dblQty>\n";
		$ResponseXML .= "<stockBal><![CDATA[".$row["stockBal"]."]]></stockBal>\n";
	}
	
	$ResponseXML .="</XMLGetLiabilityDetails>";
	echo $ResponseXML;
}
elseif($requestType=="URLgetSavedBinDetails")
{
	$liabilityNo = $_GET["liabilityNo"];
	$liabilityYear = $_GET["liabilityYear"];
	$matId = $_GET["matId"];
	$buyerPoNo = $_GET["buyerPoNo"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$grnNoDet = $_GET["grnNo"];
	$grnTypeId = $_GET["grnTypeId"];
	$state = $_GET["state"];
	$orderId = $_GET["orderId"];
	$arrGRN = explode('/',$grnNoDet);
	
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
	$ResponseXML = "<XMLGetLiabilityBinDetails>\n";
	
	if($state == '1')
		$tbl = 'stocktransactions_liability';
	else
		$tbl = 'stocktransactions_liability_temp';
		
	$sql = " SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin,Sum(ST.dblQty) as BinQty,MIL.intSubCatID 
FROM stocktransactions_liability_temp AS ST 
Inner Join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId 
WHERE ST.intDocumentNo =  '$liabilityNo' AND ST.intDocumentYear =  '$liabilityYear' 
AND ST.intStyleId = '$orderId' AND ST.strBuyerPoNo =  '$buyerPoNo'
AND ST.intMatDetailId = '$matId' AND ST.strColor = '$color' AND ST.strSize = '$size'  and strType='Liability' 
AND ST.intGrnNo = '$arrGRN[1]' AND ST.intGrnYear = '$arrGRN[0]' AND ST.strGRNType = '$grnTypeId' 			
GROUP BY ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin " ;
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
		{
			$BinQty=abs($row["BinQty"]);
				
			$ResponseXML .="<Qty><![CDATA[". round($BinQty,2) ."]]></Qty>\n";		
			$ResponseXML .="<MainStoresID><![CDATA[". $row["strMainStoresID"] ."]]></MainStoresID>\n";
			$ResponseXML .="<SubStores><![CDATA[". $row["strSubStores"] ."]]></SubStores>\n";
			$ResponseXML .="<Location><![CDATA[". $row["strLocation"] ."]]></Location>\n";
			$ResponseXML .="<Bin><![CDATA[". $row["strBin"] ."]]></Bin>\n";		
			$ResponseXML .="<MatSubCatId><![CDATA[". $row["intSubCatID"] ."]]></MatSubCatId>\n";
		}		
	$ResponseXML .="</XMLGetLiabilityBinDetails>";
	echo $ResponseXML;
}
elseif($requestType=="URLCancelLiability")
{
	$SerialNo = $_GET["SerialNo"];
	$arrSerialNo = explode('/',$SerialNo);
	$intSerialNo = $arrSerialNo[1];
	$intSerialYear = $arrSerialNo[0];	
	
	$sql=" SELECT LID.intMatDetailId,LID.dblQty,MIL.strItemDescription,
(SELECT SUM(ST.dblQty) FROM stocktransactions_liability ST WHERE ST.intStyleId=LID.intStyleId AND ST.strBuyerPoNo=LID.strBuyerPoNo AND
ST.intMatDetailId = LID.intMatDetailId AND ST.strColor=LID.strColor AND ST.intGRNNo=LID.intGRNNo AND ST.intGRNYear=LID.intGRNYear
AND ST.strGRNType = LID.strGRNType AND LIH.intMainStoreID = ST.strMainStoresID) AS StockQty
FROM itemwiseliability_detail LID INNER JOIN itemwiseliability_header LIH ON
LID.intSerialNo = LIH.intSerialNo AND LID.intSerialYear = LIH.intSerialYear
INNER JOIN matitemlist MIL ON MIL.intItemSerial = LID.intMatDetailId
WHERE LID.intSerialNo='$intSerialNo' AND LID.intSerialYear='$intSerialYear' ";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["StockQty"]<$row["dblQty"])
		{
			echo 'Item :'.$row["strItemDescription"].' not have stock ';
			return;
		}	
	}
	
	$sysYear = date("Y");
	$sql_l = "SELECT * FROM stocktransactions_liability WHERE  intDocumentNo='$intSerialNo' AND intDocumentYear='$intSerialYear' AND strType='Liability' ";
	$result_l = $db->RunQuery($sql_l);
	while($rowL=mysql_fetch_array($result_l))
	{
		$grnno = $rowL["intGrnYear"].'/'.$rowL["intGrnNo"];
		$grnNoArray = explode('/',$grnno);

		SaveBinDetails('stocktransactions_liability',$sysYear,$rowL["strMainStoresID"],$rowL["strSubStores"],$rowL["strLocation"],$rowL["strBin"],$rowL["intStyleId"],$rowL["strBuyerPoNo"],$intSerialNo,$intSerialYear,$rowL["intMatDetailId"],$rowL["strColor"],$rowL["strSize"],$rowL["strUnit"],-$rowL["dblQty"],$userId,$grnNoArray,$$rowL["strGRNType"]);
		
		SaveBinDetails('stocktransactions',$sysYear,$rowL["strMainStoresID"],$rowL["strSubStores"],$rowL["strLocation"],$rowL["strBin"],$rowL["intStyleId"],$rowL["strBuyerPoNo"],$intSerialNo,$intSerialYear,$rowL["intMatDetailId"],$rowL["strColor"],$rowL["strSize"],$rowL["strUnit"],$rowL["dblQty"],$userId,$grnNoArray,$$rowL["strGRNType"]);
	}
	$result = updateLiabilityDetails($intSerialNo,$intSerialYear,$userId);
	echo $result;
	
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
elseif($requestType=="URLloadPopupSerialNo")
{
	$status = $_GET["status"];
	$year = $_GET["year"];
	
	$sql = " SELECT DISTINCT intSerialNo FROM itemwiseliability_header WHERE intStatus='$status'  AND intSerialYear='$year' and intCompanyId='$companyId'  ORDER BY intSerialNo DESC ";
	$result = $db->RunQuery($sql);
	
	$str = "<option value=\"\" selected=\"selected\">Select One</option>";
	
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"".$row["intSerialNo"]."\">".$row["intSerialNo"]."</option>";
	}
	
	echo $str;
	
}
function SaveBinDetails($tblName,$sysYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$grnNoArray,$grnType)
{
global $db;
	$sql="insert into $tblName(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,	intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType)	values('$sysYear','$msId','$ssId','$locId','$binId','$styleId','$buyerPoNo','$serialNo','$serialYear','$itemDetailId','$color','$size','Liability','$units',$binQty,now(),'$userId','$grnNoArray[1]','$grnNoArray[0]','$grnType');";
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
function deleteLiabiltyHeaderDetails($serialNo,$serialYear)
{
	global $db;
	$sql = "delete from itemwiseliability_header 	where 	intSerialNo = '$serialNo' and intSerialYear = '$serialYear' ";
	$result=$db->RunQuery($sql);
}
function deleteLiabilityDetails($serialNo,$serialYear)
{
	global $db;
	$sql = " delete from itemwiseliability_detail 	where 	intSerialNo = '$serialNo' and intSerialYear = '$serialYear' ";
	$result=$db->RunQuery($sql);
}
function updateLiabilityDetails($intSerialNo,$intSerialYear,$userId)
{
	global $db;
	$sql = "update itemwiseliability_header 
	set
	intStatus = '10' , 
	intCancelBy = '$userId' , 
	dtmCanceled = now()
	where 	intSerialNo = '$intSerialNo' and intSerialYear = '$intSerialYear' ";
	
	return $db->RunQuery($sql);
}
?>