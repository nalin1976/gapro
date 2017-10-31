<?php
	session_start();
	include "../../Connector.php" ;

	$backwardseperator  = "../../";
	$strStyleNo			= $_GET["strStyleNo"];
	$strBPo				= $_GET["strBPo"];
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$intBuyer 	  		= $_GET["intBuyer"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$intCompany    		= $_GET["intCompany"];
	$poNoFrom			= $_GET["noFrom"];
	$poNoTo				= $_GET["noTo"];
	$intStatus 			= $_GET["status"];
	$txtMatItem			= $_GET["txtMatItem"];
	if($intCompany != '')
		$report_companyId =$intCompany;
	else
		$report_companyId =$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Style Reports :: Issue Details</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-size: 12pt}
.style2 {font-size: 14pt}
-->
</style>
</head>


<body>
<table width="1000" border="0" align="center" cellpadding="0">
  <tr>
    <td colspan="5"><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("ISSUES REGISTER.")?></td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==10) $listType="(PENDING LIST)";					 
		else $listType="(CANCELED LIST)"; 		
		echo $listType;
	?></td>
  </tr> 
  	<?php
# ===============================================================================================  	 	
// Comment On - 05/05/2016
// Comment By - Nalin Jayakody
// Alterration - Remove 'Buyer PO #' from the query
//===============================================================================================   	
/*$sql = "SELECT DISTINCT issues.intIssueNo, 
issues.intIssueYear, 
issues.dtmIssuedDate,  
issuesdetails.intStyleId,
issuesdetails.strBuyerPoNo,
department.strDepartment 
FROM issues 
INNER JOIN issuesdetails ON issues.intissueno= issuesdetails.intissueno and issues.intIssueYear = issuesdetails.intIssueYear 
INNER JOIN matitemlist ON issuesdetails.intMatDetailID = matitemlist.intItemSerial 
INNER JOIN department on issues.strProdLineNo = department.intDepID 
INNER JOIN orders ON issuesdetails.intStyleId= orders.intStyleId where issues.intStatus = 1  ";*/

# ===============================================================================================

$sql = "SELECT DISTINCT issues.intIssueNo, 
issues.intIssueYear, 
issues.dtmIssuedDate,  
issuesdetails.intStyleId,
department.strDepartment 
FROM issues 
INNER JOIN issuesdetails ON issues.intissueno= issuesdetails.intissueno and issues.intIssueYear = issuesdetails.intIssueYear 
INNER JOIN matitemlist ON issuesdetails.intMatDetailID = matitemlist.intItemSerial 
INNER JOIN department on issues.strProdLineNo = department.intDepID 
INNER JOIN orders ON issuesdetails.intStyleId= orders.intStyleId where issues.intStatus = 1"; 			
			
			if ($poNoFrom!="")
			{
				$sql .= " AND issues.intIssueNo>=$poNoFrom ";
			}
			if ($poNoTo!="")
			{
				$sql .= " AND issues.intIssueNo<=$poNoTo ";
			}
			
			if ($intCompany!="")
			{
				$sql = $sql." AND issues.intCompanyID=$intCompany ";
			}
						
			if ($strStyleNo!= "")
			{ 
				$sql = $sql." and issuesdetails.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql = $sql." and issuesdetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$sql = $sql." and matitemlist.intMainCatID=$intMeterial ";	
			}
			if ($txtMatItem!= "")
			{				
				$sql .= " and matitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intCategory!= "")
			{
				$sql = $sql." and matitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql = $sql." and matitemlist.intItemSerial=$intDescription " ;
			}
			
			if ($intSupplier!="")
			{			
				$sql = $sql." and purchaseorderheader.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!="")
			{			
				$sql = $sql." and orders.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(issues.dtmIssuedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{					
				$sql = $sql."  and DATE_FORMAT(issues.dtmIssuedDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
		
			$sql = $sql." order by issues.intIssueNo";
			$result = $db->RunQuery($sql);
			$rowCount= mysql_num_rows($result);		
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="100" class="mainHeading4" >Issue  Number</td>
  	    <td width="131" class="mainHeading4" ><?php echo $rowdata["intIssueYear"].'/'. $rowdata["intIssueNo"];  ?></td>
  	    <td width="737"  class="normalfnth2B" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" height="92" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
		  <tr><td>
		
		<table width="970" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr height="25">
            <td width="95" class="normalfnth2B">Date</td>
			<td width="202" class="normalfnt"><?php echo $rowdata["dtmIssuedDate"]; ?></td>
			<td width="85" class="normalfnth2B">Department</td>
			<td width="346" class="normalfnt"><?php echo $rowdata["strDepartment"]; ?></td>
			<td width="62" class="normalfnth2B">&nbsp;</td>
			<td width="178" class="normalfnt">&nbsp;</td>
          </tr>
        </table>
		<p class="head2BLCK"></p></td>
  	</tr>
	
	<tr>
    	<td height="25" colspan="3" class="normalfnth2B">Item Details</td>
  	</tr>
	<tr>
    	<td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="66" bgcolor="#CCCCCC" class="normalfntBtab"  >MRN No </td>
            <td width="81" bgcolor="#CCCCCC" class="normalfntBtab"  >Style No </td>
            <td width="81" bgcolor="#CCCCCC" class="normalfntBtab"  >Order No </td>
			<td width="71" bgcolor="#CCCCCC" class="normalfntBtab"  >SCNo</td>
            <td width="96" bgcolor="#CCCCCC" class="normalfntBtab"  ><span class="normalfnth2B">Buyer PO No</span></td>
            <td width="45" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="206" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="92" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
            <td width="89" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="62" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
            <td width="79" bgcolor="#CCCCCC" class="normalfntBtab">Ret To Stores</td>
			</tr>
		  	<?php 
$detailSql="SELECT DISTINCT issues.intIssueNo,
issues.intIssueYear, 
issues.dtmIssuedDate, 
issuesdetails.intStyleId,
issuesdetails.strBuyerPoNo,
matitemlist.strItemDescription,
matmaincategory.strDescription,
issuesdetails.strColor,
issuesdetails.strSize,
issuesdetails.dblQty,
SP.intSRNO, orders.strOrderNo,orders.strStyle,
(issuesdetails.dblQty-issuesdetails.dblBalanceQty)AS retToStoress,
concat(issuesdetails.intMatReqYear,'/',issuesdetails.intMatRequisitionNo)as mrnNo
FROM issues 
INNER JOIN issuesdetails ON issues.intissueno= issuesdetails.intissueno and issues.intIssueYear= issuesdetails.intIssueYear 
INNER JOIN matitemlist ON issuesdetails.intMatDetailID=matitemlist.intItemSerial 
INNER JOIN department on issues.strProdLineNo=department.intDepID 
INNER JOIN orders ON issuesdetails.intStyleId=orders.intStyleId 
INNER JOIN matmaincategory ON matitemlist.intMainCatId=matmaincategory.intID 
INNER JOIN matsubcategory ON matitemlist.intSubCatId=matsubcategory.intSubCatNo and matitemlist.intMainCatId=matsubcategory.intCatNo
INNER JOIN specification SP ON SP.intStyleId=issuesdetails.intStyleId
WHERE issues.intStatus=$intStatus 
AND issues.intissueno=".$rowdata["intIssueNo"]." 
and issues.intIssueYear=".$rowdata["intIssueYear"]."";
			
			if ($intCompany!="")
			{
				$detailSql .= " AND issues.intCompanyID=$intCompany ";
			}

			if ($strStyleNo!= "")
			{ 
				$detailSql .= " AND issuesdetails.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql = $sql." and issuesdetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND matitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND matitemlist.intSubCatID=$intCategory " ;
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and matitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intDescription!= "")
			{
				$detailSql .= " AND issuesdetails.intMatDetailID=$intDescription ";						
			}
					
			$detailResult = $db->RunQuery($detailSql);
			while ($details=mysql_fetch_array($detailResult))
			{
				
		  	?>
          <tr>
            <td class="normalfntTAB"><?php echo $details["mrnNo"]; ?></td>
            <td class="normalfntTAB"><?php echo $details["strStyle"]; ?></td>
            <td class="normalfntTAB"><?php echo $details["strOrderNo"]; ?></td>
			 <td class="normalfntMidTAB"><?php echo $details["intSRNO"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strBuyerPoNo"]; ?></td>
            <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["retToStoress"],2); ?></td>
            </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	</table>
	<tr><td colspan="3">&nbsp;</td></tr>
<?php
	}
?>

<tr><td colspan="3"></td><tr><td colspan="3"></tr></table>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
</body>
</html>
