<?php
 session_start();
include "authentication.inc";
 $POstatus = $_GET["status"];
 include "Connector.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro : :  Approved PO</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
function closePage()
{
	window.open('', '_self', '');
    window.close();

}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#FFD5AA" class="normalfnth2Bm" height="30">
        <?php 
		if($POstatus == '2')
		{
			echo 'Purchase Order first approval saved successfully.';
		}
		else if($POstatus == '1')
		{
			echo 'Purchase Order rejected successfully.';
		}
		else
		{
			echo 'Purchase Order first approval saved failed.';
		}
		?>
        </td>
      </tr>
      <tr bgcolor="#FFD5AA">
        <td align="center"><img src="images/close.png" onClick="closePage();"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
<script typr="text/javascript">
window.opener.location.reload();
</script>
</html>
