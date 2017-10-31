<?php
session_start();
include "../Connector.php";

$Request		= $_GET["Request"];
$companyId		= $_SESSION["FactoryID"];
$UserID			= $_SESSION["UserID"];

if($Request=="LoadSubStores")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$mainStoresID = $_GET["mainStoresID"];
	$ResponseXML = "<XMLLoadSubStores>\n";
	
	$sql_load = "SELECT strSubID,strSubStoresName FROM substores WHERE strMainID='$mainStoresID'";
				
	$result_load =$db->RunQuery($sql_load);
	
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["strSubID"] ."\">".$row["strSubStoresName"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadSubStores>\n";
		echo $ResponseXML;
}
if($Request=="getCommonBin")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$mainStoresID = $_GET["mainStoresID"];
	$ResponseXML = "<LoadCommBin>\n";
	
	$sql = "select intCommonBin from mainstores where strMainID=$mainStoresID  and intStatus=1";
				
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$commBin =  $row["intCommonBin"];
	
	$ResponseXML .= "<commBin><![CDATA[" . $commBin . "]]></commBin>\n";
	$ResponseXML .="</LoadCommBin>";
	echo $ResponseXML;
}
if($Request=="LoadGatePassDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$gatePassNo = $_GET["gatePassNo"];
	$GPNoArray  = explode('/',$gatePassNo);
	
	$ResponseXML .="<LoadGatePassDetails>\n";
	
	$SQL = "SELECT BGPD.intMatDetailId,BGPD.strColor,BGPD.strSize,BGPD.dblQty,BGPD.dblBalQty,MIL.intSubCatID, 
			 MIL.strItemDescription,MIL.strUnit,BGPD.intGrnNo,BGPD.intGRNYear 
			 FROM bulk_gatepassdetails AS BGPD 
			 Inner Join matitemlist MIL ON BGPD.intMatDetailId = MIL.intItemSerial 
			 Inner Join bulk_gatepassheader BGH ON BGPD.intGatePassNo = BGH.intGatePassNo and  BGPD.intGatePassYear = BGH.intGatePassYear 
			 WHERE BGPD.intGatePassNo =$GPNoArray[1] AND BGPD.intGatePassYear =$GPNoArray[0] AND BGPD.dblBalQty >0 AND BGH.intStatus=1";
	$result=$db->RunQuery($SQL);
	while($row=mysql_fetch_array($result))
	{
			$ResponseXML .="<intMatDetailId><![CDATA[".$row["intMatDetailId"]."]]></intMatDetailId>\n";
			$ResponseXML .="<strColor><![CDATA[".$row["strColor"]."]]></strColor>\n";
			$ResponseXML .="<strSize><![CDATA[".$row["strSize"]."]]></strSize>\n";
			$ResponseXML .="<dblBalQty><![CDATA[".round($row["dblBalQty"],2)."]]></dblBalQty>\n";
			$ResponseXML .="<intSubCatID><![CDATA[".$row["intSubCatID"]."]]></intSubCatID>\n";
			$ResponseXML .="<strItemDescription><![CDATA[".$row["strItemDescription"]."]]></strItemDescription>\n";
			$ResponseXML .="<strUnit><![CDATA[".$row["strUnit"]."]]></strUnit>\n";
			$ResponseXML .="<intGrnNo><![CDATA[".$row["intGrnNo"]."]]></intGrnNo>\n";
			$ResponseXML .="<intGRNYear><![CDATA[".$row["intGRNYear"]."]]></intGRNYear>\n";
			
	}
	$ResponseXML .="</LoadGatePassDetails>";
	echo $ResponseXML;
	
}
if($Request=="LoadGPTransferInNo")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$GatePassYear = date("Y");
	$ResponseXML .="<LoadGPTransferInNo>\n";
	
	$strSQL="update syscontrol set  dblBulkTranferInNo= dblBulkTranferInNo+1 WHERE syscontrol.intCompanyID='$companyId'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblBulkTranferInNo FROM syscontrol WHERE syscontrol.intCompanyID='$companyId'";
	$result=$db->RunQuery($strSQL);
	$GPNo = 'NA';
	while($row = mysql_fetch_array($result))
	 {
		$GPNo  =  $row["dblBulkTranferInNo"] ;
		$ResponseXML .= "<TransferInNo><![CDATA[".$GPNo."]]></TransferInNo>\n";
		$ResponseXML .= "<TransferInYear><![CDATA[".$GatePassYear."]]></TransferInYear>\n";
		break;
	 }
	 $ResponseXML .="</LoadGPTransferInNo>";
	 echo $ResponseXML; 	
}
if($Request=="LoadPopUpTransIn")
{
	$state	= $_GET["state"];
	$year	= $_GET["year"];

$ResponseXML.="<LoadPopUpTransIn>";

	$SQL="SELECT DISTINCT BGP.intTransferInNo 
		 FROM bulk_gatepasstransferinheader AS BGP 
		 INNER JOIN bulk_gatepasstransferindetails AS BGPD 
		 ON BGP.intTransferInNo=BGPD.intTransferInNo AND BGP.intTransferInYear=BGPD.intTransferInYear 
		 WHERE BGP.intStatus='$state' AND BGP.intTransferInYear='$year' and BGP.intCompanyId='$companyId' 
		 order by BGP.intTransferInNo";	
	$result=$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"". "0" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intTransferInNo"] ."\">" . $row["intTransferInNo"] ."</option>" ;
	}
$ResponseXML.="</LoadPopUpTransIn>";
echo $ResponseXML;
}
if($Request=="LoadPopUpHeaderDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$No 		= $_GET["No"];
	$Year		= $_GET["Year"];
	
	$ResponseXML .="<LoadPopUpHeaderDetails>\n";
	
	$Sql ="SELECT CONCAT(BGTIH.intTransferInYear,'/',BGTIH.intTransferInNo) AS GpTranferNo, 
		 CONCAT(BGTIH.intGPYear,'/',BGTIH.intGatePassNo) AS GatePassNo, 
		 BGTIH.intStatus, 
		 BGTIH.dtmDate, 
		 BGTIH.strRemarks,
		 STB.strMainStoresID,
	     STB.strSubStores	 
		 FROM bulk_gatepasstransferinheader AS BGTIH 
		 inner join stocktransactions_bulk STB ON STB.intDocumentNo = BGTIH.intTransferInNo and STB.intDocumentYear = BGTIH.intTransferInYear
		 WHERE BGTIH.intTransferInNo =  '$No' AND 
		 BGTIH.intTransferInYear =  '$Year' AND
		 STB.strType='TI';";
	$result=$db->RunQuery($Sql);
	
	while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<GpTranferNo><![CDATA[" . $row["GpTranferNo"] . "]]></GpTranferNo>\n";	
			$ResponseXML .= "<GatePassNo><![CDATA[" . $row["GatePassNo"] . "]]></GatePassNo>\n";					
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"] . "]]></Remarks>\n";						
				$Date =substr($row["dtmDate"],0,10);
				$NOArray=explode('-',$Date);
				$formatedDate=$NOArray[2]."/".$NOArray[1]."/".$NOArray[0];
			$ResponseXML .= "<formatedDate><![CDATA[" . $formatedDate . "]]></formatedDate>\n";
			$ResponseXML .= "<MainStoresID><![CDATA[" . $row["strMainStoresID"] . "]]></MainStoresID>\n";
			$ResponseXML .= "<SubStoresID><![CDATA[" . $row["strSubStores"] . "]]></SubStoresID>\n";
			
						
		}
	$ResponseXML .="</LoadPopUpHeaderDetails>";
	echo $ResponseXML;
}
if($Request=="LoadPopUpDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$No 	= $_GET["No"];
	$Year 	= $_GET["Year"];

	$ResponseXML .="<LoadPopUpDetails>\n";
	$SQL="SELECT BGPTD.intMatDetailId,BGPTD.strColor,BGPTD.strSize,BGPTD.dblQty,BGPTD.strUnit,MIL.intSubCatID, 
			 MIL.strItemDescription,BGPTD.intGRNNo,BGPTD.intGRNYear,BGTH.intGatePassNo,BGTH.intGPYear 
			 FROM bulk_gatepasstransferindetails AS BGPTD 
			 Inner Join matitemlist MIL ON BGPTD.intMatDetailId = MIL.intItemSerial 
			 Inner Join bulk_gatepasstransferinheader BGTH ON BGPTD.intTransferInNo = BGTH.intTransferInNo and  BGPTD.intTransferInYear = BGTH.intTransferInYear 
			 WHERE BGPTD.intTransferInNo ='$No' AND BGPTD.intTransferInYear ='$Year' AND BGTH.intStatus=1";	
	$result=$db->RunQuery($SQL);
	
		while($row=mysql_fetch_array($result))
		{			
			$GatePassNo			= $row["intGatePassNo"];
			$GatePassYear		= $row["intGPYear"];			
			$MatDetailID		= $row["intMatDetailId"];
			$Color				= $row["strColor"];
			$Size				= $row["strSize"];
			$grnNo 				= $row["intGRNNo"];
			$grnYear 			= $row["intGRNYear"];
		
			$GatePassQty = getGatePassQty($GatePassNo,$GatePassYear,$MatDetailID,$Color,$Size,$grnNo,$grnYear);
			$ResponseXML .= "<MatDetailID><![CDATA[" . $row["intMatDetailId"] . "]]></MatDetailID>\n";
			$ResponseXML .= "<Color><![CDATA[" . $row["strColor"] . "]]></Color>\n";
			$ResponseXML .= "<Size><![CDATA[" . $row["strSize"] . "]]></Size>\n";
			$ResponseXML .= "<GatePassQty><![CDATA[" . $GatePassQty . "]]></GatePassQty>\n";	
			$ResponseXML .= "<BalQty><![CDATA[" . round($row["dblQty"],2) . "]]></BalQty>\n";	
			$ResponseXML .= "<intSubCatID><![CDATA[" . $row["intSubCatID"] . "]]></intSubCatID>\n";							
			$ResponseXML .= "<strItemDescription><![CDATA[" .$row["strItemDescription"]. "]]></strItemDescription>\n";				
			$ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"] . "]]></strUnit>\n";
			$ResponseXML .= "<intGRNNo><![CDATA[" . $row["intGRNNo"] . "]]></intGRNNo>\n";			
			$ResponseXML .= "<intGRNYear><![CDATA[" . $row["intGRNYear"] . "]]></intGRNYear>\n";
			
		}
		$ResponseXML .="</LoadPopUpDetails>";
		echo $ResponseXML;

}
if($Request=="SaveHeaderDetails")
{
	$TransferInNo 		= $_GET["TransferInNo"];
	$TransferInYear 	= $_GET["TransferInYear"];
	$GatePassNo 		= $_GET["GatePassNo"];
	$GatePassNoArray 	= explode('/',$GatePassNo);
	$remarks 			= $_GET["remarks"];
	
	$sql_header = "insert into bulk_gatepasstransferinheader 
					(
					intTransferInNo, 
					intTransferInYear, 
					intGatePassNo, 
					intGPYear, 
					dtmDate, 
					intUserid, 
					intStatus,  
					strRemarks, 
					intCompanyId
					)
					values
					(
					$TransferInNo,
					$TransferInYear,
					$GatePassNoArray[1],
					$GatePassNoArray[0],
					now(),
					$UserID,
					1,
					'$remarks',
					$companyId
					)";
	$result_header = $db->executeQuery($sql_header);
	
	if($result_header)
		echo "Header_Saved";
	else
		echo "Header_Error";
}
if ($Request=="SaveDetails")
{
	$TransferInNo   = $_GET["TransferInNo"];
	$TransferInYear = $_GET["TransferInYear"];	
	$MatDetailID    = $_GET["MatDetailID"];
	$Color          = $_GET["Color"];
	$Size           = $_GET["Size"];
	$Qty       	    = $_GET["Qty"];
	$Unit 	        = $_GET["Unit"];	
	$GatePassNo     = $_GET["GatePassNo"];
	$grnNo			= $_GET["grnNo"];
	$grnYear		= $_GET["grnYear"];
	$GPArray     	= explode('/',$GatePassNo);
	
	$sql_insertdetail = "insert into bulk_gatepasstransferindetails 
							(
							 intTransferInNo, 
							 intTransferInYear, 
							 intMatDetailId, 
							 strColor, 
							 strSize, 
							 dblQty,  
							 intGRNNo, 
							 intGRNYear, 
							 strUnit
							)
							values
							(
							$TransferInNo,
							$TransferInYear,
							$MatDetailID,
							'$Color',
							'$Size',
							$Qty,
							$grnNo,
							$grnYear,
							'$Unit'
							)";
	$result_detail = $db->executeQuery($sql_insertdetail);
	
	if($result_detail)
		echo "Detail_Saved";
	else
		echo "Detail_Error";
		
	$sqlUpDate ="update bulk_gatepassdetails 
					set
					dblBalQty =dblBalQty-$Qty 
					where
					intGatePassNo = '$GPArray[1]' and intGatePassYear = '$GPArray[0]' and intMatDetailId = '$MatDetailID' and strColor = '$Color' and strSize = '$Size' and intGrnNo = '$grnNo' and intGRNYear = '$grnYear' ;";
					
	$db->executeQuery($sqlUpDate);
	
}
if ($Request=="SaveBinDetails")
{
	$TransferInNo    	= $_GET["TransferInNo"];
	$TransferInYear     = $_GET["TransferInYear"];
	$MatDetailID   		= $_GET["MatDetailID"];
	$Color         		= $_GET["Color"];
	$Size          		= $_GET["Size"];
	$Unit         	 	= $_GET["Unit"];
	$MainStores   	 	= $_GET["MainStores"];
	$SubStores    	 	= $_GET["SubStores"];
	$Location     	 	= $_GET["Location"];
	$BinID         		= $_GET["BinID"];	
	$BinQty       		= $_GET["BinQty"];
	$SubCatID			= $_GET["SubCatID"];	
	$grnNo				= $_GET["grnNo"];
	$grnYear			= $_GET["grnYear"];
	$commonBin			= $_GET["commonBin"];
	
	if($commonBin==1)
	{
		$sqlCommon="select * from storesbins where strMainID='$MainStores' AND strSubID='$SubStores' AND intStatus=1 ;";	
		$resultCommon=$db->RunQuery($sqlCommon);
		while($rowCommon = mysql_fetch_array($resultCommon))
		{
			$Location		= $rowCommon["strLocID"];
			$BinID			= $rowCommon["strBinID"];
		}	
		
			$SQLbinAllo = " Select * from storesbinallocation
			where strMainID='$MainStores' and strSubID='$SubStores' and strLocID='$Location' and strBinID='$BinID' and intSubCatNo = '$SubCatID' ";			
			$resBinAllo = $db->CheckRecordAvailability($SQLbinAllo);			
			if($resBinAllo != '1')
			{
				$x = "INSERT INTO storesbinallocation(strMainID,strSubID,strLocID,strBinID,intSubCatNo,strUnit,intStatus,dblCapacityQty)
				VALUES($MainStores,$SubStores,$Location,$BinID,$SubCatID,'$Unit','1','10000000')";
				$x1 = $db->RunQuery($x);
			}
	}	
	$sqlbinallocation="update storesbinallocation 
						set 
						dblFillQty = dblFillQty+$BinQty 
						where 
						strMainID = '$MainStores' 
						and strSubID = '$SubStores' 
						and strLocID = '$Location' 
						and strBinID = '$BinID' 
						and intSubCatNo = '$SubCatID';";
	$db->executeQuery($sqlbinallocation);
	$StockSql="insert stocktransactions_bulk 
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
				 $TransferInYear,
				 $MainStores,
				 $SubStores,
				 $Location,
				 $BinID,
				 $TransferInNo,
				 $TransferInYear,
				 $MatDetailID,
				 '$Color',
				 '$Size',
				 'TI',
				 '$Unit',
				 $BinQty,
				 now(),
				 $UserID,
				 $grnNo,
				 $grnYear
				)";
		 	
	$result_stock = $db->executeQuery($StockSql);
	if($result_stock)
		echo "Stock_saved";
	else
		echo "Stock_erorr";
}
function getGatePassQty($GatePassNo,$GatePassYear,$MatDetailID,$Color,$Size,$grnNo,$grnYear)
{
			global $db;
						
			$SQLStock="SELECT 
						 Sum(BGD.dblQty) AS GatePassQtyQty 
						 FROM 
						 bulk_gatepassdetails AS BGD 
						 WHERE 
						 BGD.intGatePassNo =$GatePassNo AND 
						 BGD.intGatePassYear =$GatePassYear AND 
						 BGD.intMatDetailId =$MatDetailID AND 
						 BGD.strColor ='$Color' AND 
						 BGD.strSize ='$Size' and 
						 BGD.intGrnNo =$grnNo and  
						 BGD.intGRNYear =$grnYear
						 GROUP BY 
						 BGD.intMatDetailId, 
						 BGD.intGrnNo, 
						 BGD.intGRNYear, 
						 BGD.strColor, 
						 BGD.strSize;";
			
			$resultStock=$db->RunQuery($SQLStock);
			$rowcount = mysql_num_rows($resultStock);
			if ($rowcount > 0)
			{
				while($rowStock=mysql_fetch_array($resultStock))
				{
					return $rowStock["GatePassQtyQty"];
				}
			}
			else 
			{
				return 0;
			}
}


?>
