/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var SupplierId = -1;
var PayTermId  = -1;
var PatModeId  = -1;
var ShipModeId = -1;
var ShipTermId = -1;
var InvoiceId = -1;
var DeliveryId = -1;
var dtDelivery = "";
var dtETA = "";
var dtETD = "";

$(function(){
    
    //alert(dir_path);   
    /*
     * Load Suppliers
     * ====================================================================
     */
    
    var url 		= dir_path+"pocorrection.php?RequestType=LoadSuppliers";
    //var url 		= "../../../pocorrection.php?RequestType=LoadSuppliers";
    var htmlObj 	= $.ajax({url:url, async:false});
    
    var XMLSupplierID    = htmlObj.responseXML.getElementsByTagName("SupplierID");	
    var XMLSupplier      = htmlObj.responseXML.getElementsByTagName("SupplierName");
   
    var optSupplier	= $("#cboSupplier");
    optSupplier.append($('<option></option>').val(-1).text(""));
   
    for ( var loop = 0; loop < XMLSupplierID.length; loop ++){

        var supplierID      = XMLSupplierID[loop].childNodes[0].nodeValue;
        var supplierName    = XMLSupplier[loop].childNodes[0].nodeValue

        optSupplier.append($('<option></option>').val(supplierID).text(supplierName));
    }
    
    /* ==================================================================== */
    
    /*
     * Load SC List
     * =====================================================================     * 
     */
    
    var urlSC 		= dir_path+"pocorrection.php?RequestType=LoadSCList";
    var htmlObjSC 	= $.ajax({url:urlSC, async:false});
    
    var XMLStyleID    = htmlObjSC.responseXML.getElementsByTagName("StyleID");	
    var XMLSC         = htmlObjSC.responseXML.getElementsByTagName("SCNo");
   
    var optSC	= $("#cboSR");
    optSC.append($('<option></option>').val(-1).text(""));
   
    for ( var loop = 0; loop < XMLStyleID.length; loop ++){

        var styleID = XMLStyleID[loop].childNodes[0].nodeValue;
        var SCNo    = XMLSC[loop].childNodes[0].nodeValue

        optSC.append($('<option></option>').val(styleID).text(SCNo));
    }
    
    /* ==================================================================== */
    
    /*
     * Load Orders List
     * =====================================================================     * 
     */
    
    var urlSC 		= dir_path+"pocorrection.php?RequestType=LoadOrdersList";
    var htmlObjStyle 	= $.ajax({url:urlSC, async:false});
    
    var XMLStyleID    = htmlObjStyle.responseXML.getElementsByTagName("StyleID");	
    var XMLStyleName  = htmlObjStyle.responseXML.getElementsByTagName("StyleName");
   
    var optOrders = $("#cboOrderNo");
    optOrders.append($('<option></option>').val(-1).text(""));
   
    for ( var loop = 0; loop < XMLStyleID.length; loop ++){

        var styleID     = XMLStyleID[loop].childNodes[0].nodeValue;
        var StyleName   = XMLStyleName[loop].childNodes[0].nodeValue

        optOrders.append($('<option></option>').val(styleID).text(StyleName));
    }
    
    /* ==================================================================== */
    
    /*
     * Load Years
     * =====================================================================
     */
    
    var currentDate = new Date();
    var optYear = $("#cboYear");
    var currentYear = currentDate.getFullYear();
    
    
    for(var loop = currentYear; loop >= 2008; loop-- ){
        optYear.append($('<option></option>').val(loop).text(loop));
    }
    
   
    
    /* ===================================================================== */
    
    $("#cboSR").on('change', function(){$("#cboOrderNo").val($("#cboSR").val());});
    $("#cboOrderNo").on('change', function(){$("#cboSR").val($("#cboOrderNo").val());});
    
    $("#btnSearch").click(function(e){LoadGrid();});
    
    function LoadGrid(){
        
        
        
        $("#tbListing > tbody").html("");
        
        var styleId     = $("#cboSR").val();
        var supplierId  = $("#cboSupplier").val();
        var poNumber    = $("#txtPOLike").val();
        var poYear      = $("#cboYear").val();
        
        
        
        var urlPOList   = "pocorrection.php?RequestType=GetPOList&stylecode="+styleId+"&suppliercode="+supplierId+"&pono="+poNumber+"&poyear="+poYear;
        
        var objPO = $.ajax({url:urlPOList, async:false});
        
        var XMLPOYear = objPO.responseXML.getElementsByTagName("POYear");
        var XMLPONo   = objPO.responseXML.getElementsByTagName("PONumber");
        var XMLSupplier = objPO.responseXML.getElementsByTagName("Supplier");
        var XMLPODate = objPO.responseXML.getElementsByTagName("PODate");
        var XMLDeliveryDate = objPO.responseXML.getElementsByTagName("DeliveryDate");
        var XMLDeliveryTo = objPO.responseXML.getElementsByTagName("DeliveryTo");
        var XMLETD = objPO.responseXML.getElementsByTagName("ETD");
        var XMLPOUser = objPO.responseXML.getElementsByTagName("POUser");
        
        for ( var loop = 0; loop < XMLPONo.length; loop ++)
        {
            var POYear = XMLPOYear[loop].childNodes[0].nodeValue;
            var PONo   = XMLPONo[loop].childNodes[0].nodeValue;
            var PONumber = POYear +"/" + PONo;
            var SupplierName = XMLSupplier[loop].childNodes[0].nodeValue;
            var DeliveryTo = XMLDeliveryTo[loop].childNodes[0].nodeValue;
            var PODate = XMLPODate[loop].childNodes[0].nodeValue;
            var PODeliDate = XMLDeliveryDate[loop].childNodes[0].nodeValue;
            var POETD = XMLETD[loop].childNodes[0].nodeValue;
            var POUser = XMLPOUser[loop].childNodes[0].nodeValue;
            
            
            
            $("#tbListing > tbody:last-child").append("<tr data-toggle='tooltip'><td class='col-xs-1' style='width:7%'>"+PONumber+"</td><td class='col-xs-1' style='width:8%'>"+SupplierName+"</td><td class='col-xs-1' style='width:7%'>&nbsp;"+DeliveryTo+"</td><td class='col-xs-1' style='width:7%'>&nbsp;"+PODate+"</td><td class='col-xs-1'>&nbsp;"+PODeliDate+"</td><td class='col-xs-1'>&nbsp;"+POETD+"</td><td class='col-xs-1'>&nbsp;"+POUser+"</td><td class='col-xs-1'><button class='btn btn-warning' id="+PONumber+" onclick='ViewCorrection(this)'>View</button></td></tr>");
        }
        
        
        
    }
    
    
});

function ViewCorrection(obj){
    
    var arrayPOObj = obj.id.split("/"); 
    window.open("changePO.php?pono=" + arrayPOObj[1] + "&year=" + arrayPOObj[0],'frmcomplete');
    
    
}

function loadPO(varPONo, varPOYear){
    
    var urlPOInformation   = "pocorrection.php?RequestType=GetPOInformation&pono="+varPONo+"&poyear="+varPOYear;
    var objPODetails = $.ajax({url:urlPOInformation, async:false});
    
    SupplierId = objPODetails.responseXML.getElementsByTagName("SupplierID")[0].childNodes[0].nodeValue;
    PayTermId  = objPODetails.responseXML.getElementsByTagName("payTermID")[0].childNodes[0].nodeValue;
    PatModeId  = objPODetails.responseXML.getElementsByTagName("payModeID")[0].childNodes[0].nodeValue;
    ShipModeId = objPODetails.responseXML.getElementsByTagName("shipModeID")[0].childNodes[0].nodeValue;
    ShipTermId = objPODetails.responseXML.getElementsByTagName("shipTermID")[0].childNodes[0].nodeValue;
    InvoiceId = objPODetails.responseXML.getElementsByTagName("invoiceToID")[0].childNodes[0].nodeValue;
    DeliveryId = objPODetails.responseXML.getElementsByTagName("deliveryToID")[0].childNodes[0].nodeValue;
    dtDelivery = objPODetails.responseXML.getElementsByTagName("deliveryDate")[0].childNodes[0].nodeValue;
    dtETA = objPODetails.responseXML.getElementsByTagName("ETA")[0].childNodes[0].nodeValue;
    dtETD = objPODetails.responseXML.getElementsByTagName("ETD")[0].childNodes[0].nodeValue;
    dtACD = objPODetails.responseXML.getElementsByTagName("ACD")[0].childNodes[0].nodeValue;
    dtADD = objPODetails.responseXML.getElementsByTagName("ADD")[0].childNodes[0].nodeValue;
    
    $("#cmbSupplier").val(SupplierId);
    $("#cmbPayTerm").val(PayTermId);
    $("#cmbPayMode").val(PatModeId);
    $("#cmbShipMode").val(ShipModeId);
    $("#cmbShipTerm").val(ShipTermId);
    $("#cmbInvoiceTo").val(InvoiceId);
    $("#cmbDeliveryTo").val(DeliveryId);
    $("#dtDeliveryDate").val(dtDelivery);
    $("#dtETADate").val(dtETA);
    $("#dtETDDate").val(dtETD);
    $("#dtACDate").val(dtACD);
    $("#dtADDate").val(dtADD);
    
   // alert(XMLSupplierId)
}

function IsGRNExistPO(varPONo, varPOYear){
    
    var urlPOGRN   = "pocorrection.php?RequestType=POGRNDone&pono="+varPONo+"&poyear="+varPOYear;
    var objPOGRN = $.ajax({url:urlPOGRN, async:false});
    
    var IsGRNExist = objPOGRN.responseXML.getElementsByTagName("IsGRN")[0].childNodes[0].nodeValue;
    
    if(IsGRNExist > 0){
        alert("Sorry!\nYou cannot change this PO.GRN available for this PO.");
        window.close();
   }
}

function PageClose(){
    window.close();
}

function UpdatePO(varPONo, varPOYear){
    
    var newSupplierId = $("#cmbSupplier").val();
    var newPayMode    = $("#cmbPayMode").val();
    var newPayTerm    = $("#cmbPayTerm").val();
    var newShipMode   = $("#cmbShipMode").val();
    var newShipTerm   = $("#cmbShipTerm").val();
    var newInvoiceTo  = $("#cmbInvoiceTo").val();
    var newDeliveryTo = $("#cmbDeliveryTo").val();
    var newDeliveryDate = $("#dtDeliveryDate").val();
    var newETA          = $("#dtETADate").val();
    var newETD          = $("#dtETDDate").val();
    var actualDeliveryDate = $("#dtADDate").val();
    var actualClearedDate  = $("#dtACDate").val();
    
    if(SupplierId != newSupplierId){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=Supplier"+"&prevalue="+SupplierId+"&newvalue="+newSupplierId;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(PatModeId != newPayMode){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=PayMode"+"&prevalue="+PatModeId+"&newvalue="+newPayMode;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(PayTermId != newPayTerm){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=PayTerm"+"&prevalue="+PayTermId+"&newvalue="+newPayTerm;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(ShipModeId != newShipMode){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=ShipMode"+"&prevalue="+ShipModeId+"&newvalue="+newShipMode;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(ShipTermId != newShipTerm){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=ShipTerm"+"&prevalue="+ShipTermId+"&newvalue="+newShipTerm;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(InvoiceId != newInvoiceTo){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=InvoiceTo"+"&prevalue="+InvoiceId+"&newvalue="+newInvoiceTo;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(DeliveryId != newDeliveryTo){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=DeliveryTo"+"&prevalue="+DeliveryId+"&newvalue="+newDeliveryTo;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(dtDelivery != newDeliveryDate){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=DeliveryDate"+"&prevalue="+dtDelivery+"&newvalue="+newDeliveryDate;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(dtETA != newETA){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=ETADate"+"&prevalue="+dtETA+"&newvalue="+newETA;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    if(dtETD != newETD){
        var urlPOLog   = "pocorrection.php?RequestType=POChangeLog&pono="+varPONo+"&poyear="+varPOYear+"&source=ETDDate"+"&prevalue="+dtETD+"&newvalue="+newETD;
        var objPOLOg = $.ajax({url:urlPOLog, async:false});
    }
    
    
    var urlPOUpdate   = "pocorrection.php?RequestType=POUpdate&pono="+varPONo+"&poyear="+varPOYear+"&supplierId="+newSupplierId+"&paymodeid="+newPayMode+"&paytermid="+newPayTerm+"&shipmodeid="+newShipMode+"&shiptermid="+newShipTerm+"&invoiceto="+newInvoiceTo+"&deliveryto="+newDeliveryTo+"&deliverydate="+newDeliveryDate+"&etadate="+newETA+"&etddate="+newETD+"&addate="+actualDeliveryDate+"&acdate="+actualClearedDate;
    var objPOUpdate = $.ajax({url:urlPOUpdate, async:false});
    
    alert(objPOUpdate.responseText);
    
}

function LoadInfo(){
    
    var styleCode    = $("#cboOrderNo").val();
    var supplierCode = $("#cboSupplier").val();
    var PONoLike     = $("#txtPOLike").val();
    var POYear       = $("#cboYear").val();
    var selectionCode = $("#cboSelection").val();
    var poDtFrom     = $("#txtdtfrom").val();
    var poDtTo       = $("#txtdtto").val();
    
    window.open('rptsupotd.php?styleid='+styleCode+'&supplierid='+supplierCode+'&pono='+PONoLike+'&poyear='+POYear+'&selection='+selectionCode+'&pofrom='+poDtFrom+'&poto='+poDtTo);
    
}

function setClearedDate(){
    
    var supplierCode = $("#cmbSupplier").val();
    
    var urlPOUpdate   = "pocorrection.php?RequestType=GetSupplierCountry&supcode="+supplierCode;
    var htmlObj = $.ajax({url:urlPOUpdate,async:false});
    
    var CountryCode = htmlObj.responseXML.getElementsByTagName("CountryCode")[0].childNodes[0].nodeValue;
    
    switch(CountryCode){
        case "1":
            $("#dtACDate").val($("#dtETDDate").val());
            break;
            
        default:
            $("#dtACDate").val("");
            break;
    }
    
    
}

