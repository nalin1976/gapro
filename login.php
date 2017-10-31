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
			$x = "1";
			
			$resultset = $db->RunQuery($SQL);
			while($rowresult = mysql_fetch_array($resultset))
			{
				$x="2";
				$validUser = true; 
				$_SESSION["FactoryID"] = $rowresult["intCompanyID"];
			}
			//echo $x;
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

<script type="text/javascript" language="javascript">
	
	function Onloadvalue(){		
		//document.getElementById("txtusername").value ="Username"; 
		document.getElementById("txtPassword").value ="Password";		 		
	}
	
	function ClearUser(txtval){		
		if(document.getElementById("txtusername").value!="Username"){
			document.getElementById("txtusername").value =txtval;
		}
	else{
		document.getElementById("txtusername").value ="";	
		document.getElementById("txterror").innerHTML ="";
		if(document.getElementById("txtPassword").value =="")	
			document.getElementById("txtPassword").value ="Password";	
		}	
	}
		
	function ClearPassword(txtval){	
		if(document.getElementById("txtPassword").value!="Password"){
			document.getElementById("txtPassword").value =txtval;
		}
		else{
			document.getElementById("txtPassword").value ="";	
			document.getElementById("txterror").innerHTML ="";
		
		}
	}
	
	function SubmitDetails(){
		if(document.getElementById("txtusername").value =="" | document.getElementById("txtPassword").value ==""){
			document.getElementById("txterror").innerHTML ="";
			//document.getElementById("txtusername").value ="Username";
			document.getElementById("txtPassword").value ="Password";
			alert("Please enter Valid UserName or Password");
	}

	else	
		document.getElementById('frmlogin').submit();
	}

	function isValidEmail(emailaddress)

       {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailaddress))
            {       
                return true;
            }                     
            return false;
        }  
		
		function EnableEnterKeySubmission(evt)
		{
			 var charCode = (evt.which) ? evt.which : event.keyCode;

			 if (charCode == 13)
				SubmitDetails();
		} 
		
		/*if (window.console && window.console.firebug) 
		{
		  alert("The system found that you are using Firebug extensions.");
		}
		else
		{
		  alert("can't find Firebug");
		}*/
		
/*		if (! ('console' in window) || !('firebug' in console))
		 {
    var names = ['log', 'debug', 'info', 'warn', 'error', 'assert', 'dir', 'dirxml', 'group', 'groupEnd', 'time', 'timeEnd', 'count', 'trace', 'profile', 'profileEnd'];
    window.console = {};
    for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
}*/



/*
else{
  //alert("can't find Firebug");
}
*/


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
}

.mainLayer{
	width:700px;
	height:350px;
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
	<div class="trans_login">Gapro Login</div>
	<form id="frmlogin" name="frmlogin" method="POST" action="<?php echo $_SERVER["REQUEST_URI"];?>">
	<table style="margin-top:10px;" align="center">
		<tr>
			<td colspan="2"><img class="mainImage" src="images/logo.jpg" /></td>
		</tr>
		<tr>
			<td class="normalfntgap" colspan="2">
			<span style="margin-left:20px;">Gapro</span> WEB provides a comprehensive integrated enterprise
			resource solution for the global apparel industry. It facilitates
			managing the resources of the business enterprise to optimize profiles,
			accelerate decision making, improve customer service and eliminate waste.
			It is web based with 24/7 global access, It is highly secure and facilitates a 'paperless' 
			operating environment</td>
		</tr>
	</table>
	<div class="loginindex">
	<table>
		<tr>
			<td class="normalfntlogin">Username</td>
			<td>
			<label>
            <input name="txtusername" type="text" tabindex="0" autocompletetype="Disabled" autocomplete="off" class="txtbox_orange" id="txtusername" 
			value="<?php if(isset($_POST["txtusername"])) echo $_POST["txtusername"];?>" style="width:240px;" onclick="ClearUser(this.value);" />
           	</label>
			</td>
		</tr>
		<tr>
			<td class="normalfntlogin">Password</td>
			<td>
			<label>
            <input name="txtPassword" type="password" class="txtbox" id="txtPassword" 
			value="<?php if (isset( $_POST["txtPassword"])) echo $_POST["txtPassword"];
			else echo "Password";
			?>" style="width:240px;" onkeypress="EnableEnterKeySubmission(event);" onclick="ClearPassword(this.value);" />
            </label>
			</td>
		</tr>
		<tr>
			<td class="normalfnt"></td>
			<td class="error1" id="txterror">
			<?php
			if (!$validUser)
			{	
				echo "<br>$message";
			}
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="normalfnt"><input type="hidden" id="requestedPage" name="requestedPage" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"></td>
		</tr>
	</table>
	<table width="68%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="3%" height="31" bgcolor="">&nbsp;</td>
			<td width="59%" bgcolor="" class="normalfnt2"><a href="#">
				<img  src="<?php echo $backwardseperator; ?>images/log.jpg" alt="login" class="mainImage" onclick="SubmitDetails();" />				</a></td>
			<td width="38%" bgcolor=""><a class="forgotpass" href="forgotPass.php">Forgot Password?</a>			</td>
		</tr>
	</table>
	</div>
	</form>
	</div>
</div>
</body>
<script type="text/javascript">
	document.getElementById("txtusername").focus();
	if (window.console && window.console.firebug) {
  		//document.getElementById("firebugError").style.visibility = "visible";
	}
</script>
</html>
