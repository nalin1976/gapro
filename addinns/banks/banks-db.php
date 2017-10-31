<?php

include "../../Connector.php";
	
$strButton=$_GET["q"];
$strBankId=trim($_GET["cboBankID"],' ');
$strBnkCode=trim($_GET["strBankCode"],' ');
$strDescription=$_GET["strName"];
$intStatus=$_GET["intStatus"];
		
//---Save New Record------------------------------------------
if($strButton=="New")
{

 echo $sql_insert  = "INSERT INTO bank (strBankCode,strBankName,intStatus) values
				  ('$strBnkCode','$strDescription','$intStatus')";
 $result = $db->RunQuery($sql_insert);
 if($result!=""){
  echo "Saved successfully.";	
  }
  else{
  echo "Save failed.";	
  }	
  
}
//---Update Existing Record------------------------------------------------------------------------------
if($strButton=="Save")
{  
  $SQL_Update="UPDATE bank SET  strBankCode='$strBnkCode',strBankName='$strDescription',
		                                    intStatus='$intStatus' 
                 WHERE intBankId='$strBankId'"; 
 $result = $db->RunQuery($SQL_Update);
 if($result!=""){
  echo "Updated successfully.";
  }
  else{
  echo "Update failed.";	
  }	
}
//---Delete existing record--------------------------------<a href="../../../gapro/addinns/banks/bank-js.js"></a>------------------------------------------	
if($strButton=="Delete")
{	
 $SQL_Delete="delete from bank  where intBankId='$strBankId'";
 $result = $db->RunQuery2($SQL_Delete);
 if(gettype($result)=='string')
 {
		echo $result;return;
 }
 
  	echo "Deleted successfully.";
 
}
//-----------------------------------------------------------------------------------------
?>