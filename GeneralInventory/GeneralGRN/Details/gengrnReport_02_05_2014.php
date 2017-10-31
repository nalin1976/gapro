<?php
session_start();
include "../../../Connector.php";

$backwardseperator 	= "../../../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Good Received Note : : Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        
          <?php
		$grnno=$_GET["grnno"];
		
		$GenGRNYear = substr($grnno,0,4);
		
$SQL_alldetails="select gengrnheader.strGenGrnNo,gengrnheader.intYear,gengrnheader.intStatus,gengrnheader.strInvoiceNo,
date(gengrnheader.dtAdviceDate)AS dtAdviceDate,gengrnheader.intConfirmedBy,date(gengrnheader.dtRecdDate) as grnRecDate,
date(gengrnheader.dtmConfirmedDate)AS dtmConfirmedDate, gengrnheader.intUserId,
gengrnheader.strSupAdviceNo, generalpurchaseorderheader.intGenPONo,generalpurchaseorderheader.intYear as POYear,
date(generalpurchaseorderheader.dtmDeliveryDate)AS dtmDeliveryDate, generalpurchaseorderheader.strPINO,
generalpurchaseorderheader.intShipmentModeId,generalpurchaseorderheader.strPayTerm, generalpurchaseorderheader.intPayMode,
suppliers.strTitle,suppliers.strAddress1 as Saddress1,suppliers.strAddress2 as Saddress2,suppliers.strStreet as Sstreet,suppliers.strCity as Scity,
(select strCountry from country where country.intConID=suppliers.strCountry) as Scountry,
(select useraccounts.Name from useraccounts where useraccounts.intUserID = gengrnheader.intConfirmedBy ) as ConfirmedPerson, 
(select shipmentmode.strDescription from shipmentmode where shipmentmode.intShipmentModeId= generalpurchaseorderheader.intShipmentModeId) as ShippingMode, 
(select popaymentmode.strDescription from popaymentmode where popaymentmode.strPayModeId = generalpurchaseorderheader.intPayMode) as PmntMode , 
(select popaymentterms.strDescription from popaymentterms where popaymentterms.strPayTermId = generalpurchaseorderheader.strPayTerm) as PmntTerm , 
(select useraccounts.Name from useraccounts where useraccounts.intUserID = gengrnheader.intUserId) as preparedperson,generalpurchaseorderheader.intCompId 
from gengrnheader,generalpurchaseorderheader,suppliers,companies 
where gengrnheader.strGenGrnNo = '". substr($grnno,5,strlen($grnno)) ."'  and gengrnheader.intYear = '$GenGRNYear' 
AND generalpurchaseorderheader.intGenPONo = gengrnheader.intGenPONo 
AND generalpurchaseorderheader.intYear = gengrnheader.intGenPOYear 
AND generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID 
AND generalpurchaseorderheader.intDeliverTo = companies.intCompanyID";

//echo $SQL_alldetails;

$result_alldetails = $db->RunQuery($SQL_alldetails);

		
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$intGrnNo=$row["strGenGrnNo"];
		$genGRNStatus=$row["intStatus"];
		$intYear=$row["intYear"];
		$intGRNYearnew= $intYear;
		$strInvoiceNo=$row["strInvoiceNo"];
		$strSupAdviceNo=$row["strSupAdviceNo"];
		$dtmAdviceDate=$row["dtAdviceDate"];
		$strBatchNO=$row["strBatchNO"];
		$dtmConfirmedDate=$row["dtmConfirmedDate"];
		$strName=$row["strName"];
		$strTitle=$row["strTitle"];
		$strAddress1=$row["Saddress1"];
		$strAddress2=$row["Saddress2"];
		$strStreet=$row["Sstreet"];
		$strCity=$row["Scity"];
		$strCountry=$row["Scountry"];
		$ConfirmedPerson=$row["ConfirmedPerson"];
		$ShippingMode=$row["ShippingMode"];
		$ShippingTerm=$row["ShippingTerm"];
		$PmntMode=$row["PmntMode"];
		$PmntTerm=$row["PmntTerm"];
		$dtDeliveryDate=$row["dtmDeliveryDate"];
		$intGenPONo=$row["intGenPONo"];
		$intYear=$row["POYear"];
		$intYearnew=$intYear;
		$strPINO=$row["strPINO"];
		$preparedperson=$row["preparedperson"];
	$report_companyId	= $row["intCompId"];
		$grnRecDate = $row["grnRecDate"];
	
	
		$supDetails = $strTitle."<br/>";
		$supDetails .= ($strAddress1=="" ? "":$strAddress1."<br/>");
		$supDetails .= ($strAddress2=="" ? "":$strAddress2."<br/>");
		$supDetails .= ($strCity=="" ? "":$strCity."<br/>");
		$supDetails .= ($strCountry=="" ? "":$strCountry."<br/>");

		}
		
		$report_companyId =  $_SESSION["FactoryID"];
		?>
		<td width="100%"><?php include '../../../reportHeader.php'?></td> 
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="82%" height="38" class="head2BLCK">GOODS RECEIVED NOTE</td>
        <td width="18%" class="head2BLCK">
        <?php
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('../../../iso.xml');
   						echo  $xmlISO->ISOCodes->StyleGRNReport;
						}          
         ?>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
      <tr>
        <td width="52%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="24%" align="left" valign="top"  class="normalfnth2B">Supplier : </td>
              <td width="76%" class="normalfnt"><?php echo $supDetails;?></td>
            </tr>

        </table></td>
        <td width="48%" valign="top"><table width="100%" border="0" class="tablez" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="34%" class="normalfnth2B" height="25">Invoice No:</td>
              <td width="66%" class="normalfnth2B"><?php echo $strInvoiceNo;?></td>
            </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="17%" class="normalfnth2B">GRN No</td>
        <td width="2%" class="normalfnth2B">:</td>
        <td width="31%" class="normalfnt"><?php echo $intGRNYearnew."/".$intGrnNo;?></td>
        <td width="20%" class="normalfnth2B">GRN Date</td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="29%" class="normalfnt"><?php echo $grnRecDate; ?>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B">PO No</td>
        <td class="normalfnt2bldBLACK">:</td>
        <td class="normalfnt"><?php echo $intYearnew."/".$intGenPONo;?></td>
		<td class="normalfnth2B">PO Payment Mode</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php	echo $PmntMode;?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">PO Payment Term</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $PmntTerm;?></td>
		<td class="normalfnth2B">Supplier Advice No</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $strSupAdviceNo;?></td>
      </tr>
      <tr>
        
        <td class="normalfnth2B">Delivery Date</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $dtDeliveryDate;?></td>
		<td class="normalfnth2B">Supplier Advice Date</td>
		<td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $dtmAdviceDate;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablez">
        <tr>
          <td width="12%" class="normalfntBtab" height="25">Item Code</td> 
          <td width="44%" class="normalfntBtab" height="25">Item Description</td>
           <!-- <td width="11%" class="normalfntBtab">Cost Center</td>-->
          <td width="7%" class="normalfntBtab">Unit</td>
          <!--<td width="8%" class="normalfntBtab">COLOR</td>
          <td width="9%" class="normalfntBtab">SIZE</td>-->
          <td width="8%" class="normalfntBtab">Rate</td>
          <td width="10%" class="normalfntBtab" align="right">Qty&nbsp;</td>
          <td width="7%" class="normalfntBtab">Excess Qty</td>
          <td width="12%" class="normalfntBtab">Value</td>
        </tr>
        <?php
		$sum = 0;
		$sumexcessqty = 0;
		$sumvalue = 0;		

$SQL_RowData="select gengrnheader.strGenGrnNo,gengrndetails.intMatDetailID,gengrndetails.dblQty,gengrndetails.dblExQty, generalpurchaseorderdetails.strUnit, 
 generalpurchaseorderdetails.dblUnitPrice,generalpurchaseorderdetails.intYear, (select genmatitemlist.strItemDescription from genmatitemlist 
where genmatitemlist.intItemSerial = gengrndetails.intMatDetailID) as Description, genmatitemlist.strItemCode FROM genmatitemlist Inner Join gengrndetails ON genmatitemlist.intItemSerial = gengrndetails.intMatDetailID
 Inner Join gengrnheader ON gengrndetails.strGenGrnNo = gengrnheader.strGenGrnNo AND gengrndetails.intYear = gengrnheader.intYear
 Inner Join generalpurchaseorderdetails ON gengrnheader.intGenPONo = generalpurchaseorderdetails.intGenPONo AND gengrnheader.intGenPOYear = generalpurchaseorderdetails.intYear 
where gengrndetails.strGenGrnNo = '". substr($grnno,5,strlen($grnno)) ."' AND gengrndetails.intYear='$GenGRNYear'AND gengrndetails.intMatDetailID = generalpurchaseorderdetails.intMatDetailID 
AND gengrnheader.intGenPONo = generalpurchaseorderdetails.intGenPONo ";

		$result_RowData = $db->RunQuery($SQL_RowData);

		//echo $SQL_RowData;
		while($row = mysql_fetch_array($result_RowData))
		{		
			$sum  += $row["dblQty"];
		    $sumexcessqty += $row["dblExQty"];
			$multi = $row["dblQty"] * $row["dblUnitPrice"];
			$sumvalue += $multi;
		?>
        <tr> 
          <td class="normalfntTAB"><?php echo $row["strItemCode"];?></td>
          <td class="normalfntTAB"><?php echo $row["Description"];?></td>          
          <td class="normalfntTAB"><?php echo $row["strUnit"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["dblUnitPrice"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["dblQty"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["dblExQty"];?></td>
          <td class="normalfntRiteTAB"><?php echo $multi;?></td>
        </tr>
        <?php
		}
		?>
        <tr> 
          <td colspan="4" class="normalfnt2bldBLACKmid">TOTAL</td>
          <td class="normalfntRiteTABb-ANS"><span class="normalfntRite"><?php echo $sum;?></span></td>
          <td class="normalfntRiteTABb-ANS"><span class="normalfntRite"><?php echo $sumexcessqty;?></span></td>
          <td class="normalfntRiteTABb-ANS"><span class="normalfntRite"><?php echo $sumvalue;?></span></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="39%" border="0">
        <tr> 
          <td width="45%" class="bcgl1txt1"><?php echo $preparedperson;?></td>
          <td width="9%">&nbsp;</td>
          <td width="46%" class="bcgl1txt1">&nbsp;</td>
        </tr>
        <tr> 
          <td class="normalfnth2Bm">Prepared By</td>
          <td class="normalfnth2Bm">&nbsp;</td>
          <td class="normalfnth2Bm">Checked By</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="normalfnt">
    GRN Status : 
		<?php 
			if($genGRNStatus == 1)
			{
		?>    
    CONFIRMED <?php  echo "(".$ConfirmedPerson."-".$dtmConfirmedDate.")";?></td>
    <?php
    }
    else if ($genGRNStatus == 0)
    	echo "Pending";
    else
    	echo "Cancelled";
    ?>
  </tr>
</table>
</body>
</html>
