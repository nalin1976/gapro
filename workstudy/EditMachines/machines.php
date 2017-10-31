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
	    <td class="normalfnt" ><table width="89%" align="center" class="bcgl1">
	      <tr>
	        <td class="normalfnt" width="202" style="padding-left:80px; padding-right:10px;">Search</td>
	        <td width="336"><select name="cboSearch" class="txtbox"  id="cboSearch" style="width:203px;" onchange="loadDetails();">
	          <?php
		$SQL="SELECT intMacineID ,strName FROM ws_machines ORDER BY strName ASC";		
			$result = $db->RunQuery($SQL);
			
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intMacineID"] ."\">" . $row["strName"] ."</option>" ;
		}		  
			 ?>
	          </select></td>
	        </tr>
	      <tr>
	        <td class="normalfnt" style="padding-left:80px">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr>
	        <td class="normalfnt" width="202" style="padding-left:80px">Machine Name</td>
	        <td width="336" class="normalfnt" ><input style="width:200px;" class="txtbox" id="txtMachineName" type="text" maxlength="150" />
	          &nbsp;</td>
	        </tr>
	      <tr>
	        <td class="normalfnt"></td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr>
	        <td align="center" colspan="2"><table  width="100%">
	          <tr>
	            <td width="27%">&nbsp;</td>
	            <td width="22%"><img src="../../images/new.png" onclick="clearForm();" alt="New" name="New" class="mouseover" /></td>
	            <td width="20%"><img src="../../images/save.png"  alt="Save" name="Save" onclick="saveMachine();" class="mouseover" /><a href="../../main.php"></a></td>
	            <td width="20%"><a href="../../main.php"><img src="../../images/close.png" id="Close" border="0" /></a></td>
	            <td width="11%">&nbsp;</td>
	            </tr>
	          </table>
              <br/>
	   <div id="machinegrid" style="overflow:scroll; height:150px; width:520px;">
		<table style="width:500px" id="tblmachinegrid" class="thetable" border="1" cellspacing="1">
        						<caption>Machine Details</caption>
					<thead>
                    <tr>
								<th width="53">Edit</th>
								<th width="56">Del</th>
								<th width="74">ID</th>
								<th width="294">Name</th>
						  </tr>
                    </thead>			 		
		    <tbody>
<?php
	$SQL2="SELECT intMacineID ,strName FROM ws_machines ORDER BY strName ASC";		
	$result2 = $db->RunQuery($SQL2);
	$i=1;	
	while($row2 = mysql_fetch_array($result2))
	{
?>
				<tr id="<?php echo $row2["intMacineID"] ?>" onclick="rowclickColorChangetbl(this)">
					<td><img src="../../images/edit.png" name="butEdit" class="mouseover" id="butEdit" onClick="editRowMachine('<?php echo $row2["intMacineID"] ?>','<?php echo $row2["strName"] ?>');"/></td>
					<td><img src="../../images/deletered.png" name="butDel" width="12" class="mouseover" id="butDel" onClick="deleteRowMachine('<?php echo $row2["intMacineID"] ?>');"/></td>
					<td style="padding-left:20px;"><?php echo $i; ?></td>
					<td style="padding-left:20px;"><?php echo $row2["strName"] ?></td>
					</tr>
<?php 
$i++;
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
