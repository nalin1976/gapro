<?php
	session_start();
	include "../../Connector.php";	
	$OutputSerialNumber=$_GET["OutputSerialNumber"];
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
<title>GaPro | Line Output Report</title>
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
    <td colspan="5" class="normalfnt2bldBLACKmid">Line Output</td>
  </tr>
  
  <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td height="15">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="0%">&nbsp;</td>
        <td width="0%">&nbsp;</td>
      </tr>
<?php
	  $str_header="SELECT
PLOH.intFactory,
PLOH.intStyleId,
PLOH.strCutNo,
PLOH.dtmDate,
PLOH.intLineOutputSerial,
PLOH.intLineOutputYear,
O.strOrderNo,
O.strStyle, 
C.strName,
buyerdivisions.strDivision
FROM
productionlineoutputheader AS PLOH
Inner Join orders AS O ON O.intStyleId = PLOH.intStyleId
Inner Join companies AS C ON C.intCompanyID = PLOH.intFactory
left Join buyerdivisions ON O.intBuyerID = buyerdivisions.intBuyerID AND O.intDivisionId = buyerdivisions.intDivisionId
	  Where PLOH.intLineOutputSerial='$OutputSerialNumber' AND PLOH.intLineOutputYear='$year'";
	  $results_header=$db->RunQuery($str_header);
	  $row=mysql_fetch_array($results_header);
?>
      <tr>
        <td width="10%" align="left"><strong>Factory </strong> </td>
        <td width="29%" align="left"><strong>:</strong> <?php echo $row["strName"] ?></td>
        <td width="8%" align="left"><strong>Order No </strong></td>
        <td width="19%" align="left"><strong>:</strong> <?php echo $row["strOrderNo"] ?></td>
        <td width="7%" align="left"><strong>Serial No</strong></td>
        <td width="13%" align="left"><strong>:</strong> <?php echo $row["intLineOutputYear"].'/'.$row["intLineOutputSerial"] ?></td>
        <td width="5%" align="left"><strong>Date</strong></td>
        <td width="9%" align="left"><strong> :</strong> <?php echo $row["dtmDate"] ?></td>
      </tr>
      <tr>
        <td width="10%" align="left"><strong>Division </strong> </td>
        <td width="29%" align="left"><strong> :</strong> <?php echo $row["strDivision"] ?></td>
        <td><strong>Style No</strong></td>
        <td><strong> : </strong> <?php echo $row["strStyle"] ?></td>
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
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td height="25" class="border-top-bottom-left-fntsize12"><div align="center">Cut No </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Color </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Size </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Bundle No </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Range</div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Shade</div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Quantity / Pcs </div></td>
         <td class="border-top-bottom-left-fntsize12"><div align="center">Remarks </div></td>
         <td class="border-All-fntsize12"><div align="center">Status </div></td>
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
productionlineoutdetail.dblQty,
productionlineoutdetail.dblBalQty,
productionlineoutdetail.dblBundleNo,
productionbundledetails.strSize,
productionbundledetails.strNoRange,
productionbundledetails.strShade,
productionbundleheader.strCutNo,
productionbundleheader.strColor,
productionlineoutdetail.strRemarks
FROM
productionlineoutdetail
Inner Join productionbundledetails ON productionlineoutdetail.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionlineoutdetail.dblBundleNo = productionbundledetails.dblBundleNo
Inner Join productionbundleheader ON productionbundledetails.intCutBundleSerial = productionbundleheader.intCutBundleSerial
WHERE intLineOutputSerial='$OutputSerialNumber' AND intLineOutputYear='$year' GROUP BY productionbundledetails.intCutBundleSerial, productionbundledetails.dblBundleNo";
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
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strCutNo"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strColor"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["strSize"] ?></div></td>
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
        <td class="border-top-fntsize12">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  </table></body>
</html>
