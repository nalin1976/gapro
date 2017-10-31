<?php
$backwardseperator = "../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro Releases</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="../../javascript/script.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php
include "../Connector.php";

?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include "../Header.php";?></td>
  </tr>
  <tr>
    <td height="139"><table width="900" border="0" align="center" class="tableBorder2">
      <tr>
        <td width="80%">
       		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" class=""><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
        <tr>
          <td align="center"><strong class="normalfnt2">GaPro   Releases</strong></td>
        </tr>
      </table></td>
    </tr>
					  <tr>
				    <td>&nbsp;</td>
				    <td class="head1">&nbsp;</td>
				    <td>&nbsp;</td>
		      </tr>
  				<?php 
  				$sql = "select * from release_version order by id desc";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					$version = $row["version"];
				?>
				  <tr>
					<td width="48%">&nbsp;</td>
					<td width="17%" class="head1"><a href="<?php echo "$version.html"; ?>"> <?php echo $version; ?></a></td>
					<td width="35%">&nbsp;</td>
				  </tr>

  				<?php 
  				}
  				?>
</table>

        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>


</body>
</html>
