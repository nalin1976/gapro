<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function A(){
if(document.getElementById("payee_cboCustomer").value != "")
document.getElementById("payee_txtAddress1").focus();

}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Payee</title>
<?php
$backwardseperator = "../../";
session_start();

?>
<link href="file:///C|/Inetpub/wwwroot/css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<script src="Button.js" type="text/javascript"></script>
<script src="../../javascript/script.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmpayee" name="frmpayee" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Payee<span class="vol">(Ver 0.3)</span><span id="payee_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td><?php #include $backwardseperator."Header.php";?></td>
  </tr>-->
  <tr>
    <td><table width="600" border="0" class="tableBorder" align="center" id="tblmain" cellspacing="0" cellpadding="3">
<!--
          <tr>
            <td height="25" bgcolor="#498cc2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Payee </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr>-->
          <tr>
            <td height="96" align="center">
              <table width="90%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="3" class="normalfnt">
                  <table width="100%" border="0">
                  	<tr>
                    <td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                    <td width="4%" class="normalfnt">&nbsp;</td>
                    <td width="18%" class="normalfnt">Search</td>
                  	<td colspan="5"><select name="payee_cboCustomer" class="txtbox" onchange="getPayeeDetails();" style="width:321px" id="payee_cboCustomer" tabindex="1">
							<?php
	
	$SQL = "SELECT * FROM payee where intStatus<>10 order by strTitle ASC ";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intPayeeID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                    </tr>
                    <tr>
                    	<td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="4%" class="normalfnt">&nbsp;</td>
                      <td width="18%" class="normalfnt">Name <span class="compulsoryRed">*</span></td>
                      <td colspan="5"><input name="payee_txtName" type="text" AutoCompleteType="Disabled" autocomplete="off" class="txtbox" id="payee_txtName" maxlength="100" style="width:320px"  tabindex="2"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address</td>
                      <td colspan="5"><input name="payee_txtAddress1" type="text" class="txtbox" id="payee_txtAddress1" style="width:320px" maxlength="100" tabindex="3"/></td>
                    </tr>
                    <!--<tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="5"><input name="payee_txtAddress2" type="text" class="txtbox" id="payee_txtAddress2" style="width:320px"  maxlength="50"/></td>
                    </tr>-->
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Street</td>
                      <td colspan="5"><input name="payee_txtStreet" type="text" class="txtbox" id="payee_txtStreet" style="width:320px" maxlength="50" tabindex="4"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">City</td>
                      <td style="width:120px"><input name="payee_txtCity" type="text" class="txtbox" id="payee_txtCity" style="width:120px" maxlength="50" tabindex="5"/></td>
                      <td style="width:70px">State</td>
                      <td colspan="2"><input name="payee_txtState" type="text" class="txtbox" id="payee_txtState" style="width:120px" maxlength="10" tabindex="6"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country <span class="compulsoryRed">*</span></td>
                      <td ><select name="payee_txtCountry" class="cboCountry" id="payee_txtCountry" style="width:100px" onchange="LoadPayeeZipCode(this.value);" tabindex="7">
							<?php
			$SQL="SELECT country.strCountry,country.intConID FROM country WHERE (((country.intStatus)=1)) ORDER BY strCountry;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		if($_SESSION["sys_country"]==$row["intConID"]){
			echo "<option value=\"". $row["intConID"] ."\" selected=\""."selected"."\">" . $row["strCountry"] ."</option>" ;
		}
		else{
			echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
		}
	}
		  
?> 	
						
						
						
						
                        </select>
<img align="absbottom"  src="../../images/add.png" width="16" height="16" onclick="showCountryPopUp()" /></td>
						<?php
							$SQL="SELECT * FROM country WHERE intConID='".$_SESSION["sys_country"]."'";
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								$txtZipCode  = $row['strZipCode'];;
							}
							
						?>
                      <td style="width:70px">Zip Code</td>
                      <td colspan="2"><input name="payee_txtZipCode" type="text" class="txtbox" id="payee_txtZipCode" value="<?php echo $txtZipCode ?>" style="width:120px" maxlength="10" tabindex="8"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Phone</td>
                      <td><input name="payee_txtPhone" type="text" class="txtbox" id="payee_txtPhone" style="width:120px"   maxlength="50" tabindex="9"/></td>
                      <td style="width:70px">Fax</td>
                      <td colspan="2"><input name="payee_txtFax" type="text" class="txtbox" id="payee_txtFax" style="width:120px"  maxlength="50" tabindex="10"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">e-Mail</td>
                      <td colspan="5"><input name="payee_txtEmail" type="text" class="txtbox" id="payee_txtEmail" style="width:320px"  maxlength="50" tabindex="11"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Web</td>
                      <td colspan="5"><input name="payee_txtWeb" type="text" class="txtbox" id="payee_txtWeb" style="width:320px" maxlength="50" tabindex="12"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td colspan="3">
					  <textarea style="width:320px" onchange="imposeMaxValue(this,200);" name="payee_txtRemarks"  rows="2" class="txtbox" id="payee_txtRemarks" onkeypress="return imposeMaxLength(this,event, 200);" tabindex="13"></textarea>					  </td>
                    </tr>
					<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td colspan="5"><input type="checkbox" name="payee_chkActive" id="payee_chkActive" checked="checked" tabindex="14"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3" align="center"><div style="left:575px; top:445px; z-index:10; position:static; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="payeeloadReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="payeeloadReport();"/></div></td>
  </tr>
  </table>	  
  </div></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                  </table></td>
                  </tr>
              </table>              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="" align="center" >
                <table width="80%" border="0" style="border:none;" >
                    <tr>
                      <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td>
					  <td><img src="../../images/new.png" alt="New" name="New" id="butNew" onClick="clearFields();" tabindex="19"/></td>
                      <td><img src="../../images/save.png" alt="Save" name="Save" id="butSave"  width="84" height="24" onClick="butCommand(this.name);" tabindex="15"/></td>
                      <td><img src="../../images/delete.png" alt="Delete" id="butDelete"  width="100" height="24" name="Delete" onClick="payeeConfirmDelete(this.name);" tabindex="16"/></td>
					  <td class="normalfnt"><img src="../../images/report.png" id="butReport"  alt="Report" width="108" height="24" border="0" class="mouseover" onclick="listORDetails();" tabindex="17" /></td>
                      <td><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="butClose" tabindex="18"/></a></td> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

  </div>
  </div>
</form>
</body>
</html>

