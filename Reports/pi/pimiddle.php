<?php

session_start();

include "../../Connector.php";	

$RequestType = $_GET["RequestType"];
$userId	     = $_SESSION["UserID"];

require_once('../../classes/class_buyer.php');
require_once('../../classes/class_orders.php');

header('Content-Type: text/xml'); 

$class_buyer = new Buyer();
$class_orders = new Orders();

if(strcmp($RequestType,"LoadBuyers") == 0){

    $ResponseXML = "";
    $ResponseXML = "<Buyers>\n";

    $class_buyer->SetConnection($db);
    $resBuyersList = $class_buyer->GetBuyerList();

    while($row = mysql_fetch_array($resBuyersList)){

            $ResponseXML .= "<BuyerID><![CDATA[" . $row["intBuyerID"]  . "]]></BuyerID>\n";
            $ResponseXML .= "<BuyerName><![CDATA[" . $row["strName"]  . "]]></BuyerName>\n";

    }

    $ResponseXML .= "</Buyers>";

    echo $ResponseXML;
}

if(strcmp($RequestType,"LoadOrders") == 0){
    
    $ResponseXML = "";
    $ResponseXML = "<Orders>\n";
    
    $class_orders->SetConnection($db);
    $resOrdersList = $class_orders->GetStyleList();
    
    while($row = mysql_fetch_array($resOrdersList)){

            $ResponseXML .= "<StyleCode><![CDATA[" . $row["intStyleId"]  . "]]></StyleCode>\n";
            $ResponseXML .= "<StyleID><![CDATA[" . $row["strStyle"]  . "]]></StyleID>\n";

    }

    $ResponseXML .= "</Orders>";

    echo $ResponseXML;
    
}

if(strcmp($RequestType,"LoadSC") == 0){
    
    $ResponseXML = "";
    $ResponseXML = "<SCList>\n";
    
    $class_orders->SetConnection($db);
    $resOrdersList = $class_orders->GetSCList();
    
    while($row = mysql_fetch_array($resOrdersList)){

            $ResponseXML .= "<StyleCode><![CDATA[" . $row["intStyleId"]  . "]]></StyleCode>\n";
            $ResponseXML .= "<SCNo><![CDATA[" . $row["intSRNO"]  . "]]></SCNo>\n";

    }

    $ResponseXML .= "</SCList>";

    echo $ResponseXML;
    
}

if(strcmp($RequestType,"LoadStyles") == 0){
    
    $iBuyerCode = $_GET["bc"];
    
    $ResponseXML = "";
    $ResponseXML = "<StyleList>\n";
    
    $class_orders->SetConnection($db);
    $resOrdersList = $class_orders->GetOrdersListByBuyer($iBuyerCode);
    
    while($row = mysql_fetch_array($resOrdersList)){

        $ResponseXML .= "<StyleCode><![CDATA[" . $row["intStyleId"]  . "]]></StyleCode>\n";
        $ResponseXML .= "<StyleID><![CDATA[" . $row["strStyle"]  . "]]></StyleID>\n";
        $ResponseXML .= "<SCNo><![CDATA[" . $row["intSRNO"]  . "]]></SCNo>\n";
        $ResponseXML .= "<StyleDesc><![CDATA[" . $row["strDescription"]  . "]]></StyleDesc>\n";
        $ResponseXML .= "<Company><![CDATA[" . $row["strComCode"]  . "]]></Company>\n";
        $ResponseXML .= "<Buyer><![CDATA[" . $row["strName"]  . "]]></Buyer>\n";

    }
    
    $ResponseXML .= "</StyleList>";

    echo $ResponseXML;
    
}
