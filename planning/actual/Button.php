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

	
	//--------------------------------------------------------------------------------------------
	
	if($strButton=="New")
	{
	    $strSeasonId=$_GET["strSeasonID"];
		$strSeasonCode=$_GET["strSeasonCode"];
	    $strSeason=$_GET["strSeason"];
		$strRemarks=$_GET["strRemarks"];
		$intStatus=$_GET["intStatus"];
     $SQL_Check="SELECT * FROM seasons where strSeasonCode='$strSeasonCode' AND intStatus != '10'";
	 $result_check = $db->RunQuery($SQL_Check);	
	 if(mysql_num_rows($result_check)){
	 echo "Season Code Already Exists";
	 }else{
	  $sql_insert  = "INSERT INTO seasons (strSeasonCode,strSeason,strRemarks,intStatus) values
	                  ('$strSeasonCode','$strSeason','$strRemarks','$intStatus')";
	  $db->ExecuteQuery($sql_insert);		
	  echo "Saved SuccessFully";		  
	 // echo $sql_insert; 				  
	 }
	}


	// Update
	if($strButton=="Save")
	{  
		$strSeasonId=$_GET["strSeasonID"];
		$strSeasonCode=$_GET["strSeasonCode"];
	    $strSeason=$_GET["strSeason"];
		$strRemarks=$_GET["strRemarks"];
		$intStatus=$_GET["intStatus"];
	 $SQL_Update="UPDATE seasons SET  strSeasonCode='$strSeasonCode',
		                             strSeason='$strSeason',
		                             intStatus='$intStatus',
									 strRemarks='$strRemarks' 
                 WHERE intSeasonId='$strSeasonId'"; 
		//echo $SQL_Update;
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated SuccessFully";			

  }
	
	
		//Delete
			 
		if($strButton=="Delete")
		{		
		
		 $strSeasonId=$_GET["strSeasonID"];
		 $SQL="update seasons set intStatus='10'  where intSeasonId='$strSeasonId';";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted SuccessFully.";
		 }
	
?>
</body>
</html>
