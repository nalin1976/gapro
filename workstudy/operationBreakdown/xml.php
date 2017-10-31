<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
//--------------------------------------------------------------------
switch($RequestType){

	case "saveDet": 
		{
			$styleNo 			= $_GET["styleNo"];
			//$orderNo 			= $_GET["orderNo"];
			$machineSMV 		= $_GET["machineSMV"];
			$comments 			= $_GET["comments"];
			$lineSMV 			= $_GET["lineSMV"];
			$helperSMV 			= $_GET["helperSMV"];
			$totalSMV 			= $_GET['totalSMV'];
			$workHours 			= $_GET['workHours'];
		//	$operators 			= $_GET['operators'];
		//	$operators 			= $_GET['operators'];
		//	$helpers 			= $_GET['helpers'];
			if($helpers==''){
			$helpers=0;
			}
			
		//	$teams 		= $_GET['teams'];
			$totalOutputHr 		= $_GET['totalOutputHr'];
			
				
			$table_rows 		= $_GET['table_rows'];
			$ArraySerial 		= $_GET['ArraySerial'];
			$ArrayMachine 		= $_GET['ArrayMachine'];
			$ArrayComponents 	= $_GET['ArrayComponents'];
			$ArrayOptCode 		= $_GET['ArrayOptCode'];
			$ArrayOperations 	= $_GET['ArrayOperations'];
			$ArraySMV 			= $_GET['ArraySMV'];
			$ArrayManual 		= $_GET['ArrayManual'];

			$explodeSerial 		= explode(',',$ArraySerial);
			$explodeMachine 	= explode(',',$ArrayMachine);
			$explodeComponents 	= explode(',',$ArrayComponents);
			$explodeOptCode 	= explode(',',$ArrayOptCode);
			$explodeOperations 	= explode(',',$ArrayOperations);
			$explodeSMV 		= explode(',',$ArraySMV);
			$explodeManual 		= explode(',',$ArrayManual);
			$user=$_SESSION["UserID"];
			//opDate=date();
	
			$SQL="DELETE FROM `ws_operationbreakdowndetails` 
											WHERE `strStyleID`='$styleNo'";
			$db->ExecuteQuery($SQL);
		
			if($table_rows>0) {
				for($i=0; $i< $table_rows-1; $i++) {
						
						 $sql_save2 = "INSERT INTO `ws_operationbreakdowndetails`(`strStyleID`,`intOperationID`,`intSerial`,`dblSMV`,`intMachineType`,`intMachineTypeId`,`dblLength`) 
						VALUES ('$styleNo', '$explodeOperations[$i]', '$explodeSerial[$i]', '$explodeSMV[$i]', '$explodeManual[$i]', '$explodeMachine[$i]', '0')";
						//echo $sql_save2."----------";
						$res=$db->RunQuery($sql_save2);
				}
			}
			
			//Check the current style number related record availability	
			$sql_aval = "SELECT * FROM `ws_operationbreakdownheader` WHERE `strStyleID`='$styleNo'";
			
			$currentRecordSet =  $db->RunQuery($sql_aval);
			
			$row = mysql_fetch_array($currentRecordSet);
	 		
			$exist = $row["strStyleID"];
			
			if($exist != '') { 
								
				$sql_save = "UPDATE `ws_operationbreakdownheader` 
							SET `dblHelpSMV` = '".$helperSMV."',  `dblMachSMV` = '".$machineSMV."',  `strComments` = '".$comments."',  `intUserID` = '".$user."',  `dblworkinghours` = '".$workHours."',  `intOperators` = '0',  `intHelpers` = '0',  `strTeams` = '0',  `dtmDate` = now()  
							WHERE `strStyleID` ='".$styleNo."' ";
				
				$res=$db->RunQuery($sql_save);				
			
			}else {
			
				 $sql_save = "INSERT INTO `ws_operationbreakdownheader` (
							`strStyleID` ,
							`dblMachSMV` ,
							`dblHelpSMV` ,
							`strComments` ,
							`dblOutPutPerHr` ,
							`dblworkinghours` ,
							`intOperators` ,
							`intHelpers` ,
							`dblMachineOutPutPerHr` ,
							`intReqMO` ,
							`intReqHelp` ,
							`intUserID` , 
							`dtmDate` ,
							`strTeams` ,
							`intStatus`)					
							VALUES ('$styleNo', '$machineSMV', '$helperSMV', '$comments', '0', '$workHours', '0', '0', '0', '0', '0', '$user', now(), '0', '1')";
				
				$res=$db->RunQuery($sql_save);
			
			} 
		 	//$ResponseXML .= "<SaveDetail>$sql_save2</SaveDetail>\n";
			if($res!=""){
				
				$ResponseXML .= "<SaveDetail>True</SaveDetail>\n";			
			}else{
				
				$ResponseXML .= "<SaveDetail>False</SaveDetail>\n";				
			}			
			echo $ResponseXML;
			
		}break;
	
		case 'setSMV':  {
				$ResponseXML .= "<data>";
				
				$styleNo 	= $_GET['styleNo'];
				$operation 	= $_GET['operation'];
				$component  = $_GET['component'];								
				/*$sql_aval 	= "	SELECT *
								FROM `operationbreakdowndetails`
								WHERE `intStyleID` = '$styleNo'
								AND `intOperationID` = '$operation'";*/
				$sql_aval 			= "	SELECT ws_operations.intMachineTypeId,ws_operations.dblSMV,ws_operations.intMachineType ,ws_machinetypes.intMachineId
										FROM ws_operations inner join ws_machinetypes on ws_operations.intMachineTypeId=ws_machinetypes.intMachineTypeId
										WHERE intComponent = '$component' AND intOpID = '$operation'  ";
					 
				$currentRecordSet 	= '';
				$row 				= '';
				$currentRecordSet 	=  $db->RunQuery($sql_aval);
								
				$row 				= mysql_fetch_array($currentRecordSet);
				$numberOfRows 		= sizeof($row);
				$smv 				= $row['dblSMV'];
				$intMachineTypeId			= $row['intMachineTypeId'];
				$intMachineType			= $row['intMachineType'];
				$intMachineId			= $row['intMachineId'];
				
				if($smv==""){
				$smv=0;
				}
				//echo "Size of Row - ".$sizeofrows;
				$ResponseXML .= "<intMachineType>$intMachineType</intMachineType>\n";
				$ResponseXML .= "<intMachine>$intMachineId</intMachine>\n";
				$ResponseXML .= "<SaveDetail>$smv</SaveDetail>\n";
				$ResponseXML .= "</data>";
				echo $ResponseXML;
								 
		}break;
		
	case 'checkOpDetailAvailability': {
		$styleNo 		= $_GET['styleNo'];
		$operationID 	= $_GET['operationID'];		 
		
		$sql_aval 		= "SELECT * 
						FROM `ws_operationbreakdowndetails` 
						WHERE `strStyleID`='$styleNo' AND `intOperationID`= '$operationID'";
						 
		$currentRecordSet 	= '';
		$row 				= '';
		$existing 			= '';
		$currentRecordSet 	=  $db->RunQuery($sql_aval);						
		$row 				= mysql_fetch_array($currentRecordSet);
		$numberOfRows 		= sizeof($row);
		//echo "Size of Row - ".$sizeofrows;
		$ResponseXML .= "<SaveDetail>$numberOfRows</SaveDetail>\n";
		echo $ResponseXML;
					
	}break;
	
	case 'loadHeaderData': {				 
						 
				$styleNo 			= $_GET['styleNo'];
				$sql_aval 			= "	SELECT ws_operationbreakdownheader.strComments AS strComments, orders.strStyleId
										FROM  orders 
										LEFT OUTER JOIN ws_operationbreakdownheader 
										ON orders.strStyleId = ws_operationbreakdownheader.strStyleID
										WHERE orders.strStyleId = '".$styleNo."'";			 								
				//$sql_aval 			= "	SELECT * FROM `operationbreakdownheader` WHERE `intStyleID` = '".$styleNo."'";	 
				$currentRecordSet 	= '';
				$row 				= '';
				try{
					$currentRecordSet 	= $db->RunQuery($sql_aval);								
					$row 				= mysql_fetch_array($currentRecordSet);
				}catch(Exception $e){
				
				}
				$numberOfRows 		= sizeof($row);
				if($numberOfRows>1){
					$comment 		= $row['strComments'];
				}else {
					$comment  		= "";
				}
				 
				$ResponseXML .= "<SaveDetail>$comment</SaveDetail>\n";
				echo $ResponseXML;		
		  
	}break;
	
	case 'removeRecord': {
		$styleNo 			= $_GET['styleNo'];
		$operationID 		= $_GET['operationID'];	
		$machineType 		= $_GET['machineType'];	
		$smv 		= $_GET['smv'];	
		
		$sql_aval 			= "SELECT * 
							   FROM `ws_operationbreakdowndetails` 
							   WHERE `strStyleID`='$styleNo' AND `intOperationID`= '$operationID'";
						 
		$currentRecordSet 	= '';
		$row 				= '';
		$existing 			= '';
		$currentRecordSet 	=  $db->RunQuery($sql_aval);						
		$row 				= mysql_fetch_array($currentRecordSet);
		$numberOfRows 		= sizeof($row);
		
		if($numberOfRows>1){
			$sql = "DELETE FROM `ws_operationbreakdowndetails` 
					WHERE `strStyleID` = '$styleNo' 
					AND `intOperationID` = '$operationID'";
			$res = $db->RunQuery($sql);
			//-------update header for smv----------
			if($machineType==1){
			 echo $sqlup = "UPDATE `ws_operationbreakdownheader` 
						SET  `dblHelpSMV` = dblHelpSMV-'$smv' 
						 WHERE `strStyleID` = '$styleNo'";
			}
			else{
			 echo $sqlup = "UPDATE `ws_operationbreakdownheader` 
						SET  `dblMachSMV` = dblMachSMV-'$smv' 
						 WHERE `strStyleID` = '$styleNo'";
			}
						
			$resup=$db->RunQuery($sqlup);	  
				
			//-------delete frm layout----------
			 $sql1 = "DELETE FROM `ws_machinesoperatorsassignment` 
					WHERE `strStyle`='$styleNo' AND `intOperation`= '$operationID'";
			$res1 = $db->RunQuery($sql1);
			//--------delete from thread-------
			$sql2 = "DELETE FROM `ws_threadconsumption` 
					WHERE `strStyleID`='$styleNo' AND `intOPID`= '$operationID' AND `id`= '$id' LIMIT 1";
			$res2 = $db->RunQuery($sql2);

			$sql3 = "DELETE FROM `ws_threadconsumptiondetails` 
					WHERE `strStyleID`='$styleNo' AND `intOpeartionID`= '$operationID' AND `id`= '$id' LIMIT 1";
			$res3 = $db->RunQuery($sql3);
			//---------------
					
			/*$sql1 = "DELETE FROM `ws_operationbreakdowndetails` 
					 WHERE `ws_operationbreakdowndetails`.`strStyleID` = 34 
					 AND `ws_operationbreakdowndetails`.`intOperationID` = 5 LIMIT 1";*/		
			
			if($res){
				$ResponseXML .= "<SaveDetail>true</SaveDetail>\n";
			}else{
				$ResponseXML .= "<SaveDetail>false</SaveDetail>\n";
			}
		}else{			 
			$ResponseXML .= "<SaveDetail>false</SaveDetail>\n";
		}
		echo $ResponseXML;
					
	}break;
	
	case 'removeAllRecord': {
	
	$styleNo 			= $_GET['styleNo'];
	$componentCateg 		= $_GET['componentCateg'];		 
		
		$sql_aval 			= "SELECT
ws_operationbreakdowndetails.intOperationID
FROM
ws_operationbreakdowndetails
Inner Join ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID
Inner Join components ON ws_operations.intComponent = components.intComponentId
WHERE
ws_operationbreakdowndetails.strStyleID =  '$styleNo' AND
components.intCategory =  '$componentCateg'";

			$result2 = $db->RunQuery($sql_aval);	 
			while($row = mysql_fetch_array($result2))
			{	
			$operation=$row['intOperationID'];
		
			$sql1 = "DELETE FROM `ws_operationbreakdowndetails` 
					 WHERE `ws_operationbreakdowndetails`.`strStyleID` = '$styleNo'
					 AND `ws_operationbreakdowndetails`.`intOperationID` = '$operation'";		
			$res = $db->RunQuery($sql1);
			}
			
			if($res){
				$ResponseXML .= "<deleteDetail>true</deleteDetail>\n";
			}else{
				$ResponseXML .= "<deleteDetail>false</deleteDetail>\n";
			}
		echo $ResponseXML;
					
	}break;
	
	case 'removeRecordLayout': {
		$styleNo 			= $_GET['styleNo'];
		$operationID 		= $_GET['operationID'];		
		$id 		= $_GET['id'];		
		
		$sql_aval 			= "SELECT * 
							   FROM `ws_machinesoperatorsassignment` 
							   WHERE `strStyle`='$styleNo' AND `intOperation`= '$operationID' AND `id`= '$id'";
						 
		$currentRecordSet 	= '';
		$row 				= '';
		$existing 			= '';
		$currentRecordSet 	=  $db->RunQuery($sql_aval);						
		$row 				= mysql_fetch_array($currentRecordSet);
		$numberOfRows 		= sizeof($row);
		
		if($numberOfRows>1){

			$sql = "DELETE FROM `ws_machinesoperatorsassignment` 
					WHERE `strStyle `='$styleNo' AND `intOperation`= '$operationID' AND `id`= '$id' LIMIT 1";

			$res = $db->RunQuery($sql);
			
			
			if($res){
				$ResponseXML .= "<SaveDetail>true</SaveDetail>\n";
			}else{
				$ResponseXML .= "<SaveDetail>false</SaveDetail>\n";
			}
		}else{			 
			$ResponseXML .= "<SaveDetail>false</SaveDetail>\n";
		}
		echo $ResponseXML;
					
	}break;
	
	
	case 'layoutData':	{
	
		$styleNo 		= $_GET['styleNo'];
		$operationId 	= $_GET['operationId'];
		 				
		$sql = "SELECT
				ws_operations.strOperation AS operation,
				ws_operationbreakdowndetails.intOperationID AS operationId,
				ws_machinetypes.strMachineName AS machineName,
				ws_operationbreakdowndetails.dblSMV AS smv,
				ws_operationbreakdowndetails.intMachineTypeId AS machineCode
				FROM ws_operationbreakdowndetails
				LEFT OUTER JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
				INNER JOIN ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID
				WHERE ws_machinetypes.intStatus =1 AND ws_operations.intStatus =1 AND 
				ws_operationbreakdowndetails.strStyleID = '$styleNo' AND
				ws_operationbreakdowndetails.intOperationID = '$operationId'";
				
				//echo $sql;
		  		
		$result = $db->RunQuery($sql);
		$ResponseXML = "<data>\n";
		while($row=mysql_fetch_array($result))
		{
		$ResponseXML .= "<operation><![CDATA[" . trim($row["operation"]) . "]]></operation>\n"; 
		$ResponseXML .= "<operationId><![CDATA[" . trim($row["operationId"]) . "]]></operationId>\n"; 		
		$ResponseXML .= "<machine><![CDATA[" . trim($row["machineName"]) . "]]></machine>\n"; 
		$ResponseXML .= "<machineId><![CDATA[" . trim($row["machineCode"]) . "]]></machineId>\n"; 
		$ResponseXML .= "<smv><![CDATA[" . trim($row["smv"]) . "]]></smv>\n";								 		}
		$ResponseXML .= "</data>\n";
		echo $ResponseXML;
		
	}break; 
	
	case 'loadSMV':	{
	
		$styleNo 		= $_GET['style'];
		$operationId 	= $_GET['operation'];
		$machine 	= $_GET['machine'];
		 				
		$sql = "SELECT
				ws_operationbreakdowndetails.intOperationID AS operationId,
				ws_machinetypes.strMachineName AS machineName,
				ws_operationbreakdowndetails.dblSMV AS smv,
				ws_operationbreakdowndetails.intMachineTypeId AS machineCode
				FROM ws_operationbreakdowndetails
				LEFT OUTER JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
				WHERE
				ws_operationbreakdowndetails.strStyleID = '$styleNo' AND
				ws_operationbreakdowndetails.intOperationID = '$operationId' AND
				ws_machinetypes.intMachineTypeId = '$machine'";
				//echo $sql;
		  		
		$result = $db->RunQuery($sql);
		$ResponseXML = "<data>\n";
		while($row=mysql_fetch_array($result))
		{
		$ResponseXML .= "<smv><![CDATA[" . trim($row["smv"]) . "]]></smv>\n";								 		}
		$ResponseXML .= "</data>\n";
		echo $ResponseXML;
		
	}break; 
	
	
	
	case 'listOfMachine': {
		$sql = "SELECT ws_machinetypes.intMachineTypeId AS `code`,ws_machinetypes.strMachineName AS `name`
				FROM ws_machinetypes 
				WHERE ws_machinetypes.intStatus = 1 ";	
		$result = $db->RunQuery($sql);		
		$ResponseXML ="<xmlDet>";		
		while($row=mysql_fetch_array($result))
		{		
			$ResponseXML .= "<text><![CDATA[" . trim($row["name"])  . "]]></text>\n";
			$ResponseXML .= "<value><![CDATA[" . trim($row["code"])  . "]]></value>\n";			 
		}
		$ResponseXML .="</xmlDet>";
		echo $ResponseXML;
	
	} break; 
	
	
	case "saveLayoutData": 
		{
			$style 			= trim($_GET["style"],' ');			
			$ArrayOperations 	= $_GET["ArrayOperations"];
			$ArrayEPFNo			= $_GET["ArrayEPFNo"];
			
			$explodeOperations 	= explode(',',$ArrayOperations);
			$explodeEPFNo 		= explode(',',$ArrayEPFNo);	
			
			for($i=0; $i< sizeof($explodeOperations)-1; $i++) {
				
				  $sql_aval = "SELECT * FROM `ws_machinesoperatorsassignment` 
							 WHERE `strStyle` = '$style'
							  AND `intOperation` = '$explodeOperations[$i]' 
							 ";
				
				$currentRecordSet 	= '';
				$row 				= '';
				$existing 			= '';
				$currentRecordSet 	= $db->RunQuery($sql_aval);
				$row 			= mysql_fetch_array($currentRecordSet);
				$sizeofrows 	= sizeof($row);				 
				$existing 		= $row["strStyle"];
		
				if($existing!=''){
					
					 $sql_save2 = "UPDATE `ws_machinesoperatorsassignment` 
								SET  `intEPFNo` = '$explodeEPFNo[$i]' 
								 WHERE `strStyle` = '$style' AND 
								 `intOperation` = '$explodeOperations[$i]'";
								
					$res=$db->RunQuery($sql_save2);	  
				
				}else{ 
				
					 $sql_save2 = " INSERT INTO `ws_machinesoperatorsassignment`(`strStyle`,`intOperation`,`intEPFNo` ,`dblDate` )
					VALUES ('$style','$explodeOperations[$i]', '$explodeEPFNo[$i]',now())";					
					$res=$db->RunQuery($sql_save2); 
				}
			}						 
		 	//$ResponseXML .= "<SaveDetail>$sql_save2</SaveDetail>\n";
			 if($res!=""){				
				$ResponseXML .= "<SaveDetail>True</SaveDetail>\n";			
			}else{				
				$ResponseXML .= "<SaveDetail>False</SaveDetail>\n";				
			}	 	
			echo $ResponseXML;			
		}break;
		
		
		case "loadLayoutGrid":	{
		
			$styleId 	= $_GET['styId'];
			$side 		= $_GET['side'];
			
			$ResponseXML .="<xmlDet>";			 
			$sql_query ="SELECT `id`,`styleNo`,`L_R`,`operationId`,`location`,`intMachineTypeId`,`smv`,`r`,`tgt`,`mr`,`eff`,`totTarget`,`nos`
						 FROM `ws_machinesoperatorsassignment`
						 WHERE `styleNo` = '$styleId' AND `L_R`='$side' ";
			$result = $db->RunQuery($sql_query);
	 
			if(mysql_num_rows($result)==0)
			{
				$ResponseXML .= "<strTag>0</strTag>\n";
			}else{ 
				$ResponseXML .= "<strTag>1</strTag>\n";
				while($row=mysql_fetch_array($result))
				{				
					$ResponseXML .= "<id><![CDATA[" . trim($row["id"])  . "]]></id>\n";
					$ResponseXML .= "<styleNo><![CDATA[" . trim($row["styleNo"])  . "]]></styleNo>\n";
					$ResponseXML .= "<L_R><![CDATA[" . trim($row["L_R"])  . "]]></L_R>\n";
					$ResponseXML .= "<operationId><![CDATA[" . trim($row["operationId"])  . "]]></operationId>\n";
					$ResponseXML .= "<location><![CDATA[" .trim($row["location"]) . "]]></location>\n";
					$ResponseXML .= "<machine><![CDATA[" . trim($row["machine"])  . "]]></machine>\n";
					$ResponseXML .= "<smv><![CDATA[" . trim($row["smv"])  . "]]></smv>\n";
					$ResponseXML .= "<r><![CDATA[" . trim($row["r"])  . "]]></r>\n";
					$ResponseXML .= "<tgt><![CDATA[" . trim($row["tgt"])  . "]]></tgt>\n";
					$ResponseXML .= "<mr><![CDATA[" . trim($row["mr"])  . "]]></mr>\n";
					$ResponseXML .= "<eff><![CDATA[" . trim($row["eff"])  . "]]></eff>\n";
					$ResponseXML .= "<totTarget><![CDATA[" . trim($row["totTarget"])  . "]]></totTarget>\n";
					$ResponseXML .= "<nos><![CDATA[" . trim($row["nos"])  . "]]></nos>\n";
				}
			}		
			$ResponseXML .="</xmlDet>";
			echo $ResponseXML;
		} break;
		
		case "recordAvailable":	{
		   
			$styleId 	= $_GET['styleId'];
			$side 		= $_GET['side'];
			$rowId 		= $_GET['rowId'];			
			
			$ResponseXML .="<xmlDet>";			 
			$sql_query 	="SELECT *
						 FROM `ws_machinesoperatorsassignment`
						 WHERE `styleNo` = '$styleId' AND `L_R`='$side' AND `location`= '$rowId' ";
			$result = $db->RunQuery($sql_query);
			
			if(mysql_num_rows($result)==0) {
				$ResponseXML .= "<strTag>0</strTag>\n";
			}else{
				$ResponseXML .= "<strTag>1</strTag>\n";
			}			 	
			$ResponseXML .="</xmlDet>";
			echo $ResponseXML;
		} break;
		
		case 'styleRegisterdForReport': {
			$styleId 	= trim($_GET['styleId'],' ');
			 			
			
			$ResponseXML .="<xmlDet>";			 
			$sql_query 	="SELECT *
						 FROM `ws_machinesoperatorsassignment`
						 WHERE `strStyle` = '$styleId' ";
			$result = $db->RunQuery($sql_query);
			
			if(mysql_num_rows($result)==0) {
				$ResponseXML .= "<strTag>0</strTag>\n";
			}else{
				$ResponseXML .= "<strTag>1</strTag>\n";
			}			 	
			$ResponseXML .="</xmlDet>";
			echo $ResponseXML;
		} break;
	
case 'loadOperatorHelperTeam': {
	$style = trim($_GET["style"],' ');
	$category = $_GET["category"];
			$ResponseXML .="<xmlDet>";			 
			 $sql_query 	="SELECT *
						 FROM `ws_stylecategorydetails`
						 WHERE `strStyle` = '$style' and `intCategory` = '$category' ";
			$result = $db->RunQuery($sql_query);
			
			if(mysql_num_rows($result)==0) {
				$ResponseXML .= "<result>0</result>\n";
			}else{
				$ResponseXML .= "<result>1</result>\n";
				while($row=mysql_fetch_array($result))
				{				
				$ResponseXML .= "<teams><![CDATA[" . trim($row["strTeams"])  . "]]></teams>\n";
				$ResponseXML .= "<operators><![CDATA[" . trim($row["intOperators"])  . "]]></operators>\n";
				$ResponseXML .= "<helpers><![CDATA[" . trim($row["intHelpers"])  . "]]></helpers>\n";
				}
			}			 	
			$ResponseXML .="</xmlDet>";
			echo $ResponseXML;
			
		} break;
		
/*		case "SaveStyleCategoryDetails":	{
		   
	$ArrayStyle = $_GET["ArrayStyle"];
	$ArrayCategory = $_GET["ArrayCategory"];
	$ArrayTeam = $_GET["ArrayTeam"];
	$ArrayOperators = $_GET["ArrayOperators"];
	$ArrayHelpers = $_GET["ArrayHelpers"];
	
	$explodStyle = explode(',', $ArrayStyle) ;
	$explodCategory = explode(',', $ArrayCategory) ;
	$explodeTeam = explode(',', $ArrayTeam) ;
	$explodeOperators = explode(',', $ArrayOperators) ;
	$explodeHelpers = explode(',', $ArrayHelpers) ;
	
	$serial=$_GET["serial"];
	
	$noOfChecked = $serial-1;
			
			$sql = "DELETE FROM `ws_stylecategorydetails` 
					WHERE `strStyle`='$explodStyle[0]'";
			$res1=$db->RunQuery($sql);
			
			$ResponseXML .="<xmlDet>";	
					 
			for ($i = 0;$i < $noOfChecked;$i++)
			{
 $sql_save="INSERT INTO 
					ws_stylecategorydetails(strStyle,intCategory,intOperators,intHelpers,strTeams)
					VALUE
					('$explodStyle[$i]','$explodCategory[$i]','$explodeOperators[$i]','$explodeHelpers[$i]','$explodeTeam[$i]')";	
		$res=$db->RunQuery($sql_save);
			}
			
			if(mysql_num_rows($res)==0) {
				$ResponseXML .= "<strTag>0</strTag>\n";
			}else{
				$ResponseXML .= "<strTag>1</strTag>\n";
			}			 	
			$ResponseXML .="</xmlDet>";
			echo $ResponseXML;
		} break;*/
		
		case "deleteCategory":	{
			
			$style = $_GET["styleNo"];
			$category = $_GET["category"];
			
			$ResponseXML .="<xmlDet>";	
			
			echo $sql = "DELETE FROM `ws_stylecategorydetails` 
					WHERE `strStyle`='$style' and `intCategory`='$category' ";
			$res1=$db->RunQuery($sql);
			
			if(mysql_num_rows($res1)==0) {
				$ResponseXML .= "<strTag>0</strTag>\n";
			}else{
				$ResponseXML .= "<strTag>1</strTag>\n";
			}			 	
			$ResponseXML .="</xmlDet>";
			echo $ResponseXML;
		} break;
		
		case "deleteStyle":	{
			
			$style = trim($_GET["styleNo"],' ');
			
			$ResponseXML .="<xmlDet>";	
			
			echo $sql = "DELETE FROM `ws_operationbreakdownheader` 
					WHERE `strStyleID`='$style'";
			$res1=$db->RunQuery($sql);
			
			if(mysql_num_rows($res1)==0) {
				$ResponseXML .= "<strTag>0</strTag>\n";
			}else{
				$ResponseXML .= "<strTag>1</strTag>\n";
			}			 	
			$ResponseXML .="</xmlDet>";
			echo $ResponseXML;
		} break;
 }
 
 //   2011-05-05
 // *********************************SaveStyleCategoryDetails *****************************************
 
 if($RequestType=='SaveStyleCategoryDetails')
 {
	   
	$ArrayStyle     = $_GET["ArrayStyle"];
	$ArrayCategory  = $_GET["ArrayCategory"];
	$ArrayTeam      = $_GET["ArrayTeam"];
	$ArrayOperators = $_GET["ArrayOperators"];
	$ArrayHelpers   = $_GET["ArrayHelpers"];
	
	$explodStyle    = explode(',', $ArrayStyle) ;
	$explodCategory = explode(',', $ArrayCategory) ;
	$explodeTeam    = explode(',', $ArrayTeam) ;
	$explodeOperators = explode(',', $ArrayOperators) ;
	$explodeHelpers = explode(',', $ArrayHelpers) ;
	
	$serial =  $_GET["serial"];
	$styleNo =  $_GET["styleNo"];
	
	$noOfChecked = $serial-1;

			$sql = "DELETE FROM `ws_stylecategorydetails` WHERE `strStyle`='$explodStyle[0]'";
			$res1=$db->RunQuery($sql);
			
			$ResponseXML .="<xmlDet>";	
					 
			for ($i = 0;$i < $noOfChecked;$i++)
			{
             /*$sql_check="SELECT
						componentcategory.intCategoryNo
						FROM
					ws_operationbreakdowndetails
					Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
					Inner Join ws_operations ON ws_operations.intId = ws_operationbreakdowndetails.intOperationID
					Inner Join componentcategory ON componentcategory.intCategoryNo = ws_operations.intCompCatId
					Inner Join components ON components.intComponentId = ws_operations.intCompId AND ws_operations.intCompCatId = components.intCategory
					Inner Join ws_smv ON ws_smv.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId AND ws_smv.intOperationId = ws_operationbreakdowndetails.intOperationID
WHERE
ws_operationbreakdowndetails.strStyleID = '$styleNo' AND
componentcategory.intCategoryNo = '$explodCategory[$i]'
order by intSerial ASC";
			 $result_check=$db->RunQuery($sql_check);
			 while($row_check = mysql_fetch_array($result_check))
			 {
				$intCategoryNo = $row_check['intCategoryNo']; //-------------------------------
			 } */
			  //if($intCategoryNo =='')
			 // {
			  
				  $sql_save="INSERT INTO 
						ws_stylecategorydetails(strStyle,intCategory,intOperators,intHelpers,strTeams)
						VALUE
						('$explodStyle[$i]','$explodCategory[$i]','$explodeOperators[$i]','$explodeHelpers[$i]','$explodeTeam[$i]')";	
			$res=$db->RunQuery($sql_save);
				}
				
				if(mysql_num_rows($res)==0) {
					$ResponseXML .= "<strTag>0</strTag>\n";
				}else{
					$ResponseXML .= "<strTag>1</strTag>\n";
				}			 	
				$ResponseXML .="</xmlDet>";
				echo $ResponseXML;
			//}   // end of the check if statement
		} 
 
 //sumith harshan 2011-05-05
 //deleteStyleCategoryRow from the DB 
 if($RequestType=='deleteStyleCategoryRow')
 {
	$styleNo      = $_GET["styleNo"];
	$intCategory  = $_GET["intCategory"];
	
	$sql_delete = "DELETE FROM `ws_stylecategorydetails` WHERE `strStyle`='$styleNo' AND intCategory='$intCategory'";
	$res1=$db->RunQuery($sql_delete);
	 
 }
 
 //-----------------------------------------------------------------------------
 
 if($RequestType=='loadOperation'){
 
 $oprationId   = $_GET["oprationId"];

 		$sql = "SELECT
						ws_operations.strOperationCode,
						ws_operations.strOperationName,
						intStatus
						FROM
						ws_operations
						WHERE
						intId = '$oprationId'";	
		$result = $db->RunQuery($sql);		
		$ResponseXML ="<xmlDet>";		
		while($row=mysql_fetch_array($result))
		{		
			$ResponseXML .= "<Code><![CDATA[" . trim($row["strOperationCode"])  . "]]></Code>\n";
			$ResponseXML .= "<Name><![CDATA[" . trim($row["strOperationName"])  . "]]></Name>\n";
			$ResponseXML .= "<Status><![CDATA[" . trim($row["intStatus"])  . "]]></Status>\n";			 
		}
		$ResponseXML .="</xmlDet>";
		echo $ResponseXML;
 }

//---------------------------------------------------------------------------------

 if($RequestType=='loadMachine'){
 
 $machineId   = $_GET["machineId"];

 		$sql = "SELECT
				ws_machinetypes.strMachineName,
				ws_machinetypes.strMachineCode,
				intStatus
				FROM
				ws_machinetypes where intMachineTypeId='$machineId'";	
		$result = $db->RunQuery($sql);		
		$ResponseXML ="<xmlDet>";		
		while($row=mysql_fetch_array($result))
		{		
			$ResponseXML .= "<MCode><![CDATA[" . trim($row["strMachineCode"])  . "]]></MCode>\n";
			$ResponseXML .= "<MName><![CDATA[" . trim($row["strMachineName"])  . "]]></MName>\n";
			$ResponseXML .= "<MStatus><![CDATA[" . trim($row["intStatus"])  . "]]></MStatus>\n";			 
		}
		$ResponseXML .="</xmlDet>";
		echo $ResponseXML;
 } 
//----------------------------Edit by Badra 01/07/2012-------------------------------------------------
if($RequestType=='loadComponents')
{
	$categoryid = $_GET["categoryid"];
	$processid = $_GET["processid"];
	
	$str = "select 	intComponentId, 
					intCategory, 
					strComponent, 
					components.strDescription,
					ws_processes.strProcess,
					ws_processes.intProcessId	 
					from 
					components left join ws_processes on components.intStatus=ws_processes.intProcessId";
					
				if($categoryid != '' and $processid != ''){
				$str.= "  where intCategory='$categoryid' and ws_processes.intProcessId='$processid' and intStatus!=0";
				}	
				else if($categoryid != ''){
				$str.= "  where intCategory='$categoryid' and intStatus!=0";
				}
				else if($processid != ''){
				$str.= "  where ws_processes.intProcessId='$processid' and intStatus!=0";
				}
    $XMLString= "<Data>";
	$XMLString .= "<Componentz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<ComponentId><![CDATA[" . $row["intComponentId"]  . "]]></ComponentId>\n";
		$XMLString .= "<Category><![CDATA[" . $row["intCategory"]  . "]]></Category>\n";
		$XMLString .= "<Component><![CDATA[" . $row["strComponent"]  . "]]></Component>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]   . "]]></Description>\n";	
		$XMLString .= "<Process><![CDATA[" . $row["strProcess"]   . "]]></Process>\n";	
		$XMLString .= "<ProcessId><![CDATA[" . $row["intProcessId"]   . "]]></ProcessId>\n";		
	}
	
	$XMLString .= "</Componentz>";
	$XMLString .= "</Data>";
	echo $XMLString;
} 
 if ($RequestType =='get_process')
{
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	$catid=$_GET['catid'];
	
	
	$str="select intProcessId,strProcess,strDescription from ws_processes where  intProcessId='$catid' order by intProcessId ASC";
	
	
	$XMLString .= "<Pro>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<Processes><![CDATA[" . $row["strProcess"]  . "]]></Processes>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
	}
	
	$XMLString .= "</Pro>";
	echo $XMLString;
}
if ($RequestType=='get_category')
{
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	$categoryid=$_GET['categoryid'];
	
	
	$str="select 	intCategoryNo, strCategory,strDescription
					from 
					componentcategory 
					where  intCategoryNo='$categoryid'";
	
	
	$XMLString= "<Data>";
	$XMLString .= "<Componentz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<CategoryNo><![CDATA[" . $row["intCategoryNo"]  . "]]></CategoryNo>\n";
		$XMLString .= "<Category><![CDATA[" . $row["strCategory"]  . "]]></Category>\n";
		$XMLString .= "<CatDescription><![CDATA[" . $row["strDescription"]  . "]]></CatDescription>\n";
	}
	
	$XMLString .= "</Componentz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}
?>