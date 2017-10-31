<?php
session_start();
include "../Connector.php";
$backwardseperator = '../';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Style Items Return To Supplier - Report</title>
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
	
/*		$pub_ReturnNo 	= "119";
		$pub_ReturnYear	= "2009";*/
?>
<table width="850" border="0" align="center">
  <tr>
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
	  <?php

	 $SQLHeader="SELECT ".
				"CONCAT(RSH.intReturnToSupYear,'/',RSH.intReturnToSupNo) AS ReturnNo, ".
				"RSH.dtmRetDate, ".
				"RSH.intStatus, ".
				"RSH.strRemarks, ".				
				"RSH.intCompanyID, ".				
				"UA.Name, ".
				"S.strTitle, ".
				"S.strAddress1 AS SstrAddress1, ".
				"S.strAddress2 AS SstrAddress2, ".
				"S.strStreet AS SstrStreet, ".
				"S.strCity AS SstrCity, ".
				"S.strCountry AS SstrCountry, ".
				"S.strZipCode AS SstrZipCode, ".
				"S.strPhone AS SstrPhone, ".
				"S.strFax AS SstrFax, ".
				"S.strEMail AS SstrEMail, ".
				"S.strWeb AS SstrWeb, ".
				"(select UA.Name from useraccounts AS UA where UA.intUserID = RSH.intCancelUserID) as CancelledBy, ".
				"CO.strRegNo, ".
				"CO.strVatAcNo ".
				"FROM returntosupplierheader AS RSH ".
				"Inner Join useraccounts AS UA ON RSH.intRetUserId = UA.intUserID ".
				"Inner Join companies AS CO ON UA.intCompanyID = CO.intCompanyID ".
				"Inner Join suppliers AS S ON RSH.intRetSupplierID = S.strSupplierID ".
				"WHERE RSH.intReturnToSupNo ='$pub_ReturnNo' AND RSH.intReturnToSupYear ='$pub_ReturnYear'"; 		
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
				$Supplier		= $row["strTitle"];			
				$SstrAddress1	= $row["SstrAddress1"];
				$SstrAddress2	= $row["SstrAddress2"];
				$SStreet		= $row["SstrStreet"];	
				$SCity			= $row["SstrCity"];	
				$SCountry		= $row["SstrCountry"];	
				$SZipCode		= $row["SstrZipCode"];	
				$SPhone			= trim($row["SstrPhone"])=="" ? "":"Tel : ".trim($row["SstrPhone"]);	
				$SFax			= trim($row["SstrFax"])=="" ? "":"Fax : ".trim($row["SstrFax"]);	
				$SEMail			= trim($row["SstrEMail"])=="" ? "":"E-Mail : ".trim($row["SstrEMail"]);	
				$SWeb			= trim($row["SstrWeb"])=="" ? "":"Web : ".trim($row["SstrWeb"]);
				$companyReg		= $row["strRegNo"];
				$strVatNo 		= $row["strVatAcNo"];	
				$report_companyId	= $row["intCompanyID"];	
			}
?>
        <td><?php include '../reportHeader.php'?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="36" colspan="6" class="head2">STYLE - RETURN TO SUPPLIER </td>
      </tr>

      <tr>
        <td width="11%" valign="baseline" class="normalfnth2B">Supplier </td>
        <td width="1%" valign="baseline" class="normalfnth2B">:</td>
        <td width="52%" class="normalfnt"><?php echo $Supplier ?>
		 <p class="normalfntSM"><?php echo $SstrAddress1."".$SstrAddress2."";?></p>
		  <p class="normalfntSM"><?php echo $SStreet."".$SCity."".$SCountry."";?></p>
		 <?php if($SPhone!=""){?>
		  <p class="normalfnt"><?php echo $SPhone ." ". $SFax;?></p>
		  <?php }?>
		  <?php if($SEMail!=""){?>
		  <p class="normalfntSM"><?php echo $SEMail ." ".$SWeb ?></p> </td>
		   <?php }?>
        <td width="10%"><span class="normalfnth2B">Return No</span></td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="25%" class="normalfnt"><?php echo $ReturnNo;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt" >&nbsp;</td>
        <td><span class="normalfnth2B">Date</span></td>
        <td class="normalfnth2B">:</td>
        <td width="25%" valign="top" class="normalfnt"><?php echo $Date ;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="85" class="normalfnth2B">Remarks  </td>
    <td width="4" class="normalfnth2B">:</td>
    <td width="697" valign="top" class="normalfnt"><?php echo $Remarks ;?></td>
  </tr>
  <tr>  	
<!--    <td colspan="3" class="normalfntRiteSML"><div align="center"><span class="style4"><?PHP echo $Status==1? "":"THIS IS NOT A VALID REPORT";?></span></div></td>-->
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tablez">
      <tr>
	  	<td width="11%" class="normalfntBtab">GRN No </td>    
		<td width="11%" class="normalfntBtab">PO No </td>      
        <td width="37%" height="25" class="normalfntBtab">Description</td>
        <td width="13%" class="normalfntBtab">Color</td>
        <td width="9%" class="normalfntBtab">Size</td>
        <td width="8%" class="normalfntBtab">Unit</td>
        <td width="11%" class="normalfntBtab">GRN Qty</td>
        <td width="11%" class="normalfntBtab">Return Qty</td>
        <td width="11%" class="normalfntBtab">Item Code</td>
        </tr>
<?php
	$SqlDetail1="select distinct returntosupplierdetails.intStyleId,strBuyerPoNo, O.strOrderNo 
				 from returntosupplierdetails 
				 Inner join orders O ON O.intStyleId = returntosupplierdetails.intStyleId  ".
				"where intReturnToSupNo='$pub_ReturnNo' and ".
				"intReturnToSupYear='$pub_ReturnYear'";
		
		$resultDetail1=$db->RunQuery($SqlDetail1);			
			while($row1=mysql_fetch_array($resultDetail1))
			{
			$StyleId = $row1["intStyleId"];
?>
		   <tr>
        <td colspan="9" class="normalfntTAB"><table width="100%" border="0" class="normalfnt2BITAB">
          <tr>
            <td width="10%">Order NO   :</td>
            <td width="18%"><?php echo $row1["strOrderNo"];?></td>
            <td width="6%">ScNo : </td>
            <td width="11%">
<?PHP
$sqlscno="select intSRNO from specification where intStyleId='".$row1["intStyleId"]."';";
$result_scno = $db->RunQuery($sqlscno);
while($row_scno=mysql_fetch_array($result_scno))
{
	$scno = $row_scno["intSRNO"];
	echo $scno;
}
?>
</td>
            <td width="13%">Buyer PoNo :</td>
            <td width="14%"><?php
			$buyerPOName = $row1["strBuyerPoNo"];
			if($buyerPOName !='#Main Ratio#')
			   $buyerPOName= getBuyerPOName($StyleId,$row1["strBuyerPoNo"]);
			  echo $buyerPOName;
			  ?></td> 
			<td width="6%"></td>			         
            
          </tr>
          
				          <tr>
            <td width="10%">Buyer : </td>
            <td colspan="6">
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
	
	#===============================================================================================
	# Comment On - 03/21/2014
	# Description - To add item code from material ratio to the report
	#===============================================================================================
	/*$SqlDetail2="SELECT ".
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
				"RSD.intReturnToSupYear =  '$pub_ReturnYear'";*/
				
	#===============================================================================================
	
	$SqlDetail2 = " SELECT
CONCAT(GH.intGRNYear,'/',GH.intGrnNo) AS GrnNo,
CONCAT(GH.intYear,'/',GH.intPoNo) AS PoNo,
RSD.dblQty AS ReturnQty,
RSD.strColor,
RSD.strSize,
RSD.intMatdetailID,
MIL.strItemDescription,
MIL.strUnit,
materialratio.materialRatioID
FROM
returntosupplierdetails AS RSD
Inner Join grnheader AS GH ON GH.intGrnNo = RSD.intGrnNo AND RSD.intGrnYear = GH.intGRNYear
Inner Join matitemlist AS MIL ON MIL.intItemSerial = RSD.intMatdetailID
Inner Join materialratio ON RSD.intStyleId = materialratio.intStyleId AND RSD.intMatdetailID = materialratio.strMatDetailID AND RSD.strColor = materialratio.strColor AND RSD.strSize = materialratio.strSize AND RSD.strBuyerPoNo = materialratio.strBuyerPONO 
WHERE 
RSD.intStyleId ='".$row1["intStyleId"]."' AND RSD.strBuyerPoNo ='".$row1["strBuyerPoNo"]."' AND 
RSD.intReturnToSupNo =  '$pub_ReturnNo' AND RSD.intReturnToSupYear =  '$pub_ReturnYear'";
	
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
        <td class="normalfntRiteTAB"><?php echo $row2["materialRatioID"]; ?></td>                            
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
        <td class="normalfntMid">Prepared By</td>       
        <td class="normalfntMid">Authorised By </td>        
        <td class="normalfntMid">Cancel By</td>
		<td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
<?php
if($Status != 1)
{
?>
<div style="position:absolute;top:100px;left:400px;"><img src="../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php
}
?>

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
