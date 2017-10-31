<?php
session_start();
require_once('../../Connector.php');

$request=$_GET['request'];

if($request=="saveData")
{
	$PLNo		=$_GET['PLNo'];
	$fabricID	=$_GET['fabricID'];
	$styleNo	=$_GET['styleNo'];
	$division	=$_GET['division'];
	$color		=$_GET['color'];
	$garment	=$_GET['garment'];
	$size		=$_GET['size'];
	$orderQty	=$_GET['orderQty'];
	$cutQty		=$_GET['cutQty'];
	$washQty	=$_GET['washQty'];
	$date		=$_GET['date'];
	$styleName	=$_GET['styleName'];
	$mill		=$_GET['mill'];
	$washType	=$_GET['washType'];
	$factory	=$_GET['factory'];
	$Ex	=$_GET['Ex'];
	
	if(!checkValueExistPo($PLNo)){
	$sql ="INSERT INTO was_outsidepo(intPONo,intFabId,strStyleNo,intDivision,strColor,intGarment,strSize,dblOrderQty,dblCutQty,dblWashQty,dtmDate,strStyleDes,intMill,intWashType,intFactory,dblEx) VALUES ('$PLNo','$fabricID','$styleNo','$division','$color','$garment','$size','$orderQty','$cutQty','$washQty','$date','$styleName','$mill','$washType','$factory','$Ex');";

	
	$result=$db->RunQuery($sql) ;
	
		if($result)
			echo "saved";
		else
			echo "error";		
	}
	else
	{
		 $sql="UPDATE was_outsidepo SET intFabId='$fabricID',strStyleNo='$styleNo',intDivision='$division',strColor='$color',intGarment='$garment',strSize='$size',dblOrderQty='$orderQty',dblCutQty='$cutQty',dblWashQty='$washQty',strStyleDes='$styleName',
intMill='$mill',intWashType='$washType',intFactory='$factory',dblEx='$Ex' WHERE intPONo='$PLNo';";
		
		$result_update=$db->RunQuery($sql) ;
		
		if($result_update)
		{
			echo"update";
		}
		else
		{
			echo"updateerror";
		}	
	}
}

function checkValueExistPo($PLNo){
global $db;
$sql="select * from was_outsidepo where intPONo='$PLNo';";
$result=$db->RunQuery($sql);
	if(mysql_num_rows($result) > 0){
		return true;
	}
	else{
		return false;
	}
}

if($request=="deleteData")
{
	$deletepo	=$_GET['deletepo'];
	
	$sql ="DELETE FROM was_outsidepo WHERE intId='$deletepo';";
	
	$result=$db->RunQuery($sql);
	if($result)
	{
		echo"delete";
	}
	else
	{
		echo"error";
	}
}


?>