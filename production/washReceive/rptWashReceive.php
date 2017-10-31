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
<title>Wash Receive</title>
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
    <td colspan="5" class="normalfnt2bldBLACKmid">Wash Receive</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
<?php
	$sql = "SELECT  wm.strColor,C.strName,O.strStyle ,O.strOrderNo ,O.intQty, ws.dblQty, O.intCompanyID,ws.intStyleId, ws.dtmReceiveDate,intWashFinRecNO 
			FROM wash_finishreceive ws 
			INNER JOIN orders AS O  ON O.intStyleId=ws.intStyleId
			INNER JOIN was_machineloadingdetails AS wm ON O.intStyleId=wm.intStyleId
			INNER JOIN companies AS C ON c.intCompanyID=O.intCompanyID
			WHERE ws.intWashFinRecNO='$SerialNumber' AND ws.intWashFinRecYear='$year' GROUP BY ws.intStyleId;";
	  $results_header=$db->RunQuery($sql);
	  $row=mysql_fetch_array($results_header);
?>
      <tr>
        <td width="7%" align="left">&nbsp;&nbsp;<strong>Factory </strong> </td>
        <td width="20%" align="left"><strong> :<?php echo $row["strName"] ?></strong></td>
        <td width="7%" align="left"><strong>Style</strong></td>
        <td width="13%" align="left"><strong> :<?php echo $row["strStyle"] ?></strong></td>
        <td width="7%" align="left"><strong>Date</strong></td>
        <td width="13%" align="left"><strong> :<?php echo $row["dtmReceiveDate"] ?></strong></td>
        <td width="7%" align="left"><strong>Serial No</strong></td>
        <td width="6%" align="left"><strong> :<?php echo $row["intWashFinRecNO"] ?></strong></td>
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
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="20%" class="border-top-bottom-left-fntsize12"><div align="center">Color </div></td>
         <td width="18%" class="border-top-bottom-left-fntsize12"><div align="center">Order No </div></td>
         <td  width="19%" class="border-top-bottom-left-fntsize12"><div align="center">Order Qty</div></td>
         <td  width="18%" class="border-top-bottom-left-fntsize12"><div align="center">Wash Qty</div></td>
         <td  width="12%" class="border-top-bottom-left-fntsize12"><div align="center">Receive Qty </div></td>
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
	  $styleId=$row["intStyleId"];
	  $color=$row["strColor"];
	  $orderNo=$row["strOrderNo"];
	  $orderQty=$row["intQty"];
	  $rcvQty=$row["dblQty"];
	  
	  
	  
	 $sql3 = "SELECT  wm.strColor,C.strName,O.strStyle ,O.strOrderNo ,O.intQty, sum(ws.dblIQty)
			FROM was_issuedheader ws 
			INNER JOIN orders AS O  ON O.intStyleId=ws.intStyleId
			INNER JOIN was_machineloadingdetails AS wm ON O.intStyleId=wm.intStyleId
			INNER JOIN companies AS C ON c.intCompanyID=O.intCompanyID
			WHERE ws.intStyleId='$styleId' AND wm.strColor='$color' GROUP BY ws.intStyleId;";
			
	$result3 = $db->RunQuery($sql3);
	$row=mysql_fetch_array($result3);
	  ?>
	  <tr>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $color ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $orderNo?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $orderQty ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $row["sum(ws.dblIQty)"] ?></div></td>
        <td class="border-left-fntsize12"><div class="normalfntRite"><?php echo $rcvQty ?>&nbsp;</div></td>
        <td class="border-left-right-fntsize12"><div class="normalfntLeft">&nbsp;<?php echo $status ?></div></td>
      </tr>
      <tr>
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
      </tr>
    </table></td>
  </tr>
  </table></body>
</html>
