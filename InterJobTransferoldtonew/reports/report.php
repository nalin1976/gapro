<?php
	session_start();
	include "../../Connector.php" ;	
	$backwardseperator 	= "../../";
	$fromStyleId			= $_GET["newStyleID"];
	$toStyleId				= $_GET["oldStyleID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ePlan Web - Style Reports :: Purchase Order</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-size: 12pt}
.style2 {font-size: 14pt}
-->
</style>
</head>


<body>
<table width="1000" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1000" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="15%"><img src="../../images/eplan_logo.png" alt="" width="198" height="47" class="normalfnt" /></td>
              <td width="1%" class="normalfnt">&nbsp;</td>
				 <td align="center" valign="top" width="68%" class="topheadBLACK"><?php
if($intCompany!=0){		
		$SQL = "SELECT strname, CONCAT(straddress1,'.',strAddress2) AS address,
		strStreet,strCity,strCountry
		FROM companies WHERE intCompanyid=$intCompany;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strname"]);
		?><br />
		<span class="bigfntnm1mid"><?php echo ($row["address"]);?><br /><?php echo ($row["strStreet"]."&nbsp;".$row["strCity"]."&nbsp;".$row["strCountry"]);
		}?></span></td>
                 <td width="16%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>  
     <td colspan="5" class="normalfnt2bldBLACKmid">Style Item Transfer From Old Eplan To New Eplan</td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnth2" style="text-align:center">
</td>
  </tr>
 	
    <tr>	
    	<td colspan="3">
		<table width="1100" border="0" cellpadding="0" cellspacing="0" >
	

	<tr>
    	<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
<thead>          
		  <tr height="25" >
            <td width="10" bgcolor="#CCCCCC" class="normalfntBtab"  >&nbsp;</td>
            <td width="100" bgcolor="#CCCCCC" class="normalfntBtab">New Style No</td>
			<td width="50" bgcolor="#CCCCCC" class="normalfntBtab"  >New ScNo</td>
			<td width="100" bgcolor="#CCCCCC" class="normalfntBtab">Old Style No</td>
			<td width="50" bgcolor="#CCCCCC" class="normalfntBtab"  >Old ScNo</td>
            <td width="80" bgcolor="#CCCCCC" class="normalfntBtab"  >Buyer PoNo</td>            
            <td width="25" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="200" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="96" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
			<td width="95" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="28" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="32" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="37" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="52"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
          </tr>
</thead>
<?php 

$detailSql="select intTransferID,
intTransferYear,
strNewStyleID,
intNewSCNO,
strOldStyleID,
intOldSCNO,
strBuyerPoNo,
intMatDetailId,
strItemDescription,
MMC.strID,
strColor,
strSize,
IT.strUnit,
dblUnitPrice,
dblQty 
from itemtransfertoweb IT 
Inner Join matitemlist MIL ON MIL.intItemSerial=IT.intMatDetailId
Inner Join matmaincategory MMC ON MMC.intID=MIL.intMainCatID 
where intTransferID <>0";
if($fromStyleId !="")
	$detailSql .=" AND strNewStyleID ='$fromStyleId'";
if($toStyleId!="")
	$detailSql .=" AND strOldStyleID ='$toStyleId'";	
		
	  	$detailResult = $db->RunQuery($detailSql);
			$checkponoAndYear="";
			 $noLoop =0;
			$rowCount = mysql_num_rows($detailResult);
			while ($details=mysql_fetch_array($detailResult))
			{			 
			 $amount	= $details["dblQty"] * $details["dblUnitPrice"];	
		  	?>
		  
          <tr  onmouseover="this.style.background ='#ECECFF';" onmouseout="this.style.background=''" height="20">	
			<td class="normalfntTAB" style="text-align:center"><?php echo ++$noLoop ?></td>
			<td class="normalfntTAB"><?php echo $details["strNewStyleID"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["intNewSCNO"]; ?></td>
			<td class="normalfntTAB"><?php echo $details["strOldStyleID"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["intOldSCNO"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["strBuyerPoNo"]; ?></td>
	        <td class="normalfntTAB"><?php echo( substr($details["strID"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo $details["strItemDescription"];?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblUnitPrice"],4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($amount,4)); ?></td>
          </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	</table>
	<tr><td width="1298">&nbsp;</td></tr>
<?php
//}
//}
?>

</td></tr></table>
<script type="text/javascript">
function closeWindow() {
	window.close();
}
var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
</body>
</html>
