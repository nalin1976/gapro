<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include $backwardseperator."authentication.inc";
	/*$updateFabConpc=true;
	$updatePockConpc = true;
	$updateThreadConpc = false;
	$updateSMV = false;*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Cost Work Sheet Revision</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<!--<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script language="javascript" src="costworksheetrevise.js" type="text/javascript"></script>

<script type="text/javascript">
		$(function(){
			// TABS
			$('#tabs').tabs();
		});
	</script>

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
</table>
<table width="550" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td colspan="4">&nbsp; </td>
  </tr>
  <tr>
    <td colspan="4" class="mainHeading">Cost Work Sheet Revision </td>
  </tr>
  <tr>
    <td colspan="4"><div  id="tabs" style="background-color:#FFFFFF">
				<ul>
					<li><a href="#tabs-1" class="normalfnt">PR# Approval Cancelation</a></li>
					<li><a href="#tabs-2" class="normalfnt">Revised FS#</a></li>
					<li><a href="#tabs-3" class="normalfnt" onClick="loadCancleData();">Permanently Canceled FS#</a></li>
				</ul>
				
				<!-----------------------------------------------SAMPLE MODULE------------------------------------------>
				<div id="tabs-1">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><form name="frmRevision" id="frmRevisioSSn">
    <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center" >
     
      <tr>
        <td class="normalfnt">&nbsp;FS# No</td>
        <td width="58%" class="normalfnt"><input type="text" name="txtFSNo" id="txtFSNo" style="width:200px;" onKeyDown="isEnterKey(event,this.value);" ></td>
        <td width="26%" class="normalfnt"><input type="text" name="txthidden" id="txthidden" style="width:10px;visibility:hidden;"></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;Order No</td>
        <td class="normalfnt"><select name="cboOrderNo" id="cboOrderNo" style="width:200px;" class="txtbox" onChange="loadOrderWiseColor(this.value);" >
        <option value=""></option>
       
        </select>
        </td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;Color</td>
        <td class="normalfnt"><select name="cboColor" id="cboColor" style="width:200px;" class="txtbox" >
        <option value=""></option>
       
        </select></td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;Reason</td>
        <td rowspan="3" class="normalfnt" valign="top"><textarea name="textfield" cols="50" rows="3" id="txtReviseReason" ></textarea></td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td rowspan="4" class="normalfnt" valign="top">
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="10%" align="center" ><input type="radio" name="rdoRevise" id="rdoRevise1" checked="1" ></td>
            <td width="90%" class="normalfnt">&nbsp;Revise (Invoice & Costing)</td>
          </tr>
          <tr>
            <td align="center"><input type="radio" name="rdoRevise" id="rdoRevise2" ></td>
            <td class="normalfnt">&nbsp;Revise (Only Invoice)</td>
          </tr>
          <tr>
            <td align="center"><input type="radio" name="rdoRevise" id="rdoRevise3" ></td>
            <td class="normalfnt">&nbsp;Permanently Cancel (Invoices & Costing)</td>
          </tr>
          <tr>
            <td align="center"><input type="radio" name="rdoRevise" id="rdoRevise4" ></td>
            <td class="normalfnt">&nbsp;Permanently Cancel (Only Invoices)</td>
          </tr>
        </table>
        </td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" >&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">
          <table width="100%" border="0" cellspacing="0" cellpadding="3" class="tableFooter">
  <tr>
    <td align="center"><img src="../../images/new.png" width="96" height="24" onClick="clearPage();"><img src="../../images/save.png" width="84" height="24" id="butSave" onClick="saveData();"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
  </tr>
</table></td>
      </tr>
    </table>
    </form></td>
    </tr>
</table>
 </div> 
<div id="tabs-2" style="padding:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div style="overflow:scroll; height:250px; width:540px;"></div></td>
  </tr>
  
</table>
    </div>  <br>        
    <div id="tabs-3" style="padding:0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div style="overflow:scroll; height:250px; width:540px;">
   <table width="852" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tbldivtab3">
  <tr class="mainHeading4">
    <td width="20" height="22" nowrap="nowrap"></td>
    <td width="180" nowrap="nowrap">Invoice No</td>
    <td width="100" nowrap="nowrap">Order No</td>
    <td width="100" nowrap="nowrap">Colour</td>
    <td width="200" nowrap="nowrap">Cancle Reason</td>
    <td width="70" nowrap="nowrap">Cancle By</td>
    <td width="90" nowrap="nowrap">Cancle Date</td>
  </tr>
</table></div>
    </td>
  </tr> 
</table>
</div>
</div> </td>
</tr>
</table>
</body>
</html>
