<?php 
session_start();
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Previous Vessel</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="985" border="0" cellspacing="0" cellpadding="1" align="center">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" align="center">
				<tr>
				<td>
				<table width="100%" border="0" cellspacing="0" align="center">
					<tr>
					<td width="19%">&nbsp;</td>
						<td width="18%" align="center"><img src="../../../../images/callogo.jpg" /></td>
							<td width="63%">
								<table>
									<tr>
										<td class="normalfnBLD1"><h2><?php echo $Company; ?></h2></td>
									</tr>
									<tr>
										<td class="normalfnBLD1"><?php echo $Address; echo $City ?></td>
									</tr>
									<tr>
										<td class="normalfnBLD1">Telephone: <?php echo $phone; ?> Facsimile: <?php echo $Fax; ?></td>
									</tr>
									<tr>
										<td class="normalfnBLD1">Email: ravi@maliban.com<?php //echo $Website ?></td>
									</tr>
								</table>
				  			 </td>
						</tr>
					</table>
				  </td>
				</tr>
				
				<tr>
				<td>
				<table width="100%" border="0" cellspacing="0" align="center">
					<tr>
					<td width="19%">&nbsp;</td>
						<td width="19%">&nbsp;</td>
							<td width="62%">		  			  </td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">06.10.2011</td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">The Manager Verification </td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">BOI</td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">Air Cargo Village </td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">Katunayake.</td>
					  <td></td>
				  </tr>
				  <tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" ></td>
					  <td></td>
				  </tr>
				  <tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">Dear Sir,</td>
					  <td></td>
				  </tr>
					</table>
				  </td>
				</tr>
				
				
				<tr>
				<td>
				<table width="100%" border="0" cellspacing="0" align="center">
					<tr>
					<td width="19%">&nbsp;</td>
						<td width="71%">&nbsp;</td>
							<td width="10%">		  			  </td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">&nbsp;<b>EXPORT ENTRY NO: R-25064</b></td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt">&nbsp;</td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">We bring to your kind attention the FABRIC of above numbered Export Entry </td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">Cage no: 31 should read as <b>99% COTTON 1% SPANDEX</b> and not <b>100% COTTON </b>which is an error.</td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt">&nbsp;</td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">We would be much obliged if you could amend the Export Entry. </td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt">&nbsp;</td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">We regret any inconvenience caused to you and thank you for your kind Co-operation. </td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt">&nbsp;</td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">Yours faithfully, </td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">Group Shipping Manager, </td>
					  <td></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td class="normalfnt" style="font-size:12px">K.Ravindren</td>
					  <td></td>
				  </tr>
					</table>
				  </td>
				</tr>
				
			</table> 
		</td>
	</tr>
</table>

</body>
</html>
