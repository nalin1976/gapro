<?php
session_start();
include "../../Connector.php";
include "../../EmailSender.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="LoadSubStores")
{
	$mainStores=$_GET["mainStores"];
	
	$ResponseXML .="<LoadSubStores>\n";
	
	$SQL="select strSubID,strSubStoresName from substores where strMainID='$mainStores'";	
	$result=$db->RunQuery($SQL);	
	while ($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<SubStoresName><![CDATA[" . $row["strSubStoresName"]  . "]]></SubStoresName>\n";		
		$ResponseXML .= "<SubID><![CDATA[" . $row["strSubID"]  . "]]></SubID>\n";	
	}
	$sql_main = "select intCommonBin from mainstores where strMainID=$mainStores";
	$result_main=$db->RunQuery($sql_main);
	$row_main = mysql_fetch_array($result_main);
		$ResponseXML .= "<CommonBinId><![CDATA[" . $row_main["intCommonBin"]  . "]]></CommonBinId>\n";	
	$ResponseXML .="</LoadSubStores>";
	echo $ResponseXML;
}

else if($RequestType=="saveBinItems"){
	$styleNo	= $_GET['styleNo'];
	$location 	= $_GET['location'];
	$binId		= $_GET['binId'];
	$mainStoreID= $_GET['mainStoreID'];
	$subStoreID	= $_GET['subStoreID'];
	$buyerPo	= $_GET['buyerPo'];
	$matDetId	= $_GET['matDetId'];
	$color		= $_GET['color'];
	$size		= $_GET['size'];
	$unit		= $_GET['unit'];
	$Qty		= $_GET['Qty'];
	$grnNo		= $_GET['grnNo'];
	$grnNo		= explode('/',$grnNo);
	$tag		=	$_GET['tag'];
	$date		=	date('Y');
	$docNO="";
	
	if($tag==0)
	{
		$disNo=0;
		$disNo=disposeNo($companyId);
		$update_SysControl="UPDATE syscontrol SET dblCompleteOrderId='".((int)$disNo+1) ."' WHERE intCompanyID='$companyId';";
		$resUp=$db->RunQuery($update_SysControl);
	}
	
	
	$docNO=disposeNo($companyId);
	$sqlChk="SELECT * from stocktransactions_temp  
			where intStyleId=$styleNo
			and strSubStores='$subStoreID' 
			and strLocation='$location'
			and strMainStoresID='$mainStoreID' 
			and strType='LeftOver' 
			and strBin='$binId';";
			//echo $sqlChk;
	$rst=$db->RunQuery($sqlChk);	
	if(mysql_num_rows($rst)>0){
		$sqlD="delete from stocktransactions_temp 
			where intStyleId=$styleNo
			and strSubStores='$subStoreID' 
			and strLocation='$location'
			and strMainStoresID='$mainStoreID' 
			and strType='LeftOver' 
			and strBin='$binId'
			and strSize=$size;";
			//echo $sqlD;
			$db->RunQuery($sqlD);	
	}
	$sql_insert="insert stocktransactions_temp 		
						(strMainStoresID,
						intYear,	
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
						intGrnYear) 
					values(
						'$mainStoreID',
						'".$date."',
						'$subStoreID',
						'$location',
						'$binId',
						'$styleNo',
						'$buyerPo',
						'$docNO',
						'".$date."',
						'$matDetId',
						'$color',
						'$size',
						'LeftOver',
						'$unit',
						'$Qty',
						now(),
						'$UserID',
						'".$grnNo[1]."',
						'".$grnNo[0]."')";
					//echo $sql_insert;
	$res=$db->RunQuery($sql_insert);
	if($res=='1')
	{
	$ResponseXML .="<OrderCompletion>";		 
		$ResponseXML .= "<det><![CDATA[" . $tag."~".$docNO . "]]></det>\n";	
	$ResponseXML .="</OrderCompletion>";
	echo $ResponseXML;
	}

}

else if($RequestType=="saveToCommon"){
	$styleNo	= $_GET['styleNo'];
	$location 	= $_GET['location'];
	$binId		= $_GET['binId'];
	$mainStoreID= $_GET['mainStoreID'];
	$subStoreID	= $_GET['subStoreID'];
	$buyerPo	= $_GET['buyerPo'];
	$matDetId	= $_GET['matDetId'];
	$color		= $_GET['color'];
	$size		= $_GET['size'];
	$unit		= $_GET['unit'];
	$Qty		= $_GET['Qty'];
	$grnNo		= $_GET['grnNo'];
	$grnNo		= explode('/',$grnNo);
	$tag		=	$_GET['tag'];
	$date		=	date('Y');
	$type		=	$_GET['type'];
	$tbl="";
	$docNO="";
	
	if($tag==0)
	{
		$disNo=0;
		$disNo=disposeNo($companyId);
		$update_SysControl="UPDATE syscontrol SET dblCompleteOrderId='".((int)$disNo+1) ."' WHERE intCompanyID='$companyId';";
		$resUp=$db->RunQuery($update_SysControl);
	}
	
	$docNO=disposeNo($companyId);
	$binDet=getBinId($mainStoreID,$subStoreID);
	while($row=mysql_fetch_array($binDet)){
		$binId		=	$row['strBinID'];
		$location 	=	$row['strLocID'];
	}
	
	if($type=='Dispose'){
		$tbl='stocktransactions_temp';
		saveDetails($styleNo,$location,$binId,$mainStoreID,$subStoreID,$buyerPo,$matDetId,$color,$size,$unit,$Qty,$grnNo,$tag,$date,$docNO,$UserID,$tbl,$type);
	}
	else if($type=='LeftOver'){
				if(moveStockTransaction($styleNo)==1){
					delStockTransaction($styleNo);
				}
			$tbl='stocktransactions';
			saveDetails($styleNo,$location,$binId,$mainStoreID,$subStoreID,$buyerPo,$matDetId,$color,$size,$unit,$Qty,$grnNo,$tag,$date,$docNO,$UserID,$tbl,$type);
		
	}
}

else if($RequestType=="saveToOther"){
	$styleNo	= $_GET['styleNo'];
	$location 	= $_GET['location'];
	$binId		= $_GET['binId'];
	$mainStoreID= $_GET['mainStoreID'];
	$subStoreID	= $_GET['subStoreID'];
	$buyerPo	= $_GET['buyerPo'];
	$matDetId	= $_GET['matDetId'];
	$color		= $_GET['color'];
	$size		= $_GET['size'];
	$unit		= $_GET['unit'];
	$Qty		= $_GET['Qty'];
	$grnNo		= $_GET['grnNo'];
	$grnNo		= explode('/',$grnNo);
	$tag		=	$_GET['tag'];
	$date		=	date('Y');
	$type		=	$_GET['type'];
	$docNo		=	$_GET['docNo'];
	$tg			=	$_GET['tg'];
	$cnt		=	$_GET['cnt'];
	$tbl="";
	
	
	if($tag==0)
	{
		$disNo=0;
		$disNo=disposeNo($companyId);
		$update_SysControl="UPDATE syscontrol SET dblCompleteOrderId='".((int)$disNo+1) ."' WHERE intCompanyID='$companyId';";
		$resUp=$db->RunQuery($update_SysControl);
	}
	
	$docNO=disposeNo($companyId);
	$binDet=getBinId($mainStoreID,$subStoreID);
	while($row=mysql_fetch_array($binDet)){
		$binId		=	$row['strBinID'];
		$location 	=	$row['strLocID'];
	}
	//echo $docNo;
	moveStockTransaction($styleNo);
	if($docNo != 0){
		
					
		
					//delStockTransaction($styleNo);
					$sql_insert="INSERT INTO stocktransactions ( 
					intYear,strMainStoresID,strSubStores,
					strLocation,strBin,intStyleId,strBuyerPoNo,
					intDocumentNo,intDocumentYear,intMatDetailId,
					strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser
					)
					 
					SELECT 
					intYear,strMainStoresID,strSubStores,
					strLocation,strBin,intStyleId,strBuyerPoNo,
					intDocumentNo,intDocumentYear,intMatDetailId,
					strColor,strSize,strType,strUnit,dblQty,
					dtmDate,intUser 
					FROM stocktransactions_temp  
					where intDocumentNo='$docNo' 
		 				and strType='LeftOver' 
						and intStyleId='$styleNo';";
		$result=$db->RunQuery($sql_insert);
		//echo $sql_insert;
		
		if($result==1){
			$sqlDelete="delete  from stocktransactions_temp where intDocumentNo='$docNo' and strType='LeftOver' and intStyleId='$styleNo';";
			$result=$db->RunQuery($sqlDelete);
		}
		$tbl='stocktransactions_temp';
		saveDetails($styleNo,$location,$binId,$mainStoreID,$subStoreID,$buyerPo,$matDetId,$color,$size,$unit,$Qty,$grnNo,$tag,$date,$docNO,$UserID,$tbl,$type,$tg);	  
		
		    
	}
	else{
		if($type=='Dispose'){
		$tbl='stocktransactions_temp';
		saveDetails($styleNo,$location,$binId,$mainStoreID,$subStoreID,$buyerPo,$matDetId,$color,$size,$unit,$Qty,$grnNo,$tag,$date,$docNO,$UserID,$tbl,$type,$tg);
		//delStockTransaction($styleNo);
		}
		else if($type=='LeftOver'){
			//moveStockTransaction($styleNo);
			//delStockTransaction($styleNo);
			$tbl='stocktransactions';
			saveDetails($styleNo,$location,$binId,$mainStoreID,$subStoreID,$buyerPo,$matDetId,$color,$size,$unit,$Qty,$grnNo,$tag,$date,$docNO,$UserID,$tbl,$type,$tg);
		}
	}
	//if($tg==$cnt){
		//moveStockTransaction($styleNo);
		delStockTransaction($styleNo);
	//}
}
else if($RequestType=="sendEmails"){
	$styleId = $_GET["styleId"];
	$sqlQ="select E.strUserEmails from emails  E
			inner join emailconfig EC on EC.intSerialId = E.intPermissionId
			where EC.strFildName='intApprovalForDisposal'";
			$ems="";
		$result=$db->RunQuery($sqlQ);
		while($row=mysql_fetch_array($result)){
			$ems=$row['strUserEmails'];
		}
		//echo $sqlQ;
		$c= strlen($ems);
		$ems=substr($ems,0,$c-1);
	
			$sqlQU="select distinct userId from usercompany  UC 
			where UC.companyId in (SELECT DISTINCT
			mainstores.intCompanyId
			FROM
			mainstores
			Inner Join stocktransactions ON stocktransactions.strMainStoresID = mainstores.strMainID
			WHERE
			stocktransactions.intStyleId =  '".$styleId."')
			and UC.userId in (".$ems.");";
			//echo $sqlQU;
			
		$resultU=$db->RunQuery($sqlQU);
		$userEm="";
		while($row=mysql_fetch_array($resultU)){
			$userId=$row['userId'];
			$sqlEm="SELECT
				useraccounts.UserName
				FROM
				useraccounts
				WHERE
				useraccounts.intUserID =  '".$row['userId']."'";
		$resultEm=$db->RunQuery($sqlEm);
			while($rowEm=mysql_fetch_array($resultEm)){
				$userEm.=$rowEm['UserName'].",";
			}
		}
		$rtn=sendEmailsToStores($userEm,$styleId);
	$ResponseXML.="<RESULT>";	
	$ResponseXML.="<Res><![CDATA[" .$rtn. "]]></Res>\n";
	$ResponseXML.="</RESULT>";
	echo $ResponseXML;
}
	
else if($RequestType=="ConfiremDisposeItems"){
	
	$styleId = $_GET['styleId'];
	
	$sqlMove= "INSERT INTO stocktransactions_dispose (intYear,strMainStoresID,strSubStores,strLocation, strBin, intStyleId, strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize, strType,strUnit ,dblQty,dtmDate, intUser, intGrnNo,intGrnYear,strGRNType)
select intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,
intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType
 from stocktransactions_temp st inner join mainstores ms on 
ms.strMainID = st.strMainStoresID where st.intStyleId='$styleId' and ms.intCompanyId='$companyId' and strType='leftoverDisposal'";
					//echo $sqlMove;
	$resTR=$db->RunQuery($sqlMove);
	if($resTR==1){
		$sqlDelete="delete  from stocktransactions_temp where  strType='leftoverDisposal' and intStyleId='$styleId';";
		//echo $sqlDelete;
		$result=$db->RunQuery($sqlDelete);
		$ResponseXML.="<RESULT>";	
		$ResponseXML.="<Res><![CDATA[" .$result. "]]></Res>\n";
		$ResponseXML.="</RESULT>";
		
	}
	echo $ResponseXML;

}
//--------------start 2011-05-09---------------------------------
else if($RequestType=="loadPendingCompleteData")
{
	$styleId = $_GET["styleId"];
	$ResponseXML .="<LoadPendingOrderData>\n";
	
	$sql = "SELECT st.strBuyerPoNo, st.strColor, st.strSize, st.strUnit, storeslocations.strLocName, storesbins.strBinName, substores.strSubStoresName, mainstores.strName, matitemlist.strItemDescription, concat(st.intGrnYear,'/',st.intGrnNo) AS GRN, orders.strOrderNo, st.intStyleId, Sum(st.dblQty) AS QTY, st.strBin, st.strLocation, st.strSubStores, st.strMainStoresID, matitemlist.intSubCatID, matitemlist.intItemSerial
 FROM stocktransactions AS st Inner Join storeslocations ON storeslocations.strLocID = st.strLocation
  Inner Join storesbins ON storesbins.strBinID = st.strBin Inner Join substores ON substores.strSubID = st.strSubStores 
  Inner Join mainstores ON st.strMainStoresID = mainstores.strMainID 
  Inner Join matitemlist ON st.intMatDetailId = matitemlist.intItemSerial
 Inner Join orders ON st.intStyleId = orders.intStyleId 
WHERE st.intStyleId='$styleId'  and mainstores.intCompanyId ='$companyId' 
group by st.strBuyerPoNo, st.strColor, st.strSize, st.strUnit, storeslocations.strLocName, storesbins.strBinName,
 substores.strSubStoresName, mainstores.strName, matitemlist.strItemDescription, st.intGrnNo, st.intGrnYear, orders.strOrderNo, 
st.intStyleId 
having QTY > 0 ";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML.="<BuyerPoNo><![CDATA[" .$row["strBuyerPoNo"]. "]]></BuyerPoNo>\n";
		$ResponseXML.="<strColor><![CDATA[" .$row["strColor"]. "]]></strColor>\n";
		$ResponseXML.="<strSize><![CDATA[" .$row["strSize"]. "]]></strSize>\n";
		$ResponseXML.="<strUnit><![CDATA[" .$row["strUnit"]. "]]></strUnit>\n";
		$ResponseXML.="<strLocName><![CDATA[" .$row["strLocName"]. "]]></strLocName>\n";
		$ResponseXML.="<strBinName><![CDATA[" .$row["strBinName"]. "]]></strBinName>\n";
		$ResponseXML.="<strSubStoresName><![CDATA[" .$row["strSubStoresName"]. "]]></strSubStoresName>\n";
		$ResponseXML.="<strName><![CDATA[" .$row["strName"]. "]]></strName>\n";
		$ResponseXML.="<strItemDescription><![CDATA[" .$row["strItemDescription"]. "]]></strItemDescription>\n";
		$ResponseXML.="<GRN><![CDATA[" .$row["GRN"]. "]]></GRN>\n";
		$ResponseXML.="<intSubCatID><![CDATA[" .$row["intSubCatID"]. "]]></intSubCatID>\n";
		$ResponseXML.="<intItemSerial><![CDATA[" .$row["intItemSerial"]. "]]></intItemSerial>\n";
		$ResponseXML.="<strOrderNo><![CDATA[" .$row["strOrderNo"]. "]]></strOrderNo>\n";
		$ResponseXML.="<QTY><![CDATA[" .$row["QTY"]. "]]></QTY>\n";
		$ResponseXML.="<strBin><![CDATA[" .$row["strBin"]. "]]></strBin>\n";
		$ResponseXML.="<strLocation><![CDATA[" .$row["strLocation"]. "]]></strLocation>\n";
		$ResponseXML.="<strSubStores><![CDATA[" .$row["strSubStores"]. "]]></strSubStores>\n";
		$ResponseXML.="<strMainStoresID><![CDATA[" .$row["strMainStoresID"]. "]]></strMainStoresID>\n";
		
	}
	$ResponseXML.="</LoadPendingOrderData>";
echo $ResponseXML;
}


function sendEmailsToStores($userEm,$styleId){
global $db;
	$reciever=$userEm;
	$body = "";
	$eml =  new EmailSender();
	$fieldName = "";
	$host=$_SERVER['SERVER_ADDR'];
	$remarks="http://$host/gapro/ordercompletion/storesconfirmation/storesconfirmationReport.php?StyleNo=$styleId";
	$body = "User Comments : $remarks<br><br>";
	$sqlO="SELECT DISTINCT
			orders.strOrderNo
			FROM
			orders
			WHERE
			orders.intStyleId =  '$styleId'";
	$res=$db->RunQuery($sqlO);
	while($row=mysql_fetch_array($res)){
		$orderNo.=$row['strOrderNo']." ";
	}
	$subject = "Disposal Item Completion for Stores confirmation,In Order No :$orderNo";				
	$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
				
	return true;		
}

function saveDetails($styleNo,$location,$binId,$mainStoreID,$subStoreID,$buyerPo,$matDetId,$color,$size,$unit,$Qty,$grnNo,$tag,$date,$docNO,$UserID,$tbl,$type,$tg){
global $db;
$sql_insert="insert into $tbl (strMainStoresID,
						intYear,	
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
						intGrnYear) 
					values(
						'$mainStoreID',
						'".$date."',
						'$subStoreID',
						'$location',
						'$binId',
						'$styleNo',
						'$buyerPo',
						'$docNO',
						'".$date."',
						'$matDetId',
						'$color',
						'$size',
						'$type',
						'$unit',
						'$Qty',
						now(),
						'$UserID',
						'".$grnNo[0]."',
						'".$grnNo[1]."')";
						//echo $sql_insert;
	$res=$db->RunQuery($sql_insert);
	if($res=='1'){
	$ResponseXML .="<OrderCompletion>";		 
		$ResponseXML .= "<det><![CDATA[" . $tg."~".$docNO . "]]></det>\n";	
	$ResponseXML .="</OrderCompletion>";
	echo $ResponseXML;
	}
} 

function disposeNo($comID)
{
	global $db;
	$selectMax="SELECT dblCompleteOrderId FROM syscontrol WHERE intCompanyID='$comID';";
	//echo $selectMax;
	$resMax=$db->RunQuery($selectMax);
	$max=mysql_fetch_array($resMax);
	return $max['dblCompleteOrderId'];
}
function getBinId($mainStore,$subStore){
	global $db;	
	$sql="SELECT
			storesbins.strBinID,
			storesbins.strLocID
			FROM
			storesbins
			WHERE
			storesbins.strMainID =  '$mainStore' AND
			storesbins.strSubID =  '$subStore' ";
			//echo $sql;
	$result=$db->RunQuery($sql);
	return $result;
}
function moveStockTransaction($styleNo){
global $db;	
$sqlMove= "INSERT INTO stocktransactions_history ( 
					intYear,strMainStoresID,strSubStores,
					strLocation,strBin,intStyleId,strBuyerPoNo,
					intDocumentNo,intDocumentYear,intMatDetailId,
					strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser
					)
					 
					SELECT 
					intYear,strMainStoresID,strSubStores,
					strLocation,strBin,intStyleId,strBuyerPoNo,
					intDocumentNo,intDocumentYear,intMatDetailId,
					strColor,strSize,strType,strUnit,dblQty,
					dtmDate,intUser 
					FROM stocktransactions
					WHERE 
					intStyleId='$styleNo' and strType <> 'LeftOver' ;";
				//echo $sqlMove;
	$resTR=$db->RunQuery($sqlMove);
	return  $resTR;
}
function delStockTransaction($styleNo){
global $db;	
		/*$sqlSlct="SELECT st.lngTransactionNo FROM 
					stocktransactions AS st
					Inner Join storeslocations ON storeslocations.strLocID = st.strLocation
					Inner Join storesbins ON storesbins.strBinID = st.strBin
					Inner Join substores ON substores.strSubID = st.strSubStores
					Inner Join mainstores ON st.strMainStoresID = mainstores.strMainID
					Inner Join matitemlist ON st.intMatDetailId = matitemlist.intItemSerial
					Inner Join orders ON st.intStyleId = orders.intStyleId
					WHERE 
					st.intStyleId='$styleNo';";
					$resSlct=$db->RunQuery($sqlSlct);
					
					while($row=mysql_fetch_array($resSlct)){-- '".$row['lngTransactionNo']."' and */
						$sqlDel="delete from stocktransactions where intStyleId='$styleNo'  and strType <> 'leftOver'; ";
						//echo $sqlDel;
						$db->RunQuery($sqlDel);
						//}
}
?>