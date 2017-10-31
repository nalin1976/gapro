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
$limitNo=$_GET['limitNo'];
$limitNo =($limitNo==""?0:$limitNo);
include("invoice_queries.php");	

	  	$str_desc="select 	strInvoiceNo, 
	strStyleID, 
	intItemNo, 
	strBuyerPONo, 
	strDescOfGoods, 
	sum(dblQuantity) as dblQuantity, 
	strUnitID, 
	sum(dblUnitPrice) as dblUnitPrice, 
	strPriceUnitID, 
	sum(dblAmount) as dblAmount, 
	strHSCode, 
	sum(dblGrossMass) as dblGrossMass, 
	sum(dblNetMass) as dblNetMass, 
	strProcedureCode, 
	sum(intNoOfCTns) as intNoOfCTns, 
	strKind, 
	strISDno, 
	strFabric, 
	strPLno, 
	strDc, 
	dblNetNet, 
	strSD, 
	strConstType, 
	strSpecDesc, 
	strMRP
	 
	from 
	commercial_invoice_detail 
	where strInvoiceNo='$invoiceNo' 
	group by strBuyerPONo order by strBuyerPONo
	limit $limitNo, 1;
					";
					//die($str_desc);
	$result_desc=$db->RunQuery($str_desc);
	$row_desc=mysql_fetch_array($result_desc);

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
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $row_desc['intNoOfCTns'];?> CTNS</td>
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
          <td  nowrap="nowrap" class="normalfnt_size12"><?php echo $row_desc['dblQuantity'];?>PCS</td>
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
              <td  nowrap="nowrap" class="normalfnt_size12"><?php echo $row_desc['strDescOfGoods'];?> </td>
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
          <tr>
          <td  style="text-align:center" ><?php echo $row_desc["strDescOfGoods"];?></td>
          <td  style="text-align:center"><?php echo ($row_desc["strBuyerPONo"]=="n/a"?"":$row_desc["strBuyerPONo"]);$f_isd=$row_desc["strISDno"];?></td>
          <td  style="text-align:center" nowrap="nowrap"><?php echo ($row_desc["strISDno"]!='n/a'?$row_desc["strISDno"]:'');?></td>
          <td style="text-align:center"><?php echo $row_desc["strStyleID"];?></td>
          <td style="text-align:center"><?php echo $row_desc["dblQuantity"];?></td>
          </tr>
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
<script type="text/javascript">
/*var htpl=$.ajax({url:'../packinglist_formats/pl_levis_euro.php?plno=1',async:false})
$('#pl').html(htpl.responseText);
*/

<?php 
if($limitNo==0){
$str_counter="select strBuyerPONo from commercial_invoice_detail 
				where strInvoiceNo='$invoiceNo'
				group by strBuyerPONo	
					 
				";
$result_counter=$db->RunQuery($str_counter);
while($row_counter=mysql_fetch_array($result_counter))
{if($i>0){?>
	
	window.open("co_seperatePo.php?InvoiceNo=<?php echo $invoiceNo?> &limitNo=<?php echo $i?>","<?php echo $i.'y'?>");
	
<?php
}
$i++;
}
}
?>

</script>
</body>
</html>
