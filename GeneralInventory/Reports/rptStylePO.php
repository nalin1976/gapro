<?php
	session_start();
	include "../Connector.php" ;
	//include("DBReport.php");	
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

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
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
              <td width="6%" class="normalfnt">&nbsp;</td>
				 <td width="62%" class="tophead"><p class="normalfnt"></p></td>
                 <td width="12%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><p class="head2BLCK"><?php 	
		$cid=$_SESSION["CompanyID"];
		$SQL = "SELECT strname, CONCAT(straddress1,CONCAT(', ',CONCAT(strAddress2,CONCAT(', ', CONCAT(strStreet,'.'))))) AS strAdress FROM companies WHERE intCompanyid=$cid;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strname"]);		
		?></p></td>
  </tr>
  <tr>
    <td colspan="3"><p class="head2BLCK style1"><?php $cid=$_SESSION["CompanyID"];
		$SQL = "SELECT strname, CONCAT(straddress1,CONCAT(', ',CONCAT(strAddress2,CONCAT(', ', CONCAT(strStreet,'.'))))) AS strAdress FROM companies WHERE intCompanyid=$cid;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strAdress"]);?></p> </td>
  </tr>
  <tr>
  <?php $intStatus		=$_GET["status"]; ?>
    <td colspan="3"><p class="head2BLCK style2"><?php echo ("PURCHASE ORDER REGISTER.")?></p></td>
  </tr>
  <tr>
    <td colspan="3"><p class="head2BLCK style1">
	<?php 		
		if ($intStatus==10) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==1) $listType="(PENDING LIST)";					 
		else $listType="(CANCELED LIST)"; 		
		echo  $listType;
	?>
	</p></td>
  </tr> 
  	<?php 	
		$strStyleNo		= $_GET["strStyleNo"];
		$strBPo			= $_GET["strBPo"];
		$intMeterial 	= $_GET["intMeterial"];
		$intCategory 	= $_GET["intCategory"];
		$intDescription = $_GET["intDescription"];
		$intSupplier 	= $_GET["intSupplier"];
		$intBuyer 	  	= $_GET["intBuyer"];
		$dtmDateFrom	= $_GET["dtmDateFrom"];
		$dtmDateTo 	  	= $_GET["dtmDateTo"];
		
		if ($strBPo=='HashMain Ratio') $strBPo='#Main Ratio#';
			
		//if ($strStyleNo != "0" && $strStyleNo != NULL)
		//{			
		$sql = "SELECT DISTINCT purchaseorderdetails.strStyleID,purchaseorderdetails.intPoNo, purchaseorderdetails.strBuyerPONO,purchaseorderheader.strPINO,purchaseorderheader.strSupplierID,suppliers.strTitle , purchaseorderheader.dtmDate,purchaseorderheader.dtmDeliveryDate , specification.intSRNO FROM purchaseorderheader INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo INNER JOIN specification ON purchaseorderdetails.strStyleID = specification.strStyleID INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID= matitemlist.intItemSerial INNER JOIN suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID INNER JOIN orders ON purchaseorderdetails.strStyleID=orders.strStyleID WHERE  purchaseorderheader.intStatus=$intStatus";
			
			if ($strStyleNo!= "0")
			{ 
				$sql = $sql." and purchaseorderdetails.strStyleID ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "0")
			{
				$sql = $sql." and purchaseorderdetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "0")
			{					
				$sql = $sql." and matitemlist.intMainCatID=$intMeterial ";	
			}

			if ($intCategory!= "0")
			{
				$sql = $sql." and matitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "0")
			{
				$sql = $sql." and purchaseorderdetails.intMatDetailID=$intDescription " ;
			}
	
			if ($intSupplier!='0')
			{			
				$sql = $sql." and purchaseorderheader.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!=0)
			{			
				//echo $intBuyer;
				$sql = $sql." and orders.intBuyerID=$intBuyer";				
			}
			
			if (($dtmDateFrom!=0) || ($dtmDateTo!=0))
			{			
				//echo $dtmDateFrom;	
				//$sql = $sql." AND DATE(purchaseorderheader.dtmDate) >= DATE('$dtmDateFrom') AND DATE(purchaseorderheader.dtmDate) < DATE('$dtmDateTo')";
				$sql = $sql." and DATE_FORMAT(purchaseorderheader.dtmDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') AND DATE_FORMAT(purchaseorderheader.dtmDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
			
			
			$result = $db->RunQuery($sql);
			//echo $sql;
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="86" bgcolor="#C4DBFD" class="normalfnth2B" >PO Number</td>
  	    <td width="134"  bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo $rowdata["intPoNo"]; ?></td>
  	    <td width="772" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="bcgl1"><tr><td>
		
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr height="25">
            <td  width="86" class="normalfnth2B">Buyer PO No</td>
			<td width="141" class="normalfnt"><?php echo($rowdata["strBuyerPONO"]); ?></td>
			<td width="91" class="normalfnth2B">Supplier</td>
			<td colspan="3" class="normalfnt"><?php echo($rowdata["strTitle"]); ?></td>
			<td width="65" class="normalfnth2B">Po Date</td>
			<td width="175" class="normalfnt"><?php echo($rowdata["dtmDate"]); 
			//echo date("jS F Y", strtotime($rowbpo["dtmDeliveryDate"])) ?></td>
          </tr>
		  
          <tr height="25" >
            <td class="normalfnth2B">Style No</td>
            <td class="normalfnt"><?php echo $rowdata["strStyleID"]; ?></td>
			<td class="normalfnth2B">PI No</td>
			<td width="137" class="normalfnt"><?php echo($rowdata["strPINO"]); ?></td>
            <td width="59" class="normalfnth2B">SC No</td>
            <td width="236" class="normalfnt"><?php echo($rowdata["intSRNO"]); ?></td>
			<td class="normalfnth2B">Del date</td>
			<td class="normalfnt"><?php echo($rowdata["dtmDeliveryDate"]); ?></td>
          </tr>
        </table><p class="head2BLCK"></p></td>
  	</tr>
	
	<tr>
    	<td height="25" colspan="3" class="normalfnth2B">Item Details</td>
  	</tr>
	<tr>
    	<td colspan="3"><table width="967" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="62" bgcolor="#CCCCCC" class="normalfntBtab"  >Material</td>
	        <td width="320" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="223" bgcolor="#CCCCCC" class="normalfntBtab">Color/Size</td>
            <td width="55" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="77" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="68" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="83"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
			<td width="77" bgcolor="#CCCCCC" class="normalfntBtab">Rec Qty</td>															
          </tr>
		  	<?php 
				$detailSql="SELECT DISTINCT purchaseorderdetails.intPoNo, purchaseorderdetails.strBuyerPONO, purchaseorderheader.strPINO,purchaseorderheader.strSupplierID,suppliers.strTitle ,purchaseorderheader.dtmDate,purchaseorderheader.dtmDeliveryDate , specification.intSRNO, purchaseorderdetails.dblQty,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.dblQty*purchaseorderdetails.dblUnitPrice AS amount,purchaseorderdetails.strColor, matmaincategory.strDescription,matitemlist.strItemDescription ,purchaseorderdetails.strSize,purchaseorderdetails.strUnit,purchaseorderdetails.dblQty-purchaseorderdetails.dblPending deleveryQty FROM purchaseorderheader INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo INNER JOIN specification ON purchaseorderdetails.strStyleID = specification.strStyleID INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID= matitemlist.intItemSerial INNER JOIN suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID INNER JOIN matmaincategory ON matitemlist.intMainCatID=matmaincategory.intID INNER JOIN 
matsubcategory ON matitemlist.intSubCatID= matsubcategory.intSubCatNo WHERE  purchaseorderheader.intStatus=$intStatus and purchaseorderdetails.intPoNo =" . $rowdata["intPoNo"];
			
			if ($strStyleNo!= "0")
			{ 
				$sql = $sql." and purchaseorderdetails.strStyleID ='$strStyleNo' ";						
			}

			if ($intMeterial!= "0")
			{					
				$detailSql = $detailSql." and matitemlist.intMainCatID=$intMeterial ";	
			}			

			if ($intCategory!= "0")
			{				
				$detailSql = $detailSql." and matitemlist.intSubCatID=$intCategory " ;
			}
			
			//echo $intCategory;
			if ($intDescription!= "0")
			{
				$detailSql = $detailSql." and purchaseorderdetails.intMatDetailID=$intDescription ";						
			}			
		  		$detailResult = $db->RunQuery($detailSql);
				//echo $detailSql;		
				while ($details=mysql_fetch_array($detailResult))
				{
				
		  	?>
          <tr>
	        <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strColor"].','.$details["strSize"]); ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["dblQty"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblUnitPrice"],4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["amount"],2)); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["deleveryQty"]); ?></td>          
          </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	
	</table>
	<tr><td>&nbsp;</td></tr>
<?php
	}
//}

?>

</td></tr></table>


<p>&nbsp;</p>
</body>
</html>
