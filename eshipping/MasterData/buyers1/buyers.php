<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Buyers</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->


</style>
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
 <script src="buyers.js"></script>
 <script src="../../javascript/script.js"></script>


</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmBuyers" name="frmBuyers" method="post" action="">
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
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Buyers</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                
                <tr>
                  <td width="128%" colspan="3" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Buyer</td>
                      <td colspan="3"><select name="cboCustomer" class="txtbox"  onchange="getCustomerDetails();" style="width:320px" id="cboCustomer">
                        <?php
	
	$SQL = "SELECT strBuyerID,strBuyerCode, strName FROM buyers where intDel=0 ORDER BY strBuyerCode  ;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strBuyerID"] ."\">" . $row["strBuyerCode"] ."--->". $row["strName"] ."</option>" ;
	}
	
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Buyer Code <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtBuyerID" type="text" autocompletetype="Disabled" autocomplete="off" class="txtbox" id="txtBuyerID"  size="30" maxlength="50"></td>
                    </tr>
                    <tr>
                      <td width="2%" class="normalfnt">&nbsp;</td>
                      <td width="22%" class="normalfnt">Name <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtName" type="text" AutoCompleteType="Disabled" autocomplete="off" class="txtbox" id="txtName"  size="50" maxlength="100"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address</td>
                      <td colspan="3"><input name="txtAddress1" type="text" class="txtbox" id="txtAddress1"  size="50" maxlength="100" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="txtAddress2" type="text" class="txtbox" id="txtAddress2"  size="50" maxlength="100" /></td>
                    </tr>
                    
                    
                    <tr style="display:none">
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="txtAddress3" type="text" class="txtbox" id="txtAddress3"  size="50" maxlength="100" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country</td>
                      <td colspan="3"><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="50" maxlength="100" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Phone</td>
                      <td width="25%"><input name="txtPhone" type="text" class="txtbox" id="txtPhone" size="16"  maxlength="40" /></td>
                      <td width="8%" >Fax</td>
                      <td width="43%" ><input name="txtFax" type="text" class="txtbox" id="txtFax" size="16" maxlength="40" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">e-Mail</td>
                      <td colspan="3"><input name="txtEmail" type="text" class="txtbox" id="txtEmail" size="50" maxlength="100"/></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="50"  maxlength="100" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">TIN</td>
                      <td colspan="3"><input name="txtTIN" type="text" class="txtbox" id="txtTIN" size="50"  maxlength="100"/></td>
                    </tr>
					
					<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Contact Person</td>
                      <td colspan="3"><input name="txtCP" type="text" class="txtbox" id="txtCP" size="50"  maxlength="100"/></td>
                    </tr>
                    
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Buyer Regions</td>
                      <td colspan="3"><select name="cboRegion" class="txtbox" style="width:320px" id="cboRegion">
                        <?php
	
						$SQL = "SELECT buyerregion.strBuyerRegion, intBuyerRegionId FROM buyerregion";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"".""."\">" ."Select One"."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							$intBuyerRegionId = $row["intBuyerRegionId"];
							$strBuyerRegion = $row["strBuyerRegion"];
						?>
							<option value="<?php echo $intBuyerRegionId; ?>"><?php echo $strBuyerRegion; ?></option>
						<?php	
						}
						
					
						
						?>
                      </select></td>
                    </tr>
					
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
							<td width="10%">&nbsp;</td>                    
                    <!--
                      <td width="16%"><img src="../../images/buying-office.png" class='mouseover' alt="buying office" width="121" height="24" name="buying office" onClick="butCommand(this.name)" /></td>
                      <td width="16%"><img src="../../images/division.png" class='mouseover' alt="division" width="105" height="24" name="division" onClick="butCommand(this.name)"/></td>-->
					  <td align="center" width="20%"><img src="../../images/new.png" alt="New" name="New" class='mouseover' onClick="ClearForm();"/></td>
                      <td align="center"  width="20%"><img src="../../images/save.png" class='mouseover' alt="Save" name="Save" width="84" height="24" onClick="saveData();"/></td>
                      <td align="center"  width="20%"><img src="../../images/delete.png" class='mouseover' alt="Delete" name="Delete" width="100" height="24" onClick="deleteData();"/></td>
                      <td align="center"  width="20%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="10%">&nbsp;</td>
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
