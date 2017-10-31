<?php
	session_start();
	include "../Connector.php" ;
	//include("DBReport.php");	
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Issue Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

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
                <td width="20%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
              <td width="6%" class="normalfnt">&nbsp;</td>
				 <td width="62%" class="tophead"><p class="normalfnt"></p></td>
                 <td width="12%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><p class="head2BLCK"><?php 	
		$cid=$_SESSION["CompanyID"];
		$intCompany     = $_GET["intCompany"];
		$SQL = "SELECT strname, CONCAT(straddress1,CONCAT(', ',CONCAT(strAddress2,CONCAT(', ', CONCAT(strStreet,'.'))))) AS strAdress FROM companies WHERE intCompanyid=$intCompany;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strname"]);		
		?></p></td>
  </tr>
  <tr>
    <td colspan="5"><p class="head2BLCK style1"><?php $cid=$_SESSION["CompanyID"];
		$SQL = "SELECT strname, CONCAT(straddress1,CONCAT(', ',CONCAT(strAddress2,CONCAT(', ', CONCAT(strStreet,'.'))))) AS strAdress FROM companies WHERE intCompanyid=$intCompany;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strAdress"]);?></p> </td>
  </tr>
  <tr>
  <?php $intStatus = $_GET["status"]; ?>
    <td colspan="5"><p class="head2BLCK style2"><?php echo ("ISSUES REGISTER.")?></p></td>
  </tr>
  <tr>
    <td colspan="5"><p class="head2BLCK style1">
	<?php 		
		if ($intStatus==1) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==10) $listType="(PENDING LIST)";					 
		else $listType="(CANCELED LIST)"; 		
		echo $listType;
	?>
	</p></td>
  </tr> 
  	<?php 	
		$strStyleNo		= $_GET["strStyleNo"];
		$strBPo			= $_GET["strBPo"];
		$intMeterial 	= $_GET["intMeterial"];
		$intCategory 	= $_GET["intCategory"];
		$intDescription = $_GET["intDescription"];
		$intSupplier 	= $_GET["intSupplier"];
		$intBuyer 	  	= $_GET["intBuyer"];
		$dtmDateFrom	= $_GET["dtmDateFrom"];
		$dtmDateTo 	  	= $_GET["dtmDateTo"];		
		//echo $strStyleNo;
		if ($strBPo=='HashMain Ratio') $strBPo='#Main Ratio#';
				
				
		$sql = "SELECT DISTINCT issues.intissueno, issues.intIssueYear, issues.dtmIssuedDate,  issuesdetails.strStyleId,issuesdetails.strBuyerPoNo,department.strDepartment FROM issues INNER JOIN issuesdetails ON issues.intissueno= issuesdetails.intissueno and issues.intIssueYear = issuesdetails.intIssueYear INNER JOIN matitemlist ON issuesdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN department on issues.strProdLineNo = department.strDepartmentCode INNER JOIN orders ON issuesdetails.strStyleId= orders.strStyleId where issues.intStatus = 1  ";
			
			//echo $sql;
			if ($intCompany!=0)
			{
				$sql = $sql." AND issues.intCompanyID=$intCompany ";
			}
						
			if ($strStyleNo!= "0")
			{ 
				$sql = $sql." and issuesdetails.strStyleID ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "0")
			{
				$sql = $sql." and issuesdetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "0")
			{					
				$sql = $sql." and matitemlist.intMainCatID=$intMeterial ";	
			}

			if ($intCategory!= "0")
			{
				$sql = $sql." and matitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "0")
			{
				$sql = $sql." and matitemlist.intItemSerial=$intDescription " ;
			}
	
			if ($intSupplier!='0')
			{			
				$sql = $sql." and purchaseorderheader.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!=0)
			{			
				$sql = $sql." and orders.intBuyerID=$intBuyer";				
			}
			
			if (($dtmDateFrom!=0) || ($dtmDateTo!=0))
			{					
				$sql = $sql." and DATE_FORMAT(issues.dtmIssuedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') AND DATE_FORMAT(issues.dtmIssuedDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			$sql = $sql." order by issues.intIssueNo";
			$result = $db->RunQuery($sql);
			//echo $sql;
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="100" bgcolor="#C4DBFD" class="normalfnth2B" >Issue  Number</td>
  	    <td width="131" bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo substr($rowdata["intIssueYear"],2,2).'/'. $rowdata["intissueno"];  ?></td>
  	    <td width="737"  class="normalfnth2B" >&nbsp;</td>
  	    
  	    
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" height="92" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		  <tr><td>
		
		<table width="970" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
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
    	<td colspan="3"><table width="970" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="151" bgcolor="#CCCCCC" class="normalfntBtab"  >Style No </td>
            <td width="112" bgcolor="#CCCCCC" class="normalfntBtab"  ><span class="normalfnth2B">Buyer PO No</span></td>
            <td width="80" bgcolor="#CCCCCC" class="normalfntBtab"  >Material</td>
	        <td width="381" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="146" bgcolor="#CCCCCC" class="normalfntBtab">Color/Size</td>
            <td width="98" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			</tr>
		  	<?php 
				$detailSql="SELECT DISTINCT issues.intissueno, issues.intIssueYear, issues.dtmIssuedDate, issuesdetails.strStyleId,issuesdetails.strBuyerPoNo,matitemlist.strItemDescription,matmaincategory.strDescription,issuesdetails.strColor,issuesdetails.strSize,issuesdetails.dblQty FROM issues INNER JOIN issuesdetails ON issues.intissueno= issuesdetails.intissueno and issues.intIssueYear= issuesdetails.intIssueYear INNER JOIN matitemlist ON issuesdetails.intMatDetailID=matitemlist.intItemSerial INNER JOIN department on issues.strProdLineNo=department.strDepartmentCode INNER JOIN orders ON issuesdetails.strStyleId=orders.strStyleId INNER JOIN matmaincategory ON matitemlist.intMainCatId=matmaincategory.intID INNER JOIN matsubcategory ON matitemlist.intSubCatId=matsubcategory.intSubCatNo and matitemlist.intMainCatId=matsubcategory.intCatNo WHERE issues.intStatus=$intStatus AND issues.intissueno=".$rowdata["intissueno"]."";
			
			if ($intCompany!=0)
			{
				$detailSql = $detailSql."  AND issues.intCompanyID=$intCompany ";
			}

			if ($strStyleNo!= "0")
			{ 
				$detailSql = $detailSql." AND issuesdetails.strStyleID ='$strStyleNo' ";
			}
			
			if ($intMeterial!= "0")
			{					
				$detailSql = $detailSql." AND matitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "0")
			{
				$detailSql = $detailSql." AND matitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "0")
			{
				$detailSql = $detailSql." AND issuesdetails.intMatDetailID=$intDescription ";						
			}
					
			$detailResult = $db->RunQuery($detailSql);
			//echo $detailSql;
			while ($details=mysql_fetch_array($detailResult))
			{
				
		  	?>
          <tr>
            <td class="normalfntTAB"><?php echo $details["strStyleId"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strBuyerPoNo"]; ?></td>
            <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strColor"].','.$details["strSize"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["dblQty"]); ?></td>
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
//}

?>

<tr><td colspan="3"></td><tr><td colspan="3"></tr></table>


<p>&nbsp;</p>
</body>
</html>
