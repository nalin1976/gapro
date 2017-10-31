<?php
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 

$RequestType	= $_GET["RequestType"];
$companyId		= $_SESSION["FactoryID"];
$UserID			= $_SESSION["UserID"];

if($RequestType=="URLLoadGRNNo")
{
	$StyleId	= $_GET["StyleId"];
	$sql = "SELECT DISTINCT CONCAT(GH.intGRNYear ,'/',GH.intGrnNo) AS grnNO 
			FROM grndetails GD
			inner join grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
			inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
			inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
			WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and MSC.intInspection=1 and GD.intReject=1 and GD.intSATrimIStatus<>2 ";
			
if($StyleId!=""){
	$sql .= " and GD.intStyleId='$StyleId'";
	}
	
	$sql .= " order by grnNO desc";
	
		echo "<option value =\"".""."\">"."Select One"."</option>";
	$result =$db->RunQuery($sql);	
	while($row =mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["grnNO"]."\">".$row["grnNO"]."</option>";
	}
}
if($RequestType=="LoadOrderData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId = $_GET["styleId"];
	$ResponseXML .="<LoadOrderData>";
	
	$sql = "SELECT DISTINCT GD.intStyleId,O.strOrderNo FROM grndetails GD
				INNER JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				inner join orders O on O.intStyleId=GD.intStyleId
				inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intReject = 1 and GD.intSATrimIStatus<>2  and MSC.intInspection=1";
	if($styleId!="")
	{
		$sql.=" and O.strStyle='$styleId'";
	}
	$sql.=" order by strOrderNo DESC";
	$result_load =$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">"."Select One"."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
		}
		$ResponseXML .= "</LoadOrderData>\n";
		echo $ResponseXML;
}
if($RequestType=="LoadSCNo")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId = $_GET["styleId"];
	$ResponseXML .="<LoadSCNo>";
	
	$sql = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	if($styleId!="")
	{
		$sql.=" and orders.strStyle='$styleId'";
	}
	$sql.=" order by specification.intSRNO desc";
	$result_load =$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">"."Select One"."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
		}
		$ResponseXML .= "</LoadSCNo>\n";
		echo $ResponseXML;
}
if($RequestType=="LoadGrnDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$orderNo	= $_GET["orderNo"];
	$GRNNo		= $_GET["GRNNo"];
	$grnNoArray = explode('/',$GRNNo);
	
	$ResponseXML .="<LoadGrnDetails>";
	$sql = "SELECT	concat(GD.intGRNYear,'/',GD.intGrnNo)as grnNo,GD.intStyleId,O.strOrderNo,O.strDescription,MIL.strItemDescription,
			GD.intMatDetailID,GD.strColor,GD.strSize,MIL.strUnit, orders.strStyle,GD.intSATrimIStatus,
			GD.dblQty,GD.intPreInsp,GD.intPreInspQty,GD.intInspected,GD.dblInspPercentage,GD.intInspApproved,GD.intApprovedQty,
			GD.strComment,GD.intReject,GD.intRejectQty,GD.strReason,GD.intSpecialApp,GD.intSpecialAppQty,GD.strSpecialAppReason
			FROM orders AS O
			Inner Join grndetails AS GD ON O.intStyleId = GD.intStyleId
			Inner Join matitemlist AS MIL ON GD.intMatDetailID = MIL.intItemSerial
			Inner Join matsubcategory AS MSC ON MIL.intSubCatID = MSC.intSubCatNo
			Inner Join grnheader AS GH ON GD.intGrnNo = GH.intGrnNo AND GD.intGRNYear = GH.intGRNYear
			Inner Join orders ON GD.intStyleId = orders.intStyleId
			WHERE MSC.intInspection = '1' and GH.intStatus=1 and GD.intReject=1 and GD.intSATrimIStatus<>2 ";
	if($orderNo!="")
	$sql .= "and GD.intStyleId='$orderNo' ";	
	if($GRNNo!="")
	$sql .= "AND GD.intGrnNo =$grnNoArray[1] AND GD.intGRNYear =  $grnNoArray[0] ";
		
	$sql .= "AND GH.intCompanyID='$companyId' order by O.strOrderNo,O.strDescription,MIL.strItemDescription";
	//echo $sql;	
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<GRNNo><![CDATA[". $row["grnNo"] . "]]></GRNNo>\n";
		$ResponseXML .="<SATrimIStatus><![CDATA[". $row["intSATrimIStatus"] . "]]></SATrimIStatus>\n";
		$ResponseXML .="<TrimIStatus><![CDATA[". $row["intReject"] . "]]></TrimIStatus>\n";
		$ResponseXML .="<StyleID><![CDATA[". $row["intStyleId"] . "]]></StyleID>\n";
		$ResponseXML .="<Style><![CDATA[". $row["strStyle"] . "]]></Style>\n";
		$ResponseXML .="<OrderNo><![CDATA[". $row["strOrderNo"] . "]]></OrderNo>\n";
		$ResponseXML .="<Description><![CDATA[". $row["strDescription"] . "]]></Description>\n";	
		$ResponseXML .="<ItemDescription><![CDATA[". $row["strItemDescription"] . "]]></ItemDescription>\n";
		$ResponseXML .="<MatDetailID><![CDATA[". $row["intMatDetailID"] . "]]></MatDetailID>\n";					
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]. "]]></Size>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]. "]]></Unit>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]. "]]></Qty>\n";
		$Reject=$row["intReject"];
			if ($Reject==1)
			{
				$ResponseXML .="<Reject><![CDATA[TRUE]]></Reject>\n";
			}
			else
			{
				$ResponseXML .="<Reject><![CDATA[FALSE]]></Reject>\n";
			}
		$ResponseXML .= "<RejectQty><![CDATA[" . $row["intRejectQty"]. "]]></RejectQty>\n";
		$ResponseXML .= "<RejectReason><![CDATA[" . $row["strReason"]. "]]></RejectReason>\n";
			$SpecialApp=$row["intSpecialApp"];
			if ($SpecialApp==1)
			{
				$ResponseXML .="<SpecialApp><![CDATA[TRUE]]></SpecialApp>\n";
			}
			else
			{
				$ResponseXML .="<SpecialApp><![CDATA[FALSE]]></SpecialApp>\n";
			}
		$ResponseXML .= "<SpecialAppQty><![CDATA[" . $row["intSpecialAppQty"]. "]]></SpecialAppQty>\n";
		$ResponseXML .= "<SpecialAppReason><![CDATA[" . $row["strSpecialAppReason"]. "]]></SpecialAppReason>\n";
	}
	$ResponseXML .="</LoadGrnDetails>";
	echo $ResponseXML;
}
if($RequestType=="SaveGrnRejTrimInsDetails")
{
	$grnNo 		 = $_GET["grnNo"];
	$grnArray 	 = explode('/',$grnNo);
	$styleId 	 = $_GET["styleId"];
	$matDetId 	 = $_GET["matDetId"];
	$Color 		 = $_GET["Color"];
	$Size		 = $_GET["Size"];
	$spApp 		 = $_GET["spApp"];
	$spAppQty 	 = $_GET["spAppQty"];
	$spAppRemark = $_GET["spAppRemark"];
	
	$sql = "update grndetails 
			set
			intSpecialApp = '$spApp',
			strSpecialAppReason = '$spAppRemark',
			intSpecialAppQty = '$spAppQty',
			intSATrimIStatus = '1' , 
			intSATrimIBy = '$UserID' , 
			dtmSATrimIDate = now() 
			where
			intGrnNo = '$grnArray[1]' 
			and intGRNYear = '$grnArray[0]' 
			and intStyleId = '$styleId' 
			and intMatDetailID = '$matDetId'
			and strColor = '$Color' 
			and strSize = '$Size'";
	$result = $db->RunQuery($sql);
	 if($result!="")
	 	echo "Saved";
	 else
		echo "Error";			
}
if($RequestType=="ConfirmGrnRejTrimInsDetails")
{
	$grnNo 		= $_GET["grnNo"];
	$grnArray 	= explode('/',$grnNo);
	$styleId 	= $_GET["styleId"];
	$matDetId 	= $_GET["matDetId"];
	$Color 		= $_GET["Color"];
	$Size 		= $_GET["Size"];	
	$spAppQty 	= $_GET["spAppQty"];
	
	$sql_updateconfirm = "update grndetails 
							set
							intSATrimIStatus = '2' , 
							intSATrimIConfirmBy = '$UserID' , 
							intSATrimIConfirmDate = now()
							where
							intGrnNo = '$grnArray[1]' 
							and intGRNYear = '$grnArray[0]' 
							and intStyleId = '$styleId' 
							and intMatDetailID = '$matDetId' 
							and strColor = '$Color' 
							and strSize = '$Size'";
	$result=$db->RunQuery($sql_updateconfirm);
	
	$a1 		= $spAppQty;
	$year 		= date('Y');
	$sql = "select * from stocktransactions_temp ST_Twmp 
			where intGrnNo='$grnArray[1]' 
			and intGrnYear='$grnArray[0]' 
			and intStyleId=$styleId 
			and intMatDetailId=$matDetId 
			and strColor='$Color' 
			and strSize='$Size' 
			and strType='GRN'";
	$result_temp = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result_temp))
{	
	$temp_qty 	= $row["dblQty"];	
	if($temp_qty < $a1)
	{
		$a 	= $temp_qty;			
	}
	else
	{
		 $a = $a1;
	}
	$a1 	= $a1 - $a;
	$qty	= $a;
	if($a!=0)	
	{
		UpdateTemp($qty,$grnArray[1],$grnArray[0],$row["intStyleId"],$row["strBuyerPoNo"],$matDetId,$Color,$Size,$row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"]);	
		
		InsertToStock($year,$row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"],$row["intStyleId"],$row["strBuyerPoNo"],$grnArray[1],$grnArray[0],$matDetId,$Color,$Size,$row["strType"],$row["strUnit"],$qty,$row["intUser"]);
			
		DeleteZeroStock($grnArray[1],$grnArray[0],$row["intStyleId"],$row["strBuyerPoNo"],$matDetId,$Color,$Size,$row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"]);
	}	
}
echo "Confirmed";
}
function UpdateTemp($qty1,$docNo,$docYear,$orderId,$buyerPo,$matId,$Color,$Size,$mainId,$subId,$locationId,$binId)
{
global $db;
$sql="update stocktransactions_temp set dblQty = dblQty - $qty1 where intGrnNo='$docNo' and intGrnYear='$docYear' and intStyleId=$orderId and strBuyerPoNo='$buyerPo' and intMatDetailId=$matId and strColor='$Color' and strSize='$Size' and strtype='GRN' and  strMainStoresID=$mainId and strSubStores=$subId and strLocation=$locationId and strBin=$binId";
$result=$db->RunQuery($sql);
}
function InsertToStock($year,$mainId,$subId,$locationId,$binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,$type,$unit,$qty,$userId)
{
global $db;

	$sql="insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType)
		values('$year', 
		'$mainId', 
		'$subId', 
		'$locationId', 
		'$binId', 
		'$orderId', 
		'$buyerPo', 
		'$docNo', 
		'$docYear', 
		'$matId', 
		'$color', 
		'$size', 
		'$type', 
		'$unit', 
		'$qty', 
		now(), 
		'$userId', 
		'$docNo', 
		'$docYear','S');";
	$result=$db->RunQuery($sql);

	$sql_stn = "select intSTNno from grnheader where intGrnNo=$docNo and intGRNYear=$docYear";
	$result_stn = $db->RunQuery($sql_stn);
	$row_stn = mysql_fetch_array($result_stn);
	if($row_stn["intSTNno"]!="")
	{
		SaveStockTransaction($year,$mainId,$subId,$locationId,$binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,"STNF",$unit,$qty*-1,$userId);
		$v_mainId 		= GetVirtualMainstore($mainId);
		$v_subId 		= GetVertualSubStore($subId);
		$v_locationId	= GetVertualLocation($locationId);
		$v_binId 		= GetVertualBin($binId);
		SaveStockTransaction($year,$v_mainId,$v_subId,$v_locationId,$v_binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,"STNT",$unit,$qty,$userId);
	}
}

function SaveStockTransaction($year,$mainId,$subId,$locationId,$binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,$type,$unit,$qty,$userId)
{
global $db;
$sql="insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType)values('$year','$mainId','$subId','$locationId','$binId','$orderId','$buyerPo','$docNo','$docYear','$matId','$color','$size','$type','$unit','$qty',now(),'$userId','$docNo','$docYear','S');";
$result=$db->RunQuery($sql);
}

function DeleteZeroStock($docNo,$docYear,$orderId,$buyerPo,$matId,$Color,$Size,$mainId,$subId,$locationId,$binId)
{
global $db;
$sql="delete from stocktransactions_temp where intGrnNo='$docNo' and intGrnYear='$docYear' and intStyleId=$orderId and strBuyerPoNo='$buyerPo' and intMatDetailId=$matId and strColor='$Color' and strSize='$Size' and strtype='GRN' and strMainStoresID=$mainId and strSubStores=$subId and strLocation=$locationId and strBin=$binId and dblQty <=0
";
$result=$db->RunQuery($sql);
}

function GetVirtualMainstore($mainStore)
{
	global $db;
	$sql="select strMainID from mainstores where intSourceStores='$mainStore' and intStatus=1";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strMainID"];
}

function GetVertualSubStore($subStoreId)
{
	global $db;
	$sql="select strSubID from substores where intSourceStores='$subStoreId'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strSubID"];
}

function GetVertualLocation($location)
{
	global $db;
	$sql="select strLocID from storeslocations where intSourceStores='$location'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strLocID"];
}

function GetVertualBin($bin)
{
global $db;
	$sql="select strBinID from storesbins where intSourceStores='$bin'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strBinID"];
}


?>