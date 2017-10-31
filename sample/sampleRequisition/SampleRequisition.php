<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Requisitions</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>
<script src="../../javascript/script.js"></script>
<script src="SampleRequisition.js"></script> <!-- added on 02/03/2011 by Chandima Batuwita-->

<!--calender-->
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/functions.js" ></script>
<script type="text/javascript" src="bom.js"></script>
<style type="text/css">
.trans_layoutNew{
	width:550px; height:auto;
	border:1px solid;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	border-right-color:#550000;
	background-color:#FFFFFF;
	padding-right:15px;
	padding-top:10px;
	padding-left:30px;
	padding-right:30px;
	padding-bottom:15px;
	margin-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	border-bottom:13px solid #550000;
	border-top:30px solid #550000;
}
</style>
</head>
<body onload="clearFields();">

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include $backwardseperator.'Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutNew">
		<div class="trans_text">Sample Requisition<span class="volu"></span></div>
			<table width="95%" border="0" class="bcgl1">
            <tr>
            <td>
            <table width="101%" height="78" border="0" align="center">
				<tr>
					<td width="3%" class="normalfnt"></td>
					<td width="13%" class="normalfnt">Style No</td>
		  	  	  	<td width="38%" class="normalfnt">
						<select style="width: 152px;" class="txtbox" name="cboStyleNo" id="cboStyleNo" onchange="getOrderNo()">
							<!-- Populate the Style No combo bos with styles  -->
						<?php
						
							$SQL="SELECT DISTINCT strStyle FROM orders ORDER BY orders.strStyle";
							$result = $db->RunQuery($SQL);
							echo "<option value=\"\"></option>" ;
							while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"".cdata($row["strStyle"])."\">".cdata($row["strStyle"])."</option>";
								
								
							}
							
						?>
							
				  		</select>
				  </td>
					<td width="15%" class="normalfnt">Order No</td>
			  	  	<td width="31%" class="normalfnt"><select style="width: 152px;" class="txtbox" name="OrderDetails" id="OrderDetails" >
			  	  	  <!-- Populate the Style No combo bos with styles  -->
			  	  	  <?php
						
							$SQL="SELECT orders.intStyleid,strOrderNo FROM orders ORDER BY orders.strOrderNo";
							$result = $db->RunQuery($SQL);
							echo "<option value=\"\"></option>" ;
							while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"".cdata($row["intStyleid"])."\">".cdata($row["strOrderNo"])."</option>";
								
								
							}
							
						?>
		  	  	    </select></td>
				</tr>
				<tr>	
					<td width="3%" class="normalfnt"></td>
					<td width="13%" class="normalfnt">Date</td>
	  	  	  	  <td width="38%" class="normalfnt"><input type="text" style="width: 150px;" class="txtbox" name="txtDt" id="txtDt" onclick="return showCalendar(this.id, '%Y-%m-%d');" readonly="readonly" /><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;height:1px !important;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" /></td>
					<td width="15%" class="normalfnt">Sample No</td>
		  	  	  <td width="31%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" name="txtSmplNo" id="txtSmplNo" readonly="readonly" /></td>
				</tr>
                
                <tr>	
					<td width="3%" class="normalfnt"></td>
					<td width="13%" class="normalfnt">Buyer</td>
	  	  	  	  <td width="38%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" name="txtBuyer2" id="txtBuyer2"/></td>
					<td width="15%" class="normalfnt">&nbsp;</td>
		  	  	  <td width="31%" class="normalfnt">&nbsp;</td>
				</tr>
	  	  	</table>
			
			<table align="center" width="101%" border="0">
<tr>
				<td width="17%" class="normalfnt"></td>
			  	  	<td width="12%" class="normalfnt"></td>
					<td width="26%" class="normalfnt"></td>
					<td colspan="2" class="normalfnt"></td>	
				</tr>
<tr>
					<td width="17%" class="normalfnt"></td>
			  	  	<td width="12%" class="normalfnt" id="orignl_smpl"><input type="checkbox" /></td>
					<td width="26%" class="normalfnt">Original Sample</td>
					<td colspan="2" class="normalfnt"><!--img src="../../images/search.png" width="60" /--></td>
				</tr>
				<tr>
					<td width="17%" class="normalfnt"></td>
			  	  	<td width="12%" class="normalfnt" id="fbric"><input type="checkbox" /></td>
					<td width="26%" class="normalfnt">Fabric</td>
					<td width="14%" class="normalfnt">Date</td>
					<td width="31%" class="normalfnt">
						<input style="width:85px" type="text" class="txtbox2"  name="txtFabricReqdate" id="txtFabricReqdate" onclick="return showCalendar(this.id, '%Y-%m-%d');"  readonly="true"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;height:1px !important;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" id="fb_date">			  	  </td>
				</tr>
				<tr>
					<td width="17%" class="normalfnt"></td>
			  	  	<td width="12%" class="normalfnt" id="access"><input type="checkbox" /></td>
					<td width="26%" class="normalfnt">Accessories</td>
					<td width="14%" class="normalfnt">Date</td>
					<td width="31%" class="normalfnt">
					<input style="width:85px" type="text" class="txtbox2"  name="txtbx_Reqdate" id="txtAccReqdate" onclick="return showCalendar(this.id, '%Y-%m-%d');" readonly="true"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;height:1px !important;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" id="acc_date">			  	  </td>
				</tr>
		  	</table>
            </td>
            </tr>
            </table>	
    <br/>	
			<table width="65%" border="0" class="bcgl1">
            <tr>
            <td>
            <div style="overflow:scroll; height:150px; width:518px;">
				<table width="100%" border="0" cellspacing="1" id="tblMain" bgcolor="#CCCCFF">
					<thead>
						<tr class="mainHeading2">
							<td colspan="4" class="normaltxtmidb2">Sample Requisition Details</td>			
						</tr>	
						<tr class="mainHeading4">
							<td width="44">Add</td>
                            <td width="197">Sample Type</td>
							<td width="126">Required Date</td>
							<td width="138">Colour/Size/Qty</td>	
						</tr>		
					</thead>	
					<tbody>
					<!-- partially building the php that iterates through  array and fetch the elements which are values of
					      sampletypes.intSampleId -->
					<?php
						
						
						$SQL = " SELECT sampletypes.intSampleId,sampletypes.strDescription FROM sampletypes;";
						$result = $db->RunQuery($SQL);
						
						$count=1;  /*
									this counter helps to change the id of Date figure embeded in the table, hence all the
									DTPs generated in the while loop (one for each row in "Required Date" field) can 
									stand alone as a seperate entity.so those can be freely changed independent of each other.
									*/
						while($row = mysql_fetch_array($result))
						{ 

					?>
					<tr class="bcgcolor-tblrowWhite" id="<?php echo cdata($row["intSampleId"]) ;?>">
						<td class="normalfnt" width="44" style="text-align:center"><input type="checkbox"/></td>
                        <td class="normalfnt" width="197" style="text-align:center"><?php echo $row["strDescription"] ;?></td>
						<td class="normalfnt" width="126" style="text-align:center">
						<input type="reset"  class="txtbox" style="visibility:hidden; height:1px !important; width:1px"><input type="text" class="txtbox2"  name="<?php echo "txtReqdate{$count}"; ?>" id="<?php echo "txtReqdate{$count}"; ?>" onclick="return showCalendar(this.id, '%Y-%m-%d');" style="width:85px" readonly="true"/><input name="<?php echo "reset{$count}"; ?>"type="reset"  class="txtbox" style="visibility:hidden; height:1px !important; width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" id="<?php echo "reset{$count}"; ?>">
						</td>
						<td width="138" class="normalfnt" style="text-align:center">
						<img src="../../images/Select.png" onclick="selectComponents(this);" name="txtbx_NoPcs" id="txtbx_NoPcs" style="height:17px"/>
						</td>	
					</tr>
					
					<?php
						$count++;
						}
					?>
											
					</tbody>
				</table>
			</div>
            </td>
            </tr>
            </table>
			<!-- ******************************************************** --><!--********************************************************* -->
    <br />
			<table align="center" width="367" border="0">
      			<tr>
					<td width="15%">&nbsp;</td>
					<td width="13%"></td>
					<td width="24%"><img src="../../images/save.png" width="80"  onclick="saveToTables();"/></td>
					<td width="38%"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="90" border="0" /></a></td>
					<td width="10%">&nbsp;</td>
      			</tr>
		  </table>
		</div>
	</div>
</div>
</body>
</html>
