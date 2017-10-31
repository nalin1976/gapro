<?php session_start(); 
include 'LoginDBManager.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>WaveEdge - Softknowedge</title>
<style type="text/css">
	body{background:url(images/login_back.png) repeat-x;}
	
	
	.normalfnt {
		font-family: Verdana;
		font-size: 11px;
		color: #000000;
		margin: 0px;
		font-weight: normal;
		text-align:left;
	}
	
	.normalfntforgot {
		font-family: Verdana;
		font-size: 11px;
		color: #4d3267;
		margin: 0px;
		font-weight: normal;
		text-align:left;
		text-decoration:none;
		background-color:#b6aac3;
		padding:5px;
		cursor:pointer;
	}
	
	.normalfntforgot:hover {border: 1px solid #4d3267;}
	
	.login_txtbox {
		font-family: Verdana;
		font-size: 11px;
		color: #20407B;
		border: 1px solid #e0dae6;
		text-align:left;
	}
	
	.login_txtbox:hover {
		font-family: Verdana;
		font-size: 11px;
		color: #20407B;
		border: 1px solid #c1afd3;
		text-align:left;
	}
	
</style>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">


	
function Onloadvalue(){		
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
	
</script>
</head>

<body>
<form id="frmlogin" name="frmlogin" method="POST" action="login.php">
<div align="center">
	<div align="center" style="width:640px; margin-top:200px; background:url(images/eshipping.jpg) no-repeat; height:500px;">
		<div align="right" style="width:300px; text-align:right; height:300px; padding-bottom:10px; margin-left:305px;">
			<table align="right" style="margin-top:170px;">
				<tr>
					<td class="normalfnt">Username</td>
					<td>
						<label>
                		<input name="txtusername" type="text" tabindex="0"  autocompletetype="Disabled" autocomplete="off" class="login_txtbox" id="txtusername"
						value="<?php if (isset( $_POST["txtusername"]))echo $_POST["txtusername"]; ?>" style="width:200px;" onclick="ClearUser(this.value);" />
              			</label>
					</td>
				</tr>
				<tr>
					<td class="normalfnt">Password</td>
					<td>
						<label>
                		<input name="txtPassword" type="password" class="login_txtbox" id="txtPassword" 
						value="<?php if (isset( $_POST["txtPassword"]))	echo $_POST["txtPassword"]; else echo "Password";?>" 
						style="width:200px;" onkeypress="EnableEnterKeySubmission(event);" onclick="ClearPassword(this.value);" />
              			</label>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align="right"><img src="images/button_login.png" onclick="SubmitDetails();" style="cursor:pointer" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>	
					<td colspan="2" class="error1" id="txterror">
					<?php
					
					$UserName = $_POST["txtusername"];	
					
					if ($UserName != null)
					{	
						$Password =  $_POST["txtPassword"];
						
						$xml = simplexml_load_file('config.xml');
						$networkName = $xml->companySettings->NetworkName;
						$pos = strpos($UserName, "@");
					
						if ($pos == '')
						{
							$UserName .= "@" .$networkName;
						}
						
								
						//echo "dffsdsdsd";
						$db =  new LoginDBManager();
						$SQL = "SELECT users.UserID, users.UserName, users.Password, users.CompanyID, company.CompanyName, " .
						" company.Server, company.UserName, company.Password, company.db " .
						"FROM company INNER JOIN users ON company.CompanyID = users.CompanyID ".
						"WHERE (((users.UserName)='". $UserName."') AND ((users.Password)='". md5($Password) .		
						"'));";
						//$SQL ="SELECT UserID FROM users where UserName='". $UserName."' and Password='". md5($Password) ."';";
						//echo $SQL;
						$result = $db->RunQuery($SQL);
						$validUser = false;

						$db = NULL;
						while($row = mysql_fetch_array($result))
						{
					
							$_SESSION["UserID"] = $row["UserID"];
							$_SESSION["CompanyID"] = $row["CompanyID"];
							$_SESSION["Server"] = $row["Server"];
							$_SESSION["UserName"] = $row["UserName"];
							$_SESSION["Password"] = $row["Password"];
							$_SESSION["Database"] = $row["db"];
	
							$validUser = true;
							$userDisabled = true;
							include "Connector.php";
							$SQL = "select intUserID,UserName,Password,Name,intCompanyID from useraccounts  where intUserID = ". $row["UserID"] . " and status=1;";
							$resultset = $db->RunQuery($SQL);
							while($rowresult = mysql_fetch_array($resultset))
							{
								$userDisabled	= false;
	
								$_SESSION["FactoryID"] = $rowresult["intCompanyID"];
							}

							$userlogin = true;
							include "${backwardseperator}usertracking.php";
						}		

						if($userDisabled){
							session_unset(); 
							session_destroy(); 
							echo  "<br>Sorry! Your account has been disabled by the system administrator.";
						}
						else
						{
							if($validUser){
								//echo "Logged In";
								echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php">';
	
								//header( 'Location: main.php' ) ;	
							}
							else
							{
								echo "<br>Invalid UserName or Password";
							}
						}	
					}?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><a href="forgetpassword.php" class="normalfntforgot">Forgot Password?</a></td>
				</tr>
				<tr>
					<td colspan="2" class="normalfnt2bld"><span class="error1"> </span></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</form>
</body>
<script type="text/javascript" >
document.getElementById("txtusername").focus();
</script>
</html>
