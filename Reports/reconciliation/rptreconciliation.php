<?php

session_start();
include "../../Connector.php";
include "../../helasite/ConnectorHelaSite.php";
$backwardseperator = "../../";

$iuserCompanyId  	= $_SESSION["FactoryID"];
$report_companyId = $iuserCompanyId;
	
$iStyleId = $_GET['StyleNo'];
$booWith0 = $_GET['with0'];
$iMainStores = $_GET['mainStores'];

#==== Get Order header information ==========================
#============================================================
	
$sqlOrderHeader = " SELECT specification.intSRNO, orders.strStyle, buyers.strName, useraccounts.Name 
FROM
orders
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
Inner Join specification ON orders.intStyleId = specification.intStyleId
Inner Join useraccounts ON orders.intCoordinator = useraccounts.intUserID
WHERE
orders.intStyleId = '$iStyleId'";

$resOrderHeader = $db->RunQuery($sqlOrderHeader);

while($rowOrderHeader=mysql_fetch_array($resOrderHeader)){
	
	$_scno = $rowOrderHeader['intSRNO'];
	$_styleno = $rowOrderHeader['strStyle'];
	$_sbuyername = $rowOrderHeader['strName'];
	$_smerchant = $rowOrderHeader['Name'];
	
}
#============================================================================	
	
	
#============================================================================	
# Get stores locations for style	
#============================================================================	

$sqlStores = " SELECT DISTINCT mainstores.strName, mainstores.strMainID, mainstores.intCompanyId
FROM
stocktransactions
Inner Join mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
WHERE
stocktransactions.intStyleId = '$iStyleId'
GROUP BY  mainstores.strMainID, mainstores.strName, mainstores.intCompanyId
HAVING SUM(dblQty)>0";

$resStores = $db->RunQuery($sqlStores);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Item Reconciliation</title>
<style type="text/css">
.header{font-family:Tahoma, Geneva, sans-serif; font-size:12px; font-weight:bold;}
.headerline{font-family:Tahoma, Geneva, sans-serif; font-size:12px;}
.headerleft{font-family:Tahoma, Geneva, sans-serif; 
			font-size:11px; 
			font-weight:bold; 
			text-align:left;
			border-top:#000 thin solid;
			border-left:#000 thin solid;
			border-bottom:#000 thin solid;}
.headercenter{font-family:Tahoma, Geneva, sans-serif; 
			  font-size:11px; 
			  font-weight:bold; 
			  text-align:center;
			  border-top:#000 thin solid;
			  border-left:#000 thin solid;
			  border-bottom:#000 thin solid;}
.headerright{font-family:Tahoma, Geneva, sans-serif; 
			  font-size:11px; 
			  font-weight:bold; 
			  text-align:right;
			  border-top:#000 thin solid;
			  border-left:#000 thin solid;
			  border-bottom:#000 thin solid;}
.headerfinalcol{font-family:Tahoma, Geneva, sans-serif; 
			  font-size:11px; 
			  font-weight:bold; 
			  text-align:right;
			  border:#000 thin solid;}
.lineleft{font-family:Tahoma, Geneva, sans-serif; 
			font-size:11px;
			text-align:left;
			border-left:#000 thin solid;
			border-bottom:#000 thin solid;}
			
.lineright{font-family:Tahoma, Geneva, sans-serif; 
			font-size:11px;
			text-align:right;
			border-left:#000 thin solid;
			border-bottom:#000 thin solid;}	

.linerightend{font-family:Tahoma, Geneva, sans-serif; 
			  font-size:11px;
			  text-align:right;
			  border-left:#000 thin solid;
			  border-bottom:#000 thin solid;
			  border-right:#000 thin solid;}	

.linecenter{font-family:Tahoma, Geneva, sans-serif; 
			font-size:11px;
			text-align:center;
			border-left:#000 thin solid;
			border-bottom:#000 thin solid;}	
			
.footer{font-family:Tahoma, Geneva, sans-serif; 
			font-size:10px;
			text-align:center;}							  
			
			  
</style>
</head>

<body>
<table width="101%">
<tr><td height="30">&nbsp;</td></tr>
 <tr>
    <td style="font-family:Tahoma, Geneva, sans-serif; font-size:13px; font-weight:bold; text-align:left;"><?php include $backwardseperator.'reportHeader.php'?></td>
  </tr>
<tr>
<tr><td style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; font-weight:bold; text-align:center;">&nbsp;Left Over Stocks Report</td></tr>
<td>
	<table width="648">
    	<tr>
        	<td width="149" class="header">SC</td>
            <td width="178" class="headerline"><?php echo $_scno; ?></td>
            <td width="70" class="header">Style No</td>
            <td width="231" class="headerline"><?php echo $_styleno; ?></td>
        </tr>    
        <tr>
        	<td width="149" class="header">Buyer Name</td>
            <td width="178" class="headerline"><?php echo $_sbuyername; ?></td>
        </tr>    
        <tr>
        	<td width="149" class="header">Merchandiser</td>
            <td width="178" class="headerline"><?php echo $_smerchant; ?></td>            
        </tr>    
        <tr>
        	<td width="149" class="header">Last Shippment Flaged</td>
            <td width="178" class="headerline"><?php echo GetLastShipCompletedDate($_scno); ?></td>            
        </tr>    
        
    </table>
</td>
</tr>
<tr><td>&nbsp;</td></tr>

<?php 
	while($rowStores=mysql_fetch_array($resStores)){
		
		$iStoresId = $rowStores['strMainID'];
		$sStores = $rowStores['strName'];
		$iCompanyId = $rowStores['intCompanyId'];
		
?>
	<tr><td>
    	<table width="100%" border="0">
        	<tr><td width="7%" class="header">Stores Location</td><td width="93%" class="headerline"><?php echo $sStores; ?></td></tr>
        </table>
    </td></tr>	
	<tr><td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr><td width="30%" class="headerleft">&nbsp;Material Description</td>
                    <td width="4%" class="headerleft">&nbsp;Size</td>
                    <td width="4%" class="headerleft">&nbsp;Color</td>
                    <td width="3%" class="headercenter">UOM</td>
                    <td width="4%" class="headerright">Avg. PO Price&nbsp;</td>
                    <td width="5%" class="headerright">Ordered Qty&nbsp;</td>
                    <td width="5%" class="headerright">Recieved Qty&nbsp;</td>
                    <td width="4%" class="headercenter">Recieved/Ordered (%)</td>
                    <td width="5%" class="headerright">Return to Supplier&nbsp;</td>
                    <td width="5%" class="headerright">Gate Pass IN&nbsp;</td>
                    <td width="5%" class="headerright">Gate Pass OUT&nbsp;</td>
                    <td width="5%" class="headerright">Transfer IN Qty&nbsp;</td>
                    <td width="5%" class="headerright">Transfer OUT Qty&nbsp;</td>
                    <td width="5%" class="headerright">Issued QTY&nbsp;</td>
                    <!--<td width="8%">Return To Stores</td>-->                    
                    <td width="8%" class="headerright">Stock In Hand&nbsp;</td>
                    <td width="4%" class="headercenter">Stock In Hand/Recieved (%)</td>
                    <td width="7%" class="headerfinalcol">Value&nbsp;</td>
                </tr>
				<?php	
	
	#=======================================================================
	# Get the item details by the stores location
	#========================================================================
	
			$sqlItem = " SELECT DISTINCT
		matitemlist.strItemDescription,
		materialratio.strColor,
		materialratio.strSize,
		specificationdetails.strUnit,
		matitemlist.intItemSerial,
		materialratio.strBuyerPONO,
		Sum(stocktransactions.dblQty) AS StockQty,
		matitemlist.intItemSerial
		FROM
		matitemlist
		Inner Join specificationdetails ON matitemlist.intItemSerial = specificationdetails.strMatDetailID
		Inner Join materialratio ON specificationdetails.intStyleId = materialratio.intStyleId AND specificationdetails.strMatDetailID = materialratio.strMatDetailID
		Inner Join stocktransactions ON materialratio.intStyleId = stocktransactions.intStyleId AND materialratio.strMatDetailID = stocktransactions.intMatDetailId AND materialratio.strColor = stocktransactions.strColor AND materialratio.strSize = stocktransactions.strSize AND materialratio.strBuyerPONO = stocktransactions.strBuyerPoNo
		WHERE
		specificationdetails.intStyleId =  '$iStyleId' AND
		specificationdetails.intStatus =  '1' AND
		stocktransactions.strMainStoresID =  '$iStoresId'
		GROUP BY
		matitemlist.strItemDescription,
		materialratio.strColor,
		materialratio.strSize,
		specificationdetails.strUnit,
		matitemlist.intItemSerial,
		materialratio.strBuyerPONO
		HAVING 
		ROUND(Sum(stocktransactions.dblQty),2)>0
		ORDER BY
matitemlist.intMainCatID ASC";
		
		//echo $sqlItem;
		
		$resItemDetails = $db->RunQuery($sqlItem);
			
			while($rowItems = mysql_fetch_array($resItemDetails)){
				
			$_dblRcvPercentage = 0;
			$_dblBalPercentage = 0;
				
			$_itemcode = $rowItems['intItemSerial'];	
			$_color = $rowItems['strColor'];	
			$_size = $rowItems['strSize'];	
			$_buyerpono = $rowItems['strBuyerPONO'];	
			$_dblStockInHand = $rowItems['StockQty'];	
				
			#====== Get PO Price ===================================
			$_dblPOPrice = 	GetPOPrice($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iCompanyId);
			#=======================================================
			
			#====== Get PO QTY ===================================
			$_dblPOQty = GetPOQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iCompanyId);
			#=======================================================
			
			#====== Get Received QTY ===================================
			$_dblRcvdQty = GetRecivedQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId);
			#=======================================================
			
			#====== Get Interjob transfer IN QTY ===================================
			$_dblTRInQty = GetTransferInQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId);
			#=======================================================
			
			#====== Get Interjob transfer OUT QTY ===================================
			$_dblTROutQty = GetTransferOutQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId);
			#=======================================================
			
			#====== Get Issued QTY ===================================
			$_dblIssuedQty = GetIssuedQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId)*-1;
			#=======================================================
			
			
			#====== Get Return to supplier QTY ===================================
			$_dblRetSupQty = GetReturnToSupQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId)*-1;
			#=======================================================
			
			#====== Get GP IN QTY ===================================
			$_dblGPINQty = GetGPINQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId);
			#=====================================================================
			
			#====== Get GP OUT QTY ===================================
			$_dblGPOUTQty = GetGatePassOUT($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId)*-1;
			#=======================================================
			
			
			$_dblStockValue = (float)$_dblPOPrice * (float)$_dblStockInHand;
			
			if($_dblRcvdQty>0)
				$_dblRcvPercentage = ($_dblRcvdQty/$_dblPOQty)*100;
			if($_dblRcvdQty>0)	
				$_dblBalPercentage = ($_dblStockInHand/$_dblRcvdQty)*100;
			
			echo "<tr><td class='lineleft'>&nbsp;".$rowItems['strItemDescription']."</td><td class='lineleft'>&nbsp;".$_size."</td><td class='lineleft'>&nbsp;".$_color."</td><td class='linecenter'>".$rowItems['strUnit']."</td><td class='lineright'>".number_format($_dblPOPrice,5)."&nbsp;</td><td class='lineright'>".number_format($_dblPOQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblRcvdQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblRcvPercentage,2)."%&nbsp;</td><td class='lineright'>".number_format($_dblRetSupQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblGPINQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblGPOUTQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblTRInQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblTROutQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblIssuedQty,2)."&nbsp;</td><td class='lineright'>".number_format($_dblStockInHand,2)."&nbsp;</td><td class='lineright'>".number_format($_dblBalPercentage,2)."%&nbsp;</td><td class='linerightend'>".number_format($_dblStockValue,2)."&nbsp;</td></tr>";	
				
				
			}
		
?>		
              
            </table>
    	</td></tr>	
    <tr><td align="right" class="footer">&nbsp;</td></tr>    
	<tr><td align="right" class="footer"><?php include "../../commonPHP/footer.php"; ?></td></tr>		
      
		
<?php		
	
	}
?>

</table>
</body>
</html>
<?php

function GetPOPrice($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmDeliveryCompanyId){
	
	global $db;
	
	$_dblPOPrice = 0;
	
	$sqlPOPrice = " SELECT Avg(purchaseorderdetails.dblUnitPrice) AS PO_PRICE ".
	              " FROM   purchaseorderdetails Inner Join purchaseorderheader ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND ".
				  "        purchaseorderdetails.intYear = purchaseorderheader.intYear ".
				  " WHERE  purchaseorderheader.intStatus =  '10' AND purchaseorderdetails.intStyleId =  '$prmStyleId' AND ".
				  "        purchaseorderdetails.intMatDetailID =  '$prmItemCode' AND purchaseorderdetails.strColor =  '$prmColor' AND ".
                  "        purchaseorderdetails.strSize =  '$prmSize' AND purchaseorderdetails.strBuyerPONO =  '$prmBuyerPONo'";
				  // AND  purchaseorderheader.intDelToCompID = '$prmDeliveryCompanyId'";
	//echo $sqlPOPrice;			  
	$resPOPrice = $db->RunQuery($sqlPOPrice);
	
	while($rowPOPrice = mysql_fetch_array($resPOPrice)){
		$_dblPOPrice = $rowPOPrice['PO_PRICE'];	
	}
	
	return $_dblPOPrice;	
}


function GetPOQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmDeliveryCompanyId){
	
	global $db;
	
	$_dblPOQty = 0;
	
	$sqlPOQty = " SELECT SUM(purchaseorderdetails.dblQty) AS PO_QTY ".
	              " FROM   purchaseorderdetails Inner Join purchaseorderheader ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND ".
				  "        purchaseorderdetails.intYear = purchaseorderheader.intYear ".
				  " WHERE  purchaseorderheader.intStatus =  '10' AND purchaseorderdetails.intStyleId =  '$prmStyleId' AND ".
				  "        purchaseorderdetails.intMatDetailID =  '$prmItemCode' AND purchaseorderdetails.strColor =  '$prmColor' AND ".
                  "        purchaseorderdetails.strSize =  '$prmSize' AND purchaseorderdetails.strBuyerPONO =  '$prmBuyerPONo' AND ".
				  "        purchaseorderheader.intDelToCompID = '$prmDeliveryCompanyId'";
	//echo $sqlPOPrice;			  
	$resPOQty = $db->RunQuery($sqlPOQty);
	
	while($rowPOPrice = mysql_fetch_array($resPOQty)){
		$_dblPOQty = $rowPOPrice['PO_QTY'];	
	}
	
	return $_dblPOQty;	
}

function GetRecivedQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblReceivedQty = 0;
	
	$sqlReceivedQty = " SELECT SUM(stocktransactions.dblQty) AS RCVD_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'GRN' ";
	//echo $sqlReceivedQty;				  
	$resRcvdQty = $db->RunQuery($sqlReceivedQty);
	
	while($rowRcvdQty = mysql_fetch_array($resRcvdQty)){
		$_dblReceivedQty = $rowRcvdQty['RCVD_QTY'];	
	}
	
	return $_dblReceivedQty;	
 
}

function GetTransferInQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblTrInQty = 0;
	
	$sqlTrInQty = " SELECT SUM(stocktransactions.dblQty) AS TRIN_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'IJTIN' ";
	//echo $sqlReceivedQty;				  
	$resTrInQty = $db->RunQuery($sqlTrInQty);
	
	while($rowTrInQty = mysql_fetch_array($resTrInQty)){
		$_dblReceivedQty = $rowTrInQty['TRIN_QTY'];	
	}	
	return $_dblTrInQty;	
}

function GetTransferOutQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblTrOutQty = 0;
	
	$sqlTrOutQty = " SELECT SUM(stocktransactions.dblQty) AS TROUT_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'IJTOUT' ";
	//echo $sqlReceivedQty;				  
	$resTrOutQty = $db->RunQuery($sqlTrOutQty);
	
	while($rowTrOutQty = mysql_fetch_array($resTrOutQty)){
		$_dblTrOutQty = $rowTrOutQty['TROUT_QTY'];	
	}	
	return $_dblTrOutQty;	
}

function GetIssuedQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblIssuedQty = 0;
	
	$sqlIssuedQty = " SELECT SUM(stocktransactions.dblQty) AS ISSUED_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'ISSUE' ";
	//echo $sqlReceivedQty;				  
	$resIssuedQty = $db->RunQuery($sqlIssuedQty);
	
	while($rowIssuedQty = mysql_fetch_array($resIssuedQty)){
		$_dblIssuedQty = $rowIssuedQty['ISSUED_QTY'];	
	}	
	return $_dblIssuedQty;	
}

function GetReturnToSupQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblRetSupQty = 0;
	
	$sqlRetSupQty = " SELECT SUM(stocktransactions.dblQty) AS RETSUP_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'SRTSUP' ";
	//echo $sqlReceivedQty;				  
	$resRetSupQty = $db->RunQuery($sqlRetSupQty);
	
	while($rowRetSupQty = mysql_fetch_array($resRetSupQty)){
		$_dblRetSupQty = $rowRetSupQty['RETSUP_QTY'];	
	}	
	return $_dblRetSupQty;	
}

function GetLastShipCompletedDate($prmSCNo){
	
	global $dbHelaSite;
	
	$sql = "SELECT compledDate FROM d2d_master_style_main WHERE scNumber = '$prmSCNo'";
	
	$resShipComDate = $dbHelaSite->RunQuery($sql);
	
	while($row = mysql_fetch_array($resShipComDate)){
		
		return $row['compledDate'];
	}
	
}

function GetGPINQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblGPINQty = 0;
	
	$sqlGPINQty = " SELECT SUM(stocktransactions.dblQty) AS GPIN_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'TI' ";
	//echo $sqlReceivedQty;				  
	$resGPINQty = $db->RunQuery($sqlGPINQty);
	
	while($rowGPINQty = mysql_fetch_array($resGPINQty)){
		$_dblGPINQty = $rowGPINQty['GPIN_QTY'];	
	}
	
	return $_dblGPINQty;	
 
}

function GetGatePassOUT($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblGPOUTQty = 0;
	
	$sqlGPOUT = " SELECT SUM(stocktransactions.dblQty) AS GPOUT_QTY ".
			    " FROM   stocktransactions ".
				" WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
				"        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
				"        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
				"        stocktransactions.strType = 'SGatePass' ";
				  
	$resGPOUT = $db->RunQuery($sqlGPOUT);
	
	while($rowGPOUT = mysql_fetch_array($resGPOUT)){
		$_dblGPOUTQty = $rowGPOUT['GPOUT_QTY'];	
	}	
	return $_dblGPOUTQty;	
}



?>