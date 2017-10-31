<?php
include('../../Connector.php');	
	$type=trim($_GET["type"]);
	
	 
if($type=="save")
{
	$machineTypeId	=	trim($_GET["machineTypeId"]);
	$machineId		=	trim($_GET["machineId"]);
	$machineCode	=	trim($_GET["machineCode"]);
	$machineName	=	trim($_GET["machineName"]);	
	$intHelper		=	trim($_GET["intHelper"]);
	$status			=	trim($_GET["status"]);
	
	//**************************check this machine is exist in the database*******************************
	$sql="SELECT * FROM ws_machinetypes WHERE intMachineId='$machineTypeId'";
	$result1 = $db->ExecuteQuery($sql);
	$row1 = mysql_fetch_array($result1);
	$exist1 = $row1["machineTypeId"];
	
	// ***********************if exist the machineTypeId in the hidden text box, data will be saved***************************
	if($machineTypeId=='')
	{
    	$query_insert="INSERT INTO ws_machinetypes (strMachineCode,strMachineName,intMachineId,intStatus,intHelper)
				VALUES
				('$machineCode','$machineName',$machineId,$status,$intHelper)";
		$result_insert = $db->ExecuteQuery($query_insert);	
		if($result_insert)							 
		  echo "Saved successfully.";
		else
		  echo "Saved Error";   
	}
	else   // **************************************Update data *********************************************
	{
		$query_update="UPDATE ws_machinetypes SET 
											strMachineCode = '$machineCode',
											strMachineName = '$machineName',
											intMachineId   = '$machineId',
											intStatus      = '$status', 
											intHelper      = '$intHelper'
					                   WHERE intMachineTypeId='$machineTypeId'";  

	$result_update = $db->ExecuteQuery($query_update);
	if($result_update)
		echo "Updated successfully.";
	else	
		echo "Updated Error";
	}
	
}

// ***********************************************user selected record delete********************************
else if($type=="delete")
{	
    $intMachineTypeId=$_GET["machineId"];  
	$SQL_delete="DELETE FROM ws_machinetypes WHERE intMachineTypeId='$intMachineTypeId'";
	$result_delete=$db->ExecuteQuery($SQL_delete);
	if($result_delete)
    	echo "Deleted successfully.";
	else 
		echo "Deleted Error";
 }
 
 
 
//********************************Save group name in the entered prompt box *********************************************

else if($type=="saveGroupName")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$name = $_GET["name"];
	
	
	$sql= "select * from events_group where strGroupName ='".$name."'";
	$res3= $db->RunQuery($sql);
	$row = mysql_fetch_array($res3);
	$exist = $row["intGroupId"];
	
	if($exist==""){	
		   $sql_save="INSERT INTO 
					events_group(strGroupName)
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

//-------------------------------------------------------------------------------------------------------------------------------

else if($type=="events_user_groups_Save"){
 $groupID = $_GET["groupID"];
 $userID  = $_GET["userID"];
 
 $sql = "insert into events_user_groups(intUserId,intGroupId)VALUES($userID,$groupID)";
 $res = $db->RunQuery($sql);
}

//--------------------------------------------------------------------------------------------------------------------------------

else if($type=="deleteBeforeSave"){
  $groupID = $_GET["groupID"];
  $sql = "delete from events_user_groups where intGroupId = '$groupID'";
  $res = $db->RunQuery($sql);
  echo $res;
}

?>