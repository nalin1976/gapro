<?php 
session_start();
include "../Connector.php";
$backwardseperator = "../";
$styId=$_GET['styId'];
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
    <td id="tdHeader">&nbsp;</td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
	  <div class="main_text">
        Added Destinations<span id="prc_popup_close_button"></span>	</div>
	</div>
<div class="main_body">
<table style="width:260" border="0" class="tableBorder">  
	<tr>
		<td>
		<div style="overflow:scroll; width:280px; height:200px;">
			<table id="tblDestination" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
			<tr class="mainHeading4">
				<td style="width:30px;" >Del</td>
				<td >Qty</td>
				<td style="width:100px;" >Dest. Code</td>
			    <td style="width:200px;" >Dest. Name </td>
			</tr>
			<?php
				$sql="select D.intDestID,D.intDestCode,D.strDestName,OD.dblQty from destination D inner join orderdata_destination OD on OD.intDestinationId=D.intDestID where intStyleId='$styId'"; 
			$res=$db->RunQuery($sql);
			
			$cls="";
			$count=0;
			while($row=mysql_fetch_array($res)){?>
			<tr class="bcgcolor-tblrowWhite" id="<?php echo $row['intDestID'];?>">
				<td style="width:30px;text-align:center" class="normalfnt"><img src="../images/del.png" onclick="RemoveDestRow(this);" /></td>
				<td class="normalfnt"><input type="text" class="txtbox" value="<?php echo $row['dblQty'];?>" style="width:60px;text-align:right"/></td>
				<td style="width:100px;" class="normalfntRite"><?php echo $row['intDestCode']; ?></td>
			    <td style="width:200px;" class="normalfnt"><?php echo $row['strDestName'];?></td>
			</tr>
		<?php $count++;}	?>
	  </table>
	  </div>	  </td>
	  </tr>
	  <tr>
	  	<td  align="center">
	  		<table>
				<tr>
	  				<td id="tdDelete">&nbsp;</td>
					<td><img src="../images/ok.png" onclick="SaveDestination();" /></td>
					<td><img src="../images/add_pic.png" onclick="LoadAllDestination(<?php echo $styId;?>);" /></td>
	  			</tr>
			</table>		</td>
	  </tr>
</table>
</div>
</div>
</body>
</html>
