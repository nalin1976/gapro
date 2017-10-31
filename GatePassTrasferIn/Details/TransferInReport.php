<?php
include "../../Connector.php";
$backwardseperator = '../../';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gate Pass TransferIn :: Report</title>
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
	$pubTransInNo=$_GET["TransferInNo"];
	$pubTransInYear=$_GET["TransferInYear"];
?>
<table width="800" border="0" align="center">
  <tr>
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
<?php
$SQLHeader="SELECT ".
"CONCAT(TIH.intTINYear,'/',TIH.intTransferInNo) AS TransferInNo, ".
"CONCAT(TIH.intGPYear,'/',TIH.intGatePassNo) AS GatePassNo, ".
"TIH.dtmDate, ".
"TIH.intStatus, ".
"TIH.strRemarks, ".
"TIH.intStatus, ".
"UA.Name, ".
"TIH.intCompanyId ".				
"FROM ".
"gategasstransferinheader AS TIH ".
"Inner Join useraccounts AS UA ON TIH.intUserid = UA.intUserID ".
"Inner Join companies AS CO ON UA.intCompanyID = CO.intCompanyID ".
"WHERE ".
"TIH.intTransferInNo ='$pubTransInNo' AND ".
"TIH.intTINYear ='$pubTransInYear'";

$resultHeader=$db->RunQuery($SQLHeader);			
while($row=mysql_fetch_array($resultHeader))
{
$TransferInNo 		= $row["TransferInNo"];
$GatePassNo			= $row["GatePassNo"];
$Date				= $row["dtmDate"];
$Remarks			= $row["strRemarks"];
$UserName			= $row["Name"];	
$Status				= $row["intStatus"];
$report_companyId	= $row["intCompanyId"];
}
?>
      <tr>
        <td><?php include '../../reportHeader.php'?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="6" class="head2">TRANSFER IN (From Gate Pass)</td>
      </tr>

      <tr>
        <td width="16%" class="normalfnth2B">TRANSFER IN NO </td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="31%" class="normalfnt"><?php echo $TransferInNo;?></td>
        <td width="12%">&nbsp;</td>
        <td width="15%" class="normalfnth2B">GATE PASS NO : </td>
        <td width="25%" class="normalfnt"><?php echo $GatePassNo ;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">DATE</td>
        <td height="13" class="normalfnth2B">:</td>
        <td class="normalfnt" ><?php echo $Date ;?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td width="25%" valign="top" class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td width="124" class="normalfnth2B">REMARKS</td>
    <td width="4" class="normalfnth2B">:</td>
    <td width="658" valign="top" class="normalfnt"><?php echo $Remarks ;?></td>
  </tr>
 <!-- <tr>
    <td colspan="2" class="normalfnth2B"><p class="normalfnth2B">PLEASE SUPPLY IN ACCORDANCE WITH THE INSTRUCTIONS HEREIN THE FOLLOWING : </p>
    <p class="normalfntSM">PLEASE INDICATE OUR P.O NO IN ALL YOUR INVOICES, PERFORMA INVOICES AND OTHER RELEVANT DOCUMENTS AND DELIVER TO THE ABOVE MENTIONED DESTINATION AND INVOICE TO THE CORRECT PARTY.</p></td>
  </tr>-->
  <tr>  	
    <td colspan="3" class="normalfntRiteSML"><div align="center"><span class="style4"><?PHP echo $Status==1? "":"THIS IS NOT A VALID REPORT";?></span></div></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>        
        <td width="36%" height="25" class="normalfntBtab">Description</td>
        <td width="12%" class="normalfntBtab">Color</td>
        <td width="8%" class="normalfntBtab">Size</td>
        <td width="7%" class="normalfntBtab">Unit</td>
        <td width="10%" class="normalfntBtab">TransIn Qty </td>
        <td width="9%" class="normalfntBtab">Bin Qty </td>
        <td width="18%" class="normalfntBtab">Location:Bin</td>
        </tr>
<?php
	$SqlDetail1="select distinct O.strOrderNo,GTD.intStyleId,GTD.strBuyerPONO ".
				"from gategasstransferindetails GTD ".
				"inner join orders O on O.intStyleId=GTD.intStyleId ".
				"where GTD.intTransferInNo='$pubTransInNo' ".
				"and GTD.intTINYear='$pubTransInYear'";
		
		$resultDetail1=$db->RunQuery($SqlDetail1);			
			while($row1=mysql_fetch_array($resultDetail1))
			{
				$buyerPONO	 = $row1["strBuyerPONO"];
				$styleid	 = $row1["intStyleId"];
				$buyerPoName = $row1["strBuyerPONO"];
				
				if($buyerPONO != '#Main Ratio#')
					$buyerPoName = getBuyerPOName($styleid,$buyerPONO);
?>
		   <tr>
        <td colspan="7" class="normalfntTAB"><table width="100%" border="0" class="normalfnt2BITAB">
          <tr>
            <td width="14%">Order No  :</td>
            <td width="20%"><?php echo $row1["strOrderNo"];?></td>
            <td width="6%">SCNO : </td>
            <td width="23%">
<?PHP
$sqlscno="select intSRNO from specification where intStyleId='".$row1["intStyleId"]."';";
$result_scno = $db->RunQuery($sqlscno);
while($row_scno=mysql_fetch_array($result_scno))
{
	$scno = $row_scno["intSRNO"];
	echo $scno;
}
?>			</td>
            <td width="9%">BUYER PO :</td>
            <td width="28%"><?php echo $buyerPoName;?></td> 
			</tr>
        </table></td>
        </tr>
	<?php
	
	$SqlDetail2="SELECT ".
				"MIL.strItemDescription, ".
				"GPD.strColor, ".
				"GPD.strSize, ".
				"MIL.strUnit, ".
				"GPD.dblQty, ".
				"GPD.intMatDetailId ".
				"FROM ".
				"gategasstransferindetails AS GPD ".
				"Inner Join matitemlist AS MIL ON GPD.intMatDetailId = MIL.intItemSerial ".
				"WHERE ".
				"GPD.intStyleId ='".$row1["intStyleId"]."' AND ".
				"GPD.strBuyerPONO ='".$row1["strBuyerPONO"]."' AND ".
				"GPD.intTransferInNo='$pubTransInNo' AND ".
				"GPD.intTINYear='$pubTransInYear'";
	$resultDetail2=$db->RunQuery($SqlDetail2);			
	while($row2=mysql_fetch_array($resultDetail2))
	{
			
			$printed			=false;
			$ItemDescription	=$row2["strItemDescription"];
			$Color				=$row2["strColor"];
			$Size				=$row2["strSize"];
			$Unit				=$row2["strUnit"];
			$Qty				=$row2["dblQty"];	
			
					
			 $sqlBin = "SELECT strBinName,SL.strLocName,ST.dblQty as BinQty,ST.strUnit FROM stocktransactions ST
Inner Join storeslocations SL ON ST.strLocation = SL.strLocID 
INNER JOIN storesbins SB ON ST.strBin = SB.strBinID  
WHERE intDocumentYear = '$pubTransInYear' AND intStyleId = '".$row1["intStyleId"]."' AND strBuyerPoNo = '".$row1["strBuyerPONO"]."' 
AND intDocumentNo ='$pubTransInNo' AND strColor = '".$row2["strColor"]."' AND strSize ='".$row2["strSize"]."' AND strType = 'TI' 
AND intMatDetailId = '".$row2["intMatDetailId"]."'";
			$resultBin=$db->RunQuery($sqlBin);						
			while($row=mysql_fetch_array($resultBin))
			{
				$Unit=$row["strUnit"];
				if ($printed)
				{
	
				$ItemDescription="";
				$Color="";
				$Size="";
				$Unit="";
				$Qty="";	
				}
			
		?>
		       <tr>       
        <td class="normalfntTAB"><?php echo $ItemDescription;?></td>
        <td class="normalfntTAB"><?php echo $Color  ;?></td>
        <td class="normalfntTAB"><?php echo $Size;?></td>
        <td class="normalfntTAB"><?php echo $Unit;?></td>
        <td class="normalfntRiteTAB">
		<?php 		
				echo $Qty;
				$sum +=$Qty;		
		?></td>
        <td class="normalfntRiteTAB">
		<?php
		if (!$printed)
				{ echo $row["BinQty"];}
			$BinSum +=$row["BinQty"];
		?></td>
        <td class="normalfntTAB"><?php 
		if (!$printed){
		echo $row["strLocName"].':'.$row["strBinName"];
		}?></td>
		<?php
		$printed =true;
			}
		?>
        </tr>
		 <tr>
<?php
	}
}
?>
        <td colspan="4" class="normalfnt2bldBLACKmid">Grand Total</td>
        <td class="normalfntRiteTABb-ANS"><?php echo $sum?></td>
		<td class="normalfntRiteTABb-ANS"><?php echo $BinSum?></td> 
        </tr>  
    <!--  <tr>       
        <td class="normalfntBtab">Grand Total</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntRiteTABb-ANS">&nbsp;</td>
        <td class="nfhighlite1">18944</td>
        </tr>-->
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
        <td width="25%" class="bcgl1txt1"><?php echo $UserName?></td>        
		<td width="20%">&nbsp;</td>       
        <td width="25%"  class="bcgl1txt1">&nbsp;</td>
         <td width="5%">&nbsp;</td>
      </tr>
      <tr>
	   <td >&nbsp;</td>
        <td class="normalfntMid">PREPARED BY</td>       
        <td>&nbsp;</td>        
        <td class="normalfntMid">AUTHORIZED BY</td>
		<td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
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