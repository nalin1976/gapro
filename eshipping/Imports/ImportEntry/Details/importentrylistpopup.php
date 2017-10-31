<?php
include("../../../Connector.php");
session_start();

?>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<td width="62%"><table width="100%" border="0">
          <tr>
            <td width="95%" height="30" bgcolor="#588DE7" class="TitleN2white">Import Entry Listing </td>
            <td width="5%" bgcolor="#588DE7" class="TitleN2white"><img src="../../../images/cross.png" alt="popupclose" width="17" height="17" onClick="closeWindow();"></td>
          </tr>
          <tr bgcolor="#FEFDEB">
            <td height="96" colspan="2">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td width="100%" bgcolor="#FFFFFF" class="normalfnt"><div id="divGatePassDetails" style="overflow:scroll; height:320px; width:600px;">
                    <table id="tblpopup" width="580" cellpadding="0" cellspacing="1"  bgcolor="#CCCCFF">
			  <tr>
				<td width="3%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Delivery No </td>
				<td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice No </td>
				<td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Entry No </td>
				<td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Cleared Date </td>
			  </tr>
<?php
$sql="select 
intDeliveryNo,
strInvoiceNo,
strEntryNo,
date(dtmClearedOn)AS date
from deliverynote
where intStatus=1";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
				
  <tr class="bcgcolor-tblrowWhite mouseover" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';" onDblClick="GetDetailsToMainPage(this);">
	<td height="15" class="normalfntMid"><?php echo $row["intDeliveryNo"];?></td>
	<td class="normalfntMid"><?php echo $row["strInvoiceNo"];?></td>
	<td class="normalfntMid"><?php echo $row["strEntryNo"];?></td>
	<td class="normalfntMid"><?php echo $row["date"];?></td>
  </tr>  
<?php
}
?>              
                    </table>
                  </div></td>
                </tr>
              </table></td>
          </tr>
        </table></td>