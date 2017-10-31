<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator = "../../";
	$companyId  =$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Gatepass</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--

-->
</style>

<script type="text/javascript" src="gengatepass.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--<link href="../GeneralIssue/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../GeneralIssue/javascript/calendar/theme.css" />-->

<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["FactoryID"]; 
 ?>;
 //alert(factoryID);
var UserID = <?php
 session_start();
 echo $_SESSION["UserID"]; 
 ?>;
var EscPercentage = 0.25;
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>));
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>));
</script>

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../GeneralIssue/java.js" type="text/javascript"></script>

</head>

<body onload="loadGenGPData(
<?php  $id=$_GET["id"];
if($id == '1')
	echo $_GET["GenGPNo"].','.$_GET["intYear"].','.$_GET["intStatus"];
else
	echo '0,0,0';	
 ?>

)">

<form name="frmIssues" id="frmIssues">
<table width="100%"><tr><td><?php include '../../Header.php'; ?></td></tr>
<tr><td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  
   <tr>
    <td height="26"  class="mainHeading">General Gatepass</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td width="100%"><table  width="100%" border="0" cellpadding="2" cellspacing="0" >
          <tr>
            <td class="normalfnt" height="24">Gatepass No</td>
            <td class="normalfnt"><input name="txtreturnNo" type="text" class="txtbox" id="txtreturnNo" size="15" readonly="readonly"  onclick="showFindGenGPpopup();"/></td>
            <td class="normalfnt">Attention</td>
            <td class="normalfnt"><input name="txtattention" type="text" class="txtbox" id="txtattention" size="30" maxlength="60" /></td>
            <td class="normalfnt">Destination</td>
            <td class="normalfnt"><select name="cboreturnedby" class="txtbox" id="cboreturnedby" style="width:180px">
              <?php 	

	echo "<option value =\"".""."\">"."Select One"."</option>";
	$SQL="select intCompanyID,strName from companies where intStatus=1 and intCompanyID<>'$companyId' ";
	
	$result =$db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
	}
?>
            </select></td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
      
            <td width="9%" class="normalfnt">&nbsp;</td>
            <td width="19%" class="normalfnt">&nbsp;</td>
            <td width="7%" class="normalfnt">Through</td>
            <td width="22%" class="normalfnt">
              <input name="txtthrough" type="text" class="txtbox" id="txtthrough" size="30" maxlength="60" /></td>
            <td width="11%" class="normalfnt">Instructed By </td>
            <td width="22%" class="normalfnt">
              <select name="cboinstruct" class="txtbox" id="cboinstruct" style="width:180px">
                <?php 	
	$SQL="select intUserID,Name from useraccounts where intCompanyID = '". $_SESSION["FactoryID"] ."' and intUserID = '". $_SESSION["UserID"] ."'";
	$result =$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intUserID"]."\">".$row["Name"]."</option>";
	}
	//echo "<option value =\"".""."\">"."Select One"."</option>";
	
	$SQL="select intUserID,Name from useraccounts where intCompanyID = '". $_SESSION["FactoryID"] ."' and
useraccounts.intUserID <>  '". $_SESSION["UserID"] ."' order by Name ";
	
	$result =$db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intUserID"]."\">".$row["Name"]."</option>";
	}
?>
              </select></td>          
			<td width="10%" class="normalfnt"><a href="../GeneralGatePass/gengatepasslist.php" class=\"non-html pdf\" target=\"_blank\"><img src="../../images/search.png" alt="search" width="80" height="24" border="0" /></a></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr class="mainHeading2">
        <td width="89%" ><div align="center">General Gatepass Details</div></td>
        <td width="11%" ><img src="../../images/add-new.png" alt="add new" width="109" height="18" onclick="OpenItemPopUp();"/></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:350px; width:950px;">
          <table id="tblGPItemList" width="950" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
               <th width="3%" height="25" >Del</th>              
			  <th width="37%" >Detail</th>	
               <th width="9%" >Unit</th>		  
              <th width="9%" >GatePass Qty</th>
              <th width="7%" >Stock Bal </th>			  
			  <th width="6%" >GRN No </th>
			  <th width="8%" >GRN Year </th>
              <!--<th width="12%" >Cost Center </th>
              <th width="9%" >GL Code</th>-->
            </tr>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25"><table width="100%" cellpadding="2" cellspacing="0" >
      <tr>
        <td width="100%"  align="center">
   		<img src="../../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" /> 
        <img src="../../images/save.png" alt="save" width="84" height="24" id="butSave" onclick="saveGatePass();" />
        <img src="../../images/conform.png" onclick="openConfirmRpt();" id="butConfirm" />
        <img src="../../images/report.png" width="108" height="24" onclick="openReport();" />
        <a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a></td>
      </tr>
    </table></td>
  </tr>
</table>
</td></tr>
</table>
</form>
<div style="left:300px; top:145px; z-index:10; position:absolute; width:240px; visibility:hidden; " id="gotoReport" ><table width="270" height="65" border="0" cellpadding="1" cellspacing="0" class="tablezRED">
		<tr>
            <td colspan="4" bgcolor="#550000" align="right"><img src="../../images/cross.png" onclick="closeFindGPpopup();" />&nbsp;</td>
         </tr>
          <tr>
            <td width="48" height="27">State </td>
            <td width="108"><select name="cboPpoupState" class="txtbox" id="cboPpoupState" style="width:100px" onchange="LoadPopUpGenGPNo();">
           	 <option value="0">Save</option>                
              <option value="1">Confirm</option>             
            </select></td>
            <td width="39">Year</td>
            <td width="65"><select name="cboPopupYear" class="txtbox" id="cboPopupYear" style="width:55px" onchange="LoadPopUpGenGPNo();">
             
			<?php
				$SQL = " SELECT DISTINCT intYear FROM gengatepassheader ORDER BY intYear desc ";	
				$result = $db->RunQuery($SQL);		
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intYear"] ."\">" . $row["intYear"] ."</option>" ;
				}
			?>
            </select></td>
    </tr>
          <tr>
            <td><div align="left">GP  No</div></td>
            <td><select name="cboPopupGPNo" class="txtbox" id="cboPopupGPNo" style="width:100px" onchange="loadGenGPDetails();">
			<option value="" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
        </table>
		
		
</div>
</body>
</html>
<script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>