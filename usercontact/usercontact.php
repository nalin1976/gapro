<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ePlan Web : User Contacts List</title>
<style type="text/css">
<!--
body {
	background-color: #000000;
}
-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<script type="text/javascript" src="usercontact.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../java.js" type="text/javascript"></script>
</head>
<body>

<form>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#316895" class="TitleN2white"><table width="100%" border="0">
      <tr>       
        <td colspan='4' width="20%">User Contacts List</td>        
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="1%" valign="middle" class="normalfnt"></td>
        <td width="52%" valign="middle" class="normalfnt"><table width="299" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
		
              <tr>
                <td width="78" style="text-align:center">User Name</td>			  
                <td colspan="2" width="108" style="text-align:center">
                  <input class="txtbox" type="text" name="txtUserName" size="19" maxlength="20" id="txtUserName" onkeyup="LoadDetails(this.value);">
                  </td>                
              </tr>
            </table></td>
        <td width="12%"><span class="normalfnt">Company</span></td>
        <td width="35%"><select name="cboCompany" class="txtbox" id="cboCompany" style="width:285px">
	<?PHP
		$SQL="SELECT intCompanyID,strName FROM companies ";
		
			$result = $db->RunQuery($SQL);
		
					echo "<option value=\"".""."\">" ."Select Company"."</option>";
			while ($row = mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["intCompanyID"]."\">". $row["strName"] ."</option>";
				}
    ?>
	</select></td>
      </tr>
    </table></td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="32%" bgcolor="#9BBFDD">&nbsp;</td>
            <td width="56%" bgcolor="#9BBFDD">&nbsp;</td>
            <td width="12%" bgcolor="#9BBFDD">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divGatePassDetails" style="overflow:scroll; height:300px; width:950px;">
          <table id="tblGatePassDetails" width="100%" cellpadding="0" border="0" cellspacing="1" bgcolor="#CCCCFF" >
            <tr>
			  <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">ID</td>	
              <td width="14%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">User Name</td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Departement</td>
              <td width="34%" bgcolor="#498CC2" class="normaltxtmidb2">Factory</td>
			  <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Fac Ex.</td>
			  <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">User Ex.</td>
			  <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Remarks</td>
<?php 
$sql="SELECT *,
(select strName from companies where usercontact.intCompanyID=companies.intCompanyID)AS CompName
 FROM usercontact ORDER BY intUserID";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
			  <tr onmouseover="this.style.background ='#ECECFF';" onmouseout="this.style.background=''" class="bcgcolor-tblrowWhite">
			  <td class="normalfnt"><?php echo $row["intUserID"];?></td>
              <td class="normalfnt"><?php echo $row["strUserName"];?></td>
              <td class="normalfnt"><?php echo $row["strDepartement"];?></td>
              <td class="normalfnt"><?php echo $row["CompName"];?></td>
              <td class="normalfnt"><?php echo $row["intFactoryExtension"];?></td>
			  <td class="normalfnt"><?php echo $row["intUserExtension"];?></td>
			  <td class="normalfnt"><?php echo $row["strRemarks"];?></td>
            </tr>
<?php
}
?>
                      </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#D6E7F5">
    <td height="30"><table width="100%" border="0">
      <tr>
        <td width="25%" class="normalfnt">&nbsp;</td>       
        <td width="12%" class="normalfnt">&nbsp;</td>
        <td width="15%" class="normalfnt">&nbsp;</td>
        <td width="11%" class="normalfntRite"><img src="../images/usr.png" alt="close" border="0" onclick="LoadPoUp();" class="mouseover"/></td>
        <td width="25%" class="normalfnt"><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" class="mouseover"/></a></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
