<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 

$RequestType = $_GET["RequestType"];

//****************************************************LOAD Main Grid***********************************************************
if($RequestType=="loadGrid")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styId=trim($_GET['styId'],' ');
	
	$ResponseXML .="<xmlDet>";
		

			   $sql="SELECT

ws_operationbreakdowndetails.intSerial,
ws_operationbreakdowndetails.intMachineType,
ws_operationbreakdowndetails.intOperationID,
ws_operations.strOperationName,
ws_operations.strOperationCode,
componentcategory.strCategory,
ws_operationbreakdowndetails.intMachineTypeId,
ws_machinetypes.strMachineName,
ws_machinetypes.strMachineCode
FROM
ws_operationbreakdowndetails
INNER JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
INNER JOIN ws_operations ON ws_operations.intId = ws_operationbreakdowndetails.intOperationID
INNER JOIN componentcategory ON componentcategory.intCategoryNo = ws_operations.intCompCatId
INNER JOIN components ON components.intComponentId = ws_operations.intCompId AND ws_operations.intCompCatId = components.intCategory
INNER JOIN ws_smv ON ws_smv.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId AND ws_smv.intOperationId = ws_operationbreakdowndetails.intOperationID

WHERE
					ws_operationbreakdowndetails.strStyleID =  '$styId' AND  ws_machinetypes.intHelper !=1 
order by intSerial ASC";
			

		       // echo $sql;
	$result = $db->RunQuery($sql);
	//echo $sql;
	if(mysql_num_rows($result)==0)
	{
		$ResponseXML .= "<strTag>0</strTag>\n";
	}
	while($row=mysql_fetch_array($result))
	{
	if(trim($row["dblOpt_length_inch"])==""){
	$length=0;
	}
	else{
	$length=trim($row["dblOpt_length_inch"]);
	}
		$ResponseXML .= "<serial><![CDATA[" . trim($row["intSerial"])  . "]]></serial>\n";
		$ResponseXML .= "<machineID><![CDATA[" . trim($row["intMachineTypeId"])  . "]]></machineID>\n";
		$ResponseXML .= "<machineDesc><![CDATA[" . trim($row["strMachineName"])  . "]]></machineDesc>\n";
		$ResponseXML .= "<opID><![CDATA[" . trim($row["intOperationID"])  . "]]></opID>\n";
		$ResponseXML .= "<opCode><![CDATA[" . trim($row["strOperationCode"])  . "]]></opCode>\n";
		$ResponseXML .= "<strOperat><![CDATA[" . trim($row["strOperationName"])  . "]]></strOperat>\n";
		$ResponseXML .= "<length><![CDATA[" . $length  . "]]></length>\n";
		$ResponseXML .= "<comCatogory><![CDATA[" . trim($row["strCategory"])  . "]]></comCatogory>\n";
		$ResponseXML .= "<srtMachine><![CDATA[" . trim($row["intMachineTypeId"])  . "]]></srtMachine>\n";
		
 $sql1= "select ws_threaddetails.dblOpt_length_inch from ws_threaddetails where ws_threaddetails.strStyleId = '$styId' AND ws_threaddetails.strOperationId='". $row["intOperationID"]."'";
	$res3= $db->RunQuery($sql1);
	$row1 = mysql_fetch_array($res3);
		$ResponseXML .= "<MachineRatio><![CDATA[" . trim($row1["dblOpt_length_inch"])  . "]]></MachineRatio>\n";
		
 
		
	}
	$sqlwast1="SELECT dblWastage FROM ws_threadheader WHERE strStyleId='$styId'";
$reswast1= $db->RunQuery($sqlwast1);
$rowwast1 = mysql_fetch_array($reswast1);
		$ResponseXML .= "<dblWastage><![CDATA[" . trim($rowwast1["dblWastage"])  . "]]></dblWastage>\n";

	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
//--------------------------------------------------------------------
if($RequestType=="Save")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ArraySerial = $_GET["ArraySerial"];
	$ArrayStyle = $_GET["ArrayStyle"];
	$ArrayOpId = $_GET["ArrayOpId"];
	$ArrayMacineID = $_GET["ArrayMacineID"];
	$ArrayLength = $_GET["ArrayLength"];
	
	$explodeSerial= explode(',', $ArraySerial) ;
	$explodStyle = explode(',', $ArrayStyle) ;
	$explodeOpId = explode(',', $ArrayOpId) ;
	$explodeMachID = explode(',', $ArrayMacineID) ;
	$explodeLength = explode(',', $ArrayLength) ;
	
	$noOfChecked = count($explodeSerial)-1;
	
		for ($i = 0;$i < $noOfChecked;$i++)
		{
	   $sql= "select * from ws_threadconsumption where intSerialNo ='".$explodeSerial[$i]."' AND strStyleID= '".$explodStyle[$i]."'";
	 $res3= $db->RunQuery($sql);
	$row = mysql_fetch_array($res3);
	$exist = $row["intSerialNo"];
	
	if($exist==""){	
		   $sql_save="INSERT INTO 
					ws_threadconsumption(intSerialNo,strStyleID,intOPID,intMachineTypeId,dblLength)
					VALUE
					('$explodeSerial[$i]','$explodStyle[$i]','$explodeOpId[$i]','$explodeMachID[$i]','$explodeLength[$i]')";	
					//echo $sql_save;
		$res=$db->RunQuery($sql_save);
		}
		else{
       $sql= "UPDATE ws_threadconsumption SET dblLength=$explodeLength[$i] WHERE intSerialNo = '". $explodeSerial[$i]."' AND strStyleID= '".$explodStyle[$i]."'";
	
		$res2=$db->RunQuery($sql);
		}
		
	}
		
	 if($res!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[True]]></SaveDetail>\n";
	 }
	 else if($res2!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[UpdateTrue]]></SaveDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveDetail><![CDATA[False]]></SaveDetail>\n";
	 }
	 
	 echo $ResponseXML;
}
//--------------------------------------------------------------------
if($RequestType=="SaveCombinations")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style = $_GET["style"];
	$mId = $_GET["mId"];
	$opID = $_GET["opID"];
	$machineId = $_GET["machineId"];
	$stitchRatio = $_GET["stitchRatio"];
	$serial = $_GET['serial'];
	$totLength = $_GET['totLength'];
	$HeadWast = $_GET['HeadWast'];
	$lengthDetail = $_GET['lengthDetail'];

	$ArrayLength = $_GET["ArrayLength"];
	$ArrayStitch = $_GET["ArrayStitch"];
	$ArrayTex = $_GET["ArrayTex"];
	$ArrayThread = $_GET["ArrayThread"];
	$ArrayColor = $_GET["ArrayColor"];
	$ArrayMFactor = $_GET["ArrayMFactor"];
	$ArrayWast = $_GET["ArrayWast"];
	$ArrayLengthInches = $_GET["ArrayLengthInches"];
	$ArrayHeaderLength = $_GET["ArrayHeaderLength"];
	
	$explodeLength= explode(',', $ArrayLength) ;
	$explodStitch = explode(',', $ArrayStitch) ;
	$explodeTex = explode(',', $ArrayTex) ;
	$explodeThread = explode(',', $ArrayThread) ;
	$explodeColor = explode(',', $ArrayColor) ;
	$explodeMFactor = explode(',', $ArrayMFactor) ;
	$explodeWast = explode(',', $ArrayWast) ;
	$explodeLengthInInch = explode(',', $ArrayLengthInches) ;
	
	 $noOfChecked = count($explodeLength)-1;
	 
	  //----save header------------------------------
	   /*$sql= "select * from ws_threadheader where strStyleId ='$serial'";
	 $res3= $db->RunQuery($sql);
	$row = mysql_fetch_array($res3);
	$exist = $row["strStyleId"];*/
	
		   $sql_saveHeader ="INSERT INTO 
					         ws_threadheader(strStyleId,dblWastage)
					         VALUES('$style',$HeadWast)";	
					//echo $sql_save;
		   $res = $db->RunQuery($sql_saveHeader);
		   
		   if(!$res)
		   {
			   $sql_saveHeaderUpdate = "UPDATE ws_threadheader SET dblWastage=$HeadWast WHERE strStyleId='$style'";
			   $res1=$db->RunQuery($sql_saveHeaderUpdate);
		   }
		  
		   $sql_saveDetail ="INSERT INTO 
					         ws_threaddetails(strStyleId,strMachineTypeId,strOperationId,dblOpt_length_inch)
					         VALUES('$style','$machineId','$opID',$lengthDetail)";	
					//echo $sql_save;
		   
		   $res2 = $db->RunQuery($sql_saveDetail);
		   
		   if(!$res2)
		   {
			   $sql_saveDetailUpdate = "UPDATE ws_threaddetails SET dblOpt_length_inch=$lengthDetail 
			   							WHERE strStyleId='$style'
			   							AND strOperationId='$opID'";
										
			   $res3=$db->RunQuery($sql_saveDetailUpdate);
		   }
		   
		   
		
	 //------------------------------
	 	$sqlDELETE = "Delete From ws_threaddetails_combination
		  				Where strStyleId='$style'   
						AND strOperationId= '$opID' ";
						
		$db->RunQuery($sqlDELETE);
	 
		for ($i = 0;$i < $noOfChecked;$i++)
		{
		
		  $color=trim($explodeColor[$i], ' ');
		  
		  
		  
		  $sql_saveCombination = "INSERT INTO ws_threaddetails_combination
		                          (strStyleId,strStitchType,strMachineTypeId,strOperationId,strColor,strThreadType,
		                           dblLength_meters,intFactorNameID)
					               VALUES
                                   ('$style','$explodStitch[$i]','$machineId','$opID','$explodeColor[$i]',
                                    '$explodeThread[$i]',$explodeLength[$i],'$mId')";	
					
		  $res4 = $db->RunQuery($sql_saveCombination);
		  
		 /* if(!$res4)
		  {
			   $sql_saveCombinationUpdate = "UPDATE ws_threaddetails_combination SET
			  								strColor='$explodeColor[$i]', strThreadType='$explodeThread[$i]',
											dblLength_meters=$explodeLength[$i]
											  WHERE strStyleId='$style' AND 
											strOperationId='$opID' AND strStitchType='$explodStitch[$i]'";
											
			  $res5=$db->RunQuery($sql_saveCombinationUpdate);
		  }*/
		
		}
		
	 if($res || $res2 || $res4)
	 {
	 	$ResponseXML .= "<SaveDetail><![CDATA[True]]></SaveDetail>\n";
	 }
	 else 
	 {
	 	$ResponseXML .= "<SaveDetail><![CDATA[False]]></SaveDetail>\n";
	 }
	 
	 echo $ResponseXML;
}
//---------------------------------------------------------------------------------
if($RequestType=="assignLength")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML ="<xmlDet>";
	$stitchID=$_GET['stitchID'];
	
		$SQL="	SELECT DISTINCT s.intID,s.strStitchType, s.intLength  
				FROM ws_stitchtype s where  s.intID='$stitchID';";
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				$ResponseXML .= "<stLength><![CDATA[" .  $row["intLength"] . "]]></stLength>\n";
			}
	
	
	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
//---------------------------------------------------------------------------------
if($RequestType=="getSerial")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .="<xmlDet>";

	$sql1="SELECT MAX(dblCombination) FROM syscontrol";
	$result= $db->RunQuery($sql1);
	$row = mysql_fetch_array($result);
	$old= $row["MAX(dblCombination)"];
	$newSerial=$old+1;
	$sqls= "UPDATE syscontrol SET dblCombination='$newSerial' WHERE dblCombination='$old'";
	 $db->executeQuery($sqls);
	$ResponseXML .= "<serial><![CDATA[" . $old . "]]></serial>\n";
	
	$ResponseXML .="</xmlDet>";
	
	echo $ResponseXML;
}

if($RequestType=="loadCombo")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .="<xmlDet>";
	
$colorCombo="<select id=\"cboColor\" name=\"cboColor\" class=\"txtbox\" style=\"width: 100px\" onchange=\"updateDataGrid(this.value);  \"><option>select</option>";   
	 
		$SQL="	SELECT `strColor`
			    FROM `colors` ORDER BY `strColor` ASC  ";		
		$result = $db->RunQuery($SQL);	 
		while($row = mysql_fetch_array($result))
		{
			$colorCombo .= "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
		}		  
		$colorCombo .= "</select>"; 
	
$threadCombo="<select id=\"cboThread\" name=\"cboThread\" class=\"txtbox\" style=\"width: 100px\" onchange=\"updateDataGrid(this.value);  \"><option>select</option>";   
	 
		$SQL="	SELECT `intID`, `strthread`
			    FROM `ws_thread` ORDER BY `strthread` ASC  ";		
		$result = $db->RunQuery($SQL);	 
		while($row = mysql_fetch_array($result))
		{
			$threadCombo .= "<option value=\"". $row["intID"] ."\">" . $row["strthread"] ."</option>" ;
		}		  
		$threadCombo .= "</select>"; 

$texCombo="<select id=\"cboTex\" name=\"cboTex\" class=\"txtbox\" style=\"width: 100px\" onchange=\"updateDataGrid(this.value);  \"><option>select</option>";   
	 
		$SQL="	SELECT `intID`,`strDescription`
			    FROM `ws_tex` ORDER BY `strDescription` ASC  ";		
		$result = $db->RunQuery($SQL);	 
		while($row = mysql_fetch_array($result))
		{
			$texCombo .= "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		}		  
		$texCombo .= "</select>";
		
		$ResponseXML .= "<colorCombo><![CDATA[" .  $colorCombo . "]]></colorCombo>\n";
		$ResponseXML .= "<threadCombo><![CDATA[" .  $threadCombo . "]]></threadCombo>\n";
		$ResponseXML .= "<texCombo><![CDATA[" .  $texCombo . "]]></texCombo>\n";
		
		
	$ResponseXML .="</xmlDet>";
	
	echo $ResponseXML;
}

// ********************************************LOAD popup grid ************************************************************
if($RequestType=="loadCombinationGrid")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .="<xmlDet>";

	$style = $_GET['style'];
	$opCode= $_GET['opCode'];
	$mID   = $_GET['mID'];
	
	
	//chk for existing---
	$stitchRatioName=$_GET['stitchRatioName'];

	 $sql_aval = "SELECT * FROM `ws_threadconsumptiondetails` 
					WHERE `strStyleID`='$style' AND `intOpeartionID`= '$opCode'  AND `intMachineTypeId`= '$mID'";
	$currentRecordSet =  $db->RunQuery($sql_aval);
	$row1 = mysql_fetch_array($currentRecordSet);
	if($row1["strStyleID"]!=''){
	  $sql3 = "SELECT
ws_threadconsumptiondetails.intMachineTypeId,
ws_threadconsumptiondetails.intOpeartionID,
ws_threadconsumptiondetails.strStyleID,
ws_machineratio.intRatioNameId,
ws_threadconsumptiondetails.intTex,
ws_threadconsumptiondetails.intThread,
ws_threadconsumptiondetails.strColor,
ws_threadconsumptiondetails.intStitchType,
ws_stitchtype.strStitchType,
ws_thread.strthread,
ws_tex.strDescription
FROM
ws_threadconsumptiondetails
Inner Join ws_machineratio ON ws_threadconsumptiondetails.intMachineTypeId = ws_machineratio.intMachineTypeId
Inner Join ws_tex ON ws_threadconsumptiondetails.intTex = ws_tex.intID
Inner Join ws_thread ON ws_threadconsumptiondetails.intThread = ws_thread.intID
Inner Join ws_stitchtype ON ws_threadconsumptiondetails.intStitchType = ws_stitchtype.intID  
	 WHERE strStyleID='$style' AND intOpeartionID='$opCode' AND ws_threadconsumptiondetails.intMachineTypeId ='$mID' AND ws_machineratio.intRatioNameId ='$stitchRatioName' 
	 GROUP BY strStyleID, intOpeartionID, ws_threadconsumptiondetails.intMachineTypeId, intStitchType, intThread,intTex, strColor;";

		$result3 = $db->RunQuery($sql3);
		while($row=mysql_fetch_array($result3))
		{
		$ResponseXML .= "<color><![CDATA[" .  $row["strColor"] . "]]></color>\n";
		$ResponseXML .= "<thread><![CDATA[" .  $row["intThread"] . "]]></thread>\n";
		$ResponseXML .= "<tex><![CDATA[" .  $row["intTex"] . "]]></tex>\n";
		$ResponseXML .= "<stitch><![CDATA[" .  $row["intStitchType"] . "]]></stitch>\n";
		$ResponseXML .= "<stitchDes><![CDATA[" .  $row["strStitchType"] . "]]></stitchDes>\n";
		
		}
	}
	 else{
	 /*$sql3 = "SELECT
	ws_stitchtype.strStitchType,
	ws_machineratio.intMachineTypeId,
	ws_machineratio.intRatioNameId, 
	ws_machineratio.intStitchType 
	FROM
	ws_machineratio
	Inner Join ws_stitchtype ON ws_machineratio.intStitchType = ws_stitchtype.intID	WHERE intMachineTypeId ='$mID' AND intRatioNameId ='$stitchRatioName'" ;*/
	$sql3="SELECT
			ws_machineratio.intMachineTypeId,
			ws_machineratio.intRatioNameId,
			ws_machineratio.intStitchType,
			ws_machineratio.dblRatio,
			ws_machineratio.id,
			ws_stitchtype.strStitchType
			FROM
			ws_machineratio
			INNER JOIN ws_stitchtype ON ws_stitchtype.intID = ws_machineratio.intStitchType
			WHERE intMachineTypeId ='$mID' AND intRatioNameId ='$stitchRatioName'";
	
		$result3 = $db->RunQuery($sql3);
		while($row=mysql_fetch_array($result3))
		{
		$ResponseXML .= "<color><![CDATA[]]></color>\n";
		$ResponseXML .= "<thread><![CDATA[]]></thread>\n";
		$ResponseXML .= "<tex><![CDATA[]]></tex>\n";
		$ResponseXML .= "<stitch><![CDATA[" .  $row["intStitchType"] . "]]></stitch>\n";
		$ResponseXML .= "<stitchDes><![CDATA[" .  $row["strStitchType"] . "]]></stitchDes>\n";
		}
	 }
	// echo $sql3;
	
	$ResponseXML .="</xmlDet>";
	
	echo $ResponseXML;
}
//--------------------------------------------------------------------
if($RequestType=="saveRatioName")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$name = $_GET["name"];
	
	
	   $sql= "select * from ws_rationames where strName ='".$name."'";
	 $res3= $db->RunQuery($sql);
	$row = mysql_fetch_array($res3);
	$exist = $row["id"];
	
	if($exist==""){	
		   $sql_save="INSERT INTO 
					ws_rationames(strName)
					VALUE
					('$name')";	
					//echo $sql_save;
		$res=$db->RunQuery($sql_save);
		}
		else{
	
		$res2=1;
		}
		
		
	 if($res!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[True]]></SaveDetail>\n";
	 }
	 else if($res2!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[exist]]></SaveDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveDetail><![CDATA[False]]></SaveDetail>\n";
	 }
	 
	 echo $ResponseXML;
}
//--------------------------------------------------------------------
if($RequestType=="saveMachineStitchRatios")
{echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ArrayMachine = $_GET["ArrayMachine"];
	$ArrayStitchRatio = $_GET["ArrayStitchRatio"];
	$ArrayStitchType = $_GET["ArrayStitchType"];
	$ArrayRatio = $_GET["ArrayRatio"];
	
	$explodeMachine= explode(',', $ArrayMachine) ;
	$explodStitchRatio = explode(',', $ArrayStitchRatio) ;
	$explodeStitchType = explode(',', $ArrayStitchType) ;
	$explodeRatio = explode(',', $ArrayRatio) ;
	 
	 $noOfChecked = count($explodeMachine)-1;
	 
	 $sqlDel= "select * from ws_machineratio where intMachineTypeId = '". $explodeMachine[$i] ."'";
	 $resDel= $db->RunQuery($sqlDel);
	
		for ($i = 0;$i < $noOfChecked;$i++)
		{
		
	    $sql= "select * from ws_machineratio where intMachineTypeId = '". $explodeMachine[$i] ."' AND intRatioNameId= '".$explodStitchRatio[$i]."' AND intStitchType= '".$explodeStitchType[$i]."'";
	  
	 $res3= $db->RunQuery($sql);
	$row = mysql_fetch_array($res3);
	$exist = $row["intMachineTypeId"];
	
	if($exist==""){	
		echo   $sql_save="INSERT INTO 
					ws_machineratio(intMachineTypeId,intRatioNameId,intStitchType,dblRatio)
					VALUE
					('$explodeMachine[$i]','$explodStitchRatio[$i]','$explodeStitchType[$i]','$explodeRatio[$i]')";	
					//echo $sql_save;
		$res=$db->RunQuery($sql_save);
		}
		else{
      echo $sql= "UPDATE ws_machineratio SET dblRatio=$explodeRatio[$i] where intMachineTypeId = '". $explodeMachine[$i] ."' AND intRatioNameId= '".$explodStitchRatio[$i]."' AND intStitchType= '".$explodeStitchType[$i]."'";
		$res2=$db->RunQuery($sql);
		}
		
	}
		
	 if($res!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[True]]></SaveDetail>\n";
	 }
	 else if($res2!=""){
	 $ResponseXML .= "<SaveDetail><![CDATA[UpdateTrue]]></SaveDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveDetail><![CDATA[False]]></SaveDetail>\n";
	 }
	 
	 echo $ResponseXML;
}
//-----------------------------------------------------------------------------
if($RequestType=="loadStitchRatioGrid")
{
	$machineID=$_GET['machineID'];
	$stitchRatio=$_GET['stitchRatio'];

	$ResponseXML .="<xmlDet>";
	 $sql3 = "SELECT 
	ws_machineratio.id, 
ws_machineratio.intMachineTypeId,
ws_machineratio.intRatioNameId,
ws_machineratio.intStitchType,
ws_machineratio.dblRatio,
ws_rationames.strName,
ws_stitchtype.strStitchType
FROM
ws_machineratio
Inner Join ws_rationames ON ws_machineratio.intRatioNameId = ws_rationames.id
Inner Join ws_stitchtype ON ws_machineratio.intStitchType = ws_stitchtype.intID
WHERE
ws_machineratio.intMachineTypeId =  '$machineID' and ws_machineratio.intRatioNameId =  '$stitchRatio';";
	// echo $sql3;
	$result3 = $db->RunQuery($sql3);
	while($row=mysql_fetch_array($result3))
	{
	$ResponseXML .= "<id><![CDATA[" .  $row["id"] . "]]></id>\n";
	$ResponseXML .= "<machineID><![CDATA[" .  $row["intMachineTypeId"] . "]]></machineID>\n";
	$ResponseXML .= "<StichRatName><![CDATA[" .  $row["strName"] . "]]></StichRatName>\n";
	$ResponseXML .= "<StichRatNameID><![CDATA[" .  $row["intRatioNameId"] . "]]></StichRatNameID>\n";
	$ResponseXML .= "<StitchType><![CDATA[" .  $row["strStitchType"] . "]]></StitchType>\n";
	$ResponseXML .= "<StitchTypeID><![CDATA[" .  $row["intStitchType"] . "]]></StitchTypeID>\n";
	$ResponseXML .= "<Ratio><![CDATA[" .  $row["dblRatio"] . "]]></Ratio>\n";
	}
	
	$ResponseXML .="</xmlDet>";
	
	echo $ResponseXML;
}
if($RequestType=="removeStitchRatio")
{	
	$ResponseXML .="<xmlDet>";
    $id=$_GET["id"];  
	$SQL="DELETE FROM ws_rationames WHERE id='$id'";
	$res=$db->RunQuery($SQL);
	 if($res!=""){
	 $ResponseXML .= "<DeleteDetail><![CDATA[True]]></DeleteDetail>\n";
	 }
	 else{
	 $ResponseXML .= "<DeleteDetail><![CDATA[False]]></DeleteDetail>\n";
	 }
	$ResponseXML .="</xmlDet>";
	 echo $ResponseXML;
 }
 
 if($RequestType=="saveColor")
{	
	
    $color   = $_GET["colorname"];
	$styleid = $_GET["styleid"];
	 
	$SQL="Select intBuyerID,intDivisionId FROM orders WHERE intStyleId='$styleid'";
	$res=$db->RunQuery($SQL);
	$row=mysql_fetch_array($res);
	
	$buyerid = $row["intBuyerID"];
	$diviid  = $row["intDivisionId"];
	
    $sqlcolor = "Insert into colors (strColor,intCustomerId,intDivisionID) 
				 values('$color','$buyerid','$diviid')";
				 
	$rescolor=$db->RunQuery($sqlcolor);
				 
	if($rescolor && $res)
	{
		echo $color;
	}
	
 }
//--------------------------------------------------------------------
?>