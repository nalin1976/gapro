
<html>
    <head>
        <style>
            .item_header{
                font-family: 'Calibri';
                font-size: 17px;
                text-align: left;
            }
            .header_left{
                font-family: 'Calibri';
                font-size: 15px;
                text-align: left;
                border-top: black solid thin;
                border-left: black solid thin;
                border-bottom: black solid thin;
                height: 40px;
            }
            
            .header_left_full_border{
                font-family: 'Calibri';
                font-size: 15px;
                text-align: left;
                border: black solid thin;                
                height: 40px;
            }
            
            .header_center{
                font-family: 'Calibri';
                font-size: 15px;
                text-align: center;
                border-top: black solid thin;
                border-left: black solid thin;
                border-bottom: black solid thin;
                height: 40px;
            }
            
            .header_right{
                font-family: 'Calibri';
                font-size: 15px;
                text-align: right;
                border-top: black solid thin;
                border-left: black solid thin;
                border-bottom: black solid thin;
                height: 40px;
            }
            
            .detail_left{
                font-family: 'Calibri';
                font-size: 14px;
                text-align: left;
                border-left: black solid thin;
                border-bottom: black solid thin;
                height: 40px;
            }
            
            .detail_center{
                font-family: 'Calibri';
                font-size: 14px;
                text-align: center;
                border-left: black solid thin;
                border-bottom: black solid thin;
                height: 40px;
            }
            
            .detail_right{
                font-family: 'Calibri';
                font-size: 15px;
                text-align: right;
                border-left: black solid thin;
                border-bottom: black solid thin;
                height: 40px;
            }
            
            .detail_left_full_border{
                font-family: 'Calibri';
                font-size: 15px;
                text-align: left;
                border-left: black solid thin;
                border-bottom: black solid thin;               
                border-right: black solid thin;               
                height: 40px;
            }
        </style>
    </head>
<?php 

session_start();
include "../../Connector.php";

$itemcode = $_GET["itemcode"];

$rsItemDescription = GetItemDescription($itemcode);
$arr_ItemDescription = mysql_fetch_row($rsItemDescription);


$rsItemHistory = GetItemHisDetails($itemcode);

$htmlTable = "";
$htmlTable = "<table width='60%' align='center' cellpadding='0' cellspacing='0'>";
$htmlTable .= "<thead>";
$htmlTable .= "<tr><th colspan='6'>&nbsp;</th></tr>";
$htmlTable .= "<tr><th colspan='6' class='item_header'>&nbsp;Item Code & Description - ".$arr_ItemDescription[0].' - '.$arr_ItemDescription[1]."</th></tr>";
$htmlTable .= "<tr><th colspan='6'>&nbsp;</th></tr>";
$htmlTable .= "<tr><th class='header_left'>&nbsp;PO#</th><th class='header_left'>&nbsp;Supplier Name</th><th class='header_center'>UOM</th><th class='header_right'>Unit Price&nbsp;</th><th class='header_right'>Order Qty&nbsp;</th><th class='header_left_full_border'>&nbsp;Delivery Location</th></tr>";
$htmlTable .= "</thead>";
$htmlTable .= "<tbody>";


while($rowItemHis = mysql_fetch_array($rsItemHistory)){

    $htmlTable .= "<tr><td class='detail_left'>&nbsp;".$rowItemHis['poNO']."</td>";
    $htmlTable .= "<td class='detail_left'>&nbsp;".$rowItemHis['strTitle']."</td>";
    $htmlTable .= "<td class='detail_center'>".$rowItemHis['strUnit']."</td>";
    $htmlTable .= "<td class='detail_right'>".number_format($rowItemHis['dblUnitPrice'],2)."&nbsp;</td>";
    $htmlTable .= "<td class='detail_right'>".$rowItemHis['dblQty']."&nbsp;</td>";
    $htmlTable .= "<td class='detail_left_full_border'>&nbsp;".$rowItemHis['strName']."</td></tr>";

    

}
$htmlTable .= "</tbody>";
$htmlTable .= "<table width='60%'>";
echo $htmlTable;
function GetItemHisDetails($prmItemCode){
    
    global $db;
    
    $sql = " SELECT concat(generalpurchaseorderheader.intYear,'/',generalpurchaseorderheader.intGenPONo) AS poNO, suppliers.strTitle, generalpurchaseorderdetails.strUnit, generalpurchaseorderdetails.dblUnitPrice,
                    generalpurchaseorderdetails.dblQty, companies.strName
             FROM generalpurchaseorderheader INNER JOIN generalpurchaseorderdetails ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPoNo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
                  INNER JOIN suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID INNER JOIN companies ON generalpurchaseorderheader.intCompId = companies.intCompanyID
             WHERE generalpurchaseorderdetails.intMatDetailID = '$prmItemCode' AND generalpurchaseorderheader.intStatus = '1'";
              
    $result = $db->RunQuery($sql);
        
    return $result;

}

function GetItemDescription($prmItemCode){
    global $db;
     
    $sql = " SELECT strItemCode, strItemDescription FROM  genmatitemlist WHERE intItemSerial = '$prmItemCode' ";
     
    $result = $db->RunQuery($sql);
        
    return $result;
}


?>
</html>