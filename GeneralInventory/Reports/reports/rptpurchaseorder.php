<?php
	session_start();
	include "../../../Connector.php" ;	
	$backwardseperator 	= "../../../";
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
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
<title>ePlan Web - Style Reports :: Purchase Order</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

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
                <td width="15%"><img src="../../../images/eplan_logo.png" alt="" width="198" height="47" class="normalfnt" /></td>
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
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("GENERAL PURCHASE ORDER REGISTER.")?></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) $listType="(CONFIRMED LIST)"; 
		else if ($intStatus==0) $listType="(PENDING LIST)";					 
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
            <td width="18%" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="30%" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="10%" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>
            <td width="10%"  bgcolor="#CCCCCC" class="normalfntBtab">Location</td>
            <td width="10%" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="10%" bgcolor="#CCCCCC" class="normalfntBtab">Bal Qty To GRN</td>
			<td width="10%" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="10%"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
          </tr>
</thead>
<?php 
$detailSql="SELECT DISTINCT
generalpurchaseorderdetails.intGenPoNo,
generalpurchaseorderdetails.intYear,
generalpurchaseorderheader.strPINO,
generalpurchaseorderheader.intSupplierID,
suppliers.strTitle,
generalpurchaseorderheader.dtmDate,
generalpurchaseorderheader.dtmDeliveryDate,
generalpurchaseorderdetails.dblQty,
generalpurchaseorderdetails.dblPending,
generalpurchaseorderdetails.dblUnitPrice,
generalpurchaseorderdetails.dblQty*generalpurchaseorderdetails.dblUnitPrice AS amount,
genmatmaincategory.strDescription,
genmatitemlist.strItemDescription,
generalpurchaseorderdetails.strUnit,
generalpurchaseorderdetails.dblQty-generalpurchaseorderdetails.dblPending AS deleveryQty,
generalpurchaseorderheader.strCurrency,
generalpurchaseorderdetails.strRemarks,
generalpurchaseorderheader.intDeliverTo,
companies.strName  
FROM generalpurchaseorderheader  
INNER JOIN generalpurchaseorderdetails ON generalpurchaseorderheader.intGenPoNo = generalpurchaseorderdetails.intGenPoNo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
 INNER JOIN genmatitemlist ON generalpurchaseorderdetails.intMatDetailID= genmatitemlist.intItemSerial INNER JOIN suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID 
INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID=genmatmaincategory.intID INNER JOIN genmatsubcategory ON genmatitemlist.intSubCatID= genmatsubcategory.intSubCatNo
INNER JOIN companies ON generalpurchaseorderheader.intDeliverTo = companies.intCompanyID
WHERE generalpurchaseorderheader.intStatus=$intStatus ";
			
			if ($noFrom!="")
			{
			 	$detailSql .= " AND generalpurchaseorderheader.intGenPoNo>=$noFrom ";
			}
			if ($noTo!="")
			{
				$detailSql .= " AND generalpurchaseorderheader.intGenPoNo<=$noTo ";
			}
			
			if ($intCompany!="")
			{
			 	$detailSql .= " AND generalpurchaseorderheader.intCompId=$intCompany ";
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " and genmatitemlist.intMainCatID=$intMeterial ";	
			}			

			if ($intCategory!= "")
			{				
				$detailSql .= " and genmatitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$detailSql .= " and generalpurchaseorderdetails.intMatDetailID=$intDescription ";						
			}	
			
			if ($intSupplier!="")
			{			
				$detailSql .= " and generalpurchaseorderheader.strSupplierID=$intSupplier ";
			}

			
			if ($dtmDateFrom!="")
			{						
				$detailSql .= " and DATE_FORMAT(generalpurchaseorderheader.dtmDate,'%Y/%m/%d')>= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{						
				$detailSql .= " AND DATE_FORMAT(generalpurchaseorderheader.dtmDate,'%Y/%m/%d')<= DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
			}	
			$detailSql .=" order By generalpurchaseorderdetails.intGenPoNo,generalpurchaseorderdetails.intYear";				
			//echo $detailSql;
		  	$detailResult = $db->RunQuery($detailSql);
			$$checkponoAndYear="";
			$rowCount = mysql_num_rows($detailResult);
			while ($details=mysql_fetch_array($detailResult))
			{			
		  	?>
			<?php
            $ponoAndYear = $details["intYear"].'/'.$details["intGenPoNo"];
            if($ponoAndYear != $checkponoAndYear){
            $checkponoAndYear = $ponoAndYear;
            $noLoop =0;
             
            ?>
 <tr bgcolor="#E4E4E4" height="20">	
	<td colspan="2" class="normalfnt" style="text-align:center">PoNo :&nbsp;<?php echo $details["intYear"].'/'.$details["intGenPoNo"]; ?>&nbsp;&nbsp;Currency : <?php echo $details["strCurrency"]?></td>
	<td  colspan="2" class="normalfntMid">Date : &nbsp;<?php  echo substr($details["dtmDate"],0,10);?></td>
	<td colspan="5" class="normalfnt">Supplier : &nbsp;<?php echo($details["strTitle"]); ?></td>
</tr>
<?php
}
?>
		  
          <tr  onmouseover="this.style.background ='#ECECFF';" onmouseout="this.style.background=''" height="20">	
			<td class="normalfntTAB" style="text-align:center"><?php echo ++$noLoop ?></td>
	        <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
<!--        <td class="normalfntTAB"><?php //echo $details["strItemDescription"].' --> '.$details["strRemarks"]; ?></td>-->
 			<td class="normalfntTAB"><?php echo $details["strItemDescription"].($details["strRemarks"] =="" ? "":'--> '.$details["strRemarks"]); ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strName"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblPending"],2); ?></td>
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
