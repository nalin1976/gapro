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
<title>GaPro - Style Reports :: MRN Details</title>
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
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("MRN REGISTER.")?></td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) $listType="(PENDING LIST)"; 
		elseif ($intStatus==10) $listType="(CONFIRMED LIST)";					 
		echo $listType;
	?></td>
  </tr> 
  	<?php 	
$sql = "SELECT distinct mrn.intMatRequisitionNo,mrn.intMRNYear,date(mrn.dtmDate) as dtmDate,d.strDepartment, ms.strName AS storeName,ua.Name as mrnUser
FROM matrequisition mrn
inner JOIN department d ON mrn.strDepartmentCode = d.intDepID
inner JOIN mainstores ms ON mrn.strMainStoresID = ms.strMainID
inner join matrequisitiondetails mrd on mrd.intMatRequisitionNo = mrn.intMatRequisitionNo and
mrd.intYear = mrn.intMRNYear
inner join matitemlist mil on mil.intItemSerial = mrd.strMatDetailID
inner join orders o on o.intStyleId = mrd.intStyleId
inner join useraccounts ua on mrn.intUserId= ua.intUserID
 where mrn.intStatus = '$intStatus'  ";
			
			
			if ($poNoFrom!="")
			{
				$sql .= " AND mrn.intMatRequisitionNo>=$poNoFrom ";
			}
			if ($poNoTo!="")
			{
				$sql .= " AND mrn.intMatRequisitionNo<=$poNoTo ";
			}
			
			if ($intCompany!="")
			{
				$sql = $sql." AND mrn.intCompanyID=$intCompany ";
			}
						
			if ($strStyleNo!= "")
			{ 
				$sql = $sql." and mrd.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql = $sql." and mrd.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$sql = $sql." and mil.intMainCatID=$intMeterial ";	
			}
			if ($txtMatItem!= "")
			{				
				$sql .= " and mil.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intCategory!= "")
			{
				$sql = $sql." and mil.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql = $sql." and mil.intItemSerial=$intDescription " ;
			}
			
			
			if ($intBuyer!="")
			{			
				$sql = $sql." and o.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(mrn.dtmDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{					
				$sql = $sql."  and DATE_FORMAT(mrn.dtmDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
		
			$sql = $sql." order by mrn.intMatRequisitionNo";
			//echo $sql;
			$result = $db->RunQuery($sql);
			$rowCount= mysql_num_rows($result);		
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="100" class="mainHeading4" >MRN   Number</td>
  	    <td width="131" class="mainHeading4" ><?php echo $rowdata["intMRNYear"].'/'. $rowdata["intMatRequisitionNo"];  ?></td>
  	    <td width="737"  class="normalfnth2B" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" height="92" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
		  <tr><td>
		
		<table width="970" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr height="25">
            <td width="62" class="normalfnth2B">Date</td>
			<td width="121" class="normalfnt"><?php echo $rowdata["dtmDate"]; ?></td>
			<td width="164" class="normalfnth2B">Department (From) :</td>
			<td width="180" class="normalfnt"><?php echo $rowdata["strDepartment"]; ?></td>
			<td width="47" class="normalfnth2B">To :</td>
			<td width="177" class="normalfnt"><?php echo $rowdata["storeName"]; ?></td>
            <td width="60" class="normalfnth2B">User :</td>
             <td width="157" class="normalfnt"><?php echo $rowdata["mrnUser"]; ?></td>
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
           <td width="135" bgcolor="#CCCCCC" class="normalfntBtab" height="25"  >Style No</td>
            <td width="135" bgcolor="#CCCCCC" class="normalfntBtab" height="25"  >Order No </td>
			<td width="43" bgcolor="#CCCCCC" class="normalfntBtab"  >SCNo</td>
            <td width="83" bgcolor="#CCCCCC" class="normalfntBtab"  ><span class="normalfnth2B">Buyer PO No</span></td>
            <td width="39" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="253" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="100" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
            <td width="97" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="67" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
            <td width="80" bgcolor="#CCCCCC" class="normalfntBtab">Issue Qty</td>
            <td width="80" bgcolor="#CCCCCC" class="normalfntBtab">Balance To Issue</td>
			</tr>
		  	<?php 
$detailSql="select mrn.intMatRequisitionNo,mrn.intMRNYear,o.strOrderNo,o.strStyle, sp.intSRNO,mrd.strBuyerPONO,mil.strItemDescription,matCat.strDescription,
mrd.strColor,mrd.strSize,mrd.dblQty,(mrd.dblQty-mrd.dblBalQty) as issueQty
from matrequisition mrn inner join matrequisitiondetails mrd on mrn.intMatRequisitionNo= mrd.intMatRequisitionNo and 
mrn.intMRNYear = mrd.intYear
inner join orders o on o.intStyleId = mrd.intStyleId
inner join specification sp on sp.intStyleId= o.intStyleId
inner join matitemlist mil on mil.intItemSerial= mrd.strMatDetailID
inner join matmaincategory matCat on matCat.intID= mil.intMainCatID
WHERE  mrn.intMatRequisitionNo=".$rowdata["intMatRequisitionNo"]." 
and mrn.intMRNYear=".$rowdata["intMRNYear"]."";
			
			if ($intCompany!="")
			{
				$detailSql .= " AND mrn.intCompanyID=$intCompany ";
			}

			if ($strStyleNo!= "")
			{ 
				$detailSql .= " AND mrd.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql = $sql." and mrd.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND mil.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND mil.intSubCatID=$intCategory " ;
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and mil.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intDescription!= "")
			{
				$detailSql .= " AND mrd.strMatDetailID=$intDescription ";						
			}
					
			$detailResult = $db->RunQuery($detailSql);
			while ($details=mysql_fetch_array($detailResult))
			{
                            $dbl_issue_bal_qty = (float)$details["dblQty"] - (float)$details["issueQty"];
		  	?>
          <tr>
              <td class="normalfntTAB"><?php echo $details["strStyle"]; ?></td>
             <td class="normalfntTAB"><?php echo $details["strOrderNo"]; ?></td>
			 <td class="normalfntMidTAB"><?php echo $details["intSRNO"]; ?></td>
            <td class="normalfntMidTAB" nowrap="nowrap"><?php echo $details["strBuyerPONO"]; ?></td>
            <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["issueQty"],2); ?></td>
            <td class="normalfntRiteTAB" <?php if($dbl_issue_bal_qty>0) { ?> style="background-color: tomato" <?php } ?>><?php echo round($dbl_issue_bal_qty,2); ?></td>
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
