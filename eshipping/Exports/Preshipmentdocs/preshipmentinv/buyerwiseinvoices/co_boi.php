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
//$invoiceNo='10250/OTL/09/10';
//$invoiceNo='194/OTL/NY/02/11';
$limitNo=$_GET['limitNo'];
$limitNo =($limitNo==""?0:$limitNo);
include("invoice_queries.php");	




$str_detail="select 	strInvoiceNo, 
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
	group by strHSCode order by strBuyerPONo
	limit $limitNo, 1;";
	
	//die($str_detail);
$result_detail=$db->RunQuery($str_detail);
$detail_data_set=mysql_fetch_array($result_detail);
$hs = $detail_data_set["strHSCode"];

$ArrayinvYear=explode(",",$FullInvoiceDate);

$SQL_countryCd="SELECT
				city.strCountryCode as cd
				FROM
				city
				Inner Join commercial_invoice_header ON city.strCityCode = commercial_invoice_header.strFinalDest
				WHERE
				commercial_invoice_header.strInvoiceNo = '$invoiceNo'";

$resultCountryCd = $db->RunQuery($SQL_countryCd);
$countryCdArry = mysql_fetch_array($resultCountryCd); // get the countrycode for the final destination.

				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CO</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>

</head>

<body class="body_bound">
<table style="width:800px;"border="0" cellspacing="1" cellpadding="0" bgcolor="#FFFFFF">
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
    <td><div  style="z-index:25; position:absolute; left:530px; top:92px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $ArrayinvYear[1];?></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div  style="z-index:25; position:absolute; left:90px; top:114px; width:277px; height:35px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; line-height:12px;">
            <tr>
              <td nowrap="nowrap"  ><?php echo $Company;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" ><?php echo $Address;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" ><?php echo $City;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
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
    <td><div  style="z-index:25; position:absolute; left:496px; top:313px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $Country; ?></td>
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
    <td><div  style="z-index:25; position:absolute; left:763px; top:94px; width:32px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $com_inv_dataholder["strCat"]; ?></td>
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
    <td><div  style="z-index:25; position:absolute; left:686px; top:58px; width:89px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php print("LK".$countryCdArry["cd"]."".substr($ArrayinvYear[1],2,2)."02");  ?></td>
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
    <td><div  style="z-index:25; position:absolute; left:92px; top:205px; width:350px; height:44px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; line-height:11px;">
              <tr>
                <td nowrap="nowrap"><?php echo $dataholder['BuyerAName'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><?php echo $dataholder['buyerAddress1'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><?php echo $dataholder['buyerAddress2'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><?php echo $dataholder['BuyerCountry'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><strong>SHIP TO:</strong></td>
              </tr>
              <tr>
                <td nowrap="nowrap" ><?php echo $dataholder['notify2Name'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap" ><?php echo $dataholder['notify2Address1'];?> <?php echo $dataholder['notify2Address2'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap" ><?php echo $dataholder['notify2Country'];?></td>
              </tr>
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
      <div  style="z-index:25; position:absolute; left:10px; top:415px; width:88px; height:24px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td nowrap="nowrap" class="normalfnt_size12">AS PER</td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt_size12">COMMERCIAL </td>
                </tr>
                <tr>
                  <td width="308" nowrap="nowrap" class="normalfnt_size12">INVOICE</td>
                </tr>
            </table></td>
          </tr>
        </table>
      </div>
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
    <td><div  style="z-index:25; position:absolute; left:98px; top:1123px; width:350px; height:44px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12">THE MANAGER</td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12">BOARD OF INVESTMENT OF SRILANKA</td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12">NO14 SIR BARON JAYATHILAKE MW</td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt_size12">COLOMBO SRILANKA</td>
            </tr>
            </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:95px; top:388px; width:233px; height:41px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; line-height:11px;">
              <tr>
                <td nowrap="nowrap" >FROM : COLOMBO, SRI LANKA</td>
              </tr>
              <tr>
                <td width="308" nowrap="nowrap" >BY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo strtoupper($dataholder['strTransportMode']);?> FREIGHT</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:294px; top:559px; width:68px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?> CTNS</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div>
      <div  style="z-index:25; position:absolute; left:165px; top:556px; width:128px; height:24px;"  >
        <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td  nowrap="nowrap" class="normalfnt_size12"><?php echo $detail_data_set['dblQuantity']." ".$detail_data_set['strUnitID']; ?></td>
          </tr>
        </table>
    </div></td>
    <td><div  style="z-index:25; position:absolute; left:644px; top:314px; width:130px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $dataholder['countrydest'];?></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div>
      <div  style="z-index:25; position:absolute; left:503px; top:1071px; width:114px; height:24px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $dataholder["strPortOfLoading"]; ?></td>
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
    <td><div  style="z-index:25; position:absolute; left:165px; top:582px; width:187px; height:24px;"  >
      <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  nowrap="nowrap" class="normalfnt_size12">MATERIAL : <?php echo $detail_data_set['strFabric'];?></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:400px; top:559px; width:187px; height:32px;"  >
      <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td  nowrap="nowrap" class="normalfnt_size12"><?php echo $r_summary->summary_string_lbl($invoiceNo,'strDescOfGoods');?> </td>
            </tr>
        </table>
    </div>
      <div  style="z-index:25; position:absolute; left:596px; top:847px; width:168px; height:22px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="93" nowrap="nowrap" class="normalfnt_size12" style="text-align:center"><?php echo $detail_data_set['dblQuantity'];?></td>
                  <td width="73" nowrap="nowrap" class="normalfnt_size12" style="text-align:right"><?php  echo $r_summary->summary_sum($invoiceNo,'dblAmount');?></td>
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
    <td><div  style="z-index:25; position:absolute; left:353px; top:657px; width:416px; height:43px;"  >
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="normalfnt_size12">
        <tr>
          <td width="65%" nowrap="nowrap"  style="text-align:center"><strong>D.O.NO.</strong></td>
          <td width="15%" nowrap="nowrap"  style="text-align:center"><strong>QTY (PCS)</strong></td>
          <td width="20%" nowrap="nowrap"  style="text-align:center"><strong>US$</strong></td>
        </tr>
        <tr>
          <td style="text-align:center">&nbsp;</td>
          <td style="text-align:center">&nbsp;</td>
          <td style="text-align:center">&nbsp;</td>
        </tr>
        <?php $str_hs_dtl="select strISDno,dblQuantity,dblAmount from commercial_invoice_detail
where strInvoiceNo='$invoiceNo' and strHSCode='$hs'";
		 $resukt_hs_dtl=$db->RunQuery($str_hs_dtl);
		 while($row_hs_dtl=mysql_fetch_array($resukt_hs_dtl)){
		 ?>
        <tr>
          <td style="text-align:center"><?php echo $row_hs_dtl['strISDno'];?></td>
          <td style="text-align:center"><?php echo $row_hs_dtl['dblQuantity'];?></td>
          <td style="text-align:right"><?php  echo number_format($row_hs_dtl['dblAmount'],2);?></td>
        </tr>
        <?php }?>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:493px; top:385px; width:240px; height:41px;"  >
      <table width="240" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="71" nowrap="nowrap" class="normalfnt_size12"> CAT NO : </td>
              <td width="160" nowrap="nowrap" class="normalfnt_size12"><?php echo $com_inv_dataholder["strCat"]; ?></td>
            </tr>
            <tr>
              <td colspan="2" nowrap="nowrap" class="normalfnt_size12"><?php echo $r_summary->summary_string_lbl($invoiceNo,'strDescOfGoods');?></td>
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
    <td><div  style="z-index:25; position:absolute; left:690px; top:1072px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt_size12"><?php echo $dateInvoice; ?></td>
              </tr>
          </table></td>
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
    <td width="10%" height="25">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
/*var htpl=$.ajax({url:'../packinglist_formats/pl_levis_euro.php?plno=1',async:false})
$('#pl').html(htpl.responseText);
*/
var i=0;
<?php 

if($limitNo==0){
$str_counter="select strHSCode from commercial_invoice_detail 
				where strInvoiceNo='$invoiceNo'
				group by strHSCode	
				 
				";
$result_counter=$db->RunQuery($str_counter);

while($row_counter=mysql_fetch_array($result_counter))
{if($i>0){?>
	window.open("co_boi.php?InvoiceNo=<?php echo $invoiceNo?> &limitNo=<?php echo $i?>","<?php echo $i.'x'?>");

<?php
}
$i++;
}
}
?>
</script>
</body>
</html>
