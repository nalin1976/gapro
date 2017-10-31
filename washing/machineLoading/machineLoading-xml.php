<?php
session_start();
include "../../Connector.php";
//$id="loadGrnHeader";

	$request =  $_GET["request"];
	$sql = $_GET["sql"];
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$id = $row[0];
		$name= $row[1];
		$value.="<option value=\"$id\">$name</option>";
	}
	 
	 echo $value;

	

$id  = $_GET["id"];

if($id=='loadMachType')
{
	$intSerialNo = $_GET["intSerialNo"];
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
		$ResponseXML .="<loadMachType>";
		
		$sql = "SELECT was_machinetype.intMachineId,was_machinetype.strMachineType FROM was_machinetype INNER JOIN was_actualcostheader ON was_machinetype.intMachineId= was_actualcostheader.intMachineType where was_actualcostheader.intSerialNo='$intSerialNo' ORDER BY was_machinetype.strMachineType";	
		        
		$result = $db->RunQuery($sql);
		//echo $sql;
		while($row=mysql_fetch_array($result))
		{
		$ResponseXML .= "<intMachineId><![CDATA[" . trim($row["intMachineId"])  . "]]></intMachineId>\n";
    	$ResponseXML .= "<strMachineType><![CDATA[" . trim($row["strMachineType"])  . "]]></strMachineType>\n";	
		}
		$ResponseXML .="</loadMachType>";
		echo $ResponseXML;
}

if($id=='none'){
echo "<option></option>";
}

if($id=='loadCostID')
{
	$intSerialNo = $_GET["intSerialNo"];
	$cat=$_GET['cat'];
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
		$ResponseXML .="<actualCostHeader>";
		
		//$sql = "SELECT        was_actualcostheader.intSerialNo,was_actualcostheader.dblQty,was_actualcostheader.dblWeight,		was_washtype.strWasType,was_washtype.intWasID,was_actualcostheader.strColor FROM was_actualcostheader INNER JOIN was_washtype ON 		was_actualcostheader.intWashType=was_washtype.intWasID	WHERE was_actualcostheader.intSerialNo = '$intSerialNo' AND was_actualcostheader.intStatus=1";	

		$sql="SELECT
		was_actualcostheader.intSerialNo,
		was_actualcostheader.dblQty,
		was_actualcostheader.dblWeight,
		was_washtype.strWasType,
		was_washtype.intWasID,
		was_actualcostheader.strColor,";
		if($cat==0){
			$sql.=" productionfinishedgoodsreceiveheader.dblTotQty";
			}else{
			$sql.=" was_outsidepo.dblOrderQty";
			}
		$sql.=" FROM was_actualcostheader Inner Join was_washtype ON was_actualcostheader.intWashType = was_washtype.intWasID";
		if($cat==0){
			$sql.=" Inner Join productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceiveheader.intStyleNo = was_actualcostheader.intStyleId";
		}else{
			$sql.=" Inner Join was_outsidepo ON was_actualcostheader.intStyleId = was_outsidepo.intId";
		}
		$sql.="	WHERE was_actualcostheader.intSerialNo = '$intSerialNo' AND was_actualcostheader.intStatus=1;";		        
		$result = $db->RunQuery($sql);
		//echo $sql;
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<intSerialNo><![CDATA[" . trim($row["intSerialNo"])  . "]]></intSerialNo>\n";
			$ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";	
			$ResponseXML .= "<dblWeight><![CDATA[" . trim($row["dblWeight"])  . "]]></dblWeight>\n";
			$ResponseXML .= "<strWashType><![CDATA[" . trim($row["strWasType"])  . "]]></strWashType>\n";
			$ResponseXML .= "<intWasID><![CDATA[" . trim($row["intWasID"])  . "]]></intWasID>\n";
			$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
			$ResponseXML .= "<TotRQty><![CDATA[" . trim($row["dblTotQty"])  . "]]></TotRQty>\n";
		}
		$ResponseXML .="</actualCostHeader>";
		echo $ResponseXML;
}
if($id=="loadPoQty"){
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
		$ResponseXML .="<loadQty>";
	$pono	= $_GET['pono'];
	$cat	= $_GET['cat'];

	//$sql="SELECT orders.intQty,orders.intStyleId FROM orders WHERE orders.intStyleId = '$pono';";
	if($cat==0){
		$sql="SELECT Sum(was_issuedtowashdetails.dblIssueQty) AS TOTR,was_issuedtowashheader.intStyleNo,orders.strOrderNo,orders.intQty FROM was_issuedtowashheader
			Inner Join was_issuedtowashdetails ON was_issuedtowashdetails.dblIssueNo = was_issuedtowashheader.dblIssueNo AND was_issuedtowashheader.intIssueYear = was_issuedtowashdetails.intIssueYear Inner Join orders ON orders.intStyleId = was_issuedtowashheader.intStyleNo WHERE orders.intStyleId  = '$pono' GROUP BY orders.intStyleId ,was_issuedtowashdetails.strColor;";
		}
		else{
		 $sql="SELECT Sum(was_oustside_issuedtowash.dblQty) AS TOTR,was_outsidepo.intPONo AS strOrderNo,was_outsidepo.dblOrderQty AS intQty,was_oustside_issuedtowash.intPoNo FROM was_oustside_issuedtowash Inner Join was_outsidepo ON was_outsidepo.intId = was_oustside_issuedtowash.intPoNo WHERE  was_outsidepo.intId  = '$pono ' GROUP BY was_outsidepo.intId,was_oustside_issuedtowash.strColor;";
			}
			//echo $sql;
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		 $ResponseXML.="<PoQty><![CDATA[" . trim($row["intQty"])  . "]]></PoQty>";
		 $ResponseXML.="<TotRQty><![CDATA[" . trim($row["TOTR"])  . "]]></TotRQty>";
		 $ResponseXML.="<WashQty><![CDATA[" . getwashQTY($pono) . "]]></WashQty>";
	}
	
	$ResponseXML .="</loadQty>";
	echo $ResponseXML;
}
function getwashQTY($pono){
	global $db;
	$qty = 0;
	$sqlW="SELECT DISTINCT
			was_machineloadingdetails.intTotQty  wQTY
			FROM
			was_machineloadingheader
			Inner Join was_machineloadingdetails ON was_machineloadingdetails.intStyleId = was_machineloadingheader.intStyleId 
			AND was_machineloadingdetails.strColor = was_machineloadingheader.strColor
			WHERE
			was_machineloadingheader.intStyleId =  '$pono' AND
			was_machineloadingheader.intStatus =  '1'";
			//echo $sqlW;
	$resW=$db->RunQuery($sqlW);
	while($rowW=mysql_fetch_array($resW)){
		$qty = trim($rowW["wQTY"]);
	}	
	return $qty;
}
//------------------------------------------------------listing----------------------------------------------------------
if($id=="loadLotNumber"){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$po=$_GET['po'];
$costId=$_GET['costId'];
$mcnCat=$_GET['mcnCat'];
$mcnID=$_GET['mcnID'];
$ResponseXML .= "<loadLotNo>";
	$sql="SELECT was_machineloadingheader.intLotNo FROM was_machineloadingheader WHERE was_machineloadingheader.intStyleId =  '$po' AND was_machineloadingheader.intCostId =  '$costId' AND was_machineloadingheader.intMachineType =  '$mcnCat' AND was_machineloadingheader.intMachineId = '$mcnID';";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		$lotNo=$row["intLotNo"]+1;
		$ResponseXML .="<LotNo><![CDATA[" . $lotNo  . "]]></LotNo>";
	}
	$ResponseXML .= "</loadLotNo>";
	echo $ResponseXML;
}

/*if($id=="loadRootCardNumber"){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$po=$_GET['po'];
$costId=$_GET['costId'];
$sql="select max(was_machineloadingheader.intRootCardNo)
		from  was_machineloadingheader 
		where was_machineloadingheader.intStyleId='$po'";
$res=$db->RunQuery($sql);
$latest=$row=mysql_fetch_array($res)

		 "and was_machineloadingheader.intCostId='$costId';";
$ResponseXML .= "<RootCardNumber>";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		$RcNo=$row["intLotNo"]+1;
		$ResponseXML .="<RcNo><![CDATA[" . $lotNo  . "]]></RcNo>";
	}
	$ResponseXML .= "</RootCardNumber>";
	echo $ResponseXML;

}*/
if($id=="loadMachineLoadningGrid")
{
		$fromDate		= $_GET["fromDate"];
		$fromDateToArray= explode('/',$fromDate);
		$formatedfromDate = $fromDateToArray[2]."-".$fromDateToArray[1]."-".$fromDateToArray[0];
		$toDate			= $_GET["toDate"];
		$toDateToArray= explode('/',$toDate);
		$formatedtoDate = $toDateToArray[2]."-".$toDateToArray[1]."-".$toDateToArray[0];
		$costID		    = $_GET["costID"];
		$machineType	= $_GET["machineType"];
		$machine    	= $_GET["machine"];
		$cboMode    	= $_GET["cboMode"];
		 //echo $formatedtoDate;
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<loadMachineLoadningGrid>";
$SQL=  "SELECT orders.strStyle,orders.intStyleId,was_machineloadingheader.intCostId,was_machine.strMachineName,was_machinetype.strMachineType,was_machineloadingheader.intLotNo,was_machineloadingheader.intReWashNo,was_machineloadingheader.tmInTime,was_machineloadingheader.tmOutTime,was_operators.strName,was_shift.strShiftName,
was_machineloadingheader.intRootCardNo,was_machineloadingheader.intStatus,
was_machineloadingheader.dblQty,was_machineloadingheader.dblWeight,was_machineloadingheader.strColor,
was_machineloadingheader.dtmInDate,was_machineloadingheader.dtmOutDate,was_washtype.strWasType,was_machineloadingheader.intMachineType,was_machineloadingheader.intMachineId,was_machineloadingheader.intOperatorId,was_machineloadingheader.intShiftId,was_machineloadingheader.intWashType,orders.strDescription,was_machineloadingheader.intCostId,was_machineloadingheader.intRewashNo,was_machineloadingheader.tmInTime,was_machineloadingheader.tmOutTime,was_machineloadingheader.intStatus,was_machineloadingheader.tmInTime,was_machineloadingheader.tmOutTime
FROM orders INNER JOIN was_machineloadingheader ON was_machineloadingheader.intStyleId=orders.intStyleId
            INNER JOIN was_machine ON was_machineloadingheader.intMachineId=was_machine.intMachineId
			INNER JOIN was_operators ON was_machineloadingheader.intOperatorId= was_operators.intOperatorId
			INNER JOIN was_shift ON was_machineloadingheader.intShiftId = was_shift.intShiftId
			INNER JOIN was_machinetype ON was_machineloadingheader.intMachineType=was_machinetype.intMachineId
			INNER JOIN was_washtype ON was_machineloadingheader.intWashType=was_washtype.intWasID
			WHERE was_machineloadingheader.intStatus='$cboMode'";
			
			if($costID !=""){
			$SQL .= "AND was_machineloadingheader.intCostId='$costID'";
			}
			if($machineType !=""){
			$SQL .= "AND was_machineloadingheader.intMachineType='$machineType'";
			}
			if($machine != ""){
			$SQL .= "AND was_machineloadingheader.intMachineId";
			}
			if($fromDate != ""){
			$SQL .= "AND was_machineloadingheader.dtmInDate>='$formatedfromDate'";
			}
			if($toDate != ""){
			$SQL .= "AND was_machineloadingheader.dtmInDate<='$formatedtoDate'";
			}			


		$result = $db->RunQuery($SQL);
		//echo $SQL;
	    while($row = mysql_fetch_array($result))
		{		
		 $ResponseXML .= "<intMachineType><![CDATA[" . $row["intMachineType"]  . "]]></intMachineType>\n";	
		 $ResponseXML .= "<strMachineType><![CDATA[" . $row["strMachineType"]  . "]]></strMachineType>\n";
         $ResponseXML .= "<intMachineId><![CDATA[" . $row["intMachineId"]  . "]]></intMachineId>\n";
		 $ResponseXML .= "<strMachineName><![CDATA[" . $row["strMachineName"]  . "]]></strMachineName>\n";
		 $ResponseXML .= "<intOperatorId><![CDATA[" . $row["intOperatorId"]  . "]]></intOperatorId>\n";
		 $ResponseXML .= "<operatorName><![CDATA[" . $row["strName"]  . "]]></operatorName>\n";
	     $ResponseXML .= "<intShiftId><![CDATA[" . $row["intShiftId"]  . "]]></intShiftId>\n";
		 $ResponseXML .= "<strShiftName><![CDATA[" . $row["strShiftName"]  . "]]></strShiftName>\n";
		 $dateIn         = $row["dtmInDate"];
		 $dateInArray	 = explode('-',$dateIn);
         $formateddateIn = $dateInArray[2]."/".$dateInArray[1]."/".$dateInArray[0];	 
		 $ResponseXML .= "<dtmInDate><![CDATA[" . $formateddateIn . "]]></dtmInDate>\n";
		 $dateOut        = $row["dtmOutDate"];
		 $dateOutArray	 = explode('-',$dateOut);
         $formateddateOut= $dateOutArray[2]."/".$dateOutArray[1]."/".$dateOutArray[0];	 
		 $ResponseXML .= "<dtmOutDate><![CDATA[" . $formateddateOut  . "]]></dtmOutDate>\n";
		 $ResponseXML .= "<intWashType><![CDATA[" . $row["intWashType"]  . "]]></intWashType>\n";
		 $ResponseXML .= "<strWasType><![CDATA[" . $row["strWasType"]  . "]]></strWasType>\n";
 		 $ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";	
		 $ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		 $ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		 $ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
		 $ResponseXML .= "<intCostId><![CDATA[" . $row["intCostId"]  . "]]></intCostId>\n";
		 $ResponseXML .= "<intCostId><![CDATA[" . $row["intCostId"]  . "]]></intCostId>\n";
 		 $ResponseXML .= "<intLotNo><![CDATA[" . $row["intLotNo"]  . "]]></intLotNo>\n";
		 $ResponseXML .= "<intRootCardNo><![CDATA[" . $row["intRootCardNo"]  . "]]></intRootCardNo>\n";
		 $ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";		
		 $ResponseXML .= "<dblWeight><![CDATA[" . $row["dblWeight"]  . "]]></dblWeight>\n";		
		 $ResponseXML .= "<intRewashNo><![CDATA[" . $row["intRewashNo"]  . "]]></intRewashNo>\n";	
		 $ResponseXML .= "<tmInTime><![CDATA[" . $row["tmInTime"]  . "]]></tmInTime>\n";		
		 $ResponseXML .= "<tmOutTime><![CDATA[" . $row["tmOutTime"]  . "]]></tmOutTime>\n";	
		 $ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";

		 /*
         $tmInTime = $row["tmInTime"];	
		 $tmInArray	 = explode('.',$tmInTime);
		 $tmInTimeHours = $tmInArray[0];
		 $tmInTimeMinutes = $tmInArray[1];
		 $tmINAMPM      = $tmInArray[2];*/
		
		 /*
		 $tmOutTime = $row["tmOutTime"];	
		 $tmOutArray	 = explode('.',$tmOutTime);
		 $tmOutTimeHours = $tmOutArray[0];
		 $tmOutTimeMinutes = $tmOutArray[1];
		 $tmOUTAMPM      = $tmOutArray[2];*/
		 
			 
		 }
		$ResponseXML .= "</loadMachineLoadningGrid>";
		echo $ResponseXML;
}



if($id=="loadMachineLoadingForm")
{
 $status		= $_GET["status"];
 $styleId    	= $_GET["styleId"];

 header('Content-Type: text/xml'); 
 echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
$ResponseXML .= "<loadMachineLoadningForm>";
$SQL=  "SELECT orders.strStyle,
		orders.intStyleId,
		was_machineloadingheader.intCostId,
		was_machine.strMachineName,
		was_machinetype.strMachineType,
		was_machineloadingheader.intLotNo,
		was_machineloadingheader.intReWashNo,
		was_machineloadingheader.tmInTime,
		was_machineloadingheader.tmOutTime,
		was_operators.strName,
		was_shift.strShiftName,
		was_machineloadingheader.intRootCardNo,
		was_machineloadingheader.intRootCardYear,
		was_machineloadingheader.intStatus,
		was_machineloadingheader.strRewashStatus,
		was_machineloadingheader.dblQty,
		was_machineloadingheader.dblWeight,
		was_machineloadingheader.strColor,
		was_machineloadingheader.dtmInDate,
		was_machineloadingheader.dtmOutDate,
		was_washtype.strWasType,
		was_machineloadingheader.intMachineType,
		was_machineloadingheader.intMachineId,
		was_machineloadingheader.intOperatorId,
		was_machineloadingheader.intShiftId,
		was_machineloadingheader.intWashType,
		orders.strDescription,
		orders.strOrderNo,
		was_machineloadingheader.intCostId,
		was_machineloadingheader.tmInTime,
		was_machineloadingheader.tmOutTime,
		was_machineloadingheader.tmInAmPm,
		was_machineloadingheader.tmOutAmPm,
		wpd.strLotNo,
		was_machineloadingheader.intLotNo as batchId
		FROM orders INNER JOIN was_machineloadingheader ON was_machineloadingheader.intStyleId=orders.intStyleId
        INNER JOIN was_machine ON was_machineloadingheader.intMachineId=was_machine.intMachineId
		INNER JOIN was_operators ON was_machineloadingheader.intOperatorId= was_operators.intOperatorId
		INNER JOIN was_shift ON was_machineloadingheader.intShiftId = was_shift.intShiftId
		INNER JOIN was_machinetype ON was_machineloadingheader.intMachineType=was_machinetype.intMachineId
		INNER JOIN was_washtype ON was_machineloadingheader.intWashType=was_washtype.intWasID
		INNER JOIN was_planmachineallocationdetail wpd ON wpd.intBatchId=was_machineloadingheader.intLotNo
		WHERE -- was_machineloadingheader.strRootCardNo='$RootCardNo' AND 
		orders.intStyleId='$styleId' AND was_machineloadingheader.intStatus='$status'
		ORDER BY orders.strStyle";				
	//echo $SQL;
		$result = $db->RunQuery($SQL);
		
	
		while($row = mysql_fetch_array($result))
		{	
		 $ResponseXML .= "<batchId><![CDATA[" . $row["batchId"]  . "]]></batchId>\n";
		 $ResponseXML .= "<LotNo><![CDATA[" . $row["strLotNo"]  . "]]></LotNo>\n";	
		 $ResponseXML .= "<intMachineType><![CDATA[" . $row["intMachineType"]  . "]]></intMachineType>\n";	
		 $ResponseXML .= "<strMachineType><![CDATA[" . $row["strMachineType"]  . "]]></strMachineType>\n";
         $ResponseXML .= "<intMachineId><![CDATA[" . $row["intMachineId"]  . "]]></intMachineId>\n";
		 $ResponseXML .= "<machineOperator><![CDATA[<option value=\"".$row["intOperatorId"]."\">".$row["strName"]."</option>]]></machineOperator>\n";
		 $ResponseXML .= "<strMachineName><![CDATA[" . $row["strMachineName"]  . "]]></strMachineName>\n";
		 $ResponseXML .= "<RewashStatus><![CDATA[" . $row["strRewashStatus"]  . "]]></RewashStatus>\n";
		// $ResponseXML .= "<operatorName><![CDATA[" . $row["strName"]  . "]]></operatorName>\n";
	     $ResponseXML .= "<intShiftId><![CDATA[" . $row["intShiftId"]  . "]]></intShiftId>\n";
		 $ResponseXML .= "<strShiftName><![CDATA[" . $row["strShiftName"]  . "]]></strShiftName>\n";
		 $dateIn         = $row["dtmInDate"];
		 $dateInArray	 = explode('-',$dateIn);
         $formateddateIn = $dateInArray[2]."/".$dateInArray[1]."/".$dateInArray[0];	 
		 $ResponseXML .= "<dtmInDate><![CDATA[" . $formateddateIn . "]]></dtmInDate>\n";
		 $dateOut        = $row["dtmOutDate"];
		 $dateOutArray	 = explode('-',$dateOut);
         $formateddateOut= $dateOutArray[2]."/".$dateOutArray[1]."/".$dateOutArray[0];	 
		 $ResponseXML .= "<dtmOutDate><![CDATA[" . $formateddateOut  . "]]></dtmOutDate>\n";
		 $ResponseXML .= "<intWashType><![CDATA[" . $row["intWashType"]  . "]]></intWashType>\n";
		 $ResponseXML .= "<strWasType><![CDATA[" . $row["strWasType"]  . "]]></strWasType>\n";
 		 $ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";	
		 $ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		 $ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		 $ResponseXML .= "<PoNo><![CDATA[<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>]]></PoNo>\n";
		 $ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
		 $ResponseXML .= "<intCostId><![CDATA[" . $row["intCostId"]  . "]]></intCostId>\n";
		 $ResponseXML .= "<intCostId><![CDATA[" . $row["intCostId"]  . "]]></intCostId>\n";
 		 $ResponseXML .= "<intLotNo><![CDATA[" . $row["intLotNo"]  . "]]></intLotNo>\n";
		 $ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";		
		 $ResponseXML .= "<dblWeight><![CDATA[" . $row["dblWeight"]  . "]]></dblWeight>\n";	
		 $ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";	
         $tmInTime = $row["tmInTime"];	
		 $tmInArray	 = explode('.',$tmInTime);
		 $tmInTimeHours = $tmInArray[0];
		 $tmInTimeMinutes = $tmInArray[1];
		 $tmINAMPM      = $tmInArray[2];
		 $ResponseXML .= "<tmInTimeHours><![CDATA[" . $tmInTimeHours  . "]]></tmInTimeHours>\n";
		 $ResponseXML .= "<tmInTimeMinutes><![CDATA[" . $tmInTimeMinutes  . "]]></tmInTimeMinutes>\n";	
		 $ResponseXML .= "<tmINAMPM><![CDATA[" . $row["tmInAmPm"] . "]]></tmINAMPM>\n";	
		 
		 $tmOutTime = $row["tmOutTime"];	
		 $tmOutArray	 = explode('.',$tmOutTime);
		 $tmOutTimeHours = $tmOutArray[0];
		 $tmOutTimeMinutes = $tmOutArray[1];
		 $tmOUTAMPM      = $tmOutArray[2];
		 $ResponseXML .= "<tmOutTimeHours><![CDATA[" . $tmOutTimeHours  . "]]></tmOutTimeHours>\n";
		 $ResponseXML .= "<tmOutTimeMinutes><![CDATA[" . $tmOutTimeMinutes  . "]]></tmOutTimeMinutes>\n";	
		 $ResponseXML .= "<tmOUTAMPM><![CDATA[" . $row["tmOutAmPm"]  . "]]></tmOUTAMPM>\n";	
	 
		}
		$ResponseXML .= "</loadMachineLoadningForm>";
		echo $ResponseXML;
}
if($request=="Getcolor")
{	
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<GetColor>\n";
$poId		 = $_GET["poId"];

	$SQL="select distinct strColor,intStyleId from was_machineloadingheader 
						where intStatus=1 and intStyleId='$poId'";
	
	$result = $db->RunQuery($SQL);
	$text= "";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<color><![CDATA[" . $row["intStyleId"]  . "]]></color>\n";
		
	}
$ResponseXML .= "</GetColor>";	
echo $ResponseXML;
}

?>