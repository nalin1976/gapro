<?php
session_start();
$backwardseperator = "../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Dispose Listing</title>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
<script src="itemDispos.js" type="text/javascript"></script>
</head>

<body>
<?php
	include "../Connector.php";	
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td><?php include $backwardseperator."Header.php";?></td>
	</tr>
</table>

<div class="main_bottom">

	<div class="main_top">
		<div class="main_text">Item Dispose Listing<span class="vol"></span></div>
	</div>
	<div class="main_body">
	
	<form name="frmGPListing" id="frmGPListing" >
		<table width="750" border="0" class="main_border_line">
			<tr>
				<td></td>
			</tr>
			<tr>
				<td width="12">&nbsp;</td>
				<td width="89" class="normalfnt">Dispose No.</td>
				<td width="232">
				<select name="cboDisposeNo" id="cboDisposeNo" class="txtbox" style="width:200px" onchange="loadDisposedItems(this);" tabindex="1">
					<?php
					$SQL = "SELECT DISTINCT intDocumentNo,DATE_FORMAT(dtmDate,'%Y-%m-%d') AS dtm from stocktransactions where dblQty<0 ORDER BY intDocumentNo ASC;";
					$result = $db->RunQuery($SQL);
					
					echo "<option value = \"". "" . "\">" . "Select one" . "</option>";
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"" . $row["intDocumentNo"] ."\">" . $row["intDocumentNo"]."::".$row["dtm"]. "</option>";
					}
					?>
				</select>
				</td>
				<td class="normalfnt">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
			</tr>
		</table>
		
    <br/>
		
		<div id="divcons" style="overflow:scroll; height:300px; width:750px;">
        <table width="750" border="0" class="main_border_line" id="tblMain">
        	<thead>
			<tr>
				<td height="20" colspan="7" class="sub_containers">&nbsp;</td>
			</tr>
			<tr>
				<td width="11%" class="grid_header">Dispose No</td>
				<td width="16%" class="grid_header">Style</td>
				<td width="22%" class="grid_header">Buyer Po No</td>
				<td width="34%" class="grid_header">Material Discription</td>
				<td width="17%" class="grid_header">Dispose Qty </td>
			</tr>
            </thead>
            <tbody>
            </tbody>
		</table></div>
        <table width="750" border="0" class="main_border_line">
            <tr> 
                <td width="33%">&nbsp;</td>
                <td width="13%"></td>
                <td width="10%"><img src="../images/report.png" onClick="loadReport();"/></td>
                <td width="20%"></td>
                <td width="24%">&nbsp;</td>
            </tr>
        </table>
	</form>
	</div>
	<div class="gap"></div>
</div>
</body>
</html>