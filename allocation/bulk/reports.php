<?php
session_start();
include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ePlan Web :: Style Items Return To Supplier Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
	//$pub_transferNo=$_GET["transferNo"];
	//$pub_transferYear=$_GET["transferYear"];
	
	$pub_transferNo		= 106;
	$pub_transferYear	= 2010;
?>
<table width="800" border="0" align="center">
  <tr>
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <?php

	 $SQLHeader="SELECT BH.dtmDate, BH.intStatus, BH.strRemarks, CO.strName, CO.strAddress1, CO.strAddress2, CO.strStreet, CO.strCity, CO.strCountry, CO.strZipCode, CO.strPhone, CO.strEMail, CO.strFax, CO.strWeb, UA.Name, 
(select UA.Name from useraccounts AS UA where UA.intUserID = BH.intCancelBy) as CancelledBy,
CO.strRegNo, CO.strVatAcNo 
FROM commonstock_bulkheader BH Inner Join useraccounts AS UA ON BH.intUserId = UA.intUserID 
Inner Join companies CO ON BH.intCompanyId = CO.intCompanyID 
WHERE BH.intTransferNo ='$pub_transferNo' AND BH.intTransferYear ='$pub_transferYear'"; 		
	
			$resultHeader=$db->RunQuery($SQLHeader);	
		
			while($row=mysql_fetch_array($resultHeader))
			{
				
				$ReturnNo 		= $row["ReturnNo"];				
				$Date			= $row["dtmRetDate"];
				$Remarks		= $row["strRemarks"];
				$UsrNme			= $row["Name"];
				$CompanyName 	= $row["strName"];
				$Address1    	= $row["strAddress1"];
				$Address2    	= $row["strAddress2"];
				$Street    		= $row["strStreet"];
				$City    		= $row["strCity"];
				$Country    	= $row["strCountry"];
				$ZipCode    	= $row["strZipCode"];
				$Phone    		= $row["strPhone"];
				$Fax    		= $row["strFax"];
				$EMail    		= $row["strEMail"];				
				$Web    		= $row["strWeb"];				
				$Status			= $row["intStatus"];	
				$ReturnBy		= $row["strDepartment"];	
				$CancelledBy	= $row["CancelledBy"];
				$companyReg		= $row["strRegNo"];
				$strVatNo 		= $row["strVatAcNo"];		
			}			
?>
        <td width="71%"  align="center" class="tophead"><p class="topheadBLACK"><?php echo $CompanyName;?></p>
            <p class="normalfntMid"><?php echo $Address1.",".$Address2.",".$Street.",".$City.",".$Country.".";?></p>
			<p class="normalfntMid"><?php echo "Tel : "."(".($ZipCode).") ".$Phone." , Fax : "."(".($ZipCode).") ".$Fax.".";?></p>
          <p class="normalfntMid"><?php echo "E-Mail : ".$EMail." , Web : ".$Web ?></p>
		  <p class="normalfntMidSML" ><?php echo ($strVatNo==""?"":" VAT NO: $strVatNo") . "   &nbsp;&nbsp; :&nbsp;&nbsp " . ($companyReg==""?"":"  Company Reg. No : $companyReg ") ?></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td width="100%" height="36" colspan="6" class="head2">Bulk Allocation </td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td width="85" class="normalfnth2B">Transfer No </td>
    <td width="4" class="normalfnth2B">:</td>
    <td width="697" valign="top" class="normalfnt"><?php echo $pub_transferYear.'/'.$pub_transferNo ;?></td>
  </tr>
    <tr>
    <td width="85" class="normalfnth2B">Remarks</td>
    <td width="4" class="normalfnth2B">:</td>
    <td width="697" valign="top" class="normalfnt"><?php echo $Remarks ;?></td>
  </tr>
  <tr>  	
    <td colspan="3" class="normalfntRiteSML"><div align="center"><span class="style4"><?PHP echo $Status==1? "":"THIS IS NOT A VALID REPORT";?></span></div></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tablez">
      <tr>
	  	<td width="11%" class="normalfntBtab">GRN NO </td>    
		<td width="11%" class="normalfntBtab">PO NO </td>      
        <td width="37%" height="25" class="normalfntBtab">DISCRIPTION</td>
        <td width="13%" class="normalfntBtab">COLOR</td>
        <td width="9%" class="normalfntBtab">SIZE</td>
        <td width="8%" class="normalfntBtab">UNIT</td>
        <td width="11%" class="normalfntBtab">GRN QTY</td>
        <td width="11%" class="normalfntBtab">RETURN QTY</td>
        </tr>
<?php
	$SqlDetail1="select distinct returntosupplierdetails.intStyleId,strBuyerPoNo, O.strStyle 
				 from returntosupplierdetails 
				 Inner join orders O ON O.intStyleId = returntosupplierdetails.intStyleId  ".
				"where intReturnToSupNo='$pub_ReturnNo' and ".
				"intReturnToSupYear='$pub_ReturnYear'";
		
		$resultDetail1=$db->RunQuery($SqlDetail1);			
			while($row1=mysql_fetch_array($resultDetail1))
			{
			$StyleId = $row1["intStyleId"];
?>
		   
	<?php
	
	$SqlDetail2="SELECT ".
				"CONCAT(GH.intGRNYear,'/',GH.intGrnNo) AS GrnNo, ".
				"CONCAT(GH.intYear,'/',GH.intPoNo) AS PoNo, ".
				"RSD.dblQty AS ReturnQty, ".
				"RSD.strColor, ".
				"RSD.strSize, ".
				"RSD.intMatdetailID, ".
				"MIL.strItemDescription, ".
				"MIL.strUnit ".
				"FROM ".
				"returntosupplierdetails AS RSD ".
				"Inner Join grnheader AS GH ON GH.intGrnNo = RSD.intGrnNo AND RSD.intGrnYear = GH.intGRNYear ".
				"Inner Join matitemlist AS MIL ON MIL.intItemSerial = RSD.intMatdetailID ".
				"WHERE ".
				"RSD.intStyleId ='".$row1["intStyleId"]."' AND ".
				"RSD.strBuyerPoNo ='".$row1["strBuyerPoNo"]."' AND ".
				"RSD.intReturnToSupNo =  '$pub_ReturnNo' AND ".
				"RSD.intReturnToSupYear =  '$pub_ReturnYear'";
				
	
	$resultDetail2=$db->RunQuery($SqlDetail2);			
	while($row2=mysql_fetch_array($resultDetail2))	
	{			
		$grnNo 			= $row2["GrnNo"];
		$grnNoArray	= explode('/',$grnNo);
?>
	<tr>  
		<td class="normalfntTAB"><?php echo $row2["GrnNo"];?></td>
		<td class="normalfntTAB"><?php echo $row2["PoNo"];?></td>	     
        <td class="normalfntTAB"><?php echo $row2["strItemDescription"];?></td>
        <td class="normalfntTAB"><?php echo $row2["strColor"];?></td>
        <td class="normalfntTAB"><?php echo $row2["strSize"];?></td>
        <td class="normalfntTAB"><?php echo $row2["strUnit"];?></td>
        <td class="normalfntRiteTAB"><?php 
		
$sqlgrnqty="SELECT ".
			"GD.dblQty ".
			"FROM ".
			"grndetails AS GD ".
			"WHERE ".
			"GD.intGrnNo ='$grnNoArray[1]' AND ".
			"GD.intGRNYear =  '$grnNoArray[0]' AND ".
			"GD.intStyleId = '".$row1["intStyleId"]."' AND ".
			"GD.strBuyerPONO = '".$row1["strBuyerPoNo"]."' AND ".
			"GD.intMatdetailID='".$row2["intMatdetailID"]."' AND ".
			"GD.strColor =  '".$row2["strColor"]."' AND ".
			"GD.strSize = '".$row2["strSize"]."'";
		
			$resultgrn=$db->RunQuery($sqlgrnqty);			
	while($row_grn=mysql_fetch_array($resultgrn))	{
	
			echo $row_grn["dblQty"];
									$ReturnQtySum +=$row_grn["dblQty"];
    }
	?></td>
	    <td class="normalfntRiteTAB"><?php echo $row2["ReturnQty"];
									$ReturnSum +=$row2["ReturnQty"]?></td>
    </tr>
		
<?php
	}
}
?>
	 <tr>
        <td colspan="6" class="normalfnt2bldBLACKmid">Grand Total</td>       
		<td class="normalfntRiteTABb-ANS"><?php echo $ReturnQtySum;?></td>
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
		<td width="25%" bgcolor="#FFFFFF"  class="bcgl1txt1">&nbsp;</td>
		<td width="25%" bgcolor="#FFFFFF"  class="bcgl1txt1"><?php echo $CancelledBy?></td>
         <td width="5%">&nbsp;</td>
      </tr>
      <tr>
	   <td >&nbsp;</td>
        <td class="normalfntMid">PREPARED BY</td>       
        <td class="normalfntMid">AUTHORISED BY </td>        
        <td class="normalfntMid">CANCEL BY</td>
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
?>
</body>
</html>
