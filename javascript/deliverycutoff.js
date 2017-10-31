// JavaScript Document
$(document).ready(function(e) {
	
	var dt = new Date();
	//$("#txtCutOffDate").val(dt.toDateString());
	
    $("#cmdSearch").click(function(e) {
		//alert(dt.getDate())
		var currentDate = dt.toISOString().slice(0,10).replace(/-/g,"-");
		
		$("#tbDeliveries").empty();
        
		var buyerCode 	= $("#cmbBuyer").val();
		var dtCutOff	= $("#txtCutOffDate").val();
				
		var url = "../lib/middledeliverycutoff.php?RequestType=CutOffDelivery&buyercode="+buyerCode+"&cutoff="+dtCutOff;
		
		var resDelivery = $.ajax({url:url, async:false});
		
		var XMLSCNo			= resDelivery.responseXML.getElementsByTagName("SCNO");
		var XMLStyle		= resDelivery.responseXML.getElementsByTagName("StyleID");
		var XMLMerchant		= resDelivery.responseXML.getElementsByTagName("Merchant");
		var XMLBuyer		= resDelivery.responseXML.getElementsByTagName("Buyer");
		var XMLBuyerPONo	= resDelivery.responseXML.getElementsByTagName("BuyerPONo");
		var XMLCutOffDate	= resDelivery.responseXML.getElementsByTagName("CutOffDate");
		var XMLDeliveryDate	= resDelivery.responseXML.getElementsByTagName("DeliveryDate");
		var XMLQty			= resDelivery.responseXML.getElementsByTagName("Qty");
		
		
		for(var loop=0;loop<XMLSCNo.length;loop++){
			
			var scno		= XMLSCNo[loop].childNodes[0].nodeValue;
			var styleId		= XMLStyle[loop].childNodes[0].nodeValue;
			var user		= XMLMerchant[loop].childNodes[0].nodeValue;
			var buyer		= XMLBuyer[loop].childNodes[0].nodeValue;
			var buyerpoNo	= XMLBuyerPONo[loop].childNodes[0].nodeValue;
			var cutoffdate	= XMLCutOffDate[loop].childNodes[0].nodeValue;
			var dtdelivery	= XMLDeliveryDate[loop].childNodes[0].nodeValue;
			var qty			= XMLQty[loop].childNodes[0].nodeValue;
			
			if(cutoffdate<=currentDate){
			
			$("#tbDeliveries").append("<tr style='background-color:#FF3300;' height='20'><td class='normalfnt'>"+scno+"</td><td class='normalfnt'>"+styleId+"</td><td class='normalfnt'>&nbsp;"+user+"</td><td class='normalfnt'>"+buyer+"</td><td class='normalfnt'>"+buyerpoNo+"</td><td class='normalfntRite'>"+qty+"&nbsp;</td><td class='normalfntMid'>"+cutoffdate+"</td><td class='normalfntMid'>"+dtdelivery+"</td></tr>");
			}else{
				
				$("#tbDeliveries").append("<tr style='background-color:#FFFF99;' height='20'><td class='normalfnt'>"+scno+"</td><td class='normalfnt'>"+styleId+"</td><td class='normalfnt'>&nbsp;"+user+"</td><td class='normalfnt'>"+buyer+"</td><td class='normalfnt'>"+buyerpoNo+"</td><td class='normalfntRite'>"+qty+"&nbsp;</td><td class='normalfntMid'>"+cutoffdate+"</td><td class='normalfntMid'>"+dtdelivery+"</td></tr>");
				
			}
		}
    });
	
	$("#cmdExcelFile").click(function(e) {
        
		var buyerCode 	= $("#cmbBuyer").val();
		var dtCutOff	= $("#txtCutOffDate").val();
		
		window.location = "rptxlsdeliverycutoff.php?cutOffDate="+dtCutOff+"&buyerCode="+buyerCode;
		
		
    });
});
