<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Line End</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="../finish_line/finish_line.js"></script>

</head>
<body>
<?php
	include "../../Connector.php";	
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td><?php include $backwardseperator."Header.php";?></td>
	</tr>
</table>

<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Line End<span class="vol"></span></div>
	</div>
	<div class="main_body">
	<table align="center" border="0" cellspacing="1" width="751">
		<tr>
			<td class="normalfnt" width="25">&nbsp;</td>
			<td class="normalfnt" width="85">Style No</td>
			<td width="218">
<select name="cboStyle" class="txtbox" id="cboStyle" style="width:203px" onchange="loadColors(this.value)">
		  <option value="">Select one</option> 

		<?php
		
		$SQL="	SELECT DISTINCT o.intStyleId,o.strStyle 
				FROM orders o
				INNER JOIN was_issuedheader AS ws ON ws.intStyleId=o.intStyleId";
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strStyle"]."</option>";
			}
	
 	    ?>
 </select>	
			</td>
			<td class="normalfnt" width="135">&nbsp;</td>
			<td class="normalfnt" width="105">Line Issue No</td>
			<td width="123"><input style="width: 100px;" class="txtbox" type="text" id="txtOperationCode" maxlength="10"></td> 
			<td class="normalfnt" width="38">&nbsp;</td>
		</tr>
		<tr>
			<td class="normalfnt" width="25">&nbsp;</td>
			<td class="normalfnt" width="85">Order No</td>
			<td width="218">
				<select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:203px" onchange="loadColors(this.value)">
		  <option value="">Select one</option> 

		<?php
		
		$SQL="	SELECT DISTINCT o.intStyleId,o.strOrderNo 
				FROM orders o
				INNER JOIN was_issuedheader AS ws ON ws.intStyleId=o.intStyleId";
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	    ?>
 </select>			
 	  	</td>
 
			  <?php
			  $date=date("d/m/Y");
			  
			  ?>
			<td class="normalfnt" width="135">&nbsp;</td>
			<td class="normalfnt" width="105">Date</td>
		  	<td width="123"><input name="finish_lineDate" type="text" class="txtbox" id="finish_lineDate" style="width: 100px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $date ?>"  /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/>
		  
<input type="hidden" name="txtYear" id="txtYear" value="<?php echo date(Y); ?>" /><input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" />	</td> 
			<td class="normalfnt" width="38">&nbsp;</td>
		</tr>
		<tr>
			<td class="normalfnt" width="25">&nbsp;</td>
			<td class="normalfnt" width="85">Color</td>
			<td width="218">
				          <select name="cboColor" id="cboColor" style="width:203px" onchange="loadData(this.value)">
          	<option value="">Select One</option>
          </select>
			
		  	</td>
			<td class="normalfnt" width="135">&nbsp;</td>
			<td class="normalfnt" width="105">Order Qty</td>
		  	<td width="123"><input style="width: 100px;" class="txtbox" type="text" id="txtPoQty" name="txtPoQty"  readonly=""maxlength="10"></td> 
			<td class="normalfnt" width="38">&nbsp;</td>
		</tr>
		<tr>
			<td class="normalfnt" width="25">&nbsp;</td>
			<td class="normalfnt" width="85">Factory</td>
			<td width="218"><input type="text" name="txtFactory" id="txtFactory" style="width:203px" readonly=""/></td>
		</tr>
	</table>
	<br />
	<div id="divcons" class="main_border_line" style="overflow:scroll; height:150px; width:731px;">
		<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblFinishLine">
			<caption></caption>
			<tr>
				<th>Size</th>
				<th>PO Qty</th>
				<th>Received Qty</th>
				<th>Issued Qty</th>
				<th>Issue Qty</th>
				<th>Balance Qty</th>
				<th>Status</th>
			</tr>
		</table>
	</div>
	<br />
	<table align="center" border="0" cellspacing="1" width="751">
		<tr>
			<td class="normalfnt" width="25">&nbsp;</td>
			<td class="normalfnt" width="85">&nbsp;</td>
		  <td width="631">&nbsp;</td>
		</tr>
	</table>
	<br />
	<table width="658">
		<tr>
			<td width="26%">&nbsp;</td>
			<td width="14%"><img src="../../images/new.png" name="New"></td>
			<td width="13%"><img src="../../images/save.png" alt="Save" name="Save"></td>
			<td width="15%"><img src="../../images/delete.png"></td>       
			<td width="16%" class="normalfnt"><img src="../../images/report.png"/></td>
			<td width="14%"><a href="../../main.php"><img src="../../images/close.png"></a></td>
			<td width="2%">&nbsp;</td>
		</tr>
	</table>
	</div>
</div>
</body>
</html>