<?php

session_start();
$backwardseperator = "../../";

$userId	= $_SESSION["UserID"];

require_once "../Connector.php";
require_once '../classes/class_buyer.php';
require_once '../classes/class_orders.php';
require_once '../classes/class_stocktransaction.php';

$class_buyer = new Buyer();
$class_orders = new Orders();
$class_stocktransaction = new StockTransaction();

$class_buyer->SetConnection($db);
$class_orders->SetConnection($db);
$class_stocktransaction->SetConnection($db);

$parmOption = $_GET["opt"];

header('Content-Type: text/xml'); 
$ResponseXML = "";

if($parmOption == "b"){
    
   $rs_buyers = $class_buyer->GetBuyerList();
   
   $ResponseXML .= "<BUYERS>\n";
   
   while($row_buyres = mysql_fetch_array($rs_buyers)){
       
       $ResponseXML .= "<BUYER_ID><![CDATA[" . $row_buyres["intBuyerID"] . "]]></BUYER_ID>\n";
       $ResponseXML .= "<BUYER_NAME><![CDATA[" . $row_buyres["strName"] . "]]></BUYER_NAME>\n";       
   }
   
   $ResponseXML .= "</BUYERS>";
   
   echo $ResponseXML;
    
}

if($parmOption == "s"){
    
   $rs_styles = $class_orders->GetStyleList();
   
   $ResponseXML .= "<ORDERS>\n";
   
   while($row_styles = mysql_fetch_array($rs_styles)){
       
       $ResponseXML .= "<ORDER_ID><![CDATA[" . $row_styles["intStyleId"] . "]]></ORDER_ID>\n";
       $ResponseXML .= "<STYLE_NAME><![CDATA[" . $row_styles["strStyle"] . "]]></STYLE_NAME>\n";       
   }
   
   $ResponseXML .= "</ORDERS>";   
   echo $ResponseXML;    
}

if($parmOption == "SC"){
    
   $rs_SC = $class_orders->GetSCList();
   
   $ResponseXML .= "<SC>\n";
   
   while($row_sc = mysql_fetch_array($rs_SC)){
       
       $ResponseXML .= "<STYLE_ID><![CDATA[" . $row_sc["intStyleId"] . "]]></STYLE_ID>\n";
       $ResponseXML .= "<SC_NO><![CDATA[" . $row_sc["intSRNO"] . "]]></SC_NO>\n";       
   }
   
   $ResponseXML .= "</SC>";   
   echo $ResponseXML;    
}

if($parmOption == "BUYER"){
    
    $buyerCode = $_GET["buyerCode"];
    
    $rs_orderlistBuyers = $class_orders->GetOrdersListByBuyer($buyerCode);
    
    echo GetOrderListFormat($rs_orderlistBuyers);
}

if($parmOption == "STYLE"){
    
    $buyerCode = $_GET["styleCode"];
    
    $rs_orderlistBuyers = $class_orders->GetOrdersListByCode($buyerCode);
    
    echo GetOrderListFormat($rs_orderlistBuyers);
}

if($parmOption == "SAVESTOCK"){
    
    $styleCode = $_GET["styleCode"];
    
    $rs_stock_history = $class_stocktransaction->GetStockHistory($styleCode);
    
    if($rs_stock_history > 0){
        $rs_stock = 1;
    }else{
        $rs_stock = $class_stocktransaction->SaveStockTransactionToHistory($styleCode);
    }
    
    
    
    if($rs_stock == '1'){
        
        $rs_blanace_to_leftover = $class_stocktransaction->TranferStockBalanceToLeftOver($styleCode);
        
        if($rs_blanace_to_leftover == '1'){
            
            $rs_order_complete = $class_orders->SetOrderAsComplete($styleCode, $userId);
            
            if($rs_order_complete == '1'){
                $rs_remove_st = $class_stocktransaction->RemoveStockTransactionFromLive($styleCode);
                echo $rs_remove_st;
            }else{
                echo $rs_order_complete;
            }
            
            
        }else{
           echo $rs_blanace_to_leftover;
        }
        
    }else{
        echo $rs_stock;
    }
}

if($parmOption == "COMPORDER"){
    
    $styleCode = $_GET["styleCode"];
    
    $rs_order_complete = $class_orders->SetOrderAsComplete($styleCode, $userId);
    
    echo $rs_order_complete;
    
}

function GetOrderListFormat($prmRsOrderList){
    
    $ResponseXML .= "<ORDER_LIST>\n";
    
    while($row_orders = mysql_fetch_array($prmRsOrderList)){
        
        $ResponseXML .= "<STYLE_ID><![CDATA[" . $row_orders["intStyleId"] . "]]></STYLE_ID>\n";
        $ResponseXML .= "<SC_NO><![CDATA[" . $row_orders["intSRNO"] . "]]></SC_NO>\n";
        $ResponseXML .= "<STYLE_NAME><![CDATA[" . $row_orders["strStyle"] . "]]></STYLE_NAME>\n";  
        $ResponseXML .= "<DESC><![CDATA[" . $row_orders["strDescription"] . "]]></DESC>\n";
        $ResponseXML .= "<BUYER><![CDATA[" . $row_orders["strName"] . "]]></BUYER>\n";
        $ResponseXML .= "<ORDER_QTY><![CDATA[" . $row_orders["intQty"] . "]]></ORDER_QTY>\n";
        
    }
    
    $ResponseXML .= "</ORDER_LIST>\n";
    return $ResponseXML;  
    
}

?>
