<?php
include('../../Connector.php');	
 $type=trim($_GET["type"]);
	
	 
if($type=="save")
{	
	//$texD=trim($_GET["q"]);
	$cboSearch=trim($_GET["cboSearch"]);  //intId
	$intID=trim($_GET["txtId"]);
	$strDescription=trim($_GET["txtDescription"]);
	
			 
	if($cboSearch =='')
	{	//insert data		 
		$query="INSERT INTO ws_tex(strDescription)
		VALUES
		('$strDescription')"; 
		$message = "Saved successfully."; 
	
	}

	else
	{  //update data		
	   $query="UPDATE ws_tex SET  	strDescription='$strDescription'
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
	$SQL="DELETE FROM ws_tex WHERE intID='$cboSearch'";
	$db->ExecuteQuery($SQL);
	
	echo "Deleted successfully.";
 }
 

?>