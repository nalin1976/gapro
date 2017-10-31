<?php 
session_start();
include "../../Connector.php"; 

$companyId  =$_SESSION["FactoryID"];

$expIssue = explode("/",$_GET["issueNo"]);


$intIssueNo =$expIssue[1];
$year = $expIssue[0];
$backwardseperator 	= "../../";
$report_companyId  =$_SESSION["FactoryID"];

		/*$sql_issu="SELECT issues.dtmIssuedDate,issues.intIssueNo,issues.intUserid,issues.strProdLineNo,issues.intIssueYear,(SELECT useraccounts.Name FROM useraccounts WHERE issues.intUserid = useraccounts.intUserID)AS preparedby,(SELECT department.strDepartment FROM department WHERE department.strDepartmentCode = issues.strProdLineNo)AS recever FROM issues WHERE issues.intIssueNo = $intIssueNo AND issues.intIssueYear = $year;";*/
		$sql_issu="SELECT
gen_chemicalallocation_header.intChemAllocationYear,
gen_chemicalallocation_header.intChemAllocationNo,
gen_chemicalallocation_header.intUserId,
gen_chemicalallocation_header.dtmSaveDate,
useraccounts.Name
FROM
gen_chemicalallocation_header
Inner Join useraccounts ON gen_chemicalallocation_header.intUserId = useraccounts.intUserID
WHERE gen_chemicalallocation_header.intChemAllocationNo = '". $intIssueNo ."' AND gen_chemicalallocation_header.intChemAllocationYear = '". $year ."' ";
		
		$result_issu = $db->RunQuery($sql_issu);
		
		while($row=mysql_fetch_array($result_issu))
		{
		$IssueYearnew=$row["intChemAllocationYear"];		
		$dtmIssuedDate=$row["dtmSaveDate"];
		$dtIssuedDateNew= substr($dtmIssuedDate,-19,10);
		$dtIssuedDateNewDate= substr($dtIssuedDateNew,-2);//date
		$dtIssuedDateNewYear=substr($dtIssuedDateNew,-10,4);//year
		$dtIssuedDateNewmonth1=substr($dtIssuedDateNew,-5);
		$dtIssuedDateNewmonth=substr($dtIssuedDateNewmonth1,-5,2);//month
		$month=mktime(0,0,0,$dtIssuedDateNewmonth,$dtIssuedDateNewDate,$dtIssuedDateNewYear);
		$intIssueNo=$row["intChemAllocationNo"];
		$preparedby=$row["Name"];
		
		}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Chemical Allocation Note</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td colspan="5"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%"><?php include '../../reportHeader.php'?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td height="38" class="head2">CHEMICAL ALLOCATION NOTE</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0">
      <tr>
        <td width="24%" class="normalfnth2B">CHEMICAL ALLOCATION NO : </td>
        <td width="18%" class="normalfnt"><?php echo $IssueYearnew."/".$intIssueNo;?></td>
        <td width="27%" class="normalfnth2B">CHEMICAL ALLOCATION DATE : </td>
        <td width="31%" class="normalfnt"><?php  echo date('d/M/Y',$month);?></td>
      </tr>
    <!--  <tr>
        <td class="normalfnth2B">REASON : </td>
        <td class="normalfnt"><?php echo $Reason;?></td>
        <td class="normalfnth2B"> SUPPLIER : </td>
        <td class="normalfnt"><?php echo $recever;
		?></td>
      </tr>-->
      <tr>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">	</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="10%" height="35" class="normalfntBtab">CHEMICAL ALLOCATION NO</td>
        <td width="39%" height="35" class="normalfntBtab">DETAILS</td>
        <td width="13%" class="normalfntBtab">QTY</td>
        </tr>
					
 	  	   <?php

		
		$strSQL = "SELECT
gen_chemicalallocation_header.intChemAllocationYear,
gen_chemicalallocation_header.intChemAllocationNo,
gen_chemicalallocation_header.intUserId,
gen_chemicalallocation_header.dtmSaveDate,
gen_chemicalallocation_detail.intTargetMatDetailId,
gen_chemicalallocation_detail.dblStockQty,
genmatitemlist.strItemDescription
FROM
gen_chemicalallocation_header
Inner Join gen_chemicalallocation_detail ON gen_chemicalallocation_header.intChemAllocationNo = gen_chemicalallocation_detail.intChemAllocationNo AND gen_chemicalallocation_header.intChemAllocationYear = gen_chemicalallocation_detail.intChemAllocationYear
Inner Join genmatitemlist ON gen_chemicalallocation_detail.intTargetMatDetailId = genmatitemlist.intItemSerial
WHERE gen_chemicalallocation_header.intChemAllocationNo = '". $intIssueNo ."'
;";
		/*$strSQL = " SELECT  gensupreturndetail.intGRNYear, gensupreturndetail.strGRNNO, genmatitemlist.strItemDescription,
					gensupreturndetail.dblQtyReturned as dblQty
					FROM gensupreturndetail
					Inner Join genmatitemlist ON gensupreturndetail.intMatDetailID = genmatitemlist.intItemSerial
					WHERE gensupreturndetail.strReturnID = '". $intIssueNo ."'  ";*/
		
		$resultdata = $db->RunQuery($strSQL);
		while($rowdata=mysql_fetch_array($resultdata))
		{
		$qty=$rowdata["dblStockQty"];
		$sum += $qty;
		
	  ?>
        <tr> 
          <td class="normalfntTAB"><?php echo $rowdata["intChemAllocationYear"]."/".$rowdata["intChemAllocationNo"];?></td>
          <td class="normalfntTAB"><?php echo $rowdata["strItemDescription"];?></td>
        <td class="normalfntRiteTAB"><?php echo $rowdata["dblStockQty"];?></td>
        </tr>
		<?php
		//}
		
		}
		?>
      <tr>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid">TOTAL</td>
        <td class="normalfnt2bldBLACKmid"><span class="normalfntRiteTABb-ANS"><?php echo $sum;?></span></td>
        </tr>
    </table></td>
  </tr>
  	<td height="20"/>
  <tr>
  </tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
	  <td width="5%">&nbsp;</td>
        <td width="25%" class="bcgl1txt1"><?php echo $preparedby?></td>        
		<td width="20%">&nbsp;</td>       
        <td width="25%"  class="bcgl1txt1">&nbsp;</td>
         <td width="5%">&nbsp;</td>
      </tr>
      <tr>
	   <td >&nbsp;</td>
        <td class="normalfntMid">PREPARED BY</td>       
        <td>&nbsp;</td>        
        <td class="normalfntMid">CHECKED BY</td>
		<td>&nbsp;</td>
      </tr>

    </table></td>
  
</table>
</body>
</html>
