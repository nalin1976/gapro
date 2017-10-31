<?php
	session_start();
	include "../../Connector.php";	
	//$gpnumber=$_GET["gpnumber"];
	$backwardseperator 	= "../../";	
	$userId	= $_GET["UserId"];
	
	//$serial_array=explode("/",$gpnumber);
	//die($serial_array[1]);
	//$serial_year=($serial_array[1]!=""?$serial_array[0]:date("Y"));
	//$serial_no=($serial_array[1]!=""?$serial_array[1]:$serial_array[0]);
delGPView();
$serial_year 	= $_GET["intYear"];
$serial_no 		= $_GET["SerialNumber"];

$str_header="select intGPnumber, 
intGPYear,
(select Name from useraccounts u where u.intUserID=productionfggpheader.intUser)as UserName,
intStyleId, 
dtmGPDate, 
strFromFactory, 
strToFactory, 
dblTotQty, 
dblBalQty, 
intStatus, 
intUser, 
strVehicleNo,
strRemarks,
intConfirmedBy
from 
productionfggpheader
where intGPnumber='$serial_no' and intGPYear='$serial_year';";	

//echo $str_header;
$result_header = $db->RunQuery($str_header);
$row_header = mysql_fetch_array($result_header);
$tofactory		= $row_header["tofactory"];
$date_array		= explode("-",$row_header["dtmGPDate"]);
$date			= $date_array[2]."-".$date_array[1]."-".$date_array[0];
$vehicle		= $row_header["strVehicleNo"];
$pallet			= $row_header["strPalletNo"];
$fromfactory	= $row_header["fromfactory"];
$fax			= $row_header["fax"];
$phone			= $row_header["phone"];
$FromFactory	= $row_header["strFromFactory"];
$toFactory		= $row_header["strToFactory"];
$Remarks		= $row_header["strRemarks"];
$report_companyId  = $row_header["strFromFactory"];
$status=$row_header['intStatus'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Gate Pass</title>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script language="javascript">
var xmlHttpreq = [];
function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpreq[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpreq[index] = new XMLHttpRequest();
    }
}
//------------------------------------------------------------------------------------------------------------
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
function ConfirmGP(gpass,searchYear,po)
{
	createNewXMLHttpRequest(0);
	xmlHttpreq[0].onreadystatechange = HandleConfirmData;
	var url="db.php?RequestType=confirmReq&po="+po+"&gpass="+gpass+"&searchYear="+searchYear;
	xmlHttpreq[0].open("GET",url,true);
	xmlHttpreq[0].send(null);
}
//------------------------------
function HandleConfirmData()
{
	if(xmlHttpreq[0].readyState == 4) 
	{
		if(xmlHttpreq[0].status == 200) 
		{
			alert(xmlHttpreq[0].responseText);
			document.getElementById('btnConfirm').style.display='none';
		}
	}		
}

</script>
<style type="text/css">
td{
 font-size:140%;
}

</style>
</head>

<body>
<?php
$sqlf="select CO.strName,CO.strAddress1,CO.strAddress2,CO.strStreet,CO.strCity,C.strCountry,CO.strZipCode,CO.strPhone,CO.strFax from companies CO
inner join country C on CO.intCountry=C.intConID where CO.intCompanyID='$FromFactory';";
$resultf=$db->RunQuery($sqlf);
while($rowf=mysql_fetch_array($resultf))
{
	$f_name = $rowf["strName"];
	$f_name .= ($rowf["strAddress1"]=='' ? '':'<br/>'.$rowf["strAddress1"]);
	$f_name .= ($rowf["strAddress2"]=='' ? '':'<br/>'.$rowf["strAddress2"]);
	$f_name .= ($rowf["strStreet"]=='' ? '':'<br/>'.$rowf["strStreet"]);
	$f_name .= ($rowf["strCity"]=='' ? '':'<br/>'.$rowf["strCity"]);
	$f_name .= ($rowf["strCountry"]=='' ? '':'<br/>'.$rowf["strCountry"]);
	$f_name .= ($rowf["strPhone"]=='' ? '':'<br/>TEL : '.$rowf["strPhone"]);
	$f_name .= ($rowf["strFax"]=='' ? '':'<br/>FAX : '.$rowf["strFax"]);
	$from_city	= $rowf["strCity"];
}

$sqlt="select CO.strName,CO.strAddress1,CO.strAddress2,CO.strStreet,CO.strCity,C.strCountry,CO.strZipCode,CO.strPhone,CO.strFax from companies CO
inner join country C on CO.intCountry=C.intConID where CO.intCompanyID='$toFactory';";
$resultt=$db->RunQuery($sqlt);
while($rowt=mysql_fetch_array($resultt))
{
	$t_name  = $rowt["strName"];
	$t_name .= ($rowt["strAddress1"]=='' ? '':'<br/>'.$rowt["strAddress1"]);
	$t_name .= ($rowt["strAddress2"]=='' ? '':'<br/>'.$rowt["strAddress2"]);
	$t_name .= ($rowt["strStreet"]=='' ? '':'<br/>'.$rowt["strStreet"]);
	$t_name .= ($rowt["strCity"]=='' ? '':'<br/>'.$rowt["strCity"]);
	$t_name .= ($rowt["strCountry"]=='' ? '':'<br/>'.$rowt["strCountry"]);
	$t_name .= ($rowt["strPhone"]=='' ? '':'<br/>TEL : '.$rowt["strPhone"]);
	$t_name .= ($rowt["strFax"]=='' ? '':'<br/>FAX : '.$rowt["strFax"]);
	
	
}
if($status==10){
	echo "<div style=\"position:absolute;top:200px;left:320px;\">
            	<img src=\"../../images/cancelled.png\">
           		 </div>";
}
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" class="head2" >ORIT APPARELS LANKA (PVT)LTD.</td>
  </tr>
 
  
  <tr>
    <td colspan="3" class="normalfntSubHeader"><div align="center" >GATE PASS -(Invoice Wise)</div></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="30%"  height="40" class="border-All-fntsize12"><strong>&nbsp;Wash Ready - <?php  $fac=getFacId($serial_no,$serial_year); echo getWashReadyComapny($fac);?></strong></td>
    <td width="40%"  ></td>
    <td width="30%" class="border-All-fntsize12"><strong>&nbsp;GatePass No : <?php echo $serial_year.'/'.$serial_no?></strong></td>
  </tr>
   <tr>
     <td height="10" >&nbsp;</td>
     <td height="10" >&nbsp;</td>
     <td height="10" >&nbsp;</td>
   </tr>
   <tr>
    <td height="10" colspan="3" class="border-top">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="12%" valign="top">&nbsp;&nbsp;<strong>Deliver From </strong> </td>
        <td width="1%" valign="top">:</td>
        <td width="37%" rowspan="3" valign="top"><?php echo $f_name;?></td>
        <td width="12%" valign="top"><strong>Deliver To</strong></td>
        <td width="1%" valign="top">:</td>
        <td width="37%" rowspan="3" valign="top"><?php echo $t_name;?></td>
      </tr>
      
      <tr>
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
      </tr>
      
      <tr>
        <td><strong>&nbsp; Vehicle No</strong></td>
        <td>:</td>
        <td><?php echo $vehicle;?> </td>
        <td><strong>GatePass Date</strong></td>
        <td>:</td>
        <td class="normalfnt"> <?php echo $date;?> </td>
      </tr>
	  
	  <tr>
        <td><strong>&nbsp; Remarks</strong></td>
        <td>&nbsp;</td>
        <td colspan="4"><?php echo $Remarks;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
   <tr>
     <td colspan="3">
     <table width="100%" border="0" cellspacing="0" cellpadding="0" >
     <thead>
       <tr>
         <td width="15%"  height="25" class="border-top-bottom-left-fntsize12"><div align="center"><strong>PO No. </strong></div></td>
         <td width="15%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Style No</strong></div></td>
         <td width="11%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Color</strong></div></td>
         <td width="14%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Division</strong></div></td>
         <td colspan="4" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Description of Articles </strong></div></td>
         <td width="8%" class="border-All-fntsize12"><div align="center"><strong>Quantity</strong></div></td>
       </tr>
       </thead>
       
        <?php //create view rptEGP AS
	  delGPView();
	  $orderNo='';
	  $styleNo='';
	  $color='';
	  $division='';
	  $mainFabric=''; 
	  $InvoiceNo='';
	  $shade='';
	  $confirmedBy='';
	  $styleID='';
	  $shadeQty=0;
	  $results_det=getDet($serial_no,$serial_year);
	  $str_details="SELECT * FROM rptEGP;";
	  $i=0;
	 // echo $str_details;
	  $results_details=$db->RunQuery($str_details);	
	  while($row=mysql_fetch_array($results_details))
	  { 
	  	$i++;
		$styleID=$row['intStyleId'];
	  	$confirmedBy=$row['intConfirmedBy'];
		if($orderNo==""){
	  ?>
	  
      <tr>
        <td class="border-left-fntsize12" ><?php echo $orderNo=$row['strOrderNo']; ?></td>
        <td class="border-left-fntsize12" ><?php echo  $styleNo=$row['strStyle']; ?></td>
        <td class="border-left-fntsize12" ><?php $color = GetColor($row["intStyleId"]); echo  $color; ?></td>
        <td class="border-left-fntsize12" ><?php $division = GetDivision($row["intStyleId"]); echo  $division; ?> </td>
        <td  colspan="4" class="border-left-fntsize12">
		<?php $mainFabric = GetMainFabric($row["intStyleId"]);echo  $mainFabric; ?> </td>
        <td  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <?php }?>
	  
      <tr>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td  class="border-left-fntsize12"><?php if($i==1){  ?><?php echo "Invoice No :";}?></td>
         <td class="normalfnt"><?php if($InvoiceNo=="" || $InvoiceNo!=$row["strInvoiceNo"]){  ?><?php echo $row["strInvoiceNo"];$InvoiceNo=$row["strInvoiceNo"]; }?></td>
         <td class="normalfnt"><?php if($i==1){  ?><?php echo "Shade :";}?></td>
         <td class="normalfnt"><?php		
		 $final_tot=$final_tot+$row['QTY'];
			echo $row['strShade'];								 
			 ?></td>
         <td class="border-left-right-fntsize12"><?php echo $row['QTY'];?></td>
       </tr>
      
	  <?php }  ?>
	  
      <tr>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td  class="border-left-fntsize12">&nbsp;</td>
         <td colspan="4" class="border-left-fntsize12"><b><div align="right">Total Garments</div></b></td>
         <td class="border-Left-Top-right-fntsize12"><div align="right">
		 <?php echo $final_tot;
			delGPView(); 
		 ?></div></td>
       </tr>
<!--       <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
         <td style="border-left:solid #000 1px;">&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td style="border-left:solid #000 1px;">&nbsp;</td>
       </tr>-->
         <tr align="center">
           <td height="25" colspan="9" class="border-top" align="center" style="text-align:center;">
		   	<?php 
				if($status==1){
			
            	echo "<img src=\"../../images/conform.png\" id=\"btnConfirm\" onclick=\"ConfirmGP($serial_no".","."$serial_year".","."$styleID);\" />";
                
			 }
			 
			 ?>           </td>
          </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="3" class="normalfntMid">
      <tr height="10"></tr>
      <tr>
        <td width="25%" class="bcgl1txt1" height="25" style="text-align:center;font-size:15px;"><?php echo getUser($row_header["intUser"]);?></td>
        <td width="25%" class="bcgl1txt1" style="text-align:center;font-size:15px;"><?php echo getUser($row_header["intConfirmedBy"]);?></td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="repo">Prepared by</td>
        <td class="reportBottom">Authorized By</td>
        <td class="reportBottom">Delivered By</td>
        <td class="reportBottom">Signature</td>
      </tr>
      <tr>
        <td width="25%" class="bcgl1txt1" height="25" style="text-align:center;font-size:15px;"><?php echo $date;?></td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="reportBottom">Date</td>
        <td class="reportBottom">Time Out</td>
        <td class="reportBottom">Time In</td>
        <td class="reportBottom">Signature Security</td>
      </tr>
      <tr>
        <td class="normalfntMid" height="25">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1" style="text-align:center;font-size:15px;"><?php echo $vehicle;?></td>
        <td class="normalfntMid">&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td class="reportBottom">No Of Packages </td>
        <td class="reportBottom">Vehical No </td>
        <td >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
  </td>
  </tr>
</table>
</body>
</html>
<?php
function GetColor($styleId)
{
global $db;
	$sql="select distinct strColor from styleratio where intStyleId='$styleId';";
	//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strColor"];
	}
}
function GetDivision($styleId)
{
global $db;
	$sql="select distinct BD.strDivision from orders O inner join buyerdivisions BD on BD.intDivisionId=O.intDivisionId where O.intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strDivision"];
	}
}

function GetMainFabric($styleId)
{
global $db;
	$sql="select distinct MIL.strItemDescription from matitemlist MIL inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial where OD.intMainFabricStatus=1 and intStyleId=$styleId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strItemDescription"];
	}
}

function getFacId($gp,$year){
global $db;
	$sql="SELECT DISTINCT productionwashreadyheader.intFactory
			FROM
			productionfggpheader
			INNER JOIN productionwashreadyheader ON productionwashreadyheader.intStyleId = productionfggpheader.intStyleId
			WHERE
			productionfggpheader.intGPnumber='$gp' AND
			productionfggpheader.intGPYear='$year';";

	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intFactory"];
}
function getWashReadyComapny($ComId)
{
global $db;
	$sql="select c.strCity from companies c where c.intCompanyID='$ComId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strCity"];

}

function getShadeQty($InvoiceNo){
global $db;
$sql="SELECT
		Sum(rptEGP.dblQty) as qty,
		rptEGP.strInvoiceNo,
		rptEGP.strShade
		from rptEGP
		where rptEGP.strInvoiceNo='$InvoiceNo'
		GROUP BY
		rptEGP.strInvoiceNo,
		rptEGP.strShade";
		//echo $sql;
 	return $db->RunQuery($sql);	
	
	
}

function getDet($serial_no,$serial_year){
	global $db;
	
		
 $str_details=" create view rptEGP AS SELECT
				Sum(gpd.dblQty) AS QTY,
				gpd.dblBalQty,
				pbh.intStyleId,
				orrds.strStyle,
				orrds.strOrderNo,
				gpd.strShade,
				pbh.strInvoiceNo,
				productionfggpheader.intConfirmedBy
				FROM
				productionfggpdetails AS gpd
				LEFT JOIN productionbundledetails AS pbd ON pbd.intCutBundleSerial = gpd.intCutBundleSerial AND pbd.dblBundleNo = gpd.dblBundleNo
				LEFT JOIN productionbundleheader AS pbh ON pbh.intCutBundleSerial = gpd.intCutBundleSerial
				INNER JOIN orders AS orrds ON pbh.intStyleId = orrds.intStyleId
				INNER JOIN productionfggpheader ON productionfggpheader.intGPnumber = gpd.intGPnumber AND productionfggpheader.intGPYear = gpd.intGPYear
				where gpd.intGPnumber='$serial_no' and gpd.intGPYear='$serial_year'
				GROUP BY orrds.strOrderNo, gpd.strShade, pbh.strInvoiceNo
				ORDER BY orrds.strOrderNo ASC;";
			//echo  $str_details;
	  return $db->RunQuery($str_details);	 
}

function delGPView(){
	global $db;
	$sql="drop view rptEGP;";
	$db->RunQuery($sql);	 
	
}
function getUser($id){
global $db;
$sql="select ur.Name from useraccounts ur where ur.intUserID='$id'";
$res=$db->RunQuery($sql);
$row=mysql_fetch_array($res);
return $row['Name'];
	
}
?>