<?php 
session_start();
$document='NI';
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
include("invoice_queries.php");	
include 'common_report.php';


$invoiceNo=$_GET['InvoiceNo'];
$type=($_GET['type']==""? "FOB":$_GET['type']);
 $sqlinvoiceheader="SELECT
					IH.strInvoiceNo,
					date(dtmInvoiceDate) AS dtmInvoiceDate,
					IH.bytType,
					customers.strName AS CustomerName,
					CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress,
					customers.strAddress1,
					customers.strAddress2,
					customers.strCountry AS CustomerCountry,
					buyers.strBuyerID,
					buyers.strName AS BuyerAName,
					buyers.strAddress1 AS buyerAddress1,
					buyers.strAddress2 AS buyerAddress2,
					buyers.strCountry AS BuyerCountry,
					buyers.strBuyerCode AS strBuyerCode,
					soldto.strName AS soldtoAName,
					soldto.strAddress1 AS soldtoAddress1,
					soldto.strAddress2 AS soldtoAddress2,
					soldto.strCountry AS soldtoCountry,
					(SELECT cty.strCity FROM city cty where cty.strCityCode=IH.strFinalDest) AS strFinalDest,
					IH.strNotifyID1,
					IH.strNotifyID2,
					IH.strLCNo AS LCNO,
					IH.dtmLCDate AS LCDate,
					IH.strLCBankID,
					IH.dtmLCDate,
					IH.strPortOfLoading,
					city.strCity AS city,
					IH.strCarrier,
					IH.strVoyegeNo,
					IH.dtmSailingDate,
					IH.strCurrency,
					IH.dblExchange,
					IH.intNoOfCartons,
					IH.intMode,
					IH.strCartonMeasurement,
					IH.strCBM,
					IH.strMarksAndNos,
					IH.strGenDesc,
					IH.bytStatus,
					IH.intFINVStatus,
					IH.intCusdec,
					IH.strTransportMode,
					IH.strIncoterms,
					IH.strPay_trms,
					IH.strVesselName,
					IH.dtmVesselDate,
					IH.intPackingMthd,
					invoicedetail.dblGOHstatus,
					commercial_invoice_detail.strBuyerPONo,
					commercial_invoice_detail.dblQuantity,
					commercial_invoice_detail.dblUnitPrice,
					invoicedetail.dblNetMass,
					invoicedetail.dblGrossMass,
					invoicedetail.strStyleID,
					invoicedetail.strBuyerPONo,
					invoicedetail.strDescOfGoods,
					invoicedetail.intChkGsp,
					commercial_invoice_detail.strStyleID,
					invoicedetail.strSC_No
					FROM
					invoiceheader AS IH
					LEFT JOIN customers ON IH.strCompanyID = customers.strCustomerID
					LEFT JOIN buyers ON IH.strBuyerID = buyers.strBuyerID
					LEFT JOIN buyers AS soldto ON IH.strSoldTo = soldto.strBuyerID
					LEFT JOIN city ON IH.strFinalDest = city.strCityCode
					INNER JOIN commercial_invoice_detail ON IH.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
					INNER JOIN invoicedetail ON IH.strInvoiceNo = invoicedetail.strInvoiceNo
					LEFT JOIN shipmentforecast_detail ON shipmentforecast_detail.strPoNo = invoicedetail.strBuyerPONo
					WHERE IH.strInvoiceNo='$invoiceNo'";
	
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
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>| NEXT | Commercial Invoice |</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td  class="normalfntMid" height="18"></td>
  </tr>
  <tr>
    <td class="normalfntMid" height="18"></td>
  </tr>
  <tr>
    <td class="normalfnt_size20" style="text-align:center" height="40"><img src="../../../../images/helalogo.jpg" /></td>
  </tr> 
  <tr>
    <td class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%">&nbsp;</td>
        <td width="60%" style="text-align:center; font-size:18px"><u><?PHP echo 'COMMERCIAL INVOICE' ;?></u></td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td><td>&nbsp;</td>
        <td width="1%">&nbsp;</td>
        </tr>
          <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-All"><div align="center">GSP</div></td>
         <td class="border-top-bottom-right"><div align="center"><?php if($dataholder['intChkGsp']==0){echo "NO";} else {echo "YES";}?></div></td>
        <td>&nbsp;</td>
        </tr>
          <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-Left-bottom-right"><div align="center">FABRIC MILL</div></td>
         <td class="border-bottom-right"><div align="center">OCEAN LANKA</div></td>
        <td>&nbsp;</td>
        </tr>
           <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-Left-bottom-right"><div align="center">ORIGIN</div></td>
         <td class="border-bottom-right"><div align="center">SRI LANKA</div></td>
        <td>&nbsp;</td>
        </tr>
          
      
      <tr>
        <td width="14%" class="normalfnth2B">&nbsp;</td>
        <td width="27%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="18%">&nbsp;</td>
        <td width="17%">&nbsp;</td>
      </tr>
      
       <tr>
        <td width="14%" class="normalfnth2B">TO  :</td>
        <td width="27%"><?PHP echo $dataholder['BuyerAName'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="16%"><span class="normalfnth2B">INVOICE NO</span></td>
        <td width="18%" >: <?PHP echo $dataholder['strInvoiceNo'];?></td>
        <td width="17%">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="14%" height="0">&nbsp;</td>
       <td width="27%"><?PHP echo $dataholder['buyerAddress1'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="16%">INVOICE DATE </td>
        <td width="18%">: <?PHP echo $dataholder['dtmInvoiceDate'];?></td>
        <td width="17%">&nbsp;</td>
      </tr>
      <tr>
        <td width="14%" >&nbsp;</td>
        <td width="27%"><?PHP echo $dataholder['buyerAddress2'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="16%">SHIPMENT FROM </td>
        <td width="18%">: <?php echo $dataholder['strPortOfLoading'];?>,SRI LANKA</td>
        <td width="17%">&nbsp;</td>
      </tr>
       <tr>
        <td width="14%" >&nbsp;</td>
        <td width="27%"><?PHP echo $dataholder['BuyerCountry'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="16%">TO </td>
        <td width="18%">: <?php echo $dataholder['city'];?></td>
        <td width="17%">&nbsp;</td>
      </tr>
      
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>VESSEL </td>
        <td>: <?php echo $dataholder['strVesselName'];?></td>
        
        <?php $notifyParty1Id = $dataholder['strNotifyID1'];
		 $sql_NotPty=" SELECT buyers.strBuyerID,
						buyers.strBuyerCode,
						buyers.strName,
						buyers.strAddress1,
						buyers.strAddress2,
						buyers.strCountry
						FROM buyers
						WHERE strBuyerID='$notifyParty1Id'";
		
				
	$result=$db->RunQuery($sql_NotPty);
	$notyfy=mysql_fetch_array($result);		 
	?>	
        
        
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td></td>
        <td>&nbsp;</td>
        <td>ON/ABT </td>
        <td>: </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td></td>
        <td class="normalfnth2B">&nbsp;</td>
        <td><span class="normalfnth2B">SC NO </span></td>
        <td class="normalfnth2B">: <?php echo $dataholder['strSC_No'];?></td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td ><span class="normalfnth2B"><strong><u>MARKS &amp; NOS:</u></strong></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><strong><u>DESCRIPTION OF GOODS</u></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      
      <?php 
	  	$str_hs="select strHSCode,strFabrication,replace(strFabrication,' ','') as fabric					 
						from 
						invoicedetail 
						where 
						strInvoiceNo='$invoiceNo'
						group by fabric";
						$boo_count=0;
		$result_hs=$db->RunQuery($str_hs);
		$row_hs=mysql_fetch_array($result_hs);
	  ?>
      
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>   <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td ><span class="normalfnth2B">NSL D/No #</span></td>
        <td>&nbsp;</td>
         <td>&nbsp;</td>
        <!--<td><strong><?php if($dataholder['soldtoAName']!=""){?>Shipped to<?php }?></strong></td>-->
        <?php 
	  	  $str_summ="SELECT
			commercial_invoice_detail.strInvoiceNo,
			sum(commercial_invoice_detail.dblQuantity) AS dQuantity,
			sum(commercial_invoice_detail.intNoOfCTns) AS NoOfCrTns ,
			sum(commercial_invoice_detail.dblAmount) AS dAmount,
			sum(commercial_invoice_detail.dblUnitPrice) AS dUnitPrice,
			commercial_invoice_detail.strDescOfGoods,
			commercial_invoice_detail.strUnitID
			FROM
			commercial_invoice_detail
			WHERE
			commercial_invoice_detail.strInvoiceNo = '$invoiceNo'
			GROUP BY
			commercial_invoice_detail.strInvoiceNo";
  		$result_summ=$db->RunQuery($str_summ);
		$row_summary=mysql_fetch_array($result_summ);
	  ?>
        <td colspan="2"><?php echo $row_summary['NoOfCrTns'];?> <?php if($dataholder['intPackingMthd']=='1'){echo "CTNS";} else if($dataholder['intPackingMthd']=='2') {echo "GOH";} ?> CONTAINING...</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="font-weight:bold">P.O. <span class="normalfnth2B">#</span></td>
        <td colspan="2">: <?php echo $dataholder['strBuyerPONo'];?></td>
        <td colspan="2"><?php echo $row_summary['dQuantity'];?> <?php echo $row_summary['strUnitID'];?> OF</td>
        <td></td>
        </tr>
        
        
         <tr>
        <td style="font-weight:bold">STYLE <span class="normalfnth2B">#</span></td>
        <td colspan="2">: <?php echo $dataholder['strStyleID']; ?></td>
        <td colspan="2"><?php echo $dataholder['strDescOfGoods']; ?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><span style="font-weight:bold">ITEM <span class="normalfnth2B">#</span></span></td>
        <td colspan="2">: <?php echo $dataholder['strDescOfGoods'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><span style="font-weight:bold">CONT <span class="normalfnth2B">#</span></span></td>
        <td colspan="2"></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        </tr>
      
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>EEC CAT NO : </td>
        <td><?php 
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
        <td>&nbsp;</td>
      </tr>
      <tr>
      <?php 
	  	$str_hs="select strHSCode,strFabrication,replace(strFabrication,' ','') as fabric					 
						from 
						invoicedetail 
						where 
						strInvoiceNo='$invoiceNo'
						group by fabric";
						$boo_count=0;
		$result_hs=$db->RunQuery($str_hs);
		$row_hs=mysql_fetch_array($result_hs);
	  ?>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>FABRIC : </td>
        <td><?php echo $row_hs['strFabrication'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr> 
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>  
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>                   
    </table>
    <TABLE></TABLE>
    </td>
  </tr>
  
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="10%"><div align="center"><strong><u>P.O. # </u></strong></div></td>
        <td width="20%"><div align="center"><strong><u>STYLE #</u></strong></div></td>
        <td width="10%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="14%"><div align="center"><strong><u>QTY PCS</u></strong></div></td>
        <td width="20%"><div align="center"><strong><u>UNIT PRICE PCS/US $</u></strong></div></td>
        <td width="15%"><div align="center"><strong><u>TTL FOB US $</u></strong></div></td>
      </tr>
      <tr>
        <td ></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     
      <?php 
  		$str_summary="SELECT
			commercial_invoice_detail.strInvoiceNo,
			SUM(commercial_invoice_detail.dblQuantity) AS dblQuantity,
			sum(commercial_invoice_detail.intNoOfCTns) AS intNoOfCTns ,
			SUM(commercial_invoice_detail.dblAmount) AS dblAmount,
			SUM(commercial_invoice_detail.dblUnitPrice) AS dblUnitPrice,
			commercial_invoice_detail.strDescOfGoods
			FROM
			commercial_invoice_detail
			WHERE
			commercial_invoice_detail.strInvoiceNo = '$invoiceNo'
			GROUP BY
			commercial_invoice_detail.strDescOfGoods ";
  		$result_summary=$db->RunQuery($str_summary);
		while($row_HS_summary=mysql_fetch_array($result_summary))
		{
			$tot+=$row_HS_summary["dblAmount"];
			$totqty+=$row_HS_summary["dblQuantity"];
  ?>
       <tr>
        <td align="center"><?php echo $dataholder['strBuyerPONo'];?></td>
        <td align="center"><?php echo $dataholder['strStyleID']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center"><?php echo $row_HS_summary['dblQuantity'];?></td>
        <td align="center"><?php echo number_format($row_HS_summary['dblUnitPrice'],2);?></td>
        <td align="center"><?php echo number_format($row_HS_summary['dblAmount'],2);?></td>
      </tr>
      <?php }?>

      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">_______________</td>
        <td ></td>
        <td align="center">_______________</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center"><strong><?php echo $totqty;?></strong></td>
        <td align="center"></td>
        <td align="center"><strong><?php echo number_format($tot,2);?></strong></td>
      </tr>
            
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">________________</td>
        <td></td>
        <td align="center">________________</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td colspan="2"><strong>LESS LAB TEST 0.015 USD * <?php echo $totqty;?> PCS<strong></td>
        <?php $totqty=$totqty;
			  $usd= $totqty * 0.015;
		?>
        <td align="center">&nbsp; &nbsp;&nbsp;<?php echo number_format(($usd),2);?></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">________________</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php  $totamt= $tot;
				$val = $totamt- $usd;
		?>
        <td align="center"><strong><?php echo number_format(($val),2);?></strong>
          <p>_______________</p></td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
      <thead>
        <td colspan="3"></thead> <strong>TTL FOB US $ : <?php  
		include "../../../../Reports/numbertotext.php";
		$mat_array=explode(".",number_format($$val,2));
		echo convert_number($val);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></strong></td>
            </tr>
	  
      <tr>
          <td colspan="3" style="font-family:'Times New Roman', Times, serif; font-size:11px">&nbsp;</td>
          <td width="19%" style="text-align:center"></td>
        </tr>
         <tr>
        <td width="40%" class="border-top-left">The Hong Kong &amp; Shanghai Banking Corporation</td>
        <td width="11%" class="border-left">&nbsp;</td>
        <td colspan="4" class="border-Left-Top-right">From: NSL Sri Lanka</td>
        </tr>
       <tr>
        <td class="border-left">A/C # 011-003738-001</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="4" class="border-left-right">To: HK Accounts Dept</td>
        </tr>
       <tr>
        <td class="border-bottom-left">Swift code # HSBCLKX</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="4" class="border-left-right">&nbsp;</td>
        </tr>
       <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="4" class="border-left-right">Documents checked and certified correct.</td>
        </tr>
        <tr>
        <td>HELA CLOTHING (PVT )LTD</td>
        <td >&nbsp;</td>
        <td colspan="4" class="border-left-right">Please arrange payment to supplier.</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="4" class="border-left-right">&nbsp;</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td width="17%" class="border-left">NSL Invoice No</td>
        <?php 
			$nslNo="SELECT
commercial_invoice_header.strNslInvoiceNo
FROM
commercial_invoice_header
INNER JOIN invoicedetail ON commercial_invoice_header.strInvoiceNo = invoicedetail.strInvoiceNo
WHERE
commercial_invoice_header.strInvoiceNo = '$invoiceNo'
";
	$inresult=$db->RunQuery($nslNo);
	$nslIn=mysql_fetch_array($inresult);
	
		?>
        <td colspan="3" class="border-right">: <?php echo $nslIn['strNslInvoiceNo'];?> </td>
        </tr>
        <tr>
        <td>Authorized Signature</td>
        <td >&nbsp;</td>
        <td colspan="4" class="border-left-right">Approved by NSL Sri Lanka</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="4" class="border-left-right">&nbsp;</td>
        </tr>
       <tr>
        <td>MANAGER,</td>
        <td >&nbsp;</td>
        <td colspan="4" class="border-left-right"><p>Shaneli Perera(Authorized signatory)</p></td>
        </tr>
       <tr>
        <td>IMPORT/EXPORT</td>
        <td >&nbsp;</td>
        <td class="border-left">Approved Date</td>
        <td colspan="3" class="border-right">:</td>
        </tr>
       <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-left">Deductions</td>
        <td colspan="3" class="border-right">:</td>
        </tr>
       <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-left">Penalty</td>
        <td colspan="3" class="border-right">:</td>
        </tr>
       <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-bottom-left">Other</td>
        <td colspan="3" class="border-bottom-right">:</td>
        </tr>
       <tr>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="3%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
      </tr>
     
    </table></td>
  </tr>  
 </table>
 <?php 
 function summary_string($obj1,$obj2)
	{
			global $db;
			global $invoiceNo;
			$str_summary_dtl	="select $obj2,replace($obj2,' ','') as grpby from invoicedetail where strInvoiceNo='$invoiceNo' and  strHSCode='$obj1' group by grpby order by strBuyerPONo";
			$result_summary_dtl	=$db->RunQuery($str_summary_dtl);
			$first=0;
			while($row_summary_dtl	=mysql_fetch_array($result_summary_dtl))
			{
				if($first==0){
				$str.=$row_summary_dtl[$obj2];
				$first=1;
				}
				else 
				$str.="/ ".$row_summary_dtl[$obj2];
			}
			return $str;
	}
	?>
</body>
</html>
