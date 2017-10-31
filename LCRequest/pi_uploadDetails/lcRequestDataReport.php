<?php
 session_start();
 $backwardseperator = "../../";
	include "../../authentication.inc";
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
$orderNo = $_GET["orderNo"];
$supplier = $_GET["supplier"];
$oritRefNo = $_GET["oritRefNo"];
$piNo = $_GET["piNo"];
$factory = $_GET["factory"];
$shipMode = $_GET["shipMode"];
$type = $_GET["type"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | L/C Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="950" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td class="head2BLCK">Import Item List</td>
  </tr>
  <tr>
    <td><table  width="1100" border="0" cellspacing="1" bgcolor="#000000"cellpadding="2" id="tblMain">
         <thead>
          <tr  bgcolor="#CCCCCC" class="normalfntMid">
            <th>Supplier</th>
            <th >Factory</th>
            <th>PO No</th>
            <th>PI No</th>
            <th>Orit Ref<br/>No</th>
            <th>Supplier<br/>PINo</th>
            <th>DN#/EN#/Release #</th>
            <th>Ship Mode</th>
            <th>Item Code</th>
            <th>Color</th>
            <th>Size</th>
            <th>Qty<br/>(Pcs)</th>
            <th>Amount<br/>(USD)</th>
            <th>G.W.<br/>(KGS)</th>
            <th>Meas.<br/>(CM)</th>
            <th>Payment<br/>(Y/N)</th>
            <th>Handle<br/>By</th>
            <th>Ready<br/>Date</th>
            <th>PI Confirm<br/>Date</th>
            <th>Handover<br/>Date</th>
            <th>Remarks</th>
       	   </tr>
          </thead>
          <?php 
		  
		  if($type == 'M')
		  {
			  $sql = "select * from lc_supplierdetails where strOrderNo<>'' ";
				if($orderNo != '')
					$sql .= " and  strOrderNo='$orderNo' ";
				if($supplier !='')
					$sql .= " and supplier like '%$supplier%' ";
				if($oritRefNo != '')
					$sql .= " and strOritRefNo = '$oritRefNo' ";
				if($piNo != '')
					$sql .= " and strPINo = '$piNo' ";
				if($factory != '')
					$sql .= " and strfactory = '$factory' ";
				if($shipMode != '')
					$sql .= " and strShipMode = '$shipMode' ";			
		}
		else if($type == 'I')
		{
			$LCno = $_GET["LCno"];
			$arrLCNo = explode('/',$LCno);
			
			$sql = " select lc.* from lc_supplierdetails lc inner join lcrequest_piallodetails lcd on 
lc.intRecordNo = lcd.intRecordNo 
where lcd.intLCRequestNo='".$arrLCNo[1]."' and lcd.intRequestYear = '".$arrLCNo[0]."' ";
		}
	$result = $db->RunQuery($sql);	

	while($row = mysql_fetch_array($result))
	{	
		  ?>
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td><?php echo $row["supplier"]; ?></td>
        <td height="20" ><?php echo $row["strfactory"]; ?></td>
        <td ><?php echo $row["strOrderNo"]; ?></td>
        <td ><?php echo $row["strPINo"]; ?></td>
        <td ><?php echo $row["strOritRefNo"]; ?></td>
        <td ><?php echo $row["strSupplierPINo"]; ?></td>
        <td ><?php echo $row["strDNNo"]; ?></td>
        <td ><?php echo $row["strShipMode"]; ?></td>
        <td ><?php echo $row["strItemCode"]; ?></td>
        <td ><?php echo $row["strColor"]; ?></td>
        <td ><?php echo $row["strSize"]; ?></td>
        <td class="normalfntRite"><?php echo $row["dblQty"]; ?></td>
        <td class="normalfntRite"><?php echo $row["dblAmount"]; ?></td>
        <td><?php echo $row["strGW"]; ?></td>
        <td class="normalfntRite"><?php echo $row["dblCM"]; ?></td>
        <td><?php echo $row["strPayment"]; ?></td>
        <td ><?php echo $row["strHandleBy"]; ?></td>
        <td ><?php echo $row["dtmReadyDate"]; ?></td>
        <td ><?php echo $row["dtmPIConfirmDate"]; ?></td>
        <td ><?php echo $row["dtmHandoverDate"]; ?></td>
        <td ><?php echo $row["strRemarks"]; ?></td>
        </tr>
      <?php 
	  }
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
