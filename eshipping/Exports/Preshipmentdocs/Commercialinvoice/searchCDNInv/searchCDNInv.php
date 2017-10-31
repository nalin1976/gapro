<?php
session_start();
$backwardseperator = "../../../../";
include "$backwardseperator".''."Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search CDN Invoice</title>
<style type="text/css"> 
body {
	background-color: #CCCCCC;
	
}
</style>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../../js/jquery-1.4.4.min.js"></script>
<link href="../../../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="../../../../javascript/script.js" type="text/javascript"></script>
<script src="searchCDNInv.js" type="text/javascript"></script>
<script src="../../../../shipmentpackinglist/jquery.fixedheader.js" type="text/javascript"></script>
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
<table  width="950" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "".$backwardseperator."Header.php"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#316895"  height="25" class="TitleN2white" >CDN  Invoice Search</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
     
      <tr>
        <td width="10%" height="25">Doc Type</td>
        
        <td width="20%"><select name="cmbDocType" class="txtbox" id="cmbDocType" style="width:150px" tabindex="3" onchange="loadDoctype(this);">
          <option value=""></option>
          <option value="1">CDN</option>
          <option value="2">Pre Invoice</option>
          <option value="3">Commercial Invoice</option>
       	  </select></td>
        
        
        <td width="10%">Inv No</td>
        <td width="20%"><select name="cmbInv" class="txtbox" id="cmbInv" style="width:150px" tabindex="3">
          <option value=""></option>
      
        </select></td>
        <td width="13%">PO No</td>
        <td width="20%"><input name="txtPONo"  type="text" class="txtbox" id="txtPONo" tabindex="1" style="width:150px" /></td>
      </tr>
       <tr>
         <td height="25">Style No</td>
         <td><input name="txtStyleNo"  type="text" class="txtbox" id="txtStyleNo" tabindex="1" style="width:150px" /></td>
         <td>Manufacturer</td>
         <td><select name="cmbManu" class="txtbox" id="cmbManu" style="width:150px" tabindex="3">
           <option value=""></option>
           <?php 
			$buyerstr="SELECT DISTINCT strCustomerID, strName, strMLocation FROM customers";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{1
		?>
           <option value="<?php echo $buyerrow['strCustomerID'];?>"><?php echo $buyerrow['strName'];?>--><?php echo $buyerrow['strMLocation'];?></option>
           <?php } ?>
         </select></td>
         <td><img src="../../../../images/search.png" width="80" height="24" id="btnSearch" class="mouseover"/></td>
         <td>&nbsp;</td>
       </tr>
    </table></td>
  </tr>s
  <tr>
    <td height="300" valign="top"><table style="width:100%;"  cellpadding="2" cellspacing="1" bgcolor="#EFDEFE"  id="tblPL" class="dataTable">
      <thead>
        <tr class="mainHeading4 normaltxtmidb2 " >
          <th height="25"  width="6%" bgcolor="#498CC2">Inv No</th>
           <th height="25"  width="8%" bgcolor="#498CC2">Date</th>
           <th height="25"  width="12%" bgcolor="#498CC2">PO No</th>
           <th height="25"  width="12%" bgcolor="#498CC2">Style No</th>
          <th height="25"  width="10%" bgcolor="#498CC2">CTN No</th>
          <th height="25"  width="10%" bgcolor="#498CC2">QTY</th>
          <th height="25"  width="16%" bgcolor="#498CC2">Manufacturer</th>
          <th height="25"  width="12%" bgcolor="#498CC2">Destination</th>
          <th height="25"  width="10%" bgcolor="#498CC2">Mode</th>
          <th height="25"  width="3%" bgcolor="#498CC2">Status</th>
        </tr>
      </thead><tbody></tbody>
    </table></td>
  </tr>
</table>
</body>
</html>