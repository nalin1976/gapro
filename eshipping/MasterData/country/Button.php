
<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	$strCountryCode=$_GET["strCountryCode"];
	

    //New & Save
    if($strButton=="New")
	{
	  $strCountry=$_GET["strCountry"];
	  $strCountryCode=$_GET["strCountryCode"];
			
			$SQL_Check="SELECT strCountryCode,intStatus FROM country where strCountryCode='".$strCountryCode."';";
			$result_check = $db->RunQuery($SQL_Check);	
		
			if($row_check = mysql_fetch_array($result_check))
			
			{$strCountryCode=$row_check["strCountryCode"];
			
			  if($row_check["intStatus"]==0)
			  {
			  		$SQL_Update="UPDATE country SET strCountryCode='".$strCountryCode."',strCountry='".$strCountry."',intStatus=1 where strCountryCode='".$strCountryCode."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved SuccessFully";
			  
			  }
			else
			{
			echo "Record all ready Exsists.";
			}
			
			}
	      else
		  {
		  $SQL="insert into country (strCountryCode,strCountry) values ('".$strCountryCode."','".$strCountry."')";
		  
		  $db->ExecuteQuery($SQL);
		    echo "Saved SuccessFully";
			
		  }
	
	
	}










	 	
	// Update
	if($strButton=="Save")
	{    $strCountry=$_GET["strCountry"];
	 
		
		
	$SQL_CheckData="SELECT strCountryCode FROM country where strCountryCode='".$strCountryCode."';";
	$result = $db->RunQuery($SQL_CheckData);	

	if($row = mysql_fetch_array($result))	
	{
		$SQL_Update="UPDATE country SET strCountry='".$strCountry."',intStatus=1 where strCountryCode='".$strCountryCode."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved SuccessFully";			
		//echo $SQL_Update;
	}
		
		}
	
	
		
		//Delete
			 
		if($strButton=="Delete" & $strCountryCode !=null)
		{		
		 $SQL="update country set intStatus=0  where strCountryCode='".$strCountryCode."';";
		 
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted SuccessFully.";
		 }
	
		


?>





