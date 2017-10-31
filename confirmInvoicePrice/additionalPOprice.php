<?php
session_start();
//include "authentication.inc";
 include "../Connector.php"; 
 $intPONo = $_GET["intPONo"];
 $intYear = $_GET["intYear"];
 $intGRNno = $_GET["intGRNno"];
 $intGRNYear =  $_GET["intGRNYear"];
 
 /*$intPONo =112;
 $intYear = 2010;
 $intGRNno = 147;
 $intGRNYear = 2010;*/
 
 $backwardseperator = "../";
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PO Price Discripancy</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function PageSubmit()
{
	//alert(document.getElementById("datUpload").value);
	document.getElementById("frmPOPrice").submit();
}
function OpenFileTransfer()
{
	window.open("fileUpload.php","Window1","menubar=no,width=800,height=300,toolbar=no");
}
</script>
<script src="cinfirmPrice.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
</head>

<body>
<form id="frmPOPrice" enctype="multipart/form-data" method="post">
<table width="850" border="0" align="center">
  <tr>
    <td colspan="3" class="head2BLCK">Purchase Order - Price Discrimency Details</td>
  </tr>
  <tr>
    <td width="216">&nbsp;</td>
    <td width="539">&nbsp;</td>
    <td width="37">&nbsp;</td>
  </tr>
<?php 
$SQLPO = "SELECT DATE_FORMAT(P.dtmDate, '%d-%M-%Y')  AS dtmDate, S.strTitle,S.strAddress1,
S.strAddress2,S.strStreet,S.strCity,S.strState,C.strCountry 
FROM purchaseorderheader P 
INNER JOIN suppliers S ON P.strSupplierID = S.strSupplierID
inner join country C on C.intConID=S.strCountry
WHERE P.intPONo='$intPONo' AND P.intYear='$intYear'";
$resultPO = $db->RunQuery($SQLPO);		
while($rowP = mysql_fetch_array($resultPO))
{
	$SupplierName  = $rowP["strTitle"].'<br/>';
	$SupplierName .= ($rowP["strAddress1"]=="" ? "":$rowP["strAddress1"]);
	$SupplierName .= ($rowP["strAddress2"]=="" ? "":$rowP["strAddress2"].'<br/>');
	$SupplierName .= ($rowP["strStreet"]=="" ? "":$rowP["strStreet"].'<br/>');
	$SupplierName .= ($rowP["strCity"]=="" ? "":$rowP["strCity"].'<br/>');
	$SupplierName .= ($rowP["strState"]=="" ? "":$rowP["strState"].'<br/>');
	$SupplierName .= ($rowP["strCountry"]=="" ? "":$rowP["strCountry"].'<br/>');
	$dtmDate 	   = $rowP["dtmDate"];
}
?>
  <tr>
    <td colspan="3"><table width="100%" border="0">
      <tr>
        <td width="146" class="normalfnBLD1">PO No</td>
        <td width="9" class="normalfnt">:</td>
        <td width="391" class="normalfnt"><?php echo $intYear.'/'.$intPONo; ?></td>
        <td width="76" class="normalfnBLD1">PO Date</td>
        <td width="206" class="normalfnt">: <?php echo $dtmDate; ?></td>
      </tr>
      <tr>
        <td class="normalfnBLD1" valign="top">Supplier Name</td>
        <td class="normalfnt" valign="top">:</td>
        <td class="normalfnt" valign="top"><?php echo $SupplierName; ?></td>
        <td class="normalfnBLD1">&nbsp;</td>
        <td class="normalfnBLD1">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><!--<div id="divPoItem" style="overflow:scroll; height:200px; width:800px;">-->
      <table width="850" border="0" cellspacing="1" bgcolor="#000000" id="poDetails">
        <tr bgcolor="#CCCCCC" class="normalfntMid">
          <th width="122" height="25"  >Style No</th>
          <th width="85">Buyer PONo</th>
          <th width="160">Item</th>
          <th width="87">Color</th>
          <th width="70">Unit</th>
          <th width="66">Size</th>
          <th width="86">Qty</th>
          <th width="65">PO Price</th>
          <th width="81">Invoice Price</th>
        </tr>
<?php 		
$SQL = "SELECT
matitemlist.strItemDescription,
matitemlist.intItemSerial,
purchaseorderdetails.strBuyerPONO,
purchaseorderdetails.dtmItemDeliveryDate,
purchaseorderdetails.strSize,
purchaseorderdetails.dblAdditionalQty,
purchaseorderdetails.intYear,
purchaseorderdetails.strColor,
purchaseorderdetails.strUnit,
purchaseorderdetails.dblUnitPrice,
grndetails.dblInvoicePrice,
purchaseorderdetails.dblQty,
purchaseorderdetails.intPoNo,
purchaseorderdetails.strRemarks,
purchaseorderdetails.intPOType,
orders.strOrderNo,
orders.intStyleId,
orders.strStyle,
specification.intSRNO,
materialratio.materialRatioID
FROM
(purchaseorderdetails)
left Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
left Join orders ON purchaseorderdetails.intStyleId = orders.intStyleId
left join specification on purchaseorderdetails.intStyleId = specification.intStyleId
left join materialratio on purchaseorderdetails.intStyleId = materialratio.intStyleId and purchaseorderdetails.intMatDetailID = materialratio.strMatDetailID and purchaseorderdetails.strColor = materialratio.strColor and purchaseorderdetails.strSize = materialratio.strSize aND purchaseorderdetails.strBuyerPONO = materialratio.strBuyerPONO
left join grndetails on grndetails.intStyleId = purchaseorderdetails.intStyleId and purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
and grndetails.intMatDetailID=purchaseorderdetails.intMatDetailID and grndetails.strColor = purchaseorderdetails.strColor
and purchaseorderdetails.strSize = grndetails.strSize
WHERE (((purchaseorderdetails.intPoNo)='$intPONo')) and (((purchaseorderdetails.intYear)='$intYear')) and grndetails.intGrnNo ='$intGRNno' and grndetails.intGRNYear='$intGRNYear' and purchaseorderdetails.dblInvoicePrice<>grndetails.dblInvoicePrice ";
$result = $db->RunQuery($SQL);		
while($row = mysql_fetch_array($result))
{
$StyleName = $row["strOrderNo"];
$BuyerPONo = $row["strBuyerPONO"];
$unit      = $row["strUnit"];
$color     = $row["strColor"];
$size      = $row["strSize"];
$poPrice   = $row["dblUnitPrice"];
$invoicePrice = $row["dblInvoicePrice"];
$qty       = $row["dblQty"]; 
$itemName  = $row["strItemDescription"];
$StyleID   = $row["intStyleId"];
$BuyerPONo = $row["strBuyerPONO"];
$ItemID    = $row["intItemSerial"];

if($BuyerPONo == '#Main Ratio#')
	$BuyerPoName = $BuyerPONo;
else
	$BuyerPoName = getBuerPOName($StyleID,$BuyerPONo);
?>
		<tr class="bcgcolor-tblrowWhite">
			<td class="normalfnt" id="<?php echo $StyleID; ?>"><?php echo $StyleName; ?></td>
			<td class="normalfnt" id="<?php echo $BuyerPONo; ?>"><?php echo $BuyerPoName; ?></td>
			<td class="normalfnt" id="<?php echo $ItemID; ?>"><?php echo $itemName; ?></td>
			<td class="normalfnt"><?php echo  $color;?></td>
			<td class="normalfnt"><?php echo $unit; ?></td>
			<td class="normalfnt"><?php echo $size; ?></td>
			<td class="normalfntRite"><?php echo $qty; ?></td>
			<td class="normalfntRite"><?php echo $poPrice; ?></td>
			<td><input name="txtInvoicePrice" type="text" class="txtbox" size="10" style="text-align:right" value="<?php echo $invoicePrice; ?>"></td>
		</tr>
<?php
}
?>
      </table>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/conform.png" width="115" height="24" class="mouseover" onClick="ConfirmInvoicePrice(<?php echo  $intPONo; ?>,<?php echo $intYear;//$_GET["intYear"]; ?>,<?php echo  $intGRNno;//$_GET["intGRNno"]; ?>,<?php echo $intGRNYear;//$_GET["intGRNYear"]; ?>);"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="800" border="0" style="display:none">
      <tr>
        <td width="135" class="normalfnt">Proof Document</td>
        <td width="389"><input name="docUpload" type="file" class="normalfnt" id="docUpload" size="50px;"></td>
        <td width="262"><img src="../images/upload.jpg" width="115" height="24" class="mouseover" onClick="PageSubmit();"></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="3" class="normalfnt" style="display:none">
<?php 	
if ($_FILES["docUpload"]["error"] > 0)
{
	echo "Error: " . $_FILES["docUpload"]["error"] . "<br />";
	die();
}
if($_FILES["docUpload"]["name"]=='')
	die();

$fileName =  date('Y-m-d').time().$intPONo.$intYear;
mkdir("upload/".$fileName, 0700);
$target_path = "upload/".$fileName."/".  $_FILES['docUpload']['name'];

if(move_uploaded_file($_FILES['docUpload']['tmp_name'], $target_path))
{
	echo "The file ". basename( $_FILES['docUpload']['name'])." has been uploaded";
}
else
{
	echo "There was an error uploading the file, please try again!";
}
?></td>
    </tr>
  <tr>
   &nbsp;</td>
    </tr>
</table>
</form>
<?php 
function getBuerPOName($StyleID,$buyerPOno)
{
global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$StyleID' AND strBuyerPONO='$buyerPOno'";	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$BPOname = $row["strBuyerPoName"];
	}
return $BPOname;			 
}
?>
</body>
</html>