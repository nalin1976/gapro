<?php
	session_start();
	include "../../Connector.php";	
	$inputSerialNumber=$_GET["inputSerialNumber"];
	$year=$_GET["intYear"];
	$backwardseperator 	= "../../";	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
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
</style>
</head>

<body>

<table width="950" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">Line Input</td>
  </tr>
  
  <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
<?php
	 /* echo $str_header="select PLH.*,C.strName,O.strOrderNo from productionlineinputheader PLH inner join companies C on C.intCompanyID=PLH.intFactory inner join orders O on O.intStyleId=PLH.intStyleId Where PLH.intLineInputSerial='$inputSerialNumber' AND PLH.intLineInputYear='$year'";*/
	  
$str_header="SELECT
PLH.intLineInputSerial,
PLH.intLineInputYear,
PLH.dtmDate,
PLH.intFactory,
PT.strTeam,
PLH.intStyleId,
PLH.strCutNo,
PLH.strPatternNo,
PLH.dblTotQty,
PLH.dblBalQty,
PLH.intStatus,
C.strName,
O.strOrderNo,
O.intDivisionId,
PBH.strColor,
BD.strDivision
FROM
productionlineinputheader AS PLH
Inner Join companies C ON C.intCompanyID = PLH.intFactory
Inner Join orders O ON O.intStyleId = PLH.intStyleId
Inner Join productionbundleheader PBH ON PLH.intStyleId = PBH.intStyleId AND PLH.strCutNo = PBH.strCutNo
Inner Join buyerdivisions BD ON O.intDivisionId = BD.intDivisionId
inner join plan_teams PT on PT.intTeamNo=PLH.strTeamNo
Where PLH.intLineInputSerial='$inputSerialNumber' AND PLH.intLineInputYear='$year'";

	  $results_header=$db->RunQuery($str_header);
	  $row=mysql_fetch_array($results_header);
	  
	  $cutNo=$row["strCutNo"];
?>
      <tr>
        <td width="9%" align="left"><strong>Factory </strong> </td>
        <td width="30%" align="left">:<?php echo $row["strName"] ?></td>
        <td width="7%" align="left"><strong>Order No </strong></td>
        <td width="24%" align="left">:<?php echo $row["strOrderNo"] ?></td>
        <td width="5%" align="left"><strong>Cut No</strong></td>
        <td width="10%" align="left">:<?php echo $row["strCutNo"] ?></td>
        <td width="7%" align="left"><strong>Serial No</strong></td>
        <td width="8%" align="left">:<?php echo $row["intLineInputSerial"] ?></td>
        </tr>
      <tr>
        <td align="left"><strong>Division</strong></td>
        <td align="left">:<?php echo $row["strDivision"] ?></td>
        <td align="left"><strong>Color </strong></td>
        <td align="left">:<?php echo $row["strColor"] ?></td>
        <td align="left"><strong><strong>Team</strong></strong></td>
        <td align="left">:<?php echo $row["strTeam"] ?></td>
        <td align="left"><strong>Date</strong></td>
        <td align="left">:<?php echo $row["dtmDate"] ?></td>
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
        </tr>
    </table></td>
  </tr>
  
   <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
       <tr bgcolor="#CCCCCC">
         <td class="border-top-bottom-left-fntsize12"><div align="center">Bundle No </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Size </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Cut No </div></td>
         <td  class="border-top-bottom-left-fntsize12"><div align="center">Range</div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Shade</div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Quantity / Pcs </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Size Total </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Cut Total </div></td>
         <td class="border-All-fntsize12"><div align="center">Pattern</div></td>
       </tr>
      <tr>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
		<td class="border-top-left-fntsize12">&nbsp;</td>
		<td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-top-left-fntsize12">&nbsp;</td>
		<td class="border-top-left-fntsize12">&nbsp;</td>
		<td class="border-top-left-fntsize12">&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
      </tr>
      <?php
$str_details="SELECT DISTINCT
PBD.strSize,
PBD.dblBundleNo,
PBD.strNoRange,
PBD.strShade,
PLD.dblQty,
PLD.dblBalQty,
PBH.strPatternNo
FROM
productionbundledetails PBD
Inner Join productionlineindetail PLD ON PBD.dblBundleNo = PLD.dblBundleNo AND PBD.intCutBundleSerial = PLD.intCutBundleSerial
Inner Join productionbundleheader PBH ON PBD.intCutBundleSerial = PBH.intCutBundleSerial
Where intLineInputSerial='$inputSerialNumber' AND intLineInputYear='$year'
order by PBD.dblBundleNo,PBD.strSize ASC";

	  $results_details=$db->RunQuery($str_details);
	  $p_revious="";
	  $p_cut="";
	  $tmpSize="";
	  $sizeTotal=0;
	  $cutTotal=0;
	  $tmpPattern="";
	  
	  while($row=mysql_fetch_array($results_details))
	  { 
	  	$cutTotal +=$row["dblQty"];
	  	if($row["dblBalQty"]==0)
	  		$status="Completed";
	 	 else
	  		$status="Pending";	  	
	  ?>
      
<?php 
		if(($tmpSize!=$row["strSize"]) && ($tmpSize!='')){
?>
	  <tr bgcolor="#EBEBEB">
        <td class="border-left-fntsize12"><div class="normalfntMid"></div></td>
        <td class="border-left-fntsize12"><div class="normalfntMid"></div></td>
        <td class="border-left-fntsize12"><div class="normalfntMid"></div></td>
        <td class="border-left-fntsize12"><div class="normalfntMid"></div></td>
        <td class="border-left-fntsize12"><div class="normalfntMid"></div></td>
        <td class="border-left-fntsize12"><div class="normalfntMid"></div></td>
        <td class="border-left-fntsize12"><div class="normalfntRite">&nbsp;<?php echo $sizeTotal; ?>&nbsp;</div></td>
        <td class="border-left-fntsize12"><div class="normalfntMid"></div></td>
        <td class="border-left-right-fntsize12"><div class="normalfntMid"></div></td>
      </tr>
	  <?php
      $sizeTotal=0;
	  }
	  ?>
	  <tr>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["dblBundleNo"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strSize"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $cutNo ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strNoRange"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strShade"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntRite"><?php echo $row["dblQty"] ?>&nbsp;</div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft"></div></td>
        <td class="border-left-fntsize12"><div class="normalfntRite">&nbsp;</div></td>
        <td class="border-left-right-fntsize12"><div class="normalfntLeft">&nbsp;<?php if($tmpPattern!=$row["strPatternNo"]){echo $row["strPatternNo"];} ?>&nbsp;</div></td>
      </tr>
	  <?php
	  $sizeTotal +=$row["dblQty"];  
	  $tmpSize=$row["strSize"];
	  $tmpPattern=$row["strPatternNo"];
	  
	  }?>
      <tr bgcolor="#CCCCCC">
	    <td class="border-bottom-left-fntsize12">&nbsp;</td>
	    <td class="border-bottom-left-fntsize12">&nbsp;</td>
	    <td class="border-bottom-left-fntsize12">&nbsp;</td>
	    <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-left-fntsize12"></td>
	    <td class="border-bottom-left-fntsize12">&nbsp;</td>
	    <td class="border-bottom-left-fntsize12"><div class="normalfntRite">&nbsp;<?php echo $sizeTotal; ?>&nbsp;</div></td>
	    <td class="border-bottom-left-fntsize12"><div class="normalfntRite">&nbsp;<?php echo $cutTotal; ?>&nbsp;</div></td>
	    <td class="border-Left-bottom-right-fntsize12">&nbsp;</td>
	    </tr>
    </table></td>
  </tr>
  </table>
</body>
</html>