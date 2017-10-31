<?php

session_start();

include "Connector.php";

$currentMonth = date("m");
$currentYear  = date("Y");




$sql = "SELECT deliveryschedule.intStyleId, deliveryschedule.dtDateofDelivery, deliveryschedule.dblQty, deliveryschedule.dtmHandOverDate,
                deliveryschedule.intBPO, deliveryschedule.intManufacturingLocation, deliveryschedule.estimatedDate,
                deliveryschedule.strShippingMode
        FROM deliveryschedule Inner Join specification ON deliveryschedule.intStyleId = specification.intStyleId
        WHERE month(deliveryschedule.dtmHandOverDate) =  $currentMonth and year(deliveryschedule.dtmHandOverDate) = $currentYear 
        order by deliveryschedule.dtmHandOverDate, deliveryschedule.intStyleId";

$result = $db->RunQuery($sql);

while($row = mysql_fetch_array($result)){
    
    $iStyleId   = $row["intStyleId"];
    $bpoNo      = $row["intBPO"];
    $dtDelivery = $row["dtDateofDelivery"];
    $iDelQty    = $row["dblQty"];
    $dtHO       = $row["dtmHandOverDate"];
    $dtEstimate = $row["estimatedDate"];
    $iManuLoca  = $row["intManufacturingLocation"];
    $iShipping  = $row["strShippingMode"];
    
    $sqlFreeze = " SELECT * FROM freeze_schedule WHERE intStyleId = '$iStyleId' AND intBPO = '$bpoNo' ";
    
    $resFreeze = $db->RunQuery($sqlFreeze);
    
   while($rowFreeze = mysql_fetch_array($resFreeze)){
       
       $dtFreezeHO = $rowFreeze["dtmHandOverDate"];
       
       $iFreezeMonth = GetMonth($dtHO);
       
       if(($dtHO != $dtFreezeHO) && ($iFreezeMonth == $currentMonth)){
           
           //$sqlUpdate = "UPDATE freeze_schedule SET dtmHandOverDate = '$dtHO', dtDateofDelivery = '$dtDelivery', dblQty = '$iDelQty', delChanged = '1' WHERE intStyleId = '$iStyleId' AND intBPO = '$bpoNo'  ";
           $sqlUpdate = "UPDATE freeze_schedule SET dtmHandOverDate = '$dtHO', dtDateofDelivery = '$dtDelivery', delChanged = '1' WHERE intStyleId = '$iStyleId' AND intBPO = '$bpoNo'  ";
           $res = $db->ExecuteQuery($sqlUpdate);
       }
   }
    
}

function GetMonth($prmDate){
    
    $arrFormatDate = explode('-', $prmDate);
    
    $iMonth = $arrFormatDate[1];
    
    return $iMonth;
}

?>
