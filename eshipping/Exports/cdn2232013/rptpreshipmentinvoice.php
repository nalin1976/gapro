<?php 
session_start();
include "../../Connector.php";
$xmldoc=simplexml_load_file('../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$cdnNo=$_GET['cdnNo'];

$type=($_GET['type']==""? "FOB":$_GET['type']);
$sqlinvoiceheader="SELECT 	
	IH.strInvoiceNo, 
	date(dtmInvoiceDate) as dtmInvoiceDate, 
	bytType, 
	customers.strName AS CustomerName,
	CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress, 
	customers.strAddress1,
	customers.strAddress2,
	customers.strMLocation,	
	customers.strcountry AS CustomerCountry,
	buyers.strBuyerID,
	buyers.strName AS BuyerAName, 
	buyers.strAddress1 AS buyerAddress1 ,
	buyers.strAddress2 AS buyerAddress2,
	buyers.strCountry AS BuyerCountry,
	
	soldto.strName AS soldtoAName, 
	soldto.strAddress1 AS soldtoAddress1 ,
	soldto.strAddress2 AS soldtoAddress2,
	soldto.strCountry AS soldtoCountry,
	
	(SELECT  cty.strCity FROM city cty where cty.strCityCode=IH.strFinalDest) as strFinalDest,
	(SELECT  cty.strPortOfLoading FROM city cty where cty.strCityCode=IH.strFinalDest) as strFinalPort,
	
	strNotifyID1, 
	strNotifyID2,
	strLCNo AS LCNO,
	dtmLCDate AS LCDate, 
	strLCBankID, 
	dtmLCDate, 
	IH.strPortOfLoading, 
	city.strCity AS city,
	strCarrier, 
	strVoyegeNo, 
	IH.dtmSailingDate,
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
	intCusdec,
	strTransportMode,
	strIncoterms,
	strNotifyID1
FROM
invoiceheader AS IH
LEFT JOIN customers ON IH.intManufacturerId = customers.strCustomerID
LEFT JOIN buyers ON IH.strBuyerID = buyers.strBuyerID
LEFT JOIN buyers AS soldto ON IH.strSoldTo = soldto.strBuyerID
LEFT JOIN city ON IH.strFinalDest = city.strCityCode
INNER JOIN cdn_header ON cdn_header.strInvoiceNo = IH.strInvoiceNo
WHERE intCDNNo=$cdnNo
";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$sqlinvoiceheader"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.latter {font-family: Verdana;
	font-size: 12px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:600;
}
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PRE-INVOICE</title>
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="" height="10"></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%">&nbsp;</td>
        <td width="60%" style="text-align:center"></td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td colspan="3" rowspan="6" class="">
        <table width="447">
        	<tr>
            	<td width="107" rowspan="2"> <img src="../../images/callogo.jpg" /></td>
            	<td width="328" height="30" style="font-size:12px"><label class="normalfnth2B" style="font-size:12px" ><?php echo $Company;?></label><br /><br /><u>Manufacturers and Exporters of Quality Garments</u></td>
                
            </tr>
            <tr>
            	<td class="normalfntMid" height="20" style="text-align:left; font-size:12px"><?php echo $Address." ".$City?><br /><?php echo "Tel ".$phone." Fax ".$Fax;?><br /><?php echo "E-mail: general@maliban.com";?></td>
            </tr>
        </table>
        </td>
        <td height="25"  class="normalfnth2B border-top-left-fntsize12" style="font-size:12px">Invoice No. and Date</td>
        <td colspan="2" class="normalfnth2B border-top-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left" height="25" style="font-size:12px"><?PHP echo $dataholder['strInvoiceNo'];?></td>
        <td colspan="2" class="border-right" style="font-size:12px"><span style="text-align:center">
           <?PHP  $date_array=explode("-",$dataholder['dtmInvoiceDate']); echo $date_array[2]."/".$date_array[1]."/".$date_array[0]; ?>
        </span></td>
        </tr>
      <tr>
        <td class="normalfnth2B border-Left-Top-right" height="25" style="font-size:12px">Seller's/Shipper's Ref.</td>
        <td colspan="2" class="normalfnth2B border-top-right" style="font-size:12px">Buyer's Ref.</td>
        </tr>
      <tr>
        <td class="border-left border-right" height="25" style="font-size:12px"><?php echo strtoupper($dataholder['strMLocation']);?></td>
        <td colspan="2" class="normalfnth2B  border-right">&nbsp;</td>
        </tr>
      <tr>
        <td width="27%" class="normalfnth2B border-top-left-fntsize12" height="25" style="font-size:12px">FCR/BL/Awb No. and Date</td>
        <td colspan="2" class="normalfnth2B border-top-right">&nbsp;</td>
        </tr>
      <tr>
        <td class=" border-left" height="25" style="font-size:12px">&nbsp;
        <?php 
		
			if($BL!="")
			{
				echo $BL."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dateVariable;
			}
			else if($HAWB)
			{
				echo $HAWB."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dateVariable;
			}
			else if($FCR)
			{
				echo $FCR."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dateVariable;
			}
		
		?>
        
        </td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" height="25"  class="normalfnth2B border-top-left" style="font-size:12px">Consignee</td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right" style="font-size:12px">Buyer (If not Consignee)</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left" style="font-size:12px">
        <br />
        &nbsp;<?php echo $dataholder['BuyerAName'];?><br />
        &nbsp;<?php echo $dataholder['buyerAddress1'];?><br />
        &nbsp;<?php echo $dataholder['buyerAddress2'];?><br />
        &nbsp;<?php echo $dataholder['BuyerCountry'];?><br />
        </td>
        <td colspan="3" class="border-Left-Top-right">&nbsp;</td>

      </tr>
      <tr>
        <td colspan="3" height="25"  class="border-top-left" style="font-size:12px"><span class="normalfnth2B">Notify</span></td>
				<?php
			$SQLNOTIFY =   "SELECT
							buyers.strName,
							buyers.strAddress1,
							buyers.strAddress2,
							buyers.strCountry,
							buyers.strBuyerID
							FROM
							buyers
							Inner Join invoiceheader ON buyers.strBuyerID = invoiceheader.strNotifyID1
							WHERE
							invoiceheader.strInvoiceNo =  '$invoiceNo' ";
			$idresult1=$db->RunQuery($SQLNOTIFY);
			$dataholder2=mysql_fetch_array($idresult1);
		?>
        <td colspan="3" class="normalfnth2B border-Left-Top-right" style="font-size:12px">Terms of Delivery and Payment</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left" style="font-size:12px">
        <br />
        &nbsp;<?php if($dataholder["strBuyerID"]==$dataholder["strNotifyID1"]){ echo "Same As Consignee"; } else { echo $dataholder2["strName"]; ?><br />
        &nbsp;<?php 
		  echo $dataholder2["strAddress1"]; ?><br />
        &nbsp;<?php echo $dataholder2["strAddress2"]; ?><br />
        &nbsp;<?php echo $dataholder2["strCountry"]; } ?><br /><br />
       
          </td>
        <td colspan="3" class="border-Left-Top-right" style="text-align:center"><?php if($dataholder["strIncoterms"]=="Null"){} else{ echo $dataholder["strIncoterms"]; } ?> </td>
        </tr>
      <tr>
        <td width="30%" height="25" class="border-top-left" style="font-size:12px"><span class="normalfnth2B " style="font-size:12px">Mode</span></td>
        <td colspan="2" class="border-top-left"><span class="normalfnth2B" style="font-size:12px">Port of Loading</span></td>
        <td class="border-top-left">&nbsp;</td>
        <td colspan="2" class="border-top-right">&nbsp;</td>
        </tr>
      <tr>
        <td height="30" class="border-top-left" style="font-size:12px"><?php echo strtoupper($dataholder['strTransportMode']);?></td>
        <td colspan="2" class="border-top-left" style="font-size:12px"><?php echo $dataholder['strPortOfLoading'];?></td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="normalfnth2B border-top-left" style="font-size:12px">Port of Discharge</td>
        <td colspan="2" class="normalfnth2B border-top-left" style="font-size:12px">Final Destination</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td height="30"  class="border-bottom-left border-top" style="font-size:12px"><?php echo strtoupper($dataholder['strFinalPort']);?></td>
        <td colspan="2" class="border-top-left border-bottom" style="font-size:12px"><?php echo strtoupper($dataholder['strFinalDest']);?></td>
        <td class="border-left border-bottom">&nbsp;</td>
        <td colspan="2" class="border-bottom border-right" >&nbsp;</td>
        </tr>
      <?php 
  		$str_summary="SELECT
cdn_detail.strUnitID,
cdn_detail.strDescOfGoods,
cdn_detail.strFabrication,
cdn_detail.strPriceUnitID,
Sum(cdn_detail.dblAmount) AS totamt,
Sum(cdn_detail.dblQuantity) AS totqty
FROM
cdn_detail
where intCDNNo=$cdnNo
group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_summary=mysql_fetch_array($result_summary);
		
		
		$str_CTNS = "SELECT
Sum(cdn_detail.intNoOfCTns) AS CTNSUM,
Sum(cdn_detail.intCBM) AS CBMSum,
ROUND(Sum(cdn_detail.dblGrossMass),2) AS SumGross,
Sum(cdn_detail.dblNetMass) AS SumNet
From cdn_detail
Where intCDNNo=$cdnNo
group by intCDNNo
";
		$result_summary1=$db->RunQuery($str_CTNS);
		$row_summary1=mysql_fetch_array($result_summary1);
  ?>
      <tr>
        <td colspan="6" class="border-left">
         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
         	<tr>
            	<td class="normalfnth2B border-bottom-right" style="text-align:center; font-size:12px">Container/Seal Nos : Shipping Marks</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center; font-size:12px">No. and Kind of Packages; Description of Goods</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center; font-size:12px">Category</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center; font-size:12px">Quantity (Units)</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center; font-size:12px">Unit Price (USD)</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center;  font-size:12px">Amount (USD)</td>
            </tr>
            
            <tr>
            	<td class="" style="text-align:left">
				<br />
               
                <textarea name="textarea" readonly='readonly'  style='border:0px; height:450px; width:180px;overflow:hidden; font-size:12px ' class="normalfnt"><?php echo $dataholder['strMarksAndNos']; ?></textarea>
                
                </td>
                <td class="" style="text-align:left; vertical-align:top; font-size:12px">
                <br /><br />&nbsp;<u>WEARING APPARELS</u>
                <br /><br />
                &nbsp;<?php echo $row_summary1['CTNSUM']; ?>&nbsp;&nbsp;Cartons Containing
                <br /><br />
                 &nbsp;<?php echo ($row_summary["strUnitID"]!='DZN'?$row_summary["totqty"]:$row_summary["totqty"]*12) ." PCS";?>&nbsp;&nbsp;of&nbsp;<?php echo $row_summary['strDescOfGoods'];  ?><br /><br />
                 &nbsp;<?php echo ($row_summary["strFabrication"]); ?>
                 <br />
                 <br />
				       <?php 
	  	$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					SUM(dblQuantity)as dblQuantity,
					dblUnitPrice,
					strStyleID,
					SUM(dblAmount)as dblAmount,
					strISDno
					from
					cdn_detail					
					where 
					intCDNNo='$cdnNo'  GROUP BY dblUnitPrice
order by intItemNo";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$row_desc1=mysql_fetch_array($result_desc);
				?>
                 &nbsp;Style No : <?php echo $row_desc1["strStyleID"];?>
        		 <br /><br />
        		 &nbsp;Order No : <?php echo $row_desc1["strBuyerPONo"];?>
                 <br /><br />
                 <br /><br />
        		 &nbsp;CBM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row_summary1["CBMSum"];?>
                 <br /><br />
        		 &nbsp;Final Gross Weight : <?php echo $row_summary1["SumGross"];?> Kgs
                 <br /><br />
        		 &nbsp;Final Net Weight&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row_summary1["SumNet"];?> Kgs
                </td>
                <?php
				$sql_cat = "SELECT DISTINCT strCatNo FROM invoicedetail	where 
					strInvoiceNo='$invoiceNo'";
				$res_val=$db->RunQuery($sql_cat);
				$row_cat=mysql_fetch_array($res_val);
				?>
                <td class="normalfnt" style="text-align:center; font-size:12px" valign="top"><br /><br /><?php echo $row_cat['strCatNo']; ?></td>
                <td class="" style="text-align:center; vertical-align:text-top;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                <tr>
                <td style="border-bottom-style:double; text-align:center; font-size:12px">
                <br />
                <?php
					$result_desc1=$db->RunQuery($str_desc);
					$sumQty = 0;
					while($row_desc=mysql_fetch_array($result_desc1))
					{
						
						echo $row_desc["dblQuantity"]."<br />";
						$sumQty+=$row_desc["dblQuantity"];
					}
				?>
                ______________<br />
                <br />
                <?php echo $sumQty; ?>
                <br />
                <br />
                </td>
                </tr>
                <tr>
                <td style="text-align:center">
                <br />
                	
                </td>
                </tr> 
                </table>               
                </td>
                <td  style="text-align:center;" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                <tr>
                <td style="text-align:center; font-size:12px" valign="top">
               <br />
                <?php
					$sumUP = 0;
					$result_Detail_Sum = $db->RunQuery($str_desc);
					while($row_Detail_Sum = mysql_fetch_assoc($result_Detail_Sum))
					{
						
						echo number_format($row_Detail_Sum["dblUnitPrice"],2)."<br />";
						$sumUP+=$row_Detail_Sum["dblUnitPrice"];
					}
				?>
               
                <br />
                
                <br />
                <br />
                </td></tr></table>
                </td>
                <td class="border-right" style="text-align:center; vertical-align:text-top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                <tr>
                <td style="border-bottom-style:double; text-align:center; font-size:12px">
                <br />
                <?php
					$sumAMT = 0;
					$result_Detail_Sum_Amt = $db->RunQuery($str_desc);
					while($row_Detail_Sum_Amt = mysql_fetch_assoc($result_Detail_Sum_Amt))
					{
						
						echo number_format($row_Detail_Sum_Amt["dblAmount"],2)."<br />";
						$sumAMT+=$row_Detail_Sum_Amt["dblAmount"];
					}
				?>
                ______________<br />
                <br />
                <?php echo number_format($sumAMT,2); ?><br />
                <br />
                </td></tr></table>
                </td>
            </tr>
            <tr>
              <td height="27" class="" style="text-align:left">&nbsp;</td>
              <td class="" style="text-align:left; vertical-align:text-top">&nbsp;</td>
              <td class="" style="text-align:center"></td>
              <td class="" style="text-align:center; vertical-align:text-top;">&nbsp;</td>
              <td  style="text-align:center;" valign="top">&nbsp;</td>
              <td class="border-right" style="text-align:center; vertical-align:text-top">&nbsp;</td>
            </tr>
            <tr>
              <td height="27" class="" style="text-align:left">&nbsp;</td>
              <td class="" style="text-align:left; vertical-align:text-top">&nbsp;</td>
              <td class="" style="text-align:center"></td>
              <td class="" style="text-align:center; vertical-align:text-top;">&nbsp;</td>
              <td  style="text-align:center;" valign="top">&nbsp;</td>
              <td class="border-right" style="text-align:center; vertical-align:text-top">&nbsp;</td>
            </tr>
            <tr>
              <td height="187" class="" style="text-align:left">&nbsp;</td>
              <td class="" style="text-align:left; vertical-align:text-top">&nbsp;</td>
              <td class="" style="text-align:center"></td>
              <td class="" style="text-align:center; vertical-align:text-top;">&nbsp;</td>
              <td  style="text-align:center;" valign="top">&nbsp;</td>
              <td class="border-right" style="text-align:center; vertical-align:text-top">&nbsp;</td>
            </tr>
         </table>
        </td>
        </tr>
      
    </table></td>
  </tr>
  
  <tr>
    <td class="border-top">&nbsp;</td>
  </tr>
 </table>
</body>
</html>
