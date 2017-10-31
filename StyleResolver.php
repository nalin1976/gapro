<?php
session_start();
include "Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Style Resolver</title>


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
        <td height="21">&nbsp;</td>
      </tr>
      <tr>
        <td height="57" bgcolor="#D2E9F7"  align="center">
<form action="StyleResolverProcess.php" method="post" name="frmProcess">
<div id="Layer1" style="width:500px;" align="center" >
  <div>
    <p class="tophead">Style Resolver</p>
    <p align="left" class="tophead">&nbsp;</p>
    <p align="left" class="bigfntnm1">Please use this program to resolve following problems which occured due to revisions done before June 2009. </p>
    <p align="left" class="bigfntnm1">&nbsp;</p>
    <p align="left" class="bigfntnm1">1. Can't raise PO's, getting balance quantity not available error.<br />
    2. Style not visible in PO<br />
    3. Material Ratio not configured well<br />
    4. Color and Sizes Not matching
    <br />
    5. Can't raise MRN's, Issues.....
    <br />
    <br />
    <span class="headRed">Please do not close your browser till you get &quot;Resolved Completed&quot; message.</span> </p>
    <p class="bigfntnm1">&nbsp;</p>
    <div align="left"><table width="421" height="78" border="0">
      <tr>
        <td class="bigfntnm1">Please select your style :</td>
        <td><select name="StyleID" class="txtbox" style="width:200px" id="StyleID" >
          <option value="Select One" selected="selected">Select One</option>
          <?php
	
	$SQL = "select specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>" ;
	}
	
	?>
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="left">
          <input name="cmdResolve" type="submit" style="width:150px;" id="cmdResolve" value="Resolve" />
        </div></td>
      </tr>
    </table></div>
    
    <div align="center"></div><p>&nbsp;</p>
    <p align="center" class="color2">Only for FGM </p>
  </div>
</div>
</form>
</td>
      </tr>
      <tr>
        <td height="74">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class="copyright" align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>
