<?php
session_start();
include "../Connector.php";
$backwardseperator ='../';
$RequestType = $_GET["RequestType"];
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$companyId=$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];
/*
Recut Status Details
0 - Pending
1 - Send to approval
2 - First Approval
3 - Confirm
*/
if($RequestType=="RemoveFile")
{
	$url	= $_GET["url"];
	$fh = fopen($url, 'a');
	fclose($fh);	
	unlink($url);
}
if($RequestType=="checkFileUploaded")
{
	$ResponseXML = "<Result>\n";
	$recutNo = $_GET["recutNo"];
	$recutNoArry = explode('/',$recutNo);
	$_SESSION["no"] = $recutNoArry[0].'-'.$recutNoArry[1];
	$folder ="../upload files/Recut/".$_SESSION["no"];
	
		if(count(glob("$folder/*")) === 0)
			$ResponseXML .= "<checkUpload><![CDATA[False]]></checkUpload>\n";
		else
			$ResponseXML .= "<checkUpload><![CDATA[True]]></checkUpload>\n";
	
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"getStyleWiseData")==0)
{
	$styleName = $_GET["styleName"];
	$chkUser = $_GET["chkUser"];
	$ResponseXML.="<StyleOrderdata>";
	
	$resOrder = getOrderNoList($userId,$styleName,$chkUser);
	$strO = '';
	$strO = "<option value=\"\" >Select One</option>";
	while($rowO = mysql_fetch_array($resOrder))
	{
		$strO .= "<option value=\"". $rowO["intStyleId"] ."\">" . $rowO["strOrderNo"] ."</option>";
	}
	
	$resSc = getSCNoList($userId,$styleName,$chkUser); 
	$strS = '';
	$strS = " <option value=\"\" >Select One</option>";
	while($rowS = mysql_fetch_array($resSc))
	{
		$strS .= "<option value=\"". $rowS["intStyleId"] ."\">" . $rowS["intSRNO"] ."</option>";
	}
	$ResponseXML.="<OrderNoList><![CDATA[" .$strO. "]]></OrderNoList>\n";
	$ResponseXML.="<SCNolist><![CDATA[" .$strS. "]]></SCNolist>\n";
	$ResponseXML.="</StyleOrderdata>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"recutNoList")==0)
{
	$status = $_GET["status"];
	$ResponseXML.="<recutNoList>";
	$intYear = $_GET["intYear"];
	$intYear =($intYear==''?date("Y"):$intYear);
	
	$sql = " SELECT intRecutNo FROM orders_recut WHERE intRecutYear = '$intYear' and intStatus='$status' ";
	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		$recut_arr.= $row['intRecutNo']."|";
	}
	$ResponseXML.="<recutNo><![CDATA[" .$recut_arr. "]]></recutNo>\n";
	$ResponseXML.="</recutNoList>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"getPreorderData")==0)
{
	$styleId = $_GET["styleId"];
	$recutNo = $_GET["recutNo"];
	if($recutNo != '')
	{
		$arrRecutNo = explode('/',$recutNo);
		$result=getRecutOrdersData($styleId,$arrRecutNo[1],$arrRecutNo[0]);
	}
	else
	{
		$result=getOrdersData($styleId);
	}
	
	$recutReason = '';
	$resposiblePerson='';
	$epfNo = '';	
	$ResponseXML.="<Orderdata>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<OrderNo><![CDATA[" .$row["strOrderNo"]. "]]></OrderNo>\n";
		$ResponseXML.="<StyleName><![CDATA[" .$row["strStyle"]. "]]></StyleName>\n";
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<CompanyID><![CDATA[" .$row["intCompanyID"]. "]]></CompanyID>\n";
		$ResponseXML.="<Description><![CDATA[" .$row["strDescription"]. "]]></Description>\n";
		$ResponseXML.="<BuyerID><![CDATA[" .$row["intBuyerID"]. "]]></BuyerID>\n";
		$ResponseXML.="<intQty><![CDATA[" .$row["intQty"]. "]]></intQty>\n";
		$ResponseXML.="<Status><![CDATA[" .$row["intStatus"]. "]]></Status>\n";
		$ResponseXML.="<CustomerRefNo><![CDATA[" .$row["strCustomerRefNo"]. "]]></CustomerRefNo>\n";
		$ResponseXML.="<SMVRate><![CDATA[" .$row["reaSMVRate"]. "]]></SMVRate>\n";
		$ResponseXML.="<FOB><![CDATA[" .$row["reaFOB"]. "]]></FOB>\n";
		$ResponseXML.="<Finance><![CDATA[" .$row["reaFinance"]. "]]></Finance>\n";
		$ResponseXML.="<UserID><![CDATA[" .$row["intUserID"]. "]]></UserID>\n";
		$ResponseXML.="<FinPercntage><![CDATA[" .$row["reaFinPercntage"]. "]]></FinPercntage>\n";
		$ResponseXML.="<EfficiencyLevel><![CDATA[" .$row["reaEfficiencyLevel"]. "]]></EfficiencyLevel>\n";
		$ResponseXML.="<CostPerMinute><![CDATA[" .$row["reaCostPerMinute"]. "]]></CostPerMinute>\n";
		$ResponseXML.="<ECSCharge><![CDATA[" .$row["reaECSCharge"]. "]]></ECSCharge>\n";
		$ResponseXML.="<BuyingOfficeId><![CDATA[" .$row["intBuyingOfficeId"]. "]]></BuyingOfficeId>\n";
		$ResponseXML.="<DivisionId><![CDATA[" .$row["intDivisionId"]. "]]></DivisionId>\n";
		$ResponseXML.="<SeasonId><![CDATA[" .$row["intSeasonId"]. "]]></SeasonId>\n";
		$ResponseXML.="<RPTMark><![CDATA[" .$row["strRPTMark"]. "]]></RPTMark>\n";
		$ResponseXML.="<LineNos><![CDATA[" .$row["intLineNos"]. "]]></LineNos>\n";
		$ResponseXML.="<UPCharges><![CDATA[" .$row["reaUPCharges"]. "]]></UPCharges>\n";
		$ResponseXML.="<UPChargesReason><![CDATA[" .$row["strUPChargeDescription"]. "]]></UPChargesReason>\n";
		$ResponseXML.="<AppDate><![CDATA[" .$row["dtmAppDate"]. "]]></AppDate>\n";
		$ResponseXML.="<ExPercentage><![CDATA[" .$row["reaExPercentage"]. "]]></ExPercentage>\n";
		$ResponseXML.="<SMV><![CDATA[" .$row["reaSMV"]. "]]></SMV>\n";
		$ResponseXML.="<Profit><![CDATA[" .$row["reaProfit"]. "]]></Profit>\n";
		$ResponseXML.="<SheduleMethod><![CDATA[" .$row["strScheduleMethod"]. "]]></SheduleMethod>\n";
		$ResponseXML.="<SubQty><![CDATA[" .$row["intSubContractQty"]. "]]></SubQty>\n";
		$ResponseXML.="<orderUnit><![CDATA[" .$row["orderUnit"]. "]]></orderUnit>\n";
		$ResponseXML.="<proSubcat><![CDATA[" .$row["productSubCategory"]. "]]></proSubcat>\n";		
		$ResponseXML.="<Coordinator><![CDATA[" .$row["intCoordinator"]. "]]></Coordinator>\n";	
		$ResponseXML.="<labourCost><![CDATA[" .$row["reaLabourCost"]. "]]></labourCost>\n";		
		$ResponseXML.="<facProfit><![CDATA[" .$row["dblFacProfit"]. "]]></facProfit>\n";
		$ResponseXML.="<OrderType><![CDATA[" .$row["intOrderType"]. "]]></OrderType>\n";
		$ResponseXML.="<facCostPerMin><![CDATA[" .$row["reaFactroyCostPerMin"]. "]]></facCostPerMin>\n";
		$ResponseXML.="<intRecutQty><![CDATA[" .$row["intRecutQty"]. "]]></intRecutQty>\n";
		if($recutNo != '')
		{
			$recutReason = $row["strRecutReason"];
			$resposiblePerson = $row["intReponsiblePerson"];
			$epfNo = $row["strEPFNo"];
		}
			
		$ResponseXML.="<recutReason><![CDATA[" .$recutReason. "]]></recutReason>\n";
		$ResponseXML.="<resposiblePerson><![CDATA[" .$resposiblePerson. "]]></resposiblePerson>\n";	
		$ResponseXML.="<epfNo><![CDATA[" .$epfNo. "]]></epfNo>\n";	
	}
	
	$ResponseXML.="</Orderdata>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"getPreorderItemData")==0)
{
	$styleID = $_GET["styleId"];
	$recutNo = $_GET["recutNo"];
	if($recutNo != '')
	{
		$arrRecutNo = explode('/',$recutNo);
		$result=getRecutOrderItemDetails($styleID,$arrRecutNo[1],$arrRecutNo[0]);
	}
	else
	{
		$result=getOrderDetailsData($styleID);
	}
	
	$ResponseXML.="<Orderdata>";
	while($row=mysql_fetch_array($result))
	{
		$OriginDet =  getOrigineName($row["intOriginNo"]);
		$arrOrigin = explode('*',$OriginDet);
		
		$ResponseXML.="<OrderNo><![CDATA[" .$row["strOrderNo"]. "]]></OrderNo>\n";
		$ResponseXML.="<MatDetailID><![CDATA[" .$row["intMatDetailID"]. "]]></MatDetailID>\n";
		$ResponseXML.="<ItemName><![CDATA[" .$row["strItemDescription"]. "]]></ItemName>\n";
		$ResponseXML.="<OrigineName><![CDATA[" .$arrOrigin[1]. "]]></OrigineName>\n";
		$ResponseXML.="<Unit><![CDATA[" .$row["strUnit"]. "]]></Unit>\n";		
		$ResponseXML.="<UnitPrice><![CDATA[" .$row["dblUnitPrice"]. "]]></UnitPrice>\n";
		$ResponseXML.="<ConPc><![CDATA[" .$row["reaConPc"]. "]]></ConPc>\n";
		$ResponseXML.="<Wastage><![CDATA[" .$row["reaWastage"]. "]]></Wastage>\n";
		$ResponseXML.="<OriginNo><![CDATA[" .$row["intOriginNo"]. "]]></OriginNo>\n";
		$ResponseXML.="<ReqQty><![CDATA[" .$row["dblReqQty"]. "]]></ReqQty>\n";
		$ResponseXML.="<TotalQty><![CDATA[" .$row["dblTotalQty"]. "]]></TotalQty>\n";
		$ResponseXML.="<TotalValue><![CDATA[" .$row["dblTotalValue"]. "]]></TotalValue>\n";
		$ResponseXML.="<totalcostpc><![CDATA[" .$row["dbltotalcostpc"]. "]]></totalcostpc>\n";
		$ResponseXML.="<Freight><![CDATA[" .$row["dblFreight"]. "]]></Freight>\n";
		$ResponseXML.="<MainItem><![CDATA[" .getMainItemName($row["intMatDetailID"]). "]]></MainItem>\n";
		$ResponseXML.="<MatMainCat><![CDATA[" .$row["intMainCatID"]. "]]></MatMainCat>\n";
		
		$ResponseXML.="<OriginType><![CDATA[" .$arrOrigin[0]. "]]></OriginType>\n";	
	}
	$ResponseXML.="</Orderdata>";
	echo $ResponseXML;
}
if(strcmp($RequestType,"getRecutNo")==0)
{	
	$intYear = date('Y');
	$strSQL="SELECT dblRecutNo FROM syscontrol WHERE syscontrol.intCompanyID='$companyId'";
	$result=$db->RunQuery($strSQL);
	$row = mysql_fetch_array($result);
	$recutNo = $row["dblRecutNo"];
	
	$SQL="update syscontrol set  dblRecutNo= dblRecutNo+1 WHERE syscontrol.intCompanyID='$companyId'";
	$results =$db->RunQuery($SQL);
	
	$ResponseXML.="<RecutNo>";
	$ResponseXML.="<intRecutNo><![CDATA[" .$recutNo. "]]></intRecutNo>\n";	
	$ResponseXML.="<intYear><![CDATA[" .$intYear. "]]></intYear>\n";	
	$ResponseXML.="</RecutNo>";
	
	echo $ResponseXML;
}
if(strcmp($RequestType,"getRecutHeader")==0)
{
	$styleID = $_GET["styleID"];
	$recutQty = $_GET["recutQty"];
	$recutNo = $_GET["recutNo"];
	$recutReason = $_GET["recutReason"];
	$responsiblePerson = $_GET["responsiblePerson"];
	$epfNo = $_GET["epfNo"];
	$arrRecutNo = explode('/',$recutNo);
	$responsiblePerson = ($responsiblePerson==''?'Null':$responsiblePerson);
	
	$intRecutNo =$arrRecutNo[1];
	$intRecutYear =  $arrRecutNo[0];
	
	$chkRecutAv = checkRecutDetailsAvailability($intRecutNo,$intRecutYear);
	if($chkRecutAv == 1)
		updateRecutHeaderData($intRecutNo,$intRecutYear,$styleID,$recutQty,$recutReason,$userId,$responsiblePerson,$epfNo);
	else	
		insertRecutHeaderData($intRecutNo,$intRecutYear,$styleID,$recutQty,$recutReason,$userId,$responsiblePerson,$epfNo);
	
}
if(strcmp($RequestType,"getRecutItemDetails")==0)
{
	$intrecutNo = $_GET["intrecutNo"];
	$intrecutYear = $_GET["intrecutYear"];
	$matDetailID = $_GET["matDetailID"];
	$strUnit = $_GET["strUnit"];
	$unitprice = $_GET["unitprice"];
	$conPc = $_GET["conPc"];
	$wastage = $_GET["wastage"];
	$originId = $_GET["originId"];
	$reqQty = $_GET["reqQty"];
	$totalQty = $_GET["totalQty"];
	$totalValue = $_GET["totalValue"];
	$costpc = $_GET["costpc"];
	$freight = $_GET["freight"];
	
	$chkRecAv = checkRecutItemDetailAv($intrecutNo,$intrecutYear,$matDetailID);
	if($chkRecAv == 1)
		updateRecutItemDetails($intrecutNo,$intrecutYear,$matDetailID,$strUnit,$unitprice,$conPc,$wastage,$originId,$reqQty,$totalQty,$totalValue,$costpc,$freight);
	else
		insertRecutItemDetails($intrecutNo,$intrecutYear,$matDetailID,$strUnit,$unitprice,$conPc,$wastage,$originId,$reqQty,$totalQty,$totalValue,$costpc,$freight);	
}

if(strcmp($RequestType,"updateRecutSendtoAppStatus")==0)
{
	$recutNo = $_GET["recutNo"];
	$arrRecutNo = explode('/',$recutNo);
	
	$sql = " update orders_recut set
	intStatus = '1' , dtmDate = now() 
	where
	intRecutNo = '$arrRecutNo[1]' and intRecutYear = '$arrRecutNo[0]' ";
	$result = $db->RunQuery($sql);
	
	$ResponseXML.="<AppStatus>";
	$ResponseXML.="<updateResult><![CDATA[" .$result. "]]></updateResult>\n";		
	$ResponseXML.="</AppStatus>";
	
	echo $ResponseXML;
}
if(strcmp($RequestType,"chekStyleRatio")==0)
{
	global $db;
	$styleNo = $_GET["styleNo"];
	
	$sql = " select * from styleratio where intStyleId='$styleNo' ";
	$result = $db->CheckRecordAvailability($sql);
	
	$ResponseXML.="<styleRatio>";
	$ResponseXML.="<styleRatioAv><![CDATA[" .$result. "]]></styleRatioAv>\n";		
	$ResponseXML.="</styleRatio>";
	
	echo $ResponseXML;
}

function getOrdersData($styleId)
{
	global $db;
	$sql ="SELECT strStyle,strOrderNo,intStyleId,o.intCompanyID,strDescription, reaLabourCost,intBuyerID,intQty,o.intStatus,intCoordinator,strCustomerRefNo,reaSMVRate,reaFOB,reaFinance,intUserID,reaFinPercntage,reaEfficiencyLevel,reaCostPerMinute,reaECSCharge,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark,intLineNos,reaUPCharges,strUPChargeDescription,dtmAppDate,reaExPercentage,reaSMV,strScheduleMethod,intSubContractQty,orderUnit,productSubCategory,reaProfit,dblFacProfit,reaFactroyCostPerMin,intOrderType,'0' as intRecutQty FROM orders o inner join companies c on o.intCompanyID = c.intCompanyID where intStyleId='$styleId' ";
	return $db->RunQuery($sql);
}
function getRecutOrdersData($styleId,$recutNo,$recutYear)
{
	global $db;
	$sql = "SELECT strStyle,strOrderNo,o.intStyleId,o.intCompanyID,strDescription, reaLabourCost,intBuyerID, intQty,o.intStatus,intCoordinator,strCustomerRefNo,reaSMVRate,reaFOB,reaFinance, o.intUserID,reaFinPercntage, reaEfficiencyLevel,reaCostPerMinute,reaECSCharge,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark,intLineNos, reaUPCharges,strUPChargeDescription,dtmAppDate,reaExPercentage,reaSMV,strScheduleMethod, intSubContractQty,orderUnit,productSubCategory,reaProfit,dblFacProfit,reaFactroyCostPerMin,
intOrderType,orc.intRecutQty,orc.strRecutReason,orc.intReponsiblePerson,orc.strEPFNo
 FROM orders o inner join companies c on o.intCompanyID = c.intCompanyID 
inner join orders_recut orc on orc.intStyleId = o.intStyleId
where o.intStyleId='$styleId'  and orc.intRecutNo='$recutNo' and orc.intRecutYear='$recutYear'";
	return $db->RunQuery($sql);
}
function getOrderDetailsData($styleID)
{

	global $db;
			$sql="SELECT strOrderNo,intStyleId,intMatDetailID,o.dblUnitPrice,reaConPc,reaWastage,intOriginNo, dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,dblFreight,m.strItemDescription,o.strUnit,intMainCatID
			FROM
			orderdetails AS o
			Inner Join matitemlist AS m ON o.intMatDetailID = m.intItemSerial
			Inner Join matsubcategory ON m.intSubCatID = matsubcategory.intSubCatNo AND m.intMainCatID = matsubcategory.intCatNo
			WHERE
			o.intStyleId =  '$styleID' AND
			matsubcategory.intStatus =  '1'
			ORDER BY m.intMainCatID, m.strItemDescription";
	return $db->RunQuery($sql);
}
function getRecutOrderItemDetails($styleID,$recutNo,$recutYear)
{
	global $db;
	$sql = "(SELECT strOrderNo,o.intStyleId,intMatDetailID,orcd.dblUnitPrice,reaConPc,reaWastage,intOriginNo, dblReqQty,dblTotalQty,
dblTotalValue,dbltotalcostpc,dblFreight,m.strItemDescription,orcd.strUnit,intMainCatID
FROM	orders_recut AS orc
inner join orderdetails_recut orcd on orc.intRecutNo = orcd.intRecutNo and orc.intRecutYear = orcd.intRecutYear
inner join orders o on o.intStyleId = orc.intStyleId
Inner Join matitemlist AS m ON orcd.intMatDetailID = m.intItemSerial
Inner Join matsubcategory ON m.intSubCatID = matsubcategory.intSubCatNo AND m.intMainCatID = matsubcategory.intCatNo
WHERE	matsubcategory.intStatus =  '1' and orc.intRecutNo='$recutNo' and orc.intRecutYear='$recutYear'
)
union
(SELECT o.strOrderNo,o.intStyleId,intMatDetailID,od.dblUnitPrice,reaConPc,reaWastage,intOriginNo, 0,0,
0,0,dblFreight,m.strItemDescription,od.strUnit,intMainCatID
FROM orders o inner join orderdetails od on o.intStyleId = od.intStyleId 
Inner Join matitemlist AS m ON od.intMatDetailID = m.intItemSerial
Inner Join matsubcategory ON m.intSubCatID = matsubcategory.intSubCatNo AND m.intMainCatID = matsubcategory.intCatNo
WHERE	matsubcategory.intStatus =  '1' and od.intStyleId='$styleID' and od.intMatDetailID not in (select orcd.intMatDetailID from orders_recut orc inner join
orderdetails_recut orcd on orc.intRecutNo = orcd.intRecutNo and orc.intRecutYear = orcd.intRecutYear 
where orc.intRecutNo='$recutNo' and orc.intRecutYear='$recutYear' )
)
ORDER BY intMainCatID, strItemDescription ";
	return $db->RunQuery($sql);
}
function getMainItemName($ItemID)
{
	global $db;
	$sql="SELECT intMainCatID FROM matitemlist i where i.intItemSerial='".$ItemID."';";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intMainCatID"];	
	
	
}
function getOrigineName($orgineID)
{
	global $db;
	$sql="SELECT strOriginType,intType FROM itempurchasetype where intOriginNo='".$orgineID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$str = $row["intType"].'*'.$row["strOriginType"];
		//$str = $row["strOriginType"];
	}
	return $str;	
}
function checkRecutDetailsAvailability($intRecutNo,$intRecutYear)
{
	global $db;
	$sql = "select * from orders_recut where intRecutNo = '$intRecutNo' and  intRecutYear = '$intRecutYear' ";
	return $db->CheckRecordAvailability($sql);
}
function insertRecutHeaderData($intRecutNo,$intRecutYear,$styleID,$recutQty,$recutReason,$userId,$responsiblePerson,$epfNo)
{
	global $db;
	$sql = " insert into orders_recut (intRecutNo,intRecutYear,intRecutQty,intStyleId,intUserID,intStatus,dtmDate,	strRecutReason, dtmRecutDate,intReponsiblePerson,strEPFNo)
	values 	('$intRecutNo', '$intRecutYear', '$recutQty','$styleID','$userId','0',now(),'$recutReason', now(),$responsiblePerson,'$epfNo')";
	$result=$db->RunQuery($sql);	
}
function updateRecutHeaderData($intRecutNo,$intRecutYear,$styleID,$recutQty,$recutReason,$userId,$responsiblePerson,$epfNo)
{
	global $db;
	$sql = " update orders_recut set intRecutQty = '$recutQty' , intStyleId = '$styleID' ,	intUserID = '$userId' , 
	intStatus = '0' ,	dtmDate =now() , 	strRecutReason = '$recutReason', intReponsiblePerson=$responsiblePerson,
	strEPFNo='$epfNo'
	where 	intRecutNo = '$intRecutNo' and intRecutYear = '$intRecutYear'  ";
	$result=$db->RunQuery($sql);
}
function checkRecutItemDetailAv($intrecutNo,$intrecutYear,$matDetailID)
{
	global $db;
	$sql = "select * from orderdetails_recut where intRecutNo='$intrecutNo' and  intRecutYear='$intrecutYear' and  intMatDetailID = '$matDetailID' ";
	return $db->CheckRecordAvailability($sql);
}
function insertRecutItemDetails($intrecutNo,$intrecutYear,$matDetailID,$strUnit,$unitprice,$conPc,$wastage,$originId,$reqQty,$totalQty,$totalValue,$costpc,$freight)
{
	global $db;
	$sql = "insert into orderdetails_recut 	(intRecutNo,intRecutYear,intMatDetailID,strUnit,dblUnitPrice,reaConPc, 
	reaWastage,	intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,	dblFreight)
	values	('$intrecutNo','$intrecutYear','$matDetailID','$strUnit','$unitprice','$conPc','$wastage','$originId', 
	'$reqQty','$totalQty','$totalValue','$costpc','$freight')";
	$result=$db->RunQuery($sql);
}
function updateRecutItemDetails($intrecutNo,$intrecutYear,$matDetailID,$strUnit,$unitprice,$conPc,$wastage,$originId,$reqQty,$totalQty,$totalValue,$costpc,$freight)
{
	global $db;
	$sql = " update orderdetails_recut 	set
	strUnit = '$strUnit' ,	dblUnitPrice = '$unitprice' ,	reaConPc = '$conPc' , 	reaWastage = '$wastage' , 
	intOriginNo = '$originId' , dblReqQty = '$reqQty' ,	dblTotalQty = '$totalQty' , dblTotalValue = '$totalValue' , 
	dbltotalcostpc = '$costpc' ,	dblFreight = '$freight'
	where
	intRecutNo = '$intrecutNo' and intRecutYear = '$intrecutYear' and intMatDetailID = '$matDetailID' ";
	$result=$db->RunQuery($sql);
}

function getOrderNoList($userId,$styleName,$chkUser)
{
	global $db;
	$sql = "select intStyleId,strOrderNo from orders where  intStatus  =11";
	if($chkUser =='TRUE')
		$sql .= " AND intUserID = '$userId' ";
	if($styleName != '')
		$sql .= " and strStyle = '$styleName'";
	$sql .= " order by strOrderNo ";
	
	return $db->RunQuery($sql);	
}
function getSCNoList($userId,$styleName,$chkUser)
{
	global $db;
	$sql = " select specification.intSRNO,orders.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus=11  ";
	if($chkUser =='TRUE')
		$sql .= " AND intUserID = '$userId' ";
	if($styleName != '')
		$sql .= " and orders.strStyle = '$styleName' ";
	$sql .= " order by intSRNO desc ";	
	
	return $db->RunQuery($sql);	
}
?>
