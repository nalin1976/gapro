<?php
	session_start();
	include "../../../Connector.php" ;

	$backwardseperator  = "../../../";
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$intCompany    		= $_GET["intCompany"];
	$poNoFrom			= $_GET["poNoFrom"];
	$poNoTo				= $_GET["poNoTo"];
	$intStatus 			= $_GET["status"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GAPRO - General Inventory Reports :: Issue Details</title>
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
$sql = "SELECT DISTINCT genissues.intIssueNo, 
genissues.intIssueYear, 
genissues.dtmIssuedDate,  
department.strDepartment 
FROM genissues 
INNER JOIN genissuesdetails ON genissues.intIssueNo= genissuesdetails.intIssueNo and genissues.intIssueYear = genissuesdetails.intIssueYear 
INNER JOIN genmatitemlist ON genissuesdetails.intMatDetailID = genmatitemlist.intItemSerial 
INNER JOIN department on genissues.strProdLineNo = department.strDepartmentCode 
where genissues.intStatus = 1  ";
			
			
			if ($poNoFrom!="")
			{
				$sql .= " AND genissues.intIssueNo>=$poNoFrom ";
			}
			if ($poNoTo!="")
			{
				$sql .= " AND genissues.intIssueNo<=$poNoTo ";
			}
			
			if ($intCompany!="")
			{
				$sql = $sql." AND genissues.intCompanyID=$intCompany ";
			}
			if ($intMeterial!= "")
			{					
				$sql = $sql." and genmatitemlist.intMainCatID=$intMeterial ";	
			}

			if ($intCategory!= "")
			{
				$sql = $sql." and genmatitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql = $sql." and genmatitemlist.intItemSerial=$intDescription " ;
			}
	
			if ($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(genissues.dtmIssuedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{					
				$sql = $sql."  and DATE_FORMAT(genissues.dtmIssuedDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
		
			$sql = $sql." order by genissues.intIssueNo";
			//echo $sql;
			$result = $db->RunQuery($sql);
			$rowCount= mysql_num_rows($result);		
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="100" bgcolor="#C4DBFD" class="normalfnth2B" >Issue  Number</td>
  	    <td width="131" bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo $rowdata["intIssueYear"].'/'. $rowdata["intIssueNo"];  ?></td>
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
    	<td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="50" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
			<td width="60" bgcolor="#CCCCCC" class="normalfntBtab" >Item Code</td>
	        <td width="381" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="98" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
            <td width="98" bgcolor="#CCCCCC" class="normalfntBtab">Ret To Stores</td>
			</tr>
		  	<?php 
$detailSql="SELECT DISTINCT genissues.intIssueNo,
genissues.intIssueYear, 
genissues.dtmIssuedDate, 
genmatitemlist.intItemSerial,
genmatitemlist.strItemCode,
genmatitemlist.strItemDescription,
genmatmaincategory.strDescription,
genissuesdetails.dblQty,
(genissuesdetails.dblQty-genissuesdetails.dblBalanceQty)AS retToStoress
FROM genissues 
INNER JOIN genissuesdetails ON genissues.intissueno= genissuesdetails.intissueno and genissues.intIssueYear= genissuesdetails.intIssueYear 
INNER JOIN genmatitemlist ON genissuesdetails.intMatDetailID=genmatitemlist.intItemSerial 
INNER JOIN department on genissues.strProdLineNo=department.strDepartmentCode 
INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatId=genmatmaincategory.intID 
INNER JOIN genmatsubcategory ON genmatitemlist.intSubCatId=genmatsubcategory.intSubCatNo and genmatitemlist.intMainCatId=genmatsubcategory.intCatNo
WHERE genissues.intStatus=$intStatus 
AND genissues.intissueno=".$rowdata["intIssueNo"]." 
and genissues.intIssueYear=".$rowdata["intIssueYear"]."";
			
			if ($intCompany!="")
			{
				$detailSql .= " AND genissues.intCompanyID=$intCompany ";
			}

			if ($intMeterial!= "")
			{					
				$detailSql .= " AND genmatitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND genmatitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND genissuesdetails.intMatDetailID=$intDescription ";						
			}
			//	echo 	$detailSql;
			$detailResult = $db->RunQuery($detailSql);
		
			while ($details=mysql_fetch_array($detailResult))
			{
				
		  	?>
          <tr>
            <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemCode"]); ?></td>
			<td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
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
