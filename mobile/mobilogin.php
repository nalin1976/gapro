<?php
session_start();

if(isset($_SESSION["Server"]))
{
	$page = "mobimenu.php";
	if(isset($_SESSION["Requested_Page"]))
		$page = $_SESSION["Requested_Page"];
	header("Location:${backwardseperator}$page");
	exit;
}

$UserName = $_POST["txtusername"];	
	
	if ($UserName != null)
	{	
		$Password =  $_POST["txtPassword"];
		
		$xml = simplexml_load_file("../config.xml");
		$networkName = $xml->companySettings->NetworkName;
		$pos = strpos($UserName, "@");
	
		if ($pos == '')
		{
			$UserName .= "@" .$networkName;
		}
		
		include '../LoginDBManager.php';		
		
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
		$message = "Invalid UserName or Password";
		while($row = mysql_fetch_array($result))
		{
			$_SESSION["UserID"] = $row["UserID"];
			$_SESSION["CompanyID"] = $row["CompanyID"];
			$_SESSION["Server"] = $row["Server"];
			$_SESSION["UserName"] = $row["UserName"];
			$_SESSION["Password"] = $row["Password"];
			$_SESSION["Database"] = $row["db"];


			
			include "../Connector.php";
			$SQL = "select intUserID,UserName,Password,Name,intCompanyID from useraccounts  where intUserID = ". $row["UserID"] . " and status=1;";
			$resultset = $db->RunQuery($SQL);
			while($rowresult = mysql_fetch_array($resultset))
			{
				$validUser = true; 
				$_SESSION["FactoryID"] = $rowresult["intCompanyID"];
			}
			
			$userlogin = true;
			include "../usertracking.php";
			
			if(!$validUser)
			{
				session_unset(); 
				session_destroy(); 
				$message = "Sorry! Your account has been disabled by the system administrator.";
			}
		}
		
		if ($validUser)
		{
			//echo "Logged In";			//echo $_POST["requestedPage"];
			//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php">';
			//header( 'Location: main.php' ) ;
			if(!isset($_POST["requestedPage"]))	
				header("Location:${backwardseperator}mobimenu.php");
			else if ($_POST["requestedPage"] == "/eplan/mobile/mobilogin.php")
				header("Location:${backwardseperator}mobimenu.php");
			else
				header("Location:" . $_POST["requestedPage"]);
			exit;
		}	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login - Eplan ERP</title>
</head>
 
<body>
<form id="frmlogin" name="frmlogin" method="POST" action="<?php echo $_SERVER["REQUEST_URI"];?>">
  <div>
    <table width="275" height="213" align="left">
      <tr>
        <td width="338" valign="top"><table width="100%">
            <tr>
              <td width="9%" height="50">&nbsp;</td>
              <td width="83%" valign="bottom"><span>Eplan Login</span></td>
              <td width="8%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><div align="center"><img src="../images/dwn-log-bar.png" width="238" height="12" /></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><label>
                <input name="txtusername" type="text" tabindex="0"  style="width:200px;"  autocompletetype="Disabled" autocomplete="off" id="txtusername" value="<?php
			
			if (isset( $_POST["txtusername"]))			
			echo $_POST["txtusername"];
			
			
			?>" style="width:240px;"/>
              </label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><label>
                <input name="txtPassword" style="width:200px;" type="password"  id="txtPassword" value="<?php
			
			if (isset( $_POST["txtPassword"]))			
			echo $_POST["txtPassword"];
			
			?>" style="width:240px;" />
              </label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
	
	         <td class="error1" id="txterror"><?php
		if (!$validUser)
		{	
			echo "<br>$message";
		}
	
	?></td>
              <td>&nbsp;<input type="hidden" id="requestedPage" name="requestedPage" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"></td>
            </tr>
            <tr>
              <td colspan="3"><input type="submit" value="Submit"></td>
            </tr>
        </table></td>
      </tr>
    </table>
  </div>  
</form>
</body>
</html>
