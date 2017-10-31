<?php
session_start();
$xml = simplexml_load_file('../config.xml');
$backwardseperator = '../';
$ReportISORequired = $xml->companySettings->ReportISORequired;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Gate Pass - Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {color: #ECE9D8}
-->
</style>
</head>

<body>
<?php
include "../Connector.php";
 $Gatepass = explode("/",$_GET["cboGatePassNo"]);
 $GatepassNo =$Gatepass[1];
 $Year = $Gatepass[0];

	$SQL_header =	"SELECT ".
		"GH.intGatePassNo, ".
		"GH.intGPYear, ".
		"GH.dtmDate, ".				
		"GH.intStatus, ".			
		"GH.intCompany, ".
		"GH.strTo, ".
		"GH.strCategory, ".
		"(select UA.Name from useraccounts UA where GH.intUserId=UA.intUserID) AS PreparedBy, ".
		"(select UA.Name from useraccounts UA where GH.intCancelledBy=UA.intUserID) AS CancelledBy, ".
		"GH.strAttention, ".
		"GH.strRemarks, ".
		"GH.intNoOfPackages ".
		"FROM gatepass AS GH ".				
		"WHERE intGatePassNo = ".$GatepassNo." AND ".
		"intGPYear = ".$Year.";";
	$result_header = $db->RunQuery($SQL_header);
	while($row_header = mysql_fetch_array($result_header))
	{
		$PassNo 			= $row_header["intGatePassNo"];
		$PassYear 			= $row_header["intGPYear"];
		$DateTime 			= $row_header["dtmDate"];
		$Date 				= substr($DateTime,-19,10);
		$Time 				= substr($DateTime,-8);
		$NewDate 			= explode("-",$Date);
		$Status				= $row_header["intStatus"];			 
		$PreparedBy			= $row_header["PreparedBy"];
		$CancelledBy		= $row_header["CancelledBy"];
		$attentionBy		= $row_header["strAttention"];
		$destinationTo		= $row_header["strTo"];	
		$category			= $row_header["strCategory"];	
		$remarks			= $row_header["strRemarks"];
		$report_companyId	= $row_header["intCompany"];
		$noOfPackages		= $row_header["intNoOfPackages"];
	}
?>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><?php include '../reportHeader.php'?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="20%" height="38" class="head2">&nbsp;</td>
        <td width="58%" class="head2">
		<?php if($category=="I")
				echo "INTERNAL";
			  elseif($category=="E")
			  	echo "EXTERNAL";
		?>
					GATE PASS</td>
        <td width="22%" class="head2BLCK"><?php
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('../iso.xml');
   						echo  $xmlISO->ISOCodes->StyleIssueReport;
						}          
         ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="15%" class="normalfnth3B">Serial No</td>
        <td width="2%" class="normalfnth3B">:</td>
        <td width="25%" class="}
.normalfnt2"><?php echo $PassYear."/".$PassNo; ?></td>
        <td width="16%" class="}
.normalfnt2">&nbsp;</td>
        <td width="14%" class="normalfnth3B">Date </td>
        <td width="2%" class="normalfnth3B"> :</td>
        <td width="26%" class="}
.normalfnt2"><?php echo $NewDate[2]."-".$NewDate[1]."-".$NewDate[0];?></td>
      </tr>
      <tr>
        <td class="normalfnth3B">Destination</td>
        <td class="normalfnth3B">:</td>
        <td valign="top" class="}
.normalfnt2"><p class="normalfnt2"><?php 
        
		$xml = simplexml_load_file('../config.xml');
$AllowSubContractorToGatePass = $xml->styleInventory->AllowSubContractorToGatePass;
if($category=="E"){

$sql="select strSubContractorID,strName from subcontractors  where  strSubContractorID='$destinationTo'";

	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		echo $row["strName"];
	break;
	}
}
elseif($category=="I"){

$sqlstore="SELECT DISTINCT strName FROM gatepass 
INNER JOIN mainstores ON gatepass.strTo=mainstores.strMainID 
WHERE intGatePassNo=$GatepassNo AND intGPYear=$Year";	
$result=$db->RunQuery($sqlstore);
while($row=mysql_fetch_array($result))
{
	echo $row["strName"];
	break;
}
}
?></p>
        <td valign="top" class="normalfntSM1">        
        <td class="normalfnth3B">Time </td>
        <td class="normalfnth3B">: </td>
        <td class="}
.normalfnt2"><?php echo $Time;?></td>
      </tr>
      <tr>
        <td class="normalfnth3B">Dispatched By </td>
        <td class="normalfnth3B">:</td>
        <td class="normalfntSM1">
		<?PHP
/*$sqlstore="SELECT DISTINCT strMainID,strName FROM gatepass 
INNER JOIN mainstores ON gatepass.intCompany=mainstores.intCompanyId 
WHERE intGatePassNo=$GatepassNo AND intGPYear=$Year";*/
if($Status == 1)
 $tblName = 'stocktransactions';
else
	$tblName = 'stocktransactions_temp';
 
$sqlstore="SELECT DISTINCT strMainID,strName FROM $tblName ST
INNER JOIN mainstores MS ON ST.strMainStoresID=MS.strMainID 
WHERE intDocumentNo=$GatepassNo AND intDocumentYear=$Year and strType='SGatePass'";
	
$result=$db->RunQuery($sqlstore);
while($row=mysql_fetch_array($result))
{
	echo $row["strName"];
	break;
}
		?></td>   
        
        <td valign="top" class="normalfntSM1">        
        <td class="normalfnth3B">Attention By</td>
        <td class="normalfnth3B">:</td>
        <td class="}
.normalfnt2"><span class="normalfntSM1"><?PHP echo $attentionBy;?></span></td>
      </tr>
      <tr>
        <td class="normalfnth3B">No Of Packages </td>
        <td class="normalfnth3B">:</td>
        <td class="normalfntSM1"><?php echo $noOfPackages;?></td>
        <td valign="top" class="normalfntSM1">      
        <td class="normalfnth3B">Entry No</td>
        <td class="normalfnth3B">:</td>
        <td class="}
.normalfnt2"><?php echo getEntryNoDetails($GatepassNo,$Year); ?></td>
      </tr>
      
       <tr>
        <td width="15%" class="normalfnth3B">Remarks</td>
        <td width="2%" class="normalfnth3B">:</td>
        <td colspan='5'class="}
.normalfnt2"><?php echo $remarks;?></td>        
      </tr>
      
    </table></td>	
  </tr>
     <tr>  	
    <!--<td colspan="2" class="normalfntRiteSML"><div align="center"><span class="headRed">
	<?PHP 	
			if($Status==1)
				echo "";
			elseif($Status==10)
				echo "THIS IS NOT A VALID REPORT";
			elseif($Status==0)
				echo "NOT APPROVED";
	?></span></div></td>-->
  </tr>
  <tr>
    <td height="69"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
      <td width="15%" height="35" class="normalfntBtab1">Item Code</td>
        <td width="43%" height="35" class="normalfntBtab1">Description</td>
        <td width="15%" class="normalfntBtab1">Color</td>
		<td width="10%" class="normalfntBtab1">Size</td>
		<td width="9%" class="normalfntBtab1">Unit</td>
        
        <td width="10%" class="normalfntBtab1">Qty</td>
		<td width="13%" class="normalfntBtab1">Bin Location</td>
        </tr>		
<?php
$sql_header="SELECT distinct ".
			"GD.intStyleId, ".
			"O.strOrderNo, ".
			"GD.strBuyerPONO, ".
			"B.strName, ".
			"(select Name from useraccounts UA where UA.intUserID=O.intUserId) AS Merchandiser ".
			"FROM ".
			"gatepassdetails AS GD ".
			"Inner Join orders AS O ON O.intStyleId = GD.intStyleId ".
			"Inner Join buyers AS B ON B.intBuyerID = O.intBuyerID ".
			"WHERE ".
			"GD.intGatePassNo =  '$GatepassNo' AND ".
			"GD.intGPYear =  '$Year';";
		
 $result_header = $db->RunQuery($sql_header);
 while($row_header = mysql_fetch_array($result_header))
 {
 	$buyerPONO	 = $row_header["strBuyerPONO"];
	$styleid	 = $row_header["intStyleId"];
	$buyerPoName = $row_header["strBuyerPONO"];
		
	if($buyerPONO != '#Main Ratio#')
		$buyerPoName = getBuyerPOName($styleid,$buyerPONO);
?>
 <tr>
<td colspan="7" class="normalfntTAB1">
		<table width="100%" border="0" class="normalfnt3BITAB">
		
          <tr>
            <td width="11%">Order No :</td>
            <td width="17%"><?php echo $row_header["strOrderNo"];?></td>
            <td width="7%">ScNo :</td>
            <td width="6%">
<?PHP
$sqlscno="select intSRNO from specification where intStyleId='".$row_header["intStyleId"]."';";
$result_scno = $db->RunQuery($sqlscno);
while($row_scno=mysql_fetch_array($result_scno))
{
	$scno = $row_scno["intSRNO"];
	echo $scno;
}
?>
			</td>
            <td width="11%">Buyer PoNo :</td>
            <td width="16%"><?php echo $buyerPoName;?></td>
                <td width="13%">Merchandiser :</td>
                <td width="19%"><?php echo $row_header["Merchandiser"];?></td>              
          </tr>	
		  <tr>
            <td width="11%">Buyer : </td>
            <td colspan="8" ><?php echo $row_header["strName"];?></td>
          </tr>		  
        </table>          </td>
	    </tr>
<?php

$SQL_details = "SELECT ".
				"matitemlist.intItemSerial, ".
				"matitemlist.strItemDescription, ".
				"GPD.strColor, ".
				"GPD.strSize, ".
				"matitemlist.strUnit, ".
				"GPD.dblQty, ".
				"materialratio.materialRatioID ".
				"FROM ".
				"gatepassdetails AS GPD ".
				"Inner Join matitemlist ON matitemlist.intItemSerial = GPD.intMatDetailId ".
				"INNER JOIN materialratio ON GPD.intStyleId = materialratio.intStyleId AND GPD.intMatDetailId = materialratio.strMatDetailID AND GPD.strColor = materialratio.strColor AND GPD.strSize = materialratio.strSize AND GPD.strBuyerPONO = materialratio.strBuyerPONO ".
				"WHERE ".
				"GPD.intStyleId =  '".$row_header["intStyleId"]."' AND ".
				"GPD.strBuyerPONO =  '".$row_header["strBuyerPONO"]."' AND ".
				"GPD.intGatePassNo ='$GatepassNo' AND ".
				"GPD.intGPYear ='$Year';";

   $result_details = $db->RunQuery($SQL_details);
   while($row_details = mysql_fetch_array($result_details))  
   {
$TotQty += $row_details["dblQty"];
?>
      <tr>
       <td class="normalfntTAB1"><?php echo $row_details["materialRatioID"];?></td>
        <td class="normalfntTAB1"><?php echo $row_details["strItemDescription"];?></td>
        <td class="normalfntMidTAB1"><?php echo $row_details["strColor"];?></td>
        <td class="normalfntMidTAB1"><?php echo $row_details["strSize"];?></td>
<?php 
$sqlLoc = "SELECT
specificationdetails.strUnit,
storeslocations.strLocName
FROM
$tblName AS st
INNER JOIN specificationdetails ON st.intStyleId = specificationdetails.intStyleId AND st.intMatDetailId = specificationdetails.strMatDetailID
INNER JOIN storeslocations ON st.strLocation = storeslocations.strLocID AND st.strSubStores = storeslocations.strSubID AND st.strMainStoresID = storeslocations.strMainID
WHERE intDocumentNo ='$GatepassNo' 
AND st.intDocumentYear = '$Year' 
AND st.intStyleId = '" . $row_header["intStyleId"] . "' 
AND st.strBuyerPoNo = '" . $row_header["strBuyerPONO"] . "' 
AND st.strColor =  '" . $row_details["strColor"] . "' 
AND st.strSize ='" . $row_details["strSize"] . "' 
AND st.strType = 'SGatePass' 
AND st.intMatDetailId = '". $row_details["intItemSerial"] ."'";

	$resultLocation = $db->RunQuery($sqlLoc);
while($row_Location=mysql_fetch_array($resultLocation))
{      
	$locationName =  $row_Location["strLocName"];
	$unit =  $row_Location["strUnit"];
	break ;
}            
?>
		<td class="normalfntMidTAB1"><?php echo $unit;?></td>		
        <td class="normalfntRiteTAB1"><?php echo $row_details["dblQty"];?></td>
		<td class="normalfntTAB1"><?php  echo $locationName;?></td>
		
        </tr>
	<?php
	   }
	   }
	?>
      <tr>
        <td colspan="5" class="tablezREDMids">Total</td>
        <td class="tablezREDMids"><div align="right"><?php echo $TotQty ;?></div></td>
		 <td class="tablezREDMids"><div align="right"></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="73"><table width="100%" border="0">
      <tr height="10">
	   </tr>
	   <tr>
        <td width="25%" height="30" class="bcgl1txt3"><?php echo $PreparedBy;?></td>
        <td width="25%" height="30" class="bcgl1txt3">&nbsp;</td>
        <td width="25%" height="30" class="bcgl1txt3">&nbsp;</td>
        <td width="25%" height="30" class="bcgl1txt3">&nbsp;</td>
      </tr>
      
      <tr>
        <td class="normalfntMid1">Prepared by</td>
        <td class="normalfntMid1">Authorized By</td>
        <td class="normalfntMid1">Delivered By</td>
        <td class="normalfntMid1">Signature</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="25%" height="30" class="bcgl1txt3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="25%" height="30" class="bcgl1txt3"><?php echo $CancelledBy;?></td>
      </tr>
      <tr>
        <td class="normalfntMid1">Vehicle No</td>
        <td class="normalfntMid1">&nbsp;</td>
        <td class="normalfntMid1">&nbsp;</td>
        <td class="normalfntMid1">Canceled By </td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="25%" height="30"  class="bcgl1txt3">&nbsp;</td>
        <td width="25%" height="30" class="bcgl1txt3">&nbsp;</td>
        <td width="25%" height="30" class="bcgl1txt3">&nbsp;</td>
        <td width="25%" height="30" class="bcgl1txt3">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid1">Date</td>
        <td class="normalfntMid1">Time Out</td>
        <td class="normalfntMid1">Time In</td>
        <td class="normalfntMid1">Signature Security</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
if($Status==10)
{
	echo "<div style=\"position:absolute;top:120px;left:400px;\"><img src=\"../images/cancelled.png\" style=\"-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);\" /></div>";
}
else if($Status==0)
{
	echo "<div style=\"position:absolute;top:120px;left:180px;\"><img src=\"../images/pending.png\"/></div>";
}

function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

function getEntryNoDetails($GatepassNo,$Year)
{
	global $db;
	$sql = " select distinct gh.strEntryNo from grnheader gh inner join gatepassdetails gpd on 
gh.intGrnNo = gpd.intGrnNo and gh.intGRNYear=gpd.intGRNYear
where gpd.strGRNType='S' and gh.strEntryNo is not null  and gh.strEntryNo <>''
 and gpd.intGatePassNo='$GatepassNo' and gpd.intGPYear='$Year' ";
 	$result=$db->RunQuery($sql);
	$entryNo ='';
	$numRows = mysql_num_rows($result);
	$count=0;
	while($row = mysql_fetch_array($result))
	{
		$count++;
		if($count == $numRows)
			$entryNo .= $row["strEntryNo"].' ';
		else
			$entryNo .= $row["strEntryNo"].', ';	
	}
// echo $sql;
 	return $entryNo;
}
?>