<?php
	session_start();
	
	include "../../../Connector.php";
$backwardseperator = '../../../';
	
	$datefrom=$_GET["datefrom"];
	$PONo=$_GET["PONo"];
	$cboshift=$_GET["cboshift"];
	$cboshiftid=$_GET["cboshiftid"];
	$machine=$_GET["machine"];
	$machineID = 0;
	$shiftID   = 0;
	$date	   = 0;
	 
	
$report_companyId =$_SESSION["FactoryID"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Machine Loading Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>

<table width="895" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="30" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%" height="39" class="normalfnt2bldBLACK"></td>
            <td width="40%"  class="head2">MACHINE LOADING REPORT</td>
            <td width="30%">&nbsp;</td>
          </tr>
        </table>          </td>
        </tr>
      

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblItems">
      <tr>
        <td width="6%" height="25" class="normalfntBtab">Date</td>
        <td width="8%" class="normalfntBtab">Shift</td>
        <td width="9%" height="25" class="normalfntBtab">Weight</td>
        <td width="9%" height="25" class="normalfntBtab">Start T </td>
        <td width="8%" height="25" class="normalfntBtab">End T </td>
        <td width="10%" height="25" class="normalfntBtab">PONo</td>
        <td width="8%" class="normalfntBtab">Load</td>
        <td width="8%" class="normalfntBtab">Card</td>
        <td width="8%" height="25" class="normalfntBtab">Qty</td>
        <td width="8%" class="normalfntBtab">Prod</td>
        <td width="9%" class="normalfntBtab">User</td>
        <td width="9%" class="normalfntBtab">Time</td>
      </tr>
		<?php
			
			$strSQL="select
								MH.intStyleId,   
								MH.intMachineId, 
								MH.intShiftId, 
								MH.intOperatorId, 
								MH.intStatus,  
								MH.intLotNo, 
								MH.intRootCardNo, 
								MH.dblQty, 
								MH.dblWeight, 
								MH.dtmInDate, 
								MH.dtmOutDate, 
								MH.tmInTime, 
								MH.tmInAmPm, 
								MH.tmOutTime, 
								MH.tmOutAmPm,
								MH.intStatus,
								OD.strOrderNo,
								SH.strShiftName,
								WM.strMachineName,
								WO.strName,
								TIMEDIFF(MH.tmOutTime,MH.tmInTime) as TimeDiffrent
								 
								from 
								was_machineloadingheader MH
								inner join orders OD on OD.intStyleId=MH.intStyleId
								inner join was_shift SH on SH.intShiftId=MH.intShiftId
								inner join was_machine WM on WM.intMachineId=MH.intMachineId
								inner join was_operators WO on WO.intOperatorId=MH.intOperatorId
								where MH.intStatus=1 ";
  				
				if($datefrom != '')
				$strSQL .= " AND MH.dtmInDate='$datefrom' ";
				
				if($PONo!= '')
				$strSQL .= " AND OD.strOrderNo='$PONo' ";
				
				if($cboshiftid!= '')
				$strSQL .= " AND MH.intShiftId='$cboshiftid' ";
				
				if($machine!= '')
				$strSQL .= "AND WM.intMachineId='$machine' ";
			
			$result=$db->RunQuery($strSQL);
			
			while($row = mysql_fetch_array($result))
			{ 
				$curMachineID	= $row["intMachineId"];
				$curShiftID		= $row["intShiftId"];
				$curDate		= $row["dtmInDate"];
				
				
				if($curDate!=$date)
				{
					if($curShiftID!=$shiftID)
					{
						if($curMachineID!=$machineID)
						{
		?>
				<tr>
				  <td height="18" colspan="2" align="left" bgcolor="#5CB3FF" class="normalfnBLD1TAB"><?php echo $row["dtmInDate"]; ?></td>
	              <td height="18" colspan="10" align="left"  class="normalfnBLD1TAB">&nbsp;</td>
        </tr>
				<tr>
				  <td align="left" class="normalfnBLD1TAB" bgcolor="#C9BE62" >&nbsp;</td>
	              <td height="18" colspan="2" align="center" bgcolor="#C9BE62" class="normalfnBLD1TAB"><?php echo $row["strShiftName"];?></td>
                  <td colspan="9" align="left"  class="normalfnBLD1TAB" bgcolor="#C9BE62">&nbsp;</td>
        </tr>
				<tr>
				  <td align="left" class="normalfnBLD1TAB" >&nbsp;</td>
				  <td height="18" colspan="2" align="left"class="normalfnBLD1TAB" bgcolor="#CFECEC"><?php echo $row["strMachineName"];?></td>
                  <td colspan="9" align="left"  class="normalfnBLD1TAB">&nbsp;</td>
		</tr>
				<tr>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dtmInDate"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strShiftName"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblWeight"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmInTime"];?>&nbsp;<?php echo $row["tmInAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmOutTime"];?>&nbsp;<?php echo $row["tmOutAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strOrderNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intLotNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intRootCardNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblQty"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo ($row["intStatus"]= 1 ? "YES" :"NO");?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strName"];?></td>
				<td height="18" align="right" class="normalfntTAB9"><?php echo setMin(substr($row["TimeDiffrent"],0,5));?>&nbsp;</td>
				</tr>
			<?php
					
						$machineID=$curMachineID;
						$shiftID=$curShiftID;
						$date=$curDate;
					}
				
				}
				$machineID=$curMachineID;
				$shiftID=$curShiftID;
				$date=$curDate;
		}
			
			else
			{
				if($curShiftID!=$shiftID)
					{
					?>
					<tr>
				  <td align="left" class="normalfnBLD1TAB" bgcolor="#C9BE62" >&nbsp;</td>
	              <td height="18" colspan="2" align="center" bgcolor="#C9BE62" class="normalfnBLD1TAB"><?php echo $row["strShiftName"];?></td>
                  <td colspan="9" align="left"  class="normalfnBLD1TAB" bgcolor="#C9BE62">&nbsp;</td>
        </tr>
					<?php
						if($curMachineID!=$machineID)
						{
						?>
						<tr>
						  <td align="left" class="normalfnBLD1TAB" >&nbsp;</td>
				  <td height="18" colspan="2" align="left"class="normalfnBLD1TAB" bgcolor="#CFECEC"><?php echo $row["strMachineName"];?></td>
                  <td colspan="9" align="left"  class="normalfnBLD1TAB">&nbsp;</td>
		</tr>
				<tr>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dtmInDate"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strShiftName"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblWeight"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmInTime"];?>&nbsp;<?php echo $row["tmInAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmOutTime"];?>&nbsp;<?php echo $row["tmOutAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strOrderNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intLotNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intRootCardNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblQty"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo ($row["intStatus"]= 1 ? "YES" :"NO");?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strName"];?></td>
				<td height="18" align="right" class="normalfntTAB9"><?php echo setMin(substr($row["TimeDiffrent"],0,5));?>&nbsp;</td>
				</tr>
							
						<?php
						$machineID=$curMachineID;
						$shiftID=$curShiftID;
						$date=$curDate;
						}
						else
						{
						?>
						<tr>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dtmInDate"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strShiftName"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblWeight"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmInTime"];?>&nbsp;<?php echo $row["tmInAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmOutTime"];?>&nbsp;<?php echo $row["tmOutAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strOrderNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intLotNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intRootCardNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblQty"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo ($row["intStatus"]= 1 ? "YES" :"NO");?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strName"];?></td>
				<td height="18" align="right" class="normalfntTAB9"><?php echo setMin(substr($row["TimeDiffrent"],0,5));?>&nbsp;</td>
				</tr>
						<?php
						$machineID=$curMachineID;
						$shiftID=$curShiftID;
						$date=$curDate;
						}
						$machineID=$curMachineID;
						$shiftID=$curShiftID;
						$date=$curDate;
					}
					else
					{
						if($curMachineID!=$machineID)
						{
						?>
						<tr>
				  <td align="left" class="normalfnBLD1TAB" >&nbsp;</td>
				  <td height="18" colspan="2" align="left"class="normalfnBLD1TAB" bgcolor="#CFECEC"><?php echo $row["strMachineName"];?></td>
                  <td colspan="9" align="left"  class="normalfnBLD1TAB">&nbsp;</td>
		</tr>
				<tr>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dtmInDate"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strShiftName"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblWeight"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmInTime"];?>&nbsp;<?php echo $row["tmInAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmOutTime"];?>&nbsp;<?php echo $row["tmOutAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strOrderNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intLotNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intRootCardNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblQty"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo ($row["intStatus"]= 1 ? "YES" :"NO");?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strName"];?></td>
				<td height="18" align="right" class="normalfntTAB9"><?php echo setMin(substr($row["TimeDiffrent"],0,5));?>&nbsp;</td>
				</tr>
							
						<?php
						$machineID=$curMachineID;
						$shiftID=$curShiftID;
						$date=$curDate;
						}
						else
						{
						?>
						<tr>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dtmInDate"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strShiftName"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblWeight"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmInTime"];?>&nbsp;<?php echo $row["tmInAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["tmOutTime"];?>&nbsp;<?php echo $row["tmOutAmPm"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strOrderNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intLotNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["intRootCardNo"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["dblQty"];?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo ($row["intStatus"]= 1 ? "YES" :"NO");?></td>
				<td height="18" align="left" class="normalfntTAB9"><?php echo $row["strName"];?></td>
				<td height="18" align="right" class="normalfntTAB9"><?php echo setMin(substr($row["TimeDiffrent"],0,5));?>&nbsp;</td>
				</tr>
						<?php
						$machineID=$curMachineID;
						$shiftID=$curShiftID;
						$date=$curDate;
						}
						$machineID=$curMachineID;
						$shiftID=$curShiftID;
						$date=$curDate;
					
					}
					$machineID=$curMachineID;
					$shiftID=$curShiftID;
					$date=$curDate;
			}
			
							
	}
	?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td class="normalfnt">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
</table>
<?php 
function setMin($tm){
global $db;
	$time=split(":",$tm);
    return $time[0]*60+$time[1];
}
?>
</body>
</html>
