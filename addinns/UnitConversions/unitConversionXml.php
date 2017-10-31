<?php 
session_start();
include "../../Connector.php";
header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$req=$_GET['req'];

if($req=='loadUnit'){
	$unit=$_GET['unit'];
	$result=getUnits($unit);
	$ResponseXML .= "<Units>";
		while($row=mysql_fetch_array($result)){
			$ResponseXML .= "<UnitName><![CDATA[" . $row["strUnit"]  . "]]></UnitName>\n";
		}
	$ResponseXML .= "</Units>";
	echo $ResponseXML;
}

else if($req=='addNew'){
$toUnit		=$_GET['toUnit'];
$fromUnit	=$_GET['fromUnit'];
$factor		=$_GET['factor'];

$sql="Insert into unitconversion(strFromUnit,strToUnit,dblFactor)values('$fromUnit','$toUnit','$factor');";
$res=$db->RunQuery($sql);
$ResponseXML .= "<Result>";	
	if($res==1){
		
		$ResponseXML .= "<Res><![CDATA[TRUE]]></Res>\n";
		$ResponseXML .= "<serial><![CDATA[".getSerial()."]]></serial>\n";
		$ResponseXML .= "<tag><![CDATA[1]]></tag>\n";
	}
$ResponseXML .= "</Result>";	
echo $ResponseXML;
}

else if($req=='updateDet'){
$serial		=$_GET['serial'];
$toUnit		=$_GET['toUnit'];
$fromUnit	=$_GET['fromUnit'];
$factor		=$_GET['factor'];

$sql="UPDATE unitconversion SET  strToUnit='$toUnit', dblFactor='$factor' WHERE strFromUnit='$fromUnit' and intSerialNo='$serial';";
$res=$db->RunQuery($sql);
$ResponseXML .= "<Result>";	
	if($res==1){
		$ResponseXML .= "<Res><![CDATA[TRUE]]></Res>\n";
		$ResponseXML .= "<tag><![CDATA[2]]></tag>\n";
	}
$ResponseXML .= "</Result>";	
echo $ResponseXML;
}

else if($req=="deleteUnit"){
	$serial	=	$_GET['serial'];
	$sql="DELETE FROM unitconversion WHERE intSerialNo='$serial';";
	$res=$db->RunQuery($sql);
$ResponseXML .= "<Result>";	
	if($res==1){
		$ResponseXML .= "<Res><![CDATA[TRUE]]></Res>\n";
	}
$ResponseXML .= "</Result>";	
echo $ResponseXML;
}
function getUnits($unit){
global $db;
	$sql="select strUnit from units where intStatus=1 and strUnit <> '$unit' and strUnit 
			not in (select strToUnit from unitconversion where strFromUnit='$unit') order by strUnit;";
			//echo $sql;
	$res=$db->RunQuery($sql);
	return $res;
}

function getSerial(){
global $db;
	$sql="select max(intSerialNo) M from unitconversion;";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		return $row['M'];
	}
	
}
?>