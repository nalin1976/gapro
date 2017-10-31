<?php
session_start();
require_once('../../Connector.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
#FTransIn +
#IWash +
#SubOut -
#SubIn +
#IFin 
#1 - MainStore
#2 - SubStore

$ResponseXml='';

if(strcmp($request,'saveDet')==0){
	$PONo		=	$_GET['PONo'];
	$color		=	$_GET['color'];
	$sendQty	=	$_GET['sendQty'];
	$toFactory	=	$_GET['toFactory'];
	$sFactory	=	$_GET['sFactory'];
	$remarks	=	$_GET['remarks'];
	$factory	=	$_SESSION['FactoryID'];
	$user		=	$_SESSION['UserID'];
	$vNo		=	$_GET['vNo'];
	$reason		=	$_GET['reason'];
	$dameges	=	($_GET['dameges']=="true"?1:0);
	
	$sql="select dblWasSOFacGPNo from syscontrol where intCompanyID='".$_SESSION['FactoryID']."';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	$gpNo=$row['dblWasSOFacGPNo']+1;
	$ResponseXml.="<RP>";	
	if(saveDet($gpNo,date('Y'),$PONo,$color,$sendQty,$toFactory,$remarks,$factory,$sFactory,$user,$vNo,$reason,$dameges)==1){
		
		$ResponseXml.="<Res><![CDATA[1]]></Res>";
		$ResponseXml.="<GP><![CDATA[".date('Y').'/'.$gpNo."]]></GP>";
		updateSyscontrol($factory);	
		//moveToTransaction($gpNo,date('Y'),$PONo,$color,$sendQty,$toFactory,$remarks,$factory,$sFactory,$user);
	}
	else{	
		$ResponseXml.="<Res><![CDATA[0]]></Res>\n";
		$ResponseXml.="<GP><![CDATA[".$gpNo."]]></GP>\n";
	}
	$ResponseXml.="</RP>";	
	echo $ResponseXml;
}

if(strcmp($request,"cancelDet")==0){
	$gpno		=	split('/',$_GET['gpno']);
	$reason		=	$_GET['reason'];
	$sql="update was_issuedtootherfactory set intStatus='10',intCanceledBy=".$_SESSION['UserID'].",dtmCancelDate='".date('Y-m-d')."',strCancelReason='$reason' where intYear='$gpno[0]' AND dblGPNo='$gpno[1]';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$ResponseXml.="<Det>";
	if($res)
		$ResponseXml.="<Res><![CDATA[1]]></Res>\n"; 
	else
		$ResponseXml.="<Res><![CDATA[0]]></Res>\n";
		
	$ResponseXml.="</Det>";
	echo $ResponseXml;
}

if(strcmp($request,"confirmDet")==0){
	$gpno		=	split('/',$_GET['gpno']);
	$sql="update was_issuedtootherfactory set intStatus='1',inrConfirmedBy=".$_SESSION['UserID'].",dtmConfirmDate='".date('Y-m-d')."' where intYear='$gpno[0]' AND dblGPNo='$gpno[1]';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	
	$ResponseXml.="<Det>";
	if($res){
		$ResponseXml.="<Res><![CDATA[1]]></Res>\n";
		moveToTransaction($gpno[1],$gpno[0]);//,$PONo,$color,$sendQty,$toFactory,$remarks,$factory,$sFactory,$user
	}
	else
		$ResponseXml.="<Res><![CDATA[0]]></Res>\n";
		
	$ResponseXml.="</Det>";
	echo $ResponseXml;
}

function saveDet($gpNo,$year,$PONo,$color,$sendQty,$toFactory,$remarks,$factory,$sFactory,$user,$vNo,$reason,$dameges){
	global $db;	
	$sqlSave="insert into was_issuedtootherfactory(dblGPNo,intYear,intStyleId,strColor,dblQty,intToFactory,strRemarks,intCompanyId,dtmDate,intSFactory,intUser,strVehicleNo,intReason,intStatus,intDamages) values('$gpNo',$year,'$PONo','$color','$sendQty','$toFactory','$remarks','$factory',now(),'$sFactory',$user,'$vNo','$reason','0','$dameges');";
	//echo $sqlSave;
	return $db->RunQuery($sqlSave);
}

function updateSyscontrol($factory){
	global $db;
	$sql="update syscontrol set dblWasSOFacGPNo=dblWasSOFacGPNo+1 where intCompanyID='$factory';";	
	return $db->RunQuery($sql);	
}

function moveToTransaction($gpNo,$year){
	global $db;//,$PONo,$color,$sendQty,$toFactory,$remarks,$factory,$sFactory,$user
//$sql="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)values('$year ','1','$PONo','$gpNo','$year','$color','FacOut','-$sendQty',now(),'$user','$factory','$sFactory','In');";
	$sql="insert into was_stocktransactions(intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)
SELECT was_issuedtootherfactory.intYear,'1' as Stores,was_issuedtootherfactory.intStyleId,was_issuedtootherfactory.dblGPNo,was_issuedtootherfactory.intYear,was_issuedtootherfactory.strColor,
'FacOut',- was_issuedtootherfactory.dblQty as QTY,now() as DT,was_issuedtootherfactory.intUser as UserID,was_issuedtootherfactory.intCompanyId,was_issuedtootherfactory.intSFactory,'In' from was_issuedtootherfactory where intYear='$year' AND dblGPNo='$gpNo'";	//echo $sql;
	return $db->RunQuery($sql);	
}
?>