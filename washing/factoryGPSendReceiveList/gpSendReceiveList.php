<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";  
$color		=  	$_GET["cboColor"];
$factoryId	=	$_GET['cboFactory'];
$po			= 	$_GET['cboPo'];
$style		=	$_GET['cboStyleNo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gapro | Gatapass Send Receive Log</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<!--<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="../../javascript/script.js"></script>

<script src="gpSendReceiveList.js" type="text/javascript"></script>

<script type="text/javascript">
function fromSubmit(){
document.getElementById('frmGPLog').submit();
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
<form name="frmGPLog" id="frmGPLog" method="GET">
<table width="800" border="0" align="center" class="bcgl1" bgcolor="#FFFFFF">
  <tr>
  	<td class="mainHeading" colspan="5">Gatapass Send Receive Log</td>
  </tr>
  <tr>
  	<td width="120" class="normalfnt">PO Number</td>
	<td width="181">
	<select style="width:150px;" id="cboPo" name="cboPo" onchange="getStyle(this)">
	<option value=""></option>
	<?php 
		$sql="SELECT DISTINCT o.strOrderNo,o.intStyleId FROM was_stocktransactions AS w INNER JOIN orders AS o ON w.intStyleId = o.intStyleId WHERE w.strType IN ('FacRCvIn', 'FTransIn', 'FacOut', 'mrnIssue', 'IRtn') AND w.intCompanyId = '".$_SESSION['FactoryID']."' ORDER BY o.strOrderNo ASC";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["cboPo"]== $row["intStyleId"])
				echo "<option selected=\"selected\"value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
		}?>
	</select>
	</td>
    <td width="45" class="normalfnt">Style</td>
	<td width="304" class="normalfnt">
    <select name="cboStyleNo" id="cboStyleNo" style="width:150px;" onchange="getPo(this)">	
    	<option value=""></option>
        <?php 
		$sql="SELECT DISTINCT orders.strStyle FROM was_stocktransactions INNER JOIN orders ON was_stocktransactions.intStyleId = orders.intStyleId WHERE was_stocktransactions.strType IN ('FacRCvIn', 'FTransIn', 'FacOut', 'mrnIssue', 'IRtn') AND  was_stocktransactions.intCompanyId='".$_SESSION['FactoryID']."' ORDER BY orders.strOrderNo ASC;";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["cboStyleNo"]== $row["strStyle"])
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
      <select name="cboColor" id="cboColor" style="width:150px;">
      	<option value=""></option>
        <?php
			if($_GET["cboColor"]== $color)
				echo "<option selected=\"selected\"value=\"".$_GET["cboColor"]."\">".$_GET["cboColor"]."</option>";
			else
				echo "<option value=\"".$_GET["cboColor"]."\">".$_GET["cboColor"]."</option>";
		?>
      </select>
      </td>
      <td class="normalfnt">Factory</td>
      <td >
      <select style="width:300px;" id="cboFactory" name="cboFactory">
		<option></option>
	<?php 
		$sql="SELECT DISTINCT c.intCompanyID,c.strName FROM companies AS c WHERE c.intStatus = 1 order by c.strName ASC;";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["cboFactory"]== $row["intCompanyID"])
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

				<td class="grid_header" colspan="5" style="width:400px;">Receive</td>
                <td class="grid_header" colspan="4" style="width:400px;">Send</td>
				
			</tr>
			<tr>
				<td style="width:20px;" class="grid_header">*</td>
				<td style="width:100px;" class="grid_header">GP Type</td>
				<td style="width:100px;" class="grid_header">AOD</td>
				<td style="width:80px;" class="grid_header">Qty</td>
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
				<td style="width:20px;background-color:#CCC;" class="normalfnt" colspan="9"><?php echo $row['SOD'];$dt=$row['SOD'];?></td>
        </tr>
        <?php }//($row['REMARK']=='FTransIn' ||  $row['REMARK']== 'IRtn' || $row['REMARK']== 'FacRCvIn') && ?>
	    <tr>
				<td colspan="2" class="<?php echo $cls;?>" style="width:20px;text-align:left;"><?php setGPTypes($row['REMARK'],$row['dblQty']) ;?></td>
				<td class="<?php echo $cls;?>" style="text-align:left;"><?php if(((int)$row['dblQty'] > 0)){echo $row['AOD'];} ?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if(((int)$row['dblQty'] > 0)){echo abs($row['dblQty']);$sOutTot=$sOutTot+abs($row['dblQty']);}?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if(((int)$row['dblQty'] > 0)){echo $sOutTot;}?></td>
                <td class="<?php echo $cls;?>" style="text-align:left;"><?php if( ($row['dblQty'] < 0)){echo $row['AOD'];}?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if(($row['dblQty'] < 0)){echo abs($row['dblQty']);$sInTot=$sInTot+abs($row['dblQty']);}?></td>
				<td class="<?php echo $cls;?>" style="text-align:right;"><?php if(($row['dblQty'] < 0)){ echo $sInTot;}?></td>          
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
 $sqlO="SELECT
		w.intStyleId,
		concat(w.intDocumentYear,'/',w.intDocumentNo) as AOD,
		w.strColor,
		w.strType AS REMARK,
		Sum(w.dblQty) as dblQty,
		date(w.dtmDate) as SOD,
		w.intUser,
		w.intCompanyId
		FROM
		was_stocktransactions AS w
		WHERE
		w.intCompanyId = '".$_SESSION['FactoryID']."' AND
		w.strType IN ('FTransIn', 'FacOut', 'mrnIssue', 'IRtn','FacRCvIn') AND
		w.intStyleId = '$po' AND
		w.strColor='$color'
		GROUP BY
		w.strColor,
		w.intStyleId,
		w.strType,
		concat(w.intDocumentYear,'/',w.intDocumentNo)
		ORDER BY
		w.dtmDate ASC;";
//echo $sqlO;
return $db->RunQuery($sqlO);

}

function setGPTypes($gp,$qty){
	switch($gp){
	case 'FTransIn':
		if($qty>0)
			echo "Sewing Factory GP Receive";
		else
			echo "Washing Factory GP";
				
		break;
	case 'mrnIssue':
		echo "MRN GP";	
		break;
	case 'IRtn':
		echo "MRN Return GP";	
		break;
	case 'FacOut':
		echo "Lot/Bulk Wise GP";	
		break;
	default:
        echo "";		
	}
}
?>
</body>
</html>
