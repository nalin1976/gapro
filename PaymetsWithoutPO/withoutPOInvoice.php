<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Without PO Invoice</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<style type="text/css">
<!--
body 
{
	background-color: #CCCCCC;
}
-->
</style>
<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
</style>

<script language="javascript" type="text/javascript" src="withoutPOInvoice.js"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


</head>

<body onload="setDefaultDate()">

<form name="frmWithoutPOInvoice" id="frmWithoutPOInvoice">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
	  <td height="6" colspan="2"><?php include '../Header.php'; ?></td>
    </tr>
	<tr>
       <td height="26" colspan="2"  bgcolor="#498CC2" class="normaltxtmidb2" >Payment - Without PO Invoice</td>
     </tr>  <tr>
    <td><table width="100%" border="0" class="tablezRED">

      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="58%" height="155" valign="top"><table width="537" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="18%" height="27" bgcolor="#F8DDB6" class="normalfnt">Invoice  No</td>
            <td width="1%" bgcolor="#F8DDB6">&nbsp;</td>
            <td width="34%" bgcolor="#F8DDB6"><span class="normalfnt">
              <input name="txtInvNo" type="text" class="txtbox" id="txtInvNo" size="20" style="text-align:center" maxlength="20" />
            </span></td>
            <td width="15%" bgcolor="#F8DDB6"><span class="normalfnt">Date</span></td>
            <td width="32%" bgcolor="#F8DDB6" class="normalfnt"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
          </tr>
          <tr>
            <td height="23" colspan="5" class="normalfnt"><table width="537" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100" height="23">Payee</td>
                <td colspan="3"><select name="cboPayee" class="txtbox" id="cboPayee" style="width:435px" >
                  <?php
					$strSQL="SELECT intPayeeID,strTitle FROM payee WHERE intStatus=1 ORDER BY strTitle";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intPayeeID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
				
				
				
				?>
                </select></td>
                </tr>
              <tr>
                <td height="23">Company</td>
                <td colspan="3"><select name="cbocompany" class="txtbox" id="cbocompany" style="width:435px">
                  <?php
					$strSQL="SELECT intCompanyID,strName FROM companies WHERE intStatus=1 ORDER BY strName";
					$result = $db->RunQuery($strSQL);
				
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
					}
				?>
                </select></td>
                </tr>
              <tr>
                <td height="23">Discription</td>
                <td colspan="3"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" size="70" onfocus="setSelect(this)" /></td>
              </tr>
              <tr>
                <td height="23">Batch No</td>
                <td width="217"><select name="cbobatch" class="txtbox" id="cbobatch" style="width:207px" onchange="getEntryNo()">
                  <?php
					$strSQL="SELECT intBatch,strDescription FROM batch WHERE intBatchType=1 ORDER BY strDescription";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intBatch"] ."\">" . $row["strDescription"] ."</option>" ;
					}
				?>
                </select></td>
                <td width="82">Entry No</td>
                <td width="136"><input name="txtEntryNo" type="text" class="txtbox" id="txtEntryNo" size="20" style="text-align:center" maxlength="20" disabled="disabled"/></td>
              </tr>
              <tr>
                <td height="23">VAT  No</td>
                <td><input name="txtVATNo" type="text" class="txtbox" id="txtVATNo" size="32" /onfocus="setSelect(this)" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="23">Accpac ID </td>
                <td><input name="txtAccpacID" type="text" class="txtbox" id="txtAccpacID" size="32" onfocus="setSelect(this)" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          
          

        </table></td>
        <td width="42%" valign="top">
		  <div id=="divaa" style="height:20px; width:400px;"><span class="normalfnt">
		    <input name="btnshowgl" type="button" class="tablezREDMid" id="btnshowgl" value="Show all GLS" onclick="showGLAccounts();" />
		  </span>		  </div>
		  <div id="divGLAccsList" style="overflow:scroll; height:140px; width:400px;"><table width="380" cellpadding="0" cellspacing="0" class="bcgl1" id="tblGLAccs">
                  <tr>
                    <td width="2" height="18" bgcolor="#498CC2" class="normaltxtmidb2"></td>
                    <td width="80" bgcolor="#498CC2" class="normaltxtmidb2">GL Acc Id</td>
                    <td width="120" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                    <td width="60" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
                  </tr>
                </table></div>		  		  </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<table width="949" border="0">
      <tr>
        <td width="59%" valign="top"><div id="aaa" style="height:180"><table width="537%" height="100" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr>
            <td width="101" height="22" class="normalfnt">Currency</td>
            <td width="217"><select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:157px" onchange="rateShow()">
              <?php
					//$strSQL="SELECT strCurrency,intCurID FROM currencytypes ORDER BY strCurrency";
					$strSQL="SELECT DISTINCT exchangerate.rate as dblRate, currencytypes.strCurrency as strCurrency , 	exchangerate.dateFrom
							FROM
							currencytypes
							Inner Join exchangerate ON currencytypes.intCurID = exchangerate.currencyID
							WHERE
							exchangerate.intStatus =  '1'
							";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["dblRate"] ."\">" . $row["strCurrency"] ."</option>" ;
					}
				?>
                  </select></td>
            <td width="82" class="normalfnt">Rate</td>
            <td width="137"><span class="normalfnt">
              <input name="txtRate" type="text" class="txtbox" id="txtRate" size="20" style="text-align:center" maxlength="20" disabled="disabled"/>
            </span></td>
          </tr>
          <tr>
            <td height="22" class="normalfnt">Amount</td>
            <td colspan="2"><span class="normalfnt">
              <input name="txtAmount" type="text" class="txtbox" id="txtAmount" style="text-align:right" value="0.00" size="24" maxlength="20" onfocus="setSelect(this)"/>
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="22" class="normalfnt">Discount</td>
            <td colspan="2"><span class="normalfnt">
              <input name="txtDiscount" type="text" class="txtbox" id="txtDiscount" style="text-align:right" value="0.00" size="24" maxlength="20" onfocus="setSelect(this)" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="22" class="normalfnt">Tax</td>
            <td><span class="normalfnt">
              <input name="txtTaxAmt" type="text" class="txtbox" id="txtTaxAmt" style="text-align:right" value="0.00" size="24" maxlength="20" disabled="disabled" />
            </span></td>
            <td><span class="normalfnt">Total Amount</span></td>
            <td><span class="normalfnt">
              <input name="txtTotalAmount" type="text" class="txtbox" id="txtTotalAmount" style="text-align:right" value="0.00" size="20"  onfocus="setSelect(this)" disabled="disabled" />
            </span></td>
          </tr>
        </table></div></td>
        <td width="41%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><div id="divTaxType" style="overflow:scroll; height:100px; width:400px;"><table width="380" cellpadding="0" cellspacing="0" class="bcgl1" id="tbltaxdetails">
			<tr>
<!--			  <td width="10" height="23" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
			  <td width="80" bgcolor="#498CC2" class="normaltxtmidb2">Tax</td>
			  <td width="50" bgcolor="#498CC2" class="normaltxtmidb2">Rate</td>
			  <td width="93" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
-->			  
				<td bgcolor="#498CC2" class="normaltxtmidb2" height="18" width="10">*</td>
				<td bgcolor="#498CC2" class="normaltxtmidb2" height="18" width="131">Tax</td>
				<td bgcolor="#498CC2" class="normaltxtmidb2" height="18" width="58" >Tax ID</td>
				<td bgcolor="#498CC2" class="normaltxtmidb2" height="18" width="70">Rate</td>
				<td bgcolor="#498CC2" class="normaltxtmidb2" height="18" width="119">Value</td>
			  </tr>
		  </table></div></td>
            </tr>
        </table></td>
      </tr>
    </table>	</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>        </tr>
      <tr>
		</td>
		  
    </table></td>
  </tr>
  
  
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td width="21%">&nbsp;</td>
        <td width="13%"><img src="../images/new.png" alt="new" width="96" height="24" onclick="setForNewInvData()" /></td>
        <td width="13%"><img src="../images/cal.png" alt="new" width="96" height="24" onclick="calculateAmounts()" /></td>
        <td width="12%"><img src="../images/save.png" alt="Save" width="84" height="24" class="mouseover" onclick="saveNewWithoutPOInvoice()" /></td>
        <td width="11%"><a href="InvoiceFinder.php"><img src="../images/search.png" width="80" height="24" border="0" /></a></td>
        <td width="13%"><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <td width="17%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
