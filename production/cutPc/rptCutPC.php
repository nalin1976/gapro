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
<title>Cut PC's Transfer In Note Report</title>
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
    <td colspan="5" class="normalfnt2bldBLACKmid">Transfer In</td>
  </tr>
  
  <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td height="15">&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="6%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
<?php
$str_header="SELECT
C.strName,
PGTH.dblCutGPTransferIN,
PGTH.intGPTYear,
PGTH.intGPnumber,
PGTH.intGPYear,
PGTH.dtmGPTransferInDate,
O.strStyle,
O.strOrderNo,
BD.strDivision
FROM
productiongptinheader PGTH
Inner Join companies C ON C.intCompanyID = PGTH.intFactoryId
Inner Join productiongpheader PGH ON PGTH.intGPnumber = PGH.intGPnumber and PGTH.intGPYear = PGH.intYear
Inner Join orders O ON PGH.intStyleId = O.intStyleId
left Join buyerdivisions BD ON O.intDivisionId = BD.intDivisionId
Where PGTH.dblCutGPTransferIN='$inputSerialNumber' AND PGTH.intGPTYear='$year'
GROUP BY PGTH.intGPnumber";
$results_header=$db->RunQuery($str_header);
$row=mysql_fetch_array($results_header);
?>
      <tr>
        <td width="7%" align="left"><strong>Factory </strong> </td>
        <td align="left" colspan="3"> : <?php echo $row["strName"] ?></td>
        <td width="7%" align="left"><strong>Serial No </strong></td>
        <td width="21%" align="left"> : <?php echo $row["intGPTYear"].'/'.$row["dblCutGPTransferIN"] ?></td>
        <td width="10%" align="left"><strong>Gate Pass No </strong></td>
        <td width="14%" align="left"> :<?php echo $row["intGPYear"].'/'.$row["intGPnumber"] ?></td>
        <td width="4%" align="left"><strong>Date</strong></td>
        <td width="8%" align="left"> : <?php echo $row["dtmGPTransferInDate"] ?></td>
      </tr>
      <tr height="20">
        <td width="7%" align="left"><strong>Division </strong></td>
        <td align="left" colspan="3"> : <?php echo $row["strDivision"] ?></td>
        <td width="7%" align="left"><strong>Order No </strong></td>
        <td width="21%" align="left">: <?php echo $row["strOrderNo"] ?></td>
        <td width="10%" align="left"><strong>Style No </strong></td>
        <td colspan="3" align="left">:<?php echo $row["strStyle"] ?><strong></strong></td>
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
      </tr>
    </table></td>
  </tr>
  
   <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfntMid">
       <tr bgcolor="#FFFFFF">
         <th class="border-top-bottom-left-fntsize12"><div align="center"><b>Cut No</b></div></th>
         <td class="border-top-bottom-left-fntsize12"><div align="center"><b>Color</b></div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center"><b>Size</b></div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center"><b>Bundle No</b></div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center"><b>Range</b></div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center"><b>Shade</b></div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center"><b>Quantity / Pcs</b></div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center"><b>Remarks</b></div></td>
         <td class="border-All-fntsize12"><div align="center"><b>Status</b></div></td>
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
	  
$str_details="SELECT
PBD.strSize,
PBD.dblBundleNo,
PGD.intCutBundleSerial,
PBD.strNoRange,
PBD.strShade,
PGTD.dblQty,
PGD.dblBalQty,
PBH.strCutNo,
PBH.strColor,
PGTD.strRemarks
FROM productionbundledetails PBD 
Inner Join productiongpdetail PGD ON PBD.intCutBundleSerial = PGD.intCutBundleSerial
Inner Join productiongptinheader PGTH ON PGTH.intGPnumber = PGD.intGPnumber and PGTH.intGPYear = PGD.intYear 
Inner Join productiongptindetail PGTD ON PGTD.dblCutGPTransferIN = PGTH.dblCutGPTransferIN AND PGTD.intGPTYear = PGTH.intGPTYear 
Inner Join productionbundleheader PBH ON PBD.intCutBundleSerial = PBH.intCutBundleSerial
Where PGTD.dblCutGPTransferIN='$inputSerialNumber' AND PGTD.intGPTYear='$year' 
GROUP BY PBD.dblBundleNo , PGD.intCutBundleSerial ";
	  $results_details=$db->RunQuery($str_details);
	  $p_revious="";
	  $p_cut="";
	  while($row=mysql_fetch_array($results_details))
	  { 
	  if($row["dblBalQty"]==0){
	  $status="Completed";
	  }
	  else{
	  $status="Pending";
	  }
	  ?>
	  <tr>
      
      
        <td class="border-left-fntsize12" align="center"><div class="normalfntLeft">&nbsp;<?php echo $row["strCutNo"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strColor"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["dblBundleNo"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["dblBundleNo"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strNoRange"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strShade"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntRite"><?php echo $row["dblQty"] ?>&nbsp;</div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strRemarks"] ?>&nbsp;</div></td>
        <td class="border-left-right-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $status ?></div></td>
      </tr>
	  <?php }?>
      <tr>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-fntsize12">&nbsp;</td>
	    <td class="border-left-right-fntsize12">&nbsp;</td>
	    </tr>
	  <tr>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
	    <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  </table></body>
</html>
