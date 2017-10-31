<?php
session_start();
require_once('../../Connector.php');

$request=$_GET['request'];

if($request=="saveData")
{
	$strPreInvNo			="select dblInvFormatId from syscontrol";
	$resultPreInvNo			=$db->RunQuery($strPreInvNo);
	$rowPreInvNo			=mysql_fetch_array($resultPreInvNo);
	$InvFormatId			=$rowPreInvNo["dblInvFormatId"];
	$strUpdatePreInvNo		="update syscontrol set dblInvFormatId=dblInvFormatId+1";
	$resultUpdatePreInvNo	=$db->RunQuery($strUpdatePreInvNo);
	
	$commercial		=$_GET['commercial'];
	$buyer			=$_GET['buyer'];
	$destination	=$_GET['destination'];
	$transport		=$_GET['transport'];
	$ptline1		=$_GET['ptline1'];
	$ptline2		=$_GET['ptline2'];
	$ptline3		=$_GET['ptline3'];
	$ptnotify1		=($_GET['ptnotify1']==""?'null':$_GET['ptnotify1']);
	$ptnotify2		=($_GET['ptnotify2']==""?'null':$_GET['ptnotify2']);
	$ptnotify3		=($_GET['ptnotify3']==""?'null':$_GET['ptnotify3']); 
	$acountee		=($_GET['acountee']==""?'null':$_GET['acountee']);
	$csc			=($_GET['csc']==""?'null':$_GET['csc']); 
	$sold			=($_GET['sold']==""?'null':$_GET['sold']);
	$incoterm		=$_GET['incoterm'];
	$authorise		=($_GET['authorise']==""?'null':$_GET['authorise']); 
	$mline1			=$_GET['mline1'];
	$mline2			=$_GET['mline2'];
	$mline3			=$_GET['mline3'];
	$mline4			=$_GET['mline4'];
	$mline5			=$_GET['mline5'];
	$mline6			=$_GET['mline6'];
	$mline7			=$_GET['mline7'];
	$sline1			=$_GET['sline1'];
	$sline2			=$_GET['sline2'];
	$sline3			=$_GET['sline3'];
	$sline4			=$_GET['sline4'];
	$sline5			=$_GET['sline5'];
	$sline6			=$_GET['sline6'];
	$sline7			=$_GET['sline7'];
	$buyerTitle				=$_GET['buyerTitle'];
	$brokerTitle			=$_GET['brokerTitle'];
	$accounteeTitle			=$_GET['accounteeTitle'];
	$notify1Title			=$_GET['notify1Title'];
	$notify2Title			=$_GET['notify2Title'];
	$CSCTitle				=$_GET['CSCTitle'];
	$soldTitle				=$_GET['soldTitle'];
	$BuyerBank				=$_GET['BuyerBank'];
	$IncoDesc				=$_GET['IncoDesc'];
	$forwader				=$_GET['forwader'];
	
	
	$sql ="INSERT INTO commercialinvformat(intCommercialInvId,	strCommercialInv,intBuyer,intDestination,intTrnsMode,strPtLine1,strPtLine2,
	strPtLine3,intNotify1,intNotify2,intNotify3,intAccountee,intCsc,intDeliveryTo,intIncoTerm,
	intAuthorisedPerson,strMMLine1,strMMLine2,strMMLine3,strMMLine4,strMMLine5,strMMLine6,strMMLine7,strSMLine1,strSMLine2,
	strSMLine3,strSMLine4,strSMLine5,strSMLine6,strSMLine7,strBuyerTitle,strBrokerTitle,strAccounteeTitle,strNotify1Title,strNotify2Title,strCSCTitle,strSoldTitle,strBuyerBank,strIncoDesc,strForwader)
	VALUES ('$InvFormatId', '$commercial','$buyer','$destination','$transport','$ptline1','$ptline2',
	'$ptline3',$ptnotify1,$ptnotify2,$ptnotify3,$acountee,$csc,$sold
	,'$incoterm',$authorise,'$mline1','$mline2','$mline3','$mline4','$mline5','$mline6','$mline7','$sline1','$sline2','$sline3','$sline4','$sline5','$sline6','$sline7','$buyerTitle','$brokerTitle','$accounteeTitle','$notify1Title','$notify2Title','$CSCTitle','$soldTitle','$BuyerBank','$IncoDesc','$forwader');";
	
	$result=$db->RunQuery($sql) ;
		
	
		if($result)
			echo $InvFormatId;
		else
			echo 'error';	
		}	
	
if($request=="updateData")	
{
	$commercialid   =$_GET['commercialid'];
	$commercial		=$_GET['commercial'];
	$buyer			=$_GET['buyer'];
	$destination	=$_GET['destination'];
	$transport		=$_GET['transport'];
	$ptline1		=$_GET['ptline1'];
	$ptline2		=$_GET['ptline2'];
	$ptline3		=$_GET['ptline3'];
	$ptnotify1		=($_GET['ptnotify1']==""?'null':$_GET['ptnotify1']);
	$ptnotify2		=($_GET['ptnotify2']==""?'null':$_GET['ptnotify2']);
	$ptnotify3		=($_GET['ptnotify3']==""?'null':$_GET['ptnotify3']); 
	$acountee		=($_GET['acountee']==""?'null':$_GET['acountee']);
	$csc			=($_GET['csc']==""?'null':$_GET['csc']); 
	$sold			=($_GET['sold']==""?'null':$_GET['sold']);
	$incoterm		=$_GET['incoterm'];
	$authorise		=($_GET['authorise']==""?'null':$_GET['authorise']);
	$mline1			=$_GET['mline1'];
	$mline2			=$_GET['mline2'];
	$mline3			=$_GET['mline3'];
	$mline4			=$_GET['mline4'];
	$mline5			=$_GET['mline5'];
	$mline6			=$_GET['mline6'];
	$mline7			=$_GET['mline7'];
	$sline1			=$_GET['sline1'];
	$sline2			=$_GET['sline2'];
	$sline3			=$_GET['sline3'];
	$sline4			=$_GET['sline4'];
	$sline5			=$_GET['sline5'];
	$sline6			=$_GET['sline6'];
	$sline7			=$_GET['sline7'];
	$buyerTitle				=$_GET['buyerTitle'];
	$brokerTitle			=$_GET['brokerTitle'];
	$accounteeTitle			=$_GET['accounteeTitle'];
	$notify1Title			=$_GET['notify1Title'];
	$notify2Title			=$_GET['notify2Title'];
	$CSCTitle				=$_GET['CSCTitle'];
	$soldTitle				=$_GET['soldTitle'];
	$BuyerBank				=$_GET['BuyerBank'];
	$IncoDesc				=$_GET['IncoDesc'];
	$forwader				=$_GET['forwader'];

		 $sql="UPDATE commercialinvformat SET strCommercialInv='$commercial', intBuyer='$buyer',intDestination='$destination',intTrnsMode='$transport',strPtLine1='$ptline1',strPtLine2='$ptline2',strPtLine3='$ptline3',intNotify1=$ptnotify1,intNotify2=$ptnotify2,intNotify3=$ptnotify3,intAccountee=$acountee,
intCsc=$csc,intDeliveryTo=$sold,intIncoTerm='$incoterm',intAuthorisedPerson=$authorise,strMMLine1='$mline1',strMMLine2='$mline2',strMMLine3='$mline3',strMMLine4='$mline4',strMMLine5='$mline5',strMMLine6='$mline6',strMMLine7='$mline7',strSMLine1='$sline1',strSMLine2='$sline2',strSMLine3='$sline3',strSMLine4='$sline4',strSMLine5='$sline5' ,strSMLine6='$sline6',strSMLine7='$sline7',strBuyerTitle = '$buyerTitle' ,strBrokerTitle = '$brokerTitle' ,strAccounteeTitle = '$accounteeTitle' ,strNotify1Title = '$notify1Title' ,strNotify2Title = '$notify2Title' ,strCSCTitle = '$CSCTitle' ,strSoldTitle = '$soldTitle',strBuyerBank = '$BuyerBank' ,strIncoDesc = '$IncoDesc',strForwader='$forwader' WHERE intCommercialInvId='$commercialid' ;";
				
		$result_update=$db->RunQuery($sql) ;
		
		
		if($result_update)
		{
			echo $commercialid;
		}
		else
		{
			echo 'error';
		}	
del_inv_detail($commercialid);	
	
}

if($request=="deleteData")
{
	$deletecmi		=$_GET['deletecmi'];
	
	$sql ="DELETE FROM commercialinvformat WHERE intCommercialInvId='$deletecmi';";
	
	$result=$db->RunQuery($sql);
	if($result)
	{
		echo"delete";
	}
	else
	{
		echo"error";
	}
}

if($request=="savedetails")
{
	$doc_id		    =$_GET['doc_id'];
	$format_id		=$_GET['format_id'];
	
	$sql ="insert into commercialinvoicedocuments 
	(intFormatId, 
	intDocumentId
	)
	values
	('$format_id', 
	'$doc_id'
	);";
	
	$result=$db->RunQuery($sql);
	if($result)
	{
		echo"saved";
	}
	else
	{
		echo"error";
	}
}

function del_inv_detail($format)
{
	global $db;		
	$sql ="delete from commercialinvoicedocuments where intFormatId = '$format' ";	
	$result=$db->RunQuery($sql);
	
}
?>