<?php
session_start();
$xml = simplexml_load_file('../../config.xml');
$backwardseperator = '../../';
$ReportISORequired = $xml->companySettings->ReportISORequired;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Gate Pass - Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {color: #ECE9D8}
-->
</style>
</head>

<body>
<?php
include "../../Connector.php";
$GatepassNo 	= $_GET["GatePassNo"];
$Year 			= $_GET["GatePassYear"]; 

	$SQL_header =	"SELECT 
						GH.intGatePassNo, 
						GH.intGPYear, 
						GH.dtmDate, 			
						GH.intStatus, 			
						GH.intCompany, 
						GH.strDestination, 
						GH.strCategory, 
						(select UA.Name from useraccounts UA where GH.intUserId=UA.intUserID) AS PreparedBy, 
						(select UA.Name from useraccounts UA where GH.intCancelledBy=UA.intUserID) AS CancelledBy,
						GH.strAttention, 
						GH.strRemarks, 
						GH.intNoOfPackages 
						FROM leftover_gatepass AS GH 				
						WHERE intGatePassNo = '$GatepassNo' AND 
						intGPYear ='$Year'";
	$result_header = $db->RunQuery($SQL_header);
	//echo $SQL_header;
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
		$destinationTo		= $row_header["strDestination"];	
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
        <td><?php include '../../reportHeader.php'?></td>
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
					LEFT OVER GATE PASS</td>
        <td width="22%" class="head2BLCK"><?php
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('../../iso.xml');
   						echo  $xmlISO->ISOCodes->StyleIssueReport;
						}          
         ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="15%" class="normalfnth2B">Serial No</td>
        <td width="2%" class="normalfnth2B">:</td>
        <td width="25%" class="normalfnt"><?php echo $PassYear."/".$PassNo; ?></td>
        <td width="16%" class="normalfnt">&nbsp;</td>
        <td width="14%" class="normalfnth2B">Date </td>
        <td width="2%" class="normalfnth2B"> :</td>
        <td width="26%" class="normalfnt"><?php echo $NewDate[2]."-".$NewDate[1]."-".$NewDate[0];?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Destination</td>
        <td class="normalfnth2B">:</td>
        <td valign="top" class="normalfntSM"><p class="normalfnt"><?php 
        
		$xml = simplexml_load_file('../../config.xml');
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

$sqlstore="SELECT DISTINCT strName FROM leftover_gatepass 
INNER JOIN mainstores ON leftover_gatepass.strDestination=mainstores.strMainID 
WHERE intGatePassNo='$GatepassNo' AND intGPYear='$Year'";	
$result=$db->RunQuery($sqlstore);
while($row=mysql_fetch_array($result))
{
	echo $row["strName"];
	break;
}
}
?></p>
        <td valign="top" class="normalfntSM">        
        <td class="normalfnth2B">Time </td>
        <td class="normalfnth2B">: </td>
        <td class="normalfnt"><?php echo $Time;?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Dispatched By </td>
        <td class="normalfnth2B">:</td>
        <td class="normalfntSM">
		<?PHP
/*$sqlstore="SELECT DISTINCT strMainID,strName FROM gatepass 
INNER JOIN mainstores ON gatepass.intCompany=mainstores.intCompanyId 
WHERE intGatePassNo=$GatepassNo AND intGPYear=$Year";*/
if($Status == 1)
 $tblName = 'stocktransactions_leftover';
else
	$tblName = 'stocktransactions_leftover_temp';
 
$sqlstore="SELECT DISTINCT strMainID,strName FROM $tblName ST
INNER JOIN mainstores MS ON ST.strMainStoresID=MS.strMainID 
WHERE intDocumentNo=$GatepassNo AND intDocumentYear=$Year and strType='LGATEPASS'";
	
$result=$db->RunQuery($sqlstore);
while($row=mysql_fetch_array($result))
{
	echo $row["strName"];
	break;
}
		?></td>   
        
        <td valign="top" class="normalfntSM">        
        <td class="normalfnth2B">Attention By</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><span class="normalfntSM"><?PHP echo $attentionBy;?></span></td>
      </tr>
      <tr>
        <td class="normalfnth2B">No Of Packages </td>
        <td class="normalfnth2B">:</td>
        <td class="normalfntSM"><?php echo $noOfPackages;?></td>
        <td valign="top" class="normalfntSM">      
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      
       <tr>
        <td width="15%" class="normalfnth2B">Remarks</td>
        <td width="2%" class="normalfnth2B">:</td>
        <td colspan='5'class="normalfnt"><?php echo $remarks;?></td>        
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
        <td width="43%" height="35" class="normalfntBtab">Description</td>
        <td width="15%" class="normalfntBtab">Color</td>
		<td width="10%" class="normalfntBtab">Size</td>
		<td width="9%" class="normalfntBtab">Unit</td>
        
        <td width="10%" class="normalfntBtab">Qty</td>
		<td width="13%" class="normalfntBtab">Bin Location</td>
        </tr>		
<?php
$sql_header="SELECT distinct 
				GD.intStyleId, 
				O.strOrderNo, 
				GD.strBuyerPONO, 
				B.strName, 
				(select Name from useraccounts UA where UA.intUserID=O.intUserId) AS Merchandiser 
				FROM 
				leftover_gatepassdetails AS GD 
				Inner Join orders AS O ON O.intStyleId = GD.intStyleId 
				Inner Join buyers AS B ON B.intBuyerID = O.intBuyerID 
				WHERE 
				GD.intGatePassNo = '$GatepassNo' AND 
				GD.intGPYear = '$Year';";
		
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
<td colspan="6" class="normalfntTAB">
		<table width="100%" border="0" class="normalfnt2BITAB">
		
          <tr>
            <td width="10%">Order No :</td>
            <td width="16%"><?php echo $row_header["strOrderNo"];?></td>
            <td width="6%">ScNo :</td>
            <td width="7%">
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
            <td width="8%">Buyer PoNo :</td>
            <td width="15%"><?php echo $buyerPoName;?></td>
                <td width="12%">Merchandiser :</td>
                <td width="16%"><?php echo $row_header["Merchandiser"];?></td>              
          </tr>	
		  <tr>
            <td width="8%">Buyer : </td>
            <td colspan="8" ><?php echo $row_header["strName"];?></td>
          </tr>		  
        </table>          </td>
	    </tr>
<?php

$SQL_details = "SELECT 
					matitemlist.intItemSerial, 
					matitemlist.strItemDescription,
					GPD.strColor, 
					GPD.strSize, 
					matitemlist.strUnit, 
					GPD.dblQty 
					FROM 
					leftover_gatepassdetails AS GPD 
					Inner Join matitemlist ON matitemlist.intItemSerial = GPD.intMatDetailId 
					WHERE 
					GPD.intStyleId =  '".$row_header["intStyleId"]."' AND 
					GPD.strBuyerPONO =  '".$row_header["strBuyerPONO"]."' AND 
					GPD.intGatePassNo ='$GatepassNo' AND 
					GPD.intGPYear ='$Year';";

   $result_details = $db->RunQuery($SQL_details);
   while($row_details = mysql_fetch_array($result_details))  
   {
$TotQty += $row_details["dblQty"];
?>
      <tr>
        <td class="normalfntTAB"><?php echo $row_details["strItemDescription"];?></td>
        <td class="normalfntMidTAB"><?php echo $row_details["strColor"];?></td>
        <td class="normalfntMidTAB"><?php echo $row_details["strSize"];?></td>
<?php 
$sqlLoc = "SELECT strLocName,strUnit FROM $tblName as st INNER JOIN storeslocations ON  st.strMainStoresID = storeslocations.strMainID AND  
st.strSubStores = storeslocations.strSubID AND st.strLocation = storeslocations.strLocID
WHERE intDocumentNo ='$GatepassNo' 
AND intDocumentYear = '$Year' 
AND intStyleId = '" . $row_header["intStyleId"] . "' 
AND strBuyerPoNo = '" . $row_header["strBuyerPONO"] . "' 
AND strColor =  '" . $row_details["strColor"] . "' 
AND strSize ='" . $row_details["strSize"] . "' 
AND strType = 'LGATEPASS' 
AND intMatDetailId = '". $row_details["intItemSerial"] ."'";

	$resultLocation = $db->RunQuery($sqlLoc);
	
while($row_Location=mysql_fetch_array($resultLocation))
{      
	$locationName =  $row_Location["strLocName"];
	$unit =  $row_Location["strUnit"];
	break ;
}            
?>
		<td class="normalfntMidTAB"><?php echo $unit;?></td>		
        <td class="normalfntRiteTAB"><?php echo $row_details["dblQty"];?></td>
		<td class="normalfntTAB"><?php  echo $locationName;?></td>
		
        </tr>
	<?php
	   }
	   }
	?>
      <tr>
        <td colspan="4" class="tablezREDMid">Total</td>
        <td class="tablezREDMid"><div align="right"><?php echo $TotQty ;?></div></td>
		 <td class="tablezREDMid"><div align="right"></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="73"><table width="100%" border="0">
      <tr height="10">
	   </tr>
	   <tr>
        <td width="25%" class="bcgl1txt1"><?php echo $PreparedBy;?></td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">Prepared by</td>
        <td class="normalfntMid">Authorized By</td>
        <td class="normalfntMid">Delivered By</td>
        <td class="normalfntMid">Signature</td>
      </tr>
      <tr>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="25%" class="bcgl1txt1"><?php echo $CancelledBy;?></td>
      </tr>
      <tr>
        <td class="normalfntMid">Vehicle No</td>
        <td class="normalfntMid">&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td class="normalfntMid">Canceled By </td>
      </tr>
      <tr>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">Date</td>
        <td class="normalfntMid">Time Out</td>
        <td class="normalfntMid">Time In</td>
        <td class="normalfntMid">Signature Security</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
if($Status==10)
{
	echo "<div style=\"position:absolute;top:120px;left:400px;\"><img src=\"../../images/cancelled.png\" style=\"-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);\" /></div>";
}
else if($Status==0)
{
	echo "<div style=\"position:absolute;top:120px;left:180px;\"><img src=\"../../images/pending.png\"/></div>";
}

function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}
?>