<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');

$sNO 				= $_GET['q'];
$po_location		= $_GET['po_location'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WASHING FORMULA </title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
table
{
	border-spacing:1px;
	font:Arial, Helvetica, sans-serif;

	
}
</style>
</head>
<body>
<table align="center" width="800" border="0">

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  <?php	
  if($po_location=='outside')
	{
     $sql_header="	SELECT  m.strFabricId,
							m.strFabricContent,
							O.strStyleDes as strDescription,
							O.strStyleNo as	strStyle, 
							O.intPONo as strOrderNo, 
							O.strStyleNo as intStyleId ,
							wb.intGarmentId,
							wt.strWasType, 
							wb.strColor, wb.dblQty,
							wb.dblWeight, mt.strMachineCode,
							wb.dtmDate, wb.dblHTime,
							wb.intStatus,
							wb.intCompanyId
							FROM was_actualcostheader wb
							left JOIN was_outsidewash_fabdetails AS m ON m.intId= wb.intMatDetailId 
							INNER JOIN was_outsidepo AS O ON O.intId = wb.intStyleId
							INNER JOIN was_machinetype AS mt ON mt.intMachineId =wb.intMachineType
							INNER JOIN was_washtype AS wt ON wt.intWasID = wb.intWashType
							WHERE intSerialNo ='$sNO';";
	}
	else 
	{
     $sql_header="	SELECT 
					m.strItemDescription,
					O.strStyle,
					O.strOrderNo,
					wb.intStyleId ,
					wb.intGarmentId,
					wt.strWasType,
					wb.strColor,
					wb.dblQty,
					wb.dblWeight,
					mt.strMachineCode,
					wb.dtmDate,
					wb.dblHTime,
					wb.intStatus,
					O.strDescription,
					mt.strMachineType,
					wb.intCompanyId
					FROM 
					was_actualcostheader wb
					INNER JOIN matitemlist AS m ON m.intItemSerial= wb.intMatDetailId
					INNER JOIN orders AS O ON  O.intStyleId = wb.intStyleId 
					INNER JOIN was_machinetype AS mt ON mt.intMachineId =wb.intMachineType
					INNER JOIN was_washtype AS wt ON wt.intWasID = wb.intWashType
					WHERE 
					intSerialNo =$sNO;";
	}
	
				
	$resHeader=$db->RunQuery($sql_header);
	$rowHeader=mysql_fetch_array($resHeader); 
	$report_companyId=$rowHeader['intCompanyId'];
	include('../../reportHeader.php');
	
	 ?>
</td>
</tr>
<tr>
 <td class="head2">
 WASHING FORMULA
 </td>
 </tr>
</table>
	<?php
	

	$fabric=$rowHeader['strItemDescription'];
	$fabArr=split('-',$fabric);
	$c=count($fabArr);
	$fabDsc="";
	for($a=0;$a<$c-1;$a++)
	{
		$fabDsc.=$fabArr[$a]."-";
	}

	  //
      $sql_RTime="SELECT SUM(dblTime) R_TIME,SUM(dblLiqour) LIQUOR FROM was_actualcostdetails WHERE intSerialNo=$sNO;";
	  $resRT=$db->RunQuery($sql_RTime);
	  $rowRT=mysql_fetch_array($resRT);
	  ?>
<table width="800" align='center' CELLPADDING=3 CELLSPACING=1 border="0" >
	  <tr><?php if($rowHeader['intStatus']==0){  
 			//echo "<td class='normalfnt' align=\"left\" style=\"width:400px;color:#F30;\">NOT CONFIRM</td>";
			echo "<div style=\"position:absolute;top:300px;left:300px;\">
            	<img src=\"../../images/pending.png\">
           		 </div>";
             }else {
            //echo "<td class='normalfnt' align=\"left\" style=\"width:400px;color:#F30;\">CONFIRM</td>";
			 }?>
            <td>&nbsp;</td>
            <td class='normalfnt' align="left" style="width:100px;">
            	Cost No.:
            </td>
            <td class='normalfnt' align="left" style="width:100px;"><?php if($po_location=="inhouse"){ echo $sNO.'- In';}else{ echo $sNO.'- Out';} ?></td>
 	  </tr>
</table>

    
<table width="800" border="1" align='center' CELLPADDING=2 CELLSPACING=2 rules="all" bordercolor="#000000" >
      <tr height="25">
	  <td class='bcgl1txt1NB' align="left" width="12%" style="font-size:12px;">Date</td>
	  <td class='normalfnt' align="left" width="32%" style="font-size:12px;"><?php echo substr($rowHeader['dtmDate'],0,10); ?></td>
      <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Style No </td>
	  <td class='bcgl1txt1NB' align="left" width="39%" style="font-size:12px;"><span class="normalfnt"><?php echo $rowHeader['strStyle']; ?></span></td>
	  </tr>
      <tr height="20">
	  <td class='bcgl1txt1NB' align="left" width="12%" style="font-size:12px;">PO No</td>
	  <td class='bcgl1txt1NB' align="left" width="32%" style="font-size:12px;"><span class="bcgl1txt1NB" style="font-size:12px;"><?php echo $rowHeader['strOrderNo']; ?></span></td>
      <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Fabric Name </td>
	  <td class='normalfnt' align="left" width="39%" ><span class="bcgl1txt1NB" style="font-size:12px;">
	    <?php  echo ($po_location=='outside'?$rowHeader['strFabricId']:$fabDsc); ?>
	  </span></td>
	  </tr>
      <tr height="20">
	  <td class='bcgl1txt1NB' align="left" width="12%" style="font-size:12px;">Style Name </td>
	  <td class='normalfnt' align="left" width="32%"><span class="bcgl1txt1NB" style="font-size:12px;"><?php echo $rowHeader['strDescription']; ?></span></td>
      <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Fabric <span class="bcgl1txt1NB" style="font-size:12px;">Content</span></td>
	  <td class='bcgl1txt1NB' align="left" width="39%" style="font-size:12px;"><span class="normalfnt"><?php echo ($po_location=='outside'?$rowHeader['strFabricContent']:$fabArr[$c-1]);?></span></td>
	  </tr>	

      <tr height="20">
	  <td class='bcgl1txt1NB' align="left" width="12%" style="font-size:12px;">Color</td>
	  <td class='bcgl1txt1NB' align="left" width="32%" style="font-size:12px;"><?php echo $rowHeader['strColor']; ?></td>
      <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Running Time(m)</td>
	  <td class='normalfnt' align="left" width="39%"><span class="bcgl1txt1NB"><font  style='font-size: 12px;' ><?php echo $rowRT['R_TIME'];?></font></span></td>
	  </tr>	

      <tr height="20">
	  <td class='bcgl1txt1NB' align="left" width="12%" style="font-size:12px;">Weight<span class="bcgl1txt1NB" style="font-size:12px;">(kg)</span></td>
	  <td class='normalfnt' align="left" width="32%" style="font-size:12px;"><?php echo $rowHeader['dblWeight']?></td>
      <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Handling Time<span class="bcgl1txt1NB" style="font-size:12px;">(m)</span></td>
	  <td class='normalfnt' align="left" width="39%" style="font-size:12px;"><?php echo $rowHeader['dblHTime'];?></td>
	  </tr>	

      <tr height="20">
	  <td class='bcgl1txt1NB' align="left" width="12%" style="font-size:12px;">No of PCS</td>
	  <td class='bcgl1txt1NB' align="left" width="32%"><font  style='font-size: 12px;' ><?php echo $rowHeader['dblQty']?></font></td>
      <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Total Time<span class="bcgl1txt1NB" style="font-size:12px;">(m)</span></td>
	  <td class='normalfnt' align="left" width="39%" style="font-size:12px;"><strong><?php echo ($rowRT['R_TIME']+$rowHeader['dblHTime']);?></strong></td>
	  </tr>	
      
       <tr>
	  <td class='bcgl1txt1NB' align="left" width="12%" style="font-size:12px;">Wash Type</td>
	  <td class='normalfnt' align="left" width="32%" style="font-size:12px;"><?php echo $rowHeader['strWasType']; ?></td>
      <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Machine Code</td>
	  <td class='normalfnt' align="left" width="39%" style="font-size:12px;"><?php echo $rowHeader['strMachineType']?></td>
	  </tr>
</table>
<br />	
<table width="800" align="center" border="1" bordercolor="#000000" rules="cols"  CELLPADDING=3 CELLSPACING=3 >
            <tr height="28">
            	<td width="19" align="left" class='normalfntMid'>&nbsp;</td>
                <td width="110" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>PROCESS</strong></font></td>
                <td width="95" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>LIQUOR(L)</strong></font></td>
                <td width="70" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>TEMP(c)</strong></font></td>
                <td width="75" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>TIME(m)</strong></font></td>
                <td width="81" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>PH Value</strong></font></td>
                <td width="257" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>CHEMICAL</strong></font></td>
                <td width="43" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>UNIT</strong></font></td>
                <td width="36" align="left" class='normalfntMid'><font style='font-size: 15px;'><strong>QTY</strong></font></td>
            </tr>
            <?php 
			  $sql_processes="SELECT 
			  				  wb.intProcessId,
							  wb.intRowID,
							  wf.strProcessName,
							  wb.dblLiqour,
							  wb.dblTemp,
							  wb.dblTime,
							  wb.dblPHValue
							  FROM 
							  was_actualcostdetails wb
							  INNER JOIN was_washformula AS wf ON wf.intSerialNo=wb.intProcessId
							  WHERE 
							  wb.intSerialNo=$sNO order by intRowID;";
							  //echo $sql_processes;
			  $resP=$db->RunQuery($sql_processes);
			  while($rowP=mysql_fetch_array($resP))
			  {
			  
			  $sql_chemicals="SELECT wcl.strItemDescription, wcl.strUnit, wbc.dblQty, wbc.dblUnitPrice 
								FROM genmatitemlist wcl 
								INNER JOIN was_actcostchemicals AS wbc ON wbc.intChemicalId=wcl.intItemSerial 
								WHERE wcl.intStatus=1 AND wbc.intProcessId=".$rowP['intProcessId']."  AND wbc.intRowOder='".$rowP['intRowID']."' AND wbc.intSerialNo=$sNO;";
						//echo $sql_chemicals;
						$pid=1;
				$resCh=$db->RunQuery($sql_chemicals);
				$numRows=mysql_num_rows($resCh);
              	if($numRows>0)
				{
					while($rowCh=mysql_fetch_array($resCh))
					{
	  		?>
            <tr  <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>>
            	<td width="19" align="left" class='normalfntRite' valign="middle"><?php  if($pid==1){ echo $rowP['intRowID'];}?>&nbsp;</td>
            	<td class='normalfnt' align="left" valign="middle" ><font  style='font-size: 14px;' ><?php if($pid==1){echo $rowP['intRowOder']." ".$rowP['strProcessName'];}?></font></td>
                <td class='normalfntRite'  valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){echo number_format($rowP['dblLiqour']);}?></font>&nbsp;</td>
                <td class='normalfntRite'  valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){ if($rowP['dblTemp']==0) echo 'COOL'; else echo number_format($rowP['dblTemp']); };?></font>&nbsp;</td>
                <td class='normalfntRite' valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){echo number_format($rowP['dblTime'],2);}?></font>&nbsp;</td>
                <td class='normalfntRite' valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){echo number_format($rowP['dblPHValue'],2);}?></font>&nbsp;</td>
				<td class='normalfnt' style="border-bottom:solid #000 0px;" ><font  style='font-size: 13px;' >&nbsp;<?php  if($pid==1){?><br />&nbsp;<?php  } $des=split('-',$rowCh['strItemDescription']);$chmA="";
													for($a=3;$a<count($des);$a++){
															//$chmA.=$des[$a]."-";
															if((trim($des[$a])!="PWD"))
															  if(trim($des[$a])!="LIQ")
															  	if(trim($des[$a])!="PST")
																	$chmA.=$des[$a]."-";
													}
													//echo strConvertion(ucwords(strtolower(substr($chmA,0,strlen($chmA)-1))));
													echo substr($chmA,0,strlen($chmA)-1);
													?></font></td>
				<td class='normalfnt' style="border-bottom:solid #000 0px;text-align:center" ><font  style='font-size: 13px;' ><?php  if($pid==1){?><br /><?php  }echo $rowCh['strUnit'];?></font></td>
				<td class='normalfntRite' style="border-bottom:solid #000 0px;" ><font  style='font-size: 13px;' ><?php  if($pid==1){?><br /><?php  } echo number_format($rowCh['dblQty'],6);?></font></td>
  </tr>
			<?php $pid++;}
			  }
			else{?>
			<tr  <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>>
            	<td width="19" align="left" class='normalfntRite' valign="middle"><?php  if($pid==1){ echo $rowP['intRowID'];}?>&nbsp;</td>
            	<td class='normalfnt' valign="middle"><font  style='font-size: 14px;' ><?php echo $rowP['intRowOder']." ".$rowP['strProcessName'];?></font></td>
                <td class='normalfntRite' valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){echo number_format($rowP['dblLiqour']);}?></font>&nbsp;</td>
                <td class='normalfntRite' valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){if($rowP['dblTemp']==0) echo 'COOL'; else echo number_format($rowP['dblTemp']);}?></font>&nbsp;</td>
                <td class='normalfntRite' valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){echo number_format($rowP['dblTime'],2);}?></font>&nbsp;</td>
                <td class='normalfntRite' valign="middle"><font  style='font-size: 13px;' ><?php if($pid==1){echo number_format($rowP['dblPHValue'],2);}?></font>&nbsp;</td>
				<td class='normalfnt' colspan="1" height="19" valign="bottom"><font  style='font-size: 13px;' ><br />
			  &nbsp;&nbsp;NO CHEMICAL</font></td>
				<td class='normalfntMid'></td>
				<td class='normalfntMid' ></td>
			 </tr>
			<?php }
		}?>
            </table>


<br />
<table width="800" border='0' align='center' CELLPADDING=3 CELLSPACING=1 style="border:solid #000 1px;">
	 <tr>
      <td class='normalfnt' align="left" colspan="4"><b>THE ABOVE PROCESS IS AN INDICATION IT MAY REQUIRE FINE TUNING</b></td>
      </tr>
      <tr>
      <td class='normalfnt' align="left" colspan="4">&nbsp;</td>
      </tr>
      <tr>
      <td class='normalfnt' align="left" colspan="4">&nbsp;</td>
      </tr>
      <tr>
      <td class='normalfnt' align="left" colspan="4"><b>SIGNATURE</b></td>
      </tr>
      <tr>
	  <td width="97" colspan="1" align="left" class='normalfnt'>
      <td width="307" colspan="1"  class='normalfntMid'>............................................................</td>
      <td width="370" colspan="2"  class='normalfntMid'>............................................................</td>
      </tr>
      <tr>
	  <td width="97" colspan="1" align="left" class='normalfnt'>
      <td width="307" colspan="1"  class='normalfntMid'>PLANT MANAGER</td>
      <td width="370" colspan="2"  class='normalfntMid'>HEAD OF WASHING</td>
      </tr>
</table>
<br />

</body>
</html>
<?php 
function strConvertion($str){
	/* $c = explode('',$str);
	 $st='';
	
	 for($i=0;$i<count($c)-1;$i){
		if(is_numeric($c[$i])) 
			$st.= strtoupper($c[$i]); 
		else
			$st.=$c[$i].' ' ;
	 }*/
	return $str;
}