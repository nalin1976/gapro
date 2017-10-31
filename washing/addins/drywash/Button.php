<?php
include "../../../Connector.php";

$strButton=trim($_GET["q"],' ');

if($strButton=="New")
{	
$strDryCode	= trim($_GET["strDryCode"],' ');
$strDes		= trim($_GET["strDes"],' ');
$intStatus	= $_GET["intStatus"];
$category	= $_GET["Category"];
$FSCategory	= $_GET["FSCategory"];	
$strcondition=$_GET["strcondition"];
$dryprocess_cboDryProcess =$_GET["dryprocess_cboDryProcess"];
$serialNo =$_GET["serialNo"];	
$description =$_GET["description"];	

$sql_insert  = "INSERT INTO was_dryprocess (strDryProCode,strDescription,intStatus,strCategory,FScategory,strCondition) values
			 ('$strDryCode','$strDes','$intStatus','$category',$FSCategory,'$strcondition')";	 
$db->ExecuteQuery($sql_insert);	

echo "Saved Successfully";
/*if($result  == '1'){	
echo '1';
}else{
echo '0';
}	*/
}
if($strButton=="updateHeader")
{
$dryprocess_cboDryProcess =$_GET["dryprocess_cboDryProcess"];	
$dryprocess_txtcode =$_GET["dryprocess_txtcode"];	
$dryprocess_txtDes =$_GET["dryprocess_txtDes"];	

$SQL1 = "update was_dryprocess set strDryProCode  ='$dryprocess_txtcode',
                                   strDescription ='$dryprocess_txtDes'
		 where intSerialNo = '$dryprocess_cboDryProcess'";
$db->ExecuteQuery($SQL1);

 $SQL2 = "DELETE FROM process_termsandcondition WHERE intProcessId ='$cboDryProcess'";  
 $db->ExecuteQuery($SQL2);
 
}


if($strButton=="Save")
{  
$strDryID	= $_GET["strDryID"];
$strDryCode	= trim($_GET["strDryCode"],' ');
$strDes		= trim($_GET["strDes"],' ');
$intStatus	= $_GET["intStatus"];
$category	= $_GET["Category"];
$FSCategory	= $_GET["FSCategory"];	
$strcondition=$_GET["strcondition"];
$dryprocess_cboDryProcess =$_GET["dryprocess_cboDryProcess"];
$serialNo =$_GET["serialNo"];	
$description =$_GET["description"];	
			 
$sql_update = "update was_dryprocess set strDryProCode='$strDryCode',strDescription='$strDes',intStatus='$intStatus',strCategory='$category',FScategory='$FSCategory',
               strCondition='$strcondition' WHERE intSerialNo='$strDryID'  ";			 
$db->ExecuteQuery($sql_update);	
 //echo "Updated Successfully";
if($result  == '1'){	
echo '1';
}else{
echo '0';
}					
}


if($strButton=="Delete")
{
	$strDryID= $_GET["strDryID"];
	echo $strDryID; 
	$SQL = "delete from  was_dryprocess  where intSerialNo='$strDryID'";
	$db->ExecuteQuery($SQL);
	
	echo "Deleted successfully.";
}
else if($strButton=="loadLastNo")
{
	$Dryload= $_GET["Dryload"];
	$SQL = "SELECT * FROM process_termsandcondition where intProcessId='$Dryload' order by intTermId desc limit 1;";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	echo $row['intTermId']+1; 	
}

//---------------------------------------------------------------------------------------------------------------------

if($strButton=="deleteBeforeSave")
{  
 $dryprocess_cboDryProcess= $_GET["dryprocess_cboDryProcess"];
 
 $SQL = "DELETE FROM process_termsandcondition WHERE intProcessId ='$dryprocess_cboDryProcess'";  
 $result = $db->ExecuteQuery($SQL);
 
 if($result == '1'){
  echo 1;
 }else{
  echo 0;
 }
}

//--------------------------------------------------------------------------------------------------------------------------

if($strButton=="saveDetails")
{  
 $cboDryProcess= $_GET["cboDryProcess"];
 $serialNo= $_GET["serialno"];
 $condition= $_GET["condition"];
 
 $sql_insert1  = "INSERT INTO process_termsandcondition (intProcessId,intTermId,strDescription) values
			 ('$cboDryProcess','$serialNo','$condition')";	
 $result = $db->ExecuteQuery($sql_insert1);
}

//---------------------------------------------------------------------------------------------------------------------------


?>