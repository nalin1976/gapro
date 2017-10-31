$(function(){
   
    // =============================================================
    // Load buyers to the buyers dropdown list
    // =============================================================
    var url 		= "bomreportmiddle.php?RequestType=LoadBuyers";
    var htmlObj 	= $.ajax({url:url, async:false});

    var XMLBuyers 	= htmlObj.responseXML.getElementsByTagName("BuyerID");	
    var XMLBuyerName 	= htmlObj.responseXML.getElementsByTagName("BuyerName");

    var optBuyers	= $("#cboCustomer");
    optBuyers.append($('<option></option>').val(-1).text(""));

    for ( var loop = 0; loop < XMLBuyers.length; loop ++){

        var buyerID 	= XMLBuyers[loop].childNodes[0].nodeValue;
        var buyerName 	= XMLBuyerName[loop].childNodes[0].nodeValue

        optBuyers.append($('<option></option>').val(buyerID).text(buyerName));
    }
    
    // =============================================================
    // Load styles to the selection list
    // =============================================================
    var urlOrders	= "bomreportmiddle.php?RequestType=LoadOrders";
    var htmlObjOrders 	= $.ajax({url:urlOrders, async:false});
    
    var XMLStyleCode = htmlObjOrders.responseXML.getElementsByTagName("StyleCode");
    var XMLStyleId   = htmlObjOrders.responseXML.getElementsByTagName("StyleID");
    
    var optOrders	= $("#cboStyles");
    optOrders.append($('<option></option>').val(-1).text(""));

    for ( var loop = 0; loop < XMLStyleCode.length; loop ++){

        var styleCode 	= XMLStyleCode[loop].childNodes[0].nodeValue;
        var styleName 	= XMLStyleId[loop].childNodes[0].nodeValue

        optOrders.append($('<option></option>').val(styleCode).text(styleName));
    }
    
    // =============================================================
    // Load styles to the selection list
    // =============================================================
    var urlSC       = "bomreportmiddle.php?RequestType=LoadSC";
    var htmlObjSC   = $.ajax({url:urlSC, async:false});
    
    var XMLStyleCode = htmlObjSC.responseXML.getElementsByTagName("StyleCode");
    var XMLSCNo      = htmlObjSC.responseXML.getElementsByTagName("SCNo");
    
    var optSC       = $("#cboSR");
    optSC.append($('<option></option>').val(-1).text(""));

    for ( var loop = 0; loop < XMLStyleCode.length; loop ++){

        var styleCode 	= XMLStyleCode[loop].childNodes[0].nodeValue;
        var scNo 	= XMLSCNo[loop].childNodes[0].nodeValue

        optSC.append($('<option></option>').val(styleCode).text(scNo));
    }
    
    
    $("#cboSR").change(function(){
       
       var styleCode = $("#cboSR").val();
       
       //$("#cboStyles option:contains(" + styleCode + ")").attr('selected', true);
        
    });
    
    $("#btnSearch").click(function(){
        
        $("#tblPreOders > tbody").html("");
        
        var buyerCode = $("#cboCustomer").val();
        
        if(buyerCode == '-1'){
            ValidateControls("Please select buyer name from the list");
            return;
        }
        
        var urlOrders   = "bomreportmiddle.php?RequestType=LoadStyles&bc="+buyerCode;
        var htmlObjSC   = $.ajax({url:urlOrders, async:false});
        
        var XMLStyleCode = htmlObjSC.responseXML.getElementsByTagName("StyleCode");
        var XMLStyleId   = htmlObjSC.responseXML.getElementsByTagName("StyleID");
        var XMLSCNo      = htmlObjSC.responseXML.getElementsByTagName("SCNo");
        var XMLStyleDesc = htmlObjSC.responseXML.getElementsByTagName("StyleDesc");
        var XMLCompany   = htmlObjSC.responseXML.getElementsByTagName("Company");
        var XMLBuyer     = htmlObjSC.responseXML.getElementsByTagName("Buyer");
        
        for ( var loop = 0; loop < XMLStyleCode.length; loop ++){

            var styleCode = XMLStyleCode[loop].childNodes[0].nodeValue;
            var scNo 	  = XMLSCNo[loop].childNodes[0].nodeValue;
            var styleNo   = XMLStyleId[loop].childNodes[0].nodeValue;
            var styleDesc = XMLStyleDesc[loop].childNodes[0].nodeValue;
            var sCompany  = XMLCompany[loop].childNodes[0].nodeValue;
            var buyerName = XMLBuyer[loop].childNodes[0].nodeValue;

            $("#tblPreOders > tbody:last-child").append("<tr class=\"textformat\"><td>"+styleNo+"</td><td>"+scNo+"</td><td>"+styleDesc+"</td><td>"+sCompany+"</td><td>"+buyerName+"</td><td><input type='button' class=\"btn btn-warning\" id="+styleCode+" name="+styleCode+" value='View' onclick='viewreport(this.id)' /></td><td><button type=\"button\" class=\"btn btn-warning\" id="+styleCode+" name="+styleCode+" onclick='viewXLSReport(this.id)'><img src='images/excel.png'></img></button></td></tr>");
        }
        
    });
    
});

function ValidateControls(prmMessage){
    
    alert(prmMessage);
}


