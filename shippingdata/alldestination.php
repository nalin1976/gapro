<?php 
session_start();
include "../Connector.php";
$backwardseperator = "../";
$styleId=$_GET['orderId'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdDrHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
	  <div class="main_text">
     New Destination List<span id="dryPrc_popup_close_button"></span></div>
	</div>
<div class="main_body">
<table width="292" border="0" style="width:270" class="tableBorder">
	<tr>
		<td>
			<div style="overflow:scroll; width:290px; height:200px;">
			<table width="290" id="tblDryPrc"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
			<thead>
			<tr class="mainHeading4">
				<td width="69" style="width:70px;">Dest. Code</td>
				<td width="189" style="width:110px;">Dest. Name</td>
			</tr>
			</thead>
			<tbody>
			<?php
					$sql="select D.intDestID,D.intDestCode,D.strDestName from destination D  where intDestID not in (select intDestinationId from orderdata_destination OD where intStyleId=$styleId);";
			$res=$db->RunQuery($sql);
			$cls="";
			$count=0;
			while($row=mysql_fetch_array($res)){?>
			
			<tr ondblclick="AddNewDestinationRow(this);" class="bcgcolor-tblrowWhite" id="<?php echo $row['intDestID'];?>" style="cursor:pointer">
				<td style="width:70px;text-align:right;" class="normalfnt" ><?php echo $row['intDestCode'];?></td>
				<td style="width:110px;text-align:left;" class="normalfnt" ><?php echo $row['strDestName'];?></td>
			</tr>
			
		<?php $count++;}	?>
		</tbody>
	  </table>
	  </div>	  </td>
	  </tr>
</table>
</div>
</div>
</body>
</html>
