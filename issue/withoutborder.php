<?php 

include "../Connector.php"; 
$xml = simplexml_load_file('../config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;

$expIssue = explode("/",$_GET["issueNo"]);


$intIssueNo =$expIssue[1];
$year = $expIssue[0];
//$intIssueNo="100000";
//$year="2009";

		$sql_issu="SELECT issues.dtmIssuedDate,issues.intIssueNo,issues.intUserid,issues.strProdLineNo,issues.intIssueYear,issues.strSecurityNo,(SELECT useraccounts.Name FROM useraccounts WHERE issues.intUserid = useraccounts.intUserID)AS preparedby,(SELECT department.strDepartment FROM department WHERE department.strDepartmentCode = issues.strProdLineNo)AS recever FROM issues WHERE issues.intIssueNo = $intIssueNo AND issues.intIssueYear = $year;";
	
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
		$securityNo =$row["strSecurityNo"];
		}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Style Items - Issue Note</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
        <td width="24%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="2%" class="normalfnt"><?php 
		//$sqlcom="select DISTINCT issuesdetails.intStyleId, issuesdetails.strBuyerPONO, orders.intUserID, useraccounts.Name, orders.intBuyerID, buyers.strName,orders.intCompanyID,(SELECT companies.strName from companies where orders.intCompanyID = companies.intCompanyID)as companyname from issuesdetails, orders, useraccounts, buyers,companies where issuesdetails.intIssueNo =  ".$intIssueNo." and issuesdetails.intIssueYear =$year AND issuesdetails.intStyleId = orders.intStyleId AND orders.intUserID = useraccounts.intUserID AND orders.intBuyerID = buyers.intBuyerID ;";
		//die ($sqlcom);
		$sqlcom = "SELECT strName FROM issues  INNER JOIN companies ON issues.intCompanyID = companies.intCompanyID WHERE issues.intIssueNo = '$intIssueNo' AND issues.intIssueYear = '$year';";
	$resultcom = $db->RunQuery($sqlcom);
		while($row=mysql_fetch_array($resultcom))
		{	
		$company=$row["strName"];
		}
		?>		</td>
        <td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $company;?></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td height="38" width="82%" class="head2">ISSUE NOTE</td>
 			<td width="18%" class="head2"><?php
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('../iso.xml');
   						echo  $xmlISO->ISOCodes->StyleIssueReport;
						}          
         ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0">
      <tr>
        <td width="14%" class="normalfnth2B">ISSUE NO </td>
        <td width="2%" class="normalfnth2B">: </td>
        <td width="34%" class="normalfnt"><?php echo $IssueYearnew."/".$intIssueNo;?></td>
        <td width="17%" class="normalfnth2B">ISSUED DATE</td>
        <td width="2%" class="normalfnth2B"> : </td>
        <td width="31%" class="normalfnt"><?php  echo $dtmIssuedDate;?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">ISSUED STORE</td>
        <td class="normalfnth2B"> : </td>
        <td class="normalfnt"><?php 
	

$sqlstore= "SELECT strName FROM stocktransactions 
INNER JOIN mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
WHERE intDocumentNo = '$intIssueNo' AND strType = 'ISSUE' AND intDocumentYear = '$year' LIMIT 1";

$result=$db->RunQuery($sqlstore);
while($row=mysql_fetch_array($result))
{
	echo $row["strName"];
	break;
}
		?></td>
        <td class="normalfnth2B">PRODUCT LINE TO </td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $recever;
		?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">SECURITY NO </td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $securityNo;?></td>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">	</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="border-All">
      <tr bgcolor="#CCCCCC">
	   <td width="9%" height="25" class="border-bottom-fntsize12" style="text-align:center"><b>Item Code</b></td>
        <td width="12%" class="border-bottom-fntsize12" style="text-align:center"><b>MRN NO</b></td>
        <td width="26%" class="border-bottom-fntsize12" style="text-align:center"><b>DETAILS</b></td>
        <td width="12%" class="border-bottom-fntsize12" style="text-align:center"><b>COLOR</b></td>
        <td width="8%" class="border-bottom-fntsize12" style="text-align:center"><b>SIZE</b></td>
		 <td width="4%" class="border-bottom-fntsize12" style="text-align:center"><b>UNIT</b></td>
        <td width="9%" class="border-bottom-fntsize12" style="text-align:center"><b>QTY</b></td>
        <td width="20%" class="border-bottom-fntsize12" style="text-align:center"><b>BIN LOCATION</b></td>
        </tr>
					<?php 
					$sum = 0;
	$sql_oth="select DISTINCT issuesdetails.intStyleId, issuesdetails.strBuyerPONO, orders.intUserID, useraccounts.Name, orders.intBuyerID, buyers.strName from issuesdetails, orders, useraccounts, buyers,companies where issuesdetails.intIssueNo = $intIssueNo AND issuesdetails.intIssueYear = $year AND issuesdetails.intStyleId = orders.intStyleId AND orders.intCoordinator = useraccounts.intUserID AND orders.intBuyerID = buyers.intBuyerID ;";
			$result_oth = $db->RunQuery($sql_oth);
		while($row=mysql_fetch_array($result_oth ))
		{
		

	?>

      <tr>

        <td colspan="8" >
		<table width="100%" border="0" class="normalfntMid">

          <tr>
            <td width="9%">STYLE NO  :</td>
            <td width="16%"><?php 
			$styleID = $row["intStyleId"];
			echo getStyleName($styleID);?></td>
            <td width="7%">SCNO :</td>
            <td width="10%">
<?PHP
$sqlscno="select intSRNO from specification where intStyleId='".$row["intStyleId"]."';";
$result_scno = $db->RunQuery($sqlscno);
while($row_scno=mysql_fetch_array($result_scno))
{
	$scno = $row_scno["intSRNO"];
	echo $scno;
}
?>
			</td>
            <td width="10%">BUYER PO :</td>
            <td width="14%"><?php echo getBuyerPOName($styleID,$row["strBuyerPONO"]);?></td>
                <td width="14%">MERCHANDISER :</td>
                <td width="15%"><?php echo $row["Name"];?></td>         
          </tr>
       
             <tr>
            <td width="9%">BUYER : </td>
            <td colspan="9" style="text-align:left"><?php echo $row["strName"];?></td>          
        
          </tr>
   
        </table>          </td>
        </tr>
   	  	   <?php

		
		$strSQL = "select issuesdetails.intIssueNo,issuesdetails.intMatDetailID,issuesdetails.intMatRequisitionNo,issuesdetails.intMatReqYear, matitemlist.strItemDescription, issuesdetails.strColor, issuesdetails.strSize, issuesdetails.dblQty,  matitemlist.strUnit from issuesdetails, matitemlist where issuesdetails.intStyleId = '" . $row["intStyleId"] . "' AND 
issuesdetails.strBuyerPONO='".$row["strBuyerPONO"]."' And matitemlist.intItemSerial = issuesdetails.intMatDetailID AND issuesdetails.intIssueNo = $intIssueNo AND issuesdetails.intIssueYear = $year;";
		
		
		$resultdata = $db->RunQuery($strSQL);
		while($rowdata=mysql_fetch_array($resultdata))
		{
		$qty=$rowdata["dblQty"];
		$sum += $qty;
		
	  ?>
        <tr> 
		<td class="normalfntMid"><?php 
$sql_code="select materialRatioID from materialratio 
where intStyleId ='" . $row["intStyleId"] . "'
and strBuyerPONO ='".$row["strBuyerPONO"]."'
and strMatDetailID ='".$rowdata["intMatDetailID"]."'
and strColor ='".$rowdata["strColor"]."'
and strSize ='".$rowdata["strSize"]."'";
$result_code = $db->RunQuery($sql_code);
$row_code =mysql_fetch_array($result_code);

$itemCode = $row_code["materialRatioID"];
echo $itemCode;?></td>
          <td class="normalfntMid"  ><?php echo $rowdata["intMatReqYear"]."/".$rowdata["intMatRequisitionNo"];?></td>
          <td class="normalfnt"><?php echo $rowdata["strItemDescription"];?></td>
          <td class="normalfntMid"><?php echo $rowdata["strColor"];?></td>
        <td class="normalfntMid"><?php echo $rowdata["strSize"];?></td>
		<td class="normalfntMid"><?php echo $rowdata["strUnit"];?></td>
        <td class="normalfntRite"><?php echo $rowdata["dblQty"];?></td>
        <td class="normalfntRite">
<?php          


$sqlLoc = "SELECT strBinName,storeslocations.strLocName FROM stocktransactions 
		  INNER JOIN storesbinallocation ON stocktransactions.strMainStoresID = storesbinallocation.strMainID 
		  Inner Join storeslocations ON storeslocations.strLocID = storesbinallocation.strLocID
AND stocktransactions.strSubStores = storesbinallocation.strSubID AND stocktransactions.strLocation = storesbinallocation.strLocID 
 AND stocktransactions.strBin = storesbinallocation.strBinID INNER JOIN storesbins ON storesbinallocation.strBinID = storesbins.strBinID
WHERE intDocumentYear = '$IssueYearnew' AND intStyleId = '" . $row["intStyleId"] . "' AND
strBuyerPoNo = '" . $row["strBuyerPONO"] . "' AND intDocumentNo ='$intIssueNo' AND strColor =  '" . $rowdata["strColor"]. "' AND strSize ='" . $rowdata["strSize"]. "' AND strType = 'ISSUE' AND
intMatDetailId = '". $rowdata["intMatDetailID"] ."'";



	$resultLocation = $db->RunQuery($sqlLoc);
while($row_Location=mysql_fetch_array($resultLocation))
{      
	echo $row_Location["strLocName"]. "<br/>" .$row_Location["strBinName"];
	break ;
}    
          
          ?></td>
        </tr>
		<?php
		}
		
		}
		?>
      <tr>
        <td colspan="6" class="border-top-fntsize12" style="text-align:center"><b>TOTAL</b></td>
        <td class="border-top-fntsize12" style="text-align:right"><b><?php echo $sum;?></b></td>
        <td class="border-top-fntsize12">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  	<td height="20"/>
  <tr>
  </tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td width="25%" class="bcgl1txt1" height="20"><?php echo $preparedby?></td>
	  <td width="25%" class="bcgl1txt1">&nbsp;</td>        
		<td width="25%" class="bcgl1txt1">&nbsp;</td>
		<td width="25%"  class="bcgl1txt1">&nbsp;</td>         
      </tr>
      <tr>
	   <td class="normalfntMid">PREPARED BY</td>
        <td class="normalfntMid">DISPATCHED BY </td>       
        <td class="normalfntMid">AUTHORIZED BY </td>        
        <td class="normalfntMid">RECEIVED BY </td>		
      </tr>

    </table></td>
  
</table>
<?php 
function getStyleName($styleID)
{
	global $db;
	$SQL = " SELECT strStyle FROM orders WHERE intStyleId='$styleID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strStyle"];	
}

function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}
?>
</body>
</html>
