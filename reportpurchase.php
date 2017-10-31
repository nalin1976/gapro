<?php
$xml = simplexml_load_file('config.xml');
$purchaseOrderReportName = $xml->PurchaseOrder->ReportName;
include $purchaseOrderReportName;
?>