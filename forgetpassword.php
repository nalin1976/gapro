<?php

session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro -Forgot Password</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
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
</head>

<body>
<form id="frmpassword" name="frmpassword" method="get" action="forgetpassword.php">
  <table width="950" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="20%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" /></td>
            <td width="7%">&nbsp;</td>
            <td class="tophead">Password Retrieval</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="191"><table width="100%" height="189" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="25%" rowspan="3">&nbsp;</td>
            <td width="1%" height="33" bgcolor="#d6e7f5"><p class="head1">&nbsp;</p>              </td>
            <td width="49%" height="33" bgcolor="#d6e7f5"><span class="head1">To recover your password,</span></td>
            <td width="25%" rowspan="3">&nbsp;</td>
          </tr>
          
          <tr>
            <td height="118" colspan="2" class="error1"><p class="normalfnt">Please Enter your  E-Mail Address which registered with the <span class="normalfnth2">GaPro</span>. </p>
              <p class="normalfnt">&nbsp;</p>
              <p class="normalfnt">&nbsp;</p>
              <p class="normalfnt">You will recive an E-Mail Wich support you to reset your password. For any questions or More information, Please contact admin@calilink.com</p>
              <p class="normalfnt">&nbsp;</p>
              <p class="normalfnt">
                <label>
                <input name="txtusername" type="text" class="txtbox" id="txtusername" size="35" />
                </label>
              </p>
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
          <tr>
            <td colspan="2" bgcolor="#d6e7f5"><div align="center"><img src="images/send.png" alt="send" width="101" height="24" onclick="IsvalidData();" /></div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
       <td class="copyright" align="right">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
