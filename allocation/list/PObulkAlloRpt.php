<?php 
session_start();
include "../../Connector.php";
$backwardseperator = "../../";
include "{$backwardseperator}authentication.inc";
$companyId=$_SESSION["FactoryID"];
//$styleID = $_GET["styleID"];
//$styleName = $_GET["styleName"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bulk Allocation : : PO Wise</title>
<link href="../../css/erpstyle.css" type="text/css" rel="stylesheet"/>
</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">Allocation From Common Stock - PO Wise</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
<td><hr color="#000000"></td>
</tr>
<tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="850" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Bulk PO</td>
        <td>&nbsp;</td>
        <td>Qty</td>
        <td>&nbsp;</td>
        <td>Received Qty</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Invoice</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="850" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Item Description</td>
        <td>Allocation No</td>
        <td>Color</td>
        <td>Size</td>
        <td>Qty</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
