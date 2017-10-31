<?php
 session_start();
 include "../../Connector.php";
 $intCompanyId		=$_SESSION["FactoryID"];
 //echo $intCompanyId;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Production Teams</title>

<link href="../css/planning.css" rel="stylesheet" type="text/css" />
</script>
<script src="../teams/teams-js.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>
<script src="../teams/teams-js.js" type="text/javascript"></script>

</head>

<body>
<form id="frmTeam" method="get" action="../teams/teams.php">
<?php 
	$intTeamId 			= $_GET['cboTeam'];
	
	$sql="select * from plan_teams where intTeamNo =$intTeamId ";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
					
		$strTeamName 		= $row['strTeam'];
		$intMachines 		= $row['intMachines'];
		$intEfficiency 		= $row['intEfficency'];
		$intOperators 		= $row['intOperators'];
		$intWorkingHours 	= $row['dblWorkingHours'];
		$intSubTeamOf		= $row['intSubTeamOf'];
		$intHelpers			= $row['intHelper'];
		$fromTime 			= $row['dblStartTime'];
		$toTime 			= $row['dblEndTime'];
		$mealHrs			= $row['dblMealHours'];
	
	}
?>
<table width="400" height="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross" onmousedown="grab(document.getElementById('frmTeamWindow'),event);">
    <td height="25" bgcolor="#498CC2" class="mainHeading">Production Teams </td>
  </tr>
  <tr>
    <td><table width="300" border="0">
      <tr>
        <td width="300">
          <table width="300" border="0">

            <tr>
              <td height="17"><table width="200" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td height="23" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25%">&nbsp;</td>
                      <td width="11%" class="normalfnt">Team</td>
                      <td width="36%"><select onchange="pageSubmit2(this);" name="cboTeam" class="txtbox" id="cboTeam"  style="width:200px">
                        <?php
							
							$SQL="select intTeamNo,strTeam from plan_teams where intCompanyId = '$intCompanyId';";
							
							$result = $db->RunQuery($SQL);
							echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
							while($row = mysql_fetch_array($result))
							{
								if($_GET['cboTeam']==$row['intTeamNo'])
									echo "<option selected=\"selected\" value=\"". $row["intTeamNo"] ."\">" . $row["strTeam"] ."</option>" ;
								else
									echo "<option value=\"". $row["intTeamNo"] ."\">" . $row["strTeam"] ."</option>" ;
							}
					?>
                      </select></td>
                      <td width="28%">&nbsp;</td>
                    </tr>
                  </table>                    </td>
                  </tr>
                <tr>
                  <td width="1%" height="12">&nbsp;</td>
                  <td colspan="4" class="normalfnt">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td width="18%" class="normalfnt">Team Name </td>
                  <td width="28%" align="left" ><input name="txtTeamName" value="<?php echo $strTeamName; ?>"  class="txtbox"  type="text" id="txtTeamName" /></td>
                  <td class="normalfnt" > Sub Team Of </td>
                  <td class="normalfnt" ><select name="cboSubTeam" class="txtbox" id="cboSubTeam" style="width:125px" onchange="checkValidMainTeam(this);">
                        <option value="0" >No</option>
                        <?php
							$SQL="select intTeamNo,strTeam,intSubTeamOf from plan_teams where intCompanyId = '$intCompanyId' and intSubTeamOf=0;";
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								$intTeamNo = $row["intTeamNo"];
								$strTeam = $row["strTeam"];
								if($intTeamNo == $intSubTeamOf)
									echo "<option selected=\"selected\" value=\"$intTeamNo\">$strTeam</option>";
								else
									echo "<option value=\"$intTeamNo\">$strTeam</option>";
							}
					?>
					
                  </select></td>
                </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td class="normalfnt">No Of Machines</td>
                  <td align="left" ><input name="txtNoOfMachines"  type="text" class="txtbox" id="txtNoOfMachines" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value,0,event);" value="<?php echo $intMachines; ?>" size="10" maxlength="4" /></td>
                  <td class="normalfnt" >Helpers                    </td>
                  <td class="normalfnt" ><input  name="txtHelpers"  type="text" class="txtbox" id="txtHelpers" style="text-align:right"  onkeypress="return CheckforValidDecimal(this.value,0,event);" value="<?php echo $intHelpers; ?>" size="5" maxlength="3"  /></td>
                </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td class="normalfnt">Team Efficiency </td>
                  <td align="left" ><input name="txtTeamEfficiency"  type="text" class="txtbox" id="txtTeamEfficiency" style="text-align:right"  onkeypress="return CheckforValidDecimal(this.value,2,event);"  value="<?php echo $intEfficiency; ?>" size="10" maxlength="3"  /></td>
                  <td colspan="2" class="normalfnt" ><table width="235" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="113">from</td>
                      <td width="45"><input name="txtFromTime"  type="text" class="txtbox" id="txtFromTime" style="text-align:right"   onkeypress="return CheckforValidDecimal(this.value,2,event);" onkeyup="calculateWorkingHours()" value="<?php echo $fromTime; ?>" size="5" maxlength="5"  /></td>
                      <td width="35">To</td>
                      <td width="42"><input name="txtToTime"  type="text" class="txtbox" id="txtToTime" style="text-align:right"  onkeypress="return CheckforValidDecimal(this.value,2,event);" onkeyup="calculateWorkingHours()" value="<?php echo $toTime; ?>" size="5" maxlength="5"  /></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td class="normalfnt">Operators</td>
                  <td align="left" ><input name="txtOperators"  type="text" class="txtbox" id="txtOperators" style="text-align:right"  onkeypress="return CheckforValidDecimal(this.value,0,event);"  value="<?php echo $intOperators; ?>" size="10" maxlength="4"  /></td>
                 <td class="normalfnt" >Meal Hours                    </td>
                  <td class="normalfnt" ><input  name="txtMealHrs"  type="text" class="txtbox" id="txtMealHrs" style="text-align:right"  onkeypress="return CheckforValidDecimal(this.value,2,event);" value="<?php echo $mealHrs; ?>" size="5" maxlength="4"   onkeyup="calculateWorkingHours()"  /></td>
                  </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td class="normalfnt">Working Hours </td>
                  <td align="left" ><input  name="txtWorkingHours" type="text" class="txtbox" id="txtWorkingHours" style="text-align:right;background-color:#C7D9F3" onkeypress="return CheckforValidDecimal(this.value,2,event);" value="<?php echo $intWorkingHours; ?>" size="10" maxlength="2" readonly="true"/></td>
                  <td colspan="2" class="normalfnt" >&nbsp;</td>
                </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td >&nbsp;</td>
                  <td colspan="2" class="normalfnt" >&nbsp;</td>
                </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td colspan="2" class="normalfnt"><span class="normalfnth2">Activated Time Periods </span></td>
                  <td width="20%" class="normalfnt" >&nbsp;</td>
                  <td width="33%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="12">&nbsp;</td>
                  <td colspan="4" class="normalfnth2"><table width="503" border="0" cellpadding="0" cellspacing="0" class="tablezREDMid" style="tab">
                    <tr>
                      <td width="75" class="normalfnt">Valid From </td>
                      <td width="132" class="normalfnt"><input name="txtValidFrom" type="text"  class="txtbox" id="txtValidFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                      <td width="53" class="normalfnt">Valid To </td>
                      <td width="163" class="normalfnt"><input name="txtValidTo" type="text"  class="txtbox" id="txtValidTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                      <td width="78" class="normalfnt"><img onclick="addrowtovalidgrid();" src="../../images/add_alone.png" name="butAdd" id="butAdd" /></td>
                      </tr>
                  </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="120"><table width="85%" height="128" border="0" cellpadding="0" cellspacing="0">
                <tr class="bcgl1">
                  <td width="100%"><table width="50%" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3"><div id="divcons" style="overflow:auto; height:90px; width:510px;">
                        <div align="center">
                          <table width="435" height="20" cellpadding="0" cellspacing="0" class="normalfnt" id="tblTeamsValidateGrid">
                            <tr>
                              <td width="76" bgcolor="#498CC2" class="grid_raw"><b>Del</b></td>
                              <td width="123" bgcolor="#498CC2" class="grid_raw" style="text-align:center"><b>Valid From</b></td>  
                              <td width="133" bgcolor="#498CC2" class="grid_raw" style="text-align:center"><b>Valid To</b></td>
                              <td width="93" bgcolor="#498CC2" class="grid_raw">&nbsp;</td>
                            </tr>
					<?php
							$sql="	SELECT *
									FROM plan_teamsvaliddates
									WHERE
									plan_teamsvaliddates.intCompanyId =  '$intCompanyId' AND
									plan_teamsvaliddates.intTeamId =  '$intTeamId'";
							$result = $db->RunQuery($sql);
							//echo $sql;
							while($row = mysql_fetch_array($result))
							{
								$dtmValidFrom 	= substr($row["dtmValidFrom"],0,10);
								$dtmValidTo 	= substr($row["dtmValidTo"],0,10);
					?>
							
                           <tr>
                              <td align="center" valign="middle" class="normalfntMid"><img src="../../images/del.png" name="butDel" id="butDel" onclick="deleteValidRow(this);" /></td>
                              <td class="normalfntMid"><?php echo $dtmValidFrom ?></td>
							  <td class="normalfntMid"><?php echo $dtmValidTo ?></td>
							  <td class="normalfntMid">&nbsp;</td>
                            </tr>
							
					<?php
						}
					?>
                          </table>
                        </div>
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td bgcolor="#FFFFFF"><table width="100%" border="0">
                    <tr>
                      <td width="15%" class="normalfntp2">&nbsp;</td>
                      <td width="19%" class="normalfntp2"><img src="../../images/new.png" alt="report" name="butNew" width="96" height="24" border="0" class="mouseover" id="butNew" onclick="refreshWindow()" /></td>
                      <td width="17%" class="normalfntp2"><img src="../../images/save.png" alt="report" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="validateTeam()" /></td>
                      <td width="20%" class="normalfntp2"><img src="../../images/delete.png" alt="report" name="butDelete" width="100" height="24" class="mouseover" id="butDelete" onclick="deleteTeams()" /></td>
                      <td width="28%" class="normalfntp2"><img src="../../images/close.png" alt="close" name="butClose" width="97" height="24" border="0" class="mouseover" id="butClose" onclick="closeWindow();" /></td>
                      <td width="1%">&nbsp;</td>
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
    
  </tr>
</table>
</form>
</body>
</html>
