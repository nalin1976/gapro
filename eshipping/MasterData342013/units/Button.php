<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	$strUnit=$_GET["strUnit"];
	 
	 //New
	 if($strButton=="New")
	 {
	     $strTitle=$_GET["strTitle"];
	     $intPcsForUnit=$_GET["intPcsForUnit"];
		 if($intPcsForUnit=="")
		 $intPcsForUnit=0;
		 
		 $SQL_CheckData="SELECT strUnit,intStatus FROM units where strUnit='".$strUnit."';";
	$result = $db->RunQuery($SQL_CheckData);	

	if($row = mysql_fetch_array($result))
	{
	$strUnit=$row["strUnit"];
	
	if($row["intStatus"]==0)
	{
			$SQL_Update="UPDATE units SET strTitle='".$strTitle."',intPcsForUnit='". $intPcsForUnit."',intStatus=1 where strUnit='".$strUnit."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved SuccessFully";
	}
	else
	{
	echo"Record All Ready Exsists";
	}
	
	}
	else
	{
	$SQL = "insert into units ( strUnit,strTitle,intPcsForUnit) values ('".$strUnit."','".$strTitle."','".$intPcsForUnit."');";

			$db->ExecuteQuery($SQL);
		    echo "Saved SuccessFully";
	}
	 
	 
	 
	 }
	 
	 	
	//Update
	if($strButton=="Save")
	{    
	     $strUnit=$_GET["strUnit"];
	     $strTitle=$_GET["strTitle"];
	     $intPcsForUnit=$_GET["intPcsForUnit"];
		 if($intPcsForUnit=="")
		 $intPcsForUnit=0;
		
		
	$SQL_CheckData="SELECT strUnit FROM units where strUnit='".$strUnit."';";
	$result = $db->RunQuery($SQL_CheckData);	

	if($row = mysql_fetch_array($result))	
	{
		$SQL_Update="UPDATE units SET strTitle='".$strTitle."',intPcsForUnit='". $intPcsForUnit."',intStatus=1 where strUnit='".$strUnit."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved SuccessFully";			
		//echo $SQL_Update;
	}
			
		}
	
	
		
		//Delete
			 
		if($strButton=="Delete")
		{		
		 $SQL="update units set intStatus=0  where strUnit='".$strUnit."';";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted SuccessFully.";
		 }
	
		


?>

</body>
</html>
