<?php 
session_start();
	include "../Connector.php";	
	$companyId = $_SESSION["FactoryID"];
	$backwardseperator = "../";
	$No = $_GET["No"];
	
	$arrNo = explode('/',$No);
	$serialNo = $arrNo[1];
	$serialYear = $arrNo[0];
	
	$sql_h = " SELECT LIH.intStatus,LIH.intCompanyId,DATE(LIH.dtmDate) AS dtmDate ,MS.strName AS MainStore
FROM itemwiseliability_header LIH INNER JOIN mainstores MS ON LIH.intMainStoreID = MS.strMainID
WHERE LIH.intSerialNo='$serialNo' AND LIH.intSerialYear='$serialYear' ";
	$result_h =$db->RunQuery($sql_h);
	$rowH = mysql_fetch_array($result_h);
	
	$report_companyId	= $rowH["intCompanyId"];
	$intStatus 			= $rowH["intStatus"];
	$dtmDate			= $rowH["dtmDate"];
	$MainStore			= $rowH["MainStore"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | Liability Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="frmItemWiseLiability.js" type="text/javascript"></script>
</head>

<body>
 <?php if($intStatus==10) {?>
  <div style="position:absolute;top:50px;left:250px;"><img src="../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php }?>
<table width="900" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td><?php include '../reportHeader.php'; ?></td>
  </tr>
  <tr>
    <td  height="36"  class="head2">Liability Report</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="10%" class="normalfnth2B">Liability No </td>
        <td width="41%" class="normalfnt"><?php echo $No; ?></td>
        <td width="9%" class="normalfnth2B">Main Store</td>
        <td width="40%" class="normalfnt"><?php echo $MainStore; ?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Date </td>
        <td class="normalfnt"><?php echo $dtmDate; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
  <tr bgcolor="#CCCCCC" class="normalfntMid">
    <th width="32%" height="20">Item Description</th>
        <th width="17%">Order No</th>
        <th width="10%">Buyer PO No</th>
        <th width="8%">Color</th>
        <th width="8%">Size</th>
        <th width="6%">Unit</th>
        <th width="7%">Qty</th>
        <th width="6%">GRN No </th>
        <th width="6%">GRN Type </th>
  </tr>
   <?php 
	  $sql = " SELECT MIL.strItemDescription,O.strOrderNo,LID.strBuyerPoNo,LID.strColor,LID.strSize,LID.strUnit,
LID.dblQty,CONCAT(LID.intGRNYear,'/',LID.intGRNNo) AS GRNno,LID.strGRNType
FROM itemwiseliability_detail LID INNER JOIN orders O ON O.intStyleId = LID.intStyleId
INNER JOIN matitemlist MIL ON MIL.intItemSerial = LID.intMatDetailId
WHERE LID.intSerialNo='$serialNo' AND LID.intSerialYear='$serialYear'  
ORDER BY MIL.strItemDescription ";
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$grnType = $row["strGRNType"];
			if($grnType =='S')
				$strGRNType = 'Style';
			if($grnType == 'B')	
				$strGRNType = 'Bulk';
	  ?>
  <tr bgcolor="#FFFFFF" class="normalfnt">
   <td height="20"><?php echo $row["strItemDescription"]; ?></td>
        <td><?php echo $row["strOrderNo"]; ?></td>
        <td><?php echo $row["strBuyerPoNo"]; ?></td>
        <td><?php echo $row["strColor"]; ?></td>
        <td><?php echo $row["strSize"]; ?></td>
        <td><?php echo $row["strUnit"]; ?></td>
        <td class="normalfntRite"><?php echo $row["dblQty"]; ?></td>
        <td><?php echo $row["GRNno"]; ?></td>
        <td><?php echo $strGRNType; ?></td>

  </tr>
   <?php 
	  }
	  ?>
</table>
</td>
  </tr>
</table>
</body>
</html>
