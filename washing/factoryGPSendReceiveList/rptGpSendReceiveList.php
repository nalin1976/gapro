<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
$po=$_GET['po'];
$color=$_GET['color'];
$factory=$_GET['factory'];
$report_companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gatepass Send Receive Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table align="center" width="800" border="0">

<tr>
 	 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  		<?php include('../../reportHeader.php'); ?>
	 </td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
  		Gatepass Send Receive Report
 </td>
</tr>

</table>
<table style="width:800px;" border="1" rules="all" align="center">
			<tr>

				<td class="normalfntMid" colspan="4" style="width:500px;">Receive</td>
                <td class="normalfntMid" colspan="4" style="width:400px;">Send</td>
				
			</tr>
			<tr>
				<td class="normalfntMid" style="width:220px;">GP Type</td>
				<td style="width:100px;" class="normalfntMid">AOD</td>
				<td style="width:80px;" class="normalfntMid">Qty</td>
				<td style="width:100px;" class="normalfntMid">Total Qty</td>
                <td style="width:100px;" class="normalfntMid">AOD</td>
                <td style="width:100px;" class="normalfntMid">Qty</td>
                <td style="width:100px;" class="normalfntMid">Total Qty</td>
				<td style="width:100px;" class="normalfntMid">Balance</td>
			</tr>  
            <?php 
				$res=getDets($po,$factory,$color);
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
				<td style="width:20px;background-color:#CCC;" class="normalfnt" colspan="8"><?php echo $row['SOD'];$dt=$row['SOD'];?></td>
        </tr>
        <?php }//($row['REMARK']=='FTransIn' ||  $row['REMARK']== 'IRtn' || $row['REMARK']== 'FacRCvIn') && ?>
	    <tr>
				<td class="normalfnt" style="width:20px;text-align:left;"><?php setGPTypes($row['REMARK'],$row['dblQty']) ;?></td>
				<td class="normalfnt" style="text-align:left;"><?php if(((int)$row['dblQty'] > 0)){echo $row['AOD'];} ?></td>
				<td class="normalfnt" style="text-align:right;"><?php if(((int)$row['dblQty'] > 0)){echo abs($row['dblQty']);$sOutTot=$sOutTot+abs($row['dblQty']);}?></td>
				<td class="normalfnt" style="text-align:right;"><?php if(((int)$row['dblQty'] > 0)){echo $sOutTot;}?></td>
                <td class="normalfnt" style="text-align:left;"><?php if( ($row['dblQty'] < 0)){echo $row['AOD'];}?></td>
				<td class="normalfnt" style="text-align:right;"><?php if(($row['dblQty'] < 0)){echo abs($row['dblQty']);$sInTot=$sInTot+abs($row['dblQty']);}?></td>
				<td class="normalfnt" style="text-align:right;"><?php if(($row['dblQty'] < 0)){ echo $sInTot;}?></td>          
				<td class="normalfnt" style="text-align:right;"><?php $cum=$sOutTot-$sInTot;if($cum==0){?><font color="#FF0000"><?php }echo $cum;?></font></td>
         </tr>  
         <?php
			$i++;	}
		 ?>
         
        
	  </table>
      <br />
      <table align="center" style="width:800px;" border="0">
      	<tr>
				<td width="161" class="normalfntMid" ><?php echo getUser($_SESSION['UserID']);?></td>
				<td width="540" class="normalfntMid"></td>
				<td width="77" class="normalfntMid"></td>
         </tr>
      	 <tr>
				<td width="161" class="normalfntMid" >.......................</td>
				<td width="540" class="normalfntMid"></td>
				<td width="77" class="normalfntMid"></td>
         </tr>
         <tr>
				<td class="normalfntMid">Received By</td>
				<td class="normalfntMid"></td>
				<td class="normalfnt"></td>
         </tr>
         
      </table>
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

function getUser($user){
	global $db;
	$sql="select * from useraccounts where intUserID='$user';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_assoc($res);
	return $row['Name'];
	
}
?>
</body>
</html>