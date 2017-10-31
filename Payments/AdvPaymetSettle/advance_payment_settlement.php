<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Advance Payment Settlement</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>
<link rel="stylesheet" href="mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script  src="../../js/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="../../javascript/table_script.js" type="text/javascript"></script>

<script src="grnDetails2GlAcc.js" type="text/javascript"></script>


<style type="text/css">
<!--
body 
{
	background-color: #FFF;
}
.style1 {color: #0000FF}

</style>
</head>
<body onload="">
<table width="100%">
	<tr>
		<td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
	</tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Advance Payment Settlement<span class="vol"></span></div>
	</div>
	<div class="main_body">
		<form method="post" name="frmAdvPaySet" id="frmAdvPaySet">
		<div class="tableBorder">
		<table width="600" >
			<tr>
				<td width="76" class="normalfnt">Supplier</td>
				<td width="374" class="normalfnt">
					<select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:300px" onchange="getStylePO();">
					<option value=" "></option>
              <?php
						
						$SQL="SELECT distinct
								suppliers.strSupplierID,
								suppliers.strTitle
								FROM
								suppliers
								Inner Join advancepayment ON suppliers.strSupplierID = advancepayment.supid
								ORDER BY
								suppliers.strTitle ASC";
						//echo($SQL);
						$result = $db->RunQuery($SQL);
						
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
						}
					?>
            </select>
			  </td>
				<td width="201"></td>
				<td width="14" >&nbsp;</td>
			</tr>
		</table>
		
		
		<table width="600" >
			<tr>
			    <td width="63" class="normalfnt">PO Type</td>
			  <td width="20" class="normalfnt"><input type="radio" checked="checked" class="txtbox" id="rdoStyle" name="rdCat" onclick="getStylePO()";></td>
				<td width="41" class="normalfnt">Style</td>
			  <td width="20" class="normalfnt"><input type="radio" class="txtbox" id="rdoGeneral" name="rdCat" onclick="getStylePO()";></td>
				<td width="55" class="normalfnt">General</td>
			  <td width="20" class="normalfnt"><input type="radio" class="txtbox" id="rdoBulk" name="rdCat" onclick="getStylePO()";></td>
				<td width="298" class="normalfnt">Bulk</td>
				<td width="47">&nbsp;</td>
			</tr>
		</table>
		</div>
		<br />
		<div style="width:600px;" class="mainHeading2">PO's</div>
		<div id="divcons2" style="overflow:scroll; height:250px; width:600px;" class="tableBorder">
			<table width="582" cellspacing="1" id="tblMain" class="table_grid_style">
				<thead>
					<tr class="mainHeading4">
						<td>Payment No</td>
						<td>Advance Paid</td>
						<td>PO No</td>
						<td>PO Amount</td>						
						<td>Set Amount</td>
						<td>Balance</td>
						<td>GRN</td>
						<td>Surrended</td>
					</tr>
				</thead>
				<tbody id="table_grid_style_body">

				</tbody>
			</table>
		</div>
		<br />
		<table width="600" border="0" class="tableBorder">
			<tr>
				<td align="center"><img  src="../../images/save.png" onclick="updateForSurrender();"/>
                <a href="../../main.php"><img src="../images/close.png" border="0" onclick="advclose()"/></a></td>
			</tr>
		</table>
		</form>
	</div>
</div>
</body>
<script src="../../js/jquery.fixedheader.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="advance_Payment_Settelment.js"></script>
</html>