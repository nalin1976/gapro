<?php
 session_start();
  $backwardseperator = "../../../";
include "../../../Connector.php";
$sNO = $_GET['q'];
$report_companyId = $_SESSION["UserID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Budgeted - Cost Sheet - Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
					m.strItemDescription,
					m.strItemCode,
					O.strStyle,
					O.intStyleId,
					wb.intGarmentId,
					wt.strWasType,
					wb.strColor,
					wb.dblQty,
					wb.dblWeight,
					mt.strMachineCode,
					bd.strDivision,
					wb.dblQty,
					wb.intRevisionNo,
					sp.strTitle,
					wg.strGarmentName,
					wb.dblHTime,
					mt.dblOHCostMin,
					mt.dblTaggingCost,
					mt.dblUnitPrice,
					wb.intStatus
					FROM 
					was_budgetcostheader wb
					INNER JOIN matitemlist AS m ON m.intItemSerial= wb.intMatDetailId
					INNER JOIN orders AS O ON  O.intStyleId = wb.intStyleId 
					INNER JOIN was_machinetype AS mt ON mt.intMachineId =wb.intMachineId
					INNER JOIN was_washtype AS wt ON wt.intWasID = wb.intWashType
					INNER JOIN buyerdivisions AS bd ON bd.intDivisionId=wb.intDivisionId
					INNER JOIN orderdetails AS OD ON OD.intMainFabricStatus=1 
					INNER JOIN suppliers AS sp ON sp.strSupplierID=OD.intMillID
					INNER JOIN was_garmenttype AS wg ON wg.intGamtID=wb.intGarmentId
					WHERE 
					intSerialNo =$sNO;";

					//echo $sql_header;
	$resHeader=$db->RunQuery($sql_header);
	$rowHeader=mysql_fetch_array($resHeader);
	$fabric=$rowHeader['strItemDescription'];
	$fabArr=split('-',$fabric);
	$c=count($fabArr);
	$fabDsc="";
	for($a=0;$a<$c-1;$a++)
	{
		$fabDsc.=$fabArr[$a]."-";
	}
	
	?>
	<table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border='0' align='center' cellpadding="3" cellspacing="1" >
      <tr>
        <td colspan="3"><?php include '../../../reportHeader.php';?></td>
      </tr>
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
    <td><table width="100%" border='1' align='center' cellpadding="0" cellspacing="0" rules="groups">
      <tr>
	 	<td  class='bcgl1txt1NB'  align="left" style="width:150px">Style</td>
	  	<td class='normalfnt' align="left">:<?php echo $rowHeader['strStyle']; ?></td>
	  </tr>
      <tr>
	 	<td class='bcgl1txt1NB' align="left" style="width:150px;">Fabric ID</td>
	  	<td class='normalfnt' align="left">:<?php echo $rowHeader['strItemCode']; ?></td>
	  </tr>		
	  <tr>
	 	<td class='bcgl1txt1NB' align="left" style="width:150px;">Fab Discription</td>
	  	<td class='normalfnt' align="left">:<?php echo $fabDsc;?></td>
	  </tr>
      <tr>
	 	<td class='bcgl1txt1NB' align="left" style="width:150px;">Fab Content</td>
	  	<td class='normalfnt' align="left">:<?php echo $fabArr[$c-1]?></td>
	  </tr>	
</table></td>
  </tr>
  
  <tr>
    <td>
	<table width="100%" border='1' align='center' cellpadding="0" cellspacing="0" rules="groups">
      <tr>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Wash Type</td>
        <td class='normalfnt' align="left" style="width:200px;">:<?php echo $rowHeader['strWasType']; ?></td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Mill</td>
        <td class='normalfnt' align="left" style="width:200px;">:<?php echo $rowHeader['strTitle']; ?></td>
      </tr>
      <tr>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Weight</td>
        <td class='normalfnt' align="left">:<?php echo $rowHeader['dblWeight']; ?></td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Division</td>
        <td class='normalfnt' align="left">:<?php echo $rowHeader['strDivision']; ?></td>
      </tr>
      <tr>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Garment</td>
        <td class='normalfnt' align="left">:<?php echo $rowHeader['strGarmentName']; ?></td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Color</td>
        <td class='normalfnt' align="left">:<?php echo $rowHeader['strColor']; ?></td>
      </tr>
    </table></td>
  </tr>
  <td height="5">&nbsp;</td>
  <tr>
    <td><table width="100%" border='1' align='center' cellpadding="0" cellspacing="0" rules="all">
      <tr>
        <td class='normalfntMidSML' align="left" style="width:80px;"><b>Running Time</b></td>
        <td class='normalfntMidSML' align="left" style="width:80px;"><b>Handling Time</b></td>
        <td class='normalfntMidSML' align="left" style="width:70px;"><b>Total Time</b></td>
        <td class='normalfntMidSML' align="left" style="width:120px;"><b>OH Cost Per minute</b></td>
        <td class='normalfntMidSML' align="left" style="width:80px;"><b>OH Cost</b></td>
        <td class='normalfntMidSML' align="left" style="width:70px;"><b>TagCostDz</b></td>
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
        <td class='normalfntMid' align="left" style="width:70px;"><?php echo $rowHeader['dblTaggingCost'];?></td>
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
        <td class='normalfnt' align="left"><font  style='font-size: 9px;' ><b> : <?php echo $rowHeader['dblQty'];?></font></td>
        <td class='normalfnt' align="left" style="width:120px;"><font  style='font-size: 9px;' ><b>Tag Cos</font></td>
        <td class='normalfnt' align="left"><font  style='font-size: 9px;' ><b>: </font></td>
        <td class='normalfnt' align="left" style="width:120px;"><font  style='font-size: 9px;' ><b>Revision No</font></td>
        <td class='normalfnt' align="left"><font  style='font-size: 9px;' ><b> : <?php echo $rowHeader['intRevisionNo'];?></font></td>
      </tr>
    </table></td>
  <tr>
    <td>&nbsp;</td>
  <tr>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0" rules="rows">
      <tr>
        <td class='normalfntMid' align="left" style="width:50px;"><b>NO</b></td>
        <td class='normalfnt' align="left" style="width:120px;"><b>PROCESS</b></td>
        <td class='normalfnt' align="left" style="width:130px;"><b>CHEMICAL </b></td>
        <td class='normalfntMid' align="center" style="width:120px;"><b>UNIT PRICE</b></td>
        <td class='normalfntMid' align="center" style="width:80px;"><b>QTY</b></td>
        <td class='normalfntMid' align="center" style="width:80px;"><b>UNIT </b></td>
        <td class='normalfntMid' align="center" style="width:80px;" ><b>VALUE</b></td>
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
	  		?>
      <tr style="border-bottom:solid #999 1px;">
        <td class='normalfntMid' align="right" valign="top"><font  style='font-size: 10px;' ><?php echo $rowP['intRowOder']; ?></font></td>
        <td valign="top" tyle="width:150px;"><font  style='font-size: 10px;' ><?php echo $rowP['strProcessName'];?></font></td>
        <td class='normalfnt' align="left" colspan="5"><table border="0" width="100%">
            <?php 
				$sql_chemicals="SELECT wcl.strItemDescription, wcl.strUnit, wbc.dblQty, wbc.dblUnitPrice,wbc.intChemicalId 
								FROM was_chemmatitemlist wcl 
								INNER JOIN was_budgetchemicals AS wbc ON wbc.intChemicalId=wcl.intSerialNo 
								WHERE wcl.intStatus=1 AND wbc.intProcessId=".$rowP['intProcessId']." AND wbc.intRowOder=".$rowP['intRowOder']." AND wbc.intSerialNo=$sNO;";
				
				$resCh=$db->RunQuery($sql_chemicals);
				$nR=mysql_num_rows($resCh);
				if($nR > 0){
					while($rowCh=mysql_fetch_array($resCh))
					{
						?>
            <tr>
              <td style="width:120px;" class='normalfnt' ><font  style='font-size: 10px;' >
                <?php 
							$val=$rowCh['strItemDescription'];
								echo $rowCh['strItemDescription'];
							?>
              </font></td>
              <td style="width:110px;" class='normalfntMid' align="center" ><font  style='font-size: 10px;' ><?php echo $rowCh['dblUnitPrice'];?></font></td>
              <td style="width:80px;" class='normalfntMid' align="center" ><font  style='font-size: 10px;' ><?php echo $rowCh['dblQty'];?></font></td>
              <td style="width:70px;" class='normalfntMid' align="center"><font  style='font-size: 10px;' ><?php echo $rowCh['strUnit'];?></font></td>
              <td style="width:70px;" class='normalfntMid' align="center"><font  style='font-size: 10px;' > <?php echo $rowCh['dblUnitPrice']*$rowCh['dblQty'];
							$totCost += $rowCh['dblUnitPrice']*$rowCh['dblQty'];
							?> </font></td>
            </tr>
            <?php }
				}
				else
				{?>
            <tr>
              <td style="width:100px;" class='normalfnt' colspan="5" ><font  style='font-size: 10px;' >NO chemical</font></td>
            </tr>
            <?php }
				?>
        </table></td>
		
      </tr>
      <?php }?>
    </table></td>
  <tr>
    <td><table width="100%" border='0' align='center' cellpadding="3" cellspacing="1">
      <tr>
        <td class='normalfnt' align="left"  colspan="6"><font  style='font-size: 9px;'><b> Total Chemical Cost</b></font></td>
        <td align="center" class='normalfntMid' style="width:90px;" ><font  style='font-size: 9px;' ><b><?php echo $totCost; ?></b></font></td>
      </tr>
    </table></td>
  <tr>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0" rules="all">
      <tr>
        <td class='normalfnt' align="left" style="width:120px;"><font  style='font-size: 9px;' ><b> </font></td>
        <td class='bcgl1txt1NB' align="left" >OverHead Cost</td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Water Cost</td>
        <td class='bcgl1txt1NB' align="left">Tagging Cost</td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Chemical Cost</td>
        <td class='bcgl1txt1NB' align="left">Total Cost</td>
      </tr>
      <tr>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Cost</td>
        <td class='normalfnt' align="left" ><?php echo $OHC=round(($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']),2);?></td>
        <td class='normalfnt' align="left" style="width:120px;">
          <?php $WC=($rowRT['LIQUOR']*$rowHeader['dblUnitPrice']);
		echo round($WC,2);
		?></td>
        <td class='normalfnt' align="left"><?php echo $TC=($rowHeader['dblTaggingCost']/12)*$rowHeader['dblQty'];?></td>
        <td class='normalfnt' align="left" style="width:120px;"><?php echo round($totCost,2);?></td>
        <td class='normalfnt' align="left">
          <?php 
		$COST=$OHC+$WC+$TC+$totCost;
		echo round($COST,2);  ?>
       </td>
      </tr>
      <tr>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Cost per Doz</td>
        <td class='normalfnt' align="left" >
          <?php
		$CPDzOH=((($rowRT['R_TIME']+$rowHeader['dblHTime'])*($rowHeader['dblOHCostMin']))/$rowHeader['dblQty'])*12;
		 echo round($CPDzOH,2);
		?></td>
        <td class='normalfnt' align="left" style="width:120px;">
          <?php 
		$CPDzWC=((($rowRT['LIQUOR']*$rowHeader['dblUnitPrice'])/$rowHeader['dblQty'])*12);
		echo round($CPDzWC,2);
		?></td>
        <td class='normalfnt' align="left"><?php echo $CPDzTC =$rowHeader['dblTaggingCost'];?></td>
        <td class='normalfnt' align="left" style="width:120px;">
          <?php 
		$CPDzTCost= ($totCost/200)*12;
		echo round($CPDzTCost,2);
		?></td>
        <td class='normalfnt' align="left">
          <?php $TCCPDz=$CPDzOH+$CPDzWC+$CPDzTC+$CPDzTCost;
		echo round($TCCPDz,2);
		?></td>
      </tr>
      <tr align="right">
        <td class='normalfnt' align="left" style="width:120px;">&nbsp;</td>
        <td class='normalfnt' align="left">&nbsp;</td>
        <td class='normalfnt' align="left" style="width:120px;">&nbsp;</td>
        <td class='normalfnt' align="left">&nbsp;</td>
        <td class='bcgl1txt1NB' align="left" style="width:120px;">Required Price</td>
        <td class='normalfnt' align="left"><font  style='font-size: 9px;' ><b>
          <?php  echo round((($TCCPDz*10)/(100+$TCCPDz)),2);?>
        </b></font></td>
      </tr>
    </table></td>
  <tr>
    <td>&nbsp;</td>
  <tr>
    <td>&nbsp;</td>
  <tr>
    <td><table width="800" border='0' align='center' cellpadding="3" cellspacing="1">
      <tr>
        <td class='normalfnt' align="center" style="width:120px;" colspan="6"><font  style='font-size: 9px;'><b>..............................................</font></td>
        <td class='normalfnt' align="center" style="width:120px;"><font  style='font-size: 9px;' ><b>...............................................................</font></td>
        <td class='normalfnt' align="center" style="width:120px;"><font  style='font-size: 9px;' ><b>................................................................</font></td>
      </tr>
      <tr>
        <td class='normalfnt' align="center" style="width:300px;" colspan="6"><font  style='font-size: 9px;'><b>Prepared By</font></td>
        <td class='normalfnt' align="center" style="width:250px;"><font  style='font-size: 9px;' ><b>Approved by Development Manager</font></td>
        <td class='normalfnt' align="center" style="width:250px;"><font  style='font-size: 9px;' ><b>Approved by washing Plant Manager</font></td>
      </tr>
    </table></td>
</table>

    	
    </td>
    </tr>
    </table>
    <br />
</body>
</html>
