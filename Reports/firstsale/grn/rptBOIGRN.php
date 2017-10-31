<?php
require_once('../../../Connector.php');
$dateFrom 	= $_GET["DateFrom"];
$dateTo 	= $_GET["DateTo"];
$iExporter	= $_GET["IExporter"];
$reportType	= $_GET["ReportType"];

if($reportType=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="ExportAnalysis.xls"');
}

$month = strtoupper(date('M',strtotime($dateFrom)));
$year = strtoupper(date('Y',strtotime($dateFrom)));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | FS Good Received Node</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 

$sql_compay="select strName,strAddress1,strAddress2,strCity,strVatAcNo from companies where intCompanyID='$iExporter'";
$result_compay=$db->RunQuery($sql_compay);
$row_company=mysql_fetch_array($result_compay);
$IECompanyName 	= explode('-',$row_company["strName"]);
$IECompanyName 	= $IECompanyName[0];
$IEaddress1		= $row_company["strAddress1"];
$IEaddress2		= $row_company["strAddress2"];
$IEStreet		= $row_company["strAddress2"];
$IECity			= $row_company["strCity"];
$IEVatRegNo 	= $row_company["strVatAcNo"];

$xmlObj 		= simplexml_load_file('../../../company.xml');
$FECompanyName 	= $xmlObj->Name->CompanyName;
$FEaddress1		= $xmlObj->Address->AddressLine1;
$FEaddress2		= $xmlObj->Address->AddressLine2;
$FEStreet		= $xmlObj->Address->Street;
$FECity			= $xmlObj->Address->City;
$FEVatRegNo 	= $xmlObj->Address->VatRegNo;
?>
<table width="850" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td colspan="2" class="head2BLCK" style="text-align:left">GOODS RECEIVED NOTE</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td height="25" colspan="5"  class="border-top-left-fntsize12" style="font-weight:bold">Name Of Indirect Exporter &amp; Tin No :</td>
        <td colspan="5" class="border-top-left-fntsize12" style="font-weight:bold">Approval No :</td>
        <td colspan="4" class="border-Left-Top-right-fntsize12" style="font-weight:bold">GRN Ref No:</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">&nbsp;<?php echo $IEVatRegNo?></td>
        <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="4" class="border-left-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">&nbsp;<?php echo $IECompanyName?></td>
        <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="4" class="border-left-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">&nbsp;<?php echo $IEaddress1.'&nbsp;'.$IEaddress2?></td>
        <td width="50" class="border-left-fntsize12">&nbsp;</td>
        <td width="55" class="border-left-right-fntsize12">&nbsp;</td>
        <td width="49">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td width="57" class="border-left-fntsize12">&nbsp;</td>
        <td width="59" class="border-left-right-fntsize12">&nbsp;</td>
        <td width="60">&nbsp;</td>
        <td width="61" class="border-left-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="border-bottom-left-fntsize12">&nbsp;<?php echo $IEStreet.'&nbsp;'.$IECity?></td>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-left-fntsize12">ORIT</td>
        <td class="border-Left-bottom-right-fntsize12">GRN</td>
        <td class="border-bottom-fntsize12">&nbsp;<?php echo $month?></td>
        <td class="border-Left-bottom-right-fntsize12">&nbsp;<?php echo $year?></td>
      </tr>
      <tr>
        <td height="25" colspan="5" class="border-left-fntsize12" style="font-weight:bold">Name Of Final Exporter &amp; Tin No :</td>
        <td colspan="9" class="border-left-right-fntsize12" style="font-weight:bold">Remarks :</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">&nbsp;<?php echo $FEVatRegNo?></td>
        <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">&nbsp;<?php echo $FECompanyName?></td>
        <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">&nbsp;<?php echo $FEaddress1.' , '.$FEaddress2?></td>
        <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">&nbsp;<?php echo $FEStreet.' , '.$FECity?></td>
        <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td height="25" colspan="5" class="border-top-left-fntsize12" style="font-weight:bold">Description Of Good With Specifications :</td>
        <td colspan="2" class="border-top-left-fntsize12" style="font-weight:bold; text-align:center">H.S No :</td>
        <td colspan="3" class="border-top-left-fntsize12" style="font-weight:bold">Unit of Measure</td>
        <td colspan="2" class="border-top-left-fntsize12" style="font-weight:bold; text-align:center">Quantity(Pcs)</td>
        <td colspan="2" class="border-Left-Top-right-fntsize12" style="font-weight:bold; text-align:center">Price (USD)</td>
        </tr>
<?php
$sql="select CID.strDescOfGoods,CID.strHSCode,sum(CID.dblQuantity)as dblQuantity,sum(CID.dblAmount) as dblUnitPrice
from eshipping.commercial_invoice_header CIH
inner join eshipping.commercial_invoice_detail CID on CIH.strInvoiceNo=CID.strInvoiceNo
where dtmManufactDate between '$dateFrom' and '$dateTo' and strInvoiceType='F'
group by CID.strHSCode";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
      <tr>
        <td width="60" height="25" class="border-top-left-fntsize12" style="text-align:right"><?Php echo ++$i;?></td>
        <td colspan="4" class="border-top-left-fntsize12" ><?Php echo $row["strDescOfGoods"];?></td>
        <td colspan="2" class="border-top-left-fntsize12" style="text-align:left"><?Php echo $row["strHSCode"];?></td>
        <td colspan="3" class="border-top-left-fntsize12" style="text-align:center">PCS</td>
        <td colspan="2" class="border-top-left-fntsize12" style="text-align:right"><?Php echo number_format($row["dblQuantity"],0);?></td>
        <td colspan="2" class="border-Left-Top-right-fntsize12" style="text-align:right"><?Php echo number_format($row["dblUnitPrice"],2);?></td>
        </tr>
<?php
	$totalQty	+= round($row["dblQuantity"],0);
	$totalPrice	+= round($row["dblUnitPrice"],2);
}
?>
      <tr>
        <td colspan="10" class="border-top-left-fntsize12" style="font-weight:bold; text-align:center">Total</td>
        <td colspan="2" class="border-top-left-fntsize12" style="text-align:right"><b><?php echo number_format($totalQty,0)?></b></td>
        <td colspan="2" class="border-Left-Top-right-fntsize12" style="text-align:right"><b><?php echo number_format($totalPrice,2)?></b></td>
        </tr>
      <tr>
        <td colspan="10"  class="border-top-left-fntsize12">(Quantities get from actual washed production figures of the related date duration)</td>
        <td colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" rowspan="2"  class="border-top-left-fntsize12" style="font-weight:bold">Unit Of Measure </td>
        <td width="85" rowspan="2"  class="border-top-left-fntsize12" style="font-weight:bold">Quantity</td>
        <td height="20" colspan="7"  class="border-top-left-fntsize12" style="font-weight:bold; text-align:center">Bond/TIEP/Approval No:</td>
        <td colspan="4" rowspan="2" class="border-Left-Top-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td width="49" height="20" class="border-top-left-fntsize12">&nbsp;</td>
        <td width="43" class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td width="31" class="border-top-left-fntsize12">&nbsp;</td>
        <td width="36" class="border-top-left-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td height="25" class="border-top-left-fntsize12">1</td>
        <td width="71" class="border-top-left-fntsize12">PCS</td>
        <td class="border-top-left-fntsize12" id="tdQty" style="text-align:right">&nbsp;</td>
        <td colspan="7" class="border-top-left-fntsize12">We........................................................(Name of </td>
        <td colspan="4" rowspan="13" class="border-Left-Top-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td height="25" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">exporter) Certify that we have purchase and </td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">exporter) Certify that we have warehouse</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">2</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">at ............................................................(address)</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">on......................(date) the locally produced goods</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">fully described in the GRN, We undertake that the</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">3</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">lacally produced goods will be used by us </td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">exclusively for export. We here by authorized the</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp; </td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">customs to duty debit out stock/bank guarantee</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">4</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">registers with these particulars on or before </td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp; </td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">............/............./...........(date) No claim will be</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="7" class="border-left-fntsize12">made for duty rebate in respect of goods supplied</td>
        </tr>
      <tr>
      <td class="border-left-fntsize12">&nbsp;</td>
       <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
         <td colspan="7" class="border-left-fntsize12">&nbsp;</td>
        </tr>
        <tr>
        <td height="20" colspan="10" class="border-top-left-fntsize12">&nbsp;</td>
        <td colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;</td>
        </tr> 
      <tr>
        <td height="20" colspan="10" class="border-left-fntsize12" style="font-weight:bold">Accepted above in good ordes</td>
        <td colspan="4" class="border-left-right-fntsize12" style="font-weight:bold">Name &amp; Authorized Signatory</td>
        </tr>
      <tr>
        <td colspan="3" class="border-left-fntsize12" style="font-weight:bold">Name of Company : </td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="4" class="border-left-right-fntsize12" style="font-weight:bold">Designation :</td>
        </tr>
      <tr>
        <td colspan="3" class="border-left-fntsize12" style="font-weight:bold">Name of Signatory :</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="4" class="border-left-right-fntsize12" style="font-weight:bold">Signature :</td>
      </tr>
       <tr>
        <td colspan="3" class="border-bottom-left-fntsize12" style="font-weight:bold">Signature :</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-fntsize12" style="font-weight:bold">Date:</td>
        <td colspan="4" class="border-bottom-fntsize12">&nbsp;</td>
        <td colspan="4" class="border-Left-bottom-right-fntsize12" style="font-weight:bold">Date :</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="normalfnt" height="20" style="font-weight:bold; font-size:12px;">Name of Enterprise : <span class="normalfnt"><?php echo $IECompanyName?></span></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td width="277"  style="font-weight:bold; font-size:12px;" valign="top" class="normalfnt">Customer :</td>
    <td width="573"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="7%" height="20" class="normalfntMid" style="font-weight:bold; font-size:12px;" >PPC</td>
        <td width="93%"><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000" class="normalfntMid">
          <tr bgcolor="#FFFFFF">
            <td height="20">5</td>
            <td>4</td>
            <td>0</td>
            <td>1</td>
            <td>6</td>
            <td>0</td>
            <td>8</td>
            <td>S</td>
            <td>E</td>
            <td>0</td>
            <td>2</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="10"></td>
        <td></td>
      </tr>
      <tr>
        <td class="normalfntMid" style="font-weight:bold; font-size:12px;">CPC</td>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000" class="normalfntMid">
          <tr bgcolor="#FFFFFF">
            <td width="9%" height="20">5</td>
            <td width="9%">4</td>
            <td width="9%">5</td>
            <td width="9%">4</td>
            <td width="9%">W</td>
            <td width="9%">9</td>
            <td width="9%">9</td>
            <td width="10%">&nbsp;</td>
            <td width="9%">&nbsp;</td>
            <td width="9%">&nbsp;</td>
            <td width="9%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="63%">&nbsp;</td>
        <td width="12%" class="normalfnt" height="20" style="font-size:12px; font-style:italic">Printed On: </td>
        <td width="25%" class="normalfnt" height="20" style="font-size:12px; font-style:italic"><?php echo date('m/d/Y'); ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
document.getElementById('tdQty').innerHTML = '<?php echo number_format($totalQty,0);?>';
</script>