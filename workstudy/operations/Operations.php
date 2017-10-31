<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operations</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="machines-js.js"></script>
<script src="../../javascript/script.js"></script>
</head>
<body>
<?php
include "../../Connector.php";
?>
<form id="frmOperations" name="frmOperations" method="post" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
  <tr>
	<td align="center">
		<table width="80%" border="0" align="center"  bgcolor="#FFFFFF" class="bcgl1">
		<tr>
			<td colspan="3" class="normalfnt">&nbsp;</td>
		</tr> 
		
		<tr> 
		<td colspan="3" bgcolor="#498CC2" class="TitleN2white">Operations </td>
		  </tr>
		 
		 <tr>
				<td colspan="3" height="12" class="TitleN2white"></td>
			</tr>
			 
		<tr>
				<td width="100">&nbsp;</td>
			  <td width="125" class="normalfnt">Search</td>
		    <td width="326">
					<select class="txtbox" id="cboSearch" style="width: 203px;"  onchange="loadDetails(this);">	
					<?php
					$SQL="SELECT intOpID ,strOperation FROM ws_operations ORDER BY strOperation ASC";		
					$result = $db->RunQuery($SQL);
				
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intOpID"] ."\">" . $row["strOperation"] ."</option>" ;
					}		  
					  
					?>  
					</select>  		    </td>
		</tr>
		<tr>
		  <td class="normalfnt">&nbsp;</td>
		  <td></td>
		  <td></td>
		  </tr>
		<tr>
			<td>&nbsp;</td>
			<td class="normalfnt">Operation  Code</td>
			<td><input style="width: 201px;" class="txtbox" type="text" id="txtOperationCode" maxlength="40"></td>              
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="normalfnt">Operation</td>
		  	<td width="326"><input style="width:201px;" class="txtbox" type="text" id="txtOperation"  maxlength="100"></td>              
		</tr>
<tr>
			  <td>&nbsp;</td>
		  	  <td class="normalfnt">Component Category</td>
			  <td><select name="select" class="txtbox" style="width: 203px;" id="cboComponentCateg" onchange="updateComCateg(this.value);">
					<option value="''" >select</option>
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
				
			  </select>			  </td>
		  </tr><tr>
			  <td>&nbsp;</td>
		  	  <td class="normalfnt">Component</td>
			  <td><select name="select" class="txtbox" style="width: 203px;" id="cboComponent">
			  <?php
			/*	$SQL="SELECT intComponentId ,strComponent FROM components ORDER BY strComponent ASC";		
				$result = $db->RunQuery($SQL);
			
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intComponentId"] ."\">" . $row["strComponent"] ."</option>" ;
				}	*/	  
				  
				?>  
				
			  </select>			  </td>
		  </tr>		<tr>
			<td>&nbsp;</td>
			<td class="normalfnt">Operation Mode</td>
			<td width="326">
				<select class="txtbox" style="width: 203px;" id="cboOperationMode">	
			        <option value="0">Machine</option>
					<option value="1">Manual</option>  
		   		</select>	      	</td>  	             
		</tr>
<tr>
			<td>&nbsp;</td>
			<td class="normalfnt">Machine</td>
			<td><select name="select" class="txtbox" style="width: 203px;" id="cboMachine" onchange="loadMachineTypes(this.value);">
						<?php
		$SQL="SELECT intMacineID ,strName FROM ws_machines ORDER BY strName ASC";		
			$result = $db->RunQuery($SQL);
			
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intMacineID"] ."\">" . $row["strName"] ."</option>" ;
		}		  
			 ?>
			</select>			</td>	
		</tr>		<tr>
			<td>&nbsp;</td>
			<td class="normalfnt">Machine Type</td>
			<td><select class="txtbox" style="width: 203px;" name="cboMachineType" id="cboMachineType">
			<?php /*
			$SQL="SELECT intMachineTypeId ,strMachineName FROM ws_machinetypes where intStatus!='0' ORDER BY strMachineName ASC";		
			$result = $db->RunQuery($SQL);
		
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intMachineTypeId"] ."\">" . $row["strMachineName"] ."</option>" ;
			}	*/	  
			  
			?>				 
			</select>			</td>	
		</tr>
		<tr>
          <td>&nbsp;</td>
		  <td class="normalfnt">SMV</td>
		  <td><input name="txtSMV" type="text" class="txtbox" id="txtSMV" style="width:100px;" onkeypress="return CheckforValidDecimal(this.value, 2,event);" onkeyup="calculateSMVandTMU('smv')"  maxlength="10" /></td>
		  </tr>
<tr>
          <td>&nbsp;</td>
		  <td class="normalfnt">TMU</td>
		  <td><input name="txtTMU" type="text" class="txtbox" id="txtTMU" style="width:100px;" onkeypress="return CheckforValidDecimal(this.value, 2,event);"  maxlength="10" onkeyup="calculateSMVandTMU('tmu')"/></td>
		  </tr>		<tr>
			<td>&nbsp;</td>
			<td><span class="normalfnt">Active</span></td>
		    <td align="left"><input name="checkbox" type="checkbox" class="chkbox"  id="chkActive" checked="checked" /></td>
		</tr>
		<tr>
				<td colspan="3" height="12" class="TitleN2white"></td>
			</tr>
			
		<tr bgcolor="#d6e7f5">
			<td colspan="3">
				<table bgcolor="#d6e7f5" width="60%" align="center">
					<tr>
						<td width="19%"><img src="../../images/new.png" name="New" onclick="ClearForm();" class="mouseover"></td>
						<td><img src="../../images/save.png" alt="Save" name="Save" onclick="saveOperation();" class="mouseover"></td>
						<td width="15%"><img src="../../images/delete.png" onclick="deleteOperation()" class="mouseover"  name="Delete" height="24"></td>       
						<td class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewOperationsReport();"/></td>
						<td width="18%"><a href="../../main.php"><img src="../../images/close.png"  id="Close" border="0"></a></td>
					</tr>
				</table>			</td>
		</tr>
		</table>
	</td>
  </tr>
</table>
</form>
</body>
</html>
