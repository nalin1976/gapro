<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Unit Connersion</title>

<!--<link href="../../Units/css/erpstyle.css" rel="stylesheet" type="text/css" />-->
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="unitConversion.js"></script>
<script src="../../javascript/script.js"></script>
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
		<div class="main_text">Unit Conversion<span id="units_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmUnits" name="frmUnits" method="post" action="">
<table width="93%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
  	 <td align="center">&nbsp;</td>
    <td align="center" class="normalfnt">From Unit <span class="redText">*</span></td>
	<td align="" >
		<select id="cboFromUnit" name="cboFromUnit" style="width:100px;" onchange="loadToUnit(this);"> 
			<option value=""></option>
			<?php 
				$sqlUnit1="select strUnit from units where intStatus=1 order by strUnit;";
				$res1=$db->RunQuery($sqlUnit1);
				 while($row1=mysql_fetch_array($res1)){
				 ?>
				 	<option value="<?php echo $row1['strUnit'];?>"><?php echo $row1['strUnit'];?></option>
				<?php }
			?>
		</select>
	</td>
	<td colspan="3">&nbsp;</td>
	</tr>
	
	<tr>
	<td>&nbsp;</td>
	<td align="center" class="normalfnt">To Unit<span class="redText">*</span></td>
	<td align="">
	<select id="cboToUnit" name="cboToUnit" style="width:100px;">
		<option value=""></option>
	 </select></td>
	 <td colspan="3">&nbsp;</td>
	 </tr>
	 <tr>
	 	<td>&nbsp;</td>
		<td align="center" class="normalfnt">Factor<span class="redText">*</span></td>
		<td align="" ><input type="text" maxlength="10" id="txtFactor" name="txtFactor" style="width:100px;text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
		<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="6">
		<table align="center">	
			<tr>
				<td><img src="../../images/new.png" onclick="setNew();" /></td>
				<td><img src="../../images/save.png" onclick="saveDet();" /></td>
				<td><a href="../../main.php"><img src="../../images/close.png" style="border:none;" /></a></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td colspan="6" class="tableBorder">
		<div style="width:500px;height:250px;overflow:scroll;">
		<table width="100%" id="tblmain" >
			<thead>
				<tr>
					<td class="grid_header">&nbsp;</td>
					<td class="grid_header">&nbsp;</td>
					<td class="grid_header">From Unit</td>
					<td class="grid_header">To Unit</td>
					<td class="grid_header">Factor</td>
				</tr>
			</thead>
			<tbody>
				<?php 
					$c=0;
					$cls="normalfnt";
					
					$sqlGrid="SELECT intSerialNo,strFromUnit,strToUnit,dblFactor from unitconversion order by intSerialNo;";
					$result=$db->RunQuery($sqlGrid);
					while($row=mysql_fetch_array($result)){
					($c%2==0)?$cls="grid_raw":$cls="grid_raw2";
				?>
				<tr>
					<td class="<?php echo $cls;?>" id="<?php echo $row['intSerialNo'];?>"><img src="../../images/del.png" onclick="deleteUnit(this);" /></td>
					<td class="<?php echo $cls;?>"><img src="../../images/edit.png" onclick="editUnit(this);" /></td>
					<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strFromUnit'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strToUnit'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblFactor'];?></td>
				</tr>
				<?php $c++;}?>
			</tbody>
		</table>
		</div>
	</td>
  </tr>
</table>
</form>
</div>
</div>
</body>
</html>
