<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Layout</title>
 
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
<script src="ajaxupload.js"></script>
<script src="Operation.js"></script>
<script src="../../js/jquery-1.2.6.min.js"></script>
<script src="../../js/table_script.js"></script> 
</head>
<body>
<?php
include "../../Connector.php";
?> 
 
<div class="main_bottom_center_popup">
	<div class="main_top"><div class="main_text">Layout<span class="vol">#</span></div></div>
	<div class="main_body">
	<table align="center" width="920">
		<tr>
			<td class="normalfnt" width="100">Order No</td>
		  	<td width="213">
			<select class="txtbox" style="width: 202px;" onchange="setStyleNoInLayout(this.value);">
			<option value="0">select</option>
			<?php
			  $SQL="SELECT `intStyleId`,`strOrderNo`,`strStyle`
				FROM `orders`
				ORDER BY `orders`.`intStyleId` ASC  ";		
			$result = $db->RunQuery($SQL);	 
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
			} 	 	  
			?>
			</select>			</td> 
			<td class="normalfnt" width="78">Style No</td>
		  	<td width="509"><input style="width: 200px;" class="txtbox" type="text" id="txtStyleNo" name="txtStyleNo" readonly="readonly"></td>        
		</tr>
		<tr style="display:none">
												<td class="normalfnt" id="tdHeader">&nbsp;</td>
												<td id="tdDelete" >&nbsp;</td>
												<td class="normalfnt">&nbsp;</td>
												<td id="tdDelete2">&nbsp;</td>
		</tr>
	</table>
	<br />
	<table align="center" width="920">
		<tr>
			<td>
				<div id="divcons" class="main_border_line" style="overflow:scroll; height:150px; width:445px;">
					<table width="100%" cellpadding="0"  cellspacing="1" class="table_grid_css" id="tblLayoutOperationLeft">
						<thead>
							<tr>
								<td>No</td>
								<td>Operation</td>
								<td>Machine</td>
								<td>SMV</td>
								<td>R</td>
								<td>TGT</td>
								<td>MR</td>
								<td>EFF %</td>
								<td>Tot Tgt</td>
								<td>Nos</td>
							</tr>
						</thead>
						<tbody>
							<?php $k =90; 
							for($i=30;$i>0;$i--){
							for($j=3;$j>0;$j--){ ?>
							<tr id="<?php echo $k; ?>">
								<td><?php echo "L-".$i; ?></td>
								<td><img src="../../images/aad.png" alt="add" border="0" onclick="addOperationToLayout(this.parentNode.parentNode.rowIndex);"/>[Add]</td>
								<td><select class="txtbox" id="machine2" name="machine2">
																		<option value="0">select</option>
																		<?php
				 $SQL="	SELECT `intMachineTypeId` , `strMachineName`
						FROM `machines`
						WHERE `intStatus` =1
						ORDER BY `machines`.`intMachineTypeId` ASC ";		
				$result = $db->RunQuery($SQL);	 
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["intMachineTypeId"]."\">" .substr($row["strMachineName"],0,7)."</option>" ;
				} 		  
				?>
								</select></td>
								<td>-----</td>
								<td>--</td>
								<td>----</td>
								<td><input type="checkbox" class="chkbox"></td>
								<td>----</td>
								<td>------</td>
								<td>----</td>
							</tr>
							 <?php  $k--; } } $i=0; $j=0; $k=0;  ?>
						</tbody>
					</table>
				</div>
			</td>
			<td>
			<div id="divcons" class="main_border_line" style="overflow:scroll; height:150px; width:445px;">
				<table width="100%" cellpadding="0"  cellspacing="1" class="table_grid_css" id="tblLayoutOperationRight">
						<thead>
							<tr>
								<td>No</td>
								<td>Operation</td>
								<td>Machine</td>
								<td>SMV</td>
								<td>R</td>
								<td>TGT</td>
								<td>MR</td>
								<td>EFF %</td>
								<td>Tot Tgt</td>
								<td>Nos</td>
							</tr>
						</thead>
						<tbody>
							<?php $k =90; 
							for($i=30;$i>0;$i--){
							for($j=3;$j>0;$j--){ ?>
							<tr id="<?php echo $k; ?>">
								<td><?php echo "R-".$i; ?></td>
								<td><img src="../../images/aad.png" alt="add" border="0" onclick="addOperationToRightTableLayout(this.parentNode.parentNode.rowIndex);"/>[Add]</td>
								<td>
									 
				<select class="txtbox" id="machine" name="machine">	
				<option value="0">select</option>
				<?php
				 $SQL="	SELECT `intMachineTypeId` , `strMachineName`
						FROM `machines`
						WHERE `intStatus` =1
						ORDER BY `machines`.`intMachineTypeId` ASC ";		
				$result = $db->RunQuery($SQL);	 
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["intMachineTypeId"]."\">" .substr($row["strMachineName"],0,7)."</option>" ;
				} 		  
				?>   
				</select>
								</td>
								<td>-----</td>
								<td>--</td>
								<td>----</td>
								<td><input type="checkbox" class="chkbox"></td>
								<td>----</td>
								<td>------</td>
								<td>----</td>
							</tr>
							 <?php  $k--; } } $i=0; $j=0; $k=0; ?>
						</tbody>
					</table>
			  </div>
			</td>
		</tr>
	</table>
	<br />
	<table width="792">
		<th colspan="8"  class="normalfnt" style="text-align:left;"><b>Color Codes</b></th>
		<tr>
			<td width="23" class="normalfnt">&nbsp;</td>
			<td width="22" class="normalfnt"><img src="../../images/normal.jpg"/></td>
			<td width="50" class="normalfnt">Normal</td>
			<td width="18"><img src="../../images/yellow.jpg"/></td>
		  	<td width="200" class="normalfnt">Add Machine/Operation to Layout</td>
			<td width="20"><img src="../../images/green.jpg"/></td>
			<td width="117" class="normalfnt">Operation Overload</td>
		  	<td width="21"><img src="../../images/blue.jpg"/></td>
			<td width="281" class="normalfnt">Work Station Overload</td>
		</tr>
	</table>
	<br />
	<table width="800">
		<tr>
			<td width="36%">&nbsp;</td>
			<td width="13%"><img src="../../images/new.png" class="mouseover"></td>
			<td width="11%"><img src="../../images/save.png" alt="Save" class="mouseover"></td>
			<td width="13%"><img src="../../images/delete.png" class="mouseover" height="24"></td>
			<td width="13%"><a href="#"><img src="../../images/close.png" id="Close" border="0" onclick="CloseWindow()" ></a></td>
			<td width="14%">&nbsp;</td>
		</tr>
	</table>
	</div>
</div>
</body>
</html>
