<?php
session_start();
include "LoginDBManager.php";
include "Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

$dbepl =  new LoginDBManager();

if (strcmp($RequestType,"CheckVerification") == 0)
{
	 $ResponseXML = "";
	 $verificationCode=$_GET["code"];
	 $ResponseXML .= "<ResultSet>\n";
	 $result = "False";
	 //echo $verificationCode . "  " . $_SESSION["captcha"];
	if (strcmp($verificationCode,$_SESSION["captcha"]) == 0)
	{
		$result  = "True";
	}
	$ResponseXML .= "<Result><![CDATA[" . $result  ."]]></Result>\n";

	 $ResponseXML .= "</ResultSet>";
	 echo $ResponseXML;
}
else if (strcmp($RequestType,"CheckUserAvailability") == 0)
{
	
	$ResponseXML = "";
	 $email=$_GET["Email"];
	 $ResponseXML .= "<ResultSet>\n";
	 
	 $result=getUserDetails($email);
	 
	 $ans = "False";
	 while($row = mysql_fetch_array($result))
  	 {
	 	$ans = "True";
		             
	 }
	 $ResponseXML .= "<Result><![CDATA[" . $ans . "]]></Result>\n";  
	 $ResponseXML .= "</ResultSet>";
	 echo $ResponseXML;
}
else if(strcmp($RequestType,"UserPrivil") == 0)
{

	$userPrivilageList=$_GET["PrivilageList"];
	
	$ResponseXML = "";
	$ResponseXML .= "<ResultSet>\n";
	$ResponseXML .= "<Result><![CDATA[" . saveUserPrivilages($userPrivilageList) . "]]></Result>\n";  
	$ResponseXML .= "</ResultSet>"; 
	echo $ResponseXML;
	
	
}
else if(strcmp($RequestType,"UpdatePrivil") == 0)
{

	$userPrivilageList=$_GET["PrivilageList"];
	$userID = $_GET["userID"];
	
	$ResponseXML = "";
	$ResponseXML .= "<ResultSet>\n";
	$ResponseXML .= "<Result><![CDATA[" . updateUserPrivilages($userPrivilageList,$userID) . "]]></Result>\n";  
	$ResponseXML .= "</ResultSet>"; 
	echo $ResponseXML;
	
	
}
else if (strcmp($RequestType,"LockUser") == 0)
{
	$userID = $_GET["userID"];
	
	$sql = "UPDATE useraccounts SET STATUS ='0' WHERE intUserID ='$userID'";
	$db->executeQuery($sql);
}
else if (strcmp($RequestType,"UnLockUser") == 0)
{
	$userID = $_GET["userID"];
	
	$sql = "UPDATE useraccounts SET STATUS ='1' WHERE intUserID ='$userID'";
	$db->executeQuery($sql);
}
else if (strcmp($RequestType,"SetPermission") == 0)
{
	$CategoryID = $_GET["CategoryID"];
	$RoleName = $_GET["RoleName"];
	$RolleDescription = $_GET["RolleDescription"];
	$ResponseXML ="";
	$sql = "insert into role 
	(categoryID, 
	RoleName, 
	roleDescription
	)
	values	 
	('$CategoryID', 
	'$RoleName', 
	'$RolleDescription');";
	$result=$db->RunQuery($sql);
	if($result==1)
		$result = "True";
	else
		$result = "False";
		$ResponseXML .= "<Result><![CDATA[" . $result  ."]]></Result>\n";
	echo $ResponseXML;	
}

function getUserDetails($email)
{
	global $dbepl;
	$sql="select UserID from users where UserName = '" . $email . "';";
	return $dbepl->RunQuery($sql);
}

function saveUserData($userName,$passWord,$CompnyId)
{
	global $dbepl;
	$passWordEncrip=md5($passWord);
	$userID=0;
	$sql="INSERT INTO users(UserName,Password,CompanyID) VALUES ('".$userName."','".$passWordEncrip."',".$CompnyId.");";
	$dbepl->ExecuteQuery($sql);
	
	$sql="SELECT UserID FROM users WHERE UserName='".$userName."';";
	$result=$dbepl->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$userID=$row["UserID"];
	}
	
	return $userID;
	//INSERT INTO user(intUserID,UserName,Password,Name) VALUES ();
	//INSERT INTO users(UserID,UserName,Password,CompanyID) VALUES ();
	
}

function saveUserPrivilages($privilageList)
{
	global $db;
	$validate=0;

	$userName=$_SESSION["NewUseremailAddress"];
	$passWord=$_SESSION["NewUserPasword"];
	$CompnyId=$_SESSION["CompanyID"];
	$name=$_SESSION["NewUserName"];
	$factory = $_SESSION["NewCompanyID"];
	$userID=saveUserData($userName,$passWord,$CompnyId);
	if($userID>0)
	{
	$sql="INSERT INTO useraccounts(intUserID,UserName,Password,Name,intCompanyID)VALUES (".$userID.",'".$userName."','".md5($passWord)."','".$name."',$factory);";
	if($db->ExecuteQuery($sql))$validate++;

	$privil=explode(",",$privilageList);
	$arrayCount=sizeof($privil);
	$PrivilageLength=strlen($privilageList);
	foreach($privil AS $values)
	{
		$sql="INSERT INTO userpermission(intUserID,RoleID) VALUES(".$userID.",".$values.");";
		if($db->ExecuteQuery($sql)) $validate++;

		
	}
	if($validate==$arrayCount+1)
	{
		return "True";
	}
	else
	{
		return "False";
	}
	}

	
}

function updateUserPrivilages($privilageList,$userID)
{
	global $db;
	$validate=0;

		$sql = "DELETE FROM userpermission WHERE intUserID = $userID AND RoleID NOT IN ($privilageList)";
		$db->ExecuteQuery($sql);
		$privil=explode(",",$privilageList);
		$arrayCount=sizeof($privil);
		$PrivilageLength=strlen($privilageList);
		foreach($privil AS $values)
		{
			$sql="INSERT INTO userpermission(intUserID,RoleID) VALUES(".$userID.",".$values.");";
			//echo $sql;
			$db->ExecuteQuery($sql);			
		}

			return "True";



	
}

