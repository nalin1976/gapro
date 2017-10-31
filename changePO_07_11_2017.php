<?php
 session_start();
include "authentication.inc";
include "Connector.php"; 

$pono = $_REQUEST["pono"];
$poyear = $_REQUEST["year"];

$dir_path = "";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Confirmed PO Correction</title>
<link href="css/cssStyle.css" rel="stylesheet" type="text/css" />
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.11.3.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/pocorrrection.js"></script>
<script>
   var dir_path =  <?php echo json_encode($dir_path); ?>
</script>
<script>
    $(function(){
       $("#dtDeliveryDate").datepicker();
       $("#dtETADate").datepicker();
       $("#dtETDDate").datepicker();
       
        var url 		= "pocorrection.php?RequestType=LoadSuppliers";
        var htmlObj 	= $.ajax({url:url, async:false});

        var XMLSupplierID    = htmlObj.responseXML.getElementsByTagName("SupplierID");	
        var XMLSupplier      = htmlObj.responseXML.getElementsByTagName("SupplierName");

        var optSupplier	= $("#cmbSupplier");
        optSupplier.append($('<option></option>').val(-1).text(""));

        for ( var loop = 0; loop < XMLSupplierID.length; loop ++){

            var supplierID      = XMLSupplierID[loop].childNodes[0].nodeValue;
            var supplierName    = XMLSupplier[loop].childNodes[0].nodeValue

            optSupplier.append($('<option></option>').val(supplierID).text(supplierName));
        }
        
        
        var urlPayMode 	= "pocorrection.php?RequestType=LoadPayMode";
        var htmlObjPayMode = $.ajax({url:urlPayMode, async:false});

        var XMLPayModeID    = htmlObjPayMode.responseXML.getElementsByTagName("PayModeId");	
        var XMLPayMode      = htmlObjPayMode.responseXML.getElementsByTagName("PayMode");

        var optPayMode	= $("#cmbPayMode");
        optPayMode.append($('<option></option>').val(-1).text(""));

        for ( var loop = 0; loop < XMLPayModeID.length; loop ++){

            var payModeID  = XMLPayModeID[loop].childNodes[0].nodeValue;
            var payMode    = XMLPayMode[loop].childNodes[0].nodeValue;

            optPayMode.append($('<option></option>').val(payModeID).text(payMode));
        }
        
        var urlPayTerms 	= "pocorrection.php?RequestType=LoadPayTerms";
        var htmlObjPayTerm      = $.ajax({url:urlPayTerms, async:false});

        var XMLPayTermID        = htmlObjPayTerm.responseXML.getElementsByTagName("PayTermId");	
        var XMLPayTerm          = htmlObjPayTerm.responseXML.getElementsByTagName("PayTerm");

        var optPayTerm	= $("#cmbPayTerm");
        optPayTerm.append($('<option></option>').val(-1).text(""));

        for ( var loop = 0; loop < XMLPayTermID.length; loop ++){

            var payTermID  = XMLPayTermID[loop].childNodes[0].nodeValue;
            var payTerm    = XMLPayTerm[loop].childNodes[0].nodeValue;

            optPayTerm.append($('<option></option>').val(payTermID).text(payTerm));
        }
        
        var urlShipMode 	= "pocorrection.php?RequestType=LoadShipmentMode";
        var htmlObjShipMode      = $.ajax({url:urlShipMode, async:false});
        
        var XMLShipModeID        = htmlObjShipMode.responseXML.getElementsByTagName("ShipModeId");	
        var XMLShipMode          = htmlObjShipMode.responseXML.getElementsByTagName("ShipMode");

        var optShipMode	= $("#cmbShipMode");
        optShipMode.append($('<option></option>').val(-1).text(""));

        for ( var loop = 0; loop < XMLShipModeID.length; loop ++){

            var shipModeID  = XMLShipModeID[loop].childNodes[0].nodeValue;
            var shipMode    = XMLShipMode[loop].childNodes[0].nodeValue;
            
            optShipMode.append($('<option></option>').val(shipModeID).text(shipMode));
        }
        
        
        var urlShipTerm 	= "pocorrection.php?RequestType=LoadShipmentTerm";
        var htmlObjShipTerm      = $.ajax({url:urlShipTerm, async:false});
        
        var XMLShipTermID        = htmlObjShipTerm.responseXML.getElementsByTagName("ShipTermId");	
        var XMLShipTerm          = htmlObjShipTerm.responseXML.getElementsByTagName("ShipTerm");

        var optShipTerm	= $("#cmbShipTerm");
        optShipTerm.append($('<option></option>').val(-1).text(""));

        for ( var loop = 0; loop < XMLShipTermID.length; loop ++){

            var shipTermID  = XMLShipTermID[loop].childNodes[0].nodeValue;
            var shipTerm    = XMLShipTerm[loop].childNodes[0].nodeValue;
            
            optShipTerm.append($('<option></option>').val(shipTermID).text(shipTerm));
        }
        
        
        var urlInvoiceTo 	= "pocorrection.php?RequestType=LoadLocation";
        var htmlObjInvoice      = $.ajax({url:urlInvoiceTo, async:false});
        
        var XMLInvToId          = htmlObjInvoice.responseXML.getElementsByTagName("LocationId");	
        var XMLInvoiceTo        = htmlObjInvoice.responseXML.getElementsByTagName("Location");

        var optInvoiceTo	= $("#cmbInvoiceTo");
        optInvoiceTo.append($('<option></option>').val(-1).text(""));

        for ( var loop = 0; loop < XMLInvToId.length; loop ++){

            var invoiceToID  = XMLInvToId[loop].childNodes[0].nodeValue;
            var invoiceTo    = XMLInvoiceTo[loop].childNodes[0].nodeValue;
            
            optInvoiceTo.append($('<option></option>').val(invoiceToID).text(invoiceTo));
        }
        
        var urlDeliveryTo 	= "pocorrection.php?RequestType=LoadLocation";
        var htmlObjDeliveryTo   = $.ajax({url:urlDeliveryTo, async:false});
        
        var XMLDelToId          = htmlObjDeliveryTo.responseXML.getElementsByTagName("LocationId");	
        var XMLDeliveryTo       = htmlObjDeliveryTo.responseXML.getElementsByTagName("Location");

        var optInvoiceTo	= $("#cmbDeliveryTo");
        optInvoiceTo.append($('<option></option>').val(-1).text(""));

        for ( var loop = 0; loop < XMLDelToId.length; loop ++){

            var deliveryToID  = XMLDelToId[loop].childNodes[0].nodeValue;
            var deliveryTo    = XMLDeliveryTo[loop].childNodes[0].nodeValue;
            
            optInvoiceTo.append($('<option></option>').val(deliveryToID).text(deliveryTo));
        }
        
       
       
       loadPO(<?php echo $pono ?>, <?php echo $poyear ?> );
       
       IsGRNExistPO(<?php echo $pono ?>, <?php echo $poyear ?> );
    });
</script>
<style>
    .select-xmd{ width:280px; font-family: Futura, 'Trebuchet MS', Arial, sans-serif;font-size:09pt; height:30px;}
    .text-md{ width:180px; font-family: Futura, 'Trebuchet MS', Arial, sans-serif;font-size:09pt; height:25px;}
    
    .btn-md{width:100px;}
    .col-md-6{
    padding: 0px 0px 0px 0px;
}
</style>
</head>
    
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><?php include 'Header.php';  ?></td>
    </tr>
    <tr>
        <td width="100%">
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6 div-board">
                <div class="col-md-12 div-header">Confirmed PO - Correction</div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-3 div-pad">PO Number</div>
                <div class="col-md-2 div-pad"><?php echo $pono; ?></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Year</div>
                <div class="col-md-2 div-pad"><?php echo $poyear; ?></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Supplier</div>
                <div class="col-md-4 div-pad"><select class="form-control select-xmd" id="cmbSupplier" name="cmbSupplier"></select></div>
                <div class="col-md-5 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Payment Mode</div>
                <div class="col-md-4 div-pad"><select class="form-control select-xmd" id="cmbPayMode" name="cmbPayMode"></select></div>
                <div class="col-md-5 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Payment Term</div>
                <div class="col-md-2 div-pad"><select class="form-control select-xmd" id="cmbPayTerm" name="cmbPayTerm"></select></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Shipment Mode</div>
                <div class="col-md-2 div-pad"><select class="form-control select-xmd" id="cmbShipMode" name="cmbShipMode"></select></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Shipment Terms</div>
                <div class="col-md-2 div-pad"><select class="form-control select-xmd" id="cmbShipTerm" name="cmbShipTerm"></select></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Invoice To</div>
                <div class="col-md-2 div-pad"><select class="form-control select-xmd" id="cmbInvoiceTo" name="cmbInvoiceTo"></select></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Delivery To</div>
                <div class="col-md-2 div-pad"><select class="form-control select-xmd" id="cmbDeliveryTo" name="cmbDeliveryTo"></select></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">Delivery Date</div>
                <div class="col-md-2 div-pad"><input type="text" id="dtDeliveryDate" class="form-control text-md" readonly></input></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">ETA (PI Date)</div>
                <div class="col-md-2 div-pad"><input type="text" id="dtETADate" class="form-control text-md" readonly></input></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-3 div-pad">ETD</div>
                <div class="col-md-2 div-pad"><input type="text" id="dtETDDate" class="form-control text-md" readonly></input></div>
                <div class="col-md-7 div-pad">&nbsp;</div>
                <div class="col-md-12 div-seperator">&nbsp;</div>
                <div class="col-md-3 div-pad"></div>
                <div class="col-md-2 div-pad">&nbsp;</div>
                <div class="col-md-7 div-pad"> <button class="btn btn-primary btn-md" id="btnSave" onclick="UpdatePO(<?php echo $pono ?>, <?php echo $poyear ?>)">Save</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-md" id="btnClose" onclick="PageClose()">Close</button></div>
                <div class="col-md-12">&nbsp;</div>    
            </div>    
            <div class="col-md-3">&nbsp;</div>
        </td>
    </tr>    
</table>
</body>      

</html>
<?php
    $sql="select count(intGrnNo)as count from grnheader where intPoNo='$pono' and intYear='$poyear' and intStatus<>10";
    $result=$db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $rowCount = $row["count"];
?>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
if(rowCount>0){
	alert("Sorry!\nYou cannot change this PO.GRN available for this PO.");
	window.close();
}
</script>