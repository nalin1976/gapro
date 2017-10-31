<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>StitchType</title>
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
		<div class="main_text">Stitch Type<span id="banks_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmStitchType" name="frmStitchType" method="post" action="">
<table width="500" border="0" align="center" bgcolor="#FFFFFF">
   <tr>
	<td>
		<table width="70%" align="center" border="0"  class="bcgl1"> 
			
			<tr>
				<td colspan="3" height="12" class="TitleN2white"></td>
			</tr>
			
		<tr>
			<td class="normalfnt" width="68">&nbsp;</td>
			<td class="normalfnt" width="113">Search</td>
			<td width="203">
				<select class="txtbox" id="cboSearch" style="width: 203px;"  onchange="loadDetails(this);">	
				<?php
				$SQL="SELECT intID ,strStitchType FROM ws_stitchtype ORDER BY strStitchType ASC";		
				$result = $db->RunQuery($SQL);
			
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intID"] ."\">" . $row["strStitchType"] ."</option>" ;
				}		  
				  
				?>  
			  </select>
			</td>
		</tr>
		<tr>
			<td class="normalfnt" width="68">&nbsp;</td>
			<td class="normalfnt" width="113"></td>
			<td><input  style="width: 201px; display:none;" class="txtbox" type="text" id="txtID" maxlength="10" readonly="readonly"></td>
		</tr>
		<tr>
		  <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnt">Stitch Type</td>
		  <td><input style="width: 201px;" class="txtbox" type="text" id="txtStitchType" maxlength="20"></td>
		</tr>
 
		  <tr>
				<td colspan="3" height="12" class="TitleN2white"></td>
			</tr>
			           
		<tr>
			<td colspan="3" align="center" >
				<table width="80%" >
					<tr>
						<td width="22%">&nbsp;</td>
						<td width="19%"><img src="../../images/new.png" name="New" onclick="ClearForm();" class="mouseover"></td>
						<td><img src="../../images/save.png" alt="Save" name="Save" onclick="saveOperation();" class="mouseover"></td>
						<td width="15%"><img src="../../images/delete.png" onclick="deleteOperation()" class="mouseover"  name="Delete" ></td>       
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
