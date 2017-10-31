<?php
	session_start();
	$backwardseperator = "../../";
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$batchNo = $_GET["batchNo"];
	$rowindex = $_GET["rowindex"];	

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Batch Details</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="700" height="262" border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td width="710" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="575" class="mainHeading">Batch Details</td>
    <td width="25" class="mainHeading"><img src="../../images/cross.png" width="17" height="17" align="right" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table></td>
  </tr>
<tr>
<td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableBorder">
  <tr bgcolor="#FAD163" >
    <td ><table width="100%" border="0" cellspacing="2" cellpadding="0" >
        <tr>
          <td class="normalfnt">&nbsp;</td>
          </tr>
    </table></td>
  </tr>
  
</table>
</td>
</tr>
 
  <tr>
    <td><div id="delPopup" style="width:700px; height:250px; overflow:scroll;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="popupPlSearch">
        <tr class="mainHeading4">
          <td height="20" nowrap="nowrap">Entry No </td>
          <td nowrap="nowrap">Invoice No</td>
          <td nowrap="nowrap">Supplier Name </td>
          <td nowrap="nowrap">Accpacc Id </td>
          <td nowrap="nowrap">Amount</td>
          <td nowrap="nowrap">Tax Amount</td>
          <td nowrap="nowrap">Total Amount</td>
        </tr>
		<?php
		$SQL = "select intEntryNo,strInvoiceNo,S.strTitle,S.strAccPaccID,
				round(dblInvoiceAmount,4) as dblInvoiceAmount,round(dblTotalTaxAmount,4) as dblTotalTaxAmount,
				round(dblTotalAmount,4) as dblTotalAmount,strBatchNo
				from invoiceheader IH
				inner join suppliers S on IH.strSupplierId=S.strSupplierID
				where strBatchNo='$batchNo'
				order by intEntryNo";
		
		$result = $db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
		?>
			<tr class="bcgcolor-tblrowWhite">
			  <td class="normalfnt" nowrap="nowrap"><?php echo $row["intEntryNo"] ?> </td>
			  <td class="normalfnt" nowrap="nowrap" style="text-align:left"><?php echo $row["strInvoiceNo"] ?></td>
			  <td class="normalfnt" nowrap="nowrap"><?php echo $row["strTitle"] ?></td>
			  <td class="normalfnt" nowrap="nowrap"><input name="txtAccpaccId" id="txtAccpaccId" type="text" size="10" value="<?php echo $row["strAccPaccID"] ?>"></td>
			  <td class="normalfnt" nowrap="nowrap" style="text-align:right"><?php echo $row["dblInvoiceAmount"]; ?></td>
			  <td class="normalfnt" nowrap="nowrap" style="text-align:right"><?php echo $row["dblTotalTaxAmount"]; ?></td>
			  <td class="normalfnt" nowrap="nowrap" style="text-align:right"><?php echo $row["dblTotalAmount"]; ?></td>
			</tr>
		<?php
		}
		?>
      </table>
    
    </div></td>
  </tr>
   <tr>
    <td>
		<table width="100%" class="tableBorder">
		<tr>
			<td align="center"><img src="../../images/ok.png" alt="delete" onClick="postingBatch(<?php echo $batchNo; ?>,<?php echo $rowindex; ?>);"/></td>
		</tr>
		</table>
	</td>
   </tr>
</table>
</body>
</html>
