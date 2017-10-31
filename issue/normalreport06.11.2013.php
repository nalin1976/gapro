<?php 

include "../Connector.php"; 
$xml = simplexml_load_file('../config.xml');
$ReportISORequired 			= $xml->companySettings->ReportISORequired;
$DisplayRatioCodeInReport 	= $xml->styleInventory->Issue->DisplayRatioCodeInReport;
$expIssue = explode("/",$_GET["issueNo"]);
$backwardseperator 	= "../";
$userId	= $_GET["UserId"];
$report_companyId  = $_SESSION["FactoryID"];
$colspan = 5;
$intIssueNo =$expIssue[1];
$year = $expIssue[0];
//$intIssueNo="100000";
//$year="2009";

		$sql_issu="SELECT issues.dtmIssuedDate,issues.intIssueNo,issues.intUserid,issues.strProdLineNo,issues.intIssueYear,issues.strSecurityNo,(SELECT useraccounts.Name FROM useraccounts WHERE issues.intUserid = useraccounts.intUserID)AS preparedby,(SELECT department.strDepartment FROM department WHERE department.intDepID = issues.strProdLineNo)AS recever FROM issues WHERE issues.intIssueNo = $intIssueNo AND issues.intIssueYear = $year;";
	
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
    <td colspan="5" class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><?php include "../reportHeader.php";?></td>
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
        <td width="14%" class="normalfnth2B">Issue No </td>
        <td width="2%" class="normalfnth2B">: </td>
        <td width="34%" class="normalfnt"><?php echo $IssueYearnew."/".$intIssueNo;?></td>
        <td width="17%" class="normalfnth2B">Issued Date</td>
        <td width="2%" class="normalfnth2B"> : </td>
        <td width="31%" class="normalfnt"><?php  echo $dtmIssuedDate;?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Issued Store</td>
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
        <td class="normalfnth2B">Product Line To </td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $recever;
		?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Security No </td>
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
    <td colspan="6"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="tablez">
      <tr>
	  <?php if($DisplayRatioCodeInReport=="true"){
	  $colspan = 6;?>
	   <td nowrap="nowrap" height="25" class="normalfntBtab">Item Code</td>
	   <?php } ?>
        <td nowrap="nowrap" height="25" class="normalfntBtab">MRN No</td>
        <td width="35%" class="normalfntBtab">Details</td>
        <td width="14%" class="normalfntBtab">Color</td>
        <td width="9%" class="normalfntBtab">Size</td>
		 <td width="5%" class="normalfntBtab">Unit</td>
        <td width="10%" class="normalfntBtab">Qty</td>
        <td width="18%" class="normalfntBtab">Bin Location</td>
        </tr>
					<?php 
					$sum = 0;
	 $sql_oth="select DISTINCT issuesdetails.intStyleId, issuesdetails.strBuyerPONO, orders.intUserID, useraccounts.Name, orders.intBuyerID, buyers.strName from issuesdetails, orders, useraccounts, buyers,companies where issuesdetails.intIssueNo = $intIssueNo AND issuesdetails.intIssueYear = $year AND issuesdetails.intStyleId = orders.intStyleId AND orders.intCoordinator = useraccounts.intUserID AND orders.intBuyerID = buyers.intBuyerID ;";
			$result_oth = $db->RunQuery($sql_oth);
		while($row=mysql_fetch_array($result_oth ))
		{
		

	?>

      <tr>

        <td colspan="9" class="normalfntTAB">
		<table width="100%" border="0" class="normalfnt2BITAB">
            <?php
			$styleID= $row["intStyleId"];
			 $order =  getStyleName($styleID); 
			 $style =  getStyle($styleID);?>
          <tr>
            <td width="9%">Style :</td>
            <td width="15%"><?php
			$styleID= $row["intStyleId"]; echo $style;?></td>
            <td width="8%">SCNo :</td>
            <td width="11%">
<?PHP
$sqlscno="select intSRNO from specification where intStyleId='".$row["intStyleId"]."';";
$result_scno = $db->RunQuery($sqlscno);
while($row_scno=mysql_fetch_array($result_scno))
{
	$scno = $row_scno["intSRNO"];
	echo $scno;
}
?>			</td>
            <td width="11%">Buyer PONo :</td>
            <td width="15%"><?php echo $row["strBuyerPONO"];?></td>
                <td width="15%">Merchandiser :</td>
                <td width="16%"><?php echo $row["Name"];?></td>         
          </tr>
       
             <tr>
			
			<td>Order No </td>
			<td><?php  echo $order;?></td>
            <td width="9%">Buyer : </td>
            <td colspan="9"><?php echo $row["strName"];?></td>          
        
          </tr>
   
        </table>          </td>
        </tr>
   	  	   <?php

		
		 /*$strSQL = "select DISTINCT issuesdetails.intIssueNo ,issuesdetails.intGrnNo,issuesdetails.intMatDetailID,
issuesdetails.intMatRequisitionNo,issuesdetails.intMatReqYear, matitemlist.strItemDescription, 
issuesdetails.strColor, issuesdetails.strSize, issuesdetails.dblQty, stocktransactions.strUnit,purchaseorderdetails.strRemarks 
from issuesdetails, matitemlist,specificationdetails , stocktransactions,purchaseorderdetails 
where issuesdetails.intStyleId = '" . $row["intStyleId"] . "'' AND issuesdetails.strBuyerPONO='".$row["strBuyerPONO"]."' 
And specificationdetails.strMatDetailID = issuesdetails.intMatDetailID 
And specificationdetails.intStyleId = issuesdetails.intStyleId 
And matitemlist.intItemSerial = stocktransactions.intMatDetailID 
AND issuesdetails.intIssueNo = '$intIssueNo' AND issuesdetails.intIssueYear = '$year' 
AND stocktransactions.strBuyerPoNo = issuesdetails.strBuyerPONO 
AND stocktransactions.intMatDetailId = issuesdetails.intMatDetailID 
AND stocktransactions.strColor = issuesdetails.strColor 
AND stocktransactions.strSize = issuesdetails.strSize 
and stocktransactions.intDocumentNo = issuesdetails.intIssueNo 
and stocktransactions.intDocumentYear =issuesdetails.intIssueYear and stocktransactions.intGrnNo = issuesdetails.intGrnNo 
and stocktransactions.intGrnYear = issuesdetails.intGrnYear and stocktransactions.strGRNType = issuesdetails.strGRNType AND
purchaseorderdetails.intStyleId = issuesdetails.intStyleId AND issuesdetails.strColor = purchaseorderdetails.strColor 
AND issuesdetails.strSize = purchaseorderdetails.strSize AND issuesdetails.strBuyerPONO = purchaseorderdetails.strBuyerPONO 
AND purchaseorderdetails.intMatDetailID = issuesdetails.intMatDetailID";*/

	$strSQL = "select DISTINCT issuesdetails.intIssueNo ,
issuesdetails.intGrnNo,issuesdetails.intMatDetailID,issuesdetails.intMatRequisitionNo,issuesdetails.intMatReqYear, matitemlist.strItemDescription, issuesdetails.strColor, issuesdetails.strSize, issuesdetails.dblQty,  stocktransactions.strUnit from issuesdetails, matitemlist,
stocktransactions where issuesdetails.intStyleId = '" . $row["intStyleId"] . "' AND 
issuesdetails.strBuyerPONO='".$row["strBuyerPONO"]."' And matitemlist.intItemSerial = issuesdetails.intMatDetailID 
AND issuesdetails.intIssueNo = '$intIssueNo' AND issuesdetails.intIssueYear = '$year' AND 
			stocktransactions.strBuyerPoNo = issuesdetails.strBuyerPONO AND 
stocktransactions.intMatDetailId = issuesdetails.intMatDetailID AND 
			stocktransactions.strColor = issuesdetails.strColor AND 
			stocktransactions.strSize = issuesdetails.strSize and 
			stocktransactions.intDocumentNo = issuesdetails.intIssueNo and 
			stocktransactions.intDocumentYear =issuesdetails.intIssueYear and
stocktransactions.intGrnNo = issuesdetails.intGrnNo and
stocktransactions.intGrnYear = issuesdetails.intGrnYear and 
			stocktransactions.strGRNType = issuesdetails.strGRNType";
		
		$resultdata = $db->RunQuery($strSQL);
		while($rowdata=mysql_fetch_array($resultdata))
		{
		$qty=$rowdata["dblQty"];
		$sum += $qty;
		
	  ?>
        <tr>
 <?php if($DisplayRatioCodeInReport=="true"){?>
		<td nowrap="nowrap" class="normalfntTAB"><?php 
$sql_code="select materialRatioID from materialratio 
where intStyleId ='" . $row["intStyleId"] . "'
and strBuyerPONO ='".$row["strBuyerPONO"]."'
and strMatDetailID ='".$rowdata["intMatDetailID"]."'
and strColor ='".$rowdata["strColor"]."'
and strSize ='".$rowdata["strSize"]."'";
$result_code = $db->RunQuery($sql_code);
$row_code =mysql_fetch_array($result_code);

echo $row_code["materialRatioID"];?></td>
<?php } ?>
		<td nowrap="nowrap" class="normalfntTAB">&nbsp;<?php echo $rowdata["intMatReqYear"]."/".$rowdata["intMatRequisitionNo"];?>&nbsp;</td>
		<td class="normalfntTAB"><?php echo $rowdata["strItemDescription"];?></td>
		<td class="normalfntMidTAB"><?php echo $rowdata["strColor"];?></td>
		<td class="normalfntMidTAB"><?php echo $rowdata["strSize"];?></td>
		<td class="normalfntMidTAB"><?php echo $rowdata["strUnit"];?></td>
		<td class="normalfntRiteTAB"><?php echo $rowdata["dblQty"];?></td>
		<td class="normalfntTAB">
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
        <td colspan="<?php echo $colspan;?>" class="normalfnt2bldBLACKmid">TOTAL</td>
        <td class="normalfntRiteTABb-ANS"><?php echo $sum;?></td>
        <td  class="normalfntRiteTABb-ANS">&nbsp;</td>
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
	   <td class="normalfntMid">Prepared By</td>
        <td class="normalfntMid">Dispatched By </td>       
        <td class="normalfntMid">Authorized By </td>        
        <td class="normalfntMid">Received By </td>		
      </tr>

    </table></td>
  
</table>
<?php 
function getStyleName($styleID)
{
	global $db;
	$SQL = " SELECT strOrderNo FROM orders WHERE intStyleId='$styleID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];	
}

function getStyle($styleID)
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
