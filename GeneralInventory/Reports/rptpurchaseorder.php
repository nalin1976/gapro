<?php
	session_start();
	include "../../Connector.php" ;	
	$backwardseperator 	= "../../";
	$strStyleNo			= $_GET["strStyleNo"];
	$strBPo				= $_GET["strBPo"];
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$intBuyer 	  		= $_GET["intBuyer"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$noTo 	  			= $_GET["noTo"];
	$noFrom 	  		= $_GET["noFrom"];
	$intCompany     	= $_GET["intCompany"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro Web - General Inventory Reports :: Purchase Order</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-size: 12pt}
.style2 {font-size: 14pt}
-->
</style>
</head>


<body>
<table width="1302" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1298" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
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
  <?php $intStatus		=$_GET["status"]; ?>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("PURCHASE ORDER REGISTER.")?></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==10) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==1) $listType="(PENDING LIST)";					 
		else $listType="(CANCELED LIST)"; 		
		echo  $listType;
	?>
</td>
  </tr>
 	
    <tr>	
    	<td colspan="3">
		<table width="1296" border="0" cellpadding="0" cellspacing="0" >
	

	<tr>
    	<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
<thead>          
		  <tr height="25" >
            <td width="2%" bgcolor="#CCCCCC" class="normalfntBtab"  >&nbsp;</td>
            <td width="15%" bgcolor="#CCCCCC" class="normalfntBtab">Style No</td>
			<td width="4%" bgcolor="#CCCCCC" class="normalfntBtab"  >ScNo</td>
            <td width="10%" bgcolor="#CCCCCC" class="normalfntBtab"  >Buyer PoNo</td>            
            <td width="2%" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="320" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="130" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
			<td width="130" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="60" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="68" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="87"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
          </tr>
</thead>
<?php 
$detailSql="SELECT DISTINCT purchaseorderdetails.intPoNo ,purchaseorderdetails.intYear, purchaseorderdetails.strBuyerPONO, purchaseorderheader.strPINO,purchaseorderheader.strSupplierID,suppliers.strTitle ,purchaseorderheader.dtmDate,purchaseorderheader.dtmDeliveryDate  , specification.intSRNO, purchaseorderdetails.dblQty,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.dblQty*purchaseorderdetails.dblUnitPrice AS amount,purchaseorderdetails.strColor, matmaincategory.strDescription,matitemlist.strItemDescription ,purchaseorderdetails.strSize,purchaseorderdetails.strUnit,purchaseorderdetails.dblQty-purchaseorderdetails.dblPending deleveryQty, purchaseorderdetails.strStyleID, purchaseorderheader.strCurrency, purchaseorderdetails.strRemarks,purchaseorderdetails.dblAdditionalQty FROM purchaseorderheader 
INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
INNER JOIN specification ON purchaseorderdetails.strStyleID = specification.strStyleID 
INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID= matitemlist.intItemSerial 
INNER JOIN suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID 
INNER JOIN matmaincategory ON matitemlist.intMainCatID=matmaincategory.intID 
INNER JOIN matsubcategory ON matitemlist.intSubCatID= matsubcategory.intSubCatNo 
INNER JOIN orders ON purchaseorderdetails.strStyleID=orders.strStyleID 
WHERE  purchaseorderheader.intStatus=$intStatus ";
			
			if ($noFrom!="")
			{
			 	$detailSql .= " AND purchaseorderheader.intPoNo>=$noFrom ";
			}
			if ($noTo!="")
			{
				$detailSql .= " AND purchaseorderheader.intPoNo<=$noTo ";
			}
			
			if ($intCompany!="")
			{
			 	$detailSql .= " AND purchaseorderheader.intCompanyID=$intCompany ";
			}
			
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and purchaseorderdetails.strStyleID ='$strStyleNo' ";						
			}
			
			if ($strBPo	!= "")
			{
				$detailSql .= " and purchaseorderdetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " and matitemlist.intMainCatID=$intMeterial ";	
			}			

			if ($intCategory!= "")
			{				
				$detailSql .= " and matitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$detailSql .= " and purchaseorderdetails.intMatDetailID=$intDescription ";						
			}	
			
			if ($intSupplier!="")
			{			
				$detailSql .= " and purchaseorderheader.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!="")
			{
				$detailSql .= " and orders.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{						
				$detailSql .= " and DATE_FORMAT(purchaseorderheader.dtmDate,'%Y/%m/%d')>= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{						
				$detailSql .= " AND DATE_FORMAT(purchaseorderheader.dtmDate,'%Y/%m/%d')<= DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
			}	
							
			//echo $detailSql;
		  	$detailResult = $db->RunQuery($detailSql);
			$$checkponoAndYear="";
			$rowCount = mysql_num_rows($detailResult);
			while ($details=mysql_fetch_array($detailResult))
			{			
		  	?>
<?php
$ponoAndYear = $details["intYear"].'/'.$details["intPoNo"];
 if($ponoAndYear != $checkponoAndYear){
$checkponoAndYear = $ponoAndYear;
 $noLoop =0;
 
?>
 <tr bgcolor="#E4E4E4" height="20">	
	<td colspan="2" class="normalfnt" style="text-align:center">PoNo :&nbsp;<?php echo $details["intYear"].'/'.$details["intPoNo"]; ?>&nbsp;&nbsp;Currency : <?php echo $details["strCurrency"]?></td>
	<td  colspan="2" class="normalfntMid">Date : &nbsp;<?php  echo substr($details["dtmDate"],0,10);?></td>
	<td colspan="8" class="normalfnt">Supplier : &nbsp;<?php echo($details["strTitle"]); ?></td>
</tr>
<?php
}
?>
		  
          <tr  onmouseover="this.style.background ='#ECECFF';" onmouseout="this.style.background=''" height="20">	
			<td class="normalfntTAB" style="text-align:center"><?php echo ++$noLoop ?></td>
			<td class="normalfntTAB"><?php echo $details["strStyleID"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["intSRNO"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["strBuyerPONO"]; ?></td>
	        <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
<!--        <td class="normalfntTAB"><?php //echo $details["strItemDescription"].' --> '.$details["strRemarks"]; ?></td>-->
 			<td class="normalfntTAB"><?php echo $details["strItemDescription"].($details["strRemarks"] =="" ? "":'--> '.$details["strRemarks"]); ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
			<td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblUnitPrice"],4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["amount"],4)); ?></td>
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
//window.open('','_parent','');
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
