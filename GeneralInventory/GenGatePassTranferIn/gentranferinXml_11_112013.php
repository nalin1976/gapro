<?php
session_start();
include "../../Connector.php";
include "../class.glcode.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
$companyId		= $_SESSION["FactoryID"];
$UserID			= $_SESSION["UserID"];
$gl = new glcode();

 if($RequestType=="LoadGatePassDetails")
{
	$gatePassNo =$_GET["gatePassNo"];
		$GPNoArray=explode('/',$gatePassNo);
	
	
	$ResponseXML .="<LoadGatePassDetails>\n";
		
	$SQL="  SELECT  GPD.strGatepassID,
			GPD.intYear,
			GPD.intMatDetailID,
			GMI.strItemDescription,
			GPD.dblBalQty,
			GPD.strUnit,
			GPD.intGrnNo,
			GPD.intGrnYear,
			GPD.intCostCenterId,
			CC.strDescription as costCenterDes,GPD.intGLAllowId
			FROM gengatepassdetail AS GPD
			Inner Join genmatitemlist GMI ON GPD.intMatDetailID = GMI.intItemSerial 
			Inner Join costcenters CC on CC.intCostCenterId=GPD.intCostCenterId
			WHERE GPD.strGatepassID ='$GPNoArray[1]' AND GPD.intYear ='$GPNoArray[0]' AND GPD.dblQty >0";	
	$result=$db->RunQuery($SQL);
	
		while($row=mysql_fetch_array($result))
		{
			$glAlloId = $row["intGLAllowId"];
			$glCode = $gl->getGLCode($glAlloId);
				
			$ResponseXML .="<MatDetailID><![CDATA[".$row["intMatDetailID"]."]]></MatDetailID>\n";
			$ResponseXML .="<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
			$ResponseXML .="<Unit><![CDATA[".$row["strUnit"]."]]></Unit>\n";
			$ResponseXML .="<Qty><![CDATA[".round($row["dblBalQty"],2)."]]></Qty>\n";
			$ResponseXML .="<GRNno><![CDATA[".$row["intGrnNo"]."]]></GRNno>\n";
			$ResponseXML .="<GRNYear><![CDATA[".$row["intGrnYear"]."]]></GRNYear>\n";
			$ResponseXML .="<CostCenterId><![CDATA[".$row["intCostCenterId"]."]]></CostCenterId>\n";
			$ResponseXML .="<costCenterDes><![CDATA[".$row["costCenterDes"]."]]></costCenterDes>\n";
			$ResponseXML .="<glAlloId><![CDATA[".$glAlloId."]]></glAlloId>\n";
			$ResponseXML .="<glCode><![CDATA[".$glCode."]]></glCode>\n";
			
		}	
	$ResponseXML .="</LoadGatePassDetails>";
	echo $ResponseXML;
}
else if($RequestType=="LoadLocation")
{
	$mainStoreID =$_GET["mainStoreID"];
	$subStoresID =$_GET["subStoresID"];
	$subCatID =$_GET["subCatID"];
	
	$ResponseXML .="<LoadLocation>\n";
		
	$SQLLOC	="SELECT DISTINCT ".
				 "SBA.strMainID, ".
				 "SBA.strSubID, ".
				 "SBA.strLocID, ".
				 "SL.strLocName ".
				 "FROM ".
				 "storesbinallocation AS SBA ".
				 "Inner Join storeslocations AS SL ON SL.strLocID = SBA.strLocID ".
				 "WHERE ".
				 "SBA.intSubCatNo =$subCatID AND ".
				 "SBA.strMainID ='$mainStoreID' AND ". 
				 "SBA.strSubID ='$subStoresID'";
		
	$result=$db->RunQuery($SQLLOC);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Location><![CDATA[".$row["strLocName"]."]]></Location>\n";
			$ResponseXML .="<LocationID><![CDATA[".$row["strLocID"]."]]></LocationID>\n";
		}	

	$ResponseXML .="</LoadLocation>";
	echo $ResponseXML;
}

else if($RequestType=="LoadGPTransferInNo")
{		
$ResponseXML .="<LoadGPTransferInNo>\n";			
	$GatePassNo = getGetPassTrnsferInNo();
	$GatePassYear = date("Y");
	
	$ResponseXML .= "<TransferInNo><![CDATA[".$GatePassNo."]]></TransferInNo>\n";
	$ResponseXML .= "<TransferInYear><![CDATA[".$GatePassYear."]]></TransferInYear>\n";
	
$ResponseXML .="</LoadGPTransferInNo>";
echo $ResponseXML;
}
else if($RequestType=="SaveHeaderDetails")
{
$transferIn 		= $_GET["transferIn"];
$transferInYear 	= $_GET["transferInYear"];
$GatePassNo 		= $_GET["GatePassNo"];
$GatePassNoArray 	= explode('/',$GatePassNo);
$remarks 			= $_GET["remarks"];
		
	$SQL= " INSERT INTO gengatepasstransferinheader      
		   (intTransferInNo, 
			intTransferInYear, 
			intGatePassNo, 
			intGPYear, 
			dtmDate, 
			intUserId, 
			intStatus, 
			strRemarks, 
			intCompanyId)
			values
			('$transferIn', 
			'$transferInYear', 
			'$GatePassNoArray[1]', 
			'$GatePassNoArray[0]', 
			 now(), 
			'$UserID', 
			'1', 
			'$remarks', 
			'$companyId'
			);";

	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveDetails")
{
	$transferIn     = $_GET["transferIn"];
	$transferInYear = $_GET["transferInYear"];	
	$MatDetailID    = $_GET["MatDetailID"];
	$Unit			= $_GET["Unit"];
	$Qty       	    = $_GET["Qty"];
	$grnNo			= $_GET["grnNo"];
	$grnYear		= $_GET["grnYear"];
	$GatePassNo		= $_GET["GatePassNo"];
	$GPArray 		= explode('/',$GatePassNo);
	$costCenterId	= $_GET["costCenterId"];
	$glAlloId 		= $_GET["glAlloId"];
	
	$sqlHeader ="   INSERT INTO gengatepasstransferindetails
					(intTransferInNo, 
					 intTransferInYear, 
					 intMatDetailId, 
					 strUnit, 
					 dblQty, 
					 intGrnNo, 
					 intGRNYear,
					 intCostCenterId,
					 intGLAllowId
					 )
					VALUES
				    ($transferIn,
					 $transferInYear,
					 $MatDetailID,
					 '$Unit',
					 $Qty,
					 $grnNo,
					 $grnYear,
					 $costCenterId,'$glAlloId')";			
	$db->executeQuery($sqlHeader);
	
	$sqlUpDate ="UPDATE gengatepassdetail SET dblBalQty=dblBalQty-$Qty WHERE strGatepassID=$GPArray[1] AND intYear=$GPArray[0] AND intMatDetailID = $MatDetailID and intGrnNo='$grnNo' and  intGrnYear='$grnYear' and intCostCenterId ='$costCenterId' and intGLAllowId ='$glAlloId' ";
	
	$db->executeQuery($sqlUpDate);
	
	$SQL="INSERT INTO genstocktransactions
					(intYear, 
					 strMainStoresID, 
					 intDocumentNo, 
					 intDocumentYear, 
					 intMatDetailId, 
					 strType, 
					 strUnit, 
					 dblQty, 
					 dtmDate, 
					 intUser,
					 intGRNNo,
					 intGRNYear,
					 intCostCenterId,
					 intGLAllowId
					 ) 
					 VALUES
		 			($transferInYear,
					'$companyId',
					'$transferIn',
					'$transferInYear',
					'$MatDetailID',
					'TI',
					'$Unit',
					'$Qty',
					now(),
					'$UserID',
					'$grnNo',
					'$grnYear',
					'$costCenterId',
					'$glAlloId'
					); ";
		 	
	$db->executeQuery($SQL);
}
else if ($RequestType=="ResponseValidate")
{
	$TransferIn       =$_GET["transferIn"];
	$Year             =$_GET["transferInYear"];
	$validateCount    =$_GET["validateCount"];
		
	
	$ResponseXML .="<ResponseValidate>\n";
	
	$SQLHeder="SELECT COUNT(intTransferInNo) AS headerRecCount FROM gengatepasstransferinheader where intTransferInNo=$TransferIn AND intTransferInYear=$Year";
	
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
			
	$SQLDetail="SELECT COUNT(intTransferInNo) AS DetailsRecCount FROM gengatepasstransferindetails where intTransferInNo=$TransferIn AND intTransferInYear=$Year";
	
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
	$SQL="SELECT COUNT(intDocumentNo) AS stockDetails FROM genstocktransactions where intDocumentNo='$TransferIn' AND intDocumentYear='$Year' AND strType='TI'";	

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$recCountBinDetails=$row["stockDetails"];
		
			if($recCountBinDetails==$validateCount)
			{
				$ResponseXML .= "<recCountBinDetails><![CDATA[TRUE]]></recCountBinDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountBinDetails><![CDATA[FALSE]]></recCountBinDetails>\n";
			}
	}
		
	
	$ResponseXML .="</ResponseValidate>";
	echo $ResponseXML;
}

else if($RequestType=="LoadPopUpHeaderDetails")
{

	$intGrnNo 		= $_GET["intGrnNo"];
	$intYear		= $_GET["intYear"];
	
	$ResponseXML .="<LoadPopUpHeaderDetails>\n";
	
	$SQL="SELECT CONCAT(GTIH.intTransferInYear,'/',GTIH.intTransferInNo) AS GpTranferNo,
		 CONCAT(GTIH.intGPYear,'/',GTIH.intGatePassNo) AS GatePassNo,
		 GTIH.intStatus,
		 GTIH.dtmDate,
		 GTIH.strRemarks		 
		 FROM gengatepasstransferinheader AS GTIH
		 WHERE GTIH.intTransferInNo ='$intGrnNo ' AND
		 GTIH.intTransferInYear='$intYear'";
	
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<GpTranferNo><![CDATA[" . $row["GpTranferNo"] . "]]></GpTranferNo>\n";	
			$ResponseXML .= "<GatePassNo><![CDATA[" . $row["GatePassNo"] . "]]></GatePassNo>\n";					
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"] . "]]></Remarks>\n";						
				$Date =substr($row["dtmDate"],0,10);
				$NOArray=explode('-',$Date);
				$formatedDate=$NOArray[2]."/".$NOArray[1]."/".$NOArray[0];
			$ResponseXML .= "<formatedDate><![CDATA[" .$formatedDate. "]]></formatedDate>\n";
					
		}
	$ResponseXML .="</LoadPopUpHeaderDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpDetails")
{
$intGrnNo 	= $_GET["intGrnNo"];
$intYear 	= $_GET["intYear"];

$ResponseXML .="<LoadPopUpDetails>\n";
	
	$SQL="SELECT	 CONCAT(GTIH.intGPYear,'/',GTIH.intGatePassNo)AS GatePassNo, 
		 GTID.intMatDetailId,  
		 GTID.dblQty, 		  
		 MIL.strItemDescription, 
		 GTID.strUnit,
		 GTID.intGrnNo, 
		 GTID.intGRNYear,
		 GTID.intCostCenterId,
		 CC.strDescription as CostCenterDes,
		 GTID.intGLAllowId
		 FROM 
		 gengatepasstransferindetails AS GTID 
		 Inner Join genmatitemlist AS MIL ON GTID.intMatDetailId = MIL.intItemSerial 
		 Inner Join gengatepasstransferinheader AS GTIH ON 
		 GTIH.intTransferInNo=GTID.intTransferInNo 
		 Inner Join costcenters CC on CC.intCostCenterId=GTID.intCostCenterId
		 WHERE 
		 GTID.intTransferInNo =$intGrnNo AND 
		 GTID.intTransferInYear =$intYear;";	
		$id=0;
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{	
				
			$GatePassNo			= $row["GatePassNo"];
			$GatePassNoArray	= explode('/',$GatePassNo);			
			$MatDetailID		= $row["intMatDetailId"];
			$grnNo 				= $row["intGrnNo"];
			$grnYear 			= $row["intGRNYear"];
			$Qty				= $row["dblQty"];
			$balQty				= BalQty($intGrnNo,$intYear,$id);
			$itemDiscription	= $row["strItemDescription"];
			$strUnit			= $row["strUnit"];
			$glAlloId 			= $row["intGLAllowId"];
			$glCode = $gl->getGLCode($glAlloId);
			
			$ResponseXML .= "<GatePassNo><![CDATA[" . $GatePassNo . "]]></GatePassNo>\n";
			$ResponseXML .= "<MatDetailID><![CDATA[" . $MatDetailID . "]]></MatDetailID>\n";
			$ResponseXML .= "<grnNo><![CDATA[" . $grnNo . "]]></grnNo>\n";
			$ResponseXML .= "<grnYear><![CDATA[" . $grnYear . "]]></grnYear>\n";
			$ResponseXML .= "<Qty><![CDATA[" . $Qty . "]]></Qty>\n";
			$ResponseXML .= "<balQty><![CDATA[" . $balQty . "]]></balQty>\n";
			$ResponseXML .= "<itemDiscription><![CDATA[" . $itemDiscription . "]]></itemDiscription>\n";
			$ResponseXML .= "<strUnit><![CDATA[" . $strUnit . "]]></strUnit>\n";
			$ResponseXML .= "<costCenterId><![CDATA[" . $row["intCostCenterId"] . "]]></costCenterId>\n";
			$ResponseXML .= "<costCenterDes><![CDATA[" .  $row["CostCenterDes"] . "]]></costCenterDes>\n";
			$ResponseXML .= "<glAlloId><![CDATA[" .  $glAlloId . "]]></glAlloId>\n";
			$ResponseXML .= "<glCode><![CDATA[" .  $glCode . "]]></glCode>\n";
			$id++;
			
		}
$ResponseXML .="</LoadPopUpDetails>";
echo $ResponseXML;
}

function BalQty($intGrnNo,$intYear,$id)
{
			global $db;
						
			$SQLStock="SELECT CONCAT(GTIH.intTransferInYear,'/',GTIH.intTransferInNo) AS GpTranferNo,
						 GD.dblBalQty		 
						 FROM gengatepasstransferinheader AS GTIH
						 inner join gengatepassdetail GD on GTIH.intGatePassNo=GD.strGatepassID
						 WHERE GTIH.intTransferInNo ='$intGrnNo' AND
						 GTIH.intTransferInYear='$intYear'
						 limit $id,1;";
			
			$resultStock=$db->RunQuery($SQLStock);
			$rowcount = mysql_num_rows($resultStock);
			if ($rowcount > 0)
			{
				while($rowStock=mysql_fetch_array($resultStock))
				{
					
					return $rowStock["dblBalQty"];
					
				}
			}
			else 
			{
				return 0;
			}
}
//start 2010-11-08 generate style gatepass trnsfer in number---------
function getGetPassTrnsferInNo()
{
	$compCode=$_SESSION["FactoryID"];
	global $db; 

	$strSQL="update syscontrol set  dblGenTranferInNo= dblGenTranferInNo+1 WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblGenTranferInNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$GTRFNo = 'NA';
	while($row = mysql_fetch_array($result))
	 {
		$GTRFNo  =  $row["dblGenTranferInNo"] ;
		break;
	 }
	return $GTRFNo;
}
// end 2010-11-08-------------------------------
?>