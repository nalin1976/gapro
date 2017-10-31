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
$invoiceNo=$_GET['newCellInvoiceNo'];

$abc=$_GET['abc'];

$invoo123 = explode(",", $abc);
$count=count(explode(",", $abc));

/*$invoo123 = explode(',', $abc);

$i = 0;
$data = count($invoo123);

while ($i < $count) {

    $lowvalue = $data[$i++];

}
echo $lowvalue;*/
$date=$_GET['date'];
$name_arr=$_GET['name_arr'];
$org_arr1=$_GET['org_arr1'];
$copy_arr1=$_GET['copy_arr1'];
$org_arr2=$_GET['org_arr2'];
$copy_arr2=$_GET['copy_arr2'];
$cboBuyer=$_GET['cboBuyer'];
include("invoice_queries.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOCUMENT CHECK LIST</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.fnt4{
		font-family:Arial;
		font-size:4px;
		text-align:center;
		line-height:6px;
}
.fnt6{
		font-family:Arial;
		font-size:6px;
		text-align:center;
		line-height:8px;
}
.fnt7{
		font-family:Arial;
		font-size:7px;
		text-align:center;
		line-height:9px;
}
.fnt8{
		font-family:Arial;
		font-size:8px;
		text-align:center;
		line-height:10px;
}
.fnt9{
		font-family:Arial;
		font-size:11px;
		line-height:11px;
}
.fnt12{
		font-family:Arial;
		font-size:12px;
		text-align:center;
		line-height:14px;
}
.fnt12-bold{
		font-family:Arial;
		font-size:12px;
		font-weight:900;
		line-height:14px;
}

.fnt12-bold-head{
		font-family:Arial;
		font-size:13px;
		text-align:center;
		font-weight:900;
		line-height:14px;
}

.fnt14-bold{
		font-family:Arial;
		font-size:16px;
		font-weight:700;
		line-height:20px;
}
.fnt16-bold{
		font-family:Arial;
		font-size:18px;
		text-align:center;
		font-weight:700;
		line-height:20px;
}
.fnt30-bold{
		font-family:Arial;
		font-size:34px;
		text-align:center;
		font-weight:700;
}

</style>
<?PHP //$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
//include("printer.php");?>
</head>

<?php
$sql="SELECT
				
									buyers.strBuyerId,
									buyers.strName
									FROM
									buyers
									where strBuyerId ='$cboBuyer'
									";
							$result=$db->RunQuery($sql);
							
							$datahol				=mysql_fetch_array($result);
	$consigneee 			= $datahol['strName'];
?>

<body class="body_bound">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" class=" border-Left-Top-right" style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:60px" height="56" >MAERSK LOGISTICS</td>
  </tr>

  <tr>
    <td colspan="3" class="border-Left-bottom-right" style="text-align:right;font-family:'Times New Roman';font-weight:bold;font-size:17px" height="29"><span class="border-left-right" style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:16px">We deliver certainty</span></td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:right"></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="4%">&nbsp;</td>
    <td width="92%"><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" class="fnt16-bold" style="text-align:left"><u><I>CHECK LIST FOR VENDOR DOCUMENTS</I></u></td>
      </tr>
      <tr>
        <td colspan="7" class="fnt16-bold" style="text-align:center"></td>
      </tr>
      <tr>
        <td colspan="7" class="fnt16-bold" style="text-align:center"></td>
      </tr>
      
      <tr>
        <td height="24">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="font-weight:bold; font-size:14px">TO</td>
        <td colspan="3" style="font-weight:bold; font-size:14px">: MAERSK LOGISTICS CFS</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      	<td colspan="7">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="font-weight:bold; font-size:14px">SHIPPER NAME</td>
        <td colspan="3" style="font-weight:bold; font-size:14px">: <?php echo $Company;?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      	<td colspan="7">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="font-weight:bold; font-size:14px; vertical-align:text-top;">ENTRY NAME</td>
        <td colspan="3" style="font-weight:bold; font-size:14px">:
        <?php
		for($x=0;$x<$count;$x++)
		{
			echo $invoo123[$x]."</br>"."&nbsp;"."&nbsp;";
		
		}
		?>
        &nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
      	<td colspan="7">&nbsp;</td>
      </tr>
 
      <tr>
      	<td colspan="7">&nbsp;</td>
      </tr>

      <tr>
      	<td colspan="7">&nbsp;</td>
      </tr>

      <tr>
      	<td colspan="7">&nbsp;</td>
      </tr>
     
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     <tr>
      	<td>&nbsp;</td>
        <td colspan="3" class="border-top-left" style="font-size:15px">CUSDEC</td>
        <td colspan="2" class="border-top-left" style="text-align:center; font-size:14px">&nbsp;</td>
        <td class=" border-Left-Top-right" style="text-align:center; font-size:14px">&nbsp;</td>
      </tr>
    
      <tr>
      	<td>&nbsp;</td>
        <td colspan="3" class="border-top-bottom-left" style="font-size:15px">S.L.P.A</td>
        <td colspan="2" class="border-top-bottom-left">&nbsp;</td>
        <td class="border-All">&nbsp;</td>
      </tr>
      
            <tr>
      	<td>&nbsp;</td>
        <td colspan="3" class="border-top-bottom-left" style="font-size:15px">CAPTAIN'S COPY</td>
        <td colspan="2" class="border-top-bottom-left">&nbsp;</td>
        <td class="border-All">&nbsp;</td>
      </tr>
      
            <tr>
      	<td>&nbsp;</td>
        <td colspan="3" class="border-top-bottom-left" style="font-size:15px">SHIPPING ORDER</td>
        <td colspan="2" class="border-top-bottom-left">&nbsp;</td>
        <td class="border-All">&nbsp;</td>
      </tr>
      
            <tr>
      	<td>&nbsp;</td>
        <td colspan="3" class="border-top-bottom-left" style="font-size:15px">PACKING LIS</td>
        <td colspan="2" class="border-top-bottom-left">&nbsp;</td>
        <td class="border-All">&nbsp;</td>
      </tr>
      
      
            <tr>
      	<td>&nbsp;</td>
        <td colspan="3" class="border-top-bottom-left" style="font-size:15px">INVOICV</td>
        <td colspan="2" class="border-top-bottom-left">&nbsp;</td>
        <td class="border-All">&nbsp;</td>
      </tr>
      
            <tr>
      	<td>&nbsp;</td>
        <td colspan="3" class="border-top-bottom-left" style="font-size:15px">OTHER DOCUMENT</td>
        <td colspan="2" class="border-top-bottom-left">&nbsp;</td>
        <td class="border-All">&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5" class="fnt14-bold">RECEIVED  BY &nbsp;&nbsp;: ........................................................</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="3%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="34%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="17%">&nbsp;</td>
        <td width="17%">&nbsp;</td>
      </tr>
    </table></td>
    <td width="4%">&nbsp;</td>
  </tr>
</table>
</body>
</html>