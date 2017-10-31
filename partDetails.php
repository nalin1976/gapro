<?php
	 session_start();
	 include "Connector.php";
	 $StyleId =$_GET["StyleId"];
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
<script type="text/javascript" src="javascript/partDetails.js"></script>
<script src="javascript/preorder.js" type="text/javascript"></script>
<!--<link href="file:///C|/Inetpub/wwwroot/GaPro/css/erpstyle.css" rel="stylesheet" type="text/css" />
--><link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="divPart" style="overflow:hidden; height:300px; width:570px;">
<table id="tblMain" width="570" border="0" align="" bgcolor="#FFFFFF">
  <tr>
    <td> <table width="100%" height="237" border="0" class="bcgl1">
            <tr class="cursercross" onmousedown="grab(document.getElementById('frmpartDetails'));" >
              <td height="7" bgcolor="#498CC2" class="TitleN2white">Part Details</td>
            </tr>
            <tr>
              <td height="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center"></div></td>
                  </tr>
                <tr>
                  <td><div id="divPartDetails" style="overflow:scroll; height:130px; width:557px;">
                      <table  id="tblPartDetails" width="520" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
                          <td width="11%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">No</td>
                          <td width="35%" bgcolor="#498CC2" class="normaltxtmidb2">Part</td>
                          <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Sewing SMV</td>
                          <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Pack SMV</td>
                          <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">EFF%</td>
                          <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Garment Dye</td>
                          <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2"> Permanent Creasing</td>
                        </tr>
<?php
	$SQLPart="select * from stylepartdetails where intStyleId ='$StyleId'";
	$resultPart = $db->RunQuery($SQLPart);
	
	$booOption ="false";
	while($partRow = mysql_fetch_array($resultPart))
	{
	$booOption ="true";
 ?>                      
		<tr>
		  <td height="20" class="normalfntMid"><img src="images/del.png" alt="del" width="15" height="15" onclick="RemoveRowItem(this);"/></td>
		  <td class="normalfntMid"><?php echo $partRow["intPartNo"]?></td>
		  <td class="normalfnt"><input type="text" name="txtpart" id="txtpart" class="txtbox" size="20" style="text-align:left" value="<?php echo $partRow["strPartName"]?>" /></td>
		  <td class="normalfntMid"><input type="text" name="txtSmv2" id="txtSmv2" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $partRow["dblsmv"]?>"  onblur="CalculateEff(this);" /></td>
                  <td class="normalfntMid"><input type="text" name="txtPackSMV" id="txtPackSMV" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $partRow["dblPackSMV"]?>"  onblur="CalculateEff(this);" /></td>
		  <td class="normalfntMid"><input type="text" name="txtEFF" id="txtEFF" class="txtbox" size="8" style="text-align:right"  value="<?php echo $partRow["dblEffLevel"]?>" readonly="" />		  </td>
                  <td class="normalfntMid"><input type="checkbox" id="chkGD" name="chkGD" <?php if($partRow["iGarmentDye"] == 1){echo "checked='checked'";} ?>></input></td>
                  <td class="normalfntMid"><input type="checkbox" id="chkPC" name="chkPC" <?php if($partRow["iPermanantCreasing"] == 1){echo "checked='checked'";} ?>></input></td>
		</tr>
<?php
	}

if($booOption=="false")
{
?>                   
		<tr>
		  <td height="20" class="normalfntMid"><img src="images/del.png" alt="del" width="15" height="15" onclick="RemoveRowItem(this);"/></td>
		  <td class="normalfntMid">1</td>
		  <td class="normalfnt"><input type="text" name="txtpart" id="txtpart" class="txtbox" size="20" style="text-align:left" value="" /></td>
		  <td class="normalfntMid"><input type="text" name="txtSmv" id="txtSmv" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="CalculateEff(this);"/></td>
                  <td class="normalfntMid"><input type="text" name="txtPackSMV" id="txtPackSMV" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="CalculateEff(this);" /></td>
		  <td class="normalfntMid"><input type="text" name="txtEFF" id="txtEFF" class="txtbox" size="8" style="text-align:right" value="" readonly=""/>		  </td>
		  <td class="normalfntMid"><input type="checkbox" id="chkGD" name="chkGD" <?php if($SmokingState == 1){echo "checked='checked'";} ?>></input></td>
                  <td class="normalfntMid"><input type="checkbox" id="chkPC" name="chkPC" <?php if($SmokingState == 1){echo "checked='checked'";} ?>></input></td>
                  <td class="normalfntMid"><input type="checkbox" id="chkGD" name="chkGD" <?php if($partRow["iGarmentDye"] == 1){echo "checked='checked'";} ?>></input></td>
                  <td class="normalfntMid"><input type="checkbox" id="chkPC" name="chkPC" <?php if($partRow["iPermanantCreasing"] == 1){echo "checked='checked'";} ?>></input></td>s
                  </td>
		</tr>
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
                  <td width="16%">&nbsp;</td>
                  <td width="23%"><img src="images/ok.png" alt="ok" width="86" height="24" onclick="SavePartDetails();" /></td>
                  <td width="27%"><img src="images/addsmall.png" alt="add" width="95" height="24" onclick="AddPartRow();" /></td>
                  <td width="33%"><img src="images/close.png" width="97" height="24" onclick="SavePartDetails(); closeWindow();" /></td>
                  <td width="1%">&nbsp;</td>
                </tr>
          </table>
        </form></td>
        
      </tr>
    </table></td>
  </tr>
</table>
</div>

</body>
</html>
