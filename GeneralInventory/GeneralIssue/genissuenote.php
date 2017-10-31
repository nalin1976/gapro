<?php 
session_start();
include "../../Connector.php"; 

$expIssue = explode("/",$_GET["issueNo"]);
$backwardseperator 	= "../../";

$intIssueNo =$expIssue[1];
$year = $expIssue[0];
//$intIssueNo="100000";
//$year="2009";
$report_companyId  =$_SESSION["FactoryID"];


		$sql_issu="SELECT genissues.dtmIssuedDate,genissues.intIssueNo,genissues.intUserid,genissues.strProdLineNo,genissues.intIssueYear,(SELECT useraccounts.Name FROM useraccounts WHERE genissues.intUserid = useraccounts.intUserID)AS preparedby,(SELECT department.strDepartment FROM department WHERE department.intDepID = genissues.strProdLineNo)AS recever FROM genissues WHERE genissues.intIssueNo = $intIssueNo AND genissues.intIssueYear = $year;";
		
		$result_issu = $db->RunQuery($sql_issu);
		
		while($row=mysql_fetch_array($result_issu))
		{
		$IssueYearnew=$row["intIssueYear"];		
		$dtmIssuedDate=$row["dtmIssuedDate"];
		$dtIssuedDateNew= substr($dtmIssuedDate,-19,10);
		$dtIssuedDateNewDate= substr($dtIssuedDateNew,-2);//date
		$dtIssuedDateNewYear=substr($dtIssuedDateNew,-10,4);//year
		$dtIssuedDateNewmonth1=substr($dtIssuedDateNew,-5);
		$dtIssuedDateNewmonth=substr($dtIssuedDateNewmonth1,-5,2);//month
		$month=mktime(0,0,0,$dtIssuedDateNewmonth,$dtIssuedDateNewDate,$dtIssuedDateNewYear);
		$intIssueNo=$row["intIssueNo"];
		$preparedby=$row["preparedby"];
		//$intMatRequisitionNo=$row["intMatRequisitionNo"];
		$strProdLineNo=$row["strProdLineNo"];
		$recever=$row["recever"];
		
		}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General ISSUE NOTE</title>
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
        <td height="38" class="head2">GENERAL ISSUE NOTE</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0">
      <tr>
        <td width="22%" class="normalfnth2B">ISSUE NO : </td>
        <td width="28%" class="normalfnt"><?php echo $IssueYearnew."/".$intIssueNo;?></td>
        <td width="19%" class="normalfnth2B">ISSUED DATE : </td>
        <td width="31%" class="normalfnt"><?php  echo date('d/M/Y',$month);?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">ISSUED TO : </td>
        <td class="normalfnt"><?php echo $recever;
		?></td>
        <td class="normalfnth2B">MERCHANDISER :</td>
        <td class="normalfnt"><?php echo $preparedby;?></td>
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
        <td width="13%" height="35" class="normalfntBtab">MRN NO</td>
        <td width="18%" height="35" class="normalfntHTab">&nbsp;ITEM CODE</td>
        <td width="53%" height="35" class="normalfntBtab">DETAILS</td>
        <td width="16%" class="normalfntBtab">QTY</td>
        </tr>
   	  	   <?php

		
		 $strSQL = "select genissuesdetails.intIssueNo,genissuesdetails.intMatDetailID,genissuesdetails.intMatRequisitionNo,genissuesdetails.intMatReqYear, genmatitemlist.strItemDescription, genissuesdetails.dblQty, genmatitemlist.strItemCode  from genissuesdetails, genmatitemlist where  genmatitemlist.intItemSerial = genissuesdetails.intMatDetailID AND genissuesdetails.intIssueNo = $intIssueNo AND genissuesdetails.intIssueYear = '$IssueYearnew'; ";

		$resultdata = $db->RunQuery($strSQL);
		while($rowdata=mysql_fetch_array($resultdata))
		{
		$qty=$rowdata["dblQty"];
		$sum += $qty;
		
	  ?>
        <tr> 
          <td class="normalfntMidTAB"><?php echo $rowdata["intMatReqYear"]."/".$rowdata["intMatRequisitionNo"];?></td>
          <td class="normalfntMidTAB10">&nbsp;<?php echo $rowdata["strItemCode"];?></td>
          <td class="normalfntTAB"><?php echo $rowdata["strItemDescription"];?></td>
        <td class="normalfntRiteTAB"><?php echo $rowdata["dblQty"];?></td>
        </tr>
		<?php
		//}
		
		}
		?>
      <tr>
        <td colspan="3" class="normalfnt2bldBLACKmid">TOTAL</td>
        <td class="normalfntRiteTABb-ANS"><?php echo $sum;?></td>
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
      <tr><td>&nbsp;</td></tr>
	  <tr>
	  <td width="5%">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>        
		<td width="20%">&nbsp;</td>       
        <td width="25%"  class="bcgl1txt1">&nbsp;</td>
         <td width="5%">&nbsp;</td>
      </tr>
      <tr>
	   <td >&nbsp;</td>
        <td class="normalfntMid">RECIEVED BY</td>       
        <td>&nbsp;</td>        
        <td class="normalfntMid">AUTHORIZED BY</td>
		<td>&nbsp;</td>
      </tr>
    </table></td>
  
</table>
</body>
</html>
