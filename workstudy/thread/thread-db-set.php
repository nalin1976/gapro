<?php
include('../../Connector.php');	

$type=trim($_GET["type"]);
	
	 
if($type=="save")
{
	$cboSearch=trim($_GET["cboSearch"]);
	$intID=trim($_GET["txtID"]);
	$txtDescription=trim($_GET["txtDescription"]);
	$codeNumber=trim($_GET["codeNumber"]);
	
			 
    if($cboSearch=='')  //insert data
    {			 
		$query="INSERT INTO ws_thread(strthread,strCode)
		VALUES
		('$txtDescription',
		'$codeNumber')"; 
		
		$message = "Saved successfully."; 
	}
	else  //update data
	{
		$query="UPDATE ws_thread SET  strthread='$txtDescription', 
                                      strCode='$codeNumber'
								      WHERE intID='$cboSearch'";
	echo "Updated successfully.";
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
	$SQL="DELETE FROM ws_thread WHERE intID='$cboSearch'";
	$db->ExecuteQuery($SQL);
	echo "Deleted successfully.";
 }
 

?>