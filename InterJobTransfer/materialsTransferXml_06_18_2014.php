<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$CompanyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="LoadMerchandiser")
{
	$styleId =$_GET["styleId"];
	
	$ResponseXML .="<LoadMerchandiser>\n";
	
	$SQL ="select Name from orders ".
		  " inner join ".
		  " useraccounts on useraccounts.intUserID=orders.intUserID ".
		  "	where intStyleID='$styleId'";
		  
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Name><![CDATA[".$row["Name"]."]]></Name>\n";
		}
	$ResponseXML .="</LoadMerchandiser>";
	echo $ResponseXML;
}
elseif($RequestType=="GetToBuyerPoNo")
{
$styleId = $_GET["styleId"];

$ResponseXML = "<GetToBuyerPoNo>\n";
	
	$SQL ="select distinct strBuyerPONO from materialratio where intStyleID='$styleId' order by strBuyerPONO;";		
	$result=$db->RunQuery($SQL);	
	while ($row=mysql_fetch_array($result))
	{
		$BpoName = $row["strBuyerPONO"];
		if($row["strBuyerPONO"] != '#Main Ratio#')
			$BpoName = getBuyerPOName($styleId,$row["strBuyerPONO"]);
			
		$ResponseXML .= "<option value=\"".$row["strBuyerPONO"]."\">".$BpoName."</option>";
	}
$ResponseXML .= "</GetToBuyerPoNo>";
echo $ResponseXML;
}
elseif($RequestType=="LaodFromStyle")
{
	$fromStyleId =$_GET["fromStyleId"];
	
	$ResponseXML .="<LaodFromStyle>\n";
	
	$SQL ="";
		  
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<StyleName><![CDATA[".$row["Name"]."]]></StyleName>\n";
			$ResponseXML .="<SrNo><![CDATA[".$row["Name"]."]]></SrNo>\n";
		}
	$ResponseXML .="</LaodFromStyle>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadJobNo")
{		
/*	$NextID = "InterJob".$CompanyId;
    $intMaxNo=0;
	$ResponseXML .="<LoadJobNo>\n";
	
		$SqlRange="select strValue AS companyRange from settings where strKey ='$CompanyId'";
		
		$resultRange =$db->RunQuery($SqlRange);
		
			while($row = mysql_fetch_array($resultRange))
				{
					$companyRange=explode("-",$row["companyRange"]);				
				}
		
		$sql="SELECT strValue AS No FROM settings where strKey='$NextID';";
		
		$result=$db->RunQuery($sql);
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$maxNo=$row["No"];
				}
				$intMaxNo=(int)$maxNo;
		}
		else 
		{		
			$intMaxNo=(int)$companyRange[0];
			$SQLIN ="INSERT INTO settings (strKey,strValue) VALUES ('$NextID',$intMaxNo)";
			
			$db->executeQuery($SQLIN);
		}		
		if($intMaxNo>=(int)$companyRange[0] && $intMaxNo<(int)$companyRange[1])
		{
			$JobYear = date('Y');
			$ResponseXML .= "<JobNo><![CDATA[".$intMaxNo."]]></JobNo>\n";
			$ResponseXML .= "<JobYear><![CDATA[".$JobYear."]]></JobYear>\n";
			$intGatePassNo=$intMaxNo+1;
			$sqlUpdate="UPDATE settings SET strValue='$intGatePassNo' WHERE strKey='$NextID';";
			$db->executeQuery($sqlUpdate);
		}*/
		
	//
	$ResponseXML ="<LoadJobNo>\n";
	$No=0;
	$Sql="select intCompanyID,dblInterJobNO from syscontrol where intCompanyID='$CompanyId'";
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);
	
	if ($rowcount > 0)
	{	
			while($row = mysql_fetch_array($result))
			{				
				$No=$row["dblInterJobNO"];
				$NextNo=$No+1;
				$ReturnYear = date('Y');
				$sqlUpdate="UPDATE syscontrol SET dblInterJobNO='$NextNo' WHERE intCompanyID='$CompanyId';";
				$db->executeQuery($sqlUpdate);			
				$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";		
				$ResponseXML .= "<JobNo><![CDATA[".$No."]]></JobNo>\n";
				$ResponseXML .= "<JobYear><![CDATA[".$ReturnYear."]]></JobYear>\n";
			}
	}
	else
	{
		$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
	}	
	//
	$ResponseXML .="</LoadJobNo>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveHeader")
{
	$JobNo =$_GET["JobNo"];
	$JobYear =$_GET["JobYear"];
	$fromStyleNo =$_GET["fromStyleNo"];	
	$toStyleNo =$_GET["toStyleNo"];
	$remarks =$_GET["remarks"];
	$StoresId =$_GET["StoresId"];
	$toBuyerPoNo =$_GET["toBuyerPoNo"];
	
	$DelSqlHeader="DELETE FROM itemtransfer WHERE intTransferId='$JobNo' AND intTransferYear='$JobYear'	";	
	$db->executeQuery($DelSqlHeader);
	
	$sqldeldetails="delete from itemtransferdetails ".
	"where ".
	"intTransferId = '$JobNo' and ".
	"intTransferYear = '$JobYear';";
	$db->executeQuery($sqldeldetails);
	
	$SQL= "insert into itemtransfer ".
		"(intTransferId, ".
		"intTransferYear, ".
		"intStyleIdFrom, ".
		"intStyleIdTo, ".
		"strToBuyerPoNo, ".
		"intStatus, ".
		"strRemarks, ".
		"intUserId, ".
		"dtmTransferDate, ".
		"intFactoryCode, ".
		"intMainStoreID) ".
		"values ".
		"('$JobNo', ".
		"'$JobYear', ".
		"'$fromStyleNo', ".
		"'$toStyleNo', ".
		"'$toBuyerPoNo', ".
		"'0', ".
		"'$remarks', ".
		"'$UserID', ".
		"now(), ".
		"'$CompanyId', ".
		"$StoresId);";
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveDetails")
{
$JobNo 			= $_GET["JobNo"];
$JobYear 		= $_GET["JobYear"];	
$BuyerPoNo 		= $_GET["BuyerPoNo"];
$itemDetailID 	= $_GET["itemDetailID"];	
$color 			= $_GET["color"];
$size 			= $_GET["size"];
$units 			= $_GET["units"];
$Qty 			= $_GET["Qty"];	
$unitPrise 		= $_GET["unitPrise"];
$grnNo 			= $_GET["grnNo"];
$arrayGrnNo 	= explode('/',$grnNo);
$grnTypeId		= $_GET["grnTypeId"];
	

	
	$SQL="insert into itemtransferdetails (intTransferId,intTransferYear,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblUnitPrice,dblQty,dblBalance,intConfirmNo,intGrnNo,intGrnYear,strGRNType) values ('$JobNo','$JobYear','$BuyerPoNo','$itemDetailID','$color','$size','$units','$unitPrise','$Qty','$Qty','0',$arrayGrnNo[1],$arrayGrnNo[0],'$grnTypeId');";		
	$db->executeQuery($SQL);
}
else if ($RequestType=="ResponseValidate")
{
	$JobNo=$_GET["JobNo"];
	$JobYear =$_GET["JobYear"];
	$validateCount =$_GET["validateCount"];		
	
	$ResponseXML .="<ResponseValidate>\n";
	
	$SQLHeder="SELECT COUNT(intTransferId) AS headerRecCount FROM itemtransfer where intTransferId=$JobNo AND intTransferYear=$JobYear";
	
	$resultHeader=$db->RunQuery($SQLHeder);
	
			while($row = mysql_fetch_array($resultHeader))
			{		
				$recCountHeader=$row["headerRecCount"];
			
				if($recCountHeader>0)
				{
					$ResponseXML .= "<recCountInterJobHeader><![CDATA[TRUE]]></recCountInterJobHeader>\n";
				}
				else
				{	
					$ResponseXML .= "<recCountInterJobHeader><![CDATA[FALSE]]></recCountInterJobHeader>\n";
				}
			}	
			
	$SQLDetail="SELECT COUNT(intTransferId) AS DetailsRecCount FROM itemtransferdetails where intTransferId=$JobNo AND intTransferYear=$JobYear";
	
	$resultDetail=$db->RunQuery($SQLDetail);
		
			while($row =mysql_fetch_array($resultDetail))
			{
				$recCountDetails=$row["DetailsRecCount"];
				
					if($recCountDetails==$validateCount)
					{
						$ResponseXML .= "<recCountInterJobDetails><![CDATA[TRUE]]></recCountInterJobDetails>\n";
					}
					else
					{
						$ResponseXML .= "<recCountInterJobDetails><![CDATA[FALSE]]></recCountInterJobDetails>\n";
					}
			}		
	
	$ResponseXML .="</ResponseValidate>";
	echo $ResponseXML;
}
else if ($RequestType=="DeleteRow")
{
	$JobInNo 		= $_GET["JobInNo"];
	$JobInNoArray	= explode('/',$JobInNo);	
	$buyerPoNo 		= $_GET["buyerPoNo"];
	$color 			= $_GET["color"];
	$size 			= $_GET["size"];
	$matDetailId 	= $_GET["matDetailId"];
	
  	$sqlDelRow="delete from  itemtransferdetails  ".
					"where intTransferId = '$JobInNoArray[1]' and  ".
					"intTransferYear = '$JobInNoArray[0]' and ".
					"strBuyerPoNo = '$buyerPoNo' and ".
					"intMatDetailId = '$matDetailId' and ".
					"strColor = '$color' and ".
					"strSize = '$size';";
	
	$db->executeQuery($sqlDelRow);
	
	$SQLFromBin="delete from stocktransactions ".
			"where intDocumentNo = '$JobInNoArray[1]' and intDocumentYear = '$JobInNoArray[0]' ".
			"and strBuyerPoNo='$buyerPoNo' ".
			"and intMatDetailId='$matDetailId' and strColor='$color' ".
			"and strSize='$size' and strType='IJTOUT'";
		
	$db->executeQuery($SQLFromBin);
	
	$SQLToBin="delete from stocktransactions ".
			"where intDocumentNo = '$JobInNoArray[1]' and intDocumentYear = '$JobInNoArray[0]' ".
			"and strBuyerPoNo='$buyerPoNo' ".
			"and intMatDetailId='$matDetailId' and strColor='$color' ".
			"and strSize='$size' and strType='IJTIN'";
		
	$db->executeQuery($SQLToBin);
}
else if ($RequestType=="Approved")
{
	$JobInNo =$_GET["No"];
	$JobInNoArray=explode('/',$JobInNo);	
	
  	$sqlApproved="update itemtransfer ".
				"set ".
				"intStatus = '1', ".
				"intApprovedBy = '$UserID', ".
				"dtmApprovedDate =now() ".
				"where ".
				"intTransferId = '$JobInNoArray[1]' and ".
				"intTransferYear = '$JobInNoArray[0]';";

	$result=0;
			$result = $db->RunQuery($sqlApproved);
	echo $result;
}
else if ($RequestType=="Authorise")
{
	$JobInNo =$_GET["No"];
	$JobInNoArray=explode('/',$JobInNo);	
	
  	$sqlApproved="update itemtransfer ".
				"set ".
				"intStatus = '2', ".
				"intAuthorisedby = '$UserID', ".
				"dtmAuthorisedDate =now() ".
				"where ".
				"intTransferId = '$JobInNoArray[1]' and ".
				"intTransferYear = '$JobInNoArray[0]';";

	$result=0;
			$result = $db->RunQuery($sqlApproved);
	echo $result;
}
else if($RequestType=="LoadPopUpJobNo")
{
$state	= $_GET["state"];
$year	= $_GET["year"];

$ResponseXML = "<LoadPopUpJobNo>";
	/*$SQL="SELECT DISTINCT IT.intTransferId ".
		  "FROM itemtransfer AS IT ".
		  "INNER JOIN  itemtransferdetails AS ITD ".
		  "ON IT.intTransferId=ITD.intTransferId AND IT.intTransferYear=ITD.intTransferYear  ".
		  "INNER JOIN specification AS SP ON IT.intStyleIdFrom = SP.intStyleId ".
		  "WHERE IT.intStatus='$state' AND IT.intTransferYear='$year' ";*/
		  
		$SQL = "SELECT DISTINCT
IT.intTransferId,
mainstores.intCompanyId
FROM
itemtransfer AS IT
INNER JOIN itemtransferdetails AS ITD ON IT.intTransferId = ITD.intTransferId AND IT.intTransferYear = ITD.intTransferYear
INNER JOIN specification AS SP ON IT.intStyleIdFrom = SP.intStyleId
INNER JOIN mainstores ON IT.intMainStoreID = mainstores.strMainID
WHERE IT.intStatus='$state' AND IT.intTransferYear='$year'";    
		  
	$result=$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\""."0"."\">"."Select One"."</option>";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"".$row["intTransferId"]."\">".$row["intTransferId"]."</option>";
	}
$ResponseXML .= "</LoadPopUpJobNo>";
echo $ResponseXML;
}
else if ($RequestType=="LoadHeaderDetails")
{
	$No =$_GET["No"];
	$Year=$_GET["Year"];
	
	$ResponseXML .="<LoadHeaderDetails>\n";
	
	$SQL="SELECT concat(IT.intTransferYear,'/',intTransferId) AS JObNO, ".
		"IT.intStyleIdFrom, ".
		"IT.intStyleIdTo, ".
		"IT.intStatus, ".
		"IT.strRemarks, ".
		"IT.intMainStoreID, ".
		"SPF.intSRNO AS fromSr, ".
		"SPT.intSRNO AS toSr, ".
		"UA.Name, ".
		"IT.strToBuyerPoNo ".
		"FROM ".
		"itemtransfer AS IT ".
		"Inner Join specification AS SPF ON IT.intStyleIdFrom = SPF.intStyleId ".
		"Inner Join specification AS SPT ON IT.intStyleIdTo = SPT.intStyleId ".
		"Inner Join orders AS O ON IT.intStyleIdFrom = O.intStyleId ".
		"Inner Join useraccounts AS UA ON O.intUserID = UA.intUserID ".
		"WHERE ".
		"IT.intTransferId = '$No' AND ".
		"IT.intTransferYear = '$Year'";
		
//echo $SQL;
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{
			$StyleIdFrom = $row["intStyleIdFrom"];
			$StyleIdTo = $row["intStyleIdTo"];
			$StyleFromName = StyleName($StyleIdFrom);
			$StyleToName   = StyleName($StyleIdTo);
			$OrderFromName = OrderName($StyleIdFrom);
			$OrderToName   = OrderName($StyleIdTo);
			$BuuyerPOName = $row["intStyleIdTo"];
			
			 	if($row["strToBuyerPoNo"] != '#Main Ratio#')
					$BuuyerPOName = getBuyerPOName($StyleIdTo,$row["strToBuyerPoNo"]);
							
			$ResponseXML .= "<JObNO><![CDATA[" . $row["JObNO"] . "]]></JObNO>\n";
			$ResponseXML .= "<FromStyle><![CDATA[" . $row["intStyleIdFrom"] . "]]></FromStyle>\n";			
			$ResponseXML .= "<ToStyle><![CDATA[" . $row["intStyleIdTo"] . "]]></ToStyle>\n";
			$ResponseXML .= "<FromStyleName><![CDATA[" . $StyleFromName . "]]></FromStyleName>\n";			
			$ResponseXML .= "<ToStyleName><![CDATA[" . $StyleToName . "]]></ToStyleName>\n";
			$ResponseXML .= "<FromSr><![CDATA[" . $row["fromSr"] . "]]></FromSr>\n";
			$ResponseXML .= "<ToSr><![CDATA[" . $row["toSr"] . "]]></ToSr>\n";			
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";	
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"] . "]]></Remarks>\n";			
				$Date =substr($row["dtmTransferDate"],0,10);
				$NOArray=explode('-',$Date);
				$formatedDate=$NOArray[2]."/".$NOArray[1]."/".$NOArray[0];
			$ResponseXML .= "<formatedDate><![CDATA[" . $formatedDate . "]]></formatedDate>\n";
			$ResponseXML .= "<MainStoreID><![CDATA[" . $row["intMainStoreID"] . "]]></MainStoreID>\n";
			$ResponseXML .= "<ToBuyerPoNo><![CDATA[" . $row["strToBuyerPoNo"] . "]]></ToBuyerPoNo>\n";	
			$ResponseXML .= "<ToBuyerPoName><![CDATA[" . $BuuyerPOName . "]]></ToBuyerPoName>\n";
			
			$ResponseXML .= "<OrderFromName><![CDATA[" . $OrderFromName . "]]></OrderFromName>\n";
			$ResponseXML .= "<OrderToName><![CDATA[" . $OrderToName . "]]></OrderToName>\n";	
		}
	
	$ResponseXML .="</LoadHeaderDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadDetails")
{
	$No =$_GET["No"];
	$Year =$_GET["Year"];

	$ResponseXML .="<LoadDetails>\n";
	
	$SQL="SELECT ".
		"ITD.strBuyerPoNo, ".
		"ITD.intMatDetailId, ".
		"ITD.strColor, ".
		"ITD.strSize, ".
		"ITD.strUnit, ".
		"ITD.dblQty, ".
		"MIL.strItemDescription, ".
		"IT.intStyleIdFrom, ".
		"ITD.dblUnitPrice, IT.intMainStoreID, ".
		"ITD.intGrnYear, ".
		"ITD.intGrnNo, ".
		"ITD.strGRNType ".
		"FROM ".
		"itemtransferdetails AS ITD ".
		"Inner Join matitemlist AS MIL ON ITD.intMatDetailId = MIL.intItemSerial ".
		"Inner Join itemtransfer AS IT ON IT.intTransferId = ITD.intTransferId AND IT.intTransferYear = ITD.intTransferYear ".
		"WHERE ".
		"ITD.intTransferId =  '$No' AND ".
		"ITD.intTransferYear =  '$Year'";
	
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$styleid		= $row["intStyleIdFrom"];
			$buyerPONO		= $row["strBuyerPoNo"];
			$matDetailId	= $row["intMatDetailId"];
			$color			= $row["strColor"];
			$size			= $row["strSize"];
			$buyerPOName 	= $row["strBuyerPoNo"];
			$MainStoreID 	= $row["intMainStoreID"];
			$grnYear 		= $row["intGrnYear"];
			$grnNo 			= $row["intGrnNo"];
			$grnTypeId 		= $row["strGRNType"];
			
			$StockQty=getStockQty($styleid,$buyerPONO,$matDetailId,$color,$size,$MainStoreID,$grnYear,$grnNo,$grnTypeId);		
			
			if($buyerPOName != '#Main Ratio#')
				$buyerPOName = getBuyerPOName($styleid,$buyerPONO);
				
				$ResponseXML .= "<Styleid><![CDATA[" . $styleid . "]]></Styleid>\n";
				$ResponseXML .= "<BuyerPONO><![CDATA[" . $buyerPONO . "]]></BuyerPONO>\n";
				$ResponseXML .= "<BuyerPOName><![CDATA[" . $buyerPOName . "]]></BuyerPOName>\n";
				$ResponseXML .= "<MatDetailId><![CDATA[" . $matDetailId . "]]></MatDetailId>\n";
				$ResponseXML .= "<Color><![CDATA[" . $color . "]]></Color>\n";
				$ResponseXML .= "<Size><![CDATA[" . $size . "]]></Size>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";				
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
				$ResponseXML .= "<QTY><![CDATA[" . $row["dblQty"] . "]]></QTY>\n";			
				$ResponseXML .= "<StockBal><![CDATA[" . $StockQty . "]]></StockBal>\n";
				$ResponseXML .= "<UnitPrice><![CDATA[" . $row["dblUnitPrice"] . "]]></UnitPrice>\n";
				$ResponseXML .= "<GrnNo><![CDATA[" . $row["intGrnYear"].'/'.$row["intGrnNo"] . "]]></GrnNo>\n";
				$ResponseXML .= "<GRNTypeId><![CDATA[" . $grnTypeId . "]]></GRNTypeId>\n";
				if($grnTypeId=='B')
					$grnType = 'Bulk';
				else
					$grnType = 'Style';
				$ResponseXML .= "<GRNType><![CDATA[" . $grnType . "]]></GRNType>\n";		
		}
	$ResponseXML .="</LoadDetails>";
	echo $ResponseXML;
}
else if($RequestType=="LoadMainStoresToPopUp")
{
	$ResponseXML .="<LoadMainStoresToPopUp>\n";
	
	$SQL ="select strMainID,strName from mainstores where intStatus=1";
		  
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Name><![CDATA[".$row["strName"]."]]></Name>\n";
			$ResponseXML .="<ID><![CDATA[".$row["strMainID"]."]]></ID>\n";
		}
	$ResponseXML .="</LoadMainStoresToPopUp>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpSubStores")
{
	$MainStoresId	= $_GET["MainStoresId"];
	$ResponseXML .="<LoadPopUpSubStores>\n";
	
	$SQL ="select * from substores where strMainID='$MainStoresId' AND intStatus=1";
		  
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<SubStoresName><![CDATA[".$row["strSubStoresName"]."]]></SubStoresName>\n";
			$ResponseXML .="<SubStoresID><![CDATA[".$row["strSubID"]."]]></SubStoresID>\n";
		}
	$ResponseXML .="</LoadPopUpSubStores>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpLocations")
{
	$MainStoresId	= $_GET["MainStoresId"];
	$SubStoresId	= $_GET["SubStoresId"];
	
	$ResponseXML .="<LoadPopUpLocations>\n";
	
	$SQL ="select * from storeslocations where strMainID='$MainStoresId' and strSubID='$SubStoresId' and intStatus=1";
		  
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<LocationName><![CDATA[".$row["strLocName"]."]]></LocationName>\n";
			$ResponseXML .="<LocationID><![CDATA[".$row["strLocID"]."]]></LocationID>\n";
		}
	$ResponseXML .="</LoadPopUpLocations>";
	echo $ResponseXML;
}
else if($RequestType=="ValidateBinBinDetails")
{
	$No	= $_GET["No"];
	$JobInNoArray=explode('/',$No);	
	
	$ResponseXML .="<ValidateBinBinDetails>\n";
	
	$SQL ="select intStatus from itemtransfer where intTransferId='$JobInNoArray[1]' AND intTransferYear='$JobInNoArray[0]'";
  
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Status><![CDATA[".$row["intStatus"]."]]></Status>\n";			
		}
	$ResponseXML .="</ValidateBinBinDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="updateHeader")
{
	$JobNo =$_GET["JobNo"];
	$JobYear =$_GET["JobYear"];
	$remarks =$_GET["remarks"];
		
  	$sqlApproved="update itemtransfer ".
				"set ".
				"intStatus = '3', ".
				"intConfirmedBy = '$UserID', ".
				"dtmConfirmedDate =now(), ".
				"strRemarks ='$remarks' ".
				"where ".
				"intTransferId = '$JobNo' and ".
				"intTransferYear = '$JobYear';";

	$db->executeQuery($sqlApproved);
}
else if ($RequestType=="ConfirmDetails")
{
	$JobNo 			= $_GET["JobNo"];
	$JobYear 		= $_GET["JobYear"];	
	$StyleId 		= $_GET["StyleId"];
	$BuyerPoNo 		= $_GET["BuyerPoNo"];
	$itemDetailID 	= $_GET["itemDetailID"];
	$color 			= $_GET["color"];
	$size 			= $_GET["size"];
	$Qty 			= $_GET["Qty"];
	$units 			= $_GET["units"];	
	$unitPrise 		= $_GET["unitPrise"];
	$grnNo 			= $_GET["grnNo"];
	$arrayGrnNo 	= explode('/',$grnNo);
	$grnTypeId		= $_GET["grnTypeId"];
	
	$SQLDel="DELETE FROM itemtransferdetails WHERE intTransferId='$JobNo' AND intTransferYear='$JobYear' AND strBuyerPoNo='$BuyerPoNo' AND intMatDetailId='$itemDetailID' AND strColor='$color' AND strSize='$size' AND intGrnNo='$arrayGrnNo[1]' AND intGrnYear='$arrayGrnNo[0]' and strGRNType='$grnTypeId' ";	
	$db->executeQuery($SQLDel);

	$SQL="INSERT INTO itemtransferdetails (intTransferId,intTransferYear,strBuyerPoNo,intMatDetailId,strColor,strSize,strUnit,dblUnitPrice,dblQty,dblBalance,intConfirmNo,intGrnNo,intGrnYear,strGRNType) ".
"VALUES ('$JobNo','$JobYear','$BuyerPoNo','$itemDetailID','$color','$size','$units','$unitPrise','$Qty','$Qty','0','$arrayGrnNo[1]','$arrayGrnNo[0]','$grnTypeId')";		
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveBinDetails")
{
$mainStores 		= $_GET["mainStores"];
$subStores			= $_GET["subStores"];	
$location 			= $_GET["location"];
$binId 				= $_GET["binId"];
$fromStyleNo 		= $_GET["fromStyleNo"];
$toStyleNo 			= $_GET["toStyleNo"];
$JobNo 				= $_GET["JobNo"];
$Year 				= $_GET["JobYear"];
$BuyerPoNo 			= $_GET["BuyerPoNo"];
$itemDetailID 		= $_GET["itemDetailID"];
$color 				= $_GET["color"];
$size 				= $_GET["size"];
$units 				= $_GET["units"];
$Qty 				= $_GET["Qty"];	
$fromQty 			= "-". $Qty;
$ToQty 				= $Qty;
$validateBinCount 	= $_GET["validateBinCount"];
$toBuyerPoNo		= $_GET["toBuyerPoNo"];	
$grnNo				= $_GET["grnNo"];	
$arrayGrnNo 		= explode('/',$grnNo);
$grnTypeId			= $_GET["grnTypeId"];

	
	$sqlFromStockdel="DELETE FROM stocktransactions WHERE intDocumentNo='$JobNo' AND intDocumentYear='$Year' ".
		"AND strBuyerPoNo='$BuyerPoNo' AND intMatDetailId='$itemDetailID' AND strColor='$color' AND strSize='$size' ".
		"AND strType='IJTOUT' and strMainStoresID='$mainStores' and strSubStores='$subStores' and strLocation='$location' and strBin='$binId' and intGrnNo='$arrayGrnNo[1]' and intGrnYear='$arrayGrnNo[0]' and strGRNType='$grnTypeId'";	
	$db->executeQuery($sqlFromStockdel);
	
	$sqlToStockdel="DELETE FROM stocktransactions WHERE intDocumentNo='$JobNo' AND intDocumentYear='$Year' ".
		"AND strBuyerPoNo='$BuyerPoNo' AND intMatDetailId='$itemDetailID' AND strColor='$color' AND strSize='$size' ".
		"AND strType='IJTIN' and strMainStoresID='$mainStores' and strSubStores='$subStores' and strLocation='$location' and strBin='$binId' and intGrnNo='$arrayGrnNo[1]' and intGrnYear='$arrayGrnNo[0]' and strGRNType='$grnTypeId'";	
	$db->executeQuery($sqlToStockdel);
			
	$fromSQL="INSERT INTO stocktransactions(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         " intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ".
		 " ($Year,'$mainStores','$subStores','$location','$binId','$fromStyleNo','$BuyerPoNo',$JobNo,$Year,$itemDetailID, ".
         " '$color','$size','IJTOUT','$units',$fromQty,now(),$UserID,'$arrayGrnNo[1]','$arrayGrnNo[0]','$grnTypeId') ";	
	$db->executeQuery($fromSQL);
	
		$toSQL="INSERT INTO stocktransactions(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         " intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ".
		 " ($Year,'$mainStores','$subStores','$location','$binId','$toStyleNo','$toBuyerPoNo',$JobNo,$Year,$itemDetailID, ".
         " '$color','$size','IJTIN','$units',$ToQty,now(),$UserID,'$arrayGrnNo[1]','$arrayGrnNo[0]','$grnTypeId') ";	
	$db->executeQuery($toSQL);
}
else if ($RequestType=="confirmValidate")
{
	$JobNo=$_GET["JobNo"];
	$JobYear =$_GET["JobYear"];
	$validateCount =$_GET["validateCount"];		
	$validateBinCount =$_GET["validateBinCount"];	
	
	$ResponseXML .="<confirmValidate>\n";
	
	$SQLHeder="SELECT COUNT(intTransferId) AS headerRecCount FROM itemtransfer where intTransferId=$JobNo AND intTransferYear=$JobYear";
	
	$resultHeader=$db->RunQuery($SQLHeder);
	
			while($row = mysql_fetch_array($resultHeader))
			{		
				$recCountHeader=$row["headerRecCount"];
			
				if($recCountHeader>0)
				{
					$ResponseXML .= "<recCountInterJobHeader><![CDATA[TRUE]]></recCountInterJobHeader>\n";
				}
				else
				{	
					$ResponseXML .= "<recCountInterJobHeader><![CDATA[FALSE]]></recCountInterJobHeader>\n";
				}
			}	
			
	$SQLDetail="SELECT COUNT(intTransferId) AS DetailsRecCount FROM itemtransferdetails where intTransferId=$JobNo AND intTransferYear=$JobYear";
	
	$resultDetail=$db->RunQuery($SQLDetail);
		
			while($row =mysql_fetch_array($resultDetail))
			{
				$recCountDetails=$row["DetailsRecCount"];
				
					if($recCountDetails==$validateCount)
					{
						$ResponseXML .= "<recCountInterJobDetails><![CDATA[TRUE]]></recCountInterJobDetails>\n";
					}
					else
					{
						$ResponseXML .= "<recCountInterJobDetails><![CDATA[FALSE]]></recCountInterJobDetails>\n";
					}
			}
		$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions where intDocumentNo=$JobNo AND intDocumentYear=$JobYear and strType='IJTIN'";	

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$recCountBin=$row["binDetails"];
		//$recCountBinDetails=$recCountBin/2;
		
			if($recCountBin==$validateBinCount)
			{
				$ResponseXML .= "<recCountInterJobBinDetails><![CDATA[TRUE]]></recCountInterJobBinDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountInterJobBinDetails><![CDATA[FALSE]]></recCountInterJobBinDetails>\n";
			}
	}	
	
	$ResponseXML .="</confirmValidate>";
	echo $ResponseXML;
}
else if ($RequestType=="Cancel")
{
	$NO=$_GET["No"];	
		$NoArray=explode('/',$NO);
			
	$SqlUpdate ="update itemtransfer  ".
				"set intCancelledBy =$UserID, ".
				"dtmCancelledDate = now(), ".
				"intStatus =10 ".	
				"where intTransferId ='$NoArray[1]' ".
				"AND intTransferYear ='$NoArray[0]'";
	$result=0;
	$result = $db->RunQuery($SqlUpdate);
			
	$sqlFrom ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin, ".
			"ST.intStyleId,ST.strBuyerPoNo,ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, ".
			"ST.strColor,ST.strSize,ST.strUnit,ST.dblQty,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ".
			"FROM stocktransactions AS ST ".
			"WHERE ST.intDocumentNo =$NoArray[1] AND ST.intDocumentYear =$NoArray[0] AND strType='IJTOUT';";
	
	$resultFrom=$db->RunQuery($sqlFrom);
	
		while($rowFrom=mysql_fetch_array($resultFrom))
		{
			$MainStores		= $rowFrom["strMainStoresID"];
			$SubStores		= $rowFrom["strSubStores"];
			$Location		= $rowFrom["strLocation"];
			$Bin			= $rowFrom["strBin"];
			$StyleNo		= $rowFrom["intStyleId"];
			$BuyerPoNo		= $rowFrom["strBuyerPoNo"];
			$DocumentNo		= $rowFrom["intDocumentNo"];
			$DocumentYear	= $rowFrom["intDocumentYear"];
			$MatDetailId	= $rowFrom["intMatDetailId"];
			$Color			= $rowFrom["strColor"];
			$Size			= $rowFrom["strSize"];
			$Unit			= $rowFrom["strUnit"];
			$grnNo			= $rowFrom["intGrnNo"];
			$grnYear		= $rowFrom["intGrnYear"];
			$FromQty 		= substr($rowFrom["dblQty"],1);
			$grnType		= $rowFrom["strGRNType"];	
		
			FromStockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$FromQty,$UserID,$grnNo,$grnYear,$grnType);
		}
			
	$sqlTo ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin, ".
	"ST.intStyleId,ST.strBuyerPoNo,ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, ".
	"ST.strColor,ST.strSize,ST.strUnit,ST.dblQty,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ".
	"FROM stocktransactions AS ST ".
	"WHERE ST.intDocumentNo =$NoArray[1] AND ST.intDocumentYear =$NoArray[0] AND strType='IJTIN';";

	$resultTo=$db->RunQuery($sqlTo);
	
		while($rowTo=mysql_fetch_array($resultTo))
		{
			$MainStores		= $rowTo["strMainStoresID"];
			$SubStores		= $rowTo["strSubStores"];
			$Location		= $rowTo["strLocation"];
			$Bin			= $rowTo["strBin"];
			$StyleNo		= $rowTo["intStyleId"];
			$BuyerPoNo		= $rowTo["strBuyerPoNo"];
			$DocumentNo		= $rowTo["intDocumentNo"];
			$DocumentYear	= $rowTo["intDocumentYear"];
			$MatDetailId	= $rowTo["intMatDetailId"];
			$Color			= $rowTo["strColor"];
			$Size			= $rowTo["strSize"];
			$Unit			= $rowTo["strUnit"];
			$grnNo			= $rowTo["intGrnNo"];
			$grnYear		= $rowTo["intGrnYear"];
			$ToQty			= $rowTo["dblQty"];
			$grnType		= $rowTo["strGRNType"];	
			
			ToStockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$ToQty,$UserID,$grnNo,$grnYear,$grnType);
		}	
	echo $result;
}

else if($RequestType=='getCommonBin')
{

	$ResponseXML .= "<MainstoreBinDetails>";
	$strMainStores		= $_GET["strMainStores"];
	
	 $SQL = " SELECT
				storeslocations.strLocID,
				storesbins.strBinID,
				substores.strSubID,
				mainstores.strName,
				mainstores.intCommonBin,
				mainstores.intAutomateCompany
				FROM
				mainstores
				Inner Join substores ON mainstores.strMainID = substores.strMainID
				Inner Join storesbins ON mainstores.strMainID = storesbins.strMainID AND substores.strSubID = storesbins.strSubID
				Inner Join storeslocations ON storesbins.strLocID = storeslocations.strLocID AND storeslocations.strMainID = mainstores.strMainID AND                storeslocations.strSubID = substores.strSubID where mainstores.strMainID='$strMainStores'  and mainstores.intStatus=1 ";
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<commonbin><![CDATA[" . trim($row["intCommonBin"])  . "]]></commonbin>\n";
		 $ResponseXML .= "<autoBin><![CDATA[" . trim($row["intAutomateCompany"])  . "]]></autoBin>\n";
		 $ResponseXML .= "<strLocName><![CDATA[" . trim($row["strLocID"])  . "]]></strLocName>\n";
		 $ResponseXML .= "<strBinName><![CDATA[" . trim($row["strBinID"])  . "]]></strBinName>\n";
		 $ResponseXML .= "<strSubStoresName><![CDATA[" . trim($row["strSubID"])  . "]]></strSubStoresName>\n";
	}
	
	$ResponseXML .= "</MainstoreBinDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadStyleNames")
{
	$scNo 		= $_GET["scNo"];
	
	$ResponseXML .="<LoadStyleName>\n";
	
	$SQL="SELECT distinct  O.strStyle
									FROM  orders O INNER JOIN  stocktransactions S ON O.intStyleId = S.intStyleId
									where O.intStyleId = '$scNo'
									GROUP BY O.intStyleId,O.strStyle 
									HAVING SUM(S.dblQty)>0
									order by O.strStyle";	
	 //echo $SQL;
	
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"] . "]]></strStyle>\n";						
		}
	
	$ResponseXML .="</LoadStyleName>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadStyleNamesTo")
{
	$scNoTo 		= $_GET["scNoTo"];
	
	$ResponseXML .="<LoadStyleNameto>\n";
	
	$SQL="SELECT distinct  O.strStyle
									FROM  orders O 
									where O.intStyleId = '$scNoTo'
									order by O.strStyle";	
	 //echo $SQL;
	
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<strStyleTo><![CDATA[" . $row["strStyle"] . "]]></strStyleTo>\n";						
		}
	
	$ResponseXML .="</LoadStyleNameto>";
	echo $ResponseXML;
}

function FromStockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$FromQty,$UserID,$grnNo,$grnYear,$grnType)
{
			global $db;
			
$sqlOutStock="INSERT INTO stocktransactions ".
         "(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         "intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ".
		 "($DocumentYear,'$MainStores','$SubStores','$Location','$Bin','$StyleNo','$BuyerPoNo',$DocumentNo,$DocumentYear,$MatDetailId, ".
         "'$Color','$Size','CIJTOUT','$Unit',$FromQty,now(),'$UserID',$grnNo,$grnYear,'$grnType')";
		
		$db->executeQuery($sqlOutStock);
}

function ToStockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$ToQty,$UserID,$grnNo,$grnYear,$grnType)
{
			global $db;
			
$sqlInStock="INSERT INTO stocktransactions ".
         "(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         "intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ".
		 "($DocumentYear,'$MainStores','$SubStores','$Location','$Bin','$StyleNo','$BuyerPoNo',$DocumentNo,$DocumentYear,$MatDetailId, ".
         "'$Color','$Size','CIJTIN','$Unit',-$ToQty,now(),'$UserID',$grnNo,$grnYear,'$grnType')";

		$db->executeQuery($sqlInStock);
}

function getStockQty($styleid,$buyerPONO,$matDetailId,$color,$size,$CompanyId,$grnYear,$grnNo,$grnType)
{
global $db;		
					  
			$SQLStock = "SELECT ST.intStyleId,ST.strBuyerPoNo,ST.intMatDetailId,ST.strColor, 
					  ST.strSize,Sum(ST.dblQty) AS StockQty 
					  FROM stocktransactions AS ST 
					  Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
					  WHERE ST.intStyleId =  '$styleid' AND ST.strBuyerPoNo = '$buyerPONO' AND 
					  ST.intMatDetailId =  '$matDetailId' AND ST.strColor =  '$color' AND 
					  ST.strSize =  '$size' AND MS.strMainID ='$CompanyId' 
					  and ST.intGrnYear='$grnYear' and ST.intGrnNo='$grnNo'
					  and ST.strGRNType='$grnType'
					  GROUP BY ST.intStyleId,ST.strBuyerPoNo,ST.intMatDetailId,ST.strColor,ST.strSize,ST.strGRNType;";
			
			$resultStock=$db->RunQuery($SQLStock);
			$rowcount = mysql_num_rows($resultStock);
			if ($rowcount > 0)
			{
				while($rowStock=mysql_fetch_array($resultStock))
				{
					return $rowStock["StockQty"];
				}
			}
			else 
			{
				return 0;
			}
}

function StyleName($styleID)
{
	global $db;
	$SQL = " SELECT strStyle FROM orders WHERE intStyleId='$styleID'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strStyle"];
}

function OrderName($styleID){
	global $db;
	$SQL = " SELECT strOrderNo FROM orders WHERE intStyleId='$styleID'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];
}
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}


?>
