<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stitch Ratio</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../freelance/Button.js"></script>
<script src="../../javascript/script.js"></script>
<script src="thread_consumption.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
</head>

<body>

<?php
include "../../Connector.php";

?>
<form name="frmTreadConsump" id="frmTreadConsump" >
<table width="700" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
	</tr>
	<tr>
		<td align="center">
		<table width="700" align="center" border="0" class="bcgl1">
			<tr>
				<td bgcolor="#498CC2">
				<table align="center" border="0">
					<tr>
						<td class="TitleN2white">Stitch Ratio</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>
				<table width="386" align="center" border="0">
<tr>
						<td width="89" class="normalfnt">Machine</td>
						<td colspan="2" class="normalfnt">
							<select style="width: 172px;" class="txtbox" name="cboMachine" id="cboMachine" onchange="loadMachineTypes(this.value);">
		  <option value="">Select one</option> 
						<?php
		$SQL="SELECT intMacineID ,strName FROM ws_machines ORDER BY strName ASC";		
			$result = $db->RunQuery($SQL);
			
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intMacineID"] ."\">" . $row["strName"] ."</option>" ;
		}		  
			 ?>
							</select>
			  	  	  	</td>
					</tr>					<tr>
						<td width="89" class="normalfnt">Machine Type</td>
						<td colspan="2" class="normalfnt">
							<select style="width: 172px;" class="txtbox" name="cboMachineType" id="cboMachineType" onchange="clearGrid();">
		  <option value="">Select one</option> 
								<?php /*
								
								$SQL="	SELECT * 
								FROM ws_machinetypes m where m.intStatus=1";
								
								$result =$db->RunQuery($SQL);
								while ($row=mysql_fetch_array($result))
								{
								echo "<option value=\"".$row["intMachineTypeId"]."\">".$row["strMachineCode"]."</option>";
								}
								
								*/?>
							</select>
			  	  	  	</td>
					</tr>
					<tr>
						<td width="89" class="normalfnt">Stitch Ratio</td>
						<td width="172" class="normalfnt">
							<select style="width: 172px;" class="txtbox" name="cboStitchName" id="cboStitchName" onchange="loadStitchRatioGrid();">
		  <option value="">Select one</option> 
								<?php
								
								$SQL="	SELECT * 
								FROM ws_rationames";
								
								$result =$db->RunQuery($SQL);
								while ($row=mysql_fetch_array($result))
								{
								echo "<option value=\"".$row["id"]."\">".$row["strName"]."</option>";
								}
								
								?>
							</select>
			  	  	  	</td>
						<td width="111" class="normalfnt"><img src="../../images/add.png"  onclick="prompter()" class="mouseover"/></td>
					</tr><td width="111" class="normalfnt"></td>
					<tr>
						<td width="89" class="normalfnt">&nbsp;</td>
						<td width="172" colspan="2" class="normalfnt">&nbsp;</td>
					</tr>
					<tr>	
						<td class="normalfnt"></td>					
						<td colspan="3" class="normalfnt">&nbsp;</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td><table width="100%" border="0">
				  <tr>
				    <th width="41%" scope="col">&nbsp;</th>
				    <th width="11%" scope="col"><span class="normalfnt">Stitch Type</span></th>
				    <th width="26%" scope="col"><span class="normalfnt">
				      <select class="txtbox" name="cboStitType" id="cboStitType" style="width: 172px;" >
				        <option value="">Select one</option>
				        <?php
								
								$SQL="	SELECT * 
								FROM ws_stitchtype s";
								
								$result =$db->RunQuery($SQL);
								while ($row=mysql_fetch_array($result))
								{
								echo "<option value=\"".$row["intID"]."\">".$row["strStitchType"]."".$row["strOption"]."".$row["intLength"]."</option>";
								}
								
								?>
			        </select>
				    </span></th>
				    <th width="14%" scope="col"><span class="normalfnt"><img src="../../images/add_alone.png"  onclick="addRowToStitchRatio()" class="mouseover"/></span></th>
				    <th width="8%" scope="col">&nbsp;</th>
			      </tr>
			    </table></td>
			</tr>
			<tr>
				<td align="center">
				
					<div id="divStitchRatio" style="overflow:scroll; height:150px; width:550px;">
						<table style="width:540px" class="thetable" border="1" cellspacing="1" id="tblStitchRatio">
						<caption>
						Stitch Types 
						</caption>
							<tr>
								<th>Del</th>
								<th>No</th>
								<th>Stitch Type</th>
								<th>Ratio</th>
							</tr>			 		
							<tbody>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td bgcolor="#d6e7f5">
				<table align="center" border="0">
					<tr>
						<td>&nbsp;</td>
						<td><img src="../../images/new.png" class="mouseover" onclick="clearStitchRatioForm()" /></td>
						<td><img src="../../images/save.png" alt="Save" class="mouseover"  onclick="saveMachineStitchRatios()" /></td>
						<td><a href="../../main.php"><img src="../../images/close.png" id="Close" border="0"></a></td>
						<td>&nbsp;</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
</body>
</html>
