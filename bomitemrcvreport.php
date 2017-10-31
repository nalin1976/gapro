<?php
session_start();

include "authentication.inc";
include "Connector.php";
$xml = simplexml_load_file('config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
$consumptionDecimalLength = $xml->SystemSettings->ConsumptionDecimalLength;

$locationId =  $_SESSION["FactoryID"];

$iStyleCode = $_GET["sc"];
$iItemCode  = $_GET["ic"];
$sColor     = $_GET["color"];
$sSize      = $_GET["size"];


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BOM - Item Received Details</title>
<style type="text/css">
    .borderless td, .borderless th{
        border:none !important;
    }
    
    .borders td, .borders th{
        border: 1px buttonshadow solid  !important;
    }
    
    .ReportHeader {
        font-size: 16px;
        text-align: center;
    }
    
    .DetailHeader{
       font-size: 12px; 
    }
    
    .DetailLine{
       font-size: 12px; 
    }
</style>
<link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

</head>
    
<body>
    <table class="table borderless">
        <tr><th>&nbsp;</th></tr>
        <tr>
            <td width="8%">&nbsp;</td>
            <td width="84%">
                <table class="table borders table-inverse">
                    
                    <tr>
                        <th colspan="7" class="ReportHeader">
                            Material In-House Report
                        </th>
                    </tr>
                    <tr>
                        <th class="DetailHeader">#</th>
                        <th class="DetailHeader"> Document Number</th>
                        <th class="DetailHeader"> Document Type</th>
                        <th class="DetailHeader"> Location</th>
                        <th class="DetailHeader"> Document Date</th>
                        <th class="DetailHeader"> UOM</th>
                        <th class="DetailHeader"> Quantity</th>
                    </tr>
                    <?php
                    
                    $iRowCount = 1;
                        
                    $sql = " SELECT stocktransactions.intDocumentYear, stocktransactions.intDocumentNo, stocktransactions.strType,
                                   mainstores.strName, stocktransactions.dtmDate, stocktransactions.strUnit, stocktransactions.dblQty
                             FROM  stocktransactions INNER JOIN mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
                             WHERE stocktransactions.intStyleId = '$iStyleCode' AND stocktransactions.intMatDetailId = '$iItemCode' AND stocktransactions.strColor = '$sColor' AND
                                   stocktransactions.strSize = '$sSize' AND stocktransactions.strType = 'GRN' AND mainstores.strMainID <> '$locationId'";
                    
                    $result = $db->RunQuery($sql);
                    
                    while($row = mysql_fetch_array($result)){
                        
                        echo "<tr>";
                        echo "<td class=\"DetailLine\">".$iRowCount."</td>";
                        echo "<td class=\"DetailLine\">".$row["intDocumentYear"]."/".$row["intDocumentNo"]."</td>";
                        echo "<td class=\"DetailLine\">".$row["strType"]."</td>";
                        echo "<td class=\"DetailLine\">".$row["strName"]."</td>";
                        echo "<td class=\"DetailLine\">".$row["dtmDate"]."</td>";
                        echo "<td class=\"DetailLine\">".$row["strUnit"]."</td>";
                        echo "<td class=\"DetailLine\">".$row["dblQty"]."</td>";
                        echo "</tr>";
                        
                        $iRowCount++;
                    }
                    
                    ?>
                </table>
                
            </td>
            <td width="8%">&nbsp;</td>
        </tr>
        

    </table>
</body>    
