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
$invoiceNo=$_GET['InvoiceNo'];;
//$invoiceNo='10250/OTL/09/10';
//$invoiceNo='194/OTL/NY/02/11';
$limitNo=$_GET['limitNo'];
$limitNo =($limitNo==""?0:$limitNo);
//include("invoice_queries.php");	




$str_header="SELECT
invoiceheader.strInvoiceNo,
DATE(invoiceheader.dtmInvoiceDate) as dtmInvoiceDate,
buyers.strName as BuyerAName,
buyers.strAddress1 as buyerAddress1,
buyers.strAddress2 as buyerAddress2,
buyers.strAddress3,
buyers.strCountry AS BuyerCountry,
invoicedetail.strBuyerPONo,
invoicedetail.strDescOfGoods,
Sum(invoicedetail.intNoOfCTns) AS intNoOfCartons,
ROUND(Sum(invoicedetail.dblQuantity),0) AS dblQuantity,
ROUND(Sum(invoicedetail.dblAmount),2) AS dblAmount,
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
invoiceheader.strTransportMode,
invoicedetail.strStyleID,
country.strCountry,
country.strCountryCode,
invoicedetail.strFabrication,
invoicedetail.strCatNo,
ROUND(Sum(invoicedetail.intCBM),2) AS intCBM,
ROUND(Sum(invoicedetail.dblGrossMass),2) AS dblGrossMass
FROM
invoiceheader
INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
INNER JOIN buyers ON buyers.strBuyerID = invoiceheader.strBuyerID
INNER JOIN commercialinvformat ON invoiceheader.strInvFormat = commercialinvformat.intCommercialInvId
INNER JOIN city ON city.strCityCode = invoiceheader.strFinalDest
INNER JOIN country ON country.strCountryCode = city.strCountryCode
WHERE invoiceheader.strInvoiceNo = '$invoiceNo'
GROUP BY invoiceheader.strInvoiceNo

;";
	
	//die($str_detail);
$result_detail=$db->RunQuery($str_header);
$detail_data_set=mysql_fetch_array($result_detail);
//$hs = $detail_data_set["strHSCode"];


/*$SQL_countryCd="SELECT
country.strCountryCode AS cd
FROM
cdn_header
INNER JOIN city ON cdn_header.strPortOfDischarge = city.strCityCode
INNER JOIN country ON city.strCountryCode = country.strCountryCode
WHERE cdn_header.intCDNNo= '$cdnNo'";

$resultCountryCd = $db->RunQuery($SQL_countryCd);
$countryCdArry = mysql_fetch_array($resultCountryCd);*/
$ArrayinvYear=13;

$arrInvDate=$detail_data_set['dtmInvoiceDate'];
$invDate=explode(" ",$arrInvDate);
		
		
		
		
		
		
	
			$sql_dtl="SELECT
						cdn_header.strInvoiceNo,
						date(cdn_header.dtmSailingDate) AS dtmSailingDate,
						date(cdn_header.dtmDate) AS dtmDate,
						cdn_header.strVessel,
						cdn_header.strPortOfDischarge,
						city.strCity,
						city.strPortOfLoading as strcityOfLoading ,
						invoiceheader.strPortOfLoading as strPortOfLoading,
						date(cdn_header.dtmexportDate) as  dtmexportDate
						FROM
						cdn_header
						INNER JOIN cdn_detail ON cdn_header.strInvoiceNo = cdn_detail.strInvoiceNo
						INNER JOIN invoiceheader ON cdn_header.strInvoiceNo = invoiceheader.strInvoiceNo
						INNER JOIN city ON invoiceheader.strFinalDest = city.strCityCode
						WHERE
							cdn_header.strInvoiceNo='$invoiceNo'
						ORDER BY
						cdn_header.strInvoiceNo DESC
						";	
		
		$result_det=$db->RunQuery($sql_dtl);
			$detail_data=mysql_fetch_array($result_det);
		
		
					
				 echo $sql_shipped="SELECT	cdn_detail.strInvoiceNo,
					Sum(cdn_detail.intNoOfCTns) AS intFNoOfCTns,
					ROUND(Sum(cdn_detail.intCBM),2) AS intFCBM,
					ROUND(Sum(cdn_detail.dblGrossMass),2) AS dblFGrossMass,
					ROUND(Sum(cdn_detail.dblQuantity),0) AS dblFQuantity
					FROM
					cdn_detail
					WHERE
					cdn_detail.strInvoiceNo='$invoiceNo'
					AND cdn_detail.intDescStatus = '0'
					GROUP BY cdn_detail.strInvoiceNo";
	
			$result_shipped=$db->RunQuery($sql_shipped);
			$detail_shipped=mysql_fetch_array($result_shipped);			
						
				
		
		
				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CO</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("../Commercialinvoice/printer.php");?>
 <meta charset="utf-8" />
<title>jQuery UI Draggable - Default functionality</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
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
<table width="799" height="1033"border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" style="width:800px;">
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:507px; top:127px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div class="dragableElement"  style="z-index:25; position:absolute; left:39px; top:226px; width:222px; height:35px;"  >
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:652px; top:173px; width:35px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data["dtmexportDate"]; ?></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:105px; top:162px; width:83px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set["dtmInvoiceDate"]; ?></td>
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:568px; top:72px; width:89px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strInvoiceNo']; ?></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    
    
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:549px; top:116px; width:133px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data['strVessel']; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>  
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>   
                <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data['dtmSailingDate']; ?></td>
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:355px; top:238px; width:264px; height:44px;"  >
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
      <div   style="z-index:25; position:absolute; left:-185px; top:274px; width:88px; height:24px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <!--<tr>
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
                </tr>-->
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
                <tr>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine1']; ?></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  class="dragableElement"  style="z-index:25; position:absolute; left:666px; top:215px; width:141px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; line-height:11px;">
              <tr>
                <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data['strPortOfLoading']; ?> SRI LANKA</td>
              </tr>
              <tr>
                <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
              </tr>

          </table></td>
        </tr>
      </table>
    </div></td>
    
    <td><div  style="z-index:25; position:absolute; left:674px; top:265px; width:102px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; line-height:11px;">
              <tr>
                <td nowrap="nowrap" class="normalfnt"><?php echo $detail_data['strcityOfLoading']; ?></td>
              </tr>

          </table></td>
        </tr>
      </table>
</div></td>
    
     <td><div  style="z-index:25; position:absolute; left:663px; top:312px; width:134px; height:25px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; line-height:11px;">
              <tr>
                <td nowrap="nowrap" "class="dragableElement""><?php echo $detail_data['strCity']; ?></td>
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
       <td><div class="dragableElement" style="z-index:25; position:absolute; left:36px; top:692px; width:753px; height:44px;"  >
      <table width="100%" height="38" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="23" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strBuyerPONo']; ?></td>
     <td width="7">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="44">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="44">&nbsp;</td>
                <td width="27" nowrap="nowrap" class="normalfnt"> <?php echo $detail_data_set['strStyleID']; ?></td>
         <td width="4">&nbsp;</td>
    <td width="14">&nbsp;</td>
    <td width="14">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="34">&nbsp;</td>             
               
                <td width="38" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['dblQuantity'];?></td>
   <td width="9">&nbsp;</td>
    <td width="59">&nbsp;</td>
    <td width="59">&nbsp;</td>
    <td width="50">&nbsp;</td>
       <td width="49">&nbsp;</td>
    <td width="50">&nbsp;</td>
     
                <td width="26" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_data_set['intNoOfCartons'];?></td>
     <td width="9">&nbsp;</td>
    <td width="39">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="30">&nbsp;</td>
       <td width="29">&nbsp;</td>
    <td width="30">&nbsp;</td>
     
                <td width="26" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_data_set['intCBM'];?></td>
 <td width="9">&nbsp;</td>
    <td width="39">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="30">&nbsp;</td>
       <td width="29">&nbsp;</td>
    <td width="30">&nbsp;</td>
     
     
                <td width="26" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_data_set['dblGrossMass'];?></td>
                
 <td width="9">&nbsp;</td>
    <td width="19">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
       <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
     
     
                <td width="26" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_shipped['dblFQuantity'];?></td>     <td width="5">&nbsp;</td>
 <td width="9">&nbsp;</td>
    <td width="19">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
       <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
     
                <td width="26" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_shipped['intFNoOfCTns'];?></td>     <td width="5">&nbsp;</td>
  <td width="9">&nbsp;</td>
    <td width="19">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
       <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
     
                <td width="26" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_shipped['intFCBM'];?></td>     <td width="5">&nbsp;</td>
    <td width="9">&nbsp;</td>
    <td width="19">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
       <td width="29">&nbsp;</td>
    <td width="10">&nbsp;</td>
     
     
                <td width="100" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_shipped['dblFGrossMass'];?></td>         
                
                
                
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:389px; top:512px; width:187px; height:24px;" >
      <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
          <td  nowrap="nowrap" class="normalfnt"><?php echo $detail_shipped['intFNoOfCTns'];?>  Cartons Containing</td>
          </tr>
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
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:389px; top:573px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt"><u>Style</u></td>
              
            </tr>
            <tr>
              <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strStyleID']; ?></td>
              
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
    <td height="34">&nbsp;</td>
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
    <td height="19">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="dragableElement" style="z-index:25; position:absolute; left:504px; top:574px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><u>Order No</u></td>
              </tr>
               <tr>
                <td width="308" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strBuyerPONo']; ?></td>
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
    
  <tr bgcolor="#FFFFFF">
    <td height="19">&nbsp;</td>
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
    <td height="31">&nbsp;</td>
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
    <td height="19">&nbsp;</td>
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
    <td height="19">&nbsp;</td>
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
