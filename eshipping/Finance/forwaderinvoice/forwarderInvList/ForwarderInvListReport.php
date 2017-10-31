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

$forwarderId=$_GET['forwarderId'];
$accSubmitted=$_GET['accSubmitted'];
$DateFrom=$_GET['DateFrom'];
$DateTo=$_GET['DateTo'];

$dateFromInvArray 	= explode('/',$DateFrom);
$FormatDateFrom   = $dateFromInvArray[2]."-".$dateFromInvArray[1]."-".$dateFromInvArray[0];
	
$dateToArray 	= explode('/',$DateTo);
$FormatDateTo   = $dateToArray[2]."-".$dateToArray[1]."-".$dateToArray[0];



$sql_for="SELECT strName FROM forwaders 
		  WHERE intForwaderID=$forwarderId;";
$result_for=$db->RunQuery($sql_for);
$row_for=mysql_fetch_array($result_for);
$forwarderName=$row_for['strName'];

$invoiceNo=$_GET['invoiceNo'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Forwarder Invoice Report</title>
</head>

<body>
<table width="100" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="" height="10"></td>
  </tr>
  <tr>
    <td class="normalfntMid" height="18"></td>
  </tr>
  <tr>
    <td class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="200%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td width="93%" class="">
        <table width="808">
        	<tr>
            	<td width="293" rowspan="2"> <img align="right" src="../../../images/callogo.jpg" /></td>
            	<td width="503" height="30"><label class="normalfnth2B"><?php echo $Company;?></label><br /><br /><u>Manufacturers and Exporters of Quality Garments</u></td>
                
            </tr>
            <tr>
            	<td class="normalfntMid" height="20" style="text-align:left"><?php echo $Address." ".$City?><br /><?php echo "Tel ".$phone." Fax ".$Fax;?><br /><?php echo "E-mail: general@maliban.com";?></td>
            </tr>
        </table>
        </td>
      </tr>
	  
	  <tr>
        <td width="93%" class="">
        <table width="804">
		<tr>
			<td width="9">&nbsp;</td>
			<td width="775">&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="9">&nbsp;</td>
			<td width="775">&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="9">&nbsp;</td>
			<td width="775" align="center" class="normalfnt-center_size12"><b>&nbsp;Forwarder Invoice Report </b></td>
			<td width="10">&nbsp;</td>
		</tr>
		</table>
		</td>
	</tr>
	
	 
	  <tr>
        <td width="93%" class="">
        <table width="804" cols="4" class="tablez">
		<tr>
			<td width="168">&nbsp;</td>
			<td width="309" class="normalfnBLD1" height="25">&nbsp;Forwarder :<span class="normalfnt"><?php echo $forwarderName; ?></span></td>
			
			<td width="287" class="normalfnBLD1">Invoice No :&nbsp;<span class="normalfnt"><?php if($invoiceNo!=0)echo $invoiceNo; ?></span></td>
			<td width="20">&nbsp;</td>
		</tr>
		<tr>
			<td width="168">&nbsp;</td>
			<td width="309" class="normalfnBLD1" height="25">&nbsp;</td>
			<td width="287">&nbsp;</td>
			<td width="20">&nbsp;</td>
		</tr>
		</table>
		
		</td>
	</tr>
	
	
	 <tr>
        <td width="93%">
        <table width="804" class="tablez">
		<tr>
		
			  <td  class="normalfnBLD1" height="25" align="center">Invoice No</td>
			    <td class="normalfnBLD1" align="center">Date</td>
			<td class="normalfnBLD1" align="center">Amount</td>
			<td class="normalfnBLD1" align="center">Cheque No</td>
			<td class="normalfnBLD1" height="25" align="center">Paid Amount</td>
			<td class="normalfnBLD1" align="center">Acc. Submit</td>
			<td class="normalfnBLD1" align="center">Submit Date</td>
		
		</tr>
		<?php 
		$sql="SELECT
			forwader_invoice_header.strInvoiceNo,
			forwader_invoice_header.dtmDate,
			forwader_invoice_header.dblAmount,
			forwader_invoice_header.strChequeNo,
			forwader_invoice_header.dblPaidAmount,
			forwader_invoice_header.intSubmitStatus,
			forwader_invoice_header.dtmSubmitDate
			FROM
			forwader_invoice_header
			WHERE dtmDate<='$FormatDateTo' AND dtmDate >='$FormatDateFrom' AND intForwaderId=$forwarderId 
			";
			
	if($invoiceNo!=0)
		$sql.=" AND strInvoiceNo='$invoiceNo'";
	if($accSubmitted=='Submitted')
		$sql.=" AND intSubmitStatus=1";
	if($accSubmitted=='NotSubmitted')
		$sql.=" AND intSubmitStatus=0";
	//echo $sql;	
	$result=$db->RunQuery($sql);
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
	?>
		<tr>
			<td class="normalfnt" height="25" align="center" style="text-align:center"><?php echo $row['strInvoiceNo']; ?></td>
			<td class="normalfnt" align="center" style="text-align:center"><?php echo $row['dtmDate']; ?></td>
			<td class="normalfnt" align="center" style="text-align:center"><?php echo $row['dblAmount']; ?></td>
			<td class="normalfnt" align="center" style="text-align:center"><?php echo $row['strChequeNo']; ?></td>
			<td class="normalfnt" height="25" align="center" style="text-align:center"><?php echo $row['dblPaidAmount']; ?></td>
			<td class="normalfnt" align="center" style="text-align:center">
			<?php
			if($row['intSubmitStatus']==1) 
				echo "Submitted";
			else
				echo "Not Submitted";
			?>
			</td>
			<td class="normalfnt" align="center" style="text-align:center"><?php echo $row['dtmSubmitDate']; ?></td>
		</tr>
	<?php
	}
	?>
		</table>
		
		</td>
	</tr>
	
	
	
	  
    </table></td>
  </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 </table>
</body>
</html>
