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
	$strCurrency=$_GET["strCurrency"];
	
	//New & Save
	if($strButton=="New")
	{
	
	 $strTitle=$_GET["strTitle"];
	 $dblRate=$_GET["dblRate"];
	 $strFraction = $_GET["strFraction"];
	 
	 if($dblRate=="")
	 $dblRate=0;
	
		$SQL_CheckData="SELECT strCurrency,intStatus FROM currencytypes where strCurrency='".$strCurrency."';";
		$result = $db->RunQuery($SQL_CheckData);	
	
		if($row = mysql_fetch_array($result))
		{ $strCurrency=$row["strCurrency"];
		
		if($row["intStatus"]==0)
		{
				$SQL_Update="UPDATE currencytypes SET strCurrency='".$strCurrency."',strTitle='".$strTitle."',dblRate=".$dblRate.",intStatus=1, strFractionalUnit= '$strFraction' where strCurrency='".$strCurrency."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved SuccessFully";
		}
		else
		{
		echo "Record all ready Exsist";
		}
		
		}
	else
	{
	$SQL = "insert into currencytypes ( strCurrency,strTitle,dblRate,strFractionalUnit) values ('".$strCurrency."','".$strTitle."','".$dblRate."','$strFraction');";

			$db->ExecuteQuery($SQL);
		    echo "Saved SuccessFully";
	}
	
	} 
	 
	 	 	
	//Update
	if($strButton=="Save")
	
	{
	 $strTitle=$_GET["strTitle"];
	 $dblRate=$_GET["dblRate"];
	  $strFraction = $_GET["strFraction"];
	 
	if($dblRate=="")
	$dblRate==0;
		
		
	$SQL_CheckData="SELECT strCurrency FROM currencytypes where strCurrency='".$strCurrency."';";
	$result = $db->RunQuery($SQL_CheckData);	

	if($row = mysql_fetch_array($result))	
	{
		$SQL_Update="UPDATE currencytypes SET strCurrency='".$strCurrency."',strTitle='".$strTitle."',dblRate='".$dblRate."',intStatus=1, strFractionalUnit= '$strFraction' where strCurrency='".$strCurrency."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated SuccessFully";			
		//echo $SQL_Update;
	}

			
		}
	
	
		
		//Delete
			 
		if($strButton=="Delete" & $strCurrency != null)
		{		
		 $SQL="update currencytypes set intStatus=0  where strCurrency='".$strCurrency."';";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted SuccessFully.";
		 }
	
		


?>

</body>
</html>
