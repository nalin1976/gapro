$(function(){

	SetCalendarDate();

	var currentDate = new Date();

	var currentMonth = currentDate.getMonth();
	var currentYear  = currentDate.getFullYear();

	$("#cmbFreezeMonth option:eq("+currentMonth+")").prop("selected", true);
	$("#cmbFreezeYear option:eq("+currentYear+")").prop("selected", true);
	

	// =============================================================
	
	// =============================================================
	// Add selected value to selection box
	// =============================================================
	$(".dropdown-menu li a").click(function(){
		var selText = $(this).text();

		$(this).parents(".dropdown").find(".dropdown-toggle").html(selText+" &nbsp;<span class='caret caret-right'></span>");
	});

	// =============================================================

	$("#btnFreeze").click(function(e){

		var freezeMonth = $("#cmbFreezeMonth").val();
		var freezeYear  = $("#cmbFreezeYear").val();

		var dtFrom 		= GetDateFormat($("#txtFrmDate").val());
		var dtTo 		= GetDateFormat($("#txtToDate").val());

		//Check Freeze exist in seleted month and year before save
		var url1 		= "freezemiddle.php?RequestType=IsExist&m="+freezeMonth+"&y="+freezeYear
		var htmlObj1 	= $.ajax({url:url1, async:false});

		var XMLIsExist 	= htmlObj1.responseXML.getElementsByTagName("FreezeIn");

		var iResult 	= parseInt(XMLIsExist[0].childNodes[0].nodeValue);

		if(iResult == 1){

			alert(" Delivery schedule already exist in selected month and year");
			return;
		}

		// Save freeze schedule
		var url 	= "freezemiddle.php?RequestType=SaveFreeze&m="+freezeMonth+"&y="+freezeYear+"&dtfrom="+dtFrom+"&dtto="+dtTo;
		var htmlObj = $.ajax({url:url, async:false});

		var XMLMsg 	= htmlObj.responseXML.getElementsByTagName("SaveMsg");
		var strMsg  = (XMLMsg[0].childNodes[0].nodeValue);

		if(strMsg == "1"){
			alert("Delivery schedule freeze successfully");
			return;
		}else{
			alert(strMsg + " !");
		}

		
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
