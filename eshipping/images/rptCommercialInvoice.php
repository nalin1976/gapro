<?php 
session_start();
include "../Connector.php";
$xmldoc=simplexml_load_file('../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['InvoiceNo'];	
$sqlinvoiceheader="SELECT 	
	strInvoiceNo, 
	dtmInvoiceDate, 
	bytType, 
	customers.strName AS CustomerName,
	CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress, 
	customers.strAddress1,
	customers.strAddress2,	
	customers.strcountry AS CustomerCountry,
	buyers.strBuyerID,
	buyers.strName AS BuyerAName, 
	buyers.strAddress1 AS buyerAddress1 ,
	buyers.strAddress2 AS buyerAddress2,
	buyers.strCountry AS BuyerCountry,
	strNotifyID1, 
	strNotifyID2,
	strLCNo AS LCNO,
	dtmLCDate AS LCDate, 
	strLCBankID, 
	dtmLCDate, 
	ID.strPortOfLoading, 
	city.strCity AS city,
	strCarrier, 
	strVoyegeNo, 
	dtmSailingDate, 
	strCurrency, 
	dblExchange, 	
	intNoOfCartons, 
	intMode, 
	strCartonMeasurement, 
	strCBM, 
	strMarksAndNos, 
	strGenDesc, 
	bytStatus, 
	intFINVStatus, 
	intCusdec
		 
	FROM 
	invoiceheader ID
	LEFT JOIN customers ON ID.strCompanyID=customers.strCustomerID
	LEFT JOIN buyers ON ID.strBuyerID =buyers.strBuyerID 
	LEFT JOIN city ON ID.strFinalDest =city.strCityCode 
	WHERE strInvoiceNo='$invoiceNo'";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$dateInvoice"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 
	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web :: Export :: Commercial Invoice</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
.fontColor12 {FONT-SIZE:7PT; ; FONT-FAMILY:Verdana; }
.adornment10 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.fontColor121 {FONT-SIZE:21PT; ; FONT-FAMILY:Verdana; }
.fontColor10 {FONT-SIZE:9PT; ; FONT-FAMILY:Verdana; }
-->
</style>
</head>

<body>
<table width="794" border="0" align="center">
  <tr>
    <td colspan="3" ><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="18%" >&nbsp;</td>
        <td width="66%" ><p class="head2BLCK">COMMERCIAL INVOICE</p></td>
        <td width="16%" >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" cellspacing="0">
      <tr>
        <td colspan="2" class="border-Left-Top-right-fntsize12"><strong>1. SHIPPER</strong></td>
        <td colspan="2" class="border-top-right-fntsize12"><strong>3. NO &amp; DATE OF INVOICE</strong></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['CustomerName'];?></td>
        <td colspan="2" class="border-bottom-right-fntsize12"><span class="paragraph"><?php echo $dataholder['strInvoiceNo'];?> OF <?php echo $dateInvoice ;?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['strAddress1'];?></td>
        <td colspan="2" class="border-right"><strong>4. NO &amp; DATE OF L/C</strong></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['strAddress2'];?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['LCNO']; ?> OF <?php echo $LCDate; ?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><strong>2. FOR ACCOUNT &amp; RISK OF MESSERS</strong></td>
        <td colspan="2" class="border-right-fntsize12"><strong>5. NOTIFY PARTY</strong></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['BuyerAName'];?></td>
        <td colspan="2" class="border-right-fntsize12">
          <?php 

$buyerid=$dataholder['strNotifyID1'];
if ($dataholder['strBuyerID']==$dataholder['strNotifyID1'])
{
	$buyer= "SAME AS CONSIGNEE.";
	echo $buyer;
}
else 
{	
	$sqlselectNotify="SELECT 
	strName, 
	strAddress1, 
	strAddress2, 
	strCountry, 
	strPhone	 
	FROM 
	buyers 
	WHERE strBuyerID='$buyerid'";
	$buyerresult=$db->RunQuery($sqlselectNotify);
	$buyerresultholder=mysql_fetch_array($buyerresult);
	$buyer=$buyerresultholder['strName'];
	$notfyaddress1=$buyerresultholder['strAddress1'];
	$notifyaddress2=$buyerresultholder['strAddress2'];
	$notifycountry=$buyerresultholder['strCountry'];
	echo $buyer;
}



?>        </td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['buyerAddress1'];?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $notfyaddress1;?></td>
        </tr>
	  <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['buyerAddress2']; ?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $notfyaddress2;?></td>
        </tr>
	  <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['BuyerCountry']."."; ?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $notifycountry;?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td width="25%" class="border-left-right-fntsize12"><strong>6. PORT OF LOADING</strong></td>
        <td width="25%" class="border-right-fntsize12"><strong>7. FINAL DESTINATION</strong></td>
        <td width="25%" class="border-right-fntsize12"><strong>8. CARRIER</strong></td>
        <td width="25%" class="border-right-fntsize12"><strong>9. SAILING ON OR ABOUT</strong></td>
      </tr>
      <tr>
        <td class="border-Left-bottom-right-fntsize12"><?php echo $dataholder['strPortOfLoading']; ?></td>
        <td class="border-bottom-right-fntsize12"><?php echo $dataholder['city']; ?></td>
        <td class="border-bottom-right-fntsize12"><?php echo $dataholder['strCarrier']; ?></td>
        <td class="border-bottom-right-fntsize12"> <?php echo $LCDate; ?></td>
      </tr>


    </table></td>
  </tr>

  <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" id="tblInvoice"  >
  <tr>
    <td width="229" class="border-top-left-fntsize12"><strong>10. MARKS & NOS</strong></td>
    <td width="229"  class="border-top-left-fntsize12"><strong>11. DESCRIPTION</strong></td>
    <td width="112" class="border-top-left-fntsize12"><strong>12. QUANTITY</strong></td>
    <td width="118" class="border-top-left-fntsize12"><strong>13. UNIT PRICE</strong></td>
    <td width="100" class="border-Left-Top-right-fntsize12"><strong>14. AMOUNT</strong></td>
	</tr>	
	<tr>
    <td class="border-bottom-left-fntsize12">&nbsp;</td>
    <td class="border-bottom-left-fntsize12">&nbsp;</td>
    <td class="border-bottom-left-fntsize12">&nbsp;</td>
    <td class="border-bottom-left-fntsize12"><div align="center">F.O.B. <span><?php echo $dataholder['strCurrency'];?></span> </div></td>
    <td class="border-Left-bottom-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
 
  <?php
  include "numbertotext.php";
		$sqlinvdtl="
SELECT 	
	invoicedetail.strInvoiceNo, (SELECT strMarksAndNos FROM invoiceheader WHERE  invoicedetail.strInvoiceNo=invoiceheader.strInvoiceNo)AS Marks,
	strStyleID, 
	intItemNo, 
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
	dblCMP, 
	dblAmount, 
	strHSCode, 
	dblGrossMass, 
	dblNetMass, 
	strProcedureCode, 
	strCatNo, 
	intNoOfCTns, 
	strKind
	 
	FROM 
	invoicedetail  
	WHERE invoicedetail.strInvoiceNo='$invoiceNo'
	";  
  $resultinvdtl=$db->RunQuery($sqlinvdtl);
	//$prvrow=mysql_fetch_array($resultinvdtl);  
  //$marks=$prvrow['Marks'];
  $count=0;
  while($row=mysql_fetch_array($resultinvdtl))
   {
    echo "<tr >";
    if($count==0)
    $marks=$row['Marks'];
    else
    $marks='&nbsp;';
    echo "<td >";
    echo "<textarea readonly='readonly' class ='normalfnt_size12 ' style='border:0px; height:160px; width:225px;overflow:hidden;
' >" . $marks. "</textarea></td>";
    //echo   $marks. "</td>";
    echo "<td  style='vertical-align:text-top;'  ><textarea readonly='readonly' class ='normalfnt_size12' style='border:0px; width:225px; height:160px;overflow:hidden;
' >" . $row['strDescOfGoods']. "</textarea></td>";
   	// echo "<td 'class='normalfntRite'>" . $row['strDescOfGoods']. "</td>";
    //$marks="";
    echo "<td style='vertical-align:top;'class='normalfnt-rite_size12'>". $row['dblQuantity']."</td>";
    echo "<td style='vertical-align:top;' class='normalfnt-rite_size12'>".number_format($row['dblUnitPrice'],2)."</td>";
    $totamt+=$row['dblAmount'];
    $totqty+=$row['dblQuantity'];
	$totuntprice+=$row['dblUnitPrice'];
    echo "<td style='vertical-align:top;'class='normalfnt-rite_size12'>".number_format($row['dblAmount'],2)."</td>";
  	echo "</tr>";
  	$count++;
  	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"; 
  }
  	$remdozens=$totqty%12;
	$dozen=($totqty-$remdozens)/12;
	//$totamt=number_format($totamt,2);
  	$totVarValue=convert_number(round($totamt,2));
	$textTotqty=convert_number(round($totqty,2));
	//$convrt = explode(".",round($totamt,2));
	$convrt = explode(".",number_format($totamt,2));
	$textdoz= convert_number(round($dozen,2));
	//$convrt=substr(round($totVALUE,2),-2);
	
	$cents =  $convrt[1];
	
	$totcents=centsname($cents);
    ?>
 
</table></td>
  </tr>
  <tr>
  	<td colspan="2" class="normalfnt_size12"><strong>BALANCE FOB <?php echo $totuntprice *12;?> / DOZEN US DOLLARS PAYBLE COLOMBO</strong></td>	
    <td width="103" class="normalfnt-rite_size12" ><strong><?php echo number_format($totamt,2); ?></strong></td>
  </tr>
  <tr><td colspan="2">&nbsp;</td>
  </tr>
  <tr ><td width="95" class="normalfnt_size12"><div align="left"></div></td>
    <td width="582" class="normalfnt_size12"><div align="left">COUNTRY OF ORIGIN : SRI LANKA <br/>
      TOTAL FOB COLOMBO US DOLLARS <?php echo $totVarValue;?> <?php echo $totcents; ?> CENTS ONLY <br/>
      TOTAL
      PCS : <?php echo $textTotqty;?> <br/>
      TEXTILE QUOTA CATEGORY NO : PYJAMA / 641 <br/>
    TOTAL DOZENS :  <?php echo $textdoz." AND ".$remdozens."/12 " ;?> DOZENS ONLY.</div></td>
    <td class="normalfnt_size12"><div align="left"></div></td>
  </tr>
</table>
</body>
</html>
