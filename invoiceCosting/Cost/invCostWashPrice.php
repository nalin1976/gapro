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
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">
        Processes<span id="prc_popup_close_button"></span>
	</div></div>
<div class="main_body">
<table style="width:260" border="0" class="tableBorder">  
	<tr>
		<td>
		<div style="overflow:scroll; width:280px; height:200px;">
			<table id="tblPrc">
			<tr>
				<td style="width:30px;" class="grid_header">&nbsp;</td>
				<td style="width:150px;" class="grid_header">Process</td>
				<td style="width:70px;" class="grid_header">Unit Price</td>
			</tr>
			<?php
			$sqlChk="SELECT intProcessId FROM invoicecostingproceses WHERE intStyleId='$styId';";
			$resChk=$db->RunQuery($sqlChk);
			$nR=mysql_num_rows($resChk);
			$sql="";
			if($nR>0){
				$sql="SELECT invC.intProcessId AS SERIAL ,was_dryprocess.strDescription,invC.dblUnitPrice AS PRICE 
						FROM invoicecostingproceses invC 
						INNER JOIN was_dryprocess ON was_dryprocess.intSerialNo=invC.intProcessId
						WHERE invC.intStyleId='$styId'"; 
			}
			else{
			$sql="SELECT was_dryprocess.strDescription,was_washpricedetails.dblWashPrice  AS PRICE ,was_dryprocess.intSerialNo AS SERIAL
					FROM was_washpricedetails
					INNER JOIN was_dryprocess ON was_dryprocess.intSerialNo=was_washpricedetails.intDryProssId
					WHERE was_washpricedetails.intStyleId='$styId';";
					}
			$res=$db->RunQuery($sql);
			
			$cls="";
			$count=0;
			while($row=mysql_fetch_array($res)){($count%2==0)?$cls="grid_raw":$cls="grid_raw2";?>
			<tr>
				<td style="width:30px;" class="<?php echo $cls;?>"><img src="../../images/del.png" onclick="dltDet(this);" /></td>
				<td style="width:150px;text-align:left;" class="<?php echo $cls;?>" id="<?php echo $row['SERIAL'];?>"><?php echo $row['strDescription'];?></td>
				<td style="width:70px;" class="<?php echo $cls;?>" ><input type="text" value="<?php echo $row['PRICE']; ?>" onkeypress="return CheckforValidDecimal(this.value, 2,event);" style="text-align: right;width:50px;" maxlength="10" /></td>
			</tr>
		<?php $count++;}	?>
	  </table>
	  </div>
	  </td>
	  </tr>
	  <tr>
	  	<td  align="center">
	  		<table>
				<tr>
	  				<td id="tdDelete">&nbsp;</td>
					<td><img src="../../images/ok.png" onclick="saveDryPrc();" /></td>
					<td><img src="../../images/add_pic.png" onclick="loadDryProcesses('tblPrc',<?php echo $styId;?>);" /></td>
	  			</tr>
			</table>
		</td>
	  </tr>
</table>
</div>
</div>
</body>
</html>
