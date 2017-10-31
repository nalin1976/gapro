<?php
session_start();

include "../../Connector.php";

$xml = simplexml_load_file('../../config.xml');

$intGRNNo = $_GET['grnno'];
$intGRNYear = $_GET['grnYear'];

$strSql = " SELECT
materialratio.materialRatioID,
materialratio.strColor,
materialratio.strSize,
buyers.strName,
matitemlist.strItemDescription
FROM
grndetails
Inner Join materialratio ON grndetails.intStyleId = materialratio.intStyleId AND grndetails.strBuyerPONO = materialratio.strBuyerPONO AND grndetails.intMatDetailID = materialratio.strMatDetailID AND grndetails.strColor = materialratio.strColor AND grndetails.strSize = materialratio.strSize
Inner Join orders ON grndetails.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
Inner Join matitemlist ON grndetails.intMatDetailID = matitemlist.intItemSerial
WHERE
grndetails.intGrnNo =  '$intGRNNo' AND
grndetails.intGRNYear =  '$intGRNYear'";

$result = $db->RunQuery($strSql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Code Sticker</title>
<style type="text/css">
.itemcode{font-size:32px; font-weight:bold;}
.itemColorSize{font-size:10px;}
body{margin-top:0px;}
</style>
</head>

<body topmargin="0">
<?php 
	while($row=mysql_fetch_array($result)){
?>		
		<div style="border-width:1px;border:#ffffff;border-style:solid;overflow:hidden; position:relative; top:-10px;">
    		<table border="0">
            	<tr><td class="itemcode"><?php echo $row['materialRatioID']; ?></td><tr>	
                <tr><td colspan="5" class="itemColorSize"><?php echo " Buyer - ". $row['strName']; ?></td><tr>
                <tr><td colspan="5" class="itemColorSize"><?php echo " Description - ". $row['strItemDescription']; ?></td><tr>
                <tr>
                	<td colspan="5" class="itemColorSize"><?php echo "Color - ". $row['strColor']. " ::  Size - ". $row['strSize'] ; ?></td>
                </tr>	
                <tr>
                    <td width="50" height="25">&nbsp;</td>
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