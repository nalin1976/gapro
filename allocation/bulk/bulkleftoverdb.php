<?php
include "../../Connector.php";
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

$sql="select MIL.strItemDescription,intMatDetailId,
CD.strColor,CD.strSize,CD.strUnit,dblQty,MIL.intSubCatID,
intBulkPoNo,intBulkPOYear,intBulkGrnNo,intBulkGRNYear
from commonstock_bulkdetails CD
inner join matitemlist MIL on MIL.intItemSerial=CD.intMatDetailId
where intTransferNo='$noArray[1]' and intTransferYear='$noArray[0]'";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{			
	$ResponseXML .= "<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
	$ResponseXML .= "<MatDetailId><![CDATA[".$row["intMatDetailId"]."]]></MatDetailId>\n";
	$ResponseXML .= "<Color><![CDATA[".$row["strColor"]."]]></Color>\n";
	$ResponseXML .= "<Size><![CDATA[".$row["strSize"]."]]></Size>\n";
	$ResponseXML .= "<Unit><![CDATA[".$row["strUnit"]."]]></Unit>\n";
	$ResponseXML .= "<Qty><![CDATA[".$row["dblQty"]."]]></Qty>\n";
	$ResponseXML .= "<SubCatId><![CDATA[".$row["intSubCatID"]."]]></SubCatId>\n";
	$ResponseXML .= "<BulkPONo><![CDATA[".$row["intBulkPoNo"]."]]></BulkPONo>\n";
	$ResponseXML .= "<BulkPOYear><![CDATA[".$row["intBulkPOYear"]."]]></BulkPOYear>\n";
	$ResponseXML .= "<BulkGRNNo><![CDATA[".$row["intBulkGrnNo"]."]]></BulkGRNNo>\n";
	$ResponseXML .= "<BulkGRNYear><![CDATA[".$row["intBulkGRNYear"]."]]></BulkGRNYear>\n";
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
	
		$Sql="select dblBulkAllocationNo from syscontrol where intCompanyID='$companyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		if ($rowcount > 0)
		{	
			while($row = mysql_fetch_array($result))
			{				
				$No=$row["dblBulkAllocationNo"];
				$NextNo=$No+1;
				$Year = date('Y');
				$sqlUpdate="UPDATE syscontrol SET dblBulkAllocationNo='$NextNo' WHERE intCompanyID='$companyId';";
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
	$no =$_GET["no"];
	$year =$_GET["year"];
	$remarks =$_GET["remarks"];	
	$res = 0;
$sql="select intTransferNo from commonstock_bulkheader where intTransferNo='$no' and intTransferYear='$year'";
$result=$db->RunQuery($sql);
$rowCount=mysql_num_rows($result);
	if($rowCount>0)
	{
		$sql_update="update commonstock_bulkheader set intStatus=1,strRemarks='$remarks',intConfirmBy='$userId',dtmConfirmDate=now() where intTransferNo='$no' and intTransferYear='$year'";
		$res = $db->RunQuery($sql_update);
	}else{
		$sql_insert="insert into commonstock_bulkheader 
					(intTransferNo, 
					intTransferYear, 
					intToStyleId, 
					intStatus,
					strRemarks,
					intUserId,
					dtmDate,
					intCompanyId)
					values
					('$no', 
					'$year', 
					'intToStyleId', 
					'intStatus',
					'$remarks',
					'$userId',
					now(),
					'intCompanyId');";
		$res = $db->RunQuery($sql_insert);
	}
	
	echo $res;
}
else if ($RequestType=="SaveDetails")
{
$no 		 = $_GET["no"];
$year 		 = $_GET["year"];
$matDetailId = $_GET["matDetailId"];
$color 		 = $_GET["color"];
$size 		 = $_GET["size"];
$units 		 = $_GET["units"];
$qty 		 = $_GET["qty"];
$BPONo		 = $_GET["BPONo"];
$BPOYear	 = $_GET["BPOYear"];
$BGRNNo 	 = $_GET["BGRNNo"];
$BGRNYear 	 = $_GET["BGRNYear"];	
$res         = 0;
	
$sql="select intTransferNo from commonstock_bulkdetails where intTransferNo='$no' and intTransferYear='$year'";
//echo $sql;
$result=$db->RunQuery($sql);
$rowCount=mysql_num_rows($result);
	if($rowCount>0)
	{
		$sql_update="update commonstock_bulkdetails 
					set
					dblQty = $qty 	
					where intTransferNo = '$no' 
					and intTransferYear = '$year' 
					and intMatDetailId = '$matDetailId' 
					and strColor = '$color' 
					and strSize = '$size' 
					and strUnit = '$units'
					and intBulkPoNo = '$BPONo'
					and intBulkPOYear = '$BPOYear' 
					and intBulkGrnNo = '$BGRNNo'
					and intBulkGRNYear = '$BGRNYear' ";
					
		$res  = $db->RunQuery($sql_update);
	}else{
		$sql_insert="insert into commonstock_bulkdetails 
					(intTransferNo, 
					intTransferYear, 
					intMatDetailId, 
					strColor, 
					strSize, 
					strUnit, 
					dblQty,
					intBulkPoNo, 
					intBulkPOYear, 
					intBulkGrnNo, 
					intBulkGRNYear)
					values
					('$no', 
					'$year', 
					'$matDetailId', 
					'$color', 
					'$size', 
					'$units', 
					'$qty',
					'$BPONo',
					'$BPOYear',
					'$BGRNNo',
					'$BGRNYear')";
					
		$res = $db->RunQuery($sql_insert);
	}
	
	echo $res;
}
else if ($RequestType=="SaveBinDetails")
{
	$no 			= $_GET["no"];
	$year 			= $_GET["year"];	
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
	
	$BPONo		 = $_GET["BPONo"];
	$BPOYear	 = $_GET["BPOYear"];
	$BGRNNo 	 = $_GET["BGRNNo"];
	$BGRNYear 	 = $_GET["BGRNYear"];	
	
	$commonbin 	= $_GET["pub_commonbin"];
	//echo $commonbin;
	if($commonbin == 1)
	{
		$sqlCommon="select * from storesbins where strMainID='$mainStoreId' AND intStatus=1 ;";	
		$resultCommon=$db->RunQuery($sqlCommon);
		while($rowCommon = mysql_fetch_array($resultCommon))
		{
			$subStoreId     = $rowCommon["strSubID"];
			$locationId		= $rowCommon["strLocID"];
			$binId			= $rowCommon["strBinID"];
		}	
		
			$SQLbinAllo = " Select * from storesbinallocation
			where strMainID='$mainStoreId' and strSubID='$subStoreId' and strLocID='$locationId' and strBinID='$binId' and intSubCatNo = '$subCatId' ";			
			$resBinAllo = $db->CheckRecordAvailability($SQLbinAllo);			
			if($resBinAllo != '1')
			{
				$x = "INSERT INTO storesbinallocation(strMainID,strSubID,strLocID,strBinID,intSubCatNo,strUnit,intStatus,dblCapacityQty)
				VALUES($mainStoreId,$subStoreId,$locationId,$binId,$subCatId,'$units','1','10000000')";
				$x1 = $db->RunQuery($x);
			}
	}
	
/*$sql="update storesbinallocation ".
	 "set ".
	 "dblFillQty = dblFillQty + $stockQty ".
	 "where ".
	 "strMainID = '$mainStoreId' AND ".
	 "strSubID = '$subStoreId ' AND ".
	 "strLocID = '$locationId' AND ".
	 "strBinID = '$binId' AND ".
	 "intSubCatNo = '$subCatId';";

$db->executeQuery($sql);*/

UpdateBulkStock($no,$year,$matDetailId,$color,$size,$units,$qty,$mainStoreId,$subStoreId,$locationId,$binId,$Year,"BAlloOut",$BGRNNo,$BGRNYear);

InsertStock($no,$year,$toStyleId,$toBuyerPoId,$matDetailId,$color,$size,$units,$stockQty,$mainStoreId,$subStoreId,$locationId,$binId,$Year,"BAlloIn",$BGRNNo,$BGRNYear,"B");

//update BulkGRNdetail balaceQty

updateGRNdetailBalanceQty($BGRNNo,$BGRNYear,$matDetailId,$size,$color,$stockQty);

//start 2010-10-08 update material ratio - (don't purchase the item which has bulk aloocation )
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
	
	$SQLHeder="SELECT COUNT(intTransferNo) AS headerRecCount FROM commonstock_bulkheader where intTransferNo=$no AND intTransferYear=$year";
	
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
			
	$SQLDetail="SELECT COUNT(intTransferNo) AS DetailsRecCount FROM commonstock_bulkdetails where intTransferNo=$no AND intTransferYear=$year";
	
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
		$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions where intDocumentNo=$no AND intDocumentYear=$year and strType='BAlloIn'";	

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

	$sql="select distinct intTransferNo,concat(intTransferYear,'/',intTransferNo)as concatNo from commonstock_bulkheader
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

	$sql="select strRemarks,intToStyleId,strStyle,strOrderNo,strToBuyerPoNo,intMainStoresID,merchantRemarks,LH.intStatus from commonstock_bulkheader LH
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
		$ResponseXML .= "<mainStore><![CDATA[".$row["intMainStoresID"]."]]></mainStore>\n";
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
			$result =  UpdateStatus($noArray[0],$noArray[1],$reason);
			$ResponseXML .= "<Check><![CDATA[TRUE]]></Check>\n";
			break;
		}
		case 1:
		{
			//BEGIN - Validation before cancel
			$sql=" select strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblQty,
			intGrnNo,intGrnYear  from stocktransactions where intDocumentNo='$noArray[1]' and intDocumentYear='$noArray[0]' and strType='BAlloIn'";
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
		
				$qty = $row["dblQty"];
				$validateQty = ValidateStock($row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"],$row["intStyleId"],$row["strBuyerPoNo"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["strUnit"],$row["intGrnNo"],$row["intGrnYear"],'B');
				
				$mrnQty = getMRNBalQty($row["strMainStoresID"],$row["intStyleId"],$row["strBuyerPoNo"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["intGrnNo"],$row["intGrnYear"],'B');
				
				$validateQty -= $mrnQty;
				if($qty>$validateQty)
				{
					$ResponseXML .= "<Check><![CDATA[FALSE]]></Check>\n";
					$ResponseXML .= "<Message><![CDATA["."Sorry!\nYou cannot cancel this allocation,Because no enought qty available in the Bin."."]]></Message>\n";
					$ResponseXML .= "</XMLCancel>";
					echo $ResponseXML;
					$validate 	= false;
					return;	
				}else{
					$ResponseXML .= "<Check><![CDATA[TRUE]]></Check>\n";
				}
			}
			
			if($validate){		
				CancelBulkStock($noArray[0],$noArray[1],"BAlloOut");
				Cancel($noArray[0],$noArray[1],"BAlloIn");
				
				//update material ratio qty - 2010-10-12
				updateCancelQtyinMatRatio($noArray[0],$noArray[1]);
				//update grndetail balance qty
				UpdateGRNQtyCanceAllo($noArray[1],$noArray[0]);
				$result =  UpdateStatus($noArray[0],$noArray[1],$reason);
				$ResponseXML .= "<Check><![CDATA[TRUE]]></Check>\n";
			}	
			//END - Validation before cancel
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
(select c.strName from companies c where c.intCompanyID = bh.intManufactCompanyId) as manufactCompany,
(select ua.Name from useraccounts ua where ua.intUserID = bh.intUserId) as userName,date(bh.dtmDate) as allocationDate
 from commonstock_bulkheader bh
where intStatus=0 and intCompanyId='$companyId'
order by intTransferYear,intTransferNo desc";
	$result = $db->RunQuery($sql);
		echo "<option value =\"".""."\">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["no"] ."\">".$row["no"].' - '.$row["manufactCompany"].' - '.$row["userName"].' - '.$row["allocationDate"]."</option>";
	}
}
//Start function
function GetBuyerPoName($buyerPoId)
{
global $db;
$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strBuyerPoName"];
}

function InsertStock($no,$year,$styleId,$buyerPoNo,$matDetailId,$color,$size,$units,$stockQty,$mainStoreId,$subStoreId,$locationId,$binId,$Year,$type,$BGrnNo,$BGrnYear,$GRNtype)
{
global $db;
global $userId;
$sqlbin="INSERT INTO  stocktransactions ".
		"(intYear, ".
		"strMainStoresID, ".
		"strSubStores, ".
		"strLocation, ".
		"strBin, ".
		"intStyleId, ".
		"strBuyerPoNo, ".
		"intDocumentNo, ".
		"intDocumentYear, ".
        "intMatDetailId, ".
		"strColor, ".
		"strSize, ".
		"strType, ".
		"strUnit, ".
		"dblQty, ".
		"dtmDate, ".
		"intUser,
		intGrnNo,
		intGrnYear,
		strGRNType
		) ".
		"VALUES ".
		"($Year, ".
		"'$mainStoreId', ".
		"'$subStoreId', ".
		"'$locationId', ".
		"'$binId', ".
		"'$styleId', ".
		"'$buyerPoNo', ".
		"$no, ".
		"$year, ".
		"$matDetailId, ".
        "'$color', ".
		"'$size', ".
		"'$type', ".
		"'$units', ".
		"$stockQty, ".
		"now(), ".
		"$userId,
		$BGrnNo,
		$BGrnYear,
		'$GRNtype'
		);";	
	$db->executeQuery($sqlbin);
}

function UpdateBulkStock($no,$year,$matDetailId,$color,$size,$units,$stockQty,$mainStoreId,$subStoreId,$locationId,$binId,$Year,$type,$bGRNno,$BgrnYear)
{
global $db;
global $userId;
$sqlbin="INSERT INTO  stocktransactions_bulk ".
		"(intYear, ".
		"strMainStoresID, ".
		"strSubStores, ".
		"strLocation, ".
		"strBin, ".
		"intDocumentNo, ".
		"intDocumentYear, ".
        "intMatDetailId, ".
		"strColor, ".
		"strSize, ".
		"strType, ".
		"strUnit, ".
		"dblQty, ".
		"dtmDate, ".
		"intUser,
		intBulkGrnNo,
		intBulkGrnYear
		) ".
		"VALUES ".
		"($Year, ".
		"'$mainStoreId', ".
		"'$subStoreId', ".
		"'$locationId', ".
		"'$binId', ".
		"$no, ".
		"$year, ".
		"$matDetailId, ".
        "'$color', ".
		"'$size', ".
		"'$type', ".
		"'$units', ".
		"$stockQty, ".
		"now(), ".
		"$userId,
		$bGRNno,
		$BgrnYear
		);";	
	$db->executeQuery($sqlbin);
}

function ValidateStock($mainStoreId,$subStoreId,$locationId,$binId,$styleId,$buyerPoId,$matDetailId,$color,$size,$unit,$grnNo,$grnYear,$grnType)
{
global $db;
$stockQty	= 0;
	$sql_validate="select sum(dblQty)as stockQty from stocktransactions where intStyleId='$styleId' and strBuyerPoNo='$buyerPoId' and intMatDetailId='$matDetailId' and strColor='$color' and strSize='$size' and strUnit='$unit' and strMainStoresID='$mainStoreId' and strSubStores='$subStoreId' and strLocation='$locationId' and strBin='$binId' and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and strGRNType='$grnType';";
	$result_validate=$db->RunQuery($sql_validate);
	while($row_validate=mysql_fetch_array($result_validate))
	{
		$stockQty = $row_validate["stockQty"];
	}
return $stockQty;
}
function CancelBulkStock($documentYear,$documentNo,$type)
{
global $db;
$insertType		= "C".$type;
$Year 		= date('Y');
		$sql_1="select strMainStoresID,strSubStores,strLocation,strBin,intMatDetailId,strColor,strSize,strUnit,dblQty, intBulkGrnNo,intBulkGrnYear from stocktransactions_bulk where intDocumentNo='$documentNo' and intDocumentYear='$documentYear' and strType='$type';";

	$result_1=$db->RunQuery($sql_1);
	while($row_1=mysql_fetch_array($result_1))
	{		
			$qty = ($row_1["dblQty"] * -1);
			
		UpdateBulkStock($documentNo,$documentYear,$row_1["intMatDetailId"],$row_1["strColor"],$row_1["strSize"],$row_1["strUnit"],$qty,$row_1["strMainStoresID"],$row_1["strSubStores"],$row_1["strLocation"],$row_1["strBin"],$Year,$insertType,$row_1["intBulkGrnNo"],$row_1["intBulkGrnYear"]);
	}
}
function Cancel($documentYear,$documentNo,$type)
{
global $db;
$insertType		= "C".$type;
$Year 		= date('Y');
		$sql_1="select strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblQty,
		intGrnNo, intGrnYear from stocktransactions where intDocumentNo='$documentNo' and intDocumentYear='$documentYear' and strType='$type';";

	$result_1=$db->RunQuery($sql_1);
	while($row_1=mysql_fetch_array($result_1))
	{		
			$qty = ($row_1["dblQty"] * -1);
			
		InsertStock($documentNo,$documentYear,$row_1["intStyleId"],$row_1["strBuyerPoNo"],$row_1["intMatDetailId"],$row_1["strColor"],$row_1["strSize"],$row_1["strUnit"],$qty,$row_1["strMainStoresID"],$row_1["strSubStores"],$row_1["strLocation"],$row_1["strBin"],$Year,$insertType,$row_1["intGrnNo"],$row_1["intGrnYear"],'B');
	}
}
function UpdateStatus($year,$no,$reason)
{
global $db;
global $userId;

	$sql_update="update commonstock_bulkheader 
	set intStatus = 10,intCancelBy='$userId', strCancelReason='$reason' , dtmCancelDate=now()
	where
	intTransferNo = '$no' 
	and intTransferYear = '$year';";
	$res = $db->RunQuery($sql_update);
	return $res;
}

function CheckStatus($year,$no)
{
global $db;
	$sql="select intStatus from commonstock_bulkheader where intTransferNo = '$no' and intTransferYear = '$year';";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["intStatus"];
}

function updateGRNdetailBalanceQty($grnNo,$grnYear,$matID,$size,$color,$qty)
{
	global $db;
	
	$sql = " update bulkgrndetails 
			set
			dblBalance = dblBalance-$qty
			where
			intBulkGrnNo = '$grnNo' and intYear = '$grnYear' and intMatDetailID = '$matID' and strColor = '$color' and strSize = '$size' ";
		$db->RunQuery($sql);	
}

function UpdateGRNQtyCanceAllo($alloNo,$alloYear)
{
	global $db;
	
	$sql = "SELECT intMatDetailId, strColor,strSize,dblQty,intBulkGrnNo,intBulkGRNYear 
			FROM commonstock_bulkdetails
			WHERE intTransferNo='$alloNo' AND intTransferYear='$alloYear'";
			
		$result=$db->RunQuery($sql);
		
		while($row=mysql_fetch_array($result))
		{
			$matID = $row["intMatDetailId"];
			$color = $row["strColor"];
			$size  = $row["strSize"];
			$dblQty = $row["dblQty"];
			$grnNo  = $row["intBulkGrnNo"];
			$grnYear = $row["intBulkGRNYear"];
			
			$gty = $dblQty*-1;
			
			updateGRNdetailBalanceQty($grnNo,$grnYear,$matID,$size,$color,$gty);
		}
			
	
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
	
	$SQL_BULK = "SELECT BCH.intToStyleId,BCH.strToBuyerPoNo,BCD.intMatDetailId,
				BCD.strColor,BCD.strSize,BCD.dblQty
				FROM commonstock_bulkdetails BCD INNER JOIN commonstock_bulkheader BCH ON
				BCD.intTransferNo = BCH.intTransferNo AND 
				BCD.intTransferYear = BCH.intTransferYear
				WHERE BCH.intTransferNo='$alloNo' AND BCH.intTransferYear = '$alloYear'";
				
		$result=$db->RunQuery($SQL_BULK);
		
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