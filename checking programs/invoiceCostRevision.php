<?php 
include "../Connector.php";	
header('Content-Type: application/vnd.ms-word');
header('Content-Disposition: attachment;filename="FirstSale.xls"');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <td width="20%">Approval No</td>
        <td width="27%">PO #</td>
         <td width="16%">Fob Price</td>
        <td width="18%">Last Updated Date</td>
        <td width="19%">Last Updated Person</td>
       
      </tr>
      <?php 
	  $sql = " select distinct ih.intStyleId 
from history_invoicecostingheader ih inner join orders o on o.intStyleId = ih.intStyleId 
where o.intBuyerID=1
order by ih.strOrderNo ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$styleId = $row["intStyleId"];
		$sql_IH = "select date(ih.dtmDate) as lastDate, ih.strOrderNo, ih.dblFOB,(select u.Name from useraccounts u where u.intUserID= ih.intUserId) as userName,ih.intApprovalNo
from invoicecostingheader ih 
where ih.intStyleId='$styleId' ";
		$result_I=$db->RunQuery($sql_IH);
		
		while($row_I = mysql_fetch_array($result_I))
		{
	  ?>
      <!-- <tr bgcolor="#FFFFFF">
      	<td colspan="5" class="normalfnt">&nbsp;&nbsp;&nbsp;Current Invoice Details</td>
      </tr>-->
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20">Current Invoice Details</td>
        <td><?php echo $row_I["strOrderNo"]; ?></td>
         <td class="normalfntRite"><?php echo $row_I["dblFOB"] ?></td>
        <td><?php echo $row_I["lastDate"] ?></td>
        <td><?php echo $row_I["userName"] ?></td>
      </tr>
     <!-- <tr bgcolor="#FFFFFF">
      	<td colspan="5" class="normalfnt">&nbsp;&nbsp;&nbsp;Revision Details</td>
      </tr>-->
      	<?php 
			$sql_RI = "select date(ih.dtmDate) as lastDate, ih.strOrderNo, ih.dblFOB,(select u.Name from useraccounts u where u.intUserID= ih.intUserId) as userName,ih.intApprovalNo
from history_invoicecostingheader ih 
where ih.intStyleId='$styleId' order by ih.intApprovalNo";
			$result_RI=$db->RunQuery($sql_RI);
		
			while($row_R = mysql_fetch_array($result_RI))
			{
		?>
        	 <tr bgcolor="#FFFFFF" class="normalfnt">
            <td height="20">Revision &nbsp;<?php echo $row_R["intApprovalNo"]; ?></td>
            <td><?php echo $row_R["strOrderNo"]; ?></td>
             <td class="normalfntRite"><?php echo $row_R["dblFOB"] ?></td>
            <td><?php echo $row_R["lastDate"] ?></td>
            <td><?php echo $row_R["userName"] ?></td>
          </tr>
      <?php
	  		}	 
	  	}
		?>
        <tr bgcolor="#FFFFFF"><td colspan="5">&nbsp;</td></tr>
        <?php
	  }
	  ?>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
