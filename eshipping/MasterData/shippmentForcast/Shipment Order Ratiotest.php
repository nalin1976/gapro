<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Commodity Codes</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="../commoditityCodes/button.js"></script>
<script src="CommodityCode.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php

include "../../Connector.php";

?>

<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="60%"><table width="97%" border="0" cellspacing="0" >
          <tr>
            <td width="65%" height="30" bgcolor="#498CC2" class="TitleN2white"><div align="right">Shipment Order Ratio </div>              <div align="left"></div></td>
            <td width="35%" bgcolor="#498CC2" class="TitleN2white">&nbsp;</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96" colspan="2">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
             
                <tr>
                  <td colspan="2" class="normalfnt"><table width="95%" border="0" bgcolor="#FFFFFF">
                    
                    <tr>
                      <td colspan="4" class="normalfnt"><table width="549" border="0" class="bcgl1">
                       
                        <tr>
                          <td width="134" class="normalfnt">SC Number </td>
                          <td width="208"><select name="cboUnit" class="txtbox"   style="width:200px" id="cboUnit">
                            <?php
	
	$SQL = "SELECT  strUnit ,strTitle
FROM units;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strUnit"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                          </select></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td class="normalfnt">PO NUMBER</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="4" class="normalfnt"><table width="96%" border="0" cellpadding="0" cellspacing="0">

			<tr>
			  <td colspan="2" class="normalfnt"><table><tr><td><div id="divcons" style="overflow:scroll; height:130px; width:550px;">
			  
				  <table width="551" cellpadding="0" cellspacing="1" id="tblCommodityCode">
					<tr>
					<td width="1%" height="25" bgcolor="#498CC2" class="normaltxtmidb2"></td>
					<td width="1%" height="25" bgcolor="#498CC2" class="normaltxtmidb2"></td>	
					  <td width="12%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Position</td>
					  <td width="21%" bgcolor="#498CC2" class="normaltxtmidb2">Tax Code </td>
					  <td width="17%" bgcolor="#498CC2" class="normaltxtmidb2">Rate</td>
					  <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">MP</td>
					  <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Tax Base </td>
					  <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Optional Rates </td>
						  <!--          </tr>
  <td  height="80" class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td colspan="3"    class="normaltxtmidb2"><img src="../../images/loading5.gif" width="100" height="100" border="0"  /></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
  <td    class="normaltxtmidb2"></td>
</tr>-->
                                    </tr>
                                    </table>
                                   
                              </div> </td>
												<td>&nbsp;</td>                                    
                                    </tr></table></td>
                            </tr>
                                              </table></td>
                      </tr>
                  </table></td>
                  </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      
                      <td width="50" rowspan="2">&nbsp;</td>
                      <td width="98" rowspan="2">&nbsp;</td>
                      <td width="87" rowspan="2"><img src="../../images/new.png" width="84" height="24" name="New"onclick="frmReload();" class="mouseover" id="check" alt="new"/></td>
                      <td width="85" rowspan="2"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save"  class="mouseover" onclick="savedata()"lass="mouseover" /></td>
                      <td width="114" rowspan="2"><a href="../../main.php"><img src="../../images/close.png" alt="Close"  class="mouseover" name="Close" width="84" height="24" border="0"lass="mouseover" /></a></td>
                      <td width="43" rowspan="2">&nbsp;</td>
                      <td width="47" align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      
                      <td width="47" align="right">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="21%" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
 
</table>
</form>

<div style="left:90px; top:252px; z-index:10; position:absolute; width: 426px; visibility:hidden; height: 130px;" id="confirmReport">
<table width="430" height="130" border="0" cellpadding="0" cellspacing="0" class="normalfnt" bgcolor="#ffffff">
<tr>
<td colspan="8">
    <tr bgcolor="#ccff33" class="normalfntMid" height="15"><td  colspan="8" ><div align="left">&nbsp;<strong>Edit Taxes</strong></div></td>
      
    </tr>
		<tr height="10"><td colspan="8">&nbsp;</td>		
		<tr class="normalfnt">		
	    <td width="72" align="left">&nbsp;&nbsp;Tax Code </td>
	    <td width="86"><input name="txtTaxCode" type="text" class="txtbox" id="txtTaxCode" style="text-align:right;" size="12" maxlength="15" readonly="readonly" /></td>
	     <td width="54">&nbsp;Rate</td>
	    <td width="85"><input name="txtRate" type="text" class="txtbox" id="txtRate" style="text-align:right;" size="12" maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onclick="DisableRightClickEvent()"/></td>
	
	    <td width="41">&nbsp;Opt</td>
	    <td colspan="3"><input name="txtRateOpt" type="text" class="txtbox" id="txtRateOpt" style="text-align:right;" size="12" maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onclick="DisableRightClickEvent()"/></td>
	</tr>
	<tr  >
	 	
	    <td  align="left">&nbsp;&nbsp;MP </td>
	    <td ><input name="txtMP" type="text" class="txtbox" id="txtMP" style="text-align:right;" size="12" maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
	 <td >&nbsp;Base</td>
	 <!--<td ><input name="txtBase" type="text" class="txtbox" id="txtBase" style="text-align:right;" size="15" maxlength="15"  /></td>-->
	
	 <td colspan="4">
	   
	   <div align="left">
	     <select name="txtBase" class="txtbox"  style="width:90px"  id="txtBase" value="100%" >
	       <option value=""></option>
	       <option value="100%">100%</option>
	       <option value="110%">110%</option>
	       <option value="CID">CID</option>
          </select>
         </div></td><td width="72">&nbsp;</td>
	     <!-- <td colspan="2">Recived From wharf Cleark </td>-->
	  
	    <!--<td width="108"><input name="txtDeliveryNo3" type="text" class="txtbox" id="txtDeliveryNo3" " size="15" maxlength="15" disabled="disabled" />--><td width="1"></td>
	</tr>	
	<tr class="normalfnt">     
	  
	
	 
	 <td align="center" >&nbsp;</td>
	 <td align="right" ><table class="mouseover" onclick="editcommoditydb()">
	   <tr>
	     <td  ><img src="../../images/eok.png" alt="Ok" name="btnOk" width="16" height="16"  id="butCancel" /></td>
	     <td>&nbsp;Ok</td>
	     </tr>
	   </table>	 </td>
	 <td colspan="5"align="right" ><table class="mouseover" onclick ="closePOP()"><tr><td   ><img src="../../images/eclose.png" alt="Cancel" name="butCancel" width="16" height="16"  id="butCancel" /></td><td>&nbsp;Cancel</td></tr></table></td>
     <td align="center" >&nbsp;</td>
	</tr>
<tr><td colspan="8"></td>
<tr><td colspan="8"></tr>
</table>
</div>


<div style="left:90px; top:252px; z-index:10; position:absolute; width: 180px; visibility:hidden; height: 270px;" id="divselecttax">
<table width="170" height="270" border="0" cellpadding="0" cellspacing="0" style=" background-color:#ffffff;">
<tr><td colspan="4" width="2%" height="25" bgcolor="#ccff33" class="normalfntMid">Select Taxes</td></tr>
<tr><td >&nbsp;</td><td  align="left" class="normalfnt"><input type="checkbox" name="CID" value="Vat" id="CID" />&nbsp;CID</td><td  align="left"  class="normalfnt">&nbsp;&nbsp;<input type="checkbox" name="course" value="Vat" id="EIC"/>&nbsp;EIC</td><tr>
<tr><td >&nbsp;</td><td  align="left"  class="normalfnt"><input type="checkbox" name="course" value="Vat" id="GST"/>&nbsp;GST</td><td  align="left"  class="normalfnt">&nbsp;&nbsp;<input type="checkbox" name="course" value="Vat" id="NBT"/>&nbsp;NBT</td><tr>
<tr><td >&nbsp;</td><td  align="left" class="normalfnt"><input type="checkbox" name="course" value="Vat" id="PAL"/>&nbsp;PAL</td><td  align="left"  class="normalfnt">&nbsp;&nbsp;<input type="checkbox" name="course" value="Vat" id="SRL"/>
&nbsp;SRL</td>
<tr>
<tr><td >&nbsp;</td><td  align="left" class="normalfnt"><input type="checkbox" name="course" value="Vat" id="SUR"/>&nbsp;SUR</td><td  align="left"  class="normalfnt">&nbsp;&nbsp;<input type="checkbox" name="course" value="CESS"id="CESS"/>
  &nbsp;CESS</td>
<tr>
<tr><td >&nbsp;</td><td  align="left" class="normalfnt"><input type="checkbox" name="course" value="Vat" id="VAT"/>&nbsp;VAT</td>
  <td  align="left"  class="normalfnt">&nbsp;
    <!--<input type="checkbox" name="COM" value="Vat"id="COM"/>-->
    <input type="checkbox" name="course2" value="XID" id="XID"/> 
    XID </td>
</tr>
<tr class="normalfnt" "  height="30"><td >&nbsp;&nbsp;&nbsp;</td><td><table class="mouseover"  onclick ="setTax()"><tr><td align="left"  ><img src="../../images/eok.png" alt="Cancel" name="butCancel" width="16" height="16"  id="butCancel" /></td><td>&nbsp;OK</td></tr></table ></td><td colspan="2" class="mouseover"><table  onclick ="closeTax()"><tr><td  ><img src="../../images/eclose.png" alt="Cancel" name="butCancel" width="16" height="16" class="mouseover" id="butCancel" /></td><td>&nbsp; Cancel</td></tr></table></td>
</table>
</div>


</body>
</html>
