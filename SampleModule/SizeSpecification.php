<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Size Specification</title>
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
		<div class="trans_text">Size Specification<span class="volu"></span></div>
			<table width="86%" border="0">
				<tr>
					<td width="10%" class="normalfnt">Meas. Unit</td>
					<td width="10%">
						<select id="" name="" style="width: 62px;" class="txtbox">
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
				  </td>
			  	  <td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
				  <td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
				  <td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
				  <td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
				  <td width="10%" class="normalfnt"><input id="" name=""type="text" class="txtbox" style="width:60px;" /></td>
				  <td width="10%" class="normalfnt"><input id="" name="" type="text" class="txtbox" style="width:60px;" /></td>
				  <td width="10%" class="normalfnt"><input id="" name=""type="text" class="txtbox" style="width:60px;" /></td>
				  <td width="10%" class="normalfnt"><input id="" name=""type="text" class="txtbox" style="width:60px;" /></td>
				</tr>
		  </table>
			<br />
		  <div style="overflow:scroll; height:150px; width:798px;" id="DivSizeSpecification">
		    <table style="width:780px" class="transGrid" id="tblSizeSpecification" border="1" cellspacing="1">
              <thead>
                <tr>
                  <td colspan="11">Size Specification </td>
                </tr>
                <tr>
                  <td width="38">Select</td>
                  <td width="249">Measurement Point</td>
                  <td>Tolarence</td>
                  <td>Size A</td>
                  <td>Size B</td>
                  <td>Size C</td>
                  <td>Size D</td>
                  <td>Size E</td>
                  <td>Size F</td>
                  <td>Size G</td>
                  <td>Size H</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td width="38"><input name="checkbox" id="checkbox" type="checkbox" class="txtbox"  /></td>
                  <td width="249">****</td>
                  <td width="65">****</td>
                  <td width="44">****</td>
                  <td width="48">****</td>
                  <td width="51">****</td>
                  <td width="49">****</td>
                  <td width="43">****</td>
                  <td width="42">****</td>
                  <td width="46">****</td>
                  <td width="47">****</td>
                </tr>
                <tr>
                  <td width="38"><input name="checkbox2" id="checkbox2" type="checkbox" class="txtbox"  /></td>
                  <td width="249">****</td>
                  <td width="65">****</td>
                  <td width="44">****</td>
                  <td width="48">****</td>
                  <td width="51">****</td>
                  <td width="49">****</td>
                  <td width="43">****</td>
                  <td width="42">****</td>
                  <td width="46">****</td>
                  <td width="47">****</td>
                </tr>
              </tbody>
            </table>
		  </div>
			<br />
			<table width="800" border="0">
				<tr>
					<td width="34%">&nbsp;</td>
					<td width="12%"><img src="../images/new.png" id="butNew" name="butNew" width="90" /></td>
					<td width="11%"><img src="../images/save.png" id="butSave" name="butSave" width="80" /></td>
					<td width="12%"><a href="../main.php"><img src="../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
					<td width="31%">&nbsp;</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>
