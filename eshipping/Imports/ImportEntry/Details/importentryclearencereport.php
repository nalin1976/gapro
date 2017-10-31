<?php 
session_start();
include "../../../Connector.php";
				
	$optClearance		= $_GET["optClearance"];
	$optAllImports		= $_GET["optAllImports"];
	$chkClearence		= $_GET["chkClearence"];
	$dtmClearenceFrom	= $_GET["dtmClearenceFrom"];
		$DateFromArray	= explode('/',$dtmClearenceFrom);
		$formatedFromDate = $DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
	$dtmClearenceTo		= $_GET["dtmClearenceTo"];
		$DateToArray	= explode('/',$dtmClearenceTo);
		$formatedToDate = $DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
	$test	= ($optClearance=="true" ? "CLEARENCE":"ALL IMPORTS");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web :: Import Entry :: Clearence Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

/*function sendEmail()
{
	var year = <?php echo  $_GET["year"];?>;
	var poNo = <?php echo  $_GET["pono"];?>;
	var emailAddress = prompt("Please enter the supplier's email address :");
	if (checkemail(emailAddress))
	{	
		createXMLHttpRequest(emailAddress);
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'poemail.php?pono=' + poNo + '&year=' + year + '&supplier=' + emailAddress, true);
		xmlHttp.send(null);
	}
}

function checkemail(str)
{
	var filter= /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str))
		return true;
	else
		return false;
}

function HandleEmail()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		
			if(xmlHttp.responseText == "True")
				alert("The Purchase Order has been emailed to the supplier.");
		}
	}
}*/

</script>
</head>


<body>

<table width="1100" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1101"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="18%"><img src="../../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>

              <td width="1%" class="normalfnt">&nbsp;</td>
				  
				   <td width="68%" class="tophead"><p class="head2BLCK"><?php echo $test ?> INFORMATIONS</p></td>
                 <td width="13%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><p class="normalfnt2bldBLACKmid">NEW GOODS CLEARANCE INFORMATION - SHIPPING DEPARTMENT</p></td></tr>
	
<?php
$sql_customer="select DISTINCT strCustomerID,
(select strName from customers where customers.strCustomerID=DH.strCustomerID)AS CustomerName
from deliverynote DH
Inner Join deliverydetails DD ON DD.intDeliveryNo=DH.intDeliveryNo
where DH.intDeliveryNo <>0";

if($optClearance=="true")
	$sql_customer .=" AND intStatus=1";

if($chkClearence=="true")
{
	if($formatedFromDate!="")
		$sql_customer .=" AND dtmClearedOn >= '$formatedFromDate'";
		
	if($formatedToDate!="")
		$sql_customer .=" AND dtmClearedOn <= '$formatedToDate'";
}

$result_customer=$db->RunQuery($sql_customer);
while($row_customer=mysql_fetch_array($result_customer))
{ 
$pub_customerID	= $row_customer["strCustomerID"];
?>
<tr>
<td>
<table width="100%" border="0" cellpadding="0">
<tr>
	<td width="100%"><table width="100%" cellpadding="0" border="0" class="normalfnt2BITAB">
		<tr>
			<td width="9%">Customer Name : </td>
		    <td width="91%"><?php echo $row_customer["CustomerName"];?></td>
		</tr>
	</table></td>
</tr>
        <tr>
          <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#666666"  >
			
            <tr class="bcgcolor-tblrowWhite">
              <td width="7%" height="31"class="normalfnth2Bm">Invoice No </td>
              <td width="33%" class="normalfnth2Bm">Item Description </td>
              <td width="6%" class="normalfnth2Bm" >Quantity</td>
              <td width="24%" class="normalfnth2Bm" >Supplier</td>
              <td width="11%" class="normalfnth2Bm" >Supplier Country </td>
              <td width="6%" class="normalfnth2Bm">Packs </td>
              <td width="6%" class="normalfnth2Bm" >Weight</td>
              <td width="2%" class="normalfnth2Bm">FCL</td>
              <td width="5%" class="normalfnth2Bm">Mode</td>
              </tr>
<?php
$sql="select strInvoiceNo,
strItemCode,
(select strDescription from item I where I.strItemCode=DD.strItemCode)AS ItemDescription,
dblQty,
 strExporterID,
(select strName from suppliers where suppliers.strSupplierId=DH.strExporterID)AS SupplierName,
strCtryOfExp,
(select strCountry from country CO where CO.strCountryCode=DH.strCtryOfExp)AS SupplierCountry,
dblPackages,
strWeight,
strFCL,
strMode,
(select strPlaceofDcs from mode M where M.strMode=DH.strMode)AS mode
from deliverynote DH 
Inner Join deliverydetails  DD ON DH.intDeliveryNo=DD.intDeliveryNo 
where strCustomerID='$pub_customerID'";

if($optClearance=="true")
	$sql .=" AND intStatus=1";

if($chkClearence=="true")
{
	if($formatedFromDate!="")
		$sql .=" AND dtmClearedOn >= '$formatedFromDate'";
	if($formatedToDate!="")
		$sql .=" AND dtmClearedOn <= '$formatedToDate'";
}

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>       
            <tr class="bcgcolor-tblrowWhite">
              <td class="normalfntMid"><?php echo $row["strInvoiceNo"];?></td>
              <td class="normalfnt"><?php echo $row["ItemDescription"];?></td>
              <td class="normalfntRite"><?php echo $row["dblQty"];?></td>
              <td class="normalfnt"><?php echo $row["SupplierName"];?></td>
              <td class="normalfnt"><?php echo $row["SupplierCountry"];?></td>
              <td class="normalfntRite"><?php echo $row["dblPackages"];?></td>
              <td class="normalfntMid"><?php echo $row["strWeight"];?></td>
              <td class="normalfntMid"><?php echo $row["strFCL"];?></td>
              <td class="normalfntMid"><?php echo $row["strMode"];?></td>
<?php 
}
?>              </tr>

          </table></td>
        </tr>
      </table></td>
  </tr>
<?php
}
?>

</table>
</body>
</html>
