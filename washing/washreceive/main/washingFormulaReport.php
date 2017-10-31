<?php
 session_start();
 $backwardseperator = "../../../";
include('../../../Connector.php');
$report_companyId = $_SESSION["UserID"];
$sNO = $_GET['q'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Budgeted - Wash Formula - Report</title>
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
table
{
	border-spacing:0px;
}
/*table{
	border-collapse:collapse;
	}
tr.row td{
border-width:1px 0;
border-style:solid;
border-color:#CCC;
}*/
</style>
</head>
<body>

	<?php
	
     $sql_header="	SELECT 
					m.strItemDescription,
					O.strStyle,
					wb.intGarmentId,
					wt.strWasType,
					wb.strColor,
					wb.dblQty,
					wb.dblWeight,
					mt.strMachineCode,
					wb.dtmDate,
					wb.intStatus
					FROM 
					was_budgetcostheader wb
					INNER JOIN matitemlist AS m ON m.intItemSerial= wb.intMatDetailId
					INNER JOIN orders AS O ON  O.intStyleId = wb.intStyleId 
					INNER JOIN was_machinetype AS mt ON mt.intMachineId =wb.intMachineId
					INNER JOIN was_washtype AS wt ON wt.intWasID = wb.intWashType
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
<table width="800" align='center' CELLPADDING=3 CELLSPACING=1 >
	  <tr>
	    <td colspan="4"><?php include '../../../reportHeader.php';?></td>
  </tr>
	  <tr>
	    <td colspan="4" class="head2">WASHING FORMULA</td>
  </tr>
	  <tr>	<?php if($rowHeader['intStatus']==0){
	  			$status = "NOT CONFIRM";
			}else{
				$status = "CONFIRM";
			}
	  		?>
 			<td class='normalfnt' align="left" style="width:400px;color:#F30;"><?php echo $status;?></td>			
            <td>&nbsp;</td>
            <td class='normalfnt' align="left" style="width:100px;"><b>Machine Code :</b>            </td>
            <td class='normalfnt' align="left" style="width:100px;"><?php echo $rowHeader['strMachineCode']; ?></td>
 	  </tr>
</table>

    
<table width="800"  align='center' border='0'>
      <tr>
        <td colspan="3" align="left" class='bcgl1txt1NB'><table width="100%" border='1' cellpadding="0" cellspacing="0" rules="groups">
          <tr>
            <td class='bcgl1txt1NB' align="left" width="13%"><b>Date</b></td>
            <td width="1%">:</td>
            <td width="35%"><span class="normalfnt"><?php echo  substr($rowHeader['dtmDate'],0,10); ?></span></td>
            <td class='bcgl1txt1NB' align="left" width="14%">Style Name</td>
            <td width="1%">:</td>
            <td width="36%" class="normalfnt"><?php echo $rowHeader['strStyle']; ?></td>
          </tr>
          <tr>
            <td class='bcgl1txt1NB' align="left" width="13%">Fabric Name</td>
            <td>:</td>
            <td class="normalfnt"><?php echo $rowHeader['strItemDescription']; ?></td>
            <td class='bcgl1txt1NB' align="left" width="14%">Fabric Dsc</td>
            <td>:</td>
            <td class="normalfnt"><?php echo $fabDsc;?></td>
          </tr>
          <tr>
            <td class='bcgl1txt1NB' align="left" width="13%">Color</td>
            <td>:</td>
            <td class="normalfnt"><?php echo $rowHeader['strColor']; ?></td>
            <td class='bcgl1txt1NB' align="left" width="14%">Fabric Con</td>
            <td>:</td>
            <td class="normalfnt"><?php echo $fabArr[$c-1];?></td>
          </tr>
          <tr>
            <td class='bcgl1txt1NB' align="left" width="13%">Wash Type</td>
            <td>:</td>
            <td class="normalfnt"><?php echo $rowHeader['strWasType']; ?></td>
            <td class='bcgl1txt1NB' align="left" width="14%">Weight</td>
            <td>:</td>
            <td class="normalfnt"><?php echo $rowHeader['dblWeight']; ?></td>
          </tr>
        </table></td>
      </tr>	
      <tr>
      	<td colspan="3" width="100%">
        
        	<table width="100%" border='1' cellpadding="0" cellspacing="0" rules="rows" >
            <tr>
                <td height="15" class='normalfnt' align="left"><b>PROCESS</b></td>
                <td class='normalfnt' align="left"><b>LIQUOR(L)</b></td>
                <td class='normalfnt' align="left"><b>TEMP(c)</b></td>
                <td class='normalfnt' align="left"><b>TIME(m)</b></td>
                <td class='normalfnt' align="left"><b>Chemical</b></td>
                <td class='normalfntMid' align="left"><b>UNIT</b></td>
                <td class='normalfntMid' align="left"><b>QTY</b></td>
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
							  //echo  $sql_processes;
			  $resP=$db->RunQuery($sql_processes);
			  while($rowP=mysql_fetch_array($resP))
			  {
	  		?>
            <tr class="row">
            	<td class="normalfnt" align="left" valign="top"><font  style='font-size: 10px;' ><?php echo $rowP['intRowOder']." ".$rowP['strProcessName'];?></font></td>
                <td class="border-bottom" align="left" valign="top"><font  style='font-size: 10px;' ><?php echo $rowP['dblLiqour'];?></font></td>
                <td class="border-bottom" align="left" valign="top"><font  style='font-size: 10px;' ><?php echo $rowP['dblTemp'];?></font></td>
                <td class='border-bottom' align="left" valign="top"><font  style='font-size: 10px;' ><?php echo $rowP['dblTime'];?></font></td>
                
                <td class="border-bottom" align="left" colspan="3" >   
                <table border="0" width="100%" > 
				<?php 
				$sql_chemicals="SELECT wcl.strItemDescription, wcl.strUnit, wbc.dblQty, wbc.dblUnitPrice 
								FROM was_chemmatitemlist wcl 
								INNER JOIN was_budgetchemicals AS wbc ON wbc.intChemicalId=wcl.intSerialNo 
								WHERE wcl.intStatus=1 AND wbc.intProcessId=".$rowP['intProcessId']." AND wbc.intRowOder=".$rowP['intRowOder']." AND wbc.intSerialNo=$sNO;";
								//echo $sql_chemicals;
				$resCh=$db->RunQuery($sql_chemicals);
                
				$numRows=mysql_num_rows($resCh);
              	if($numRows>0)
				{
					while($rowCh=mysql_fetch_array($resCh))
					{?>
						<tr> 
							<td width="197" class='normalfnt' style="width:110px;"><font  style='font-size: 10px;' ><?php 
							echo $rowCh['strItemDescription'];
							?></font></td>
							<td width="103" class='normalfntMid' style="width:70px;"><font  style='font-size: 10px;' ><?php echo $rowCh['strUnit'];?></font></td>
							<td width="86" class='normalfntMid' style="width:50px;"><font  style='font-size: 10px;' ><?php echo $rowCh['dblQty'];?></font></td>
				  </tr>
					<?php }
				}
				else
				{?>
					<tr> 
							<td style="width:110px;" class='normalfnt'><font  style='font-size: 10px;' >NO Chemical</font></td>
							<td style="width:70px;" class='normalfnt'></td>
							<td style="width:50px;" class='normalfnt'></td>
				  </tr>
				<?php }
				?></table>                </td>
            </tr>
			<?php }?>
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
            <td colspan="3"><font  style='font-size: 10px;' ><b>SIGNATURE : </b></font></td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td width="17%" class="normalfntMid">&nbsp;</td>
            <td width="23%" class="border-top"><b>WET PROCESSING MANAGER</b></td>
            <td width="10%" >&nbsp;</td>
            <td width="10%" class="normalfntMid">&nbsp;</td>
            <td width="20%" class="border-top"><b>DEVELOPMENT MANAGER</b></td>
            <td width="20%" class="normalfntMid">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <td class='normalfnt' align="left">&nbsp;</td>
      <td class='normalfnt' align="left">&nbsp;</td>
      </tr>
</table>	

  


</body>
</html>
