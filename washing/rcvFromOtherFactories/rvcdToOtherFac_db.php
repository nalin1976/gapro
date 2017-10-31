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
#FacRCvIn

$ResponseXml='';

if(strcmp($request,'saveDet')==0){
	$GP=$_GET['GPNo'];
	$GPNo=split('/',$GP);
	$PONo=$_GET['PONo'];
	$color=$_GET['color'];
	$rQty=$_GET['rcvQty'];
	$fFactory=$_GET['fFactory'];
	$remarks=$_GET['remarks'];
	$factory=$_SESSION['FactoryID'];
	$sFactory=$_GET['sFactory'];
	$user=$_SESSION['UserID'];
	$reason	=	$_GET['reason'];
	
	$sql="select dblWasROFacSerial from syscontrol where intCompanyID='".$_SESSION['FactoryID']."';";
	
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	$serial=$row['dblWasROFacSerial']+1;
	$ResponseXml.="<RP>";	
	if(saveDet($serial,date('Y'),$GPNo[1],$GPNo[0],$PONo,$color,$rQty,$fFactory,$remarks,$factory,$sFactory,$user,$reason)==1){
		
		$ResponseXml.="<Res><![CDATA[1]]></Res>";
		$ResponseXml.="<serial><![CDATA[".date('Y').'/'.$serial."]]></serial>";
		updateSyscontrol($factory);	
		moveToTransaction($serial,date('Y'),$PONo,$color,$rQty,$factory,$remarks,$factory,$sFactory,$user);
	}
	else{	
		$ResponseXml.="<Res><![CDATA[0]]></Res>\n";
		$ResponseXml.="<serial><![CDATA[".$serial."]]></serial>\n";
	}
	$ResponseXml.="</RP>";	
	echo $ResponseXml;
}

function saveDet($serial,$year,$gpNo,$gpYear,$PONo,$color,$rQty,$fFactory,$remarks,$factory,$sFactory,$user,$reason){
	global $db;	
	$sqlSave="insert into was_rcvdfromfactory(dblSerial,intYear,dblGPNo,intGPYear,intStyleId,strColor,dblQty,intFromFactory,strRemarks,intCompanyId,dtmDate,intSewingFactory,intUser,intReason) values('$serial','$year','$gpNo','$gpYear','$PONo','$color','$rQty','$fFactory','$remarks','$factory',now(),$sFactory,$user,'$reason')";
	//echo $sqlSave;
	return $db->RunQuery($sqlSave);
}

function updateSyscontrol($factory){
	global $db;
	$sql="update syscontrol set dblWasROFacSerial=dblWasROFacSerial+1 where intCompanyID='$factory';";
	
	return $db->RunQuery($sql);	
}

function moveToTransaction($serial,$year,$PONo,$color,$rQty,$factory,$remarks,$factory,$sFactory,$user){
	
	global $db;
	$sql="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intCompanyId,intFromFactory,strCategory,intUser)values('$year ','1','$PONo','$serial','$year','$color','FacRCvIn','$rQty',now(),'$factory','$sFactory','In','$user');";
	//echo $sql;
	return $db->RunQuery($sql);	
}
?>