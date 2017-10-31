<?php
include "../../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId		= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="GetSerialNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$No=0;
	$ResponseXML .="<LoadNo>\n";
	
	$sql="select intCompanyID,dblWasSubOut from syscontrol where intCompanyID='$companyId'";
	$result =$db->RunQuery($sql);	
	$rowcount = mysql_num_rows($result);		
	if ($rowcount > 0)
	{	
		while($row = mysql_fetch_array($result))
		{				
			$No=$row["dblWasSubOut"];
			$NextNo=$No+1;
			$ReturnYear = date('Y');
			$sqlUpdate="UPDATE syscontrol SET dblWasSubOut='$NextNo' WHERE intCompanyID='$companyId';";
			$db->executeQuery($sqlUpdate);
			$ResponseXML .= "<Admin><![CDATA[TRUE]]></Admin>\n";
			$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
			$ResponseXML .= "<Year><![CDATA[".$ReturnYear."]]></Year>\n";
		}
	}
	else
	{
		$ResponseXML .= "<Admin><![CDATA[FALSE]]></Admin>\n";
	}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
elseif($requestType=="URLGetReSerialNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$No=0;
	$ResponseXML .="<LoadNo>\n";
	
	$sql="select intCompanyID,dblWasSubIn from syscontrol where intCompanyID='$companyId'";
	$result =$db->RunQuery($sql);	
	$rowcount = mysql_num_rows($result);		
	if ($rowcount > 0)
	{	
		while($row = mysql_fetch_array($result))
		{				
			$No=$row["dblWasSubIn"];
			$NextNo=$No+1;
			$ReturnYear = date('Y');
			$sqlUpdate="UPDATE syscontrol SET dblWasSubIn='$NextNo' WHERE intCompanyID='$companyId';";
			$db->executeQuery($sqlUpdate);
			$ResponseXML .= "<Admin><![CDATA[TRUE]]></Admin>\n";
			$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
			$ResponseXML .= "<Year><![CDATA[".$ReturnYear."]]></Year>\n";
		}
	}
	else
	{
		$ResponseXML .= "<Admin><![CDATA[FALSE]]></Admin>\n";
	}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
elseif($requestType=="URLSaveHeader")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLSaveHeader>\n";

$aodNo 		 = $_GET["AodNo"];
$aodYear 	 = $_GET["AodYear"];
$styleId 	 = $_GET["StyleId"];
$sCotractor  = $_GET["SCotractor"];
$color 		 = $_GET["Color"];
$qty 		 = $_GET["Qty"];
$purpose 	 = $_GET["Purpose"];
$year 		 = date("Y");
$fFac		 = $_GET['fFac'];
$vNo		 = $_GET['vNo'];
$com		 = $_SESSION["FactoryID"];
$sserial	 = getSSerial($com);

$sql = "insert into was_subcontractout (intAODNo,intAODYear,intStyleId,intSubContractNo,strColor,strPurpose,dblQty,dblBalQty,intSFac,dblSaveSerial,dtmDate,strVehicleNo,intCompanyID,intUser)values('$aodNo','$aodYear','$styleId','$sCotractor','$color','$purpose','$qty','$qty','$fFac','$sserial',now(),'$vNo','$com','$userId')";
//echo $sql;
$result=$db->RunQuery($sql);
	updateSSerial($com);
	
$sqlT="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)values('$year ','1','$styleId','$aodNo','$aodYear','$color','SubOut','-$qty',now(),'$userId','$companyId','$fFac','In');";
$resultU=$db->RunQuery($sqlT);

//echo $sqlT;


if($result)
	$ResponseXML .= "<Result><![CDATA[TRUE]]></Result>\n";
else
	$ResponseXML .= "<Result><![CDATA[FALSE]]></Result>\n";
	
$ResponseXML .="</XMLSaveHeader>\n";
echo $ResponseXML;
}
elseif($requestType=="URLSaveReHeader")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLSaveHeader>\n";

$aodNo 		 = $_GET["AodNo"];
$aodYear 	 = $_GET["AodYear"];
$gpNo 		 = $_GET["GpNo"];
$styleId 	 = $_GET["StyleId"];
$sCotractor  = $_GET["SCotractor"];
$color 		 = $_GET["Color"];
$qty 		 = $_GET["Qty"];
$purpose 	 = $_GET["Purpose"];
$year 		 = date("Y");
$sFac		 = $_GET["sFac"];
$com		 = $_SESSION["FactoryID"];
$sserial	 = getSSerial($com);
//echo $com;
$sql = "insert into was_subcontractin (intAODNo,intAODYear,strGatePassNo,intStyleId,intSubContractNo,strColor,strPurpose,dblQty,dblBalQty,dblSaveSerial,intSFac,dtmDate,intCompanyID,intUser)values('$aodNo','$aodYear','$gpNo','$styleId','$sCotractor','$color','$purpose','$qty','$qty','$sserial','$sFac',now(),'$com','$userId')";
//echo $sql;
$result=$db->RunQuery($sql);

if($result){
	updateSSerial($com);
$sqlT="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)values('$year ','1','$styleId','$aodNo','$aodYear','$color','SubIn','$qty',now(),'$userId','$companyId','$sFac','In');";
$resultU=$db->RunQuery($sqlT);
}
//echo $sqlT;
if($result)
	$ResponseXML .= "<Result><![CDATA[TRUE]]></Result>\n";
else
	$ResponseXML .= "<Result><![CDATA[FALSE]]></Result>\n";
	
$ResponseXML .="</XMLSaveHeader>\n";
echo $ResponseXML;
}

function getSSerial($companyId){
	global $db;
	
	$sql="select dblWasSubSaveSerial from syscontrol where intCompanyID='$companyId';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dblWasSubSaveSerial'];
}

function updateSSerial($companyId){
	global $db;
	
	$sql="update syscontrol set dblWasSubSaveSerial = dblWasSubSaveSerial+1 where intCompanyID='$companyId';";
	$res=$db->RunQuery($sql);
}



?>