<?php
	session_start();
	include "../../Connector.php";	
	$SerialNumber=$_GET["SerialNumber"];
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
<title>GaPro | Wash Ready Report</title>
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
    <td colspan="5" class="normalfnt2bldBLACKmid">Wash Ready</td>
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
        </tr>
<?php
	  $str_header="SELECT
PWRH.intFactory,
PWRH.intStyleId,
PWRH.strCutNo,
PWRH.dtmDate,
PWRH.intWashreadySerial,
C.strName,
O.strOrderNo,
buyerdivisions.strDivision
FROM
productionwashreadyheader AS PWRH
Inner Join companies AS C ON C.intCompanyID = PWRH.intFactory
Inner Join orders AS O ON O.intStyleId = PWRH.intStyleId
left Join buyerdivisions ON O.intBuyerID = buyerdivisions.intBuyerID AND O.intDivisionId = buyerdivisions.intDivisionId
Where PWRH.intWashreadySerial='$SerialNumber' AND PWRH.intWashReadyYear='$year'";
	  $results_header=$db->RunQuery($str_header);
	  $row=mysql_fetch_array($results_header);
?>
      <tr>
        <td width="10%" align="left">&nbsp;&nbsp;<strong>Factory </strong> </td>
        <td width="25%" align="left"> :<?php echo $row["strName"] ?></td>
        <td width="7%" align="left"><strong>Style No </strong></td>
        <td width="21%" align="left"> :<?php echo $row["strOrderNo"] ?></td>
        <td width="5%" align="left"><strong>Date</strong></td>
        <td width="11%" align="left"> :<?php echo $row["dtmDate"] ?></td>
        <td width="8%" align="left"><strong>Serial No</strong></td>
        <td width="13%" align="left"> :<?php echo $row["intWashreadySerial"] ?></td>
		</tr>
      <tr>
        <td width="10%" align="left">&nbsp;&nbsp;<strong>Division </strong> </td>
        <td width="25%" align="left"> :<?php echo $row["strDivision"] ?></td>
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
         <td width="13%" height="25" class="border-top-bottom-left-fntsize12"><div align="center">Cut No </div></td>
         <td width="13%" class="border-top-bottom-left-fntsize12"><div align="center">Color </div></td>
         <td width="13%" class="border-top-bottom-left-fntsize12"><div align="center">Size </div></td>
         <td width="16%" class="border-top-bottom-left-fntsize12"><div align="center">Bundle No </div></td>
         <td  width="17%" class="border-top-bottom-left-fntsize12"><div align="center">Range</div></td>
         <td  width="18%" class="border-top-bottom-left-fntsize12"><div align="center">Shade</div></td>
         <td  width="10%" class="border-top-bottom-left-fntsize12"><div align="center">Quantity / Pcs </div></td>
         <td  width="13%" class="border-All-fntsize12"><div align="center">Status </div></td>
       </tr>
      <tr>
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
productionbundledetails.strSize,
productionbundledetails.dblBundleNo,
productionbundledetails.strNoRange,
productionbundledetails.strShade,
productionwashreadydetail.dblQty,
productionbundleheader.strCutNo,
productionwashreadydetail.dblBalQty,
productionbundleheader.strColor
FROM
productionwashreadydetail
Inner Join productionbundledetails ON productionbundledetails.dblBundleNo = productionwashreadydetail.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial
Inner Join productionbundleheader ON productionbundledetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial AND productionbundledetails.intCutBundleSerial = productionbundleheader.intCutBundleSerial
Where intWashreadySerial='$SerialNumber' AND intWashReadyYear='$year' GROUP BY productionbundledetails.intCutBundleSerial, productionbundledetails.dblBundleNo";
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
      </tr>
    </table></td>
  </tr>
  </table></body>
</html>
