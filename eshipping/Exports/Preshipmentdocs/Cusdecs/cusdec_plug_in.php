<?php 
session_start();
include "../../../Connector.php";
include 'common_report.php';
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
include("invoice_queries.php");	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CO</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<?PHP //$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<?php
$sql="SELECT
invoiceheader.strInvoiceNo,
invoiceheader.strPortOfLoading,
Sum(invoicedetail.intCBM) AS intCBM,
Sum(invoicedetail.dblAmount) AS dblAmount,
Sum(invoicedetail.dblQuantity) AS dblQuantity,
(SELECT wharfclerks.strName FROM wharfclerks WHERE intWharfClerkID=invoiceheader.intMarchantId) AS strName,
customers.strMLocation AS mLocation,
invoicedetail.strPriceUnitID
FROM
invoiceheader
INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
INNER JOIN customers ON customers.strCustomerID = invoiceheader.intManufacturerId
WHERE invoiceheader.strInvoiceNo='$invoiceNo'
GROUP BY invoiceheader.strInvoiceNo";
//die("pass");
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{	
	$portOfLoading 				= $row["strPortOfLoading"];
	$cbm					= $row["intCBM"];
	$Amount						= $row["dblAmount"];
	$quantity				= $row['dblQuantity'];
	$declarentName			= $row['strName'];
	$mLocation				= $row['mLocation'];
	$priceUnitID			= $row['strPriceUnitID'];
}

//echo $sql;

?>
<table height="2070"border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" style="width:800px;">
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
    <td><div  style="z-index:25; position:absolute; left:506px; top:246px; width:105px; height:51px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="21" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                  <td width="78" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt_size10" style="text-align:center">LK</td>
                  <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" >&nbsp;</td>
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
    <td><div  style="z-index:25; position:absolute; left:385px; top:273px; width:208px; height:49px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="24" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td width="137" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
                <td width="49" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" >LK</td>
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
    <td><div  style="z-index:25; position:absolute; left:591px; top:601px; width:159px; height:49px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="101%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="24" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td width="137" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" ><?php echo $Amount; ?></td>
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
    <td><div  style="z-index:25; position:absolute; left:216px; top:406px; width:235px; height:49px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="24" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td width="137" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
                <td width="49" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" ><?php echo $portOfLoading; ?></td>
                <td nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
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
    <td><div  style="z-index:25; position:absolute; left:207px; top:439px; width:235px; height:49px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="24" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td width="137" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
                <td width="49" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" ><?php echo $mLocation; ?></td>
                <td nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
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
    <td><div  style="z-index:25; position:absolute; left:509px; top:662px; width:110px; height:49px;"  >
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="87%"><table width="101%" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="24" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                  <td width="137" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                  <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" ><?php echo $quantity; ?> <?php echo $priceUnitID; ?></td>
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
    <td height="25"><div  style="z-index:25; position:absolute; left:51px; top:787px; width:325px; height:78px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="114" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="24" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td width="137" nowrap="nowrap" class="normalfnt_size10" >&nbsp;</td>
              </tr>
			  <tr>
                <td height="19" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left
				" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left
				" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left" >REMITTANCE. USD <?PHP echo $Amount; ?></td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left" ><?php echo $cbm;?> CBM</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left" ><?php echo $mLocation; ?></td>
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
    <td><div  style="z-index:25; position:absolute; left:533px; top:823px; width:261px; height:95px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="93" border="0" cellpadding="0" cellspacing="0">
              
              
              <tr>
                <td width="18" height="19" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td width="69" nowrap="nowrap" class="normalfnt_size10" style="text-align:left" >&nbsp;</td>
                <td width="198" nowrap="nowrap" class="normalfnt_size10" style="text-align:center" >&nbsp;</td>
              </tr>
              <tr>
                <td height="19" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left" >&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" ><span class="normalfnt_size10" style="text-align:center"><?PHP echo $Amount; ?><span class="normalfnt_size10" style="text-align:center"> USD</span></span></td>
              </tr>
              <tr>
                <td height="19" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left" >&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:left" >&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" ><?PHP echo $Amount; ?> USD </td>
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
    <td><div  style="z-index:25; position:absolute; left:504px; top:935px; width:265px; height:41px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="101%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="21" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td style="text-align:center" width="242" nowrap="nowrap" class="normalfnt_size10" > <?php echo $declarentName; ?></td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" class="normalfnt_size10" style="text-align:center" >&nbsp;</td>
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
    <td width="10%" height="25">&nbsp;</td>
	<td width="20%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><div  style="z-index:25; position:absolute; left:536px; top:1044px; width:265px; height:41px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="101%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="24" class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td nowrap="nowrap" ><span class="normalfnt_size10">T.P.L.A.H. PERERA &nbsp;</span></td>
				<td nowrap="nowrap" style="text-align:CENTER" ><span class="normalfnt_size10">190800</span></td>
              </tr>
              <tr>
                <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
                <td width="111" nowrap="nowrap" class="normalfnt_size10" style="text-align:LEFT" >&nbsp;</td>
                <td width="128" nowrap="nowrap" class="normalfnt_size10" style="text-align:LEFT" >&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="6" valign="top" class="border-Left-Top-right-fntsize12"><span class="normalfnt_size12">55. INSRUCTION FOR AMENDMENTS / EXAMINATIONS:</span></td>
  </tr>
  
    <td height="51" colspan="6" class="border-left-right"><table width="100%" border="0">
      <tr>
        <td width="5%" class="normalfnt">Name:</td>
        <td width="21%" class="dotborder-bottom">&nbsp;</td>
        <td width="7%" class="normalfnt">Signature:</td>
        <td width="37%" class="dotborder-bottom">&nbsp;</td>
        <td width="4%" class="normalfnt">Date:</td>
        <td width="16%" class="dotborder-bottom">&nbsp;</td>
        <td width="10%">&nbsp;</td>
      </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="30" colspan="6" valign="top" class="border-left-right"><span class="normalfnt">As per above instructions system was amended.</span></td>
  </tr>
  <tr>
    <td height="89" colspan="6"class="border-Left-bottom-right-fntsize12">
		<table width="100%" border="0">
      <tr>
        <td width="5%" class="normalfnt">Name:</td>
        <td width="21%" class="dotborder-bottom">&nbsp;</td>
        <td width="7%" class="normalfnt">Signature:</td>
        <td width="37%" class="dotborder-bottom">&nbsp;</td>
        <td width="4%" class="normalfnt">Date:</td>
        <td width="16%" class="dotborder-bottom">&nbsp;</td>
        <td width="10%">&nbsp;</td>
      </tr>
      </table>
	</td>
  </tr>
  <tr>
    <td height="173" colspan="6" valign="top"class="border-Left-bottom-right-fntsize12"><span class="normalfnt_size12">56. EXAMINATION REPORT:</span>
      <table width="100%" border="0">
        <tr>
          <td height="119" class="normalfnt_size10" valign="bottom" style="text-align:right">Examination Officer/s</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="241" colspan="6" valign="top" class="border-Left-bottom-right-fntsize12"><span class="normalfnt_size12">57. POST CLEARENCE SECTION:</span></td>
  </tr>
  <tr>
    <td height="171" colspan="6" valign="top" class="border-Left-bottom-right-fntsize12"><span class="normalfnt_size12">58. BOUNDING SECTION:</span></td>
  </tr>
  <tr>
    <td colspan="6" class="border-left-right"><table width="100%" border="0">
      <tr>
        <td width="31%" height="29" class="normalfnt_size12">59. LOADING/DELIVERY POINT - (A)OFFICE:</td>
        <td width="18%" class="dotborder-bottom">&nbsp;</td>
        <td width="16%" class="normalfnt_size12">(B)S.L.P.A BN/DO No:</td>
        <td width="20%" class="dotborder-bottom">&nbsp;</td>
        <td width="15%" class="normalfnt">&nbsp;</td>
      </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="17" colspan="6" class="border-Left-bottom-right-fntsize12"></td>
  </tr>
  <tr>
    <td class="border-Left-bottom-right-fntsize12"> (C) Date</td>
    <td class="border-bottom-right-fntsize12">(D) Cint/Vehi/Fit/G. Pass No</td>
    <td class="border-bottom-right-fntsize12">(E) No. of Pkgs</td>
    <td class="border-bottom-right-fntsize12">(F) Qty. (Nt./Gr.</td>
    <td class="border-bottom-right-fntsize12">(G) Remarks</td>
    <td class="border-bottom-right-fntsize12">(H) Initial</td>
  </tr>
  <tr>
    <td width="10%" height="90" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
    <td width="20%" class="border-bottom-right-fntsize12">&nbsp;</td>
    <td width="13%" class="border-bottom-right-fntsize12">&nbsp;</td>
    <td width="13%" class="border-bottom-right-fntsize12">&nbsp;</td>
    <td width="22%" class="border-bottom-right-fntsize12">&nbsp;</td>
    <td width="22%" class="border-bottom-right-fntsize12">&nbsp;</td>
  </tr>
</table>
</body>
</html>
