<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Branch</title>

<script src="button.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../banks/bank-js.js"></script>
<script src="../country/Button.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {color: #800040}
-->
</style>
</head>
<body>

<?php

include "../../Connector.php";

?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_brnchHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Branch<span class="vol">(Ver 0.3)</span><span id="branch_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmBranch" name="frmBranch" method="POST" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!-- <tr>
    <td id="td_brnchHeader"><?php #include "../../Header.php";?></td>
  </tr>-->
  <tr>
    <td align="center"><table width="600" height="480" border="0" class="tableBorder">
<!--     <tr class="">
        <td height="35" class="mainHeading"   ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
              <td width="72%" class="mainHeading">Branch </td>
              <td width="15%" class="seversion"> (Ver 0.3) </td>
            </tr>
        </table></td>
      </tr>-->
      <tr>
        <td ><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%" class="normalfnt"><table width="100%" border="0">
                  <tr>
                    <td class="normalfnt" width="2%">&nbsp;</td>
                    <td class="normalfnt" width="19%">&nbsp;</td>
                    <td class="normalfnt" width="29%">&nbsp;</td>
                    <td class="normalfnt" width="12%">&nbsp;</td>
                    <td class="normalfnt" width="38%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25">Search Name </td><!--onchange="getBranchDetails();"-->
                    <td colspan="3"><select name="branch_cboBranchName" id="branch_cboBranchName" style="width:382px" tabindex="1" onchange="GetBranchDetails(this);">
                        <?php
	
	 $SQL = "SELECT intBranchId,strName FROM branch WHERE intStatus<>10 order by strName ASC";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{?>
                        <option value="<?php echo $row["intBranchId"] ;?>" > <?php echo cdata($row["strName"]) ;?></option>
                        <?php }
	
	?>
                    </select></td>
                  </tr>
                  
                <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                  <td class="normalfnt" height="25">Branch Code <span class="compulsoryRed">*</span> </td>
                  <td colspan="3"><input tabindex="2" name="branch_txtBranchCode" type="text" id="branch_txtBranchCode" style="width:140px" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);" /></td>
                </tr>
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt" nowrap="nowrap">Branch Name<span class="compulsoryRed"> *</span></td>
                    <td colspan="3"><input maxlength="50" tabindex="3" name="branch_txtName" type="text" class="txtbox" id="branch_txtName" style="width:382px" /></td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt">Address</td>
                    <td colspan="3"><input maxlength="50" name="branch_txtAddress1" tabindex="4" type="text" class="txtbox" id="branch_txtAddress1" style="width:382px" /></td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="15">&nbsp;</td>
                    <td class="normalfnt">Street</td>
                    <td><input tabindex="4" name="branch_txtStreet" type="text" id="branch_txtStreet" style="width:140px" maxlength="50"></td>
                    <td>City</td>
                    <td><input tabindex="5" name="branch_txtCity" type="text" id="branch_txtCity" style="width:140px"  maxlength="50"></td>
                    </tr>
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt">Country <span class="compulsoryRed"> *</span></td>
                    <td><select tabindex="6" name="branch_cboCountry" class="txtbox" id="branch_cboCountry" style="width:142px">
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
                      </select>
                        <img src="../../images/add.png" alt="Add" width="16" height="16" class="mouseover" align="absbottom" onclick="popcountry_inbranch()" /></td>
                    <td class="normalfnt">Bank <span class="compulsoryRed"> *</span></td>
                    <td ><select tabindex="7" name="branch_cboBankName"  id="branch_cboBankName"style="width:140px">
                        <?php
	
	$SQL = "SELECT *FROM bank
            WHERE intStatus=1 order by strBankName";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBankId"] ."\">" . $row["strBankName"] ."</option>" ;
	}
	
	?>
                      </select>
                        <img src="../../images/add.png" alt="Add" width="16" height="16" class="mouseover" align="absbottom" onclick="popupBank();"/></td>
                    </tr>
                  
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt" >Phone</td>
                    <td colspan="3"><input maxlength="50" name="branch_txtPhone" tabindex="10" type="text" class="txtbox" id="branch_txtPhone" style="width:382px"></td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="22">&nbsp;</td>
                    <td>Fax</td>
                    <td colspan="3"><input maxlength="50" tabindex="11" name="branch_txtFax" type="text" class="txtbox" id="branch_txtFax" style="width:382px"></td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt">E-Mail</td>
                    <td colspan="3"><input  maxlength="50" tabindex="12" name="branch_txtEMail" type="text" class="txtbox" id="branch_txtEMail" style="width:382px"></td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="22">&nbsp;</td>
                    <td class="normalfnt">Ref. No</td>
                    <td colspan="3" height="22"><input maxlength="50" tabindex="13" name="branch_txtRefNo" type="text" class="txtbox" id="branch_txtRefNo" style="width:382px"></td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt" height="25">Contact Person</td>
                    <td colspan="3"><input maxlength="50" tabindex="14" name="branch_txtContactPerson" type="text" class="txtbox" id="branch_txtContactPerson" style="width:382px"></td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt" >Remarks</td>
                    <td colspan="3"><textarea tabindex="15"  style="width:382px" onchange="imposeMaxValue(this,200);" name="branch_txtRemarks"  rows="2" class="txtbox" id="branch_txtRemarks" onkeypress="return imposeMaxLength(this,event, 200);" ></textarea>                    </td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt">Active</td>
                    <td colspan="3"><input tabindex="16" type="checkbox" name="branch_chkActive" id="branch_chkActive" checked="checked" /></td>
                  </tr>
                  <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td class="normalfnt">&nbsp;</td>
                    <td colspan="3"><table width="200" border="0" class="tableBorder">
                      <tr>
                        <td colspan="5" class="mainHeading2">Account Details </td>
                      </tr>
                      <tr>
                        <td width="61" nowrap="nowrap">Acc. No </td>
                        <td width="125"><input tabindex="2" name="branch_txtAccountName" type="text" id="branch_txtAccountName" style="width:120px" maxlength="20" onkeypress="return checkForTextNumber(this.value, event);" /></td>
                        <td width="59">Currency </td>
                        <td width="91"><select tabindex="6" name="branch_cboCurrencyId" class="txtbox" id="branch_cboCurrencyId" style="width:80px">
                          <?php
			$SQL="select intCurID,strCurrency from currencytypes where intStatus=1 order by strCurrency;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{		
		echo "<option value=\"". $row["intCurID"] ."\">" . cdata($row["strCurrency"]) ."</option>" ;
	}
					?>
                        </select></td>
                        <td width="32"><img src="../../images/add_pic.png" alt="Add" class="mouseover" align="absbottom" onclick="AddAccountDetailsToGrid()" /></td>
                      </tr>
                      <tr>
                        <td colspan="5" ><table width="384" border="0" id="tblAccounts" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                          <tr class="mainHeading4" height="25" >
                            <td width="39">Del</td>
                            <td width="201">Account Name </td>
                            <td width="122">Currency</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>

                  <tr>
                    <td style="visibility:hidden" colspan="5" class="">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="35"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="">
            <tr>
              <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                  <tr>
                    <td width="15%">
					<div align="center">
					<img  src="../../images/new.png" id="butNew" tabindex="21" alt="New" name="New" onclick="clearformBranch();" class="mouseover"/>
                   <img src="../../images/save.png" tabindex="17" id="butSave" alt="Save" name="Save" onclick="butCmdSaveBranch(this.name)"  class="mouseover"/>
                    <img   class="mouseover" src="../../images/delete.png" id="butDelete" tabindex="18" alt="Delete" name="Delete" onclick="ConfirmDeleteBranch(this.name);"/>
                    <img  class="mouseover" src="../../images/report.png" id="but
							  report" tabindex="19" alt="Report" border="0"  onclick="listBranchPrintDetails();">
                  <a id="td_coDeleteBranch" href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="butClose" tabindex="20"/></a>
					</div>
					</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
   <tr >
    <td height="15"></td>
  </tr>
</table>


<div style="left:585px; top:485px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReportBranch();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReportBranch();"/></div></td>
  </tr>
  
  </table>	  

</div>
</form>
</div>
</div>
</body>
</html>
