<?php
session_start();
include "Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web :: User Manager</title>
<script type="text/javascript" language="javascript">

var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function LockUser(obj)
{
	var userID = "";
	if ( this instanceof HTMLImageElement)
	{
		userID = this.id;
	}	
	else
	{
		userID = obj.id
	}

	 createXMLHttpRequest();
    //xmlHttp.onreadystatechange = HandleDivisions;
    xmlHttp.open("GET", 'userHandling.php?RequestType=LockUser&userID=' + userID, true);
    xmlHttp.send(null);
    obj.src = "images/lockuser.png";
	 obj.onclick = UnlockUser;
	 if ( this instanceof HTMLImageElement)
	 {
			this.src = "images/lockuser.png";
			this.onclick = UnlockUser;
	 }
    //alert("The user account " + obj.alt + " has been disabled.");     
}

function UnlockUser(obj)
{
	var userID = "";
	if ( this instanceof HTMLImageElement)
	{
		userID = this.id;
	}	
	else
	{
		userID = obj.id
	}
	
	createXMLHttpRequest();
    //xmlHttp.onreadystatechange = HandleDivisions;
   xmlHttp.open("GET", 'userHandling.php?RequestType=UnLockUser&userID=' + userID, true);
   xmlHttp.send(null);
	obj.src = "images/UserIcon.jpg";
	obj.onclick = LockUser;
	if ( this instanceof HTMLImageElement)
	 {
			this.src = "images/UserIcon.jpg";
			this.onclick = LockUser;
	 }
	//alert("The user account " + obj.alt + " has been enabled."); 
}

</script>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="965" border="0" align="center">
  <tr>
    <td width="752"><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
     
      <tr>
        <td height="415"  align="center" valign="top">
<form action="StyleResolverProcess.php" method="post" name="frmProcess">
    <blockquote>
      <blockquote>
        <p>&nbsp;</p>
        <table width="795" border="0">
          <tr>
            <td colspan="2"><span class="tophead">Manage Users</span></td>
            </tr>
          <tr>
            <td width="519">Please click on the user which you need to modify.</td>
            <td width="254"><div align="left"><a href="createnewuser.php"><img src="images/addsmall.png" alt="Add user" width="95" height="24" border="0" class="mouseover" /></a></div></td>
          </tr>
        </table>
        </blockquote>
      </blockquote>
    <table width="792" border="0">
  <?php 
  	$sql = "SELECT useraccounts.intUserID,useraccounts.UserName,useraccounts.Name,useraccounts.status,companies.strName FROM useraccounts INNER JOIN companies ON useraccounts.intCompanyID = companies.intCompanyID ORDER BY NAME;";
  	$result = $db->RunQuery($sql);
	$num_rows = mysql_num_rows($result);
	$loop = 0;
	while ($loop < $num_rows )
	{
		$row1 = mysql_fetch_array($result);
		$row2 = mysql_fetch_array($result);
		$row3 = mysql_fetch_array($result);
		$loop  += 3;
  ?>
    <tr>
      <td width="24" class="normalfnt" >
      <?php 
      if($row1["intUserID"] != NULL)
      { 
      	if($row1["status"] == 1)
      	{
      ?> 
      <img src="images/UserIcon.jpg" class="mouseover" id="<?php echo $row1["intUserID"]; ?>" onClick="LockUser(this);" alt="<?php echo $row1["UserName"]; ?>" border="0" />
      <?php
      	}
      	else
      	{
      	?>
      	<img src="images/lockuser.png" class="mouseover" id="<?php echo $row1["intUserID"]; ?>" onClick="UnlockUser(this);" alt="<?php echo $row1["UserName"]; ?>" border="0" />
      	<?php
      	}
       } 
       ?>
      </td>
      <td width="228"><a href="permissionManager.php?userID=<?php echo $row1["intUserID"]; ?>"><?php echo $row1["Name"]; ?></a></td>
      <td width="24" class="normalfnt" >
      <?php 
      if($row2["intUserID"] != NULL)
      { 
      	if($row2["status"] == 1)
      	{
      ?> 
      <img src="images/UserIcon.jpg" class="mouseover" id="<?php echo $row2["intUserID"]; ?>" onClick="LockUser(this);" alt="<?php echo $row2["UserName"]; ?>" border="0" />
      <?php
      	}
      	else
      	{
      	?>
      	<img src="images/lockuser.png" class="mouseover" id="<?php echo $row2["intUserID"]; ?>" onClick="UnlockUser(this);" alt="<?php echo $row2["UserName"]; ?>" border="0" />
      	<?php
      	}
       } 
       ?>
      </td>
      <td width="227"><a href="permissionManager.php?userID=<?php echo $row2["intUserID"]; ?>"><?php echo $row2["Name"]; ?></a></td>
      <td width="24" class="normalfnt">
      <?php 
      if($row3["intUserID"] != NULL)
      { 
      	if($row3["status"] == 1)
      	{
      ?> 
      <img src="images/UserIcon.jpg" class="mouseover" id="<?php echo $row3["intUserID"]; ?>" onClick="LockUser(this);" alt="<?php echo $row3["UserName"]; ?>" border="0" />
      <?php
      	}
      	else
      	{
      	?>
      	<img src="images/lockuser.png" class="mouseover" id="<?php echo $row3["intUserID"]; ?>" onClick="UnlockUser(this);" alt="<?php echo $row3["UserName"]; ?>" border="0" />
      	<?php
      	}
       } 
       ?>
      </td>
      <td width="239"><a href="permissionManager.php?userID=<?php echo $row3["intUserID"]; ?>"><?php echo $row3["Name"]; ?></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="normalfnt" ><?php echo $row1["UserName"]; ?></td>
      <td>&nbsp;</td>
      <td class="normalfnt" ><?php echo $row2["UserName"]; ?></td>
      <td>&nbsp;</td>
      <td class="normalfnt" ><?php echo $row3["UserName"]; ?></td>
    </tr>
	 <tr>
      <td>&nbsp;</td>
      <td class="normalfnt"><?php echo $row1["strName"]; ?></td>
      <td>&nbsp;</td>
      <td class="normalfnt"><?php echo $row2["strName"]; ?></td>
      <td>&nbsp;</td>
      <td class="normalfnt"><?php echo $row3["strName"]; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

	<?php
		}
	?>
  </table>
  <p></p>
</form></td>
      </tr>
      
    </table>
    </td>
  </tr>
  <tr>
    <td><div align="right"><span class="specialFnt1">California Link (Pvt) Ltd. 2008/12 &copy; All Rights Reserved.</span></div></td>
  </tr>
</table>
</body>
</html>
