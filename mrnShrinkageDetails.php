<?php 
	session_start();
	include "authentication.inc";
	include "Connector.php";
	
	$balQty = $_GET["balQty"];
	$styleId = $_GET["styleId"];
	$rwNo = $_GET["rwNo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link  href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="500" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#FFFFFF" class="bcgl1">
  <tr>
    <td colspan="3" class="mainHeading" height="25">Shrinkage Details </td>
    <td class="mainHeading" height="25"><img src="images/cross.png" width="17" height="17" onClick="closeLayer();"></td>
  </tr>
  <tr>
    <td width="94" class="normalfnt">Stock Qty</td>
    <td width="110" ><input type="text" name="txtStockQty" id="txtStockQty" style="width:100px; text-align:right;" readonly="readonly" value="<?php echo $balQty; ?>" ></td>
    <td width="262">&nbsp;</td>
    <td width="18">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><div id="divShrink" style="height:150px; overflow:scroll;">
      <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF" id="tblShrinkage">
      <tr class="mainHeading4">
        <th width="28%" height="20">PatternNo</th>
        <th width="27%">Roll No</th>
        <th width="17%">Qty</th>
         <th width="8%">&nbsp;</th>
         <th width="20%">Req Qty</th>
      </tr>
      <?php 
	  $sql = "select u.strPatternNo,u.strRollNo,u.dblQty
 from orders o inner join upload_shrinkagedataretrieve u on
u.strPONo =o.strBuyerOrderNo
where o.intStyleId = '$styleId' ";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
	  ?>
      <tr class="bcgcolor-tblrowWhite">
        <td height="20" class="normalfnt" ><?php echo $row["strPatternNo"]; ?></td>
        <td class="normalfnt"><?php echo $row["strRollNo"]; ?></td>
        <td class="normalfntR"><?php echo $row["dblQty"]; ?></td>
         <td class="normalfntMid"><input name="chkBox" type="checkbox" onClick="setShrinkQty(this);" ></td>
         <td><input type="text" name="txtReqShrinkQty" id="txtReqShrinkQty" style="width:80px; text-align:right" onKeyPress="return CheckforValidDecimal(this.value, 1,event);" onKeyUp="validateRollQty(this);"></td>
      </tr>
      <?php 
	  }
	  ?>
    </table></div></td>
  </tr>
  <tr>
  	<td height="8"></td>
  </tr>
  <tr align="center">
    <td colspan="4"><img src="images/addsmall.png" width="95" height="24" onClick="addShrinkQty(<?php echo $rwNo; ?>);"></td>
  </tr>
</table>
</body>
</html>
