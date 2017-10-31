<?php
$backwardseperator = "../../";
session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Origin Types</title>

<link href="../../css/erpstyle.css"  rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmorigin" name="frmorigin" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Origin Types<span class="vol">(Ver 0.3)</span><span id="originTypes_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
	
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr id="tdHeader">
    <td><?php #include $backwardseperator."Header.php";?></td>
  </tr>-->
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="62%"><table width="500" border="0" class="tableBorder" align="center">
          <!--<tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Origin Types </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr>-->
          <tr>
            <td height="115">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="17%" rowspan="3" class="normalfnt">&nbsp; </td>
                  <td class="normalfnt" height="24">Search </td>
                  <td align="left" colspan="4"><select name="origin_cboorigin" class="txtbox" id="origin_cboorigin" onchange="getoriginDetails();"style="width:148px" tabindex="1">
				  <?php
			//$SQL="SELECT * FROM itempurchasetype WHERE intStatus != 10 ORDER BY strOriginType ASC";
			$SQL="SELECT * FROM itempurchasetype  ORDER BY strOriginType ASC";
			$result = $db ->RunQuery($SQL);	 
			
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
			while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". cdata($row["intOriginNo"]) ."\">" . cdata($row["strOriginType"]) ."</option>" ;
	}  
	 ?>
     </select></td>
     </tr>
                
                <tr>
                  <td width="21%" height="24" class="normalfnt">Origin <span class="compulsoryRed">*</span></td>
                  <td align="left" colspan="4"><input name="origin_txtorigin" type="text" class="txtbox" id="origin_txtorigin" style="width:147px;" maxlength="20" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2"/></td>
                </tr>
                <tr>
                  <td class="normalfnt" height="24
                  ">Description</td>
                  <td align="left"><input type="text" name="txtDescription" id="txtDescription" style="width:147px;" tabindex="3" maxlength="20"/></td></tr>
				<tr>
                      <td class="normalfnt" height="26">&nbsp;</td>
                      <td align="left" ><span class="normalfnt">
<input name="radiobutton" id="rdolocal" type="radio" value="0" checked="checked" tabindex="4"/>Non Finance</span></td>
                      <td align="left" ><span class="normalfnt">
                        <input name="radiobutton" id="rdoforign" type="radio" value="1" tabindex="5"/>Finance</span></td>
				</tr>
                <tr>
                  <td height="26" class="normalfnt">&nbsp;</td>
                  <td width="21%" height="26" class=""><span class="normalfnt">Active</span></td>
                  <td align="left" width="38%" class="normalfnt"><input type="checkbox" name="chkActive" id="chkActive" checked="checked"  tabindex="6"/></td>
                  <td width="24%" class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td height="18" colspan="6" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
					 <td width="15%"></td>
                      <td width="18%"><img src="../../images/new.png" alt="New" name="New" class="mouseover" onclick="ClearForm();"width="96" height="24" tabindex="10" id="butNew"/></td>
                      <td width="13%"><img src="../../images/save.png" alt="Save" class="mouseover" name="Save" onclick="butCommand(this.name)"width="84" height="24" tabindex="6" id="butSave"/></td>
                      <td width="16%"><img src="../../images/delete.png" class="mouseover" alt="Delete" name="Delete" onclick="ConfirmDelete(this.name)"width="100" height="24" tabindex="7" id="butDelete"/></td>
					  <td width="17%" class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="loadReport();" tabindex="8" id="butReport"/></td>
                      <td id="tdDelete" width="39%"><a id="td_coDelete" href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="butClose" tabindex="10"/></a></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</div>
</form>
</body>
</html>
