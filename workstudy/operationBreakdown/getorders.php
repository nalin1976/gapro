<?php
include "../../Connector.php";
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$request=$_GET['req'];
 
 switch($request)
 {
 	case 'loadoperation': 
	{
 
		$data=$_GET['data'];
 
 		echo "<select id=\"ordercombo\" name=\"ordercombo\" class=\"txtbox\" style=\"width: 150px;\" onchange=\"updateDataGrid(this.value);  \">	
	   	 	  <option value=\"\">select</option>";  
	 
		$SQL="	SELECT `intStyleId`,`strOrderNo`
			    FROM `orders`
			    WHERE `strStyle` = '".$data."'
			    ORDER BY `orders`.`strOrderNo` ASC  ";		
		$result = $db->RunQuery($SQL);	 
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}		  
		echo "</select>"; 
				
	} break;

	case'loadgridHeader':
{
	$ResponseXML= "<header>";
	$style = trim($_GET["data"],' ');
	
	   $sql = "SELECT 
	  dblworkinghours,dblMachSMV,dblHelpSMV,strComments from ws_operationbreakdownheader WHERE strStyleID = '".$style."'";
	  
	  $result = $db->RunQuery($sql);
	  
		$k=0;
		
		 while($row = mysql_fetch_array($result))
		 {
				 $ResponseXML .= "<workingHrs><![CDATA[" . trim($row["dblworkinghours"])  . "]]></workingHrs>\n";
				 $ResponseXML .= "<comments><![CDATA[" . trim($row["strComments"])  . "]]></comments>\n";
				 $ResponseXML .= "<machineSMV><![CDATA[" . trim($row["dblMachSMV"])  . "]]></machineSMV>\n";
				 $ResponseXML .= "<helperSMV><![CDATA[" . trim($row["dblHelpSMV"])  . "]]></helperSMV>\n";
			$k++;
		 }
		 if($k==0){
				 $ResponseXML .= "<flag><![CDATA[0]]></flag>\n";
		 }
		 else{
				 $ResponseXML .= "<flag><![CDATA[1]]></flag>\n";
		 }
		 
	$ResponseXML .= "</header>";
	 echo $ResponseXML;	
	} break;
	
	
	case'loadgrid':
	{ 		
		$data=$_GET['data'];
 
		/*$SQL = "SELECT operationbreakdowndetails.intOperationID, operationbreakdowndetails.*, operationbreakdowndetails.intMachineType, operationbreakdowndetails.intSerial, 
				machines.strMachineName,components.strComponent,operations.intOpID, 
				operations.strOperation, operationbreakdowndetails.dblSMV, orders.strStyle, operationbreakdowndetails.intMachineType, operationbreakdowndetails.intStyleID 
				FROM operationbreakdowndetails
				Inner Join operations ON operations.intOpID = operationbreakdowndetails.intOperationID
				Inner Join components ON components.intComponentId = operations.intComponent
				Inner Join componentcategory ON componentcategory.intCategoryNo = components.intCategory
				Inner Join orders ON orders.intStyleId = operationbreakdowndetails.intStyleID
				Inner Join machines ON machines.intMachine = operationbreakdowndetails.intMachine
				WHERE operationbreakdowndetails.intStyleID =  '".$data."' ";*///strOrderNo			
	 	 //$ResponseXML .= "<data>";
		 
		  /*$SQL = "SELECT ws_operationbreakdowndetails.*,
		 ws_operationbreakdowndetails.intOperationID,
		  ws_operationbreakdowndetails.intMachineTypeId,
		   ws_operationbreakdowndetails.intSerial, 
				ws_machinetypes.strMachineName, 
				ws_machinetypes.intHelper, 
				components.strComponent,
				ws_operations.intOpID, 
				ws_operations.strOperation,
				 ws_operationbreakdowndetails.dblSMV, 
				 orders.strStyleID,
				  ws_operationbreakdowndetails.intMachineType, 
				  ws_operationbreakdowndetails.strStyleID, 
				  componentcategory.intCategoryNo, 
				  componentcategory.strDescription 
				FROM ws_operationbreakdowndetails
				INNER JOIN ws_operations ON ws_operations.intOpID = ws_operationbreakdowndetails.intOperationID
				INNER JOIN components ON components.intComponentId = ws_operations.intComponent
				INNER JOIN componentcategory ON componentcategory.intCategoryNo = components.intCategory
				INNER JOIN orders ON orders.strStyleID = ws_operationbreakdowndetails.strStyleID
				LEFT OUTER JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
				WHERE ws_operationbreakdowndetails.strStyleID = '".$data."'  order by intSerial ASC ";*/
		 $SQL = "	SELECT
					ws_operationbreakdowndetails.intSerial,
					ws_operationbreakdowndetails.intMachineTypeId,
					ws_operationbreakdowndetails.intOperationID,
					ws_operationbreakdowndetails.intMachineType,
					components.strComponent,
					ws_machinetypes.strMachineName,
					componentcategory.strCategory,
					components.strComponent,
					ws_operations.intId,
					ws_operations.strOperationName,
					ws_smv.dblSMV,
					ws_smv.intManual,
                    componentcategory.intCategoryNo
					FROM
					ws_operationbreakdowndetails
					left Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
					Inner Join ws_operations ON ws_operations.intId = ws_operationbreakdowndetails.intOperationID
					Inner Join componentcategory ON componentcategory.intCategoryNo = ws_operations.intCompCatId
					Inner Join components ON components.intComponentId = ws_operations.intCompId AND ws_operations.intCompCatId = components.intCategory
					Inner Join ws_smv ON ws_smv.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId AND ws_smv.intOperationId = ws_operationbreakdowndetails.intOperationID
					WHERE
					ws_operationbreakdowndetails.strStyleID =  '$data'  order by intSerial ASC";
		 $ResponseXML .= "<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable \" id=\"tblOperationSelection\">
				<caption style='background-color:#FBF8B3'>&nbsp;</caption>
				
				<tr>
				
					<th style='background-color:#FBF8B3'>Serial No</th>
					<th style='background-color:#FBF8B3'>Machine</th>
					<th style='background-color:#FBF8B3'>Category</th>
					<th style='background-color:#FBF8B3'>Components</th>
					<th style='background-color:#FBF8B3'>Opt Code</th>
					<th style='background-color:#FBF8B3'>Operations</th>
					<th style='background-color:#FBF8B3'>SMV</th>
					<th style='background-color:#FBF8B3'>Manual</th>					
					<th bgcolor=\"#498cc2\" class=\"normaltxtmidb2\" style=\"display:none\">intMachineTypeId</th>
					<th  style=\"display:none\">co</th>
					<th style=\"display:none\">cc</th>
					<th style=\"display:none\">opID</th>
					<th style=\"display:none\">i/m</th>
					<th style='background-color:#FBF8B3'># Opr</th>
					<th style='background-color:#FBF8B3'>Target 100%</th>
					<th style='background-color:#FBF8B3'>SMV (TMU)</th>					 
					<th style='background-color:#FBF8B3'>Del&nbsp;</th>
				</tr> "; //style=\"display:none\"
 
	 			//	echo $SQL;

			$result2 = $db->RunQuery($SQL);	 
			$i=0;
			while($row = mysql_fetch_array($result2))
			{	
			 	//echo $SQL;	  
				$i++;
				$target = 0;
				$target = 60/$row['dblSMV'];				
				$target = number_format($target, 2, '.', '');
				
				$smv = $row['dblSMV'];
				$tmu = 1667*$smv;
				
				$ResponseXML .= "<tr> 					
					<td align=\"center\" class=\"normalfntMid\">".$row["intSerial"]."</td>
					<td  align=\"left\" class=\"normalfntMid\">".$row["strMachineName"]."</td>
					<td  align=\"left\" class=\"normalfntMid\" id=\"".$row["intCategoryNo"]."\" >".$row["strCategory"]."</td>
					<td  align=\"left\" class=\"normalfntMid\">".$row["strComponent"]."</td>
					<td  align=\"center\" class=\"normalfntMid\">".$row['intId']."</td>
					<td  align=\"left\" class=\"normalfntMid\">".$row['strOperationName']."</td>
					<td  align=\"right\" class=\"normalfntMid\" id=\"0\"><input type='text' value='$smv' size='5'  style=\"text-align:right\" class=\"txtbox\"></td>					 
					<td  align=\"center\" class=\"normalfntMid\"><input type=\"checkbox\"";				
					if($row['intMachineType']==1) { 
					$ResponseXML .="checked=\"checked\""; }    
					$ResponseXML .= " disabled=\"disabled\"></td>					
					<td  align=\"right\" style=\"display:none\" class=\"normalfntMid\">".$row['intMachineTypeId']."</td>
					<td style=\"display:none\" class=\"normalfntMid\">".$row['component']."</td>
					<td  style=\"display:none\" class=\"normalfntMid\">".$row['comCat']."</td>
					<td style=\"display:none\" class=\"normalfntMid\">".$row['intOperationID']."</td>
					<td  style=\"display:none\" class=\"normalfntMid\">".$row['intMachineType']."</td>					
					<td  class=\"normalfntRite\">&nbsp;</td>
					<td  class=\"normalfntRite\">".round($target,0)."</td>
					<td  class=\"normalfntRite\">".round($tmu,0)."&nbsp;&nbsp;&nbsp;</td>
					<td  class=\"normalfntMid\"><img src=\"../../images/del.png\" onClick=\"deleteRowNew(this);\">&nbsp;&nbsp;</td></tr>";  
				 
			}			 
			$ResponseXML .= "</table>";
		echo $ResponseXML;
			
	} break;
	
	case 'loadComponent':{
		$data=$_GET['data'];
 
		$SQL ="	SELECT `intComponentId`,`intCategory`,`strComponent` 
				FROM `components` 
				WHERE `intCategory`='".$data."' AND `intStatus`='1' ";
		  
		$result = $db->RunQuery($SQL);	
		echo "<select id=\"component\" name=\"component\" class=\"txtbox\" style=\"width: 203px;\" onchange=\"updateOperation(this.value);\">	
	   	 	  <option value=\"\">select</option>"; 
		while($row = mysql_fetch_array($result)) {
			echo "<option value=\"". $row["intComponentId"] ."\">" . $row["strComponent"] ."</option>" ;
		}		  
		echo "</select>"; 
		
	}break;
	
	case 'loadComponentForOPer':{
		$data=$_GET['data'];
 
		$SQL ="	SELECT `intComponentId`,`intCategory`,`strComponent` 
				FROM `components` 
				WHERE `intCategory`='".$data."' AND `intStatus`='1' ";
		  
		$result = $db->RunQuery($SQL);	
		echo "<select id=\"component\" name=\"component\" class=\"txtbox\" style=\"width: 203px;\" onchange=\"updateOperationForOPerat(this.value);\">	
	   	 	  <option value=\"\">select</option>"; 
		while($row = mysql_fetch_array($result)) {
			echo "<option value=\"". $row["intComponentId"] ."\">" . $row["strComponent"] ."</option>" ;
		}		  
		echo "</select>"; 
		
	}break;
	
	case 'loadOperation':{
		$data=$_GET['data']; 
		
		if($data=='loadAll')
		{
		$SQL="SELECT `intOpID` , `strOperation`
			FROM `ws_operations`
			WHERE `intStatus` =1 ORDER BY `ws_operations`.`strOperation` ASC";
		}
		else
		{
		$SQL="SELECT `intOpID` , `strOperation`
			FROM `ws_operations`
			WHERE `intStatus` =1 AND `intComponent`= '".$data."'
			ORDER BY `ws_operations`.`strOperation` ASC";
		}
		$result = $db->RunQuery($SQL);
		echo "<select id=\"operation\" name=\"operation\" class=\"txtbox\" style=\"width: 203px;\" onchange=\"updateMachineForOperat(this.value);setSMV();\" >	
	   	 	  <option value=\"\">select</option>";  
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intOpID"] ."\">" . $row["strOperation"] ."</option>" ;
		}
		echo "</select>";	
	}break;
	
	case 'loadMachine':{
		$data=$_GET['data']; 
		
	/*	$SQL="	SELECT `intMachine` , `strMachineName`
			FROM `machines`
			WHERE `intStatus` =1 AND 
			ORDER BY `machines`.`intMachine` ASC ";*/
		if($data=='loadAll')
		{
		 $SQL = "SELECT DISTINCT 
				ws_machinetypes.strMachineName AS machineName,
				ws_machinetypes.intMachineTypeId AS machineCode
				FROM
				ws_machinetypes
				INNER JOIN ws_operations ON ws_machinetypes.intMachineTypeId = ws_operations.intMachineTypeId
				WHERE ws_machinetypes.intStatus =1";
		}
		else
		{
		$SQL = "SELECT DISTINCT 
				ws_machinetypes.strMachineName AS machineName,
				ws_machinetypes.intMachineTypeId AS machineCode
				FROM
				ws_machinetypes
				INNER JOIN ws_operations ON ws_machinetypes.intMachineTypeId = ws_operations.intMachineTypeId
				WHERE ws_machinetypes.intStatus =1 AND 
				ws_operations.intOpID = $data";	
		}
		echo "<select id=\"machine\" name=\"machine\" class=\"txtbox\" style=\"width: 203px;\" onchange=\"setSMV(this.value);\">	
	   	 	  <option value=\"\">select</option>";  		
		$result = $db->RunQuery($SQL);	 
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["machineCode"] ."\" selected=\"selected\" >" . $row["machineName"] ."</option>" ;
		}	
		echo "</select>";	
	}break;	
	
	case'loadLayoutGrid':
	{ 		
		$data=trim($_GET['data'],' ');
		$category=trim($_GET['category'],' ');

// SUMITH 2011-05-13		 
	/*	 $SQL = "SELECT
components.intCategory,
ws_operationbreakdowndetails.strStyleID,
ws_operationbreakdowndetails.intOperationID,
ws_operationbreakdowndetails.dblSMV,
ws_operations.intMachineTypeId,
ws_machinetypes.strMachineName,
ws_operations.strOperation,
componentcategory.strCategory
FROM
ws_operationbreakdowndetails
Inner Join ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID
Inner Join components ON ws_operations.intComponent = components.intComponentId
Inner Join ws_machinetypes ON ws_operationbreakdowndetails.intMachineTypeId = ws_machinetypes.intMachineTypeId
Inner Join componentcategory ON components.intCategory = componentcategory.intCategoryNo
WHERE
ws_operationbreakdowndetails.strStyleID =  '$data'
";*/

$SQL="SELECT
components.intCategory,
ws_operationbreakdowndetails.strStyleID,
ws_operationbreakdowndetails.intOperationID,
ws_operationbreakdowndetails.dblSMV,
ws_machinetypes.intMachineTypeId,
ws_machinetypes.strMachineName,
ws_operations.strOperationName,
componentcategory.strCategory
FROM
ws_operationbreakdowndetails
Inner Join ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intId
Inner Join components ON ws_operations.intCompId = components.intComponentId
Inner Join ws_machinetypes ON ws_operationbreakdowndetails.intMachineTypeId = ws_machinetypes.intMachineTypeId
Inner Join componentcategory ON components.intCategory = componentcategory.intCategoryNo
WHERE
ws_operationbreakdowndetails.strStyleID ='$data'";
	
	if($category!=''){
	 $SQL .= " AND
components.intCategory =  '$category'";
	}
	//echo $SQL;				  
		 $ResponseXML .= "<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable\" id=\"tblOperationLayoutSelection\">
				<caption style='background-color:#FBF8B3'></caption>
				<tr>
				
					<th style='background-color:#FBF8B3'></th>
					<th style='background-color:#FBF8B3'>EPF No</th>
					<th style='background-color:#FBF8B3'>Category</th>
					<th style='background-color:#FBF8B3'>Operation</th>
					<th style='background-color:#FBF8B3'>Machine</th>
					<th style='background-color:#FBF8B3'>SMV</th>
					<th style='background-color:#FBF8B3'>TGT</th>
					<th style='background-color:#FBF8B3'>Bal</th>
					<th style=\"display:none\">opID</th>
					<th style=\"display:none\">i/m</th>
				</tr> "; //style=\"display:none\"
 
	 			//	echo $SQL;

			$result2 = $db->RunQuery($SQL);	 
			$i=0;
			while($row = mysql_fetch_array($result2))
			{	
			 	//echo $SQL;	  
				$i++;
				$target = 0;
				$target = 60/$row['dblSMV'];				
				$target = number_format($target, 2, '.', '');
				
				$smv = $row['dblSMV'];
				$tmu = 1667*$smv;
				
				if($row["id"]%2==0){
				$bgColor="#CCCCCC";
				}
				else{
				$bgColor='';
				}
				
				$operation=$row['intOperationID'];
			 $sql_aval1 = "SELECT * FROM `ws_machinesoperatorsassignment` WHERE `strStyle`='$data' and `intOperation`='$operation'";
			$currentRecordSet1 =  $db->RunQuery($sql_aval1);
			$row1 = mysql_fetch_array($currentRecordSet1);
			$epfNo = $row1["intEPFNo"];
				if($epfNo==''){
				$epfNo=0;
				}
				
				$ResponseXML .= "<tr bgcolor=\"".$bgColor."\"> 					
					<td class=\"normalfntMid\"><img src=\"../../images/del.png\" onClick=\"deleteRowLayout('this.parentNode.parentNode.rowIndex','".$row['operationId']."','".$data."','".$row["strStyleID"]."');\"></td>
					<td align=\"left\" class=\"normalfntMid\"><input type='text' value='$epfNo' size='5'  style=\"text-align:right\" ></td>
					<td align=\"left\" id=\"".$row["strCategory"]."\" class=\"normalfntMid\">".$row["strCategory"]."</td>
					<td align=\"left\" id=\"".$row["intOperationID"]."\" class=\"normalfntMid\">".$row["strOperationName"]."</td>
					<td align=\"center\" class=\"normalfntMid\">".$row['strMachineName']."</td>
					<td align=\"right\" class=\"normalfntRite\">".$row['dblSMV']."</td>
					<td align=\"right\" class=\"normalfntRite\">".round((60/$row['dblSMV']),2)."</td>					 
					<td align=\"center\" style=\"display:none\" class=\"normalfntMid\">".$row['intOperationID']."</td>	
					<td align=\"center\" style=\"display:none\" class=\"normalfntMid\">".$row['intMachineTypeId']."</td>	
					<td align=\"right\" style=\"display:none\" class=\"normalfntMid\"></td>
					</tr>";  
				 
			}			 
			$ResponseXML .= "</table>";
		echo $ResponseXML;
			
	} break;
	
	case 'loadEpfNo':{
		$data=$_GET['data']; 
		
		$SQL="SELECT  MAX(id) FROM ws_machinesoperatorsassignment
			WHERE styleNo= '".$data."'";
		
				$ResponseXML .= "<data>";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
		$id=$row['MAX(id)']+1;
				$ResponseXML .= "<epfNo>$id</epfNo>\n";
		}
				$ResponseXML .= "</data>";
				echo $ResponseXML;
		
	}break;
	
	
	case'loadStyleCategoryGrid':
	{ 		
		$style=$_GET['style'];
		 
		 $SQL = "SELECT
					ws_stylecategorydetails.intCategory,
					ws_stylecategorydetails.intOperators,
					ws_stylecategorydetails.intHelpers,
					ws_stylecategorydetails.strTeams,
					componentcategory.strCategory,
					orders.strStyle,
					orders.intStyleId
					FROM
					ws_stylecategorydetails
					Inner Join componentcategory ON ws_stylecategorydetails.intCategory = componentcategory.intCategoryNo
					Inner Join orders ON ws_stylecategorydetails.strStyle = orders.intStyleId
					WHERE
					ws_stylecategorydetails.strStyle =  '$style'";
					  
		 $ResponseXML .= "<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable \" id=\"tblStyleCategory\">
				<caption style='background-color:#FBF8B3'></caption>
				
				<tr>
					<th style='background-color:#FBF8B3'>Style</th>
					<th style='background-color:#FBF8B3'>Category</th>
					<th style='background-color:#FBF8B3'>Category</th>
					<th style='background-color:#FBF8B3'>Teams</th>
					<th style='background-color:#FBF8B3'>#Operators</th>
					<th style='background-color:#FBF8B3'>#Helpers</th>
				</tr>";
 
			$result2 = $db->RunQuery($SQL);	 
			$i=0;
			while($row = mysql_fetch_array($result2))
			{	
				$i++;
				$teams=$row["strTeams"];
				$operators=$row["intOperators"];
				$helpers=$row['intHelpers'];
				
				$ResponseXML .= "<tr id=\"0\"> 					
					<td align=\"center\" class=\"normalfntMid\" id=".$row["intStyleId"].">".$row["strStyle"]."</td>
					<td  align=\"center\" class=\"normalfntMid\" id=\"".$row["intCategory"]."\">".$row["strCategory"]."</td>
					<td  align=\"center\" class=\"normalfntRite\" onclick=\"setInputBox(this.parentNode.rowIndex,2);\">".$row["strTeams"]." </td>
					<td  align=\"center\" class=\"normalfntRite\" onclick=\"setInputBox(this.parentNode.rowIndex,3);\">".$row["intOperators"]." </td>
					<td  align=\"center\" class=\"normalfntRite\" onclick=\"setInputBox(this.parentNode.rowIndex,4);\">".$row['intHelpers']." </td>
					</tr>";  
				 
			}			 
			$ResponseXML .= "</table>";
		echo $ResponseXML;
			
	} break;
	
	case'loadStyleCategoryDet':
	{ 		
		$style=$_GET['style'];
		$category=$_GET['category'];
		 
		$SQL = "SELECT
ws_stylecategorydetails.intOperators,
ws_stylecategorydetails.intHelpers,
ws_stylecategorydetails.strTeams
FROM
ws_stylecategorydetails
WHERE
ws_stylecategorydetails.strStyle =  '$style' AND
ws_stylecategorydetails.intCategory =  '$category'
";
					  
		 $ResponseXML .= "<details>";
 
			$result2 = $db->RunQuery($SQL);	 
			$i=0;
			while($row = mysql_fetch_array($result2))
			{	
				$i++;
					$ResponseXML .= "<operators><![CDATA[" . trim($row["intOperators"])  . "]]></operators>\n";
					$ResponseXML .= "<teams><![CDATA[" . trim($row["intHelpers"])  . "]]></teams>\n";
					$ResponseXML .= "<helpers><![CDATA[" . trim($row["strTeams"])  . "]]></helpers>\n";
			}	
			
			if($i==0){
				$ResponseXML .= "<strTag>0</strTag>\n";
			}
			else{
				$ResponseXML .= "<strTag>1</strTag>\n";
			}		 
			$ResponseXML .= "</details>";
		echo $ResponseXML;
			
	} break;
	
}

?>
