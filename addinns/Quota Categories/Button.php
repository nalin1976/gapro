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
	$strCategoryID =$_GET["strCategoryID"];
	 	
	//Save & Update
	if($strButton=="Save")
	{  
	     $strDescription=$_GET["strDescription"];
	     $strUnit =$_GET["strUnit"];
		 $dblPrice=$_GET["dblPrice"];
		
	$SQL_CheckData="SELECT strCategoryID FROM quotacategories where strCategoryID='".$strCategoryID."';";
	$result = $db->RunQuery($SQL_CheckData);
	
		

	if($row = mysql_fetch_array($result))	
	{
		$SQL_Update="UPDATE quotacategories SET strDescription='".$strDescription."',strUnit='".$strUnit."',dblPrice='".$dblPrice."',intStatus=1 where strCategoryID='".$strCategoryID."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated SuccessFully";			
		//echo $SQL_Update;
	}
	else
	{
			
$SQL = "insert into quotacategories ( strCategoryID,strDescription,strUnit,dblPrice) values ('".$strCategoryID."','".$strDescription."','".$strUnit."','".$dblPrice."');";

		  $db->ExecuteQuery($SQL);
		  //echo "Saved SuccessFully";
			//echo $SQL ;
			
}
			
		}
		
		//New
		
	if($strButton=="New")
		{
		 $strCategoryID =$_GET["strCategoryID"];
		 $strDescription=$_GET["strDescription"];
	     $strUnit =$_GET["strUnit"];
		 $dblPrice=$_GET["dblPrice"];
		 $intStatus=$_GET["intStatus"];
		 
	//	$SQL_CheckData="SELECT strCategoryID FROM quotacategories where strCategoryID='".$strCategoryID."' & intStatus='1';";
		
		$SQL_CheckData="SELECT strCategoryID,intStatus FROM quotacategories where strCategoryID='".$strCategoryID."';";
			
		$result = $db->RunQuery($SQL_CheckData);
		
		if($row = mysql_fetch_array($result))
		{
			if($row["intStatus"]==0)
			{
				$SQL_Update="UPDATE quotacategories SET strDescription='".$strDescription."',strUnit='".$strUnit."',dblPrice='".$dblPrice."',intStatus=1 where strCategoryID='".$strCategoryID."';"; 
			
			 $db->ExecuteQuery($SQL_Update);
				echo "Saved SuccessFully";
			}
			else
			{
				echo "Record Allready Exsists.";
			}
		
		}
	/*	
		else if($intStatus==0)
		{
				$SQL_Update="UPDATE quotacategories SET strDescription='".$strDescription."',strUnit='".$strUnit."',dblPrice='".$dblPrice."',intStatus=1 where strCategoryID='".$strCategoryID."';"; 
		
	   // $db->ExecuteQuery($SQL_Update);
		//echo "Saved SuccessFully";
		}
		*/
		else
		{
		$SQL = "insert into quotacategories ( strCategoryID,strDescription,strUnit,dblPrice) values ('".$strCategoryID."','".$strDescription."','".$strUnit."','".$dblPrice."');";
	
			  $db->ExecuteQuery($SQL);
			  echo "Saved SuccessFully";
		//echo $SQL;
		}
	}	
		
		
		
	
	
		
		//Delete
			 
		if($strButton=="Delete")
		{		
		 $SQL="update quotacategories set intStatus=0  where strCategoryID='".$strCategoryID."';";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted SuccessFully.";
		 }
	
		


?>


</body>
</html>


