<?php 
session_start();
include "../../Connector.php"; 
$backwardseperator 	= "../../";


$report_companyId  =$_SESSION["FactoryID"];

$genTranferNo   = $_GET["TransferInNo"];
$genTranferYear = $_GET["TransferInYear"];
//$status			= $_GET["Status"];

$sql="SELECT (SELECT C.strName FROM companies C WHERE C.intCompanyID = GTH.intCompanyId)AS location, 
(SELECT U.Name FROM useraccounts U WHERE GTH.intUserId = U.intUserID)AS preparedBy, 
GTH.dtmDate, GTH.intStatus
FROM gengatepasstransferinheader GTH 
WHERE GTH.intTransferInNo ='$genTranferNo' AND GTH.intTransferInYear ='$genTranferYear';";
	
		$result = $db->RunQuery($sql);
		
		while($row=mysql_fetch_array($result))
		{	
			$location		= $row["location"];
			$dtmDate		= $row["dtmDate"];						
			$preparedby		= $row["preparedBy"];			
			$Status			= $row["intStatus"];
		}
		//echo $sql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General GatePass :: Report</title>
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
    <td colspan="5"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" width="100%"><?php include '../../reportHeader.php'?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td height="38" class="head2">GENERAL GATE PASS TRANFER IN REPORT </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0">
      <tr>
        <td width="22%" class="normalfnth2B">GATEPASS TRANFER IN NO</td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="38%" class="normalfnt"><?php echo $genTranferYear."/".$genTranferNo;?></td>
        <td width="13%" class="normalfnth2B"> DATE &amp; TIME </td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="25%" class="normalfnt"><?php echo $dtmDate;
		?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">LOCATION</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo $location;?></td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="10%" height="35" class="normalfntBtab">ITEM CODE </td>
        <td width="63%" class="normalfntBtab">ITEM DESCRIPTION </td>
        <td width="12%" class="normalfntBtab">UNIT</td>
        <td width="15%" class="normalfntBtab">QTY</td>
        </tr>
					<?php 
$sum = 0;

$sql_details="select GD.*,GMIL.strItemDescription,GMIL.strUnit
from gengatepasstransferindetails GD
Inner Join genmatitemlist GMIL ON GD.intMatDetailId=GMIL.intItemSerial
where intTransferInNo=$genTranferNo AND intTransferInYear=$genTranferYear";

			$result_details = $db->RunQuery($sql_details);
		while($row_details=mysql_fetch_array($result_details ))
		{
		

	?>
        <tr> 
			<td class="normalfntTAB"><?php echo $row_details["intMatDetailId"];?></td>
          	<td  class="normalfntTAB"><?php echo $row_details["strItemDescription"];?></td>
			<td  class="normalfntMidTAB"><?php echo $row_details["strUnit"];?></td>
        <td class="normalfntRiteTAB"><?php echo $row_details["dblQty"]; $sum  += $row_details["dblQty"];?></td>
        </tr>
		<?php		
		}
		?>
      <tr>
        <td colspan="3" class="normalfnt2bldBLACKmid">TOTAL</td>
        <td class="normalfntRiteTABb-ANS"><?php echo $sum;?></td>
        </tr>
    </table></td>
  </tr>
  	<td height="20"/>
  <tr>
  </tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td width="25%" class="bcgl1txt1"><?php echo $preparedby?></td>        
		<td width="10%">&nbsp;</td>       
        <td width="25%"  class="bcgl1txt1">&nbsp;</td>
		<td width="10%">&nbsp;</td> 
		<td width="25%"  class="bcgl1txt1"></td>        
      </tr>
      <tr>	    
        <td class="normalfntMid">PREPARED BY</td>       
        <td>&nbsp;</td>    
        <td class="normalfntMid">AUTHORISED BY</td>
		<td>&nbsp;</td>
		<td class="normalfntMid">INSTRUCTED BY</td>
      </tr>
	   <tr>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>        
		<td width="10%">&nbsp;</td>       
        <td width="25%"  class="bcgl1txt1">&nbsp;</td>
		<td width="10%">&nbsp;</td> 
		<td width="25%"  class="bcgl1txt1">&nbsp;</td>        
      </tr>
      <tr>	    
        <td class="normalfntMid">DELIVERED BY</td>       
        <td>&nbsp;</td>    
        <td class="normalfntMid">TIME OUT</td>
		<td>&nbsp;</td>
		<td class="normalfntMid">SIGNATURE SECURITY</td>
      </tr>

    </table></td>
  
</table>
</body>
</html>
<?php 
if($Status==10)
{
	echo "<div style=\"position:absolute;top:120px;left:400px;\"><img src=\"../../images/cancelled.png\" style=\"-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);\" /></div>";
}
else if($Status==0)
{
	echo "<div style=\"position:absolute;top:120px;left:180px;\"><img src=\"../../images/pending.png\"/></div>";
}
?>