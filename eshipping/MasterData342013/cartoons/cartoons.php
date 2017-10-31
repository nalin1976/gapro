<?php
$backwardseperator = "../../";
session_start();
$userId	 	= $_SESSION["UserID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web | Cartons</title>
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
<script src="cartoons.js"></script>
</head>
<body>
<?php
	include "../../Connector.php";	
?>

<form id="frmCartoons" name="frmCartoons" >
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
			      <td height="30" bgcolor="#588DE7" class="TitleN2white" align="center">Cartons</td>
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
			                <td class="normalfnt">&nbsp;Cartoons</td>
			                <td width="49%" class="normalfnt">
			                  <select name="cboCartoons" id="cboCartoons" style="width:130px" class="txtbox" onchange="loadData(this.value);">
                              <option value=''></option>
                              <?php
							  $sql = "select intCartoonId,strCartoon,intUserId  from cartoon WHERE intUserId='$userId'	
 										order by strCartoon;";
							  $result=$db->RunQuery($sql);
							  while($row=mysql_fetch_array($result))
							  {
								   echo "<option value=".$row['intCartoonId'].">".$row['strCartoon']."</option>";
							  }
							  ?>
		                      </select></td>
			                <td width="15%" class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td width="12%" class="normalfnt">&nbsp;</td>
			                <td width="24%" class="normalfnt">&nbsp;Length&nbsp;<span class="compulsory">*</span></td>
			                <td class="normalfnt"><input name="txtLength" id="txtLength" style="width:130px" class="txtbox" type="text" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="setCartoonValue();" tabindex="1" /></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;Width&nbsp;<span class="compulsory">*</span></td>
			                <td class="normalfnt"><input name="txtWidth" id="txtWidth" style="width:130px" class="txtbox" type="text" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="setCartoonValue();" tabindex="2"/></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;height&nbsp;<span class="compulsory">*</span></td>
			                <td class="normalfnt"><input name="txtheight" id="txtheight" style="width:130px" class="txtbox" type="text" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="setCartoonValue();" tabindex="3" /></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;Cartoons</td>
			                <td class="normalfnt"><input name="txtCartoons" id="txtCartoons" style="width:180px" class="txtbox" type="text" disabled="disabled"/></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt">&nbsp;Weight</td>
			                <td class="normalfnt"><input name="txtWeight" id="txtWeight" style="width:180px"  class="txtbox" type="text" tabindex="4" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
			                <td class="normalfnt">&nbsp;</td>
			                </tr>
			              <tr>
			                <td class="normalfnt">&nbsp;</td>
			                <td class="normalfnt" valign="top">&nbsp;Description</td>
			                <td class="normalfnt">
			                  <textarea name="textareaDes" id="textareaDes" cols="20" rows="2" tabindex="5"></textarea></td>
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
			              
			              <td align="center"><img src="../../images/new.png" id="btnNew" class="mouseover" name="btnNew" tabindex="7" onclick="clearData();" /><img src="../../images/save.png" alt="Save" width="84" height="24" name="btnSave" id="btnSave"  class="mouseover" onclick="saveData();" tabindex="6" /><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="btnClose"lass="mouseover" tabindex="8"/></a></td>
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
