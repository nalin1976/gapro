<?php
	include('../../../Connector.php');
	
	$stroperato=trim($_GET["q"]);
	$strSearch=trim($_GET["stroperatorsName"]);
	$strMachineName=trim($_GET["cboMachineName"]);
	$strShift=trim($_GET["cboShitf"]);
	$strName=trim($_GET["txtName"]);	 	
	$strRemarks=trim($_GET["txtRemarks"]);
    $intStatus=trim($_GET["intStatus"]);
if($stroperato=="New")
{
  $sql_insert="insert into was_operators (strName,intMachineId,strShift,strRemarks,intStatus)
  	values
	('$strName', 
	'$strMachineName', 
	'$strShift', 
	'$strRemarks','$intStatus');"; 
 $db->ExecuteQuery($sql_insert);
 //echo($sql_insert);
 echo "Saved successfully.";
 
}
else if($stroperato=="Save")
{	
   $cboSearch=$_GET["cboSearch"]; 
   $strMachineName=$_GET["cboMachineName"]; 
   $strShift=$_GET["cboShitf"]; 
   $strName = $_GET["txtName"]; 
   $strRemarks = $_GET["txtRemarks"];
   $intStatus=$_GET["intStatus"];
   $SQL_Update="UPDATE was_operators SET  intMachineId='$strMachineName',
								 strShift='$strShift',
								 strName='$strName',
								 strRemarks='$strRemarks',
								 intStatus='$intStatus'
						where intOperatorId='$cboSearch'";  
	$db->ExecuteQuery($SQL_Update);
	//echo($SQL_Update);
	echo "Updated successfully.";	
}
	else if($stroperato=="Delete")
		{	
		  $cboSearch=$_GET["cboSearch"];  
		 $SQL="delete from was_operators where intOperatorId='$cboSearch'";
		 $db->ExecuteQuery($SQL);
		// echo($SQL);
		 echo "Deleted successfully.";
		 }
		else if($stroperato=="LoadDetails"){
		$SQL="SELECT intOperatorId ,strName FROM was_operators WHERE intStatus <> 10 order by strName ASC";
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intOperatorId"] ."\">" . $row["strName"] ."</option>" ;
		}
	
	}
?>