<?php

	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Items :: Mrn List & Report</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--<script type="text/javascript" src="../StyleItemGatePass/Details/gatePassDetails.js"></script>-->
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="auditTrial.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../java.js" type="text/javascript"></script>
</head>
<body>

<form name="frmAuditTrial" id="frmAuditTrial" action="../../AuditTrial/Reports/auditTrialRpt.php" method="POST">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="600" border="0" align="center"  class="tableBorder">

  <tr>
    <td height="26" class="TitleN2white"><table width="100%" border="0">
      <tr>
        <td width="24%" height="35" bgcolor="#498cc2" class="mainHeading"><div align="center">Audit Trial</div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" >
	<tr>
	<td width="5%"></td>
	<td width="15%"></td>
	<td width="30%"></td>
	<td width="5%"></td>
	<td width="15%"></td>
	<td width="15%"></td>
	<td width="15%"></td>
	
	
	</tr>
	
      <tr>
	    <td class="normalfnt"><input  type="checkbox" name="chkAppDate" id="chkAppDate" checked="checked"  onclick="AppDateDisable(this);"/></td>
        <td class="normalfnt"><div align="left"> Date From </div> </td>
        <td class="normalfnt"><input name="AppDateFrom" type="text" class="txtbox" id="AppDateFrom" style="width:110px" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($AppDateFrom=="" ? date ("d/m/Y"):$AppDateFrom) ?>" readonly=""/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/> </td>
        <td class="normalfnt"><div align="right">To</div></td>
        <td class="normalfnt" colspan="3" align="left"><input name="AppDateTo" type="text" class="txtbox" id="AppDateTo"  style="width:110px" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($AppDateTo=="" ? date ("d/m/Y"):$AppDateTo) ?>" readonly="" /><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
      </tr>
	  
	    <tr>
		<td class="normalfnt"><input  type="checkbox" name="chkUser" id="chkUser"  onclick="userDisable(this) ;"/></td>
        <td class="normalfnt"><div align="left">User</div></td>
        <td class="normalfnt"><select name="cboUser" class="txtbox" id="cboUser" style="width:110px" disabled="disabled">
          <?php
		$SQL ="SELECT * FROM useraccounts ORDER BY intUserID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intUserID"]."\">".$row["Name"]."</option>";
			}
	
 	?>
        </select></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>  
	  
	  	<tr>
	    <td class="normalfnt"><input  type="checkbox" name="chkTable" id="chkTable"  onclick="tableDisable(this);"/></td>
        <td class="normalfnt"><div align="left">Table</div></td>
        <td class="normalfnt"><select name="cboTable" class="txtbox" id="cboTable" style="width:110px" disabled="disabled">
          <?php
		$SQL ="SELECT DISTINCT tableName FROM  queries ORDER BY tableName;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["tableName"]."\">".$row["tableName"]."</option>";
			}
	
 	?>
        </select></td>

        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
	  
	  	<tr>
	    <td class="normalfnt"><input  type="checkbox" name="chkProgram" id="chkProgram"  onclick="programDisable(this);"/></td>
        <td class="normalfnt"><div align="left">Program</div></td>
        <td class="normalfnt"><select name="cboProgram" class="txtbox" id="cboProgram" style="width:110px" disabled="disabled">
          <?php
		$SQL ="SELECT DISTINCT progrqmName FROM  auditretailprograms ORDER BY auditPgrmID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["progrqmName"]."\">".$row["progrqmName"]."</option>";
			}
	
 	?>
        </select></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
	  
	  	<tr>
	    <td class="normalfnt"><input  type="checkbox" name="chkOperat" id="chkOperat"  onclick="operationDisable(this);"/></td>
        <td class="normalfnt"><div align="left">Operatorion</div></td>
        <td class="normalfnt"><select name="cboOperation" class="txtbox" id="cboOperation" style="width:110px" disabled="disabled">
		<option></option>
		<option value="1">Insert</option>
		<option value="2">Update</option>
		<option value="3">Delete</option>
        </select></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
	  
	  	<tr>
	    <td class="normalfnt"><input  type="checkbox" name="chkQry" id="chkQry"  onclick="qryDisable(this);"/></td>
        <td class="normalfnt"><div align="left">Query Like</div></td>
        <td class="normalfnt" colspan="5"><input  type="text" name="txtQry" id="txtQry" class="txtbox" style="width:300px" disabled="disabled"/></td>
      </tr>
	  
	  	<tr>
	    <td class="normalfnt"><input  type="checkbox" name="chkIP" id="chkIP" onclick="IPDisable(this);"/></td>
        <td class="normalfnt"><div align="left">IP Address</div></td>
        <td class="normalfnt"><input  type="text" name="txtIP" id="txtIP"  style="width:110px" onclick="CutDateDisable(this);" disabled="disabled"/></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
	  
	  <tr><td colspan="7">
<table width="100%" border="0" class="tableFooter">
           <tr>
		   <td></td>
          <td width="20%" align="right" class="normalfnt"><img border="0" src="../../images/report.png"  alt="search" onclick="SubmitForm();" /></td>
          <td width="20%" align="right" class="normalfnt"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close"  border="0"/></a></td>
		  </tr></table>
		  </td></tr>
       
    </table></td>
  </tr>

</form>
</body>
</html>
