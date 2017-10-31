<?php 
session_start();
include "../Connector.php"; 
$backwardseperator = "../";
$companyId  = $_SESSION["FactoryID"];
$expIssue 	= explode("/",$_GET["No"]);
$intIssueNo = $expIssue[1];
$year 		= $expIssue[0];

		$sql_issu="SELECT nomgatepassheader.dtmDate, nomgatepassheader.strRemarks,nomgatepassheader.strStyleID,nomgatepassheader.intGatepassId,nomgatepassheader.strInstructions,		nomgatepassheader.intUserId, 		nomgatepassheader.intToStores,nomgatepassheader.strAttention,nomgatepassheader.strThrough,nomgatepassheader.intInstructedBy AS instructedBy,nomgatepassheader.intYear,	(SELECT useraccounts.Name FROM useraccounts WHERE nomgatepassheader.intUserId = useraccounts.intUserID)AS preparedby,(SELECT useraccounts.Name FROM useraccounts WHERE nomgatepassheader.intConfirmBy = useraccounts.intUserID)AS confirmedBy,(SELECT mainstores.strName FROM mainstores WHERE mainstores.strMainID = nomgatepassheader.intToStores)AS recever,nomgatepassheader.intStatus,strNoOfPackages	 FROM nomgatepassheader WHERE nomgatepassheader.intGatepassId = $intIssueNo AND nomgatepassheader.intYear = $year";
		$result_issu = $db->RunQuery($sql_issu);		
		while($row=mysql_fetch_array($result_issu))
		{
			$IssueYearnew			= $row["intYear"];		
			$dtmIssuedDate			= $row["dtmDate"];
			$dtIssuedDateNew		= substr($dtmIssuedDate,-19,10);
			$dtIssuedDateNewDate	= substr($dtIssuedDateNew,-2);//date
			$dtIssuedDateNewYear	= substr($dtIssuedDateNew,-10,4);//year
			$dtIssuedDateNewmonth1	= substr($dtIssuedDateNew,-5);
			$dtIssuedDateNewmonth	= substr($dtIssuedDateNewmonth1,-5,2);//month
			$month					= mktime(0,0,0,$dtIssuedDateNewmonth,$dtIssuedDateNewDate,$dtIssuedDateNewYear);
			$intIssueNo				= $row["intGatepassId"];
			$preparedby				= $row["preparedby"];		
			$strProdLineNo			= $row["intToStores"];
			$recever				= $row["recever"];
			$attention 				= $row["strAttention"];
			$through 				= $row["strThrough"];
			$instructedBy 			= $row["instructedBy"];
			$comfirmedBy			= $row["confirmedBy"];
			$instructions 			= $row["strInstructions"];
			$remarks 				= $row["strRemarks"];
			$styleID 				= $row["strStyleID"];
			$Status					= $row["intStatus"];
			$noOfPackages			= $row["strNoOfPackages"];
		}
		$report_companyId=$_SESSION['FactoryID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Normal GatePass Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->

.NormalGPheadRed {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 20px;
	font-weight: bold;
	color: #FF0000;
	margin: 0px;
}
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td colspan="5"><?php include "${backwardseperator}reportHeader.php"; ?></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td class="head2">Normal Gate Pass <span class="NormalGPheadRed"><?php echo ($Status==0 ? "<br/>(THIS IS NOT A VALID GATEPASS)":($Status==10 ? "<br/>(CANCELED GATEPASS)":""))?></span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="2">
      <tr>
        <td width="18%" class="normalfnth2B">Gate Pass No</td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="32%" class="normalfnt"><?php echo $IssueYearnew."/".$intIssueNo;?></td>
        <td width="14%" class="normalfnth2B">Date</td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="34%" class="normalfnt"><?php  echo date('d-M-Y',$month);?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Gate Pass  To</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $strProdLineNo;?></td>
        <td class="normalfnth2B">Ref/Style</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $styleID; ?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Attention</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $attention; ?></td>
        <td class="normalfnth2B">Through</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $through; ?></td>
      </tr>
 		<tr>
        <td class="normalfnth2B">Instructed By</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $instructedBy; ?></td>
        <td class="normalfnth2B">No Of Packages</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $noOfPackages;?></td>
      </tr>
        <tr>
          <td class="normalfnth2B">Remarks</td>
          <td class="normalfnth2B">:</td>
          <td class="normalfnt" colspan="4"><?php echo $remarks; ?></td>
        </tr>
        <tr>
        <td class="normalfnth2B">Special Instructions</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt" colspan="4"><?php echo $instructions; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="55%" height="20" class="normalfntBtab">Details</td>
        <td width="8%" class="normalfntBtab">Unit</td>
        <td width="8%" class="normalfntBtab">Qty</td>
        <td width="8%" class="normalfntBtab">Status</td>
        </tr>
					<?php 
					$sum = 0;
				$sql_oth="SELECT nomgatepassdetail.intMatDetailID AS strItemDescription, nomgatepassdetail.intReturnable,  nomgatepassdetail.dblQty,
				(select strTitle from units where units.intUnitID=nomgatepassdetail.intUnitId)AS Units			
				FROM nomgatepassdetail
				WHERE nomgatepassdetail.intGatepassId = $intIssueNo and intYear='$year'";
			$result_oth = $db->RunQuery($sql_oth);
		while($row=mysql_fetch_array($result_oth ))
		{
		

	?>
        <tr> 
          <td class="normalfntTAB"><?php echo $row["strItemDescription"];?></td>
          <td class="normalfntMidTAB"><?php echo $row["Units"];?></td>
        <td class="normalfntRiteTAB"><?php echo $row["dblQty"]; $sum  += $row["dblQty"];?></td>
        <td class="normalfntMidTAB"><?php 
        
        if ($row["intReturnable"] == 1)
			echo "Returnable"; 
		else 
			echo "Non Returnable";      
        ?></td>
        </tr>
		<?php		
		}
		?>
      <tr>
        <td class="normalfnt2bldBLACKmid">TOTAL</td>
        <td class="normalfnt2bldBLACKmid"></td>
        <td class="normalfntRiteTABb-ANS"><?php echo $sum;?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
  <tr>
    <td colspan="5" class="normalfnt">Received the above quantities and veryfied as correct.</td>
  </tr>
  </tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
         <td width="15%" class="bcgl1txt1"><?php echo $preparedby?></td>        
			<td width="2%">&nbsp;</td>       
        	<td width="15%"  class="bcgl1txt1"><?php echo $comfirmedBy; ?></td>
         <td width="2%">&nbsp;</td>
         <td width="15%"  class="bcgl1txt1">&nbsp;</td>
         <td width="2%">&nbsp;</td>
         <td width="15%"  class="bcgl1txt1">&nbsp;</td>
         <td width="2%">&nbsp;</td>
         <td width="15%"  class="bcgl1txt1">&nbsp;</td>
         <td width="2%">&nbsp;</td>
         <td width="15%"  class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">PREPARED BY</td>       
        <td>&nbsp;</td>        
        <td class="normalfntMid">AUTHORIZED BY</td>
		  <td>&nbsp;</td>
		   <td class="normalfntMid">INSTRUCTED BY</td>		
			<td>&nbsp;</td>
		   <td class="normalfntMid">DELIVERED BY</td>
		   <td>&nbsp;</td>
		   <td class="normalfntMid">RECEIVED BY</td>
		   <td>&nbsp;</td>
		   <td class="normalfntMid">RECEIVED DATE</td>
      </tr>
      <tr>
        <td class="normalfntMidSML"><?php echo $dtmIssuedDate;?></td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
      </tr>
      <tr>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
      </tr>
       
      <tr>
        <td class="normalfntMid">VEHICLE NO:</td>       
        <td colspan="3">&nbsp;</td>        
        <td class="normalfntMid">TIME OUT:</td>
		  <td colspan="3">&nbsp;</td>
		   <td class="normalfntMid">SIGNATURE SECURITY</td>		
			<td colspan="2">&nbsp;</td>
      </tr>

    </table></td>
  
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
?>