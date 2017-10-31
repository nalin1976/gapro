// JavaScript Document

var strHTMLDetails = '';
var dblTransportCharge = 0;
var dblExportExpences = 0;
var dblInterestCharges = 0;
var dblClearingCost = 0;
var dblLKRValue = 0;

var dtFromDate = '';
var dtToDate = '';

var intBuyerCode = -1;


function GetParamOption(){
	
	var iOption = 0;

	intBuyerCode = parseInt(document.getElementById('cmbBuyer').value);
	var booSummary = document.getElementById('chkSummary').checked;	
	
	if((intBuyerCode == -1) && (booSummary == false)){
		iOption = 1;
	}
	
	if((intBuyerCode != -1) && (booSummary == false)){
		iOption = 2;
	}
	
	if((intBuyerCode == -1) && (booSummary == true)){
		iOption = 3;
	}
	
	if((intBuyerCode != -1) && (booSummary == true)){
		iOption = 4;
	}
	
	return iOption;
	
}


function GetDateFormat(){
	
	
	var _dtFrom = document.getElementById('txtFrmDate').value;	
	var _dtTo = document.getElementById('txtToDate').value;	
	
	var _arr_from = _dtFrom.split('/');
	var _arr_to = _dtTo.split('/');
	
	var _iFromDay = _arr_from[0];
	var _iFromMonth = _arr_from[1];
	var _iFromYear = _arr_from[2];
	
	var _iToDay = _arr_to[0];
	var _iToMonth = _arr_to[1];
	var _iToYear = _arr_to[2];
	
	dtFromDate = _iFromYear + "-" + _iFromMonth + "-" + _iFromDay;
	dtToDate = _iToYear + "-" + _iToMonth + "-" + _iToDay;
	
	
}



function CreateDivHeader(prmOption){
	
	
	
	switch(prmOption){
		
		case 1:
			strHTMLDetails = "<table border='0' cellspacing='0' cellpadding = '1' width='100%'><thead><tr><th class='header_format_cd'>&nbsp;Costing Date&nbsp;</th><th class='header_format' width='50px'>&nbsp;Style No&nbsp;</th><th class='header_format'>&nbsp;SC No&nbsp;</th><th class='header_format'>&nbsp;Description&nbsp;</th><th class='header_format'>&nbsp;Buyer&nbsp;</th><th class='header_format'>&nbsp;Buyer Division&nbsp;</th><th class='header_format'>&nbsp;Season&nbsp;</th><th class='header_format'>&nbsp;Buying Office&nbsp;</th><th class='header_format_cd'>&nbsp;Costing SMV&nbsp;</th><th class='header_format'>&nbsp;FOB&nbsp;</th><th class='header_format'>&nbsp;Eff.&nbsp;</th><th class='header_format'>&nbsp;Total Qty&nbsp;</th><th class='header_format'>&nbsp;User&nbsp;</th><th class='header_format'>&nbsp;Buyer PO No&nbsp;</th><th class='header_format'>&nbsp;Buyer PO Qty&nbsp;</th><th class='header_format_cd'>&nbsp;Buyer PO Del. Date&nbsp;</th><th class='header_format_cd'>&nbsp;Buyer Hand Over Date&nbsp;</th><th class='header_format'>&nbsp;Tot SMV&nbsp;</th><th class='header_format'>&nbsp;Tot FOB&nbsp;</th><th class='header_format'>&nbsp;Upcharge&nbsp;</th><th class='header_format'>&nbsp;Fabric Cost&nbsp;</th><th class='header_format'>&nbsp;Other Cost&nbsp;</th><th class='header_format_cd'>&nbsp;Finance Cost(Tran. Chg/Clearing Cost/Export Expenses)&nbsp;</th><th class='header_format_cd'>&nbsp;Interest Charge&nbsp;</th><th class='header_format'>&nbsp;Fac. Cost&nbsp;</th><th class='header_format'>&nbsp;Cop. Cost&nbsp;</th><th class='header_format_cd'>&nbsp;CM&nbsp;</th><th class='header_format'>&nbsp;Tot CM&nbsp;</th><th class='header_format'>&nbsp;$/SMV&nbsp;</th><th class='header_format'>&nbsp;GP&nbsp;</th><th class='header_format'>&nbsp;NP&nbsp;</th><th class='header_format'>&nbsp;NP/FOB&nbsp;</th></tr></thead>";
			
			
		break;	
		
	}
	
	//document.getElementById('divListing').innerHTML = strHTMLDetails;
	
}

function ListSchedule(){
	
	document.getElementById('div_blanket').style.width = (screen.width) + 'px';
	document.getElementById('div_blanket').style.height = (screen.height) + 'px';
	document.getElementById('div_blanket').style.display = 'block';

	var iDisplayOption = GetParamOption();
	
	GetExchangeRate();
	
	CreateDivHeader(iDisplayOption);
	CreateLineDetails(iDisplayOption);
	
}

function CreateLineDetails(prmOption){
	
	var url = "delivery_middle.php?RequestType=OrderList";
	var xmlHttp = $.ajax({url:url,async:false});
	
	//var _strHTMLHeader = document.getElementById('divListing').innerHTML;
	
	var _dtCostingDateElement = xmlHttp.responseXML.getElementsByTagName("COSTINGDATE");
	var _strStyleElement = xmlHttp.responseXML.getElementsByTagName("STYLEID");
	var _elSC = xmlHttp.responseXML.getElementsByTagName("SCNO"); 
	var _elDescription = xmlHttp.responseXML.getElementsByTagName("STYLEDESC"); 
	var _elBuyer = xmlHttp.responseXML.getElementsByTagName("BUYER"); 
	var _elBuyerDivision = xmlHttp.responseXML.getElementsByTagName("BUYERDIVISION"); 
	var _elSeason = xmlHttp.responseXML.getElementsByTagName("SEASON"); 
	var _elBuyingOffice = xmlHttp.responseXML.getElementsByTagName("BUYINGOFFICE"); 
	var _elSMV = xmlHttp.responseXML.getElementsByTagName("SMV"); 
	var _elFOB = xmlHttp.responseXML.getElementsByTagName("FOB"); 
	var _elEFF = xmlHttp.responseXML.getElementsByTagName("EFF"); 
	var _elORDERQty = xmlHttp.responseXML.getElementsByTagName("ORDERQTY"); 
	var _elUser = xmlHttp.responseXML.getElementsByTagName("USER"); 
	var _elBuyerPONo = xmlHttp.responseXML.getElementsByTagName("BUYERPONO"); 
	var _elBuyerPOQty = xmlHttp.responseXML.getElementsByTagName("BUYERPOQTY");
	var _elDelDate = xmlHttp.responseXML.getElementsByTagName("DELDATE");
	var _elHandDate = xmlHttp.responseXML.getElementsByTagName("HANDODATE");
	var _elUpcharge = xmlHttp.responseXML.getElementsByTagName("UPCHARGE");
	var _elStyleCode = xmlHttp.responseXML.getElementsByTagName("STYLECODE");
	var _elSubQty = xmlHttp.responseXML.getElementsByTagName("SUBQTY");
	
	//strHTMLDetails += "<div style='overflow-y:scroll; overflow-x:hidden; height:550px; width:1810px; white-space:nowrap;'><table border='1' cellspacing='0' cellpadding = '1'>";
	
	for(i=0; i<_dtCostingDateElement.length; i++){
		
		dblExportExpences = 0;
		dblInterestCharges = 0;
		dblClearingCost = 0;
		
		var _dtCostingDate = _dtCostingDateElement[i].childNodes[0].nodeValue;
		var _strStyleId = _strStyleElement[i].childNodes[0].nodeValue;
		var _strSCNo = _elSC[i].childNodes[0].nodeValue;
		var _strDescription = _elDescription[i].childNodes[0].nodeValue;
		var _strBuyer = _elBuyer[i].childNodes[0].nodeValue;
		var _strBuyerDivision = _elBuyerDivision[i].childNodes[0].nodeValue;
		var _strSeason = _elSeason[i].childNodes[0].nodeValue;
		var _strBuyingOffice = _elBuyingOffice[i].childNodes[0].nodeValue;
		var _dblSMV = _elSMV[i].childNodes[0].nodeValue;
		var _dblFOB = _elFOB[i].childNodes[0].nodeValue;
		var _dblEFF = _elEFF[i].childNodes[0].nodeValue;
		var _intOrderQty = parseInt(_elORDERQty[i].childNodes[0].nodeValue);
		var _strUser = _elUser[i].childNodes[0].nodeValue;
		var _strBuyerPONo = _elBuyerPONo[i].childNodes[0].nodeValue;
		var _intBuyerPOQty = _elBuyerPOQty[i].childNodes[0].nodeValue;
		var _dtDelDate = _elDelDate[i].childNodes[0].nodeValue;
		var _dtHandDate = _elHandDate[i].childNodes[0].nodeValue;
		var _dblUpcharge = _elUpcharge[i].childNodes[0].nodeValue;
		var _lngStyelCode = _elStyleCode[i].childNodes[0].nodeValue;
		var _intSubQty = parseInt(_elSubQty[i].childNodes[0].nodeValue);
		
		// Calculate & get total SMV
		var _dblTOTSMV = CalTotSMV(_intBuyerPOQty, _dblSMV);
		
		//Calculate & get total FOB value
		var _dblTOTFOB = CalTotFOB(_intBuyerPOQty, _dblFOB);
		
		//Calculate & get total upcharge
		var _dblTOTUpcharge = CalTotUpcharge(_intBuyerPOQty, _dblUpcharge);
		
		//Calculate fabric cost
		var _dblTotFabCost = CalFabCost(_lngStyelCode, _intBuyerPOQty, _intOrderQty);
		
		//Calculate Accesories & Packing material cost
		var _dblTotAccPackingCost = CalAccessoriesPackingCost(_lngStyelCode, _intBuyerPOQty);
		
		//Calculate Services & Others Cost
		var _dblTotServOtherCost = CalServiceOthersCost(_lngStyelCode, _intBuyerPOQty);
		
		//Calculate ESC value
		var _dblESCValue = parseFloat(((_dblFOB/100)*0.25)*_intBuyerPOQty);
		
		//Get the total of other Accesories, Packing, Services & Other cost
		var _dbtTotOtherCost =  parseFloat(_dblTotAccPackingCost) + parseFloat(_dblTotServOtherCost) + _dblESCValue;
		
		//Get the sum of finance charge
		var _dblTotalFinanceCharges = parseFloat(dblTransportCharge) + parseFloat(dblExportExpences) + parseFloat(dblClearingCost);
		
		//Calculate labour cost
		var _dblLabourCharges = CalLabourCost(_intOrderQty, _intSubQty, _intBuyerPOQty, _dblEFF, _dblSMV);
		
		var _dblCopCharges = CalCopCost(_intBuyerPOQty, _dblSMV);
		
		var _dblTotDirectCost = parseFloat(_dblTotFabCost + _dbtTotOtherCost +  _dblTotalFinanceCharges + dblInterestCharges + _dblESCValue);
		
		var _dblTotCM         = ((_dblTOTFOB - _dblTotDirectCost) + _dblTOTUpcharge);
		var _dblCMPerPc       = parseFloat(_dblTotCM) / _intBuyerPOQty;
		
		var _dblCMPerSMV  = parseFloat(_dblCMPerPc / _dblSMV);
		
		var _dblLabourPerPc = parseFloat(_dblLabourCharges / _intBuyerPOQty);
		var _dblGP = parseFloat((_dblCMPerPc - _dblLabourPerPc) * _intBuyerPOQty);
		
		var _dblCopCostPerPc = (_dblCopCharges / _intBuyerPOQty);
		
		var _dblNP = parseFloat((_dblCMPerPc - _dblLabourPerPc - _dblCopCostPerPc) * _intBuyerPOQty);
		//var _dblGP = parseFloat((_dblLabourCharges / _intBuyerPOQty));
		
		var _dblNPFOB = (_dblNP/_dblTOTFOB) * 100
		
		
		strHTMLDetails += "<tr height='20px' id="+i+" onmouseover='lineHighlightIn(this)' onmouseout='lineHighlightOut(this)'><td class='line_format'>&nbsp;"+_dtCostingDate+"&nbsp;</td><td class='line_format'>&nbsp;"+_strStyleId+"</td><td class='line_format'>&nbsp;"+_strSCNo+"</td><td class='line_format'>&nbsp;"+_strDescription+"</td><td class='line_format'>&nbsp;"+_strBuyer+"</td><td class='line_format'>"+_strBuyerDivision+"</td><td class='line_format'>"+_strSeason+"</td><td class='line_format'>"+_strBuyingOffice+"</td><td class='line_format' align='right'>"+parseFloat(_dblSMV).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+_dblFOB+"&nbsp;</td><td class='line_format' align='right'>"+_dblEFF+"&nbsp;</td><td class='line_format' align='right'>"+_intOrderQty+"&nbsp;</td><td class='line_format'>"+_strUser+"</td><td class='line_format'>"+_strBuyerPONo+"</td><td class='line_format' align='right'>"+_intBuyerPOQty+"&nbsp;</td><td class='line_format'>&nbsp;"+_dtDelDate+"</td><td class='line_format'>&nbsp;"+_dtHandDate+"</td><td class='line_format' align='right'>"+parseFloat(_dblTOTSMV).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblTOTFOB).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+_dblTOTUpcharge+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblTotFabCost).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dbtTotOtherCost).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblTotalFinanceCharges).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(dblInterestCharges).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblLabourCharges).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblCopCharges).toFixed(2)+"&nbsp;</td><td class='line_format'>&nbsp;&nbsp;"+parseFloat(_dblCMPerPc).toFixed(4)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblTotCM).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblCMPerSMV).toFixed(4)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblGP).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblNP).toFixed(2)+"&nbsp;</td><td class='line_format' align='right'>"+parseFloat(_dblNPFOB).toFixed(2)+"&nbsp;</td></tr>"	
		
	}
	
	document.getElementById('div_blanket').style.display = 'none';


	document.getElementById('divListing').innerHTML += strHTMLDetails + "</table>";
	
	
}

function CalTotSMV(prmDelQty, prmSMV){
	
	var _dblTotSMV = 0;
	
	_dblTotSMV = parseInt(prmDelQty) * parseFloat(prmSMV);
	
	return _dblTotSMV;
	
}

function CalTotFOB(prmDelQty, prmFOB){
	
	var _dblTotFOB = 0;
	
	_dblTotFOB = parseInt(prmDelQty) * parseFloat(prmFOB);
	
	return _dblTotFOB;
	
}

function CalTotUpcharge(prmDelQty, prmUpcharge){
	
	var _dblTotUpcharge = 0;
	
	_dblTotUpcharge = parseInt(prmDelQty) * parseFloat(prmUpcharge);
	
	return _dblTotUpcharge;
	
}

function CalFabCost(prmStyleCode, prmDelQty, prmOrderQty){
	
	var _dblTotalFabricCost = 0;
	dblTransportCharge = 0;
	

	var url = "delivery_middle.php?RequestType=GetFabricCost&StyleCode="+prmStyleCode;
	var xmlHttp = $.ajax({url:url,async:false})
	
	var _elConPc = xmlHttp.responseXML.getElementsByTagName("CONPERPC");
	var _elWastage = xmlHttp.responseXML.getElementsByTagName("WASTAGE");
	var _elUnitPrice = xmlHttp.responseXML.getElementsByTagName("UNITPRICE");  
	var _elOriginType = xmlHttp.responseXML.getElementsByTagName("ORIGINTYPE");  
	
	if(_elConPc.length > 0){
	
		for(loop=0;loop<_elConPc.length;loop++)	{
			
			var _dblConPc = parseFloat(_elConPc[loop].childNodes[0].nodeValue);	
			var _dblWastage = parseFloat(_elWastage[loop].childNodes[0].nodeValue);	
			var _dblUnitPrice = parseFloat(_elUnitPrice[loop].childNodes[0].nodeValue);
			var _intOriginType = parseFloat(_elOriginType[loop].childNodes[0].nodeValue);	
			var _dblReqQty = parseInt(prmDelQty) * _dblConPc;
			var _dblWastageQty = (_dblReqQty / 100) * _dblWastage;
			
			var _dblTotReqQty = _dblReqQty + _dblWastageQty;
			
			//var _dblTotalValue = parseFloat(_dblTotReqQty * _dblUnitPrice);
			//var _dblFabricCostPerPc = parseFloat(_dblTotalValue / prmOrderQty);
			var _dblFabricCost = parseFloat(_dblTotReqQty * _dblUnitPrice).toFixed(2);
			
			_dblTotalFabricCost += parseFloat(_dblFabricCost);
			
			CalculateTransportCharge(_intOriginType, _dblFabricCost);
			CalculateClearingCost(_dblFabricCost, _intOriginType);
			CalculateExportExpenses(_dblFabricCost);
			CalculateInterestCharge(_dblFabricCost)
		}
	}
	
	return(_dblTotalFabricCost);	
}

function CalculateTransportCharge(prmOriginType, prmFabricCost){
	
	var _dblTrCost = 0;
	
	switch(parseInt(prmOriginType)){
		
		case 3:
		case 4:			
			_dblTrCost = (parseFloat(prmFabricCost) / 100) * 1; 			
			break
		default:
			_dblTrCost = 0;
	}	
	
	dblTransportCharge += _dblTrCost;
}

function CalculateExportExpenses(prmItemCost){
	
	var _dblExportExpences = 0;
	
	_dblExportExpences = (parseFloat(prmItemCost) / 100) * 1;
	
	dblExportExpences += _dblExportExpences;
	
}

function CalculateInterestCharge(prmItemCost){
	
	var _dblInterestCharges = 0;
	
	_dblInterestCharges = (parseFloat(prmItemCost) / 100) * 2;	
	
	dblInterestCharges += _dblInterestCharges;
	
}

function CalAccessoriesPackingCost(prmStyleCode, prmDelQty){
	
	var _dblTotalAccPackCost = 0;
	
	var url = "delivery_middle.php?RequestType=GetAccPackCost&StyleCode="+prmStyleCode;
	var xmlHttp = $.ajax({url:url,async:false})
	
	var _elConPc = xmlHttp.responseXML.getElementsByTagName("CONPERPC");
	var _elWastage = xmlHttp.responseXML.getElementsByTagName("WASTAGE");
	var _elUnitPrice = xmlHttp.responseXML.getElementsByTagName("UNITPRICE");  
	var _elOriginType = xmlHttp.responseXML.getElementsByTagName("ORIGINTYPE");  
	
	if(_elConPc.length > 0){
	
		for(loop=0;loop<_elConPc.length;loop++)	{
			
			var _dblConPc = parseFloat(_elConPc[loop].childNodes[0].nodeValue);	
			var _dblWastage = parseFloat(_elWastage[loop].childNodes[0].nodeValue);	
			var _dblUnitPrice = parseFloat(_elUnitPrice[loop].childNodes[0].nodeValue);
			var _intOriginType = parseFloat(_elOriginType[loop].childNodes[0].nodeValue);	
			var _dblReqQty = parseInt(prmDelQty) * _dblConPc;
			var _dblWastageQty = (_dblReqQty / 100) * _dblWastage;
			
			var _dblTotReqQty = _dblReqQty + _dblWastageQty;
			
			var _dblAccPackCost = parseFloat(_dblTotReqQty * _dblUnitPrice).toFixed(2);
			
			_dblTotalAccPackCost += parseFloat(_dblAccPackCost);			
			
			CalculateExportExpenses(_dblAccPackCost);
			CalculateInterestCharge(_dblAccPackCost)
			CalculateClearingCost(_dblAccPackCost, _intOriginType);
		}
	}	
	return(_dblTotalAccPackCost);		
}

function CalServiceOthersCost(prmStyleCode, prmDelQty){
	
	var _dblTotalServiceOtherCost = 0;
	
	var url = "delivery_middle.php?RequestType=GetServiceOthers&StyleCode="+prmStyleCode;
	var xmlHttp = $.ajax({url:url,async:false})
	
	var _elConPc = xmlHttp.responseXML.getElementsByTagName("CONPERPC");
	var _elWastage = xmlHttp.responseXML.getElementsByTagName("WASTAGE");
	var _elUnitPrice = xmlHttp.responseXML.getElementsByTagName("UNITPRICE");  
	var _elOriginType = xmlHttp.responseXML.getElementsByTagName("ORIGINTYPE");  
	
	if(_elConPc.length > 0){
	
		for(loop=0;loop<_elConPc.length;loop++)	{
			
			var _dblConPc = parseFloat(_elConPc[loop].childNodes[0].nodeValue);	
			var _dblWastage = parseFloat(_elWastage[loop].childNodes[0].nodeValue);	
			var _dblUnitPrice = parseFloat(_elUnitPrice[loop].childNodes[0].nodeValue);
			var _intOriginType = parseFloat(_elOriginType[loop].childNodes[0].nodeValue);	
			var _dblReqQty = parseInt(prmDelQty) * _dblConPc;
			var _dblWastageQty = (_dblReqQty / 100) * _dblWastage;
			
			var _dblTotReqQty = _dblReqQty + _dblWastageQty;
			
			var _dblServiceOtherCost = _dblTotReqQty * _dblUnitPrice;
			
			_dblTotalServiceOtherCost += _dblServiceOtherCost;						
			
		}
	}	
	return(_dblTotalServiceOtherCost);		
}

function CalculateClearingCost(prmItemCost, prmOriginType){
	
	var _dblClearingCost = 0;	
	
	switch(parseInt(prmOriginType)){
		
		case 1:
		case 2:			
			_dblClearingCost = (parseFloat(prmItemCost) / 100) * 1;
			
			if(dblLKRValue > _dblClearingCost){
				_dblClearingCost = dblLKRValue;
			}
			 			
			break
		default:
			_dblClearingCost = 0;
	}	
	
	dblClearingCost += _dblClearingCost;
}

function GetExchangeRate(){
	
	var url = "delivery_middle.php?RequestType=ExRate";
	var xmlHttp = $.ajax({url:url,async:false})
	
	var _elExRate = xmlHttp.responseXML.getElementsByTagName("LKRRATE");
	
	for(loop=0;loop<_elExRate.length;loop++)	{
		
		var _dblLKRRate = parseFloat(_elExRate[loop].childNodes[0].nodeValue);
		
	}
	
	dblLKRValue = 10000 / _dblLKRRate;
}

function CalLabourCost(prmOrderQty, prmSubQty, prmDeliveryQty, prmEff, prmSMV){
	
	var _dblLabourCost = 0;
	var _dblEffRateVal = parseFloat(prmEff)/100;
	
	if(prmSubQty > 0){
		
		if(prmSubQty == prmOrderQty){
			_dblLabourCost = 0;
			
		}else{
		
		 	var _iSubQty = 	(parseInt(prmDeliveryQty)/prmOrderQty) * prmSubQty;
			var _iInHouseQty = parseInt(prmDeliveryQty) - _iSubQty;
			
			_dblLabourCost = ((parseFloat(prmSMV)/_dblEffRateVal) * 0.0350) * _iInHouseQty;		
		}
	}else{
		
		_dblLabourCost = ((parseFloat(prmSMV)/_dblEffRateVal) * 0.0350) * prmDeliveryQty;
	}
	
	return _dblLabourCost;	
}

function CalCopCost(prmDeliveryQty, prmSMV){

	var _dblCopCost = 0;
	
	_dblCopCost = (parseFloat(prmDeliveryQty) * parseFloat(prmSMV)) * 0.0234;
	
	return _dblCopCost;
	
}

function lineHighlightIn(prmTr){

	document.getElementById(prmTr.id).style.backgroundColor = '#CCCCFF';	
	
}

function lineHighlightOut(prmTr){

	document.getElementById(prmTr.id).style.backgroundColor = '#FFFFFF';	
	
}

function exportExcel(){
	
	var iDisplayOption = GetParamOption();
	//alert(iDisplayOption);
	GetDateFormat();
	
	var _intProductCategoryCode = document.getElementById('cmbProductCategory').value
	
	switch(iDisplayOption){
	
		case 1:
			window.location = "rptxlsallbuyersfull.php?prmfrom="+dtFromDate+"&prmto="+dtToDate+"&prmpc="+_intProductCategoryCode;
		break;		
		
		case 2:
			window.location = "rptxlsbuyerfull.php?prmfrom="+dtFromDate+"&prmto="+dtToDate+"&prmBuyerCode="+intBuyerCode+"&prmpc="+_intProductCategoryCode;;
		break;
		
		case 3:
			window.location = "rptxlsallbuyerssummary.php?prmfrom="+dtFromDate+"&prmto="+dtToDate;
		break;
		
		case 4:
			window.location = "rptxlslbuyersummary.php?prmfrom="+dtFromDate+"&prmto="+dtToDate+"&prmBuyerCode="+intBuyerCode;		
		break;
		
	}
	
}

