<?php ///////////////////////////// Coding by Lahiru Ranagana 2013-08-01 /////////////////////////
session_start();
include "../../Connector.php";
$companyId=$_SESSION["FactoryID"];
$userid=$_SESSION["UserID"];
$RequestType = $_GET["RequestType"];

if(strcmp($RequestType,"loadFactory") == 0)
{
	$SQL = "SELECT C.intCompanyID,C.strName,C.strComCode
			FROM companies C Inner Join usercompany U ON U.companyId = C.intCompanyID
			WHERE U.userId ='$userid' AND C.intSewFactory = 1 ";
	$result = $db->RunQuery($SQL);
	echo "<option value=''>Select one</option>" ;
	while($row = mysql_fetch_array($result))
	{
		if($companyId==$row["intCompanyID"]){
		echo "<option value=\"".$row["intCompanyID"]."\" selected>".trim($row["strComCode"])." - ".trim($row["strName"])."</option>" ;	
		}else{
		echo "<option value=\"".$row["intCompanyID"]."\">".trim($row["strComCode"])." - ".trim($row["strName"])."</option>" ;	
		}		
	}
}
if(strcmp($RequestType,"loadLineNo") == 0)
{
	$SQL = "SELECT PT.intTeamNo,PT.strTeam FROM plan_teams AS PT ORDER BY PT.intTeamNo ASC";
	$result = $db->RunQuery($SQL);
	echo "<option value=''>Select one</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intTeamNo"]."\">".trim($row["strTeam"])."</option>" ;
	}
}
if(strcmp($RequestType,"searchDataPD") == 0)
{
	$srchFactory = $_GET["srchFactory"];
	$lineNo		 = $_GET["lineNo"];
	$tagetDate	 = $_GET["tagetDate"];

echo "<table style='width:913px;' border='0' cellpadding='0' cellspacing='1' id='table2PD' bgcolor='#FFFFFF'>";
		
	
 $SQL = "SELECT
			DATE_FORMAT(D.tmStartTime,'%H.%i')AS tmStartTime24h,
			DATE_FORMAT(D.tmEndTime,'%H.%i')AS tmEndTime24h,
			DATE_FORMAT(D.tmStartTime,'%h:%i %p')AS tmStartTime12h,
			DATE_FORMAT(D.tmEndTime,'%h:%i %p')AS tmEndTime12h,
			O1.strOrderNo,
			O1.intStyleId,
			D.intQty
			
			FROM production_hourlytarget_header AS H
			INNER JOIN production_hourlytarget_details AS D ON H.intHoTaSerial = D.intHoTaSerial
			INNER JOIN orders AS O1 ON O1.intStyleId = D.intStyleId
			WHERE H.dtTargetDate = '$tagetDate' AND H.intFactoryId = $srchFactory AND
			H.intTeamNo = '$lineNo' AND H.intStatus = 1 AND D.intStatus = 1 
			ORDER BY D.tmStartTime ASC,O1.strOrderNo ASC ";
	$totTarQty = 0; $totActQty = 0; $totOtherQty=0;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$tmStartTime24h = $row["tmStartTime24h"];
		$tmEndTime24h	= $row["tmEndTime24h"];
		$tmStartTime12h = $row["tmStartTime12h"];
		$tmEndTime12h	= $row["tmEndTime12h"];
		$targetOrderNo	= $row["strOrderNo"];
		$targetQty		= $row["intQty"];
		$tarFixOrderNo  = $targetOrderNo;
		$tarFixgetQty	= $targetQty;
		$totTarQty	   += $targetQty;
		
	 if($c%2){
	  $rowColor = '#FCF4CD';
	 }else{
	  $rowColor = '#FCF0AB';///fdf6d0
	 }
	
		$resultAct = getActualData($srchFactory,$lineNo,$tagetDate,$tmStartTime24h,$tmEndTime24h);	
		$rowCount = mysql_num_rows($resultAct);
		
		if($rowCount == 0){
		
		echo "<tr height='25' bgcolor='$rowColor'>
			<td width='80' align='center'>$tmStartTime12h</td>
			<td width='80' align='center'>$tmEndTime12h</td>
			<td width='215'>$targetOrderNo</td>
			<td width='80' align='right'>$targetQty &nbsp;</td>			
			<td style='background-color:#FFF;'> </td>				   
			<td width='80' align='center'> </td>
			<td width='285'> </td>
			<td width='80' align='right'> </td>
		  </tr>";	
			
		}else{
				$achTime = "";
				$achOrderNo = "";
				$achQty = "";
		
				$c2 = 1;
				while($rowAct = mysql_fetch_array($resultAct))
				{
					$achTime 	= $rowAct["tarAchTime"];
					$achOrderNo = $rowAct["tarAchOrderNo"];
					$achQty 	= $rowAct["tarAchQty"];
				
				if($c2>1){
					$tmStartTime12h = "";	
					$tmEndTime12h 	= "";
					$targetOrderNo 	= "";
					$targetQty	 	= "";
				}/// more rows  
				
				if($tarFixOrderNo==$achOrderNo && $tarFixgetQty>$achQty){
				$rowColorSub = "#FE6B9E";
				//$rowStyle = "text-decoration:blink"	;
				}else if($tarFixOrderNo!=$achOrderNo){
				$rowColorSub = "#9966FF";	
				$rowStyle = "";
				$totOtherQty += $achQty;
				}else{
				$rowColorSub = "";	
				$rowStyle = "";
				$totActQty += $achQty;
				}
								
				echo "<tr height='25' bgcolor='$rowColor' style='$rowStyle' >
						<td width='80' align='center'>$tmStartTime12h</td>
						<td width='80' align='center'>$tmEndTime12h</td>
						<td width='215'>$targetOrderNo</td>
						<td width='80' align='right'>$targetQty &nbsp;</td>			
						<td style='background-color:#FFF;'> </td>				   
						<td width='80' bgcolor='$rowColorSub' align='center'>$achTime</td>
						<td width='285' bgcolor='$rowColorSub'>$achOrderNo</td>
						<td width='80' bgcolor='$rowColorSub' align='right'>$achQty &nbsp;</td>
					  </tr>";
				$c2++;
				}
		}
	$c++;
	}
echo "</table>";
echo "<input type='hidden' id='hdTotTarQty' value='$totTarQty'>
      <input type='hidden' id='hdTotActQty' value='$totActQty'>
	  <input type='hidden' id='hdTotOtherQty' value='$totOtherQty'>";
}

function getActualData($srchFactory,$lineNo,$tagetDate,$tmStartTime24h,$tmEndTime24h)
{global $db;

$SQL = "SELECT O.strOrderNo AS tarAchOrderNo,DATE_FORMAT(H.dtmTargetAchieve,'%h:%i %p')AS tarAchTime,SUM(D.dblQty) AS tarAchQty
FROM productionlineoutputheader AS H
INNER JOIN productionlineoutdetail AS D ON H.intLineOutputSerial = D.intLineOutputSerial AND H.intLineOutputYear = D.intLineOutputYear
INNER JOIN orders AS O ON O.intStyleId = H.intStyleId
WHERE DATE(H.dtmTargetAchieve) = '$tagetDate' AND H.intFactory = $srchFactory AND H.strTeamNo = $lineNo AND
DATE_FORMAT(H.dtmTargetAchieve,'%H.%i') > $tmStartTime24h AND DATE_FORMAT(H.dtmTargetAchieve,'%H.%i') <= $tmEndTime24h 
GROUP BY H.intStyleId ORDER BY H.dtmTargetAchieve ASC";
return $result = $db->RunQuery($SQL);	
}

if(strcmp($RequestType,"loadBarChart") == 0)
{
header('Content-Type: text/xml'); 
$ResponseXML  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML .= "<loadData>\n";

	
	$srchFactory = $_GET["srchFactory"];
	$lineNo		 = $_GET["lineNo"];
	$tagetDate	 = $_GET["tagetDate"];
	
		$SQL = "SELECT
				DATE_FORMAT(D.tmStartTime,'%H.%i')AS tmStartTime24h,
				DATE_FORMAT(D.tmEndTime,'%H.%i')AS tmEndTime24h,
				DATE_FORMAT(D.tmStartTime,'%h:%i %p')AS tmStartTime12h,
				DATE_FORMAT(D.tmEndTime,'%h:%i %p')AS tmEndTime12h,
				SUM(D.intQty)AS intQty,
				D.intStyleId
				FROM
				production_hourlytarget_header AS H
				INNER JOIN production_hourlytarget_details AS D ON H.intHoTaSerial = D.intHoTaSerial
				WHERE H.dtTargetDate = '$tagetDate' AND H.intFactoryId = $srchFactory AND
				H.intTeamNo = '$lineNo' AND H.intStatus = 1 AND D.intStatus = 1
				GROUP BY D.tmStartTime,D.tmEndTime,D.intStyleId
				ORDER BY D.tmStartTime ASC ";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$tmStartTime12h = $row["tmStartTime12h"];
		$tmEndTime12h	= $row["tmEndTime12h"];
		$tmStartTime24h = $row["tmStartTime24h"];
		$tmEndTime24h	= $row["tmEndTime24h"];
		$targetQty		= $row["intQty"];
		$intStyleId		= $row["intStyleId"];		
		
		$actQty = getActualQty($srchFactory,$lineNo,$tagetDate,$tmStartTime24h,$tmEndTime24h,$intStyleId);
		
		$ResponseXML .= "<tarTime><![CDATA[".$tmEndTime12h."]]></tarTime>\n";
		$ResponseXML .= "<tarQty><![CDATA[".$targetQty."]]></tarQty>\n";
		$ResponseXML .= "<actQty><![CDATA[".$actQty."]]></actQty>\n";
	}
$ResponseXML .= "</loadData>\n";
echo $ResponseXML;	
}

function getActualQty($srchFactory,$lineNo,$tagetDate,$tmStartTime24h,$tmEndTime24h,$intStyleId)
{global $db;
$SQL = "SELECT SUM(D.dblQty) AS achQty
FROM
productionlineoutputheader AS H
INNER JOIN productionlineoutdetail AS D ON H.intLineOutputSerial = D.intLineOutputSerial AND H.intLineOutputYear = D.intLineOutputYear
WHERE
DATE(H.dtmTargetAchieve) = '$tagetDate' AND
H.intFactory = $srchFactory AND
H.strTeamNo = $lineNo AND
DATE_FORMAT(H.dtmTargetAchieve,'%H.%i') > $tmStartTime24h AND
DATE_FORMAT(H.dtmTargetAchieve,'%H.%i') <= $tmEndTime24h AND
H.intStyleId = $intStyleId ";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$achQty = $row["achQty"];		
	}
	
	////// check next rec avalability for point chart///// 
	if(empty($achQty) || $achQty=="" ){
		$SQL = "SELECT COUNT(H.intLineOutputSerial)AS noOfNextRec FROM productionlineoutputheader AS H
				WHERE DATE(H.dtmTargetAchieve) = '$tagetDate' AND H.intFactory = $srchFactory AND H.strTeamNo = $lineNo 
				AND DATE_FORMAT(H.dtmTargetAchieve,'%H.%i') > $tmEndTime24h ";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			$noOfNextRec = $row["noOfNextRec"];		
		}
		if($noOfNextRec>0){
		$achQty = 0;
		}
	}
return $achQty;	
}
?>