<?php
session_start();

include("../Connector.php");
$iouno=$_GET['iouNo'];

$xmldoc=simplexml_load_file('../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$Vat=$xmldoc->companySettings->Vat;


$sqlheaderfetch="SELECT intIOUNo,
 customers.strName AS customer,
 IOH.strVessel AS vessel,
 IOH.strPrevDoc AS bl,
 IOH.intSettled AS settled,
 suppliers.strName AS supliers,
 IOH.strMerchandiser,
 forwaders.strName AS forwader,
 wharfclerks.strName AS wharfclerk,
 strLCNumber AS LC ,
 deliverynote.intDeliveryNo AS deliveryNo,
 IOH.dblPackages,
 IOH.intIOUPrint AS printStatus,
 paymentterm.strPaymentTerm AS PaymentTerms
FROM tbliouheader IOH
LEFT JOIN customers ON IOH.strCustomerID=customers.strCustomerID 
LEFT JOIN suppliers ON IOH.intExporterID=suppliers.strSupplierId
LEFT JOIN	forwaders ON IOH.intForwarder=forwaders.intForwaderID
LEFT JOIN wharfclerks ON IOH.intWharfClerk=wharfclerks.intWharfClerkID
LEFT JOIN deliverynote ON IOH.intDeliveryNo=deliverynote.intDeliveryNo
LEFT JOIN paymentterm ON IOH.strPaymentTerms=paymentterm.strPaymentTermID
WHERE IOH.intIOUNo='$iouno' ";
//die($sqlheaderfetch);

$headerresult=$db->RunQuery($sqlheaderfetch);
$content=mysql_fetch_array($headerresult);

$settled=$content['settled'];
$printStatus	= $content['printStatus'];
?>
<HTML>

<STYLE>
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;} 
.fontColor10 {FONT-SIZE:9PT; ; FONT-FAMILY:Verdana; }
.fontColor11 {FONT-SIZE:17PT; ; FONT-FAMILY:Verdana; }
.fontColor12 {FONT-SIZE:21PT; ; FONT-FAMILY:Verdana; }
.fontColor13 {FONT-SIZE:8PT; ; FONT-FAMILY:Verdana; FONT-WEIGHT:BOLD; }
.fontColor14 {FONT-SIZE:9PT; ; FONT-FAMILY:Verdana; FONT-WEIGHT:BOLD; }
.fontColor15 {FONT-SIZE:47PT; COLOR:DADADA; FONT-FAMILY:Castellar; }
.fontColor16 {FONT-SIZE:8PT; ; FONT-FAMILY:Verdana; }
.fontColor17 {FONT-SIZE:8PT; ; FONT-FAMILY:Verdana; FONT-WEIGHT:BOLD; }
.fontColor18 {FONT-SIZE:7PT; ; FONT-FAMILY:Verdana; }
.fontColor19 {FONT-SIZE:9PT; ; FONT-FAMILY:Times New Roman; }
.fontColor110 {FONT-SIZE:7PT; ; FONT-FAMILY:Times New Roman; }
.adornment10 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.adornment11 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.adornment12 {border-color:000000; border-style:none; border-bottom-style:solid; border-bottom-color:000000; border-bottom-width:1PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-style:solid; border-right-color:000000; border-right-width:1PX; }
.adornment13 {border-color:F8F8F8; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.adornment14 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-width:0PX; }
.adornment15 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-width:0PX; border-right-width:0PX; }
.adornment16 {border-color:000000; border-style:none; border-bottom-style:solid; border-bottom-color:000000; border-bottom-width:1PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-style:solid; border-right-color:000000; border-right-width:1PX; }
</STYLE>

<TITLE>IOU :: Report </TITLE>
<link href="../../../eshipping/css/erpstyle.css" rel="stylesheet" type="text/css" />
<BODY LEFTMARGIN="0" TOPMARGIN="0" BOTTOMMARGIN="0" RIGHTMARGIN="0" style="opacity:0.9" >

<div style="z-index:25; position:absolute; left:0PX; top:101PX; border-color:000000; border-style:solid; border-top-width:1PX;  border-left-width:0px;border-right-width:0px; border-bottom-width:0px;width:731PX; ">
<table height="0px" width="730PX"><tr><td>&nbsp;</td></tr></table>
</div>

<TABLE border=1 style=" border-color:000000;  border-style:solid; border-left-width:0px;border-right-width:0px; border-bottom-width:0px;height:0px; width:736PX; z-index:25; position:absolute; left:0PX; top:101PX; ">
<TR><TD></TD></TR></TABLE>
<div style="z-index:25; position:absolute; left:1PX; top:0PX; border-color:000000; border-style:solid; border-top-width:1PX;  border-left-width:0px;border-right-width:0px; border-bottom-width:0px;width:730PX; ">
<table height="0px" width="729PX"><tr><td>&nbsp;</td></tr></table>
</div>

<TABLE border=1 style=" border-color:000000;  border-style:solid; border-left-width:0px;border-right-width:0px; border-bottom-width:0px;height:0px; width:735PX; z-index:25; position:absolute; left:1PX; top:0PX; ">
<TR><TD></TD></TR></TABLE>
<div  style=" z-index:25; position:absolute; left:0PX; top:0PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="101PX"><tr><td>&nbsp;</td></tr></table>
</div>
<div  style=" z-index:25; position:absolute; left:736PX; top:1PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="101PX"><tr><td>&nbsp;</td></tr></table>
</div>
<DIV class="box" style="border-color:000000; border-style:none; border-bottom-style:solid; border-bottom-color:000000; border-bottom-width:1PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-style:solid; border-right-color:000000; border-right-width:1PX;   width:733PX; height:224px; border-color:000000; z-index:10; position:absolute; left:1px; top:128px; ">
  <DIV  style="z-index:25; position:absolute; left:91px; top:53px; width:281px; height:15PX; " class="adornment11" >
    <table width="285PX" border=0 cellpadding="0" cellspacing="0">
      <tr>
        <td NOWRAP class="fontColor16" ><?php echo $Vat;?></td>
      </tr>
    </table>
  </DIV>
</DIV>

<DIV class="box" style="border-color:000000; border-style:none; border-bottom-style:solid; border-bottom-color:000000; border-bottom-width:1PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-style:solid; border-right-color:000000; border-right-width:1PX;   width:733PX; height:85PX; border-color:000000; z-index:10; position:absolute; left:1px; top:807px; ">
</DIV>

<DIV  style="z-index:15; position:absolute; left:1PX; top:8PX; width:143PX; height:88PX; " class="adornment10" >
<img   SRC="../../../eshipping/images/callogo.jpg">
</DIV>
<DIV  style="z-index:25; position:absolute; left:0PX; top:40PX; width:736PX; height:16PX; " class="adornment11"  ALIGN="CENTER">
<table width="731PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="fontColor10"><?php echo $Address." ".$City.", ".$Country."."  ;?></span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:0PX; top:56PX; width:736PX; height:16PX; " class="adornment11"  ALIGN="CENTER">
<table width="731PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="fontColor10">Tel: <?php echo $phone; ?>    Fax: <?php echo $Fax; ?></span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:0PX; top:72PX; width:736PX; height:16PX; " class="adornment11"  ALIGN="CENTER">
<table width="731PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="fontColor10">email: <?php echo $email;?>     Web Site : <?php echo $Website; ?></span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:4PX; top:100px; width:728PX; height:29PX; " class="adornment11"  ALIGN="CENTER">
<table width="723PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="fontColor11">I O U</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:0PX; top:8PX; width:736PX; height:32PX; " class="adornment11"  ALIGN="CENTER">
<table width="731PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="companyTitle"><?php echo $Company; ?></span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:616PX; top:112PX; width:104PX; height:15PX; " class="adornment11"  ALIGN="RIGHT">
<table width="99PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor13"  ALIGN="RIGHT"><?php echo date("d/m/Y");?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:640PX; top:80PX; width:96PX; height:15PX; " class="adornment11" >
<table width="91PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor14" >IMPORT</td></tr></table>
</DIV>
<?php
if($printStatus==0 && $settled==0)
	$status	= "ORIGINAL";
else if($printStatus==1 && $settled==0)
	$status	= "DUPLICATE";
else
	$status	= "SETTLED";
?>
<DIV  style="z-index:25; position:absolute; left:91px; top:286px; width:544PX; height:72PX; " class="adornment13"  ALIGN="CENTER">
<table width="539PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><div class="fontColor15" style="opacity:0.4"><?PHP echo $status ;?></div></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:92px; top:158PX; width:274px; height:15PX; " class="adornment11" >
<table width="285PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" ><?php echo $content['customer']?></td></tr></table>
</DIV>

o<table width="299PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" >&nbsp;</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:92px; top:204PX; width:285px; height:15PX; " class="adornment11" >
<table width="285PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" ><?php echo $content['vessel'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:92px; top:229PX; width:284px; height:15PX; " class="adornment11" >
<table width="285PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor17" ><?php echo $content['bl'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:465px; top:206PX; width:241px; height:15PX; " class="adornment11" >
<table width="242" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="fontColor16" ><?php echo $content['forwader'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:464px; top:230PX; width:184PX; height:15PX; " class="adornment11" >
<table width="179PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" ><?php echo $content['wharfclerk'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:464px; top:182PX; width:223px; height:15PX; " class="adornment11" >
<table width="220" height="21" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="fontColor16" ><?php echo $content['strMerchandiser'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:92px; top:134PX; width:120PX; height:15PX; " class="adornment11" >
<table width="115PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" ><?php echo $content['intIOUNo'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:134PX; width:72PX; height:17PX; " class="adornment11" >
<table width="70PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor14">I O U No</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:158PX; width:68px; height:17PX; " class="adornment11" >
<table width="70PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor14">Consignee</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:7PX; top:180PX; width:73px; height:17PX; " class="adornment11" >
<table width="70PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor14">VAT</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:206PX; width:68px; height:17PX; " class="adornment11" >
<table width="70PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor14">Vessel</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:230PX; width:69px; height:17PX; " class="adornment11" >
<table width="70PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor14">B/L No </span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:378px; top:206PX; width:72px; height:15PX; " class="adornment11" >
<table width="66" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="paragraph"><span class="fontColor13">Forwarder</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:379px; top:230PX; width:76px; height:15PX; " class="adornment11" >
<table width="81" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="paragraph"><span class="fontColor13">Wharf Clerk </span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:2px; top:378px; width:733px; height:60px; " class="adornment11" >
  <table width="100%" border="0"  cellspacing="0" cellpadding="0">
    <tr>
      <td width="52%" height="20" class="border-All"><strong>Expenses</strong></td>
      <td width="14%" class="border-top-bottom-right"><div align="center"><strong>Estimate</strong></div></td>
      <td width="12%" class="border-top-bottom-right"><div align="center"><strong>Actual</strong></div></td>
      <td width="12%" class="border-top-bottom-right"><div align="center"><strong>Varience</strong></div></td>
      <td width="10%" class="border-top-bottom-right"><div align="center"><strong>Invoice</strong></div></td>
    </tr>
    <tr>
      <td class="border-Left-bottom-right">&nbsp;</td>
      <td class="border-bottom-right"><div align="right" >&nbsp;</div></td>
      <td class="border-bottom-right"><div align="right" >&nbsp;</div></td>
      <td class="border-bottom-right"><div align="right" >&nbsp;</div></td>
      <td class="border-bottom-right"><div align="right" >&nbsp;</div></td>
    </tr>
    
    
		<?php
			//set proper font class		
		
		$sql="SELECT 	(SELECT strDescription FROM expensestype WHERE tblioudetails.intExpensesID=expensestype.intExpensesID)AS Expense	, 	dblEstimate, dblActual, (dblActual-dblEstimate)AS short,dblInvoice	 
	FROM tblioudetails WHERE intIOUNo='$iouno'";
		//die($sql);
			$result= $db -> RunQuery ($sql);
		$totEstimate=0;
		while($row=mysql_fetch_array($result))
		{
		 echo"<tr height='17'><td class='border-Left-bottom-right'>".$row['Expense']."</td>";
		 echo"<td class='border-bottom-right' ><div align='right' >".$row['dblEstimate']."</div></td>";
		 echo"<td class='border-bottom-right'><div align='right' >".($row['dblActual']==0 ? "&nbsp;":$row['dblActual'])."</div></td>";
		 $totEstimate+=$row['dblEstimate'];
		 $totActual+=$row['dblActual'];		 
		 $totShortage+=$row['short'];
		 $totinvoice+=$row['dblInvoice'];
		 echo"<td class='border-bottom-right'><div align='right' >".'&nbsp;'."</div></td>";
		 echo"<td class='border-bottom-right'><div align='right' >".($row['dblInvoice']==0 ? "&nbsp;":$row['dblInvoice'])."</div></td>";
		 echo"</tr>";
		}
		echo"<tr><td class='border-Left-bottom-right'><strong>Total</strong></td><td class='border-bottom-right'><div align='right' ><strong>".$totEstimate."</strong></div></td><td class='border-bottom-right'><div align='right' ><strong>" .($totActual==0 ? "&nbsp;":$totActual). "</strong></div></td><td class='border-bottom-right'><div align='right' ><strong>&nbsp;</strong></div></td></td><td class='border-bottom-right'><div align='right' ><strong>". ($totinvoice==0 ? "&nbsp;":$totinvoice). "</strong></div></td>"; 
		
      ?>
	
     
  

    
    
  </table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:377px; top:182PX; width:79px; height:16PX; " class="adornment11" >
<table width="84" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="paragraph"><span class="fontColor13">Merchandiser</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:377px; top:159px; width:89px; height:15PX; " class="adornment11" >
<table width="85" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="paragraph"><span class="fontColor13">Container No</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:376px; top:134PX; width:91px; height:15PX; " class="adornment11" >
<table width="83" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="paragraph"><span class="fontColor13">No Of CTNS</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:463px; top:158PX; width:88PX; height:15PX; " class="adornment11" >
<table width="83PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" style="text-align:center"><?php echo $content['deliveryNo'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:463px; top:134PX; width:67PX; height:15PX; " class="adornment11"  ALIGN="RIGHT">
<table width="62PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16"  ALIGN="RIGHT"><?php echo $content['dblPackages'];?></td>
</tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:379px; top:254PX; width:139px; height:16PX; " class="adornment11" >
<table width="140" border=0 cellpadding="0" cellspacing="0">
  <tr><td NOWRAP class="paragraph"><span class="fontColor14">Terms of Payments</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:380px; top:274PX; width:88PX; height:17PX; " class="adornment11" >
<table width="83PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor14">LC #</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:527px; top:254PX; width:104PX; height:15PX; " class="adornment11" >
<table width="99PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" ><?php echo $content['PaymentTerms']?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:464px; top:274PX; width:184PX; height:15PX; " class="adornment11" >
<table width="179PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor16" ><?php echo $content['LC']?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:254PX; width:70px; height:15PX; " class="adornment11" >
<table width="70PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor14">Supplier</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:92px; top:254PX; width:275px; height:15PX; " class="adornment11" >
<table width="285PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor18" ><?php echo $content['supliers']?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:9px; top:820px; width:403PX; height:15PX; " class="adornment11" >
<table width="398PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor19">Prepared By: .........................................................................................</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:9px; top:844px; width:404PX; height:15PX; " class="adornment11" >
<table width="399PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor19">Approved By: ......................................................................................</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:9px; top:868px; width:396PX; height:15PX; " class="adornment11" >
<table width="391PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor19">Authorised By:......................................................................................</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:157px; top:791px; width:481PX; height:15PX; " class="adornment11" >
<table width="476PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor13" >N/A</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:1px; top:791px; width:144PX; height:16PX; " class="adornment11" >
	<table width="139PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor13">Reason for Duplicate : </span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:1px; top:896px; width:744PX; height:15PX; " class="adornment11"  ALIGN="RIGHT">
<table width="739PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="RIGHT"><span class="fontColor110">Copyright California Link (Pvt) Ltd.</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:433px; top:868px; width:304PX; height:15PX; " class="adornment11" >
<table width="299PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor19">Recieved By: ..........................................................</span></td></tr></table>
</DIV>
<BR>
</BODY></HTML>
<?php 
$sqlprint="update tbliouheader set intIOUPrint=1 where intIOUNo=$iouno;";
$result_iouprint=$db->RunQuery($sqlprint);
?>