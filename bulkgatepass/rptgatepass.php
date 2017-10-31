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
$GatepassNo 	= $_GET["GatePassNo"];
$Year 			= $_GET["GatePassYear"]; 

	$SQL_header =	"SELECT ".
		"GH.intGatePassNo, ".
		"GH.intGatePassYear, ".
		"GH.dtmDate, ".				
		"GH.intStatus, ".			
		"GH.intCompanyId, ".
		"GH.intDestination, ".
		"GH.strCategory, ".
		"(select UA.Name from useraccounts UA where GH.intUserId=UA.intUserID) AS PreparedBy, ".
		"(select UA.Name from useraccounts UA where GH.intCancelledBy=UA.intUserID) AS CancelledBy, ".
		"GH.strAttention, ".
		"GH.strRemarks, ".
		"GH.intNoOfPackages ".
		"FROM bulk_gatepassheader AS GH ".				
		"WHERE intGatePassNo = ".$GatepassNo." AND ".
		"intGatePassYear = ".$Year.";";
	$result_header = $db->RunQuery($SQL_header);
	while($row_header = mysql_fetch_array($result_header))
	{
		$PassNo 			= $row_header["intGatePassNo"];
		$PassYear 			= $row_header["intGatePassYear"];
		$DateTime 			= $row_header["dtmDate"];
		$Date 				= substr($DateTime,-19,10);
		$Time 				= substr($DateTime,-8);
		$NewDate 			= explode("-",$Date);
		$Status				= $row_header["intStatus"];			 
		$PreparedBy			= $row_header["PreparedBy"];
		$CancelledBy		= $row_header["CancelledBy"];
		$attentionBy		= $row_header["strAttention"];
		$destinationTo		= $row_header["intDestination"];	
		$category			= $row_header["strCategory"];	
		$remarks			= $row_header["strRemarks"];
		$report_companyId	= $row_header["intCompanyId"];
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
					BULK GATE PASS</td>
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

$sqlstore="SELECT DISTINCT strName FROM bulk_gatepassheader GH INNER JOIN mainstores MS ON GH.intDestination=MS.strMainID WHERE GH.intGatePassNo=$GatepassNo AND GH.intGatePassYear=$Year";
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
if($Status == 1)
 $tblName = 'stocktransactions_bulk';
else
	$tblName = 'stocktransactions_bulk_temp';
 
$sqlstore="SELECT DISTINCT strMainID,strName FROM $tblName ST INNER JOIN mainstores MS ON ST.strMainStoresID=MS.strMainID WHERE intDocumentNo=$GatepassNo AND intDocumentYear=$Year and strType='GATEPASS'";
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
     <tr> </td>
  </tr>
  <tr>
    <td height="69"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="43%" height="25" >Description</th>
        <th width="15%" >Color</th>
		<th width="10%" >Size</th>
		<th width="9%" >Unit</th>        
        <th width="10%" >Qty</th>
		<th width="13%" >Bin Location</th>
        </tr>		
<?php
 $SQL_details = "select MIL.strUnit,MIL.intItemSerial,MIL.strItemDescription,sum(dblQty)as dblQty,strColor,strSize from bulk_gatepassdetails BGD inner join matitemlist MIL on MIL.intItemSerial=BGD.intMatDetailId 
where BGD.intGatePassNo='$GatepassNo' and BGD.intGatePassYear='$Year'
group by intMatDetailId,intGrnNo,intGRNYear,strColor,strSize";
   $result_details = $db->RunQuery($SQL_details);
   while($row_details = mysql_fetch_array($result_details))  
   {
$TotQty += $row_details["dblQty"];
?>
      <tr class="bcgcolor-tblrowWhite">
        <td class="normalfnt"><?php echo $row_details["strItemDescription"];?></td>
        <td class="normalfnt"><?php echo $row_details["strColor"];?></td>
        <td class="normalfnt"><?php echo $row_details["strSize"];?></td>
<?php 
$sqlLoc = "SELECT strLocName,strUnit FROM $tblName as st INNER JOIN storeslocations ON  st.strMainStoresID = storeslocations.strMainID AND  
st.strSubStores = storeslocations.strSubID AND st.strLocation = storeslocations.strLocID
WHERE intDocumentNo ='$GatepassNo' 
AND intDocumentYear = '$Year' 
AND strColor =  '" . $row_details["strColor"] . "' 
AND strSize ='" . $row_details["strSize"] . "' 
AND strType = 'GATEPASS' 
AND intMatDetailId = '". $row_details["intItemSerial"] ."'";
$resultLocation = $db->RunQuery($sqlLoc);
while($row_Location=mysql_fetch_array($resultLocation))
{      
	$locationName =  $row_Location["strLocName"];
	$unit =  $row_Location["strUnit"];
	break ;
}            
?>
		<td class="normalfnt"><?php echo $unit;?></td>		
        <td class="normalfntRite"><?php echo $row_details["dblQty"];?></td>
		<td class="normalfnt"><?php  echo $locationName;?></td>
        </tr>
	<?php
	   }
	?>
      <tr bgcolor="#CCCCCC">
        <td colspan="4"  class="normalfntMid">Total</td>
        <td class="normalfntRite"><?php echo $TotQty ;?></td>
		 <td class="normalfnt">&nbsp;</td>
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
	echo "<div style=\"position:absolute;top:120px;left:400px;\"><img src=\"../images/cancelled.png\" style=\"-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);\" /></div>";
}
else if($Status==0)
{
	echo "<div style=\"position:absolute;top:120px;left:250px;\"><img src=\"../images/pending.png\"/></div>";
}
?>