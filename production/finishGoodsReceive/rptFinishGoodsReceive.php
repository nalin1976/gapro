<?php
	session_start();
	include "../../Connector.php";	
	$SerialNumber=$_GET["SerialNumber"];
	$year=$_GET["intYear"];
	$backwardseperator 	= "../../";	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	$LoginUser="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Finish Goods Receive Report</title>
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
    <td colspan="5" class="normalfnt2bldBLACKmid">Wash Receive Report</td>
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
PFGH.strTComCode,
PFGH.intStyleNo,
PFGH.dblTransInNo,
PFGH.intGPTYear,
PFGH.dtmTransInDate,
C.strName,
O.strOrderNo,
O.strStyle,
buyerdivisions.strDivision,
PFGH.strRemarks,
PFGH.intUser,
concat(PFGH.intGPYear,'/',PFGH.dblGatePassNo) as GPNO
FROM
productionfinishedgoodsreceiveheader AS PFGH
Inner Join companies AS C ON C.intCompanyID = PFGH.strTComCode
Inner Join orders AS O ON O.intStyleId = PFGH.intStyleNo
left Join buyerdivisions ON O.intBuyerID = buyerdivisions.intBuyerID AND O.intDivisionId = buyerdivisions.intDivisionId
Where PFGH.dblTransInNo='$SerialNumber' AND PFGH.intGPTYear='$year'";

	  $results_header=$db->RunQuery($str_header);
	  $row=mysql_fetch_array($results_header);
	  $LoginUser=$row['intUser'];
?>
      <tr>
        <td width="10%" align="left">&nbsp;<strong>Factory </strong> </td>
        <td width="29%" align="left"> :<?php echo $row["strName"] ?></td>
        <td width="8%" align="left"><strong>PO No </strong></td>
        <td width="14%" align="left"> :<?php echo $row["strOrderNo"] ?></td>
        <td width="9%" align="left"><strong>Date</strong></td>
        <td width="13%" align="left"> :<?php echo substr($row["dtmTransInDate"],0,10); ?></td>
        <td width="8%" align="left"><strong>Serial No</strong></td>
        <td width="9%" align="left"> :<?php echo $row["intGPTYear"].'/'.$row["dblTransInNo"]; ?></td>
		</tr>
      <tr>
        <td width="10%" align="left">&nbsp;<strong>Division </strong> </td>
        <td width="29%" align="left"> :<?php echo $row["strDivision"] ?></td>
        <td><strong>Style No</strong></td>
        <td> :<?php echo $row["strStyle"]; ?></td>
        <td><strong>GatePass No</strong></td>
        <td>:<?php echo $row['GPNO'];?></td>
        <td><strong>Time</strong></td>
        <td>:<?php echo substr($row["dtmTransInDate"],10,16);?></td>
        </tr>
        <tr>
        <td width="10%" align="left">&nbsp;<strong>Remarks </strong> </td>
        <td colspan="7"> :<?php echo $row["strRemarks"]; ?></td>
        </tr>
    </table></td>
  </tr>
  
   <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0" rules="all">
       <tr>
         <td class="normalfntMid">Cut No</td>
         <td class="normalfntMid">Color</td>
         <td class="normalfntMid">Size</td>
        <!-- <td   class="normalfntMid">Cut No</td>-->
         <td class="normalfntMid">Bundle No</td>
         <td  class="normalfntMid">Range</td>
         <td class="normalfntMid">Shade</td>
         <td  class="normalfntMid" width="10%">Quantity / Pcs</td>
         <td class="normalfntMid">Remarks</td>
         <td class="normalfntMid" style="display:none;">Status</td>
       </tr>
      <tr>
        <td colspan="10">&nbsp;</td>
      </tr>
      <?php
	  $r=0;
	   $str_details="SELECT productionbundledetails.strSize, productionbundledetails.dblBundleNo, 
productionbundledetails.strNoRange, productionbundledetails.strShade, 
productionbundleheader.strCutNo, productionfinishedgoodsreceivedetails.lngRecQty, 
productionfinishedgoodsreceivedetails.dblBalQty, productionbundleheader.strColor, 
productionfinishedgoodsreceivedetails.strRemarks
FROM
productionfinishedgoodsreceivedetails
JOIN productionbundledetails ON productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial
JOIN productionbundleheader ON productionbundledetails.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial AND productionbundledetails.intCutBundleSerial = productionbundleheader.intCutBundleSerial

Where  dblTransInNo='$SerialNumber' AND intGPTYear='$year' GROUP BY productionbundledetails.intCutBundleSerial, productionbundledetails.dblBundleNo";
 //echo $str_details;
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
        <td class="normalfnt"><?php echo $row["strCutNo"] ?></td>
        <td class="normalfnt"><?php echo $row["strColor"] ?></td>
        <td class="normalfnt"><?php echo $row["strSize"] ?></td>
       <!-- <td class="normalfnt"><?php //echo $row["strCutNo"] ?></td>-->
        <td class="normalfnt"><?php echo $row["dblBundleNo"] ?></td>
        <td class="normalfnt"><?php echo $row["strNoRange"] ?></td>
        <td class="normalfnt"><?php echo $row["strShade"] ?></td>
        <td class="normalfntRite"><?php $r= $r+$row["lngRecQty"]; echo $row["lngRecQty"]; ?>&nbsp;</td>
        <td class="normalfnt"><?php echo $row["strRemarks"] ?></td>
        <td class="normalfnt" style="display:none;"><?php echo $status ?></td>
      </tr>
	  <?php }?>
      <tr>
     	<td colspan="6">&nbsp;</td>
	    <td colspan="1" class="normalfntR"><?php echo $r;?>&nbsp;</td>
	   	<td colspan="2">&nbsp;</td>
       </tr>
	   <tr>
            <td colspan="10">
                <table width="100%">
                	<tr>
                    	<td width="10%" class="normalfnt">&nbsp;</td>
                    	<td width="15%" class="normalfntMid"><?php echo getUser($LoginUser);?></td>
                        <td width="75%" class="normalfnt">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td class="normalfnt">&nbsp;</td>
                    	<td class="normalfntMid">.............................</td>
                        <td class="normalfnt">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td class="normalfnt">&nbsp;</td>
                    	<td class="normalfntMid">Received By</td>
                        <td class="normalfnt">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td class="normalfnt">&nbsp;</td>
                    	<td class="normalfntMid"><?php echo date('d-m-Y');?></td>
                        <td class="normalfnt">&nbsp;</td>
                    </tr>
                </table>
            </td>
       </tr>
    </table></td>
  </tr>
  </table></body>
</html>
<?php 
function getUser($id){
global $db;
$sql="select ur.Name from useraccounts ur where ur.intUserID='$id'";
$res=$db->RunQuery($sql);
$row=mysql_fetch_array($res);
return $row['Name'];
	
}?>