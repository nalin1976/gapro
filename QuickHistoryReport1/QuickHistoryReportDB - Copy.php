<?php
include "../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="LoadDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$no = $_GET["no"];
$noArray = explode('/',$no);

$no = $_GET["no"];

$ResponseXML = "<XMLLoadDetails>\n";

$sql="select MIL.strItemDescription,intMatDetailId,intFromStyleId,(select strOrderNo from orders O where O.intStyleId=CD.intFromStyleId)As fromStyleName,CD.strColor,CD.strSize,CD.strUnit,dblQty,strBuyerPoNo,MIL.intSubCatID,CH.intMainStoresId,concat(intGrnYear,'/',intGrnNo)as GRNNo,CD.strGRNType from commonstock_leftoverdetails CD inner join commonstock_leftoverheader CH on CD.intTransferNo=CH.intTransferNo and CD.intTransferYear=CH.intTransferYear inner join matitemlist MIL on MIL.intItemSerial=CD.intMatDetailId where CH.intTransferNo='$noArray[1]' and CH.intTransferYear='$noArray[0]'";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	if(trim($row["strBuyerPoNo"])=="#Main Ratio#")
		$buyerPoNo = "#Main Ratio#";
	else 
		$buyerPoNo = GetBuyerPoName($row["strBuyerPoNo"]);
			
	$ResponseXML .= "<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
	$ResponseXML .= "<MatDetailId><![CDATA[".$row["intMatDetailId"]."]]></MatDetailId>\n";
	$ResponseXML .= "<StyleId><![CDATA[".$row["intFromStyleId"]."]]></StyleId>\n";
	$ResponseXML .= "<StyleName><![CDATA[".$row["fromStyleName"]."]]></StyleName>\n";
	$ResponseXML .= "<BuyerPoId><![CDATA[". trim($row["strBuyerPoNo"])."]]></BuyerPoId>\n";
	$ResponseXML .= "<BuyerPoName><![CDATA[". trim($buyerPoNo)."]]></BuyerPoName>\n";
	$ResponseXML .= "<Color><![CDATA[".$row["strColor"]."]]></Color>\n";
	$ResponseXML .= "<Size><![CDATA[".$row["strSize"]."]]></Size>\n";
	$ResponseXML .= "<Unit><![CDATA[".$row["strUnit"]."]]></Unit>\n";
	$ResponseXML .= "<Qty><![CDATA[".$row["dblQty"]."]]></Qty>\n";
	$ResponseXML .= "<SubCatId><![CDATA[".$row["intSubCatID"]."]]></SubCatId>\n";
	$ResponseXML .= "<MSId><![CDATA[".$row["intMainStoresId"]."]]></MSId>\n";
	$ResponseXML .= "<GRNNo><![CDATA[".$row["GRNNo"]."]]></GRNNo>\n";
	$ResponseXML .= "<GRNTypeId><![CDATA[".$row["strGRNType"]."]]></GRNTypeId>\n";
	if($row["strGRNType"]=='B')
		$grnType = 'Bulk';
	elseif($row["strGRNType"]=='S')
		$grnType = 'Style';
	$ResponseXML .= "<GRNType><![CDATA[".$grnType."]]></GRNType>\n";
}
$ResponseXML .= "</XMLLoadDetails>\n";
echo $ResponseXML;
}
else if($RequestType=="LoadNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
    $No=0;
	$ResponseXML ="<XMLLoadNo>\n";
	
		$Sql="select dblLeftOverAllocationNo from syscontrol where intCompanyID='$companyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		if ($rowcount > 0)
		{	
			while($row = mysql_fetch_array($result))
			{				
				$No=$row["dblLeftOverAllocationNo"];
				$NextNo=$No+1;
				$Year = date('Y');
				$sqlUpdate="UPDATE syscontrol SET dblLeftOverAllocationNo='$NextNo' WHERE intCompanyID='$companyId';";
				$db->executeQuery($sqlUpdate);
				$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
				$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
				$ResponseXML .= "<Year><![CDATA[".$Year."]]></Year>\n";
			}
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</XMLLoadNo>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveHeader")
{
$no 		= $_GET["no"];
$year 		= $_GET["year"];
$remarks 	= $_GET["remarks"];	
	
	$sql="select intTransferNo from commonstock_leftoverheader where intTransferNo='$no' and intTransferYear='$year'";
	$result=$db->RunQuery($sql);
	$rowCount=mysql_num_rows($result);
	if($rowCount>0)
	{
		$sql_update="update commonstock_leftoverheader set intStatus=1,intConfirmBy='$userId',dtmConfirmDate=now() where intTransferNo='$no' and intTransferYear='$year'";
		$db->executeQuery($sql_update);
	}
	else
	{
		$sql_insert="insert into commonstock_leftoverheader (intTransferNo,intTransferYear,intToStyleId,intStatus,strRemarks,intUserId,dtmDate,intCompanyId)values('$no','$year','intToStyleId','intStatus','$remarks','$userId',now(),'intCompanyId');";
		$db->executeQuery($sql_insert);
	}
}
else if ($RequestType=="SaveDetails")
{
$no 		 = $_GET["no"];
$year 		 = $_GET["year"];
$styleId 	 = $_GET["styleId"];	
$buyerPoNo	 = $_GET["buyerPoNo"];
$matDetailId = $_GET["matDetailId"];
$color 		 = $_GET["color"];
$size 		 = $_GET["size"];
$units 		 = $_GET["units"];
$qty 		 = $_GET["qty"];
$grnNo		 = $_GET["grnNo"];
$grnNoArray	 = explode('/',$grnNo);
$grnType	 = $_GET["grnType"];
	
	$sql="select intTransferNo from commonstock_leftoverdetails where intTransferNo='$no' and intTransferYear='$year'";
	$result=$db->RunQuery($sql);
	$rowCount=mysql_num_rows($result);
	if($rowCount>0)
	{
		$sql_update="update commonstock_leftoverdetails set dblQty = $qty where intTransferNo = '$no' and intTransferYear = '$year' and intFromStyleId = '$styleId' and strBuyerPoNo = '$buyerPoNo' and intMatDetailId = '$matDetailId' and strColor = '$color' and strSize = '$size' and strUnit = '$units' and intGrnYear='$grnNoArray[0]' and intGrnNo='$grnNoArray[1]' and strGRNType='$grnType';";
		$db->executeQuery($sql_update);
	}
	else
	{
		$sql_insert="insert into commonstock_leftoverdetails (intTransferNo,intTransferYear,intFromStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblQty,intGrnYear,intGrnNo,strGRNType) values('$no','$year','$styleId','$buyerPoNo','$matDetailId','$color','$size','$units','$qty','$grnNoArray[0]','$grnNoArray[1]','$grnType');";
		$db->executeQuery($sql_insert);
	}
}
else if ($RequestType=="SaveBinDetails")
{
$no 			= $_GET["no"];
$year 			= $_GET["year"];	
$styleId		= $_GET["styleId"];
$buyerPoNo 		= $_GET["buyerPoNo"];
$matDetailId 	= $_GET["matDetailId"];
$color 			= $_GET["color"];
$size 			= $_GET["size"];
$units 			= $_GET["units"];
$stockQty 		= $_GET["stockQty"];		
$mainStoreId 	= $_GET["mainStoreId"];
$subStoreId 	= $_GET["subStoreId"];
$locationId 	= $_GET["locationId"];
$binId 			= $_GET["binId"];
$subCatId		= $_GET["subCatId"];		
$Year 			= date('Y');
$qty 			= $stockQty * -1;
$toStyleId		= $_GET["toStyleId"];
$toBuyerPoId	= $_GET["toBuyerPoId"];
$grnNo			= $_GET["grnNo"];
$grnNoArray		= explode('/',$grnNo);
$grnType		= $_GET["grnType"];

InsertStock("stocktransactions_leftover",$no,$year,$styleId,$buyerPoNo,$matDetailId,$color,$size,$units,$qty,$mainStoreId,$subStoreId,$locationId,$binId,$Year,"LAlloOut",$grnNoArray[0],$grnNoArray[1],$grnType);
InsertStock("stocktransactions",$no,$year,$toStyleId,$toBuyerPoId,$matDetailId,$color,$size,$units,$stockQty,$mainStoreId,$subStoreId,$locationId,$binId,$Year,"LAlloIn",$grnNoArray[0],$grnNoArray[1],$grnType);
//update material ratio qty
updateMatRatio($toStyleId,$toBuyerPoId,$matDetailId,$color,$size,$units,$stockQty);
}
else if ($RequestType=="SaveValidate")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$no=$_GET["no"];
	$year =$_GET["year"];
	$validateCount =$_GET["validateCount"];		
	$validateBinCount =$_GET["validateBinCount"];	
	
	$ResponseXML .="<SaveValidate>\n";
	
	$SQLHeder="SELECT COUNT(intTransferNo) AS headerRecCount FROM commonstock_leftoverheader where intTransferNo=$no AND intTransferYear=$year";
	
	$resultHeader=$db->RunQuery($SQLHeder);
	
			while($row = mysql_fetch_array($resultHeader))
			{		
				$recCountHeader=$row["headerRecCount"];
			
				if($recCountHeader>0)
				{
					$ResponseXML .= "<recCountHeader><![CDATA[TRUE]]></recCountHeader>\n";
				}
				else
				{	
					$ResponseXML .= "<recCountHeader><![CDATA[FALSE]]></recCountHeader>\n";
				}
			}	
			
	$SQLDetail="SELECT COUNT(intTransferNo) AS DetailsRecCount FROM commonstock_leftoverdetails where intTransferNo=$no AND intTransferYear=$year";
	
	$resultDetail=$db->RunQuery($SQLDetail);
		
			while($row =mysql_fetch_array($resultDetail))
			{
				$recCountDetails=$row["DetailsRecCount"];
				
					if($recCountDetails==$validateCount)
					{
						$ResponseXML .= "<recCountDetails><![CDATA[TRUE]]></recCountDetails>\n";
					}
					else
					{
						$ResponseXML .= "<recCountDetails><![CDATA[FALSE]]></recCountDetails>\n";
					}
			}
		$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions where intDocumentNo=$no AND intDocumentYear=$year and strType='LAlloIn'";	

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$recCountBin=$row["binDetails"];		
		
			if($recCountBin==$validateBinCount)
			{
				$ResponseXML .= "<recCountBinDetails><![CDATA[TRUE]]></recCountBinDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountBinDetails><![CDATA[FALSE]]></recCountBinDetails>\n";
			}
	}	
	
	$ResponseXML .="</SaveValidate>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$state	= $_GET["state"];
$year	= $_GET["year"];

$ResponseXML  = "<XMLLoadPopNo>\n";

	$sql="select distinct intTransferNo,concat(intTransferYear,'/',intTransferNo)as concatNo from commonstock_leftoverheader
	where intTransferYear='$year' and intStatus=$state and intCompanyId='$companyId' order by intTransferNo desc";

	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value=\"". "" ."\">Select One</option>\n";	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["concatNo"] ."\">".$row["intTransferNo"]."</option>\n";
	}
$ResponseXML .= "</XMLLoadPopNo>";
echo $ResponseXML;
}

else if($RequestType=="LoadHeaderDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$no	= $_GET["no"];
$noArray	= explode('/',$no);

$ResponseXML  = "<XMLLoadHeaderDetails>\n";

	$sql="select strRemarks,intToStyleId,strStyle,strOrderNo,strToBuyerPoNo,merchantRemarks,LH.intStatus 
	from commonstock_leftoverheader LH
	inner join orders O on LH.intToStyleId=O.intStyleId
	where intTransferNo='$noArray[1]' and intTransferYear='$noArray[0]'";

	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["strToBuyerPoNo"]=="#Main Ratio#")
			$toBuyerPoName = "#Main Ratio#";
		else 
			$toBuyerPoName = GetBuyerPoName($row["strToBuyerPoNo"]);
		
		$ResponseXML .= "<Remarks><![CDATA[".$row["strRemarks"]."]]></Remarks>\n";
		$ResponseXML .= "<ToStyleName><![CDATA[".$row["strOrderNo"]."]]></ToStyleName>\n";
		$ResponseXML .= "<ToStyleId><![CDATA[".$row["intToStyleId"]."]]></ToStyleId>\n";
		$ResponseXML .= "<ToBuyerPoName><![CDATA[". $toBuyerPoName ."]]></ToBuyerPoName>\n";
		$ResponseXML .= "<ToBuyerPoId><![CDATA[".$row["strToBuyerPoNo"]."]]></ToBuyerPoId>\n";
		$ResponseXML .= "<merchantRemarks><![CDATA[".$row["merchantRemarks"]."]]></merchantRemarks>\n";
		$ResponseXML .= "<intStatus><![CDATA[".$row["intStatus"]."]]></intStatus>\n";
	}
$ResponseXML .= "</XMLLoadHeaderDetails>";
echo $ResponseXML;
}

else if($RequestType=="Cancel")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$no	= $_GET["no"];
$noArray	= explode('/',$no);
$reason = $_GET["reason"];
$ResponseXML  = "<XMLCancel>\n";
$validate 	= true;
	
	$status = CheckStatus($noArray[0],$noArray[1]);
	switch($status)
	{
		case 0:
		{
			UpdateStatus($noArray[0],$noArray[1],$reason);
			$ResponseXML .= "<Check><![CDATA[TRUE]]></Check>\n";
			break;
		}
		case 1:
		{
			$sql="select strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblQty,intGrnNo,intGrnYear,strGRNType from stocktransactions where intDocumentNo='$noArray[1]' and intDocumentYear='$noArray[0]' and strType='LAlloIn'";
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				$qty = $row["dblQty"];
				$validateQty = ValidateStock($row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"],$row["intStyleId"],$row["strBuyerPoNo"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["strUnit"],$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"]);
				//get mrn Qty 
				$mrnQty = getMRNBalQty($row["strMainStoresID"],$row["intStyleId"],$row["strBuyerPoNo"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"]);
				
				$validateQty -= $mrnQty;
				if($qty>$validateQty)
				{
					$ResponseXML .= "<Check><![CDATA[FALSE]]></Check>\n";
					$ResponseXML .= "<Message><![CDATA["."Sorry!\nYou cannot cancel this allocation,Because no enought stock qty available in the Bin."."]]></Message>\n";
					$validate 	  = false;
					$ResponseXML .= "</XMLCancel>";
					echo $ResponseXML;
					return;	
				}
				else
				{
					$ResponseXML .= "<Check><![CDATA[TRUE]]></Check>\n";
				}
			}
			
			if($validate)
			{		
				Cancel("stocktransactions_leftover",$noArray[0],$noArray[1],"LAlloOut");
				Cancel("stocktransactions",$noArray[0],$noArray[1],"LAlloIn");
				UpdateStatus($noArray[0],$noArray[1],$reason);
				//UpdateBinAllocation($noArray[0],$noArray[1]);
				//update material ratios
				updateCancelQtyinMatRatio($noArray[0],$noArray[1]);
				$ResponseXML .= "<Check><![CDATA[TRUE]]></Check>\n";
			}
			break;
		}
		case 10:
		{
			$ResponseXML .= "<Check><![CDATA[FALSE]]></Check>\n";
			$ResponseXML .= "<Message><![CDATA["."Sorry!\nThis allocation is already canceled."."]]></Message>\n";
			break;
		}
	}

$ResponseXML .= "</XMLCancel>";
echo $ResponseXML;
}
else if($RequestType=="getCommonBin")
{
	$mainstoreID = $_GET["mainstoreID"];
	$SQL = " select intCommonBin from mainstores where strMainID=$mainstoreID  and intStatus=1 ";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	$commBin =  trim($row["intCommonBin"]);
	
	echo $commBin;
}
else if($RequestType=="ReloadAllocationNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$sql = "select concat(intTransferYear,'/',intTransferNo)As no,
(select c.strName from companies c where c.intCompanyID = LH.intManufactCompanyId ) as manufactCompany,
(select ua.Name from useraccounts ua where ua.intUserID = LH.intUserId) as userName,date(LH.dtmDate) as allocationDate
 from commonstock_leftoverheader LH
	where intStatus=0 and intCompanyId='$companyId'
	order by intTransferYear,intTransferNo desc";
	$result = $db->RunQuery($sql);
		echo "<option value =\"".""."\">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["no"] ."\">".$row["no"].' - '.$row["manufactCompany"].' - '.$row["userName"].' - '.$row["allocationDate"]."</option>";
	}
}

//Start functions

function GetBuyerPoName($buyerPoId)
{
global $db;
$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strBuyerPoName"];
}
function InsertStock($tblName,$no,$year,$styleId,$buyerPoNo,$matDetailId,$color,$size,$units,$stockQty,$mainStoreId,$subStoreId,$locationId,$binId,$Year,$type,$grnYear,$grnNo,$grnType)
{
global $db;
global $userId;
$sqlbin="INSERT INTO  $tblName (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ($Year,'$mainStoreId','$subStoreId','$locationId','$binId','$styleId','$buyerPoNo',$no,$year,$matDetailId,'$color','$size','$type','$units',$stockQty, now(),$userId,'$grnNo','$grnYear','$grnType');";	
$db->executeQuery($sqlbin);
}

function ValidateStock($mainStoreId,$subStoreId,$locationId,$binId,$styleId,$buyerPoId,$matDetailId,$color,$size,$unit,$grnNo,$grnYear,$grnType)
{
global $db;
$stockQty	= 0;
	$sql_validate="select sum(dblQty)as stockQty from stocktransactions where intStyleId='$styleId' and strBuyerPoNo='$buyerPoId' and intMatDetailId='$matDetailId' and strColor='$color' and strSize='$size' and strUnit='$unit' and strMainStoresID='$mainStoreId' and strSubStores='$subStoreId' and strLocation='$locationId' and strBin='$binId' and intGrnNo='$grnNo' and intGrnYear='$grnYear' and strGRNType='$grnType'";
	$result_validate=$db->RunQuery($sql_validate);
	while($row_validate=mysql_fetch_array($result_validate))
	{
		$stockQty = $row_validate["stockQty"];
	}
return $stockQty;
}

function Cancel($tblName,$documentYear,$documentNo,$type)
{
global $db;
$insertType		= "C".$type;
$Year 		= date('Y');
		$sql_1="select strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblQty,intGrnNo,intGrnYear,strGRNType from $tblName where intDocumentNo='$documentNo' and intDocumentYear='$documentYear' and strType='$type';";

	$result_1=$db->RunQuery($sql_1);
	while($row_1=mysql_fetch_array($result_1))
	{		
			$qty = ($row_1["dblQty"] * -1);
			
		InsertStock($tblName,$documentNo,$documentYear,$row_1["intStyleId"],$row_1["strBuyerPoNo"],$row_1["intMatDetailId"],$row_1["strColor"],$row_1["strSize"],$row_1["strUnit"],$qty,$row_1["strMainStoresID"],$row_1["strSubStores"],$row_1["strLocation"],$row_1["strBin"],$Year,$insertType,$row_1["intGrnYear"],$row_1["intGrnNo"],$row_1["strGRNType"]);
	}
}
function UpdateStatus($year,$no,$reason)
{
global $db;
global $userId;
	$sql_update="update commonstock_leftoverheader 
	set intStatus = 10,intCancelBy='$userId', strCancelReason='$reason' ,dtmCancelDate=now()
	where
	intTransferNo = '$no' 
	and intTransferYear = '$year';";
	$db->executeQuery($sql_update);
}
function CheckStatus($year,$no)
{
global $db;
	$sql="select intStatus from commonstock_leftoverheader 	
	where
	intTransferNo = '$no' 
	and intTransferYear = '$year';";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["intStatus"];
}

function updateMatRatio($toStyleId,$toBuyerPoId,$matDetailId,$color,$size,$units,$stockQty)
{

	global $db;
	
	$sql="SELECT dblBalQty FROM materialratio WHERE intStyleId='".$toStyleId."' AND strMatDetailID='".$matDetailId."' AND strColor='".$color."' AND strSize='".$size."' AND strBuyerPONO='".$toBuyerPoId."';";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
		{
		$qty0=$row["dblBalQty"];
		
		}
		
		$balqty=$qty0-$stockQty;
	
	$sqlUP="UPDATE materialratio SET dblBalQty='".$balqty."' WHERE intStyleId='".$toStyleId."' AND strMatDetailID='".$matDetailId."' AND strColor='".$color."'
	 AND strSize='".$size."' AND strBuyerPONO='".$toBuyerPoId."';";
	 //echo $sqlUP;
	$db->RunQuery($sqlUP);
}

function updateCancelQtyinMatRatio($alloYear,$alloNo)
{
	global $db;
	
	$SQL_left = "SELECT LCH.intToStyleId,LCH.strToBuyerPoNo,LCD.intMatDetailId,
				LCD.strColor,LCD.strSize,LCD.dblQty
				FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
				LCD.intTransferNo = LCH.intTransferNo AND 
				LCD.intTransferYear = LCH.intTransferYear
				WHERE LCH.intTransferNo='$alloNo' AND LCH.intTransferYear = '$alloYear'";
				
		$result=$db->RunQuery($SQL_left);
		
		while($row = mysql_fetch_array($result))
		{
			$styleID = $row["intToStyleId"];
			$buyerPO = $row["strToBuyerPoNo"];
			$matDetailID = $row["intMatDetailId"];
			$color   = $row["strColor"];
			$size    = $row["strSize"];
			$qty     = $row["dblQty"];
		
			$sqlUP="UPDATE materialratio SET dblBalQty= dblBalQty + $qty
		WHERE intStyleId='".$styleID."' AND strMatDetailID='".$matDetailID."' AND strColor='".$color."'
	 AND strSize='".$size."' AND strBuyerPONO='".$buyerPO."';";
	 //echo $sqlUP;
	$db->RunQuery($sqlUP);
		}
		
		
}
function getMRNBalQty($mainstoreId,$styleId,$buyerPOno,$matDetailId,$color,$size,$grnNo,$grnYear,$grnType)
{
	global $db;
	$sql = "select round(sum(mrd.dblBalQty),2) as qty from matrequisition mrn inner join matrequisitiondetails mrd on
mrn.intMatRequisitionNo = mrd.intMatRequisitionNo and mrn.intMRNYear = mrd.intYear
where mrd.intStyleId='$styleId' and mrd.strBuyerPONO='$buyerPOno' and strMatDetailID='$matDetailId' and strColor='$color'
and strSize='$size' and intGrnNo='$grnNo' and intGrnYear='$grnYear' and strGRNType='$grnType' and strMainStoresID='$mainstoreId'
and mrd.dblBalQty>0 ";
	
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["qty"];
}

?>