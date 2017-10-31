<?php
session_start();
require_once('../../Connector.php');
include "../../production/production.php";	
$request=$_GET['req'];
$user=$_SESSION['UserID'];
$issueNo=$_GET['serial'];
$issueDate=$_GET['issueDate'];
$poNo=$_GET['poNo'];
$year=split('-',$issueDate);
$intCompanyId = $_SESSION["FactoryID"];
$color=$_GET['color'];
$Qty=$_GET['iQty'];

if($request=="saveHeader")
{
	$fromComID = $_GET['fromComID'];
	$sql_selectMax="select syscontrol.dblIssueToWash SERIALNO from syscontrol where syscontrol.intCompanyID='$intCompanyId';";
	//echo $sql_selectMax;
	$sql_max=$db->RunQuery($sql_selectMax);
	$rowMax=mysql_fetch_array($sql_max);
	
	$serial=$rowMax['SERIALNO'] + 1;
		
		$sql_insert="INSERT INTO was_issuedtowashheader (dblIssueNo,intIssueYear,dtmIssueDate,intStyleNo,intStatus,strFComCode,intCompanyID,intUser,strColor,dblQty) VALUES('$serial','".$year[0]."','$issueDate','$poNo','0','$fromComID','$intCompanyId','$user','$color',$Qty);";
		
		//saveTostockTransaction();
		$resInsert=$db->RunQuery($sql_insert);
	//	echo $sql_insert;
		if($resInsert=='1')
		{
			$sql_UpdateSysTab="UPDATE syscontrol SET dblIssueToWash='$serial' where intCompanyID='$intCompanyId'";
			$db->RunQuery($sql_UpdateSysTab);
			echo "1~".$year[0]."/$serial";
		}
		else
		{
			echo "0~".$year[0]."/$serial";
		}
}
if($request=="updateHeader")
{
	$issueID=split('/',$issueNo);
	
	$sql_Update="UPDATE was_issuedtowashheader SET dtmIssueDate='$issueDate',dblQty='$Qty' WHERE dblIssueNo='".$issueID[1]."' AND intIssueYear='".$issueID[0]."';";
	//echo $sql_Update;
	$resUp=$db->RunQuery($sql_Update);
	if($resUp=='1')
		{
			echo "2~$issueNo";
		}
		else
		{
			echo "0~$issueNo";
		}
}
if($request=="saveDetails")
{
	$serial=split('/',$_GET['serial']);
	$color=$_GET['color'] ;
	$size=$_GET['size'];
	$iQty=$_GET['iQty'];
	$tag=$_GET['tag'];
	$fromComId = $_GET["fromComId"];
	$styleNo = $_GET["styleNo"];
	
	if(empty($iQty))
	{
		$iQty='0';
	}
	$sql_chk="SELECT * FROM was_issuedtowashdetails WHERE dblIssueNo='".$serial[1]."' and intIssueYear='".$serial[0]."';";
	$resChk=$db->RunQuery($sql_chk);
	//&& $tag=='0' 
	if(mysql_num_rows($resChk) > 0 )
	{
		$sql_Del="DELETE FROM was_issuedtowashdetails WHERE dblIssueNo='".$serial[1]."' and intIssueYear=".$serial[0].";";
		$resDel=$db->RunQuery($sql_Del);
	}
	$sql_insert="INSERT INTO was_issuedtowashdetails (dblIssueNo,intIssueYear,strColor,dblIssueQty) 
	VALUES('".$serial[1]."','".$serial[0]."','".$color."','$iQty');";
	//echo $sql_insert;
		$resInsert=$db->RunQuery($sql_insert);
		if($resInsert=='1')
		{
			update_production_wip_withoutBserial($intCompanyId,$fromComId,$styleNo,$color,'intIssuedtoWash',$iQty);
			echo 1;
		}
		else
		{
			echo 0;
		}
}
if($request=="confirmRecord"){

	$iNo	=	$_GET['iNo'];
	$iYear	=	$_GET['iYear'];
	$up="update was_issuedtowashheader set intStatus=1 where dblIssueNo='$iNo' and intIssueYear='$iYear';";
	$db->RunQuery($up);
	echo saveTostockTransaction($iNo,$iYear);
}

function saveTostockTransaction($iNo,$iYear){
	global $db;
	
	
	//$sql_insertToTrans="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,strCategory)values('".date('Y')."',1,'$poNo','$serial','".date('Y')."','$color','IWash','-$Qty','$issueDate','$user','$intCompanyId','In');";
	$sql_insertToTransM="insert into was_stocktransactions(intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,
strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)
select intIssueYear,1,intStyleNo,dblIssueNo,intIssueYear,strColor,'IWash',-dblQty,dtmIssueDate,intUser,intCompanyID,strFComCode,'In' 
from was_issuedtowashheader where dblIssueNo='$iNo' and intIssueYear='$iYear';";
//echo $sql_insertToTrans;
	$resM=$db->RunQuery($sql_insertToTransM);
	if($resM==1){
	$sql_insertToTransP="insert into was_stocktransactions(intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,
strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)
select intIssueYear,2,intStyleNo,dblIssueNo,intIssueYear,strColor,'IWash',dblQty,dtmIssueDate,intUser,intCompanyID,strFComCode,'In' 
from was_issuedtowashheader where dblIssueNo='$iNo' and intIssueYear='$iYear';";
//echo $sql_insertToTrans;
	$resP=$db->RunQuery($sql_insertToTransP);

	return $resP;
	}
}
?>