<?php 
session_start();
include "../../../../Connector.php";
include '../buyerwiseinvoices/common_report.php';
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$Com_TinNo=$xmldoc->companySettings->TinNo;
$bisRegNo=$xmldoc->companySettings->bisreg;
$invoiceNo=$_GET['InvoiceNo'];
//$invoiceNo='422/OTL/GV/03/11';
include("../buyerwiseinvoices/invoice_queries.php");	
$proforma=$_GET['proforma'];

$sql="select FW.intForwaderID,FW.strName,FW.strAddress1 as FWstrAddress1,FW.strAddress2 as FWstrAddress2,FW.strCountry as FWstrCountry,FW.strPhone as FWstrPhone,FW.strFax as FWstrFax
from forwaders FW
inner join commercial_invoice_header CID ON CID.strForwader=FW.intForwaderID
where CID.strInvoiceNo='$invoiceNo';";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ForDetails .= ($row["FWstrAddress1"]=="" ? "":$row["FWstrAddress1"]."<br/>");
	$ForDetails .= ($row["FWstrAddress2"]=="" ? "":$row["FWstrAddress2"]."<br/>");
	$ForDetails .= ($row["FWstrCountry"]=="" ? "":$row["FWstrCountry"]."<br/>");
	$ForDetails .= ($row["FWstrPhone"]=="" ? "":"Tel :".$row["FWstrPhone"]."<br/>");
	$ForDetails .= ($row["FWstrFax"]=="" ? "":"Fax :".$row["FWstrFax"]."<br/>");
}
	$buyerDetails = $dataholder["BuyerAName"]."<br/>";
	$buyerDetails .= ($dataholder["buyerAddress1"]=="" ? "":$dataholder["buyerAddress1"]."<br/>");
	$buyerDetails .= ($dataholder["buyerAddress2"]=="" ? "":$dataholder["buyerAddress2"]."<br/>");
	$buyerDetails .= ($dataholder["BuyerCountry"]=="" ? "":$dataholder["BuyerCountry"]."<br/>");
	
	$notifyDetails  = $dataholder["notify2Name"]."<br/>";
	$notifyDetails .= ($dataholder["notify2Address1"]=="" ? "":$dataholder["notify2Address1"]."<br/>");
	$notifyDetails .= ($dataholder["notify2Address2"]=="" ? "":$dataholder["notify2Address2"]."<br/>");
	$notifyDetails .= ($dataholder["notify2Country"]=="" ? "":$dataholder["notify2Country"]."<br/>");
	$notifyDetails .= ($dataholder["notify2phone"]=="" ? "":"TEL :".$dataholder["notify2phone"]."<br/>");
	$notifyDetails .= ($dataholder["notify2Fax"]=="" ? "":"FAX :".$dataholder["notify2Fax"]."<br/>");
	
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>COMMERCIAL INVOICE</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
		.invoicefnt {
		color:#000000;
		font-family:Verdana;
		font-size:10px;
		font-weight:100;
		margin:0;
		text-align:left;
}
.invoicefntbold {
		color:#000000;
		font-family:Verdana;
		font-size:10px;
		font-weight:bold;
		margin:0;
		text-align:left;
}



</style>
</head>

<body>
<table width="985" border="0" cellspacing="0" cellpadding="1" class="normalfnt_size10">
 <tr>
   <td>&nbsp;</td>
 </tr>
 
 <tr>
   <td height="19"><table width="100%" height="120" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="24%" height="120"><img src="../../../../images/toll_logo.png" alt="New" width=205 height=82 name="New"onclick="ClearForm();"/></td>
       <td width="45%" style="font-size:22pt;color:#FF9900;font-weight:700;font-style:italic;font-family:Verdana, sans-serif;" valign="top">TOLL GLOBAL forwarding</td>
       <td width="31%" style="font-size:10.0pt;font-weight:600;font-family:Verdana, sans-serif;" valign="top"><?php echo $ForDetails;?></td>
     </tr>
     
     
   </table></td>
 </tr>
 <tr>
   <td ><div  style="z-index:25; position:absolute; left:409px; top:106px; width:114px; height:24px;"  >
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="87%"><table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="308" nowrap="nowrap" style="text-align:center" class="head2BLCK"><u>B/L INSTRUCTION</u></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
 </tr>
 <tr>
   <td height="19">&nbsp;</td>
 </tr>
 <tr>
   <td><table width="100%" height="55" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="18%"><table width="101%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
         <tr>
           <td class="normalfnth2B" style="text-align:left">Attn:</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
       <td width="4%">&nbsp;</td>
       <td width="19%"><table width="102%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
         <tr>
           <td class="normalfnth2B" style="text-align:center"><span class="normalfnth2B" style="text-align:center">Vessel / Voyage:</span></td>
         </tr>
         <tr>
           <td style="text-align:center" class="normalfnt_size10"><?php echo $dataholder["strCarrier"]."/".$dataholder["strVoyegeNo"] ?></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
       <td width="8%">&nbsp;</td>
       <td width="21%"><table width="100%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
         <tr>
           <td class="normalfnth2B" style="text-align:center">Final Destination:</td>
         </tr>
         <tr>
           <td style="text-align:center" class="normalfnt_size10"><?php echo $dataholder['city'];?></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
       <td width="6%">&nbsp;</td>
       <td width="24%"><table width="100%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
         <tr>
           <td width="67%" class="normalfnth2B" style="text-align:center"><span class="xl76" style="mso-ignore:colspan">Other Reference:</span></td>
           <td width="33%" class="normalfnth2B" style="text-align:center">&nbsp;</td>
         </tr>
         <tr>
           <td colspan="2">&nbsp;</td>
         </tr>
         <tr>
           <td colspan="2">&nbsp;</td>
         </tr>
       </table></td>
       </tr>
     
     
     
   </table></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 
 <tr>
   <td><table width="100%" height="55" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="18%"><table width="101%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:left">Booking Date&nbsp;:</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
       </table></td>
       <td width="4%">&nbsp;</td>
       <td width="19%"><table width="102%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:center">Country of Origin :</td>
           </tr>
           <tr>
             <td style="text-align:center" class="normalfnt_size10">SRI LANKA</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
       </table></td>
       <td width="8%">&nbsp;</td>
       <td width="21%"><table width="100%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:left">Booking No:</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
       </table></td>
       <td width="6%">&nbsp;</td>
       <td width="24%"><table width="100%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td width="67%" class="normalfnth2B" style="text-align:left">Gross Weight:</td>
             <td width="33%" class="normalfnth2B" style="text-align:center">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="2" style="text-align:center;color:#FF0000" class="normalfnt_size10" ><b><?php echo number_format($dataholder['gross'],2);?></b></td>
           </tr>
           <tr>
             <td colspan="2">&nbsp;</td>
           </tr>
       </table></td>
     </tr>
   </table></td>
 </tr>
 
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td><table width="100%" height="55" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="18%"><table width="101%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:left">Commodity :</td>
           </tr>
           <tr>
             <td style="text-align:center" class="normalfnt_size10">GARMENTS</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
       </table></td>
       <td width="4%">&nbsp;</td>
       <td width="19%"><table width="102%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:center">Port of Loading:</td>
           </tr>
           <tr>
             <td style="text-align:center" class="normalfnt_size10"><?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
       </table></td>
       <td width="8%">&nbsp;</td>
       <td width="21%"><table width="100%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:left">Freight Terms :</td>
           </tr>
           <tr>
             <td style="text-align:center;color:#FF0000" class="normalfnt_size10"><b><?php echo $com_inv_dataholder["strFreightPC"]; ?></b></td>
           </tr>
		   <?php
		   $sql_tot="select strInvoiceNo,sum(dblCBM) as totCBM,sum(intNoOfCTns) as totNoOfCTns
						from commercial_invoice_detail
						where strInvoiceNo='$invoiceNo'
						group by strInvoiceNo;";
			$result_tot=$db->RunQuery($sql_tot);
			while($row_tot=mysql_fetch_array($result_tot))
			{
				$totCBM = $row_tot["totCBM"];
				$totNoOfCTns = $row_tot["totNoOfCTns"];
			}
		   ?>
           <tr>
             <td>&nbsp;</td>
           </tr>
       </table></td>
       <td width="6%">&nbsp;</td>
       <td width="24%"><table width="100%" height="59" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td width="67%" class="normalfnth2B" style="text-align:left">Volume / CBM :</td>
             <td width="33%" class="normalfnth2B" style="text-align:center">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="2" style="text-align:center;color:#FF0000" class="normalfnt_size10"><?php echo $totCBM; ?></td>
           </tr>
           <tr>
             <td colspan="2">&nbsp;</td>
           </tr>
       </table></td>
     </tr>
   </table></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 
 <tr>
   <td><table width="100%" height="92" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="18%" height="92"><table width="101%" height="90" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr >
             <td height="20" class="normalfnth2B" style="text-align:left">Cargo ready date :</td>
           </tr>
           <tr >
             <td height="70">&nbsp;</td>
           </tr>
           
           
       </table></td>
       <td width="4%">&nbsp;</td>
       <td width="19%"><table width="102%" height="90" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:center" height="20">Port of Discharge :</td>
           </tr>
           <tr>
             <td height="25" style="text-align:center;color:#FF0000" class="normalfnt_size10"><b><?php echo $dataholder['port'];?></b></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           
       </table></td>
       <td width="8%">&nbsp;</td>
       <td width="21%"><table width="100%" height="96" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td class="normalfnth2B" style="text-align:left" height="20">Total No, of Ctns</td>
           </tr>
           <tr>
             <td height="25" style="text-align:center" class="normalfnt_size10"><?php echo $totNoOfCTns; ?></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           
       </table></td>
       <td width="6%">&nbsp;</td>
       <td width="24%"><table width="100%" height="93" border="0" cellpadding="0" cellspacing="0" class="border-All">
           <tr>
             <td width="40%" class="normalfnth2B" style="text-align:left">Dimensions:</td>
 			 <td width="16%" class="normalfnth2B"  style="text-align:left">INC</td>
  			<td width="44%" class="normalfnth2B"  style="text-align:left">CTN</td>
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
   </table></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="border-All">
     <tr>
       <td height="20" width="30%" style="text-align:center" class="border-right-fntsize12"><strong>Shipper</strong></td>
       <td width="40%" style="text-align:center" class="border-right-fntsize12" ><strong>Consignee</strong></td>
       <td style="text-align:center;font-size:12px"><strong>Notify Party</strong></td>
     </tr>
     <tr>
       <td class="border-top-right-fntsize12">&nbsp;</td>
       <td class="border-top-right-fntsize12">&nbsp;</td>
       <td class="border-top-fntsize12">&nbsp;</td>
     </tr>
     <tr>
       <td class="border-right-fntsize10" valign="top"><?php echo $Company; ?><br /><?php echo $Address;  ?><br /><?php echo $City; ?></td>
       <td class="border-right-fntsize10" valign="top"><?php echo $buyerDetails; ?></td>
       <td class="normalfnt_size10" valign="top"><?php echo $notifyDetails;?></td>
     </tr>
     <tr>
       <td class="border-right-fntsize10">&nbsp;</td>
       <td class="border-right-fntsize10">&nbsp;</td>
       <td class="normalfnt_size10">&nbsp;</td>
     </tr>
     
   </table></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td height="15">&nbsp;</td>
 </tr>
 <tr>
   <td width="25%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="border-All">
     <tr>
       <td height="28" class="border-right-fntsize12" width="18%"><strong>Marks &amp; Numbers</strong></td>
       <td width="59%" rowspan="5" valign="top"><table width="101%" height="149" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td height="29" colspan="2" class="border-right-fntsize12" style="text-align:center"><b>No of Pieces (CTNS)</b></td>
           <td colspan="4" style="text-align:center"><b>Description of Goods</b></td>
           </tr>
         <tr>
           <td width="17%" height="28" class="border-top-right-fntsize12" style="text-align:center"><b>Ctns</b></td>
             <td width="13%" class="border-top-right-fntsize12" style="text-align:center"><b>Qty</b></td>
             <td width="16%" class="border-top-right-fntsize12" style="text-align:center"><b>PCS</b></td>
             <td width="18%" class="border-top-right-fntsize12" style="text-align:center"><b>PO #</b></td>
             <td width="18%" class="border-top-right-fntsize12" style="text-align:center"><b>Style #</b></td>
             <td width="18%" class="border-top-right-fntsize12" style="text-align:center"><b>Sap Material<br />
               Number</b></td>
           </tr>
         <tr>
           <td class="border-top-right-fntsize10">&nbsp;</td>
             <td class="border-top-right-fntsize10" style="text-align:center">DZN</td>
             <td class="border-top-right-fntsize10">&nbsp;</td>
             <td class="border-top-right-fntsize10">&nbsp;</td>
             <td class="border-top-right-fntsize10">&nbsp;</td>
             <td class="border-top-right-fntsize10">&nbsp;</td>
           </tr>
         <?php
		 $SQL="select
					CID.strInvoiceNo,
					CID.strDescOfGoods,
					CID.strBuyerPONo,
					CID.strStyleID,
					CID.dblQuantity,
					CID.intNoOfCTns,
					CID.strISDno,
					CID.strHSCode,
					CID.strSD,
					shipmentplheader.strMaterial
					from
					commercial_invoice_detail CID
					inner join shipmentplheader on shipmentplheader.strPLNo=CID.strPLno
					where CID.strInvoiceNo='$invoiceNo';";
			
		$result=$db->RunQuery($SQL);
		while(($row_det=mysql_fetch_array($result))||($count<5))	
		{
			$QtyDZN = ($row_det["dblQuantity"]/12);	
			$totCtns+= $row_det["intNoOfCTns"];	
			$totQty+= $QtyDZN;	
			$totPcs+= $row_det["dblQuantity"];	
			$count++;
		 ?>
         <tr>
           <td class="border-right-fntsize10" style="text-align:right"><?php echo $row_det["intNoOfCTns"]; ?></td>
             <td class="border-right-fntsize10" style="text-align:center"><?php echo ($QtyDZN!=0?number_format($QtyDZN,2):"");?></td>
             <td class="border-right-fntsize10" style="text-align:center"><?php echo $row_det["dblQuantity"]; ?></td>
             <td class="border-right-fntsize10" style="text-align:center"><?php echo $row_det["strBuyerPONo"]; ?></td>
             <td class="border-right-fntsize10" style="text-align:center">&nbsp;<?php echo $row_det["strStyleID"]; ?></td>
             <td class="border-right-fntsize10" style="text-align:center"><?php echo $row_det["strMaterial"]; ?></td>
           </tr>
         <?php
		  }
		   ?>
         <tr>
           <td class="border-right-fntsize10">&nbsp;</td>
             <td class="border-right-fntsize10">&nbsp;</td>
             <td class="border-right-fntsize10">&nbsp;</td>
             <td class="border-right-fntsize10">&nbsp;</td>
             <td class="border-right-fntsize10">&nbsp;</td>
             <td class="border-right-fntsize10">&nbsp;</td>
           </tr>
         <tr>
           <td height="24" class="border-right-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><?php echo$totCtns;?></td>
             <td class="border-right-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:center" ><?php echo number_format($totQty,2);?></td>
             <td class="border-right-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:center"><?php echo number_format($totPcs,2);?></td>
             <td class="border-right-fntsize10">&nbsp;</td>
             <td class="border-right-fntsize10">&nbsp;</td>
             <td class="border-right-fntsize10">&nbsp;</td>
           </tr>
       </table></td>
       <td height="28">&nbsp;</td>
     </tr>
     <tr>
       <td rowspan="3" valign="top" class="border-top-right-fntsize12" width="18%"></td>
       <td width="23%" valign="top" class="border-right-fntsize12"></td>
     </tr>
     <tr>
       <td valign="top" class="border-right-fntsize12"></td>
     </tr>
     <tr>
       <td valign="top" width="23%" ></td>
 </tr>
 <tr>
   <td class="border-right-fntsize10"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt" style="font-size:95%">
         <tr>
           <td width="50%"><?php  echo $mainmark1;?></td>
         </tr>
         <tr>
           <td><?php  echo $mainmark2;?></td>
         </tr>
         <tr>
           <td><?php  echo $mainmark3;?></td>
         </tr>
         <tr>
           <td><?php  echo $mainmark4;?></td>
         </tr>
         <tr>
           <td><?php  echo $mainmark5;?></td>
         </tr>
         <tr>
           <td><?php  echo $mainmark6;?></td>
         </tr>
         <tr>
           <td><?php  echo $mainmark7;?></td>
         </tr>
         <tr>
           <td><?php  echo $sidemark1;?></td>
         </tr>
         <tr>
           <td><?php  echo $sidemark2;?></td>
         </tr>
         <tr>
           <td><?php  echo $sidemark3;?></td>
         </tr>
         <tr>
           <td><?php  echo $sidemark4;?></td>
         </tr>
         <tr>
           <td><?php  echo $sidemark5;?></td>
         </tr>
         <tr>
           <td><?php  echo $sidemark6;?></td>
         </tr>
         <tr>
           <td><?php  echo $sidemark7;?></td>
         </tr>
       </table></td>
   <td valign="top"><table width="100%" height="118" border="0" cellpadding="0" cellspacing="0">
         <tr>
		 <td height="29" class="border-top"><b>DESCRIPTION</b></td>
		 </tr>
		 <tr>
           <td valign="top" class="border-top-fntsize10"><?php echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?><br /><br />
             HS CODE :<?php echo $r_summary->summary_string($invoiceNo,'strHSCode');?><br /><br /><br /></td>
         </tr>
         <?php
			  $sql_FI="select strInvoiceNo,strContainer,strSealNo
						from finalinvoice
						where strInvoiceNo='$invoiceNo'
						group by strInvoiceNo;";
				$result_FI=$db->RunQuery($sql_FI);
				while($row_FI=mysql_fetch_array($result_FI))	
				{
			  ?>
         <tr>
           <td class="normalfnt_size10">CONTAINER # :<?php echo $row_FI["strContainer"] ; ?><br />
             SEAL # :<?php echo $row_FI["strSealNo"] ;  ?></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td style="color:#FF0000"><b>FREIGHT :<?php echo $com_inv_dataholder["strFreightPC"]; ?></b></td>
         </tr>
         <?php
				}
					 ?>
       </table></td>
     </tr>
   </table></td>
   </tr>
 
</table>
</body>
</html>
