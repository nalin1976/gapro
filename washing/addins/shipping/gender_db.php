<?php
include_once('../../../Connector.php');
$request=trim($_GET['req']);

$genderCode=$_GET["genderCode"];
$description=$_GET["description"];
$intStatus=trim($_GET["intStatus"]);
if($request=="save")
{
	$SQL_chk="SELECT * FROM gender WHERE strGenderCode='$genderCode';";
	$resChk=$db->RunQuery($SQL_chk);
	//echo $SQL_chk;
	if(mysql_num_rows($resChk) > 0)
	{ 
		
	 echo "Record allready exist.";	
	}
	else
	{
		 $sql_insert="insert into gender (strGenderCode,strDescription,intStatus)
			values
			('$genderCode',
			'$description','$intStatus');"; 
			 $db->ExecuteQuery($sql_insert);
		// echo($sql_insert);
		 echo "Saved successfully.";
	}
}
if($request=="update")
{
	$cboVal=$_GET['cboVal'];
	$SQL_Update="UPDATE gender SET strGenderCode ='$genderCode',
									 strDescription='$description',
									  intStatus='$intStatus'
									 where intGenderId='$cboVal'";  
		$db->ExecuteQuery($SQL_Update);
		//echo($SQL_Update);
		echo "Updated successfully.";
		
}
  
?>