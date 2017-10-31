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
<title>GRN Report</title>
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
		$intCompany     = $_GET["intCompany"];
		$SQL = "SELECT strname, CONCAT(straddress1,CONCAT(', ',CONCAT(strAddress2,CONCAT(', ', CONCAT(strStreet,'.'))))) AS strAdress FROM companies WHERE intCompanyid=$intCompany;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strname"]);		
		?></p></td>
  </tr>
  <tr>
    <td colspan="3"><p class="head2BLCK style1"><?php $cid=$_SESSION["CompanyID"];
		$SQL = "SELECT strname, CONCAT(straddress1,CONCAT(', ',CONCAT(strAddress2,CONCAT(', ', CONCAT(strStreet,'.'))))) AS strAdress FROM companies WHERE intCompanyid=$intCompany;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strAdress"]);?></p> </td>
  </tr>
  <tr>
  <?php $intStatus = $_GET["status"]; ?>
    <td colspan="3"><p class="head2BLCK style2"><?php echo ("GRN REGISTER.")?></p></td>
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
		//echo $strStyleNo;
		if ($strBPo=='HashMain Ratio') $strBPo='#Main Ratio#';
				
		//if ($strStyleNo != "0" && $strStyleNo != NULL)
		//{			
			$sql = "SELECT distinct grnheader.intgrnno,grnheader.intGRNYear,purchaseorderheader.intPONo, grndetails.strBuyerPONO,grndetails.strStyleID, suppliers.strTitle, purchaseorderheader.strPINO, grnheader.dtmRecievedDate,specification.intSRNO,grnheader.intStatus from grnheader inner join grndetails on grnheader.intgrnno=grndetails.intgrnno and grnheader.intGRNYear=grndetails.intGRNYear inner join purchaseorderheader on grnheader.intPoNo =purchaseorderheader.intPONo inner join suppliers on purchaseorderheader.strSupplierID=suppliers.strSupplierID inner join specification on grndetails.strStyleID=specification.strStyleID inner join matitemlist on grndetails.intMatDetailID=matitemlist.intItemSerial inner join orders on grndetails.strStyleID=orders.strStyleID where grnheader.intStatus=$intStatus  ";
			
			//echo $sql;
			if ($intCompany!=0)
			{
				$sql = $sql." and grnheader.intCompanyID=$intCompany ";
			}
						
			if ($strStyleNo!= "0")
			{ 
				$sql = $sql." and grndetails.strStyleID ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "0")
			{
				$sql = $sql." and grndetails.strBuyerPONO='$strBPo' " ;
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
				$sql = $sql." and matitemlist.intItemSerial=$intDescription " ;
			}
	
			if ($intSupplier!='0')
			{			
				$sql = $sql." and purchaseorderheader.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!=0)
			{			
				$sql = $sql." and orders.intBuyerID=$intBuyer";				
			}
			
			if (($dtmDateFrom!=0) || ($dtmDateTo!=0))
			{					
				$sql = $sql." and DATE_FORMAT(grnheader.dtmRecievedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') AND DATE_FORMAT(grnheader.dtmRecievedDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			$sql = $sql. " order by grnheader.intgrnno";
			//echo $sql;
			$result = $db->RunQuery($sql);
			//echo $sql;
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="86" bgcolor="#C4DBFD" class="normalfnth2B" >GRN  Number</td>
  	    <td width="296" bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo substr($rowdata["intGRNYear"],2,2).'/'.$rowdata["intgrnno"];  ?></td>
  	    <td width="610" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="bcgl1"><tr><td>
		
		<table width="968" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr height="25">
            <td  width="84" class="normalfnth2B">Buyer PO No</td>
			<td width="137" class="normalfnt"><?php echo $rowdata["strBuyerPONO"]; ?></td>
			<td width="89" class="normalfnth2B">Supplier</td>
			<td colspan="3" class="normalfnt"><?php echo $rowdata["strTitle"]; ?></td>
			<td width="63" class="normalfnth2B"> Date</td>
			<td width="174" class="normalfnt"><?php  echo $rowdata["dtmRecievedDate"];
			//echo date("jS F Y", strtotime($rowbpo["dtmDeliveryDate"])) ?></td>
          </tr>
		  
          <tr height="25" >
            <td class="normalfnth2B">Style No</td>
            <td class="normalfnt"><?php echo $rowdata["strStyleID"]; ?></td>
			<td class="normalfnth2B">Po No </td>
			<td width="182" class="normalfnt"><?php echo $rowdata["intPONo"]; ?></td>
            <td width="47" class="normalfnth2B">PI No</td>
            <td width="190" class="normalfnt"><?php echo $rowdata["strPINO"]; ?></td>
			<td class="normalfnth2B">SC No</td>
			<td class="normalfnt"><?php echo $rowdata["intSRNO"]; ?></td>
          </tr>
        </table>
		<p class="head2BLCK"></p></td>
  	</tr>
	
	<tr>
    	<td height="25" colspan="3" class="normalfnth2B">Item Details</td>
  	</tr>
	<tr>
    	<td colspan="3"><table width="967" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="61" bgcolor="#CCCCCC" class="normalfntBtab"  >Material</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Color/Size</td>
            <td width="74" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="68" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="83"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
			<td width="75" bgcolor="#CCCCCC" class="normalfntBtab">Issued Qty</td>
			<td width="59" bgcolor="#CCCCCC" class="normalfntBtab">Bal QTY </td>
			<td width="77" bgcolor="#CCCCCC" class="normalfntBtab">Bal Value </td>															
          </tr>
		  	<?php 
				$detailSql="SELECT distinct grnheader.intgrnno,grnheader.intGRNYear,  grndetails.strBuyerPONO,grndetails.strStyleID, suppliers.strTitle ,grndetails.intMatDetailID, grnheader.dtmRecievedDate,matitemlist.intMainCatID,matitemlist.intSubCatID,grnheader.intStatus, matmaincategory.strDescription, matitemlist.strItemDescription, grndetails.strColor , grndetails.strSize, grndetails.dblExcessQty +grndetails.dblQty AS dblQty, grndetails.dblBalance, (grndetails.dblExcessQty +grndetails.dblQty)-grndetails.dblBalance AS dblIssued, purchaseorderdetails.dblUnitPrice,purchaseorderdetails.strUnit FROM grnheader INNER JOIN grndetails ON grnheader.intgrnno=grndetails.intgrnno AND grnheader.intGRNYear=grndetails.intGRNYear INNER JOIN purchaseorderheader ON grnheader.intPoNo=purchaseorderheader.intPONo INNER JOIN suppliers ON purchaseorderheader.strSupplierID=suppliers.strSupplierID INNER JOIN specification ON grndetails.strStyleID=specification.strStyleID INNER JOIN matitemlist ON grndetails.intMatDetailID=matitemlist.intItemSerial INNER JOIN orders ON grndetails.strStyleID=orders.strStyleID INNER JOIN matmaincategory ON matitemlist.intMainCatID=matmaincategory.intID inner join purchaseorderdetails on purchaseorderheader.intPoNo= purchaseorderdetails.intPoNo  and purchaseorderheader.intYear= purchaseorderdetails.intYear and purchaseorderdetails.strStyleID=grndetails.strStyleID and purchaseorderdetails.intMatDetailID=grndetails.intMatDetailID WHERE grnheader.intStatus=$intStatus AND grnheader.intgrnno =" .$rowdata["intgrnno"]. " AND grndetails.strStyleID ='".$rowdata["strStyleID"]."' AND grndetails.strBuyerPONO='".$rowdata["strBuyerPONO"]."' ";

			
			if ($intCompany!=0)
			{
				$detailSql = $detailSql." AND grnheader.intCompanyID=$intCompany  ";
			}
			
			if ($strStyleNo!= "0")
			{ 
//				$detailSql = $detailSql." AND grndetails.strStyleID ='$strStyleNo' ";
			}
			
			if ($intMeterial!= "0")
			{					
				$detailSql = $detailSql." AND matitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "0")
			{
				$detailSql = $detailSql." AND matitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "0")
			{
				$detailSql = $detailSql." AND purchaseorderdetails.intMatDetailID=$intDescription ";						
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
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblQty"]*$details["dblUnitPrice"],2)); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["dblIssued"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["dblBalance"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblBalance"]*$details["dblUnitPrice"],2)); ?></td>          
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
