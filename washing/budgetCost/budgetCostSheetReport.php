<?php
 session_start();
  $backwardseperator = "../../";
include "../../Connector.php";
$sNO = $_GET['q'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Budgeted Cost Sheet Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>
</head>
<body>
<?php
	
    $sql_header="	SELECT 
					wb.strFabricId,
					wb.strFabricDescription,
					wb.strFabricContent,
					wb.strStyleName,
					wb.intGarmentId,
					wb.intWashType,
					wb.strColor,
					wb.dblQty,
					wb.dblWeight,
					mt.strMachineCode,
					wb.strDivision,
					wb.dblQty,
					wb.intRevisionNo,
					(select strTitle from suppliers S where S.strSupplierID=wb.intMillId)as strTitle,
					wg.strCatName,
					wb.dblHTime,
					mt.dblOHCostMin,
					mt.dblTaggingCost,
					mt.dblUnitPrice,
					wb.intStatus,
					wb.intCompanyId
					FROM 
					was_budgetcostheader wb					
					INNER JOIN was_machinetype AS mt ON mt.intMachineId = wb.intMachineId
					INNER JOIN orderdetails AS OD ON OD.intMainFabricStatus=1 						
					INNER JOIN productcategory AS wg ON wg.intCatId=wb.intGarmentId
					WHERE 
					intSerialNo =$sNO;"; 

	$resHeader=$db->RunQuery($sql_header);
	$rowHeader=mysql_fetch_array($resHeader);
	$report_companyId = $rowHeader['intCompanyId'];
	?>
    <table width="800" align='center' CELLPADDING=3 CELLSPACING=1 >
	  <tr>
	    <td colspan="4"><?php include '../../reportHeader.php';?></td>
  </tr>
	</table>
	<table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border='0' align='center' cellpadding="3" cellspacing="1" >
    <!--  <tr>
        <td colspan="3"><?php include '../../reportHeader.php';?></td>
      </tr>-->
      <tr>
        <td colspan="3" class="head2">BUDGET COST SHEET</td>
      </tr>
      <tr>
        <?php if($rowHeader['intStatus']==0){
	  			$status = "NOT CONFIRM";
			}else{
				$status = "CONFIRM";
			}
	  		?>
        <td width="516" align="left" class='normalfnt' style="width:400px;color:#F30;"><?php echo $status;?></td>
        <td width="146" align="left" class='bcgl1txt1NB' style="width:100px;">Cost No :</td>
        <td width="116" align="left" class='normalfnt' style="width:100px;"><span class="normalfnt" style="width:100px;"><?php echo $sNO;?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="all" bordercolor="#000000">
      <tr height="20">
	 	<td width="19%"  align="left"  class='bcgl1txt1NB' style="font-size:12px;">Style Name </td>
	  	<td width="81%" align="left" class='bcgl1txt1NB' style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strStyleName']; ?></td>
	  </tr>
      <tr height="20">
	 	<td class='bcgl1txt1NB' align="left" style="font-size:12px;">Fabric Name </td>
	  	<td class='bcgl1txt1NB' align="left" style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strFabricId']; ?></td>
	  </tr>		
	  <tr height="20">
	 	<td class='bcgl1txt1NB' align="left" style="font-size:12px;">Fabric Description</td>
	  	<td class='normalfnt' align="left" style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strFabricDescription'];?></td>
	  </tr>
      <tr height="20">
	 	<td class='bcgl1txt1NB' align="left" style="font-size:12px;">Fabric Content</td>
	  	<td class='normalfnt' align="left" style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strFabricContent'];?></td>
	  </tr>	
</table></td>
  </tr>
  
  <tr>
    <td>
	<table width="100%"  border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="all" bordercolor="#000000">
      <tr>
        <td width="19%" align="left" class='bcgl1txt1NB' style="font-size:12px;">Wash Type</td>
        <td width="257" align="left" class='normalfnt' style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['intWashType']; ?></td>
        <td width="137" align="left" class='bcgl1txt1NB' style="font-size:12px;"">Mill</td>
        <td width="255" align="left" class='normalfnt' style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strTitle']; ?></td>
      </tr>
      <tr>
        <td width="19%" class='bcgl1txt1NB' align="left" style=";font-size:12px;" >Weight</td>
        <td class='normalfnt' align="left" style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['dblWeight']; ?></td>
        <td class='bcgl1txt1NB' align="left" style="font-size:12px;">Division</td>
        <td class='normalfnt' align="left" style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strDivision']; ?></td>
      </tr>
      <tr>
        <td width="19%" class='bcgl1txt1NB' align="left" style="font-size:12px;">Garment</td>
        <td class='normalfnt' align="left" style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strCatName']; ?></td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;font-size:12px;">Color</td>
        <td class='bcgl1txt1NB' align="left" style='font-size: 12px;'>&nbsp;<?php echo $rowHeader['strColor']; ?></td>
      </tr>
    </table></td>
  </tr>
  <td height="5">&nbsp;</td>
  <tr>
    <td><table width="100%" border='1' align='center' CELLPADDING=1 CELLSPACING=1 bordercolor="#000000" rules="all">
      <tr>
        <td class='normalfntMidSML' align="left" style="width:80px;"><b>Running Time</b></td>
        <td class='normalfntMidSML' align="left" style="width:80px;"><b>Handling Time</b></td>
        <td class='normalfntMidSML' align="left" style="width:70px;"><b>Total Time</b></td>
        <td class='normalfntMidSML' align="left" style="width:120px;"><b>OH Cost Per minute</b></td>
        <td class='normalfntMidSML' align="left" style="width:80px;"><b>OH Cost</b></td>
        <td class='normalfntMidSML' align="left" style="width:70px;display:none;"><b>TagCostDz</b></td>
        <td class='normalfntMidSML' align="left" style="width:80px;"><b>Water (L)</b></td>
        <td class='normalfntMidSML' align="left" style="width:70px;"><b>Unit Price($)</b></td>
        <td class='normalfntMidSML' align="left" style="width:70px;"><b>Value</b></td>
      </tr>
      <?php
	  //
      $sql_RTime="SELECT SUM(dblTime) R_TIME,SUM(dblLiqour) LIQUOR FROM was_budgetcostdetails WHERE intSerialNo=$sNO;";
	  $resRT=$db->RunQuery($sql_RTime);
	  $rowRT=mysql_fetch_array($resRT);
	  ?>
      <tr>
        <td class='normalfntMid' align="left" style="width:70px;"><?php echo $rowRT['R_TIME'];?></td>
        <td class='normalfntMid' align="left" style="width:70px;"><?php echo $rowHeader['dblHTime'];?></td>
        <td class='normalfntMid' align="left" style="width:80px;"><?php echo ($rowRT['R_TIME']+$rowHeader['dblHTime']);?></td>
        <td class='normalfntMid' align="left" style="width:100px;"><?php echo $rowHeader['dblOHCostMin'];?></td>
        <td class='normalfntMid' align="left" style="width:80px;"><?php echo (($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']));?></td>
        <td class='normalfntMid' align="left" style="width:70px;display:none;"><?php echo $rowHeader['dblTaggingCost'];?></td>
        <td class='normalfntMid' align="left" style="width:100px;"><?php echo $rowRT['LIQUOR'];?></td>
        <td class='normalfntMid' align="left" style="width:70px;"><?php echo $rowHeader['dblUnitPrice'];?></td>
        <td class='normalfntMid' align="left" style="width:70px;"><?php echo ($rowRT['LIQUOR']*$rowHeader['dblUnitPrice']);?></td>
      </tr>
    </table></td>
  <tr>
    <td><table width="100%" border='1' align='center' cellpadding="0" cellspacing="0" rules="groups">
      <tr>
        <td height="15" class='normalfnt' align="left" style="width:120px;"><font  style='font-size: 9px;' ><b> Machine Code</font></td>
        <td class='normalfnt' align="left" ><font  style='font-size: 9px;' ><b> : <?php echo $rowHeader['strMachineCode'];?></font></td>
        <td class='normalfnt' align="left" style="width:120px;"><font  style='font-size: 9px;' ><b>NO. of PCS </font></td>
        <td class='normalfnt' align="left"><font  style='font-size: 9px;' ><b> : <font  style='font-size: 9px;' ><?php echo $rowHeader['dblQty'];?></font></font></td>
        <td class='normalfnt' align="left" style="width:120px;display:none;"><font  style='font-size: 9px;' ><b>Tag Cos</font></td>
        <td class='normalfnt' align="left"><font  style='font-size: 9px;' ><b></font></td>
        <td class='normalfnt' align="left" style="width:120px;"><font  style='font-size: 9px;' ><b>Revision No</font></td>
        <td class='normalfnt' align="left"><font  style='font-size: 9px;' ><b> : <?php echo $rowHeader['intRevisionNo'];?></font></td>
      </tr>
    </table></td>
  <tr>
    <td>&nbsp;</td>
  <tr>
    <td><table width="100%" border='1' align='center' CELLPADDING=1 CELLSPACING=1  bordercolor="#000000" rules="cols">
      <tr>
        <td  class='normalfntMid' width="26">&nbsp;</td>
        <td width="200"  class='normalfnt' ><b>PROCESS</b></td>
        <td width="248"  class='normalfnt' ><b>CHEMICAL </b></td>
        <td width="110"  class='normalfntMid'><b>UNIT PRICE</b></td>
        <td width="80"  class='normalfntMid'><b>QTY</b></td>
        <td width="70"  class='normalfntMid'><b>UNIT </b></td>
        <td width="72"  class='normalfntMid'><b>VALUE</b></td>
      </tr>
      <?php 
			  $sql_processes="SELECT 
			  				  wb.intProcessId,
							  wb.intRowOder,
							  wf.strProcessName
							  FROM 
							  was_budgetcostdetails wb
							  INNER JOIN was_washformula AS wf ON wf.intSerialNo=wb.intProcessId
							  WHERE 
							  wb.intSerialNo=$sNO;";
			  $resP=$db->RunQuery($sql_processes);
			  while($rowP=mysql_fetch_array($resP))
			  {
				$sql_chemicals="SELECT GMIL.strItemDescription, WBC.strUnit, WBC.dblQty, WBC.dblUnitPrice,WBC.intChemicalId 
								FROM was_budgetchemicals WBC 
								INNER JOIN genmatitemlist AS GMIL ON GMIL.intItemSerial=WBC.intChemicalId 
								WHERE WBC.intProcessId=".$rowP['intProcessId']." AND WBC.intRowOder=".$rowP['intRowOder']." AND WBC.intSerialNo=$sNO;";
								
				$pid=1;
				$resCh=$db->RunQuery($sql_chemicals);
				$nR=mysql_num_rows($resCh);
				if($nR > 0){
					while($rowCh=mysql_fetch_array($resCh))
					{?>
      <tr <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>>
        <td class='normalfntMid' valign="top" ><font  style='font-size: 12px;' > <?php if($pid==1){ echo $rowP['intRowOder'];} ?></font>&nbsp;</td>
        <td valign="top" ><font  style='font-size: 12px;' class='normalfnt'><?php if($pid==1){ echo $rowP['strProcessName'];}?></font></td>
        <td  class='normalfnt' ><font  style='font-size: 12px;' >&nbsp;<?php if($pid==1){?><br />&nbsp; <?php }
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
													echo substr($chmA,0,strlen($chmA)-1); //echo $rowCh['strItemDescription']; ?>
        </font></td>
         <td style="width:110px;" class='normalfntRite'><font  style='font-size: 12px;' >&nbsp;<?php if($pid==1){?><br />&nbsp; <?php } echo number_format($rowCh['dblUnitPrice'],2);?></font>&nbsp;</td>
         <td style="width:80px;" class='normalfntRite'><font  style='font-size: 12px;' >&nbsp;<?php if($pid==1){?><br />&nbsp; <?php } echo number_format($rowCh['dblQty'],6);?></font>&nbsp;</td>
         <td style="width:70px;text-align:center;" class='normalfntRite'><font  style='font-size: 12px;' >&nbsp;<?php if($pid==1){?><br />&nbsp;<?php } echo $rowCh['strUnit'];?></font></td>
         <td style="width:70px;" class='normalfntRite'><font  style='font-size: 12px;' >&nbsp;<?php if($pid==1){?><br />&nbsp; <?php } echo number_format($rowCh['dblUnitPrice']*$rowCh['dblQty'],2);
			$totCost += $rowCh['dblUnitPrice']*$rowCh['dblQty'];?> </font></td>
			</tr>
		<?php $pid++; 
		 } 
		}else{?>
      <tr <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>>
		<td class='normalfntMid' valign="top"><font  style='font-size: 12px;' ><?php echo $rowP['intRowOder']; ?></font>&nbsp;</td>
		<td valign="top" tyle="width:150px;" class='normalfnt'><font  style='font-size: 12px;' ><?php echo $rowP['strProcessName'];?></font></td>
		<td class='normalfnt' align="left"><span class="normalfnt" style="width:120px;"><font  style='font-size: 10px;' >&nbsp;<?php if($pid==1){?><br />&nbsp; <?php }
         $val=$rowCh['strItemDescription'];echo $rowCh['strItemDescription'];?>
        </font></span>
          <span class="normalfnt" style="width:100px;"><font  style='font-size: 12px;' >NO chemical</font></span>
        <td style="width:100px;" class='normalfnt' colspan="1">&nbsp;</td>
        <td style="width:80px;" class='normalfntRite'><font  style='font-size: 12px;' >&nbsp;<br />&nbsp;</font>&nbsp;</td>
         <td style="width:70px;text-align:center;" class='normalfntRite'><font  style='font-size: 12px;' >&nbsp;<br />&nbsp;</font></td>
         <td style="width:70px;" class='normalfntRite'><font  style='font-size: 12px;' >&nbsp;<br />&nbsp;</font></td>
      </tr>
	<?php }
		}?>
    </table></td>
  <tr>
    <td><table width="100%" border='0' align='center' cellpadding="3" cellspacing="1">
      <tr>
        <td class='normalfnt' align="left"  colspan="6"><b> Total Chemical Cost</b></td>
        <td  class='normalfntRite' style="width:90px;" ><font  style='font-size: 12px;' ><b><?php echo number_format($totCost,2); ?></b></font></td>
      </tr>
    </table></td>
  <tr>
    <td><table width="100%" border='1' align='center' CELLPADDING=1 CELLSPACING=1 rules="all" bordercolor="#000000">
      <tr>
        <td class='normalfnt' align="left" style="width:200px;"><font  style='font-size: 9px;' ><b> </font></td>
        <td class='normalfntMid' align="left" style="width:150px;text-align:center;" ><strong>OverHead Cost</strong></td>
        <td class='normalfntMid' align="left" style="width:120px;text-align:center;"><strong>Water Cost</strong></td>
        <td class='normalfntMid' align="left" style="display:none;"><strong>Tagging Cost</strong></td>
        <td class='normalfntMid' align="left" style="width:120px;text-align:center;"><strong>Chemical Cost</strong></td>
        <td class='normalfntMid' align="left" style="text-align:center;"><strong>Total Cost</strong></td>
      </tr>
      <tr>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Cost</td>
        <td class='normalfntRite' style='font-size: 12px;'><?php echo number_format($OHC=round(($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']),2),2);?></td>
        <td class='normalfntRite'  style="width:150px;font-size: 12px;"><span class="normalfntRite" style="width:150px;font-size: 12px;">
          <?php number_format($WC=($rowRT['LIQUOR']*$rowHeader['dblUnitPrice']),2);
		echo round($WC,2);
		?>
        </span></td>
        <td class='normalfntRite' style="display:none;"><?php echo number_format($TC=($rowHeader['dblTaggingCost']/12)*$rowHeader['dblQty'],2);?></td>
        <td class='normalfntRite' style="width:150px;font-size: 12px;"><?php echo number_format(round($totCost,2),2);?></td>
        <td class='normalfntRite' style="font-size: 12px;">
          <?php 
		$COST=$OHC+$WC+$TC+$totCost;
		echo number_format(round($COST,2),2);  ?>
       </td>
      </tr>
      <tr>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Cost per Doz</td>
        <td class='normalfntRite' style='font-size: 12px;' >
          <?php
		$CPDzOH=((($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']))/$rowHeader['dblQty'])*12;
		 echo number_format(round($CPDzOH,2),2);
		?></td>
        <td class='normalfntRite' align="left" style="width:120px;font-size: 12px;">
          <?php 
		$CPDzWC=((($rowRT['LIQUOR']*$rowHeader['dblUnitPrice'])/$rowHeader['dblQty'])*12);
		echo number_format(round($CPDzWC,2),2);
		?></td>
        <td class='normalfntRite' style="display:none;"><?php echo number_format($CPDzTC =$rowHeader['dblTaggingCost'],2);?></td>
        <td class='normalfntRite'  style="width:120px;font-size: 12px;">
          <?php 
		$CPDzTCost= ($totCost/$rowHeader['dblQty'])*12;
		echo number_format(round($CPDzTCost,2),2);
		?></td>
        <td class='normalfntRite' style="font-size: 12px;">
          <?php $TCCPDz=$CPDzOH+$CPDzWC+$CPDzTC+$CPDzTCost;
		echo number_format(round($TCCPDz,2),2);
		?></td>
      </tr>
      <tr align="right">
        <td class='bcgl1txt1NB' align="left"  colspan="3"><div align="left" style="width:230px;float:left;">% of Chemical Cost Per Required Price :</div> <!--</td>
        <td class='normalfnt' align="left" >--><div align="right" style="width:100px;float:right;"><font  style='font-size: 12px;' >
		<?php $ccprp=($CPDzTCost*100)/((($TCCPDz)/100)*110);
		
		echo number_format(round($ccprp,2),2); ?></font>%</div></td>
        <td class='normalfnt' align="left" style="display:none;">&nbsp;</td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;border-right:none" colspan="1" >Required Price</td>
        <td class='normalfntRite' style="border-left:none">
        <font  style='font-size: 12px;' ><b>
          <?php  echo number_format(round((((($TCCPDz)/100)*110)),2),2);?>
        </b></font>
        </td>
      </tr>
    </table></td>
  <tr>
    <td>&nbsp;</td>
  <tr>
    <td>&nbsp;</td>
  <tr>
    <td><table width="800" border='0' align='center' cellpadding="3" cellspacing="1">
      <tr>
        <td class='normalfntMid' align="center" style="width:120px;" colspan="2"><font  style='font-size: 9px;'><b>...............................................................</font></td>
        <td class='normalfntMid' align="center" style="width:120px;" colspan="2"><font  style='font-size: 9px;' ><b>..............................................................</font></td>
        <td class='normalfntMid' align="center" style="width:120px;" colspan="2"><font  style='font-size: 9px;' ><b>..............................................................</font></td>
      </tr>
      <tr>
        <td class='normalfntMid'  style="width:300px;" colspan="2"><font  style='font-size: 9px;'><b>Prepared By</font></td>
        <td class='normalfntMid'  style="width:250px;" colspan="2"><font  style='font-size: 9px;' ><b>Approved by <br /> Development Manager</font></td>
        <td class='normalfntMid'  style="width:250px;" colspan="2"><font  style='font-size: 9px;' ><b>Approved by<br />
          Head of Washing </font></td>
      </tr>
    </table></td>
</table>

    	
    </td>
    </tr>
    </table>
    <br />
</body>
</html>
