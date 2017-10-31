<?php	
	session_start();
	include "../Connector.php";
	$IssueNo	= $_GET["issueNo"];
	
		$issueNoArray	= explode('/',$IssueNo);
	$issueNo	= $issueNoArray[1];
	$issueYear	= $issueNoArray[0];
	$companyId	= $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ePlan Web - Fabric Roll Loading Slip - Issue</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<style>
.blackBorder {
	border: 1px solid #000000;
}
</style>
<body >
<table width="900"  border="0" cellpadding="0" cellspacing="0" class="blackBorder">
  <tr>
    <td height="10" colspan="14"><div align="center" class="normalfnt2bldBLACKmid" >HELA CLOTHING (PVT) LTD </div></td>
  </tr>
  <tr>
    <td height="10" colspan="7" class="topheadBLACK">&nbsp;LOADING SLIP</td>
    <td height="10" colspan="7" class="normalfnth2Bm">&nbsp;Company Batch:- </td>
  </tr>
<?php
	$sql_stores="select strMainID,strName from mainstores where intCompanyId='$companyId';";
	
	$result_stores=$db->RunQuery($sql_stores);
	$row_stores = mysql_fetch_array($result_stores);
	$storesName = $row_stores["strName"];
	$storesID	= $row_stores["strMainID"];
?>
  <tr>
    <td height="10" colspan="7" class="normalfnth2B">&nbsp;&nbsp;Stores:- <?php echo $storesName;?> </td>
    <td colspan="7">&nbsp;</td>
  </tr>
<?php
$sql_mrn="select distinct intMatReqYear,intMatRequisitionNo from fabricrollissuedetails 
where intIssueNo='$issueNo'
and intIssueYear='$issueYear'";

$result_mrn=$db->RunQuery($sql_mrn);
while($row_mrn=mysql_fetch_array($result_mrn))
{
?>
  <tr>
    <td height="10" colspan="5" class="normalfnth2B">&nbsp;&nbsp;Issue No:- <?php echo $issueYear.'/'.$issueNo;?></td>
    <td colspan="4"  ><div align="center" class="normalfnth2Bm">MRN No:-<?php echo $row_mrn["intMatReqYear"].'/'.$row_mrn["intMatRequisitionNo"];?></div></td>
    <td colspan="5"  ><div align="center" class="normalfntMid">Loading Slip No:- </div></td>
  </tr>
  <tr>
    <td height="10" colspan="5" class="border-bottom">&nbsp;</td>
    <td colspan="4"  class="border-bottom">&nbsp;</td>
    <td colspan="5" class="border-bottom"  >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" class="normalfnt">Roll</td>
    <td class="normalfnt">Hemas</td>
    <td class="normalfnt">Supp</td>
    <td class="normalfnt">Company</td>
    <td class="normalfnt">Width</td>
    <td class="normalfnt">Supp</td>
    <td class="normalfnt">Company</td>
    <td class="normalfnt">Weight</td>
    <td class="normalfnt">Company</td>
    <td class="normalfnt">Length</td>
    <td class="normalfnt">Issued</td>
    <td class="normalfnt">Inspection</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td height="10"  class="border-bottom">No</td>
    <td  class="border-bottom">&nbsp;</td>
    <td  class="border-bottom">Width</td>
    <td  class="border-bottom">Width</td>
    <td  class="border-bottom">UOM</td>
    <td  class="border-bottom">Weight</td>
    <td  class="border-bottom">Weight</td>
    <td  class="border-bottom">UOM</td>
    <td  class="border-bottom">Length</td>
    <td  class="border-bottom">&nbsp;</td>
    <td  class="border-bottom"><div align="center">Qty</div></td>
    <td  class="border-bottom">Comments</td>
    <td  class="border-bottom">&nbsp;</td>
    <td  class="border-bottom">&nbsp;</td>
  </tr>
  <?php	
$strStyle="select distinct FID.intStyleId ,FID.strColor,FRH.intSupplierBatchNo
from fabricrollissuedetails  FID
inner join fabricrollheader FRH ON FID.intFRollSerialNO=FRH.intFRollSerialNO AND FID.intFRollSerialYear=FRH.intFRollSerialYear
where intIssueNo='$issueNo' 
AND intIssueYear ='$issueYear';";
 
	$sqlResultsStyle=$db->RunQuery($strStyle);
   
  while($StyleRow=mysql_fetch_array($sqlResultsStyle))
    {
		$sctotal=0;
?>
    <tr>
    <td height="10" colspan="7"class="normalfnth2B">&nbsp;&nbsp;SC No:-<?php echo $StyleRow["intStyleId"];?></td>
    <td ><div class="normalfnth2B"></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
    <tr>
      <td height="10" colspan="7"class="normalfnth2B">&nbsp;&nbsp;Color:-<?php echo $StyleRow["strColor"];?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
  <tr>
    <td height="10" colspan="7"class="normalfnth2B">&nbsp;&nbsp;Supp. Batch No:-<?php echo $StyleRow["intSupplierBatchNo"];?></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
   <?php 
	$serial=$StyleRow["intFRollSerialNO"];
   	$year=$issuedRow["intFRollSerialYear"]; 
   	$strIssue="select FID.intRollNo, 
	dblSuppWidth, 
	dblCompWidth, 
	strWidthUOM, 
	dblSuppLength, 
	dblCompLength, 
	strLengthUOM, 
	dblSuppWeight, 
	dblCompWeight, 
	strWeightUOM, 
	dblQty, 
	dblBalQty, 
	strSpecialComments,
	FID.dblIssueQty
	from 
	fabricrolldetails FRD
	inner join fabricrollissuedetails FID on FID.intFRollSerialNO=FRD.intFRollSerialNO and FID.intFRollSerialYear=FRD.intFRollSerialYear and FID.intRollNo=FRD.intRollNo
	INNER JOIN fabricrollheader FRH on FRH.intFRollSerialNO=FRD.intFRollSerialNO and  FRH.intFRollSerialYear=FRD.intFRollSerialYear
	where FID.intIssueNo='$issueNo' 
	and FID.intIssueYear='$issueYear'
	AND FID.strColor='".$StyleRow["strColor"]."'
	AND FID.intStyleId='".$StyleRow["intStyleId"]."'
	AND FRH.intSupplierBatchNo='".$StyleRow["intSupplierBatchNo"]."';";

   $IssueResults=$db->RunQuery($strIssue);
   
   while($issueDetailRow=mysql_fetch_array($IssueResults))
    {
		$total+=$issueDetailRow['dblIssueQty'];
		$sctotal+=$issueDetailRow['dblIssueQty'];
	?>
   
  <tr>
    <td height="10" class="border-bottom">&nbsp;<?php echo $issueDetailRow["intRollNo"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["intRollNo"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["dblSuppWidth"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["dblCompWidth"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["strWidthUOM"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["dblSuppWeight"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["intRollNo"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["strWeightUOM"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["dblCompLength"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["strLengthUOM"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["dblIssueQty"];?></td>
    <td class="border-bottom">&nbsp;<?php echo $issueDetailRow["strSpecialComments"];?></td>
    <td class="border-bottom">&nbsp;</td>
    <td class="border-bottom">&nbsp;</td>
  </tr>
  <?php 
  	}
  ?>
  
  <tr>
    <td height="10">&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td class="normalfnth2B">&nbsp;</td>
    <td colspan="2" class="normalfnth2B">&nbsp;Supp.Batch Total</td>
    <td class="normalfnth2B">&nbsp;&nbsp;<?php echo $total;?></td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
    <tr>
    <td height="10">&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td colspan="2" class="normalfnth2B">&nbsp;Color Total</td>
    <td class="normalfnth2B">&nbsp;&nbsp;<?php echo $total;?></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <?php 
  }
  ?>

  <tr>
    <td height="10">&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td colspan="2"class="normalfnth2B">&nbsp;SC total </td>
    <td class="normalfnth2B">&nbsp;&nbsp;<?php echo $sctotal;?></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td width="64" height="10">&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
  </tr>
<?php
}
?>
</table>

</body>
</html>
