<?php 
include "../../Connector.php"; 

$componentCatog = $_GET['componentCateg'];
$styleNo = $_GET['styleNo'];


	/*	$SQL = "SELECT ws_operationbreakdowndetails.*, 
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
				WHERE ws_operationbreakdowndetails.strStyleID = '".$styleNo."' order by componentcategory.intCategoryNo,intSerial ASC ";	*/
									
	 	 	  
		 echo "<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable\" id=\"tblOperationSelection1\">
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
				echo "<tr id=\"".$i."\"  bgcolor=\"#FFCCFF\"> 
					<td align=\"center\"  bgcolor=\"#FFCCFF\" class=\"normalfntMid\"  id=\"".$row["intCategoryNo"]."\">".$i."</td>
					<td  bgcolor=\"#FFCCFF\" align=\"left\" class=\"normalfntMid\">".$row["strMachineName"]."</td>
					<td  bgcolor=\"#FFCCFF\" align=\"left\" class=\"normalfntMid\" id=\"".$row["intCategoryNo"]."\" >".$row["strDescription"]."</td>
					<td  bgcolor=\"#FFCCFF\" align=\"left\" class=\"normalfntMid\">".$row["strComponent"]."</td>
					<td  bgcolor=\"#FFCCFF\" align=\"center\" class=\"normalfntMid\">".$row['intOpID']."</td>
					<td  bgcolor=\"#FFCCFF\" align=\"left\" class=\"normalfntMid\">".$row['strOperation']."</td>
					<td  bgcolor=\"#FFCCFF\" align=\"right\" class=\"normalfntMid\">".$smv."</td>
					<td  bgcolor=\"#FFCCFF\" align=\"center\" class=\"normalfntMid\"><input type=\"checkbox\"";				
				if($row['intMachineType']==1)
				{ 					
					echo "checked=\"checked\""; 
				}   
				echo " disabled=\"disabled\" > </td>
					<td  bgcolor=\"#FFCCFF\" align=\"right\" style=\"display:none\" class=\"normalfntMid\" >".$row['intMachineTypeId']."</td>
					<td  bgcolor=\"#FFCCFF\" style=\"display:none\"  class=\"normalfntMid\">".$row['component']."</td>
					<td  bgcolor=\"#FFCCFF\" style=\"display:none\" class=\"normalfntMid\" >".$row['comCat']."</td>
					<td  bgcolor=\"#FFCCFF\" style=\"display:none\"  class=\"normalfntMid\">".$row['intOperationID']."</td>
					<td  bgcolor=\"#FFCCFF\" style=\"display:none\" class=\"normalfntMid\" >".$row['intMachineType']."</td>
					<td bgcolor=\"#FFCCFF\" class=\"normalfntMid\">&nbsp;</td>
					<td  bgcolor=\"#FFCCFF\" class=\"normalfntMid\">".$target."</td>
					<td  bgcolor=\"#FFCCFF\" class=\"normalfntMid\">".$tmu."</td>
					<td  bgcolor=\"#FFCCFF\" class=\"normalfntMid\"><img src=\"../../images/del.png\" onClick=\"deleteRow1('this.parentNode.parentNode.rowIndex','".$row['intOperationID']."','".$data."');\"></td>
					</tr>";  //style=\"display:none\"			
				//".$i.",".$row['intOperationID'].",".$data.");  echo "class=\"chkbox\"></td>				
			}			 
		//	echo "</table>";		*/  
		 ?>






<?php
	    $sql3 = "SELECT
ws_machinetypes.strMachineCode,
components.strComponent,
ws_operations.intOpID,
ws_operations.strOperation,
ws_operations.dblSMV,
ws_operations.intMachineType,
ws_machinetypes.intMachineTypeId,
components.intComponentId,
componentcategory.intCategoryNo, 
componentcategory.strDescription  
FROM
ws_operations
Inner Join ws_machinetypes ON ws_operations.intMachineTypeId = ws_machinetypes.intMachineTypeId
Inner Join components ON ws_operations.intComponent = components.intComponentId
Inner Join componentcategory ON components.intCategory = componentcategory.intCategoryNo
WHERE
componentcategory.intCategoryNo =  '$componentCatog'
ORDER BY
ws_operations.strOperation ASC
;";

		$result3 = $db->RunQuery($sql3);
		$serial=$i;
		while($row=mysql_fetch_array($result3))
		{
		$serial++;
		$machineDesc= $row["strMachineCode"];
		$categoryDesc= $row["strDescription"];
		$componentDesc=$row["strComponent"];
		$operationDesc=$row["strOperation"];
		$operationID= $row["intOpID"];
		$machineType=$row["intMachineType"];
		$smv= $row["dblSMV"];
		$manual= 0;
		$machineID= $row["intMachineTypeId"];
		$componentID=$row["intComponentId"];
		$catogeryID=$row["intCategoryNo"];
		//$operationID= $row["strStitchType"];
		$manualStatus 	= 0;
		//$smv= $row["intMachineID"];
		$target=round(60/$smv,2);
		$tmu=round(1667*$smv,2);
		//$image;
		?>
		
				<tr>
					<td align="center" class="normalfntMid"><?php echo $serial ?></td>
					<td align="left" class="normalfntMid"><?php echo $machineDesc ?></td>
					<td id="<?php echo $catogeryID ?>" align="left" class="normalfntMid"><?php echo $categoryDesc ?></td>
					<td align="left" class="normalfntMid"><?php echo $componentDesc ?></td>
					<td align="center" class="normalfntMid"><?php echo $operationID ?></td>
					<td align="left" class="normalfntMid"><?php echo $operationDesc ?></td>
					<td align="right" class="normalfntMid" id="1"><?php echo $smv ?></td>
					<td align="center" class="normalfntMid"><input type="checkbox" disabled="disabled"<?php if($machineType==1){?> checked="checked"  <?php } ?>></td>
					<td style="display:none" align="right" class="normalfntMid"><?php echo $machineID ?></td>
					<td style="display:none" align="right" class="normalfntMid"><?php echo $componentID ?></td>
					<td style="display:none" align="right" class="normalfntMid"><?php echo $catogeryID ?></td>
					<td style="display:none" align="right" class="normalfntMid"><?php echo $operationID ?></td>
					<td style="display:none" align="right" class="normalfntMid"><?php echo $machineType ?></td>
					<td align="right" class="normalfntMid"></td>
					<td align="right" class="normalfntMid"><?php echo $target ?></td>
					<td align="right" class="normalfntMid"><?php echo $tmu ?></td>
					<td><img src="../../images/del.png"  onClick="deleteNonDbRecord(this.parentNode.parentNode.rowIndex,this);"></td>
				</tr>
		
		<?php
		}
?> 
