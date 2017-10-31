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

$sqlbookingheader="SELECT 	
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
	intMode, 
	strCartonMeasurement, 
	strCBM, 
	strMarksAndNos, 
	strGenDesc, 
	bytStatus, 
	intFINVStatus, 
	intCusdec
		 
	FROM 
	bookingheader IH
	LEFT JOIN customers ON IH.strCompanyID=customers.strCustomerID
	LEFT JOIN buyers ON IH.strBuyerID =buyers.strBuyerID 
	LEFT JOIN buyers soldto ON IH.strSoldTo =soldto.strBuyerID 
	LEFT JOIN city ON IH.strFinalDest =city.strCityCode 
	WHERE strInvoiceNo='$invoiceNo'";
	//echo $sqlbookingheader;
	//echo "dfdfdf";
	$idresult=$db->RunQuery($sqlbookingheader);
	$dataholder=mysql_fetch_array($idresult);
	//echo $dataholder['dtmInvoiceDate'];
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$sqlinvoiceheader"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10);
	//echo "sdsd"; 
	 //echo $dataholder['BuyerAName'];
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
    <td class="normalfntMid" height="18"></td>
  </tr>
  <tr>
    <td>
    	<table width="1090" height="18">
        	<tr>
            	<td width="237" style="text-align:left"><img src="../../../images/expeditors.png" style="text-align:left" /></td>
                <td width="841" style="text-align:center;"><strong style="text-align:center; font-size:34px">Expeditors Cargo Management Systems.</strong></td>
            </tr>
            <tr>
            	<td style="text-align:center"></td>
                <td style="text-align:center;"><strong style="text-align:center; font-size:36px">ORIGINAL</strong></td>
            </tr>
        </table>
    
    </td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        <td colspan="3" rowspan="6" class="border-top-left" style="vertical-align:text-top"><label class="normalfnth2B" style="vertical-align:top">SHIPPER (Name and Full Address)</label><br /><br /><label><?php echo $Company; ?></label><br /><?php echo $Address;?>
        <br /><?php echo $City;?> </td>
        <td class="normalfnth2B border-top-left-fntsize12">BOOKING NUMBER</td>
        <td colspan="2" class="normalfnth2B border-top-right">FCR NUMBER</td>
      </tr>
      <tr>
        <td class="border-left"><?PHP echo $invoiceNo;?></td>
        <td colspan="2" class="border-right"><span style="text-align:center">
         
        </span></td>
        </tr>
      <tr>
        <td class="normalfnth2B border-top-left">CARGO RECEIVING DATE</td>
        <td colspan="2" class="normalfnth2B border-top-right">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnth2B border-left ">&nbsp;</td>
        <td colspan="2" class="normalfnth2B  border-right">&nbsp;</td>
        </tr>
      <tr>
        <td width="26%" class="normalfnth2B border-left">&nbsp;</td>
        <td colspan="2" class="normalfnth2B border-right">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnth2B border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnth2B border-top-left">CONSIGNEE (Name and Full)</td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">FORWARDING AGENT REFERENCES</td>
      </tr>
       <tr>
        <td colspan="3" class="border-left"><?php echo $dataholder['BuyerAName']; ?><br /><?php echo $dataholder['buyerAddress1'];?><br /><?php echo $dataholder['buyerAddress2'];?><br /><?php echo $dataholder['BuyerCountry'];?></td>
        <td colspan="3" class="border-left-right"></td>
      </tr>
      <tr>
        <td colspan="3" class="border-left"><br />
          <br />
          <br /></td>
        <td colspan="3" class="border-Left-Top-right" style="vertical-align:text-top"><label class="normalfnth2B" style="vertical-align:top">POINT AND COUNTRY OF ORIGIN OF GOODS</label></td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left"><span class="normalfnth2B">NOTIFY PARTY / INTERMEDIATE CONSIGNEE (Name and Full Address)</span></td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right"><p>ALSO NOTIFY (Name and Full Address) DOMESTIC ROUTING/EXPORT INSTRUCTIONS/PIER-TERMINAL/ONWARD ROUTING FROM POINT OF DESTINATION FOR RELEASE OF CARGO PLEASE CONTACT</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
      
      <?php
			 $SQLNOTIFY =   "SELECT
							buyers.strName,
							buyers.strAddress1,
							buyers.strAddress2,
							buyers.strCountry,
							buyers.strBuyerID
							FROM
							buyers
							Inner Join bookingheader ON buyers.strBuyerID = bookingheader.strNotifyID1
							WHERE
							bookingheader.strInvoiceNo =  '$invoiceNo' ";
			$idresult1=$db->RunQuery($SQLNOTIFY);
			$dataholder2=mysql_fetch_array($idresult1);
		?>
        <td colspan="3" class="border-left">
        
      
          <p><?php if($dataholder["strBuyerID"]==$dataholder["strNotifyID1"]){ echo "Same As Consignee"; } else { echo $dataholder2["strName"]; ?><br /><?php 
		  echo $dataholder2["strAddress1"]; ?> <br /> <?php echo $dataholder2["strAddress2"]; ?> <br /> <?php echo $dataholder2["strCountry"]; } ?></p></td>
        <td colspan="3" class="border-left-right">&nbsp;</td>
        </tr>
      <tr>
        <td width="32%" class="border-top-left"><span class="normalfnth2B ">INITIAL CARRIAGE</span></td>
        <td colspan="2" class="border-top-left"><span class="normalfnth2B">PLACE OF RECEIPT</span></td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left"><?php echo strtoupper($dataholder['strTransportMode']);?> FREIGHT</td>
        <td colspan="2" class="border-left"><?php echo $dataholder['strPortOfLoading'];?>, SRI LANKA </td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B border-top-left">EXPORT CARRIER (Vessel, Voyage)</td>
        <td colspan="2" class="normalfnth2B border-top-left">PORT OF LOADING</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B border-left">&nbsp;</td>
        <td colspan="2" class="border-left"><?php echo $dataholder["strPortOfLoading"];?></td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B border-top-left">PORT OF DISCHARGE</td>
        <td colspan="2" class="normalfnth2B border-top-left">PLACE OF DELIVERY</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
       <?php    
     $SQLNEW1 =  "SELECT
				city.strCity
				FROM
				bookingheader
				Inner Join city ON bookingheader.strPortOfLoading = city.strPortOfLoading
				WHERE
				bookingheader.strInvoiceNo =  '$invoiceNo'";
	$resultNEW1=$db->RunQuery($SQLNEW1);
	$rowNEW1=mysql_fetch_array($resultNEW1);				
	
?>
        <td class="border-left"><?php echo $rowNEW1["strCity"]; ?></td>
        <td colspan="2" class="normalfnth2B border-left">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
    
      
    </table></td>
  </tr>
  <?php 
  		$str_summary="select 
		strUnitID,strPriceUnitID,sum(dblAmount) as totamt,sum(dblQuantity) as totqty
		from bookingdetail
		where strInvoiceNo ='$invoiceNo'
		group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_summary=mysql_fetch_array($result_summary);
		
		$str_CTNS = "Select SUM(intNoOfCTns) As CTNSUM From bookingdetail Where strInvoiceNo='$invoiceNo' group by strInvoiceNo";
		$result_summary1=$db->RunQuery($str_CTNS);
		$row_summary1=mysql_fetch_array($result_summary1);
		
  ?>
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt border-right">
      <tr><thead>
        <td height="20" class="border-top-bottom-fntsize12 border-left" style="text-align:center"><span class="normalfnth2B">Marks & Nos.</span></td>
        <td colspan="5" class="border-top-bottom-fntsize12 border-left" style="text-align:center"><span class="normalfnth2B">Description of goods</span> </td>
        <td class="border-top-bottom-fntsize12 border-left" style="text-align:center"><span class="normalfnth2B">Unit Price </span></td>
        <td class="border-top-bottom-fntsize12 border-left" style="text-align:center"><span class="normalfnth2B">Amount</span></td></thead>
      </tr>
	  
      <tr>
        <td class="border-left">&nbsp;</td>
        <td colspan="5" class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%"><?php echo $row_summary1['CTNSUM']; ?>&nbsp;CTNS</td>
            <td width="30%"><?php echo ($row_summary["strUnitID"]!='DZN'?$row_summary["totqty"]:$row_summary["totqty"]*12) ." PCS";?></td>
            <td width="40%"><?php echo ($row_summary["strUnitID"]!='DZN'?round(($row_summary["totqty"]/12)):$row_summary["totqty"])." DZS";?></td>
          </tr>
        </table></td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"></span></td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"></span></td>
      </tr>
      <tr>
        <td class="border-left"></td>
        <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"></span></td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"> </span></td>
      </tr>
      <tr>
        <td class="border-left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class=""><textarea name="textarea" style="width:200px;border:0px; overflow:hidden;height:250px;line-height:20px;" id="textarea" readonly="readonly"><?php echo $dataholder['strMarksAndNos']; ?></textarea></td>
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
						bookingdetail 
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
										bookingdetail 
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
        <td valign="top" class="border-left">&nbsp;</td>
        <td class="border-left-fntsize12" colspan="5">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="20%" class="border-left">&nbsp;</td>
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
					dblAmount,
					strISDno,
					strStyleID
					from
					bookingdetail					
					where 
					strInvoiceNo='$invoiceNo' order by intItemNo";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		while($row_desc=mysql_fetch_array($result_desc)){$tot+=$row_desc["dblAmount"];$totqty+=$row_desc["dblQuantity"];
	  ?>
	  <tr>
        <td class="border-left">&nbsp;</td>
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
        <td class="border-left">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="" style="text-align:right"><span class="normalfnth2B"></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right"><span class="normalfnt"><strong><?php echo number_format($tot,2);?></strong></span></td>
      </tr>
	   <?php 
  		$str_HS_summary="select 
						strUnitID,strDescOfGoods,sum(dblAmount) as totamt,sum(dblQuantity) as totqty
						from bookingdetail
						where strInvoiceNo ='$invoiceNo'
						group by strHSCode ";
  		$result_HS_summary=$db->RunQuery($str_HS_summary);
		while($row_HS_summary=mysql_fetch_array($result_HS_summary)){		
  ?>
      <tr>
        <td class="border-left">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:center"><?php echo $row_HS_summary["strDescOfGoods"];?></td>
        <td style="text-align:center"><?php echo $dataholder['strCurrency']." ".number_format($row_HS_summary["totamt"],2);?></td>
        <td style="text-align:right"><?php echo $totqty;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right">&nbsp;</td>
      </tr><?php }?>
      <tr>
        <td class="border-left">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left border-bottom">&nbsp;</td>
        <td class="border-left-fntsize12 border-bottom">&nbsp;</td>
        <td class="border-bottom">&nbsp;</td>
        <td class="border-bottom">&nbsp;</td>
        <td colspan="2" class="border-bottom"><?php if ($type=='CIF'){?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
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
        <td class="border-left-fntsize12 border-bottom">&nbsp;</td>
        <td class="border-left-fntsize12 border-bottom">&nbsp;</td>
      </tr>
       <tr>
       	<td colspan="6" class="border-left"><label style="font-size:18px">REMARKS :</label> THE ORIGINAL BILL OF LADING OF THIS SHIPMENT HAS BEEN RELEASED TO THE ABOVE MENTIONED CONSIGNEE<br /> <label style="margin-left:107px">AS AGREED AND SPECIFIED ON SHIPPING ORDER</label></td>
       </tr>
       
       <tr >
       	<td colspan="3" class="border-top-bottom-left" style="vertical-align:text-top"><label >IN ACCORDANCE WITH INSTRUCTION OF THE ABOVE CONSIGNEE<br />WE RECEIVED THE FOLLOWING DOCUMENTS ON</label><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></td>
        <td colspan="2" class="border-top-bottom-left" style="vertical-align:text-top">FOR CHARGES</td>
        <td colspan="3" class="border-top-bottom-left" style="vertical-align:text-top">THIS DOCUMENT IS EXCHANGED FOR THE DOCK'S RECEIPT/MATE'S RECEIPT IT IS ISSUED AS A RECEIPT OF PAPER AND CARGO ONLY AND WILL NOT BE NEGOTIABLE UNLESS VERIFIED AND ENDORSED BY AN AUTHORIZED SIGNATORY OF EXPEDITORS</td>
       
       </tr>
     
    </table></td>
  </tr>
 
 </table>
</body>
</html>
