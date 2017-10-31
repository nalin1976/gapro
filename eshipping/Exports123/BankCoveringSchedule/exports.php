<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Banks</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="button.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>


<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="7%">&nbsp;</td>
        <td width="89%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Export Covering Shecule </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                            <tr>
                              <td width="3%">&nbsp;</td>
                              <td width="12%">Date</td>
                              <td width="34%"><input name="txtPhone54521422" type="text" class="txtbox" id="txtPhone54521422" size="18" /></td>
                              <td width="18%">&nbsp;</td>
                              <td width="16%">Our Ref/Inv No </td>
                              <td width="17%"><input name="txtPhone54521423" type="text" class="txtbox" id="txtPhone54521423" size="18" /></td>
                            </tr>
                          </table></td>
                          </tr>
                        <tr>
                          <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                              <tr>
                                <td colspan="6" class="normalfnt2">We attach bill(s) and documents as specified below which we request you do </td>
                                </tr>
                              <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="12%">Collect</td>
                                <td width="15%"><input name="checkbox" type="checkbox" class="txtbox" id="checkbox" value="checkbox" />
                                  <label for="checkbox"></label>
                                  <label for="radiobutton"></label></td>
                                <td width="12%">Negociate</td>
                                <td width="41%"><input name="checkbox2" type="checkbox" class="txtbox" id="checkbox2" value="checkbox" /></td>
                                <td width="17%">&nbsp;</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">

                            <tr>
                              <td width="3%">&nbsp;</td>
                              <td width="27%">Document Pending Approval </td>
                              <td width="16%"><input name="checkbox3" type="checkbox" class="txtbox" id="checkbox3" value="checkbox" />
                                  <label for="checkbox3"></label>
                                  <label for="radiobutton"></label></td>
                              <td width="24%">If approval is declined </td>
                              <td width="4%"><input name="checkbox22" type="checkbox" class="txtbox" id="checkbox22" value="checkbox" /></td>
                              <td width="26%">Send On collection basis </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td><input name="checkbox22" type="checkbox" class="txtbox" id="checkbox22" value="checkbox" /></td>
                              <td>Return the document </td>
                            </tr>
                          </table></td>
                          </tr>
                        <tr>
                          <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                              <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="12%">Amount</td>
                                <td width="22%"><input name="txtPhone54521422" type="text" class="txtbox" id="txtPhone54521422" size="18" /></td>
                                <td width="12%">Tenor</td>
                                <td width="6%"><input name="checkbox32" type="checkbox" class="txtbox" id="checkbox32" value="checkbox" /></td>
                                <td width="25%">Sight</td>
                                <td width="3%"><input name="checkbox322" type="checkbox" class="txtbox" id="checkbox322" value="checkbox" /></td>
                                <td width="17%"><input name="txtPhone545214222" type="text" class="txtbox" id="txtPhone545214222" size="18" /></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                              <tr>
                                <td width="3%">&nbsp;</td>
                                <td colspan="4">For the net proceeds please credit ourt account no </td>
                                <td colspan="2">&nbsp;</td>
                                <td width="2%">&nbsp;</td>
                                <td width="15%"><input name="txtPhone5452142222" type="text" class="txtbox" id="txtPhone5452142222" size="18" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="14%">From Proceeds </td>
                                <td width="4%"><input name="checkbox33" type="checkbox" class="txtbox" id="checkbox33" value="checkbox" /></td>
                                <td width="13%">Recover</td>
                                <td width="15%"><input name="txtPhone545214222222" type="text" class="txtbox" id="txtPhone545214222222" size="18" /></td>
                                <td colspan="2">Under the pre shipment Loan no </td>
                                <td>&nbsp;</td>
                                <td><input name="txtPhone54521422224" type="text" class="txtbox" id="txtPhone54521422224" size="18" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><input name="checkbox34" type="checkbox" class="txtbox" id="checkbox34" value="checkbox" /></td>
                                <td>Transfer</td>
                                <td><input name="txtPhone545214222223" type="text" class="txtbox" id="txtPhone545214222223" size="18" /></td>
                                <td width="11%">to Account No </td>
                                <td width="23%"><input name="txtPhone54521422222" type="text" class="txtbox" id="txtPhone54521422222" size="18" /></td>
                                <td>Of</td>
                                <td><input name="txtPhone54521422225" type="text" class="txtbox" id="txtPhone54521422225" size="18" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><input name="checkbox35" type="checkbox" class="txtbox" id="checkbox35" value="checkbox" /></td>
                                <td colspan="2">Pay Agencycomission of </td>
                                <td>&nbsp;</td>
                                <td><input name="txtPhone54521422223" type="text" class="txtbox" id="txtPhone54521422223" size="18" /></td>
                                <td>&nbsp;</td>
                                <td><input name="txtPhone54521422226" type="text" class="txtbox" id="txtPhone54521422226" size="18" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>To</td>
                                <td colspan="6"><input name="txtPhone54521422227" type="text" class="txtbox" id="txtPhone54521422227" size="90" /></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                              <tr>
                                <td rowspan="3"><table width="384" height="45" cellpadding="1" cellspacing="1" class="bcgl1" id="tblMainGrn">
                                  <tr>
                                    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
                                    <td width="28%" height="16" bgcolor="#498CC2" class="normaltxtmidb2">Document No </td>
                                    <td width="42%" bgcolor="#498CC2" class="normaltxtmidb2">No Of Original </td>
                                    <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">No Of Copies </td>
                                  </tr>
                                  <tr>
                                    <td    class="normalfnt">&nbsp;</td>
                                    <td    class="normalfnt">1</td>
                                    <td    class="normalfnt"> Description </td>
                                    <td    class="normalfnt">Unit</td>
                                  </tr>
                                </table></td>
                                <td width="39%"><label for="Submit"></label>
                                  <input type="submit" name="Submit" value="For documentary Credit only                         " id="Submit" /></td>
                                </tr>
                              <tr>
                                <td><input type="submit" name="Submit2" value="For documentary collection(DP/DA) Only" id="Submit2" /></td>
                                </tr>
                              <tr>
                                <td><input type="submit" name="Submit22" value="For open account transaction only              " id="Submit22" /></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="5%">&nbsp;</td>
                              <td width="23%">Drawee (Full Name ) </td>
                              <td width="24%">&nbsp;</td>
                              <td colspan="4"><input name="txtPhone5452142222222" type="text" class="txtbox" id="txtPhone5452142222222" size="55" /></td>
                              </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>Drawee address </td>
                              <td>&nbsp;</td>
                              <td colspan="4"><input name="txtPhone54521422222222" type="text" class="txtbox" id="txtPhone54521422222222" size="55" /></td>
                              </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>Drawee Bank(Full Name) </td>
                              <td>&nbsp;</td>
                              <td colspan="4"><input name="txtPhone54521422222223" type="text" class="txtbox" id="txtPhone54521422222223" size="55" /></td>
                              </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>Drawee Bank Address </td>
                              <td>&nbsp;</td>
                              <td colspan="4"><input name="txtPhone54521422222224" type="text" class="txtbox" id="txtPhone54521422222224" size="55" /></td>
                              </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>Deliver Document against </td>
                              <td>&nbsp;</td>
                              <td width="5%"><input name="checkbox352" type="checkbox" class="txtbox" id="checkbox352" value="checkbox" /></td>
                              <td width="14%">Payment</td>
                              <td width="14%">&nbsp;</td>
                              <td width="15%"><input name="checkbox3522" type="checkbox" class="txtbox" id="checkbox3522" value="checkbox" />
                                Acceotance</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>Protect Instruction </td>
                              <td>&nbsp;</td>
                              <td><input name="checkbox353" type="checkbox" class="txtbox" id="checkbox353" value="checkbox" /></td>
                              <td>Dont' Protest </td>
                              <td>&nbsp;</td>
                              <td><input name="checkbox3523" type="checkbox" class="txtbox" id="checkbox3523" value="checkbox" /> 
                                Protect for non persons </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td colspan="5">Payment acceptance may be deffred unit the arraival oth the carring vessal </td>
                              <td><input name="checkbox3524" type="checkbox" class="txtbox" id="checkbox3524" value="checkbox" /></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>Collection charges </td>
                              <td>--collection ban charges </td>
                              <td><input name="checkbox3525" type="checkbox" class="txtbox" id="checkbox3525" value="checkbox" /></td>
                              <td>our account </td>
                              <td>&nbsp;</td>
                              <td><input name="checkbox3526" type="checkbox" class="txtbox" id="checkbox3526" value="checkbox" />
                                account drawees </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>--collect interest from Drawee </td>
                              <td>&nbsp;</td>
                              <td><input name="txtPhone5452142222223" type="text" class="txtbox" id="txtPhone5452142222223" size="18" /></td>
                              <td> % pa from </td>
                              <td><input name="txtPhone5452142222224" type="text" class="txtbox" id="txtPhone5452142222224" size="18" />
                                until date of payment </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>--charges/Interest if refued</td>
                              <td><input name="checkbox35252" type="checkbox" class="txtbox" id="checkbox35252" value="checkbox" /></td>
                              <td>Waive</td>
                              <td>&nbsp;</td>
                              <td><input name="checkbox35253" type="checkbox" class="txtbox" id="checkbox35253" value="checkbox" />
                                Dont Waive </td>
                            </tr>
                          </table></td>
                          </tr>
                        <tr>
                          <td width="4%">&nbsp;</td>
                          <td width="21%">VSL OPR Code </td>
                          <td width="24%"><input name="txtPhone5452143" type="text" class="txtbox" id="txtPhone5452143" size="18" /></td>
                          <td width="3%">&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                          <td width="27%">&nbsp;</td>
                        </tr>
                      </table></td>
                      </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="21%">&nbsp;</td>
                      <td width="19"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                      <td width="21"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="butCommand(this.name)"/></td>
                      <td width="21"><img src="../../images/delete.png" alt="Delete" width="100" height="24" name="Delete"onclick="ConfirmDelete(this.name);"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="4%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  
  
  
  
</table>

</form>
</body>
</html>
