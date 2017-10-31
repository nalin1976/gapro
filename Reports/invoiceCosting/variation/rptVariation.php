<?php
session_start();
include '../../../Connector.php';
$orderId	= $_GET["OrderId"];
$revisionNo	= $_GET["RevisionNo"];
$deci	= 4;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro | Variation Report</title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.4.2.min.js"></script>
<style type="text/css">
table.fixHeader {
	border: solid #FFFFFF;
	border-width: 1px 1px 1px 1px;
	width: 1050px;
}

tbody.ctbody {
	height: 580px;
	overflow-y: auto;
	overflow-x: hidden;
}
</style>
</head>
<body>
<?php
$sql_header="select (select UA.Name from useraccounts UA where UA.intUserID=ICH.intUserId)as preparedBy,
			dtmDate as preparedDate,
			ICH.dblTotalCostValue,
			(select UA.Name from useraccounts UA where UA.intUserID=ICH.intConfirmBy)as confirmedBy,
			intConfirmDate as confirmedDate,
			(select UA.Name from useraccounts UA where UA.intUserID=ICH.intRevisedBy)as revisedBy,
			dtmRevisedDate as revisedDate,
			(SELECT  HICH.dblTotalCostValue FROM history_invoicecostingheader HICH  WHERE HICH.intStyleId='$orderId' AND HICH.intApprovalNo='$revisionNo')as history_costvalue
			from invoicecostingheader ICH
			where 
			ICH.intStyleId='$orderId'";
$result_header		=$db->RunQuery($sql_header);
$row_header			=mysql_fetch_array($result_header);
$history_costvalue	=$row_header["history_costvalue"];
$costvalue			=$row_header["dblTotalCostValue"];
//echo $sql_header;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="7" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td colspan="7"><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" id="tblMain">
	<thead>
      <tr bgcolor="#CCCCCC">
        <th height="25" colspan="4" class="normalfntMid" scope="col">&nbsp;</th>
        <th height="25" colspan="5" class="normalfntMid" scope="col">REVISION NO : <?php echo $revisionNo?></th>
        <th colspan="6" class="normalfntMid" scope="col">WORKING COPY </th> 
        </tr>
      <tr bgcolor="#CCCCCC">
        <th width="2%" height="25" scope="col" class="normalfntMid">No</th>
        <th width="22%" class="normalfntMid">Description</th>
        <th width="4%"  class="normalfntMid">Origin</th>
        <th width="4%" class="normalfntMid">Unit</th>
        <th width="6%" class="normalfntMid">CON Per Doz</th>
        <th width="7%" class="normalfntMid">Unit Price Per Pcs</th>
        <th width="6%" class="normalfntMid">Wastage</th>
        <th width="5%" class="normalfntMid">Finance</th>
        <th width="6%" class="normalfntMid">Value</th>
        <th width="6%" class="normalfntMid">CON Per Doz</th>
        <th width="8%" class="normalfntMid">Unit Price Per Pcs</th>
        <th width="6%" class="normalfntMid">Wastage</th>
        <th width="6%" class="normalfntMid">Finance</th>
        <th width="8%" class="normalfntMid">Value</th>
        <th width="4%" class="normalfntMid">&nbsp;</th>
      </tr>
	  </thead>
	  <tbody class="ctbody">
<?php
$sql="(select MIL.intMainCatID,MIL.intItemSerial,MIL.strItemDescription,HICD.reaConPc as his_reaConPc,
	HICD.dblUnitPrice as his_dblUnitPrice,HICD.reaWastage as his_reaWastage,
	HICD.dblFinance as his_dblFinance,
	HICD.dblValue as his_dblValue,
	ICD.reaConPc,
	ICD.dblUnitPrice,
	ICD.reaWastage,
	ICD.dblFinance,
	ICD.dblValue
	from invoicecostingheader ICH 
	inner join 
	invoicecostingdetails ICD on ICD.intStyleId=ICH.intStyleId
	left join 
	history_invoicecostingdetails HICD on HICD.intStyleId=ICH.intStyleId and HICD.strItemCode=ICD.strItemCode
	inner join 
	matitemlist MIL on MIL.intItemSerial=ICD.strItemCode
	where ICH.intStyleId=$orderId and HICD.intApprovalNo=$revisionNo)
	union
	(select MIL.intMainCatID,
	MIL.intItemSerial,
	MIL.strItemDescription,
	HICD.reaConPc as his_reaConPc,
	HICD.dblUnitPrice as his_dblUnitPrice,
	HICD.reaWastage as his_reaWastage,
	HICD.dblFinance as his_dblFinance,
	HICD.dblValue as his_dblValue,	
	ICD.reaConPc,
	ICD.dblUnitPrice,
	ICD.reaWastage,
	ICD.dblFinance,
	ICD.dblValue
	from invoicecostingheader ICH 
	inner join
	history_invoicecostingdetails HICD on HICD.intStyleId=ICH.intStyleId
	left join
	invoicecostingdetails ICD on HICD.intStyleId=ICD.intStyleId and HICD.strItemCode=ICD.strItemCode
	inner join 
	matitemlist MIL on MIL.intItemSerial=HICD.strItemCode
	where ICH.intStyleId=$orderId and HICD.intApprovalNo=$revisionNo)
	order by intMainCatID,strItemDescription";
	
	//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$bgColor						= '#FFFFFF';
	
	$conPCFontColor					= '#000000';
	$unitPriceFontColor				= '#000000';
	$wastageFontColor				= '#000000';
	$financeFontColor				= '#000000';
	$valueFontColor					= '#000000';
	
	$conPC							= round($row["reaConPc"],$deci);
	$unitPrice						= round($row["dblUnitPrice"],$deci);
	$wastage						= round($row["reaWastage"],$deci);
	$finance						= round($row["dblFinance"],$deci);
	$value							= round($row["dblValue"],$deci);
	
	$his_ConPC						= round($row["his_reaConPc"],$deci);
	$his_UnitPrice					= round($row["his_dblUnitPrice"],$deci);
	$his_Wastage					= round($row["his_reaWastage"],$deci);
	$his_Finance					= round($row["his_dblFinance"],$deci);
	$his_Value						= round($row["his_dblValue"],$deci);
	
	if($conPC!=$his_ConPC)
	{
		$conPCFontColor		= '#FF0000';
	}
	if($unitPrice!=$his_UnitPrice)
	{
		$unitPriceFontColor		= '#FF0000';
	}
	if($wastage!=$his_Wastage)
	{
		$wastageFontColor		= '#FF0000';
	}
	if($finance!=$his_Finance)
	{
		$financeFontColor		= '#FF0000';
	}
	if($value!=$his_Value)
	{
		$valueFontColor		= '#FF0000';
	}

	if($row["his_reaConPc"]=="")
	{
		$bgColor = '#00FF00';
	}
	if($row["reaConPc"]=="")
	{
		$bgColor = '#FF0909';
	}

?>
      <tr bgcolor="#FFFFFF">
        <td height="20" class="normalfntRite"><?php echo ++$i.'.';?></td>
        <td nowrap="nowrap" class="normalfnt" id="<?php echo $row["intItemSerial"];?>"><?php echo $row["strItemDescription"];?></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strOriginType"]?></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strUnit"]?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo $his_ConPC=="" ? "":number_format($his_ConPC,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo $his_UnitPrice=="" ? "":number_format($his_UnitPrice,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo $his_Wastage=="" ? "":number_format($his_Wastage,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo $his_Finance=="" ? "":number_format($his_Finance,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo $his_Value=="" ? "":number_format($his_Value,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $bgColor?>"  style="color:<?php echo $conPCFontColor?>"><?php echo $conPC=="" ? "":number_format($conPC,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $bgColor?>" style="color:<?php echo $unitPriceFontColor?>"><?php echo $unitPrice=="" ? "":number_format($unitPrice,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $bgColor?>" style="color:<?php echo $wastageFontColor?>"><?php echo $wastage=="" ? "":number_format($wastage,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $bgColor?>" style="color:<?php echo $financeFontColor?>"><?php echo $finance=="" ? "":number_format($finance,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $bgColor?>" style="color:<?php echo $valueFontColor?>"><?php echo $value=="" ? "":number_format($value,$deci)?></td>
        <td nowrap="nowrap" class="normalfntRite" bgcolor="<?php echo $bgColor?>" style="color:<?php echo $invoUnitPriceFontColor?>">&nbsp;</td>
      </tr>
<?php
}
?>
      <tr bgcolor="#FFFFFF">
        <td height="20" colspan="15" class="normalfntRite">&nbsp;</td>
        </tr>
      <tr bgcolor="#FFFFFF">
        <td height="20" class="normalfntRite">&nbsp;</td>
        <td height="20" colspan="7" class="normalfnt"><strong>&nbsp;Total Cost per piece</strong></td>
        <td height="20" class="normalfntRite"><?php echo $his_Value=="" ? "":number_format($history_costvalue,$deci)?></td>
        <td height="20" colspan="4" class="normalfntRite">&nbsp;</td>
        <td height="20" class="normalfntRite"><?php echo $his_Value=="" ? "":number_format($costvalue,$deci)?></td>
        <td height="20" class="normalfntRite">&nbsp;</td>
      </tr>
<tr class="bcgcolor-tblrowWhite">
          <td colspan="15" class="normalfnt" nowrap="nowrap" >&nbsp;</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="7" >&nbsp;</td>
  </tr>
  <tr>
    <td width="5%" >&nbsp;</td>
    <td width="26%" class="normalfntMid txtbox"><?php echo $row_header["preparedBy"] ?></td>
    <td width="7%">&nbsp;</td>
    <td width="26%" class="normalfntMid txtbox"><?php echo $row_header["confirmedBy"] ?></td>
    <td width="7%">&nbsp;</td>
    <td width="24%" class="normalfntMid txtbox"><?php echo $row_header["revisedBy"] ?></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfntMid">Prepared By </td>
    <td>&nbsp;</td>
    <td class="normalfntMid">Confirmed By </td>
    <td>&nbsp;</td>
    <td class="normalfntMid">Revised By (Revision No : <?php echo $revisionNo?>) </td>
    <td class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfntMid"><?php echo $row_header["preparedDate"]?></td>
    <td >&nbsp;</td>
    <td class="normalfntMid"><?php echo $row_header["confirmedDate"]?></td>
    <td >&nbsp;</td>
    <td class="normalfntMid"><?php echo $row_header["revisedDate"]?></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
</table>
</body>
</html>
