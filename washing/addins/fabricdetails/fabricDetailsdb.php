<?php
include "../../../Connector.php";

$request=$_GET['req'];
$Buyer	=	$_GET['Buyer'];
$fabUId	=$_GET['fabUId'];
$FabId=$_GET['FabId'];
$FabDSC=$_GET['FabDSC'];
$Style=$_GET['Style'];
$FabContent=$_GET['FabContent'];
$Division=$_GET['Division'];
$Mill=$_GET['Mill'];
$Color=$_GET['Color'];
$WashType=$_GET['WashType'];
$Garment=$_GET['Garment'];
$Factory=$_GET['Factory'];
$data=$_GET['data'];
$Status =$_GET['Status'];

if ($request=="load_fab_str"){
	$sql="select strFabricId from was_outsidewash_fabdetails order by strFabricId; ";
			$results=$db->RunQuery($sql);
			while($row=mysql_fetch_array($results))
			{
				$po_arr.= $row['strFabricId']."|";
			}
			echo $po_arr;
}

else if($request=="saveDet")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="<XMLSave>";
	if(!checkValueExist($FabId)){
    	$ResponseXML .="<Status><![CDATA[" .saveData($Buyer,$FabId,$FabDSC,$Style,$FabContent,$Division,$Mill,$Color,$WashType,$Garment,$Factory,$Status )  . "]]></Status>\n";
		$ResponseXML .="<MSG><![CDATA[Saved successfully]]></MSG>\n";
	}
	else{
		$ResponseXML .="<Status><![CDATA[false]]></Status>\n";
		$ResponseXML .="<MSG><![CDATA['".$FabId."' already exist.]]></MSG>\n";
	}
	$ResponseXML .="</XMLSave>"; 
	echo $ResponseXML;
} 
else if($request=="updateDet")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="<XMLUpdate>";
	
	if(!checkValueExistUP($fabUId,$FabId)){
    	$ResponseXML .="<Status><![CDATA[" .updateData($fabUId,$Buyer,$FabId,$FabDSC,$Style,$FabContent,$Division,$Mill,$Color,$WashType,$Garment,$Factory,$Status )  . "]]></Status>\n";
		$ResponseXML .="<MSG><![CDATA[Updated successfully]]></MSG>\n";
	}
	else{
		$ResponseXML .="<Status><![CDATA[false]]></Status>\n";
		$ResponseXML .="<MSG><![CDATA['".$FabId."' already exist.]]></MSG>\n";
	}
	$ResponseXML .="</XMLUpdate>"; 
	echo $ResponseXML;
} 
else if($request=="delDet"){
	 
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="<XMLDel>";
	
    $ResponseXML .="<Status><![CDATA[" .delDet($fabUId)  . "]]></Status>\n";
	$ResponseXML .="<MSG><![CDATA[Deleted successfully]]></MSG>\n";
	$ResponseXML .="</XMLDel>"; 
	echo $ResponseXML;
}
else if($request=="loadDet"){
	 
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="<XMLLoad>";
	$res=loadDet($fabUId);
	while($row=mysql_fetch_array($res)){
	
		$ResponseXML .="<Buyer><![CDATA[" .$row['intBuyer']  . "]]></Buyer>\n";
		$ResponseXML .="<FabId><![CDATA[" .$row['strFabricId']  . "]]></FabId>\n";
		$ResponseXML .="<FabDes><![CDATA[" .$row['strFabricDsc']   . "]]></FabDes>\n";
		$ResponseXML .="<Style><![CDATA[" .$row['strStyle']   . "]]></Style>\n";
		$ResponseXML .="<Content><![CDATA[" .$row['strFabricContent']   . "]]></Content>\n";
		$ResponseXML .="<Division><![CDATA[" .$row['intDivision']   . "]]></Division>\n";
		$ResponseXML .="<Mill><![CDATA[" .$row['strMill']   . "]]></Mill>\n";
		$ResponseXML .="<Color><![CDATA[" .$row['strColor']   . "]]></Color>\n";
		$ResponseXML .="<WashType><![CDATA[" .$row['intWashType']   . "]]></WashType>\n";
		$ResponseXML .="<Garment><![CDATA[" .$row['intGarment']   . "]]></Garment>\n";
		$ResponseXML .="<Factory><![CDATA[" .$row['intFactory']   . "]]></Factory>\n";
		$ResponseXML .="<Status><![CDATA[" .$row['intStatus']   . "]]></Status>\n";
	}
	$ResponseXML .="</XMLLoad>"; 
	echo $ResponseXML;
}

function saveData($Buyer,$FabId,$FabDSC,$Style,$FabContent,$Division,$Mill,$Color,$WashType,$Garment,$Factory,$Status){
	global $db;
	$SQL="insert into was_outsidewash_fabdetails(intBuyer,strFabricId,strFabricDsc,strStyle,strFabricContent,intDivision,strMill,strColor,intWashType,intGarment,intFactory,dtmDate,intStatus) values('$Buyer','$FabId','$FabDSC','$Style','$FabContent','$Division','$Mill','$Color','$WashType','$Garment','$Factory',now(),$Status);";
	//echo $SQL;
	$res=$db->RunQuery($SQL);
	if($res==1)
		return true;
	else
		return false;
}

function updateData($fabUId,$Buyer,$FabId,$FabDSC,$Style,$FabContent,$Division,$Mill,$Color,$WashType,$Garment,$Factory,$Status){
	global $db;

	$sql="update was_outsidewash_fabdetails set intBuyer=$Buyer,strFabricId='$FabId', strFabricDsc='$FabDSC',strStyle='$Style',strFabricContent='$FabContent',intDivision='$Division',strMill='$Mill',strColor='$Color',intWashType='$WashType',intGarment='$Garment',intFactory='$Factory',dtmDate=now(),intStatus='$Status' where intId=$fabUId;";
	$res=$db->RunQuery($sql);
	if($res==1)
		return true;
	else
		return false;
	
}
function checkValueExist($FabId){
	global $db;
	$sql="select * from was_outsidewash_fabdetails where strFabricId='$FabId';";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
		return true;
	else
		return false;
}
function delDet($fabUId){
	global $db;
	$sql="delete from was_outsidewash_fabdetails where intId='$fabUId';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	if($res==1)
		return true;
	else
		return false;
}
function loadDet($fabUId){
	global $db;
	$sql="select intBuyer,strFabricId,strFabricDsc,strStyle,strFabricContent,intDivision,strMill,strColor,intWashType,intGarment,intFactory,intStatus
from was_outsidewash_fabdetails where intId='$fabUId';";
	return $db->RunQuery($sql);
}
function checkValueExistUP($fabUId,$FabId){
	global $db;
	$sql="select * from was_outsidewash_fabdetails  where intId <> '$fabUId' and strFabricId ='$FabId';";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
		return true;
	else
		return false;
}
?>
