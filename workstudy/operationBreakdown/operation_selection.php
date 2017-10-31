<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operation Selection</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="ajaxupload.js"></script>
<script src="Operation.js"></script>
<script src="../../javascript/tablegrid.js" type="text/javascript" ></script>
<script src="../../javascript/script.js"></script>


</head>

<body>

<?php
include "../../Connector.php";
//include $backwardseperator."Header.php";
?>
 
 <div> 
  <table width="600"  border="0" align="center" bgcolor="#FFFFFF">
  <tr><td align="center">
	<table align="center" width="820">
		<tr><td align="right" colspan="5"><img src="../../images/cross.png" onclick="CloseWindow();" style="width:20px;" /></td></tr>
		<tr class="cursercross" onmousedown="grab(document.getElementById('frmChemicals'),event);">
         	<td   class="mainHeading2" colspan="5">Operations Selection</td>
</tr></table>  
  </td></tr>
    <tr>
    	<td align="center"> 
	<table align="center" width="572">
		<tr>
			<td width="1" class="normalfnt">&nbsp;</td>
			<td width="148" class="normalfnt">Style No</td>
			<td class="normalfnt" width="203">
		  <input style="width:201px;" name="style_no" id="style_no" disabled="disabled" value="<?php echo $_GET['data']; ?>" class="txtbox" type="text" maxlength="10"><input   name="style_no_data" id="style_no_data" type="hidden" >	  </td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">&nbsp;</td>
		</tr>
		
		<tr>
			<td width="1" class="normalfnt">&nbsp;</td>
			<td width="148" class="normalfnt">Process</td>
			<td class="normalfnt" width="203">
<select name="cmbProcessId" class="txtbox" id="cmbProcessId" style="width:203px" onchange="loadComponentsWise();loadOperationsWise();checkForManualOperations();">
                      <option value=""></option>
                      <?php 
			$str="select intProcessId,strProcess from ws_processes order by intProcessId ASC";
		
			$results=$db->RunQuery($str);
			
			while($row=mysql_fetch_array($results))
			{
		?>
                      <option value="<?php echo $row['intProcessId'];?>"><?php echo $row['strProcess'];?></option>
                      <?php } ?>
                      </select></td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">&nbsp;</td>
		</tr>
	 
		<tr>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">Com Cat</td>
			<td class="normalfnt" width="203">
				<select class="txtbox" style="width: 203px;" name="comCat" id="comCat" onchange="loadComponentsWise();loadOperationsWise();loadDetailsToSMVtable();">	
					<option value=""></option>
					<?php
$SQL="	SELECT intCategoryNo , strDescription
			FROM componentcategory
			WHERE `intStatus` =1
			ORDER BY strDescription ";		
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCategoryNo"] ."\">" . $row["strDescription"] ."</option>" ;
	}	  
	?>  					    
		  </select>	  	  </td>
			<td class="normalfnt"><span class="normalfntp2"><img  src="../../images/add.png" class="mouseover" onclick="edit_category();" title='Add New'/></span></td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt" style="display:none;"><img src="../../images/aad.png" onclick="addAllRows();" title='Add New'/></td>
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">Component</td>
			<td class="normalfnt" width="203">
				<select class="txtbox" style="width:203px;" name="component" id="component" onchange="loadOperations(this.value)">	
					<option value=""></option>
				</select>	  
			</td>
			<td class="normalfnt"><span class="normalfntp2"><img onlick="onlick" src="../../images/add.png" class="mouseover" onclick="loadComponentEditorPopup();" title='Add New'/></span></td>
			<td class="normalfnt"><span class="normalfntp2"><img onlick="onlick" src="../../images/Tsmallreport.jpg" class="mouseover" onclick="loadComponentsCatWise('');"  title='All'/></span></td>
			<td class="normalfnt">&nbsp;</td>
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">Operation</td>
			<td class="normalfnt" width="203">
			
				<select class="txtbox" style="width: 203px;" name="operation" id="operation" >	
					<option value=""></option>
				</select>
						</td>
			<td class="normalfntp2"><img onlick="onlick" src="../../images/add.png" class="mouseover" onclick="addNewOperation();" title='Add New'/></td>
			<td class="normalfntp2"><img onlick="onlick" src="../../images/Tsmallreport.jpg" class="mouseover" onclick="loadOperations('');" title='All' /></td>
		  <td class="normalfntp2">&nbsp;</td>
		</tr>
		<tr>
		  <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnt" style="display:display;"> </td>
		  <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnt">&nbsp;</td>
	    </tr>
<!--		<tr>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">Machine</td>
			<td class="normalfnt" width="203">
				<select class="txtbox" id="cboMachine" name="cboMachine" onchange="loadMTypes(this.value);" style="width: 203px;" >	
					<option value="0"></option>
	<?php
/*	$SQL="	SELECT  intMacineID, strName FROM ws_machines order by strName";		
	$result = $db->RunQuery($SQL);	 
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intMacineID"] ."\">" . $row["strName"] ."</option>" ;
	}	*/	  
	?>   
				</select>
		 
		  <td class="normalfnt"><span class="normalfntp2"><img  src="../../images/add.png" class="mouseover" onclick="addNewMachines();" /></span></td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">&nbsp;</td>
		</tr>-->
		<tr>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">Machine  </td>
			<td class="normalfnt" width="203">
				<select class="txtbox" id="machine" name="machine" style="width: 203px;" onchange="loadSmv();">	
					<option value=""></option>
	<?php
	$SQL="	SELECT  intMachineTypeId,strMachineName  from ws_machinetypes where intStatus='1' order by strMachineName";		
	$result = $db->RunQuery($SQL);	 
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intMachineTypeId"] ."\">" . $row["strMachineName"] ."</option>" ;
	}		  
	?>   
				</select>
			</td>
			<td class="normalfnt"><span class="normalfntp2"><img onlick="onlick" src="../../images/add.png" class="mouseover" onclick="addNewMachineTypes();" /></span></td>
			<td class="normalfnt">&nbsp;<input name="manual" id="manual" type="checkbox" value="1"  class="chkbox" onchange="hideMachine();"  />
	      Manual</td>
			<td class="normalfnt">&nbsp;</td>
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">SMV</td>
			<td class="normalfnt" width="203">
		  <input style="width:201px;" name="smv" id="smv" class="txtbox" type="text" maxlength="10">	  	  </td>
			<td width="54" class="normalfnt"></td>
			<td width="107" class="normalfnt"></td>
		  <td width="31" class="normalfnt"></td>
		</tr>
		<tr>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt"></td>
			<td class="normalfnt" width="203"></td>
			<td width="54" class="normalfnt"></td>
			<td width="107" class="normalfnt"><img src="../../images/additem.png" onclick="addRow();" class="mouseover" /></td>
		  <td width="31" class="normalfnt"></td>
		</tr>
	</table>
	</td></tr>
	<br />
	<tr><td>
	<table align="left" width="820"  id="tblsmvdatatable">
		<tr>
			<td class="normalfnt" width="21">&nbsp;</td>
			<td class="normalfnt" width="94">&nbsp;</td>
		    <td width="112">&nbsp;</td>
			<td class="normalfnt" width="61">&nbsp;</td>
		    <td width="106">&nbsp;</td>
		<!-- <td class="normalfnt" width="90">None Line SMV</td>
		  <td width="110"><input style="width:100px;" class="txtbox" type="text" maxlength="10"></td> -->
			<td class="normalfnt" width="70">&nbsp;</td>
		    <td width="102">&nbsp;</td>
			<td class="normalfnt" width="12">&nbsp;</td>
		</tr>
		<tr>
			<td class="normalfnt" width="21">&nbsp;</td>
			<td class="normalfnt" width="94">Machine SMV</td>
		  <td width="112"><input style="width:100px;" class="txtbox" type="text" maxlength="10" name="opmachineSMV" id="opmachineSMV" readonly="readonly"></td>
			<td class="normalfnt" width="61">Help SMV</td>
		  <td width="106"><input style="width:100px;" class="txtbox" type="text" maxlength="10" name="ophelpSMV" id="ophelpSMV" readonly="readonly"></td>
		<!-- <td class="normalfnt" width="90">None Line SMV</td>
		  <td width="110"><input style="width:100px;" class="txtbox" type="text" maxlength="10"></td> -->
			<td class="normalfnt" width="70">Total SMV</td>
		  <td width="102"><input style="width:100px;" class="txtbox" type="text" maxlength="10" name="optotalSMV" id="optotalSMV" readonly="readonly" ></td>
			<td class="normalfnt" width="12">&nbsp;</td>
		</tr>
	</table>
	</td></tr>
	<br />
	<tr><td>
	<div id="divcons" class="main_border_line" style="overflow:scroll; height:180px; width:798px;">
		<div id="datagrid1">
		<!--<table width="100%" cellpadding="0" cellspacing="1" class="thetable" id="tblOperationSelection">
				<caption></caption>
				<tr>
					<th>Serial No</th>
					<th>Machine</th>
					<th>Components</th>
					<th>Opt Code</th>
					<th>Operations</th>
					<th>SMV</th>
					<th>Machine</th>
				</tr> 
			</table>-->		 
		 <?php
		 $data=$_GET['data'];
 
		/*$SQL = "SELECT operationbreakdowndetails.*,operationbreakdowndetails.intSerial, 
				machines.strMachineName,components.strComponent,operations.intOpID, 
				operations.strOperation, operationbreakdowndetails.dblSMV, orders.strStyle, operationbreakdowndetails.intMachineType, operationbreakdowndetails.intStyleID 
				FROM operationbreakdowndetails
				Inner Join operations ON operations.intOpID = operationbreakdowndetails.intOperationID
				Inner Join components ON components.intComponentId = operations.intComponent
				Inner Join componentcategory ON componentcategory.intCategoryNo = components.intCategory
				Inner Join orders ON orders.intStyleId = operationbreakdowndetails.intStyleID
				Inner Join machines ON machines.intMachine = operationbreakdowndetails.intMachine
				WHERE operationbreakdowndetails.intStyleID =  '".$data."' ";*/
				
		$SQL = "SELECT ws_operationbreakdowndetails.*, 
		ws_operationbreakdowndetails.intOperationID, 
		ws_operationbreakdowndetails.intMachineTypeId, 
		ws_operationbreakdowndetails.intSerial, 
				ws_machinetypes.strMachineName,
				components.strComponent,
				ws_operations.intOpID, 
				ws_operations.strOperation, 
				ws_operationbreakdowndetails.dblSMV, 
				orders.strStyleID, 
				ws_operationbreakdowndetails.intMachineType, 
				ws_operationbreakdowndetails.strStyleID,  
				componentcategory.strDescription,  
				componentcategory.intCategoryNo 
				FROM ws_operationbreakdowndetails
				INNER JOIN ws_operations ON ws_operations.intOpID = ws_operationbreakdowndetails.intOperationID
				INNER JOIN components ON components.intComponentId = ws_operations.intComponent
				INNER JOIN componentcategory ON componentcategory.intCategoryNo = components.intCategory
				INNER JOIN orders ON orders.strStyleID = ws_operationbreakdowndetails.strStyleID
				LEFT OUTER JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
				WHERE ws_operationbreakdowndetails.strStyleID = '".$data."' order by componentcategory.intCategoryNo,intSerial ASC ";	
									
	 	 	  
		 echo "<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable \" id=\"tblOperationSelection1\">
				<caption></caption>
				<tr>
					<th>Serial No</th>
					<th>Machine</th>
					<th>Category</th>
					<th>Components</th>
					<th>Opt Code</th>
					<th>Operations</th>
					<th>SMV</th>
					<th>Manual</th>
					<th style=\"display:none\">sm</th>
					<th style=\"display:none\">co</th>
					<th style=\"display:none\">cc</th>
					<th style=\"display:none\">ip</th>
					<th style=\"display:none\">im</th>
					<th># Opr</th>
					<th>Target 100%</th>
					<th>SMV (TMU)</th>	
					<th>Del</th>
				</tr> ";
 // style=\"display:none\"
 //echo $SQL;
	 
		/*	$result = $db->RunQuery($SQL);
			$i =0;	 
			while($row = mysql_fetch_array($result))
			{	 		  
				$i++;
				$target = 0;
				$target = 60/$row['dblSMV'];				
				$target = number_format($target, 2, '.', '');
				$smv = $row['dblSMV'];
				$tmu = 1667*$smv;
				echo "<tr id=\"".$i."\"> 
					<td align=\"center\" class=\"normalfntMid\"  id=\"".$row["intCategoryNo"]."\">".$i."</td>
					<td align=\"left\" class=\"normalfntMid\">".$row["strMachineName"]."</td>
					<td align=\"left\" class=\"normalfntMid\" id=\"".$row["intCategoryNo"]."\" >".$row["strDescription"]."</td>
					<td align=\"left\" class=\"normalfntMid\">".$row["strComponent"]."</td>
					<td align=\"center\" class=\"normalfntMid\">".$row['intOpID']."</td>
					<td align=\"left\" class=\"normalfntMid\">".$row['strOperation']."</td>
					<td align=\"right\" class=\"normalfntMid\">".$smv."</td>
					<td align=\"center\" class=\"normalfntMid\"><input type=\"checkbox\"";				
				if($row['intMachineType']==1)
				{ 					
					echo "checked=\"checked\""; 
				}   
				echo " disabled=\"disabled\" > </td>
					<td align=\"right\" style=\"display:none\" class=\"normalfntMid\" >".$row['intMachineTypeId']."</td>
					<td style=\"display:none\"  class=\"normalfntMid\">".$row['component']."</td>
					<td style=\"display:none\" class=\"normalfntMid\" >".$row['comCat']."</td>
					<td style=\"display:none\"  class=\"normalfntMid\">".$row['intOperationID']."</td>
					<td style=\"display:none\" class=\"normalfntMid\" >".$row['intMachineType']."</td>
					<td class=\"normalfntMid\">&nbsp;</td>
					<td class=\"normalfntMid\">".$target."</td>
					<td class=\"normalfntMid\">".$tmu."</td>
					<td class=\"normalfntMid\"><img src=\"../../images/del.png\" onClick=\"deleteRow1('this.parentNode.parentNode.rowIndex','".$row['intOperationID']."','".$data."');\"></td>
					</tr>";  //style=\"display:none\"			
				//".$i.",".$row['intOperationID'].",".$data.");  echo "class=\"chkbox\"></td>				
			}	*/		 
			echo "</table>";		  
		 ?>
		</div>
	</div>
	</td></tr>
	<tr><td>

	<table width="798px">
		<tr>
			<td align="center"><img src="../../images/addsmall.png" border="0" onclick="moveOperationBreakDownSheet('<?php echo $_GET['data']; ?>');" ></td>
		</tr>
	</table>	
	 </td>
	 </tr>
	 </table>
 </div>
</body>
</html>
