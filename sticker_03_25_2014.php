<?php
session_start();

include "Connector.php";

$xml = simplexml_load_file('config.xml');

$intMainCode = $_GET['mainCode'];
$intSCNo = $_GET['scno'];


$strSql = " SELECT
materialratio.materialRatioID,
materialratio.strColor,
materialratio.strSize,
buyers.strName,
matitemlist.strItemDescription,
orders.strStyle
FROM
materialratio
Inner Join orders ON materialratio.intStyleId = orders.intStyleId
Inner Join matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
Inner Join specification ON orders.intStyleId = specification.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
WHERE";

if($intMainCode == 0){
	$strSql .= " specification.intSRNO =  '$intSCNo' AND
matitemlist.intMainCatID <>  '4' and matitemlist.intMainCatID <>  '5' 
AND
(materialratio.intStatus =  '1' OR 
materialratio.intStatus IS NULL)
";	
}else{
	$strSql .= " specification.intSRNO =  '$intSCNo' AND
matitemlist.intMainCatID <>  '4' and matitemlist.intMainCatID <>  '5' 
AND
(materialratio.intStatus =  '1' OR 
materialratio.intStatus IS NULL) and matitemlist.intMainCatID = '$intMainCode'";
	
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
                <tr><td colspan="5" class="itemColorSize"><?php echo " Description - ". substr($row['strItemDescription'], 0, 37); ?></td><tr>
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