<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
$companyId		= $_SESSION["FactoryID"];
$UserID			= $_SESSION["UserID"];

if($RequestType=="loadItem")
{
	$styleID = $_GET["styleID"];
	
	$ResponseXML  = "<XMLloadOrderNo>\n";
	
	$sql_load = "SELECT DISTINCT ST.intStyleId,round(Sum(ST.dblQty),2) AS dblQty,O.strOrderNo 
					 FROM stocktransactions_leftover AS ST INNER JOIN 
					 mainstores AS MS ON MS.strMainID = ST.strMainStoresID
					 INNER JOIN orders O ON O.intStyleId = ST.intStyleId
					 WHERE MS.intCompanyId ='$companyId' AND MS.intStatus=1";
	if($styleID!="")
		$sql_load.=" AND O.strStyle='$styleID' ";
		
	$sql_load.=" GROUP BY ST.intStyleId 
				 having dblQty>0
				 order by O.strOrderNo";
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value =\"".""."\">"."Select One"."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
		}
		$ResponseXML .= "</XMLloadOrderNo>\n";
		echo $ResponseXML;
}
if($RequestType=="loadSCNo")
{
	$styleID = $_GET["styleID"];
	
	$sql_load = "SELECT DISTINCT SP.intSRNO,SP.intStyleId,round(Sum(ST.dblQty),2) AS dblQty 
				 FROM stocktransactions_leftover AS ST INNER JOIN 
				 specification AS SP ON ST.intStyleId=SP.intStyleId 
				 Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID
				 inner join  orders O on O.intStyleId = SP.intStyleId and O.intStyleId = ST.intStyleId
				 WHERE MS.intCompanyId ='$companyId' ";
				 
	if($styleID!="")
			$sql_load.=" AND O.strStyle='$styleID' ";
			
	$sql_load.=" GROUP BY SP.intStyleId
				 having dblQty>0
				 order by SP.intSRNO desc ";
	
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value =\"".""."\">"."Select One"."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
		}
		$ResponseXML .= "</XMLloadOrderNo>\n";
		echo $ResponseXML;
}
if ($RequestType=="LoadSubStores")
{
	$MainStoresID=$_GET["MainStoreId"];
	
	$ResponseXML .="<LoadSubStores>\n";
	
	$SQLBin="SELECT strSubID,strSubStoresName FROM substores WHERE strMainID='$MainStoresID'";
	
	$result=$db->RunQuery($SQLBin);
	$str = '';
		while($row=mysql_fetch_array($result))
		{
			/* $ResponseXML .= "<SubID><![CDATA[" . $row["strSubID"]  . "]]></SubID>\n";
			 $ResponseXML .= "<SubStoresName><![CDATA[" . $row["strSubStoresName"]  . "]]></SubStoresName>\n";*/
			  $str .= "<option value=\"". $row["strSubID"] ."\">" . $row["strSubStoresName"] ."</option>";
		}
	$ResponseXML .= "<strSubID><![CDATA[" . $str  . "]]></strSubID>\n";
	$ResponseXML .="</LoadSubStores>";
	echo $ResponseXML;
}

else if($RequestType=='getCommonBin')
{
	$strMainStores		= $_GET["strMainStores"];
	
	$ResponseXML .="<LoadCommBin>\n";
	
	$SQL = " select intCommonBin from mainstores where strMainID=$strMainStores  and intStatus=1 ";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	$commBin =  $row["intCommonBin"];
	
	$ResponseXML .= "<commBin><![CDATA[" . $commBin . "]]></commBin>\n";
	$ResponseXML .="</LoadCommBin>";
	echo $ResponseXML;
	
}
else if($RequestType=="LoadGatePassDetails")
{
	$gatePassNo =$_GET["gatePassNo"];
	$GPNoArray=explode('/',$gatePassNo);
	
	$ResponseXML .="<LoadGatePassDetails>\n";
		
	$SQL="SELECT GPD.intStyleId,GPD.strBuyerPONO,GPD.intMatDetailId,GPD.strColor,GPD.strSize,GPD.dblQty,GPD.dblBalQty,intSubCatID,
		 strItemDescription,strUnit,O.strOrderNo, GPD.intGrnNo, GPD.intGRNYear,GPD.strGRNType 
		 FROM leftover_gatepassdetails AS GPD 
		 Inner Join matitemlist ON GPD.intMatDetailId = matitemlist.intItemSerial 
		 Inner join orders O on O.intStyleId= GPD.intStyleId 
		 WHERE GPD.intGatePassNo ='$GPNoArray[1]' AND GPD.intGPYear ='$GPNoArray[0]' AND GPD.dblBalQty >0";	
	$result=$db->RunQuery($SQL);
	
		while($row=mysql_fetch_array($result))
		{
			$unit=GetUnit($GPNoArray[1],$GPNoArray[0],$row["intStyleId"],$row["strBuyerPONO"],$row["intMatDetailId"],$row["strColor"],$row["strSize"]);
			$BpoName = $row["strBuyerPONO"];
			$styleId = $row["intStyleId"];
			if($row["strBuyerPONO"] !='#Main Ratio#')
				$BpoName = getBuyerPOName($styleId,$row["strBuyerPONO"]);
				
			$ResponseXML .="<StyleID><![CDATA[".$row["intStyleId"]."]]></StyleID>\n";
			$ResponseXML .="<StyleName><![CDATA[".$row["strOrderNo"]."]]></StyleName>\n";
			$ResponseXML .="<BuyerPoNO><![CDATA[".$row["strBuyerPONO"]."]]></BuyerPoNO>\n";
			$ResponseXML .="<BuyerPoName><![CDATA[".$BpoName."]]></BuyerPoName>\n";
			$ResponseXML .="<MatDetailID><![CDATA[".$row["intMatDetailId"]."]]></MatDetailID>\n";
			$ResponseXML .="<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
			$ResponseXML .="<Color><![CDATA[".$row["strColor"]."]]></Color>\n";
			$ResponseXML .="<Size><![CDATA[".$row["strSize"]."]]></Size>\n";
			$ResponseXML .="<Unit><![CDATA[".$unit."]]></Unit>\n";
			$ResponseXML .="<Qty><![CDATA[".round($row["dblBalQty"],2)."]]></Qty>\n";
			$ResponseXML .="<SubCatID><![CDATA[".$row["intSubCatID"]."]]></SubCatID>\n";
			$ResponseXML .="<GRNno><![CDATA[".$row["intGrnNo"]."]]></GRNno>\n";
			$ResponseXML .="<GRNYear><![CDATA[".$row["intGRNYear"]."]]></GRNYear>\n";
			$ResponseXML .="<GRNTypeId><![CDATA[".$row["strGRNType"]."]]></GRNTypeId>\n";
			if($row["strGRNType"]=='B')
				$grnType	= 'Bulk';
			else if($row["strGRNType"]=='S')
				$grnType	= 'Style';
			$ResponseXML .="<GRNType><![CDATA[".$grnType."]]></GRNType>\n";
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
else if($RequestType=="ShowSubCatName")
{
	$subCatID =$_GET["subCatID"];
	
	$ResponseXML .="<ShowSubCatName>\n";
		
	$SQL ="select distinct StrCatName from  matsubcategory ".
			 "where intSubCatNo ='$subCatID'";
		
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<SubCatName><![CDATA[".$row["StrCatName"]."]]></SubCatName>\n";
		}	

	$ResponseXML .="</ShowSubCatName>";
	echo $ResponseXML;
}
else if($RequestType=="LoadBinDetails")
{
	$mainStoreID =$_GET["mainStoreID"];
	$subStores =$_GET["subStores"];	
	$locationID =$_GET["locationID"];
	$subCatID =$_GET["subCatID"];
	
	$ResponseXML .="<LoadBinDetails>\n";
		
	/*$SQL="SELECT strMainID,strSubID,strLocID,strBinID,strUnit,intSubCatNo, ".
			 "Sum(dblCapacityQty)-Sum(dblFillQty) as AvalableQty  ".
			 "FROM storesbinallocation AS SBA ".
			 "WHERE intSubCatNo ='$subCatID' AND strMainID ='$mainStoreID' AND strSubID ='$subStores' AND strLocID='$locationID'".
			 "GROUP BY strMainID,strSubID,strLocID,strBinID,intSubCatNo";
	echo $SQL;*/
	
	//LAST edited query
	/*$SQL="SELECT strMainID, ".
	"(select strName from mainstores MS where MS.strMainID=SBA.strMainID)AS mainStoreName, ".
	"strSubID, ".
	"(select strSubStoresName from substores SS where SS.strSubID=SBA.strSubID)AS subStoreName, ".
	"strLocID, ".
	"(select strLocName from storeslocations SL where SL.strLocID=SBA.strLocID)AS locationName, ".
	"strBinID, ".
	"(select strBinName from storesbins SB where SB.strBinID=SBA.strBinID)AS binName, ".
	"strUnit,intSubCatNo, ".
	"Sum(dblCapacityQty)-Sum(dblFillQty) as AvalableQty  FROM storesbinallocation AS SBA ".
	"WHERE intSubCatNo ='$subCatID' ".
	"AND strMainID ='$mainStoreID' ".
	"AND strSubID ='$subStores' ".
	//"AND strLocID='$locationID' ".
	"GROUP BY strMainID,strSubID,strLocID,strBinID,intSubCatNo";*/
	
	$SQL= "SELECT strMainID,
		 (select strName from mainstores MS where MS.strMainID=SBA.strMainID)AS mainStoreName, strSubID,
		 (select strSubStoresName from substores SS where SS.strSubID=SBA.strSubID AND SS.strMainID = SBA.strMainID)AS subStoreName, strLocID,
		 (select strLocName from storeslocations SL where SL.strLocID=SBA.strLocID AND SL.strMainID = SBA.strMainID AND SL.strSubID=SBA.strSubID)AS locationName, strBinID, 
		(select strBinName from storesbins SB where SB.strBinID=SBA.strBinID AND SB.strLocID=SBA.strLocID AND SB.strMainID = SBA.strMainID AND SB.strSubID=SBA.strSubID)AS binName, strUnit,intSubCatNo,
		 Sum(dblCapacityQty)-Sum(dblFillQty) as AvalableQty  
		FROM storesbinallocation AS SBA 
		WHERE SBA.intSubCatNo ='$subCatID' AND SBA.strMainID ='$mainStoreID' AND SBA.strSubID ='$subStores' 
		GROUP BY strMainID,strSubID,strLocID,strBinID,intSubCatNo";
	$result=$db->RunQuery($SQL);
	
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .="<MainStoresID><![CDATA[".$row["strMainID"]."]]></MainStoresID>\n";
			$ResponseXML .="<SubStoresID><![CDATA[".$row["strSubID"]."]]></SubStoresID>\n";
			$ResponseXML .="<LocationID><![CDATA[".$row["strLocID"]."]]></LocationID>\n";
			$ResponseXML .="<BinID><![CDATA[".$row["strBinID"]."]]></BinID>\n";
			$ResponseXML .="<AvalableQty><![CDATA[".round($row["AvalableQty"],2)."]]></AvalableQty>\n";
			$ResponseXML .="<MainStoresName><![CDATA[".$row["mainStoreName"]."]]></MainStoresName>\n";
			$ResponseXML .="<SubStoresName><![CDATA[".$row["subStoreName"]."]]></SubStoresName>\n";
			$ResponseXML .="<LocationName><![CDATA[".$row["locationName"]."]]></LocationName>\n";
			$ResponseXML .="<BinName><![CDATA[".$row["binName"]."]]></BinName>\n";
		}	

	$ResponseXML .="</LoadBinDetails>";
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
		
	$SQL= "insert into leftover_gatepasstransferin_header 
			(intTransferInNo, 
			intTINYear, 
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
			$transferIn,
			$transferInYear,
			$GatePassNoArray[1],
			$GatePassNoArray[0],
			now(),
			$UserID,
			1,
			'$remarks',
			$companyId
			)";		
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveDetails")
{
$transferIn     = $_GET["transferIn"];
$transferInYear = $_GET["transferInYear"];	
$MatDetailID    = $_GET["MatDetailID"];
$Color          = $_GET["Color"];
$Size           = $_GET["Size"];
$BuyerPoNO      = $_GET["BuyerPoNO"];
$Qty       	    = $_GET["Qty"];
$StyleID 	    = $_GET["StyleID"];	
$GatePassNo     = $_GET["GatePassNo"];
$grnNo			= $_GET["grnNo"];
$grnYear		= $_GET["grnYear"];
$GPArray     	= explode('/',$GatePassNo);
$grnType		= $_GET["GRNType"];
	
	$sqlHeader ="insert into leftover_gatepasstransferin_details 
					(intTransferInNo, 
					intTINYear, 
					intStyleId, 
					strBuyerPONO, 
					intMatDetailId, 
					strColor, 
					strSize, 
					dblQty,  
					intGrnNo, 
					intGRNYear, 
					strGRNType
					)
					values
					(
					$transferIn,
					$transferInYear,
					'$StyleID',
					'$BuyerPoNO',
					'$MatDetailID',
					'$Color',
					'$Size',
					$Qty,
					$grnNo,
					$grnYear,
					'$grnType'
					)";			
	$db->executeQuery($sqlHeader);
	
	$sqlUpDate ="UPDATE leftover_gatepassdetails SET dblBalQty=dblBalQty-$Qty WHERE intGatePassNo=$GPArray[1] AND intGPYear=$GPArray[0] AND intStyleId='$StyleID' AND strBuyerPONO='$BuyerPoNO' AND intMatDetailId = $MatDetailID AND strColor ='$Color' AND strSize='$Size' and intGrnNo='$grnNo' and  intGRNYear='$grnYear' and strGRNType='$grnType'";
	
	$db->executeQuery($sqlUpDate);
}
else if ($RequestType=="SaveBinDetails")
{
$transferIn    	= $_GET["transferIn"];
$InYear        	= $_GET["transferInYear"];
$StyleID       	= $_GET["StyleID"];
$BuyerPoNO     	= $_GET["BuyerPoNO"];
$MatDetailID   	= $_GET["MatDetailID"];
$Color         	= $_GET["Color"];
$Size          	= $_GET["Size"];
$Unit          	= $_GET["Unit"];
$MainStores    	= $_GET["MainStores"];
$SubStores     	= $_GET["SubStores"];
$Location      	= $_GET["Location"];
$BinID         	= $_GET["BinID"];	
$BinQty       	= $_GET["BinQty"];
$SubCatID		= $_GET["SubCatID"];	
$grnNo			= $_GET["grnNo"];
$grnYear		= $_GET["grnYear"];
$commonBin		= $_GET["commonBin"];
$grnType		= $_GET["GRNType"];
	
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
		
$sqlbinallocation="update storesbinallocation ".
					"set ".
					"dblFillQty = dblFillQty+$BinQty ".
					"where ".
					"strMainID = '$MainStores' ".
					"and strSubID = '$SubStores' ".
					"and strLocID = '$Location' ".
					"and strBinID = '$BinID' ".
					"and intSubCatNo = '$SubCatID';";
$db->executeQuery($sqlbinallocation);

	$binSql="insert into stocktransactions_leftover 
				(
				intYear, 
				strMainStoresID, 
				strSubStores, 
				strLocation, 
				strBin, 
				intStyleId, 
				strBuyerPoNo, 
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
				intGrnNo, 
				intGrnYear, 
				strGRNType 
				)
				values
				(
				$InYear,
				'$MainStores',
				'$SubStores',
				'$Location',
				'$BinID',
				'$StyleID',
				'$BuyerPoNO',
				'$transferIn',
				'$InYear',
				'$MatDetailID',
				'$Color',
				'$Size',
				'LTI',
				'$Unit',
				$BinQty,
				now(),
				$UserID,
				$grnNo,
				$grnYear,
				'$grnType'
				)";
	$db->executeQuery($binSql);
}
else if ($RequestType=="ResponseValidate")
{
	$TransferIn       =$_GET["transferIn"];
	$Year             =$_GET["transferInYear"];
	$validateCount    =$_GET["validateCount"];
	$validateBinCount =$_GET["validateBinCount"];	
	
	$ResponseXML .="<ResponseValidate>\n";
	
	$SQLHeder="SELECT COUNT(intTransferInNo) AS headerRecCount FROM leftover_gatepasstransferin_header where intTransferInNo=$TransferIn AND intTINYear=$Year";
	
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
			
	$SQLDetail="SELECT COUNT(intTransferInNo) AS DetailsRecCount FROM leftover_gatepasstransferin_details where intTransferInNo=$TransferIn AND intTINYear=$Year";
	
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
	$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions_leftover where intDocumentNo=$TransferIn AND intDocumentYear=$Year AND strType='LTI'";	

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
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
		
	
	$ResponseXML .="</ResponseValidate>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpTransIn")
{
$state	= $_GET["state"];
$year	= $_GET["year"];

$ResponseXML.="<LoadPopUpTransIn>";

	$SQL="SELECT DISTINCT GP.intTransferInNo 
		 FROM leftover_gatepasstransferin_header AS GP 
		 INNER JOIN leftover_gatepasstransferin_details AS GPD 
		 ON GP.intTransferInNo=GPD.intTransferInNo AND GP.intTINYear=GPD.intTINYear 
		 WHERE GP.intStatus='$state' AND GP.intTINYear='$year' and GP.intCompanyId='$companyId' 
		 order by GP.intTransferInNo";	
	$result=$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"". "0" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intTransferInNo"] ."\">" . $row["intTransferInNo"] ."</option>" ;
	}
$ResponseXML.="</LoadPopUpTransIn>";
echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpHeaderDetails")
{
	$No 		= $_GET["No"];
	$Year		= $_GET["Year"];
	
	$ResponseXML .="<LoadPopUpHeaderDetails>\n";
	
	$SQL="SELECT CONCAT(GTIH.intTINYear,'/',GTIH.intTransferInNo) AS GpTranferNo, 
		 CONCAT(GTIH.intGPYear,'/',GTIH.intGatePassNo) AS GatePassNo, 
		 GTIH.intStatus, 
		 GTIH.dtmDate, 
		 GTIH.strRemarks 		 
		 FROM leftover_gatepasstransferin_header AS GTIH 
		 WHERE GTIH.intTransferInNo =  '$No' AND 
		 GTIH.intTINYear =  '$Year';";
	
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
			$ResponseXML .= "<formatedDate><![CDATA[" . $formatedDate . "]]></formatedDate>\n";
			//$ResponseXML .= "<SupplierID><![CDATA[" . $row["intRetSupplierID"] . "]]></SupplierID>\n";			
		}
	$ResponseXML .="</LoadPopUpHeaderDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpDetails")
{
$No 	= $_GET["No"];
$Year 	= $_GET["Year"];

$ResponseXML .="<LoadPopUpDetails>\n";
	
	$SQL="SELECT  
			 CONCAT(GTIH.intGPYear,'/',GTIH.intGatePassNo)AS GatePassNo, 	
			 GTID.intStyleId,  
			 GTID.strBuyerPONO,  
			 GTID.intMatDetailId,  
			 GTID.strColor, 
			 GTID.strSize, 
			 GTID.dblQty, 		  
			 MIL.strItemDescription, 
			 MIL.strUnit, O.strStyle,
			 GTID.intGrnNo, GTID.intGRNYear, 
			 GTID.strGRNType 
			 FROM 
			 leftover_gatepasstransferin_details AS GTID 
			 Inner Join matitemlist AS MIL ON GTID.intMatDetailId = MIL.intItemSerial 
			 Inner Join leftover_gatepasstransferin_header AS GTIH ON 
			 GTIH.intTransferInNo=GTID.intTransferInNo and GTID.intTINYear=GTIH.intTINYear 
			 Inner join orders O on  O.intStyleId = GTID.intStyleId
			 WHERE 
			 GTID.intTransferInNo ='$No' AND 
			 GTID.intTINYear ='$Year';";	
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{			
			$GatePassNo			= $row["GatePassNo"];
			$GatePassNoArray	= explode('/',$GatePassNo);			
			$StyleID			= $row["intStyleId"];
			$styleName 			= $row["strStyle"];
			$BuyerPONO			= $row["strBuyerPONO"];
			$MatDetailID		= $row["intMatDetailId"];
			$Color				= $row["strColor"];
			$Size				= $row["strSize"];
			$StyleName 			= $row["strSize"];
			$grnNo 				= $row["intGrnNo"];
			$grnYear 			= $row["intGRNYear"];
			
			$GatePassQty=getGatePassQty($GatePassNoArray[1],$GatePassNoArray[0],$StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear);		
			if($row["strBuyerPONO"] != '#Main Ratio#')
				$BuyerPONO = getBuyerPOName($StyleID,$row["strBuyerPONO"]);
							
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";
				$ResponseXML .= "<StyleID><![CDATA[" . $StyleID . "]]></StyleID>\n";
				$ResponseXML .= "<StyleName><![CDATA[" . $styleName . "]]></StyleName>\n";
				$ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"] . "]]></BuyerPONO>\n";	
				$ResponseXML .= "<BuyerPOName><![CDATA[" . $BuyerPONO . "]]></BuyerPOName>\n";							
				$ResponseXML .= "<Color><![CDATA[" . $Color . "]]></Color>\n";				
				$ResponseXML .= "<Size><![CDATA[" . $Size . "]]></Size>\n";
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";			
				$ResponseXML .= "<Qty><![CDATA[" . round($row["dblQty"],2) . "]]></Qty>\n";
				$ResponseXML .= "<GatePassQty><![CDATA[" . $GatePassQty . "]]></GatePassQty>\n";
				$ResponseXML .= "<GRNno><![CDATA[" . $grnNo . "]]></GRNno>\n";
				$ResponseXML .= "<GRNyear><![CDATA[" . $grnYear . "]]></GRNyear>\n";
				$ResponseXML .= "<GRNTypeId><![CDATA[" . $row["strGRNType"] . "]]></GRNTypeId>\n";			
				if($row["strGRNType"]=='B')
					$grnType	= 'Bulk';
				elseif($row["strGRNType"]=='S')
					$grnType	= 'Style';
				$ResponseXML .="<GRNType><![CDATA[".$grnType."]]></GRNType>\n";
		}
$ResponseXML .="</LoadPopUpDetails>";
echo $ResponseXML;
}
else if ($RequestType=="getGPNolist")
{
	$styleId =$_GET["styleId"];
	
	$ResponseXML .="<loadGPlist>\n";
	
		$SQL= "SELECT DISTINCT CONCAT(GP.intGPYear,'/',GP.intGatePassNo) AS GatePassNo FROM leftover_gatepass AS GP 
			Inner Join leftover_gatepassdetails AS GPD ON GPD.intGatePassNo = GP.intGatePassNo AND GP.intGPYear = GPD.intGPYear 
			Inner Join mainstores AS MS ON GP.strDestination = MS.strMainID 
			WHERE GP.intStatus =1 AND 	
			GPD.dblBalQty >0 AND MS.intCompanyId ='$companyId'";
		
		if($styleId != '')	
		$SQL .=" and GPD.intStyleId in ($styleId) ";
		
		$SQL .= " union 
			select DISTINCT CONCAT(GP1.intGPYear,'/',GP1.intGatePassNo) AS GatePassNo FROM leftover_gatepass AS GP1 
			Inner Join leftover_gatepassdetails AS GPD ON GPD.intGatePassNo = GP1.intGatePassNo AND GP1.intGPYear = GPD.intGPYear 
			where GP1.intStatus =1 and GP1.intCompany='$companyId'  and GPD.dblBalQty >0";
			
		if($styleId != '')	
		$SQL .=" and GPD.intStyleId in ($styleId) ";
			
	    $SQL .=" order by GatePassNo desc ";
		
		$result =$db->RunQuery($SQL);
		
		$ResponseXML .= "<option value =\"".""."\">"."Select One"."</option>";
		
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=\"". "" ."\">".$row["GatePassNo"]."</option>";	
		}
	$ResponseXML .="</loadGPlist>";
	echo $ResponseXML;
}
if($RequestType=='checkBinavailabiltyforSubcat')
{
	
	$ResponseXML = '';
	$strMainStores = $_GET["strMainStores"];
	$strSubStores = $_GET["strSubStores"];
	$pub_location = $_GET["pub_location"];
	$pub_bin = $_GET["pub_bin"];
	$mainCatNo = $_GET["mainCatNo"];
	
	$sql = "select * from storesbinallocation
	where strMainID='$strMainStores' and strSubID='$strSubStores' and strLocID='$pub_location' and 
	strBinID='$pub_bin' and intSubCatNo='$mainCatNo' and intStatus=1 ";
	
	$res = $db->CheckRecordAvailability($sql);
	//echo $sql;
	
	$ResponseXML .= "<binAvforSubcat>";
	$ResponseXML .= "<binResult><![CDATA[" . $res  . "]]></binResult>\n";
	$ResponseXML .= "</binAvforSubcat>";
	
	echo $ResponseXML;
}

function getGatePassQty($GatePassNo,$GatePassYear,$StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear)
{
			global $db;
						
			$SQLStock="SELECT 
						 Sum(GD.dblBalQty) AS GatePassQtyQty 
						 FROM
						 leftover_gatepassdetails AS GD 
						 WHERE 
						 GD.intGatePassNo ='$GatePassNo' AND 
						 GD.intGPYear ='$GatePassYear' AND 
						 GD.intStyleId ='$StyleID' AND 
						 GD.strBuyerPONO ='$BuyerPONO' AND 
						 GD.intMatDetailId ='$MatDetailID' AND 
						 GD.strColor ='$Color' AND 
						 GD.strSize ='$Size' and 
						 GD.intGrnNo ='$grnNo' and  GD.intGRNYear ='$grnYear' 
						 GROUP BY 
						 GD.intStyleId, 
						 GD.strBuyerPONO, 
						 GD.intMatDetailId, 
						 GD.strColor, 
						 GD.strSize;";
			
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
function GetUnit($gatePassNo,$gatePassYear,$styleId,$buyerPoNo,$matDetailsId,$color,$size)
{
	global $db;
	$sqlunit="select strUnit from stocktransactions_leftover 
			where intDocumentNo='$gatePassNo' 
			and intDocumentYear='$gatePassYear' 
			and intStyleId='$styleId' 
			and strBuyerPoNo ='$buyerPoNo' 
			and intMatDetailId ='$matDetailsId' 
			and strColor ='$color' 
			and strSize ='$size'";
			$result_unit = $db->RunQuery($sqlunit);
			while($row_unit=mysql_fetch_array($result_unit))
			{
				return $row_unit["strUnit"];
			}
}

function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

function getGetPassTrnsferInNo()
{
	global $companyId;
	global $db; 

	$strSQL="update syscontrol set  dblLeftOverTransferIn= dblLeftOverTransferIn+1 WHERE syscontrol.intCompanyID='$companyId'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblLeftOverTransferIn FROM syscontrol WHERE syscontrol.intCompanyID='$companyId'";
	$result=$db->RunQuery($strSQL);
	$GPNo = 'NA';
	while($row = mysql_fetch_array($result))
	 {
		$GPNo  =  $row["dblLeftOverTransferIn"] ;
		break;
	 }
	return $GPNo;
}
?>