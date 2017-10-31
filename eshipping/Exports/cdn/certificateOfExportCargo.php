
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CERTIFICATE OF EXPORT CARGO</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1050" border="0" cellspacing="0" cellpadding="1" align="center">
	<tr height="2%">
    	<td height="51" class="normalfnBLD1" style="text-align:center; font-size:14px">CERTIFICATE OF EXPORT CARGO</td>
    </tr>
    <tr>
   	  <td height="81">
		<table cellspacing="0" border="0" align="center" width="100%">
			<tr>
				<td width="14%">&nbsp;</td>
				<td width="16%" class="normalfnt">Name of the Enterprise:</td>
				<td width="30%" class="dotborder-bottom"><span class="normalfnBLD1"><?php echo $Company; ?></span></td>
				<td width="40%">&nbsp;</td>
			</tr>
			<?php
				$sql_entry="SELECT strCustomesEntry FROM cdn_header WHERE intCDNNo=$cdnNo;"; 
				$result_entry=$db->RunQuery($sql_entry);
				$row_entry=mysql_fetch_array($result_entry);
				$exEntryNo=$row_entry['strCustomesEntry'];
			?>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt">Export Entry No: </td>
			  <td class="dotborder-bottom"><span class="normalfnBLD1"><?php echo $exEntryNo; ?></span></td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td height="28">&nbsp;</td>
			  <td class="normalfnt">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		</table>
	</td>
	</tr>
	<tr>
		<td height="83">
		<table border="0" align="center" cellspacing="0" width="100%">
			<tr>
				<td width="14%" height="38">&nbsp;</td>
				<td width="70%" class="normalfnBLD1">Senior Manager (Export Services) H/O-</td>
				<td width="16%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">&nbsp;&nbsp;&nbsp;This is to certify that the under-mentioned goods are to be shipped against the above Export Entry</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
			  <td height="21">&nbsp;</td>
			  <td class="normalfnt">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>

	<tr>
		<td height="288">
		<table border="0" align="center" cellspacing="0" width="100%">
			<tr>
				<td width="25%">&nbsp;</td>
				<td width="11%" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">Item No</span></td>
				<td width="19%" class="border-top-left" style="text-align:center"><span class="normalfnBLD1">No of ctns./pkgs./rolls</span></td>
				<td width="20%" class="border-Left-Top-right" style="text-align:center"><span class="normalfnBLD1">Quantity pcs./kgs./dzs.</span></td>
				<td width="25%">&nbsp;</td>
			</tr>
			<?php
			$itemNo=0;
				$sql="SELECT
						cdn_detail.intCDNNo,
						cdn_detail.strInvoiceNo,
						sum(cdn_detail.dblQuantity) AS QtySum,
						sum(cdn_detail.intNoOfCTns) AS CartonSum,
						cdn_header.dtmDate
						FROM
						cdn_detail
						INNER JOIN cdn_header ON cdn_header.intCDNNo = cdn_detail.intCDNNo 
						WHERE cdn_detail.intCDNNo=$cdnNo;
						";
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				$itemNo=$itemNo+1;
			$date=$row['dtmDate'];
			?>
			<tr>
				<td>&nbsp;</td>
				<td class="border-top-left" style="text-align:center">&nbsp;<?php echo $itemNo; ?></td>
				<td class="border-top-left" style="text-align:center">&nbsp;<?php echo $row['CartonSum']; ?></td>
				<td class="border-Left-Top-right" style="text-align:center">&nbsp;<?php echo $row['QtySum']; ?>&nbsp;<?php echo $row_sum['strUnitID']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<?php
			}
			$dateArray 	= explode(' ',$date);
			$FormatDate = $dateArray[0]
			
			?>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-Left-Top-right" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-Left-Top-right" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-Left-Top-right" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-Left-Top-right" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-Left-Top-right" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-Left-Top-right" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-left" style="text-align:center">&nbsp;</td>
			  <td class="border-Left-Top-right" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="border-top-bottom-left" style="text-align:center">&nbsp;</td>
			  <td class="border-top-bottom-left" style="text-align:center">&nbsp;</td>
			  <td class="border-All" style="text-align:center">&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>
	
	
	<tr>
		<td>
		<table border="0" align="center" cellspacing="0" width="100%">
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="14%">&nbsp;</td>
				<td width="13%" class="normalfnt">Container No./Nos. :</td>
				<td width="28%" class="dotborder-bottom">&nbsp;</td>
				<td width="45%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="dotborder-bottom">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="dotborder-bottom">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="dotborder-bottom">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt">Signature of the </td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		</table>
	</td>
</tr>


<tr>
	<td>
		<table border="0" align="center" cellspacing="0" width="100%">
			<tr>
				<td width="17%">&nbsp;</td>
				<td width="16%" class="normalfnt">Enterprise Representative:</td>
				<td width="22%" class="dotborder-bottom">&nbsp;</td>
				<td width="45%">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
		<?php
		$sql_per="SELECT
				wharfclerks.strName,
				wharfclerks.strPhone
				FROM
				cdn_header
				INNER JOIN wharfclerks ON cdn_header.intSignatory = wharfclerks.intWharfClerkID
				WHERE intCDNNo=$cdnNo
				;";
		$result_per=$db->RunQuery($sql_per);
		$row_per=mysql_fetch_array($result_per);
	?>

<tr>
	<td>
		<table border="0" align="center" cellspacing="0" width="100%">
			<tr>
				<td width="14%">&nbsp;</td>
				<td width="18%" class="normalfnt">Name</td>
				<td width="1%" class="normalfnt">:</td>
				<td width="22%" class="dotborder-bottom"><span class="normalfnBLD1"><?php echo $row_per['strName']; ?></span></td>
				<td width="45%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">Designation</td>
				<td class="normalfnt">:</td>
				<td class="dotborder-bottom"><span class="normalfnBLD1">SHIPPING MANAGER</span></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">Date</td>
				<td class="normalfnt">:</td>
				<td class="dotborder-bottom"><span class="normalfnBLD1"><?php echo $FormatDate; ?></span></td>
				<td>&nbsp;</td>
			</tr>
			
		</table>
	</td>
</tr>

</table>

</body>
</html>
