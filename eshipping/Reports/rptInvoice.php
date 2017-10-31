<?php 
session_start();
include "../Connector.php";
$xmldoc=simplexml_load_file('../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$Email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
// CONCAT(customers.strAddress1,', ',customers.strAddress2) AS customeraddress,
$invoiceNo=$_GET['iouNo'];	
$sqlinvoiceheader="SELECT intIOUNo,
 customers.strName AS customer,
 customers.strTIN as vatno,
 strEntryNo,
 customers.strAddress1,
 customers.strAddress2,
 IOH.strVessel AS vessel,
 IOH.strPrevDoc AS bl,
 suppliers.strName AS supliers,
 IOH.strMerchandiser,
 forwaders.strName AS forwader,
 wharfclerks.strName AS wharfclerk,
 strLCNumber AS LC ,
 deliverynote.strContainerNo AS container,
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
WHERE IOH.intIOUNo='$invoiceNo'";
//die($sqlinvoiceheader);	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$dateInvoice"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 
	  
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>REIMBURSMENT OF ADVANCE</title>
<link href="../../eshipping/css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.adornment11 {border-color:#000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.fontColor10 {FONT-SIZE:9PT; ; FONT-FAMILY:Verdana; }
-->
</style>
<script src="../javascript/script.js"="text/javascript"></script> 
<script type="text/javascript">
var chid='';
function popupandshow(str)
{
	chid=str.id;
	
	drawPopupArea(462,92,'rptconfirm');	
	document.getElementById("rptconfirm").innerHTML =document.getElementById('divEditor').innerHTML;
	document.getElementById('divEditor').innerHTML='';
	document.getElementById('txtCurrent').value=str.childNodes[0].nodeValue	;
	
//alert(chid);
//setInvVal();
}

function setInvVal()
{
if(document.getElementById('txtNew').value=='')
document.getElementById('txtNew').value='-'
document.getElementById(chid).childNodes[0].nodeValue=document.getElementById('txtNew').value;
totalculater();
closeit();
}

function closeit()
{

document.getElementById('divEditor').innerHTML=document.getElementById("rptconfirm").innerHTML;
closeWindow();


}

function totalculater()
{
	var ss=parseFloat(document.getElementById('cell1').childNodes[0].nodeValue)
	+parseFloat(document.getElementById('cell2').childNodes[0].nodeValue)+parseFloat(document.getElementById('cell3').childNodes[0].nodeValue)+parseFloat(document.getElementById('cell4').childNodes[0].nodeValue);
	document.getElementById('subtot').childNodes[0].nodeValue=ss;
	var vat=ss*.12;
	document.getElementById('amtvat').childNodes[0].nodeValue=vat;
	
	document.getElementById('amttot').childNodes[0].childNodes[0].nodeValue=ss+vat;
}

</script>
</head>

<body onload="totalculater()" >
<table width="645" height="304" border="0"  id="tblPerent">
  <tr>
    <td height="59" colspan="2"><table width="638" border="0" class="normalfnt_size10">
      <tr>
        <td width="107" rowspan="3"><span class="adornment10" style="z-index:15; position:absolute; left:47px; top:14px; width:62px; height:50px; "><img src="../../eshipping/images/callogo.jpg" alt="as" width="62" height="50" /></span><span class="adornment10" style="z-index:15; position:absolute; left:58px; top:620px; width:62px; height:50px; "><img src="../../eshipping/images/callogo.jpg" alt="as" width="62" height="50" /></span></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="305">&nbsp;</td>
        <td width="208">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="2" colspan="2"><div  style="z-index:15; position:absolute; left:134px; top:54px; width:518px; height:10px; " class="normalfntSMB" >TEL.<?php echo $phone; ?> FAX.<span class="normalfnBLD1"><?php echo $Fax; ?></span> </div></td>
  </tr>
  <tr>
    <td width="390" height="64"><fieldset style="width:375px;  height:20; border-color:#000080 " class="roundedCorners" >
      <legend><span style="background-color:#ffffff" class="normalfnt"><strong>&nbsp;Customer:&nbsp;</strong></span></legend>
      <span class="fontColor10"></span>
      <table width="349" border="0" class="fontColor10">
        <tr>
          <td width="53" height="20" class="normalfnt">&nbsp;</td>
          <td class="normalfnt_size20"><div  style="z-index:15; position:absolute; left:218px; top:152px; width:230px; height:10px; " class="normalfnth2Bm" >REIMBURSMENT OF ADVANCE <span class="normalfnt"></span></div></td>
        </tr>
      </table>
      <div  style="z-index:15; position:absolute; left:437px; top:97px; width:190px; height:10px; " class="normalfntSMB" >
        <table width="200" border="0">
          <tr>
            <td width="55" class="normalfntSMB">Inv No</td>
            <td width="125"><span class="normalfnt_size10"><?php echo date("d/m/Y");?></span></td>
          </tr>
        </table>
      </div>
      <p class="bigfntnm1">&nbsp;</p>
    </fieldset></td>
    <td width="231"><fieldset style="width:205px;  height:20; border-color:#000080 " class="roundedCorners" >
      
      <span class="fontColor10"></span>
      <table width="190" border="0" class="fontColor10">
        <tr>
          <td width="53" height="28" class="normalfnt">&nbsp;</td>
          <td width="190" class="normalfnt_size20"><div  style="z-index:15; position:absolute; left:128px; top:657px; width:518px; height:10px; " class="normalfntSMB" >Email :<?php echo $Email;?> </div></td>
        </tr>
      </table>
      <div  style="z-index:15; position:absolute; left:437px; top:81px; width:190px; height:10px; " class="normalfntSMB" >
        <table width="200" border="0">
          <tr>
            <td width="55" class="normalfntSMB">Date</td>
            <td width="125"><span class="normalfnt_size10"><?php echo date("d/m/Y");?></span></td>
          </tr>
        </table>
      </div>
	  <div  style="z-index:15; position:absolute; left:457px; top:683px; width:190px; height:10px; " class="normalfntSMB" >
        <table width="200" border="0">
          <tr>
            <td width="28" class="normalfntSMB">Date</td>
            <td width="152"><span class="normalfnt_size10"><?php echo date("d/m/Y");?></span></td>
          </tr>
        </table>
      </div>
     <div  style="z-index:15; position:absolute; left:437px; top:113px; width:190px; height:10px; " class="normalfntSMB" >
        <table width="200" border="0">
          <tr>
            <td width="55" class="normalfntSMB">SE No</td>
            <td width="125"><span class="normalfnt_size10"><?php echo date("d/m/Y");?></span></td>
          </tr>
        </table>
      </div>
      <div  style="z-index:15; position:absolute; left:437px; top:128px; width:190px; height:10px; " class="normalfntSMB" >
        <table width="200" border="0">
          <tr>
            <td width="55" class="normalfntSMB">Im/Ex</td>
            <td width="125"><span class="normalfnt_size10">Import</span></td>
          </tr>
        </table>
      </div>
	  <div  style="z-index:15; position:absolute; left:21px; top:93px; width:378px; height:10px; " class="normalfntSMB" >
	    <table width="381" border="0">
          <tr>
            <td width="48" class="normalfntSMB">Name</td>
            <td width="320" class="normalfnt_size10">:<?php echo $dataholder['customer'];?></td>
          </tr>
        </table>
	  </div>
	  <div  style="z-index:15; position:absolute; left:14px; top:699px; width:378px; height:10px; " class="normalfntSMB" >
	    <table width="381" border="0">
          <tr>
            <td width="107" class="normalfntSMB">Name.</td>
            <td width="261" class="normalfnt_size10"><?php echo $dataholder['customer'];?></td>
          </tr>
        </table>
	  </div>
      <p class="bigfntnm1">&nbsp;</p>
    </fieldset></td>
  </tr>
  <tr>
    <td height="15" colspan="2"><table width="637" cellspacing="0" class="normalfnt_size10">
      <tr height="10px">
        <td colspan="5" >&nbsp;</td>
      </tr>
      <tr height="10px">
        <td width="151" >Vessel</td>
        <td width="161" class="border-bottom-fntsize10">&nbsp;</td>
        <td>&nbsp;</td>
        <td>No of Ctns</td>
        <td width="162" class="border-bottom-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td  id ="name"; onclick="popupandshow(this)">Custom Entry No</td>
        <td class="border-bottom-fntsize10">&nbsp;</td>
        <td width="30" class='mouseover'  >&nbsp;</td>
        <td width="119" class='mouseover' id="txtCustTitle" onclick="popupandshow(this)">P.O NO.</td>
        <td class="border-bottom-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td height="14">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td class="border-bottom-fntsize10">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="52" colspan="2">
	
	<table width="635" border="0" cellspacing="0" class="normalfnt_size10" >
      <tr height="13">
        <td width="25" class="border-top-left-fntsize10">&nbsp;</td>
        <td width="376" class="border-top-fntsize10"><strong>PERTICULARS</strong></td>
        <td width="102" class="border-top-left-fntsize10"t">&nbsp;</td>
        <td width="124" class="border-Left-Top-right-fntsize10"><div align="center"><strong>AMOUNT</strong></div></td>
      </tr>
		 <tr>
		   <td colspan="2" class="border-top-left-fntsize10">&nbsp;</td>
		   <td class="border-top-left-fntsize10"t">&nbsp;</td>
		   <td class="border-Left-Top-right-fntsize10">&nbsp;</td>
	    </tr>
		<?php
			//set proper font class		
		
		$sql="SELECT 
				(SELECT strDescription FROM expensestype WHERE 
				tblioudetails.intExpensesID=expensestype.intExpensesID)AS Expense, 
				dblEstimate, dblActual, 
				(dblActual-dblEstimate)AS short,
				dblInvoice
				FROM tblioudetails WHERE intIOUNo='$invoiceNo'AND intDoInvoice='1'";
		//die($sql);
			$result= $db -> RunQuery ($sql);
		$totEstimate=0;
		$intnum=1;
		while($row=mysql_fetch_array($result))
		{
		if($intnum<10)
			$lineno="<strong>0".$intnum.".</strong>";
			else
		$lineno="<strong>".$intnum.".</strong>";
		 echo"<tr> <td width='25' class='border-top-left-fntsize10'><div align='left' >".$lineno."</div></td>
		 <td width='376'  class='border-top-fntsize10' >".$row['Expense']."</td>";
		 echo"<td width='102' class='border-top-left-fntsize10't'>&nbsp;</td>";
		 $totEstimate+=$row['dblEstimate'];
		 $totActual+=$row['dblActual'];		 
		 $totShortage+=$row['short'];
		 $totinvoice+=$row['dblInvoice'];
		 
		 echo " <td width='124' class='border-Left-Top-right-fntsize10'><div align='right' >".$row['dblInvoice']."</div></td>";
		 
		 
		 //echo"<td td width='121' class='border-bottom-right' ><div align='right' >".$row['dblInvoice']."</div></td>";
		 //echo"</tr>";
		 $intnum++;
		}
		echo"<tr><td class='border-top-left-fntsize10'  colspan='3' style='text-align:right'><strong>Total Amount Payable</strong></td>
		<td class='border-Left-Top-right-fntsize10'><div align='right' ><strong>". $totinvoice. "</strong></div></td>"; 
		
		
		?>
		
		
		
		<tr>
		   <td height="18" colspan="2" class="border-top-bottom-fntsize10">(Tear off)</td>
		   <td class="border-top-bottom-fntsize10"t">&nbsp;</td>
		   <td class="border-top-bottom-fntsize10">&nbsp;</td>
	    </tr>
    </table>	</td>
  </tr>
  <tr>
    <td height="22" colspan="2"><table width="636" border="0" >
      <tr>
        <td width="99">&nbsp;</td>
        <td width="527">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="22" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="2" colspan="2"><div  style="z-index:15; position:absolute; left:128px; top:645px; width:518px; height:10px; " class="normalfntSMB" >TEL.<?php echo $phone; ?> FAX.<span class="normalfnBLD1"><?php echo $Fax; ?></span> </div></td>
  </tr>
</table>

<div style="left:91px; top:249px; z-index:10; position:absolute; width: 426px; visibility:hidden; height: 103px;" id="divEditor">
<table width="426" height="89" border="0" cellpadding="0" cellspacing="0" class="normalfnt" bgcolor="#ffffff">
<tr>
<td colspan="7">
    <tr bgcolor="#ccff33" class="normalfntMid" height="15"><td  colspan="7" >
	<div align="left">&nbsp;<strong>Edit Invoice </strong></div></td>
    </tr>
		<tr height="10"><td colspan="7">&nbsp;</td>		
		<tr class="normalfnt">		
	    <td width="50" height="26" align="left">&nbsp;Current</td>
	    <td width="159"><input name="txtTaxCode" type="text" class="txtbox" id="txtCurrent" style="text-align:right;" size="25" maxlength="50" readonly="readonly" /></td>
	     <td colspan="3">&nbsp;New</td>
	     <td colspan="2"><div align="center">
	       <input name="txtNew" type="text" class="txtbox" id="txtNew" style="text-align:right;" size="25" maxlength="50";" onclick="DisableRightClickEvent()"/>
          </div></td>
		</tr>
	<tr  >
	 	
	    <td height="13" colspan="7"  align="left">&nbsp;</td>
      <!--<td ><input name="txtBase" type="text" class="txtbox" id="txtBase" style="text-align:right;" size="15" maxlength="15"  /></td>-->
	
	 <!-- <td colspan="2">Recived From wharf Cleark </td>-->
	  
	    <!--<td width="108"><input name="txtDeliveryNo3" type="text" class="txtbox" id="txtDeliveryNo3" " size="15" maxlength="15" disabled="disabled" />--><td width="4"></td>
	</tr>	
	<tr class="normalfnt">     
	  
	
	 
	 <td align="center" >&nbsp;</td>
	 <td align="right" ><table class="mouseover" onclick="setInvVal()">
	   <tr>
	     <td width="16"  ><img src="../images/eok.png" alt="Ok" name="btnOk" width="16" height="16"  id="butCancel" /></td>
	     <td width="20">&nbsp;Ok</td>
	     </tr>
	   </table>	 </td>
	 <td colspan="3"align="right" >&nbsp;</td>
     <td width="71" colspan="-1" align="center" ><table class="mouseover" onclick ="closeit()">
       <tr>
         <td width="16"   ><img src="../images/eclose.png" alt="Cancel" name="butCancel" width="16" height="16"  id="butCancel" /></td>
         <td width="43">&nbsp;Cancel</td>
       </tr>
     </table>     </td>
	 <td width="122" align="center" >&nbsp;</td>
	</tr>
<tr><td colspan="7"></td>
<tr><td colspan="7"></tr>
</table>
</div>
<p>&nbsp;</p>
<div  style="z-index:15; position:absolute; left:133px; top:9px; width:518px; height:15px; " class="adornment10" ><span class="tophead"><?php echo $Company; ?>.</span></div>
<div  style="z-index:15; position:absolute; left:133px; top:40px; width:518px; height:10px; " class="adornment10" ><span class="normalfntSMB"><?php echo $Address." ".$City.", ".$Country.".";?></span></div>
<div  style="z-index:15; position:absolute; left:212px; top:677px; width:230px; height:10px; " class="normalfnth2Bm" >TAX INVOICE <span class="normalfnt"></span></div>
<div  style="z-index:15; position:absolute; left:14px; top:686px; width:230px; height:10px; " class="normalfntSMB" >
  <table width="231" border="0">
    <tr>
      <td width="105">Vat Reg.No. </td>
      <td width="116"><?php echo $dataholder['vatno'];?></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:441px; top:895px; width:244px; height:14px; " class="normalfntSMB" >
  <table width="244" border="0">
    <tr>
      <td width="238"><?php echo $Company; ?>.</span></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:478px; top:960px; width:143px; height:14px; " class="normalfntSMB" >
  <table width="140" border="0">
    <tr>
      <td width="134" class="border-top-fntsize10">Authorized Signature </td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:25px; top:912px; width:186px; height:10px; " class="normalfntSMB" >
  <table width="190" border="0">
    <tr>
      <td width="69">Balance</td>
      <td width="14">=</td>
      <td width="93">&nbsp;</td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:458px; top:698px; width:186px; height:10px; " class="normalfntSMB" >
  <table width="190" border="0">
    <tr>
      <td width="72">Invoice No </td>
      <td width="118">&nbsp;</td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:25px; top:889px; width:186px; height:10px; " class="normalfntSMB" >
  <table width="190" border="0">
    <tr>
      <td width="69">Bill Amount</td>
      <td width="13">=</td>
      <td width="94">&nbsp;</td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:128px; top:623px; width:518px; height:10px; " class="normalfntSMB" ><span class="normalfntSMB"><?php echo $Company; ?>.</span></div>
<div  style="z-index:15; position:absolute; left:128px; top:634px; width:518px; height:10px; " class="adornment10" ><span class="normalfntSMB"><?php echo $Address." ".$City.", ".$Country.".";?></span></div>
<div  style="z-index:15; position:absolute; left:10px; top:771px; width:645px; height:10px; " class="normalfntSMB" >
  <table width="643" border="0" cellspacing="0">
    <tr>
      <td width="536" class="border-Left-Top-right-fntsize10">01. Handling Charges </td>
      <td width="103" class="border-top-right mouseover" ><div align="right" id="cell1"   onclick="popupandshow(this)">100</div></td>
    </tr>
    <tr>
      <td class="border-Left-Top-right-fntsize10" >02. Documentation Charges </td>
      <td class="border-top-right"><div align="right" id="cell2" class='mouseover'  onclick="popupandshow(this)">200</div></td>
    </tr>
    <tr>
      <td class="border-Left-Top-right-fntsize10">03. Agency Fees </td>
      <td class="border-top-right"><div align="right" id="cell3" class='mouseover'  onclick="popupandshow(this)">300</div></td>
    </tr>
    <tr >
      <td class="border-Left-Top-right-fntsize10">04. Other </td>
      <td class="border-top-right"><div align="right" id="cell4" class='mouseover'  onclick="popupandshow(this)" >400</div></td>
    </tr>
    <tr>
      <td class="border-Left-Top-right-fntsize10"><div align="right">Sub Total </div></td>
      <td class="border-top-right"><div align="right"  id="subtot">1</div></td>
    </tr>
    <tr>
      <td class="border-left-right-fntsize10" ><div align="right" ><span>Vat 12% </span></div></td>
      <td class="border-top-right-fntsize10"><div align="right" id='amtvat'>100</div></td>
    </tr>
    <tr>
      <td  class="border-Left-bottom-right-fntsize10"><div align="right"><strong>Total</strong></div></td>
      <td class="border-top-bottom-right-fntsize10 " ><div align="right" id="amttot"><strong>100</strong></div></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:21px; top:111px; width:380px; height:11px; " class="normalfntSMB" >
  <table width="380" border="0" >
    <tr>
      <td width="48" class="normalfntSMB">Address</td>
      <td width="322"><span class="normalfnt_size10">:<?php echo $dataholder['strAddress1'];?></span></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:15px; top:744px; width:380px; height:11px; " class="normalfntSMB" >
  <table width="380" border="0" >
    <tr>
      <td width="103" class="normalfntSMB">Customer Vat No.</td>
      <td width="267"><span class="normalfnt_size10"><?php echo $dataholder['vatno'];?></span></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:13px; top:731px; width:380px; height:11px; " class="normalfntSMB" >
  <table width="380" border="0" >
    <tr>
      <td width="105" class="normalfntSMB">&nbsp;</td>
      <td width="265"><span class="normalfnt_size10"><?php echo $dataholder['strAddress2'];?></span></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:13px; top:714px; width:380px; height:11px; " class="normalfntSMB" >
  <table width="380" border="0" >
    <tr>
      <td width="104" class="normalfntSMB">Address.</td>
      <td width="266"><span class="normalfnt_size10"><?php echo $dataholder['strAddress1'];?></span></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:26px; top:129px; width:380px; height:11px; " class="normalfntSMB" >
  <table width="380" border="0" >
    <tr>
      <td width="48" class="normalfntSMB">&nbsp;</td>
      <td width="322"><span class="normalfnt_size10"><?php echo $dataholder['strAddress2'];?></span></td>
    </tr>
  </table>
</div>
<div  style="z-index:15; position:absolute; left:134px; top:67px; width:518px; height:10px; " class="normalfntSMB" >Email :<?php echo $Email;?> </div>
</body>
</html>
