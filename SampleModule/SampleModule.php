<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Module</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/tablegrid.js"></script>
</head>
<body>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutL">
		<div class="trans_text">Sample Module<span class="volu"></span></div>
			<table width="90%" border="0">
				<tr>
					<td width="25%" class="normalfnt">Sample ID</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Sample Type</td>
					<td width="22%" class="normalfnt">
						<select style="width: 152px;" class="txtbox">
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
				  	</td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Date</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Style / Article No</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Sample Order No</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Model / Design No</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Cus. Style No</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Finish Date</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Description</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Sample Factory</td>
					<td width="22%" class="normalfnt">
						<select style="width: 152px;" class="txtbox">
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
				  	</td>				
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Season</td>
					<td width="22%" class="normalfnt">
						<select style="width: 152px;" class="txtbox">
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
				  	</td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Customer</td>
					<td width="22%" class="normalfnt">
						<select style="width: 152px;" class="txtbox">
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
				  	</td>				
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Item Group</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Follow Up By</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Sample Material</td>
					<td width="22%" class="normalfnt">
						<select style="width: 152px;" class="txtbox">
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
				  	</td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Sample Status</td>
					<td width="22%" class="normalfnt">
						<select style="width: 152px;" class="txtbox">
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
				  	</td>				
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Brand / Label</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td width="13%" class="normalfnt"></td>
					<td width="18%" class="normalfnt">Handle By</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Various Attachment Files</td>
				  	<td colspan="4" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Measurement Photo for Spec</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td colspan="3" class="normalfnt"><img src="../images/search.png" width="60" /></td>
				</tr>
				<tr>
					<td width="25%" class="normalfnt">Technical Photo for Worksheet</td>
				  	<td width="22%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" /></td>
					<td colspan="3" class="normalfnt"><img src="../images/search.png" width="60" /></td>
				</tr>
			</table>
			<br />		
			<div style="overflow:scroll; height:150px; width:798px;">
				<table style="width:780px" class="transGrid" border="1" cellspacing="1">
					<thead>
						<tr>
							<td colspan="3">Sample Quality Color Size</td>			
						</tr>	
						<tr>
							<td width="255">Color</td>
							<td width="255">Size</td>
							<td width="254">City</td>				
						</tr>		
					</thead>	
					<tbody>
						<tr>
							<td width="255">****</td>
							<td width="255">****</td>
							<td width="254">****</td>				
						</tr>
						<tr>
							<td width="255">****</td>
							<td width="255">****</td>
							<td width="254">****</td>				
						</tr>	
					</tbody>
				</table>
			</div>
			<br />
			<table width="800" border="0">
      			<tr>
					<td width="34%">&nbsp;</td>
					<td width="12%"><img src="../images/new.png" width="90" /></td>
					<td width="11%"><img src="../images/save.png" width="80" /></td>
					<td width="12%"><a href="../main.php"><img src="../images/close.png" alt="close" width="90" border="0" /></a></td>
					<td width="31%">&nbsp;</td>
      			</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>
