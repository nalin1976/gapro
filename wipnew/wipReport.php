<?php
include "../../Connector.php";

$checkDate	= $_GET["checkDate"];
$txtDfrom	= $_GET["txtDfrom"];
$txtDto		= $_GET["txtDto"];
$companyId	= $_GET["companyId"];
$PONo		= $_GET["PONo"];
$ReportType	= $_GET["ReportType"];
$i = 0;
if($ReportType=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="WipReport.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WIP REPORT</title>

<style type="text/css">
<!--
tbody.ctbody1 
{
        height: 580px;

        overflow-y: auto;

        overflow-x: hidden;
}
-->
</style>
</head>
<link type="text/css"  href="../../css/erpstyle.css" rel="stylesheet" />
<style type="text/css">

    table.fixHeader {

        border: solid #FFFFFF;

        border-width: 1px 1px 1px 1px;

        width: 1050px;

    }

    tbody.ctbody {

        height: 580px;

        overflow-y: auto;

        overflow-x: hidden;

    }
</style>

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="head2">WIP REPORT</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  <td><table  width="100%" cellspacing="1" cellpadding="1"  bgcolor="#000000" id="tblMain" class="fixHeader">
  <thead>
            <tr bgcolor="#CCCCCC">
              <th  height="25"  width="2%" class="normalfntMid" nowrap="nowrap">No</th>
			  <th  height="25"  width="2%" class="normalfntMid" nowrap="nowrap">Manufacturer </th>
              <th  height="25"  width="2%" class="normalfntMid" nowrap="nowrap">Order No</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Style No</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Buyer</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Order Qty</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Color</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Season</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Cut Qty</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Cut Rate</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Cut Total Value</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Issued to factory</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Balance</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Canceled</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">GPT In Qty</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Return Qty</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Variance</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">In Put</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Out Put </th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">In Out Balance</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Missing PCs Charge Back </th>
              <th   width="1%" class="normalfntMid" nowrap="nowrap">Wash Ready</th>
              <th   width="1%" class="normalfntMid" nowrap="nowrap">Wash Balance</th>
              <th   width="1%" class="normalfntMid" nowrap="nowrap">Finish Good Gp</th>
              <th   width="1%" class="normalfntMid" nowrap="nowrap">Finish Good Received</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Sewing Tot Balance </th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Sewing Rates</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Sewing Tot Value</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Wash Rec</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Missing Pcs Carge Back & QC/Wash/Sand Blast Standard For Washing Plant</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Issued Wash</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Sent Pcs</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">Wsh Return</th>
              <th   width="2%" class="normalfntMid" nowrap="nowrap">At Washing</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Wash Rate</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Wash Total Value</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Checking Trimming Input</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Checking Trimming Output</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Balance</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Packing Input</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Packed</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Packing For Sample</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Return To Stores</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Packed Balance</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Packing Total Pcs</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Packing Rate</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Packing Total Value</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">FG Out From Fact</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Shipped Qty</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Finished TTL</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Finished Rate</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Finished Value</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">INV.NO</th>
			  <th   width="2%" class="normalfntMid" nowrap="nowrap">Balance at yard</th>
              <th width="5%"  class="normalfntMid">&nbsp;</th>
			  </tr>
        </thead>
          <tbody class="ctbody1">
		<?php
          
		   $sql ="select comp.strName,
		   			ordr.intStyleId,
					ordr.strStyle,
					ordr.strOrderNo,
					WV.dblCutting,
					WV.dblSewing,
					pwip.intStyleID, 
					pwip.strColor, 
					pwip.strSeason, 
					pwip.intSourceFactroyID, 
					pwip.intDestinationFactroyID, 
					pwip.intOrderQty, 
					pwip.intCutQty, 
					pwip.intCutIssueQty, 
					pwip.intCutReceiveQty, 
					pwip.intCutReturnQty, 
					pwip.intInputQty, 
					pwip.intOutPutQty, 
					pwip.intMissingPcs, 
					pwip.intWashReady, 
					pwip.intSentToWash, 
					pwip.intMissingPcsBeforeWash, 
					pwip.intIssuedtoWash, 
					pwip.intFGReturnsBeforeWash,
					pwip.intFGgatePass, 
					pwip.intFGReceived,
					ordr.intQty,
					ordr.intSeasonId,
					ordr.reaSMV,
					ordr.reaSMVRate,
					B.buyerCode
					from 
					productionwip pwip inner join orders ordr on ordr.intStyleID=pwip.intStyleID
					left join companies comp on comp.intCompanyID=pwip.intDestinationFactroyID
					inner join wip_valuation WV on WV.intCompanyId=pwip.intDestinationFactroyID
					inner join buyers B on B.intBuyerID=ordr.intBuyerID
					where pwip.intStyleID <> 'a' "; 
		
		if($companyId!="")
		$sql .= "and pwip.intDestinationFactroyID='$companyId' ";
		
		if($PONo!="")
		$sql .= "and pwip.intStyleID='$PONo' ";
		
		$sql .= "order by ordr.strOrderNo";
		$result=$db->RunQuery($sql);
		
		while($row=mysql_fetch_array($result))
		{
			
			$season = '';
			if($row["intSeasonId"] != '')	
			$season = getSeason($row["intSeasonId"]);
			$Cuttingbalance = $row["intCutQty"]-$row["intCutIssueQty"];
			$inOutBal = $row["intInputQty"]-$row["intOutPutQty"];
			$cutRate = round((($row["reaSMV"]*$row["dblCutting"])/100)*($row["reaSMVRate"]),4);
			$sewingTotBal = ($row["intOutPutQty"]-$row["intWashReady"]);
			$sewingRate = round((($row["reaSMV"]*$row["dblSewing"])/100)*($row["reaSMVRate"]),4);
	
        ?>            
            <tr bgcolor="#FFFFFF">
              <td  height="25" class="normalfntMid"  nowrap="nowrap"><?php echo ++$i; ?></td>
			  <td  height="25" class="normalfnt"  nowrap="nowrap"><?php echo $row["strName"]; ?></td>
              <td  height="25" class="normalfnt"  nowrap="nowrap" id="<?php echo $row["intStyleId"]; ?>"><?php echo $row["strOrderNo"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $row["buyerCode"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intQty"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $row["strColor"]; ?></td>
              <td  class="normalfnt"  nowrap="nowrap"><?php echo $season; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intCutQty"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo number_format($cutRate,4); ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo number_format(($Cuttingbalance>=0?$Cuttingbalance:0)*$cutRate,4); ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intCutIssueQty"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo ($Cuttingbalance>=0?$Cuttingbalance:0) ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo ($Cuttingbalance<0?($Cuttingbalance*-1):0) ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intCutReceiveQty"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intCutReturnQty"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intInputQty"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intOutPutQty"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $inOutBal; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intWashReady"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intFGgatePass"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $row["intFGReceived"]; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo $sewingTotBal; ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo number_format($sewingRate,4); ?></td>
              <td  class="normalfntRite"  nowrap="nowrap"><?php echo number_format($sewingTotBal*$sewingRate,4); ?></td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
			  <td  class="normalfntRite"  nowrap="nowrap">0</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			  </tr>
      <?php
		}
		?>
        <tr class="bcgcolor-tblrowWhite">
          <td colspan="55" class="normalfnt" nowrap="nowrap" >&nbsp;</td>
        </tr>
      </tbody>
     </table>
  </td>
  </tr>
</table>
<script type="text/javascript">

var prev_row_no=-99;

var pub_bg_color_click='#FFFFFF';

$(document).ready(function()
{
     $('#tblMain tbody tr').click(function(){
         if($(this).attr('bgColor')!='#82FF82')
             {
                 var color=$(this).attr('bgColor')
                 $(this).attr('bgColor','#82FF82')
                 if(prev_row_no!=-99){
                    $('#tblMain tbody')[0].rows[prev_row_no].bgColor=pub_bg_color_click;           
                       }
                  if(prev_row_no==$(this).index())
                   {
                         prev_row_no=-99

                                }

						else
							prev_row_no=$(this).index()                                   

						pub_bg_color_click=color                  
					   }                                             
		})
});

</script>

</body>
</html>
<?php
function getSeason($seasonId)
{
	global $db;
	$sql = " select strSeason from seasons where intSeasonId='$seasonId' ";
	$result = $db->RunQuery($sql); 
	$row = mysql_fetch_array($result);
	
	return $row["strSeason"];
}
?>