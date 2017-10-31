
<?php 
session_start();
include "../../Connector.php";
include_once 'common_report.php';
$xmldoc=simplexml_load_file('../../config.xml');

$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$invoiceNo=$_GET['InvoiceNo'];	

include "../Preshipmentdocs/Commercialinvoice/buyerwiseinvoices/invoice_queries.php";
include "../Preshipmentdocs/Commercialinvoice/buyerwiseinvoices/common_report.php";

$fromDate	=$_GET["fromDate"];
$toDate	=$_GET["toDate"];
$numofelement	=$_GET["numofelement"]; // number of dynomic columns 
$dbFieldNames = $_GET["dbFieldNames"];  // field names as it's in the data base
$fieldGivenNames =$_GET["fieldGivenNames"]; // given names for those fields in the summary.php screen
//$col_width		=90/($numofelement+7);
$dynColumnNames = ($fieldGivenNames!=''?explode(',',$fieldGivenNames):null); // converting the given name to an array.
$dynDbFieldNames = ($dbFieldNames!=''?explode(',',$dbFieldNames):null); //converting the given database fieldnames to an array.

# retreiving invoice numbers within a date period
$sql = "SELECT
		CIH.strInvoiceNo,
		date(CIH.dtmInvoiceDate)as dtmInvoiceDate,
		BYR.strName,
		CID.dblUnitPrice,
		CID.dblAmount,
		CID.strBuyerPONo,
		CID.dblQuantity,
		FI.dblTotFreight,
		FI.dblTotInsuranse,
		FI.dblTotDest,
		COALESCE(((FI.dblTotInsuranse+FI.dblTotInsuranse+FI.dblTotDest)*(CID.dblQuantity)),0)as FOB,
		
		 ";
		//echo $sql;
if($dbFieldNames !="") // if there is any fields being checked, then add to the sql
{
	//$sql .=",";
	//$dbFieldNames";
	foreach($dynDbFieldNames as $val1)
	{
		$temparray = explode('.',$val1);
		if(substr($temparray[1],0,3)=='dtm'){
		$sql .="date($val1) as $temparray[1],";	
		}
		else $sql .="$val1,";
		
	}
		}
$sql .=	"COALESCE(((FI.dblTotInsuranse+FI.dblTotInsuranse+FI.dblTotDest)),0)as invoiceAmount";
$sql .=	" FROM
		commercial_invoice_header AS CIH
		Inner Join commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
		Left Join finalinvoice AS FI ON CIH.strInvoiceNo = FI.strInvoiceNo
		Left Join buyers AS BYR ON CIH.strBuyerID = BYR.strBuyerID
		WHERE CIH.dtmInvoiceDate BETWEEN  '$fromDate' AND '$toDate'
		ORDER BY
		CIH.dtmInvoiceDate ASC,
		CIH.strInvoiceNo ASC;";

//echo $sql ;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Summary Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>


<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
<tr bordercolor="#FFFFFF"><td   height="25" style="font-size:14px"><strong>REPORT SUMMARY</strong></td></tr>
<tr bordercolor="#FFFFFF"><td>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
  <tr class="tbl-h-fnt" style="background:#CCC;text-align:center" >
    <td style="text-align:center" class="border-Left-Top-right tbl-h-fnt" align="center" width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>Invoice No</strong></td>
    <td style="text-align:center" class="border-top-right tbl-h-fnt" width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>FOB Date</strong></td>
        <td class="border-top-right tbl-h-fnt" style="text-align:center"  width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>Buyer</strong></td>
    <?php
		
		foreach($dynColumnNames as $val){
	
	?>
 		<td style="text-align:center" class="border-top-right tbl-h-fnt" width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong><?php echo $val?></strong> </td>
	<?php
		}
		?>
    
    <td class="border-top-right tbl-h-fnt" style="text-align:center"  width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>PO No</strong></td>
    <td class="border-top-right tbl-h-fnt" style="text-align:center" width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>Quantity</strong></td>
    <td class="border-top-right tbl-h-fnt" style="text-align:center" width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>Unit Price</strong></td>
    <td class="border-top-right tbl-h-fnt" style="text-align:center" width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>FOB</strong></td>
    <td class="border-top-right tbl-h-fnt" style="text-align:center"  width="<?php echo $col_width."%";?>" nowrap="nowrap"><strong>Amount</strong></td>
  </tr>
    <?php
	$result = $db->RunQuery($sql);
	//echo mysql_num_rows($result);
	while($row=mysql_fetch_array($result))
	{
		
	?> 
  <tr class="tbl-h-fnt">
    <td class="border-Left-Top-right-fntsize9 tbl-h-fnt" align="center" ><?php echo $row["strInvoiceNo"]; ?></td>
    <td class="border-top-right tbl-h-fnt" ><?php echo $row["dtmInvoiceDate"];?></td>
    <td class="border-top-right tbl-h-fnt" ><?php echo $row["strName"];?></td>

	<?php
	 foreach($dynDbFieldNames as $val2){
	?>
    <td class="border-top-right tbl-h-fnt" nowrap="nowrap" ><?php $val2_array=explode(".",$val2);$val2=$val2_array[1]; echo $row[$val2];
	
	?></td>
    <?php
	 }
	?>
    <td class="border-top-right tbl-h-fnt" ><?php echo $row["strBuyerPONo"];?></td>
    <td class="border-top-right tbl-h-fnt" style="text-align:right"><?php 
	$totalQuantity+=$row["dblQuantity"];
	
	echo $row["dblQuantity"]; ?></td> 
    <td class="border-top-right tbl-h-fnt" style="text-align:right"><?php echo $row["dblUnitPrice"]; ?></td>
    <td class="border-top-right tbl-h-fnt" style="text-align:right"><?php 
	$totalFob+= $row["FOB"];
	if ($row["FOB"])echo sprintf( "%.2f", $row["FOB"]);else echo '0.00';
	 ?></td>
    <td class="border-top-right tbl-h-fnt" style="text-align:right"><?php 
	$ammount = $row["FOB"]+ $row["dblAmount"];
	$totalAmmount +=$ammount;
	if ($ammount)echo sprintf( "%.2f",$ammount);else echo '0.00'; ?></td>

  </tr>
      <?php
	  }
	?>
    <tr class="tbl-h-fnt" style="background:#CCC">
    <td colspan="3" align="center" class="border-Left-Top-right-fntsize9 tbl-h-fnt"><strong>TOTAL</strong></td>
    <?php
		
		foreach($dynColumnNames as $val){
	
	?>
 		<td class="border-top-right tbl-h-fnt" width="<?php echo $col_width."%";?>" >&nbsp;</td>
	<?php
		}
		?>
    
    <td class="border-top-right tbl-h-fnt"  width="<?php echo $col_width."%";?>">&nbsp;</td>
    <td class="border-top-right tbl-h-fnt"  style="text-align:right" width="<?php echo $col_width."%";?>"><strong><?php if ( $totalQuantity)echo sprintf( "%.2f", $totalQuantity);else echo '0.00';?></strong></td>
    <td class="border-top-right tbl-h-fnt" width="<?php echo $col_width."%";?>">&nbsp;</td>
    <td class="border-top-right tbl-h-fnt" width="<?php echo $col_width."%";?>" style="text-align:right"><strong><?php if ( $totalFob)echo sprintf( "%.2f", $totalFob);else echo '0.00';?></strong></td>
    <td class="border-top-right tbl-h-fnt"  width="<?php echo $col_width."%";?>" style="text-align:right"><strong><?php if ( $totalAmmount)echo sprintf( "%.2f", $totalAmmount);else echo '0.00';?></strong></td>
  </tr>
</table>
</td></tr>
<tr bordercolor="#FFFFFF"><td  align="center" height="25" class="border-top">&nbsp; </td></tr>
</table>


</body>
</html>