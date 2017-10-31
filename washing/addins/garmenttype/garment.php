<?php
include('../../../Connector.php');
	
	$strgarment=trim($_GET["q"]);
	$cboSearch=trim($_GET["cboSearch"]);
	$strGamtDesc=trim($_GET["cboDescrtiption"]);
	$strGarmentName=trim($_GET["txtGarmentName"]);	
	$intStatus=trim($_GET["intStatus"]);
	 
if($strgarment=="New")
{
    $sql_insert="insert into was_garmenttype (strGarmentName,strGamtDesc,intStatus)
  	values
	('$strGarmentName',	 
	 '$strGamtDesc',
	 '$intStatus');"; 
    $db->ExecuteQuery($sql_insert);
    // echo($sql_insert);
    echo "Saved successfully.";
    
}

else if($strgarment=="Save")
{	
    $cboSearch=trim($_GET["cboSearch"]);
	$strGamtDesc=trim($_GET["cboDescrtiption"]);
	$strGarmentName=trim($_GET["txtGarmentName"]);	
	$intStatus=trim($_GET["intStatus"]);
	 
    $SQL_Update="UPDATE was_garmenttype SET strGamtDesc='$strGamtDesc',
                                            strGarmentName='$strGarmentName',
								 		    intStatus='$intStatus'
						                    where intGamtID='$cboSearch'";  
	$db->ExecuteQuery($SQL_Update);
	//echo($SQL_Update);
	echo "Updated successfully.";	
}
else if($strgarment=="Delete")
{	
    $cboSearch=$_GET["cboSearch"];  
	$SQL="delete from was_garmenttype where intGamtID='$cboSearch'";
	$db->ExecuteQuery($SQL);
	//echo($SQL);
	echo "Deleted successfully.";
 }
else if($strgarment=="LoadDetails")
{
	$SQL="SELECT intGamtID ,strGarmentName FROM was_garmenttype order by strGarmentName ASC";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	    {
	echo "<option value=\"". $row["intGamtID"] ."\">" . $row["strGarmentName"] ."</option>" ;
	    }
	
 }
?>