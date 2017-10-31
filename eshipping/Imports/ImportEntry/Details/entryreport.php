<?php
	session_start();
	include("../../../Connector.php");	
?>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0">
          <tr>
            <td width="94%" height="30" bgcolor="#588DE7" class="TitleN2white">Import Entry Report </td>
            <td width="6%" bgcolor="#588DE7" class="TitleN2white"><img src="../../../images/cross.png" alt="popupclose" width="17" height="17" onClick="closeWindow();"></td>
          </tr>
          <tr bgcolor="#FEFDEB">
            <td height="96" colspan="2">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" class="bcgl1 normalfnt">
                      <tr>
                        <td colspan="3" class="normalfnt"><strong>Clearance Information </strong></td>
                        <td >&nbsp;</td>
                        <td colspan="2" >&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="1%" class="normalfnt">&nbsp;</td>
                        <td class="normalfnt"><label for="radiobutton">
                          <input name="optClearance" type="radio" class="txtbox" id="optClearance" value="radiobutton" checked="checked" />
                        </label></td>
                        <td class="normalfnt">Clearance
                          <label for="label"></label></td>
                        <td width="22%" >&nbsp;</td>
                        <td colspan="2" align="right" ><img src="../../../images/print.png" alt="print" onClick="ViewClearenceData();" ></td>
                        <td width="14%"><img src="../../../images/btn-email.png" alt="Save" name="Save" id="Save" onclick="butCommand(this.name)"/></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td width="4%" class="normalfnt"><input name="optClearance" type="radio" class="txtbox" id="optAllImports" value="radiobutton" /></td>
                        <td width="25%" >All Imports </td>
                        <td colspan="4" ><table width="100%" cellspacing="0" class="normalfnt">
                          <tr>
                            <td width="9%">&nbsp;</td>
                            <td width="12%">&nbsp;</td>
                            
                            <td width="6%">&nbsp;</td>
                            <td width="8%">&nbsp;</td>
                            <td width="26%">&nbsp;</td>
                          </tr>
                        </table></td>
                    </tr>

                      <tr>
                        <td>&nbsp;</td>
                        <td><input name="chkClearence" type="checkbox" class="txtbox" id="chkClearence" value="radiobutton" onClick="SetDates(this,0);" checked="checked" /></td>
                        <td>Date From</td>
                        <td><input name="dtmClearenceFrom" type="text" class="txtbox" id="dtmClearenceFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date("d/m/Y");?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                        <td width="10%">To</td>
                        <td width="24%"><input name="dtmClearenceTo" type="text" class="txtbox" id="dtmClearenceTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date("d/m/Y");?>"/><input name="reset232" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                        <td>&nbsp;</td>
                      </tr>
					
                    </table>
					
                    <table width="100%" class="bcgl1 normalfnt">				
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="4%"><input name="optHeader" type="radio" class="txtbox" id="optHeaderAllEntry" value="radiobutton" checked="checked" /></td>
                        <td width="16%">All Entries </td>
                        <td width="6%">&nbsp;</td>
                        <td width="7%"><input name="optHeader" type="radio" class="txtbox" id="optHeaderEntryPass" /></td>
                        <td width="17%">Entry Passed</td>
                        <td width="10%">&nbsp;</td>
                        <td width="6%"><input name="optHeader" type="radio" class="txtbox" id="optHeaderAwaitingEntry" /></td>
                        <td width="24%">Awaiting Entries</td>
                        <td width="9%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="10">&nbsp;</td>
                      </tr> 
					   <tr>
                        <td>&nbsp;</td>
                        <td><input name="chkEntry" type="checkbox" class="txtbox" id="chkEntry" onClick="SetDates(this,1);" checked="checked"/></td>
                        <td>Date From </td>
                        <td colspan="3"><input name="dtmEntryFrom" type="text" class="txtbox" id="dtmEntryFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date("d/m/Y");?>"/><input name="reset22" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                        <td width="10%">To</td>
                        <td colspan="2"><input name="dtmEntryTo" type="text" class="txtbox" id="dtmEntryTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date("d/m/Y");?>"/><input name="reset23" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                        <td width="9%">&nbsp;</td>
                      </tr>                 
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="4%"><input name="optOther" type="radio" class="txtbox" id="optBuyerPoWise" style="visibility:hidden" /></td>
                        <td width="16%">Buyer Wise </td>
                        <td colspan="7"><select name="cmbBuyer" class="txtbox" style="width:150px" id="cmbBuyer">
<?php
$sqlbuyer="SELECT strBuyerID,strName  FROM buyers";
$result_buyer=$db->RunQuery($sqlbuyer);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_buyer=mysql_fetch_array($result_buyer))
	{
		echo "<option value=\"".$row_buyer["strBuyerID"]."\">".$row_buyer["strName"]."</option>";
	}
?>
                        </select></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><input name="optOther" type="radio" class="txtbox" id="optExporterWise" style="visibility:hidden"/></td>
                        <td>Exporter Wise </td>
                        <td colspan="7"><select name="cmbExporter" class="txtbox" style="width:150px" id="cmbExporter">
<?php
$sqlsupplier="SELECT strSupplierId,strName FROM suppliers";
$result_supplier=$db->RunQuery($sqlsupplier);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_supplier=mysql_fetch_array($result_supplier))
	{
		echo "<option value=\"".$row_supplier["strSupplierId"]."\">".$row_supplier["strName"]."</option>";
	}
?>
                        </select></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><input name="optOther" type="radio" class="txtbox" id="optCustomerWise" style="visibility:hidden"/></td>
                        <td>Customer Wise </td>
                        <td colspan="7"><select name="cboCustomer" class="txtbox" style="width:150px" id="cboCustomer">
<?php
$sqlcostomer="SELECT strCustomerID,strName  FROM customers";
$result_costomer=$db->RunQuery($sqlcostomer);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_costomer=mysql_fetch_array($result_costomer))
	{
		echo "<option value=\"".$row_costomer["strCustomerID"]."\">".$row_costomer["strName"]."</option>";
	} 
?>
                        </select></td>
                      </tr>
                     
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="7">&nbsp;</td>
                      </tr>

                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2"><div align="right"><img src="../../../images/print.png" alt="print" onClick="ViewCusdecListReports();" ></div></td>
                      </tr>
                    </table></td>
                  </tr>
              </table>            </td>
          </tr>
        </table>
