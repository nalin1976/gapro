<?php
session_start();
include "../Connector.php";
$backwardseperator = '../';
	

$no			= explode('/',$_GET["No"]);
$PRNo		= $no[1];
$PRYear		= $no[0];
$value		= 0;
$tot		= 0;
$tot_qty    = 0;
$report_companyId = GetSavedFactory($PRYear,$PRNo);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Purchase Requisition Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="purchaserequisition.js" type="text/javascript"></script>
<body>

<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%"><table width="100%" border="0" cellspacing="10" cellpadding="0" class="border-All-fntsize10">
      <tr>
        <td><table width="100%" border="0" align="center" bgcolor="#FFFFFF">
            <tr>
              <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
                  <tr>
                    <td height="30" colspan="4" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="39" class="head2"><u>PURCHASE REQUISITION</u></td>
                          </tr>
                    </table></td>
                  </tr>
<?php
#=============================================================================================
# Comment     - 11/04/2013
# Description - Comment to remove the supplier & currency link
#=============================================================================================
/*$sql = "select PH.intPRNo, 
	PH.intPRYear, 
	PH.strPRNo, 
	SP.strTitle, 
	CT.strCurrency, 
	PH.dblCurrencyRate, 
	DP.strDepartment, 
	CP.strName, 
	UA.Name, 
	PH.dtmRequestDate, 
	PH.strAttension, 
	PH.strRemarks,
	PH.strJobNo, 
	PH.intStatus,
	(select U.Name from useraccounts U where U.intUserID=PH.intRequestBy)as PraparedBy,
	dtmRequestDate,
	(select U.Name from useraccounts U where U.intUserID=PH.intFirstApprovedBy)as FirstApprovedBy,
	intFirstApprovedDate,
	(select U.Name from useraccounts U where U.intUserID=PH.intSecondApprovedBy)as SecondApprovedBy,
	intSecondApprovedDate,
	dblDiscount,dblTotalValue,dblTotalPRValue,dblDiscountValue,
	CO.strDescription as CostCenter,
	PH.strCommonSupplierName
	from 
	purchaserequisition_header PH
	inner join department DP ON PH.intDepartmentId=DP.intDepID
	inner join suppliers SP ON PH.intSupplierId=SP.strSupplierID
	inner join currencytypes CT ON PH.intCurrencyId=CT.intCurID
	inner join useraccounts UA ON PH.intRequestBy=UA.intUserID
	inner join companies CP ON PH.intCompanyId=CP.intCompanyID
	inner join costcenters CO on CO.intCostCenterId=PH.intCostCenterId
	where PH.intPRNo='$PRNo' AND PH.intPRYear='$PRYear';";	*/
#=============================================================================================
# END
#=============================================================================================	

$sql = "select PH.intPRNo, 
	PH.intPRYear, 
	PH.strPRNo, 
	PH.dblCurrencyRate, 
	DP.strDepartment, 
	CP.strName, 
	UA.Name, 
	PH.dtmRequestDate, 
	PH.strAttension, 
	PH.strRemarks,
	PH.strJobNo, 
	PH.intStatus,
	(select U.Name from useraccounts U where U.intUserID=PH.intRequestBy)as PraparedBy,
	dtmRequestDate,
	(select U.Name from useraccounts U where U.intUserID=PH.intFirstApprovedBy)as FirstApprovedBy,
	intFirstApprovedDate,
	(select U.Name from useraccounts U where U.intUserID=PH.intSecondApprovedBy)as SecondApprovedBy,
	intSecondApprovedDate,
	dblDiscount,dblTotalValue,dblTotalPRValue,dblDiscountValue,
	CO.strDescription as CostCenter,
	PH.strCommonSupplierName
	from 
	purchaserequisition_header PH
	inner join department DP ON PH.intDepartmentId=DP.intDepID
	inner join useraccounts UA ON PH.intRequestBy=UA.intUserID
	inner join companies CP ON PH.intCompanyId=CP.intCompanyID
	inner join costcenters CO on CO.intCostCenterId=PH.intCostCenterId
	where PH.intPRNo='$PRNo' AND PH.intPRYear='$PRYear';";
	
	
	
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$status					= $row["intStatus"];	
	$currency 				= $row["strCurrency"];
	$praparedBy				= $row["PraparedBy"];
	$firstApprovedBy		= $row["FirstApprovedBy"];
	$secondApprovedBy		= $row["SecondApprovedBy"];
	$requestDate			= $row["dtmRequestDate"];
	$firstApprovedDate		= $row["intFirstApprovedDate"];
	$secondApprovedDate		= $row["intSecondApprovedDate"];
	$discount				= $row["dblDiscount"];
	$totalValue				= $row["dblTotalValue"];
	$totalPRValue			= $row["dblTotalPRValue"];
	$discountValue			= $row["dblDiscountValue"];
	$costCenter				= $row["CostCenter"];
	$supplier				= ($row["strCommonSupplierName"] == ''?$row["strTitle"]:$row["strCommonSupplierName"]);
?>
	<tr>
		<td height="24" align="left" class="normalfnBLD1"><span class="normalfnt">Cost Center</span></td>
		<td width="50%" class="normalfnt">:  <?php echo $costCenter?></td>
		<td width="9%" class="normalfnt">&nbsp;</td>
		<td width="30%" class="normalfnt">&nbsp;</td>
	</tr>
	<tr>
		<td height="24" align="left" class="normalfnt">PR No</td>
		<td colspan="3" class="normalfnt">: <?php echo $row["strPRNo"]; ?></td>
	</tr>
	<tr>
		<td height="24" align="left" class="normalft">PR Date</td>
		<td colspan="3" class="normalfnt">: <?php echo $row["dtmRequestDate"]; ?></td>
	</tr>
	<tr>
		<td height="24" align="left" class="normalfnt">Job No</td>
		<td colspan="3" class="normalfnt">: <?php echo $row["strJobNo"]; ?></td>
	</tr>
	<tr>
		<td height="24" align="left" class="normalfnt">Requested By</td>
		<td colspan="3" class="normalfnt">: <?php echo $row["Name"]; ?></td>
	</tr>
	<tr>
		<td height="24" align="left" class="normalfnt">Department</td>
		<td colspan="3" class="normalfnt">: <?php echo $row["strDepartment"]; ?></td>
	</tr>
	<!--<tr>
		<td height="24" align="left" class="normalft">Supplier</td>
		<td colspan="3" class="normalfnt">: <?php echo $supplier; ?></td>
	</tr>-->
	<tr>
		<td height="24" align="left" class="normalfnt">Attention</td>
		<td colspan="3" class="normalfnt">: <?php echo $row["strAttension"]; ?></td>
	</tr>
	<tr>
		<td height="24" align="left" class="normalfnt">Remarks</td>
		<td colspan="3" class="normalfnt">: <?php echo $row["strRemarks"]; ?></td>
	</tr>
	<!--<tr>
		<td width="11%" height="24" align="left" class="normalfnt">Currency</td>
		<td colspan="3" class="normalfnt">: <?php echo $currency; ?></td>
	</tr>-->
	</table></td>
	</tr>
<?php
}	
?>
            <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000" id="tblItems">
			  <thead>
                  <tr bgcolor="#CCCCCC" class="normalfntMid">
                    <th width="6%" height="25" >Item Code</th>
                    <th width="60%" >Item Description</th>
                    <th width="5%" >Unit</th>
                    <th width="8%" >Unit Price <br/>(<?php echo $currency;?>)</th>
                    <th width="9%" >Qty</th>
                    <!--<th width="7%" >Value <br/>(<?php echo $currency;?>)</th>
                    <th width="7%" >Dis<br/>%</th>
                    <th width="5%" >Final Value (<?php echo $currency;?>)</th>
                    <th width="5%" >Assest <br/>YES/No</th>-->
                  </tr>
				 </thead>
<?php
$sql_detail =" select PD.intPRNo, PD.intPRYear, PD.intMatDetailId, GM.strItemDescription, PD.strUnit, PD.dblUnitPrice, PD.dblQty, PD.dblValue ,PD.intAssest, PD.dblDiscount, PD.dblFinalValue,strRemarks 
from purchaserequisition_details PD 
inner join genmatitemlist GM ON PD.intMatDetailId=GM.intItemSerial 
where PD.intPRNo='$PRNo' AND PD.intPRYear='$PRYear' 
order by PD.intMatDetailId ;";
$result_detail=$db->RunQuery($sql_detail);
while($row_detail = mysql_fetch_array($result_detail))
{
	if($row_detail["strRemarks"]== "")
		$desc		= $row_detail["strItemDescription"];
	else
		$desc		= $row_detail["strItemDescription"].'-'.$row_detail["strRemarks"];
?>
                  <tr class="bcgcolor-tblrowWhite">
                    <td height="20" class="normalfntMid"><?php echo $row_detail["intMatDetailId"]; ?></td>
                    <td align="left" class="normalfnt"><?php echo $desc; ?></td>
                    <td align="center" class="normalfnt"><?php echo $row_detail["strUnit"]; ?></td>
                    <td align="right" class="normalfntRite"><?php echo $row_detail["dblUnitPrice"]; ?></td>
                    <td align="right" class="normalfntRite"><?php echo $row_detail["dblQty"]; ?>&nbsp;</td>
                  <!--  <td align="right" class="normalfntRite"><?php echo $row_detail["dblValue"] ; ?></td>
                    <td align="right" class="normalfntRite"><?php echo $row_detail["dblDiscount"];?></td>
                    <td align="right" class="normalfntMid"><?php echo $row_detail["dblFinalValue"] ; ?></td>
                    <td align="right" class="normalfntMid"><?php echo ($row_detail["intAssest"]=='1' ? 'YES':'No'); ?></td>-->
                  </tr>
				  <?php
				  $tot_qty += $row_detail["dblQty"];
				  $tot+=$value;     
			}
		?>
              </table></td>
            </tr>
            <tr>
              <td><table width="100%" height="67" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="20" width="66%">&nbsp;</td>
                    <td width="0%"></td>
                    <td width="19%" align="right">&nbsp;<strong>Total</strong></td>
                    <td width="15%" class="normalfntRite"><b><?php echo number_format($tot_qty); ?>&nbsp;</b></td>
                  </tr>
                 <!-- <tr>
                    <td height="20">&nbsp;</td>
                    <td width="17%">Discount</td>
                    <td width="5%" class="normalfntRite"><?php echo $discount?>&nbsp;</td>
                    <td class="normalfntRite"><b><?php echo number_format($discountValue,4)?>&nbsp;</b></td>
                  </tr>
                  <tr>
                    <td height="20">&nbsp;</td>
                    <td class="normalfnt"><b>PR Value (<?php echo $currency;?>)</b></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfntRite"><b><?php echo number_format($totalPRValue,4)?>&nbsp;</b></td>
                  </tr>-->
                </table>                               
              </td>
            </tr>
         <!--   <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="1" id="tblItems" bgcolor="#000000">
                  <tr bgcolor="#CCCCCC" class="normalfntMid">
                    <th width="6%" height="25"> GL Code</th>
                    <th width="19%" >Account Description</th>
                    <th width="9%" >Budget</th>
                    <th width="11%" >Additional</th>
                    <th width="11%" >Transfer</th>
                    <th width="10%" >Total Budget</th>
                    <th width="10%" >Actual</th>
                    <th width="9%" >Budget Varience</th>
                    <th width="8%" >Requested</th>
                    <th width="7%" >Current Budget</th>
                  </tr> -->
<?php
$sql="select PRGD.intMainCatId,PRGD.intGLAllowId,G.strAccID,C.strCode,G.strDescription,PRGD.dblCurrentBudget,MONTH(dtmCreatedDate)as createMonth,YEAR(dtmCreatedDate)as createYear
from purchaserequisition_gldetails PRGD 
inner join purchaserequisition_header PRH on PRH.intPRNo=PRGD.intPRNo and PRH.intPRYear=PRGD.intPRYear
inner join glallowcation GA on GA.GLAccAllowNo=PRGD.intGLAllowId 
inner join glaccounts G on G.intGLAccID=GA.GLAccNo 
inner join costcenters C on C.intCostCenterId=GA.FactoryCode  
where PRGD.intPRNo='$PRNo' and PRGD.intPRYear='$PRYear';";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
/* BEGIN - cannot take current year & month , I took month & year from PR crated date.
$year 	= date("Y");
$month 	= date("m");
END - cannot take current year & month , I took month & year from PR crated date. */
$year 	= $row["createYear"];
$month 	= $row["createMonth"];

$amount		  = GetBudgetAmount($row["intGLAllowId"],$year,$month);
?>
            <!--      <tr class="bcgcolor-tblrowWhite">
                    <td height="20" class="normalfnt"><?php echo CreateGlCode($row["strAccID"],$row["strCode"])?></td>
                    <td align="left" class="normalfnt"><?php echo $row["strDescription"];?></td>
                    <td align="right" class="normalfntRite"><?php echo $amount[0]?></td>
                    <td align="right" class="normalfntRite"><?php echo $amount[1];?></td>
                    <td align="right" class="normalfntRite"><?php echo $amount[2];?></td>
                    <td align="right" class="normalfntRite"><?php echo $amount[3];?></td>
                    <td align="right" class="normalfntRite"><?php echo $amount[4];?></td>
                    <td align="right" class="normalfntRite"><?php echo ($amount[3]-$amount[4]);?></td>
                    <td align="right" class="normalfntRite"><?php echo $row["dblCurrentBudget"];?></td>
                    <td align="right" class="normalfntRite"><?php echo $amount[5];?></td>
                  </tr> -->
<?php
}
?>
              </table></td>
            </tr>
             <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="45" height="20">&nbsp;</td>
                    <td width="202" class="bcgl1txt1"><?php echo $praparedBy;?></td>
                    <td width="62">&nbsp;</td>
                    <td width="202" class="bcgl1txt1"><?php echo $firstApprovedBy;?></td>
                    <td width="62">&nbsp;</td>
                    <td width="202" class="bcgl1txt1"><?php echo $secondApprovedBy;?></td>
                    <td width="45">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20">&nbsp;</td>
                    <td class="normalfntMid">Prepaired By</td>
                    <td>&nbsp;</td>
                    <td class="normalfntMid">Checked By</td>
                    <td>&nbsp;</td>
                    <td class="normalfntMid">Approved By</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20">&nbsp;</td>
                    <td class="normalfntMid"><?php echo $requestDate;?></td>
                    <td>&nbsp;</td>
                    <td class="normalfntMid"><?php echo $firstApprovedDate;?></td>
                    <td>&nbsp;</td>
                    <td class="normalfntMid"><?php echo $secondApprovedDate;?></td>
                    <td>&nbsp;</td>
                  </tr>
                  
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
function CreateGlCode($glId,$facid)
{
	return $glId."-".$facid;
}

function GetBudgetAmount($glAlloNo,$year,$month)
{
global $db;
$amount = array();
	$sql = "select COALESCE((select sum(dblQty) from budget_transaction where  strType='bgtmod' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as modAmount,
COALESCE((select sum(dblQty) from budget_transaction where  strType='bgtAddi' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as addAmount,
COALESCE((select sum(dblQty) from budget_transaction where  strType='bgttransin' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as transInAmount,
COALESCE((select sum(dblQty) from budget_transaction where intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month'
group by intGLNO,intBudgetYear,intBudgetMonth),0) as balAmount,
COALESCE((select sum(dblActual) from budget_modification_details where intYear='$year' and intMonth='$month' and intAlloGLNo=$glAlloNo),0)as actualAmount,
COALESCE((select sum(dblQty) from budget_transaction where strType='bgtPR' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as requested;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$amount[0] = $row["modAmount"];
		$amount[1] = $row["addAmount"];
		$amount[2] = $row["transInAmount"];
		$amount[3] = $row["balAmount"];
		$amount[4] = $row["actualAmount"];
		$amount[5] = abs($row["requested"]);
	}
return $amount;
}

function  GetSavedFactory($PRYear,$PRNo)
{
	global $db;
	$sql="select intCompanyId from purchaserequisition_header where intPRNo='$PRNo' and intPRYear='$PRYear'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intCompanyId"];
}
?>
<?php if($status=='0' || $status=='1' || $status=='2') { ?>
	<div style="position:absolute;top:100px;left:300px;"><img src="../images/pending.png"></div>
<?php }elseif($status=='10'){ ?>
	<div style="position:absolute;top:200px;left:400px;"><img src="../images/cancelled.png"></div>
<?php } ?>