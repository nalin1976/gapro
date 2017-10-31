<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";  
$color		=  	$_GET["sub_cboColor"];
$factoryId	=	$_GET['sub_cboFactory'];
$po			= 	$_GET['sub_cboPo'];
$style		=	$_GET['sub_cboStyleNo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gapro:Washing-Sub Contractor Log</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<!--<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="../../javascript/script.js"></script>

<script src="subcontractor.js" type="text/javascript"></script>

<script type="text/javascript">
function fromSubmit(){
document.getElementById('frmSubWip').submit();
}
</script>
</head>
<!--onload="loadColor();"-->
<body >

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<form name="frmSubWip" id="frmSubWip" method="GET">
<table width="800" border="0" align="center" class="bcgl1" bgcolor="#FFFFFF">
  <tr>
  	<td class="mainHeading" colspan="5">Sub Contractor Log</td>
  </tr>
  <tr>
  	<td width="120" class="normalfnt">PO Number</td>
	<td width="181">
	<select style="width:150px;" id="sub_cboPo" name="sub_cboPo" onchange="getStyle(this)">
	<option value=""></option>
	<?php 
		$sql="SELECT DISTINCT orders.strOrderNo,orders.intStyleId FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.strType = 'SubOut' ORDER BY orders.strOrderNo ASC;";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["sub_cboPo"]== $row["intStyleId"])
				echo "<option selected=\"selected\"value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
		}?>
	</select>
	</td>
    <td width="45" class="normalfnt">Style</td>
	<td width="304" class="normalfnt">
    <select name="sub_cboStyleNo" id="sub_cboStyleNo" style="width:150px;" onchange="getPo(this)">	
    	<option value=""></option>
        <?php 
		$sql="SELECT DISTINCT orders.strStyle FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.strType = 'SubOut' AND  was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."' ORDER BY orders.strOrderNo ASC;";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["sub_cboStyleNo"]== $row["strStyle"])
				echo "<option selected=\"selected\"value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
			else
				echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
		}?>
    </select>
    </td> 
	<td width="190"><input type="hidden" id="sub_txtPurpose" name="sub_txtPurpose" style="width:250px;"/></td>
  </tr>
  <tr>
 	  <td class="normalfnt" >Color</td>
      <td class="normalfnt" >
      <select name="sub_cboColor" id="sub_cboColor" style="width:150px;">
      	<option value=""></option>
        <?php
			if($_GET["sub_cboColor"]== $color)
				echo "<option selected=\"selected\"value=\"".$_GET["sub_cboColor"]."\">".$_GET["sub_cboColor"]."</option>";
			else
				echo "<option value=\"".$_GET["sub_cboColor"]."\">".$_GET["sub_cboColor"]."</option>";
		?>
      </select>
      </td>
      <td class="normalfnt">Factory</td>
      <td >
      <select style="width:300px;" id="sub_cboFactory" name="sub_cboFactory">
		<option></option>
	<?php 
		$sql="SELECT DISTINCT was_outside_companies.intCompanyID,was_outside_companies.strName FROM was_outside_companies WHERE was_outside_companies.intStatus = 1 ORDER BY was_outside_companies.strName ASC;";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["sub_cboFactory"]== $row["intCompanyID"])
				echo "<option selected=\"selected\"value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
			else
				echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
		}?>
		</select>
    </td>
      <td style="text-align:center;"><img src="../../images/search.png" onclick="fromSubmit();" /></td>
  </tr>
  <tr>
  	<td colspan="5">
    <div style="overflow:scroll;height:350px;width:820px;">
		<table style="width:800px;" border="0" rules="rows">
			<tr>

				<td class="grid_header" colspan="5" style="width:400px;">Send</td>
                <td class="grid_header" colspan="4" style="width:400px;">Receive</td>
				
			</tr>
			<tr>
				<td style="width:20px;" class="grid_header">*</td>
				<td style="width:80px;" class="grid_header">Date</td>
				<td style="width:100px;" class="grid_header">AOD</td>
				<td style="width:100px;" class="grid_header">Qty</td>
				<td style="width:100px;" class="grid_header">Total Qty</td>
                <td style="width:100px;" class="grid_header">AOD</td>
                <td style="width:100px;" class="grid_header">Qty</td>
                <td style="width:100px;" class="grid_header">Total Qty</td>
				<td style="width:100px;" class="grid_header">Balance</td>
			</tr>  
            <?php 
				$res=getDets($po,$factoryId,$color);
				$dt='';
				$sOutTot=0;
				$sInTot=0;
				$i=0;
				while($row=mysql_fetch_array($res)){
				$cls='';
				($i%2==0)?$cls="grid_raw":$cls="grid_raw2";
				if($row['SOD']=="" || $row['SOD']!=$dt){	
			?> 
        <tr>
				<td style="width:20px;background-color:#99F;" class="normalfnt" colspan="9"><?php echo $row['SOD'];$dt=$row['SOD'];?></td>
        </tr>
        <?php }?>
	    <tr>
				<td style="width:20px;" class="<?php echo $cls;?>">&nbsp;</td>
				<td class="<?php echo $cls;?>" style="width:80px;text-align:left;">&nbsp;</td>
				<td class="<?php echo $cls;?>" style="text-align:left;"><?php if($row['STYPE']=='SUBOUT'){echo $row['AOD'];}?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if($row['STYPE']=='SUBOUT'){ echo $row['dblQty'];$sOutTot=$sOutTot+$row['dblQty'];}?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if($row['STYPE']=='SUBOUT'){echo $sOutTot;}?></td>
                <td class="<?php echo $cls;?>" style="text-align:left;"><?php if($row['STYPE']=='SUBIN'){echo $row['AOD'];}?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if($row['STYPE']=='SUBIN'){echo $row['dblQty'];$sInTot=$sInTot+$row['dblQty'];}?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if($row['STYPE']=='SUBIN'){echo $sInTot;}?></td>          
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php $cum=$sOutTot-$sInTot;if($cum==0){?><font color="#FF0000"><?php }echo $cum;?></font></td>
         </tr>  
         <?php
			$i++;	}
		 ?>
	  </table>
	</div>
 <table width="800" border="0" align="center" bgcolor="#FFFFFF"><!-- class="bcgl1"-->
      <tr style="background-color:#FFF;">
				<td width="25%" class="normalfnt"  style="text-align:left"><!--TOTAL--></td>
				<td width="25%"  class="normalfnt" style="text-align:right"><?php //echo $total; ?>
			    <img src="../../images/new.png" onclick="clearF();" /></td>
				<td width="25%"  ><img src="../../images/report.png" onclick="showLogReport();"/></td>
				<td width="25%" class="normalfnt"  style="text-align:left"><!--TOTAL--></td>
		  </tr>
  </table>
	</td>
  </tr>
</table>
</form>
<?php

function getDets($po,$factoryId,$color){
global $db;
$sqlO="SELECT TBL.AOD,TBL.dblQty,TBL.SOD,TBL.STYPE 
FROM (SELECT
concat(sO.intAODYear,'/',sO.intAODNo) AS AOD,
sO.dblSaveSerial,
sO.dblQty,
DATE(sO.dtmDate) AS SOD,
sO.intCompanyID,
'SUBOUT' AS STYPE
FROM
was_subcontractout AS sO
WHERE
sO.intStyleId = '$po' AND
sO.intSubContractNo = '$factoryId' AND
sO.strColor = '$color' AND
sO.intCompanyID='".$_SESSION['FactoryID']."'
UNION
SELECT
sI.strGatePassNo,
sI.dblSaveSerial,
sI.dblQty,
DATE(sI.dtmDate) AS SID,
sI.intCompanyID,
'SUBIN' AS STYPE
FROM
was_subcontractin AS sI
WHERE
sI.intSubContractNo='$factoryId' AND
sI.intStyleId='$po' AND
sI.strColor='$color' AND
sI.intCompanyID='".$_SESSION['FactoryID']."') AS TBL
ORDER BY TBL.dblSaveSerial;";
//echo $sqlO;
return $db->RunQuery($sqlO);

}
?>
</body>
</html>
