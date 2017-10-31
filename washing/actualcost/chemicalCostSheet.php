<?php
 session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
//$report_companyId=$_SESSION['FactoryID'];
$sNO = $_GET['q'];
$dpl=4;
$TCCPDz=0;
$OHC=0;
$CPDzOH=0;
$po_location		= $_GET['po_location'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CHEMICAL COST SHEET </title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
table
{
	border-spacing:0px;
}
.rowBoder
{
	border-bottom:solid #CCC 2px;
}
</style>
</head>
<body>
<table align="center" width="800" border="0">
<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
 <?php if($po_location=='outside')
	{	   
		$sql_header="SELECT
					was_actualcostheader.intDivisionId,
					was_actualcostheader.intCompanyId,
					was_actualcostheader.intGarmentId,
					was_actualcostheader.strColor,
					was_actualcostheader.dblWeight,
					was_actualcostheader.dblHTime,
					was_actualcostheader.intRevisionNo,
					was_actualcostheader.dblQty AS PCs,
					was_actualcostheader.intStatus,
					was_outsidepo.intPONo AS strOrderNo,
					was_outsidepo.strStyleNo as strStyle,
					was_outsidepo.strStyleDes AS strDescription,
					was_outsidewash_fabdetails.strFabricId AS strItemDescription,
					was_outsidewash_fabdetails.strFabricContent,
					was_washtype.strWasType,
					buyerdivisions.strDivision,
					productcategory.strCatName as strGarmentName,
					suppliers.strTitle,
					was_outsidepo.dblOrderQty as intQty,
					was_machinetype.intMachineId,
					was_machinetype.dblOHCostMin,
					was_machinetype.strMachineType,
					was_machinetype.dblUnitPrice,
					was_machinetype.strMachineCode,
					was_outsidepo.intId as intStyleId
					FROM
					was_actualcostheader
					Inner Join was_outsidepo ON was_actualcostheader.intStyleId = was_outsidepo.intId
					Inner Join was_outsidewash_fabdetails ON was_outsidewash_fabdetails.intId = was_outsidepo.intFabId
					Inner Join was_washtype ON was_actualcostheader.intWashType = was_washtype.intWasID
					left  Join buyerdivisions ON was_outsidepo.intDivision = buyerdivisions.intDivisionId
					Inner Join productcategory ON was_actualcostheader.intGarmentId = productcategory.intCatId
					Inner Join suppliers ON was_outsidewash_fabdetails.strMill = suppliers.strSupplierID
					Inner Join was_machinetype ON was_actualcostheader.intMachineType = was_machinetype.intMachineId
					WHERE
					was_actualcostheader.intSerialNo = '$sNO';";
					//echo $sql_header;
	}
	else 
	{
		$sql_header="SELECT
					orders.strStyle,
					orders.strOrderNo,
					orders.intStyleId,
					orders.intBuyerID,
					orders.strDescription,
					was_actualcostheader.intDivisionId,
					buyerdivisions.strDivision,
					was_actualcostheader.intCompanyId,
					orders.intDivisionId,
					was_actualcostheader.intGarmentId,
					productcategory.strCatName as strGarmentName,
					orderdetails.intMillId,
					orderdetails.intMatDetailID,
					orderdetails.intMainFabricStatus,
					matitemlist.strItemDescription,
					suppliers.strTitle,
					was_washtype.strWasType,
					was_actualcostheader.strColor,
					orders.intQty,
					was_actualcostheader.dblWeight,
					was_actualcostheader.dblHTime,
					was_machinetype.intMachineId,
					was_machinetype.dblOHCostMin,
					was_machinetype.strMachineType,
					was_machinetype.dblUnitPrice,
					was_machinetype.strMachineCode,
					was_actualcostheader.intRevisionNo,
					was_actualcostheader.dblQty AS PCs,
					was_actualcostheader.intStatus
					FROM
					was_actualcostheader
					Inner Join orders ON was_actualcostheader.intStyleId = orders.intStyleId
					left Join buyerdivisions ON buyerdivisions.intBuyerID = orders.intBuyerID AND orders.intDivisionId = buyerdivisions.intDivisionId
					Inner Join productcategory ON was_actualcostheader.intGarmentId = productcategory.intCatId
					Inner Join orderdetails ON orderdetails.intStyleId = orders.intStyleId AND was_actualcostheader.intMatDetailId = orderdetails.intMatDetailID
					Inner Join matitemlist ON matitemlist.intItemSerial = was_actualcostheader.intMatDetailId
					Inner Join suppliers ON orderdetails.intMillId = suppliers.strSupplierID
					Inner Join was_washtype ON was_actualcostheader.intWashType = was_washtype.intWasID AND was_washtype.intWasID = was_actualcostheader.intWashType
					Inner Join was_machinetype ON was_actualcostheader.intMachineType = was_machinetype.intMachineId
					WHERE
					orderdetails.intMainFabricStatus =  '1' AND
					was_actualcostheader.intSerialNo =  '$sNO';";
					
	}
				//echo $sql_header; AND orderdetails.strOrderNo = orders.strOrderNo 
	$resHeader=$db->RunQuery($sql_header);
	$rowHeader=mysql_fetch_array($resHeader);
	$report_companyId=$rowHeader['intCompanyId'];
	
	include('../../reportHeader.php'); ?>
</td>
</tr>
<tr>
 <td class="head2">
 CHEMICAL COST SHEET
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
	
	?>
<table width="800" align='center' CELLPADDING=1 CELLSPACING=1 border="0" >
	  <tr><?php if($rowHeader['intStatus']=='0'){  
 			echo "<td class='normalfnt' align=\"left\" style=\"width:400px;color:#F30;\">NOT CONFIRM</td>";
             }else {
            echo "<td class='normalfnt' align=\"left\" style=\"width:400px;color:#F30;\">CONFIRM</td>";
			 }?>
            <td>&nbsp;</td>
            <td class='normalfnt' align="left" style="width:100px;">
            	<font  style='font-size: 9px;'><b>Cost No.:
            </td>
            <td class='normalfnt' align="left" style="width:100px;"><font  style='font-size: 9px;'><b><?php if($po_location=="inhouse"){ echo $sNO.'- In';}else{ echo $sNO.'- Out';} ?></td>
 	  </tr>
</table>

    
<table width="800"  border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="all" bordercolor="#000000" >
      <tr height="20">
	  <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Style</td>
	  <td class='bcgl1txt1NB' align="left"  width="320"><font  style='font-size: 12px;' ><?php echo $rowHeader['strDescription']; ?></font></td>
      <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Style No </td>
	  <td class='normalfnt' align="left"  width="297" style="font-size:12px;"><?php echo $rowHeader['strStyle']; ?></td>
	  </tr>
      <tr height="20">
	  <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Fabric</td>
	  <td class='bcgl1txt1NB' align="left"  width="320"><font  style='font-size: 12px;' ><?php echo $rowHeader['strItemDescription']; ?></font></td>
      <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">PO No </td>
	  <td class='bcgl1txt1NB' align="left"  width="297"><font  style='font-size: 12px;' ><?php echo $rowHeader['strOrderNo'];?></font></td>
	  </tr>
      <tr height="20">
	  <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Fab Content</td>
	  <td class='normalfnt' align="left"  width="320" style="font-size:12px;"><?php  if($po_location!='outside'){echo $fabArr[$c-1];}else echo $rowHeader['strFabricContent'];?></td>
      <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">PO QTY</td>
	  <td class='normalfnt' align="left"  width="297" style="font-size:12px;"><?php echo $rowHeader['intQty'];?></td>
	  </tr>	

      <tr height="20">
	  <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Wash Type</td>
	  <td class='normalfnt' align="left"  width="320" style="font-size:12px;"><?php echo $rowHeader['strWasType']; ?></td>
      <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Mill</td>
	  <td class='normalfnt' align="left"  width="297" style="font-size:12px;"><?php echo $rowHeader['strTitle']; ?></td>
	  </tr>	

      <tr height="20">
	  <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Weight</td>
	  <td class='normalfnt' align="left"  width="320" style="font-size:12px;"><?php echo $rowHeader['dblWeight']; ?></td>
      <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Division</td>
	  <td class='normalfnt' align="left"  width="297" style="font-size:12px;"><?php echo $rowHeader['strDivision']; ?></td>
	  </tr>	

      <tr height="20">
	  <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Garment</td>
	  <td class='normalfnt' align="left"  width="320" style="font-size:12px;"><?php echo $rowHeader['strGarmentName']; ?></td>
      <td class='bcgl1txt1NB' align="left"  width="130" style="font-size:12px;">Color</td>
	  <td class='bcgl1txt1NB' align="left"  width="297"><font  style='font-size: 12px;' ><?php echo $rowHeader['strColor']; ?></font></td>
	  </tr>	
</table>	
<!--<br />-->
<table width="800" border='1' align='center' CELLPADDING=1 CELLSPACING=1 bordercolor="#000000" rules="all">
      <tr height="25">
	 	<td class='bcgl1txt1NB' align="left" style="width:80px;"> Running Time</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:90px;"> Handling Time</td>
	 	<td class='bcgl1txt1NB' align="left" style="width:80px;">Total Time</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:120px;">OH Cost Per minute </td>
	 	<td class='bcgl1txt1NB' align="left" style="width:50px;">OH Cost</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:70px;display:none"> TagCostDz</td>
	 	<td class='bcgl1txt1NB' align="left" style="width:70px;">Water (L)</td>
	  	<td class='bcgl1txt1NB' align="left" style="width:80px;">Unit Price($) </td>
	  	<td class='bcgl1txt1NB' align="left" style="width:60px;"> Value</td>
	  </tr>
      <?php
	  //
      $sql_RTime="SELECT SUM(dblTime) R_TIME,SUM(dblLiqour) LIQUOR FROM was_actualcostdetails WHERE intSerialNo=$sNO;";
	  $resRT=$db->RunQuery($sql_RTime);
	  $rowRT=mysql_fetch_array($resRT);
	  ?>	
      <tr>
	 	<td class='normalfnt' style="text-align:center;" ><font  style='font-size: 12px;' ><?php echo $rowRT['R_TIME'];?></font></td>
	  	<td class='normalfnt' style="text-align:center;" ><font  style='font-size: 12px;' ><?php echo $rowHeader['dblHTime'];?></font></td>
	 	<td class='normalfnt' style="text-align:center;" ><font  style='font-size: 12px;' ><?php echo ($rowRT['R_TIME']+$rowHeader['dblHTime']);?></font></td>
	  	<td class='normalfnt' style="text-align:center;" ><font  style='font-size: 12px;' ><?php echo $rowHeader['dblOHCostMin'];?></font></td>
	 	<td class='normalfnt' style="text-align:center;" ><font  style='font-size: 12px;' ><?php echo number_format(round(($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']),2),2);?></font></td>
	  	<td class='normalfnt' style="text-align:center;display:none"><font  style='font-size: 12px;' ><?php echo $rowHeader['dblTaggingCost'];?></font></td>
	 	<td class='normalfnt' style="text-align:center;"><font  style='font-size: 12px;' ><?php echo $rowRT['LIQUOR'];?></font></td>
	  	<td class='normalfnt' style="text-align:center;"><font  style='font-size: 12px;' ><?php echo $rowHeader['dblUnitPrice'];?></font></td>
	  	<td class='normalfnt' style="text-align:center;"><font  style='font-size: 12px;' ><?php echo number_format(round(($rowRT['LIQUOR']*$rowHeader['dblUnitPrice']),2),2);?></font></td>
	  </tr>	
</table>
<table width="800" border='0' align='center' CELLPADDING=1 CELLSPACING=1 >
      <tr>
	 	<td class='bcgl1txt1NB' align="left" style="width:120px;"> Machine Code</td>
	  	<td class='normalfnt' align="left" > : <font  style='font-size: 11px;' ><?php echo $rowHeader['strMachineCode'];?></font></td>
	 	<td class='bcgl1txt1NB' align="left" style="width:120px;">NO. of PCS </td>
	  	<td class='normalfnt' align="left"> : <font  style='font-size: 11px;' ><?php echo $rowHeader['PCs'];?></font></td>
	 	<td class='bcgl1txt1NB' align="left" style="width:120px;display:none;">Tag Cos</td>
	  	<td class='normalfnt' align="left">: </td>
	 	<td class='bcgl1txt1NB' align="left" style="width:120px;">Revision No</td>
	  	<td class='normalfnt' align="left"> : <font  style='font-size: 11px;' ><?php echo $rowHeader['intRevisionNo'];?></font></td>
	  </tr>	
</table>
<table width="800" border='1' align='center' CELLPADDING=1 CELLSPACING=1  bordercolor="#000000" rules="cols">
      <tr style="border-bottom:#000 solid 1px;"><!---->
	 	<td width="20" class='normalfntMid' ><strong> </strong></td>
	  	<td width="200" class='normalfntMid' ><strong>PROCESS</strong></td>
	 	<td width="302" class='normalfntMid' ><strong>CHEMICAL</strong></td>
	  	<td width="75" class='normalfntRite' ><strong>UNIT PRICE</strong></td>
	 	<td width="72" class='normalfntMid' ><strong>QTY</strong></td>
	  	<td width="41" class='normalfntMid' ><strong>UNIT</strong></td>
	 	<td width="52" class='normalfntMid' ><strong>VALUE</strong></td>
	  </tr>	
      <?php 
			  $sql_processes="SELECT 
			  				  wb.intProcessId,
							  wb.intRowID,
							  wf.strProcessName
							  FROM 
							  was_actualcostdetails wb
							  INNER JOIN was_washformula AS wf ON wf.intSerialNo=wb.intProcessId
							  WHERE 
							  wb.intSerialNo=$sNO order by  wb.intRowID;";
							  //echo $sql_processes;
			  $resP=$db->RunQuery($sql_processes);
			  while($rowP=mysql_fetch_array($resP))
			  {
			  $sql_chemicals="SELECT wcl.strItemDescription, wcl.strUnit, wbc.dblQty, wbc.dblUnitPrice,wbc.intChemicalId 
								FROM genmatitemlist wcl 
								INNER JOIN was_actcostchemicals AS wbc ON wbc.intChemicalId=wcl.intItemSerial 
								WHERE wcl.intStatus=1 AND wbc.intProcessId='".$rowP['intProcessId']."' AND wbc.intRowOder='".$rowP['intRowID']."' AND wbc.intSerialNo='$sNO';";
				//echo $sql_chemicals;
				$pid=1;
				$resCh=$db->RunQuery($sql_chemicals);
				$nR=mysql_num_rows($resCh);
				if($nR > 0){
					while($rowCh=mysql_fetch_array($resCh))
					{
					?>
					<tr  <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>>
					  <td class='normalfnt' valign="middle">&nbsp;<?php if($pid==1){echo $rowP['intRowID'];} ?></td>
					  <td valign="middle" class='normalfnt'><font  style='font-size: 12px;' ><?php  if($pid==1){echo $rowP['strProcessName'];}?></font></td>
					  <td class='normalfnt' style="border-bottom:solid #000 0px;font-size: 12px;" >&nbsp;<font  style='font-size: 12px;' ><?php if($pid==1){?><br />&nbsp; <?php }
									$val=$rowCh['strItemDescription'];
										//echo $rowCh['strItemDescription'];
										$des=split('-',$rowCh['strItemDescription']); 
										$chmA="";
													for($a=3;$a<count($des);$a++){
														//echo $des[$a];
															if((trim($des[$a])!="PWD"))
															  if(trim($des[$a])!="LIQ")
															  	if(trim($des[$a])!="PST")
																	$chmA.=$des[$a]."-";
															  
															
															
													}
													echo substr($chmA,0,strlen($chmA)-1);
										//echo $des[count($des)-1];
									?></font></td>
					  <td class='normalfntRite' style="border-bottom:solid #000 0px;"><font  style='font-size: 12px;' ><?php if($pid==1){?><br />&nbsp; <?php } echo number_format($rowCh['dblUnitPrice'],2);?></font></td>
					  <td class='normalfntRite' style="border-bottom:solid #000 0px;"><font  style='font-size: 12px;' ><?php if($pid==1){?><br /> <?php } echo number_format($rowCh['dblQty'],6);?></font></td>
					  <td class='normalfnt' style="border-bottom:solid #000 0px;text-align:center;"><font  style='font-size: 12px;' ><?php if($pid==1){?><br /> <?php } echo $rowCh['strUnit'];?></font></td>
					  <td class='normalfntRite' style="border-bottom:solid #000 0px;"><font  style='font-size: 12px;' ><?php if($pid==1){?><br />&nbsp; <?php }echo number_format($rowCh['dblUnitPrice']*$rowCh['dblQty'],2);
									$totCost += $rowCh['dblUnitPrice']*$rowCh['dblQty'];
									?></font></td>
					</tr>
					<?php 
					$pid++;
					}
				} 
				else{?>
            <tr  <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>>
              <td class='normalfnt' valign="middle" >&nbsp;<?php echo $rowP['intRowID']; ?></td>
              <td valign="middle" class='normalfnt'><font  style='font-size: 12px;' ><?php echo $rowP['strProcessName'];?></font></td>
              <td class='normalfnt' ><br />&nbsp; <font  style='font-size: 12px;' >No Chemical</font></td>
              <td class='normalfnt'>&nbsp;</td>
              <td class='normalfnt'>&nbsp;</td>
              <td class='normalfnt'>&nbsp;</td>
              <td class='normalfnt'>&nbsp;</td>
            </tr>
			<?php  }
			}?>
</table>
            
<table width="800" border='0' align='center' CELLPADDING=1 CELLSPACING=1>
	<tr>
	 	<td class='bcgl1txt1NB' align="left" colspan="6">Total Chemical Cost</td>
	 	<td class='normalfntRite' align="right" style="width:120px;"><font  style='font-size: 12px;' ><?php echo number_format($totCost,2); ?></font></td>
	</tr>
</table>

<table width="800" border='1' align='center' CELLPADDING=1 CELLSPACING=1 rules="all" bordercolor="#000000">
      <tr>
	 	<td width="190" class='normalfntMid'> </td>
	  	<td width="124" class='normalfntMid'><strong>OverHead Cost</strong></td>
	 	<td width="114" class='normalfntMid'><strong>Water Cost </strong></td>
	  	<td width="110" class='normalfntMid' style="display:none"><strong>Tagging Cost</strong></td>
	 	<td width="128" class='normalfntMid'><strong>Chemical Cost</strong></td>
	  	<td width="101" class='normalfntMid'><strong>Total Cost </strong></td>
	  </tr>	
      <tr>
	 	<td class='bcgl1txt1NB'>Cost </td>
	  	<td class='normalfntRite'><font  style='font-size: 12px;' >
        <?php echo number_format($OHC=round(($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']),2),2);?>
        </font>
        </td>
	 	<td class='normalfntRite'><font  style='font-size: 12px;' >
        <?php number_format( $WC=($rowRT['LIQUOR']*$rowHeader['dblUnitPrice']),2);
		echo round($WC,2);
		?>
        </font>
        </td>
	  	<td class='normalfntRite' style="display:none"><font  style='font-size: 12px;' >
        <?php echo number_format($TC=($rowHeader['dblTaggingCost']/12)*$rowHeader['dblQty'],2);?>
        </font>
        </td>
	 	<td class='normalfntRite'><font  style='font-size: 12px;' >
		<?php echo number_format(round($totCost,2),2);?></font></td>
	  	<td class='normalfntRite'><font  style='font-size: 12px;' >
        <?php 
		$COST=$OHC+$WC+$TC+$totCost;
		echo number_format(round($COST,2),2);  ?>
        </font>
        
        </td>
	  </tr>
       <tr>
	 	<td class='bcgl1txt1NB' align="left" style="width:120px;">Cost per Doz</td>
	  	<td class='normalfntRite'><font  style='font-size: 12px;' >
		<?php
		$CPDzOH=((($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']))/$rowHeader['PCs'])*12;
		 echo number_format(round($CPDzOH,2),2);
		?></font></td>
	 	<td class='normalfntRite'><font  style='font-size: 12px;' >
        <?php 
		$CPDzWC=((($rowRT['LIQUOR']*$rowHeader['dblUnitPrice'])/$rowHeader['PCs'])*12);
		echo number_format(round($CPDzWC,2),2);
		?></font>
        </td>
	  	<td class='normalfntRite' style="display:none"><font  style='font-size: 12px;' ><?php echo number_format($CPDzTC =$rowHeader['dblTaggingCost'],2);?></font></td>
	 	<td class='normalfntRite'><font  style='font-size: 12px;' >
		<?php 
		$CPDzTCost= ($totCost/$rowHeader['PCs'])*12;
		echo number_format(round($CPDzTCost,2),2);
		?></font></td>
	  	<td class='normalfntRite'><font  style='font-size: 12px;' ><?php $TCCPDz=$CPDzOH+$CPDzWC+$CPDzTC+$CPDzTCost;
		echo number_format(round($TCCPDz,2),2);
		?></font></td>
	  </tr>
       <tr align="right">
	 	<td class='bcgl1txt1NB'>Persentage</td>
	  	<td class='normalfntRite'><font  style='font-size: 12px;' ><?php echo round(($OHC/$COST)*100,$dpl);?>%</font></td>
	 	<td class='normalfntRite'><font  style='font-size: 12px;' ><?php echo round(($WC/$COST)*100,$dpl);?>%</font></td>
	  	<td class='normalfntRite' style="display:none"><?php echo round(($TC/$TCCPDz)*100,$dpl);?>%</td>
	 	<td class='normalfntRite'><font  style='font-size: 12px;' ><?php echo round(($totCost/$COST)*100,$dpl);?>%</font></td>
	  	<td class='normalfntRite'><font  style='font-size: 12px;' ><?php echo round(($COST/$COST)*100,$dpl);?>%</font></td>
	  </tr>
</table>

<table width="800" border='0' align='center' CELLPADDING=3 CELLSPACING=1>
	<tr>
	 	<td class='bcgl1txt1NB' align="left" width="50%" >&nbsp;</td>
	 	<td class='normalfntRite' align="right" width="50%"> 
			<table width="100%" border='0' align='center' CELLPADDING=3 CELLSPACING=2 style="border:solid #000000 1px;" rules="rows">
				<tr><td class='bcgl1txt1NB' style="width:300px;">Cost per Doz 10% </td><td class='normalfntRite' style="width:100px;"><b><font  style='font-size: 11px;' ><?php $TCCPDz=$CPDzOH+$CPDzWC+$CPDzTC+$CPDzTCost;
		echo number_format(($TCCPDz/100)*110,2); $tintPrice=getTintPrice($rowHeader['intStyleId'],$po_location);?></font></b></td></tr>
				<tr>
					<td class='bcgl1txt1NB' style="width:300px;">% of Chemical Cost Per Wash Price</td>
					<td class='normalfntRite' style="width:100px;"><font  style='font-size: 11px;' ><?php $prOf=getPriceOffered($rowHeader['intStyleId']);
					//echo number_format(round((($CPDzTCost+$tintPrice)*100)/$prOf,3),2) ; 
					$priceOfferd = getPriceOffered($rowHeader['intStyleId']);
					echo number_format(((round($CPDzTCost,2)/($priceOfferd+$tintPrice))*100),2);?></font>%</td>
				</tr>
                
			</table>
		</td>
	</tr>
	  <tr>
      	<td class='normalfnt' width="50%">&nbsp;</td>
      	<td class='normalfnt' width="50%" align="right" >
		<table width="100%" border='0' align='center' CELLPADDING=1 CELLSPACING=1 style="border:solid #000000 1px;" rules="rows">
          <tr>
            <td class='bcgl1txt1NB' style="width:300px;">Price Offered</td>
            <td class='normalfntRite' style="width:100px;"><strong><font  style='font-size: 11px;' ><?php echo number_format(getPriceOffered($rowHeader['intStyleId']),2); //echo number_format((($TCCPDz*10)/(100+$TCCPDz)),2);?></font></strong></td>
          </tr>
          <?php 
		  if($tintPrice > 0){
		  ?>
          <tr>
            <td class='bcgl1txt1NB' style="width:300px;">Price Offered+Tint</td>
            <td class='normalfntRite' style="width:100px;"><strong><font  style='font-size: 11px;' ><?php echo number_format(getPriceOffered($rowHeader['intStyleId'])+$tintPrice,2); //echo number_format((($TCCPDz*10)/(100+$TCCPDz)),2);?></font></strong></td>
          </tr>
          <?php }?>
          <tr>
            <td class='bcgl1txt1NB' >Dry Process Description</td> <!--style="width:300px;border-bottom:solid #CCC 2px;border-top:solid #CCC 2px;"-->
            <td class='bcgl1txt1NB' >Dozen Price</td><!--style="width:100px;border-bottom:solid #CCC 2px;border-top:solid #CCC 2px;text-align:right;"-->
          </tr>
         
          <?php 
		  if($po_location=='outside'){
		  $sql_loadDryPrc="SELECT dp.strDescription,wp.dblWashPrice 
							FROM was_dryprocess dp 
							INNER JOIN was_washpricedetails AS wp ON wp.intDryProssId=dp.intSerialNo 
							WHERE  dp.intStatus=1 AND wp.intStyleId='".$rowHeader['intStyleId']."';" ;
		  }
		  else
		  {
			  $sql_loadDryPrc="SELECT dp.strDescription,wp.dblWashPrice 
							FROM was_dryprocess dp 
							INNER JOIN was_washpricedetails AS wp ON wp.intDryProssId=dp.intSerialNo 
							WHERE  dp.intStatus=1 AND wp.intStyleId='".$rowHeader['intStyleId']."';" ;
		  
		  }
				
		  $resDryPrc=$db->RunQuery($sql_loadDryPrc);
		  while($rowDrPrc=mysql_fetch_array($resDryPrc))
		  {
		  ?>
          <tr>
            <td class='normalfnt' style="width:300px; font-size: 11px;"><?php echo $rowDrPrc['strDescription'];?></td>
            <td class='normalfntRite' style="width:100px;font-size: 11px;"><?php echo number_format($rowDrPrc['dblWashPrice'],2);?></td>
          </tr>
          <?php }?>
        </table>
        </td>
    </tr>
</table>
<br /><br /><br />
<table width="800" border='0' align='center' CELLPADDING=1 CELLSPACING=1>
	<tr>
	 	<td class='normalfntMid' align="center" style="width:120px;">&nbsp;</td>
	 	<td class='normalfntMid' align="center" style="width:120px;">&nbsp;</td>
        <td class='normalfntMid' align="center" style="width:120px;">&nbsp;</td>
	</tr>
	<tr>
	 	<td class='normalfntMid' align="center" style="width:120px;">...............................................................</td>
	 	<td class='normalfntMid' align="center" style="width:120px;">...............................................................</td>
        <td class='normalfntMid' align="center" style="width:120px;">...............................................................</td>
	</tr>
    <tr>
    	<td class='normalfntMid' width="33.33%">Prepared By </td>
        <td class='normalfntMid' width="33.33%" >Approved by<br />Washing Plant Manager</td>
        <td class='normalfntMid' width="33.33%">Approved by<br />Head of Washing </td>
	</tr>
	<tr>
	 	<td class='normalfntMid' width="33.33%" ><?php echo date("Y-m-d");?></td>
	 	<td class='normalfntMid' width="33.33%">&nbsp;</td>
        <td class='normalfntMid' width="33.33%">&nbsp;</td>
	</tr>
</table>
<?php
function getPriceOffered($po){
	global $db;
	$sql="SELECT wp.dblIncome from was_washpriceheader wp WHERE wp.intStyleId='$po';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_assoc($res);
	return $row['dblIncome'];
}

function getTintPrice($po,$po_location){
	global $db;
	if($po_location=='outside'){
		  $sql_loadDryPrc="SELECT COALESCE(wp.dblWashPrice,0) AS WashPrice 
							FROM was_dryprocess dp 
							INNER JOIN was_washpricedetails AS wp ON wp.intDryProssId=dp.intSerialNo 
							WHERE  dp.intStatus=1 AND wp.intStyleId='".$po."' AND dp.strDryProCode='TINT';" ;
		  }
		  else
		  {
			  $sql_loadDryPrc="SELECT COALESCE(wp.dblWashPrice,0) AS WashPrice
							FROM was_dryprocess dp 
							INNER JOIN was_washpricedetails AS wp ON wp.intDryProssId=dp.intSerialNo 
							WHERE  dp.intStatus=1 AND wp.intStyleId='".$po."' AND dp.strDryProCode='TINT';" ;
		  
		  }
		 // echo $sql_loadDryPrc;
		$res=$db->RunQuery($sql_loadDryPrc);
		$row=mysql_fetch_assoc($res);
		return $row['WashPrice'];
}
?>
</body>
</html>
