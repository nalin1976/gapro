<?php
	 session_start();
	 include "Connector.php";
	 $StyleId = $_GET["StyleId"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Ratio</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="javascript/subPartDetails.js"></script>
</head>

<body>
<table width="380" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td>
          <table width="100%" height="237" border="0" class="bcgl1">
            <tr  class="cursercross" onmousedown="grab(document.getElementById('frmSubPartDetails'));" >
              <td height="7" bgcolor="#498CC2" class="TitleN2white">Sub Contractor Details</td>
            </tr>
            <tr>
              <td height="3"><table width="103%" height="158" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center"></div></td>
                </tr>
                <tr>
                  <td><div id="divcons2" style="overflow:scroll; height:130px; width:420px;">
                      <table id="tblSubContractors" width="400" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
                          <td width="11%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">No</td>
                          <td width="47%" bgcolor="#498CC2" class="normaltxtmidb2">Part</td>
                          <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">C &amp; M </td>
                          <td width="27%" bgcolor="#498CC2" class="normaltxtmidb2">Transport/pc</td>
                        </tr>
<?php
	$sql="select * from stylepartdetails where intStyleId ='$StyleId'";
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{ 	
		
	$sqlSub="select * from stylepartdetails_sub where intStyleId ='$StyleId' AND intPartId ='" . $row["intPartId"] . "' ";
	$resultSub = $db->RunQuery($sqlSub);
	$rowcount = mysql_num_rows($resultSub);
	if($rowcount>0)
	{
		while($rowSub = mysql_fetch_array($resultSub))
	{
	?>
			<tr>
		  <td class="normalfntMid"><img src="images/del.png" alt="del" width="15" height="15" onclick="RemoveSubRowItem(this)"/></td>
		  <td class="normalfntMid"><?php echo $rowSub["intPartNo"]?></td>
		  <td class="normalfnt"><input type="text" name="txtpart" id="txtpart" class="txtbox" size="20" style="text-align:left" value="<?php echo $rowSub["strPartName"]?>" /></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $rowSub["dblCM"]?>" /></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $rowSub["dblTransportCost"]?>" /></td>
		</tr>
	<?php
	}
	}
	else
	{
	?>
		<tr>
		  <td class="normalfntMid"><img src="images/del.png" alt="del" width="15" height="15" onclick="RemoveSubRowItem(this)"/></td>
		  <td class="normalfntMid"><?php echo $row["intPartNo"]?></td>
		  <td class="normalfnt"><input type="text" name="txtpart" id="txtpart" class="txtbox" size="20" style="text-align:left" value="<?php echo $row["strPartName"]?>" /></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" /></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" /></td>
		</tr>
	<?php
	}
	?>
<?php
	
	}
?> 
                      </table>
                  </div></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="32"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#D6E7F5">
                  <td width="30%">&nbsp;</td>
                  <td width="23%"><img src="images/ok.png" alt="ok" width="86" height="24" onclick="Save();" /></td>
                                   
                  <td width="26%"><img src="images/close.png" width="97" height="24" onclick="closeWindow();" /></td>
                  <td width="21%">&nbsp;</td>
                </tr>
             
          </table>
        </form></td>
        <td width="32%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
