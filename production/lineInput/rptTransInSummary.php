<?php
	session_start();
	include "../../Connector.php";	
	$factoryid	=$_GET["factoryid"];
	$teamno		=$_GET["teamno"];
	$from_date	=$_GET["from_date"];
	$to_date	=$_GET["to_date"];
	$backwardseperator 	= "../../";	
	$userId		= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	$styleId		= $_GET["StyleId"];
	if($from_date!="")
	{
		$from_date_array=explode('/',$from_date);
		$from_date		=$from_date_array[2]."-".$from_date_array[1]."-".$from_date_array[0];
	}
	if($to_date!="")
	{
		$to_date_array  =explode('/',$to_date);
		$to_date		=$to_date_array[2]."-".$to_date_array[1]."-".$to_date_array[0];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>GaPro | Line Input Report</title>
<style type="text/css">
.tophead1  {
color:#000000;
font-family:"Century Gothic";
font-size:24px;
line-height:24px;
font-weight:normal;
margin:0;
}
.tophead2  {
color:#000000;
font-family:"Century Gothic";
line-height:22px;
font-size:20px;
font-weight:normal;
margin:0;
}
.tophead3  {
color:#000000;
font-family:"Century Gothic";
line-height:18px;
font-size:16px;
font-weight:bold;
margin:0;
}
td{
font-family:Tahoma;

}

div{
	font-family:Tahoma;
	font-weight:normal;
	font-size:12px;
}
</style>
</head>

<body>

<table width="850" border="0" align="center" cellpadding="0" cellspacing="1">
<!--  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../reportHeader.php";?></td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>-->
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">Line Input</td>
  </tr>
  
  <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="normalfnt">
      
<?php
	 /* echo $str_header="select PLH.*,C.strName,O.strOrderNo from productionlineinputheader PLH inner join companies C on C.intCompanyID=PLH.intFactory inner join orders O on O.intStyleId=PLH.intStyleId Where PLH.intLineInputSerial='$inputSerialNumber' AND PLH.intLineInputYear='$year'";*/
$grandCutTotal	  = 0;
$str_header="SELECT
PLH.intLineInputSerial,
PLH.intLineInputYear,
PLH.dtmDate,
PLH.intFactory,
plan_teams.strTeam,
PLH.intStyleId,
PLH.strCutNo,
PLH.strPatternNo,
PLH.dblTotQty,
PLH.dblBalQty,
PLH.intStatus,
C.strName,
O.strOrderNo,
O.strStyle,
O.intDivisionId,
productionbundleheader.strColor,
buyerdivisions.strDivision
FROM
productionlineinputheader AS PLH
Inner Join companies AS C ON C.intCompanyID = PLH.intFactory
left Join orders AS O ON O.intStyleId = PLH.intStyleId
Inner Join productionbundleheader ON PLH.intStyleId = productionbundleheader.intStyleId AND PLH.strCutNo = productionbundleheader.strCutNo
left Join buyerdivisions ON O.intBuyerID = buyerdivisions.intBuyerID AND O.intDivisionId = buyerdivisions.intDivisionId
left join plan_teams on plan_teams.intTeamNo=PLH.strTeamNo
Where PLH.intFactory='$factoryid'  and PLH.strTeamNo='$teamno' ";

if($styleId!="")
	$str_header .= "and PLH.intStyleId='$styleId' ";

if($from_date!="" && $to_date!="")
{
	$str_header.= " and PLH.dtmDate between '$from_date' and '$to_date' ";
}
	 
	  $results_header=$db->RunQuery($str_header);
	  $row=mysql_fetch_array($results_header);
	  
	  $cutNo=$row["strCutNo"];
	  
?>
      <tr>
        <td width="8%" align="left" >&nbsp;&nbsp;Factory</td>
        <td width="35%" align="left">:&nbsp;<?php echo $row["strName"] ?></td>
        <td width="7%" align="left" nowrap="nowrap">Order No / Style No</td>
        <td width="26%" align="left" nowrap="nowrap">&nbsp;:&nbsp;<?php echo $row["strOrderNo"].' / '.$row["strStyle"] ?></td>
        <td width="7%" align="left">Date</td>
        <td width="17%" align="left" nowrap="nowrap">:&nbsp;<?php echo $row["dtmDate"] ?></td>
      </tr>
      <tr>
        <td align="left" >&nbsp;&nbsp;Team</td>
        <td align="left">:&nbsp;<?php echo $row["strTeam"] ?></td>
        <td align="left">Color</td>
        <td align="left">&nbsp;:&nbsp;<?php echo $row["strColor"] ?></td>
        <td align="left">Division</td>
        <td align="left">:&nbsp;<?php echo $row["strDivision"] ?></td>
      </tr>
    </table></td>
  </tr>
  
   <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" >
       <tr >
         <td width="10%" height="25" class="border-top-left-fntsize12"><div align="center"><strong>Bundle No </strong></div></td>
         <td width="12%" class="border-top-left-fntsize12" ><div align="center"><strong>Size</strong></div></td>
         <td width="12%" class="border-top-left-fntsize12"><div align="center"><strong>Cut No</strong></div></td>
         <td width="17%"  class="border-top-left-fntsize12"><div align="center"><strong>Range</strong></div></td>
         <td width="8%" class="border-top-left-fntsize12"><div align="center"><strong>Shade</strong></div></td>
         <td width="8%" class="border-top-left-fntsize12"><div align="center"><strong>Qty</strong></div></td>
         <td width="8%" class="border-top-left-fntsize12"><div align="center"><strong>Size Total </strong></div></td>
         <td width="8%" class="border-top-left-fntsize12"><div align="center"><strong>Cut Total</strong></div></td>
         <td width="16%" class="border-Left-Top-right-fntsize12"><div align="center"><strong>Pattern</strong></div></td>
       </tr>
      <tr>
        <td class="border-top-fntsize12" >&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
		<td class="border-top-fntsize12">&nbsp;</td>
		<td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
		<td class="border-top-fntsize12">&nbsp;</td>
		<td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
      </tr>
      <?php
	  
	  $str_details="SELECT
productionbundledetails.strSize,
productionbundledetails.dblBundleNo,
productionbundledetails.strNoRange,
productionbundledetails.strShade,
productionlineindetail.dblQty,
productionlineindetail.dblBalQty,
productionbundleheader.strPatternNo,
productionbundleheader.strCutNo
FROM
productionlineindetail
Inner Join productionbundledetails  ON productionbundledetails.dblBundleNo = productionlineindetail.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionlineindetail.intCutBundleSerial
inner join productionlineinputheader on  productionlineindetail.intLineInputSerial=productionlineinputheader.intLineInputSerial and productionlineindetail.intLineInputYear=productionlineinputheader.intLineInputYear 
Inner Join productionbundleheader ON productionbundledetails.intCutBundleSerial = productionbundleheader.intCutBundleSerial
Where productionlineinputheader.intFactory='$factoryid' and productionlineinputheader.strTeamNo='$teamno' ";

if($styleId!="")
	$str_details .= "and productionlineinputheader.intStyleId='$styleId' ";
	
if($from_date!="" && $to_date!="")
{
	$str_details.=" and productionlineinputheader.dtmDate between '$from_date' and '$to_date' ";
}
	
	  $str_details.=" order by productionbundledetails.dblBundleNo";
	  $results_details=$db->RunQuery($str_details);
	  $p_revious="";
	  $p_cut="";
	  $tmpSize="";
	  $sizeTotal=0;
	  $cutTotal=0;
	  $tmpPattern="";
	  
	  while($row=mysql_fetch_array($results_details))
	  { 
	 
	  if($row["dblBalQty"]==0){
	  $status="Completed";
	  }
	  else{
	  $status="Pending";
	  }
	  ?>
      
	  <?php 
	  $size_break_array=explode("-",$row["strSize"]);
	  $size_break=$size_break_array[0];
	  if(($tmpSize!=$size_break) && ($tmpSize!='')){
		?>
	  <tr >
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div align="right">&nbsp;<strong><?php echo $sizeTotal; ?></strong>&nbsp;</div></td>
        <td class="normalfnt_size12" ><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12"><div class="normalfntMid"></div></td>
      </tr>
	  <?php
      $sizeTotal=0;
	  }
	  ?>
       <?php 
	  if(($tmpCut!=$row["strCutNo"]) && ($tmpCut!='')){
		?>
	  <tr >
	    <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
        <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;"><div align="right">&nbsp;&nbsp;</div></td>
	    <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div align="right">&nbsp;<strong><?php echo $cutTotal; ?></strong>&nbsp;</div></td>
	    <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    </tr>
	  <?php
	  $grandCutTotal += $cutTotal;
      $cutTotal=0;
	  }
	  ?>
	  <tr>
        <td class="normalfnt_size12"><div align="left">&nbsp;<?php echo $row["dblBundleNo"] ?></div></td>
        <td class="normalfnt_size12"><div align="left">&nbsp;<?php echo $size_break; ?></div></td>
        <td class="normalfnt_size12"><div align="left">&nbsp;<?php echo $row["strCutNo"] ?></div></td>
        <td class="normalfnt_size12"><div align="center">&nbsp;<?php echo $row["strNoRange"] ?></div></td>
        <td class="normalfnt_size12"><div align="center">&nbsp;<?php echo $row["strShade"] ?></div></td>
        <td class="normalfnt_size12"><div align="right"><?php echo $row["dblQty"] ?>&nbsp;</div></td>
        <td class="normalfnt_size12"><div align="left"></div></td>
        <td class="normalfnt_size12"><div align="right">&nbsp;</div></td>
        <td class="normalfnt_size12"><div align="left">&nbsp;<?php if($tmpPattern!=$row["strPatternNo"]){echo $row["strPatternNo"];} ?>&nbsp;</div></td>
      </tr>
	  <?php
	  	$sizeTotal +=$row["dblQty"];
	   	$cutTotal +=$row["dblQty"];  
	  	$tmpSize=$size_break;
	  	$tmpCut=$row["strCutNo"];
	  	$tmpPattern=$row["strPatternNo"];
	  }?>
      <tr >
        <td class="normalfnt_size12"  height="20" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div align="right">&nbsp;<strong><?php echo $sizeTotal; ?></strong>&nbsp;</div></td>
        <td class="normalfnt_size12"><div class="normalfntMid"></div></td>
        <td class="normalfnt_size12"><div class="normalfntMid"></div></td>
      </tr>
      <tr >
	    <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
        <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    <td class="normalfnt_size12"  style="border-top-style:dashed;border-top-width:1px;"><div align="right">&nbsp;&nbsp;</div></td>
	    <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;"><div align="right">&nbsp;<strong>
		<?php echo $cutTotal; 
		$grandCutTotal += $cutTotal;
		?></strong>&nbsp;</div></td>
	    <td class="normalfnt_size12" style="border-top-style:dashed;border-top-width:1px;">&nbsp;</td>
	    </tr>
      <tr >
        <td colspan="5" class="border-left-fntsize12"  style="border-top-style:solid;border-top-width:1px;">&nbsp;&nbsp;<b>Total</b></td>
        <td class="normalfnt_size12"  style="border-top-style:solid;border-top-width:1px;">&nbsp;</td>
        <td class="normalfnt_size12"  style="border-top-style:solid;border-top-width:1px;">&nbsp;</td>
        <td class="normalfnt_size12" style="border-top-style:solid;border-top-width:1px;"><div align="right"><strong><?php echo $grandCutTotal;?>&nbsp;</strong></div></td>
        <td class="border-right-fntsize12" style="border-top-style:solid;border-top-width:1px;">&nbsp;</td>
      </tr>
      <tr>
	    <td colspan="9" class="border-top">&nbsp;</td>
	    </tr>
    </table></td>
  </tr>
  </table></body>
</html>
