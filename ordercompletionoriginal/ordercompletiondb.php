<?php
	include "../Connector.php";
	include "../EmailSender.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
$userId			= $_SESSION["UserID"];
$companyId  	= $_SESSION["FactoryID"];

if($RequestType=="competeOrders")
{	
	$styleID=$_GET["styleID"];
	$ResponseXML.="<Details>";
	
	$sql = "UPDATE orders SET intStatus = 13,intOrderCompleteBy='$userId', dtmDateCompleteOrder=now() WHERE intStyleId = '$styleID'";
	//echo $sql;
	
	$affrows = $db->AffectedExecuteQuery($sql);
	//GetStockSum($styleID,$companyId);
	 
	if ($affrows > 0)
		$ResponseXML.="<Status><![CDATA[True]]></Status>\n";
	else
		$ResponseXML.="<Status><![CDATA[False]]></Status>\n";
	$ResponseXML.="</Details>";
	echo $ResponseXML;
}

else if($RequestType=="getStyleWiseOrderNum")
{	
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	if ($orderCompletionForAny)
	$userQuery = "";
	else
	$userQuery = " and orders.intUserID =" . $_SESSION["UserID"] ;
	
	$SQL = "select orders.strOrderNo,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus <>13 " . $userQuery." ";
	
		
	if($stytleName != 'Select One')
		$SQL .= " and strStyle='$stytleName' ";
		
		$SQL .= " order by strOrderNo ";	
	
	$result = $db->RunQuery($SQL);
		$str .= " <option value=\"Select One\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}

else if($RequestType=="getStyleWiseSCNum")
{	
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	if ($orderCompletionForAny)
	$userQuery = "";
	else
	$userQuery = " and orders.intUserID =" . $_SESSION["UserID"] ;
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus <>13 " . $userQuery ;
	
		
	if($stytleName != 'Select One')
		$SQL .= " and orders.strStyle='$stytleName' ";
		
		$SQL .= " order by specification.intSRNO desc ";	
	
	//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= " <option value=\"Select One\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<SCNo><![CDATA[" .$str. "]]></SCNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}
#########################################################
else if($RequestType=="getStyles"){
	$ResponseXML="";
	$buyerId = $_GET["buyerId"];
		
	$SQL = "SELECT DISTINCT
			orders.strStyle,
			orders.intStyleId,
			orders.intBuyerID
			from specification 
			inner join orders on specification.intStyleId = orders.intStyleId 
			AND orders.intStatus <>13 and orders.intUserID =" . $_SESSION["UserID"]."";
			if($buyerId != 'Select One'){
			$SQL .=" WHERE orders.intBuyerID =  '$buyerId' ";
			}
			$SQL .=" group by orders.strStyle";
	//echo $SQL;
	
	$result = $db->RunQuery($SQL);
	$str .= " <option value=\"Select One\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		
	}
	$ResponseXML.="<Styles>";	
	$ResponseXML.="<StyleName><![CDATA[" .$str. "]]></StyleName>\n";
	$ResponseXML.="</Styles>";
	echo $ResponseXML;
}
else if($RequestType=="sendEmails"){
$styleId = $_GET["styleId"];
$sqlQ="select E.strUserEmails from emails  E
		inner join emailconfig EC on EC.intSerialId = E.intPermissionId
		where EC.strFildName='intOrderCompletionToStores'";
		//echo $sqlQ;
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
	//echo $userEm;
	$rtn=sendEmailsToStores($userEm,$styleId);
	$ResponseXML.="<RESULT>";	
	$ResponseXML.="<Res><![CDATA[" .$rtn. "]]></Res>\n";
	$ResponseXML.="</RESULT>";
	echo $ResponseXML;
	
}
function sendEmailsToStores($userEm,$styleId){
global $db;
	$reciever=$userEm;
	$body = "";
	$eml =  new EmailSender();
	$fieldName = "";
	$host=$_SERVER['SERVER_ADDR'];
	$remarks="http://$host/gapro/ordercompletion/storesconfirmation/storesconfirmation.php?StyleNo=$styleId";
	$body = "User Comments : $remarks<br><br>";
	$sqlO="SELECT DISTINCT
			orders.strOrderNo
			FROM
			orders
			WHERE
			orders.intStyleId =  '$styleId'";
			//echo $sqlO;
	$res=$db->RunQuery($sqlO);
	while($row=mysql_fetch_array($res)){
		$orderNo.=$row['strOrderNo']." ";
	}
	$subject = "Order Completion for Stores confirmation,In Order No :$orderNo";				
	$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
				
	return true;		
}
##############################################
function GetStockSum($styleID,$companyId)
{
global $db;
$sql="select sum(dblQty)as stockQty,intCompanyId,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,
	intMatDetailId,strColor,strSize,strUnit,intGrnNo,intGrnYear
	from stocktransactions S inner join mainstores M on M.strMainID=S.strMainStoresID where intStyleId='$styleID'
 	GROUP BY intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,intGrnNo,intGrnYear ,
 	strMainStoresID,strSubStores,strLocation,strBin ";
$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		
			$year 		= date('Y');
			$stockQty 	= $row["stockQty"];
			$companyId  = $row["intCompanyId"];
		if($stockQty>0){	
			$sql_common = "select strMainID from mainstores where intCompanyId='$companyId' and intCommonBin=1;";
			
			$result_common = $db->RunQuery($sql_common);
			while($row_common=mysql_fetch_array($result_common))
			{
				$mainStore	= $row_common["strMainID"];
				$subStore	= 90; //asign default substore when insert in left overs
				$location	= 90; //asign default location when insert in left overs
				$bin		= 90; //asign default bin when insert in left overs
			}		
			SaveLeftOverStock($year,$row["intStyleId"],$row["strBuyerPoNo"],$row["intGrnNo"],$row["intGrnYear"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["strUnit"],$row["stockQty"],$mainStore,$subStore,$location,$bin);
		}
	}
	CopyDetailsToStockHistory($styleID);
}


function SaveLeftOverStock($year,$styleId,$buyerPoNo,$documentNo,$documentYear,$matdetailId,$color,$size,$unit,$stockQty,$mainStore,$subStore,$location,$bin)
{

//2010-11-10 save grn no and year as document no and year

global $db;
global $userId;
$sql="insert into stocktransactions 
	(intYear, 
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
	intGrnYear
	)
	values
	('$year',
	'$mainStore', 
	'$subStore', 
	'$location', 
	'$bin', 
	'$styleId', 
	'$buyerPoNo', 
	'$documentNo', 
	'$documentYear', 
	'$matdetailId', 
	'$color', 
	'$size', 
	'LeftOver', 
	'$unit', 
	'$stockQty', 
	now(), 
	'$userId',
	'$documentNo',
	'$documentYear');";
	//echo $sql;
$result=$db->RunQuery($sql);	
}
function CopyDetailsToStockHistory($styleID)
{
global $db;
$sql="insert into stocktransactions_history 
	(lngTransactionNo, 
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
	intGrnYear
	)
	select
	lngTransactionNo, 
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
	intGrnYear
	from stocktransactions
	where intStyleId='$styleID' and strType<>'LeftOver';";
	$result=$db->RunQuery($sql);
	if($result)
		DeleteFromMainStock($styleID);
}
function DeleteFromMainStock($styleID)
{
global $db;
$sql="delete from stocktransactions where intStyleId='$styleID' and strType<>'LeftOver';";
$result=$db->RunQuery($sql);
}
?>