<?php
session_start();

include "../../Connector.php";

$xml = simplexml_load_file('../../config.xml');

$intGRNNo = $_GET['grnno'];
$intGRNYear = $_GET['grnYear'];
$poNo = $_GET['poNo'];
//echo "AA".$intGRNNo;
$poNoArray		= explode('/',$poNo);
if($intGRNNo!=""){
$strSql = " SELECT
materialratio.materialRatioID,
materialratio.strColor,
materialratio.strSize,
buyers.strName,
matitemlist.strItemDescription,
orders.strStyle
FROM
grndetails
Inner Join materialratio ON grndetails.intStyleId = materialratio.intStyleId AND grndetails.strBuyerPONO = materialratio.strBuyerPONO AND grndetails.intMatDetailID = materialratio.strMatDetailID AND grndetails.strColor = materialratio.strColor AND grndetails.strSize = materialratio.strSize
Inner Join orders ON grndetails.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
Inner Join matitemlist ON grndetails.intMatDetailID = matitemlist.intItemSerial
WHERE
grndetails.intGrnNo =  '$intGRNNo' AND
grndetails.intGRNYear =  '$intGRNYear'";
}else{
$strSql = " SELECT
materialratio.materialRatioID,
materialratio.strColor,
materialratio.strSize,
orders.strStyle,
buyers.strName,
matitemlist.strItemDescription,
orders.strStyle
FROM
purchaseorderdetails
INNER JOIN materialratio ON purchaseorderdetails.intStyleId = materialratio.intStyleId AND purchaseorderdetails.intMatDetailID = materialratio.strMatDetailID AND purchaseorderdetails.strBuyerPONO = materialratio.strBuyerPONO AND purchaseorderdetails.strColor = materialratio.strColor AND purchaseorderdetails.strSize = materialratio.strSize
INNER JOIN orders ON purchaseorderdetails.intStyleId = orders.intStyleId
INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
WHERE
purchaseorderdetails.intPoNo = '$poNoArray[1]' AND
purchaseorderdetails.intYear = '$poNoArray[0]'";
}
$result = $db->RunQuery($strSql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Code Sticker</title>
<style type="text/css">
.itemcode{font-size:30px; font-weight:bold; font-family:"Times New Roman", Times, serif;}
.itemColorSize{font-size:10px;}
</style>
</head>

<body topmargin="0">
<?php 
	while($row=mysql_fetch_array($result)){
?>		
		<div style="border-width:1px;border:#ffffff;border-style:solid;overflow:hidden; top:0;">
    		<table border="0">
            	<tr><td class="itemcode"><?php echo $row['materialRatioID']; ?></td><tr>	
                <tr><td colspan="5" class="itemColorSize"><?php echo " Style - ". $row['strStyle']. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Buyer - ". $row['strName']; ?></td><tr>
                <tr><td colspan="5" class="itemColorSize"><?php echo " Description - ". substr($row['strItemDescription'],0, 37); ?></td><tr>
                <tr>
                	<td colspan="5" class="itemColorSize"><?php echo "Color - ". $row['strColor']. " ::  Size - ". $row['strSize'] ; ?></td>
                </tr>	
                <tr>
                    <td width="50" height="27">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td width="84">&nbsp;</td>
              	</tr>		        			
			</table>        
        </div>
<?php } ?>

</body>
</html>