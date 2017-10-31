<?php 
session_start();
include "../../../../Connector.php";
include 'common_report.php';
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$invoiceNo=$_GET['InvoiceNo'];
include("invoice_queries.php");	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SUPPLIER DECLARATION</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table cellspacing="0" cellpadding="0">
  <col width="64" />
  <col width="107" />
  <col width="274" />
  <col width="64" />
  <col width="111" />
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr height="17">
    <td height="17" colspan="5" class="normalfnt2bldBLACKmid">SUPPLIER DECLARATION FOR PRODUCTS NOT HAVING&nbsp;</td>
  </tr>
  <tr height="17">
    <td colspan="5" height="17" class="normalfnt2bldBLACKmid">PREFERENTIAL ORIGIN    STATUS ACCORDING TO EEC 1207/2001</td>
  </tr>
  <tr height="17">
    <td width="95" height="17"></td>
    <td width="139"></td>
    <td width="456"></td>
    <td width="45"></td>
    <td width="97"></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="41">
    <td height="41" colspan="5" class="normalfnt_size12" style="padding:10px;">&nbsp;I, THE UNDERSIGNED,    SUPPLIER OF THE GOODS COVERED BY THIS DOCUMENT, WHICH ARE REGULARLY SENT TO    LEVI STRAUSS, DECLARE THAT THE    GOODS DESCRIBED BELOW:</td>
  </tr>
  <tr height="18">
    <td height="18"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="24">
    <td height="24"></td>
    <td class="border-top-left-fntsize12" style="text-align:center"><strong>Lot number</strong></td>
    <td colspan="2" class="border-Left-Top-right-fntsize12" style="text-align:center;"><strong>Description of non-originating goods</strong></td>
    <td></td>
  </tr>
    <?php 
	  	$str_desc="select
					strDescOfGoods,
					strStyleID,
					dblQuantity	,
					strSD				
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					ORDER BY strBuyerPONo
					";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		
		while($row_desc=mysql_fetch_array($result_desc)){?>
  <tr height="23">
    <td height="23"></td>
    <td class="border-top-left-fntsize12">&nbsp;&nbsp;<?php echo str_replace('-','',$row_desc["strStyleID"]);?></td>
    <td colspan="2" class="border-Left-Top-right-fntsize12" style="text-align:center">&nbsp;&nbsp;<?php echo $row_desc["strSD"];?></td>
    <td></td>
  </tr><?php }?>
  <tr height="23">
    <td height="23"></td>
    <td class="border-top-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-top-fntsize12">&nbsp;</td>
    <td></td>
  </tr>
  
  <tr height="21">
    <td colspan="5" height="21" class="normalfnt_size12" style="padding:10px;">HAVE BEEN PRODUCED IN SRI LANKA AND DO NOT ORIGINATE IN THE COMMUNITY.</td>
  </tr>
  <tr height="56">
    <td colspan="5" height="56" class="normalfnt_size12" style="padding:10px;">I    UNDERTAKE TO INFORM LEVI STRAUS    IMMEDIATELY IF THIS DECLARATION IS NO LONGER VALID. I UNDERTAKE TO MAKE    AVAILABLE TO THE CUSTOMS AUTHORITIES ANY FURTHER SUPPORTING DOCUMENTS THEY    REQUIRE.</td>
  </tr>
  <tr height="38">
    <td colspan="5" height="38" class="normalfnt_size12" style="padding:10px;">THIS    DECLARATION IS VALID FOR ALL FURTHER SHIPMENTS OF THESE PRODUCTS DISPATCHED    FROM 01/02/2011 TO 31/01/2012    (Max. 12 month)</td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="2" class="normalfnt_size12" style="padding:10px;"><u>PLACE AND DATE</u></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="22">
    <td height="22"></td>
    <td colspan="2" class="normalfnt_size12" style="padding:10px;">Orit Trading Lanka (Pvt)    Ltd - <?php echo $FullInvoiceDate;?></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="22">
    <td height="22"></td>
    <td colspan="4" class="normalfnt_size12" style="padding:10px;"><u>NAME AND POSITION IN THE    COMPANY, NAME AND ADDRESS OF COMPANY</u></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21"></td>
    <td colspan="2" class="normalfnt_size12" style="padding:10px;">CHANDANA FERNANDO &ndash;    SHIPPING MANAGER</td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="2" class="normalfnt_size12" >&nbsp;&nbsp; Orit Trading Lanka (Pvt.)    Ltd.,</td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="3" class="normalfnt_size12" >&nbsp;&nbsp; 07-02 East Tower, Echelon    Square, World Trade Centre.&nbsp;</td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="normalfnt_size12" >&nbsp;&nbsp; Colombo</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="normalfnt_size12"> &nbsp; &nbsp;Sri Lanka</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="normalfnt_size12">&nbsp;&nbsp;SIGNATURE</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
</html>
