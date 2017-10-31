<?php
	include "../../Connector.php";
	$requestType= $_GET["RequestType"];
	$comapany =	$_SESSION["FactoryID"];
	$user		=	$_SESSION['UserID'];
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	if($requestType='saveDets'){
		$ino=$_GET['ino'];
		$ino=split('/',$ino);
		$store=$_GET['store'];
		$dep=$_GET['dep'];
		$poNo=$_GET['poNo'];
		$color=$_GET['color'];
		$qty=$_GET['qty'];
		$sFAC=$_GET['sFAC'];
		$remarks=$_GET['remarks'];
		
		$rNo=getReturnNo($comapany);
		$sql="insert into was_mrnReturn(intRYear,dblRNo,intIYear,dblINo,intStyleId,strColor,intDepartment,intStore,dblQty,strRemarks,intCompanyId,intSFac,dtmDate,intUser)
			  value('".date('Y')."','".$rNo."','$ino[0]','$ino[1]','$poNo','$color','$dep','$store','$qty','$remarks','$comapany','$sFAC',now(),'$user')";
			//echo $sql;  
		$res=$db->RunQuery($sql);
		if($res==1){
			updateSyscontrol($comapany);
			addToWas_Stocktransaction($rNo,date('Y'),$poNo,$color,$qty,$comapany,$remarks,$comapany,$sFAC,$user);
			$ResponseXml.="<Res>";
			$ResponseXml.="<R><![CDATA[True]]></R>";
			$ResponseXml.="<RN><![CDATA[".date('Y')."/$rNo]]></RN>";
			$ResponseXml.="</Res>";
		}
		else{
			$ResponseXml.="<Res>";
			$ResponseXml.="<R><![CDATA[False]]></R>";
			$ResponseXml.="</Res>";
		}
		echo $ResponseXml;
	}
	
	function getReturnNo($comapany){
		global $db;
		$sql="select dblWasIRSerial from syscontrol where intCompanyID='".$comapany."';";
		$res=$db->RunQuery($sql);
		$row=mysql_fetch_array($res);
		return $row['dblWasIRSerial']+1;
	}
	
	
	function addToWas_Stocktransaction($serial,$year,$PONo,$color,$rQty,$factory,$remarks,$factory,$sFactory,$user){
	
		global $db;
		$sql="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intCompanyId,intFromFactory,strCategory,intUser)values('$year ','1','$PONo','$serial','$year','$color','IRtn','$rQty',now(),'$factory','$sFactory','In','$user');";
		//echo $sql;
		return $db->RunQuery($sql);	
	}
	
	function updateSyscontrol($factory){
		global $db;
		$sql="update syscontrol set dblWasIRSerial=dblWasIRSerial+1 where intCompanyID='$factory';";
		return $db->RunQuery($sql);	
	}
?>