<?php

include "../../Connector.php";

		
?>

<link href="../panelCSS.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../css/erpstyle.css"/>




  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
      <td align="center" class="normalfnt">
      <table width="950" height="550" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="100%" valign="top">
             
              
            <fieldset  class="fieldsetPnl" style="display:none" >
              <legend class="lengendfntPnl">Graphical View</legend>
              <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td >
                  <div id="graphicDivPD" style="width:650px;height:30px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                 	<table>
                    	<tr class="mouseover">
                                              
                        
                          <td width="70" >MRN No 
						</td>
 <td width="150" ><select id="cboMrnno" class="txtbox" style="width:150px" name="cboMrnno" onChange="loadMrnDetailsToGrid();"></select></td>  
 
 <td  height="23" width="21" >&nbsp;</td>
                         <td  width="15" >&nbsp;</td>
                        
                       
                        <td height="23" width="12" >&nbsp;</td>
                         <td width="13">&nbsp;</td>
                            
                       
                     
                       
                        <td  height="23" width="10">&nbsp;</td>
                         <td width="289" ><img id="btCompleteEvent" class="mouseover" height="23" width="79" title="Tick events & click this for completing your events" 	                             onclick="completeEvent();" name="btCompleteEvent" src="images/btComplete.png" /></td>
                        </tr>
                    </table>
                  </div></td>
                  </tr>
                </table></fieldset>
              </td>
              </tr>
            <tr>
              <td colspan="2" valign="top">
              <fieldset  class="fieldsetPnl"><legend class="lengendfntPnl">Details View</legend>
              <table width="930" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                  <div id="mainGridHeadDivPD" style="width:913px;height:30px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                    <table width="928" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" id="table1PD" style="width:913px;">
                   
                      <tr class="gridHdrTxtPnlMn">
                          
                         
                          <td style="background-color:#FFF;"></td>
                          
                      </tr>
                      <tr bgcolor="#fbbf6f" class="gridHdrTxtPnl" style="width:100%;" >
       
                        <td width="9%">SC No</td>
                        <td width="19%" height="30">Customer</td>
                        <td width="10%">Delivery Date</td>
                        <td width="12%">Last Shipment Date</td>
                        <td width="11%">Order Qty</td>
                        <td width="13%">Shipped Qty</td>
                       <td width="12%">Shipped %</td>
                       <td width="14%">SO Status</td>
                      </tr>
                    </table>
                    
                  </div>
                  </td>
                  </tr>
                <tr>
                
                  <td><div id="mainGridDataDivPD" style="overflow:scroll; height:450px; width:930px;" onMouseDown="scrollGridHead('mainGridHeadDivPD','mainGridDataDivPD');">
              <table  style="width:913px;" border="0" cellpadding="0" cellspacing="1" id="MRNtbl" bgcolor="#FFFFFF">
                      <thead>
                      
                      <tr class="gridHdrTxtPnlMn">
                          
                         
                          <td style="background-color:#FFF;"></td>
                          
                      </tr>
                      <tbody>
                       <tr class="gridHdrTxtPnlMn">
                          
                         
                          <td style="background-color:#FFF;"></td>
                          
                      </tr>
                      </tbody>
                      </thead>
                    </table>
               <?php

function shippedQty($scNo)
{
$con_Eshipping = mysql_connect('172.23.1.15','exporemote','Exp0U$3r2016') or die (mysql_error());
$shipping_db = mysql_select_db('myexpo',$con_Eshipping) or die ('Connection to gapros db failed.');
				
		 $shpStyle = "SELECT
					pre_invoice_detail.strSC_No,
					pre_invoice_detail.strStyleID
					FROM
					pre_invoice_detail
					WHERE
					pre_invoice_detail.strSC_No = '$scNo'
					GROUP BY
					pre_invoice_detail.strSC_No";

$resultSt = @mysql_query($shpStyle);
$_rowSt = mysql_fetch_array($resultSt);
$StyleNo=$_rowSt['strStyleID'];

//echo "AAA".$StyleNo."XX";

		
		$cm_query2 = "SELECT
cdn_detail.strStyleID,
Sum(cdn_detail.dblQuantity) AS Qty,
cdn_detail.strUnitID
FROM
cdn_detail
WHERE
cdn_detail.strStyleID = '$StyleNo'
GROUP BY
cdn_detail.strStyleID";

$result2 = @mysql_query($cm_query2);
$_rowCdn2 = mysql_fetch_array($result2);

if($StyleNo!=""){
	$cdnQty=$_rowCdn2['Qty']." ".$_rowCdn2['strUnitID'];
}else{
		$cdnQty=0;
	}
//echo "AA".$cdnQty."XX";

return $cdnQty;
		mysql_close($con_Eshipping);
}


function lastShipDate($scNo)
{
$con_Eshipping = mysql_connect('172.23.1.15','exporemote','Exp0U$3r2016') or die (mysql_error());
$shipping_db = mysql_select_db('myexpo',$con_Eshipping) or die ('Connection to gapros db failed.');
				
				
				
		$cm_query = "SELECT
		pre_invoice_detail.strSC_No,
		date(cdn_header.dtmDate) AS cdnDate
		FROM
		cdn_header
		INNER JOIN pre_invoice_detail ON cdn_header.strInvoiceNo = pre_invoice_detail.strInvoiceNo
		WHERE
		pre_invoice_detail.strSC_No ='$scNo'
		ORDER BY
		cdn_header.dtmDate DESC
		LIMIT 1";

$result = @mysql_query($cm_query);
while($_rowCdn = mysql_fetch_array($result)){
$cdnDate=$_rowCdn['cdnDate'];

	
	}

return $cdnDate;
		mysql_close($con_Eshipping);
}



		$sql = "SELECT
		specification.intSRNO,
		buyers.strName,
		DATE(deliveryschedule.dtDateofDelivery) AS dtDateofDelivery,
		Sum(orders.intQty) AS OrderQty,
		orders.intStyleId,
		orders.intStatus
		FROM
		orders
		INNER JOIN specification ON orders.intStyleId = specification.intStyleId
		INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
		INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId
		WHERE
Year(orders.dtmDate) >2016
		GROUP BY
		orders.intStyleId
		ORDER BY
		orders.intStyleId DESC ";
		$result=$db->RunQuery($sql);
//echo $sql;
while($row=mysql_fetch_array($result))
{
	
	$scNo = 	$row["intSRNO"];
	 $lastShipDate = lastShipDate($scNo);
	 $shippedQty = shippedQty($scNo);
	if($lastShipDate!=""){
		$lastShipDate=$lastShipDate;
		}else{
				$lastShipDate="0000-00-00";
			}
			
			
	
?>     
                    
       <table width="928" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" id="table1PD" style="width:913px;">
                   
                      <tr class="gridHdrTxtPnlMn">
                          
                         
                          <td style="background-color:#FFF;"></td>
                          
                      </tr>
                      <tr  class="gridHdrTxtPnl" style="width:100%;" >
       
                        <td width="9%"><?php echo $row["intSRNO"]?></td>
                        <td width="19%" height="30"><?php echo $row["strName"];?></td>
                        <td width="10%"><?php echo $row["dtDateofDelivery"];?></td>
                        <td width="12%"><?php echo $lastShipDate;?></td>
                        <td width="11%"><?php echo $row["OrderQty"];?></td>
                        <td width="13%"><?php echo $shippedQty;?></td>
                        <td width="12%"><?php echo round(($shippedQty/$row["OrderQty"])*100,2) ." %";?></td>
                        <td width="14%"><?php $status =  $row["intStatus"];
			
			
			switch ($status) {
    case "0":
        echo "Pre order mode";
        break;
    case "10":
        echo "1<sup>st</sup> approved";
        break;
    case "11":
        echo "Order Processing";
        break;
    case "12":
        echo "Reject orders";
		break;
		
	case "16":
		echo "Order Complete";
		break;
		
	case "14":
		echo "Cancel orders";
		break;
		
	case "20":
		echo "Style Process Pending";
		break;
		
	case "25":
		echo "Pending For 3<sup>rd</sup> Approval";
		break;
		
	default:
        echo $status;
}?></td>
                       
                      
                      </tr>
                    </table>             
                    
                    
                    
                    
                    
    <?php
}
?>                
                  
                  </div></td>
                  
                  </tr>
              </table></fieldset></td>
              </tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>