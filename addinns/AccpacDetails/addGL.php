<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
#load De
$accID=$_GET["accId"];
$facId=$_GET["facCode"];
$status=$_GET['status'];
if(!isset($status)) $status=0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payments:GL Account Creation</title>

<link href="../../../../Inetpub/wwwroot/GaPro/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script  language="javascript" type="text/javascript" src="accPackGL.js">

</script>
<script src="../../javascript/script.js"></script>

</head>
<!-- -->
<body onload="loadEditGls(<?php echo "'$accID'";?>,<?php echo "'$facId'";?>,<?php echo $status;?>);">
<form id="frmGlAccCreation" name="frmGlAccCreation">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2" id="td_coHeader"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">GL Account Creation<span class="vol"></span><span id="country_popup_close_button"></span></div>
	</div>
<div class="main_body">
<table width="534" height="195" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="">
  <tr>
    <td colspan="6"><table width="100%" height="139" border="0">
      <tr>
       
        <td height="135">
          <table width="100%" border="0" bordercolor="" class="">
            <tr>
              <td height="94">
              <table width="100%" height="92" border="0" cellpadding="0" cellspacing="0">
                  <tr class="">
                    <td width="100%" height="62"><table width="100%" border="0">
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">Account</td>
                        <td align="left"><select name="cboAcc" id="cboAcc" style="width:152px;" onchange="viewGLdetails();" tabindex="1">
                        <?php
								$SQL_GLA="select intGLAccID,strDescription from glaccounts order by strDescription;";
								$result_GLA = $db->RunQuery($SQL_GLA);
								
								echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
								
								while($row_GLA = mysql_fetch_array($result_GLA))
								{
									echo "<option value='". $row_GLA["intGLAccID"] ."'>" . $row_GLA["strDescription"] ."</option>" ;
								}
						
							?>
                        </select>                        </td>
                      </tr>
                      <tr>
                        <td width="6%">&nbsp;</td>
                        <td width="32%" class="normalfnt">Account Code</td>
                        <td width="62%" align="left"><input name="txtAccID" type="text" class="txtbox" id="txtAccID" style="width:150px;" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2"  /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">Description</td>
                        <td align="left"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" style="width:250px" maxlength="50"  tabindex="3"/></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">Account Type</td>
                        <td align="left"><select name="cboAcType" size="1" class="txtbox" id="cboAcType" style="width:150px"  tabindex="4">
                          <option value="0">-</option>
                          <option value="1">P &amp; L Account</option>
                          <option value="2">Balance Sheet</option>
                                                </select></td>
                      </tr>
					  <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">GL Type </td>
                        <td align="left"><select name="cboGLType" size="1" class="txtbox" id="cboGLType" style="width:150px"  tabindex="5">
                          <option value="0">NONE</option>
                          <option value="1">Tax</option>
                          <option value="2">Freight</option>
						  <option value="3">Insurance</option>
						   <option value="4">Courier</option>
						  <option value="5">Other</option>
                                                </select></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">GL Category</td>
                        <td align="left"><select name="cboCategory" id="cboCategory" style="width:150px;">
                        <option value="Null"></option>
                        <?php 
						$sql_glCat = "select intCategoryId,strCategory from budget_category where intStatus=1 order by strCategory";
						$result_glCat = $db->RunQuery($sql_glCat);
								
																
								while($row_GLCat = mysql_fetch_array($result_glCat))
								{
									echo "<option value='". $row_GLCat["intCategoryId"] ."'>" . $row_GLCat["strCategory"] ."</option>" ;
								}
						?>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">Active</td>
                        <td align="left"><input name="chkActive" type="checkbox" id="chkActive" checked="checked" tabindex="6"/></td>
                      </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
          </table>
        </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
	<img src="../../images/new.png" alt="new"  onclick="getClear()"  tabindex="11" />
    <img src="../../images/save.png" alt="save"  onclick="getCheckedValue(<?php echo $status;?>)"  tabindex="7"/>
    <img src="../../images/delete.png" width="100" height="24" border="0" tabindex="8" onclick="deleteGLAcc();"   />
	 <img src="../../images/report.png" width="100" height="24" border="0" tabindex="9" onclick="Report();" /> 
    <a id="td_coDelete" href=../../main.php><img src="../../images/close.png" alt="close"  border="0"   tabindex="10"/></a>
    </td>
  </tr>
</table>
</div>
</div>
</form>
</body>
</html>
