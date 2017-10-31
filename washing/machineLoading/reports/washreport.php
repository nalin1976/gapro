<?php
	session_start();
	
	include "../../../Connector.php";
$backwardseperator = '../../../';
	
	$datefrom=$_GET["datefrom"];
	$dateto=$_GET["dateto"];
	$PONo=$_GET["PONo"];
	$color=$_GET["color"];
	$cboshift=$_GET["cboshift"];
	$cboshiftid=$_GET["cboshiftid"];
	
	$washtype=$_GET["washtype"];
	
	//$frmdate='2011-03-23';
	//$todate='2011-03-25';
	
$report_companyId =$_SESSION["FactoryID"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wash Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>

<table width="959" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="30" colspan="5" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="37%" height="39" class="normalfnt"><?php echo date("l d/m/Y"); ?></td>
            <td width="28%"  class="head2">WASH REPORT</td>
            <td width="35%">&nbsp;</td>
          </tr>
        </table>          </td>
        </tr>
      <tr>
        <td width="30%" height="36" align="left" class="normalfnt2bldBLACK"><?php echo $cboshift; ?> </td>
        <td width="15%" class="normalfnt">For the Period from   :</td>
        <td width="14%" class="normalfnt"><?php echo $datefrom; ?></td>
        <td width="5%" class="normalfnt">to   : </td>
        <td width="36%" class="normalfnt"><?php echo $dateto; ?></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblItems">
      <tr>
        <td width="12%" height="25" class="normalfntBtab">PO NO</td>
        <td width="12%" class="normalfntBtab">STYLE TYPE</td>
        <td width="12%" height="25" class="normalfntBtab">WASH TYPE</td>
        <td width="12%" height="25" class="normalfntBtab">STYLE NAME</td>
        <td width="12%" height="25" class="normalfntBtab">COLOR</td>
        <td width="28%" height="25" class="normalfntBtab">FAB ID</td>
        <td height="25" class="normalfntBtab">QTY.(PCS)</td>
        </tr>
		<?php
			$tot=0;
			$strSQL="select
						OD.strOrderNo,
						OD.strStyle,
						WW.strWasType,
						OD.strDescription,
						ML.strColor,
						MIL.strItemDescription,
						sum(ML.dblQty) as totqty,
						SH.strShiftName,
						WM.strMachineName
						from was_machineloadingheader ML
						inner join orderdetails ODD on  ML.intStyleId=ODD.intStyleId
						inner join orders OD on  ML.intStyleId=OD.intStyleId
						inner join matitemlist MIL on MIL.intItemSerial=ODD.intMatDetailID
						inner join was_washtype WW on ML.intWashType=WW.intWasID
						inner join was_shift SH on SH.intShiftId=ML.intShiftId	
						inner join was_machine WM on WM.intMachineId=ML.intMachineId	
						where ML.intStatus=1 AND ODD.intMainFabricStatus=1 ";
						
  
  					if($datefrom!= '' && $dateto!='' )
					$strSQL .= " AND date(ML.dtmOutDate) between '$datefrom' and '$dateto' ";
					
					if($PONo!= '')
					$strSQL .= " AND OD.strOrderNo='$PONo' ";
					
					if($color!= '')
					$strSQL .= " AND ML.strColor='$color' ";
					
					if($cboshiftid!= '')
					$strSQL .= " AND SH.intShiftId='$cboshiftid' ";
					
					if($washtype!= '')
					$strSQL .= " AND ML.intWashType='$washtype' ";
					
					$strSQL .= "group by ML.intStyleId,ML.intWashType,ML.strColor ";
			
			$result=$db->RunQuery($strSQL);
			
			while($row = mysql_fetch_array($result))
			{ 
		?>
				<tr>
				<td height="18" align="left" class="normalfntTAB9"><?PHP echo($row["strOrderNo"]);  ?></td>
				<td align="left" class="normalfntTAB9"><?PHP echo($row["strStyle"]);  ?></td>
				<td align="left" class="normalfntTAB9"><?PHP echo($row["strWasType"]);  ?></td>
				<td align="left" class="normalfntTAB9"><?PHP echo($row["strDescription"]);  ?></td>
				<td align="left" class="normalfntTAB9"><?PHP echo($row["strColor"]);  ?></td>
				<td align="left" class="normalfntTAB9"><?PHP echo($row["strItemDescription"]);  ?></td>
				<td align="right" class="normalfntTAB9"><?PHP $tot=$tot+$row["totqty"]; echo($row["totqty"]);  ?>&nbsp;</td>
				</tr>
		<?php
			}
		?>
        <tr>
    <td colspan="7" style="text-align:right" class="normalfntTAB9"><?php echo number_format($tot);?>&nbsp;</td>
  </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="7" style="text-align:right"><?php //echo number_format($tot);?>&nbsp;</td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td class="normalfnt">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
</table>

</body>
</html>
