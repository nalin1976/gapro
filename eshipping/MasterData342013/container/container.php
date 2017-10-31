<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web | Container</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->


</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="container.js"></script>
</head>
<body>
<?php
	include "../../Connector.php";	
?>

<form id="frmContainer" name="frmContainer" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<tr>
	<td><table width="100%" border="0">
		<tr>
			<td>
			  <table width="500" border="0" class="bcgl1" align="center">
			    <tr>
			      <td height="30" bgcolor="#588DE7" class="TitleN2white" align="center">Container</td>
			      </tr>
			    <tr bgcolor="#FFFFFF">
			      <td ><table width="100%" border="0" cellpadding="2" cellspacing="10">
			        
			          <tr>
			            <td align="center"><table width="90%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;Search Container </td>
			                <td width="44%" class="normalfnt">
			                  <select name="cboContainer" id="cboContainer" style="width:130px" class="txtbox" onchange="loadContainerData(this.value);">
                              <option value=0></option>
							  <?php
							  	$sql="SELECT intContainerId,strContainerName FROM container";
								 $result=$db->RunQuery($sql);
								 while($row=mysql_fetch_array($result))
								 {
							  ?>
							  <option value=<?php echo $row['intContainerId']; ?>><?php echo $row['strContainerName']; ?></option>
							  <?php
							  }
							  ?>
		                      </select></td>
			                <td width="15%" class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td width="9%" class="normalfnt">&nbsp;</td>
			                <td width="32%" class="normalfnt">&nbsp;Container&nbsp;<span class="compulsory">*</span></td>
			                <td class="normalfnt"><input name="txtContainer" id="txtContainer" style="width:130px" class="txtbox" type="text" tabindex="1" /></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;Description&nbsp;<span class="compulsory">*</span></td>
			                <td class="normalfnt"><input name="txtDescription" id="txtDescription" style="width:130px" class="txtbox" type="text" tabindex="2"/></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;Measurement&nbsp;<span class="compulsory">*</span></td>
			                <td class="normalfnt"><input name="txtMeasurement" id="txtMeasurement" style="width:130px" class="txtbox" type="text" tabindex="3" /></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
		                </table></td>
		              </tr>
			        <tr>
			          <td></td>
			          </tr>
			        </table></td>
		        </tr>
			    <tr>
			      <td height="34" colspan="2"><table width="100%" border="0" class="bcgl1">
			        <tr>
			          <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
			            <tr>
			              
			              <td align="center"><img src="../../images/new.png" id="btnNew" class="mouseover" name="btnNew" tabindex="7" onclick="clearForm();" /><img src="../../images/save.png" alt="Save" width="84" height="24" name="btnSave" id="btnSave"  class="mouseover" onclick="validateData();" tabindex="6" /><img src="../../images/delete.png" id="btnDel" class="mouseover" name="btnDel" tabindex="7" onclick="deleteData();" /><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="btnClose"lass="mouseover" tabindex="8"/></a></td>
			              </tr>
			            
			            </table></td>
			          </tr>
			        </table>
		          </td>
		        </tr>
		      </table>		    </td>
		  </tr>
	</table>
	</td>
</tr>
</table>
</form>
</body>
</html>
