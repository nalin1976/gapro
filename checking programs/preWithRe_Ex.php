<?php
include "../Connector.php";

header('Content-Type: application/vnd.ms-word');
header('Content-Disposition: attachment;filename="PreWithRe.xls"');
?>
<html>
<head>
</head>

<link type="text/css"  href="../css/erpstyle.css" rel="stylesheet" />
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="normalfntMid">
  <tr>
    <th width="104" >Order No</th>
    <th width="47">Style No</th>
    <th width="19">FABRIC</th>
    <th width="20">HIS_FABRIC</th>
    <th width="20">ACCESSORIES</th>
    <th width="20">HIS_ACCESSORIES</th>
    <th width="20">PACKING MATERIALS</th>
    <th width="20">HIS_PACKING MATERIALS</th>
    <th width="20">SERVICES</th>
    <th width="20">HIS_SERVICES</th>
    <th width="20">OTHERS</th>
    <th width="20">HIS_OTHERS</th>
    <th width="20">WASHING</th>
    <th width="20">HIS_WASHING</th>
  </tr>
<?php
$sql="SELECT DISTINCT o.intStyleId,o.strOrderNo,o.strStyle,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM orderdetails OD INNER JOIN matitemlist MIL ON MIL.intItemSerial=OD.intMatDetailID WHERE  OD.intStyleId=o.intStyleId AND MIL.intMainCatID=1) AS preFabric,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM orderdetails OD INNER JOIN matitemlist MIL ON MIL.intItemSerial=OD.intMatDetailID WHERE  OD.intStyleId=o.intStyleId AND MIL.intMainCatID=2) AS preAcc,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM orderdetails OD INNER JOIN matitemlist MIL ON MIL.intItemSerial=OD.intMatDetailID WHERE  OD.intStyleId=o.intStyleId AND MIL.intMainCatID=3) AS prePacking,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM orderdetails OD INNER JOIN matitemlist MIL ON MIL.intItemSerial=OD.intMatDetailID WHERE  OD.intStyleId=o.intStyleId AND MIL.intMainCatID=4) AS preServi,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM orderdetails OD INNER JOIN matitemlist MIL ON MIL.intItemSerial=OD.intMatDetailID WHERE  OD.intStyleId=o.intStyleId AND MIL.intMainCatID=5) AS preOther,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM orderdetails OD INNER JOIN matitemlist MIL ON MIL.intItemSerial=OD.intMatDetailID WHERE  OD.intStyleId=o.intStyleId AND MIL.intMainCatID=6) AS preWashing,

(SELECT SUM(dblTotalValue) AS dblTotalValue FROM history_orderdetails HOD INNER JOIN matitemlist MIL ON MIL.intItemSerial=HOD.intMatDetailID WHERE HOD.intStyleId=o.intStyleId AND MIL.intMainCatID=1 AND intApprovalNo IN ( SELECT MAX(intApprovalNo) FROM history_orderdetails HOD WHERE HOD.intStyleId=o.intStyleId)) AS hisFabric,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM history_orderdetails HOD INNER JOIN matitemlist MIL ON MIL.intItemSerial=HOD.intMatDetailID WHERE HOD.intStyleId=o.intStyleId AND MIL.intMainCatID=2 AND intApprovalNo IN ( SELECT MAX(intApprovalNo) FROM history_orderdetails HOD WHERE HOD.intStyleId=o.intStyleId)) AS hisAcc,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM history_orderdetails HOD INNER JOIN matitemlist MIL ON MIL.intItemSerial=HOD.intMatDetailID WHERE HOD.intStyleId=o.intStyleId AND MIL.intMainCatID=3 AND intApprovalNo IN ( SELECT MAX(intApprovalNo) FROM history_orderdetails HOD WHERE HOD.intStyleId=o.intStyleId)) AS hisPacking,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM history_orderdetails HOD INNER JOIN matitemlist MIL ON MIL.intItemSerial=HOD.intMatDetailID WHERE HOD.intStyleId=o.intStyleId AND MIL.intMainCatID=4 AND intApprovalNo IN ( SELECT MAX(intApprovalNo) FROM history_orderdetails HOD WHERE HOD.intStyleId=o.intStyleId)) AS hisServi,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM history_orderdetails HOD INNER JOIN matitemlist MIL ON MIL.intItemSerial=HOD.intMatDetailID WHERE HOD.intStyleId=o.intStyleId AND MIL.intMainCatID=5 AND intApprovalNo IN ( SELECT MAX(intApprovalNo) FROM history_orderdetails HOD WHERE HOD.intStyleId=o.intStyleId)) AS hisOther,
(SELECT SUM(dblTotalValue) AS dblTotalValue FROM history_orderdetails HOD INNER JOIN matitemlist MIL ON MIL.intItemSerial=HOD.intMatDetailID WHERE HOD.intStyleId=o.intStyleId AND MIL.intMainCatID=6 AND intApprovalNo IN ( SELECT MAX(intApprovalNo) FROM history_orderdetails HOD WHERE HOD.intStyleId=o.intStyleId)) AS hisWashing

FROM gapro.orders o INNER JOIN eshipping.shipmentplheader splh ON splh.intStyleId=o.intStyleId
 INNER JOIN eshipping.commercial_invoice_detail cid ON splh.strPLNo = cid.strPLNo 
INNER JOIN eshipping.commercial_invoice_header cih ON cih.strInvoiceNo= cid.strInvoiceNo
INNER JOIN eshipping.buyers b ON b.strBuyerID = cih.strBuyerID
INNER JOIN eshipping.customers c ON c.strCustomerID = cih.strCompanyID
INNER JOIN eshipping.finalinvoice fi ON fi.strInvoiceNo = cih.strInvoiceNo
INNER JOIN gapro.buyers GB ON GB.intBuyerID=o.intBuyerID
INNER JOIN eshipping.city CT ON CT.strCityCode = cih.strFinalDest
INNER JOIN eshipping.country cn ON cn.strCountryCode = CT.strCountryCode
WHERE DATE(cih.dtmInvoiceDate) BETWEEN '2011-11-01' AND '2011-11-30' AND cih.strInvoiceType='F' 
AND DATE(o.strRevisedDate) BETWEEN '2011-11-01' AND '2011-11-30'";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$PreCost	= GetPreOrderValues();
?>
  <tr>
    <td class="normalfnt"><?php echo $row["strOrderNo"]?></td>
   <td class="normalfnt"><?php echo $row["strStyle"]?></td>
    <td class="normalfntRite"><?php echo $row["preFabric"]=="" ? '&nbsp;':$row["preFabric"]?></td>
    <td class="normalfntRite"><?php echo $row["hisFabric"]=="" ? '&nbsp;':$row["hisFabric"]?></td>
    <td class="normalfntRite"><?php echo $row["preAcc"]=="" ? '&nbsp;':$row["preAcc"]?></td>
    <td class="normalfntRite"><?php echo $row["hisAcc"]=="" ? '&nbsp;':$row["hisAcc"]?></td>
    <td class="normalfntRite"><?php echo $row["prePacking"]=="" ? '&nbsp;':$row["prePacking"]?></td>
    <td class="normalfntRite"><?php echo $row["hisPacking"]=="" ? '&nbsp;':$row["hisPacking"]?></td>
    <td class="normalfntRite"><?php echo $row["preServi"]=="" ? '&nbsp;':$row["preServi"]?></td>
    <td class="normalfntRite"><?php echo $row["hisServi"]=="" ? '&nbsp;':$row["hisServi"]?></td>
    <td class="normalfntRite"><?php echo $row["preOther"]=="" ? '&nbsp;':$row["preOther"]?></td>
    <td class="normalfntRite"><?php echo $row["hisOther"]=="" ? '&nbsp;':$row["hisOther"]?></td>
    <td class="normalfntRite"><?php echo $row["preWashing"]=="" ? '&nbsp;':$row["preWashing"]?></td>
    <td class="normalfntRite"><?php echo $row["hisWashing"]=="" ? '&nbsp;':$row["hisWashing"]?></td>
  </tr>
<?php
}
?>
</table>
</table>
</body>
</html>
<?php
function  GetPreOrderValues()
{
	global $db;
	$sql1="";
	$result1=$db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{
	}
}
?>