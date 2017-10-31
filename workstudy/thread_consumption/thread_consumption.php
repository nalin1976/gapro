<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thread Consumption</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../freelance/Button.js"></script>
<script src="../../javascript/script.js"></script>
<script src="thread_consumption.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="../../javascript/styleNoOrderNoLoading.js" type="text/javascript" ></script>

</head>

<body>

<?php
include "../../Connector.php";

?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>

<!--<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Thread Consumption<span id="banks_popup_close_button"></span></div>
	</div>
	<div class="main_body">-->
<form name="frmTreadConsump" id="frmTreadConsump" >
<table width="700" border="0" align="center" bgcolor="#FFFFFF" >
			<tr>
				<td colspan="3"  class="mainHeading2">
				Thread Conssumption Sheet</td>
			</tr>
  <tr>
	<td align="center">
		<table width="100%" align="center" border="0" class="bcgl1">
  <tr>
	<td>
		<table width="100%" align="center" border="0">
			<tr>
			  <td width="10">&nbsp;</td>
			  <td class="normalfnt" width="75">Style Name</td>
			  <td class="normalfnt" width="165">
			    <select name="cboStyles" class="txtbox" id="cboStyles" style="width:153px" 
				onchange="getStylewiseOrderNoNew('OPBDReportGetStylewiseOrderNo',this.value,'cboStyle');getScNo('OPBDReportgetStyleWiseSCNum','cboOrderNo');">
			      <option value="">Select one</option> 
			      
			      <?php
					//$SQL="	SELECT distinct intStyleId, intSRNO FROM specification  ";	
					$SQL = "SELECT
							orders.intStyleId,
							orders.strStyle
							FROM
							ws_operationbreakdownheader
							Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId order by strStyle ASC";	
					$result = $db->RunQuery($SQL);	 
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"".$row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
					}		  
					?>
			      </select>        
			    </td>
				
			  <td class="normalfnt" width="61">Order No</td>
			  <td class="normalfnt" width="157">
			    <select name="cboStyle" class="txtbox" id="cboStyle" style="width:153px" onchange="getSC('cboOrderNo','cboStyle');loadGrid(this.value);">
			      <option value="">Select one</option> 
			      
			      <?php
					//$SQL="	SELECT distinct intStyleId, intSRNO FROM specification  ";	
					$SQL = "SELECT
							orders.intStyleId,
							orders.strOrderNo
							FROM
							ws_operationbreakdownheader
							Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId order by strStyle ASC";	
					$result = $db->RunQuery($SQL);	 
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"".$row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
					}		  
					?>
			      </select>        
			    </td>
				
			  <td class="normalfnt"  width="49">SC No</td>
			  <td class="normalfnt" width="91">
  <select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:75px" onchange="loadGrid(this.value);getStyleNoFromSC('cboOrderNo','cboStyle');">
    <option value="">Select one</option> 
    
    <?php
		
/*		$SQL="SELECT DISTINCT s.strStyleID,s.intSRNO 
				FROM specification s order by intSRNO DESC";*/
			$SQL = "SELECT
				orders.intStyleId,
				specification.intSRNO
				FROM
				ws_operationbreakdownheader
				Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId
				Inner Join specification ON orders.intStyleId = specification.intStyleId order by intSRNO ASC ";		
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
			}
	
 	    ?>
    </select>		  </td>
			  <td class="normalfnt" width="72">Wastage(%)</td>
			  <td width="43"><input type="text" id="txtWastage" name="txtWastage" style="height:11px; width:40px" /></td>
			  <td width="50" class="normalfnt"><img src="../../images/ok-mark.png" onclick="loadGrid('cboOrderNo.value')"/></td>
			  </tr>
	</table>
	</td>
  </tr>
  <tr>
	<td align="center">
		<div id="divcons" class="main_border_line" style="overflow:scroll; height:250px; width:813px;">
			<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblThreadCons">

				<tr >
					<th style="background-color:#FBF8B3" >Serial No</th>
					<th style="background-color:#FBF8B3" >Comp Catogory</th>
					<th style="background-color:#FBF8B3" >Machine ID</th>
					<th style="background-color:#FBF8B3" >Opt Code</th>
					<th style="background-color:#FBF8B3" >Operations</th>
					<th style="background-color:#FBF8B3" >Opt Lenth (inches)</th>
					<th style="background-color:#FBF8B3" >Combination</th>
					<th style="display:none;background-color:#FBF8B3"></th>
				</tr>
			</table>
		</div>
	</td>
  </tr>
  <tr >
	<td align="center">
		<table width="585">
			<tr>
				<td height="16" colspan="7" class="normalfnt" style="text-align:left;">Color Codes</td>
			</tr>	
			<tr>
				<td width="28" height="21" class="normalfnt">&nbsp;</td>
				<td width="16"><img src="../../images/yellow.jpg"/></td>
				<td width="160" class="normalfnt">Combination Not Added</td>
				<td width="15"><div style="width:15px; height:15px; background:#FFD2FF"></div></td>
				<td width="120" class="normalfnt">Half Combination</td>
				<td width="19"><img src="../../images/blue.jpg"/></td>
				<td width="195" class="normalfnt">Full Combination</td>
			</tr>
		</table>
	</td>
   </tr>
   <tr>
	<td >
	<table width="100%">
		<tr>
			<td width="35%">&nbsp;</td>
			<td width="11%"><img src="../../images/new.png" onclick="clearForm();"  class="mouseover"></td>
			<td width="11%"><a href="../../main.php"><img src="../../images/close.png" id="Close" border="0"></a></td>
			<td width="17%"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewThreadReport();"  /></td>
			<td width="26%">&nbsp;</td>
		</tr>
	</table>
	</td>
   </tr>
   
</table></td></tr>
   
</table>
</form>
<!--</div>
</div>-->

</body>
</html>
