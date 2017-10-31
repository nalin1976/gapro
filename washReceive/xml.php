<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

//load color
if($RequestType=="selectColors")
{
	$style=$_GET['styId'];	
	$ResponseXML .="<xmlDet>";
	$sql_loadColors="SELECT strColor FROM was_machineloadingdetails WHERE intStyleId='$style';";
	$res=$db->RunQuery($sql_loadColors);
	while($row=mysql_fetch_array($res))
	{
		$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"]) . "]]></strColor>\n";
	}
	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
//---------------------------------------------------------------------------------
if($RequestType=="selectDet")
{
	$styId=$_GET['styId'];
	$color=$_GET['color'];
	
	$ResponseXML .="<xmlDet>";
		
	$sql = "SELECT  wm.strColor,C.strName,O.strStyle ,O.strOrderNo ,O.intQty, sum(ws.dblIQty)
			FROM was_issuedheader ws 
			INNER JOIN orders AS O  ON O.intStyleId=ws.intStyleId
			INNER JOIN was_machineloadingdetails AS wm ON O.intStyleId=wm.intStyleId
			INNER JOIN companies AS C ON c.intCompanyID=O.intCompanyID
			WHERE ws.intStyleId='$styId' AND wm.strColor='$color' GROUP BY ws.intStyleId;";
			
	//$sql2="SELECT SUM(dblQty) FROM wash_finishreceive WHERE intStyleId='$styId' AND strColor='$color';";

		       // echo $sql;
	$result = $db->RunQuery($sql);
	//echo $sql;
	if(mysql_num_rows($result)==0)
	{
		$ResponseXML .= "<strTag>0</strTag>\n";
	}
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<strTag>1</strTag>\n";
		$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
		$ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
		$ResponseXML .= "<strOderNo><![CDATA[" . trim($row["strOrderNo"])  . "]]></strOderNo>\n";
		$ResponseXML .= "<POQTY><![CDATA[" . trim($row["intQty"])  . "]]></POQTY>\n";
		$ResponseXML .= "<QTY><![CDATA[" . trim($row["sum(ws.dblIQty)"])  . "]]></QTY>\n";
	}
	
	$sql2="SELECT SUM(dblQty) FROM wash_finishreceive WHERE intStyleId='$styId' AND strColor='$color';";
	$result2 = $db->RunQuery($sql2);
	$row=mysql_fetch_array($result2);
	$ResponseXML .= "<ExistQty><![CDATA[" . trim($row["SUM(dblQty)"])  . "]]></ExistQty>\n";

		       // echo $sql;
	$result = $db->RunQuery($sql);
	

	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
//--------------------------------------------------------------------
if($RequestType=="saveDet")
{
	$year = $_GET["year"];
	$date = $_GET["dtmDate"];
	$color = $_GET["color"];
	$rcvQty = $_GET["rcvQty"];
	$style = $_GET["style"];
	
	//$fgRcvDateArray		= explode('/',$date);
	//$date = $fgRcvDateArray[2]."-".$fgRcvDateArray[1]."-".$fgRcvDateArray[0];


		$sql_GetMax="SELECT MAX(dblWashReceive) SERIALNO FROM syscontrol;";
		$resMax=$db->RunQuery($sql_GetMax);
		$row=mysql_fetch_array($resMax);
		$washRcvNo=$row['SERIALNO']+1;
		$upSysControl="UPDATE syscontrol SET dblWashReceive='$washRcvNo';";
		$sqlUpSys=$db->RunQuery($upSysControl);
		
		$sql_save="INSERT INTO 
					wash_finishreceive(intWashFinRecNO,intWashFinRecYear,intStyleId,dtmReceiveDate,strColor,dblQty)
					VALUE
					('$washRcvNo','$year','$style','$date','$color','$rcvQty')";	
					//echo $sql_save;
		$res=$db->RunQuery($sql_save);
		
	 if($res!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[True]]></SaveDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveDetail><![CDATA[False]]></SaveDetail>\n";
	 }
	 
	 echo $ResponseXML;
}
//--------Update------------------------------------------------------------
if($RequestType=="updateDet")
{
	$washRcvNo = $_GET["washRcvNo"];
	$washRcvYear = $_GET["washRcvYear"];

	$date = $_GET["dtmDate"];
	$color = $_GET["color"];
	$rcvQty = $_GET["rcvQty"];
	$style = $_GET["style"];
		
		$sql_update="UPDATE wash_finishreceive SET dtmReceiveDate='$date', dblQty='$rcvQty' WHERE intWashFinRecNO='$washRcvNo' AND intWashFinRecYear='$washRcvYear'";		
		
		$res=$db->RunQuery($sql_update);
		
	 if($res!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[UpdateTrue]]></SaveDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveDetail><![CDATA[UpdateFalse]]></SaveDetail>\n";
	 }
	 
	 echo $ResponseXML;
}
//---------------------------------------------------------------------------------
if($RequestType=="LoadHeaderToSerial")
{
	$washRcvNo=$_GET['serialNo'];
	$washRcvYear=$_GET['year'];
	
	$ResponseXML .="<xmlDet>";
		
	$sql = "SELECT  wm.strColor,C.strName,O.strStyle ,O.strOrderNo ,O.intQty, ws.dblQty, O.intCompanyID,ws.intStyleId, ws.dtmReceiveDate 
			FROM wash_finishreceive ws 
			INNER JOIN orders AS O  ON O.intStyleId=ws.intStyleId
			INNER JOIN was_machineloadingdetails AS wm ON O.intStyleId=wm.intStyleId
			INNER JOIN companies AS C ON c.intCompanyID=O.intCompanyID
			WHERE ws.intWashFinRecNO='$washRcvNo' AND ws.intWashFinRecYear='$washRcvYear' GROUP BY ws.intStyleId;";
			
	//$sql2="SELECT SUM(dblQty) FROM wash_finishreceive WHERE intStyleId='$styId' AND strColor='$color';";

		       // echo $sql;
	$result = $db->RunQuery($sql);
	//echo $sql;
	if(mysql_num_rows($result)==0)
	{
		$ResponseXML .= "<strTag>0</strTag>\n";
	}
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<strTag>1</strTag>\n";
		$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
		$ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
		$ResponseXML .= "<compId><![CDATA[" . trim($row["intCompanyID"])  . "]]></compId>\n";
		$ResponseXML .= "<styleId><![CDATA[" . trim($row["intStyleId"])  . "]]></styleId>\n";
		$ResponseXML .= "<strOderNo><![CDATA[" . trim($row["strOrderNo"])  . "]]></strOderNo>\n";
		$ResponseXML .= "<POQTY><![CDATA[" . trim($row["intQty"])  . "]]></POQTY>\n";
		$ResponseXML .= "<QTY><![CDATA[" . trim($row["dblQty"])  . "]]></QTY>\n";
		$ResponseXML .= "<date><![CDATA[" . trim($row["dtmReceiveDate"])  . "]]></date>\n";
		
		$styleId=trim($row["intStyleId"]) ;
		$color=trim($row["strColor"]);
	}
	
	$sql2="SELECT SUM(dblQty) FROM wash_finishreceive WHERE intStyleId='$styleId' AND strColor='$color' AND intWashFinRecNO !='$washRcvNo';";
	$result2 = $db->RunQuery($sql2);
	$row=mysql_fetch_array($result2);
	$ResponseXML .= "<ExistQty><![CDATA[" . trim($row["SUM(dblQty)"])  . "]]></ExistQty>\n";

	 $sql3 = "SELECT  wm.strColor,C.strName,O.strStyle ,O.strOrderNo ,O.intQty, sum(ws.dblIQty)
			FROM was_issuedheader ws 
			INNER JOIN orders AS O  ON O.intStyleId=ws.intStyleId
			INNER JOIN was_machineloadingdetails AS wm ON O.intStyleId=wm.intStyleId
			INNER JOIN companies AS C ON c.intCompanyID=O.intCompanyID
			WHERE ws.intStyleId='$styleId' AND wm.strColor='$color' GROUP BY ws.intStyleId;";
			
	$result3 = $db->RunQuery($sql3);
	$row=mysql_fetch_array($result3);
	$ResponseXML .= "<WashQty><![CDATA[" . trim($row["sum(ws.dblIQty)"])  . "]]></WashQty>\n";

	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}

?>