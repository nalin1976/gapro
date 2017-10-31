<?php
	session_start();
	include "../../Connector.php";
	
	$rootCrdNoArry = explode('/',$_GET['rootCardNo']);
	$rootCardNo    = $rootCrdNoArry[0];
	$rootCardYear  = $rootCrdNoArry[1];
	
	$sql = "select distinct WM.strMachineName,WR.strColor,WPD.strLotNo,
			concat(WRD.strTimeIN,'',WRD.strTimeInAMPM) as timeIn,
			concat(WRD.strTimeOut,'',WRD.srtTimeOutAMPM) as TimeOut
			from was_rootcard WR
			inner join was_planmachineallocationdetail WPD on WPD.intBatchId= WR.intBatch
			inner join was_rootcard_detail WRD on WRD.intRYear=WR.intRYear and WRD.intRootCardNo=WR.dblRootCartNo
			inner join was_machine WM on WM.intMachineId=WPD.intMachine
			where WR.dblRootCartNo='$rootCardNo' and WR.intRYear='$rootCardYear' and WRD.intDepatmentId=2";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$machine  = $row['strMachineName'];
	$color    = $row['strColor'];
	$lotNo	  = $row['strLotNo'];
	$timeIn	  = $row['timeIn'];
	$TimeOut  = $row['TimeOut'];
	$TimeDiff = $row['TimeDiff'];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Root Card Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="550" cellpadding="0" cellspacing="0" class="border-All">
<tr>
	<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td width="20%" class="normalfnt">&nbsp;</td>
    <td width="24%" class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="head2"><span style="font-size:18px"> Machine&nbsp;</span> <span style="color:#000;"><?php echo $machine; ?></span></td>
    <td class="normalfnt" style="text-align:right">&nbsp;Date :&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;<?php echo date('d-M-Y') ?></td>
    </tr>
  <tr>
    <td width="2%" class="normalfnt">&nbsp;</td>
    <td width="28%" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt" style="text-align:right">&nbsp;Lot :&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;<?php echo $lotNo; ?></td>
    </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td width="24%" class="normalfnt">&nbsp;</td>
    <td width="2%" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="4" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="5" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt" width="1%">&nbsp;</td>
        <td class="normalfnt" width="10%">&nbsp;</td>
        <td class="normalfnt" width="2%">&nbsp;</td>
        <td class="normalfnt" width="18%">&nbsp;</td>
        <td class="normalfnt" width="11%">Time In :</td>
        <td class="normalfnt" width="21%">&nbsp;<b><?php echo $timeIn ?></b></td>
        <td class="normalfnt" width="12%">Time Out :</td>
        <td class="normalfnt" width="25%">&nbsp;<b><?php echo $TimeOut; ?></b></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="8" ><table width="100%" border="0" cellspacing="0" class="tableBorder" rules="all" cellpadding="0">
          <tr bgcolor="#E6E6E6">
            <th width="18%" class="normalfntMid" >&nbsp;PO</th>
            <th width="18%" class="normalfntMid" >&nbsp;Style&nbsp;</th>
            <th width="20%" class="normalfntMid" >&nbsp;Colour&nbsp;</th>
            <th width="20%" class="normalfntMid" >&nbsp;Duration(Min)&nbsp;</th>
            <th width="11%" class="normalfntMid" >&nbsp;Qty&nbsp;</th>
            <th width="13%" class="normalfntMid" >Act Qty</th>
            </tr>
          <?php
	  	$sqlMain = "select O.strOrderNo,WPD.intLotQty,O.strStyle,WR.strColor,COALESCE(WR.intActualQty,'') as intActualQty,
					TIME_TO_SEC(timediff(WRD.strTimeOut,WRD.strTimeIN)) as difTime
					from was_rootcard WR
					inner join was_planmachineallocationdetail WPD on WPD.intBatchId=WR.intBatch
					inner join was_rootcard_detail WRD on WRD.intRYear=WR.intRYear and WRD.intRootCardNo=WR.dblRootCartNo
					inner join orders O on WPD.intStyleId=O.intStyleId 
					where WR.dblRootCartNo='$rootCardNo' and WR.intRYear='$rootCardYear' and WRD.intDepatmentId=2"; 
		$resultMain = $db->RunQuery($sqlMain);
		while($rowMain = mysql_fetch_array($resultMain))
		{
			$seconds = $rowMain['difTime'] ;
			$minutes = floor($seconds/60);
			$secondsleft = $seconds%60;
			if($minutes<10)
				$minutes = "0" . $minutes;
			if($secondsleft<10)
				$secondsleft = "0" . $secondsleft;
			$durationMinuts = $minutes.':'.$secondsleft;
		
		?>
          <tr >
            <td class="normalfnt" >&nbsp;<?php echo $rowMain['strOrderNo']; ?>&nbsp;</td>
            <td class="normalfnt" >&nbsp;<?php echo $rowMain['strStyle']; ?>&nbsp;</td>
            <td class="normalfnt" >&nbsp;<?php echo $rowMain['strColor']; ?>&nbsp;</td>
            <td class="normalfnt" >&nbsp;<?php echo $durationMinuts; ?>&nbsp;</td>
            <td class="normalfnt" style="text-align:right">&nbsp;<?php echo $rowMain['intLotQty']; ?>&nbsp;</td>
            <td class="normalfnt" style="text-align:right">&nbsp;<?php echo $rowMain['intActualQty']; ?>&nbsp;</td>
            </tr>
          <?php
		}
		?>
          
          </table>  </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">Remarks</td>
        <td class="normalfnt">&nbsp;:</td>
        <td colspan="5" rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
      </tr>
    </table></td>
    <td class="normalfnt">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr style="display:none">
    <td class="normalfnt">&nbsp;</td>
    <td colspan="4" class="normalfnt"><table width="70%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="border-top-left-fntsize10" style="text-align:center"><b>Lot No</b></td>
        <td class="border-top-left-fntsize10" style="text-align:center"><b>Killos</b></td>
        <td class="border-Left-Top-right-fntsize10" style="text-align:center"><b>Issue<br />KG</b></td>
      </tr>
      <?php
	  $sqlLot = "select distinct WPD.strLotNo
				from was_rootcard WR
				inner join was_planmachineallocationdetail WPD on WPD.intBatchId=WR.intBatch
				inner join orders O on WPD.intStyleId=O.intStyleId 
				where WR.dblRootCartNo='$rootCardNo' and WR.intRYear='$rootCardYear'"; 
	  $resultMain = $db->RunQuery($sqlLot);
	  while($rowMain = mysql_fetch_array($resultMain))
	  {
	  ?>
      <tr>
        <td class="border-top-left-fntsize10" style="text-align:left">&nbsp;<?php echo $rowMain['strLotNo']; ?>&nbsp;</td>
        <td class="border-top-left-fntsize10" style="text-align:right">1111</td>
        <td class="border-Left-Top-right-fntsize10" style="text-align:right">1111</td>
      </tr>
      <?php
	  }
	  ?>
      <tr>
        <td class="border-top-fntsize10" style="text-align:left">&nbsp;</td>
        <td class="border-top-fntsize10" style="text-align:right">&nbsp;</td>
        <td class="border-top-fntsize10" style="text-align:right">&nbsp;</td>
      </tr>
    </table></td>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="normalfnt" style="border-bottom:dotted">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt" style="text-align:right">&nbsp;Date :&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;<?php echo date('d-M-Y') ?></td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
   <td class="normalfnt" style="text-align:right">&nbsp;Lot :&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;<?php echo $lotNo; ?></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;<b>Chemical Issue</b></td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt" style="text-align:right">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="4" class="normalfnt"><table width="100%" border="0" cellspacing="0" class="tableBorder" rules="all" cellpadding="0">
          <tr bgcolor="#E6E6E6">
            <th width="20%" class="normalfntMid" >&nbsp;PO&nbsp;</th>
            <th width="18%" class="normalfntMid" >&nbsp;Style&nbsp;</th>
            <th width="17%" class="normalfntMid" >&nbsp;Colour&nbsp;</th>
            <th width="37%" class="normalfntMid" >&nbsp;Chemical&nbsp;</th>
            <th width="8%" class="normalfntMid" >&nbsp;Qty&nbsp;</th>
            </tr>
      <?php
	  $i=1;
 	 $sqlChemPro = "select WA.intRowID,WA.intProcessId,WP.dblCostNo,WP.intCostYear,WR.strColor,O.strOrderNo,O.strStyle
					from was_rootcard WR
					inner join was_planmachineallocationdetail WP on WP.intBatchId=WR.intBatch
					inner join was_actualcostdetails WA on WA.intSerialNo=WP.dblCostNo and WA.intYear=WP.intCostYear
					inner join orders O on WP.intStyleId=O.intStyleId 
					where WR.dblRootCartNo='$rootCardNo' and WR.intRYear='$rootCardYear'"; 
	$resultChemPro = $db->RunQuery($sqlChemPro);
	while($rowChemPro = mysql_fetch_array($resultChemPro))
	{
		$sqlChem = "SELECT
					GL.strItemDescription,
					WACC.dblQty
					FROM
					was_actcostchemicals WACC
					INNER JOIN genmatitemlist GL ON WACC.intChemicalId = GL.intItemSerial
					WHERE
					WACC.intProcessId = '".$rowChemPro['intProcessId']."' AND
					WACC.intSerialNo = '".$rowChemPro['dblCostNo']."' AND
					WACC.intYear = '".$rowChemPro['intCostYear']."' and
					WACC.intRowOder='".$rowChemPro['intRowID']."'";
		$resultChem = $db->RunQuery($sqlChem);
		$Rowcount = mysql_num_rows($resultChemPro);
		while($rowChem = mysql_fetch_array($resultChem))
		{
		?>
            <tr >
                <td class="normalfnt" >&nbsp;<?php echo $rowChemPro['strOrderNo']; ?>&nbsp;</td>
                <td class="normalfnt" >&nbsp;<?php echo $rowChemPro['strStyle']; ?>&nbsp;</td>
                <td class="normalfnt" >&nbsp;<?php echo $rowChemPro['strColor']; ?>&nbsp;</td>
                <td class="normalfnt" >&nbsp;<?php echo $rowChem['strItemDescription']; ?>&nbsp;</td>
                <td class="normalfntRite" >&nbsp;<?php echo $rowChem['dblQty']; ?>&nbsp;</td>
        	</tr>
         <?php	
		}    	
	}
	?>  
    </table></td>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="normalfnt" style="border-bottom:dotted">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
     <td class="normalfnt" style="text-align:right">&nbsp;Date :&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;<?php echo date('d-M-Y') ?></td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
     <td class="normalfnt" style="text-align:right">&nbsp;Lot :&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;<?php echo $lotNo; ?></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;<b>Lot Issue</b></td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt" style="text-align:right">&nbsp;</td>
    <td colspan="2" class="normalfnt"></td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="4" class="normalfnt">
    <table width="100%" border="0" cellspacing="0" class="tableBorder" rules="all" cellpadding="0">
          <tr bgcolor="#E6E6E6">
            <th width="23%" class="normalfntMid" >&nbsp;PO&nbsp;</th>
            <th width="19%" class="normalfntMid" >&nbsp;Style&nbsp;</th>
            <th width="20%" class="normalfntMid" >&nbsp;Colour&nbsp;</th>
            <th width="14%" class="normalfntMid" >&nbsp;Lot No&nbsp;</th>
            <th width="11%" class="normalfntMid" >&nbsp;Qty&nbsp;</th>
            <th width="13%" class="normalfntMid" >Act Qty</th>
          </tr>
          <?php
		  $sqlLotI = "select WPD.intLotQty,WPD.strLotNo,WR.strColor,O.strOrderNo,O.strStyle,COALESCE(WR.intActualQty,'') as intActualQty
						from was_rootcard WR
						inner join was_planmachineallocationdetail WPD on WPD.intBatchId= WR.intBatch
						inner join orders O on WPD.intStyleId=O.intStyleId 
						where WR.dblRootCartNo='$rootCardNo' and WR.intRYear='$rootCardYear'";
		  $resultLotI = $db->RunQuery($sqlLotI);
		  while($rowLotI = mysql_fetch_array($resultLotI))
		  {
		  ?>
           <tr bgcolor="#FFFFFF">
            <th width="23%" class="normalfnt" >&nbsp;<?php echo $rowLotI['strOrderNo'];?>&nbsp;</th>
            <th width="19%" class="normalfnt" >&nbsp;<?php echo $rowLotI['strStyle'];?>&nbsp;</th>
            <th width="20%" class="normalfnt" >&nbsp;<?php echo $rowLotI['strColor'];?>&nbsp;</th>
            <th width="14%" class="normalfnt" >&nbsp;<?php echo $rowLotI['strLotNo'];?>&nbsp;</th>
            <th width="11%" class="normalfnt" style="text-align:right" >&nbsp;<?php echo $rowLotI['intLotQty'];?>&nbsp;</th>
            <th width="13%" class="normalfnt" style="text-align:right" >&nbsp;<?php echo $rowLotI['intActualQty'];?>&nbsp;</th>
           </tr>
          <?php
		  }
		  ?>
    </table>
    </td>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="2" class="normalfnt">&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
</body>
</html>