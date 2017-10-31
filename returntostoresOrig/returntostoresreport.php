<?php
session_start();
include "../Connector.php";
$backwardseperator = '../';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro Web :: Style Items Return To Stores Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<?php 
	$pub_ReturnNo=$_GET["ReturnNo"];
	$pub_ReturnYear=$_GET["ReturnYear"];
?>
<table width="800" border="0" align="center">
  <tr>
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
<?php
	 $SQLHeader="SELECT ".
				"CONCAT(RSH.intReturnYear,'/',RSH.intReturnNo) AS ReturnNo, ".
				"RSH.dtmRetDate, ".
				"RSH.intStatus, ".
				"RSH.strRemarks, ".
				"RSH.intCompanyID, ".				
				"UA.Name, ".
				"(select UA.Name from useraccounts AS UA where UA.intUserID = RSH.intCancledBy) as CancelledBy, ".
				"(select UA.Name  from useraccounts AS UA where UA.intUserID = RSH.intConfirmedBy) as ConfirmBy, ".
				"strDepartment, ".
				"RSH.dtmCreateDate ".
				"FROM returntostoresheader AS RSH ".
				"Inner Join useraccounts AS UA ON UA.intUserid = RSH.intCreateBy ".				
				"Inner Join department ON RSH.strReturnedBy = department.intDepID ".
				"WHERE RSH.intReturnNo ='$pub_ReturnNo' AND ".
				"RSH.intReturnYear ='$pub_ReturnYear'"; 			
			$resultHeader=$db->RunQuery($SQLHeader);	
			while($row=mysql_fetch_array($resultHeader))
			{
				$ReturnNo 		= $row["ReturnNo"];				
				$Date			= $row["dtmRetDate"];
				$Remarks		= $row["strRemarks"];
				$UsrNme			= $row["Name"];						
				$Status			= $row["intStatus"];	
				$ReturnBy		= $row["strDepartment"];	
				$CancelledBy	= $row["CancelledBy"];
				$ConfirmBy      = $row["ConfirmBy"];
				$report_companyId	= $row["intCompanyID"];			
			}
?>
      <tr>
        <td><?php include '../reportHeader.php'?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="36" colspan="7" class="head2">STYLE - RETURN TO STORES </td>
      </tr>

      <tr>
        <td width="12%" class="normalfnth2B">Return No </td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="35%" class="normalfnt"><?php echo $ReturnNo;?></td>
        <td width="12%">&nbsp;</td>
        <td width="11%" class="normalfnth2B">Return By</td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="28%" class="normalfnt"><?php echo $ReturnBy ;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">Date</td>
        <td height="13" class="normalfnth2B">:</td>
        <td class="normalfnt" ><?php echo $Date ;?></td>
        <td>&nbsp;</td>
        <td colspan="2" class="normalfnth2B">&nbsp;</td>
        <td width="28%" valign="top" class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td width="92" bgcolor="#FFFFFF" class="normalfnth2B">Remarks</td>
    <td width="4" bgcolor="#FFFFFF" class="normalfnth2B">:</td>
    <td width="690" valign="top" bgcolor="#FFFFFF" class="normalfnt"><?php echo $Remarks ;?></td>
  </tr>
  <tr>  	
    <td colspan="3" bgcolor="#FFFFFF" class="normalfntRiteSML"><div align="center"><span class="style4"><?PHP 
	if($Status==0)
	//echo  "THIS IS NOT A VALID REPORT";?>
	</span></div></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tablez">
      <tr>
        <td class="normalfntBtab">Grn No</td>
	  	<td class="normalfntBtab">Issue No </td>        
        <td width="50%" height="25" class="normalfntBtab">Description</td>
        <td width="13%" class="normalfntBtab">Color</td>
        <td width="9%" class="normalfntBtab">Size</td>
        <td width="8%" class="normalfntBtab">Unit</td>
        <td width="10%" class="normalfntBtab">Issue Qty </td>
        <td width="10%" class="normalfntBtab">Return Qty</td>
        </tr>
<?php
	$SqlDetail1="select distinct returntostoresdetails.intStyleId,strBuyerPoNo, O.strOrderNo 
		 from returntostoresdetails Inner join orders O ON O.intStyleId = returntostoresdetails.intStyleId   ".
				"where intReturnNo='$pub_ReturnNo' and ".
				"intReturnYear='$pub_ReturnYear'";
		$resultDetail1=$db->RunQuery($SqlDetail1);			
			while($row1=mysql_fetch_array($resultDetail1))
			{
				$StyleId = $row1["intStyleId"];
?>
		   <tr>
        <td colspan="8" class="normalfntTAB"><table width="100%" border="0" class="normalfnt2BITAB">
          <tr>
            <td width="10%">Order No   :</td>
            <td width="21%"><?php echo $row1["strOrderNo"];?></td>
            <td width="5%">SCNo : </td>
            <td width="11%">
<?PHP
$sqlscno="select intSRNO from specification where intStyleId='$StyleId';";
$result_scno = $db->RunQuery($sqlscno);
while($row_scno=mysql_fetch_array($result_scno))
{
	$scno = $row_scno["intSRNO"];
	echo $scno;
}
?>			</td>
            <td width="10%">Buyer PONo :</td>
            <td width="14%"><?php 
			$buyerPOName = $row1["strBuyerPoNo"];
			if($buyerPOName !='#Main Ratio#')
			   $buyerPOName= getBuyerPOName($StyleId,$row1["strBuyerPoNo"]);
			  echo $buyerPOName;
		?></td> 
			<td width="6%"></td>			         
          </tr>
        
            <td width="10%">Buyer : </td>
              <td  colspan="6">
<?PHP
$sqlbuyer="SELECT ".
			"buyers.strName, ".
			"orders.intStyleId ".
			"FROM ".
			"orders ".
			"Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID ".
			"WHERE ".
			"orders.intStyleId ='".$row1["intStyleId"]."';";
			
			$resultBuyer=$db->RunQuery($sqlbuyer);			
			while($row_Buyer=mysql_fetch_array($resultBuyer))
			{
				echo $row_Buyer["strName"];
			}
?>			</td>
         
          </tr>
       
        </table></td>
        </tr>
	<?php
	
	$SqlDetail2="SELECT ".
				"CONCAT(ID.intIssueYear,'/',ID.intIssueNo) AS IssueNo, ".
				"CONCAT(ID.intGrnYear,'/',ID.intGrnNo) AS GrnNo, ".
				"MIL.strItemDescription, ".
				"RSD.strColor, ".
				"RSD.strSize, ".
				"MIL.strUnit, ".
				"RSD.dblReturnQty, ".
				"ID.dblQty ".
				"FROM ".
				"returntostoresdetails AS RSD ".
				"Inner Join matitemlist AS MIL ON RSD.intMatdetailID = MIL.intItemSerial ".
				"Inner Join issuesdetails AS ID ON ID.intIssueNo = RSD.intIssueNo AND RSD.intIssueYear = ID.intIssueYear AND ID.intStyleId = RSD.intStyleId AND RSD.strBuyerPoNo = ID.strBuyerPONO AND ID.intMatDetailID = RSD.intMatdetailID AND ID.strColor = RSD.strColor AND RSD.strSize = ID.strSize AND RSD.intGrnYear = ID.intGrnYear AND RSD.intGrnNo = ID.intGrnNo ".
				"WHERE ".
				"RSD.intStyleId ='".$row1["intStyleId"]."' AND ".
				"RSD.strBuyerPoNo ='".$row1["strBuyerPoNo"]."' AND ".
				"RSD.intReturnNo='$pub_ReturnNo' AND ".
				"RSD.intReturnYear='$pub_ReturnYear'";
	$resultDetail2=$db->RunQuery($SqlDetail2);			
	while($row2=mysql_fetch_array($resultDetail2))
	{			
?>
	<tr>
	  <td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row2["GrnNo"];?>&nbsp;</td>  
		<td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row2["IssueNo"];?>&nbsp;</td>	     
        <td class="normalfntTAB"><?php echo $row2["strItemDescription"];?></td>
        <td class="normalfntTAB"><?php echo $row2["strColor"];?></td>
        <td class="normalfntTAB"><?php echo $row2["strSize"];?></td>
        <td class="normalfntTAB"><?php echo $row2["strUnit"];?></td>
        <td class="normalfntRiteTAB"><?php echo $row2["dblQty"];
									$IssueQtuSum +=$row2["dblQty"];?></td>
        <td class="normalfntRiteTAB"><?php echo $row2["dblReturnQty"];
									$ReturnSum +=$row2["dblReturnQty"]?></td>
    </tr>
		
<?php
	}
}
?>
	 <tr>
        <td colspan="6" class="normalfnt2bldBLACKmid">Grand Total</td>       
		<td class="normalfntRiteTABb-ANS"><?php echo $IssueQtuSum;?></td>
		<td class="normalfntRiteTABb-ANS"><?php echo $ReturnSum;?></td> 
        </tr>   
    </table></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
 <!--   <td colspan="2" class="normalfnBLD1">PAYMENT WILL BE MADE STRICTLY UP TO THE QUANTITY AND THE RELEVANT VALUE OF THE PURCHASE ORDER.</td>-->
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0">
      <tr>
	  <td width="5%">&nbsp;</td>
        <td width="25%" bgcolor="#FFFFFF" class="bcgl1txt1"><?php echo $UsrNme?></td>        
		<td width="25%" bgcolor="#FFFFFF"  class="bcgl1txt1"><?php echo $ConfirmBy; ?></td>
		<td width="25%" bgcolor="#FFFFFF"  class="bcgl1txt1"><?php echo $CancelledBy?></td>
         <td width="5%">&nbsp;</td>
      </tr>
      <tr>
	   <td >&nbsp;</td>
        <td class="normalfntMid">Prepared By</td>       
        <td class="normalfntMid">Authorised By </td>        
        <td class="normalfntMid">Cancelled By</td>
		<td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
<?php
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
} 
if($Status==10)
{
	echo "<div style=\"position:absolute;top:120px;left:400px;\"><img src=\"../images/cancelled.png\" style=\"-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);\" /></div>";
}
else if($Status==0)
{
	echo "<div style=\"position:absolute;top:120px;left:180px;\"><img src=\"../images/pending.png\"/></div>";
}


?>
</body>
</html>
