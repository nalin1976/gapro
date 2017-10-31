<?php
$backwardseperator = "../../";
 session_start();
 $checkTrType="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Payments - Tax Type</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="taxjs.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script type="text/javascript">

</script>
</head>

<body>
<?php
	include "../../Connector.php";
	//$pub_url	= "/gapro";
	 
?>
<form id="frmTaxType" name="frmTaxType">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include '../../Header.php';?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Tax Types<span id="taxTypes_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
  <table width="550" border="0" align="center">
      <tr>
        <td height="260">
          <table width="100%" border="0" class="tableBorder" align="center">
            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="normalfnt">
                  <tr>
                    <td width="59" height="25">&nbsp;</td>
                    <td width="73" class="normalfnt">Tax Type <span class="compulsoryRed">*</span></td>
                    <td align="left" id="taxID" title=""><input name="txtType" type="text" class="txtbox" id="txtType" style="width:150px;" maxlength="30" onkeypress="return checkForTextNumber(this.value, event);"  tabindex="1"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="24">&nbsp;</td>
                    <td class="normalfnt">Tax Rate <span class="compulsoryRed">*</span></td>
                    <td><table width="104" border="0" cellspacing="0" cellpadding="0" align="left">
                        <tr>
                          <td width="85"><input name="txtRate" type="text" class="txtbox" id="txtRate" style="text-align:right" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  size="10" maxlength="6" tabindex="2"/></td>
                          <td width="115"><span class="normalfnBLD1">&nbsp;%</span></td>
                        </tr>
                      </table></td>
                    <td>&nbsp;</td>
                  </tr>
				  <tr>
                    <td height="24">&nbsp;</td>
                    <td class="normalfnt">Tax GL</td>
                    <td><table width="104" border="0" cellspacing="0" cellpadding="0" align="left">
                        <tr>
                          <td width="85">
						  	<select id="cboTaxtGL" name="cboTaxtGL" style="width:150px" tabindex="3">  
						  		<option value="0">Select Tax GL</option>
<?php
	//$sql="select intGLAccID,strAccID,strDescription from glaccounts where intStatus='1' and intGLType='1' and intGLAccID not in (select intGLId from taxtypes) order by strAccID;";
	$sql="select GA.GLAccAllowNo,concat(G.strAccID,'',C.strCode)as glCode from glallowcation GA 
inner join glaccounts G on G.intGLAccID=GA.GLAccNo
inner join costcenters C on C.intCostCenterId=GA.FactoryCode;";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res))
	{
?>
		<option value="<?php echo $row['GLAccAllowNo'];?>">	<?php echo $row['glCode'];?></option>								  
<?php 
	} 
?>
						  	</select>
						  </td>
                          <td width="115"></td>
                        </tr>
                      </table></td>
                    <td><img src="../../images/add.png" class="mouseover" onclick="loadGLAcc();" style="display:none"/></td>
                  </tr>
                  <tr>
                    <td height="24">&nbsp;</td>
                    <td height="24">Active</td>
                    <td width="161" height="24"><input type="checkbox" name="chkActive" id="chkActive" checked="checked" tabindex="4"/></td>
                    <td width="243" height="24">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="24" colspan="4" class="tableBorder"><table  width="10" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td >&nbsp;</td>
                        <td ><img src="../../images/new.png" title="New" alt="New" name="New" id="butNew" onClick="ClearTxForm();" class="mouseover" tabindex="6"/></td>
                        <td ><img src="../../images/save.png" onclick="NewTax();" id="butSave" alt="save" width="84" height="24" tabindex="5" /></td>
                        <td  id="tdDelete"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" tabindex="7" /></a></td>
                        <td >&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="150"><table width="100%" height="141" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" height="141"><table width="100%" border="0" class="bcgl1">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow:scroll; height:130px; width:100%;">
                              <table width="100%" id="tblTaxTypes"  cellpadding="0" cellspacing="1" bgcolor="" >
                                <tr>
								  <td width="39" class="grid_header">No</td>
                                  <td width="39" class="grid_header">Del</td>
                                  <td width="44" class="grid_header">Edit</td>
                                  <td width="249" class="grid_header">Tax Type</td>
                                  <td width="116" height="20" class="grid_header">Rate</td>
								  <td width="116" height="20" class="grid_header">GL ID</td>
                                </tr>
<?php
$SQL = "SELECT T.strTaxTypeID,T.strTaxType,T.dblRate,T.intStatus,T.intGLId,T.intUsed,concat(G.strAccID,'',C.strCode)as glCode
FROM taxtypes T
left join glallowcation GA on GA.GLAccAllowNo=T.intGLId
left Join glaccounts G ON G.intGLAccID = GA.GLAccNo 
left join costcenters C on C.intCostCenterId=GA.FactoryCode 
order by T.strTaxType;";	
$result = $db->RunQuery($SQL);
$i=0;
while($row = mysql_fetch_array($result))
{
$cls="";
($i%2==0)?$cls="grid_raw":$cls="grid_raw2";
$i++;
?>								  
	<tr class="bcgcolor-tblrowWhite">
		<td class="<?php echo $cls;?>" ><div align="center"><?php echo $i ?></div></td>
		<td class="<?php echo $cls;?>" ><div align="center">
		<?php if($row['intUsed'] == "0"){?>
		<img src="../../images/del.png" title="Delete" onclick="removeRow(this,this.id);" alt="Delete"  width="15" height="15" class="mouseover" id="<?php echo $row["strTaxTypeID"];  ?>" />
		<?php }?>
		</div></td>
		<td class="<?php echo $cls;?>"><div align="center"><img src="../../images/edit.png" title="Edit"  alt="Edit"  width="15" height="15" 
		class="mouseover" id="<?php echo $row["strTaxTypeID"];  ?>" 
		onclick="showData(this)" /></div></td>
		<td class="<?php echo $cls;?>" style="text-align:left" id="<?php echo $row["intStatus"]; ?>" ><?php echo $row["strTaxType"];  ?></td>
		<td style="text-align:right" class="<?php echo $cls;?>" ><?php echo $row["dblRate"];  ?></td>
		<td style="text-align:center" id="<?php echo $row["intGLId"]; ?>" class="<?php echo $cls;?>" ><?php echo $row["glCode"];  ?></td>
	</tr>
<?php
}
?>
                              </table>
                          </div></td>
                        </tr>
						
                    </table></td>
                  </tr>
				           <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="">
                  <tr>
                    <td width="100%" height="24"><table width="100%" border="0">
                      <tr>
                        <td width="18%">&nbsp;</td>
                        <td width="23%">&nbsp;</td>
                        <td width="21%"><div align="right"></div></td>
                        <td width="20%">&nbsp;</td>
                        <td id="tdDelete" width="18%"><!--<a href="../../main.php"><img src="../../images/close.png" alt="cLOSE" width="97" height="24" border="0" /></a>--></td>
                        </tr>
                     
                    </table></td>
                    </tr>
              </table></td>
            </tr>
              </table></td>
            </tr>
          </table>       </td>
        </tr>
	  
    </table></td>
</div>
</div>
</form>
</body>
</html>
