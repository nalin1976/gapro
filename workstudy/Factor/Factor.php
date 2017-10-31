<?php
$backwardseperator = "../../";
session_start();

$machineID = $_POST['cboMachine'];
$stitchID  = $_POST['cboStitchType'];
$seamID    = $_POST['cboSeamType'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Factor</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="factor-js.js"></script>
<script src="../../javascript/script.js"></script>
</head>
<body>
<?php include "../../Connector.php"; ?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Factor<span id="banks_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmMachineFacors" name="frmMachineFacors" method="post" action="Factor.php">
<table width="700" border="0" align="center" bgcolor="#FFFFFF">
   <tr>
	<td>
		<table width="70%" align="center" border="0"  class="bcgl1">
			<tr>
				<td class="normalfnt" width="124">&nbsp;</td>
				  <td class="normalfnt" width="114">Machine</td>
				  <td colspan="2">
						<select class="txtbox" id="cboMachine" name="cboMachine" style="width: 203px;" onchange="submitPage();">	
						<?php
		$SQL="SELECT intMachineTypeId ,strMachineName FROM ws_machinetypes ORDER BY strMachineName ASC";		
			$result = $db->RunQuery($SQL);
			
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
		while($row = mysql_fetch_array($result))
		{
			if($row["intMachineTypeId"]==$machineID)
			{
				echo "<option selected value=\"". $row["intMachineTypeId"] ."\">" . $row["strMachineName"] ."</option>" ;
			}
			
			else
			{
				echo "<option  value=\"". $row["intMachineTypeId"] ."\">" . $row["strMachineName"] ."</option>" ;
			}
		}		  
			 ?>
						</select>
				  </td>
			</tr>
			<tr>
				<td class="normalfnt" width="124">&nbsp;</td>
				<td class="normalfnt" width="114">Stitch Type</td>
				<td width="210">
					<select style="width: 203px;" class="txtbox" name="cboStitchType" id="cboStitchType" onchange="">
		  
								<?php
				$SQL="SELECT intID ,strStitchType FROM ws_stitchtype ORDER BY strStitchType ASC";		
				$result = $db->RunQuery($SQL);
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					if($row["intID"]==$stitchID)
					{	
						echo "<option selected value=\"". $row["intID"] ."\">" . $row["strStitchType"] ."</option>" ;
					}
					else
					{
						echo "<option  value=\"". $row["intID"] ."\">" . $row["strStitchType"] ."</option>" ;
					}
				}		  
				  
								?>
				  </select>
	  	  	  	</td>
				<td class="normalfnt" width="193">&nbsp;</td>
			</tr>
<tr>
				<td class="normalfnt" width="124">&nbsp;</td>
				<td class="normalfnt" width="114">Seam Type</td>
				<td width="210">
					<select style="width: 203px;" class="txtbox" name="cboSeamType" id="cboSeamType"  onchange="">
		 
								<?php
								
								$SQL="	SELECT * 
								FROM ws_seamtype";
								echo "<option value=\"". "" ."\">" . "" ."</option>" ;
								$result =$db->RunQuery($SQL);
								while ($row=mysql_fetch_array($result))
								{
									if($row["intId"]==$seamID)
									{
										echo "<option selected value=\"".$row["intId"]."\">".$row["strName"]."</option>";
									}
									else
									{
										echo "<option  value=\"".$row["intId"]."\">".$row["strName"]."</option>";
									}
								}
								
								?>
				  </select>
	  	  	  	</td>
				<td class="normalfnt" width="193">&nbsp;</td>
		  </tr>			<tr>
				<td class="normalfnt" width="124">&nbsp;</td>
				<td class="normalfnt" width="114">Length Per Inch</td>
			  	<td colspan="2"><input type="text" id="txtLength" name="txtLength" class="txtbox" style="width:201px;" maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
			</tr>
		<tr>
			<td align="center" colspan="4">
	  <table  width="100%">		
						<tr>
							<td width="22%">&nbsp;</td>
							<td width="77%"><img src="../../images/new.png" onclick="clearForm();" alt="New" name="New" class="mouseover"><img src="../../images/save.png"  alt="Save" name="Save" onclick="saveMachineFactors();" class="mouseover"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewMachinesFactorReport();"  /><a href="../../main.php"><img src="../../images/close.png" id="Close" border="0"></a></td>
							<td width="1%">&nbsp;</td>
						</tr>
                        <tr>
                        <td colspan="2">
                        
                        <div id="machinegrid" style="overflow:scroll; height:250px; width:690px;">
		<table width="100%" id="tblmachinegrid" class="thetable" border="1" cellspacing="1">
        						<caption>Factor Details</caption>
					<thead>
                    <tr>
								
								<th width="53">Edit</th>
                                <th width="56">Del</th>
								<th width="60">ID</th>
								<th width="294">Machine Name</th>
                                <th width="294">Stitch Type</th>
                                <th width="294">Seam Type</th>
                                <th width="90">Length Per Inch</th>
						  </tr>
                    </thead>			 		
		    <tbody>
<?php
	$SQL2="SELECT
			ws_machinefactors.intId,
			ws_machinefactors.dblFactor,
			ws_machinefactors.intMachineTypeId,
			ws_machinefactors.intStitchTypeId,
			ws_machinefactors.intSeamTypeId,
			ws_machinetypes.strMachineName,
			ws_seamtype.strName,
			ws_stitchtype.strStitchType
			FROM
			ws_machinefactors
			Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_machinefactors.intMachineTypeId
			Inner Join ws_seamtype ON ws_machinefactors.intSeamTypeId = ws_seamtype.intId
			Inner Join ws_stitchtype ON ws_machinefactors.intStitchTypeId = ws_stitchtype.intID WHERE 1=1";
			
			if($machineID!="")
				$SQL2.=" AND ws_machinefactors.intMachineTypeId=$machineID";
				
			
				
					
	$result2 = $db->RunQuery($SQL2);
	$i=1;	
	while($row2 = mysql_fetch_array($result2))
	{
?>
				<tr id="<?php echo $row2["intId"] ?>" onclick="rowclickColorChangetbl(this)">
					<td><img src="../../images/edit.png" name="butEdit" class="mouseover" id="butEdit" onClick="editRowMachine(this);"/></td>
					<td><img src="../../images/deletered.png" name="butDel" width="12" class="mouseover" id="butDel" onClick="deleteRowMachine('<?php echo $row2["intId"] ?>');"/></td>
					<td style="padding-left:20px;"><?php echo $i; ?></td>
					<td id="<?php echo $row2["intMachineTypeId"] ?>" style="padding-left:20px;"><?php echo $row2["strMachineName"] ?></td>
                    <td id="<?php echo $row2["intStitchTypeId"] ?>" style="padding-left:20px;"><?php echo $row2["strStitchType"] ?></td>
                    <td id="<?php echo $row2["intSeamTypeId"] ?>" style="padding-left:20px;"><?php echo $row2["strName"] ?></td>
                    <td style="padding-left:20px;"><?php echo $row2["dblFactor"] ?></td>
					</tr>
<?php 
$i++;
}
?>
			</tbody>
		</table>
	 </div>
                        </td>
                        </tr>
                        </table></td></tr>
                        
                        
		</table>
        
        
	</td>
   </tr>
</table>
</form>
</div>
</div>
</body>
</html>
