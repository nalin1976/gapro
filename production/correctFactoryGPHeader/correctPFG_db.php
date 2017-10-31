<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}Connector.php";
$req=$_GET['req'];

if(strcmp($req,"loadGPFacories")==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML='<det>';
	$gpNo=$_GET['gpNo'];
	
	$sql="select  p.strFromFactory,p.strToFactory 
		  from productionfggpheader p 
		  where concat(p.intGPyear,'/',p.intGPnumber)='$gpNo'";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_assoc($res)){
		$ResponseXML.= "<FromFac><![CDATA[" . $row["strFromFactory"]  . "]]></FromFac>\n";
		$ResponseXML.= "<ToFac><![CDATA[" . $row["strToFactory"]  . "]]></ToFac>\n";
	}
	$ResponseXML.='</det>';
	echo $ResponseXML;
}
if(strcmp($req,"updateDet")==0){
	$gpNo=split('/',$_GET['gpNo']);
	$fromFac=$_GET['fromFac'];
	$toFac=$_GET['toFac'];
	$reason=$_GET['reason'];
	
	$sqlBk="insert into tblproductionfactorygpchangehistory select * from productionfggpheader where intGPyear='$gpNo[0]' and intGPnumber='$gpNo[1]';";
	$db->RunQuery($sqlBk); 
	$sqlUp="update productionfggpheader set strToFactory='$toFac' where strFromFactory='$fromFac' and intGPyear='$gpNo[0]' and intGPnumber='$gpNo[1]';";
	$res=$db->RunQuery($sqlUp); 
	if($res){
		$sql="insert into tblproductionfactorygpchange(intGPYear,dblGPNumber,intFromFac,intToFac,strReason,intUser,dtmDate) 
			  values('$gpNo[0]','$gpNo[1]','$fromFac','$toFac','$reason','".$_SESSION['UserID']."',now());";
	    $res=$db->RunQuery($sql);
		 if($res==1)
		 {
			echo 1;	 
		 }
		 else{
			 echo 2;
		 }
		 
	}
	
}
?>
