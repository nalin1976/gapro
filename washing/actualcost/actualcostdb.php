<?php
require_once('../../Connector.php');
session_start();
$request=$_GET['req'];
$currentYear=date('Y');
$dtTime =date('Y-m-d');
$userID=$_SESSION["UserID"];
$company=$_SESSION["FactoryID"];

	$cusName=$_GET['cusName'];
	$styName=$_GET['styName'];
	$fabName=$_GET['fabName'];
	$color=$_GET['color'];
	$branch=$_GET['branch'];
	$machineType=$_GET['machineType'];
	$noOfPcs=$_GET['noOfPcs'];
	$division = $_GET['division'];
	$garmentType=$_GET['garmentType'];
	$washType=$_GET['washType'];
	$weight=$_GET['weight'];
	$totalHT=$_GET['totalHT'];
	$orderQty=$_GET['orderQty'];
	$exPercent=$_GET['exPercent'];
	$totalQty=$_GET['totalQty'];
	$serialNO=$_GET['serial'];
	$mode	=$_GET['mode'];
	$orderNo=$_GET['orderNo'];
	if(empty($division))
	{
		$division=0;		
	}
	
if($request=="saveHeader")
{
	$sql_selectMax="select max(dblWasActCostNo) SERIALNO from syscontrol WHERE intCompanyID='$company';";
	$sql_max=$db->RunQuery($sql_selectMax);
	$rowMax=mysql_fetch_array($sql_max);
	
	$serial=$rowMax['SERIALNO'] + 1;
	
	$sql_UpdateSysTab="UPDATE syscontrol SET dblWasActCostNo=$serial WHERE intCompanyID=$company;";
	$db->RunQuery($sql_UpdateSysTab);
	
	$sql_insert="INSERT INTO was_actualcostheader(
 				intSerialNo,
				intYear,
				intCustomerId,
				intStyleId,
				intMatDetailId,
				intDivisionId,
				intGarmentId,
				intWashType,
				intMachineType,
				strColor,
				dblQty,
				dblWeight,
				dblHTime,
				intUserId,
				dtmDate,
				intCompanyId,
				intCat
				)
				VALUES(".$serial.",
							  '$currentYear',
							  '$cusName',
							  '$orderNo',
							  '$fabName',
							  '$division',
							  '$garmentType', 
							  '$washType',
							  '$machineType',
							  '$color',				  
							  '$noOfPcs',
							  '$weight',
							  '$totalHT',
							  '$userID',
							  now(),
							  '$company',
							  '$mode');";
				//echo $sql_insert;
				$sql_res=$db->RunQuery($sql_insert);
				if($sql_res==1)
				{
					echo "1~$serial";
				}
}

if($request=="updateHeader")
{
	$sql_update="UPDATE was_actualcostheader 
				SET intCustomerId=$cusName,
				intStyleId=$orderNo,
				intMatDetailId=$fabName,
				intDivisionId=$division,
				intGarmentId=$garmentType,
				intWashType=$washType,
				intMachineType=$machineType,
				strColor='$color',
				dblQty=$noOfPcs,
				dblWeight=$weight,
				dblHTime=$totalHT,
				intUserId=$userID,
				dtmDate=now(),
				intCompanyId=$company,
				intCat=$mode
				WHERE
				intSerialNo=$serialNO;";
				//echo $sql_update;
				$sql_res=$db->RunQuery($sql_update);
				if($sql_res==1)
				{
					echo "1~$serialNO";
				}
}

if($request=="saveCostDetails")
{
	$serial	 = $_GET['serial'];
	$rOder	 = $_GET['rOder'];
	$prcID	 = $_GET['prcID'];
	$temp	 = $_GET['temp'];
	$liqour	 = $_GET['liqour'];
	$tm		 = $_GET['tm'];
	$PHValue = $_GET['PHValue'];
	$loop	 = $_GET['loop'];
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
	/*if(empty($PHValue))
	{
		$PHValue	= 0;
	}*/
	$sql_chk="SELECT * FROM was_actualcostdetails WHERE intSerialNo=$serial;";
	//echo $sql_chk;
	$resChk=$db->RunQuery($sql_chk);
	if(mysql_num_rows($resChk) > 0 && $loop==1)
	{
		$sql_del="DELETE FROM was_actualcostdetails WHERE intSerialNo=$serial;";
		$db->RunQuery($sql_del);
	}
	
	$sql_InsertCostDet="INSERT INTO was_actualcostdetails 
						(intRowID,intSerialNo,intYear,intProcessId,dblTemp,dblLiqour,dblTime,dblPHValue) 
						VALUES($rOder,$serial,$currentYear,'$prcID','$temp','$liqour','$tm','$PHValue');";
						//echo $sql_InsertCostDet;
	    $res=$db->RunQuery($sql_InsertCostDet);
		if ($res==1)
		{
			echo $res;
		}
}

if($request=="confirmActCost")
{
	$serialNO = $_GET['sNo'];
	
	$sql_Confirm="UPDATE was_actualcostheader SET intStatus = 1 WHERE intSerialNo=$serialNO;";
	$res=$db->RunQuery($sql_Confirm);
	//echo $sql_Confirm;
	if($res==1)
	{
		echo $res;
	}
	else
	{
		echo 0;
	}
}

if($request=="reviseSample")
{
	$serialNO = $_GET['sNo'];
	$reason=$_GET['reason'];
	$sql_rev="SELECT intRevisionNo FROM was_actualcostheader WHERE intSerialNo='$serialNO';";
	$resR=$db->RunQuery($sql_rev);
	saveRevisionHistory($serialNO);
	$row=mysql_fetch_array($resR);
	//echo $row['intRevisionNo'];
	$sql_Revise="UPDATE was_actualcostheader SET intStatus = 0,intRevisionNo=intRevisionNo+1 ,strReviseReason='$reason' WHERE intSerialNo=$serialNO;";
	//echo $sql_Revise;
	$res=$db->RunQuery($sql_Revise);
	if($res==1)
	{
		echo $res."~".($row['intRevisionNo']+1);
	}
	else
	{
		echo "0~".($row['intRevisionNo']);
	}
}

if($request=="clearChemicalDetails")
{
	$serial = $_GET['serial'];
	$sql_chk="SELECT * FROM was_actcostchemicals WHERE intSerialNo=$serial;";
	//echo $sql_chk;
	$resChk=$db->RunQuery($sql_chk);
	if(mysql_num_rows($resChk) > 0)
	{
		$sql_del="DELETE FROM was_actcostchemicals WHERE intSerialNo=$serial;";
		$db->RunQuery($sql_del);
		//echo $sql_del;
	}
	echo 1;
}
if($request=="saveChemicalDetails")
{
	//$cId 	= $_GET['cId'];
	$serial	= $_GET['serial'];
	$prcID	= $_GET['prcID'];
	$chmID	= $_GET['chmID'];
	$liqour	= $_GET['liqour'];
	$tm		= $_GET['tm'];
	$intRowOder =$_GET['rowOder'];
	$chmQty	=$_GET['chmQty'];
	$chmUP	=$_GET['chmUP'];
	
	/*if(empty($chmID))
	{
		$chmID=0;
		$unit=0;
		$chmQty=0;
		$chmUP=0.00;
		echo 0;
	}
	else
	{*/
		$sql_selectChm="SELECT
						wc.strUnit,wc.dblQty,wc.dblUnitPrice
						FROM 
						was_chemical wc
						
						WHERE 
						wc.intChemicalId=$chmID 
						AND 
						wc.intProcessId = $prcID";
		
		//echo $sql_selectChm;
		$resC=$db->RunQuery($sql_selectChm);
		$row=mysql_fetch_array($resC);
		$unit=$row['strUnit'];
		$qty=$row['dblQty'];
		$unitPrice =$row['dblUnitPrice'];
		
		$sql_InsertChmtDet="INSERT INTO was_actcostchemicals 
					(intRowOder,intSerialNo,intYear,intProcessId,intChemicalId,strUnit,dblQty,dblUnitPrice) 
					VALUES($intRowOder,$serial,$currentYear,$prcID,$chmID,'".$unit."','".$chmQty."','".$chmUP."');";
						//echo $sql_InsertChmtDet;
		$res=$db->RunQuery($sql_InsertChmtDet);
			echo 1;
	//}
	
}
if($request=="loadChemicals")
{
	$serial	=	$_GET['sNo'];
	$rId	=	$_GET['rId'];
	$pId	=	$_GET['pId'];
	
	/*$sql_chm="SELECT 
				wbc.intRowOder,wbc.intProcessId,wbc.intChemicalId,wcl.strItemDescription,wbc.dblQty,wbc.dblUnitPrice
			  FROM 
				was_actcostchemicals wbc
			  INNER JOIN was_chemmatitemlist AS wcl ON wcl.intSerialNo=wbc.intChemicalId
			  WHERE
				wbc.intSerialNo=$serial
			  AND 
				wbc.intRowOder=$rId
			  AND
				wbc.intProcessID=$pId;";*/
		$sql_chm="SELECT 
				wbc.intRowOder,wbc.intProcessId,wbc.intChemicalId,wcl.strItemDescription,wbc.dblQty,wbc.dblUnitPrice
			  FROM 
				was_actcostchemicals wbc
			  INNER JOIN genmatitemlist AS wcl ON wcl.intItemSerial = wbc.intChemicalId
			  WHERE
				wbc.intSerialNo=$serial
			  AND 
				wbc.intRowOder=$rId
			  AND
				wbc.intProcessID=$pId;";		
				
				//echo $sql_chm;
				
		$res=$db->RunQuery($sql_chm);
		$htm="";
	while($row=mysql_fetch_array($res))
	{
		$des=split('-',$row['strItemDescription']);
	$htm.="<option value=\"".$row['intChemicalId'].":".$row['dblQty'].":".$row['dblUnitPrice']."\">".$row['intChemicalId'].":".$des[count($des)-1]."</option>";
	}
	echo $htm;
}
function saveRevisionHistory($serial){
	global $db;
	saveActualCostHeaderHistory($serial);
	saveActualCostDetailHistory($serial);
	saveActualCostChemicalHistory($serial);
}
//Move Data to History
function saveActualCostHeaderHistory($serial){
	global $db;
	$sql="INSERT INTO was_actualcostheader_history (intSerialNo,intYear,intCustomerId,intStyleId,intMatDetailId,intDivisionId,intGarmentId,intWashType,intMachineType,intCat,strColor,dblQty,dblWeight,dblHTime,intStatus,intRevisionNo,intUserId,dtmDate,intConfirmBy,dtmConfirm,strReviseReason,intCompanyId) 
		SELECT intSerialNo,intYear,intCustomerId,intStyleId,intMatDetailId,intDivisionId,intGarmentId,intWashType,intMachineType,intCat,strColor,dblQty,dblWeight,dblHTime,intStatus,intRevisionNo,intUserId,dtmDate,intConfirmBy,dtmConfirm,strReviseReason,intCompanyId 
		FROM was_actualcostheader
		WHERE
			 was_actualcostheader.intSerialNo = '$serial';";	
	 $db->RunQuery($sql); 
}

function saveActualCostDetailHistory($serial){
	global $db;
	$sql="INSERT INTO was_actualcostdetails_history(intRowID,intSerialNo,intYear,intProcessId,dblTemp,dblLiqour,dblTime)
SELECT intRowID,intSerialNo,intYear,intProcessId,dblTemp,dblLiqour,dblTime 
FROM was_actualcostdetails
WHERE was_actualcostdetails.intSerialNo='$serial';";
 	$db->RunQuery($sql);	
}

function saveActualCostChemicalHistory($serial){
	global $db;
	$sql="INSERT INTO was_actcostchemicals_history(intRowOder,intSerialNo,intYear,intProcessId,intChemicalId,strUnit,dblQty,dblUnitPrice)
		  SELECT  
		  intRowOder,intSerialNo,intYear,intProcessId,intChemicalId,strUnit,dblQty,dblUnitPrice
		  FROM was_actcostchemicals 
		  WHERE was_actcostchemicals.intSerialNo='$serial';";
	$db->RunQuery($sql);
}
?>