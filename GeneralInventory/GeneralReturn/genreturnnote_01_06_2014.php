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
		$sql_issu="SELECT genreturnheader.dtmRetDate,genreturnheader.intReturnId,genreturnheader.intUserid,
		genreturnheader.intReturnedBy,genreturnheader.intRetYear,
		(SELECT useraccounts.Name FROM useraccounts WHERE genreturnheader.intUserId = useraccounts.intUserID)AS preparedby,
		(SELECT department.strDepartment  FROM department WHERE department.intDepID = genreturnheader.intReturnedBy)AS recever,intStatus
		FROM genreturnheader 
		WHERE genreturnheader.intReturnId =$intIssueNo AND genreturnheader.intRetYear =$year;";
		$result_issu = $db->RunQuery($sql_issu);
		
		while($row=mysql_fetch_array($result_issu))
		{
		$IssueYearnew=$row["intRetYear"];		
		$dtmIssuedDate=$row["dtmRetDate"];
		$dtIssuedDateNew= substr($dtmIssuedDate,-19,10);
		$dtIssuedDateNewDate= substr($dtIssuedDateNew,-2);//date
		$dtIssuedDateNewYear=substr($dtIssuedDateNew,-10,4);//year
		$dtIssuedDateNewmonth1=substr($dtIssuedDateNew,-5);
		$dtIssuedDateNewmonth=substr($dtIssuedDateNewmonth1,-5,2);//month
		$month=mktime(0,0,0,$dtIssuedDateNewmonth,$dtIssuedDateNewDate,$dtIssuedDateNewYear);
		$intIssueNo=$row["intReturnId"];
		$preparedby=$row["preparedby"];
		//$intMatRequisitionNo=$row["intMatRequisitionNo"];
		$strProdLineNo=$row["strReturnedBy"];
		$recever=$row["recever"];
		$status = $row["intStatus"];
		
		}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Return Note</title>
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
        <td width="100%" colspan="3"><?php include '../../reportHeader.php'?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td height="38" class="head2">RETURN  NOTE</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0">
      <tr>
        <td width="22%" class="normalfnth2B">RETURN NO : </td>
        <td width="28%" class="normalfnt"><?php echo $IssueYearnew."/".$intIssueNo;?></td>
        <td width="19%" class="normalfnth2B">RETURNED DATE : </td>
        <td width="31%" class="normalfnt"><?php  echo date('d/M/Y',$month);?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">REASON : </td>
        <td class="normalfnt"><?php echo $strProdLineNo;?></td>
        <td class="normalfnth2B"> DEPRATMENT : </td>
        <td class="normalfnt"><?php echo $recever;
		?></td>
      </tr>
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
        <td width="10%" height="35" class="normalfntBtab">ISSUE NO</td>
        <td width="10%" height="35" class="normalfntBtab">ITEM CODE</td>
        <td width="39%" height="35" class="normalfntBtab">DETAILS</td>
        <td width="13%" class="normalfntBtab">QTY</td>
        </tr>
<!--
      <tr>

        <td colspan="5" class="normalfntTAB">
		<table width="100%" border="0" class="normalfnt2BITAB">

        </table>          </td>
        </tr>
--> <?php
	$sum = 0;
		/*$strSQL = "select issuesdetails.intIssueNo,issuesdetails.intMatDetailID,issuesdetails.intMatRequisitionNo,issuesdetails.intMatReqYear, matitemlist.strItemDescription, issuesdetails.strColor, issuesdetails.strSize, issuesdetails.dblQty  from issuesdetails, matitemlist where issuesdetails.intStyleId = '" . $row["intStyleId"] . "' And matitemlist.intItemSerial = issuesdetails.intMatDetailID AND issuesdetails.intIssueNo = $intIssueNo;";*/
		$strSQL="SELECT genreturndetail.intIssYear,genreturndetail.intIssueNo,
			  genmatitemlist.strItemDescription, genmatitemlist.strItemCode,
			  genreturndetail.dblQty as dblQty FROM genreturndetail
			  Inner Join genmatitemlist ON genreturndetail.intMatDetailID = genmatitemlist.intItemSerial
			  WHERE genreturndetail.intReturnId ='". $intIssueNo ."' ";		
		
		$resultdata = $db->RunQuery($strSQL);
		while($rowdata=mysql_fetch_array($resultdata))
		{
		$qty=$rowdata["dblQty"];
		$sum += $qty;
		
	  ?>
        <tr> 
          <td class="normalfntTAB"><?php echo $rowdata["intIssYear"]."/".$rowdata["intIssueNo"];?></td>
          <td class="normalfntTAB"><?php echo $rowdata["strItemCode"];?></td>
          <td class="normalfntTAB"><?php echo $rowdata["strItemDescription"];?></td>
        <td class="normalfntRiteTAB"><?php echo $rowdata["dblQty"];?></td>
        </tr>
		<?php
		//}
		
		}
		?>
      <tr>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
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
<?php 
if($status==10)
{
	echo "<div style=\"position:absolute;top:120px;left:400px;\"><img src=\"../../images/cancelled.png\" style=\"-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);\" /></div>";
}
else if($status==0)
{
	echo "<div style=\"position:absolute;top:120px;left:180px;\"><img src=\"../../images/pending.png\"/></div>";
}
?>
