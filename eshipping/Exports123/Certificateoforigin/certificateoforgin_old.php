<?php
$backwardseperator = "../../";
session_start();
include("../../Connector.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web -Certificate of Origin</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="certificateoforgin.js"></script>
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
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="10" bgcolor="#588DE7" class="TitleN2white">Certificate Of Origin 
              </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="3%">&nbsp;</td>
                          <td width="20%">&nbsp;</td>
                          <td width="23%">&nbsp;</td>
                          <td width="2%">&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                          <td width="31%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="20%" height="30">Select Invoice </td>
                          <td colspan="4"><select name="cboInvoice"  class="txtbox" id="cboInvoice"style="width:140px" onchange="getData();">				<option value=""></option>
                            <?php $sql="select strInvoiceNo from cdn" ;
							$results=$db->RunQuery($sql);
							while($r=mysql_fetch_array($results)){
							?>
                            <option value="<?php echo $r['strInvoiceNo'];?>"><?php echo $r['strInvoiceNo'];?></option>
							<?php } ?>
                          </select></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Shipper(Company)</td>
                          <td><input name="txtCompany" type="text" class="txtbox" id="txtCompany" size="18" disabled="disabled"; /></td>
                          <td>&nbsp;</td>
                          <td>Port Of Discharge </td>
                          <td><input name="txtPortofDischarge" type="text" class="txtbox" id="txtPortofDischarge" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Consignee</td>
                          <td><input name="txtConsgnee" type="text" class="txtbox" id="txtConsgnee" size="18"  disabled="disabled"/></td>
                          <td>&nbsp;</td>
                          <td>Export Year </td>
                          <td><input name="txtYear" type="text" class="txtbox" id="txtYear" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Vessel</td>
                          <td><input name="txtVessel" type="text" class="txtbox" id="txtVessel" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>Supplimentary Det. </td>
                          <td><input name="txtSupplimentry" type="text" class="txtbox" id="txtSupplimentry" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Final Destination </td>
                          <td><input name="txtDestination" type="text" class="txtbox" id="txtDestination" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>No Of Cartons </td>
                          <td><input name="txtCartoons" type="text" class="txtbox" id="txtCartoons" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Cage 2 </td>
                          <td><input name="txtCage2" type="text" class="txtbox" id="txtCage2" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Marks No Of Pkgs </td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="4" rowspan="4"><label for="label"></label>
                            <textarea name="texMarksnNos" cols="50" rows="4" id="texMarksnNos"></textarea></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
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
                      <td width="19"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="Clearformm();" class="mouseover"/></td>
                      <td width="21"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="savedb()" class="mouseover"/></td>
                      <td width="21"><img src="../../images/print.png" alt="Delete" class="mouseover" name="Delete" width="100" height="24"  id="Delete"onclick="printReport();"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
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
