<?php 
include "../../Connector.php"; 

$style = $_GET['style'];
$opCode = $_GET['opCode'];
$operatDesc = $_GET['operatDesc'];
$mID = $_GET['mID'];
$stitchRatioName = $_GET['stitchRatioName'];
//$machineFactor = $_GET['machineFactor'];
$totLength = $_GET['totLength'];
$actualTotLen = $_GET['actualTotLen'];
$wast2 = $_GET['wast2'];
$mId = $_GET['mId'];
?>
<script src="../../javascript/script.js"></script>
<table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblCombination">
											<tr>
												<td width="5%" style='background-color:#FBF8B3'>Serial</td>
												<td width="25%" style='background-color:#FBF8B3'>Color</td>
												<td width="15%" style='background-color:#FBF8B3'>Stitch Type</td>
												<td width="17%" style='background-color:#FBF8B3'>Thread Type</td>
												<td width="10%" style='background-color:#FBF8B3'>Machine Id</td>
												<td width="28%" style='background-color:#FBF8B3'>Operation</td>
												<td width="10%" style='background-color:#FBF8B3'>Waste (%)</td>
												<td width="9%" style='background-color:#FBF8B3'>Length(M)</td>
												<!--<th width="4%" style=" display:none;">status</th>-->
											</tr>
<?php
	   $sql_aval = "SELECT * FROM `ws_threaddetails`  
	  WHERE `strStyleId`='$style' AND `strOperationId`= '$opCode'";
	  //echo $sql_aval;
	$currentRecordSet =  $db->RunQuery($sql_aval);
	$row1 = mysql_fetch_array($currentRecordSet);
	if($row1["strStyleId"]!='')
	{
	         $sql3 = "SELECT ws_threaddetails_combination.strMachineTypeId, 

ws_threaddetails_combination.strOperationId, 

ws_threaddetails_combination.strStyleId, 

ws_threaddetails_combination.strColor,

ws_threaddetails_combination.strStitchType AS comStitch, 

ws_threaddetails_combination.dblLength_meters, 

ws_threaddetails_combination.strThreadType,

ws_threadheader.dblWastage,

ws_threaddetails_combination.intFactorNameID, 

ws_stitchtype.strStitchType, 

ws_operations.strOperationName  

FROM ws_threaddetails_combination
 
Inner Join ws_stitchtype ON ws_threaddetails_combination.strStitchType = ws_stitchtype.intID 

Inner Join ws_operations ON ws_threaddetails_combination.strOperationId = ws_operations.intId 

Inner Join ws_threadheader ON ws_threaddetails_combination.strStyleId = ws_threadheader.strStyleId
 
WHERE 
ws_threaddetails_combination.strStyleId='$style' 
AND ws_threaddetails_combination.strOperationId='$opCode' 
AND ws_threaddetails_combination.strMachineTypeId='$mID'
AND ws_threaddetails_combination.intFactorNameID = $mId
GROUP BY ws_threaddetails_combination.strStyleId,ws_threaddetails_combination.strOperationId, ws_threaddetails_combination.strMachineTypeId, 
ws_threaddetails_combination.strStitchType, ws_threaddetails_combination.strColor
Order By ws_stitchtype.strStitchType;";
$arr[]=array();
		$result3 = $db->RunQuery($sql3);
		//echo $sql3;
		$serial=0;
		while($row=mysql_fetch_array($result3))
		{
			$miniSQL="Select ws_machinefactors.dblFactor,ws_machinefactors.intSeamTypeId From ws_machinefactors Where 
						ws_machinefactors.intMachineTypeId=".$row["strMachineTypeId"]." 
						 AND ws_machinefactors.intStitchTypeId=".$row["comStitch"].
						" AND ws_machinefactors.intFactorNameID=".$row["intFactorNameID"];
						//echo $miniSQL;
			$resultminiSQL = $db->RunQuery($miniSQL);
			$rowmini=mysql_fetch_array($resultminiSQL);
			
			
		$serial++;
		$color= $row["strColor"];
		$threadID= $row["strThreadType"];
		$texID=$row["intTex"];
		$stichTypeID=$row["comStitch"];
		$arr[$serial-1]=$stichTypeID;
		$StitchTypeDesc= $row["strStitchType"];
		$machineID= $row["strMachineTypeId"];
		$operationID= $row["strOperationId"];
		$operationDesc= $row["strOperationName"];
		$ratio=$row["dblRatio"];
		$len=$row["dblLength_meters"];
		$machineFactor=$rowmini["dblFactor"];
		$wast=$row["dblWastage"];
		$dblLengthInInch=$row["dblLength_inch_with_wastage"];
		
			
		?>
		
			<tr bgcolor="#FFD2FF" id="<?php echo $serial ?>">
				<td><?php echo $serial ?></td>
				<td id="<?php echo $color ?>"><select class="txtbox" name="<?php echo "color".$serial ?>"  id="<?php echo "color".$serial ?>" style="width:125px;" >	
						<?php
		$SQL="SELECT strColor FROM colors ORDER BY strColor ASC";		
			$result = $db->RunQuery($SQL);
			
			
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
						if(trim($color,' ')==trim($row["strColor"],' ')){
							echo "<option value=\"" . $row["strColor"] ."\" selected=\"selected\" >" . $row["strColor"]."</option>";
							}
							else{
							echo "<option value=\"" . $row["strColor"] ."\">" . $row["strColor"]. "</option>";
							}
						}
			 ?>
			       </select><img src="../../images/add.png" style="vertical-align:bottom" align="bottom" onclick="addColor(this)" /></td>
				<td id="<?php echo $stichTypeID ?>"><?php echo $StitchTypeDesc ?></td>
				<td id="<?php echo $threadID ?>"><select class="txtbox"  id="<?php echo "threadID".$serial ?>" style="width:125px;">	
						<?php
		$SQL="SELECT intID,strthread FROM ws_thread ORDER BY strthread ASC";		
			$result1 = $db->RunQuery($SQL);
			
			
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result1))
						{
						if($threadID==$row["intID"]){
							echo "<option value=\"" . $row["intID"] ."\" selected=\"selected\" >" . $row["strthread"] . "</option>";
							}
							else{
							echo "<option value=\"" . $row["intID"] ."\">" . $row["strthread"] . "</option>";
							}
						}
			 ?>
			       </select></td>
				<td id="<?php echo $machineID; ?>"><?php echo $machineID; ?></td>
				<td id="<?php echo $operationID; ?>"><?php echo $operatDesc; ?></td>
				<td id="<?php echo $wast2; ?>"><?php echo $wast2; ?></td>
				<td id="<?php echo $machineFactor; ?>"><?php echo round(((($machineFactor*$totLength)*($wast2+100)/100))/39,2); ?></td>
              
				
			</tr>
            
             
				
		
		<?php
		}
		
		?>
        <?php
	
                
				$newsqlqry = "SELECT ws_stitchtype.strStitchType,ws_machinefactors.intStitchTypeId,
							  ws_machinefactors.dblFactor
						      FROM ws_stitchtype
						      Inner Join ws_machinefactors ON ws_stitchtype.intID = ws_machinefactors.intStitchTypeId
						      WHERE ws_machinefactors.intMachineTypeId = $mID
							  AND ws_machinefactors.intFactorNameID = '$mId'";
							  
				for($y=0;$y<$serial;$y++)
				{
					$sType = $arr[$y];
					$newsqlqry.=" AND ws_machinefactors.intStitchTypeId != ".$sType;
					
					//
				}
				$newsqlqry.=" Order By ws_stitchtype.strStitchType";
				$resultnewsqlqry = $db->RunQuery($newsqlqry);
				
				while($rownewsqlqry = mysql_fetch_array($resultnewsqlqry))
				{
					$mFactor = $rownewsqlqry['dblFactor'];
					$serial++;
				?>
                
                	
                    	<tr bgcolor="#FFD2FF" id="<?php echo $serial ?>">
				<td><?php echo $serial ?></td>
				<td><select class="txtbox" name="<?php echo "color".$serial ?>"  id="<?php echo "color".$serial ?>" style="width:125px;" >	
						<?php
		$SQL7="SELECT strColor FROM colors ORDER BY strColor ASC";		
			$result7 = $db->RunQuery($SQL7);
			
			
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row7 = mysql_fetch_array($result7))
						{
						
							echo "<option value=\"" . $row7["strColor"] ."\">" . $row7["strColor"]. "</option>";
							
						}
			 ?>
			       </select><img src="../../images/add.png" style="vertical-align:bottom" align="bottom" onclick="addColor(this)" /></td>
				<td id="<?php echo $rownewsqlqry['intStitchTypeId']; ?>"><?php echo $rownewsqlqry['strStitchType']; ?></td>
				<td><select class="txtbox"  id="<?php echo "threadID".$serial ?>" style="width:125px;">	
						<?php
		$SQL="SELECT intID,strthread FROM ws_thread ORDER BY strthread ASC";		
			$result1 = $db->RunQuery($SQL);
			
			
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result1))
						{
						
							echo "<option value=\"" . $row["intID"] ."\">" . $row["strthread"] . "</option>";
							
						}
			 ?>
             
			       </select></td>
				<td id="<?php echo $mID; ?>"><?php echo $mID; ?></td>
				<td id="<?php echo $opCode; ?>"><?php echo $operatDesc; ?></td>
				<td id="<?php echo $wast2; ?>"><?php echo $wast2; ?></td>
				<td id="<?php echo $mFactor; ?>"><?php echo round(((($mFactor*$totLength)*($wast2+100)/100))/39,2); ?></td>	
                    
                    </tr>	
                
                <?php
				}
                ?>
        <?php
	}
	
	
	
    
	 else  //  if not exist data*********************************
	 {
	   	    $sql3 = "SELECT 
					 ws_stitchtype.strStitchType,
					 ws_machinefactors.intStitchTypeId, 
					 ws_machinefactors.dblFactor 
					 FROM ws_machinefactors
					 Inner Join ws_stitchtype ON ws_machinefactors.intStitchTypeId= ws_stitchtype.intID 
					 WHERE ws_machinefactors.intMachineTypeId='$mID' AND
					 ws_machinefactors.intFactorNameID='$mId'
					 Order BY ws_stitchtype.strStitchType";
	
		$result3 = $db->RunQuery($sql3); //echo $sql3;
		$serial=0;
		while($row=mysql_fetch_array($result3))
		{
		$serial++;
		$color= '';
		$threadID= '';
		$texID='';
		$stichTypeID=$row["intStitchTypeId"];
		$StitchTypeDesc= $row["strStitchType"];
		$machineID= $mID;
		$operationID= $opCode;
		$operationDesc= $operatDesc;
		$ratio=$row["dblRatio"];
		$machineFactor=$row["dblFactor"];
		?>
		
			<tr>
				<td><?php echo $serial ?></td>
				<td id="<?php echo $color; ?>"><select class="txtbox" name="<?php echo "color".$serial; ?>"  id="<?php echo "color".$serial; ?>" style="width:125px;" >	
						<?php
			$SQL="SELECT strColor FROM colors ORDER BY strColor ASC";		
			$result = $db->RunQuery($SQL);
			
			
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						while($row = mysql_fetch_array($result))
						{
						if(trim($color,' ')==trim($row["strColor"],' ')){
							echo "<option value=\"" . $row["strColor"] ."\" selected=\"selected\" >" . $row["strColor"] . "</option>";
							}
							else{
							echo "<option value=\"" . $row["strColor"] ."\">" . $row["strColor"] . "</option>";
							}
						}
			 ?>
			       </select><img src="../../images/add.png" align="bottom" style="vertical-align:bottom" onclick="addColor(this)" /></td>
				<td id="<?php echo $stichTypeID; ?>"><?php echo $StitchTypeDesc; ?></td>
				<td id="<?php echo $threadID; ?>"><select class="txtbox"  id="<?php echo "threadID".$serial; ?>" style="width:150px;">	
						<?php
		$SQL="SELECT intID,strthread FROM ws_thread ORDER BY strthread ASC";		
			$result1 = $db->RunQuery($SQL);
			
			
						echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
						
						while($row = mysql_fetch_array($result1))
						{
						if($threadID==$row["intID"]){
							echo "<option value=\"" . $row["intID"] ."\" selected=\"selected\" >" . $row["strthread"] . "</option>";
							}
							else{
							echo "<option value=\"" . $row["intID"] ."\">" . $row["strthread"] . "</option>";
							}
						}
			 ?>
			       </select></td>
				<td id="<?php echo $machineID; ?>"><?php echo $machineID; ?></td>
				<td id="<?php echo $operationID; ?>"><?php echo $operatDesc; ?></td>
				<td id="<?php echo round($machineFactor*$totLength,2); ?>"><?php echo $wast2; ?></td>
				<td id="<?php echo $machineFactor; ?>"><?php echo round(((($machineFactor*$totLength)*($wast2+100)/100))/39,2); ?></td>
				
				
			</tr>
		
		<?php
		}
	 }
?> 
</table>	 
