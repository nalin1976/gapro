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
//$invoiceNo='10250/OTL/09/10';
//$invoiceNo='194/OTL/NY/02/11';
$limitNo=$_GET['limitNo'];
$limitNo =($limitNo==""?0:$limitNo);
//include("invoice_queries.php");	




$str_header="SELECT
cdn_header.strInvoiceNo,
cdn_header.intConsignee,
cdn_header.intShipper,
cdn_header.dtmSailingDate,
cdn_header.dtmDate,
cdn_header.strPortOfDischarge,
buyers.strName AS BuyerAName,
buyers.strAddress1 AS buyerAddress1,
buyers.strAddress2 AS buyerAddress2,
buyers.strAddress3 AS buyerAddress3,
buyers.strCountry AS BuyerCountry,
city.strCity,
city.strPortOfLoading,
country.strCountry AS countrydest,
Sum(cdn_detail.intNoOfCTns) AS intNoOfCTns,
Sum(cdn_detail.dblQuantity) AS dblQuantity,
cdn_detail.strUnitID,
cdn_detail.dblUnitPrice,
round(sum(cdn_detail.dblAmount),2) AS dblAmount,
cdn_detail.strStyleID,
cdn_detail.strBuyerPONo,
commercialinvformat.strMMLine1,
commercialinvformat.strMMLine2,
commercialinvformat.strMMLine3,
commercialinvformat.strMMLine4,
commercialinvformat.strMMLine5,
commercialinvformat.strMMLine6,
commercialinvformat.strMMLine7,
commercialinvformat.strSMLine1,
commercialinvformat.strSMLine2,
commercialinvformat.strSMLine3,
commercialinvformat.strSMLine4,
commercialinvformat.strSMLine5,
commercialinvformat.strSMLine6,
commercialinvformat.strSMLine7,
cdn_detail.strCatNo,
cdn_detail.strDescOfGoods,
cdn_detail.strFabrication,
invoiceheader.strTransportMode
FROM
cdn_header
INNER JOIN buyers ON buyers.strBuyerID = cdn_header.intConsignee
INNER JOIN city ON city.strCityCode = cdn_header.strPortOfDischarge
LEFT JOIN country ON country.strCountryCode = city.strCountryCode
INNER JOIN cdn_detail ON cdn_detail.intCDNNo = cdn_header.intCDNNo
INNER JOIN invoiceheader ON invoiceheader.strInvoiceNo = cdn_detail.strInvoiceNo
INNER JOIN commercialinvformat ON invoiceheader.strInvFormat = commercialinvformat.intCommercialInvId
WHERE cdn_header.intCDNNo=$cdnNo
GROUP BY cdn_detail.intCDNNo
;";
	
	//die($str_detail);
$result_detail=$db->RunQuery($str_header);
$detail_data_set=mysql_fetch_array($result_detail);
$hs = $detail_data_set["strHSCode"];


$SQL_countryCd="SELECT
country.strCountryCode AS cd
FROM
cdn_header
INNER JOIN city ON cdn_header.strPortOfDischarge = city.strCityCode
INNER JOIN country ON city.strCountryCode = country.strCountryCode
WHERE cdn_header.intCDNNo= '$cdnNo'";

$resultCountryCd = $db->RunQuery($SQL_countryCd);
$countryCdArry = mysql_fetch_array($resultCountryCd);
$ArrayinvYear=13;

$arrInvDate=$detail_data_set['dtmDate'];
$invDate=explode(" ",$arrInvDate);
				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CO</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
<style>
#draggable { width: 150px; height: 150px; padding: 0.5em; }
</style>
<script>
$(function() {
$( "#draggable" ).draggable();
});
</script>
</head>

<body class="body_bound">
<table style="width:800px;"border="0" cellspacing="1" cellpadding="0" bgcolor="#FFFFFF">
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
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:542px; top:69px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt">2013</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div  style="z-index:25; position:absolute; left:82px; top:70px; width:277px; height:35px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; line-height:12px;">
            <tr>
              <td nowrap="nowrap" class="normalfnt"><?php echo $Company;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt"><?php echo $Address;?></td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt"><?php echo $City;?></td>
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
    <td><div class="dragableElement"  style="z-index:25; position:absolute; left:484px; top:269px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $Country; ?></td>
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:737px; top:76px; width:32px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set["strCatNo"]; ?></td>
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:604px; top:38px; width:89px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><?php print("LK".$countryCdArry["cd"]." ".$ArrayinvYear."02");  ?></td>
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
    <td><div  style="z-index:25; position:absolute; left:82px; top:188px; width:350px; height:44px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; line-height:11px;">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['BuyerAName'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['buyerAddress1'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['buyerAddress2'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['BuyerCountry'];?></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <div  style="z-index:25; position:absolute; left:-9px; top:302px; width:88px; height:24px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine1']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine2']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine3']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine4']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine5']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine6']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine7']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine1']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine2']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine3']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine4']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine5']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine6']; ?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine7']; ?></td>
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left: 79px; top: 1031px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt">THE MANAGER</td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt">BOARD OF INVESTMENT OF SRILANKA</td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt">NO14 SIR BARON JAYATHILAKE MW</td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="normalfnt">COLOMBO SRILANKA</td>
            </tr>
            </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:80px; top:367px; width:233px; height:41px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; line-height:11px;">
              <tr>
                <td nowrap="nowrap" class="normalfnt">FROM : COLOMBO, SRI LANKA</td>
              </tr>
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt">BY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo strtoupper($detail_data_set['strTransportMode']); ?> FREIGHT</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div  style="z-index:25; position:absolute; left:483px; top:365px; width:68px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt" style="text-align:center">NILL</td>
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
    <td><div  style="z-index:25; position:absolute; left:269px; top:507px; width:68px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['intNoOfCTns'];?> CTNS</td>
            </tr>
          </table></td>
        </tr>
      </table>
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
    <td><div  style="z-index:25; position:absolute; left:686px; top:493px; width:68px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt" style="text-align:center">F.O.B</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div>
      <div  style="z-index:25; position:absolute; left:340px; top:508px; width:128px; height:24px;"  >
        <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td  nowrap="nowrap" class="normalfnt"> CONTAINING </td>
          </tr>
        </table>
    </div></td>
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:642px; top:268px; width:130px; height:27px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['countrydest'];?></td>
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
    <td><div  style="z-index:25; position:absolute; left:269px; top:532px; width:187px; height:24px;"  >
      <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['dblQuantity']." PCS"; ?> of <?php echo $detail_data_set['strDescOfGoods'];?></td>
          </tr>
          <tr>
           <td  nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strFabrication'];?></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:267px; top:588px; width:187px; height:32px;"  >
      <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td  nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strFabrication
'];?></td>
            </tr>
        </table>
    </div>
      <div  style="z-index:25; position:absolute; left:591px; top:557px; width:168px; height:22px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="93" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_data_set['dblQuantity'];?></td>
                  <td width="73" nowrap="nowrap" class="normalfnt" style="text-align:right"><?php  echo $detail_data_set['dblAmount'];?></td>
                </tr>
            </table></td>
          </tr>
        </table>
    </div></td>
    <td><div  style="z-index:25; position:absolute; left:589px; top:524px; width:168px; height:22px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="93" nowrap="nowrap" class="normalfnt" style="text-align:center">(PCS)</td>
                  <td width="73" nowrap="nowrap" class="normalfnt" style="text-align:center">(USD)</td>
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
    <td><div  style="z-index:25; position:absolute; left:264px; top:656px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt">Style : <?php echo $detail_data_set['strStyleID']; ?></td>
            </tr>
          </table></td>
        </tr>
      </table>
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
    <td><div  style="z-index:25; position:absolute; left:261px; top:749px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt">INVOICE NO : <?php echo $detail_data_set['strInvoiceNo']; ?></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div  style="z-index:25; position:absolute; left:261px; top:708px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt">PO NO : <?php echo $detail_data_set['strBuyerPONo']; ?></td>
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; width:114px; height:24px; left: 494px; top: 1014px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="308" nowrap="nowrap" class="normalfnt">COLOMBO</td>
                </tr>
            </table></td>
          </tr>
        </table>
    </div></td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; width:114px; height:24px; left: 652px; top: 1010px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $invDate[0]; ?></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
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
<script type="text/javascript" src="dragable/dragable-content.js"></script>
</html>
