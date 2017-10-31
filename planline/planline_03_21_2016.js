// JavaScript
$(document).ready(function(e){

	// Load order details
	var url = "planmiddle.php?reqid=NotTransfer";
	var htmlObj = $.ajax({url:url, async:false});

	var XMLStyleID   = htmlObj.responseXML.getElementsByTagName("STYLEID");
	var XMLSCNO      = htmlObj.responseXML.getElementsByTagName("SCNO");
	var XMLStyleCode = htmlObj.responseXML.getElementsByTagName("STYLE_CODE");

	// Get assign list object
	var objAssign = $("#assignlist");

	//Get unassign list object
	var objUnassign = $("#unassignlist");


	for(i=0;i<XMLStyleID.length;i++){

		var styleID = XMLStyleID[i].childNodes[0].nodeValue;
		var SCNO    = XMLSCNO[i].childNodes[0].nodeValue;
		var Style   = XMLStyleCode[i].childNodes[0].nodeValue;

		objUnassign.append("<option style='height:1.9em;' value='"+styleID+"'>"+SCNO+ " - " +Style+"</option>");

	}

	$("#unassignlist").dblclick(function(){

		AssignOrders(objUnassign, objAssign);

	});


	$("#btnAssign").click(function(){
		AssignOrders(objUnassign, objAssign);
	});


	$("#assignlist").dblclick(function(){

		UnAssignOrders(objUnassign, objAssign);

	});

	$("#btnUnAssign").click(function(){
		UnAssignOrders(objUnassign, objAssign);
	});

	$("#btnTransfer").click(function(){

		var count = $("#assignlist option").length;

		//alert(count);

		$("#assignlist option").each(function(index){

			var optionText = $(this).text();
			var optionValue = $(this).val();
			

			setTimeout(function(){
				$("#txtProgress").val("Processing........ " + optionText);


				//Get order details from GAPRO
				GetOrderDetails(optionValue);

				//Calculate labour processing
				LabourProcessing(optionValue);

				//Calculate finance processing
				FinanceProcessing(optionValue);

				//Order add to the transfer table
				AddStyleToTransfer(optionValue);

			},index*1000);
			//return false;
			//$("#assignlist").empty();

			setTimeout(function(){

				if(index+1==count){

					$("#assignlist").empty();
					$("#txtProgress").val("Process Completed... "); 
				}
			},index*1500);
		});		

	});

});

function msg(){

	alert("OK");
		$("#txtProgress").val("Completed");

}



function AssignOrders(prmObjUnAssign, prmObjAssign){

	$(prmObjUnAssign).find('option:selected').each(function(){

		var selectedValue = $(this).val();
		var selectedText  = $(this).text();

		prmObjAssign.append("<option style='height:1.9em;' value='"+selectedValue+"'>"+selectedText+"</option>");	

		$(this).remove();	

	});

}

function UnAssignOrders(prmObjUnAssign, prmObjAssign){

	$(prmObjAssign).find('option:selected').each(function(){

		var selectedValue = $(this).val();
		var selectedText  = $(this).text();

		prmObjUnAssign.append("<option style='height:1.9em;' value='"+selectedValue+"'>"+selectedText+"</option>");	

		$(this).remove();	

	});

}

function GetOrderDetails(prmStyleID){


	var url = "planmiddle.php?reqid=OrderDetails&ordercode="+prmStyleID;
	var htmlObj = $.ajax({url:url, async:false});

	var XMLSCNO 		= htmlObj.responseXML.getElementsByTagName("SCNO");
	var XMLTaskCode 	= htmlObj.responseXML.getElementsByTagName("TASK_CODE");
	var XMLOrderDate 	= htmlObj.responseXML.getElementsByTagName("O_DATE");
	var XMLItemID		= htmlObj.responseXML.getElementsByTagName("ITEM_ID");
	var XMLItemDesc		= htmlObj.responseXML.getElementsByTagName("ITEM_DESC");
	var XMLUOM			= htmlObj.responseXML.getElementsByTagName("ITEM_UNIT");
	var XMLTotValue		= htmlObj.responseXML.getElementsByTagName("ITEM_TOT_VALUE");
	var XMLTotQty		= htmlObj.responseXML.getElementsByTagName("ITEM_TOT_QTY");
	var XMLItemPrice	= htmlObj.responseXML.getElementsByTagName("ITEM_PRICE");

	for(iRows = 0; iRows<XMLSCNO.length; iRows++){

		var iSCNO 		= XMLSCNO[iRows].childNodes[0].nodeValue;
		var iItemId 	= XMLItemID[iRows].childNodes[0].nodeValue; 
		var TaskCode    = XMLTaskCode[iRows].childNodes[0].nodeValue; 
		var ItemDesc    = XMLItemDesc[iRows].childNodes[0].nodeValue; 
		var sUOM 		= XMLUOM[iRows].childNodes[0].nodeValue;
		var UnitPrice   = XMLItemPrice[iRows].childNodes[0].nodeValue;
		var ItmeTotVal  = XMLTotValue[iRows].childNodes[0].nodeValue;
		var TotReqQty   = XMLTotQty[iRows].childNodes[0].nodeValue;
		var CostDate    = XMLOrderDate[iRows].childNodes[0].nodeValue;


		var JobNo		= "SC" + iSCNO;
		var sItemCode 	= iSCNO + "-" + iItemId;

		if(ItemDesc.length > 50){
			ItemDesc = ItemDesc.substring(0,48);
		}


		// Check if item exist in the Navision based on given SC number and item code
		var url1 				= "planmiddle.php?reqid=IsInNavision&jobNo="+JobNo+"&taskcode="+TaskCode+"&itemcode="+sItemCode;
		var htmlObjNaviExist 	= $.ajax({url:url1, async:false});

		XMLIsExist 		= htmlObjNaviExist.responseXML.getElementsByTagName("LINE_EXIST");

		var IsExist 	= parseInt(XMLIsExist[0].childNodes[0].nodeValue);
		//alert(IsExist)
		if(IsExist == 0){

			//alert("OK");

			var iMaxLineNo = GetMaxLineNo();
			iMaxLineNo += 10000; // Line number increase by 10,000

			// Save line to the Navision
			SavePlanningLines(JobNo, TaskCode, iMaxLineNo, CostDate, sItemCode, ItemDesc, sUOM, UnitPrice, ItmeTotVal, iSCNO, TotReqQty, "500", "1", "WELISARA", "RAWMAT",0,2,1,"YES", "NO",1)

		}


	}
}

function GetMaxLineNo(){

	//Get max line number from Navision table
	var urlMaxNo 		= "planmiddle.php?reqid=GetMaxNo";
	var htmlObjMaxNo 	= $.ajax({url:urlMaxNo, async:false});

	XMLMaxLine 		= htmlObjMaxNo.responseXML.getElementsByTagName("LINE_NO");
	
	var iMaxLine 	= parseInt(XMLMaxLine[0].childNodes[0].nodeValue);

	return iMaxLine;

}

function SavePlanningLines(prmJobNo, prmTaskCode, prmLineNo, prmCostDate, prmItemCode, prmItemDescription, prmItemUOM, prmUnitPrice, prmTotalPrice, prmSCNo, prmTotQty, prmDocNo, prmDocType, prmLocationCode, prmGenProd, prmLineType, prmStatus, prmQUOM, prmContractLine, prmScheduleLine, prmExRate){

	var urlSave				= "planmiddle.php?reqid=SaveLines&jobno="+prmJobNo+"&taskcode="+prmTaskCode+"&lineno="+prmLineNo+"&costdate="+prmCostDate+"&itemcode="+prmItemCode+"&itemdesc="+prmItemDescription+"&uom="+prmItemUOM+"&itemprice="+prmUnitPrice+"&itemvalue="+prmTotalPrice+"&scno="+prmSCNo+"&itemqty="+prmTotQty+"&docno="+prmDocNo+"&type="+prmDocType+"&loccode="+prmLocationCode+"&genprod="+prmGenProd+"&linetype="+prmLineType+"&status="+prmStatus+"&quom="+prmQUOM+"&conline="+prmContractLine+"&scheline="+prmScheduleLine+"&exrate="+prmExRate;
	var htmlObjSaveBuget 	= $.ajax({url:urlSave, async:false});

	var XMLResult 		= htmlObjSaveBuget.responseXML.getElementsByTagName("RES");
	var XMLQuery 		= htmlObjSaveBuget.responseXML.getElementsByTagName("QYE");

	var iResult = parseInt(XMLResult[0].childNodes[0].nodeValue);
	var sQuery  = XMLQuery[0].childNodes[0].nodeValue;

	if(iResult==0){

		alert("Saving Error in query " + sQuery);
	}
}

function LabourProcessing(prmStyleId){


	var url = "planmiddle.php?reqid=OrderHeader&ordercode="+prmStyleId;
	var htmlObj = $.ajax({url:url, async:false});

	var XMLSCNO 		= htmlObj.responseXML.getElementsByTagName("SCNO");
	var XMLOrderQty 	= htmlObj.responseXML.getElementsByTagName("ORDER_QTY");
	var XMLEff		 	= htmlObj.responseXML.getElementsByTagName("EFF");
	var XMLSubQty		= htmlObj.responseXML.getElementsByTagName("SUB_QTY");
	var XMLODate		= htmlObj.responseXML.getElementsByTagName("O_DATE");
	var XMLFOH			= htmlObj.responseXML.getElementsByTagName("FAC_OH");
	var XMLSMV 			= htmlObj.responseXML.getElementsByTagName("SMV");
	
	for(iRows = 0; iRows<XMLSCNO.length; iRows++){

		var scNo 		= XMLSCNO[iRows].childNodes[0].nodeValue;
		var orderQty 	= parseInt(XMLOrderQty[iRows].childNodes[0].nodeValue);
		var orderEff 	= parseFloat(XMLEff[iRows].childNodes[0].nodeValue);
		var subQty 		= XMLSubQty[iRows].childNodes[0].nodeValue;
		var costDate 	= XMLODate[iRows].childNodes[0].nodeValue;
		var facOH 		= parseFloat(XMLFOH[iRows].childNodes[0].nodeValue);
		var smv 		= XMLSMV[iRows].childNodes[0].nodeValue;

		var InHouseQty  = orderQty - subQty;
		var JobNo 		= "SC"+scNo;

		if(InHouseQty > 0){

			var LabourCost = parseFloat(CalculateLabourCost(InHouseQty, facOH, smv, orderEff));
			var unitLabour = parseFloat(LabourCost/InHouseQty);

			var IsExist = IsLabourExist(JobNo);

			if(IsExist == 0){

				var iLineNo = GetMaxLineNo();

				//Save Labour Cost
				SavePlanningLines(JobNo,"14",iLineNo,costDate,"E001", "LABOUR", "UM", unitLabour, LabourCost, scNo, InHouseQty, "500", "0", "WELISARA", "LABOUR",0,2,1,"YES", "NO",1);

			}
		}
	}
}

function CalculateLabourCost(prmInhouseQty, prmFacOH, prmSMV, prmEff){

	var _LabourCost = 0;

	_LabourCost = parseFloat(((prmSMV/prmEff) * 100) * prmInhouseQty * prmFacOH);

	return _LabourCost.toFixed(2);
}

function IsLabourExist(prmJobNo){

	// Check if labour cost exist in the NAVISION
	var url2 = "planmiddle.php?reqid=LabourExist&jobno="+prmJobNo;
	var htmlObjLabourExist = $.ajax({url:url2, async:false});

	XMLIsExist 		= htmlObjLabourExist.responseXML.getElementsByTagName("L_EXIST");

	var IsExist 	= parseInt(XMLIsExist[0].childNodes[0].nodeValue);

	return IsExist;
}

function FinanceProcessing(prmStyleId){

	var lineDescription = "FINANCE AND ESC CHARGE VALUE";

	var url = "planmiddle.php?reqid=GetFinance&ordercode="+prmStyleId;
	var htmlObj = $.ajax({url:url, async:false});

	var XMLSCNO 		= htmlObj.responseXML.getElementsByTagName("SCNO");
	var XMLOrderQty 	= htmlObj.responseXML.getElementsByTagName("ORDER_QTY");
	var XMLODate		= htmlObj.responseXML.getElementsByTagName("O_DATE");
	var XMLFIN			= htmlObj.responseXML.getElementsByTagName("FIN");
	
	for(iRows = 0; iRows<XMLFIN.length; iRows++){

		var scNo 		= XMLSCNO[iRows].childNodes[0].nodeValue;
		var orderQty 	= parseInt(XMLOrderQty[iRows].childNodes[0].nodeValue);
		var finValue 	= parseFloat(XMLFIN[iRows].childNodes[0].nodeValue);
		var costDate 	= XMLODate[iRows].childNodes[0].nodeValue;

		var JobNo  		= "SC"+scNo;

		var totFinValue	= finValue * orderQty;

		var IsExist = IsFinanceExist(JobNo);

		if(IsExist == 0){

			var iLineNo = GetMaxLineNo();

			SavePlanningLines(JobNo,"506",iLineNo,costDate,"F001", lineDescription, "PCS", finValue, totFinValue, scNo, orderQty, "500", "1", "WELISARA", "RAWMAT",0,2,1,"YES", "NO",1);

		}


	}

}

function IsFinanceExist(prmJobNo){

	// Check if finance exist in the NAVISION
	var url2 = "planmiddle.php?reqid=FinanceExist&jobno="+prmJobNo;
	var htmlObjFinanceExist = $.ajax({url:url2, async:false});

	XMLIsExist 		= htmlObjFinanceExist.responseXML.getElementsByTagName("F_EXIST");

	var IsExist 	= parseInt(XMLIsExist[0].childNodes[0].nodeValue);

	return IsExist;
}

function AddStyleToTransfer(prmStyleId){

	var url2 = "planmiddle.php?reqid=AddTransfer&ordercode="+prmStyleId;
	var htmlObj = $.ajax({url:url2, async:false});

}
