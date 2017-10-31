<?php 
session_start();
include "../../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../../../config.xml');
include "../common_report1.php";
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['InvoiceNo'];
//include "../invoice_queries.php";

$type=($_GET['type']==""? "FOB":$_GET['type']);


 $sql="SELECT DISTINCT
		byr.strName AS BuyerName,
		byr.strAddress1 AS BuyerAddress1,
		byr.strAddress2 AS BuyerAddress2,
		byr.strCountry AS BuyerCountry,
		byr.strPhone AS BuyerPhone,
		byr.strFax AS BuyerFax,
		notify.strName AS BrokerName,
		notify.strAddress1 AS BrokerAddress1,
		notify.strAddress2 AS BrokerAddress2,
		notify.strAddress3 AS BrokerAddress3,
		notify.strCountry AS BrokerCountry,
		notify.strPhone AS BrokerPhone,
		notify.strFax AS BrokerFax,
		ih.strPortOfLoading,
		city.strPortOfLoading AS `port`,
		city.strCity,
		ih.strCarrier,
		invoicedetail.strBuyerPONo,
		Sum(invoicedetail.dblQuantity) AS dblQuantity,
		Sum(invoicedetail.dblAmount) AS dblAmount,
		Sum(invoicedetail.intCBM) AS intCBM,
		invoicedetail.strStyleID,
		Sum(invoicedetail.intNoOfCTns) AS intNoOfCTns,
		invoicedetail.strDescOfGoods,
		invoicedetail.strFabrication,
		SUM(invoicedetail.dblGrossMass) AS dblGrossMass,
		SUM(invoicedetail.dblNetMass) AS dblNetMass
		FROM
		invoiceheader AS ih
		LEFT JOIN buyers AS byr ON byr.strBuyerID = ih.strBuyerID
		LEFT JOIN buyers AS notify ON notify.strBuyerID = ih.strNotifyID1
		LEFT JOIN city ON ih.strFinalDest = city.strCityCode
		INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = ih.strInvoiceNo
		WHERE ih.strInvoiceNo='$invoiceNo'
		GROUP BY invoicedetail.strBuyerPONo

		";
		$result=$db->RunQuery($sql);
		
while($row = mysql_fetch_array($result))
{
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Expeditors</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="" height="5"></td>
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
    <td class=""><table width="103%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td colspan="6" class="border-top-left">
          <table width="639">
            <tr>
              <td width="320" rowspan="2"> <img src="../../../../../images/expeditors.png" /></td>
              <td width="307" height="20"><br /><br /></td>
              
              </tr>
            <tr>
              <td class="normalfntMid" height="10" style="text-align:center"><p><br />
                <strong>SHIPPER'S LETTER OF INSTRUCTIONS</strong></p>
                <p><strong>FOR AIR FREIGHT</strong><br />
                </p></td>
              </tr>
            </table>
        </td>
        <td class="border-top-right"></td>
        </tr>
      <tr>
        <td width="49%" style="vertical-align:text-top" colspan="" rowspan="4" class="border-top-left"><b>CONSIGNEE NAME AND ADDRESS</b><br /><br />
        &nbsp;<?php echo $row['BuyerName']; ?><br />
                    &nbsp;<?php echo $row['BuyerAddress1']; ?><br />
                    &nbsp;<?php echo $row['BuyerAddress2']; ?><br />
                    &nbsp;<?php echo $row['BuyerCountry']; ?><br /></td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">DESTINATION AIR PORT</td>
        <td width="13%" class="border-top-right"><?php echo $row['port']; ?></td>
        <td width="13%" class="normalfnth2B border-top-right">PLACE OF DELIVERY</td>
        <td width="13%" class="border-top-right"><?php echo $row['strCity']; ?></td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Cargo Ready Date</td>
        <td colspan="3" class="border-top-right"><?php echo $dateETA; ?></td>
        </tr>
       <tr>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Documents Ready Date</td>
        <td colspan="3" class="border-top-right"><?php echo $dateVariable; ?></td>
        </tr>
       <tr>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Merchandiser Name</td>
        <td colspan="3" class="border-top-right"><?php echo $MerchID; ?></td>
        </tr>
       <tr>
        <td colspan="" style="vertical-align:text-top" rowspan="3" class="border-top-left border-bottom"><b>NOTIFY</b><br /><br />
        &nbsp;<?php echo $row['BrokerName']; ?><br />
        &nbsp;<?php echo $row['BrokerAddress1']; ?><br />
        &nbsp;<?php echo $row['BrokerAddress2']; ?><br />
        &nbsp;<?php echo $row['BrokerCountry']; ?><br />
	
        </td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Brand Name</td>
        <td colspan="3" class="border-top-right"><?php echo $Brand; ?></td>
        </tr>
       <tr>
        <td colspan="3" class="normalfnth2B border-top-left">&nbsp;</td>
        <td colspan="2" class="border-top " style="text-align:left; font-size:18px; padding-top:20px"><strong>FREIGHT COLLECT</strong></td>
        <td class="border-top-right">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="3" class="normalfnth2B border-left border-bottom">&nbsp;</td>
        <td colspan="2" class=" border-bottom" style="text-align:left; font-size:18px">&nbsp;</td>
        <td class="border-right border-bottom">&nbsp;</td>
        
      </tr>
     
     
     
     
     
   
      
   
      
    </table></td>
  </tr>
  
 
  <tr>
    <td class="border-left-right-fntsize12">
    	<table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
    		<thead>
   		  <td height="8" colspan="4" style="text-align:left" class=""><strong>SPECIAL INSTRUCTION (E.G.LETTER OF CREDIT/CONSULAR REQUIREMENTS)</strong></td>
          		<td width="4%" class="border-left" style="text-align:center">&nbsp;</td>
          		<td width="2%" class="" style="text-align:center">
    		</thead>
    
      <tr>
          <td width="12%" height="31" class="normalfnth2B border-top" style="text-align:center">NO OF PACKAGES</td>
        <td width="13%" height="31" class="border-top border-left" style="text-align:center"><span class="normalfnth2B">METHOD OF PACKING</span></td>
        <td width="29%" height="31" class="border-top border-left" style="text-align:center"><span class="normalfnth2B">NATURE AND QUANTITY OF GOODS</span></td>
        <td colspan="3" class="border-top border-left" style="text-align:center"><span class="normalfnth2B">MARKS AND NUMBER</span> </td>
        <td width="22%" colspan="-1" class="border-top border-left" style="text-align:center"><span class="normalfnth2B">MEASUREMENTS (Specify cms or Inc)</span></td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="normalfnth2B">WEIGHTS (KGS)</p></td>
      </tr>
       <tr height="">
          <td width="12%" height="" class="border-top" style="text-align:center; vertical-align:text-top"><?php  echo $row['intNoOfCTns'];?></td>
        <td width="13%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td width="29%" height="" class="border-top border-left" style="text-align:center; vertical-align:text-top; text-align:left">
        <br />&nbsp;
        <b>Style No :</b> <?php echo $row['strStyleID']; ?>
        <br /><br />
        &nbsp;<b>Order No :</b> <?php echo $row['strBuyerPONo']; ?>
        <br /><br />
        &nbsp;<b>Cat No   :</b>
        <br /><br />
        &nbsp;<b><u>DESCRIPTION</u></b><br /><br />
        <?php echo $row['intNoOfCTns']; ?>&nbsp;<b>Cartons Containing</b><br />
        <?php echo $row['dblQuantity']; ?>&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strUnitID'); ?>&nbsp;<b>of&nbsp;<?php echo $row['strDescOfGoods']; ?></b><br /><br /><b><?php echo $row['strFabrication']; ?></b>
        </td>
        <td colspan="3" class="border-top border-left" style="text-align:center">
        <?php echo $mainmark1; ?><br />
        <?php echo $mainmark2; ?><br />
        <?php echo $mainmark3; ?><br />
        <?php echo $mainmark4; ?><br />
        <?php echo $mainmark5; ?><br />
        <?php echo $mainmark6; ?><br />
        <?php echo $mainmark7; ?><br />
        <?php echo $sidemark1; ?><br />
        <?php echo $sidemark2; ?><br />
        <?php echo $sidemark3; ?><br />
        <?php echo $sidemark4; ?><br />
        <?php echo $sidemark5; ?><br />
        <?php echo $sidemark6; ?><br />
        <?php echo $sidemark7; ?><br />
        </td>
        <td width="22%" colspan="-1" class="border-top border-left" style="text-align:center; vertical-align:text-top"><?php  echo $row['intCBM'];?></td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="" style="text-align:left">Gross :<br /><?php  echo $row['dblGrossMass'];?><br /><br />Net :<br /><?php  echo $row['dblNetMass'];?><br /><br />Net Net :<br /><?php  echo $r_summary->summary_sum($invoiceNo,'dblNetNet');?></p></td>
      </tr>
        <tr height="">
          <td height="" colspan="8" class="normalfnth2B border-top" style="text-align:LEFT"><label>DECLARED VALUE FOR CUSTOMS :&nbsp;<label></label></label><label style="margin-left:250px">DECLARED VALUE FOR CARRIAGE :&nbsp;</label></td>
        </tr>
        <tr height="">
          <td height="" colspan="8" class="normalfnth2B border-top" style="text-align:LEFT"><p class="normalfnth2B">INSURE FOR : &nbsp;</p></td>
        </tr>
        <tr height="">
          <td height="" colspan="8" class="normalfnth2B border-top" style="text-align:LEFT"><p class="normalfnth2B">AMOUNT OF C.O.D :&nbsp;</p></td>
        </tr>
        <tr height="">
          <td width="12%" rowspan="2" class="normalfnth2B border-top" style="text-align:center">CHARGES</td>
        <td height="" colspan="2" class="normalfnth2B border-top border-left" style="text-align:center">PAYABLE BY(TICK AS APPOPRIATE)</td>
        <td colspan="3" class=" border-left" style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top border-left" style="text-align:center">DOCUMENT ATTACHED(Please Indicate)</td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
        <tr height="">
          <td width="13%" height="" class="normalfnth2B border-top border-left" style="text-align:center">SHIPPER</td>
        <td width="29%" height="" class="normalfnth2B border-top border-left" style="text-align:center">CONSIGNEE</td>
        <td colspan="3" class=" border-left" style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top border-left" style="text-align:center">CUSTOMS PRE ENTRY L88</td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
        <tr height="">
          <td width="12%" height="" class="normalfnth2B border-top" style="text-align:center">AIR FREIGHT</td>
        <td width="13%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td width="29%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td colspan="3" class=" border-left" style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top border-left" style="text-align:center">COMMERCIAL INVOICES</td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
        <tr height="">
          <td width="12%" height="" class="normalfnth2B border-top" style="text-align:center">F.O.B. (Processing)</td>
        <td width="13%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td width="29%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td colspan="3" class=" border-left" style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top border-left" style="text-align:center">CERTIFICATE OF ORIGIN/CONSULAR INVOICE</td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
        <tr height="">
          <td width="12%" height="" class="normalfnth2B border-top" style="text-align:center">INSURANCE</td>
        <td width="13%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td width="29%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td colspan="3" class=" border-left" style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top border-left" style="text-align:center">DOCUMENTS ATTACHED(Please Indicate)</td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
        <tr height="">
          <td width="12%" height="" class="normalfnth2B border-top" style="text-align:center">AT DESTINATION</td>
        <td width="13%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td width="29%" height="" class="border-top border-left" style="text-align:center">&nbsp;</td>
        <td colspan="3" class=" border-left" style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top border-left" style="text-align:center">DOCUMENTS ATTACHED(Please Indicate)</td>
        <td width="11%" class="border-top border-left" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
     
      <tr height="">
          <td height="" colspan="3" class="normalfnth2B border-top" style="text-align:left">For Googs destined for the EUROPEAN COMMUNITY :</td>
        <td colspan="3" class=" " style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top " style="text-align:center">&nbsp;</td>
        <td width="11%" class="border-top" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
       <tr height="">
          <td height="" colspan="3" class="normalfnth2B " style="text-align:left">Googs in free Circulation : YES/NO</td>
        <td colspan="3" class=" " style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B " style="text-align:center">..............................................</td>
        <td width="11%" class="" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
       <tr height="">
          <td width="12%" height="" class="normalfnth2B " style="text-align:center">&nbsp;</td>
        <td width="13%" height="" class="" style="text-align:center">&nbsp;</td>
        <td width="29%" height="" class=" " style="text-align:center">&nbsp;</td>
        <td colspan="3" class=" " style="text-align:center">&nbsp;</td>
        <td width="22%" colspan="-1" class="normalfnth2B " style="text-align:center">SIGNATURE</td>
        <td width="11%" class="" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
      <tr height="">
          <td colspan="2" rowspan="2" class=" border-top" style="text-align:left"><strong>SHIPPER NAME AND ADDRESS :</strong><br /><br /><?php echo $Company; ?><br /><?php echo $Address; ?><br /><?php echo $City; ?></td>
        <td width="29%" height="" class="border-top" style="text-align:center">&nbsp;</td>
        <td colspan="3" class="border-top" style="text-align:center">&nbsp;</td>
        <td colspan="2" class="border-top" style="text-align:left"><p class="">The Shipper hereby declared that the above particulars are corredt and that he is aware of and accepts the Conditions of Trading referred to on the reverse side of this form</p></td>
        </tr>
      <tr height="">
          <td width="29%" height="" class=" " style="text-align:center">&nbsp;</td>
        <td colspan="3" class="normalfnth2B" style="text-align:left">By :</td>
        <td colspan="2" class="normalfnth2B " style="text-align:right
        "><p class="">Signed on behalf of Shipper</p></td>
        </tr>
      <tr height="">
          <td width="12%" height="" class="normalfnth2B " style="text-align:center">&nbsp;</td>
        <td width="13%" height="" class="" style="text-align:center">&nbsp;</td>
        <td width="29%" height="" class=" " style="text-align:center">&nbsp;</td>
        <td colspan="3" class="normalfnth2B" style="text-align:left">Dated :</td>
        <td width="22%" colspan="-1" class="normalfnth2B " style="text-align:center"></td>
        <td width="11%" class="" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
      
       <tr height="">
          <td width="12%" height="30" class="normalfnth2B border-top " style="text-align:center">UPDATED :</td>
        <td width="13%" height="30" class="border-top" style="text-align:center">&nbsp;</td>
        <td width="29%" height="30" class="border-top" style="text-align:center">&nbsp;</td>
        <td colspan="3" class="normalfnth2B border-top" style="text-align:left">OWNER :</td>
        <td width="22%" colspan="-1" class="normalfnth2B border-top" style="text-align:center">R.M. TINDALL-EXPEDITORS LANKA (PVT) LT</td>
        <td width="11%" class="border-top" style="text-align:center"><p class="normalfnth2B">&nbsp;</p></td>
      </tr>
     
      
    </table></td>
  </tr>
  <tr>
    <td height="21" class="border-top">&nbsp;</td>
    
  </tr>
 </table>
</body>
</html>
<?php
}
?>
