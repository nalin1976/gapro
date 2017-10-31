<?php
	session_start();
	include "../../../Connector.php" ;

	$backwardseperator  = "../../../";
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GAPRO - General Inventory Reports :: Return To Stores</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

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
    <td colspan="5"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="19%"><img src="../../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
              <td width="1%" class="normalfnt">&nbsp;</td>
				 <td align="center" valign="top" width="62%" class="topheadBLACK">
<?php
if($intCompany!=0){		
		$SQL = "SELECT strname, CONCAT(straddress1,'.',strAddress2) AS address,
		strStreet,strCity,strCountry
		FROM companies WHERE intCompanyid=$intCompany;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strname"]);
		?><br />
		<span class="bigfntnm1mid"><?php echo ($row["address"]);?><br /><?php echo ($row["strStreet"]."&nbsp;".$row["strCity"]."&nbsp;".$row["strCountry"]);
		}?></span></td>
                 <td width="18%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("RETURN TO STORES.")?></td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==0) $listType="(PENDING LIST)";					 
		else $listType="(CANCELED LIST)"; 		
		echo $listType;
	?></td>
  </tr> 
  	<?php 	
$sql_header = "select distinct RSH.strReturnID,RSH.intRetYear,dtmRetDate,
(select strDepartment from department D where D.strDepartmentCode=RSH.strReturnedBy)as departmentName
 from genreturnheader RSH
inner join genreturndetail RSD on RSH.strReturnID=RSD.strReturnID and RSH.intRetYear=RSD.intRetYear 
inner join genmatitemlist MIL on  MIL.intItemSerial=RSD.intMatDetailID
where RSH.intStatus=$intStatus";
	
			if ($noFrom != "")
			{ 
				$sql_header .= " and RSH.strReturnID >='$noFrom' ";
			}
			if ($noTo!= "")
			{ 
				$sql_header .= " and RSH.strReturnID <='$noTo' ";
			}			
						
/*			if ($strStyleNo!= "")
			{ 
				$sql_header = $sql_header." and RSD.strStyleID ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql_header = $sql_header." and RSD.strBuyerPoNo='$strBPo' " ;
			}
*/			
			if ($intMeterial!= "")
			{					
				$sql_header = $sql_header." and MIL.intMainCatID=$intMeterial ";	
			}

			if ($intCategory!= "")
			{
				$sql_header = $sql_header." and MIL.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql_header = $sql_header." and MIL.intItemSerial=$intDescription " ;
			}	
			
			/*if ($intCompany!="")
			{
				$sql_header = $sql_header." AND RSH.intCompanyID=$intCompany ";
			}*/		
			
			if (($dtmDateFrom!=""))
			{					
				$sql_header = $sql_header." and DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if (($dtmDateTo!=""))
			{					
				$sql_header = $sql_header."  AND DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
				
				$sql_header = $sql_header." order by  RSH.strReturnID,RSH.intRetYear";
			
		//	echo $sql_header ;
			
			$result_header = $db->RunQuery($sql_header);
			$rowCount= mysql_num_rows($result_header);	
			while ($row_header=mysql_fetch_array($result_header))
			{								
	?>
	<tr>
    	<td width="100" bgcolor="#C4DBFD" class="normalfnth2B" >Return  No : </td>
  	    <td width="131" bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo $row_header["intRetYear"].'/'. $row_header["strReturnID"];  ?></td>
  	    <td width="737"  class="normalfnth2B" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" height="76" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
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
            <td width="116" bgcolor="#CCCCCC" class="normalfntBtab"  ><span class="normalfnth2B">Issue No</span></td>
            <td width="136" bgcolor="#CCCCCC" class="normalfntBtab"  >Category</td>
	        <td width="129" bgcolor="#CCCCCC" class="normalfntBtab" >Item Code</td>
	        <td width="440" bgcolor="#CCCCCC" class="normalfntBtab" >Item</td>
            <td width="147" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			</tr>
		  	<?php 
				$sql_details="SELECT DISTINCT
RSD.strReturnID,
RSD.intRetYear,
RSD.strIssueNo,
RSD.intIssYear,
MIL.strItemCode, 
MIL.strItemDescription, 
RSD.dblQtyReturned,
MMC.intID,
MMC.strDescription
from genreturnheader RSH
inner join genreturndetail RSD on RSH.strReturnID=RSD.strReturnID and RSH.intRetYear=RSD.intRetYear
inner join genmatitemlist MIL on  MIL.intItemSerial=RSD.intMatdetailID
inner join genmatmaincategory MMC on MIL.intMainCatID=MMC.intID
where RSH.intStatus=$intStatus and RSH.strReturnID='".$row_header["strReturnID"]."' and RSH.intRetYear='".$row_header["intRetYear"]."'";		
		

/*			if ($strStyleNo!= "")
			{ 
				$sql_details = $sql_details." AND RSD.strStyleID ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql_details = $sql_details." and RSD.strBuyerPoNo='$strBPo' " ;
			}
*/			
			if ($intMeterial!= "")
			{					
				$sql_details = $sql_details." AND MIL.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$sql_details = $sql_details." AND MIL.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$sql_details = $sql_details." AND RSD.intMatDetailID=$intDescription ";						
			}
			
			/*if ($intCompany!="")
			{
				$sql_details = $sql_details."  AND RSH.intCompanyId=$intCompany ";
			}*/
			
			if (($dtmDateFrom!=""))
			{					
				$sql_details = $sql_details." and DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if (($dtmDateTo!=""))
			{					
				$sql_details = $sql_details."  AND DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
					
					//echo $sql_details;
					
			$result_details = $db->RunQuery($sql_details);
		
			while ($row_details=mysql_fetch_array($result_details))
			{
				
		  	?>
          <tr>
            <td class="normalfntMidTAB"><?php echo $row_details["strIssueNo"].'/'.$row_details["intIssYear"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $row_details["strDescription"]; ?></td>
            <td class="normalfntTAB"><?php echo $row_details["strItemCode"] ; ?></td>
            <td class="normalfntTAB"><?php echo $row_details["strItemDescription"] ; ?></td>
            <td class="normalfntRiteTAB"><?php echo $row_details["dblQtyReturned"];?></td>
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
