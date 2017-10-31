<?php
session_start();
require_once('../../Connector.php');
$request		= $_GET['req'];
$currentYear	= date('Y');
$dtTime 		= date('Y-m-d');

if($request=="saveHeader")
{
$company		= $_SESSION["FactoryID"];
$fabricName		= $_GET['fabricName'];
$customerName	= $_GET['customerName'];
$styleName		= $_GET['styleName'];
$division		= $_GET['division'];
$cl				= $_GET['color'];
$color			= $cl;//str_replace('~','#', $cl);
$washType		= $_GET['washType'];
$garment		= $_GET['garment'];
$machine		= $_GET['machine'];
$radioType		= $_GET['radioType'];
$receiveDate	= $_GET['receiveDate'];
$mill			= $_GET['mill'];
$fabricDsc		= $_GET['fabricDsc'];
$fabricContent	= $_GET['fabricContent'];
$timeHandling	= $_GET['timeHandling'];
$noOfPcs		= $_GET['noOfPcs'];
$weight			= $_GET['weight'];
$sampleNo		= $_GET['sampleNo'];
$userID			= $_SESSION["UserID"];
		
$sql_chk="SELECT * FROM was_budgetcostheader WHERE intSerialNo='$sampleNo' AND intYear=$currentYear";
$resChk=$db->RunQuery($sql_chk);
	if(mysql_num_rows($resChk) > 0)
	{
		$sql_Update="UPDATE was_budgetcostheader 
		SET 	
		intCustomerId=$customerName,
		strStyleName='$styleName',
		intMillId='$mill',
		strFabricId='$fabricName',
		strFabricDescription='$fabricDsc',
		strFabricContent='$fabricContent',
		strDivision='$division',
		intGarmentId='$garment',
		intWashType='$washType',
		strColor='$color',
		dblQty='$noOfPcs',
		dblWeight='$weight',
		intCat='$radioType',
		intRevisionNo=0,
		dtmDate=now(),
		intMachineId='$machine',
		dblHTime='$timeHandling',
		intCompanyId='$company'
		WHERE 
		intSerialNo=$sampleNo 
		AND 
		intYear=$currentYear ;";
		$db->RunQuery($sql_Update);
		echo "2~$sampleNo";
	}
	else
	{
		$sql_getSerial="SELECT dblWasBudgeteNo SERIALNO FROM syscontrol WHERE intCompanyID=$company;";			
		$resSerial=$db->RunQuery($sql_getSerial);
		$rowSerial = mysql_fetch_array($resSerial);
		$serial=$rowSerial['SERIALNO']+1;
		
		$sql_UpdateSysTab="UPDATE syscontrol SET dblWasBudgeteNo=$serial WHERE intCompanyID=$company;";
		$db->RunQuery($sql_UpdateSysTab);
		
		$sql_insert="INSERT INTO 
					was_budgetcostheader(
							intSerialNo,
							intYear,
							intCustomerId,
							strStyleName,
							intMillId,
							strFabricId,
							strFabricDescription,
							strFabricContent,
							strDivision,
							intGarmentId,
							intWashType,
							strColor,
							dblQty,
							dblWeight,
							dblHTime,
							intMachineId,
							intCat,
							intUserId,
							dtmDate,
							intCompanyId)
					VALUE($serial,
						  $currentYear,
						  '$customerName',
						  '$styleName',
						  '$mill',
						  '$fabricName',
						  '$fabricDsc',
						  '$fabricContent',
						  '$division',
						  '$garment',
						  '$washType',
						  '$color',
						  '$noOfPcs',
						  '$weight',
						  '$timeHandling',
						  '$machine',
						  '$radioType',
						  '$userID',
						  '$receiveDate',
						  '$company');";
		try
		{
				$db->RunQuery($sql_insert);
				echo "1~$serial";
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
}
elseif($request=="saveCostDetails")
{
	$serial	= $_GET['serial'];
	$rOder	= $_GET['rOder'];
	$prcID	= $_GET['prcID'];
	$temp	= $_GET['temp'];
	$liqour	= $_GET['liqour'];
	$tm		= $_GET['tm'];
	$loop	= $_GET['loop'];
	if(empty($temp))
	{
		$temp=0;
	}
	if(empty($liqour))
	{
		$liqour	= 0;
	}
	if(empty($tm))
	{
		$tm	= 0;
	}
	$sql_chk="SELECT * FROM was_budgetcostdetails WHERE intSerialNo=$serial;";
	$resChk=$db->RunQuery($sql_chk);
	if(mysql_num_rows($resChk) > 0 && $loop==1)
	{
		$sql_del="DELETE FROM was_budgetcostdetails WHERE intSerialNo=$serial;";
		$db->RunQuery($sql_del);
	}
	
	$sql_InsertCostDet="INSERT INTO was_budgetcostdetails 
						(intRowOder,intSerialNo,intYear,intProcessId,dblTemp,dblLiqour,dblTime) 
						VALUES($rOder,$serial,$currentYear,'$prcID','$temp','$liqour','$tm');";
	$res=$db->RunQuery($sql_InsertCostDet);
	if ($res==1)
	{
		echo $res;
	}
}
elseif($request=="clearChemicalDetails")
{
	$serial = $_GET['serial'];
	$sql_chk="SELECT * FROM was_budgetchemicals WHERE intSerialNo='$serial';";
	$resChk=$db->RunQuery($sql_chk);
	if(mysql_num_rows($resChk) > 0)
	{
		$sql_del="DELETE FROM was_budgetchemicals WHERE intSerialNo='$serial';";
		$db->RunQuery($sql_del);
	}
	echo 1;
}
elseif($request=="saveChemicalDetails")
{
	$serial		= $_GET['serial'];
	$prcID		= $_GET['prcID'];
	$chmID		= $_GET['chmID'];
	$liqour		= $_GET['liqour'];
	$tm			= $_GET['tm'];
	$intRowOder = $_GET['rowOder'];
	$chmQty		= $_GET['chmQty'];
	$chmUP		= $_GET['chmUP'];
	
	$sql_selectChm="SELECT wc.strUnit,wc.dblQty,wc.dblUnitPrice FROM was_chemical wc WHERE wc.intChemicalId=$chmID AND wc.intProcessId = $prcID";
	$resC=$db->RunQuery($sql_selectChm);
	$row=mysql_fetch_array($resC);
	$unit=$row['strUnit'];
	$qty=$row['dblQty'];
	$unitPrice =$row['dblUnitPrice'];
	
	$sql_InsertChmtDet="INSERT INTO was_budgetchemicals 
				(intRowOder,intSerialNo,intYear,intProcessId,intChemicalId,strUnit,dblQty,dblUnitPrice) 
				VALUES($intRowOder,$serial,$currentYear,$prcID,$chmID,'".$unit."','".$chmQty."','".$chmUP."');";
	$res=$db->RunQuery($sql_InsertChmtDet);
		echo 1;
}
elseif($request=="confirmSample")
{
	$sNo = $_GET['sNo'];
	
	$sql_Confirm="UPDATE was_budgetcostheader SET intStatus = 1,intConfirmBy='".$_SESSION["UserID"]."',dtmConfirm=now() WHERE intSerialNo=$sNo;";
	$res=$db->RunQuery($sql_Confirm);
	if($res==1)
	{
		echo $res;
	}
	else
	{
		echo 0;
	}
}
elseif($request=="reviseSample")
{
	$sNo = $_GET['sNo'];
	$reason=$_GET['reason'];
	$sql_rev="SELECT intRevisionNo FROM was_budgetcostheader WHERE intSerialNo='$sNo';";
	$resR=$db->RunQuery($sql_rev);
	moveBudgetDetailsToHistory($sNo);
	$row=mysql_fetch_array($resR);
	$sql_Revise="UPDATE was_budgetcostheader SET intStatus = 0,intRevisionNo=intRevisionNo+1,strReviseReason='$reason' WHERE intSerialNo=$sNo;";
	$res=$db->RunQuery($sql_Revise);
	if($res==1)
	{
		echo $res;
	}
	else
	{
		echo 0;
	}
}
elseif($request=="loadDetails")
{
$serial =$_GET['serial'];
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML ="<loadWashProcess>";
		
		$sql_loadHeader="SELECT intSerialNo,wsb.intRevisionNo,wsb.dtmDate,wsb.intCustomerId,wsb.strStyleName,wsb.intStatus,wsb.intMillId,wsb.strFabricId,strFabricDescription,strFabricContent,wsb.strDivision,wsb.intGarmentId,wsb.intWashType,wsb.intMachineId,wsb.intCat,wsb.strColor,wsb.dblQty,wsb.dblWeight,wsb.dblHTime FROM was_budgetcostheader wsb WHERE wsb.intSerialNo=$serial;";
		$resHeader = $db->RunQuery($sql_loadHeader);
		while($row=mysql_fetch_array($resHeader))
		{
			$ResponseXML.="<intSerialNo><![CDATA[" . trim($row["intSerialNo"])  . "]]></intSerialNo>\n";
			$ResponseXML.="<intStatus><![CDATA[" . trim($row["intStatus"])  . "]]></intStatus>\n";
			$ResponseXML.="<intRevisionNo><![CDATA[".trim($row["intRevisionNo"])."]]></intRevisionNo>\n";
			$ResponseXML.="<intYear><![CDATA[" . trim(substr($row["dtmDate"],0,10))  . "]]></intYear>\n";	
			$ResponseXML.="<intCustomerId><![CDATA[" . trim($row["intCustomerId"])  . "]]></intCustomerId>\n";			
			$ResponseXML.="<Mill><![CDATA[" . trim($row["intMillId"])  . "]]></Mill>\n";
			$ResponseXML.="<StyleName><![CDATA[" . trim($row["strStyleName"])  . "]]></StyleName>\n";
			$ResponseXML.="<FabricId><![CDATA[" . trim($row["strFabricId"])  . "]]></FabricId>\n";
			$ResponseXML.="<FD><![CDATA[" . trim($row["strFabricDescription"])  . "]]></FD>\n";	
			$ResponseXML.="<FC><![CDATA[" . trim($row["strFabricContent"])  . "]]></FC>\n";		
			$ResponseXML.="<Division><![CDATA[" . trim($row["strDivision"])  . "]]></Division>\n";	
			$ResponseXML.="<intGarmentId><![CDATA[" . trim($row["intGarmentId"])  . "]]></intGarmentId>\n";	
			$ResponseXML.="<intWashType><![CDATA[" . trim($row["intWashType"])  . "]]></intWashType>\n";
			$ResponseXML.="<cboMachine><![CDATA[" . trim($row["intMachineId"])  . "]]></cboMachine>\n";
			$ResponseXML.="<intCat><![CDATA[" . trim($row["intCat"])  . "]]></intCat>\n";
			$ResponseXML.="<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";	
			$ResponseXML.="<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
			$ResponseXML.="<dblWeight><![CDATA[" . trim($row["dblWeight"])  . "]]></dblWeight>\n";	
			$ResponseXML.="<dblHTime><![CDATA[" . trim($row["dblHTime"])  . "]]></dblHTime>\n";
		}
		$sql_loadDetails="SELECT 
							wb.intRowOder,wb.intProcessId,wb.dblTemp,wb.dblLiqour,wb.dblTime,wf.strProcessName
							FROM  
							was_budgetcostdetails wb
							INNER JOIN was_washformula AS wf ON wf.intSerialNo=wb.intProcessId
							WHERE
							wb.intSerialNo=$serial;";
		$resGrid=$db->RunQuery($sql_loadDetails);
		while($rowG=mysql_fetch_array($resGrid))
		{
			$ResponseXML.="<intRowOder><![CDATA[" . trim($rowG["intRowOder"])  . "]]></intRowOder>\n";
			$ResponseXML.="<strProcessName><![CDATA[" . trim($rowG["strProcessName"])  . "]]></strProcessName>\n";
			$ResponseXML.="<intProcessId><![CDATA[" . trim($rowG["intProcessId"])  . "]]></intProcessId>\n";
			$ResponseXML.="<dblTemp><![CDATA[" . trim($rowG["dblTemp"])  . "]]></dblTemp>\n";
			$ResponseXML.="<dblLiqour><![CDATA[" . trim($rowG["dblLiqour"])  . "]]></dblLiqour>\n";
			$ResponseXML.="<dblTime><![CDATA[" . trim($rowG["dblTime"])  . "]]></dblTime>\n";
		}
		
		$sql_chemical="SELECT wbc.intRowOder,wbc.intProcessId,wbc.intChemicalId,wcl.strItemDescription
						FROM 
						was_budgetchemicals wbc
						INNER JOIN was_chemmatitemlist AS wcl ON wcl.intSerialNo=wbc.intChemicalId
						WHERE
						wbc.intSerialNo=$serial;";
		$resCmb=$db->RunQuery($sql_chemical);	
		while($rowC=mysql_fetch_array($resCmb))
		{
			$ResponseXML.="<intChemicalId><![CDATA[" . trim($rowC["intChemicalId"])  . "]]></intChemicalId>\n";
			$ResponseXML.="<strItemDescription><![CDATA[" . trim($rowC["strItemDescription"])  . "]]></strItemDescription>\n";
			$ResponseXML.="<intProcessId><![CDATA[" . trim($rowC["intProcessId"])  . "]]></intProcessId>\n";
			$ResponseXML.="<intRowOder><![CDATA[" . trim($rowC["intRowOder"])  . "]]></intRowOder>\n";
		}
		
		$ResponseXML .="</loadWashProcess>";
		echo $ResponseXML;
}
elseif($request=="loadChemicals")
{
	$serial	=	$_GET['sNo'];
	$rId	=	$_GET['rId'];
	$pId	=	$_GET['pId'];
	
	$sql_chm="SELECT WBC.intRowOder,WBC.intProcessId,WBC.intChemicalId,GMIL.strItemDescription,WBC.dblQty,WBC.dblUnitPrice
		FROM was_budgetchemicals WBC
		INNER JOIN genmatitemlist AS GMIL ON GMIL.intItemSerial=WBC.intChemicalId
		WHERE WBC.intSerialNo=$serial AND WBC.intRowOder=$rId AND WBC.intProcessID=$pId;";	
		$res=$db->RunQuery($sql_chm);
		$htm="";
	while($row=mysql_fetch_array($res))
	{
		$des=split('-',$row['strItemDescription']);
		$htm.="<option value=\"".$row['intChemicalId'].":".$row['dblQty'].":".$row['dblUnitPrice']."\">".$row['intChemicalId'].":".$des[count($des)-1]."</option>";
	}
	echo $htm;
}
//Move Data to History
function moveBudgetDetailsToHistory($sNo){
	global $db;
	savebudgetCostHeaderHistory($sNo);
	savebudgetCostDetailHistory($sNo);
	savebudgetCostChemicalHistory($sNo);
}

function savebudgetCostHeaderHistory($serial){
	global $db;
	$sql="INSERT INTO was_budgetcostheader_history(intSerialNo,intYear,intCustomerId,strStyleName,intMillId,strFabricId,
strFabricDescription,strFabricContent,strDivision,intGarmentId,intWashType,strColor,dblQty,dblWeight,dblHTime,
intMachineId,intCat,intStatus,intRevisionNo,intUserId,dtmDate,intConfirmBy,dtmConfirm,intCompanyId,strReviseReason) 
		SELECT intSerialNo,intYear,intCustomerId,strStyleName,intMillId,strFabricId,
strFabricDescription,strFabricContent,strDivision,intGarmentId,intWashType,strColor,dblQty,dblWeight,dblHTime,
intMachineId,intCat,intStatus,intRevisionNo,intUserId,dtmDate,intConfirmBy,dtmConfirm,intCompanyId,strReviseReason FROM was_budgetcostheader
		WHERE
			 was_budgetcostheader.intSerialNo = '$serial';";	//AND was_budgetcostheader.intYear = '$year'
	 $db->RunQuery($sql); 
}

function savebudgetCostDetailHistory($serial){
	global $db;
	$sql="INSERT INTO was_budgetcostdetails_history(intRowOder,intSerialNo,intYear,intProcessId,dblTemp,dblLiqour,dblTime)
SELECT intRowOder,intSerialNo,intYear,intProcessId,dblTemp,dblLiqour,dblTime 
FROM was_budgetcostdetails
WHERE was_budgetcostdetails.intSerialNo='$serial' ;";//AND was_budgetcostdetails.intYear='$year'
 	$db->RunQuery($sql);	
}

function savebudgetCostChemicalHistory($serial){
	global $db;
	$sql="INSERT INTO was_budgetchemicals_history(intRowOder,intSerialNo,intYear,intProcessId,intChemicalId,strUnit,dblQty,dblUnitPrice)
		  SELECT  
		  intRowOder,intSerialNo,intYear,intProcessId,intChemicalId,strUnit,dblQty,dblUnitPrice
		  FROM was_budgetchemicals 
		  WHERE intSerialNo='$serial';"; //and intYear='$year'
	$db->RunQuery($sql);
}
?>