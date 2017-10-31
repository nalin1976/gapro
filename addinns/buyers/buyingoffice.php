<?php
$backwardseperator = "../../";
$pub_url = "/gaprohela/";
 session_start();
 $buyerName	= $_GET["buyerName"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buyers</title>

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
<!--<script src="button.js"></script>
<script src="Search.js"></script>-->
<script src="button.js" type="text/javascript"></script>
<script src="Search.js" type="text/javascript"></script>

</head>

<body>
<?php
	include "../../Connector.php";	
?>
<form id="frmBuyers" name="frmBuyers" method="post" action="">

  <table width="100%" border="0" bgcolor="#FFFFFF" align="center" > 
  <tr>
  	<td id="td_BoHeader">yrhr</td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Buyers Office<span class="vol">(Ver 0.3)</span><span id="buyingOffice_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="tableBorder">          
          <tr>
            <td colspan="2" class="normalfntMid" align="center"><div id="divcons" style="overflow:scroll; height:125px; width:490px;">
                <table id="tblBuyerOffic" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" class="tableBorder">
                  <tr>
                    <td width="39" height="17" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
                    <td width="436" bgcolor="#498CC2" class="normaltxtmidb2" style="text-align:center">Buying Office Name</td>
                  </tr>
                  <?php
$sql="select strName from buyerbuyingoffices where intBuyerID='$buyerName' and intStatus!=10";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
                  <tr class="bcgcolor-tblrowWhite">
                    <td class="normalfntMid"><input name="checkbox" type="checkbox" checked="checked"/></td>
                    <td class="normalfnt" ><?php echo cdata($row["strName"]);?></td>
                  </tr>
                  <?php
}
?>
                </table>
            </div></td>
          </tr>
          <tr height="5">
            <td width="28%" height="5"class="normalfnt">&nbsp;</td>
            <td width="72%" height="5" class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="normalfnt"><table width="100%" border="0" align="center">
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Search</td>
                  <td colspan="3"><select name="cboBoName" class="txtbox"  onchange="GetBuyingOfficeDetails();" style="width:325px" id="cboBoName" tabindex="1">
                      <?php
	
	$SQL = "SELECT intBuyingOfficeId, strName FROM buyerbuyingoffices where intStatus!=10 and intBuyerID='$buyerName' order by strName ";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyingOfficeId"] ."\">" . cdata($row["strName"]) ."</option>" ;
	}
	
	?>
                  </select></td>
                </tr>
                <tr>
                  <td width="2" class="normalfnt">&nbsp;</td>
                  <td width="77" class="normalfnt">Name&nbsp;<span class="compulsoryRed">*</span></td>
                  <td colspan="3"><input name="txtBOName" type="text" class="txtbox" id="txtBOName"  size="50" maxlength="100" style="width:323px" tabindex="2"/></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Address</td>
                  <td colspan="3"><input name="txtBOAddress1" type="text" class="txtbox" id="txtBOAddress1"  size="50" maxlength="45" style="width:323px" tabindex="3"/></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Street</td>
                  <td colspan="3"><input name="txtBOStreet" type="text" class="txtbox" id="txtBOStreet" size="50" maxlength="30" style="width:323px" tabindex="4"/></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">City</td>
                  <td width="163"><input name="txtBOCity" type="text" class="txtbox" id="txtBOCity" style="width:155px" maxlength="30" tabindex="5"/></td>
                  <td width="61">State</td>
                  <td width="173"><input name="txtBOState" type="text" class="txtbox" id="txtBOState" style="width:93px" maxlength="30" tabindex="6"/></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Country</td>
                  <td><!--<input name="txtBOCountry" type="text" class="txtbox" id="txtBOCountry" size="16" />-->
                      <select name="cmbCountry" id="cmbCountry" class="txtbox" style="width:157px" tabindex="7" onchange="GetpopZipCode(this.value)">
                        <?php 
							$SQL = " Select strCountryCode,strCountry from country ";
							$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountryCode"] ."\">" . $row["strCountry"] ."</option>" ;
	}
						?>
                      </select>                  </td>
                  <td>Zip</td>
                  <td><input tabindex="8" name="txtBOZipCode" type="text" class="txtbox" id="txtBOZipCode" style="width:93px" readonly="readonly"/></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Web</td>
                  <td><input name="txtBOWeb" type="text" class="txtbox" id="txtBOWeb" style="width:155px" maxlength="30" tabindex="9"/></td>
                  <td>Fax</td>
                  <td><input name="txtBOFax" type="text" class="txtbox" id="txtBOFax" style="width:93px" maxlength="30" tabindex="10"/></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">E-Mail</td>
                  <td><input name="txtBOEmail" type="text" class="txtbox" id="txtBOEmail" style="width:155px" maxlength="30" tabindex="11"/></td>
                  <td>Phone</td>
                  <td><input name="txtBOPhone" type="text" class="txtbox" id="txtBOPhone" style="width:93px" maxlength="30" tabindex="12"/></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Remarks</td>
                  <td colspan="3"><textarea name="txtBORemarks" style="width:323px"  rows="2" class="txtbox" id="txtBORemarks" onkeypress="return imposeMaxLength(this,event, 45);" tabindex="14"></textarea></td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Active</td>
                  <td colspan="3"><input type="checkbox" name="chkActive" id="chkActive" checked="checked"  tabindex="14"/></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2" class="normalfnt">&nbsp;</td>
          </tr>
		   <tr>
				<td colspan="2"><img src="<?php echo $pub_url?>images/new.png" alt="New" name="butBoNew" class="mouseover" onclick="ClearDetails(1);" id="butNew" tabindex="18"/>
				<img src="<?php echo $pub_url?>images/save.png" alt="Save" name="butBosave"  height="24" class="mouseover" onclick="butSaveBuyingOffice();" id="butSave" tabindex="15"/>
				<img src="<?php echo $pub_url?>images/delete.png" alt="Delete" name="butBoDelete" width="100" height="24" class="mouseover" onclick="ConformDeleteBO(this.name)" id="butDelete" tabindex="16"/>
				<a id="td_BoDelete" href="../../main.php"><img src="<?php echo $pub_url?>images/close.png" alt="Close" name="Close"  height="24" border="0" class="mouseover" onclick="closeWindow();" id="butClose" tabindex="17"/></a></td>
          </tr>
      </table></td>
    </tr>
<!--    <tr>
      <td height="34"><table width="550" border="0" >
          <tr>
            <td width="100%" bgcolor=""><table width="100%" border="0">
                <tr>
                  <td width="28%"><img src="<?php echo $pub_url?>images/new.png" alt="New" name="butBoNew" align="right" class="mouseover" onclick="ClearDetails(1);" id="butNew" tabindex="18"/></td>
                  <td width="18%"><img src="<?php echo $pub_url?>images/save.png" alt="Save" name="butBosave"  height="24" align="middle" class="mouseover" onclick="butSaveBuyingOffice();" id="butSave" tabindex="15"/></td>
                  <td width="22%" ><img src="<?php echo $pub_url?>images/delete.png" alt="Delete" name="butBoDelete" width="100" height="24" align="right" class="mouseover" onclick="ConformDeleteBO(this.name)" id="butDelete" tabindex="16"/></td>
                  <td width="32%" id="td_BoDelete"><img src="<?php echo $pub_url?>images/close.png" alt="Close" name="Close"  height="24" border="0" align="left" class="mouseover" onclick="closeWindow();" id="butClose" tabindex="17"/></td>
                </tr>
            </table></td>
          </tr>-->
      </table></td>  
    </div>
  </div>
</form>
</body>
</html>
