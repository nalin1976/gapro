<?php
session_start();
include "../Connector.php";
$RequestType = $_GET["RequestType"];
$companyId	 = $_SESSION["FactoryID"];
$UserID		 = $_SESSION["UserID"];

if($RequestType=="LoadStores")
{
	$category	= $_GET["category"];
	
	$ResponseXML = "";
	$ResponseXML .="<LoadStores>";
	if($category=="I"){
	$sql="";
	$sql="select strMainID AS ID,strName AS Name from mainstores  where intCompanyId <> '$companyId'";
	}
	elseif($category=="E"){
	$sql="";
	$sql="select strSubContractorID AS ID ,strName AS Name from subcontractors  where intStatus =1";
	}
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value =\"".$row["ID"]."\">".$row["Name"]."</option>";
	}
	$ResponseXML .="</LoadStores>";
	echo $ResponseXML;
}
if($RequestType=="LoadGatePassNo")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$GatePassYear = date("Y");
	$ResponseXML .="<LoadGatePassNo>\n";
	$strSQL="update syscontrol set  dblBulkGatePassNo= dblBulkGatePassNo+1 WHERE syscontrol.intCompanyID='$companyId'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblBulkGatePassNo FROM syscontrol WHERE syscontrol.intCompanyID='$companyId'";
	$result=$db->RunQuery($strSQL);
	$GPNo = 'NA';
	while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<GatePassNo><![CDATA[". $row["dblBulkGatePassNo"] ."]]></GatePassNo>\n";
		$ResponseXML .= "<GatePassYear><![CDATA[".$GatePassYear."]]></GatePassYear>\n";
	 }
	$ResponseXML .="</LoadGatePassNo>";
	echo $ResponseXML;
}
if($RequestType=="SaveHeaderDetails")
{
	$gatePassNo 	= $_GET["gatePassNo"];
	$gatePassYear 	= $_GET["gatePassYear"];
	$Attention 		= $_GET["Attention"];	
	$Destination 	= $_GET["Destination"];
	$Remarks 		= $_GET["Remarks"];
	$MainStore 		= $_GET["MainStore"];
	$category		= $_GET["category"];
	$noOfPackages	= $_GET["noOfPackages"];
	
	$DelSql_Header = "DELETE FROM bulk_gatepassheader WHERE intGatePassNo='$gatePassNo' AND intGatePassYear='$gatePassYear'";
	$result_delHeader = $db->executeQuery($DelSql_Header);
	
	$SQLDel_detail = "DELETE FROM bulk_gatepassdetails WHERE intGatePassNo='$gatePassNo' AND intGatePassYear='$gatePassYear' ";	
	$result_deldetail = $db->executeQuery($SQLDel_detail);
	
	$SQLDel_temp = "DELETE FROM stocktransactions_bulk_temp WHERE intDocumentNo='$gatePassNo' AND intDocumentYear='$gatePassYear' and strType='GATEPASS'  ";	
	$result_deltemp = $db->executeQuery($SQLDel_temp);
	
	
	$sql_insert_header = "insert into bulk_gatepassheader 
							(intGatePassNo, 
							intGatePassYear, 
							dtmDate, 
							strAttention, 
							intDestination, 
							intUserId, 
							strRemarks, 
							intStatus, 
							intPrintStaus, 
							intCompanyId, 
							strCategory, 
							intNoOfPackages
							)
							values
							(
							 $gatePassNo,
							 $gatePassYear,
							 now(),
							'$Attention',
							 $Destination,
							 $UserID,
							'$Remarks',
							 0,
							 0,
							 $companyId,
							 '$category',
							 $noOfPackages
							);";
	$result_insert_header = $db->executeQuery($sql_insert_header);
	
	if($result_insert_header)
		echo "Header_Saved";
	else
		echo "Header_Error";
}
if ($RequestType=="SaveDetails")
{
	$gatePassNo 	= $_GET["gatePassNo"];
	$gatePassYear 	= $_GET["gatePassYear"];	
	$matDetailId	= $_GET["matDetailId"];
	$color 			= $_GET["color"];
	$size 			= $_GET["size"];
	$Qty 			= $_GET["Qty"];
	$itemunit 		= $_GET["itemunit"];
	$grnNo 			= $_GET["grnNo"];
	$grnYear 		= $_GET["grnYear"];
	$RTN 			= $_GET["RTN"];
	
	$sql_insert_detail = "insert into bulk_gatepassdetails 
							(intGatePassNo, 
							intGatePassYear, 
							intMatDetailId, 
							strColor, 
							strSize, 
							dblQty, 
							dblBalQty, 
							intRTN, 
							intGrnNo, 
							intGRNYear
							)
							values
							(
							$gatePassNo,
							$gatePassYear,
							$matDetailId,
						   '$color',
						   '$size',
						   '$Qty',
						   '$Qty',
						    $RTN,
							$grnNo,
							$grnYear
							)";
	 $result_insert_detail = $db->executeQuery($sql_insert_detail);
	
	 if($result_insert_detail)
		echo "Detail_Saved";
	else
		echo "Detail_Error";
}
if($RequestType=="getCommonBin")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$MainStores = $_GET["MainStores"];
	$ResponseXML = "<LoadCommBin>\n";
	
	$sql_combin = "select intCommonBin from mainstores where strMainID='$MainStores'  and intStatus=1;";
	$result_combin = $db->RunQuery($sql_combin);
	while($row = mysql_fetch_array($result_combin))
	{
		$ResponseXML .= "<CommBinDetails><![CDATA[".$row["intCommonBin"]."]]></CommBinDetails>\n";
	}
	$ResponseXML .="</LoadCommBin>";
	echo $ResponseXML;
}
if($RequestType=="SaveBinDetails")
{
	$mainStores 		= $_GET["mainStores"];
	$subStores 			= $_GET["subStores"];	
	$location 			= $_GET["location"];
	$binId 				= $_GET["binId"];
	$gatePassNo 		= $_GET["gatePassNo"];
	$gatePassYear 		= $_GET["gatePassYear"];
	$matDetailId 		= $_GET["matDetailId"];
	$color 				= $_GET["color"];
	$size 				= $_GET["size"];
	$itemunit 			= $_GET["itemunit"];
	$issueBinQty 		= $_GET["issueBinQty"];	
	$binQty 			= "-". $issueBinQty;
	$validateBinCount 	= $_GET["validateBinCount"];	
	$grnNo				= $_GET["grnNo"];
	$grnYear			= $_GET["grnYear"];
	$pub_commonBin      = $_GET["pub_commonBin"];
	$MainStore 			= $_GET["MainStore"];
	
	if($pub_commonBin == 1)
		{	
			$sqlCommBin = " select s.strSubID,s.strLocID,s.strBinID,s.strMainID
				from storesbins s inner join mainstores ms on 
				ms.strMainID = s.strMainID
				where s.strMainID='$MainStore' and ms.intCommonBin=1 and ms.intStatus=1" ;		
			$resCommBin =$db->RunQuery($sqlCommBin);			
			while ($rowBin =mysql_fetch_array($resCommBin))
			{
				$mainStores = $rowBin["strMainID"];
				$subStores = $rowBin["strSubID"];
				$location = $rowBin["strLocID"];	
				$binId	  = $rowBin["strBinID"];	
			}	
		}
		$sql_insert_temp = "insert into stocktransactions_bulk_temp 
							( 
							intYear, 
							strMainStoresID, 
							strSubStores, 
							strLocation, 
							strBin, 
							intDocumentNo, 
							intDocumentYear, 
							intMatDetailId, 
							strColor, 
							strSize, 
							strType, 
							strUnit, 
							dblQty, 
							dtmDate, 
							intUser, 
							intBulkGrnNo, 
							intBulkGrnYear
							)
							values
							(
							$gatePassYear,
							'$mainStores',
							'$subStores',
							'$location',
							'$binId',
							 $gatePassNo,
							 $gatePassYear,
							 $matDetailId,
							'$color',
							'$size',
							'GATEPASS',
							'$itemunit',
							'$binQty',
							 now(),
							 $UserID,
							 $grnNo,
							 $grnYear	 
							)";
		$result_insert_temp = $db->RunQuery($sql_insert_temp); 
		if($result_insert_temp)
			echo "Bin_Saved";
		else
			echo "Bin_Error";
}
if($RequestType=="confirmGatePass")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$GPNo = $_GET["GPNo"];
	$arrGPno = explode('/',$GPNo);
	$validateBinCount = $_GET["validateBinCount"];
	
	$ResponseXML = "<binValidate>\n";
	$GatepassNo = $arrGPno[1];
	$GPyear = $arrGPno[0];
	
	$sql = "SELECT * FROM stocktransactions_bulk_temp WHERE intDocumentNo='$GatepassNo' AND intDocumentYear='$GPyear' AND strType='GATEPASS' ";
	$result = $db->RunQuery($sql);
	
	$response='';
	while($row = mysql_fetch_array($result))
	{
		$mainStore 		= $row["strMainStoresID"];
		$subStore 		= $row["strSubStores"];
		$location 		= $row["strLocation"];
		$bin 			= $row["strBin"];
		$matdetailID 	= $row["intMatDetailId"];
		$color 			= $row["strColor"];
		$size 			= $row["strSize"];
		$grnNo 			= $row["intBulkGrnNo"];
		$grnYear 		= $row["intBulkGrnYear"];
		$qty   			= abs($row["dblQty"]);
		
		$SQLStock = "SELECT SUM(dblQty) AS StockQty FROM stocktransactions_bulk WHERE intMatDetailId = '$matdetailID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$mainStore' and intBulkGrnNo= '$grnNo' and intBulkGrnYear='$grnYear' and strSubStores='$subStore' and strLocation = '$location' and strBin = '$bin' ";
		$resStock =  $db->RunQuery($SQLStock);
		while($rowST = mysql_fetch_array($resStock))
		{
			$StockQty = $rowST["StockQty"];
			if($StockQty < $qty || $StockQty==0)
			{
				$response = 'Some items not in stock';				
			}
		}
	}
		echo $response;
		if($response == '')
		{
			$SQLstock =  "insert into stocktransactions_bulk 
							( 
							intYear, 
							strMainStoresID, 
							strSubStores, 
							strLocation, 
							strBin,  
							intDocumentNo, 
							intDocumentYear, 
							intMatDetailId, 
							strColor, 
							strSize, 
							strType, 
							strUnit, 
							dblQty, 
							dtmDate, 
							intUser, 
							intBulkGrnNo, 
							intBulkGrnYear
							)
							select  
							intYear, 
							strMainStoresID, 
							strSubStores, 
							strLocation, 
							strBin, 
							intDocumentNo, 
							intDocumentYear, 
							intMatDetailId, 
							strColor, 
							strSize, 
							strType, 
							strUnit, 
							dblQty, 
							dtmDate, 
							intUser, 
							intBulkGrnNo, 
							intBulkGrnYear 
							from 
							stocktransactions_bulk_temp 
							where intDocumentNo='$GatepassNo' AND intDocumentYear='$GPyear' AND strType='GATEPASS' ;";
			
			$resultStock = $db->RunQuery($SQLstock);
				if($resultStock)
				{
					$SQLdel		= "delete from stocktransactions_bulk_temp where intDocumentNo='$GatepassNo' AND intDocumentYear='$GPyear' AND strType='GATEPASS'";
					$resultDel	= $db->RunQuery($SQLdel);
				}	
				
				$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions_bulk where intDocumentNo='$GatepassNo' AND intDocumentYear='$GPyear' AND strType='GATEPASS'";	
		
				$result=$db->RunQuery($SQL);
				$row = mysql_fetch_array($result);
				$recCountBinDetails=$row["binDetails"];			
					if($recCountBinDetails==$validateBinCount)
					{
						$ResponseXML .= "<recCountBinDetails><![CDATA[TRUE]]></recCountBinDetails>\n";
					}
					else
					{
						$ResponseXML .= "<recCountBinDetails><![CDATA[FALSE]]></recCountBinDetails>\n";
					}
		}
		$ResponseXML .= "<stockValidation><![CDATA[".$stockResponse."]]></stockValidation>\n";
		$ResponseXML .="</binValidate>";
		echo $ResponseXML;
	
}
if($RequestType=="GatePassComfirm")
{
	$GPNO      = $_GET["GPNO"];
	$GPNOArray =explode('/',$GPNO);	
	
	$SqlConfirm="Update bulk_gatepassheader 
				 set intConfirmedBy = '$UserID',dtmConfirmedDate = now(),
				 intStatus =1 
				 where intGatePassNo = '$GPNOArray[1]' and intGatePassYear = '$GPNOArray[0]' ";
 	$result = $db->RunQuery($SqlConfirm);
	if($result)
		echo "Confirmed";
	else
		echo "Error confirming";
}
if($RequestType=="LoadHeaderDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$gatePassNo 	= $_GET["gatePassNo"];
	$gatePassYear 	= $_GET["gatePassYear"];
	$gatePassStatus = $_GET["gatePassStatus"];
	
	$ResponseXML .="<LoadHeaderDetails>\n";
	$sql_category ="select strCategory from bulk_gatepassheader 
					WHERE intGatePassNo ='$gatePassNo' 
					AND intGatePassYear ='$gatePassYear'";
	$result_category = $db->RunQuery($sql_category);
	$row_category 	 = mysql_fetch_array($result_category);
	$category 		 = $row_category["strCategory"];
	
	$SQL="SELECT CONCAT(BGP.intGatePassYear,'/' ,BGP.intGatePassNo) AS GPNO,BGP.intDestination,date(BGP.dtmDate) as dtmDate,BGP.strRemarks,
			BGP.strAttention,BGP.intStatus,BGP.strCategory,BGP.intNoOfPackages 
			FROM bulk_gatepassheader AS BGP ";		 
if($category=="E")
	$SQL .= " Inner Join subcontractors ON BGP.intDestination = subcontractors.strSubContractorID ";
elseif($category=="I")
	$SQL .= "Inner Join mainstores ON BGP.intDestination = mainstores.strMainID ";

	$SQL .= "WHERE BGP.intGatePassNo ='$gatePassNo' ".
		 	"AND BGP.intGatePassYear ='$gatePassYear'
			 AND BGP.intStatus ='$gatePassStatus'";
			
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<GPNO><![CDATA[" . $row["GPNO"] . "]]></GPNO>\n";						
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"] . "]]></Remarks>\n";
			$ResponseXML .= "<DestinationID><![CDATA[" . $row["intDestination"] . "]]></DestinationID>\n";			
				$Date =$row["dtmDate"];
				$GPNOArray=explode('-',$Date);
				$formatedGPDate=$GPNOArray[2]."/".$GPNOArray[1]."/".$GPNOArray[0];
			$ResponseXML .= "<formatedGPDate><![CDATA[" . $formatedGPDate . "]]></formatedGPDate>\n";
			$ResponseXML .= "<Attention><![CDATA[" . $row["strAttention"] . "]]></Attention>\n";
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
			$ResponseXML .= "<category><![CDATA[" . $row["strCategory"] . "]]></category>\n";
			$ResponseXML .= "<intNoOfPackages><![CDATA[" . $row["intNoOfPackages"] . "]]></intNoOfPackages>\n";
			
		}
	
	$ResponseXML .="</LoadHeaderDetails>";
	echo $ResponseXML;	
}
if($RequestType=="LoadGatePassDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$gatePassNo 	= $_GET["gatePassNo"];
	$gatePassYear 	= $_GET["gatePassYear"];
	$gatePassStatus = $_GET["gatePassStatus"];
	
	$ResponseXML .="<LoadGatePassDetails>\n";
	
	$SQL = "SELECT  BGPD.intMatDetailId,BGPD.strColor,BGPD.strSize,BGPD.dblQty,MIL.strItemDescription,
			MMC.strDescription,MIL.strUnit,BGPD.intGrnNo, BGPD.intGRNYear,BGPD.intRTN
			FROM bulk_gatepassdetails AS BGPD 
			Inner Join matitemlist AS MIL ON BGPD.intMatDetailId = MIL.intItemSerial 
			Inner Join matmaincategory AS MMC ON MIL.intMainCatID = MMC.intID 
			WHERE BGPD.intGatePassNo ='$gatePassNo' AND BGPD.intGatePassYear ='$gatePassYear' 
			ORDER BY MIL.intMainCatID ASC";
			
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$matDetailId	= $row["intMatDetailId"];
			$color			= $row["strColor"];
			$size			= $row["strSize"];
			$grnNo 			= $row["intGrnNo"];
			$grnYear		= $row["intGRNYear"];
			$StockQty		= getStockQty($matDetailId,$color,$size,$companyId,$grnNo,$grnYear);
			
			$ResponseXML .= "<MainCategory><![CDATA[" . $row["strDescription"] . "]]></MainCategory>\n";
			$ResponseXML .= "<MatDetailId><![CDATA[" . $matDetailId . "]]></MatDetailId>\n";
			$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";					
			$ResponseXML .= "<Color><![CDATA[" . $color . "]]></Color>\n";
			$ResponseXML .= "<Size><![CDATA[" . $size . "]]></Size>\n";
			$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
			$ResponseXML .= "<GPQTY><![CDATA[" . round($row["dblQty"],2) . "]]></GPQTY>\n";
			$ResponseXML .= "<GRNno><![CDATA[" . $grnNo . "]]></GRNno>\n";
			$ResponseXML .= "<GRNYear><![CDATA[" . $grnYear . "]]></GRNYear>\n";
			$ResponseXML .= "<stockQty><![CDATA[" .  round($StockQty,2) . "]]></stockQty>\n";
			$ResponseXML .= "<intRTN><![CDATA[" .  $row["intRTN"] . "]]></intRTN>\n";
				
		}
		$ResponseXML .="</LoadGatePassDetails>";
		echo $ResponseXML;
}
if($RequestType=="LoadPendingConfirmBinDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$GatePassNo		= $_GET["gatePassNo"];
	$gatePassYear	= $_GET["gatePassYear"];
	$MatDetailID	= $_GET["matDetailID"];
	$Color			= $_GET["color"];
	$Size			= $_GET["size"];
	$grnNo			= $_GET["GRNNo"];	
	$grnYear		= $_GET["GRNYear"];	
	$gatePassStatus = $_GET["gatePassStatus"];
	
	if($gatePassStatus == '1')
		$tbl = 'stocktransactions_bulk';
	else
		$tbl = 'stocktransactions_bulk_temp';
	$ResponseXML .="<LoadPendingConfirmBinDetails>\n";
	
	$SQL_Bin ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin,Sum(ST.dblQty) as BinQty,MIL.intSubCatID 
			FROM $tbl AS ST 
			Inner Join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId 
			WHERE ST.intDocumentNo =  '$GatePassNo' AND ST.intDocumentYear =  '$gatePassYear' 
			AND ST.intMatDetailId = '$MatDetailID' AND ST.strColor = '$Color' AND ST.strSize = '$Size' and strType='GATEPASS' 
			AND ST.intBulkGrnNo = '$grnNo' AND ST.intBulkGrnYear = '$grnYear'
			GROUP BY ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin,ST.intBulkGrnNo,ST.intBulkGrnYear";
	$result_bin=$db->RunQuery($SQL_Bin);
		while($row=mysql_fetch_array($result_bin))
		{
			$BinQty=$row["BinQty"];
			$Qty =substr($BinQty,1);	
			$ResponseXML .="<Qty><![CDATA[". round($Qty,2) ."]]></Qty>\n";		
			$ResponseXML .="<MainStoresID><![CDATA[". $row["strMainStoresID"] ."]]></MainStoresID>\n";
			$ResponseXML .="<SubStores><![CDATA[". $row["strSubStores"] ."]]></SubStores>\n";
			$ResponseXML .="<Location><![CDATA[". $row["strLocation"] ."]]></Location>\n";
			$ResponseXML .="<Bin><![CDATA[". $row["strBin"] ."]]></Bin>\n";		
			$ResponseXML .="<MatSubCatId><![CDATA[". $row["intSubCatID"] ."]]></MatSubCatId>\n";
		}		
	$ResponseXML .="</LoadPendingConfirmBinDetails>";
	echo $ResponseXML;
	
}
function getStockQty($matDetailId,$color,$size,$companyId,$grnNo,$grnYear)
{
	global $db;	
	$SQLStock=" SELECT Sum(ST.dblQty) AS StockQty 
				  FROM stocktransactions_bulk AS ST 
				  Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID  
				  WHERE ST.intMatDetailId ='$matDetailId' AND ST.strColor ='$color' AND 
				  ST.strSize ='$size' AND MS.intCompanyId ='$companyId' 
				  and ST.intBulkGrnNo='$grnNo' and ST.intBulkGrnYear='$grnYear' and MS.intStatus=1
				  GROUP BY ST.intMatDetailId,ST.strColor,ST.strSize,ST.intBulkGrnNo,ST.intBulkGrnYear;";
	
	$resultStock=$db->RunQuery($SQLStock);
	$rowStockcount = mysql_num_rows($resultStock);
	if ($rowStockcount > 0)
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

?>