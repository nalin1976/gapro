<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];
if ($RequestType=="LoadInternalDestination")
{
	$ResponseXML .="<LoadInternalDestination>\n";
	$SQL="SELECT strMainID,strName FROM mainstores WHERE intStatus=1";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<MainID><![CDATA[" . $row["strMainID"]  . "]]></MainID>\n";
		 $ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
	}
	$ResponseXML .="</LoadInternalDestination>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadExternalDestinationRequest")
{
	$ResponseXML .="<LoadExternalDestinationRequest>\n";
	$SQL="SELECT strSubContractorID,strName FROM subcontractors WHERE intStatus=1";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<SubContractorID><![CDATA[" . $row["strSubContractorID"]  . "]]></SubContractorID>\n";
		 $ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
	}
	$ResponseXML .="</LoadExternalDestinationRequest>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadBuyetPoNo")
{
	$styleId=$_GET["styleId"];
	$ResponseXML .="<LoadBuyetPoNo>\n";
	
	$SQL = "SELECT DISTINCT S.strBuyerPoNo,S.intStyleId 
			FROM stocktransactions S 
			WHERE S.intStyleId='$styleId' ORDER BY S.strBuyerPoNo";
	$result=$db->RunQuery($SQL);
	while ($row=mysql_fetch_array($result))
	{
		$buyerPONO	 = $row["strBuyerPoNo"];
		$styleid	 = $row["intStyleId"];
		$buyerPoName = $row["strBuyerPoNo"];
		
		if($buyerPONO != '#Main Ratio#')
				$buyerPoName = getBuyerPOName($styleid,$buyerPONO);
					
		$ResponseXML .= "<BuyerPoNo><![CDATA[" . $buyerPONO  . "]]></BuyerPoNo>\n";	
		$ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName  . "]]></BuyerPoName>\n";			
	}
	$ResponseXML .="</LoadBuyetPoNo>";
	echo $ResponseXML;
}
else if($RequestType=="LoadDetails")
{
	$styleId		= $_GET["StyleId"];
	$buyerPONO		= $_GET["BuyerPONO"];
	$mainStoreId	= $_GET["mainStoreId"];

	$ResponseXML .="<LoadDetails>\n";
		$SQL = "SELECT ST.intStyleId,ST.strBuyerPoNo,ST.intMatDetailId,ST.strColor,ST.strSize,SUM(dblQty) as dblQty,MIL.strItemDescription,
		strDescription,ST.strUnit,intGrnNo,intGrnYear,strGRNType
		FROM stocktransactions AS ST INNER JOIN matitemlist AS MIL ON ST.intMatDetailId=MIL.intItemSerial 
		INNER JOIN matmaincategory AS MMC ON MIL.intMainCatID=intID Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
		WHERE intStyleId='$styleId' AND strBuyerPoNo ='$buyerPONO' AND MS.intCompanyId ='$companyId' and MS.intStatus=1 and MS.strMainID='$mainStoreId'
		GROUP BY intStyleId,strBuyerPONO,intMatDetailID,strColor,strSize,intGrnNo,intGrnYear,strGRNType
		having SUM(dblQty)>0
		ORDER BY MIL.intMainCatID,MIL.strItemDescription,ST.strColor,ST.strSize,intGrnNo,intGrnYear ";
		
	$result=$db->RunQuery($SQL);	
	
	while ($row=mysql_fetch_array($result))
	{
		$dblStockQty 	= $row["dblQty"];				
		$matDetailId	= $row["intMatDetailId"];
		$color			= $row["strColor"];
		$size			= $row["strSize"];
		$grnNo 			= $row["intGrnNo"];
		$grnYear 		= $row["intGrnYear"];
		$grnTy 			= $row["strGRNType"];
		
		/* Start 17-12-2010 - Rejected qty not going to stocktransaction		
		$rejectQty 		= GetRejectQty($styleId,$buyerPONO,$matDetailId,$color,$size,$grnNo,$grnYear);	
		 End 17-12-2010 - Rejected qty not going to stocktransaction */
		 
		$mrnBalance		= GetmrnBalance($styleId,$buyerPONO,$matDetailId,$color,$size,$grnNo,$grnYear,$mainStoreId,$grnTy);
		//$actualQty=$dblStockQty-$rejectQty-$mrnBalance;
		$actualQty=$dblStockQty-$mrnBalance;
		
		if ($actualQty>=0)
		{	
			$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]. "]]></Description>\n";
			$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]. "]]></ItemDescription>\n";
			$ResponseXML .= "<MatDetailId><![CDATA[" . $row["intMatDetailId"]. "]]></MatDetailId>\n";
			$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]. "]]></Color>\n";
			$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]. "]]></Size>\n";
			$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]. "]]></Unit>\n";
			$ResponseXML .= "<actualQty><![CDATA[" . round($actualQty,3). "]]></actualQty>\n";
			$ResponseXML .= "<GRNno><![CDATA[" . $grnNo. "]]></GRNno>\n";
			$ResponseXML .= "<GRNYear><![CDATA[" . $grnYear . "]]></GRNYear>\n";
			$ResponseXML .= "<GRNTypeId><![CDATA[" . $row["strGRNType"] . "]]></GRNTypeId>\n";
			if($row["strGRNType"]=='B')
				$grnType = 'Bulk';
			elseif($row["strGRNType"]=='S')
				$grnType = 'Style';				
			$ResponseXML .= "<GRNType><![CDATA[" . $grnType . "]]></GRNType>\n";
		}		
	}
	
	$ResponseXML .= "</LoadDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadBinDetails")
{
$styleId 		= $_GET["styleId"];
$buyerPo 		= $_GET["buyerPoNo"];
$matDetailId 	= $_GET["matDetailId"];
$color 			= $_GET["color"];
$size 			= $_GET["size"];
$mainStore 		= $_GET["mainStore"];
$grnNo 			= $_GET["GrnNo"];
$grnYear 		= $_GET["GrnYear"];
$grnType 		= $_GET["GrnType"];

	$ResponseXML .="<LoadBinDetails>\n";
	
	$SQL="SELECT ST.strMainStoresID, ".
		 "MS.strName, ".
		 "ST.strSubStores, ".
		 "SS.strSubStoresName, ".
		 "ST.strLocation, ".
		 "SL.strLocName, ".
		 "ST.strBin, ".
		 "SB.strBinName, ".
		 "MIL.intSubCatID, ".
		 "Sum(ST.dblQty) AS stockBal ".
		 "FROM stocktransactions AS ST ".
		 "Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID  ".
		 "Inner Join substores SS on SS.strSubID=ST.strSubStores and SS.strMainID=ST.strMainStoresID ".
		 "Inner Join storeslocations SL on SL.strLocID=ST.strLocation and SL.strMainID=ST.strMainStoresID and SL.strSubID=ST.strSubStores ".
		 "Inner Join storesbins SB On SB.strBinID=ST.strBin and SB.strMainID=ST.strMainStoresID and SB.strSubID=ST.strSubStores and SB.strLocID=ST.strLocation ".
		 "Inner Join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId ".
		 "WHERE ST.intStyleId =  '$styleId' ".
		 "and ST.strBuyerPoNo =  '$buyerPo' ".
		 "and ST.intMatDetailId =  '$matDetailId' ".
		 "and ST.strColor =  '$color' ".
		 "and ST.strSize =  '$size' ".
		 "and MS.strMainID ='$mainStore' ".
		 "and MS.intStatus =1 ".
		 "and ST.intGrnYear =  '$grnYear' ".
		 "and ST.intGrnNo =  '$grnNo' ".
		 "and ST.strGRNType = '$grnType' ".
		 "GROUP BY ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin;";
	$result=$db->RunQuery($SQL);	
	while ($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<MainStoresID><![CDATA[" . $row["strMainStoresID"]  . "]]></MainStoresID>\n";	
		$ResponseXML .= "<SubStores><![CDATA[" . $row["strSubStores"]  . "]]></SubStores>\n";
		$ResponseXML .= "<Location><![CDATA[" . $row["strLocation"]  . "]]></Location>\n";
		$ResponseXML .= "<Bin><![CDATA[" . $row["strBin"]  . "]]></Bin>\n";
		$ResponseXML .= "<stockBal><![CDATA[" . round($row["stockBal"],2)  . "]]></stockBal>\n";		 
		$ResponseXML .= "<BinName><![CDATA[" . $row["strBinName"] . "]]></BinName>\n";
		$ResponseXML .= "<MainStoreName><![CDATA[" . $row["strName"] . "]]></MainStoreName>\n";
		$ResponseXML .= "<SubStoresName><![CDATA[" . $row["strSubStoresName"] . "]]></SubStoresName>\n";
		$ResponseXML .= "<LocationName><![CDATA[" . $row["strLocName"] . "]]></LocationName>\n";
		$ResponseXML .= "<MatSubCateoryId><![CDATA[" . $row["intSubCatID"] . "]]></MatSubCateoryId>\n";
	}
	$ResponseXML .="</LoadBinDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="getItemStockAvQty")
{
$styleId 		= $_GET["styleId"];
$buyerPo 		= $_GET["buyerPo"];
$matId 			= $_GET["matId"];
$color 			= $_GET["color"];
$size 			= $_GET["size"];
$mainstore 		= $_GET["mainstore"];
$grnNo 			= $_GET["grnNo"];
$grnYear 		= $_GET["grnYear"];
$grnType 		= $_GET["grnType"];
$issueQty		= $_GET["issueQty"];
	$ResponseXML .="<LoadBinDetails>\n";
	
	//check stock availability
	$sql = "select sum(dblQty) as Qty,strSubStores,strLocation,strBin,strMainStoresID,mil.intSubCatID
from stocktransactions st inner join matitemlist mil on
mil.intItemSerial = st.intMatDetailId
where strMainStoresID='$mainstore' and intStyleId='$styleId' and strBuyerPoNo='$buyerPo' and strColor='$color' and strSize='$size' and intGrnNo='$grnNo' and intMatDetailId='$matId'
and intGrnYear='$grnYear' and strGRNType='$grnType'
group by strSubStores,strLocation,strBin,mil.intSubCatID
having Qty>0";

	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		//check stock Qty is equal or greater than issue Qty
		$stockQty = $row["Qty"];
		if($stockQty>=$issueQty)
		{
			$ResponseXML .="<Resresult><![CDATA[true]]></Resresult>\n";
			$ResponseXML .="<SubStore><![CDATA[" . $row["strSubStores"] . "]]></SubStore>\n";
			$ResponseXML .="<Location><![CDATA[" . $row["strLocation"] . "]]></Location>\n";
			$ResponseXML .="<Bin><![CDATA[" . $row["strBin"] . "]]></Bin>\n";
			$ResponseXML .="<subCategory><![CDATA[" . $row["intSubCatID"] . "]]></subCategory>\n";
			$ResponseXML .="</LoadBinDetails>";
			echo $ResponseXML;
			return;	
		}
	}
	$ResponseXML .="<Resresult><![CDATA[false]]></Resresult>\n";
	$ResponseXML .="</LoadBinDetails>";
	echo $ResponseXML;
}
else if($RequestType=="LoadGatePassNo")
{
	//start 2010-11-05 get style gatepass no from syscontrol 
	
	$GatePassNo = getGetPassNo();
	$GatePassYear = date("Y");
	$ResponseXML .="<LoadGatePassNo>\n";
	$ResponseXML .= "<GatePassNo><![CDATA[".$GatePassNo."]]></GatePassNo>\n";
	$ResponseXML .= "<GatePassYear><![CDATA[".$GatePassYear."]]></GatePassYear>\n";
	$ResponseXML .="</LoadGatePassNo>";
	
	echo $ResponseXML;
}
else if ($RequestType=="SaveHeaderDetails")
{
	$gatePassNo 	= $_GET["gatePassNo"];
	$gatePassYear 	= $_GET["gatePassYear"];
	$Destination 	= $_GET["Destination"];	
	$remarks 		= $_GET["remarks"];
	$state 			= $_GET["state"];
	$attention 		= $_GET["attention"];
	$category		= $_GET["category"];
	$noOfPackages	= $_GET["noOfPackages"];
	$UserID=$_SESSION["UserID"];
	
	$DelSqlHeader="DELETE FROM gatepass WHERE intGatePassNo='$gatePassNo' AND intGPYear='$gatePassYear'	;";
	
	$db->executeQuery($DelSqlHeader);
	
	$SQLDel="DELETE FROM gatepassdetails WHERE intGatePassNo='$gatePassNo' AND intGPYear='$gatePassYear' ;";	
	$db->executeQuery($SQLDel);
	
	$SQL= "INSERT INTO gatepass (intGatePassNo,intGPYear,dtmDate,strTo,intInstructedBy,intUserId,strRemarks,intStatus,intPrintStaus,intCompany,strAttention,strCategory,intNoOfPackages)".
		  "VALUES ($gatePassNo,$gatePassYear,now(),'$Destination','$UserID','$UserID','$remarks',0,0,'$companyId','$attention','$category','$noOfPackages') ;";	
	
	$db->executeQuery($SQL);	

}
else if ($RequestType=="SaveDetails")
{
$gatePassNo 	= $_GET["gatePassNo"];
$gatePassYear 	= $_GET["gatePassYear"];	
$StyleId		= $_GET["StyleId"];
$BuyerPoNo 		= $_GET["BuyerPoNo"];
$matDetailId 	= $_GET["matDetailId"];
$color 			= $_GET["color"];
$size 			= $_GET["size"];
$qty 			= $_GET["Qty"];
$rtn 			= $_GET["rtn"];
$grnNo 			= $_GET["grnNo"];
$grnYear 		= $_GET["grnYear"];		
$grnType 		= $_GET["GrnType"];	

	$SQL="INSERT INTO gatepassdetails (intGatePassNo,intGPYear,intStyleId,strBuyerPONO,intMatDetailId,strColor,strSize,dblQty,intRTN,dblBalQty,intGrnNo,intGRNYear,strGRNType) ".
	     "VALUES ($gatePassNo,$gatePassYear,'$StyleId','$BuyerPoNo',$matDetailId,'$color','$size',$qty,$rtn,$qty,$grnNo,$grnYear,'$grnType') ;"; 
	$db->executeQuery($SQL);
		
}
else if ($RequestType=="SaveBinDetails")
{
$state				= $_GET["state"];
$mainStores 		= $_GET["mainStores"];
$subStores 			= $_GET["subStores"];	
$location 			= $_GET["location"];
$binId 				= $_GET["binId"];
$StyleId 			= $_GET["StyleId"];
$gatePassNo 		= $_GET["gatePassNo"];
$Year 				= $_GET["gatePassYear"];
$BuyerPoNo 			= $_GET["BuyerPoNo"];
$matDetailId 		= $_GET["matDetailId"];
$color 				= $_GET["color"];
$size 				= $_GET["size"];
$units 				= $_GET["units"];
$issueBinQty 		= $_GET["issueBinQty"];	
//$binQty 			= "-". $issueBinQty;
#=================================
# GP out qty change as a minus qty
#=================================
$binQty 			= $issueBinQty*-1;
#=================================
$validateBinCount 	= $_GET["validateBinCount"];	
$matSubCategoryId 	= $_GET["matSubCategoryId"];
$grnNo				= $_GET["grnNo"];
$grnYear			= $_GET["grnYear"];
$pub_commonBin      = $_GET["pub_commonBin"];
$mainStoreId 		= $_GET["mainStoreId"];
$grnType 			= $_GET["GrnType"];	
	
	$UserID=$_SESSION["UserID"];
	//get bin details if default bin activated
		if($pub_commonBin == 1)
		{	
			$sqlCommBin = " select s.strSubID,s.strLocID,s.strBinID,s.strMainID
				from storesbins s inner join mainstores ms on 
				ms.strMainID = s.strMainID
				where s.strMainID='$mainStoreId' and ms.intCommonBin=1 and ms.intStatus=1" ;		
			$resCommBin =$db->RunQuery($sqlCommBin);			
			while ($rowBin =mysql_fetch_array($resCommBin))
			{
				$mainStores = $rowBin["strMainID"];
				$subStores = $rowBin["strSubID"];
				$location = $rowBin["strLocID"];	
				$binId	  = $rowBin["strBinID"];	
			}	
		}
			
		insertStockTempData($gatePassNo,$Year,$StyleId,$BuyerPoNo,$matDetailId,$color,$size,$mainStores,$subStores,$location,$binId,$grnNo,$grnYear,$units,$binQty,$UserID,$grnType);		
}
else if ($RequestType=="ResponseValidateGP")
{
	$state		= $_GET["state"];
	$gatePassNo=$_GET["gatePassNo"];
	$gatePassYear =$_GET["gatePassYear"];
	$validateCount =$_GET["validateCount"];
	$validateBinCount =$_GET["validateBinCount"];	
	
	$ResponseXML .="<ResponseValidate>\n";
	
	$SQLHeder="SELECT COUNT(intGatePassNo) AS headerRecCount FROM gatepass where intGatePassNo=$gatePassNo AND intGPYear=$gatePassYear";
	
	$resultHeader=$db->RunQuery($SQLHeder);
	
			while($row = mysql_fetch_array($resultHeader))
			{		
				$recCountGatePassHeader=$row["headerRecCount"];
			
				if($recCountGatePassHeader>0)
				{
					$ResponseXML .= "<recCountGatePassHeader><![CDATA[TRUE]]></recCountGatePassHeader>\n";
				}
				else
				{	
					$ResponseXML .= "<recCountGatePassHeader><![CDATA[FALSE]]></recCountGatePassHeader>\n";
				}
			}	
			
	$SQLDetail="SELECT COUNT(intGatePassNo) AS GPDetailsRecCount FROM gatepassdetails where intGatePassNo=$gatePassNo AND intGPYear=$gatePassYear";
	
	$resultDetail=$db->RunQuery($SQLDetail);
		
			while($row =mysql_fetch_array($resultDetail))
			{
				$recCountGatePassDetails=$row["GPDetailsRecCount"];
				
					if($recCountGatePassDetails==$validateCount)
					{
						$ResponseXML .= "<recCountGatePassDetails><![CDATA[TRUE]]></recCountGatePassDetails>\n";
					}
					else
					{
						$ResponseXML .= "<recCountGatePassDetails><![CDATA[FALSE]]></recCountGatePassDetails>\n";
					}
			}
//if($state==1){
//check bin validation from stock temp 
		$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions_temp where intDocumentNo=$gatePassNo AND intDocumentYear=$gatePassYear AND strType='SGatePass'";	
	
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
	//}
	
	$ResponseXML .="</ResponseValidate>";
	echo $ResponseXML;
}
else if ($RequestType=="DeleteRow")
{
$GatePassNO 		= $_GET["GatePassNO"];
$GatePassNOArray	= explode('/',$GatePassNO);
$styleId 			= $_GET["styleId"];
$buyerPoNo 			= $_GET["buyerPoNo"];
$color 				= $_GET["color"];
$size 				= $_GET["size"];
$matDetailId 		= $_GET["matDetailId"];
$grnNo 				= $_GET["grnNo"];
$grnYear 			= $_GET["grnYear"];
$grnType 			= $_GET["GrnType"];
	
  	$SQLDetails="delete from gatepassdetails ".
		 "where intGatePassNo = '$GatePassNOArray[1]' and intGPYear = '$GatePassNOArray[0]' and intStyleId = '$styleId' ".
		 "and strBuyerPONO = '$buyerPoNo' and intMatDetailId = '$matDetailId' ".
		 "and strColor = '$color' and strSize = '$size' and intGrnNo = '$grnNo' and intGRNYear = '$grnYear' and strGRNType='$grnType'";
	
	$db->executeQuery($SQLDetails);
	
	$SQLBin="delete from stocktransactions ".
			"where intDocumentNo = '$GatePassNOArray[1]' and intDocumentYear = '$GatePassNOArray[0]' ".
			"and intStyleId='$styleId' and strBuyerPoNo='$buyerPoNo' ".
			"and intMatDetailId='$matDetailId' and strColor='$color' ".
			"and strSize='$size' and strType='SGatePass' and intGrnNo = '$grnNo' and  intGrnYear = '$grnYear' and strGRNType='$grnType'";
		
	$db->executeQuery($SQLBin);
}
else if ($RequestType=="LoadHeaderDetails")
{
	$GPNO =$_GET["intGPNO"];
	$GPYear =$_GET["intGPYear"];
	
	$ResponseXML .="<LoadHeaderDetails>\n";
$sql_category ="select strCategory from gatepass ".
	"WHERE intGatePassNo =  '$GPNO' ".
	"AND intGPYear =  '$GPYear'";

$result_category=$db->RunQuery($sql_category);
$row_category = mysql_fetch_array($result_category);
$category = $row_category["strCategory"];

		 
	$SQL="SELECT CONCAT(GP.intGPYear,'/' ,GP.intGatePassNo) AS GPNO,GP.strTo,GP.dtmDate,GP.strRemarks,GP.strTo,GP.strAttention,GP.intStatus,GP.strCategory ".
		 "FROM gatepass AS GP ";		 
if($category=="E"){
	$SQL .= " Inner Join subcontractors ON GP.strTo = subcontractors.strSubContractorID ";
}
elseif($category=="I"){
	$SQL .= "Inner Join mainstores ON GP.strTo = mainstores.strMainID ";
}
	$SQL .= "WHERE GP.intGatePassNo =  '$GPNO' ".
		 	"AND GP.intGPYear =  '$GPYear'";
	
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<GPNO><![CDATA[" . $row["GPNO"] . "]]></GPNO>\n";						
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"] . "]]></Remarks>\n";
			$ResponseXML .= "<DestinationID><![CDATA[" . $row["strTo"] . "]]></DestinationID>\n";			
				$Date =substr($row["dtmDate"],0,10);
				$GPNOArray=explode('-',$Date);
				$formatedGPDate=$GPNOArray[2]."/".$GPNOArray[1]."/".$GPNOArray[0];
			$ResponseXML .= "<formatedGPDate><![CDATA[" . $formatedGPDate . "]]></formatedGPDate>\n";
			$ResponseXML .= "<Attention><![CDATA[" . $row["strAttention"] . "]]></Attention>\n";
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
			$ResponseXML .= "<category><![CDATA[" . $row["strCategory"] . "]]></category>\n";
			
		}
	
	$ResponseXML .="</LoadHeaderDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadGatePassDetails")
{
$GPNO =$_GET["intGPNO"];
$GPYear =$_GET["intGPYear"];
$gatePassStatus = $_GET["gatePassStatus"];

$ResponseXML .="<LoadGatePassDetails>\n";

	//start 2010-12-29 get mainstoreid
	$mainstoreID = getMainstoreID($GPNO,$GPYear,$gatePassStatus);
	//end 2010-12-29
	
	$SQL = "SELECT
GPD.intStyleId,
GPD.strBuyerPONO,
GPD.intMatDetailId,
GPD.strColor,
O.strOrderNo,
GPD.strSize,
GPD.dblQty,
MIL.strItemDescription,
MMC.strDescription,
GPD.intGrnNo,
GPD.intGRNYear,
GPD.strGRNType,
specificationdetails.strUnit
FROM
gatepassdetails AS GPD
INNER JOIN matitemlist AS MIL ON GPD.intMatDetailId = MIL.intItemSerial
INNER JOIN matmaincategory AS MMC ON MIL.intMainCatID = MMC.intID
INNER JOIN orders AS O ON O.intStyleId = GPD.intStyleId
INNER JOIN specificationdetails ON specificationdetails.intStyleId = GPD.intStyleId AND specificationdetails.strMatDetailID = GPD.intMatDetailId
	WHERE GPD.intGatePassNo =  '$GPNO' AND GPD.intGPYear =  '$GPYear' 
	ORDER BY MIL.intMainCatID ASC";	
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$styleid		= $row["intStyleId"];
			$StyleName      = $row["strOrderNo"];
			$buyerPONO		= $row["strBuyerPONO"];
			$buyerPoName    = $row["strBuyerPONO"];
			$matDetailId	= $row["intMatDetailId"];
			$color			= $row["strColor"];
			$size			= $row["strSize"];
			$grnNo 			= $row["intGrnNo"];
			$grnYear		= $row["intGRNYear"];
			$grnType		= $row["strGRNType"];
			
			$StockQty		= getStockQty($styleid,$buyerPONO,$matDetailId,$color,$size,$companyId,$grnNo,$grnYear,$grnType);
			//$rejectQty	= GetRejectQty($styleid,$buyerPONO,$matDetailId,$color,$size,$grnNo,$grnYear);
			$mrnBalance		= GetmrnBalance($styleid,$buyerPONO,$matDetailId,$color,$size,$grnNo,$grnYear,$mainstoreID,$grnType);
			//$actualStock=$StockQty-$rejectQty-$mrnBalance;
			$actualStock = $StockQty-$mrnBalance;
			//echo $matDetailId;  echo 'ddd';  echo  $StockQty; echo 'ddd';
			if($buyerPONO != '#Main Ratio#')
				$buyerPoName = getBuyerPOName($styleid,$buyerPONO);
				
				$ResponseXML .= "<MainCategory><![CDATA[" . $row["strDescription"] . "]]></MainCategory>\n";
				$ResponseXML .= "<MatDetailId><![CDATA[" . $matDetailId . "]]></MatDetailId>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";
				$ResponseXML .= "<Styleid><![CDATA[" . $styleid . "]]></Styleid>\n";
				$ResponseXML .= "<StyleName><![CDATA[" . $StyleName . "]]></StyleName>\n";
				$ResponseXML .= "<BuyerPONO><![CDATA[" . $buyerPONO . "]]></BuyerPONO>\n";	
				$ResponseXML .= "<BuyerPOName><![CDATA[" . $buyerPoName . "]]></BuyerPOName>\n";							
				$ResponseXML .= "<Color><![CDATA[" . $color . "]]></Color>\n";
				$ResponseXML .= "<Size><![CDATA[" . $size . "]]></Size>\n";
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
				$ResponseXML .= "<StockBal><![CDATA[" . round($actualStock,3) . "]]></StockBal>\n";
				$ResponseXML .= "<GPQTY><![CDATA[" . round($row["dblQty"],3) . "]]></GPQTY>\n";
				$ResponseXML .= "<GRNno><![CDATA[" . $grnNo . "]]></GRNno>\n";
				$ResponseXML .= "<GRNYear><![CDATA[" . $grnYear . "]]></GRNYear>\n";
				$ResponseXML .= "<GRNTypeId><![CDATA[" . $row["strGRNType"] . "]]></GRNTypeId>\n";
				if($row["strGRNType"]=='B')
					$grnType = 'Bulk';
				elseif($row["strGRNType"]=='S')
					$grnType = 'Style';				
				$ResponseXML .= "<GRNType><![CDATA[" . $grnType . "]]></GRNType>\n";				
		}
	$ResponseXML .="</LoadGatePassDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadPendingConfirmBinDetails")
{
$GatePassNo		= $_GET["gatePassNo"];
$GPNOArray		= explode('/',$GatePassNo);
$StyleId		= $_GET["styleId"];
$buyerPoNo		= $_GET["buyerPoNo"];
$MatDetailID	= $_GET["matDetailID"];
$Color			= $_GET["color"];
$Size			= $_GET["size"];
$grnNo			= $_GET["GRNNo"];	
$grnYear		= $_GET["GRNYear"];
$grnType		= $_GET["GRNType"];		
$gatePassStatus = $_GET["gatePassStatus"];
	
	if($gatePassStatus == '1')
		$tbl = 'stocktransactions';
	else
		$tbl = 'stocktransactions_temp';
	$ResponseXML .="<LoadPendingConfirmBinDetails>\n";
	
	 $SQLBIN="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin,Sum(ST.dblQty) as BinQty,MIL.intSubCatID ".
			"FROM $tbl AS ST ".
			"Inner Join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId ".
			"WHERE ST.intDocumentNo =  '$GPNOArray[1]' AND ST.intDocumentYear =  '$GPNOArray[0]' ".
			"AND ST.intStyleId = '$StyleId' AND ST.strBuyerPoNo =  '$buyerPoNo' ".
			"AND ST.intMatDetailId = '$MatDetailID' AND ST.strColor = '$Color' AND ST.strSize = '$Size' and strType='SGatePass' ".
			"AND ST.intGrnNo = '$grnNo' AND ST.intGrnYear = '$grnYear' AND ST.strGRNType = '$grnType' ".			
			"GROUP BY ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin;";
	$result=$db->RunQuery($SQLBIN);
		while($row=mysql_fetch_array($result))
		{
			$BinQty=$row["BinQty"];
				$Qty =substr($BinQty,3);	
			$ResponseXML .="<Qty><![CDATA[". $BinQty ."]]></Qty>\n";		
			$ResponseXML .="<MainStoresID><![CDATA[". $row["strMainStoresID"] ."]]></MainStoresID>\n";
			$ResponseXML .="<SubStores><![CDATA[". $row["strSubStores"] ."]]></SubStores>\n";
			$ResponseXML .="<Location><![CDATA[". $row["strLocation"] ."]]></Location>\n";
			$ResponseXML .="<Bin><![CDATA[". $row["strBin"] ."]]></Bin>\n";		
			$ResponseXML .="<MatSubCatId><![CDATA[". $row["intSubCatID"] ."]]></MatSubCatId>\n";
		}		
	$ResponseXML .="</LoadPendingConfirmBinDetails>";
	echo $ResponseXML;
}
else if($RequestType=="GatePassComfirm")
{
	$GPNO = $_GET["GPNO"];
		$GPNOArray=explode('/',$GPNO);		
	
	$SqlConfirm="Update gatepass ".
				"set intConfirmedBy = '$UserID',dtmConfirmedOn = now(), ".
				"intStatus =1 ".
				"where intGatePassNo = '$GPNOArray[1]' and intGPYear = '$GPNOArray[0]' ";
			$result=0;
			$result = $db->RunQuery($SqlConfirm);
			echo $result;
}
/*BEGIN - Gate pass cancel part comment because if user want to cancel the gatepass user must transfer in to his own factory.
else if ($RequestType=="GatePassCancel")
{
	$GPNO	= $_GET["GPNO"];
		$GatePassNoArray = explode('/',$GPNO);
	$Year 	= date('Y');
	$UserID	= $_SESSION["UserID"];
	
	$SqlUpdate ="update gatepass  ".
				"set intCancelledBy =$UserID, ".
				"dtmCancelledDate = now(), ".
				"intStatus =10 ".	
				"where intGatePassNo =$GatePassNoArray[1] ".
				"AND intGPYear =$GatePassNoArray[0]";
	
	$resultUpdate = $db->RunQuery($SqlUpdate);		
	
	  $sql ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin, ".
			"ST.intStyleId,ST.strBuyerPoNo,ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, ".
			"ST.strColor,ST.strSize,ST.strUnit,ST.dblQty ".
			"FROM stocktransactions AS ST ".
			"WHERE ST.intDocumentNo =$GatePassNoArray[1] AND ST.intDocumentYear =$GatePassNoArray[0] AND strType='SGatePass'";
	
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$MainStores=$row["strMainStoresID"];
			$SubStores=$row["strSubStores"];
			$Location=$row["strLocation"];
			$Bin=$row["strBin"];
			$StyleNo=$row["intStyleId"];
			$BuyerPoNo=$row["strBuyerPoNo"];
			$DocumentNo=$row["intDocumentNo"];
			$DocumentYear=$row["intDocumentYear"];
			$MatDetailId=$row["intMatDetailId"];
			$Color=$row["strColor"];
			$Size=$row["strSize"];
			$Unit=$row["strUnit"];
			$Qty=$row["dblQty"];
				$BinQty =substr($Qty,1);
			StockRevise($Year,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$BinQty,$UserID);
			ReviseStockAllocation($MainStores,$SubStores,$Location,$Bin,$MatDetailId,$BinQty);	
		}		
	
	echo $resultUpdate;
}
END - Gate pass cancel part comment because if user want to cancel the gatepass user must transfer in to his own factory.*/
else if($RequestType=="SaveFabricRollDetails")
{
	$state						= $_GET["state"];
	if($state==1){
		
		$rollSerialNo			= $_GET["rollSerialNo"];
			$rollSerialNoArray	= explode('/',$rollSerialNo);
		$gatePassNo 			= $_GET["gatePassNo"];
		$gatePassYear 			= $_GET["gatePassYear"];				
		$rollNo					= $_GET["rollNo"];
		$styleId 				= $_GET["styleId"];
		$BuyerPoNo 				= $_GET["BuyerPoNo"];			
		$itemdDetailID 			= $_GET["itemdDetailID"];
		$color 					= $_GET["color"];
		$size 					= $_GET["size"];
		$rollIssueQty			= $_GET["rollIssueQty"];		
		
		$sqlroll= "insert into fabricrollgatepassdetails ".
				  "(intFRollSerialNO, ".
				  "intFRollSerialYear, ".
				  "intGatePassNo, ".
				  "intGatePassYear, ".				  
				  "intRollNo, ".
				  "intStyleId, ".
				  "strBuyerPONO, ".
				  "intMatDetailID, ".
				  "strColor, ".
				  "strSize, ".
				  "intStoresID, ".
				  "dblQty, ".
				  "intCompanyID, ".
				  "intUserID) ".
				  "values ('$rollSerialNoArray[1]', ".
				  "'$rollSerialNoArray[0]', ".
				  "$gatePassNo, ".
				  "$gatePassYear, ".
				  "$rollNo, ".
				  "'$styleId', ". 
				  "'$BuyerPoNo', ".
				  "'$itemdDetailID', ".
				  "'$color', ".
				  "'$size', ".
				  "1, ".
				  "$rollIssueQty, ".
				  "$companyId, ".
				  "$UserID);";
			 
		$db->executeQuery($sqlroll);	
		
		$sqlrollupdate ="update fabricrolldetails ".
						"set dblBalQty = dblBalQty-$rollIssueQty ".
						"where ".
						"intFRollSerialNO = $rollSerialNoArray[1] and ".
						"intFRollSerialYear = $rollSerialNoArray[0] and ".
						"intRollNo =$rollNo;";		  
		$db->executeQuery($sqlrollupdate);
	}
}
else if($RequestType=="LoadStores")
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
else if($RequestType=="GetAllocatedBinQty")
{
$ResponseXML = "<LoadStores>\n";

$mainStoreId	= $_GET["msId"];
$subStoreId		= $_GET["ssId"];
$locationId		= $_GET["locId"];
$binId			= $_GET["binId"];

	$sql=" select MS.strName,SS.strSubStoresName,SL.strLocName,SB.strBinName
		from mainstores MS 
		inner join substores SS on SS.strMainID=MS.strMainID
		inner join storeslocations SL on SL.strMainID=MS.strMainID and SL.strSubID=SS.strSubID
		inner join storesbins SB on SB.strMainID=MS.strMainID and SB.strSubID=SS.strSubID and SB.strLocID=SL.strLocID
		where MS.strMainID='$mainStoreId'
		and SS.strSubID='$subStoreId'
		and SL.strLocID='$locationId'
		and SB.strBinID='$binId'";
		
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<MainStore><![CDATA[".$row["strName"]."]]></MainStore>\n";
		$ResponseXML .= "<SubStore><![CDATA[".$row["strSubStoresName"]."]]></SubStore>\n";
		$ResponseXML .= "<Location><![CDATA[".$row["strLocName"]."]]></Location>\n";
		$ResponseXML .= "<Bin><![CDATA[".$row["strBinName"]."]]></Bin>\n";
	}
$ResponseXML .="</LoadStores>";
echo $ResponseXML;
}

if($RequestType=='getCommonBin')
{
	$ResponseXML = "<LoadCommBin>\n";
	
	$strMainStores		= $_GET["strMainStores"];
	
	$SQL = " select intCommonBin from mainstores where strMainID=$strMainStores  and intStatus=1 ";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	$commBin = $row["intCommonBin"];
	
	$ResponseXML .= "<CommBinDetails><![CDATA[".$commBin."]]></CommBinDetails>\n";
	$ResponseXML .="</LoadCommBin>";
	echo $ResponseXML;

}
if($RequestType=='confirmGatePass')
{
	$GPNo = $_GET["GPNo"];
	$arrGPno = explode('/',$GPNo);
	$validateBinCount = $_GET["validateBinCount"];
	 $ResponseXML = "<binValidate>\n";
	 
	$GatepassNo = $arrGPno[1];
	$GPyear = $arrGPno[0];
	
	//$stockResponse = validateStockDetails($GatepassNo,$GPyear);
	if($stockResponse == '')
	{
		confirmGP($GatepassNo,$GPyear);
		$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions where intDocumentNo=$GatepassNo AND intDocumentYear=$GPyear AND strType='SGatePass'";	
		
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
if($RequestType=='deleteStockTemp')
{
	$gatePassNo = $_GET["gatePassNo"];
	$gatePassYear = $_GET["gatePassYear"];
	deleteStockTempData($gatePassNo,$gatePassYear);
	
}

function getStockQty($styleid,$buyerPONO,$matDetailId,$color,$size,$companyId,$grnNo,$grnYear,$grnType)
{
	global $db;	
	$SQLStock=" SELECT ST.intStyleId,ST.strBuyerPoNo,ST.intMatDetailId,ST.strColor, ".
			  "ST.strSize,Sum(ST.dblQty) AS StockQty ".
			  "FROM stocktransactions AS ST ".
			  "Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID  ".
			  "WHERE ST.intStyleId =  '$styleid' AND ST.strBuyerPoNo =  '$buyerPONO' AND ".
			  "ST.intMatDetailId =  '$matDetailId' AND ST.strColor =  '$color' AND ".
			  "ST.strSize =  '$size' AND MS.intCompanyId =  '$companyId' ".
			  "and ST.intGrnNo=$grnNo and ST.intGrnYear=$grnYear and MS.intAutomateCompany=0 and MS.intStatus=1 and strGRNType='$grnType' ".
			  "GROUP BY ST.intStyleId,ST.strBuyerPoNo,ST.intMatDetailId,ST.strColor,ST.strSize;";
	
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

function StockRevise($Year,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$BinQty,$UserID)
{
	global $db;
	
$sqlInStock="INSERT INTO stocktransactions ".
 "(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
 "intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser) VALUES ".
 "($Year,'$MainStores','$SubStores','$Location','$Bin','$StyleNo','$BuyerPoNo',$DocumentNo,$DocumentYear,$MatDetailId, ".
 "'$Color','$Size','CSGatePass','$Unit',$BinQty,now(),'$UserID')";

$db->executeQuery($sqlInStock);
}

function GetmrnBalance($styleid,$buyerPONO,$matDetailId,$color,$size,$grnNo,$grnYear,$mainStoreId,$grnType)
{
global $companyId;
global $db;

		$sqlmrnbal = " SELECT MRD.intStyleId,
				MRD.strBuyerPONO,MRD.strMatDetailID, 
				MRD.strColor,MRD.strSize, 
				sum(MRD.dblBalQty) AS mrnBalQty, MRD.intGrnNo,MRD.intGrnYear
				FROM 
				matrequisitiondetails AS MRD 
				Inner Join matrequisition AS MR 
				ON MR.intMatRequisitionNo = MRD.intMatRequisitionNo AND MR.intMRNYear = MRD.intYear 
				WHERE 
				MRD.intStyleId =  '$styleid' AND 
				MRD.strBuyerPONO =  '$buyerPONO' AND 
				MRD.strMatDetailID =  '$matDetailId' AND 
				MRD.strColor =  '$color' AND 
				MRD.strSize =  '$size' AND  
				MRD.intGrnNo = '$grnNo' and 
				MRD.intGrnYear = '$grnYear' and 
				MR.strMainStoresID ='$mainStoreId' and
				dblBalQty>0 and 
				strGRNType='$grnType'
				Group By MRD.intStyleId,MRD.strBuyerPONO,MRD.strMatDetailID, MRD.strColor,MRD.strSize,
				MRD.intGrnNo,MRD.intGrnYear,MRD.strGRNType";	
	$resultmrnbal=$db->RunQuery($sqlmrnbal);
	$rowmrnbalcount = mysql_num_rows($resultmrnbal);
	if ($rowmrnbalcount > 0)
	{
		while($rowmrnbal=mysql_fetch_array($resultmrnbal))
		{
			return $rowmrnbal["mrnBalQty"];
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

//BEGIN - 2010-11-05 generate style gatepass using syscontrol
function getGetPassNo()
{
	$compCode=$_SESSION["FactoryID"];
	global $db; 

	$strSQL="update syscontrol set  dblSGatePassNo= dblSGatePassNo+1 WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblSGatePassNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$GPNo = 'NA';
	while($row = mysql_fetch_array($result))
	 {
		$GPNo  =  $row["dblSGatePassNo"] ;
		break;
	 }
	return $GPNo;
}
//END 2010-11-05 generate style gatepass using syscontrol

function deleteStockTempData($gatePassNo,$Year)
{
	global $db;
	
	$sqlStockdel=" DELETE FROM stocktransactions_temp WHERE intDocumentNo='$gatePassNo' AND intDocumentYear='$Year' 
				AND strType='SGatePass' ";
		
		$db->executeQuery($sqlStockdel); 
}

function insertStockTempData($gatePassNo,$Year,$StyleId,$BuyerPoNo,$matDetailId,$color,$size,$mainStores,$subStores,$location,$binId,$grnNo,$grnYear,$units,$binQty,$UserID,$grnType)
{
	global $db;
	
	$SQL="INSERT INTO stocktransactions_temp(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
			 " intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ".
			 " ($Year,'$mainStores','$subStores','$location','$binId','$StyleId','$BuyerPoNo',$gatePassNo,$Year,$matDetailId, ".
			 " '$color','$size','SGatePass','$units',$binQty,now(),$UserID,$grnNo,$grnYear,'$grnType') ";		
		$db->executeQuery($SQL);
}

function getSubCatDetails($matdetailID)
{
	global $db;
	$sql = " select intSubCatID from matitemlist where intItemSerial=$matdetailID ";
	$result=$db->RunQuery($sql);
	
	$row = mysql_fetch_array($result);
	return $row["intSubCatID"];
}

function validateStockDetails($GatepassNo,$GPyear)
{
	global $db;
	
	$sql = "SELECT * FROM stocktransactions_temp WHERE intDocumentNo='$GatepassNo' AND intDocumentYear='$GPyear' AND strType='SGatePass' ";				
	$result = $db->RunQuery($sql);
	
	$response='';
	while($row = mysql_fetch_array($result))
	{
		$mainStore 		= $row["strMainStoresID"];
		$subStore 		= $row["strSubStores"];
		$location 		= $row["strLocation"];
		$bin 			= $row["strBin"];
		$styleID 		= $row["intStyleId"];
		$buyerPO 		= $row["strBuyerPoNo"];
		$matdetailID 	= $row["intMatDetailId"];
		$color 			= $row["strColor"];
		$size 			= $row["strSize"];
		$grnNo 			= $row["intGrnNo"];
		$grnYear 		= $row["intGrnYear"];
		$grnType 		= $row["strGRNType"];
		$qty   			= abs($row["dblQty"]);
		
		$SQLStock = "SELECT SUM(dblQty) AS StockQty FROM stocktransactions WHERE intStyleId='$styleID' AND strBuyerPONO = '$buyerPO' AND intMatDetailId = '$matdetailID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$mainStore' and intGrnNo= '$grnNo' and intGrnYear='$grnYear' and strSubStores='$subStore' and strLocation = '$location' and strBin = '$bin' and strGRNType='$grnType' ";
		$resStock =  $db->RunQuery($SQLStock);
			   
		while($rowST = mysql_fetch_array($resStock))
		{
			$mrnQty = GetmrnBalance($styleID,$buyerPO,$matdetailID,$color,$size,$grnNo,$grnYear,$mainStore,$grnType);			
			$StockQty = $rowST["StockQty"] - $mrnQty;
			//echo $StockQty; echo 'rrr'; echo $qty;  echo 'rrr';
			if($StockQty < $qty || $StockQty==0)
			{
				$response = 'Some items not in stock';				
			}
		}
	}	
return $response;		
}

function confirmGP($GatepassNo,$GPyear)
{
	global $db;
	
	$sql = "SELECT * FROM stocktransactions_temp WHERE intDocumentNo='$GatepassNo' AND intDocumentYear='$GPyear'  AND strType='SGatePass' ";				
	$result = $db->RunQuery($sql);
	
	$response='';
	while($row = mysql_fetch_array($result))
	{
		$mainStore = $row["strMainStoresID"];
		$subStore = $row["strSubStores"];
		$location = $row["strLocation"];
		$bin = $row["strBin"];
		$matdetailID = $row["intMatDetailId"];
		$subCatId = getSubCatDetails($matdetailID);
		$qty   = abs($row["dblQty"]);
		updateBinDetails($mainStore,$subStore,$location,$bin,$subCatId,$qty);
	}
	
	$SQLstock =  "INSERT INTO stocktransactions ( intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) SELECT intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType FROM stocktransactions_temp  
	where intDocumentNo='$GatepassNo' and intDocumentYear='$GPyear' and strType='SGatePass' ";
	
	$resultStock = $db->RunQuery($SQLstock);
	if($resultStock == 1)
	{
		$SQLdel		= " delete from stocktransactions_temp where intDocumentNo='$GatepassNo' and intDocumentYear='$GPyear' and strType='SGatePass'";
		$resultDel	= $db->RunQuery($SQLdel);
	}	
}

function updateBinDetails($mainStore,$subStore,$location,$bin,$subCatId,$qty)
{
	global $db;
	
	$sqlbinallocation="update storesbinallocation ".
						"set ".
						"dblFillQty = dblFillQty-$qty ".
						"where ".
						"strMainID = '$mainStore' ".
						"and strSubID = '$subStore' ".
						"and strLocID = '$location' ".
						"and strBinID = '$bin' ".
						"and intSubCatNo = '$subCatId';";	
	$db->RunQuery($sqlbinallocation);
}

function getMainstoreID($GPNO,$GPYear,$gatePassStatus)
{
	global $db;
	
	if($gatePassStatus == 0)
		$tblName = 'stocktransactions_temp';
	else
		$tblName = 'stocktransactions';
		
	$sql = " select distinct strMainStoresID from $tblName where intDocumentNo='$GPNO' and intDocumentYear=$GPYear and strType='SGatePass'";		
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);	
	return $row["strMainStoresID"];		
}


//--------------------------------------------------------------------------------------------

if ($RequestType=="loadReportName")
{
$xml = simplexml_load_file('../config.xml');
$MarsylkaStyleItemGatepass = $xml->styleInventory->MarsylkaStyleItemGatepass;

$ResponseXML .="<loadReportName>\n";
$ResponseXML .="<ReportName><![CDATA[".$MarsylkaStyleItemGatepass."]]></ReportName>\n";

	$ResponseXML .="</loadReportName> ";
	echo $ResponseXML;

}
?>