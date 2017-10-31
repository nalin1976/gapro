<?php
	session_start();
	$backwardseperator = "../../../";
	include "../../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	include "../../../eshipLoginDB.php";	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
  <tr>
    <td colspan="4" ><table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="575" class="mainHeading">Monthly Shipment Details</td>
    <td width="25" class="mainHeading"><img src="../../../images/cross.png" width="17" height="17" align="right" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table></td>
  </tr>
 <tr>
    <td colspan="4" height="5"></td>
  </tr>
  <tr>
    <td class="normalfnt">Destination</td>
    <td><select name="cboPopupDestination" id="cboPopupDestination" style="width:120px;">
      <option value=""></option>
      <?php 
	$eshipDB = new eshipLoginDB();
			$sql = "select strCityCode,strCity,strPortOfLoading from city order by strCity ";
			$result = $eshipDB->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				 echo "<option value=".$row["strCityCode"].">".$row["strCity"].'-'.$row["strPortOfLoading"]."</option>\n";
			}
			?>
    </select></td>
    <td class="normalfnt">Month Schedule No</td>
    <td><select name="cboPopMonthScheduleNo" id="cboPopMonthScheduleNo" style="width:120px;" onChange="loadMonthScheduleDetails();">
      <option value=""></option>
      <?php 
			$sql = "select intScheduleNo,strMonthSheduleNo from finishing_month_schedule_header where intStatus=1 order by strMonthSheduleNo desc ";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				 echo "<option value=".$row["intScheduleNo"].">".$row["strMonthSheduleNo"]."</option>\n";
			}
			?>
    </select></td>
  </tr>
  <tr>
    <td width="109" class="normalfnt">ISD No</td>
    <td width="181"><input type="text" name="txtISDNo" id="txtISDNo" style="width:120px;"></td>
    <td width="123" class="normalfnt">DC No</td>
    <td width="175"><input type="text" name="txtDCNo" id="txtDCNo" style="width:120px;"></td>
  </tr>
  <tr>
  <td class="normalfnt">DO No</td>
  <td><input type="text" name="txtDONo" id="txtDONo" style="width:120px;"></td>
  <td></td>
  <td></td>
  </tr>
  <tr>
    <td colspan="4" height="5"></td>
  </tr>
  <tr>
    <td colspan="4"><div id="delPopup" style="width:600px; height:200px; overflow:scroll;">
      <table width="600" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="popupMonthSchedule">
        <tr class="mainHeading4">
          <td width="43" height="20"><input type="checkbox" name="checkbox" id="checkbox" onClick="CheckAll(this,'popupMonthSchedule')"></td>
          <td width="134">Order No</td>
          <td width="85">Style No</td>
          <td width="80">HO Date</td>
          <td width="84">Del Date</td>
          <td width="72">Mode</td>
          <td width="94">Qty</td>
        </tr>
      </table>
    
    </div></td>
  </tr>
  <tr>
    <td colspan="4" height="8"></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><table width="600" border="0" cellspacing="0" cellpadding="2" class="bcgl1" >
  <tr>
    <td align="center"><img src="../../../images/addsmall.png" width="95" height="24" onClick="addToMainGrid();"><img src="../../../images/close.png" width="97" height="24" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table></td>
  </tr>
   <tr>
    <td colspan="4" height="5"></td>
  </tr>
</table>
</body>
</html>
