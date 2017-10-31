<?php
	session_start();
	include("../../../Connector.php");
	$deliveryNo	= $_GET["deliveryNo"];
	//$deliveryNo	= 165;
	$companyID	= $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Custom Value Declaration_Back :: Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.reporttitle {
	font-family: Times New Roman;
	font-size: 25pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
	letter-spacing:normal;
	word-spacing:normal;
}
.reportsubtitle {
	font-family: Times New Roman;
	font-size: 18pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.font-Size12_family-times{	font-family:Times New Roman;
			font-size:22px;
			color:#000000;
			margin:0px;
			font-weight: normal;
			text-align:justify;
		
}
-->
</style>
</head>

<body style="margin-top:50px">
<?php

$sql="select *
from deliverynote DH where intDeliveryNo=$deliveryNo";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$customerID					= $row["strCustomerID"];
	$authorizedBy				= $row["strAuthorizedBy"];
}

$sqlconsignee="select * from customers where strCustomerID=$customerID";

$result_consignee=$db->RunQuery($sqlconsignee);
while($row_consignee=mysql_fetch_array($result_consignee))
{
	$consigneeName			= $row_consignee["strName"];
}

?>
<table  width="979"  align="center" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td width="42" rowspan="3" >&nbsp;</td>
    <td width="891"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      
      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="outline">
          <tr > 
            <td class="normalfnt">20.</td>
            <td class="normalfnt">Previous imports of identical / similar goods, if any (within last three months) </td>
          </tr>
		  <tr > 
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">Bill of entry(CUSDEC) Number and Date : </td>
          </tr>
		  <tr >
            <td colspan="2" class="normalfnt_size12">&nbsp;</td>
            </tr>
          <tr >
            <td colspan="2" class="normalfnt_size12">&nbsp;</td>
            </tr>
          <tr >
            <td colspan="2" class="normalfnt_size12">&nbsp;</td>
            </tr>
			  <tr >
            <td colspan="2" class="normalfnt_size12">&nbsp;</td>
            </tr>
          <tr >
            <td width="21" class="border-bottom-fntsize12">&nbsp;</td>
            <td width="869" class="border-bottom-fntsize12">&nbsp;</td>
          </tr>
          <tr >
            <td height="60" colspan="2" class="reportsubtitle">DECLARATION</td>
            </tr>
          <tr >
            <td class="normalfnt">1.</td>
            <td class="normalfnt">I here by declare that the information furnished above is true and correct in every respect.</td>
          </tr>
          <tr >
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr >
            <td class="normalfnt">2.</td>
            <td class="normalfnt">I also undertake to bring to the nortice of Custom any particulars, which may subsequently come to my knowledge,that will</td>
          </tr>
			 <tr><td class="normalfnt">&nbsp;</td>
               <td class="normalfnt">have a bearing on valuation. </td>
			 </tr>
          <tr >
            <td height="25" class="normalfnt_size12">&nbsp;</td>
            <td class="normalfnt_size12">&nbsp;</td>
          </tr>
          <tr >
            <td height="25" class="normalfnt_size12">&nbsp;</td>
            <td class="normalfnt_size12">&nbsp;</td>
          </tr>
          <tr >
            <td height="25" class="normalfnt_size12">&nbsp;</td>
            <td class="normalfnt_size12">&nbsp;</td>
          </tr>
          <tr >
            <td height="25" class="normalfnt_size12">&nbsp;</td>
            <td class="normalfnt_size12">&nbsp;</td>
          </tr>
          <tr >
            <td height="25" class="normalfnt_size12">&nbsp;</td>
            <td class="normalfnt_size12">&nbsp;</td>
          </tr>
          <tr >
            <td colspan="2" class="normalfnt_size12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="14%" class="normalfnt">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
                <td class="normalfnt" style="text-align:center">&nbsp;</td>
                <td width="32%" class="normalfntTAB2" style="text-align:center">&nbsp;</td>
                <td width="6%" class="normalfnt" style="text-align:center">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="normalfnt">Date</span></td>
                <td>:</td>
                <td class="normalfnt_size12"><?php echo date("d:m:Y");?></td>
                <td class="normalfntMid">&nbsp;</td>
                <td class="normalfntMid">Signature Of Importer / Agent </span></td>
                <td class="normalfntMid">&nbsp;</td>
              </tr>
              <tr>
                <td  class="normalfnt">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="normalfnt">Name Of Signatory </span></td>
                <td>:</td>
                <td class="normalfnt_size12">&nbsp;<?php echo $authorizedBy;?></td>
                <td width="7%">Title : <span class="normalfntTAB2"></span></td>
                <td class="normalfntTAB2">&nbsp;</td>
                <td class="normalfnt">&nbsp;</td>
              </tr>
              <tr>
                <td  class="normalfnt">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="normalfnt">Name OF Company</span></td>
                <td>:</td>
                <td colspan="4" class="normalfnt_size12">&nbsp;<?php echo $consigneeName;?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          
        
        </table>
          </td>
        </tr>
      <tr>
        <td height="16" colspan="5" class="font-Size12_family-times"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="reportsubtitle">&nbsp;</td>
            </tr>
          <tr>
            <td width="2%" class="reportsubtitle">For Office Use :</td>
            </tr>
          
        </table></td>
        </tr>     	   
         
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="outline">
        <tr>
          <td height="25" colspan="3" class="normalfnt_size12"><b>Appraiser's Comments</b></td>
        </tr>
        <tr>
          <td width="2%">&nbsp;</td>
          <td width="96%" class="normalfnt_size12">Satisfied / Dout / Suspect Fraud. </td>
          <td width="2%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfntTAB2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfntTAB2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfntTAB2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="2%">&nbsp;</td>
              <td width="30%" class="normalfntTAB2">&nbsp;</td>
              <td width="17%">&nbsp;</td>
              <td width="23%">&nbsp;</td>
              <td width="26%" class="normalfntTAB2">&nbsp;</td>
              <td width="2%">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="normalfntMid">Date</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="normalfntMid">Appraiser</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="border-bottom">&nbsp;</td>
          <td class="border-bottom">&nbsp;</td>
          <td class="border-bottom">&nbsp;</td>
        </tr>
        <tr>
          <td height="25" colspan="2" class="normalfnt_size12"><b>SC's Comments</b></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfnt_size12">Satisfied / Doubt / Suspect Fraud. </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfnt">Reasons:</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfntTAB2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfntTAB2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="normalfntTAB2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="2%">&nbsp;</td>
              <td width="30%" class="normalfntTAB2">&nbsp;</td>
              <td width="17%">&nbsp;</td>
              <td width="23%">&nbsp;</td>
              <td width="26%" class="normalfntTAB2">&nbsp;</td>
              <td width="2%">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="normalfntMid">Date</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="normalfntMid">SC</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    <td rowspan="3" width="42">&nbsp;</td>
  </tr>  
    
</table>

</body>
</html>
