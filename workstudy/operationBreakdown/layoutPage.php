<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operation Layout Sheet</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Operation.js"></script>

<script src="ajaxupload.js"></script>
<script src="test.js"></script>
<script src="../../javascript/script.js" type="text/javascript" ></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="../../javascript/styleNoOrderNoLoading.js" type="text/javascript" ></script>
</head>
<?php
$style=$_GET["style"];
$operators=$_GET["operators"];
$helpers=$_GET["helpers"];
$machineSMV=$_GET["machineSMV"];
$helperSMV=$_GET["helperSMV"];
$teams=$_GET["teams"];
$hoursPerDay=$_GET["hoursPerDay"];
?>

<body onload="loadGrid('<?php echo $style ?>','');">
<?php
include "../../Connector.php";
?> 
<form id="frmOperationBrackDown" name="frmOperationBrackDown">
<table width="1000" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
  <tr>
	<td align="center">
		<table width="80%" align="center" border="0" class="bcgl1">
			<tr>
				<td colspan="3" height="10"></td>
			</tr>
			<tr>
				<td colspan="3"  class="mainHeading2">Operation Layout</td>			
			</tr>
            <tr>
				<td colspan="2">
				<table  width="100%">
				<tr>
				<td class="normalfnt" width="41" >Style</td>
				<td class="normalfnt" width="148">
					<select class="txtbox" style="width: 125px;" 
					onchange="getStylewiseOrderNoNew('OPBDGetStylewiseOrderNo',this.value,'cboOrderNo');getScNo('OPBDgetStyleWiseSCNum','cboScNo');"
					 name="cboStyles" id="cboStyles">
			         <option value="">select</option>
					 
		             <?php	
		             $SQL="	SELECT
					        distinct
							orders.strStyle
							FROM
							orders
							Inner Join specification ON orders.intStyleId = specification.intStyleId order by orders.strStyle";
		
						$result =$db->RunQuery($SQL);
						while ($row=mysql_fetch_array($result))
						{
									if($style==$row["strStyle"])
										echo "<option selected = \"selected\" value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
									else
							echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
						}
	
 	                 ?>
		          </select></td>
				<td class="normalfnt" width="62">Order No</td>
				<td class="normalfnt" width="147">
                   <select class="txtbox" style="width: 125px;" name="cboOrderNo" id="cboOrderNo" onchange="getSC('cboScNo','cboOrderNo');loadLayoutStyle();">
                    <option value="">select</option>
					
                    <?php
					$SQL="	SELECT
							orders.intStyleId,
							orders.strOrderNo
							FROM
							orders
							Inner Join specification ON orders.intStyleId = specification.intStyleId order by orders.strOrderNo ASC";		
					$result = $db->RunQuery($SQL);	 
					while($row = mysql_fetch_array($result))
					{
						if($style==$row["intStyleId"])
							echo "<option selected = \"selected\" value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
						else
						echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
					}		  
					?>
                  </select> 				
				
					<input  style="display:none" class="txtbox" type="text" id="txtOperators" name="txtOperators" value="<?php echo $operators; ?>">				
					<input  style="display:none" class="txtbox" type="text" id="txtHelpers" name="txtHelpers" value="<?php echo $helpers; ?>">	
					<input style="display:none" class="txtbox" type="text" id="txtMSMV" name="txtMSMV" value="<?php echo $machineSMV; ?>">
					<input style="display:none" class="txtbox" type="text" id="txtHSMV" name="txtHSMV" value="<?php echo $helperSMV; ?>">
					<input style="display:none" class="txtbox" type="text" id="txtTeams" name="txtTeams" value="<?php echo $teams; ?>">	
					<input style="display:none" class="txtbox" type="text" id="txtHrs" name="txtHrs" value="<?php echo $hoursPerDay; ?>">	
			     </td>
				 
				 <td class="normalfnt" width="38" >SC</td>
				<td class="normalfnt" width="101">
					<select class="txtbox" style="width: 75px;" onchange="getStyleNoFromSC('cboScNo','cboOrderNo');loadLayoutStyle();" name="cboScNo" id="cboScNo">
			         <option value="">select</option>
					 
		             <?php	
		             $SQL="	SELECT
                            orders.intStyleId,
							specification.intSRNO
							FROM
							orders
							Inner Join specification ON orders.intStyleId = specification.intStyleId order by specification.intSRNO DESC";
		
						$result =$db->RunQuery($SQL);
						while ($row=mysql_fetch_array($result))
						{
									if($style==$row["intStyleId"])
										echo "<option selected = \"selected\" value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
									else
							echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
						}
	
 	                 ?>
		          </select></td>
					
				<td class="normalfnt" width="68" >Catogery</td>
				<td class="normalfnt" width="146">
					<select class="txtbox" style="width: 100px;" name="comCat" id="comCat" 
					onchange="loadGrid(cboOrderNo.value,this.value);loadOperatorHelperTeam(cboOrderNo.value,this.value);">	
					<option value="" >select</option>
					<?php
					$SQL="	SELECT `intCategoryNo` , `strCategory`
							FROM `componentcategory`
							WHERE `intStatus` =1
							ORDER BY `componentcategory`.`intCategoryNo` ASC";		
					$result = $db->RunQuery($SQL);	
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intCategoryNo"] ."\">" . $row["strCategory"] ."</option>" ;
					}		  
					?>  					    
	              </select></td>
				</tr>
			</table></td>
		</tr>			
		  
		<tr>
			<td colspan="2" align="center" >
				<table>
				<tr>
				<td width="720">
				<div id="divcons" class="main_border_line" style="overflow:scroll; height:250px; width:730px;">
					<div id="datagrid">
					<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblOperationLayoutSelection">
						<caption style='background-color:#FBF8B3'></caption>
						<tr>
							<th style='background-color:#FBF8B3'></th>
							<th style='background-color:#FBF8B3'>EPF No</th>
							<th style='background-color:#FBF8B3'>Operation</th>
							<th style='background-color:#FBF8B3'>Machine</th>
							<th style='background-color:#FBF8B3'>SMV</th>
							<th style='background-color:#FBF8B3'>TGT</th>
							<th style='background-color:#FBF8B3'>Bal</th>
							<th style='background-color:#FBF8B3'>operatId</th>
							<th style='background-color:#FBF8B3'>machineId</th>
						</tr>			 
					</table>		
					</div>		
				</div></td>
				</tr>
				</table></td>
		</tr>
		
		<tr>
			<td align="center">&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="2" align="center" >
			<table  border="0" class="tableBorder">
				<tr>					
					<td><img src="../../images/new.png" class="mouseover" border="0" onclick="LayoutPageClear();" ></td>
					<td><img src="../../images/save.png" alt="Save" name="Save" id="Save" class="mouseover" onclick="saveLayoutData()"></td>
					<td><img src="../../images/close.png" id="Close" border="0" onclick="backToTheMainPage();"></td>
					<td><img id="butReport" src="../../images/report.png" alt="Report" border="0" class="mouseover" onclick="reportLayout();"/></td>
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
