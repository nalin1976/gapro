<?php 
session_start();
include "../../Connector.php"; 
$backwardseperator = "../../";

$companyId  = $_SESSION["FactoryID"];
$report_companyId=$_SESSION['FactoryID'];
$PONo = $bulkPoNo;
$Year = $intYear;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Normal GatePass Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td colspan="5"><?php include "${backwardseperator}reportHeader.php"; ?></td>
  </tr>
  
  <tr>
    <td colspan="5"><table width="100%" border="0" class="head2BLCK">
      <tr>
	  
	  <?php
  $sql ="select 	GPO.intGenPONo,
	GPO.intYear, GPO.intStatus,
	substring(GPO.intYear,3,4) as ponodate,
	date(GPO.dtmDate) as dtmDate,
	(select c.strTitle from currencytypes c where c.intCurID = GPO.strCurrency) as strCurrency,
	CP.strName as DtostrName,
	CP.strAddress1 as DtostrAddress1,
	CP.strAddress2 as DtostrAddress2,
	CP.strStreet as DtostrStreet,
	CP.strCity as DtostrCity,
	PM.strDescription as payMode,
	PT.strDescription as payTerm,
	SP.strTitle as TostrTitle,
	SP.strAddress1 as TostrAddress1,
	SP.strAddress2 as TostrAddress2,
	SP.strStreet as TostrStreet,
	SP.strCity as TostrCity,
	(select c.strCountry from country c where c.intConID = SP.strCountry) as TostrCountry,
	CP.strName as InvstrName,
	CP.strAddress1 as InvstrAddress1,
	CP.strAddress2 as InvstrAddress2,
	CP.strStreet as InvstrStreet,
	CP.strCity as InvstrCity,
	CN.strCountry as InvstrCountry,
	CP.strPhone as InvstrPhone,
	CP.strEMail as InvstrEMail
	from 
	generalpurchaseorderheader GPO
	inner join companies CP ON GPO.intDeliverTo=CP.intCompanyID 
	inner join popaymentmode PM ON GPO.intPayMode=PM.strPayModeId
	inner join popaymentterms PT ON GPO.strPayTerm=PT.strPayTermId
	inner join suppliers SP ON GPO.intSupplierID=SP.strSupplierID
	inner join country CN ON CP.intCountry=CN.intConID
	where GPO.intGenPONo='$PONo' AND GPO.intYear='$Year'
	order by GPO.intGenPONo;";
  
  $result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{	
	$invDetails = $row["InvstrName"]."<br/>";
	$invDetails .= ($row["InvstrAddress1"]=="" ? "":$row["InvstrAddress1"]."<br/>");
	$invDetails .= ($row["InvstrAddress2"]=="" ? "":$row["InvstrAddress2"]."<br/>");
	$invDetails .= ($row["InvstrStreet"]=="" ? "":$row["InvstrStreet"]."<br/>");
	$invDetails .= ($row["InvstrCity"]=="" ? "":$row["InvstrCity"]."<br/>");
	$invDetails .= ($row["InvstrCountry"]=="" ? "":$row["InvstrCountry"]."<br/>");
	
	$toDetails 	 = $row["TostrTitle"]."<br/>";
	$toDetails  .= ($row["TostrAddress1"]=="" ? "":$row["TostrAddress1"]."<br/>");
	$toDetails  .= ($row["TostrAddress2"]=="" ? "":$row["TostrAddress2"]."<br/>");
	$toDetails  .= ($row["TostrStreet"]=="" ? "":$row["TostrStreet"]."<br/>");
	$toDetails  .= ($row["TostrCity"]=="" ? "":$row["TostrCity"]."<br/>");
	$toDetails  .= ($row["TostrCountry"]=="" ? "":$row["TostrCountry"]."<br/>");
	
	$DtoDetails   = $row["DtostrName"]."<br/>";
	$DtoDetails  .= ($row["DtostrAddress1"]=="" ? "":$row["DtostrAddress1"]."<br/>");
	$DtoDetails  .= ($row["DtostrAddress2"]=="" ? "":$row["DtostrAddress2"]."<br/>");
	$DtoDetails  .= ($row["DtostrStreet"]=="" ? "":$row["DtostrStreet"]."<br/>");
	$DtoDetails  .= ($row["DtostrCity"]=="" ? "":$row["DtostrCity"]."<br/>");
	$DtoDetails  .= ($row["InvstrCountry"]=="" ? "":$row["InvstrCountry"]."<br/>");
?>	

  
        <td class="head2">Chemical Purchase Order </td>
      </tr>
      <tr>
        <td class="head1">W / <?php echo $row["ponodate"]; ?> / <?php echo $row["intGenPONo"]; ?> </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="2">
      <tr>
        <td colspan="3" rowspan="6" valign="top" class="normalfnt"><?php echo $invDetails; ?></td>
        <td class="normalfnth2B">PO # </td>
        <td class="normalfnt"><span class="normalfnth2B">:</span></td>
		<td width="34%" class="normalfnt">W / <?php echo $row["ponodate"]; ?> / <?php echo $row["intGenPONo"]; ?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Date</td>
        <td class="normalfnt"><span class="normalfnth2B">:</span></td>
		<td class="normalfnt"><?php echo $row["dtmDate"];?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Currency</td>
        <td class="normalfnt"><span class="normalfnth2B">:</span></td>
		<td class="normalfnt"><?php echo $row["strCurrency"];?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">PR # </td>
        <td class="normalfnt"><span class="normalfnth2B">:</span></td>
		<td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B">Delivery Location</td>
        <td class="normalfnt"><span class="normalfnth2B">:</span></td>
        <td rowspan="6" class="normalfnt" valign="top"><?php echo $DtoDetails; ?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        </tr>
      <tr>
        <td width="10%" class="normalfnth2B">To</td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="38%" rowspan="5" valign="top" class="normalfnt"><?php echo $toDetails; ?></td>
        <td width="16%" class="normalfnth2B">&nbsp;</td>
        <td width="1%" class="normalfnth2B">&nbsp;</td>
       </tr>
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
 		<tr>
        <td rowspan="2" class="normalfnth2B">&nbsp;</td>
        <td rowspan="2" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        </tr>
 		<tr>
 		  <td class="normalfnth2B">&nbsp;</td>
	      <td class="normalfnt">&nbsp;</td>
 		  <td valign="top" class="normalfnt">&nbsp;</td>
 		</tr>
        <tr>
          <td class="normalfnth2B">Phone</td>
          <td class="normalfnth2B">:</td>
          <td class="normalfnt"><?php echo $row["InvstrPhone"];?></td>
          <td class="normalfnth2B">&nbsp;</td>
          <td class="normalfnth2B">&nbsp;</td>
		  <td class="normalfnth2B">&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnth2B">Mail</td>
          <td class="normalfnth2B">:</td>
          <td class="normalfnt"><?php echo $row["InvstrEMail"];?></td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnth2B">&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnth2B">Pay Mode </td>
          <td class="normalfnth2B">:</td>
          <td class="normalfnt"><?php echo $row["payMode"];?></td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnth2B">&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnth2B">Pay Term </td>
          <td class="normalfnth2B">:</td>
          <td class="normalfnt"><?php echo $row["payTerm"];?></td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
		  <td class="normalfnth2B">&nbsp;</td>
        </tr>
	<?php
	}
	?>
        <tr>
        <td colspan="6" class="normalfnt">Please issue proforma invoice, in accordance with the instructions, the following </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="67" colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="24%" height="21" class="normalfntBtab">Chemical</td>
        <td width="24%" class="normalfntBtab">Delivery Date </td>
        <td width="13%" class="normalfntBtab">Unit</td>
        <td width="13%" class="normalfntBtab">Qty</td>
        <td width="13%" class="normalfntBtab">Unit Price</td>
        <td width="13%" class="normalfntBtab">Value</td>
      </tr>
	  
					<?php  
					$sum = 0;
				$sql_oth="select 	GP.intGenPoNo, 
						GP.intYear,
						GL.strItemDescription, 
						GP.strUnit, 
						GP.dblUnitPrice, 
						sum(GP.dblQty) as dblQty,
						date(GPO.dtmDeliveryDate) as dtmDeliveryDate
						 
						from 
						generalpurchaseorderdetails GP
						inner join genmatitemlist GL ON GP.intMatDetailID=GL.intItemSerial 
						inner join generalpurchaseorderheader GPO ON GP.intGenPoNo=GPO.intGenPONo AND GP.intYear=GPO.intYear
						where GP.intGenPONo='$PONo' AND GP.intYear='$Year'
						group by GL.strItemDescription,GP.strUnit";
						
			$result_oth = $db->RunQuery($sql_oth);
		while($row=mysql_fetch_array($result_oth ))
		{
				$value = $row["dblQty"]*$row["dblUnitPrice"];
	?>	
                    <tr>
                      <td class="normalfntTAB" align="left"><?php echo $row["strItemDescription"];?></td>
                      <td class="normalfntTAB" align="center"><?php echo $row["dtmDeliveryDate"]; ?></td>
                      <td class="normalfntTAB" align="center"><?php echo $row["strUnit"];?></td>
                      <td class="normalfntTAB" align="right"><?php echo $row["dblQty"];?></td>
                      <td class="normalfntTAB" align="right"><?php echo $row["dblUnitPrice"];?></td>
                      <td class="normalfntTAB" align="right"><?php echo $value;?></td>
                    </tr>
		<?php
			$sum+=$value;	
		}
		?>
                    <tr>
                      <td colspan="5" class="normalfnt">&nbsp;</td>
                      <td class="normalfntTAB" align="right"><b><?php echo $sum;?></b></td>
                    </tr>
		
     
    </table></td>
  </tr>
  <tr>
  <tr>
    <td colspan="5" class="normalfnt">&nbsp;</td>
  </tr>
  </tr>
  
  <?php
  
  $sql_pre="select strRemarks,(select Name from useraccounts UA where UA.intUserID=GPH.intUserID)as preparedBy,
(select Name from useraccounts UA where UA.intUserID=GPH.intConfirmedBy)as confirmedBy
from generalpurchaseorderheader GPH where GPH.intGenPONo='$PONo' and GPH.intYear='$Year';";

 	 $result_pre = $db->RunQuery($sql_pre);
	while($row=mysql_fetch_array($result_pre))
		{
	  ?>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td width="11%" class="normalfnt">Prepared By </td>
        <td width="22%" class="normalfnt">:<?php echo $row["preparedBy"];?></td>
        <td width="11%" class="normalfnt">Checked By </td>
        <td width="22%" class="normalfnt">:</td>
        <td width="11%" class="normalfnt">Approved By </td>
        <td width="22%" class="normalfnt">:<?php echo $row["confirmedBy"];?></td>
      </tr>
      <tr >
        <td colspan="6" class="bcgl1txtLB">Remarks   :-<?php echo $row["strRemarks"];?></td>
      </tr>
	<?php
	}
	?>
      <tr >
        <td colspan="6" class="normalfnt">&nbsp;</td>
      </tr>
      <tr >
        <td colspan="6" class="normalfnt">Terms : </td>
      </tr>
      <tr >
        <td colspan="6" class="normalfnt">1. Please confirm the receipt of this purchase and our requested delivery date. </td>
      </tr>
      <tr >
        <td colspan="6" class="normalfnt">2. Please send your proforma invoice within 03 days upon receipt of this. </td>
      </tr>
      <tr >
        <td colspan="6" class="normalfnt">3. Goods supplied and that do not meet our specifications will not be accepted. </td>
      </tr>
      <tr >
        <td colspan="6" class="normalfnt">4. This purchase order number should appear on all invoices, Delivery notes and all correspondence relating to this purchase. </td>
      </tr>
      <tr >
         <td colspan="6" class="normalfnt">&nbsp;</td>        
	    </tr>
      

    </table></td>
  
</table>
</body>
</html>
