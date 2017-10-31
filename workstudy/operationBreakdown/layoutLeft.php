<?php 
include "../../Connector.php"; 
$styleNo = $_GET['styleNo'];

$sqlCountQuery = "	SELECT count(*) AS count
					 FROM `ws_machinesoperatorsassignment`
					 WHERE `styleNo` = '$styleNo' AND `L_R`='left' ";
		$recordCount 	= $db->RunQuery($sqlCountQuery);
		$reCount 		= mysql_fetch_array($recordCount);
		$resCount 		= $reCount['count'];
					
		$sqlQuery = "SELECT
					MP.id AS id,
					MP.styleNo AS styleNo,
					MP.L_R as L_R,
					MP.operationId AS operationId,
					MP.location AS location,
					MP.machine AS intMachineTypeId,
					MP.smv AS smv,
					MP.r AS r,
					MP.tgt AS tgt,
					MP.mr AS mr,
					MP.eff AS eff,
					MP.totTarget AS totTarget,
					MP.nos AS nos,
					MP.lineNo AS lineNo,
					OP.strOperation AS strOperation
					
					FROM
					ws_machinesoperatorsassignment AS MP
					LEFT OUTER JOIN ws_operations AS OP ON MP.operationId = OP.intOpID
					WHERE MP.styleNo = '$styleNo' AND MP.L_R ='left'
					ORDER BY MP.location ASC";
					
				//	echo $sqlQuery;
		$recordSet = $db->RunQuery($sqlQuery); 
?> 
  
		<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblLayoutOperationLeft">
						<caption></caption>
			<thead>
				<tr>
					<th>No</th>
					<th>Operation</th>
					<th>Machine</th>
					<th>SMV</th>
					<th>R</th>
					<th>TGT</th>
					<th>MR</th>
					<th>EFF %</th>
					<th>Tot Tgt</th>
					<th>Nos</th>
					<th style="display:none">-</th>
					<th style="display:none">-</th>
					<th style="display:none">-</th>
					<th style="display:none">save</th>
				</tr>
			</thead>
		<tbody>
		
		<?php 	$k =90; $n=1; 
				for($i=30;$i>0;$i--){
				for($j=3;$j>0;$j--){ 
				if((90-$n) < $resCount){ break; }
							?>
							<tr id="<?php echo $k; ?>">
								<td><?php echo "L".$i;  $machineName = "machineL".$n; ?></td>
								<td align="center"><img src="../../images/aad.png" alt="add" border="0" onClick="addOperationToLayout(this.parentNode.parentNode.rowIndex);"/></td>
								<td>
				<select class="txtbox" id="<?php echo $machineName; ?>" name="<?php echo $machineName; ?>" style="width: 70px;">
				<option value="0">select</option>
				<?php
				 $SQL="	SELECT `intMachineTypeId` , `strMachineName`
						FROM `ws_machinetypes`
						WHERE `intStatus` =1
						ORDER BY `ws_machinetypes`.`intMachineTypeId` ASC ";		
				$result = $db->RunQuery($SQL);	 
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["intMachineTypeId"]."\">" .$row["strMachineName"]."</option>" ;
				} 		  
				?>
				</select></td>
				<td>0.00</td>
				<td>0</td>
				<td>0.00</td>
				<td><input type="checkbox" class="chkbox"></td>
				<td>0.00%</td>
				<td>-</td>
				<td>-</td>
				<td style="display:none">0</td>
				<td style="display:none">left</td>
				<td style="display:none"><?php echo $n; ?></td>
				<td style="display:none" >1</td>
							</tr>
		<?php  $k--; $n++;  } }   
		
		$outerLoop = (int)($resCount/3) + 1;
		$innerLoop = $resCount%3;		 		
		while($record = mysql_fetch_array($recordSet)) {		
		if($innerLoop == 0){ $outerLoop--; $innerLoop =3; }
		?>
			<tr id="<?php echo $n; ?>">
			<td><?php echo $record['lineNo'];			
			 //echo  "L".$outerLoop;			
			$innerLoop--;			 			
			$machineName = "machineL".$n; ?></td>
			<td align="left"><img src="../../images/edit.png" height="19" width="19" alt="add" border="0" onClick="addOperationToLayout(this.parentNode.parentNode.rowIndex,20);"/>
			<?php echo $record['strOperation']; ?></td>
			<td><select class="txtbox" id="<?php echo $machineName; ?>" name="<?php echo $machineName; ?>" style="width: 70px;">
				<option value="0" >select</option>
				<?php
				$opId=$record['operationId'];
				
				 $SQL="	SELECT DISTINCT 
				 ws_machinetypes.strMachineName, 
				 ws_machinetypes.intMachineTypeId
				 FROM 
				 ws_machinetypes 
				 INNER JOIN ws_operations ON ws_machinetypes.intMachineTypeId = ws_operations.intMachineTypeId
				 WHERE ws_machinetypes.intStatus =1 AND 
				 ws_operations.intOpID =$opId";		
				$result = $db->RunQuery($SQL);	 
				while($row = mysql_fetch_array($result))
				{
					if($row["intMachineTypeId"]==$record['machine']){
						echo "<option value=\"".$row["intMachineTypeId"]."\" selected=\"selected\" >" .$row["strMachineName"]."</option>" ;
					}else{
						echo "<option value=\"".$row["intMachineTypeId"]."\">" .$row["strMachineName"]."</option>" ;
					}
				} 	 	  
				?>
				</select>		</td>
		<td><?php echo $record['smv']; ?></td>
		<td><?php echo $record['r']; ?></td>
		<td><?php echo $record['tgt']; ?></td>
		<td><input type="checkbox" class="chkbox"></td>
		<td><?php echo $record['eff']; ?></td>
		<td><?php echo $record['totTarget']; ?></td>
		<td><?php echo $record['nos']; ?></td>
		<td style="display:none"><?php echo $record['operationId']; ?></td>
		<td style="display:none">left</td>
		<td style="display:none"><?php echo $n; ?></td>
		<td style="display:none">0</td>
			</tr>
		<?php $n++; $k--; } $i=0; $j=0; $k=0; ?>
		</tbody>
	</table>
	 