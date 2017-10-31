<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Machines</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="machines-js.js"></script>
<script src="../../javascript/script.js"></script>
<script src="../../js/jquery-1.3.2.min.js"></script>




</head>

<body onload="rowclickColorChangetbl(this)">

<?php
include "../../Connector.php";

?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Machines<span id="banks_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmmachines" name="frmmachines" method="post" action="">

<table width="500" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
	<td><table width="66%" align="center" class="bcgl1">
	  <tr>
	    <td class="normalfnt" ><table width="101%" align="center" class="bcgl1">
	      <tr>
	        <td class="normalfnt" width="226" style="padding-left:80px; padding-right:10px;"> Search</td>
	        <td width="378"><select name="cboMachines" class="txtbox"  id="cboMachines" style="width:203px;" onchange="loadDetails()">
	          <?php
		$SQL="SELECT 
				ws_machinetypes.strMachineName,
				ws_machinetypes.intMachineTypeId 
			FROM  ws_machinetypes  ORDER BY strMachineName ASC";		
			$result = $db->RunQuery($SQL);
			
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intMachineTypeId"] ."\">" . $row["strMachineName"] ."</option>" ;
		}		  
			 ?>
	          </select></td>
	        </tr>
	      <tr>
	        <td class="normalfnt" width="226" style="padding-left:80px">Machine  Code</td>
	        <td width="378"><input style="width: 200px;" class="txtbox" type="text" id="txtMachineCode" maxlength="100" /></td>
	        </tr>
	      <tr>
	        <td class="normalfnt" width="226" style="padding-left:80px">Machine Name</td>
	        <td width="378" class="normalfnt" ><input style="width:200px;" class="txtbox" id="txtMachine" type="text" maxlength="150" />
	        </tr>
	      <tr>
	        <td class="normalfnt" style="padding-left:80px">Active</td>
	        <td><input type="checkbox" checked="checked" id="chkActive"  class="chkbox" /></td>
	        </tr>
	      <tr>
	        <td class="normalfnt"></td>
	        <td></td>
	        </tr>
	      <tr>
	        <td align="center" colspan="2"><table width="100%">
	          <tr>
	            <td align="center"><img src="../../images/new.png" onclick="clearForm();" alt="New" name="New" class="mouseover" /><img src="../../images/save.png"  alt="Save" name="Save" onclick="saveMachine();" class="mouseover" /><a href="../../main.php"><img src="../../images/close.png" id="Close" border="0" /></a></td>
	            </tr>
	          </table>
              <br/>
	   <div id="machinegrid" style="overflow:scroll; height:150px; width:520px;">
		<table style="width:500px" id="tblmachinegrid" class="thetable" border="1" cellspacing="1">
        						<caption>Machine Details</caption>
					<thead>
                    <tr>
								<th width="26">Edit</th>
								<th width="34">Del</th>
								<th width="108">Machine Code</th>
								<th width="122">Machine Name</th>
                                <th width="43">Active</th>
					</tr>
                    </thead>			 		
		    <tbody>
<?php
	$SQL2="SELECT 
				ws_machinetypes.intStatus,
				ws_machinetypes.strMachineCode,
				ws_machinetypes.strMachineName,
				ws_machinetypes.intMachineTypeId 
			FROM  ws_machinetypes  ORDER BY strMachineName ASC";		
	$result2 = $db->RunQuery($SQL2);	
	while($row2 = mysql_fetch_array($result2))
	{
?>
				<tr id="<?php echo $row2["intMachineTypeId"] ?>" onclick="rowclickColorChangetbl(this)">
					<td><img src="../../images/edit.png" name="butEdit" class="mouseover" id="butEdit" onClick="editRowMachine('<?php echo $row2["intMachineTypeId"] ?>','<?php echo $row2["strMachineCode"] ?>','<?php echo $row2["strMachineName"] ?>','<?php echo $row2["intStatus"] ?>');"/></td>
					<td><img src="../../images/deletered.png" name="butDel" width="12" class="mouseover" id="butDel" onClick="deleteRowMachine('<?php echo $row2["intMachineTypeId"] ?>');"/></td>

					<td><?php echo $row2["strMachineCode"] ?></td>
					<td><?php echo $row2["strMachineName"] ?></td>
                    <td>
                    <?php 
					if($row2["intStatus"]==0)
					  echo "<input type=\"checkbox\"  disabled=\"disabled\" class=\"txtbox\" />";
					else 
					  echo "<input type=\"checkbox\"  checked=\"checked\" disabled=\"disabled\" class=\"txtbox\" />";  
					?> 
                    
                    </td>
				</tr>
<?php 
}
?>
			</tbody>
		</table>
	 </div>
	          <p>&nbsp;</p></td>

	      </table></td>
	    </tr>
	</table></td>
	</tr>
	</table>
</form>
</body>
</html>
