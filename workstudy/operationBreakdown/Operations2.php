<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operations</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="ajaxupload.js"></script>
<script src="Operation.js"></script>
<script src="../../javascript/script.js"></script>

<style type="text/css">
.trans_one{
	width:400px; height:auto;
	border:1px solid;
	border-bottom-color:#FAD163;
	border-top-color:#FAD163;
	border-left-color:#FAD163;
	border-right-color:#FAD163;
	background-color:#FFFFFF;
	padding-right:15px;
	padding-top:10px;
	padding-left:30px;
	padding-right:30px;
	margin-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	border-bottom:13px solid #FAD163;
	border-top:30px solid #FAD163;
}
</style>

</head>

<body>

<?php
include "../../Connector.php";

$intCatId = $_GET["intCatId"];
$intCompId = $_GET["intCompId"];
?>
<form id="frmPopOperation" name="frmPopOperation">
<div>
	<div align="center">
		<div class="trans_one">
		<div class="trans_text">Operations<span class="volu"><span id="country_popup_close_button"></span></span></div>
		<table align="center" border="0" cellspacing="1" width="231">
		<tr>
			<td class="normalfnt" width="4">&nbsp;</td>
			<td class="normalfnt" width="73">Search</td>
			<td width="156">
				<select class="txtbox" style="width: 150px;" onchange="loadOperation();" id="cboSearch" name="cboSearch">	
					<option></option>
					<?php
				$SQL="	SELECT
						ws_operations.intId,
						ws_operations.strOperationCode
						FROM
						ws_operations";		
				$result = $db->RunQuery($SQL);	
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intId"] ."\">" . $row["strOperationCode"] ."</option>" ;
				}		  
				?>    
				</select>			
		  </td>
		</tr>
		<tr>
			<td class="normalfnt" width="4">&nbsp;</td>
			<td class="normalfnt" width="73">Code</td>
			<td><input id="txtOptCode" name="txtOptCode" style="width: 147px;" class="txtbox" type="text" maxlength="20"></td>              
			<td width="5"></td>
		</tr>
		<tr>
			<td class="normalfnt" width="4">&nbsp;</td>
			<td class="normalfnt" width="73">Operation</td>
		  <td width="156"><input id="txtName" name="txtName" style="width:147px;" class="txtbox" type="text" maxlength="20"></td>              
		</tr>

		<tr>
			<td class="normalfnt" width="4">&nbsp;</td>
			<td class="normalfnt" width="73">Active</td>
			<td><input name="chkStatus" id="chkStatus" type="checkbox" checked="checked"  class="chkbox"></td>
		</tr>
	</table>
	<br />
	<table width="296">
		<tr>
			<td width="19%" align="center">
			<img src="../../images/new.png" alt="Save" class="mouseover" onclick="document.frmPopOperation.reset();">
			<img src="../../images/save.png" alt="Save" class="mouseover" onclick="saveOperationsPopUp();">
		    <img src="../../images/delete.png" class="mouseover" alt="Delete" id="butDelete" name="Delete"  onclick="DeleteDataOperation();" tabindex="8"/>   
			</td>
		</tr>
	</table>
</div>
</div>
</div>

</form>
</body>
</html>
