<?php
session_start();
include "../../Connector.php";	
$backwardseperator = "../../";
$report_companyId 	= $_SESSION["FactoryID"];
//include "../../authentication.inc";

$chkNotInspect	= $_GET["NotInspect"];
$cboOrderNo		= $_GET["OrderNo"];
$cboGrnNo		= $_GET["GrnNo"];
$cboGrnNoArray	= explode('/',$cboGrnNo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Trim Inspection Listing</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="triminspectlist.js"></script>
<script type="text/javascript" src="../../javascript/script.js" ></script>
</head>
<style type="text/css">
.Approved{
	color:#009900;
	font-size:12px;
	font-weight:bold
}
.Reject{
	color:#FF0000;
	font-size:12px;
	font-weight:bold;
}
</style>
<form name="frmTrimInspectList" id="frmTrimInspectList" method="post" action="triminspectlist.php">
  <tr>
     <?php include $backwardseperator.'reportHeader.php'; ?>
  </tr>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" class="normalfnt_Header">Trim Inspection Listing </td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
      <tr>
        <td >&nbsp;</td>
        </tr>
      <tr>
        <td>
          <table id="tblTrimInspectionGrn" width="100%" cellpadding="0" cellspacing="1" bgcolor="#000000">
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <td width="3%">GRN No </td>
              <td width="6%" height="25" >Style No</td>
              <td width="6%" >OrderNo</td>
              <td width="7%" >Style Name</td>
              <td width="12%" >Item Description</td>
              <td width="4%" >Color</td>
              <td width="4%" >Size</td>
              <td width="3%" >Unit</td>
              <td width="5%" >Qty</td>
              <td width="4%" >Approved</td>
              <td width="4%" >Approve Qty</td>
              <td width="4%" >Approve Remarks&nbsp;</td>
              <td width="3%" >Rejected</td>
              <td width="2%" >Reject Qty</td>
              <td width="4%" >Reject Reason&nbsp;</td>
              <td width="4%" nowrap="nowrap" >SP <br /> Approved</td>
              <td width="4%" nowrap="nowrap" >SP Approved<br />Qty</td>
              <td width="4%" nowrap="nowrap" >SP Approved<br />Reason</td>
              <td width="4%" >Saved By </td>
              <td width="4%" >Saved Date </td>
              <td width="2%" >Approved By </td>
              <td width="2%" >Approved Date </td>
              <td width="2%" nowrap="nowrap" >SP Approve<br />
               Confirm By</td>
              <td width="2%" nowrap="nowrap" >SP Approve<br />
                Confirm Date</td>
              </tr>
<?php
$sql="select concat(GH.intGRNYear,'/',GH.intGrnNo)as grnNo,O.strStyle,O.strOrderNo,O.strDescription,MIL.strItemDescription,GD.strColor,GD.strSize,PD.strUnit,GD.dblQty,
GD.intInspApproved,
(select Name from useraccounts UA where UA.intUserID=GD.intTrimIBy)as trimInsPectBy,GD.strComment,
GD.intApprovedQty,GD.intReject,GD.intRejectQty,GD.strReason,
(select Name from useraccounts UA where UA.intUserID=GD.intTrimIConfirmBy)as trimInsConfirmBy,
GD.dtmTrimIDate,GD.intTrimIConfirmDate,MSC.intInspection,GD.intSpecialApp,GD.strSpecialAppReason,GD.intSpecialAppQty,
(select Name from useraccounts UA where UA.intUserID=GD.intSATrimIConfirmBy)as SAConfirmedBy,GD.intSATrimIConfirmDate 
from grnheader GH 
inner join grndetails GD on GD.intGrnNo=GH.intGrnNo
inner join orders O on O.intStyleId=GD.intStyleId
inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
inner join purchaseorderdetails PD on PD.intYear=GH.intYear and PD.intPoNo=GH.intPoNo and PD.intStyleId=GD.intStyleId and PD.intMatDetailID=GD.intMatDetailID and PD.strColor=GD.strColor and PD.strSize=GD.strSize and PD.strBuyerPONO=GD.strBuyerPONO 
where GH.intStatus=1 ";
if($chkNotInspect=='false')
	$sql .= "and MSC.intInspection=1 ";
if($cboOrderNo!="")
	$sql .= "and O.intStyleId='$cboOrderNo' ";
if($cboGrnNo!="")
	$sql .= "and GH.intGRNYear='$cboGrnNoArray[0]' and GH.intGrnNo='$cboGrnNoArray[1]' ";
	
$sql .= "order by grnNo,O.strOrderNo,MIL.strItemDescription,GD.strColor,GD.strSize";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
$className = "bcgcolor-tblrowWhite";
	if($row["intInspection"]=='0')
		$className = "bcgcolor-InvoiceCostTrim";
?>
            <tr class="<?php echo $className;?>" >
              <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["grnNo"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDescription"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblQty"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="Approved"><?php echo ($row["intInspApproved"]=='1' ? '&radic;':'-')?></span></td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo ($row["intInspApproved"]=='1' ? $row["intApprovedQty"]:'-')?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strComment"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfntMid"><span class="Reject"><?php echo ($row["intReject"]=='1' ? '&times;':'-')?></span></td>
              <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo ($row["intReject"]=='1' ? $row["intRejectQty"]:'-')?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strReason"];?>&nbsp;</td>
               <td nowrap="nowrap" class="normalfntMid"><span class="Approved"><?php echo ($row["intSpecialApp"]=='1' ? '&radic;':'-')?></span></td>
              <td nowrap="nowrap" class="normalfntRite"><?php echo ($row["intSpecialApp"]=='1' ? $row["intSpecialAppQty"]:'-')?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSpecialAppReason"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["trimInsPectBy"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["dtmTrimIDate"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["trimInsConfirmBy"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["intTrimIConfirmDate"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["SAConfirmedBy"];?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["intSATrimIConfirmDate"];?>&nbsp;</td>
              </tr>
<?php
}
?>
          </table>        </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
