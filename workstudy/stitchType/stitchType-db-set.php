<?php
include('../../Connector.php');	

$type=trim($_GET["type"]);
		 
if($type=="save")
{
	$cboSearch=trim($_GET["cboSearch"]); //intId
	$intId=trim($_GET["txtID"]);
	$strStitchType=trim($_GET["txtStitchType"]);
			 
    if($cboSearch=='')
	{   //insert data				 
	$query="INSERT INTO ws_stitchtype (strStitchType)
	        VALUES
	        ('$strStitchType')";
			
	$message = "Saved successfully."; 	
    }

    else
    {   //update data	 	
    $query="UPDATE ws_stitchtype SET                                  
									   intID='$cboSearch',
									   strStitchType='$strStitchType' 
						               WHERE intID='$cboSearch'";
	
	$message = "Updated successfully.";	
	}
	$result = $db->ExecuteQuery($query);
	if($result)
		echo $message;	
	else	
		echo $query;
			
 }

//delete data
else if($type=="delete")
{	
    $cboSearch=$_GET["cboSearch"];  
	$SQL="DELETE FROM ws_stitchtype WHERE intID='$cboSearch'";
	$db->ExecuteQuery($SQL);
	echo "Deleted successfully.";
 }
 


?>