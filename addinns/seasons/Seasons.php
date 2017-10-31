<?php
$backwardseperator = "../../";
session_start();
$pub_url = "/gapro/";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Seasons</title>

<script src="Button.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include "../../Connector.php";
?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Seasons<span class="vol">(Ver 0.3)</span><span id="seasons_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<!--  <tr>
    <td id="tdHeader"><?php #include $backwardseperator ."Header.php";?></td>
  </tr>-->
  <tr>
    <td height="139" ><table width="560" border="0" align="center" class="tableBorder">
      <tr>
        <td width="62%"><form id="frmSeason" name="frmSeason" method="post" action="">
        	<table width="100%" border="0"  cellspacing="0">

<!--          <tr>
            <td height="25" colspan="3" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Seasons </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr>-->
          <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
                    <tr>
                      <td width="53" >&nbsp;</td>
                      <td width="157" class="normalfnt">Seasons</td>
                      <td width="302" align="left"><select name="seasons_cboSeasons" onchange="getSeasonsDetails();"class="txtbox" id="seasons_cboSeasons" style="width:150px" tabindex="1">
					  
					  <?php
					  $SQL="SELECT * FROM seasons  order by strSeason";
					
					
						$result = $db->RunQuery($SQL);
						
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;
						}  
					  ?>
                      </select>                      </td>
                </tr>
                 
                    
                    <tr>
                    	<td>&nbsp;</td>
                      <td class="normalfnt" >Season Code <span class="compulsoryRed">*</span></td>
                      <td align="left"><input name="seasons_txtcode" type="text" class="txtbox" id="seasons_txtcode" style="width:148px"  maxlength="10" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2"/></td>
                      </tr>
                    <tr>
                    <td>&nbsp;</td>
                      <td class="normalfnt" >Season <span class="compulsoryRed">*</span></td>
                      <td align="left"><input name="seasons_txtseason" type="text" class="txtbox" id="seasons_txtseason" style="width:300px" maxlength="50" tabindex="3"/></td>
                      </tr>
                    <tr>
                    <td>&nbsp;</td>
                      <td class="normalfnt" >Remarks</td>
                      <td align="left">
					   <textarea style="width:300px" onchange="imposeMaxValue(this,200);" name="seasons_txtremarks"  rows="2" class="txtbox" id="seasons_txtremarks" onkeypress="return imposeMaxLength(this,event, 200);" tabindex="4" ></textarea>					  </td>
                      </tr>
					<tr>
                    	<td>&nbsp;</td>
                      <td class="normalfnt">Active</td>
                      <td align="left"><input type="checkbox" name="seasons_chkActive" id="seasons_chkActive" checked="checked" tabindex="5" /></td>
                    </tr>
					     <tr>
              <td height="3">&nbsp;</td>
              <td height="3">&nbsp;<span id="seasons_txtHint" style="color:#FF0000"></span></td>
            </tr>            
          <tr>
            <td height="21" colspan="3">
              <table width="100%" border="0" class="tableFooter">
                <tr>
                  <td width="10%">&nbsp;</td>
                  <td ><img src="<?php echo $pub_url;?>images/new.png" alt="New" name="New" onclick="ClearForm();" class="mouseover"  id="butNew" tabindex="10" /></td>
                  <td id="tdSave" ><img  src="<?php echo $pub_url;?>images/save.png" class="mouseover" alt="Save" name="Save" onclick="butCommand(this.name)" id="butSave" tabindex="6"/></td>
                  <td><img src="<?php echo $pub_url;?>images/delete.png" class="mouseover" alt="Delete" name="Delete" onclick="ConfirmDelete(this.name);" tabindex="7" id="butDelete"/></td>
                  <td  class="normalfnt"><img src="<?php echo $pub_url;?>images/report.png" alt="Report" border="0" class="mouseover" onclick="loadReport();"   tabindex="8" id="butReport"/></td>
                  <td width="10"  id="tdDelete"><a href="<?php echo $pub_url;?>main.php"><img src="<?php echo $pub_url;?>images/close.png" alt="Close" name="Close"  border="0"  id="butClose" tabindex="9"/></a></td>
                  <td width="10%">&nbsp;</td>
                </tr>
               </table>             </td>
          </tr>
        </table>
        </form>        </td>
        </tr>
    </table></td>
  </tr>
</table>
</div>
</div>
</body>
</html>
