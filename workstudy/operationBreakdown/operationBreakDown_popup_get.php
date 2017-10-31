<?php
include "../../Connector.php";
$id = $_GET['id'];

if($id=='loadCategory')
{
	return loadcomboDetails("SELECT componentcategory.intCategoryNo, componentcategory.strDescription  FROM componentcategory order by  strDescription");
}
else if($id=='loadComponents')
{
	$intCatId = $_GET['intCatId'];
	$cmbProcessId = $_GET['cmbProcessId'];
	if($intCatId!='' && $cmbProcessId!='')
		//return loadcomboDetails("SELECT distinct components.intComponentId, components.strComponent FROM components WHERE components.intCategory =  '$intCatId'");
		return loadcomboDetails("SELECT distinct
									components.intComponentId,
									components.strComponent
									FROM
									components
									Inner Join ws_operations ON components.intComponentId = ws_operations.intCompId
									WHERE
									ws_operations.intProcessId =  '$cmbProcessId' AND
									ws_operations.intCompCatId =  '$intCatId'");
	else
		return loadcomboDetails("SELECT distinct components.intComponentId, components.strComponent FROM components");
}
else if($id=='loadOperations')
{
	$intCatId = $_GET['intCatId'];
	$intCompId = $_GET['intCompId'];
	$cmbProcessId = $_GET['cmbProcessId'];
	
	if($intCompId!='')
		return loadcomboDetails("SELECT intId, concat(strOperationCode,'-',strOperationName) FROM ws_operations WHERE intCompCatId = '$intCatId' AND intCompId = '$intCompId' and intProcessId='$cmbProcessId' and intStatus='1'");
	else
		return loadcomboDetails("SELECT intId, concat(strOperationCode,'-',strOperationName) FROM ws_operations where intStatus='1' order by strOperationName");
}
else if($id=='loadMTypes')
{
	$intMachineId = $_GET['intMachineId'];
	return loadcomboDetails("SELECT intMachineTypeId, strMachineName FROM ws_machinetypes WHERE intMachineId =  '$intMachineId'");
}
else if($id=='loadMachines')
{
	return loadcomboDetails("SELECT intMacineID, strName FROM ws_machines where intStatus=1 order by strName");
}
else if($id =='loadSmv')
{
	$intMachineTypeId 	= $_GET['intMachineTypeId'];
	$intOperationId 	= $_GET['intOperationId'];
	
	$sql = "SELECT  dblSMV  FROM ws_smv WHERE  ws_smv.intMachineTypeId =  '$intMachineTypeId' AND ws_smv.intOperationId =  '$intOperationId'";
	$result = $db->RunQuery($sql);
	
	$row = mysql_fetch_array($result);
	echo $row['dblSMV'];
}
////////////////////////////////////////// COMON COMBO LOAD /////////////////////////////////////////
function loadcomboDetails($sql)
{   echo $sql;
	global $db;
	$result = $db->RunQuery($sql);
	$value = '<option value="0"></option>';
	while($row = mysql_fetch_array($result))
	{
		$id = $row[0];
		$name= $row[1];
		$value.="<option value=\"$id\">$name</option>";
	}
	 
	 echo $value;
}
?>