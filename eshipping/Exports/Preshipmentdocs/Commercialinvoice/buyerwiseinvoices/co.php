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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CO</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<?PHP //$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table style="width:800px;" border="0" cellspacing="1" cellpadding="0" bgcolor="#FFFFFF">
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:92px; top:80px; width:277px; height:35px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12" ><?php echo $Company;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12"><?php echo $Address;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12"><?php echo $City;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt">Tel: <?php echo $phone;?> Fax: <?php echo $Fax;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:93px; top:200px; width:350px; height:44px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12"><?php echo $dataholder['BuyerAName'];?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12"><?php echo $dataholder['buyerAddress1'];?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12"><?php echo $dataholder['buyerAddress2'];?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12"><?php echo $dataholder['BuyerCountry'];?></td>
            </tr>
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
      <div  style="z-index:25; position:absolute; left:483px; top:39px; width:212px; height:24px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td nowrap="nowrap" class="normalfnt_size12">LK - SRI LANKA</td>
              </tr>
             
            </table></td>
          </tr>
        </table>
      </div>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:324px; top:487px; width:68px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?> CTNS</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:121px; top:487px; width:108px; height:22px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $mainmark1;?></td>
            </tr>
             <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $mainmark2;?></td>
            </tr>
             <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $mainmark3;?></td>
            </tr>
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $mainmark4 ;?></td>
            </tr>
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $mainmark5 ;?></td>
            </tr>
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12">&nbsp;</td>
            </tr>
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $sidemark1 ;?></td>
            </tr>
             <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $sidemark2 ;?></td>
            </tr>
             <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $sidemark3 ;?></td>
            </tr>
             <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $sidemark4 ;?></td>
            </tr>
             <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $sidemark5 ;?></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:628px; top:1067px; width:108px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $dateInvoice;?></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:721px; top:485px; width:54px; height:25px;"  >
      <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  nowrap="nowrap" class="normalfnt_size12"><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity');?>PCS</td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:417px; top:490px; width:187px; height:32px;"  >
      <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td  nowrap="nowrap" class="normalfnt_size12"><?php echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?> </td>
            </tr>
          </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:93px; top:360px; width:233px; height:41px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12">COLOMBO - SRI LANKA</td>
            </tr>
            <tr>
              <!--<td width="308" nowrap="nowrap" class="normalfnt_size12">BY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo strtoupper($dataholder['strTransportMode']);?> FREIGHT</td>-->
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:128px; top:668px; width:651px; height:43px;"  >
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="normalfnt_size12" style="padding-left:3px;padding-right:3px">
        <tr>
          <td nowrap="nowrap" style="text-align:center"><u><strong>ITEM</strong></u></td>
          <td nowrap="nowrap" style="text-align:center"><u><strong><?php echo ($com_inv_dataholder['dblSampleQuote']!=""?"":"P.O.NO.")?></strong></u></td>
          <td nowrap="nowrap" style="text-align:center"><strong><u><?php $isd=$r_summary->summary_string($invoiceNo,'strISDno');echo ($isd!='n/a'?"ISD NO":"");?></u></strong></td>
          <td  style="text-align:center" nowrap="nowrap"><u><strong>PRODUCT CODE</strong></u></td>
          <td  style="text-align:center" nowrap="nowrap"><u><strong>QTY (PCS)</strong></u></td>
        </tr>
         <?php 
	  	$str_desc="select
					commercial_invoice_detail.strDescOfGoods,
					commercial_invoice_detail.strBuyerPONo,
					commercial_invoice_detail.strStyleID,
					commercial_invoice_detail.dblQuantity,
					commercial_invoice_detail.dblUnitPrice,
					commercial_invoice_detail.dblAmount,
					commercial_invoice_detail.intNoOfCTns,
					commercial_invoice_detail.strISDno,
					commercial_invoice_detail.strHSCode,
					shipmentplheader.strWashCode
					from
					commercial_invoice_detail
					left join shipmentplheader on shipmentplheader.strPLNo=commercial_invoice_detail.strPLno					
					where 
					strInvoiceNo='$invoiceNo'
					order by commercial_invoice_detail.strBuyerPONo
					";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc)){?>
          <tr>
          <td  style="text-align:center" ><?php echo $row_desc["strDescOfGoods"];?></td>
          <td  style="text-align:center"><?php echo ($row_desc["strBuyerPONo"]=="n/a"?"":$row_desc["strBuyerPONo"]);$f_isd=$row_desc["strISDno"];?></td>
          <td  style="text-align:center" nowrap="nowrap"><?php echo ($row_desc["strISDno"]!='n/a'?$row_desc["strISDno"]:'');?></td>
          <td style="text-align:center"><?php echo $row_desc["strStyleID"];?></td>
          <td style="text-align:center"><?php echo $row_desc["dblQuantity"];?></td>
          </tr>
        <?php }?>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:628px; top:1033px; width:179px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:628px; top:1010px; width:179px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size10">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="10%" height="25">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
</table>
<?php 
$str_pages		="select intManifestNo from manifestdetail where intManifestNo='$manifestno'";
$result_pages	=$db->RunQuery($str_pages);
$pages			=mysql_num_rows($result_pages);
for($loop=1;$loop<$pages;$loop++){
?>
<script type="text/javascript">
window.open('do_sub.php?manifestno=<?php echo $manifestno;?>&limitz=<?php echo $loop;?>',<?php echo $loop;?>)

</script>
<?php }?>
</body>
</html>
