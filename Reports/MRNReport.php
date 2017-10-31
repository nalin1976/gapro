<?php
	session_start();
	include "../Connector.php"; 
	$backwardseperator = "../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Requisition Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<style type="text/css">
<!--
/*body {
	background-color: #CCCCCC;
}*/
-->
</style>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
</style>


</head>
<script language="javascript" type="text/javascript" src="MRNReport.js"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>


<body>

<form id="form1" name="form1" method="post" action="">
<table width="100%" >
<tr><td><?php include '../Header.php'; ?></td></tr>
<tr><td>
  <table width="957" height="520" border="0" id="tblMain"  align="center" bgcolor="#FFFFFF">
    <tr>
      <td width="951" height="20" colspan="4"></td>
    </tr>
    <tr>
      <td height="494" colspan="4"><table width="92%" cellpadding="0" cellspacing="0" >
        <tr>
          <td height="25" colspan="5" bgcolor="#498CC2" class="normaltxtmidb2">Material Requisition  Report  </td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="0" class="tablezRED">
            <tr>
              <td height="24" colspan="8"><table width="534" height="23" class="backcolorGreenRedBorder" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="normalfntMid">Confirmed</td>
                    <td><input name="optOption" type="radio" value="radiobutton" checked="checked" id="optConfirmed" /></td>
                    <td class="normalfntMid">Canceled</td>
                    <td><input name="optOption" type="radio" value="radiobutton" id="optCanceled" /></td>
                    <td class="normalfntMid">Balanced to Issue</td>
                    <td><input name="optOption" type="radio" value="radiobutton" id="optBalancedtoIssue" /></td>
                    <td class="normalfntMid">Total Issued</td>
                    <td><input name="optOption" type="radio" value="radiobutton" id="optTotalIssued" /></td>
                  </tr>
                            </table></td>
              <td width="16%" height="24">&nbsp;</td>
              <td width="9%" height="24">&nbsp;</td>
            </tr>
            <tr>
              <td height="21">Style  No </td>
              <td colspan="3">
			    <select name="cboStyle" class="txtbox"  id="cboStyle" style="width:150px" onchange="StyleDataCollector()">
				<?php
				
				 	 
	 
					$SQL = "SELECT orders.intStyleId,specification.intSRNO,orders.strStyle FROM orders INNER JOIN specification ON (orders.intStyleId=specification.intStyleId) WHERE orders.intStatus=11 ORDER BY orders.strStyle";	
					
					$result = $db->RunQuery($SQL);
						
					echo "<option value=\"0\">(Select a Style)</option>" ;	
					while($row = mysql_fetch_array($result))
					{
						if($_POST["cboStyle"]==$row["intStyleId"])
							echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
					}
				?>
			  </select>			  </td>
              <td class="normalfnt" >SC No </td>
              <td colspan="2"><select name="cboSCNo" class="txtbox" id="cboSCNo" style="width:150px" onchange="SCDataCollector()" >
                <?php
				$SQL = "SELECT orders.intStyleId,specification.intSRNO FROM orders INNER JOIN specification ON (orders.intStyleId=specification.intStyleId) WHERE orders.intStatus=11 ORDER BY orders.intStyleId";	
				$result = $db->RunQuery($SQL);	
				echo "<option value=\"0\">(Select a SC No)</option>" ;		
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
				}
				
				?>
              </select></td>
              <td class="normalfnt">Order No </td>
              <td><select name="cboOrderNo" id="cboOrderNo"  style="width:150px;" onchange="OrderDataCollector();">
              <?php 
			  
			 $SQL = "SELECT orders.intStyleId,orders.strOrderNo FROM orders INNER JOIN specification ON (orders.intStyleId=specification.intStyleId) WHERE orders.intStatus=11 ORDER BY orders.strOrderNo";	
					
					$result = $db->RunQuery($SQL);
						
					echo "<option value=\"0\">Select Order No</option>" ;	
					while($row = mysql_fetch_array($result))
					{
						if($_POST["cboOrderNo"]==$row["intStyleId"])
							echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
					}
			  ?>
              </select>
              </td>
              <td style="visibility:hidden"><select name="cboBuyerPO" class="txtbox" id="cboBuyerPO" style="width:50px" >
              </select></td>
            </tr>
            <tr>
              <td width="11%" height="21">Main Category</td>
              <td colspan="3"><select name="cboMainMats" class="txtbox" id="cboMainMats" style="width:150px" onchange="getSubcategories()" >
                <?php
					$SQL = "SELECT intID,strDescription FROM MatMainCategory ORDER BY intID";	
					$result = $db->RunQuery($SQL);	
					echo "<option value=\"0\"></option>" ;		
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
					}
				
				?>
              </select></td>
              <td width="14%" class="normalfnt"> Sub Category </td>
              <td colspan="2"><select name="cboCategories" class="txtbox" id="cboCategories" style="width:150px" onchange="getItems()" >
    
              </select></td>
              <td width="12%" class="normalfnt">Material Details </td>
              <td><select name="cboItems" class="txtbox" id="cboItems" style="width:150px" >
             </select></td>
              <td><img src="../images/search.png" width="80" height="24" onclick="getMRNDetails()" /></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td height="360" colspan="5">
		  <div class="bcgl1" id="divMRNData" style="overflow:scroll; width:945px;height:350px">
		  <table width="1050" height="25"  border="0" cellpadding="0" cellspacing="0" id="tblPVData">
            <tr>
			  <td width="60" bgcolor="#498CC2" class="normaltxtmidb2">Req. No </td>
              <td width="80" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Style No </td>
              <td width="60" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
              <td width="130" bgcolor="#498CC2" class="normaltxtmidb2">Material Detail </td>
              <td width="73" bgcolor="#498CC2" class="normaltxtmidb2">Colour</td>
              <td width="73" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
              <td width="73" bgcolor="#498CC2" class="normaltxtmidb2">Req. Quantity</td>
              <td width="73" bgcolor="#498CC2" class="normaltxtmidb2">Issued Qty</td>
              <td width="73" bgcolor="#498CC2" class="normaltxtmidb2">Balance to Issue </td>
              </tr>
			 <!--<tr>
			 	<td class="normalfnt" height="20">222</td>
			 	<td class="normalfnt" >123123</td>
			 	<td class="normalfnt" >123</td>
			 	<td class="normalfnt" >Temp Item </td>
			 	<td class="normalfnt" >123</td>
			 	<td class="normalfnt" >123</td>
			 	<td class="normalfnt" >333</td>
			 	<td class="normalfnt" >123</td>
			 	<td class="normalfnt" >123123</td>
			 	</tr>
-->          </table>
		  </div>		  </td>
        </tr>
	 <tr bgcolor="#D6E7F5">
	 	<td width="59%" height="30">&nbsp;</td>
	    <td width="10%">&nbsp;</td>
	    <td width="10%"><img src="../images/report.png" width="96" height="24" onclick="printMRNsReport()" /></td>
	    <td width="17%"><a href="../main.php"><img src="../images/close.png" width="94" height="24" border="0" /></a></td>
	    <td width="4%">&nbsp;</td>
	 </tr>
		
      </table></td>
    </tr>
    
  </table>
  </td>
  </tr>
  </table>
</form>
</body>
</html>
