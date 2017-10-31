<html>
    <head>
    </head>
    
    <body>
    	<table width="100%" border="0" class="tableBorder" cellspacing="0" style="background:#FFF;">
           <tr class="mainHeading">
               	<td height="35"  colspan="5">Lot </td><td width="5%"><img src="../../images/cross.png" onClick="CloseWindow();" /></td>
           </tr>
           <tr style="height:10;">
               	<td height="35"  colspan="6">&nbsp;</td>
           </tr>
           <tr class="normalfnt">
           		<td width="5%"></td>
                <td width="14%">Order No</td>
                <td width="29%"><input type="text" value="" id="txt_scs_orderNo" name="txt_scs_orderNo" style="text-align:left;width:160px;" readonly="readonly"/><input type="hidden" id="txt_scs_hdnOrderNo" name="txt_scs_hdnOrderNo" /></td>
               	<td width="25%">Order Qty</td>
                <td width="22%"><input type="text" value="" id="txt_scs_orderQty" name="txt_scs_orderQty" style="text-align:right;width:160px;" readonly="readonly"/></td>
           </tr>
           <tr class="normalfnt">
           		<td width="5%"></td>
                <td width="14%">Plan Qty</td>
                <td width="29%"><input type="text" value="" id="txt_scs_planQty" name="txt_scs_planQty" style="text-align:right;width:160px;" onKeyPress="return isValidZipCode(this.value,event);" onKeyUp="checkbalance(this);" maxlength="8"/><input type="hidden" id="txtPQty" name="txtPQty"></td>
               	<td width="25%">Order Qty x Ex %</td>
                <td width="22%"><input type="text" value="" id="txt_scs_ex" name="txt_scs_ex" style="text-align:right;width:160px;" readonly="readonly"/><input type="hidden" id="txtBalanceQty" name="txtBalanceQty" value="0"></td>
           </tr>
           <tr class="normalfnt">
           		<td width="5%"></td>
                <td width="14%">Cost Id</td>
                <td width="29%"><select id="cbo_scs_costId" name="cbo_scs_costId" style="width:160px;" onChange="selectMachines(this)">
                </select></td>
               	<td width="25%">Handling Time per PC</td>
                <td width="22%"><input type="text" value="" id="txt_scs_ht" name="txt_scs_ht" style="text-align:right;width:160px;" readonly="readonly"/></td>
           </tr>
           <tr class="normalfnt">
           		<td width="5%"></td>
                <td width="14%">Plan Machine</td>
                <td width="29%" id="machineCategory" title="">
                	<select style="width:160px;" id="txt_scs_planMachine" name="txt_scs_planMachine">
                    	<option value="">Select One</option>
                    </select>
                </td>
               	<td width="25%">Capacity</td>
                <td width="22%"><input type="text" value="" id="txt_scs_macCap" name="txt_scs_macCap" style="text-align:right;width:160px;" readonly="readonly"/></td>
           </tr>
           <tr class="normalfnt">
           		<td width="5%"></td>
                <td width="14%">Date</td>
                <td width="29%">
               	  <input type="text" name="txt_scs_txtDateS" id="txt_scs_txtDateS" readonly="readonly" maxlength="10" style="width:110px;" value=""/>
                </td>
               	<td width="25%">&nbsp;</td>
                <td width="22%"><img src="../../images/add_pic.png" onClick="createNewLotPool(document.getElementById('txt_scs_planMachine'));" /></td>
           </tr>
           <tr class="normalfnt">
           		<td width="5%"></td>
                <td width="14%"><input type="hidden" id="hdnObj"></td>
                <td width="29%">&nbsp;</td>
               	<td width="25%"></td>
                <td width="22%"></td>
           </tr>
           <tr class="normalfnt">
           		<td width="5%"></td>
                <td width="14%">&nbsp;</td>
                <td width="29%">&nbsp;</td>
               	<td width="25%"></td>
                <td width="22%"></td>
           </tr>
         </table>
    </body>
</html>