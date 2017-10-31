<?php
session_start();
include "${backwardseperator}mobile/mobiledetect.php";

if(detect_mobile_device()){
header("Location:${backwardseperator}mobile/mobilogin.php");
exit;
}

$main_url_project = substr($_SERVER["REQUEST_URI"],1,strpos($_SERVER["REQUEST_URI"],'/',1)-1);
if(isset($_SESSION["Server"]) && ($main_url_project==$_SESSION["Project"]))
{
	$page = "main.php";
	if(isset($_SESSION["Requested_Page"]))
		$page = $_SESSION["Requested_Page"];
	header("Location:${backwardseperator}$page");
	exit;
}

//die($_SESSION["Project"]);
// -----------------------------------------------------

$UserName = $_POST["txtusername"];	
	
	if ($UserName != null)
	{	
		$Password =  $_POST["txtPassword"];
		
		$xml = simplexml_load_file("${backwardseperator}config.xml");
		$networkName = $xml->companySettings->NetworkName;
		$pos = strpos($UserName, "@");
	
		if ($pos == '')
		{
			$UserName .= "@" .$networkName;
		}
		
		include 'LoginDBManager.php';		
		
		$db =  new LoginDBManager();
		$SQL = "SELECT users.UserID, users.UserName, users.Password, users.CompanyID, company.CompanyName, " .
				" company.Server, company.UserName, company.Password, company.db " .
				"FROM company INNER JOIN users ON company.CompanyID = users.CompanyID ".
				"WHERE (((users.UserName)='".$UserName."') AND ((users.Password)='". md5($Password) .		
				"'));";
		//$SQL ="SELECT UserID FROM users where UserName='". $UserName."' and Password='". md5($Password) ."';";
		//echo $SQL;
		$result = $db->RunQuery($SQL);
		$validUser = false;
		$db = NULL;
		$message = "Invalid UserName or Password";
		while($row = mysql_fetch_array($result))
		{
			$_SESSION["UserID"] = $row["UserID"];
			$_SESSION["CompanyID"] = $row["CompanyID"];
			$_SESSION["Server"] = $row["Server"];
			$_SESSION["UserName"] = $row["UserName"];
			$_SESSION["Password"] = $row["Password"];
			$_SESSION["Database"] = $row["db"];
			$_SESSION["Project"] = $main_url_project;


			
			include "Connector.php";
			$SQL = "select intUserID,UserName,Password,Name,intCompanyID from useraccounts  where intUserID = ". $row["UserID"] . " and status=1;";
			$resultset = $db->RunQuery($SQL);
			while($rowresult = mysql_fetch_array($resultset))
			{
				$validUser = true; 
				$_SESSION["FactoryID"] = $rowresult["intCompanyID"];
			}
			
			$check_db="select intBaseCurrency,intBaseCountry from systemconfiguration";
			$results_check=$db->RunQuery($check_db);
			$row_sys=mysql_fetch_array($results_check);
			$currency=$row_sys["intBaseCurrency"];
			$country=$row_sys["intBaseCountry"];
			$_SESSION["sys_currency"] =$currency;
			$_SESSION["sys_country"] =$country;

			$userlogin = true;
			include "${backwardseperator}usertracking.php";
			
			if(!$validUser)
			{
				session_unset(); 
				session_destroy(); 
				$message = "Sorry! Your account has been disabled by the system administrator.";
			}
		}
		
		if ($validUser)
		{
			//echo "Logged In";
			//echo $_POST["requestedPage"];
			//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php">';
			//header( 'Location: main.php' ) ;
			if(!isset($_POST["requestedPage"]))	
				header("Location:${backwardseperator}main.php");
			else if ($_POST["requestedPage"] == "/gapro/login.php")
				header("Location:${backwardseperator}main.php");
			else
				header("Location:" . $_POST["requestedPage"]);
			exit;
		}	
	}

// -----------------------------------------------------

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login - GaPro ERP</title>
<link href="<?php echo $backwardseperator; ?>css/erpstyle.css" rel="stylesheet" type="text/css" />

</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript">

function IsvalidData()
	{
	if(document.getElementById("txtusername").value =="")
		{
		alert("Please Enter Email Address");
		document.getElementById("txtusername").focus();
		return false;
		}
	else if(!isValidEmail(document.getElementById("txtusername").value))
		{
		alert("Please Enter Valid Email");		
		document.getElementById("txtusername").focus();
		return false;
		}
		else
		document.getElementById('frmpassword').submit();
	}

function isValidEmail(emailaddress)

       {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailaddress))
            {       
                   
                   return true;
                   
                   
             }                     
            return false;
        }   
</script>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	background-color: #000033;
}
.fuch {
	font-family: Verdana;
}
.inner {
	left: 20%;
	position: absolute;
	top: 25%;
}
#apDiv2 {
	position:absolute;
	width:640px;
	height:335px;
	z-index:1;
}
body {
	/*background:url(images/loginbg.jpg) repeat-x;*/
	/*background-color:#f0ede9;*/
}
#Layer1 {
	position:absolute;
	left:225px;
	top:372px;
	width:638px;
	height:193px;
	z-index:2;
	#border-style:solid;
	#border-color:#0000FF;
	#background-color:#FFFFFF;
}
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style5 {
	font-size: 20px;
	font-family: Verdana;
	color: #990000;
}

.normalfntgap {
	font-family: Verdana;
	font-size: 11px;
	color: #73716e;
	margin: 0px;
	font-weight: normal;
	text-align:justify;
	padding:10px;
	width:600px;
}

.mainLayer{
	width:700px;
	height:300px;
	margin-top:80px;
	background-color:#ffffff;
	-moz-border-radius:10px;
	-moz-box-shadow: 0 0 5px rgba(0,0,0,1);
	border-bottom:13px solid #fb8d1a;
	border-top:25px solid #fb8d1a;
	border-top-left-radius:10px;
	/*box-shadow: 10px 10px 5px #888;*/
}

.normalfnt_size20 {
	font-family: Verdana;
	font-size: 21px;
	color: #fb8d1a;
	font-weight: normal;
	text-align:left;
}

.normalfntlogin {
	font-family: Verdana;
	font-size: 11px;
	color: #fb8d1a;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}

.forgotpass {
	font-family: Verdana;
	font-size: 11px;
	color: #fb8d1a;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	margin-left:3px;
}

.forgotpass:hover {
	font-family: Verdana;
	font-size: 11px;
	color: #79430b;
	margin: 0px;
	font-weight: bold;
	text-align:left;
}

.trans_login{
	position:relative;
	top : -23px; left:-1px; width:100%; height:20px;
	text-align:center;
	font-size: 12px;
	font-family: Verdana;
	padding-top:4px;
	width:100%;
	color:#ffffff;
	text-align:center;
	font-weight:bold;
}

.loginindex{margin-top:10px; border:1px solid #ffffff; width:450px; padding:10px;-moz-border-radius:5px;}

-->
</style>
</head>

<body>
<div align="center">
	<div class="mainLayer" align="center">
	<div class="trans_login">Gapro Password Retrieval</div>
	<form id="frmlogin" name="frmlogin" method="POST" action="<?php echo $_SERVER["REQUEST_URI"];?>">
	<table style="margin-top:10px;" align="center">
		<tr>
			<td colspan="2"><img class="mainImage" src="images/logo.jpg" /></td>
		</tr>
		<tr>
			<td class="normalfntgap" colspan="2">Please Enter your  E-Mail Address which registered with the <span class="forgotpass">GaPro</span></td>
		</tr>
		<tr>
			<td class="normalfntgap" colspan="2">You will recive an E-Mail Wich support you to reset your password. For any questions or More information, Please contact info@softknowedge.com</td>
		</tr>
	</table>
	<div class="loginindex">
	<table>
		<tr>
			<td class="normalfntlogin">E-mail</td>
			<td>
				<label>
            		<input name="txtusername" type="text" class="txtbox" id="txtusername" size="35" />
           		</label>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				   <?PHP 
			  
			function createPassword($length) 
			{
				$chars = "234567890abcdefghijkmnopqrstuvwxyz";
				$i = 0;
				$password = "";
				while ($i <= $length) {
					$password .= $chars{mt_rand(0,strlen($chars))};
					$i++;
				}
				return $password;
			}

			  $UserName = $_GET["txtusername"];	
	
			if ($UserName != null)
			{					
				include 'LoginDBManager.php';		
				
				$db =  new LoginDBManager();
				$SQL ="SELECT Password,UserName FROM users where UserName='".$UserName."';";
				$result = $db->RunQuery($SQL);
				//$validUser = false;
				
				if($row = mysql_fetch_array($result))
				{
					$generatedPassword = createPassword(5);
					$newPassword = md5($generatedPassword);
					
					
					$SQL = "update users set Password = '$newPassword' where  UserName = '$UserName';";
					$db->ExecuteQuery($SQL);
					
					$SQL = "SELECT users.UserID, users.UserName, users.Password, users.CompanyID, company.CompanyName, " .
				" company.Server, company.UserName, company.Password, company.db " .
				"FROM company INNER JOIN users ON company.CompanyID = users.CompanyID ".
				"WHERE users.UserName='". $UserName."';";
				//echo $SQL;
				$resultuser = $db->RunQuery($SQL);
				while($rowresult = mysql_fetch_array($resultuser))
				{
					$_SESSION["UserID"] = $rowresult["UserID"];
					$_SESSION["CompanyID"] = $rowresult["CompanyID"];
					$_SESSION["Server"] = $rowresult["Server"];
					$_SESSION["UserName"] = $rowresult["UserName"];
					$_SESSION["Password"] = $rowresult["Password"];
					$_SESSION["Database"] = $rowresult["db"];
					
				}
				
					$db = NULL;
					include "Connector.php";
					$SQL = "update useraccounts set Password = '$newPassword' where UserName = '$UserName';";
					$resultset = $db->RunQuery($SQL);
					
					$to = $row['UserName'];
					
					$subject = "GaPro - New password.";
					$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>Password Changed</title>
<style type=\"text/css\">
<!--
.style1 {color: #000066}
.style4 {
	color: #0000CC;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p class=\"style4\">Password Changed. </p>
<p class=\"style1\">Your password has been changed according to your request. Please use following to log in to the system.</p>
<p class=\"style1\">User Name : <strong>" . $to . "</strong> <br />
Password : <strong>" .  $generatedPassword . "</strong> </p>
<p class=\"style1\">Please contact admin@jinadasa.com if you have any further issue. Thank you.</p>
<p class=\"style1\">GaPro Administrator. </p>
</body>
</html>
";

					include "EmailSender.php";
					$eml =  new EmailSender();
					$eml->SendMessage("admin@jinadasa.com","GaPro Administrator",$to,$subject,$message);					

					header( 'Location: password_send.php' ) ;
				}
				else
				{	
					echo $UserName." "."is invalid Email.";
				}
			
			}
			


			  ?>
			</td>
		</tr>
	</table>
	<table width="68%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="3%" height="31" bgcolor="">&nbsp;</td>
			<td width="59%" bgcolor="" class="normalfnt2">
				<img  src="<?php echo $backwardseperator; ?>images/forsend.jpg" alt="login" class="mainImage" onclick="IsvalidData();" />	</td>
		</tr>
	</table>
	</div>
	</form>
	</div>
</div>
</body>
</html>
