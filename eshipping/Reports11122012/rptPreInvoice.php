<?php
session_start();
include("../Connector.php");
//$iouno=$_GET['iouNo'];

$sqlinvoiceheader="SELECT 	
	strInvoiceNo, 
	dtmInvoiceDate, 
	bytType, 
	customers.strName AS CustomerName,
	CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress, 
	customers.strAddress1,
	customers.strAddress2,	
	customers.strcountry AS CustomerCountry,
	buyers.strBuyerID,
	buyers.strName AS BuyerAName, 
	buyers.strAddress1 AS buyerAddress1 ,
	buyers.strAddress2 AS buyerAddress2,
	buyers.strCountry AS BuyerCountry,
	strNotifyID1, 
	strNotifyID2,
	strLCNo AS LCNO,
	dtmLCDate AS LCDate, 
	strLCBankID, 
	dtmLCDate, 
	ID.strPortOfLoading, 
	city.strCity AS city,
	strCarrier, 
	strVoyegeNo, 
	dtmSailingDate, 
	strCurrency, 
	dblExchange, 	
	intNoOfCartons, 
	intMode, 
	strCartonMeasurement, 
	strCBM, 
	strMarksAndNos, 
	strGenDesc, 
	bytStatus, 
	intFINVStatus, 
	intCusdec
		 
	FROM 
	invoiceheader ID
	LEFT JOIN customers ON ID.strCompanyID=customers.strCustomerID
	LEFT JOIN buyers ON ID.strBuyerID =buyers.strBuyerID 
	LEFT JOIN city ON ID.strFinalDest =city.strCityCode 
	WHERE strInvoiceNo='111'";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$dateInvoice"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 
	  
?>

<HTML>

<STYLE>
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;} 
.fontColor10 {FONT-SIZE:11PT; ; FONT-FAMILY:Verdana; FONT-WEIGHT:BOLD; }
.fontColor11 {FONT-SIZE:9PT; ; FONT-FAMILY:Verdana; FONT-WEIGHT:BOLD; }
.fontColor12 {FONT-SIZE:7PT; ; FONT-FAMILY:Verdana; }
.fontColor13 {FONT-SIZE:7PT; ; FONT-FAMILY:Verdana; TEXT-DECORATION:UNDERLINE; }
.fontColor14 {FONT-SIZE:7PT; ; FONT-FAMILY:Verdana; FONT-WEIGHT:BOLD; }
.fontColor15 {FONT-SIZE:5PT; ; FONT-FAMILY:Verdana; }
.adornment10 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.adornment11 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-width:0PX; }
.adornment12 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-width:0PX; border-right-width:0PX; }
.adornment13 {border-color:000000; border-style:none; border-bottom-style:solid; border-bottom-color:000000; border-bottom-width:1PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-style:solid; border-right-color:000000; border-right-width:1PX; }
</STYLE>

<TITLE>Comercial Invoice</TITLE>
<BODY LEFTMARGIN="0" TOPMARGIN="0" BOTTOMMARGIN="0" RIGHTMARGIN="0">

<div style="z-index:25; position:absolute; left:0PX; top:129PX; border-color:000000; border-style:solid; border-top-width:1PX;  border-left-width:0px;border-right-width:0px; border-bottom-width:0px;width:737PX; ">
<table height="0px" width="736PX"><tr><td>&nbsp;</td></tr></table>
</div>

<TABLE border=1 style=" border-color:000000;  border-style:solid; border-left-width:0px;border-right-width:0px; border-bottom-width:0px;height:0px; width:742PX; z-index:25; position:absolute; left:0PX; top:129PX; ">
<TR><TD></TD></TR></TABLE>
<div style="z-index:25; position:absolute; left:0PX; top:284PX; border-color:000000; border-style:solid; border-top-width:1PX;  border-left-width:0px;border-right-width:0px; border-bottom-width:0px;width:737PX; ">
<table height="0px" width="736PX"><tr><td>&nbsp;</td></tr></table>
</div>

<TABLE border=1 style=" border-color:000000;  border-style:solid; border-left-width:0px;border-right-width:0px; border-bottom-width:0px;height:0px; width:742PX; z-index:25; position:absolute; left:0PX; top:284PX; ">
<TR><TD></TD></TR></TABLE>
<div  style=" z-index:25; position:absolute; left:186PX; top:350PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="34PX"><tr><td>&nbsp;</td></tr></table>
</div>
<div  style=" z-index:25; position:absolute; left:504PX; top:350PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="34PX"><tr><td>&nbsp;</td></tr></table>
</div>
<div  style=" z-index:25; position:absolute; left:637PX; top:350PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="34PX"><tr><td>&nbsp;</td></tr></table>
</div>
<div  style=" z-index:25; position:absolute; left:380PX; top:30PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="306PX"><tr><td>&nbsp;</td></tr></table>
</div>
<div  style=" z-index:25; position:absolute; left:380PX; top:350PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="33PX"><tr><td>&nbsp;</td></tr></table>
</div>
<div style="z-index:25; position:absolute; left:381PX; top:80PX; border-color:000000; border-style:solid; border-top-width:1PX;  border-left-width:0px;border-right-width:0px; border-bottom-width:0px;width:357PX; ">
<table height="0px" width="356PX"><tr><td>&nbsp;</td></tr></table>
</div>

<TABLE border=1 style=" border-color:000000;  border-style:solid; border-left-width:0px;border-right-width:0px; border-bottom-width:0px;height:0px; width:362PX; z-index:25; position:absolute; left:381PX; top:80PX; ">
<TR><TD></TD></TR></TABLE>
<div  style=" z-index:25; position:absolute; left:187PX; top:285PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="51PX"><tr><td>&nbsp;</td></tr></table>
</div>
<div  style=" z-index:25; position:absolute; left:540PX; top:286PX; border-color:000000; border-style:solid; border-left-width:1PX; border-top-width:0px; border-right-width:0px; border-bottom-width:0px;">
<table width="0px" height="49PX"><tr><td>&nbsp;</td></tr></table>
</div>

<DIV class="box" style="border-color:000000; border-style:none; border-bottom-style:solid; border-bottom-color:000000; border-bottom-width:1PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-style:solid; border-right-color:000000; border-right-width:1PX;   width:742PX; height:312PX; border-color:000000; z-index:10; position:absolute; left:0PX; top:30PX; ">
</DIV>

<DIV class="box" style="border-color:000000; border-style:none; border-bottom-style:solid; border-bottom-color:000000; border-bottom-width:1PX; border-left-style:solid; border-left-color:000000; border-left-width:1PX; border-top-style:solid; border-top-color:000000; border-top-width:1PX; border-right-style:solid; border-right-color:000000; border-right-width:1PX;   width:742PX; height:40PX; border-color:000000; z-index:10; position:absolute; left:0PX; top:350PX; ">
</DIV>

<DIV  style="z-index:25; position:absolute; left:192PX; top:8PX; width:384PX; height:19PX; " class="adornment10"  ALIGN="CENTER">
<table width="379PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="fontColor10">COMMERCIAL INVOICE</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:38PX; width:106PX; height:15PX; " class="adornment10" >
<table width="101PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">1. SHIPPER</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:62PX; width:351PX; height:15PX; " class="adornment10" >
<table width="346PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['CustomerName'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:78PX; width:351PX; height:15PX; " class="adornment10" >
<table width="346PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['strAddress1'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:94PX; width:351PX; height:15PX; " class="adornment10" >
<table width="346PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['strAddress2'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:384PX; top:36PX; width:208PX; height:15PX; " class="adornment10" >
<table width="203PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">3. NO & DATE OF INVOICE</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:134PX; width:296PX; height:15PX; " class="adornment10" >
<table width="291PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">2. FOR ACCOUNT & RISK OF MESSERS</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:158PX; width:351PX; height:15PX; " class="adornment10" >
<table width="346PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['BuyerAName'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:174PX; width:351PX; height:15PX; " class="adornment10" >
<table width="346PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['buyerAddress1'];?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:190PX; width:351PX; height:15PX; " class="adornment10" >
<table width="346PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['buyerAddress2']; ?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:206PX; width:351PX; height:15PX; " class="adornment10" >
<table width="346PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['BuyerCountry']."."; ?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:384PX; top:84PX; width:160PX; height:15PX; " class="adornment10" >
<table width="155PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">4. NO & DATE OF L/C</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:384PX; top:132PX; width:133PX; height:15PX; " class="adornment10" >
<table width="128PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">5. NOTIFY PARTY</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:294PX; width:160PX; height:15PX; " class="adornment10" >
<table width="155PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">6.PORT OF LOADING</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:192PX; top:294PX; width:184PX; height:15PX; " class="adornment10" >
<table width="179PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">7.FINAL DESTINATION</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:387PX; top:292PX; width:133PX; height:15PX; " class="adornment10" >
<table width="128PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">8.CARRIER</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:541PX; top:292PX; width:192PX; height:15PX; " class="adornment10" >
<table width="187PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">9.SAILING ON OR ABOUT</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:16PX; top:318PX; width:168PX; height:15PX; " class="adornment10" >
<table width="163PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['strPortOfLoading']; ?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:200PX; top:318PX; width:176PX; height:15PX; " class="adornment10" >
<table width="171PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['city']; ?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:394PX; top:318PX; width:144PX; height:15PX; " class="adornment10" >
<table width="139PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['strCarrier']; ?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:557PX; top:318PX; width:159PX; height:13PX; " class="adornment10" >
<table width="154PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $LCDate; ?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:8PX; top:358PX; width:146PX; height:15PX; " class="adornment10" >
<table width="141PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">10.MARKS & NOS</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:192PX; top:358PX; width:152PX; height:15PX; " class="adornment10" >
<table width="147PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">11.DESCRIPTION </span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:384PX; top:356PX; width:112PX; height:15PX; " class="adornment10" >
<table width="107PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">12.QUANTITY</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:512PX; top:356PX; width:120PX; height:15PX; " class="adornment10" >
<table width="115PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">13.UNIT PRICE</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:640PX; top:356PX; width:94PX; height:15PX; " class="adornment10" >
<table width="89PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11">14.AMOUNT</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:394PX; top:62PX; width:192PX; height:16PX; " class="adornment10" >
<table width="187PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor12"><?php echo $dataholder['strInvoiceNo'];?></span><span class="fontColor12"> OF </span><span class="fontColor12"><?php echo $dateInvoice ;?></span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:400PX; top:158PX; width:342PX; height:51PX; " class="adornment10" >
<table width="337PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >
<?php 

$buyerid=$dataholder['strNotifyID1'];
if ($dataholder['strBuyerID']==$dataholder['strNotifyID1'])
{
	$buyer= "SAME AS CONSIGNEE.";
}
else 
{	
	$sqlselectNotify="SELECT 
	strName, 
	strAddress1, 
	strAddress2, 
	strCountry, 
	strPhone	 
	FROM 
	buyers 
	WHERE strBuyerID='$buyerid'";
	$buyerresult=$db->RunQuery($sqlselectNotify);
	$buyerresultholder=mysql_fetch_array($buyerresult);
	die($sqlselectNotify);
	$buyer=$buyerresultholder['strName'];
	$notfyaddress1=$buyerresultholder['strAddress1'];
	$notifyaddress2=$buyerresultholder['strAddress2'];
	$notifycountry=$buyerresultholder['strCountry'];
}

echo $buyer;

?></td></tr></table>

<table width="337PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $notfyaddress1;?></td></tr></table>

<table width="337PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $notfyaddress2;?></td></tr></table>

<table width="337PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $notifycountry;?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:394PX; top:110PX; width:342PX; height:15PX; " class="adornment10" >
<table width="337PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" ><?php echo $dataholder['LCNO']; ?> OF <?php echo $LCDate; ?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:512PX; top:374PX; width:120PX; height:15PX; " class="adornment10"  ALIGN="CENTER">
<table width="115PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12"  ALIGN="CENTER">F.O.B  USD</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:390PX; top:412PX; width:104PX; height:15PX; " class="adornment10"  ALIGN="CENTER">
<table width="99PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12"  ALIGN="CENTER">66 PCS</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:390PX; top:428PX; width:104PX; height:15PX; " class="adornment10"  ALIGN="CENTER">
<table width="99PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12"  ALIGN="CENTER">5 - 6/12 DOZ</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:518PX; top:412PX; width:108PX; height:13PX; " class="adornment10"  ALIGN="CENTER">
<table width="103PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12"  ALIGN="CENTER">792.00</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:13PX; top:398PX; width:171PX; height:128PX; " class="adornment10" >
<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >MANUFACTURERS NAME</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >DEPT#</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >STYLE#</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >COLOR:</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >SIZE:</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >QTY:</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >CARTON.....</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >OF...</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >MADE IN SRI LANKA</td></tr></table>

<table width="166PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >PORT OF ENTRY TO :</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:637PX; top:412PX; width:100PX; height:13PX; " class="adornment10"  ALIGN="RIGHT">
<table width="95PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12"  ALIGN="RIGHT">4,356.00</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:200PX; top:398PX; width:176PX; height:15PX; " class="adornment10" >
<table width="171PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor13" >HANGING GARMENTS</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:518PX; top:428PX; width:104PX; height:15PX; " class="adornment10"  ALIGN="CENTER">
<table width="99PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12"  ALIGN="CENTER">PER DOZEN</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:200PX; top:422PX; width:174PX; height:64PX; " class="adornment10" >
<table width="169PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >588 BALES OF</td></tr></table>

<table width="169PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >COMPRESSED COIR</td></tr></table>

<table width="169PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >FIBRE PITH IN 4 CU.FT</td></tr></table>

<table width="169PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >BALE</td></tr></table>

<table width="169PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >(EACH 25 KG NETT)</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:176PX; top:670PX; width:560PX; height:16PX; " class="adornment10" >
<table width="555PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >TOTAL FOB COLOMBO US DOLLARS  FOUR THOUSAND THREE HUNDRED FIFTY-SIX ONLY</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:176PX; top:654PX; width:248PX; height:17PX; " class="adornment10" >
<table width="243PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor12">COUNTRY OF ORIGIN : SRI LANKA</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:176PX; top:718PX; width:560PX; height:16PX; " class="adornment10" >
<table width="555PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >TOTAL PCS : SIXTY-SIX ONLY</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:176PX; top:702PX; width:264PX; height:13PX; " class="adornment10" >
<table width="259PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor12">TEXTILE QUOTA CATEGORY NO : </span><span class="fontColor12">SKIRT</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:13PX; top:558PX; width:595PX; height:88PX; " class="adornment10" >
<table width="590PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor14" >BALANCE FOB 792.00 / DOZEN US DOLLARS PAYBLE COLOMBO</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:176PX; top:734PX; width:560PX; height:15PX; " class="adornment10" >
<table width="555PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor12" >TOTAL DOZENS : FIVE AND 6/12 DOZENS ONLY</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:640PX; top:561PX; width:96PX; height:88PX; " class="adornment10"  ALIGN="RIGHT">
<table width="91PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor14"  ALIGN="RIGHT">4,356.00</td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:13PX; top:1069PX; width:355PX; height:15PX; " class="adornment10" >
<table width="350PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor15" >COPYRIGHT � CALIFORNIA LINK (PVT) LTD</td></tr></table>
</DIV>
<BR>
</BODY>
</HTML>
