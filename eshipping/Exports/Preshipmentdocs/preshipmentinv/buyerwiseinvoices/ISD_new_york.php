<?php 
session_start();
include "../../../../Connector.php";

$invoiceNo=$_GET['InvoiceNo'];	
$str_header		="select 
date(dtmSailingDate) as dtmSailingDate,
strContainer,
strVoyegeNo,
strCarrier,
strSealNo,
city.strtoLocation AS city,
strBL, 
strHAWB, 
useraccounts.Name as UserName,
strMAWB
from 
commercial_invoice_header
left join finalinvoice on commercial_invoice_header.strInvoiceNo=finalinvoice.strInvoiceNo
LEFT JOIN useraccounts ON commercial_invoice_header.intUserId =useraccounts.intUserID
LEFT JOIN city ON commercial_invoice_header.strFinalDest =city.strCityCode
where  commercial_invoice_header.strInvoiceNo='$invoiceNo'";
$result_header	=$db->RunQuery($str_header);
$data_header	=mysql_fetch_array($result_header);
$sail_date_array=explode("-",$data_header["dtmSailingDate"]);	

$str_summary	="select
sum(dblNetMass) as dblNetMass,
sum(dblGrossMass) as dblGrossMass,
strISDno
from 
commercial_invoice_detail
where strInvoiceNo='$invoiceNo'";
$result_summary	=$db->RunQuery($str_summary);
$summary_data	=mysql_fetch_array($result_summary);
 
		
$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
$result = $db->RunQuery($SQL);

while($row = mysql_fetch_array($result))
{
	$session_user= $row["Name"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INVENTORY SHIPMENT DOCUMENT</title>
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
		font-size:9px;
		text-align:center;
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
		text-align:center;
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
		text-align:center;
		font-weight:700;
		line-height:16px;
}
.fnt16-bold{
		font-family:Arial;
		font-size:18px;
		text-align:center;
		font-weight:700;
		line-height:18px;
}
.fnt30-bold{
		font-family:Arial;
		font-size:34px;
		text-align:center;
		font-weight:700;
}

</style>
<?php 
$orientation="jsPrintSetup.kLandscapeOrientation";
//$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="bottom" align="right"><img src="isd.png" /></td>
    <td ><table cellspacing="0" cellpadding="0" border="0" >
      <col width="26" />
      <col width="16" />
      <col width="38" />
      <col width="57" />
      <col width="152" />
      <col width="46" />
      <col width="17" />
      <col width="19" />
      <col width="50" />
      <col width="56" />
      <col width="24" />
      <col width="82" />
      <col width="18" />
      <col width="28" />
      <col width="24" />
      <col width="39" />
      <col width="26" />
      <col width="30" />
      <col width="22" />
      <col width="48" />
      <col width="45" />
      <col width="36" />
      <col width="49" />
      <col width="126" />
      <col width="137" />
      <tr >
        <td colspan="12" class="fnt12-bold-head" style="text-align:right">LEVI STRAUSS&amp;CO.</td>
        <td width="28">&nbsp;</td>
        <td width="28">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="39">&nbsp;</td>
        <td width="15">&nbsp;</td>
        <td width="23">&nbsp;</td>
        <td width="6">&nbsp;</td>
        <td width="45">&nbsp;</td>
        <td width="34">&nbsp;</td>
        <td width="68">&nbsp;</td>
        <td colspan="3" class="fnt9 border-Left-Top-right-fntsize9">DOCUMENT NO.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="51">&nbsp;</td>
        <td width="64">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="14" class="fnt14-bold">                INVENTORY SHIPMENT DOCUMENT</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="fnt30-bold border-All-fntsize9"><?php echo $summary_data['strISDno'];?></td>
      </tr>
      <tr>
        <td colspan="6" class="fnt9 border-Left-Top-right-fntsize9">USE ONLY IF 3-WAY SHIPMENT</td>
        <td width="23">&nbsp;</td>
        <td width="23">&nbsp;</td>
        <td width="61">&nbsp;</td>
        <td colspan="11" class="fnt16-bold">(WIP and Finished Goods)</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="8">&nbsp;</td>
        <td width="46">&nbsp;</td>
        <td width="44">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" height="20" class="fnt7 border-top-bottom-left-fntsize9" style="border-top-width:2px;">FROM LOCATION(Name):    </td>
        <td colspan="2" class="fnt7 border-top-bottom-right-fntsize9" style="border-top-width:2px;">SYMBOL</td>
        <td colspan="4" class="fnt7 border-top-bottom-fntsize9" style="border-top-width:2px;">FROM LOCATION(Name):</td>
        <td colspan="2" class="fnt7 border-top-bottom-right-fntsize9" style="border-top-width:2px;">SYMBOL</td>
        <td colspan="4" class="fnt7 border-top-bottom-fntsize9" style="border-top-width:2px;">TO LOCATION(Name):</td>
        <td colspan="3" class="fnt7 border-top-bottom-right-fntsize9" style="border-top-width:2px;">SYMBOL</td>
        <td colspan="3" class="fnt7 border-top-bottom-right-fntsize9" style="border-top-width:2px;">PREPARED BY:      DEPARTMENT</td>
        <td colspan="3" class="fnt7 border-top-bottom-right-fntsize9" style="border-top-width:2px;">AUTHORIZED BY:</td>
      </tr>
      <tr>
        <td colspan="4"  class="border-left-fntsize9 fnt4">&nbsp;</td>
        <td colspan="2" class="fnt4 border-right-fntsize9">&nbsp;</td>
        <td colspan="6" class="fnt4 border-right-fntsize9">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4 border-right-fntsize9">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4 border-right-fntsize9">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="fnt4">&nbsp;</td>
        <td class="border-right-fntsize9 fnt4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="fnt12-bold border-Left-bottom-right-fntsize9" >SEETHAWAKA</td>
        <td colspan="2" class="border-bottom-right-fntsize9 ">&nbsp;</td>
        <td colspan="4" class="border-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="4" class="border-bottom-right-fntsize9 fnt12-bold"><?php echo $data_header["city"];?></td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td class="border-bottom fnt12-bold"><?php echo ($data_header['UserName']==""?$session_user:$data_header['UserName']);?></td>
        <td  class="border-bottom fnt12-bold">&nbsp;</td>
        <td  class="border-bottom-right-fntsize9 fnt12-bold">SHIPPING </td>
        <td colspan="4" class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="66"></td>
        <td width="10"></td>
        <td width="48"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td height="10"></td>
      </tr>
      <tr>
        <td colspan="4" height="20" class="fnt7 border-All" style="border-bottom-width:2px;">DATE SHIPPED:</td>
        <td colspan="4" class="fnt7 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;"><?php echo ($data_header['strBL']==""?"AWB #":"BILL OF LADING NO.:".$data_header['strMAWB']);?></td>
        <td colspan="4" class="fnt7 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">CARRIER NAME</td>
        <td colspan="4" class="fnt7 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">CARRIER NO.</td>
        <td colspan="4" class="fnt7 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">TRAILER  NO.</td>
        <td colspan="2" class="fnt7 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">TRAILER SEAL NO.</td>
        <td colspan="3" class="fnt7 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">WEIGHT  (KGS)</td>
      </tr>
      <tr>
        <td colspan="4" class="fnt8 border-left-right-fntsize9" style="text-align:left">&nbsp;MM  &nbsp;&nbsp;&nbsp;                          DD                         &nbsp;&nbsp;&nbsp;&nbsp;  YY</td>
        <td colspan="4" class="border-right-fntsize9 fnt12-bold"><?php echo ($data_header['strMAWB']==""?"":"MAWB# :".$data_header['strMAWB']);?></td>
        <td colspan="4" class="border-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="4" class="border-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="4" class="border-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize9 fnt12-bold"> </td>
        <td colspan="3"  class="fnt12-bold border-right-fntsize9" style="text-align:left">GROSS WT:&nbsp;<?php echo number_format($summary_data['dblGrossMass'],2);?> KGS</td>
      </tr>
      <tr>
        <td class="fnt12-bold border-bottom-left-fntsize9"><?php echo $sail_date_array[1];?></td>
        <td class=" border-bottom">&nbsp;</td>
        <td class="border-bottom fnt12-bold" style="text-align:left"><?php echo $sail_date_array[2];?></td>
        <td class="border-bottom-right-fntsize9 fnt12-bold" style="text-align:left"><?php echo substr($sail_date_array[0],2,2);?></td>
        <td colspan="4" class="border-bottom-right-fntsize9 fnt12-bold"><?php echo ($data_header['strHAWB']==""?$data_header['strBL']:"HAWB# :".$data_header['strHAWB']);?></td>
        <td colspan="4" class="border-bottom-right-fntsize9 fnt12-bold"><?php echo $data_header['strCarrier'];?></td>
        <td colspan="4" class="border-bottom-right-fntsize9 fnt12-bold"><?php echo $data_header['strVoyegeNo'];?></td>
        <td colspan="4" class="border-bottom-right-fntsize9 fnt12-bold"><?php echo $data_header['strContainer'];?></td>
        <td colspan="2"  class="border-bottom-right-fntsize9 fnt12-bold"><?php echo $data_header['strSealNo'];?></td>
        <td colspan="3"  class="border-bottom-right-fntsize9 fnt12-bold" style="text-align:left">NET WT:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($summary_data['dblNetMass'],2);?> KGS</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" height="20" class="fnt6 border-All" style="border-bottom-width:2px;">NUMBER    OF CARTONS</td>
        <td colspan="5" class="fnt8 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">PRODUCT CODE</td>
        <td colspan="5" class="fnt8 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">CONTRACT NO.</td>
        <td colspan="6" class="fnt8 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">QUANTITY-PCS</td>
        <td colspan="6" class="fnt8 border-top-bottom-right-fntsize9" style="border-bottom-width:2px;">COMMENTS</td>
      </tr>
      <tr>
        <td colspan="3" class="fnt12-bold border-Left-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt12-bold;" style="border-right-style:dashed">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9 fnt12-bold" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
      </tr>
      <?php 
	  	$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					strStyleID,
					dblQuantity,
					dblUnitPrice,
					dblAmount,
					intNoOfCTns,
					strISDno,
					intItemNo,
					strSpecDesc
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo' order by strBuyerPONo";
					//die($str_desc);
					$no=1;
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc) or $no<=7){
		$tot+=$row_desc["dblAmount"];
		$totqty+=$row_desc["dblQuantity"];
		$totctns+=$row_desc["intNoOfCTns"];
		$no++;
	  ?>
      <tr>
        <td colspan="3" class="fnt12-bold border-Left-bottom-right-fntsize9"><?php echo $row_desc["intNoOfCTns"];?>&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt12-bold" ><?php echo $row_desc["strStyleID"];?>&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed"><?php echo $row_desc["strBuyerPONo"];?>&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9 fnt12-bold" ><?php echo $row_desc["dblQuantity"];?>&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9 fnt12-bold"><?php echo $row_desc["strSpecDesc"];?>&nbsp;</td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="3" class="border-Left-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt12-bold" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9 fnt12-bold" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class=" border-Left-bottom-right-fntsize9" style="border-top-width:1px;border-top-style:solid">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9" style="border-top-width:1px;border-top-style:solid;border-right-style:dashed">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed;border-top-width:1px;border-top-style:solid" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9 " style="border-top-width:1px;border-top-style:solid">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 " style="border-right-style:dashed;border-top-width:1px;border-top-style:solid">&nbsp;&nbsp;&nbsp;0</td>
        <td colspan="3" class="border-bottom-right-fntsize9" style="border-right-style:dashed;border-top-width:1px;border-top-style:solid">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold" style="border-top-width:1px;border-top-style:solid">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9" style="border-top-width:1px;border-top-style:solid">&nbsp;</td>
        <td class="border-bottom-right-fntsize9" style="border-top-width:1px;border-top-style:solid">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9" style="border-top-width:1px;border-top-style:solid">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class=" border-Left-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 ">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;&nbsp;&nbsp;0</td>
        <td colspan="3" class="border-bottom-right-fntsize9" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class=" border-Left-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 ">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;&nbsp;&nbsp;0</td>
        <td colspan="3" class="border-bottom-right-fntsize9" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class=" border-Left-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 ">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 " style="border-right-style:dashed">&nbsp;&nbsp;&nbsp;0</td>
        <td colspan="3" class="border-bottom-right-fntsize9" style="border-right-style:dashed">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class=" border-Left-bottom-right-fntsize9" style="border-bottom-width:2px;">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-bottom-width:2px;border-right-style:dashed" >&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 " style="border-right-style:dashed;border-bottom-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 " style="border-bottom-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 " style="border-right-style:dashed;border-bottom-width:2px;">&nbsp;&nbsp;&nbsp;0</td>
        <td colspan="3" class="border-bottom-right-fntsize9" style="border-right-style:dashed;border-bottom-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt12-bold" style="border-bottom-width:2px;">&nbsp;</td>
        <td colspan="5" class="border-bottom-right-fntsize9" style="border-bottom-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9" style="border-bottom-width:2px;">&nbsp;</td>
        <td colspan="6" class="border-bottom-right-fntsize9" style="border-bottom-width:2px;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" rowspan="3" class="fnt12-bold border-Left-bottom-right-fntsize9"  style="border-bottom-width:2px;"><?php echo $totctns;?></td>
        <td colspan="10" rowspan="3" align="left" valign="middle" class="border-bottom-right-fntsize9 fnt12-bold" style="border-bottom-width:2px;"><img src="total.png"   alt="totals" /></td>
        <td colspan="5" rowspan="3" class="border-bottom-right-fntsize9 fnt12-bold" style="border-bottom-width:2px;"><?php echo $totqty;?></td>
        <td rowspan="3" class="border-bottom-right-fntsize9 fnt12-bold" style="border-bottom-width:2px;">&nbsp;</td>
        <td colspan="3" rowspan="3" class="border-bottom-right-fntsize9 fnt12-bold" style="border-bottom-width:2px;">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt8">SUMMARY OF UNITS SHIPPED</td>
      </tr>
      <tr>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt8">1 ST'S</td>
        <td class="border-bottom-right-fntsize9 fnt8">2ND'S</td>
      </tr>
      <tr>
        <td colspan="2" rowspan="8" class="border-bottom-right-fntsize9 fnt8">&nbsp;</td>
        <td rowspan="8" class="border-bottom-right-fntsize9 fnt8">&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="7" width="27" class="border-Left-bottom-right-fntsize9 fnt6" style="text-align:left;padding:2px;border-right-width:2px;">A<br/>
          C<br/>
          C<br/>
          O<br/>
          U<br/>
          N<br/>
          T<br/>
          I<br/>
          N<br/>
          G<br/>
          <br/>
          D<br/>
          E<br/>
          P<br/>
          T. <br/>
          <br/>
          O<br/>
          N<br/>
          L<br/>
          Y<br/></td>
        <td rowspan="2" width="36"  class="border-bottom-right-fntsize9 fnt8">R <br/>
          E<br />C</td>
        <td rowspan="2" width="54" class="border-bottom-right-fntsize9 fnt8"><p>DR CR<br/>*</p></td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt8" style="border-right-width:2px;">NATURAL ACCT.</td>
        <td colspan="5" class="border-bottom-right-fntsize9 fnt8" style="border-right-width:2px;">RESPONSIBILITY CENTER</td>
        <td colspan="3" rowspan="2" class="border-bottom-right-fntsize9 fnt8" >DEBITS(10)</td>
        <td colspan="4" rowspan="2" class="border-bottom-right-fntsize9 fnt8" style="border-right-width:2px;">CREDITS(60)</td>
        <td rowspan="2" width="23" class="border-bottom-right-fntsize9 fnt8">R E<br />
          C</td>
        <td colspan="2" rowspan="2" class="border-bottom-right-fntsize9 fnt8">MEMO</td>
        <td colspan="2" rowspan="2" class="border-bottom-right-fntsize9 fnt8" style="border-right-width:2px;">SALES<br />
          REP(5)<br/>
          PROJECT (4)</td>
      </tr>
      <tr>
        <td  class="border-bottom-right-fntsize9 fnt8">Level 1 </td>
        <td class="border-bottom-right-fntsize9 fnt8" style="border-right-width:2px;">Level 2</td>
        <td width="64" class="border-bottom-right-fntsize9 fnt8">Org.   Code</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt8">P.MGR.</td>
        <td class="border-bottom-right-fntsize9 fnt8">DEPT.</td>
        <td class="border-bottom-right-fntsize9 fnt8" style="border-right-width:2px;">SECT.</td>
      </tr>
      <tr>
        <td align="right" class="border-bottom-right-fntsize9 fnt9">7</td>
        <td class="border-bottom-right-fntsize9 fnt9">8-9</td>
        <td class="border-bottom-right-fntsize9 fnt9">21-23</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">25-27</td>
        <td class="border-bottom-right-fntsize9 fnt9">32-34</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">35-36</td>
        <td class="border-bottom-right-fntsize9 fnt9">38-40</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">41-43</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt9">60-72</td>
        <td colspan="4" class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">60-72</td>
        <td class="border-bottom-right-fntsize9 fnt9">7</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">25-32</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">60-65</td>
      </tr>
      <tr>
        <td class="border-bottom-right-fntsize9 fnt9" height="27">1</td>
        <td class="border-bottom-right-fntsize9 fnt9" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" >&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" >&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">2</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-right-fntsize9 fnt9" height="27">1</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">2</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-right-fntsize9 fnt9" height="27">1</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">2</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-right-fntsize9 fnt9" height="27">1</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="3" class="border-bottom-right-fntsize9 fnt9" style="border-right-style:dashed;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
        <td class="border-bottom-right-fntsize9 fnt9">2</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize9 fnt9" style="border-right-width:2px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>