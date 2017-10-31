<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="LoadBuyetPoNo")
{
	$StyleID		=$_GET["StyleID"];
	
	$ResponseXML .="<LoadBuyetPoNo>\n";
	
	$SQL="SELECT DISTINCT strBuyerPONO
		from stocktransactions 
		where intStyleId='$StyleID'";
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{
		$buyerPoName	= $row["strBuyerPONO"];
		if($row["strBuyerPONO"]!="#Main Ratio#")
			$buyerPoName = getBuyerPOName($StyleID,$row["strBuyerPONO"]);
			
		 $ResponseXML .= "<BuyerPoNo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPoNo>\n";
		 $ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName  . "]]></BuyerPoName>\n";				
	}
	$ResponseXML .="</LoadBuyetPoNo>";
	echo $ResponseXML;
}	
elseif($RequestType=="LoadSubStores")
{
	$mainStores		= $_GET["mainStores"];
	$Status			= $_GET["Status"];
	
	$ResponseXML .="<LoadSubStores>\n";
	
	  $SQL="select strSubID,strSubStoresName,intCommonBin from substores join mainstores on substores.strMainID=mainstores.strMainID where substores.strMainID='$mainStores' AND substores.intStatus=1;";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<SubStoresName><![CDATA[" . $row["strSubStoresName"]  . "]]></SubStoresName>\n";		
		 $ResponseXML .= "<SubID><![CDATA[" . $row["strSubID"]  . "]]></SubID>\n";	
		 $ResponseXML .= "<CommonBin><![CDATA[" . $row["intCommonBin"]  . "]]></CommonBin>\n";	
	}
	$ResponseXML .="</LoadSubStores>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadSupplier")
{
	$StyleID		= $_GET["StyleID"];
	$buyerPoNo			= $_GET["BuyerPoNo"];
	
	$ResponseXML .="<LoadSupplier>\n";
	
	$SQL="SELECT DISTINCT ".
		"POH.strSupplierID, ".
		"SU.strTitle ".
		"FROM ".
		"grndetails AS GD ".
		"Inner Join grnheader AS GH ON GD.intGrnNo = GH.intGrnNo AND GD.intGRNYear = GH.intGRNYear ".
		"Inner Join purchaseorderheader AS POH ON POH.intPONo = GH.intPoNo AND POH.intYear = GH.intYear ".
		"Inner Join suppliers AS SU ON SU.strSupplierID = POH.strSupplierID ".
		"WHERE ".
		"GD.intStyleId =  '$StyleID' AND ".
		"GD.strBuyerPONO =  '$buyerPoNo' AND ".
		"GH.intCompanyID =  '$companyId';";

	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<SupplierId><![CDATA[" . $row["strSupplierID"]  . "]]></SupplierId>\n";		
		 $ResponseXML .= "<SupplierTitle><![CDATA[" . $row["strTitle"]  . "]]></SupplierTitle>\n";	
	}
	$ResponseXML .="</LoadSupplier>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadNo")
{		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
		$Sql="select intCompanyID,dblSRetToSupNo from syscontrol where intCompanyID='$companyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{	
					$Year = date('Y');		
					$No=$row["dblSRetToSupNo"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblSRetToSupNo='$NextNo' WHERE intCompanyID='$companyId';";				
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
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveHeader")
{
	$ReturnNo =$_GET["returnNo"];
	$ReturnYear =$_GET["returnYear"];
	$Remarks =$_GET["remarks"];	
	$ReturnBy =$_GET["returnBy"];
	$supplierID =$_GET["supplierID"];	
	
	$SQL= "insert into returntosupplierheader ".
		 "(intReturnToSupNo, ".
		 "intReturnToSupYear, ".
		 "intRetSupplierID, ".
		 "strRemarks, ".
		 "strReturnFrom, ". 
		 "intStatus, ".
		 "intRetUserId, ".
		 "dtmRetDate, ".
		 "intCompanyID) ".
		 "values ".
		 "('$ReturnNo', ".
		 "'$ReturnYear', ".
		 "'$supplierID', ".
		 "'$Remarks', ".
		 "'$ReturnBy', ". 
		 "'1', ".
		 "'$UserID', ". 
		 "now(), ".	 
		 "'$companyId');";
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveDetails")
{
	$ReturnNo 			= $_GET["returnNo"];
	$ReturnYear 		= $_GET["returnYear"];
	$StyleID 			= $_GET["styleID"];	
	$buyerPoNo 			= $_GET["buyerPoNo"];
	$itemDetailID 		= $_GET["itemDetailID"];	
	$color 				= $_GET["color"];
	$size 				= $_GET["size"];
	$units 				= $_GET["units"];
	$grnNo 				= $_GET["grnNo"];
		$grnNoArray		= explode('/',$grnNo);
	$qty 				= $_GET["Qty"];	
	$PoNo 				= $_GET["PoNo"];
		$PoNoArray		= explode('/',$PoNo);
	$isTempStock		= $_GET["isTempStock"];

	$sqlPoUpdade="update purchaseorderdetails ".
				 "set ".
				 "dblPending = dblPending + $qty ".
				 "where ".
				 "intPoNo = '$PoNoArray[1]' and ".
				 "intYear = '$PoNoArray[0]' and ".
				 "intStyleId = '$StyleID' and ".
				 "strBuyerPONO = '$buyerPoNo' and ".
				 "intMatDetailID = '$itemDetailID' and ".
				 "strColor = '$color' and ".
				 "strSize = '$size';";
	$db->executeQuery($sqlPoUpdade);
	
	$sqlGrnUpdade="update grndetails ".
				"set dblBalance =dblBalance-$qty ".
				"where ".
				"intGrnNo = '$grnNoArray[1]' and ".
				"intGRNYear = '$grnNoArray[0]' and ".
				"intStyleId = '$StyleID' and ".
				"strBuyerPONO = '$buyerPoNo' and ".
				"intMatDetailID = '$itemDetailID' and ".
				"strColor = '$color' and ".
				"strSize = '$size';";	
	$db->executeQuery($sqlGrnUpdade);
		
	$SQL="insert into returntosupplierdetails ".
		"(intReturnToSupNo, ".
		"intReturnToSupYear, ".
		"intGrnNo, ".
		"intGrnYear, ".
		"intStyleId, ".
		"strBuyerPoNo, ".
		"intMatdetailID, ".
		"strColor, ".
		"strSize, ".
		"intNotTrimInspect, ".
		"dblQty, ".
		"dblBalQty) ".
		"values ".
		"('$ReturnNo', ".
		"'$ReturnYear', ".
		"'$grnNoArray[1]', ".
		"'$grnNoArray[0]', ".
		"'$StyleID', ".
		"'$buyerPoNo', ".
		"'$itemDetailID', ".
		"'$color', ".
		"'$size', ".
		"$isTempStock, ".
		"'$qty', ".
		"'$qty')";		
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveBinDetails")
{
	$commonBin			= $_GET["commonBin"];
	
	$ReturnNo 			= $_GET["returnNo"];
	$ReturnYear 		= $_GET["returnYear"];	
	$StyleID			= $_GET["styleID"];
	$buyerPoNo 			= $_GET["buyerPoNo"];
	$itemDetailID 		= $_GET["itemDetailID"];
	$color 				= $_GET["color"];
	$size 				= $_GET["size"];
	$units 				= $_GET["units"];
	$binQty 			= $_GET["BinQty"];		
	$mainStoreId 		= $_GET["mainStoresId"];
	$subStoreId 		= $_GET["subStoreId"];
	$locationId 		= $_GET["locationId"];
	$binId 				= $_GET["binId"];
	$matSubCatId		= $_GET["matSubCatId"];		
	$grnNo				= $_GET["grnNo"];
	$grnNoArray			= explode('/',$grnNo);
	$isTempStock		= $_GET["isTempStock"];
	
if($commonBin==1)
{
	$sqlCommon="select * from storesbins where strMainID='$mainStoreId' AND strSubID='$subStoreId' AND intStatus=1 ;";
	
	$resultCommon=$db->RunQuery($sqlCommon);
	while($rowCommon = mysql_fetch_array($resultCommon))
	{
		$locationId		= $rowCommon["strLocID"];
		$binId			= $rowCommon["strBinID"];
	}	
	
}

 $sql="update storesbinallocation ".
	 "set ".
	 "dblFillQty = dblFillQty - $binQty ".
	 "where ".
	 "strMainID = '$mainStoreId' AND ".
	 "strSubID = '$subStoreId ' AND ".
	 "strLocID = '$locationId' AND ".
	 "strBinID = '$binId' AND ".
	 "intSubCatNo = '$matSubCatId';";
$db->executeQuery($sql);

	if($isTempStock==0)
	{
		$sqlbin="INSERT INTO  stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ($ReturnYear,'$mainStoreId','$subStoreId','$locationId','$binId','$StyleID','$buyerPoNo',$ReturnNo,$ReturnYear,$itemDetailID,'$color','$size','SRTSUP','$units',-$binQty,now(),$UserID,'$grnNoArray[1]','$grnNoArray[0]','S')";
		$db->executeQuery($sqlbin);
	}
	elseif($isTempStock==1)
	{
		$sqlbin="update stocktransactions_temp set dblQty=dblQty-$binQty where strMainStoresID=$mainStoreId and strSubStores=$subStoreId and strLocation=$locationId and strBin=$binId and intStyleId=$StyleID and strBuyerPoNo='$buyerPoNo' and intMatDetailId='$itemDetailID' and strColor='$color' and strSize='$size' and strType='GRN' and strUnit='$units' and intGrnNo='$grnNoArray[1]' and intGrnYear='$grnNoArray[0]' and strGRNType='S'";
		$db->executeQuery($sqlbin);
	}	
}
else if ($RequestType=="SaveValidate")
{
	$ReturnNo=$_GET["returnNo"];
	$ReturnYear =$_GET["returnYear"];
	$validateCount =$_GET["validateCount"];		
	$validateBinCount =$_GET["validateBinCount"];	
	
	$ResponseXML .="<SaveValidate>\n";
	
	$SQLHeder="SELECT COUNT(intReturnToSupNo) AS headerRecCount FROM returntosupplierheader where intReturnToSupNo=$ReturnNo AND intReturnToSupYear=$ReturnYear";
	
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
			
	$SQLDetail="SELECT COUNT(intReturnToSupNo) AS DetailsRecCount FROM returntosupplierdetails where intReturnToSupNo=$ReturnNo AND intReturnToSupYear=$ReturnYear";
	
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
		$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions where intDocumentNo=$ReturnNo AND intDocumentYear=$ReturnYear and strType='SRTSUP'";	

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
else if($RequestType=="LoadPopUpReturnNo")
{
global $db;
$state	= $_GET["state"];
$year	= $_GET["year"];
	
	$SQL="SELECT DISTINCT RTSH.intReturnToSupNo ".
		 "FROM returntosupplierheader AS RTSH ".
		 "INNER JOIN  returntosupplierdetails AS RTSD ".
		 "ON RTSH.intReturnToSupNo=RTSD.intReturnToSupNo AND RTSH.intReturnToSupYear=RTSD.intReturnToSupYear ".
		 "WHERE RTSH.intStatus='$state' AND  RTSH.intReturnToSupYear='$year'";
	
	$result=$db->RunQuery($SQL);
		$ResponseXML .= "<option value =\"".""."\">"."Select One"."</option>";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value =\"".$row["intReturnToSupNo"]."\">".$row["intReturnToSupNo"]."</option>";
	}
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpReturnYear")
{
global $db;
	$SQL = "SELECT DISTINCT intReturnToSupYear FROM returntosupplierheader ORDER BY intReturnToSupYear DESC;";	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value =\"".$row["intReturnToSupYear"]."\">".$row["intReturnToSupYear"]."</option>";
	}
	echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpHeaderDetails")
{
	$No 		= $_GET["No"];
	$Year		= $_GET["Year"];
	
	$ResponseXML .="<LoadPopUpHeaderDetails>\n";
	
	$SQL="SELECT CONCAT(RTSH.intReturnToSupYear,'/',RTSH.intReturnToSupNo) AS ReturnToSuplierNo, ".
		 "RTSH.intStatus, ".
		 "RTSH.dtmRetDate, ".
		 "RTSH.strRemarks, ".
		 "RTSH.intRetSupplierID ".
		 "FROM returntosupplierheader AS RTSH ".
		 "WHERE RTSH.intReturnToSupNo =  '$No' AND ".
		 "RTSH.intReturnToSupYear =  '$Year';";
	
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<ReturnNo><![CDATA[" . $row["ReturnToSuplierNo"] . "]]></ReturnNo>\n";					
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"] . "]]></Remarks>\n";						
				$Date =substr($row["dtmRetDate"],0,10);
				$NOArray=explode('-',$Date);
				$formatedDate=$NOArray[2]."/".$NOArray[1]."/".$NOArray[0];
			$ResponseXML .= "<formatedDate><![CDATA[" . $formatedDate . "]]></formatedDate>\n";
			$ResponseXML .= "<SupplierID><![CDATA[" . $row["intRetSupplierID"] . "]]></SupplierID>\n";			
		}
	
	$ResponseXML .="</LoadPopUpHeaderDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadStyleNames")
{
	$scNo 		= $_GET["scNo"];
	
	$ResponseXML .="<LoadStyleName>\n";
	
	$SQL="(SELECT DISTINCT O.strStyle
			FROM stocktransactions AS ST 			
			inner join orders O on O.intStyleId=ST.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
			WHERE MS.intCompanyId ='$companyId' 
			AND O.intStyleId = '$scNo'
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0)
			union 
			(SELECT DISTINCT O.strStyle
			FROM stocktransactions_temp AS ST 			
			inner join orders O on O.intStyleId=ST.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
			WHERE MS.intCompanyId ='$companyId'
			AND O.intStyleId = '$scNo'
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0)  order by strStyle";	
	 //echo $SQL;
	
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"] . "]]></strStyle>\n";						
		}
	
	$ResponseXML .="</LoadStyleName>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpDetails")
{
	$No =$_GET["No"];
	$Year =$_GET["Year"];

	$ResponseXML .="<LoadPopUpDetails>\n";
	
	$SQL="SELECT  ".
		 "RTSD.intGrnNo, ".
		 "RTSD.intGrnYear, ".
		 "RTSD.intStyleId,  ".
		 "RTSD.strBuyerPoNo,  ".
		 "RTSD.intMatdetailID,  ".
		 "RTSD.strColor, ".
		 "RTSD.strSize, ".
		 "RTSD.dblQty, ".
		 "RTSD.dblBalQty, ".
		 "RTSD.intNotTrimInspect, ".
		 "matitemlist.strItemDescription, ".
		 "matitemlist.strUnit, O.strStyle  ".
		 "FROM ".
		 "returntosupplierdetails AS RTSD ".
		 "Inner Join matitemlist ON RTSD.intMatdetailID = matitemlist.intItemSerial ".
		 "Inner join orders O ON O.intStyleId = RTSD.intStyleId  ".
		 "WHERE ".
		 "RTSD.intReturnToSupNo =  '$No' AND ".
		 "RTSD.intReturnToSupYear =  '$Year';";
	
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$GrnNo=$row["intGrnNo"];
			$GrnYear=$row["intGrnYear"];
			$StyleID=$row["intStyleId"];
			$BuyerPONO=$row["strBuyerPoNo"];
			$MatDetailID=$row["intMatdetailID"];
			$Color=$row["strColor"];
			$Size=$row["strSize"];
			
			if($BuyerPONO != '#Main Ratio#')
				$BuyerPONO = getBuyerPOName($StyleID,$row["strBuyerPoNo"]);
			$GrnQty		= getGrnQty($GrnNo,$GrnYear,$StyleID,$BuyerPONO,$MatDetailID,$Color,$Size);
			$StockBal	= GetStockBal($StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$row["intGrnNo"],$row["intGrnYear"],$row["intNotTrimInspect"]);
			
				$ResponseXML .= "<GrnNo><![CDATA[" . $row["intGrnNo"] . "]]></GrnNo>\n";
				$ResponseXML .= "<GrnYear><![CDATA[" . $row["intGrnYear"] . "]]></GrnYear>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";
				$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"] . "]]></StyleID>\n";
				$ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"] . "]]></StyleName>\n";
				$ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPoNo"] . "]]></BuyerPONO>\n";
				$ResponseXML .= "<BuyerPOName><![CDATA[" . $BuyerPONO . "]]></BuyerPOName>\n";
				$ResponseXML .= "<Color><![CDATA[" . $row["strColor"] . "]]></Color>\n";				
				$ResponseXML .= "<Size><![CDATA[" . $row["strSize"] . "]]></Size>\n";
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";			
				$ResponseXML .= "<Qty><![CDATA[" . round($row["dblQty"],2) . "]]></Qty>\n";
				$ResponseXML .= "<GrnQty><![CDATA[" . round($GrnQty,2) . "]]></GrnQty>\n";
				$ResponseXML .= "<StockBal><![CDATA[" . round($StockBal,2) . "]]></StockBal>\n";
				$ResponseXML .= "<MatDetailID><![CDATA[" . $row["intMatdetailID"] . "]]></MatDetailID>\n";
				$ResponseXML .= "<NotTrimInspect><![CDATA[" . $row["intNotTrimInspect"] . "]]></NotTrimInspect>\n";
					
		}
	$ResponseXML .="</LoadPopUpDetails>";
	echo $ResponseXML;
}
else if($RequestType=="CancelValidation")
{
	$No=$_GET["No"];
		$ReturnNoArray=explode('/',$No);
		
$ResponseXML .="<CancelValidation>\n";

$sql1="SELECT ".
		  "grnheader.intPoNo, ".
		  "grnheader.intYear, ".
		  "RSD.intStyleId, ".
		  "RSD.strBuyerPoNo, ".
		  "RSD.intMatdetailID, ".
		  "RSD.strColor, ".
		  "RSD.strSize, ".
		  "RSD.dblQty ".
		  "FROM ".
		  "returntosupplierdetails AS RSD ".
		  "Inner Join grnheader ON grnheader.intGrnNo = RSD.intGrnNo AND grnheader.intGRNYear = RSD.intGrnYear ".
		  "WHERE ".
		  "RSD.intReturnToSupNo =  '$ReturnNoArray[1]' AND ".
		  "RSD.intReturnToSupYear =  '$ReturnNoArray[0]'";
	
	$result1 = $db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{		
		$ReturnQty	=  $row1["dblQty"];
			
		$sql2="SELECT ".
			  "POD.dblPending, ".
			  "MIL.strItemDescription ".
			  "FROM ".
			  "purchaseorderdetails AS POD ".
			  "inner join matitemlist AS MIL  ON MIL.intItemSerial=POD.intMatDetailID ".
			  "WHERE ".
			  "POD.intPoNo ='".$row1["intPoNo"]."' AND ".
			  "POD.intYear ='".$row1["intYear"]."' AND ".
			  "POD.intStyleId ='".$row1["intStyleId"]."' AND ".
			  "POD.intMatDetailID ='".$row1["intMatdetailID"]."' AND ".
			  "POD.strColor ='".$row1["strColor"]."' AND ".
			  "POD.strSize ='".$row1["strSize"]."' AND ".
			  "POD.strBuyerPONO ='".$row1["strBuyerPoNo"]."';";
	//echo $sql2;
		$result2 = $db->RunQuery($sql2);
		while($row2=mysql_fetch_array($result2))
		{
			$PendingQty		= $row2["dblPending"];			
			$StyleID		= $row1["intStyleId"];
			$BuyerPoNo		= $row1["strBuyerPoNo"];
			$MatdetailID	= $row1["intMatdetailID"];
			$Color			= $row1["strColor"];
			$Size			= $row1["strSize"];
			$PoNo			= $row1["intYear"]."/".$row1["intPoNo"];
			
			if($ReturnQty <= $PendingQty)
			{					
				//$ResponseXML .= "<Cancel><![CDATA[TRUE]]></Cancel>\n";									
			}
			else
			{			
				$ResponseXML .= "<PoNo><![CDATA[" . $PoNo . "]]></PoNo>\n";			
				$ResponseXML .= "<StyleID><![CDATA[" . $StyleID . "]]></StyleID>\n";
				$ResponseXML .= "<BuyerPoNo><![CDATA[" . $BuyerPoNo . "]]></BuyerPoNo>\n";
				$ResponseXML .= "<Color><![CDATA[" . $Color . "]]></Color>\n";
				$ResponseXML .= "<Size><![CDATA[" . $Size . "]]></Size>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row2["strItemDescription"] . "]]></ItemDescription>\n";
				$ResponseXML .= "<ReturnQty><![CDATA[" . $ReturnQty . "]]></ReturnQty>\n";
				$ResponseXML .= "<PendingQty><![CDATA[" . $PendingQty . "]]></PendingQty>\n";
				$ResponseXML .= "<Cancel><![CDATA[FALSE]]></Cancel>\n";
			}
		}
	}
	
$ResponseXML .="</CancelValidation>";
echo $ResponseXML;
}
else if ($RequestType=="Cancel")
{
	$No=$_GET["No"];
		$ReturnNoArray=explode('/',$No);	
			
	$SqlUpdate ="update returntosupplierheader  ".
				"set intCancelUserID =$UserID, ".
				"dtmCancelDate = now(), ".
				"intStatus =10 ".	
				"where intReturnToSupNo =$ReturnNoArray[1] ".
				"AND intReturnToSupYear =$ReturnNoArray[0]";	
	$resultUpdate = $db->RunQuery($SqlUpdate);		
	
	$sql1="SELECT ".
		  "grnheader.intPoNo, ".
		  "grnheader.intYear, ".
		  "RSD.intStyleId, ".
		  "RSD.strBuyerPoNo, ".
		  "RSD.intMatdetailID, ".
		  "RSD.strColor, ".
		  "RSD.strSize, ".
		  "RSD.dblQty, ".
		  "RSD.intNotTrimInspect, ".
		  "RSD.intGrnNo, ".
		  "RSD.intGrnYear ".
		  "FROM ".
		  "returntosupplierdetails AS RSD ".
		  "Inner Join grnheader ON grnheader.intGrnNo = RSD.intGrnNo AND grnheader.intGRNYear = RSD.intGrnYear ".
		  "WHERE ".
		  "RSD.intReturnToSupNo =  '$ReturnNoArray[1]' AND ".
		  "RSD.intReturnToSupYear =  '$ReturnNoArray[0]'";	  
	$result1 = $db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{		
		$ReturnQty	=  $row1["dblQty"];
			
		$sql2="SELECT ".
			  "POD.dblPending ".
			  "FROM ".
			  "purchaseorderdetails AS POD ".
			  "WHERE ".
			  "POD.intPoNo ='".$row1["intPoNo"]."' AND ".
			  "POD.intYear ='".$row1["intYear"]."' AND ".
			  "POD.intStyleId ='".$row1["intStyleId"]."' AND ".
			  "POD.intMatDetailID ='".$row1["intMatdetailID"]."' AND ".
			  "POD.strColor ='".$row1["strColor"]."' AND ".
			  "POD.strSize ='".$row1["strSize"]."' AND ".
			  "POD.strBuyerPONO ='".$row1["strBuyerPoNo"]."';";
		
		$result2 = $db->RunQuery($sql2);
		while($row2=mysql_fetch_array($result2))
		{
			$PendingQty		= $row2["dblPending"];
			$PoNo			= $row1["intPoNo"];
			$PoYear			= $row1["intYear"];
			$StyleID		= $row1["intStyleId"];
			$BuyerPoNo		= $row1["strBuyerPoNo"];
			$MatdetailID	= $row1["intMatdetailID"];
			$Color			= $row1["strColor"];
			$Size			= $row1["strSize"];
			
			if($ReturnQty <= $PendingQty)
			{		
				PoQtyRevise($ReturnQty,$PoNo,$PoYear,$StyleID,$BuyerPoNo,$MatdetailID,$Color,$Size);						
			}		
		}
		//Start - 09-12-2010 - Revise not trim inspect qty in stock_temp table
		if($row1["intNotTrimInspect"]=='1')
		{
			ReviseTempStock($StyleID,$BuyerPoNo,$MatdetailID,$Color,$Size,$row1["intGrnNo"],$row1["intGrnYear"],$row1["dblQty"],'S');
		}
		//End - 09-12-2010 - Revise not trim inspect qty in stock_temp table
		
		//start 2011-05-06 update grn balance Qty 
		updateGRNdetails($StyleID,$BuyerPoNo,$MatdetailID,$Color,$Size,$ReturnQty,$row1["intGrnNo"],$row1["intGrnYear"]);	
		//end update grn balance Qty 
	}
	
	
	$sql ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin, ".
			"ST.intStyleId,ST.strBuyerPoNo,ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, ".
			"ST.strColor,ST.strSize,ST.strUnit,ST.dblQty,ST.intGrnNo,ST.intGrnYear  ".
			"FROM stocktransactions AS ST ".
			"WHERE ST.intDocumentNo =$ReturnNoArray[1] AND ST.intDocumentYear =$ReturnNoArray[0] AND strType='SRTSUP'";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$MainStores		= $row["strMainStoresID"];
		$SubStores		= $row["strSubStores"];
		$Location		= $row["strLocation"];
		$Bin			= $row["strBin"];
		$StyleNo		= $row["intStyleId"];
		$BuyerPoNo		= $row["strBuyerPoNo"];
		$DocumentNo		= $row["intDocumentNo"];
		$DocumentYear	= $row["intDocumentYear"];
		$MatDetailId	= $row["intMatDetailId"];
		$Color			= $row["strColor"];
		$Size			= $row["strSize"];
		$Unit			= $row["strUnit"];				
		$Qty 			= substr($row["dblQty"],1);		
		$grnNo 			= $row["intGrnNo"];
		$grnYear 		= $row["intGrnYear"];
		
		StockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$Qty,$UserID,$grnNo,$grnYear,'S');
		ReviseStockAllocation($MainStores,$SubStores,$Location,$Bin,$MatDetailId,$Qty);
		//comment on 2011-05-06 - do not update  grn details when items not trim inspected  
		//updateGRNdetails($StyleNo,$BuyerPoNo,$MatDetailId,$Color,$Size,$Qty,$grnNo,$grnYear);	
		//end comment		
	}	
	echo $resultUpdate;
}
elseif($RequestType=="ChangeGrnSaveStatus")
{
	$ReturnNo			= $_GET["No"];
		$ReturnNoArray	= explode('/',$ReturnNo);
	
	$sql="select distinct intGrnNo, intGrnYear from returntosupplierdetails ".
		 "where intReturnToSupNo='$ReturnNoArray[1]' AND intReturnToSupYear='$ReturnNoArray[0]';";
	
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$booCheck		= true;
		
		$sqlgrn="select dblQty from  grndetails where intGrnNo='".$row["intGrnNo"]."' AND intGRNYear ='".$row["intGrnYear"]."';";
		$resultgrn=$db->RunQuery($sqlgrn);
		
		while($rowgrn=mysql_fetch_array($resultgrn))
		{
			$dblQty = $rowgrn["dblQty"];
		
			if($dblQty<=0){
				$booCheck=false;				
			}
		}
		if($booCheck==false)
		{
			$sqlupdategrn = "update grnheader ".
						  	"set intStatus =10 ".
						  	"where	intGrnNo ='".$row["intGrnNo"]."' and ".
						  	"intGRNYear ='".$row["intGrnYear"]."';";
			
			$db->executeQuery($sqlupdategrn);
		}		
	}
	echo 1;
}
function getGrnQty($GrnNo,$GrnYear,$StyleID,$BuyerPONO,$MatDetailID,$Color,$Size)
{
			global $db;
			global $companyId;
			
			$SQLStock="SELECT ".
					"Sum(GD.dblQty) AS GrnQty ".
					"FROM ".
					"grndetails AS GD ".
					"WHERE ".
					"GD.intGrnNo =  '$GrnNo' AND ".
					"GD.intGRNYear =  '$GrnYear' AND ".
					"GD.intStyleId =  '$StyleID' AND ".
					"GD.strBuyerPONO =  '$BuyerPONO' AND ".
					"GD.intMatDetailID =  '$MatDetailID' AND ".
					"GD.strColor =  '$Color' AND ".
					"GD.strSize =  '$Size' ".
					"GROUP BY ".
					"GD.intStyleId, ".
					"GD.strBuyerPONO, ".
					"GD.intMatDetailID, ".
					"GD.strColor, ".
					"GD.strSize;";
			
			$resultStock=$db->RunQuery($SQLStock);
			$rowcount = mysql_num_rows($resultStock);
			if ($rowcount > 0)
			{
				while($rowStock=mysql_fetch_array($resultStock))
				{
					return $rowStock["GrnQty"];
				}
			}
			else 
			{
				return 0;
			}
}
	
function StockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$Qty,$UserID,$grnNo,$grnYear,$grnType)
{
global $db;
			
	$sqlInStock="INSERT INTO stocktransactions ".
		"(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
		"intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo, intGrnYear,strGRNType) VALUES ".
		"($DocumentYear,'$MainStores','$SubStores','$Location','$Bin','$StyleNo','$BuyerPoNo',$DocumentNo,$DocumentYear,$MatDetailId, ".
		"'$Color','$Size','CSRTSUP','$Unit',$Qty,now(),'$UserID','$grnNo','$grnYear','$grnType')";		
	$db->executeQuery($sqlInStock);
}
	
function PoQtyRevise($ReturnQty,$PoNo,$PoYear,$StyleID,$BuyerPoNo,$MatdetailID,$Color,$Size)
{
	global $db;
	
	$sqlPoQtyRevise = "update purchaseorderdetails ".
					"set ".
					"dblPending = dblPending - $ReturnQty ".
					"where ".
					"intPoNo = '$PoNo' and ".
					"intYear = '$PoYear' and ".
					"intStyleId = '$StyleID' and ".
					"strBuyerPONO = '$BuyerPoNo' and ".
					"intMatDetailID = '$MatdetailID' and ".
					"strColor = '$Color' and ".
					"strSize = '$Size';";				
		
	$db->executeQuery($sqlPoQtyRevise);
}
function GetStockBal($StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear,$notTrimInspect)
{
	global $db;
	global $companyId;
	$tableName = ($notTrimInspect=='0' ? "stocktransactions":"stocktransactions_temp");
	 $sqlInStock="SELECT ".
				"Sum(ST.dblQty) AS StockBal ".
				"FROM ".
				"$tableName AS ST ".
				"Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID ".
				"WHERE ".
				"ST.intStyleId =  '$StyleID' AND ".
				"ST.strBuyerPoNo =  '$BuyerPONO' AND ".
				"ST.intMatDetailId =  '$MatDetailID' AND ".
				"ST.strColor =  '$Color' AND ".
				"ST.strSize =  '$Size' AND ".
				"MS.intCompanyId = '$companyId' and intStatus=1 ". 
				"and intGrnNo='$grnNo' and intGrnYear='$grnYear' and ST.strGRNType='S'	".
				"GROUP BY ".
				"ST.intStyleId, ".
				"ST.strBuyerPoNo, ".
				"ST.intMatDetailId, ".
				"ST.strColor, ".
				"ST.strSize,ST.strGRNType";	
			
	$resultStock=$db->RunQuery($sqlInStock);
	$rowcount = mysql_num_rows($resultStock);
	if ($rowcount > 0)
	{
		while($row=mysql_fetch_array($resultStock))
		{			
			return $row["StockBal"];
		}
	}
	else 
	{
		return 0;
	}
}

function ReviseStockAllocation($MainStores,$SubStores,$Location,$Bin,$MatDetailId,$Qty)
{
global $db;
	$sql_allocation="select intSubCatID from matitemlist where intItemSerial='$MatDetailId'";
	$result_allocation=$db->RunQuery($sql_allocation);
	$row_allocation =mysql_fetch_array($result_allocation);
	
	$subCatId	= $row_allocation["intSubCatID"];
	
	$sqlbinallocation="update storesbinallocation ".
						"set ".
						"dblFillQty = dblFillQty+$Qty ".
						"where ".
						"strMainID = '$MainStores' ".
						"and strSubID = '$SubStores' ".
						"and strLocID = '$Location' ".
						"and strBinID = '$Bin' ".
						"and intSubCatNo = '$subCatId';";
	
	$db->executeQuery($sqlbinallocation);
}
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

function updateGRNdetails($StyleNo,$BuyerPoNo,$MatDetailId,$Color,$Size,$Qty,$grnNo,$grnYear)
{
global $db;
	$SQL = " update grndetails 
		set
		dblBalance = dblBalance + '$Qty' 
		where
		intGrnNo = '$grnNo' and intGRNYear = '$grnYear' and intStyleId = '$StyleNo'
		and strBuyerPONO = '$BuyerPoNo' and intMatDetailID = '$MatDetailId' and strColor = '$Color'
		and strSize = '$Size' ";
	$result=$db->RunQuery($SQL);
}

function ReviseTempStock($StyleID,$buyerPoNo,$itemDetailID,$color,$size,$grnNo,$grnYear,$qty,$grnType)
{
global $db;
$a 	= $qty;
	$sql="select dblQty,strMainStoresID,strSubStores,strLocation,strBin from stocktransactions_temp where intGrnNo=$grnNo and intGrnYear=$grnYear and intStyleId=$StyleID and strBuyerPoNo='$buyerPoNo' and intMatDetailId='$itemDetailID' and strColor='$color' and strSize='$size' and strGRNType='$grnType'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{		
		if($mainQty<=0)
		{
			$mainQty 	= $mainQty - $a;
			$qty		= $a;			
			UpdateTemp($qty,$grnNo,$grnYear,$StyleID,$buyerPoNo,$itemDetailID,$color,$size,$row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"],$grnType);
		}
	}
}

function UpdateTemp($qty,$docNo,$docYear,$orderId,$buyerPo,$matId,$Color,$Size,$mainId,$subId,$locationId,$binId,$grnType)
{
global $db;
	$sql="update stocktransactions_temp set dblQty = dblQty + $qty where intGrnNo='$docNo' and intGrnYear='$docYear' and intStyleId=$orderId and strBuyerPoNo='$buyerPo' and intMatDetailId=$matId and strColor='$Color' and strSize='$Size' and strtype='GRN' and  strMainStoresID=$mainId and strSubStores=$subId and strLocation=$locationId and strBin=$binId and strGRNType='$grnType' ";
	$result=$db->RunQuery($sql);
}
?>