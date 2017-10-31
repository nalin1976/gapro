<?php
session_start();
$backwardseperator = "../../";
$userId = $_SESSION["UserID"];
include "../lineInput/${backwardseperator}authentication.inc";
include "../../Connector.php";
$facroyId = $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Line In Reports</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Line In Reports<span class="vol"></span><span id="country_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<table class="normalfnt" align="center" width="480" border="0" cellspacing="1">
      <tr>
        <td width="48%"><form id="frmCountries" name="frmCountries" method="post" action="">
          <table width="480" border="0"  cellspacing="0">
            <tr>
              <td height="2" id="td_coHeader"></td>
              <td height="2" id="td_coDelete"></td>
              </tr>
            <tr>
              <td width="67" height="25">Factory</td>
              <td width="409" align="left"><select name="cboPopFactory" id="cboPopFactory" class="txtbox" style="width:400px"  tabindex="1" disabled="disabled">
                <?php
					$SQL = "SELECT DISTINCT c.intCompanyID,c.strName,c.strCity
								FROM companies c
									INNER JOIN productiongptinheader p ON p.intFactoryId=c.intCompanyID
										WHERE c.intManufacturing=1;";
					$result = $db->RunQuery($SQL);
					
					echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
					while($row = mysql_fetch_array($result))
					{
						if($facroyId==$row["intCompanyID"])
							echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
						else
							echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
					}
					?>
                </select></td>
            </tr>
            <tr>
              <td height="25">Order No </td>
              <td align="left"><select name="cboStyleId" id="cboStyleId" class="txtbox" style="width:200px">
                <?php
						$SQL = "select DISTINCT O.intStyleId,concat(O.strOrderNo,' / ',O.strStyle)as styleNo from productionbundleheader PLIH inner join orders O on O.intStyleId = PLIH.intStyleId order by O.strOrderNo";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["styleNo"] . "</option>";
						}
					?>
              </select></td>
            </tr>
            <tr>
              <td  height="25">Line <span class="compulsoryRed"></span></td>
              <td align="left"><select name="cboPopTeam" id="cboPopTeam" class="txtbox" style="width:200px">
                <?php
						$SQL = "SELECT	* FROM plan_teams";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intTeamNo"] ."\">" . $row["strTeam"] . "</option>";
						}
					?>
              </select></td>
            </tr>
            <tr >
              <td  height="25" >Date 
                <input type="checkbox" id="cbxSetDate" name="cbxSetDate"  checked="checked" onchange="date_setter()"/></td>
              <td align="left">From
                <input name="txtDateFrom" tabindex="16" type="text" class="txtbox" id="txtDateFrom" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
To
<input name="txtDateTo" tabindex="16" type="text" class="txtbox" id="txtDateTo" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset4" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            </tr>
            <tr>
              <td height="21" colspan="2" bgcolor=""><table width="102%" border="0" class="">
                <tr>
                  <td align="center"><img src="../../images/print.png" class="mouseover" alt="Save" name="Save"  onclick="printSummary()" id="butSave" tabindex="7"/>
                    <img src="../../images/close.png" class="mouseover" alt="Delete" id="butDelete" name="Delete"  onclick="closePopUpArea(pub_zIndex)" tabindex="8"/></td>
                  </tr>
                </table></td>
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