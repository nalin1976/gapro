
<?php
	include "../../Connector.php";
	

	$strButton=$_GET["q"];
	$cboCountryList=trim($_GET["cboCountryList"],' ');
	$strCountryCode=trim($_GET["strCountryCode"],' ');
	$strCountry=trim($_GET["strCountry"],' ');
	$intStatus=trim($_GET["intStatus"],' ');
	$zipCode	=trim($_GET["strZipCode"],' ');
	
if($strButton=="New")
{
  $sql_insert  = "INSERT INTO country (strCountryCode,strCountry,strZipCode,intStatus) values
				  ('$strCountryCode','$strCountry','$zipCode','$intStatus')";
  $db->ExecuteQuery($sql_insert);		
  echo "Saved successfully.";		  
  
}
else if($strButton=="Save")
{ 
	  $SQL_Update="UPDATE country SET strCountryCode='$strCountryCode',strCountry='$strCountry',strZipCode='$zipCode',intStatus='$intStatus'WHERE intConID='$cboCountryList'"; 
  $db->ExecuteQuery($SQL_Update);		
  echo "Updated successfully.";			
}	
else if($strButton=="Delete")
{	
	$txtCountryList = $_GET["cboCountryList"]; 	
 $SQL="DELETE FROM country  where intConID='$txtCountryList'";
// echo $SQL;
 $result = $db->RunQuery2($SQL);
 if(gettype($result)=='string')
 {
	echo $result;
	return;
 }

 echo "Deleted successfully.";
}		 
else if($strButton =="countries")
{
	$SQL = "SELECT country.intConID, country.strCountry FROM country where intStatus<>10 order by strCountry asc;";	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}
}
?>