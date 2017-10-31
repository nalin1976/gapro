<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Company Details</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include "../../Connector.php"
?>
<form id="frmCompanyDetails" name="frmCompanyDetails" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2" id="td_comDetHeader"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Company Details<span class="vol">(Ver 0.3)</span><span id="company_Details_popup_close_button"></span></div>
	</div>
<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td><?php #include "../../Header.php";?></td>
  </tr>-->
  <tr>
    <td><table width="585" border="0" align="center">
      <tr>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
  <!--        <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Company Details </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr> -->        
          <tr>
            <td height="47" ><table width="100%" border="0" class="bcgl1">
			  <tr>
                <td width="1" class="normalfnt">&nbsp;</td>
                <td width="129" class="normalfnt">Company</td>
                <td colspan="3">
					<select name="cbocompany" class="txtbox" id="cbocompany"  onchange="getCompanyDetails();" style="width:361px" tabindex="1">

					<?php
						$SQL="select intCompanyID,strName from companies where intStatus <> 10 order by strName";
						
							$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intCompanyID"] ."\">" . cdata($row["strName"]) ."</option>" ;
						}		  
					?>  
                    </select>				</td>                
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Company Code&nbsp;<span class="compulsoryRed">*</span></td>
                <td><input name="txtComCode" type="text" class="txtbox" id="txtComCode" style="width:140px"  maxlength="10" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2"/></td>
                <td class="normalfnt">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Company Name&nbsp;<span class="compulsoryRed">*</span></td>
                <td colspan="3"><input name="txtName" type="text" class="txtbox" id="txtName" style="width:360px" maxlength="50" tabindex="3"/></td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Address</td>
                <td colspan="3"><input name="txtAddress1" type="text" class="txtbox" id="txtAddress1" style="width:360px" maxlength="100" tabindex="4"/></td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Street</td>
                <td colspan="3"><input name="txtStreet" type="text" class="txtbox" id="txtStreet" style="width:360px" maxlength="50" tabindex="5"/></td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">City</td>
                <td><input name="txtCity" type="text" class="txtbox" id="txtCity" style="width:140px" maxlength="30" tabindex="6"/></td>
                <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="58"><span class="normalfnt">Country&nbsp;<span class="compulsoryRed">*</span></span></td>
                        <td width="158"> <select name="cboCountry" tabindex="7" class="txtbox" id="cboCountry" style="width:158px" >
                          <?php 
			$SQL="SELECT * FROM country WHERE country.intStatus=1 order by country.strCountry;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
	if($_SESSION["sys_country"]==$row["intConID"]){
	echo "<option value=\"". $row["intConID"] ."\" selected=\""."selected"."\">" . cdata($row["strCountry"]) ."</option>" ;
		}
		else{
		
		echo "<option value=\"". $row["intConID"] ."\">" . cdata($row["strCountry"]) ."</option>" ;
	}
	}
                      ?>
                                                </select></td>
                        <td width="62"><img  src="../../images/add.png" width="16" height="16" onclick="showCountryPopUppp()" class="mouseover" /></td>
                      </tr>
                                  </table></td>
                </tr>
              
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Phone</td>
                <td width="142"><input name="txtPhone" tabindex="8" type="text" class="txtbox" id="txtPhone" style="width:140px" maxlength="30" /></td>
                <td width="54" class="normalfnt">Fax</td>
                <td width="223"><input name="txtFax" type="text" tabindex="9" class="txtbox" id="txtFax" style="width:157px" maxlength="30"/></td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">E-Mail</td>
                <td colspan="3"><input name="txtEMail" tabindex="10" type="text" class="txtbox" id="txtEMail" style="width:360px" maxlength="30"/></td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Website</td>
                <td colspan="3"><input name="txtWeb" tabindex="11" type="text" class="txtbox" id="txtWeb" style="width:360px" maxlength="30"/></td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Remarks</td>
                <td colspan="3">
                  <textarea name="txtRemarks" style="width:360px"  rows="2" class="txtbox" id="txtRemarks" onkeypress="return imposeMaxLength(this,event, 200);" tabindex="12"></textarea>				</td>
              </tr>
              <tr>
                <td rowspan="4" class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Tin No</td>
                <td><input name="txtTINNo" type="text" class="txtbox" id="txtTINNo" style="width:140px" maxlength="30" tabindex="13"/></td>
                <td class="normalfnt">Reg No.</td>
                <td><input name="txtRegNo" type="text" class="txtbox" id="txtRegNo" style="width:157px" tabindex="14" maxlength="30"/></td>
              </tr>
              <tr>
                <td class="normalfnt">VAT No</td>
                <td><input name="txtVatAcNo" type="text" class="txtbox" id="txtVatAcNo" style="width:140px" tabindex="15" maxlength="30"/></td>
                <td class="normalfnt">VAT%</td>
                <td><input name="txtVatValue" type="text" class="txtbox" id="txtVatValue"onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:157px;text-align:right;" maxlength="5" tabindex="16"/></td>
              </tr>
              <tr>
                <td class="normalfnt">SVAT No </td>
                <td><input name="txtSVATNo" type="text" class="txtbox" id="txtSVATNo" style="width:140px" tabindex="17" maxlength="30"/></td>
                <td class="normalfnt">BOI No</td>
                <td><input name="txtBOINo" type="text" class="txtbox" id="txtBOINo" style="width:157px" maxlength="30" tabindex="18"/></td>
              </tr>
              <tr>
                <td class="normalfnt">Fac. Cost Per Min</td>
                <td><input name="txtFactroyCostPerMin" type="text" class="txtbox" id="txtFactroyCostPerMin" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:140px;text-align:right" maxlength="10" tabindex="19"/></td>
                <td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="52%">Default Invoice to </td>
                      <td width="48%"><select onchange="checkDefaultInvoiceStatus(this)" name="cboDefaultInvoiceTo" class="txtbox" id="cboDefaultInvoiceTo" style="width:72px" tabindex="21">
                        <option value="No" >No</option>
                        <option value="Yes" >Yes</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Account No </td>
                <td><input name="txtAccountNo" type="text" class="txtbox" id="txtAccountNo" style="width:140px" maxlength="10" tabindex="22"/></td>
                <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="52%" class="normalfnt"> Manufacturing  </td>
                    <td width="48%"><select onchange="checkDefaultInvoiceStatus(this)" name="cboManufac" class="txtbox" id="cboManufac" style="width:72px" tabindex="23">
                        <option value="0" >No</option>
                        <option value="1" >Yes</option>
                    </select></td>
                  </tr>
				  
                </table></td>
                </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Sequence No Start <span class="compulsoryRed">*</span></td>
                <td><input name="txtSequenceStart" type="text" class="txtbox" id="txtSequenceStart" style="width:140px" maxlength="10" tabindex="24" onkeypress="return IsNumberWithoutDecimals(this.value,event);"/></td>
                <td class="normalfnt">End <span class="compulsoryRed">*</span></td>
                <td><input name="txtSequenceEnd" type="text" class="txtbox" id="txtSequenceEnd" style="width:157px" maxlength="10" tabindex="25" onkeypress="return IsNumberWithoutDecimals(this.value,event);"/></td>
              </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Active</td>
                <td><input type="checkbox" name="chkActive" id="chkActive" checked="checked" tabindex="26"/></td>
                <td colspan="2"></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="50" border="0" align="center">
                    <tr>
                      <td width="20%"><img src="../../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearCompanyForm();" class="mouseover" id="butNew" tabindex="32"/></td>
                      <td width="19%"><img src="../../images/save.png" alt="Save" name="Save"width="84" height="24" onclick="butCommand1(this.name);" class="mouseover" id="butSave" tabindex="27"/></td>
                      <td width="22%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDeleteCompany(this.name);" class="mouseover" id="butDelete" tabindex="28"/></td>
					  					          <td width="12%" class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="25" border="0" class="mouseover" onclick="listORDetails();" id="butReport" tabindex="29" /></td>
                      <td width="17%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="25" border="0"  class="mouseover" id="butClose" tabindex="31"/></a></td>
                      </tr>
                </table></td>
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
<div style="left:375px; top:390px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReportCompany();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReportCompany();"/></div></td>
	<td>&nbsp;</td>
	<td align="right"><img src="../../images/cross.png" onclick="listORDetails();"/></td>
  </tr>
  </table>	  
  </div>
  </div>
  </div>
</form>
</body>
</html>
