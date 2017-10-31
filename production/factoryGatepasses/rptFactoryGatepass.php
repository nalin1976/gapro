<?php
	session_start();
	include "../../Connector.php";	
	//$gpnumber=$_GET["gpnumber"];
	$backwardseperator 	= "../../";	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	//$serial_array=explode("/",$gpnumber);
	//die($serial_array[1]);
	//$serial_year=($serial_array[1]!=""?$serial_array[0]:date("Y"));
	//$serial_no=($serial_array[1]!=""?$serial_array[1]:$serial_array[0]);

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
intStatus,
intUser, 
strVehicleNo,
strRemarks,
intStatus
from 
productionfggpheader
where intGPnumber='$serial_no' and intGPYear='$serial_year';";	
$result_header = $db->RunQuery($str_header);
$row_header = mysql_fetch_array($result_header);
$tofactory		= $row_header["tofactory"];
$date_array		= explode("-",$row_header["dtmGPDate"]);
$date			= $date_array[2]."-".$date_array[1]."-".$date_array[0];
$vehicle		= $row_header["strVehicleNo"];
$remarks		= $row_header["strRemarks"];
$pallet			= $row_header["strPalletNo"];
$fromfactory	= $row_header["fromfactory"];
$fax			= $row_header["fax"];
$phone			= $row_header["phone"];
$FromFactory	= $row_header["strFromFactory"];
$toFactory		= $row_header["strToFactory"];
$status			= $row_header["intStatus"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Gate Pass</title>
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

?>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="head2" >ORIT APPARELS LANKA (PVT)LTD.</td>
  </tr>
  <tr>
    <td class="head2"><div align="center" >GATE PASS </div></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
     <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="22%" class="border-All"><strong>&nbsp;Wash Ready - <?php echo $from_city;?></strong></td>
         <td width="51%">&nbsp;</td>
         <td width="27%" class="border-All"><strong>&nbsp;GatePass No : <?php echo $serial_year.'/'.$serial_no?></strong></td>
       </tr>
     </table></td>
   </tr>
   <tr>
     <td class="border-bottom">&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
       <tr>
         <td width="12%" valign="top"><strong>Deliver From </strong> </td>
         <td width="1%" valign="top"><b>:</b></td>
         <td width="37%" rowspan="3" valign="top"><?php echo $f_name;?></td>
         <td width="13%" valign="top"><strong>Deliver To</strong></td>
         <td width="0%" valign="top"><b>:</b></td>
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
         <td><strong> Vehicle No</strong></td>
         <td><b>:</b></td>
         <td><?php echo $vehicle;?> </td>
         <td><strong>GatePass Date</strong></td>
         <td><b>:</b></td>
         <td class="normalfnt"><?php echo $date;?> </td>
       </tr>
       <tr>
         <td height="20"><strong>Remarks</strong></td>
         <td><b>:</b></td>
         <td colspan="4" class="normalfnt"><?php echo $remarks?></td>
        </tr>
     </table></td>
   </tr>
   <tr>
     <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <thead>
         <tr>
           <td width="15%" class="border-top-bottom-left-fntsize12" height="25" style="text-align:center;"><strong>PO No. </strong></td>
           <td width="15%" class="border-top-bottom-left-fntsize12" style="text-align:center;"><strong>Style No</strong></td>
           <td width="11%" class="border-top-bottom-left-fntsize12" style="text-align:center;"><strong>Color</strong></td>
           <td width="14%" class="border-top-bottom-left-fntsize12" style="text-align:center;"><strong>Division</strong></td>
           <td colspan="4" class="border-top-bottom-left-fntsize12" style="text-align:center;"><strong>Description of Articles</strong></td>
           <td width="7%" class="border-All-fntsize12" style="text-align:center;"><strong>Qty</strong></td>
         </tr>
       </thead>
       <?php
	  $str_details="select 	gpd.intGPnumber, 
					pbd.strSize,
					pbd.dblPcs,	
					gpd.intGPYear, 
					gpd.intCutBundleSerial, 
					gpd.dblBundleNo, 
					gpd.dblQty, 
					gpd.dblBalQty,
					pbh.intStyleId,
					orrds.strStyle,
					orrds.strOrderNo,
					pbh.strCutNo
					from 
					productionfggpdetails gpd left join productionbundledetails pbd on pbd.intCutBundleSerial = gpd.intCutBundleSerial	
					and pbd.dblBundleNo = gpd.dblBundleNo 
					left join productionbundleheader pbh on pbh.intCutBundleSerial = gpd.intCutBundleSerial 
					inner join orders orrds on pbh.intStyleId =orrds.intStyleId 
					where  gpd.intGPnumber='$serial_no' and gpd.intGPYear='$serial_year' order by pbh.intStyleId,pbh.strCutNo,pbd.strSize;";
	  $results_details=$db->RunQuery($str_details);
	  while($row=mysql_fetch_array($results_details))
	  {
		$current=$row["intStyleId"];
		$color = GetColor($current);
		$division	= GetDivision($current);
		$mainFabric	= GetMainFabric($current);
		$c_cut=$row["strCutNo"];
		$final_tot+=$row["dblQty"];		
		if($current!=$previous) {?>
       <tr>
         <td height="41" class="border-left-fntsize12"><?php echo $row["strOrderNo"];?></td>
         <td class="border-left-fntsize12"><?php echo $row["strStyle"];?></td>
         <td class="border-left-fntsize12"><?php echo $color;?></td>
         <td class="border-left-fntsize12"><?php echo $division;?></td>
         <td colspan="4" class="border-left-fntsize12"><?php echo $mainFabric;?></td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <?php }	  
	   
		 $size_break_array=explode("-",$row["strSize"]);
	  	 $size_break=$size_break_array[0];
	  	 if((($tmpSize!=$size_break)||($temp_cut!=$c_cut)||($current!=$previous)) && ($tmpSize!='')){
			 
		?>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td width="8%" class="border-left-fntsize12">&nbsp;</td>
         <td width="11%">&nbsp;</td>
         <td width="10%" class="normalfnt" style="font-size:12px;"><?php echo $tmpSize." - ".$no_sizes;?></td>
         <td width="9%" class="normalfntRite" style="font-size:12px;"><?php echo $size_qty;?></td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <?php 
		$no_sizes=0;
		$size_qty=0;
			}	
		if(($temp_cut!=$c_cut)||($current!=$previous))
	   		{
		if($temp_cut!=""){
	    ?>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-left-right-fntsize12" style="border-bottom-style:solid;border-top-style:solid;border-top-width:1px;border-bottom-width:1px" ><div align="right"><?php echo $cut_tot;?></div></td>
       </tr>
       <?php 
		$cut_tot=0;
		}
		
		?>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">Cut No :</td>
         <td colspan="3" class="normalfnt" style="font-size:12px;"><?php echo $row["strCutNo"];?></td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <?php }	
		$previous =$current;
		$temp_cut =$c_cut;
		$tmpSize  =$size_break;
		$no_sizes++;
		$cut_tot+=$row["dblQty"];
		$size_qty+=$row["dblQty"];
		} 		
		?>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td>&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;"><?php echo $tmpSize." - ".$no_sizes;?></td>
         <td class="normalfntRite" style="font-size:12px;"><?php echo $size_qty;?></td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="normalfnt" style="font-size:12px;">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-left-right-fntsize12" style="border-bottom-style:solid;border-top-style:solid;border-top-width:1px;border-bottom-width:1px" ><div align="right"><?php echo $cut_tot;?></div></td>
       </tr>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td colspan="4" class="border-left-fntsize12" ><b>
           <div align="right">Total Garments</div>
         </b></td>
         <td class="border-left-right-fntsize12" style="border-bottom-style:double"><div align="right"><?php echo $final_tot;?></div></td>
       </tr>
       <tr>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="border-left-fntsize12">&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td class="normalfnt">&nbsp;</td>
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <tfoot>
         <tr>
           <td colspan="9" class="border-top">&nbsp;</td>
         </tr>
       </tfoot>
     </table></td>
   </tr>
   <tr>
     <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
       <tr height="10"></tr>
       <tr>
         <td width="25%" class="bcgl1txt1" height="25"><?php echo $row_header["UserName"];?></td>
         <td width="25%" class="bcgl1txt1">&nbsp;</td>
         <td width="25%" class="bcgl1txt1">&nbsp;</td>
         <td width="25%" class="bcgl1txt1">&nbsp;</td>
       </tr>
       <tr>
         <td class="normalfntMid">Prepared by</td>
         <td class="normalfntMid">Authorized By</td>
         <td class="normalfntMid">Delivered By</td>
         <td class="normalfntMid">Signature</td>
       </tr>
       <tr>
         <td width="25%" class="bcgl1txt1" height="25"><?php echo $date;?></td>
         <td width="25%" class="bcgl1txt1">&nbsp;</td>
         <td width="25%" class="bcgl1txt1">&nbsp;</td>
         <td width="25%" class="bcgl1txt1">&nbsp;</td>
       </tr>
       <tr>
         <td class="normalfntMid">Date</td>
         <td class="normalfntMid">Time Out</td>
         <td class="normalfntMid">Time In</td>
         <td class="normalfntMid">Signature Security</td>
       </tr>
       <tr>
         <td class="normalfntMid" height="25">&nbsp;</td>
         <td class="bcgl1txt1">&nbsp;</td>
         <td class="bcgl1txt1"><?php echo $vehicle;?></td>
         <td class="normalfntMid">&nbsp;</td>
       </tr>
       <tr>
         <td >&nbsp;</td>
         <td class="normalfntMid">No Of Packages </td>
         <td class="normalfntMid">Vehical No </td>
         <td >&nbsp;</td>
       </tr>
     </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
</table>
</body>
</html>
<?php
if($status == 10)
{
?>
<div style="position:absolute;top:120px;left:450px;"><img src="../../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php
}
?>
<?php
function GetColor($styleId)
{
global $db;
	$sql="select distinct strColor from styleratio where intStyleId='$styleId'";
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
?>