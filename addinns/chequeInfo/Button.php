
<?php
	include "../../Connector.php";
	
//-----------------------------------------------------------------------------------------------------
	$strButton=$_GET["q"];
	
	$cbofrmChequeInfoList=trim($_GET["cbofrmChequeInfoList"],' ');
	$txtChequeBookName=trim($_GET["txtChequeBookName"],' ');
	$cboBankName=trim($_GET["cboBankName"],' ');
	$cboBranchName=trim($_GET["cboBranchName"],' ');
	$txtStartNo=trim($_GET["txtStartNo"],' ');
	$txtEndNo	=trim($_GET["txtEndNo"],' ');
	$intStatus  = trim($_GET["intStatus"]);
//------------------------------------------------------------------------------------------------------	
if($strButton=="New")
{
	 $sql_insert  = 
	 "INSERT INTO bankchequeinfo (strName,intBankID,intBranchId,intStartNo,intEndNo,intStatus) values
	('$txtChequeBookName','$cboBankName','$cboBranchName','$txtStartNo','$txtEndNo',$intStatus)";
	 $result = $db->RunQuery($sql_insert);
	 if($result!=""){
	  echo "Saved successfully.";	
	  }
	  else{
	  echo "Save failed.";	
	  }	
}
//---------------------------------------------------------------------------------------------------
else if($strButton=="Save")
{ 
	  $SQL_Update="UPDATE bankchequeinfo SET strName='$txtChequeBookName',intBankID='$cboBankName',intBranchId='$cboBranchName',intStartNo='$txtStartNo',intEndNo='$txtEndNo', intStatus = $intStatus WHERE intId='$cbofrmChequeInfoList'"; 
	 $result = $db->RunQuery($SQL_Update);
	 if($result!=""){
	  echo "Updated successfully.";	
	  }
	  else{
	  echo "Update failed.";	
	  }	
}
//-----------------------------------------------------------------------------------------------	
else if($strButton=="Delete")
{	
	$cbofrmChequeInfoList = $_GET["cbofrmChequeInfoList"]; 	
 $SQL_delete="DELETE FROM bankchequeinfo  where intId='$cbofrmChequeInfoList'";
	 $result = $db->RunQuery($SQL_delete);
	 if($result!=""){
	  echo "Deleted successfully.";	
	  }
	  else{
	  echo "Delete failed.";	
	  }	
}
//-------------------------------------------------------------------------------------------------		 
else if($strButton =="cheques")
{
	$SQL = "SELECT intId,strName from bankchequeinfo ORDER BY strName";	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intId"] ."\">" . $row["strName"] ."</option>" ;
	}
}
?>