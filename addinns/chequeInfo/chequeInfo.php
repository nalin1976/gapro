<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cheque Information</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="../banks/bank-js.js"></script>
<script src="../country/Button.js"></script>
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

</head>

<body>

<?php
include "../../Connector.php";

?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>


<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Cheque Information <span class="vol">(Ver 0.3)</span><span id="chequeInformation _popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td><?php #include $backwardseperator ."Header.php";?></td>
  </tr>-->
  <tr>
    <td height="139"><table align="center" width="500" border="0">
      <tr>
        <td width="48%"><form id="frmChequeInfo" name="frmChequeInfo" method="post" action="">
          <table width="532" border="0" class="tableBorder">
<!--            <tr>
              <td height="35" colspan="3" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                    <td width="72%" class="mainHeading">Cheque Information </td>
                    <td width="15%" class="seversion"> (Ver 0.3) </td>
                  </tr>
                </table></td>
            </tr>-->
            <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="58" >&nbsp;</td>
              <td width="157" class="normalfnt">Search</td>
              <td width="295" align="left"><select name="frmChequeInfo_cbofrmChequeInfoList" class="txtbox" id="frmChequeInfo_cbofrmChequeInfoList" style="width:167px" tabindex="1" onchange="getChequeDetails();">
   
 <?php
	
	$SQL = "SELECT intId,strName from bankchequeinfo ORDER BY strName";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intId"] ."\">" . cdata($row["strName"]) ."</option>" ;
	}
	
	?>
	
	 </select></td>
            </tr>
			
            <tr>
              <td >&nbsp;</td>
              <td class="normalfnt">Cheque book Name&nbsp;<span class="compulsoryRed">*</span></td>
              <td align="left"><input name="frmChequeInfo_txtChequeBookName" type="text" class="txtbox" id="frmChequeInfo_txtChequeBookName"  style="width:165px" maxlength="10" tabindex="2"  onkeypress="return checkForTextNumber(this.value, event);"/></td>
            </tr>
			
                    <tr>
                      <td width="11">&nbsp;</td>
                      <td class="normalfnt">Bank <span class="compulsoryRed">*</span></td>
                      <td colspan="4"><select  name="frmChequeInfo_cboBankName"   id="frmChequeInfo_cboBankName" style="width:168px" tabindex="3" onchange="loadBankandBranch(this.value);">
                        <?php
	
	$SQL = "SELECT intBankId, bank.strBankName FROM bank  where intStatus<>10 order by strBankName asc";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$x = $row["strBankName"];
	?>
		
		<option value="<?php echo $row["intBankId"] ?>"/><?php echo cdata($x) ?></option>
		<?php
	}
	
	?>
                      </select>
					  <img src="../../images/add.png" alt="Add" width="16" height="16" class="mouseover" align="absbottom" onclick="popupChequeBank();"/></td>
                      </tr>
			<tr>
              <td  >&nbsp;</td>
              <td class="normalfnt">Branch <span class="compulsoryRed">*</span></td>
              <td align="left"><select tabindex="4"  name="frmChequeInfo_cboBranchCode" id="frmChequeInfo_cboBranchCode"  style="width:168px"></select>
			  <img src="../../images/add.png" alt="Add" width="16" height="16" class="mouseover" align="absbottom" onclick="popupChequeBranch();"/></td>
            </tr>
			
			<tr>
              <td  >&nbsp;</td>
              <td class="normalfnt">Start No<span class="compulsoryRed">*</span></td>
              <td align="left"><input tabindex="5"  name="frmChequeInfo_txtStartNo" type="text" class="txtbox" id="frmChequeInfo_txtStartNo"  style="width:100px;text-align:right"  maxlength="10" onkeypress="return CheckforValidDecimal(this.value,0,event);"/> </td>
            </tr>
			
			<tr>
              <td  >&nbsp;</td>
              <td class="normalfnt">End No&nbsp;<span class="compulsoryRed">*</span></td>
              <td align="left"><input tabindex="6"  name="frmChequeInfo_txtEndNo" type="text" class="txtbox" id="frmChequeInfo_txtEndNo"  style="width:100px;text-align:right" maxlength="10" onkeypress="return CheckforValidDecimal(this.value,0,event);"/></td>
            </tr>
		
            <tr>
              <td >&nbsp;</td>
			  <td class="normalfnt">Active</td>
                      <td class="normalfnt"><input tabindex="7" type="checkbox" name="frmChequeInfo_chkActive" id="frmChequeInfo_chkActive" checked="checked" /></td>
            </tr>
            <tr>
              <td >&nbsp;</td>
              <td height="3">&nbsp;</td>
              <td height="3">&nbsp;<span id="countries_txtHint" style="color:#FF0000"></span></td>
            </tr>
            <tr>
              <td height="21" colspan="3" bgcolor=""><table width="100%" border="0" class="tableFooter">
                <tr>
                  <td width="25%">&nbsp;</td>
                  <td width="10%"><img src="../../images/new.png" class="mouseover" alt="New" name="New" id="butNew"  tabindex="12" onclick="ClearForm2();"/></td>
                  <td width="10%"><img src="../../images/save.png" class="mouseover" alt="Save" name="Save" id="butSave"  tabindex="8" onclick="butCommandC(this.name)"/></td>
				  <td width="10%"><img src="../../images/delete.png" class="mouseover" alt="Delete" name="Delete" id="butDelete" tabindex="9"  onclick="cheque_ConfirmDelete(this.name)"/></td>                  
				 <td width="10%" class="normalfnt"><img src="../../images/report.png" alt="Report" border="0" id="butReport" tabindex="10" class="mouseover" onclick="loadCIReport();"  /></td>
                  <td width="10%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" id="butClose" name="Close" border="0" tabindex="11"/></a></td>
                  <td width="25%">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
         </form>        </td>
      </tr>
    </table></td>
  </tr>
 
</table>
</div>
</div>
</body>
</html>
