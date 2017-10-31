<?php

session_start();

include "Connector.php";

$companyId  = $_SESSION["FactoryID"];
$user       = $_SESSION["UserID"];
$backwardseperator = "../";

header('Content-Type: text/xml'); 

$RequestType = $_GET["RequestType"];

require_once('classes/class_supplier.php');
require_once('classes/class_orders.php');
require_once('classes/class_po.php');
require_once('classes/location.php');
require_once('classes/class_common.php');


$class_supplier = new Supplier();
$class_orders = new Orders();
$class_purchaseorder = new PurchaseOrders();
$class_location = new Location();
$class_common = new CommonPHP();

if(strcmp($RequestType,"LoadSuppliers") == 0){

    $ResponseXML = "";
    $ResponseXML = "<Suppliers>\n";

    $class_supplier->SetConnection($db);
    $resSupplierList = $class_supplier->GetSupplierList();

    while($row = mysql_fetch_array($resSupplierList)){

            $ResponseXML .= "<SupplierID><![CDATA[" . $row["strSupplierID"]  . "]]></SupplierID>\n";
            $ResponseXML .= "<SupplierName><![CDATA[" . $row["strTitle"]  . "]]></SupplierName>\n";

    }

    $ResponseXML .= "</Suppliers>";

    echo $ResponseXML;
    
}

if(strcmp($RequestType,"LoadSCList") == 0){

    $ResponseXML = "";
    $ResponseXML = "<SCList>\n";

    $class_orders->SetConnection($db);
    $resSCList = $class_orders->GetSCList();

    while($row = mysql_fetch_array($resSCList)){

        $ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
        $ResponseXML .= "<SCNo><![CDATA[" . $row["intSRNO"]  . "]]></SCNo>\n";

    }
    $ResponseXML .= "</SCList>";
    echo $ResponseXML;    
}

if(strcmp($RequestType,"LoadOrdersList") == 0){

    $ResponseXML = "";
    $ResponseXML = "<StyleList>\n";

    $class_orders->SetConnection($db);
    $resStyleList = $class_orders->GetStyleList();

    while($row = mysql_fetch_array($resStyleList)){

        $ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
        $ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  . "]]></StyleName>\n";

    }
    $ResponseXML .= "</StyleList>";
    echo $ResponseXML;    
}
if(strcmp($RequestType,"GetPOList") == 0){
    
    $styleCode      = $_GET["stylecode"];
    $supplierCode   = $_GET["suppliercode"];
    $pono           = $_GET["pono"];
    $poyear         = $_GET["poyear"];
    
    $class_purchaseorder->SetConnection($db);
    $resPOList = $class_purchaseorder->GetPOHeaderDetails($poyear,$styleCode,$supplierCode,$pono);
    
    $ResponseXML = "";
    $ResponseXML = "<POList>\n";
    
    while($rowPOList = mysql_fetch_array($resPOList)){
        
        if(is_null($rowPOList["dtmETD"])){
            $dtmETD = "";
        }else{
            $dtmETD = $rowPOList["dtmETD"];
        }
      
        $ResponseXML .= "<POYear><![CDATA[" . $rowPOList["intYear"]  . "]]></POYear>\n";
        $ResponseXML .= "<PONumber><![CDATA[" . $rowPOList["intPONo"]  . "]]></PONumber>\n";
        $ResponseXML .= "<Supplier><![CDATA[" . $rowPOList["strTitle"]  . "]]></Supplier>\n";
        $ResponseXML .= "<PODate><![CDATA[" . $rowPOList["dtmDate"]  . "]]></PODate>\n";
        $ResponseXML .= "<DeliveryDate><![CDATA[" . $rowPOList["dtmDeliveryDate"]  . "]]></DeliveryDate>\n";
        $ResponseXML .= "<DeliveryTo><![CDATA[" . $rowPOList["strComCode"]  . "]]></DeliveryTo>\n";
        $ResponseXML .= "<ETD><![CDATA[" . $dtmETD  . "]]></ETD>\n";
        $ResponseXML .= "<POUser><![CDATA[" . $rowPOList["Name"]  . "]]></POUser>\n";
        
    }
    
    $ResponseXML .= "</POList>";
    echo $ResponseXML;   
}
if(strcmp($RequestType,"GetPOInformation") == 0){
    
    $pono           = $_GET["pono"];
    $poyear         = $_GET["poyear"];
    
    
    $class_purchaseorder->SetConnection($db);
    $resPOInfomation = $class_purchaseorder->GetPOHeaderDetails($poyear,-1,-1,$pono);
    
    $ResponseXML = "";
    $ResponseXML = "<PODetails>\n";

    while($row = mysql_fetch_array($resPOInfomation))
    {
        $ResponseXML .= "<SupplierID><![CDATA[" . $row["strSupplierID"]  . "]]></SupplierID>\n";
        $ResponseXML .= "<payTermID><![CDATA[" . $row["strPayTerm"]  . "]]></payTermID>\n";
        $ResponseXML .= "<payModeID><![CDATA[" . $row["strPayMode"]  . "]]></payModeID>\n";
        $ResponseXML .= "<shipModeID><![CDATA[" . $row["strShipmentMode"]  . "]]></shipModeID>\n";
        $ResponseXML .= "<shipTermID><![CDATA[" . $row["strShipmentTerm"]  . "]]></shipTermID>\n";
        $ResponseXML .= "<invoiceToID><![CDATA[" . $row["intInvCompID"]  . "]]></invoiceToID>\n";
        $ResponseXML .= "<deliveryToID><![CDATA[" . $row["intDelToCompID"]  . "]]></deliveryToID>\n";
        $ResponseXML .= "<deliveryDate><![CDATA[" . $row["dtmDeliveryDate"]  . "]]></deliveryDate>\n";
        $ResponseXML .= "<ETA><![CDATA[" . $row["dtmETA"]  . "]]></ETA>\n";
        $ResponseXML .= "<ETD><![CDATA[" . $row["dtmETD"]  . "]]></ETD>\n";        
        $ResponseXML .= "<ACD><![CDATA[" . $row["dtmACD"]  . "]]></ACD>\n";        
        $ResponseXML .= "<ADD><![CDATA[" . $row["dtmADD"]  . "]]></ADD>\n";        
       
    }
    
    $ResponseXML .= "</PODetails>";
    
    echo $ResponseXML;
    
}
if(strcmp($RequestType,"LoadPayMode") == 0){
    
    $ResponseXML = "";
    $ResponseXML = "<PayModes>\n";

    $class_supplier->SetConnection($db);
    $resPayMode = $class_supplier->GetPaymentModes();

    while($row = mysql_fetch_array($resPayMode)){

            $ResponseXML .= "<PayModeId><![CDATA[" . $row["strPayModeId"]  . "]]></PayModeId>\n";
            $ResponseXML .= "<PayMode><![CDATA[" . $row["strDescription"]  . "]]></PayMode>\n";

    }

    $ResponseXML .= "</PayModes>";

    echo $ResponseXML;
}
if(strcmp($RequestType,"LoadPayTerms") == 0){
    
    $ResponseXML = "";
    $ResponseXML = "<PayTerms>\n";

    $class_supplier->SetConnection($db);
    $resPayTerms = $class_supplier->GetPaymentTerms();

    while($row = mysql_fetch_array($resPayTerms)){

            $ResponseXML .= "<PayTermId><![CDATA[" . $row["strPayTermId"]  . "]]></PayTermId>\n";
            $ResponseXML .= "<PayTerm><![CDATA[" . $row["strDescription"]  . "]]></PayTerm>\n";

    }

    $ResponseXML .= "</PayTerms>";

    echo $ResponseXML;
}
if(strcmp($RequestType,"LoadShipmentMode") == 0){
    
    $ResponseXML = "";
    $ResponseXML = "<ShipmentMode>\n";

    $class_supplier->SetConnection($db);
    $resShipmentMode = $class_supplier->GetShipmentMode();

    while($rowShipmentMode = mysql_fetch_array($resShipmentMode)){

        $ResponseXML .= "<ShipModeId><![CDATA[" . $rowShipmentMode["intShipmentModeId"]  . "]]></ShipModeId>\n";
        $ResponseXML .= "<ShipMode><![CDATA[" . $rowShipmentMode["strDescription"]  . "]]></ShipMode>\n";

    }

    $ResponseXML .= "</ShipmentMode>";

    echo $ResponseXML;
}
if(strcmp($RequestType,"LoadShipmentTerm") == 0){
    
    $ResponseXML = "";
    $ResponseXML = "<ShipmentTerm>\n";

    $class_supplier->SetConnection($db);
    $resShipmentTerm = $class_supplier->GetShipmentTerm();

    while($rowShipmentTerm = mysql_fetch_array($resShipmentTerm)){

        $ResponseXML .= "<ShipTermId><![CDATA[" . $rowShipmentTerm["strShipmentTermId"]  . "]]></ShipTermId>\n";
        $ResponseXML .= "<ShipTerm><![CDATA[" . $rowShipmentTerm["strShipmentTerm"]  . "]]></ShipTerm>\n";

    }

    $ResponseXML .= "</ShipmentTerm>";

    echo $ResponseXML;
}
if(strcmp($RequestType,"LoadLocation") == 0){
    
    $ResponseXML = "";
    $ResponseXML = "<Locations>\n";

    $class_location->SetConnection($db);
    $resLocation = $class_location->GetLocationList();

    while($rowLocation = mysql_fetch_array($resLocation)){

        $ResponseXML .= "<LocationId><![CDATA[" . $rowLocation["intCompanyID"]  . "]]></LocationId>\n";
        $ResponseXML .= "<Location><![CDATA[" . $rowLocation["strName"]  . "]]></Location>\n";

    }

    $ResponseXML .= "</Locations>";

    echo $ResponseXML;
}
if(strcmp($RequestType,"POGRNDone") == 0){
    
    $pono           = $_GET["pono"];
    $poyear         = $_GET["poyear"];
    
    $sql="select count(intGrnNo)as count from grnheader where intPoNo='$pono' and intYear='$poyear' and intStatus<>10";
    $result=$db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $rowCount = $row["count"];
    
    $ResponseXML = "";
    $ResponseXML = "<GRNExist>\n";
    $ResponseXML .= "<IsGRN><![CDATA[" . $rowCount  . "]]></IsGRN>\n";
    $ResponseXML .= "</GRNExist>\n";
    
    echo $ResponseXML;    
}
if(strcmp($RequestType,"POChangeLog") == 0){
    
    $pono          = $_GET["pono"];
    $poyear        = $_GET["poyear"];
    $changedSource = $_GET["source"];
    $prevoiusValue = $_GET["prevalue"];
    $newValue      = $_GET["newvalue"];
    
    $sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'$changedSource','$prevoiusValue','$newValue','$user');";
    //echo $sql;
    $db->ExecuteQuery($sql);
    
}

if(strcmp($RequestType,"POUpdate") == 0){
    
    $pono           = $_GET["pono"];
    $poyear         = $_GET["poyear"];
    $newSupplier    = $_GET["supplierId"];
    $newPayMode     = $_GET["paymodeid"];
    $newPayTerm     = $_GET["paytermid"];
    $newShipmentMode     = $_GET["shipmodeid"];
    $newShipmentTerm     = $_GET["shiptermid"];
    $newInvoiceTo     = $_GET["invoiceto"];
    $newDeleverTo     = $_GET["deliveryto"];
    $actualDeliDate   = $_GET["addate"];
    $actualClearDate  = $_GET["acdate"];
    
    if($class_common->DateIsFormatted($_GET["deliverydate"]) == 1){
        $dtDateofDelivery = $_GET["deliverydate"];
    }else{
        $dtDateofDelivery     = $class_common->GetFormatDateUS($_GET["deliverydate"]);
    }
    
    if($class_common->DateIsFormatted($_GET["etadate"]) == 1){
        $formatETA = $_GET["etadate"];
    }else{
        $formatETA     = $class_common->GetFormatDateUS($_GET["etadate"]);
    }
    
    if($class_common->DateIsFormatted($_GET["etddate"]) == 1){
        $formatETD = $_GET["etddate"];
    }else{
        $formatETD     = $class_common->GetFormatDateUS($_GET["etddate"]);
    }
    
    if($class_common->DateIsFormatted($_GET["addate"]) == 1){
        $formatADD = $_GET["addate"];
    }else{
        $formatADD  = $class_common->GetFormatDateUS($_GET["addate"]);
    }
    
    if($class_common->DateIsFormatted($_GET["acdate"]) == 1){
        $formatACD = $_GET["acdate"];
    }else{
        $formatACD  = $class_common->GetFormatDateUS($_GET["acdate"]);
    }
    
    
    
    $sql = "update purchaseorderheader set strSupplierID = '$newSupplier' ,strPayMode = '$newPayMode' ,strPayTerm = '$newPayTerm',strShipmentMode = $newShipmentMode,strShipmentTerm = $newShipmentTerm,intInvCompID = '$newInvoiceTo',intDelToCompID = '$newDeleverTo', dtmDeliveryDate='$dtDateofDelivery',dtmETA='$formatETA',dtmETD='$formatETD', dtmACD='$formatACD', dtmADD = '$formatADD' where intPONo = '$pono' AND intYear = '$poyear';";
    //echo $sql;
    $res = $db->ExecuteQuery($sql);
    
    if($res == 1)
        echo "PO information update successfully";
    else    
        echo "PO information update fail ! ";
    
}

if(strcmp($RequestType,"GetSupplierCountry") == 0){
    
    $intSupplierCode = $_GET["supcode"];
    $class_supplier->SetConnection($db);
    $resSupplier = $class_supplier->GetSupplierDetails($intSupplierCode);
    
    $ResponseXML = "";
    $ResponseXML = "<Suppliers>\n";
    
    while($rowSupplier = mysql_fetch_array($resSupplier)){
        $ResponseXML .= "<CountryCode><![CDATA[" . $rowSupplier["strCountry"]  . "]]></CountryCode>\n";
    }
    
    $ResponseXML .= "</Suppliers>\n";
    
    echo $ResponseXML;

}        

?>
