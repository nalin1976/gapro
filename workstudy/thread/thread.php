<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thread</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="machines-js.js"></script>
<script src="../../javascript/script.js"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
</head>
<body>
<?php
include "../../Connector.php";
?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Thread<span id="banks_popup_close_button"></span></div>
	</div>
	<div class="main_body">
    
<form id="frmthread" name="frmthread" method="post" action="">
<table width="500" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
	<td>
		<table width="80%" align="center"  class="bcgl1">
			
				<td class="normalfnt" width="68">&nbsp;</td>
				<td class="normalfnt" width="113">Search</td>
				<td width="203">
					<select class="txtbox" id="cboSearch" style="width: 203px;"  onchange="loadDetails(this);">	
					<?php
					$SQL="SELECT intID ,strthread FROM ws_thread ORDER BY intID ASC";		
					$result = $db->RunQuery($SQL);
				
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intID"] ."\">" . $row["strthread"] ."</option>" ;
					}		  
					  
					?>  
				  </select>	</td>
			</tr>
			
			
			
			<tr>
				<td class="normalfnt" width="68">&nbsp;</td>
				<td class="normalfnt" width="113"></td>
				<td><input style="width: 201px; display:none;" class="txtbox" type="text" id="txtID" maxlength="10" readonly="readonly"></td>     
			</tr>
			<tr>
			  <td class="normalfnt">&nbsp;</td>
			  <td class="normalfnt">Code</td>
			  <td><input name="text" type="text" class="txtbox" 
			  id="txtCode" style="width: 201px;" maxlength="10"/></td>
		  </tr>
			<tr>
			  <td class="normalfnt">&nbsp;</td>
			  <td class="normalfnt">Description</td>
			  <td><input style="width: 201px;" class="txtbox" type="text" id="txtDescription" maxlength="100"></td>
			</tr>
			
			<tr>
		    <td colspan="3" height="12" class="TitleN2white"></td>
	       </tr>
			
			<tr>
		<td align="center" colspan="4">
			<table >
				<tr>
					<td width="22%">&nbsp;</td>
					<td width="19%"><img src="../../images/new.png" name="New" onclick="ClearForm();" class="mouseover"></td>
					<td><img src="../../images/save.png" alt="Save" name="Save" onclick="saveThread();" class="mouseover"></td>
					<td width="15%"><img src="../../images/delete.png" onclick="ConfirmDelete();" class="mouseover"  name="Delete" height="24"></td>       
					<td width="18%"><a href="../../main.php"><img src="../../images/close.png"  id="Close" border="0"></a></td>
					<td width="26%">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	
		</table>
	  </td>
	</tr>
	
	
	
</table>
	
</form>
</div>
</div>
</body>
</html>
