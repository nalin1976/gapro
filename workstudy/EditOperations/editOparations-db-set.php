
<?php

//**************Created by suMitH HarShan 2011-04-29*************

include "../../Connector.php";

$type=$_GET['type'];

if($type=='Save')
{

    $cmbProcessId 		    = $_GET['cmbProcessId'];
	$cboOperationID 		= $_GET['cboOperationID'];
	$cboComponentCatagory 	= $_GET['cboComponentCatagory'];
	$cboComponent 			= $_GET['cboComponent'];
	$txtOperationCode 		= $_GET['txtOperationCode'];
	$txtOperation 			= $_GET['txtOperation'];
	$status 				= $_GET['status'];

//************************Save details******************************************

		if($cboOperationID=="")
		{
			
			$sql_check="SELECT * FROM ws_operations WHERE intProcessId='$cmbProcessId' and  intCompCatId='$cboComponentCatagory' AND intCompId='$cboComponent' AND   strOperationCode='$txtOperationCode' OR strOperationName='$txtOperation' ";
			$result_checked=$db->ExecuteQuery($sql_check);
			if(mysql_num_rows($result_checked))
			{
				echo "Already exist.";
			}
			else
			{			
			
			 $sql_insert="INSERT INTO ws_operations (intCompCatId,intCompId,strOperationCode,strOperationName,intProcessId,intStatus) VALUES('$cboComponentCatagory','$cboComponent','$txtOperationCode','$txtOperation','$cmbProcessId','$status')";	
		    $result_insert= $db->RunQuery($sql_insert);	
			if($result_insert)
			  echo "Saved Succesfully.";
			else
			  echo "Saved Error!";	
			}
		}

//************************Update details******************************************
	
        else
        {
		   $sql_update= "UPDATE ws_operations SET 
		                                           intProcessId     ='$cmbProcessId'
												   intCompCatId		='$cboComponentCatagory', 
												   intCompId		='$cboComponent', 
												   strOperationCode	='$txtOperationCode', 
												   strOperationName	='$txtOperation',
												   intStatus		='$status'
												   WHERE intId = '$cboOperationID'";	
			
			$result_update= $db->RunQuery($sql_update);	
			if($result_update)
			  echo "Updated Succesfully.";
			else
			  echo "Updated Error!";	
	    }

 
	

}
// ******************************delete selected record from the database*********************************************
else if($type=='delete')
{
	$operationID = $_GET['operationID'];

	$sql_delete="DELETE FROM ws_operations WHERE intId='$operationID'";
	$result_delete=$db->RunQuery($sql_delete);
	if($result_delete)
	  echo "Deleted Succesfully.";
	else
	  echo "Deleted Error!";  
}

/*
still not use
//************************************ COMMON COMBO LOAD ***********************************************
function loadcomboDetails($sql)
{
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
}*/

?>