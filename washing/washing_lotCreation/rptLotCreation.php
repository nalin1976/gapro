<?php
	session_start();
	include "../../Connector.php";
	
	$planIDArry = explode('/',$_GET['planId']);
	$planNo   = $planIDArry[1];
	$planYear = $planIDArry[0];

	$sqlH = "select date(dtmDate) as planDate,was_planheader.intShiftId,was_shift.strShiftName
				from was_planheader
				inner join was_shift on was_shift.intShiftId=was_planheader.intShiftId
				where was_planheader.intPlanNo='$planNo' and was_planheader.intPlanYear='$planYear'";
	$resultH = $db->RunQuery($sqlH);
	$rowH = mysql_fetch_array($resultH);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lot Creation Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%">&nbsp;</td>
    <td height="1100" class="border-All" width="60%" valign="top"><table width="800" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td class="head2"><u>Lot Creation Report</u></td>
  </tr>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
   <tr>
     <td class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="1">
       <tr>
         <td class="normalfnt" width="2%">&nbsp;</td>
         <td class="normalfnt" width="7%">&nbsp;Shift</td>
         <td class="normalfnt" width="1%">&nbsp;:</td>
         <td class="normalfnt" width="53%"><b><?php echo $rowH['strShiftName']; ?></b></td>
         <td class="normalfnt" width="10%">Date From</td>
         <td class="normalfnt" width="2%">&nbsp;:</td>
         <td class="normalfnt" width="25%"><?php echo $rowH['planDate']; ?></td>
       </tr>
       <tr>
         <td class="normalfnt">&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td class="normalfnt">Date To</td>
         <td class="normalfnt">&nbsp;:</td>
         <td class="normalfnt"><?php echo $rowH['planDate']; ?></td>
       </tr>
     </table></td>
   </tr>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
   <?php
   $boolCheck = false;
   $sqlD = "select WPD.intMachine,WM.strMachineName,count(WPD.intMachine) as noOfLots,sum(WPD.intLotQty) as planQty
			from was_planmachineallocationheader WPH
			inner join was_planmachineallocationdetail WPD on WPD.intBatchId=WPH.intBatchId
			inner join was_machine WM on WM.intMachineId=WPD.intMachine
			where WPH.intPlanNo='$planNo' and WPH.intPlanYear='$planYear'
			group by WPD.intMachine";
	$resultD = $db->RunQuery($sqlD);
	while($rowD = mysql_fetch_array($resultD))
	{
		$sqlCount = "select WPD.intStyleId as noOfPOs
						from was_planmachineallocationdetail WPD
						inner join was_planmachineallocationheader WPH on WPD.intBatchId=WPH.intBatchId
						where WPH.intPlanNo='$planNo' and WPH.intPlanYear='$planYear'
						and WPD.intMachine='".$rowD['intMachine']."'
						group by WPD.intStyleId";
		$resultCount = $db->RunQuery($sqlCount);
		$NoOfPOs = mysql_num_rows($resultCount);
   ?>
   <tr>
     <td class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="1">
       <tr>
         <td class="normalfnt" width="2%">&nbsp;</td>
         <td class="normalfnt"><table width="400" border="0" cellspacing="0" cellpadding="0" rules="all" class="tableBorder">
           <tr bgcolor="#E6E6E6">
             <th height="20" class="normalfntMid">Machine</th>
             <th class="normalfntMid">No of Pos</th>
             <th class="normalfntMid">No of Lots</th>
             <th class="normalfntMid">Plan Qty.</th>
           </tr>
           <tr>
             <td height="15" class="normalfnt">&nbsp;<?php echo $rowD['strMachineName']; ?></td>
             <td class="normalfnt" style="text-align:right"><?php echo $NoOfPOs; ?></td>
             <td class="normalfnt" style="text-align:right"><span class="normalfnt" style="text-align:right"><?php echo $rowD['noOfLots']; ?></span></td>
             <td class="normalfnt" style="text-align:right"><?php echo $rowD['planQty']; ?></td>
           </tr>
         </table></td>
         </tr>
     </table></td>
   </tr>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
   <tr>
     <td class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="1">
       <tr>
         <td class="normalfnt" width="2%">&nbsp;</td>
         <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
           <tr bgcolor="#E6E6E6">
             <td height="20" class="border-top-left-fntsize10" style="text-align:center"><b>Machine</b></td>
             <td class="border-top-left-fntsize10" style="text-align:center"><b>PO</b></td>
             <td class="border-top-left-fntsize10" style="text-align:center"><b>Style</b></td>
             <td class="border-top-left-fntsize10" style="text-align:center"><b>Colour</b></td>
             <td class="border-top-left-fntsize10" style="text-align:center"><b>Order Qty.</b></td>
             <td class="border-top-left-fntsize10" style="text-align:center"><b>Lot</b></td>
             <td class="border-top-left-fntsize10" style="text-align:center"><b>Qty</b></th>
             <th class="border-top-left-fntsize10" style="text-align:center"><b>Running Total</b></th>
             <th class="border-Left-Top-right-fntsize10" style="text-align:center"><b>Actual Qty</b></th>
           </tr>
            <?php
			$loop=0;
			$runnigTotArry = array();
	   $sqlLotD = "select WPD.intMachine,WM.strMachineName,O.strOrderNo,O.strStyle,WAH.strColor,O.intQty,
	  			 	WPD.strLotNo,WPD.intLotQty,COALESCE(WR.intActualQty,'') as intActualQty
					from was_planmachineallocationdetail WPD
					inner join was_planmachineallocationheader WPH on WPH.intBatchId=WPD.intBatchId
					left join was_rootcard WR on WPH.intBatchId=WR.intBatch
					inner join orders O on O.intStyleId=WPD.intStyleId
					inner join was_machine WM on WM.intMachineId=WPD.intMachine
					inner join was_actualcostheader WAH on WAH.intSerialNo=WPD.dblCostNo and WAH.intYear=WPD.intCostYear
					where WPH.intPlanNo='$planNo' and WPH.intPlanYear='$planYear'
				 	and WPD.intMachine='".$rowD['intMachine']."'";
	$resultLotD = $db->RunQuery($sqlLotD);
	while($rowLD = mysql_fetch_array($resultLotD))
	{ 
			$runnigTotArry[$loop][0]= $rowLD["strOrderNo"];
			$runnigTotArry[$loop][1]= $rowLD["intLotQty"];
			$loop++;
   ?>
           <tr bgcolor="#FFFFFF">
           <?php
           if($boolCheck==false)
		   {
			?>
             <td height="15" class="border-top-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo $rowLD['strMachineName']; ?>&nbsp;</td>
             <?php
		   }
		   else
		   {
			?>
            <td height="15" class="border-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo $rowLD['strMachineName']; ?>&nbsp;</td>
            <?php
		   }
			?>
             <td class="border-top-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo $rowLD['strOrderNo']; ?>&nbsp;</td>
             <td class="border-top-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo $rowLD['strStyle']; ?>&nbsp;</td>
             <td class="border-top-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo $rowLD['strColor']; ?>&nbsp;</td>
             <td class="border-top-left-fntsize10" nowrap="nowrap" style="text-align:right">&nbsp;<?php echo $rowLD['intQty']; ?>&nbsp;</td>
             <td class="border-top-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo $rowLD['strLotNo']; ?>&nbsp;</td>
            
             <td class="border-top-left-fntsize10" nowrap="nowrap" style="text-align:right">&nbsp;<?php echo $rowLD['intLotQty']; ?>&nbsp;</td>
             <?php
			 
			$totQty	= 0; 	 	
			for($i=0;$i<count($runnigTotArry);$i++)
			{
				if($runnigTotArry[$i][0]==$rowLD['strOrderNo'])
				{
					$totQty += $runnigTotArry[$i][1];
				}				
			}
			 ?>
             <td class="border-top-left-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo $totQty; ?></td>
             <td class="border-Left-Top-right-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo $rowLD['intActualQty']; ?></td>
           </tr>
           
     <?php
	}
	 ?>
     	<tr bgcolor="#FFFFFF">
             <td height="15" colspan="9" nowrap="nowrap" class="border-top-fntsize10">&nbsp;</td>
             </tr>
         </table></td>
         <td width="2%">&nbsp;</td>
         </tr>
     </table></td>
   </tr>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
   <?php
	}
   ?>
   <tr>
     <td class="normalfnt">&nbsp;</td>
   </tr>
    </table>
</td>
  </tr>
</table></td>
    <td width="20%">&nbsp;</td>
  </tr>
</table>


</body>
</html>