<?php
	session_start();
	include "../../Connector.php" ;
	$backwardseperator = "../../";
	$strStyleNo		= $_GET["strStyleNo"];
	$strBPo			= $_GET["strBPo"];
	$intMeterial 	= $_GET["intMeterial"];
	$intCategory 	= $_GET["intCategory"];
	$intDescription = $_GET["intDescription"];
	$intSupplier 	= $_GET["intSupplier"];
	$intBuyer 	  	= $_GET["intBuyer"];
	$dtmDateFrom	= $_GET["dtmDateFrom"];
	$dtmDateTo 	  	= $_GET["dtmDateTo"];
	$intCompany     = $_GET["intCompany"];	
	$intStatus 		= $_GET["status"];
	$noTo 	  		= $_GET["noTo"];
	$noFrom 	  	= $_GET["noFrom"];
	$txtMatItem 	= $_GET["txtMatItem"];
if($intCompany != '')
		$report_companyId =$intCompany;
	else
		$report_companyId =$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Style Reports :: Return To Stores</title>
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
    <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo "RETURN TO STORES";?></td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==10) $listType="(CANCEL LIST)";			 
	
		echo $listType;
	?></td>
  </tr> 
  	<?php 	
$sql_header = "select distinct RSH.intReturnNo,RSH.intReturnYear,dtmRetDate,
(select strDepartment from department D where D.intDepID=RSH.strReturnedBy)as departmentName
 from returntostoresheader RSH
inner join returntostoresdetails RSD on RSH.intReturnNo=RSD.intReturnNo and RSH.intReturnYear=RSD.intReturnYear
inner join matitemlist MIL on  MIL.intItemSerial=RSD.intMatdetailID
where RSH.intStatus=$intStatus";
	
			if ($noFrom != "")
			{ 
				$sql_header .= " and RSH.intReturnNo >='$noFrom' ";
			}
			if ($noTo!= "")
			{ 
				$sql_header .= " and RSH.intReturnNo <='$noTo' ";
			}			
						
			if ($strStyleNo!= "")
			{ 
				$sql_header = $sql_header." and RSD.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql_header = $sql_header." and RSD.strBuyerPoNo='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$sql_header = $sql_header." and MIL.intMainCatID=$intMeterial ";	
			}
			if ($txtMatItem!= "")
			{					
				$sql_header = $sql_header." and MIL.strItemDescription like '%$txtMatItem%'  ";	
			}
			if ($intCategory!= "")
			{
				$sql_header = $sql_header." and MIL.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql_header = $sql_header." and MIL.intItemSerial=$intDescription " ;
			}	
			
			if ($intCompany!="")
			{
				$sql_header = $sql_header." AND RSH.intCompanyID=$intCompany ";
			}		
			
			if (($dtmDateFrom!=""))
			{					
				$sql_header = $sql_header." and DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if (($dtmDateTo!=""))
			{					
				$sql_header = $sql_header."  AND DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
				
				$sql_header = $sql_header." order by  RSH.intReturnNo,RSH.intReturnYear";
			
			$result_header = $db->RunQuery($sql_header);
			$rowCount= mysql_num_rows($result_header);	
			while ($row_header=mysql_fetch_array($result_header))
			{								
	?>
	<tr>
    	<td width="100" class="mainHeading4" >Return  No : </td>
  	    <td width="131" class="mainHeading4" ><?php echo $row_header["intReturnYear"].'/'. $row_header["intReturnNo"];  ?></td>
  	    <td width="737"  class="normalfnth2B" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" height="76" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
		  <tr><td height="19">
		
		<table width="970" border="0" cellpadding="0" cellspacing="0">
          <tr height="25">
            <td width="95" height="19" class="normalfnth2B">Return Date</td>
			<td width="202" class="normalfnt"><?php echo $row_header["dtmRetDate"]; ?></td>
			<td width="85" class="normalfnth2B">Return By </td>
			<td width="346" class="normalfnt"><?php echo $row_header["departmentName"]; ?></td>
			<td width="62" class="normalfnth2B">&nbsp;</td>
			<td width="178" class="normalfnt">&nbsp;</td>
          </tr>
        </table>
		<p class="head2BLCK"></p></td>
  	</tr>
	

	<tr>
    	<td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="100" bgcolor="#CCCCCC" class="normalfntBtab"  ><span class="normalfnth2B">Issue No</span></td>
            <td width="151" bgcolor="#CCCCCC" class="normalfntBtab"  >Order No </td>
            <td width="112" bgcolor="#CCCCCC" class="normalfntBtab"  ><span class="normalfnth2B">Buyer PO No</span></td>
            <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="381" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="146" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
            <td width="146" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="98" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			</tr>
		  	<?php 
				$sql_details="select distinct RSD.intIssueNo,RSD.intIssueYear,RSD.intStyleId,RSD.strBuyerPoNo,MIL.strItemDescription,
RSD.strColor,RSD.strSize,RSD.dblReturnQty,MMC.strID,o.strOrderNo
from returntostoresheader RSH
inner join returntostoresdetails RSD on RSH.intReturnNo=RSD.intReturnNo and RSH.intReturnYear=RSD.intReturnYear
inner join matitemlist MIL on  MIL.intItemSerial=RSD.intMatdetailID
inner join matmaincategory MMC on MIL.intMainCatID=MMC.intID
inner join orders o on o.intStyleId = RSD.intStyleId
where RSH.intStatus=$intStatus and RSH.intReturnNo='".$row_header["intReturnNo"]."' and RSH.intReturnYear='".$row_header["intReturnYear"]."'";		
		

			if ($strStyleNo!= "")
			{ 
				$sql_details = $sql_details." AND RSD.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql_details = $sql_details." and RSD.strBuyerPoNo='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$sql_details = $sql_details." AND MIL.intMainCatID=$intMeterial ";
			}
			if ($txtMatItem!= "")
			{				
				$sql_details .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intCategory!= "")
			{
				$sql_details = $sql_details." AND MIL.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$sql_details = $sql_details." AND RSD.intMatDetailID=$intDescription ";						
			}
			
			if ($intCompany!="")
			{
				$sql_details = $sql_details."  AND RSH.intCompanyID=$intCompany ";
			}
			
			if (($dtmDateFrom!=""))
			{					
				$sql_details = $sql_details." and DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if (($dtmDateTo!=""))
			{					
				$sql_details = $sql_details."  AND DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
					
			$result_details = $db->RunQuery($sql_details);
		
			while ($row_details=mysql_fetch_array($result_details))
			{
				
		  	?>
          <tr>
            <td class="normalfntMidTAB"><?php echo $row_details["intIssueYear"].'/'.$row_details["intIssueNo"]; ?></td>
            <td class="normalfntTAB"><?php echo $row_details["strOrderNo"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $row_details["strBuyerPoNo"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $row_details["strID"]; ?></td>
            <td class="normalfntTAB"><?php echo $row_details["strItemDescription"] ; ?></td>
            <td class="normalfntMidTAB"><?php echo $row_details["strColor"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $row_details["strSize"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo $row_details["dblReturnQty"];?></td>
            </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	</table>
	<tr><td colspan="3" height="5">&nbsp;</td></tr>
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
