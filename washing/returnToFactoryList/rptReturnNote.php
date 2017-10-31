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
$serial=$serial_year."/".$serial_no;

$str_header="SELECT
			was_returntofactoryheader.intGPYear,
			was_returntofactoryheader.dblGPNo,
			was_returntofactoryheader.dtmDate,
			was_returntofactoryheader.intFromFac,
			was_returntofactoryheader.intToFac,
			was_returntofactoryheader.intStyleId,
			was_returntofactoryheader.intYear,
			was_returntofactoryheader.dblSerial,
			was_returntofactoryheader.intUser,
			was_returntofactoryheader.strRemarks
			FROM
			was_returntofactoryheader
			WHERE
			CONCAT(was_returntofactoryheader.intYear,'/',was_returntofactoryheader.dblSerial)='$serial';";	
$result_header = $db->RunQuery($str_header);
$row_header = mysql_fetch_array($result_header);
$tofactory		= $row_header["intToFac"];
$date_array		= explode("-",$row_header["dtmDate"]);
$date			= $date_array[2]."-".$date_array[1]."-".$date_array[0];
$vehicle		= $row_header["strVehicleNo"];
$pallet			= $row_header["strPalletNo"];
$fromfactory	= $row_header["intFromFac"];
$fax			= $row_header["fax"];
$phone			= $row_header["phone"];
$FromFactory	= $row_header["strFromFactory"];
$toFactory		= $row_header["strToFactory"];
$remarks		= $row_header["strRemarks"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Return Gate Pass</title>
<style type="text/css">

</style>
</head>

<body>
<?php
$sqlf="select CO.strName,CO.strAddress1,CO.strAddress2,CO.strStreet,CO.strCity,C.strCountry,CO.strZipCode,CO.strPhone,CO.strFax from companies CO
inner join country C on CO.intCountry=C.intConID where CO.intCompanyID='".$row_header['intFromFac']."';";

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
inner join country C on CO.intCountry=C.intConID where CO.intCompanyID='".$row_header['intToFac']."';";
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
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" class="head2" >ORIT APPARELS LANKA (PVT)LTD.</td>
  </tr>
 
  
  <tr>
    <td colspan="3" class="tophead3"><div align="center" >RETURN GATE PASS </div></td>
  </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr><!--class="border-All-fntsize12"-->
    <td width="200" height="40"  nowrap="nowrap" style="color:#FFF"><strong>&nbsp;Wash Ready - <?php  $fac=getFacId($str_header['dblGPNo'],$str_header['intGPYear']); echo getWashReadyComapny($fac);?></strong></td>
    <td width="401" ></td>
    <td width="200" class="border-All-fntsize12" nowrap="nowrap"><strong>&nbsp;Return No : <?php echo $serial_year.'/'.$serial_no?></strong></td>
  </tr>
   <tr>
     <td height="10" colspan="3" >&nbsp;</td>
   </tr>
   <tr>
    <td height="10" colspan="3" class="border-top">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="12%" valign="top" height="20">&nbsp;<strong>Return From </strong> </td>
        <td width="1%" valign="top">:</td>
        <td width="37%" rowspan="3" valign="top"><?php echo $f_name;?></td>
        <td width="12%" valign="top"><strong>Return To</strong></td>
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
      
      <tr >
        <td height="20">&nbsp;<strong>GatePass No  </strong></td>
        <td>:</td>
        <td>&nbsp;<?php echo $row_header['intGPYear'].'/'.$row_header['dblGPNo'];?></td>
        <td><strong>Return Date</strong></td>
        <td>:</td>
        <td class="normalfnt"> <?php echo $date;?> </td>
      </tr>
	  
	  <tr>
        <td height="20"><strong>&nbsp;Vehicle No</strong></td>
        <td>:</td>
        <td><?php echo $vehicle;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td height="20"><strong>&nbsp;Remarks</strong></td>
	    <td>:</td>
	    <td><?php echo $remarks;?></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
    </table></td>
  </tr>
   <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
     <thead>
       <tr>
         <td width="15%" class="border-top-bottom-left-fntsize12" height="25"><div align="center"><strong>PO No. </strong></div></td>
         <td width="15%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Style No</strong></div></td>
         <td width="11%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Color</strong></div></td>
         <td width="14%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Division</strong></div></td>
         <td colspan="4" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Description of Articles </strong></div></td>
         <td width="8%" class="border-All-fntsize12"><div align="center"><strong>Quantity</strong></div></td>
       </tr>
       </thead>
       
        <?php
	  $str_details="SELECT
					was_returntofactorydetails.strSize,
					was_returntofactorydetails.strCutNo,
					was_returntofactoryheader.strColor,
					was_returntofactorydetails.dblQty,
					orders.strOrderNo,
					orders.strStyle,
					orderdetails.intMainFabricStatus,
					matitemlist.strItemDescription,
					orders.intStyleId
					FROM
					was_returntofactorydetails
					INNER JOIN was_returntofactoryheader ON was_returntofactoryheader.dblSerial = was_returntofactorydetails.dblSerial AND was_returntofactorydetails.intYear = was_returntofactoryheader.intYear
					INNER JOIN orders ON was_returntofactoryheader.intStyleId = orders.intStyleId
					LEFT JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId
					INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
					WHERE
					concat(was_returntofactorydetails.intYear,'/',was_returntofactorydetails.dblSerial) = '$serial' AND
					orderdetails.intMainFabricStatus = '1'
					ORDER BY
					was_returntofactorydetails.strCutNo,was_returntofactorydetails.strSize ASC;";
				//	echo $str_details;
					
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
         <td class="border-left-fntsize12"><?php echo $row["strOrderNo"];?></td>
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
         <td width="8%" class="normalfntRite" style="font-size:12px;"><?php echo $size_qty;?></td>
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
         <td colspan="4" class="border-left-fntsize12" ><b><div align="right">Total Garments</div></b></td>
         <td class="border-left-right-fntsize12" style="border-bottom-style:double"><div align="right"><?php echo $final_tot;?></div></td>
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
         <td class="border-left-right-fntsize12">&nbsp;</td>
       </tr>
       <tfoot>
         <tr>
           <td height="25" colspan="9" class="border-top">&nbsp;</td>
          </tr>
       </tfoot>
     </table></td>
   </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="1" class="normalfntMid">
      <tr height="10"></tr>
      <tr>
        <td height="25" width="25%" class="bcgl1txt1"><?php echo getUserName($row_header["intUser"]);?></td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="reportBottom">Prepared by</td>
        <td class="reportBottom">Authorized By</td>
        <td class="reportBottom">Delivered By</td>
        <td class="reportBottom">Signature</td>
      </tr>
      <tr>
        <td width="25%" class="bcgl1txt1" height="25"><?php echo $date;?></td>
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
        <td class="bcgl1txt1"><?php echo $vehicle;?></td>
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
</table>
</body>
</html>
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

function getFacId($gp,$year){
global $db;
	$sql="SELECT DISTINCT productionwashreadyheader.intFactory
			FROM
			productionfggpheader
			INNER JOIN productionwashreadyheader ON productionwashreadyheader.intStyleId = productionfggpheader.intStyleId
			WHERE
			productionfggpheader.intGPnumber='$gp' AND
			productionfggpheader.intGPYear='$year';";
			//echo $sql;

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
function getUserName($userid)
{
global $db;
	$sql="select u.Name from useraccounts u where u.intUserID='$userid'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["Name"];

}
?>