<?php 
session_start();
include "../../../Connector.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['InvoiceNo'];
$type=($_GET['type']==""? "FOB":$_GET['type']);
$sqlinvoiceheader="SELECT 	
	strInvoiceNo, 
	date(dtmInvoiceDate) as dtmInvoiceDate, 
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
	
	soldto.strName AS soldtoAName, 
	soldto.strAddress1 AS soldtoAddress1 ,
	soldto.strAddress2 AS soldtoAddress2,
	soldto.strCountry AS soldtoCountry,
	
	(SELECT  cty.strCity FROM city cty where cty.strCityCode=IH.strFinalDest) as strFinalDest, 
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
	intCusdec,
	strTransportMode,
	strIncoterms,
	strNotifyID1
		 
	FROM 
	invoiceheader IH
	LEFT JOIN customers ON IH.strCompanyID=customers.strCustomerID
	LEFT JOIN buyers ON IH.strBuyerID =buyers.strBuyerID 
	LEFT JOIN buyers soldto ON IH.strSoldTo =soldto.strBuyerID 
	LEFT JOIN city ON IH.strFinalDest =city.strCityCode 
	WHERE strInvoiceNo='$invoiceNo'";
	
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
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PRE-INVOICE</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
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
    <td ><table width="900%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td colspan="3" rowspan="6" class="">
        <table width="420">
        	<tr>
            	<td width="107" rowspan="2"> <img src="../../../images/callogo.jpg" /></td>
            	<td width="301" height="30"><label class="normalfnth2B"><?php echo $Company;?></label><br /><br /><u>Manufacturers and Exporters of Quality Garments</u></td>
                
            </tr>
            <tr>
            	<td class="normalfntMid" height="20" style="text-align:left"><?php echo $Address." ".$City?><br /><?php echo "Tel ".$phone." Fax ".$Fax;?><br /><?php echo "E-mail: general@maliban.com";?></td>
            </tr>
        </table>
        </td>
        <td class="normalfnth2B border-top-left-fntsize12">Invoice No. and Date</td>
        <td colspan="2" class="normalfnth2B border-top-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left"><?PHP echo $dataholder['strInvoiceNo'];?></td>
        <td colspan="2" class="border-right"><span style="text-align:center">
          <?PHP  $date_array=explode("-",$dataholder['dtmInvoiceDate']); echo $date_array[2]."/".$date_array[1]."/".$date_array[0]; ?>
        </span></td>
        </tr>
      <tr>
        <td class="normalfnth2B border-Left-Top-right">Seller's/Shipper's Ref.</td>
        <td colspan="2" class="normalfnth2B border-top-right">Buyer's Ref.</td>
        </tr>
      <tr>
        <td class="normalfnth2B border-left border-right">&nbsp;</td>
        <td colspan="2" class="normalfnth2B  border-right">&nbsp;</td>
        </tr>
      <tr>
        <td width="40%" class="normalfnth2B border-top-left-fntsize12">FCR/BL/Awb No. and Date</td>
        <td colspan="2" class="normalfnth2B border-top-right">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnth2B border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnth2B border-top-left">Consignee</td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Buyer (If not Consignee)</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left"><?php echo $dataholder['BuyerAName'];?><br /><?php echo $dataholder['buyerAddress1'];?><br /><?php echo $dataholder['buyerAddress2'];?><br /><?php echo $dataholder['BuyerCountry'];?></td>
        <td colspan="3" class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left"><span class="normalfnth2B">Notify</span></td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Terms of Delivery and Payment</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left"><p>&nbsp;</p>
        
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
          <p><?php if($dataholder["strBuyerID"]==$dataholder["strNotifyID1"]){ echo "Same As Consignee"; } else { echo $dataholder2["strName"]; ?><br /><?php 
		  echo $dataholder2["strAddress1"]; ?> <br /> <?php echo $dataholder2["strAddress2"]; ?> <br /> <?php echo $dataholder2["strCountry"]; } ?></p></td>
        <td colspan="3" class="border-Left-Top-right"><?php if($dataholder["strIncoterms"]=="Null"){} else{ echo $dataholder["strIncoterms"]; } ?> </td>
        </tr>
      <tr>
        <td width="32%" class="border-top-left"><span class="normalfnth2B ">Mode</span></td>
        <td colspan="2" class="border-top-left"><span class="normalfnth2B">Port of Loading</span></td>
        <td class="border-top-left">&nbsp;</td>
        <td colspan="2" class="border-top-right">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-top-left"><?php echo strtoupper($dataholder['strTransportMode']);?> FREIGHT</td>
        <td colspan="2" class="border-top-left"><?php echo $dataholder['strPortOfLoading'];?>, SRI LANKA </td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B border-top-left">Port of Discharge</td>
        <td colspan="2" class="normalfnth2B border-top-left">Final Destination</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-left border-top">&nbsp;</td>
        <td colspan="2" class="border-top-left border-bottom"><?php echo strtoupper($dataholder['strFinalDest']);?></td>
        <td class="border-left border-bottom">&nbsp;</td>
        <td colspan="2" class="border-bottom border-right" >&nbsp;</td>
        </tr>
      
      <tr>
        <td colspan="4" class="border-left">&nbsp;</td>
        <td width="3%">&nbsp;</td>
        <td width="5%" class="border-right">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <?php 
  		$str_summary="select 
		strUnitID,strPriceUnitID,sum(dblAmount) as totamt,sum(dblQuantity) as totqty
		from invoicedetail
		where strInvoiceNo ='$invoiceNo'
		group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_summary=mysql_fetch_array($result_summary);
		
		
		$str_CTNS = "Select SUM(intNoOfCTns) As CTNSUM From invoicedetail Where strInvoiceNo='$invoiceNo' group by strInvoiceNo";
		$result_summary1=$db->RunQuery($str_CTNS);
		$row_summary1=mysql_fetch_array($result_summary1);
  ?>
  <tr>
    <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
      <tr><thead>
        <td height="20" class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Marks & Nos.</span></td>
        <td colspan="5" class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Description of goods</span> </td>
        <td class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Unit Price </span></td>
        <td class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Amount</span></td></thead>
      </tr>
	  
      <tr>
        <td >&nbsp;</td>
        <td colspan="5" class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%"><?php echo $row_summary1['CTNSUM']; ?>&nbsp;CTNS</td>
            <td width="30%"><?php echo ($row_summary["strUnitID"]!='DZN'?$row_summary["totqty"]:$row_summary["totqty"]*12) ." PCS";?></td>
            <td width="40%"><?php echo ($row_summary["strUnitID"]!='DZN'?round(($row_summary["totqty"]/12)):$row_summary["totqty"])." DZS";?></td>
          </tr>
        </table></td>
        <td colspan="2" class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $type." ";?> SRILANKA </span></td>
      </tr>
      <tr>
        <td ></td>
        <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $dataholder['strCurrency']."/".$row_summary["strPriceUnitID"];?></span></td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $dataholder['strCurrency'];?> </span></td>
      </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><textarea name="textarea" style="width:200px;border:0px; overflow:hidden;height:250px;line-height:20px;" id="textarea" readonly="readonly"><?php echo $dataholder['strMarksAndNos']; ?></textarea></td>
          </tr>
        </table></td>
        <td colspan="5" class="border-left-fntsize12" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">HS CODE NO </td>
            <td colspan="4" rowspan="2" valign="top">
              <textarea name="textarea2" style="width:400px;border:0px; overflow:hidden;height:40px;" id="textarea2" readonly="readonly"><?php 
	  	$str_hs="select strHSCode,strFabrication						 
						from 
						invoicedetail 
						where 
						strInvoiceNo='$invoiceNo'
						group by strHSCode";
						$boo_count=0;
		$result_hs=$db->RunQuery($str_hs);
		while($row_hs=mysql_fetch_array($result_hs))
		{
			if($boo_count!=0){
				echo " /";
				$fabric.=" /";
				
			}
			echo $row_hs["strHSCode"];
			$fabric.=$row_hs["strFabrication"];
			$boo_count=1;
		}
	  ?></textarea></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td colspan="4" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">CAT # </td>
            <td colspan="4" rowspan="2" valign="top">
					<?php 
						$str_hs="select distinct	
										strCatNo						 
										from 
										invoicedetail 
										where 
										strInvoiceNo='$invoiceNo'";
										$boo_count=0;
						$result_hs=$db->RunQuery($str_hs);
						while($row_hs=mysql_fetch_array($result_hs))
						{
							if($boo_count!=0)
								echo ", ";
							echo $row_hs["strCatNo"];
							$boo_count=1;
						}
	  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td></td>
            <td colspan="4" rowspan="2" valign="top"><textarea name="txtMarksnnosarea" style="width:400px;border:0px; overflow:hidden;height:150px;" id="txtMarksnnosarea" readonly="readonly"><?php echo $fabric; ?></textarea></td>
            </tr>
          <tr>
            <td valign="top"><u>FABRIC</u> : </td>
            </tr>
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
          </tr>
        </table></td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td valign="top">&nbsp;</td>
        <td class="border-left-fntsize12" colspan="5">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="20%">&nbsp;</td>
        <td class="border-left-fntsize12" width="15%">&nbsp;</td>
        <td width="15%" class="border-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">PO#</span></td>
        <td width="10%" class="border-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">QTY/<?php echo $row_summary["strUnitID"];?></span></td>
        <td width="15%" class="border-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Style#</span></td>
        <td width="5%">&nbsp;</td>
        <td class="border-left-fntsize12" width="10%">&nbsp;</td>
        <td class="border-left-fntsize12" width="10%">&nbsp;</td>
      </tr>
      <?php 
	  	$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					dblQuantity,
					dblUnitPrice,
					strStyleID,
					dblAmount,
					strISDno
					from
					invoicedetail					
					where 
					strInvoiceNo='$invoiceNo' order by intItemNo";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		while($row_desc=mysql_fetch_array($result_desc)){$tot+=$row_desc["dblAmount"];$totqty+=$row_desc["dblQuantity"];
	  ?>
	  <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:center" height="25"><span ><?php echo $row_desc["strDescOfGoods"];?></span></td>
        <td style="text-align:center"><?php echo $row_desc["strBuyerPONo"];?></td>
        <td style="text-align:right"><?php echo $row_desc["dblQuantity"];?></td>
        <td style="text-align:center"><?php echo $row_desc["strStyleID"];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right"><span class="normalfnt"><?php echo number_format($row_desc["dblUnitPrice"],2);?></span></td>
        <td class="border-left-fntsize12" style="text-align:right"><span class="normalfnt"><?php echo number_format($row_desc["dblAmount"],2);?></span></td>
      </tr>
	  <?php }?>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-All-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $totqty;?></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right"><span class="normalfnt"><strong><?php echo number_format($tot,2);?></strong></span></td>
      </tr>
	   <?php 
  		$str_HS_summary="select 
						strUnitID,strDescOfGoods,sum(dblAmount) as totamt,sum(dblQuantity) as totqty
						from invoicedetail
						where strInvoiceNo ='$invoiceNo'
						group by strHSCode ";
  		$result_HS_summary=$db->RunQuery($str_HS_summary);
		while($row_HS_summary=mysql_fetch_array($result_HS_summary)){		
  ?>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12"><?php echo $row_HS_summary["strDescOfGoods"];?></td>
        <td><?php echo $dataholder['strCurrency']." ".number_format($row_HS_summary["totamt"],2);?></td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right">&nbsp;</td>
      </tr><?php }?>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="2"><?php if ($type=='CIF'){?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td height="20">TOTAL CIF</td>
            <td style="text-align:right"><strong><?php echo number_format($tot,2);?></strong></td>
            </tr>
          <tr>
            <td height="20">INSURANCE</td>
            <td  style="text-align:right"><span class="normalfnth2B"><?php echo number_format(round($totqty*.03),2);?></span></td>
            </tr>
          <tr>
            <td height="20">FREIGHT</td>
            <td style="text-align:right"><span class="normalfnth2B" ><?php echo number_format(round($totqty*.07),2);?></span></td>
            </tr>
          <tr>
            <td width="50%" height="20">FOB</td>
            <td width="50%" class="border-top-bottom-fntsize10" style="text-align:right;border-bottom-style:double;border-bottom-width:3px;"><span class="normalfnth2B"><?php echo number_format(round($tot-($totqty*.03)-($totqty*.07)),2);?></span></td>
            </tr>
          </table><?php }?></td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="border-top">&nbsp;</td>
  </tr>
 </table>
</body>
</html>
