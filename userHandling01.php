<?php
session_start();
include "LoginDBManager.php";
include "Connector.php";
$CompnyId	=	$_SESSION["CompanyID"];
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
//Start 06-12-2010 - Edit user page details
else if (strcmp($RequestType,"LoadUserDetails") == 0)
{
$ResponseXML = "<XMLLoadUserDetails>";
$UserId = $_GET["userId"];

	$sql="select UserName,UA.Name,intExPercentage,intUserID from useraccounts UA where UA.intUserID=$UserId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<EmailAddress><![CDATA[" . $row["UserName"]  . "]]></EmailAddress>\n";
		$ResponseXML .= "<EmailAddress1><![CDATA[" . $row["intUserID"]  . "]]></EmailAddress1>\n";
		$ResponseXML .= "<UserName><![CDATA[" . $row["Name"]  . "]]></UserName>\n";		
		$ResponseXML .= "<ExPercentage><![CDATA[" . $row["intExPercentage"]  . "]]></ExPercentage>\n";
	}
 $ResponseXML .= "</XMLLoadUserDetails>";
 echo $ResponseXML;
}
else if (strcmp($RequestType,"LoadUserCompany") == 0)
{
$ResponseXML = "<XMLLoadUserCompany>";
$UserId = $_GET["userId"];

	$sql="select intCompanyID,strName from companies where intStatus=1 order by strName";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<CompanyName><![CDATA[" . $row["strName"]  . "]]></CompanyName>\n";
		$ResponseXML .= "<CompanyId><![CDATA[" . $row["intCompanyID"]  . "]]></CompanyId>\n";
		$ResponseXML .= "<Status><![CDATA[" . GetUserCompanyStats($UserId,$row["intCompanyID"]) . "]]></Status>\n";		
	}
 $ResponseXML .= "</XMLLoadUserCompany>";
 echo $ResponseXML;
}
else if (strcmp($RequestType,"CheckEditUserAvailability") == 0)
{
$email	= $_GET["Email"];
$userId	= $_GET["userId"];
$ResponseXML = "<ResultSet>\n";

	$sql="select UserID from users where UserName = '" . $email . "' and UserID <> $userId;";
	$result=$dbepl->RunQuery($sql);	 
	$ans = "False";
	while($row = mysql_fetch_array($result))
  	{
		$ans = "True";
	}
		$ResponseXML .= "<Result><![CDATA[" . $ans . "]]></Result>\n";  
$ResponseXML .= "</ResultSet>";
echo $ResponseXML;
}
else if(strcmp($RequestType,"EditUserDetails") == 0)
{
$ResponseXML   .= "<ResultSet>\n";
$Email			= $_GET["Email"];
$passwoard		= $_GET["passwoard"];
$userName		= $_GET["userName"];
$userId			= $_GET["userId"];
$exGenPercent	= $_GET["exGenPercent"];
$CompnyId	   	= $_SESSION["CompanyID"];
$companies 		= explode(',',$_GET["companies"]);
$count 			= count($companies);
	
$fieldPw = "";
if($passwoard!=""){
	$passWordEncrip = md5($passwoard);
	$fieldPw		= ",Password = '$passWordEncrip'";
}

	$sql_users = "update users set UserName = '$Email' $fieldPw , CompanyID = '$CompnyId' where UserID = '$userId' ";
	$dbepl->ExecuteQuery($sql_users);
	
	$sql_ua="update useraccounts set UserName = '$Email' $fieldPw ,Name = '$userName',intCompanyID = '$companies[0]',status = '1',intExPercentage='$exGenPercent' where intUserID = '$userId' ;";
	$db->ExecuteQuery($sql_ua);
	
	$sql_del ="delete from usercompany where userId=$userId";
	$db->ExecuteQuery($sql_del);
	

	for($i=0;$i<=$count;$i++)
	{
		if(trim($companies[$i])!='')
		{
			$sql = "INSERT INTO usercompany (userId,companyId) values('$userId','$companies[$i]')";
			$db->ExecuteQuery($sql);
		}
	}
	$ResponseXML .= "<Result><![CDATA[" . "Updated successfully." . "]]></Result>\n";
$ResponseXML .= "</ResultSet>";
echo $ResponseXML;
}
//End 06-12-2010 - Edit user page details

//Start - 06-12-2010 - Functions
function GetUserCompanyStats($UserId,$companyId)
{
global $db;
$boo = 0 ;
	$sql="select userId from usercompany where userId=$UserId and companyId=$companyId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$boo = 1 ;
	}
return $boo;
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
		$privilageListA = ($privilageList=='' ? 0:$privilageList);
		$sql = "DELETE FROM userpermission WHERE intUserID = $userID AND RoleID NOT IN ($privilageListA)";
		$db->ExecuteQuery($sql);
		$privil=explode(",",$privilageList);
		$arrayCount=sizeof($privil);
		$PrivilageLength=strlen($privilageList);
		foreach($privil AS $values)
		{
			$sql="INSERT INTO userpermission(intUserID,RoleID) VALUES(".$userID.",".$values.");";
			$db->ExecuteQuery($sql);			
		}

			return "True";
}
//End - 06-12-2010 - Functions