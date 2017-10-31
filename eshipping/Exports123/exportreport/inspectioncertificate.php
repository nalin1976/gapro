<?php
$backwardseperator = "../../";
session_start();
include "../../Connector.php" ;
$backwardseperator 	= "../../";	

$titleid			= $_GET["titleid"];

$str_h="select 	strTitleid, 
	strTitle,
	date_format(strDate,'%b %d,%Y')as  strDate 
		 
	from 
	exportreport_header 
	where strTitleid='$titleid'";
$result_h=$db->RunQuery($str_h);
$row_h=mysql_fetch_array($result_h);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inspection Certificate</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="43">&nbsp;</td>
    <td width="807"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size12" style="font-size:14px;line-height:18px;">
      <tr>
        <td>&nbsp;</td>
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
      </tr>
      <tr>
        <td colspan="5" style="font-size:25px;line-height:30px;font-weight:bold;text-align:center">Jones Apparel Group Inspection Certificate</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
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
      </tr>
      <tr>
        <td>Date:</td>
        <td><?php echo $row_h['strDate']?></td>
        <td>&nbsp;</td>
        <td colspan="2"><table width="80%" border="1" cellspacing="0" cellpadding="0" class="normalfnt_size12">
          <tr>
            <td width="25%" bgcolor="#CCCCCC" height="25">I/C No.:</td>
            <td width="75%">&nbsp;<?php echo $row_h['strTitle']?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Issuing Party Name:</td>
        <td colspan="2">Orit Holdings Limited</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">07-02, East Tower, World trade Centre,</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Echelon Square,</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Colombo 1,</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Sri Lanka</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Vendor/Factory:</td>
        <td colspan="4">ORIT TRADING LANKA (PVT) LTD</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">This is to certify that invoiced merchandise conforms to the approved production samples and all terms and conditions of the relative purchase order of Jones Apparel Group.  The merchandise shipped meets the quality specification on the order based on a random acceptable quality level (AQL) inspection that has been conducted.  This Certificate does not exonerate the manufacturer from any responsibility in case the shipment is found to be in default or the merchandise is damaged at the final destination.</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">
        
        Commercial Invoice #:
        <?php $str_d="select 	
				strTitleid, 
				strInvoiceNo	 
				from 
				exportreport_detail 
				where strTitleid='$titleid'";
				$result_d=$db->RunQuery($str_d);
				while($row_d=mysql_fetch_array($result_d)){
					if($f==1)
						echo ", ".$row_d["strInvoiceNo"];
					else
					{
						echo $row_d["strInvoiceNo"];
					}
					$f=1;
				}
					?>
        </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt-center_size12">&nbsp;</td>
        <td class="normalfnt-center_size12">&nbsp;</td>
        <td class="normalfnt-center_size12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt-center_size12">Purchase Order #</td>
        <td class="normalfnt-center_size12">Material #</td>
        <td class="normalfnt-center_size12">Quantity </td>
        <td>&nbsp;</td>
      </tr>
    <?php $sql="select distinct
	ED.strTitleid,
	ED.strInvoiceNo,	
	CIH.strInvoiceNo, 
	CS.strName, 
	FI.strBrand,
	CID.strDescOfGoods,
	CIH.strFinalDest, 
	CID.strStyleID,
	CID.strBuyerPONo,
	CID.strISDno,
	CID.dblQuantity,
	CIH.strIncoterms	 
	from 
	commercial_invoice_header CIH
	left join customers CS ON CIH.strCompanyID=CS.strCustomerID
	left join finalinvoice FI ON CIH.strInvoiceNo=FI.strInvoiceNo
	left join commercial_invoice_detail CID ON CIH.strInvoiceNo=CID.strInvoiceNo
	left join city C ON CIH.strFinalDest=C.strCityCode
	left join exportreport_detail ED ON ED.strInvoiceNo=CIH.strInvoiceNo
	where ED.strTitleid='$titleid'
	order by CIH.strInvoiceNo, CID.strBuyerPONo ;";
		
		$result = $db->RunQuery($sql);
		$i++;
		
		$previd=123;
		
		
		while (($row=mysql_fetch_array($result))||$count<10)
		{ $count++;?>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt-center_size12"><?php echo $row['strBuyerPONo']?></td>
        <td class="normalfnt-center_size12"><?php echo $row['strStyleID']?></td>
        <td class="normalfnt-center_size12"><?php echo $row['dblQuantity']?></td>
        <td>&nbsp;</td>
      </tr><?php }?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">This document is issued without prejudice and in no way releases the vendor or manufacturer from their responsibility with regard to the documentation and this merchandise.</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-top"><strong>Authorized Signature </strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width='20%'>&nbsp;</td>
        <td width='20%'>&nbsp;</td>
        <td width='20%'>&nbsp;</td>
        <td width='20%'>&nbsp;</td>
        <td width='20%'>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>