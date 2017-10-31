<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";

			$styleID		= $_GET["styleID"];		
			$buyerPoNo		= $_GET["buyerPoNo"];
			$matDetailID	= $_GET["matItemList"];
			$color			= $_GET["color"];
			$size			= $_GET["size"];
			$mainStores		= $_GET["mainStoreID"];

$sql = "SELECT intCompanyId FROM mainstores WHERE strMainID = '$mainStores'";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$pocompany = $row["intCompanyId"];
}

?>
<?php
$sqldesc="select strItemDescription from matitemlist where intItemSerial= $matDetailID";
$result_desc=$db->RunQuery($sqldesc);
while($row_desc=mysql_fetch_array($result_desc))
{
	$itemDescription 	= $row_desc["strItemDescription"];
}
?>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #B3F9AE}
-->
</style>
<table width="71%" border="0" bgcolor="#FFFFFF">
            <tr>
            <td height="16" colspan="7"  >
			<table width="100%"border="0" cellpadding="0" cellspacing="0">
                <tr class="mainHeading">
                  <td width="93%" height="25">Extra Details</td>
                  <td width="7%"  c>
		         <img src="../images/cross.png" alt="close" width="17" height="17"
				 onClick="CloseOSPopUp('popupLayer1');" class="mouseover" />				  </td>
                </tr>
              </table></td>
            </tr>
			<tr>
				<td colspan="7" class="normalfnth2"><?php echo $styleID .' :: '. $buyerPoNo .' :: '. $itemDescription .' :: '. $color .' :: '. $size;?></td>
			</tr>
            <tr>
          <td height="0" colspan="7" class="normalfnt"><table width="89%" border="0" class="bcgl1">
                <tr>
                  <td width="100%"><div align="center">
                    <div id="divcons" style="overflow:scroll; height:175px; width:690px;">
                      <table id="mytable" width="673" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                        <tr class="mainHeading4">
						<td width="19" >&nbsp;</td>
                          <td width="104" >PONo</td>
                          <td width="164"  height="20" >PO Date</td>
                          <td width="121" >GRN No </td>
						  <td width="158" >GRN Date </td>
						  <td width="106" >Batch No </td>
					    </tr>
<?php
 $loop=0;
$sql="select distinct 
GH.intStatus AS grnStatus,
PD.intPONo,
PD.intYear,
dtmDate,
concat(intGRNYear,'/',intGrnNo)AS grnNo,
dtmRecievedDate,
strBatchNO 
from purchaseorderheader PH
Inner join purchaseorderdetails PD ON PH.intPONo=PD.intPONo AND PH.intYear=PD.intYear
left Outer Join grnheader GH ON PH.intPONo=GH.intPoNo AND PH.intYear=GH.intYear
where  PD.intStyleId='$styleID' 
AND PD.strBuyerPONO='$buyerPoNo'
AND PD.intMatDetailID='$matDetailID'
AND PD.strColor='$color'
AND PD.strSize='$size'
AND PH.intStatus ='10'
AND PH.intDelToCompID='$pocompany';";

$result=$db->RunQuery($sql);

while($row=mysql_fetch_array($result))
{
$pono		= $row["intYear"].'/'.$row["intPONo"];
$poStatus	= $row["poStatus"];

$grnStatus	= $row["grnStatus"];
$grnNo		="";
$grnDate	= "";
$grnBatchNO	= "";

	
	if($grnStatus==1)
	{
		$grnNo		= $row["grnNo"];
		$grnDate	= $row["dtmRecievedDate"];
		$grnBatchNO	= $row["strBatchNO"];
	}
		
?>
<tr class="bcgcolor-tblrowWhite">
	<td class="normalfntMid" height="20"><?php echo ++$loop;?></td>
	<td class="normalfntMid" ><?php echo $pono;?></td>
	<td class="normalfntMid" ><?php echo $row["dtmDate"];?></td>
	<td class="normalfntMid" ><?php echo $grnNo;?></td>
	<td class="normalfntMid" ><?php echo $grnDate;?></td>
	<td class="normalfntRite"><?php echo $row["strBatchNO"];?></td>
	</tr>
<?PHP	
$balance += $qty;

}
?>
                      </table>
                    </div>
                  </div></td>
            </tr>
              </table></td>
  </tr>
<!--  //-------------->
<tr class="mainHeading">
<td height="25">Roll Details</td>
</tr>
              <tr>
          <td height="0" colspan="7" class="normalfnt"><table width="89%" border="0" class="bcgl1">
                <tr>
                  <td width="100%"><div align="center">
                    <div id="divcons" style="overflow:scroll; height:185px; width:690px;">
                      <table id="mytable" width="781" cellpadding="0" cellspacing="1" border="0" bgcolor="#CCCCFF">
                        <tr class="mainHeading4">
						<td width="17" height="20">&nbsp;</td>
                          <td width="89" >PONo</td>
                          <td width="115"  >Supp Batch No </td>
                          <td width="131" >Company Batch No  </td>
						  <td width="138" >Received Qty</td>
						  <td width="99" >Approved Qty</td>
						  <td width="93" >Reject Qty </td>
					    </tr>
<?php
 $loop=0;
$sql="select intFRollSerialNO,intFRollSerialYear,intPoYear,intPoNo,intSupplierBatchNo,intCompanyBatchNo from fabricrollheader 
where intStyleId='$styleID'
and strBuyerPoNo='$buyerPoNo'
and strMatDetailID='$matDetailID'
and strColor='$color'
and intStoresID='$mainStores'
and intStatus=1;";

$result=$db->RunQuery($sql);

while($row=mysql_fetch_array($result))
{
$pono		= $row["intPoYear"].'/'.$row["intPoNo"];
$rollSerialNO	= $row["intFRollSerialNO"];
$rollSerialYear	= $row["intFRollSerialYear"];
	$sql_1="select sum(dblQty)as receivedQty,sum(dblApprovedQty)as approvedQty,sum(dblRejectedQty)as rejectQty 
from fabricrolldetails
where intFRollSerialNO='$rollSerialNO'
and intFRollSerialYear='$rollSerialYear'";
$result_1=$db->RunQuery($sql_1);
$row_1	= mysql_fetch_array($result_1);
$receivedQty	= $row_1["receivedQty"];
$approvedQty	= $row_1["approvedQty"];
$rejectQty	= $row_1["rejectQty"];
?>
<tr class="bcgcolor-tblrowWhite">
	<td class="normalfntMid" height="20"><?php echo ++$loop;?></td>
	<td class="normalfntMid" ><?php echo $pono;?></td>
	<td class="normalfntMid" ><?php echo $row["intSupplierBatchNo"];?></td>
	<td class="normalfntMid" ><?php echo $row["intCompanyBatchNo"];?></td>
	<td class="normalfntMid" ><?php echo $receivedQty;?></td>
	<td class="normalfntRite"><?php echo $approvedQty;?></td>
	<td class="normalfntRite"><?php echo $rejectQty;?></td>
	</tr>
<?PHP	
}
?>
                      </table>
                    </div>
                  </div></td>
            </tr>
              </table></td>
  </tr>
<!--  //--------------->
            <tr>
             
            </table>
</td>
            </tr>
</table>
