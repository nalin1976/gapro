<?php

session_start();
include "LoginDBManager.php";
include "Connector.php";

$dbepl =  new LoginDBManager();

saveUserPrivilages();


function saveUserPrivilages()
{
	global $db;
	

	$userName		= $_POST["txtemailaddress"];
	$passWord		= $_POST["txtpassword"];
	$CompnyId		= $_SESSION["CompanyID"];
	$name			= $_POST["txtname"];
	$exGrnPercent	= $_POST["txtExGrnPercent"];	
	$factory 		= explode(',',$_POST["txtFactory"]);
	
	$userID=saveUserData($userName,$passWord,$CompnyId);
	if($userID>0)
	{
		//add records to userCompany table
		$count = count($factory);
		for($i=0;$i<=$count;$i++)
		{
			if(trim($factory[$i])!='')
			{
				$sql = "INSERT INTO usercompany (userId,companyId) values('$userID','$factory[$i]')";
				$db->ExecuteQuery($sql);
			}
		}

		$sql="INSERT INTO useraccounts(intUserID,UserName,Password,Name,intCompanyID,intExPercentage)VALUES (".$userID.",'".$userName."','".md5($passWord)."','".$name."',$factory[0],'$exGrnPercent');";
		$db->ExecuteQuery($sql);
		if($_POST["chkCopy"] == "on")	
		{
			$sql = "INSERT INTO userpermission (intUserID,RoleID) (SELECT $userID,RoleID FROM userpermission WHERE intUserID = '" . $_POST["cboCopy"]. "' )";
			$db->ExecuteQuery($sql);
			echo "<META HTTP-EQUIV=\"Refresh\" Content=\"0; URL=userManager.php\">";
		}
		else
		{
			echo "<META HTTP-EQUIV=\"Refresh\" Content=\"0; URL=permissionManager.php?userID=$userID\">";
		}
	}	
}


function saveUserData($userName,$passWord,$CompnyId)
{
global $dbepl;
$passWordEncrip	= md5($passWord);
$userID			= 0;

	$sql="INSERT INTO users(UserName,Password,CompanyID) VALUES ('".$userName."','".$passWordEncrip."',".$CompnyId.");";
	$dbepl->ExecuteQuery($sql);
	
	$sql="SELECT UserID FROM users WHERE UserName='".$userName."';";
	$result=$dbepl->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$userID=$row["UserID"];
	}
	return $userID;
}

?>