<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";

$invoiceNo = $_GET["invoiceNo"];

$sql_po = "SELECT DISTINCT strBuyerPONo FROM invoicedetail WHERE strInvoiceNo='$invoiceNo'";
$res_po = $db->RunQuery($sql_po);
$row_po = mysql_fetch_array($res_po);
$po = $row_po['strBuyerPONo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Packing List</title>
<style type="text/css"> 
body {
	background-color: #CCCCCC;
	
}
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
<link href="../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="pl_plugin_search.js" type="text/javascript"></script>
<script src="jquery.fixedheader.js" type="text/javascript"></script>
<style type="text/css">
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th { padding: 0px 0px;  margin:0px;border:1px solid #D7CEFF;}

.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>
</head>

<body>
<table  width="955" border="1" style="border-color:#30C" cellspacing="0" cellpadding="2" align="center" bgcolor="#FFFFFF">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td bgcolor="#316895"  height="25" class="TitleN2white" >Shipment Packing List Search
      <div style="float:right"><img src="../../images/cross.png" title="Close" onclick="closeCross();"/></div></td>
   
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
     
      <tr>
        <td width="10%" height="25">PL #</td>
        <td width="20%"><select name="cmbPL" class="txtbox" id="cmbPL" style="width:150px" tabindex="3">
          <option value=""></option>
          <?php 
			$buyerstr="select distinct strPLNo from shipmentplheader WHERE intCDNStatus=0 order by strPLNo desc";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
          <option value="<?php echo $buyerrow['strPLNo'];?>"><?php echo $buyerrow['strPLNo'];?></option>
          <?php } ?>
        </select></td>
        <td width="10%">PO #</td>
        <td width="20%"><input name="txtPONo" value="" type="text" class="txtbox" id="txtPONo" tabindex="1" style="width:150px" onkeyup="loadCBO();"/></td>
        <td width="13%">Style</td>
        <td width="20%"><select name="cmbStyle" class="txtbox" id="cmbStyle" style="width:180px" tabindex="3">
          <option value=""></option>
          <?php 
			$buyerstr="sselect distinct strProductCode from shipmentplheader WHERE intCDNStatus='0' order by strProductCode";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
          <option value="<?php echo $buyerrow['strProductCode'];?>"><?php echo $buyerrow['strProductCode'];?></option>
          <?php } ?>
        </select></td>
      </tr>
       <tr>
         <td height="25">ISD No</td>
         <td><select name="cmbISD" class="txtbox" id="cmbISD" style="width:150px" tabindex="3">
           <option value=""></option>
           <?php 
			$buyerstr="select distinct strISDno from shipmentplheader
						WHERE intCDNStatus='0' order by strISDno";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{1
		?>
           <option value="<?php echo $buyerrow['strISDno'];?>"><?php echo $buyerrow['strISDno'];?></option>
           <?php } ?>
          </select></td>
         <td>DO #</td>
         <td><select name="cmbDO" class="txtbox" id="cmbDO" style="width:150px" tabindex="3">
           <option value=""></option>
           <?php 
			$buyerstr="select distinct strDO from shipmentplheader WHERE intCDNStatus='0'  order by strD";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{1
		?>
           <option value="<?php echo $buyerrow['strDO'];?>"><?php echo $buyerrow['strDO'];?></option>
           <?php } ?>
          </select></td>
         <td><img src="../../images/search.png" width="80" height="24" id="btnSearch" class="mouseover" onclick="clickBtn()"/></td>
         <td>&nbsp;</td>
       </tr>
    </table></td>
  </tr>
  <tr>
    <td height="300" valign="top"><table style="width:100%;"  cellpadding="2" cellspacing="1" bgcolor="#EFDEFE"  id="tblPL" class="dataTable">
      <thead>
        <tr class="mainHeading4 normaltxtmidb2 " >
        <th height="25"  width="6%" bgcolor="#498CC2">Select</th>
          <th height="25"  width="6%" bgcolor="#498CC2">PL#</th>
           <th height="25"  width="8%" bgcolor="#498CC2">Date</th>
          <th height="25"  width="12%" bgcolor="#498CC2">PO#</th>
           <th height="25"  width="12%" bgcolor="#498CC2">LOT #</th>
          <th height="25"  width="10%" bgcolor="#498CC2">ISD#</th>
          <th height="25"  width="10%" bgcolor="#498CC2">DO#</th>
          <th height="25"  width="16%" bgcolor="#498CC2">Item</th>
          <th height="25"  width="12%" bgcolor="#498CC2">Fabric</th>
          <th height="25"  width="10%" bgcolor="#498CC2">View</th>
        </tr>
      </thead><tbody></tbody>
    </table></td>
  </tr>
</table>
</body>
</html>