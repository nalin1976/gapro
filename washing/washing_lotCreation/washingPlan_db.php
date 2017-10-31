<?php 
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
include('../../Connector.php');
include("class.washingplan.php");

$wrsr=new washingplan();
$req=$_GET['req'];

if(strcmp($req,"saveHeader")==0){
	$date=$_GET['date'];
	$shiftX=$_GET['shiftX'];
	$pub_planNo = $_GET["pub_planNo"];
	$planNewNo = explode('/',$pub_planNo);
	
	if($pub_planNo==0)
	{
		$planNo=getPlanNo()+1;
		
		$sql="insert into was_planheader
		(intPlanYear,intPlanNo,dtmDate,intUser,intFactory,intShiftId,intCreatedBy,intCreatedDate) 
		values('".date('Y')."','$planNo','$date','".$_SESSION['UserID']."','".$_SESSION['FactoryID']."','$shiftX','".$_SESSION['UserID']."',now())";	
	//echo $sql;
	$res=$db->RunQuery($sql);
		if($res==1)
		{
			updatePlanNo($planNo);
			echo $res."~".date('Y').'/'.($planNo);
		}
		else
			echo $res."~"."Header Saving Fail.";/**/
		}
	else
	{
		$sql_updH = "update was_planheader 
						set
						dtmDate = '$date' , 
						intUser = '".$_SESSION['UserID']."' , 
						intFactory = '".$_SESSION['FactoryID']."' , 
						intShiftId = '$shiftX' 
						where intPlanYear = '$planNewNo[0]' and intPlanNo = '$planNewNo[1]'";
		$res_updH = $db->RunQuery($sql_updH);
		
		$sql_delPool = "delete from was_planlotpool where intPlanYear='$planNewNo[0]' and intPlanNo='$planNewNo[1]'";
		$res_delPool = $db->RunQuery($sql_delPool);
		
		$sql_batchId = "select intBatchId from was_planmachineallocationheader where intPlanYear='$planNewNo[0]' and intPlanNo='$planNewNo[1]' ";
		$res_batchId = $db->RunQuery($sql_batchId);
		while($row_batchId = mysql_fetch_array($res_batchId))
		{
			$sql_deleteBId = "delete from was_planmachineallocationdetail where intBatchId ='".$row_batchId["intBatchId"]."';";
			$res_batchIdDel = $db->RunQuery($sql_deleteBId);
		}
		$sql_delBatchH = "delete from was_planmachineallocationheader where intPlanYear = '$planNewNo[0]' and intPlanNo = '$planNewNo[1]' ;";
		$res_delBatchH = $db->RunQuery($sql_delBatchH);
		
		if($res_updH)
			echo $res_updH."~".$pub_planNo;
		else
			echo $res_updH."~"."Header Saving Fail.";
		
	}
	
	
}

if(strcmp($req,"savePOPool")==0){
	
	$po=$_GET['po'];
	$planQty=$_GET['planQty'];
	$date=$_GET['date'];
	$shift=$_GET['shift'];
	$planNo=explode('/',$_GET['serial']);
	$sql="insert into was_planLotPool(intPlanYear,intPlanNo,intStyleId,dblPlanedQty,dtmDate,intShiftId)
	values('".$planNo[0]."',".$planNo[1].",'$po','$planQty','$date','$shift');";	
	$res=$db->RunQuery($sql);
	if($res==1){
		//updatePlanNo($planNo+1);
		echo 1;}
	else
		echo "Pool Savig Fail.";
}
if($req=="saveMachineLotsHeader")
{
	$serial = 	explode('/',$_GET['serial']);
	$batchId = getBatchId();
	
	$sql = "insert into was_planmachineallocationheader 
			(
			intBatchId, 
			intPlanYear, 
			intPlanNo
			)
			values
			('$batchId', 
			 '$serial[0]', 
			 '$serial[1]'
			)";
//	echo $sql;
	$result = $db->RunQuery($sql);
	if($result)
		echo $batchId;
	else
		echo "error";
	
}
if(strcmp($req,"saveMachineLotsDetail")==0){
	$serial  = 	explode('/',$_GET['serial']);
	$styleId =	$_GET['styleId'];
	$machine =	substr($_GET['Machine'],0,(strlen($_GET['Machine'])-1) );
	$CostNo	 =	explode('/',$_GET['CostNo']);
	$LotNo	 =	$_GET['LotNo'];
	$LotQty	 =	$_GET['LotQty'];
	$batchId =	$_GET['batchId'];
	
	$sql="insert into was_planmachineallocationdetail 
	(intBatchId, intStyleId, intMachine, dblCostNo, intCostYear, strLotNo, intLotQty)
	values
	('$batchId', '$styleId', '$machine', '$CostNo[1]', '$CostNo[0]', '$LotNo', '$LotQty');";	
	
	$res=$db->RunQuery($sql);
	if($res==1){
		echo $res."~"."Plan save successfully";}
	else
		echo $res."~"."Lot Saving Fail.";
	
}
function getPlanNo(){
	global $db;	
	$sql="select dblWasPlanNo from syscontrol where intCompanyId='".$_SESSION['FactoryID']."';";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		return $row['dblWasPlanNo'];
	}
}

function updatePlanNo($planNo){
	global $db;	
	$sql="update syscontrol set dblWasPlanNo='$planNo' where intCompanyId='".$_SESSION['FactoryID']."';";
	$res=$db->RunQuery($sql);
}
function getBatchId()
{
	global $db;	
	$sql = "update syscontrol set  dblWasBatchId= dblWasBatchId+1 WHERE intCompanyID='".$_SESSION['FactoryID']."';";
	$res = $db->RunQuery($sql);
	$sql_select = "select dblWasBatchId from syscontrol where intCompanyID='".$_SESSION['FactoryID']."';";
	$result = $db->RunQuery($sql_select);
	while($row = mysql_fetch_array($result))
	 {
		$batchId  =  $row["dblWasBatchId"] ;
		break;
	 }
	return $batchId;
}
?> 