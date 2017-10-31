
<?php
$backwardseperator = "../../../../";
session_start();
include("../../../Connector.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Packing List Printer</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script type="text/javascript">

function do_print()
{
	//var plno			=('#cboPLnumber').val;
	var InvoiceNo=document.getElementById('cboinvoiceNo').value;
	//alert(InvoiceNo);
	
//	if(InvoiceNo=="")
//		{
//			alert("Please select a Invoice number");
//			return;	
//		}
//
//		
//	url		=url_format+ "?plno="+plno;
//	window.open(url,'documentchecklist.php')

		if(InvoiceNo!='')
	
			{
				
				window.open("documentchecklist.php?InvoiceNo=" + '&InvoiceNo='+InvoiceNo,'abc');
				window.open("../rptmaersk_format.php?InvoiceNo=" + '&InvoiceNo='+InvoiceNo,'acb');
				
			}
		
	else
		alert("Please Select Invoice Number");
	//window.open("movingGSPCO.php?I nvoiceNo="+URLEncode(invNo)+"&gspDate="+gspDate,"GSP CO");
	//window.open("movingCo_Back.php?InvoiceNo="+invNo+"&exRate="+exchangeRate+"&unitPrice="+unitPrice+"&netWt="+netWt,"CO_BACK");
	

}



</script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php

include "../../../../Connector.php";

?>


</head>

<body>
<table width="500" height="150" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE" align="center">
  <tr>
    <td><?php include '../../../../Header.php'; ?></td>
  </tr>
  <tr class="bcgcolor-highlighted">
    <td height="35" colspan="4"  class="normaltxtmidb2L"  bgcolor="#588DE7">&nbsp; Maersk Report Printer</td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
  
  
  
    
    <td  width="952" class="normalfnth2Bm" style="text-align:center"><table width="477" height="88" border="0" align="center">
        <tr>
          <td width="129"><span class="normalfnth2Bm" style="text-align:left">Shipping order No :</span></td>
          <td width="338"><span class="normalfnth2Bm" style="text-align:left">
            <select name="cboinvoiceNo"  class="txtbox" id="cboinvoiceNo" style="width:160px" >
              <option value=''></option>
              <?php
                   			 $str="SELECT
									invoiceheader.strInvoiceNo
									FROM
									invoiceheader
									GROUP BY
									invoiceheader.strInvoiceNo
									ORDER BY
									invoiceheader.strInvoiceNo DESC";
                  					$exec=$db->RunQuery( $str);
									while($row=mysql_fetch_array( $exec)) 
						 		   echo "<option value=".$row['strInvoiceNo'].">".$row['strInvoiceNo']."</option>"            
                  			 ?>
            </select>
          </span></td>
        </tr>
    </table></td>
  </tr>
  
  <tr>
  
    <td class="normalfnth2Bm" style="text-align:center">&nbsp;</td>
  </tr><tr height="5">
  </tr>
  
  
  
  
  <tr align="center">
    <td colspan="3"><img src="../../../../images/go.png" width="44" height="32" alt="go" onclick="do_print()" class="mouseover" title="Print"/></td>

  </tr>
</table>
</body>
</html>
