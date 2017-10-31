<?php
 session_start();
 $backwardseperator = "../../";
include('../../Connector.php');
//$report_companyId = $_SESSION["FactoryID"];
$sNO = $_GET['q'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Budgeted - Wash Formula - Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
table
{
	border-spacing:0px;
}
</style>
</head>
<body>

	<?php
	
    /* $sql_header="	SELECT
					wb.strFabricId,
					wb.strFabricDescription,
					wb.strFabricContent,
					wb.strStyleName,
					wb.intGarmentId,
					wt.strWasType,
					wb.strColor,
					wb.dblQty,
					wb.dblWeight,
					wb.dtmDate,
					wb.intStatus,
					was_machinetype.strMachineCode
					FROM
					was_budgetcostheader AS wb					
					Inner Join was_washtype AS wt ON wt.intWasID = wb.intWashType
					Inner Join was_machine ON wb.intMachineId = was_machine.intMachineId
					Inner Join was_machinetype ON was_machine.intMachineType = was_machinetype.intMachineId
					WHERE intSerialNo =$sNO;";*/
					
	$sql_header="SELECT
				wb.strFabricId,
				wb.strFabricDescription,
				wb.strFabricContent,
				wb.strStyleName,
				wb.intGarmentId,
				wb.strColor,
				wb.dblQty,
				wb.dblWeight,
				wb.dtmDate,
				wb.intStatus,
				was_machinetype.strMachineCode,
				wb.intWashType,
				wb.dblHTime,
				was_machinetype.strMachineType,
				wb.intCompanyId
				FROM
				was_budgetcostheader AS wb
				INNER JOIN was_machinetype ON wb.intMachineId = was_machinetype.intMachineId
					WHERE intSerialNo =$sNO;";				
				//echo	$sql_header;
	$resHeader=$db->RunQuery($sql_header);
	$rowHeader=mysql_fetch_array($resHeader);
	$report_companyId=$rowHeader['intCompanyId'];
	?>
<table width="800" align='center' CELLPADDING=3 CELLSPACING=1 >
	  <tr>
	    <td colspan="4"><?php include '../../reportHeader.php';?></td>
  </tr>
	  <tr>
	    <td colspan="4" class="head2">Budget Washing Formula</td>
  </tr>
	  <tr>	<?php if($rowHeader['intStatus']==0){
	  			$status = "NOT CONFIRM"; 
				echo "<div style=\"position:absolute;top:250px;left:300px;\">
            	<img src=\"../../images/pending.png\">
           		 </div>";
			}else{
				$status = "CONFIRM";
			}
	  		?>
           
 			<td class='normalfnt' align="left" style="width:400px;color:#F30;display:none;"><?php echo $status;?></td>			
            <td>&nbsp;</td>
            <td class='normalfnt' align="left" style="width:100px;"><b>Machine Code :</b>            </td>
            <td class='normalfnt' align="left" style="width:100px;"><?php echo $rowHeader['strMachineType']; ?></td>
 	  </tr>
</table>

    
<table width="800"  align='center' border='0'>
      <tr>
        <td colspan="3" align="left" class='bcgl1txt1NB'><table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all">
          <tr height="20">
            <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;"><b>Date</b></td>
<!--            <td width="1%"></td>-->
            <td width="32%" style="font-size:12px;"><span class="normalfnt">&nbsp;<?php echo  substr($rowHeader['dtmDate'],0,10); ?></span></td>
            <td class='bcgl1txt1NB' align="left" width="16%" style="font-size:12px;">Style Name</td>
<!--            <td width="1%"></td>-->
            <td width="35%" class="bcgl1txt1NB" style="font-size:12px;">&nbsp;<?php echo $rowHeader['strStyleName']; ?></td>
          </tr>
          <tr  height="20">
            <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Fabric Name </td>
            <!--<td>:</td>-->
            <td class="bcgl1txt1NB" style="font-size:12px;">&nbsp;<?php echo $rowHeader['strFabricId']; ?></td>
            <td class='bcgl1txt1NB' align="left" width="16%" style="font-size:12px;">Fabric <span class="bcgl1txt1NB" style="font-size:12px;">Description</span></td>
            <!--<td>:</td>-->
            <td class="normalfnt" style="font-size:12px;">&nbsp;<?php echo $rowHeader['strFabricDescription']; ?></td>
          </tr>
          <tr  height="20">
            <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Color</td>
            <!--<td>:</td>-->
            <td class="bcgl1txt1NB" style="font-size:12px;">&nbsp;<?php echo $rowHeader['strColor']; ?></td>
            <td class='bcgl1txt1NB' align="left" width="16%" style="font-size:12px;">Fabric <span class="bcgl1txt1NB" style="font-size:12px;">Content</span></td>
           <!-- <td>:</td>-->
            <td class="normalfnt" style="font-size:12px;">&nbsp;<?php echo $rowHeader['strFabricContent']; ?></td>
          </tr>
          <tr  height="20">
            <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Wash Type</td>
           <!-- <td>:</td>-->
            <td class="normalfnt" style="font-size:12px;">&nbsp;<?php echo $rowHeader['intWashType']; ?></td>
            <td class='bcgl1txt1NB' align="left" width="16%" style="font-size:12px;">Weight (kg)</td>
            <!--<td>:</td>-->
            <td class="normalfnt" style="font-size:12px;">&nbsp;<?php echo $rowHeader['dblWeight']; ?></td>
          </tr>
          <tr  height="20">
            <td class='bcgl1txt1NB' align="left" width="17%" style="font-size:12px;">Handling Time(m)</td>
           <!-- <td>:</td>-->
            <td class="normalfnt" style="font-size:12px;">&nbsp;<?php echo $rowHeader['dblHTime']; ?></td>
            <td class='bcgl1txt1NB' align="left" width="16%" style="font-size:12px;"><span class="bcgl1txt1NB" style="font-size:12px;">Total Time(m)</span></td>
            <!--<td>:</td>-->
            <td class="normalfnt" style="font-size:12px;">&nbsp;<?php echo getRunTime($sNO)+$rowHeader['dblHTime']; ?></td>
          </tr>
        </table></td>
      </tr>	
      <tr>
      	<td colspan="3" width="100%">
        
        	<table width="800" align="center" border="1" bordercolor="#000000" rules="cols"  CELLPADDING=3 CELLSPACING=3 >
            <tr  height="20">
                <td width="152" class='normalfntMid' style='font-size: 15px;'><b>PROCESS</b></td>
                <td width="84" class='normalfntMid' style='font-size: 15px;'><b>LIQUOR(L)</b></td>
                <td width="70" class='normalfntMid' style='font-size: 15px;'><b>TEMP(c)</b></td>
                <td width="65" class='normalfntMid' style='font-size: 15px;'><b>TIME(m)</b></td>
                <td width="271" class='normalfntMid' style='font-size: 15px;'><b>CHEMICAL</b></td>
                <td width="74" class='normalfntMid' style='font-size: 15px;'><b>UNIT</b></td>
                <td width="62" class='normalfntMid' style='font-size: 15px;'><b>QTY</b></td>
            </tr>
            <?php 
			  $sql_processes="SELECT 
			  				  wb.intProcessId,
							  wb.intRowOder,
							  wf.strProcessName,
							  wb.dblLiqour,
							  wb.dblTemp,
							  wb.dblTime 
							  FROM 
							  was_budgetcostdetails wb
							  INNER JOIN was_washformula AS wf ON wf.intSerialNo=wb.intProcessId
							  WHERE 
							  wb.intSerialNo=$sNO;";
							 // echo  $sql_processes;
			  $resP=$db->RunQuery($sql_processes);
			  while($rowP=mysql_fetch_array($resP))
			  {
	  		?><?php 
				/*$sql_chemicals="SELECT wcl.strItemDescription, wcl.strUnit, wbc.dblQty, wbc.dblUnitPrice 
								FROM was_chemmatitemlist wcl 
								INNER JOIN was_budgetchemicals AS wbc ON wbc.intChemicalId=wcl.intSerialNo 
								WHERE wcl.intStatus=1 AND wbc.intProcessId=".$rowP['intProcessId']." AND wbc.intRowOder=".$rowP['intRowOder']." AND wbc.intSerialNo=$sNO;";*/
				$sql_chemicals="SELECT GMIL.strItemDescription, WBC.strUnit, WBC.dblQty, WBC.dblUnitPrice,WBC.intChemicalId 
								FROM was_budgetchemicals WBC 
								INNER JOIN genmatitemlist AS GMIL ON GMIL.intItemSerial=WBC.intChemicalId 
								WHERE WBC.intProcessId=".$rowP['intProcessId']." AND WBC.intRowOder=".$rowP['intRowOder']." AND WBC.intSerialNo=$sNO;";
								
				$resCh=$db->RunQuery($sql_chemicals);
                $pid=1;
				$numRows=mysql_num_rows($resCh);
              	if($numRows>0)
				{
					while($rowCh=mysql_fetch_array($resCh))
					{?>
            <tr <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>>
            	<td class="normalfnt" valign="top"><font  style='font-size: 14px;' ><?php if($pid==1){echo $rowP['intRowOder']." ".$rowP['strProcessName'];}?></font></td>
                <td class="normalfntRite" valign="top"><font  style='font-size: 13px;' ><?php if($pid==1){ echo number_format($rowP['dblLiqour'],3);}?>&nbsp;</font></td>
                <td class="normalfntRite" valign="top"><font  style='font-size: 13px;' ><?php if($pid==1){echo number_format($rowP['dblTemp'],2);}?></font>&nbsp;</td>
                <td class='normalfntRite' valign="top"><font  style='font-size: 13px;' ><?php if($pid==1){ if($rowP['dblTime']==0){ echo "COOL";}else{ echo number_format($rowP['dblTime'],2);}}?>&nbsp;</font></td>
                <td class='normalfnt' style="width:110px;"><font  style='font-size: 13px;' >&nbsp;<?php  if($pid==1){?><br />&nbsp;<?php  } $des=split('-',$rowCh['strItemDescription']);$chmA="";
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
				<td class='normalfntRite' style="text-align:center;"><font  style='font-size: 13px;' ><?php  if($pid==1){?><br /><?php  } echo $rowCh['strUnit'];?></font></td>
				<td class='normalfntRite'><font  style='font-size: 13px;' ><?php  if($pid==1){?><br /><?php  } echo number_format($rowCh['dblQty'],6);?></font>&nbsp;</td>
			</tr>
					<?php  $pid++; }
				}
				else
				{?>
			<tr <?php if($pid==1){ ?>style="border-top:#000 solid 1px;" <?php }?>> 
					<td class='normalfnt' valign="top"><font  style='font-size: 14px;' ><?php echo $rowP['intRowOder']." ".$rowP['strProcessName'];?></font></td>
					<td class='normalfntRite' valign="top"><font  style='font-size: 13px;' ><?php echo number_format($rowP['dblLiqour'],3);?>&nbsp;</font></td>
					<td class='normalfntRite' valign="top"><font  style='font-size: 13px;' ><?php if($rowP['dblTemp']==0){ echo "COOL";}else{ echo number_format($rowP['dblTemp'],2);}?>&nbsp;</font></td>
					<td class='normalfntRite' valign="top"><font  style='font-size: 13px;' ><?php echo number_format($rowP['dblTime'],2);?>&nbsp;</font></td>
					<td class='normalfnt' colspan="1"><font  style='font-size: 13px;' ><br />
					&nbsp; N0 CHEMICAL</font></td>
                    <td class='normalfntRite' style="text-align:center;">&nbsp;</td>
				<td class='normalfntRite'><font  style='font-size: 10px;' >&nbsp;</td>
			</tr>
				<?php }
			 }?>
            </table>     	</td>
      </tr>
      
      <tr>
      <td class='normalfnt' align="left" colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td class='normalfnt' align="left" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="6"><font  style='font-size: 10px;' ><b>THE ABOVE PROCESS IS AN INDICATION IT MAY REQUIRE FINE TUNING</b></font></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><font  style='font-size: 10px;' ><b>SIGNATURE : </b></font></td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td width="17%" class="normalfntMid">&nbsp;</td>
            <td width="23%" class="border-top" style="text-align:center;"><b>Approved by <br />WET PROCESSING MANAGER</b></td>
            <td width="10%" >&nbsp;</td>
            <td width="10%" class="normalfntMid" >&nbsp;</td>
            <td width="20%" class="border-top" style="text-align:center;"><b>Approved by <br />DEVELOPMENT MANAGER</b></td>
            <td width="20%" class="normalfntMid">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <td class='normalfnt' align="left">&nbsp;</td>
      <td class='normalfnt' align="left">&nbsp;</td>
      </tr>
</table>	

  <?php
  function getRunTime($costId,$PT){
		global $db;
		
	  $sql_RTime="SELECT
					Sum(bd.dblTime) AS R_TIME,
					bd.intSerialNo,
					bd.intYear
					FROM
					was_budgetcostdetails AS bd
					INNER JOIN was_washformula AS wf ON wf.intSerialNo = bd.intProcessId
					WHERE
					bd.intSerialNo = '$costId' 
					GROUP BY
					bd.intSerialNo,
					bd.intYear ;";
	  $resRT=$db->RunQuery($sql_RTime);
	  $rowRT=mysql_fetch_array($resRT);
	  return $rowRT['R_TIME'];
	}
  
  ?>


</body>
</html>
