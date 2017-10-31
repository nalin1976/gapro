<?php
include('../../Connector.php');
$po=$_GET['req'];
$sql="select strOrderNo from orders where intStyleId='$po';";
$res=$db->RunQuery($sql);
$row=mysql_fetch_assoc($res);

?>

<html>
    <head>
    </head>
    
    <body>
    	<table width="100%" border="0" class="tableBorder" cellspacing="0" style="background:#FFF;">
           <tr class="mainHeading">
               	<td height="35"  colspan="5">Lot </td><td width="3%"><img src="../../images/cross.png" onClick="CloseWindow();" /></td>
           </tr>
           <tr class="normalfnt">
           		<td colspan="5"></td>
           </tr>
           <tr class="normalfnt">
           		<td width="6%"></td>
                <td width="19%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
               	<td width="22%">Date</td>
                <td width="25%"><input type="text" name="txt_scs_txtDate" id="txt_scs_txtDate" readonly="readonly" maxlength="10" style="width:80px;" value=""/><input type="hidden" id="txtHT" name="txtHT"></td>
           </tr>
           <tr class="normalfnt">
           		<td width="6%"></td>
                <td width="19%">Cost ID</td>
                <td width="25%"><input type="text" name="txt_scs_costNo" id="txt_scs_costNo" readonly="readonly" maxlength="10" style="width:100px;" value=""/><input type="hidden" id="txtNoteCard" /></td>
               	<td width="22%">Order No</td>
                <td width="25%"><input type="text" name="txt_scs_orderNo2" id="txt_scs_orderNo2" readonly="readonly" maxlength="10" style="width:150px;" value="<?php echo $row['strOrderNo'];?>"/>
                <input type="hidden" id="txtPQNo" name="txtPQNo"></td>
           </tr>
           <tr class="normalfnt">
           		<td colspan="5"></td>
           </tr>
           <tr class="normalfnt">
           		<td width="6%"></td>
                <td width="19%">Lot Qty</td>
                <td width="25%"><input type="text" value="" id="txt_scs_lotQty" name="txt_scs_lotQty" style="text-align:right;width:100px;" onKeyPress="return isValidZipCode(this.value,event);" maxlength="8" />
                <input type="hidden" id="txtLotNo"></td>
               	<td width="22%">Split Qty</td>
                <td width="25%"><input type="text" value="" id="txt_scs_splitQty" name="txt_scs_splitQty" style="text-align:right;width:80px;" onKeyPress="return isValidZipCode(this.value,event);" /><input type="hidden" id="txtTarget" /></td>
           </tr>
           <tr class="normalfnt">
           		<td width="6%"></td>
                <td width="19%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
               	<td width="22%"></td>
                <td width="25%"><img src="../../images/add_pic.png" onClick="separateStip();"/></td>
           </tr>
           <tr class="normalfnt">
           		<td width="6%"></td>
                <td width="19%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
               	<td width="22%"></td>
                <td width="25%"></td>
           </tr>
         </table>
    </body>
</html>