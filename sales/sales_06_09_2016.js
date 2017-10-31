$(function(){

	SetCalendarDate();

	// =============================================================
	// Load buyers to the buyers dropdown list
	// =============================================================
	var url 			= "salesmiddle.php?RequestType=LoadBuyers";
	var htmlObj 		= $.ajax({url:url, async:false});

	var XMLBuyers 		= htmlObj.responseXML.getElementsByTagName("BuyerID");	
	var XMLBuyerName 	= htmlObj.responseXML.getElementsByTagName("BuyerName");

	var optBuyers	= $("#cmbBuyers");
	optBuyers.append($('<option></option>').val(-1).text(""));

	for ( var loop = 0; loop < XMLBuyers.length; loop ++){

		var buyerID 	= XMLBuyers[loop].childNodes[0].nodeValue;
		var buyerName 	= XMLBuyerName[loop].childNodes[0].nodeValue

		optBuyers.append($('<option></option>').val(buyerID).text(buyerName));
	}

	

	// =============================================================
	
	// =============================================================
	// Add selected value to selection box
	// =============================================================
	$(".dropdown-menu li a").click(function(){
		var selText = $(this).text();

		$(this).parents(".dropdown").find(".dropdown-toggle").html(selText+" &nbsp;<span class='caret caret-right'></span>");
	});

	// =============================================================

	$("#btnSearch").click(function(e){

		$("#tbListing > tbody").html("");

		var buyerId 	= $("#cmbBuyers").val();
		var fromDate 	= GetDateFormat($("#txtFrmDate").val());
		var toDate 		= GetDateFormat($("#txtToDate").val());

		if(buyerId == '-1'){alert("Select buyer from the listing"); return;}

		var url 		= "salesmiddle.php?RequestType=LoadDeliveries&BuyerID="+buyerId+"&FromDate="+fromDate+"&ToDate="+toDate;
		var htmlObj 	= $.ajax({url:url, async:false});

		var XMLStyle 	= htmlObj.responseXML.getElementsByTagName("StyleID");	
		var XMLSCNo 	= htmlObj.responseXML.getElementsByTagName("SCNO");	
		var XMLBPO 		= htmlObj.responseXML.getElementsByTagName("BPONo");	
		var XMLDelQty 	= htmlObj.responseXML.getElementsByTagName("DelQty");	
		var XMLFOB 		= htmlObj.responseXML.getElementsByTagName("FOB");		
		var XMLHODDate 	= htmlObj.responseXML.getElementsByTagName("HOD");	
		var XMLWeek 	= htmlObj.responseXML.getElementsByTagName("WEEK");	
		var XMLStyleID 	= htmlObj.responseXML.getElementsByTagName("STYLE_CODE");
		var XMLFGStock  = htmlObj.responseXML.getElementsByTagName("FG_STOCK");
		var XMLApprove  = htmlObj.responseXML.getElementsByTagName("APPROVE");
		var XMLConfirm  = htmlObj.responseXML.getElementsByTagName("CONFIRM");

		for ( var loop = 0; loop < XMLStyle.length; loop ++)
		{

			var styleName 	= XMLStyle[loop].childNodes[0].nodeValue;
			var SCNo 		= XMLSCNo[loop].childNodes[0].nodeValue;
			var BPONo 		= XMLBPO[loop].childNodes[0].nodeValue;
			var DelQty	  	= XMLDelQty[loop].childNodes[0].nodeValue;	
			var dblFOB 		= XMLFOB[loop].childNodes[0].nodeValue;	
			var dtHOD 		= XMLHODDate[loop].childNodes[0].nodeValue;	
			var weekno 		= XMLWeek[loop].childNodes[0].nodeValue;
			var styleId 	= XMLStyleID[loop].childNodes[0].nodeValue;
			var fgStock 	= XMLFGStock[loop].childNodes[0].nodeValue;
			var isApprove   = XMLApprove[loop].childNodes[0].nodeValue;
			var isConfirm   = XMLConfirm[loop].childNodes[0].nodeValue;

			var objSaleExist = IsSalesExist(styleId, BPONo);
			
			var XMLAccConfirm   = objSaleExist.responseXML.getElementsByTagName("AccConfirm");
			var XMLShipConfirm  = objSaleExist.responseXML.getElementsByTagName("ShipConfirm");

			var IsAccMgrConfirm = XMLAccConfirm[0].childNodes[0].nodeValue; 
			var IsShipConfirm   = XMLShipConfirm[0].childNodes[0].nodeValue; 


			if(IsAccMgrConfirm == 1){

				if(IsShipConfirm == 1){
					$("#tbListing > tbody:last-child").append("<tr class='Completed'><td class='col-xs-1' id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id="+BPONo+">&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td></tr>");
				}else{

					if(isConfirm == 1){
						$("#tbListing > tbody:last-child").append("<tr><td class='col-xs-1' id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id="+BPONo+">&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td></tr>");	
					}else{
						$("#tbListing > tbody:last-child").append("<tr><td class='col-xs-1' id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id="+BPONo+">&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
					}
					
				}
			}
			else{

				if(isApprove == 1){
					$("#tbListing > tbody:last-child").append("<tr><td class='col-xs-1' id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id="+BPONo+">&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
				}else{
					$("#tbListing > tbody:last-child").append("<tr><td class='col-xs-1' id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id="+BPONo+">&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
				}
				
			}	
			
		}

	});


	$("#btnSave").click(function(e){

		var tbDeliveryListing = $("#tbListing > tbody");

		tbDeliveryListing.find('tr').each(function(key, val){

			var this_td = $(this).find('td');
			
			var styleId = $(this_td).eq(0).attr('id');
			var bpoNo  	= $(this_td).eq(4).attr('id');

			// Check if check box element exist in the column 9 for account manager confirmation	
			// ===========================================================================		
			var chkAccMgr = $(this_td).eq(9).find(':checkbox');
			if(chkAccMgr.length > 0){

				if($(chkAccMgr).is(":checked")){

					// If account manager confirm update the status.
					var url 		= "salesmiddle.php?RequestType=AccConfirm&styleId="+styleId+"&bpono="+bpoNo;
					var htmlObj1 	= $.ajax({url:url, async:false});
					
				}
			}
			// ===========================================================================


			// Check if check box element exist in the column 9 for account manager confirmation	
			// ===========================================================================		
			var chkShipStatus = $(this_td).eq(10).find(':checkbox');

			if(chkShipStatus.length > 0){

				if($(chkShipStatus).is(":checked")){

					// If account manager confirm update the status.
					var url 		= "salesmiddle.php?RequestType=ShipStatusConfirm&styleId="+styleId+"&bpono="+bpoNo;
					var htmlObj1 	= $.ajax({url:url, async:false});
					
				}
			}

			//=============================================================================
		});


 
	});


	$("#btnReport").click(function(){

		var buyerCode = $("#cmbBuyers").val();
		var dtFrom    = $("#txtFrmDate").val();
		var dtTo 	  = $("#txtToDate").val();

		var url  = "salesrep.php"+"?Buyer="+buyerCode+"&delDfrom="+dtFrom+"&delDto="+dtTo;
		window.open(url);
	

	});
});

function GetDateFormat(prmDate){

	var arrDate = prmDate.split("/");

	var reFormatDate = arrDate[2]+"-"+arrDate[1]+"-"+arrDate[0];

	return reFormatDate;

}

function IsSalesExist(styleId, buyerPOId){


	var url = "salesmiddle.php?RequestType=SalesExist&styleid="+styleId+"&bpono="+buyerPOId;
	var htmlObj = $.ajax({url:url, async:false});

	

	return htmlObj;	

}
