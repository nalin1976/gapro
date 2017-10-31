<?php 
session_start();
include "../../Connector.php";
$backwardseperator = "../../";
$styId=$_GET['styId'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdDrHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">Processes<span id="dryPrc_popup_close_button"></span>
	</div></div>
<div class="main_body">
<table style="width:240" border="0" >
	<tr>
		<td>
			<div style="overflow:scroll; width:270px; height:200px;">
			<table width="270" id="tblDryPrc" class="tableBorder">
			<thead>
			<tr>
				<td colspan="3">
					<table>
						<tr><td style="width:150px;"><input type="text" id="txtDryPrcSrc" onkeydown="searchProcesses();" /></td><td><img src="../../images/searchSM.png" onclick="searchProcesses();" /></td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="width:30px;"  class="grid_header">&nbsp;</td><td style="width:150px;"  class="grid_header">Processes</td>
			</tr>
			</thead>
			<tbody>
			<?php
			$sqlChk="SELECT intProcessId FROM invoicecostingproceses WHERE intStyleId='$styId';";
			$resChk=$db->RunQuery($sqlChk);
			$nR=mysql_num_rows($resChk);
			$sql="";
			if($nR>0){
					$sql="SELECT intSerialNo,strDescription FROM was_dryprocess WHERE intStatus='1' AND intSerialNo NOT IN 
						(SELECT intProcessId FROM invoicecostingproceses WHERE intStyleId='$styId');";
				}
			else{
					$sql="SELECT intSerialNo,strDescription FROM was_dryprocess WHERE intStatus='1' AND intSerialNo NOT IN 
						(SELECT intDryProssId FROM was_washpricedetails WHERE intStyleId='$styId');";
			}
				//echo $sql;
			$res=$db->RunQuery($sql);
			$cls="";
			$count=0;
			while($row=mysql_fetch_array($res)){($count%2==0)?$cls="grid_raw":$cls="grid_raw2";?>
			
			<tr>
				<td style="width:30px;" class="<?php echo $cls;?>" id="<?php echo $row['intSerialNo'];?>"><input type="checkbox" /></td>
				<td style="width:150px;text-align:left;" class="<?php echo $cls;?>" ><?php echo $row['strDescription'];?></td>
			</tr>
			
		<?php $count++;}	?>
		</tbody>
	  </table>
	  </div>
	  </td>
	  </tr>
	  <tr>
	  	<td>
	  		<table align="center">
				<tr>
					<td id="tdDelete"></td>
					<td colspan="3" align="center"><img src="../../images/ok.png" onclick="addToProcesses('tblDryPrc');" /></td>
	  			</tr>
			</table>
		</td>
	  </tr>
</table>
</div>
</div>
</body>
</html>
