<?php
include "../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];
if($RequestType=="GetNo")
{

$mainStoreID = $_GET["mainStoreID"];
$comID  		= GetCompanyDetails($mainStoreID);
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML ="<GetNo>\n";
$sql="select dblLeftOverAllocationNo from syscontrol where intCompanyID='$comID'";
$ComAv = $db->CheckRecordAvailability($sql);
	
	if($ComAv == '1')
	{
		$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				$no = $row["dblLeftOverAllocationNo"];
				$year = date('Y');
				$ResponseXML .= "<No><![CDATA[" . $no . "]]></No>\n";	
				$ResponseXML .= "<Year><![CDATA[" . $year. "]]></Year>\n";
			}
			$sql_update ="update syscontrol set dblLeftOverAllocationNo =dblLeftOverAllocationNo +1 where intCompanyID = '$comID'";
			$db->executeQuery($sql_update);
	}
	else
	{
		$no = 'NA';
		$ResponseXML .= "<No><![CDATA[" . $no . "]]></No>\n";	
	}

$ResponseXML .="</GetNo>";
echo $ResponseXML;
}
elseif($RequestType=="SaveHeader")
{
	$no				= $_GET["no"];
	$year			= $_GET["year"];

	$toStyleId		= $_GET["toStyleId"];
	$toBuyerPoNo	= $_GET["toBuyerPoNo"];
	$mainStoreID	= $_GET["mainStoreID"];
	$manufactCom	= $_GET["manufactCom"];
	$merchantRemarks = $_GET["merchantRemarks"];
	$comID  		= GetCompanyDetails($mainStoreID);
	
	$sqlH="insert into commonstock_leftoverheader 
		(intTransferNo,	intTransferYear,intToStyleId,strToBuyerPoNo,intUserId,dtmDate,intMainStoresId,intCompanyId, intManufactCompanyId, merchantRemarks)
		values ('$no','$year','$toStyleId','$toBuyerPoNo','$userId',now(),$mainStoreID,'$comID','$manufactCom', '$merchantRemarks');";
	$resH = $db->RunQuery($sqlH);
	
	echo $resH;
}

elseif($RequestType=="SaveDetails")
{
$no				= $_GET["no"];
$year			= $_GET["year"];
$fromStyleId	= $_GET["fromStyleId"];
$matDetailId	= $_GET["matDetailId"];
$color			= $_GET["color"];
$size			= $_GET["size"];
$units			= $_GET["units"];
$qty			= $_GET["qty"];
$buyerPoNo		= $_GET["buyerPoNo"];
$grnNo			= $_GET["grnNo"];
$grnYear		= $_GET["grnYear"];
$grnType		= $_GET["grnType"];
	
	
	$sql="insert into commonstock_leftoverdetails 
		(intTransferNo, 
		intTransferYear, 
		intFromStyleId,
		strBuyerPoNo, 
		intMatDetailId, 
		strColor, 
		strSize,
		strUnit, 
		dblQty,
		intGrnNo,
		intGrnYear,
		strGRNType)
		values
		('$no', 
		'$year', 
		'$fromStyleId',
		'$buyerPoNo', 
		'$matDetailId', 
		'$color', 
		'$size',
		'$units',
		'$qty',
		'$grnNo',
		'$grnYear',
		'$grnType')";
	$resD = $db->RunQuery($sql);	
	$response ='';
	
	if($resD == '1')
	{
		$response =1;
	}
	else
	{
		$response =0;
	}	
	echo $response;
}

//Send email for nominated users to inform leftover allocation no
elseif($RequestType=="EmailAllocationNo")
{
	$no				= $_GET["no"];
	$year			= $_GET["year"];
	$toStyleId	= $_GET["toStyleId"];
	$type       = $_GET["type"];
	$mainStoreID	= $_GET["mainStoreID"];
	$comID  		= GetCompanyDetails($mainStoreID);
	
	include "../EmailSender.php";
		$eml =  new EmailSender();
		$today = date("F j, Y, g:i a");      
		$userName     = getUserName();
		$styleName =  GetStyle($toStyleId);
		$AlloNo = $no.'/'.$year;
		
		if($type == 'left')
		{
			$qty = getLeftOverAlloQty($no,$year,$comID);
			//echo $qty;
			$alloTYpe = 'Left Over Allocation';
		}
		else if($type == 'bulk')
		{
			$qty = getSumBulkAlloQty($no,$year,$comID);
			//echo $qty;
			$alloTYpe = 'Bulk Allocation';
		}
		
		$body 		= "Style Name    : $styleName <br>
					   Allocation No : $AlloNo <br>
					   Allocated Quantity      : $qty  <br>
					   User          : $userName &nbsp;  - &nbsp;  $today   <br>
					   Objective     : For your information <br>	 ";	
					   	
		$fieldName = 'intEditBomDelScheduleId';
		$sender = '';
		$reciever = '';
		
		$subject = "Style Name: $styleName New $alloTYpe in BOM";				
		$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
}


elseif($RequestType=="SaveValidation")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$no 			= $_GET["no"];
$year			= $_GET["year"];
$headerCount 	= 1;
$detailCount 	= $_GET["detailCount"];
$ResponseXML = "<ValidateDetails>\n";

$sql_header="select count(*)as headerCount from commonstock_leftoverheader where intTransferNo='$no' and intTransferYear='$year'";
$result_header=$db->RunQuery($sql_header);
while($row_header=mysql_fetch_array($result_header))
{
	if($headerCount==$row_header["headerCount"])
		$ResponseXML .= "<Header><![CDATA[TRUE]]></Header>\n";
	else
		$ResponseXML .= "<Header><![CDATA[FALSE]]></Header>\n";
}

$sql_details="select count(*)as detailsCount from commonstock_leftoverdetails where intTransferNo='$no' and intTransferYear='$year'";
$result_details=$db->RunQuery($sql_details);
while($row_details=mysql_fetch_array($result_details))
{
	if($detailCount==$row_details["detailsCount"])
		$ResponseXML .= "<Details><![CDATA[TRUE]]></Details>\n";
	else
		$ResponseXML .= "<Details><![CDATA[FALSE]]></Details>\n";
}
$ResponseXML .= "<No><![CDATA[".$year.'/'.$no."]]></No>\n";

$ResponseXML .= "</ValidateDetails>\n";
echo $ResponseXML;
}
//bulk allocation 
elseif($RequestType=="GetBulkNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML ="<GetNo>\n";
$mainStoreID = $_GET["mainStoreID"];
$comID       = GetCompanyDetails($mainStoreID);
$sql="select dblBulkAllocationNo from syscontrol where intCompanyID='$comID'";

$ComAv = $db->CheckRecordAvailability($sql);
if($ComAv == '1')
{
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$no = $row["dblBulkAllocationNo"];
			$year = date('Y');
			$ResponseXML .= "<No><![CDATA[" . $no . "]]></No>\n";	
			$ResponseXML .= "<Year><![CDATA[" . $year. "]]></Year>\n";
		}
		
		$sql_update ="update syscontrol set dblBulkAllocationNo = dblBulkAllocationNo +1 where intCompanyID = '$comID'";
		$db->executeQuery($sql_update);
}	
else
{
	$no = 'NA';
	//$year = 'NA';
	$ResponseXML .= "<No><![CDATA[" . $no . "]]></No>\n";	
			//$ResponseXML .= "<Year><![CDATA[" . $year. "]]></Year>\n";
}
$ResponseXML .="</GetNo>";
echo $ResponseXML;

}
elseif($RequestType=="SaveBulkDetails")
{
$no				 = $_GET["no"];
$year			 = $_GET["year"];
$matDetailId	 = $_GET["matDetailId"];
$toStyleId		 = $_GET["toStyleId"];
$color			 = $_GET["color"];
$size			 = $_GET["size"];
$units			 = $_GET["units"];
$qty			 = $_GET["qty"];
$bulkToBuyerPoNo = $_GET["bulkToBuyerPoNo"];

	$sql="insert into commonstock_bulkheader 
		(intTransferNo, 
		intTransferYear, 
		intToStyleId, 
		strToBuyerPoNo,
		intUserId,
		dtmDate,
		intCompanyId)
		values
		('$no', 
		'$year', 
		'$toStyleId',
		'$bulkToBuyerPoNo',
		'$userId',
		now(),
		'$companyId');";
	$db->executeQuery($sql);
	
	$sql="insert into commonstock_bulkdetails 
		(intTransferNo, 
		intTransferYear, 
		intMatDetailId, 
		strColor, 
		strSize,
		strUnit, 
		dblQty)
		values
		('$no', 
		'$year', 
		'$matDetailId', 
		'$color', 
		'$size',
		'$units',
		'$qty');";
	$db->executeQuery($sql);	
}
elseif($RequestType=="SaveBulkValidation")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$no 			= $_GET["no"];
$year			= $_GET["year"];
$headerCount 	= 1;
$detailCount 	= $_GET["detailCount"];
$ResponseXML = "<ValidateBulkDetails>\n";

$sql_header="select count(*)as headerCount from commonstock_bulkheader where intTransferNo='$no' and intTransferYear='$year'";
$result_header=$db->RunQuery($sql_header);
while($row_header=mysql_fetch_array($result_header))
{
	if($headerCount==$row_header["headerCount"])
		$ResponseXML .= "<Header><![CDATA[TRUE]]></Header>\n";
	else
		$ResponseXML .= "<Header><![CDATA[FALSE]]></Header>\n";
}

$sql_details="select count(*)as detailsCount from commonstock_bulkdetails where intTransferNo='$no' and intTransferYear='$year'";
$result_details=$db->RunQuery($sql_details);
while($row_details=mysql_fetch_array($result_details))
{
	if($detailCount==$row_details["detailsCount"])
		$ResponseXML .= "<Details><![CDATA[TRUE]]></Details>\n";
	else
		$ResponseXML .= "<Details><![CDATA[FALSE]]></Details>\n";
}
$ResponseXML .= "<No><![CDATA[".$year.'/'.$no."]]></No>\n";

$ResponseXML .= "</ValidateBulkDetails>\n";
echo $ResponseXML;
}

elseif($RequestType=="SaveBulkAlloHeader")
{
$no				 = $_GET["no"];
$year			 = $_GET["year"];
$toStyleId		 = $_GET["toStyleId"];
$bulkToBuyerPoNo = $_GET["bulkToBuyerPoNo"];
$mainStoreID     = $_GET["mainStoreID"];
$manufactCompany = $_GET["manufactCompany"];
$merchantRemarks = $_GET["merchantRemarks"];
$ComID           =  GetCompanyDetails($mainStoreID);   
//echo $ComID;  
	$sql="insert into commonstock_bulkheader (intTransferNo,intTransferYear,intToStyleId,strToBuyerPoNo,intUserId,dtmDate,
		intMainStoresID,intCompanyId,intManufactCompanyId, merchantRemarks)
		values('$no','$year','$toStyleId','$bulkToBuyerPoNo','$userId',now(),'$mainStoreID','$ComID', '$manufactCompany','$merchantRemarks')";
	//echo $sql;
	$res = $db->RunQuery($sql);
	
	if($res == '1')
	{
		echo $res;
	}
	else
	{
		echo '0';
	}
}
elseif($RequestType=="SaveBulkAlloDetail")
{
$no				 = $_GET["no"];
$year			 = $_GET["year"];
$matDetailId	 = $_GET["matDetailId"];
$color			 = $_GET["color"];
$size			 = $_GET["size"];
$units			 = $_GET["units"];
$qty			 = $_GET["qty"];
$BpoNo			 = $_GET["BpoNo"];
$BpoYear 		 = $_GET["BpoYear"];
$BgrnNo 		 = $_GET["BgrnNo"];
$BgrnYear 		 = $_GET["BgrnYear"];
	
	$sql = "insert into commonstock_bulkdetails 
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
			intBulkGRNYear
			)
			values
			('$no', 
			'$year', 
			'$matDetailId', 
			'$color', 
			'$size', 
			'$units', 
			'$qty', 
			'$BpoNo', 
			'$BpoYear', 
			'$BgrnNo', 
			'$BgrnYear'
			)";
	$res = $db->RunQuery($sql);
	
	if($res == '1')
	{
		echo $res;
	}
	else
	{
		echo '0';
	}
}
elseif($RequestType=="GetLiabilityNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML ="<GetNo>\n";
$mainStoreID = $_GET["mainStoreID"];
$comID       = GetCompanyDetails($mainStoreID);
$sql="select dblLiabilityAlloNo from syscontrol where intCompanyID='$comID'";

$ComAv = $db->CheckRecordAvailability($sql);
if($ComAv == '1')
{
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$no = $row["dblLiabilityAlloNo"];
			$year = date('Y');
			$ResponseXML .= "<No><![CDATA[" . $no . "]]></No>\n";	
			$ResponseXML .= "<Year><![CDATA[" . $year. "]]></Year>\n";
		}
		
		$sql_update ="update syscontrol set dblLiabilityAlloNo = dblLiabilityAlloNo +1 where intCompanyID = '$comID'";
		$db->executeQuery($sql_update);
}	
else
{
	$no = 'NA';
	//$year = 'NA';
	$ResponseXML .= "<No><![CDATA[" . $no . "]]></No>\n";	
			//$ResponseXML .= "<Year><![CDATA[" . $year. "]]></Year>\n";
}
$ResponseXML .="</GetNo>";
echo $ResponseXML;
}

elseif($RequestType=="SaveLiabilityHeader")
{
	$no				= $_GET["no"];
	$year			= $_GET["year"];

	$toStyleId		= $_GET["toStyleId"];
	$toBuyerPoNo	= $_GET["toBuyerPoNo"];
	$mainStoreID	= $_GET["mainStoreID"];
	$manufactCom	= $_GET["manufactCom"];
	$merchantRemarks = $_GET["merchantRemarks"];
	$comID  		= GetCompanyDetails($mainStoreID);
	
	$sqlH="insert into commonstock_liabilityheader 
		(intTransferNo,	intTransferYear,intToStyleId,strToBuyerPoNo,intUserId,dtmDate,intMainStoresId,intCompanyId, intManufactCompanyId, merchantRemarks)
		values ('$no','$year','$toStyleId','$toBuyerPoNo','$userId',now(),$mainStoreID,'$comID','$manufactCom', '$merchantRemarks');";
	$resH = $db->RunQuery($sqlH);
	
	echo $resH;
}

elseif($RequestType=="SaveLiabilityDetails")
{
$no				= $_GET["no"];
$year			= $_GET["year"];
$fromStyleId	= $_GET["fromStyleId"];
$matDetailId	= $_GET["matDetailId"];
$color			= $_GET["color"];
$size			= $_GET["size"];
$units			= $_GET["units"];
$qty			= $_GET["qty"];
$buyerPoNo		= $_GET["buyerPoNo"];
$grnNo			= $_GET["grnNo"];
$grnYear		= $_GET["grnYear"];
$grnType		= $_GET["grnType"];
	
	
	$sql="insert into commonstock_liabilitydetails 
		(intTransferNo, 
		intTransferYear, 
		intFromStyleId,
		strBuyerPoNo, 
		intMatDetailId, 
		strColor, 
		strSize,
		strUnit, 
		dblQty,
		intGrnNo,
		intGrnYear,
		strGRNType)
		values
		('$no', 
		'$year', 
		'$fromStyleId',
		'$buyerPoNo', 
		'$matDetailId', 
		'$color', 
		'$size',
		'$units',
		'$qty',
		'$grnNo',
		'$grnYear',
		'$grnType')";
	$resD = $db->RunQuery($sql);	
	$response ='';
	
	if($resD == '1')
	{
		$response =1;
	}
	else
	{
		$response =0;
	}	
	echo $response;
}
function GetCompanyDetails($MainStoreID)
{
	global $db;
	$SQL = "select intCompanyId 
			from mainstores
			where  strMainID='$MainStoreID'";
			//where intStatus=1 and intAutomateCompany=0 and strMainID='$MainStoreID'
		$result=$db->RunQuery($SQL);	
		$row=mysql_fetch_array($result);
		
		return $row["intCompanyId"];	
}

function GetStyle($styleId)
{
	global $db;
	$sql="select strStyle from orders where intStyleId='$styleId'";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleName = $row["strStyle"];		
	}
	return $styleName;	
}

function getUserName()
{
	global $db;
	$userID = $_SESSION["UserID"];
	
	$sql = "select Name from useraccounts where intUserID='$userID'"; 
	  $result= $db->RunQuery($sql);
	  $row = mysql_fetch_array($result);
	  $Uname = $row["Name"];
	  
	  return $Uname;
}

function getLeftOverAlloQty($no,$year,$comID)
{
	global $db;
	$SQL = " SELECT sum(LCD.dblQty) as qty
				FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
				LCD.intTransferNo = LCH.intTransferNo AND 
				LCD.intTransferYear = LCH.intTransferYear
				WHERE LCH.intTransferNo='$no' AND LCH.intTransferYear = '$year' and LCH.intCompanyId = '$comID'";
				
				 $result= $db->RunQuery($SQL);
	  $row = mysql_fetch_array($result);
	  
	  return $row["qty"];
}

function getSumBulkAlloQty($no,$year,$comID)
{
	global $db;
	$sql = "SELECT sum(BCD.dblQty) as Bulkqty
					FROM commonstock_bulkdetails BCD INNER JOIN commonstock_bulkheader BCH ON
					BCD.intTransferNo = BCH.intTransferNo AND 
					BCD.intTransferYear = BCH.intTransferYear
					WHERE BCH.intTransferNo = '$no'  and 
					BCD.intTransferYear = '$year' and BCH.intCompanyId='$comID'";
					
			$result= $db->RunQuery($sql);
					
	  $row = mysql_fetch_array($result);
	  
	  return $row["Bulkqty"];
}
?>