var ShipmentID="";
var emailAddress=new Array();

function abc_SCNo()
{
		var url				='Shipmentforcastdb.php?REQUEST=load_SC';
		var pub_xml_http_obj2	=$.ajax({url:url,async:false});
		var pub_in_arr			=pub_xml_http_obj2.responseText.split("|");
		
		$( "#txtSCNo" ).autocomplete({
			source: pub_in_arr
		});		
		
}

function abc_PONo(){
	
		var url				='Shipmentforcastdb.php?REQUEST=load_PO&SCNo='+ document.getElementById('txtSCNo').value;
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_in_arr			=pub_xml_http_obj.responseText.split("|");
		pub_in_arr.sort();
		var selectbox = document.getElementById("txtBuyerPoNo");
		
		for (i=selectbox.options.length-1;i>=0;i--) {
		  selectbox.remove(i);
		}
		
		for(var x=0; x<pub_in_arr.length;x++){
			var	value = pub_in_arr[x];
			var opt = document.createElement("option");
			document.getElementById("txtBuyerPoNo").options.add(opt);
			opt.text = value;
			opt.value = value;
		}
		
}



function changeSCCombo(evt)
{
	
	if (evt.keyCode == 13)
	{
		abc_PONo();
		var SCNo = document.getElementById('txtSCNo').value;
		var url     = "Shipmentforcastdb.php?REQUEST=loadData&SCNo="+SCNo;
		var htmlobj = $.ajax({url:url,async:false});
		var strStyle               = htmlobj.responseXML.getElementsByTagName("strStyle");
		var strBuyerPONO           = htmlobj.responseXML.getElementsByTagName("strBuyerPONO");
		var dtDateofDelivery       = htmlobj.responseXML.getElementsByTagName("dtDateofDelivery");
		var intQty      		   = htmlobj.responseXML.getElementsByTagName("intQty");
		var strCountry			   = htmlobj.responseXML.getElementsByTagName("strCountry");



			document.getElementById('txtStyleNO').value = strStyle[0].childNodes[0].nodeValue;
			document.getElementById('txtBuyerPoNo').value = strBuyerPONO[0].childNodes[0].nodeValue;
			document.getElementById('txtDelivery').value = dtDateofDelivery[0].childNodes[0].nodeValue;
			document.getElementById('txtQty').value = intQty[0].childNodes[0].nodeValue;
			document.getElementById('txtCountry').value = strCountry[0].childNodes[0].nodeValue;
			//document.getElementById('txtUnitPrice').value = dblUnitPrice[0].childNodes[0].nodeValue;
	
	}
}

function changePO()
{
	
	
		var PONo = document.getElementById('txtBuyerPoNo').value;
		var url     = "Shipmentforcastdb.php?REQUEST=loadPOData&PONo="+PONo;
		var htmlobj = $.ajax({url:url,async:false});
		var strStyle               = htmlobj.responseXML.getElementsByTagName("strStyle");
		var strBuyerPONO           = htmlobj.responseXML.getElementsByTagName("strBuyerPONO");
		var dtDateofDelivery       = htmlobj.responseXML.getElementsByTagName("dtDateofDelivery");
		var intQty      		   = htmlobj.responseXML.getElementsByTagName("intQty");
		var strCountry			   = htmlobj.responseXML.getElementsByTagName("strCountry");



			document.getElementById('txtStyleNO').value = strStyle[0].childNodes[0].nodeValue;
			document.getElementById('txtBuyerPoNo').value = strBuyerPONO[0].childNodes[0].nodeValue;
			document.getElementById('txtDelivery').value = dtDateofDelivery[0].childNodes[0].nodeValue;
			document.getElementById('txtQty').value = intQty[0].childNodes[0].nodeValue;
			document.getElementById('txtCountry').value = strCountry[0].childNodes[0].nodeValue;
			//document.getElementById('txtUnitPrice').value = dblUnitPrice[0].childNodes[0].nodeValue;
	
	
}

function addDecathlon(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "DECATHLON";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var IMANCode 	= document.getElementById('txtIMANCode').value;
var Criterion 	= document.getElementById('txtCriterion').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;

var Decathlon   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Decathlon   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Decathlon   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Decathlon   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&IMANCode="+IMANCode;
	Decathlon   += "&Criterion="+Criterion+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Decathlon,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}


function addMandS(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "M AND S";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtReference').value;
var PackType	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var MANDS   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	MANDS   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	MANDS   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	MANDS   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	MANDS   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS+"&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&PackType="+PackType+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:MANDS,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addTesco(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "TESCO";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtReference').value;
var PackType	= document.getElementById('txtPackType').value;
var Season		= document.getElementById('txtSeason').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
var RetekNo		= document.getElementById('txtRetekNo').value;
	
var Tesco   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Tesco   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Tesco   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Tesco   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Tesco   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Tesco	+= "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&PackType="+PackType+"&Season="+Season+"&FactoryDate="+FactoryDate+"&UserID="+UserID+"&RetekNo="+RetekNo;

var htmlobj = $.ajax({url:Tesco,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addNext(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "NEXT";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtNSLDNO').value;
var ItemNo		= document.getElementById('txtItemNo').value;
var ContractNo	= document.getElementById('txtContractNo').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var Next   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Next   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Next   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Next   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Next   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Next   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&ItemNo="+ItemNo+"&ContractNo="+ContractNo+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Next,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addSainsbury(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "SAINSBURY";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo  	= document.getElementById('txtTuPoNo').value;
var TuStyle 	= document.getElementById('txtTuStyle').value;
var PackType 	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var Sainsbury   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Sainsbury   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Sainsbury   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Sainsbury   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Sainsbury   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Sainsbury   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Sainsbury,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addFasionLab(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "FASHION LAB";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo  	= document.getElementById('txtTuPoNo').value;
var TuStyle 	= document.getElementById('txtTuStyle').value;
var PackType 	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var FasionLab   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	FasionLab   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	FasionLab   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	FasionLab   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	FasionLab   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	FasionLab   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:FasionLab,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addOriginaMarines(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "ORIGINAL MARINES";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo  	= document.getElementById('txtTuPoNo').value;
var TuStyle 	= document.getElementById('txtTuStyle').value;
var PackType 	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var OriginaMarines   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	OriginaMarines   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	OriginaMarines   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	OriginaMarines   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	OriginaMarines   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	OriginaMarines   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:OriginaMarines,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addBlues(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "BLUES";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo  	= document.getElementById('txtTuPoNo').value;
var TuStyle 	= document.getElementById('txtTuStyle').value;
var PackType 	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var Blues   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Blues   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Blues   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Blues   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Blues   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Blues   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Blues,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addFeilding(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "FEILDING";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo  	= document.getElementById('txtTuPoNo').value;
var TuStyle 	= document.getElementById('txtTuStyle').value;
var PackType 	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var Feilding   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Feilding   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Feilding   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Feilding   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Feilding   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Feilding   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Feilding,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addNike(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "NIKE";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC    = document.getElementById('txtNETWTPPC').value;
var GRSWTPPc    = document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtNSLDNO').value;
var ItemNo		= document.getElementById('txtItemNo').value;
var ContractNo	= document.getElementById('txtContractNo').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var Nike   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Nike   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Nike   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Nike   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Nike   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Nike   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&ItemNo="+ItemNo+"&ContractNo="+ContractNo+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Nike,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addLevis(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "LEVIS";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;

var Levis   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Levis   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Levis   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Levis   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Levis   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Levis,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function addAsda(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "ASDA";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var UserID		= document.getElementById('getUserID').innerHTML;
	
var Asda   = "Shipmentforcastdb.php?REQUEST=adddata&SCNO="+SCNO+"&Buyer="+Buyer;
	Asda   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Asda   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Asda   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Asda   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS+"&FactoryDate="+FactoryDate+"&UserID="+UserID;

var htmlobj = $.ajax({url:Asda,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
}

function SearchBuyers(){
	if(document.getElementById('cboBuyer').value == "Select One" && document.getElementById('cboPoNo').value == "Select One" && document.getElementById('txtdatefrom').value == "" && document.getElementById('txtdateto').value == ""){
		jQuery.noticeAdd({
				text: 'Please select the buyer',
				stay: false
			});
	}else{
		deleterows("tblDescription");
		var Buyer = document.getElementById('cboBuyer').value;
		var PoNo = document.getElementById('cboPoNo').value;
		var datefrom = document.getElementById('txtdatefrom').value;
		var dateto = document.getElementById('txtdateto').value;
		var url   = "Shipmentforcastdb.php?REQUEST=getdata&Buyer="+Buyer+'&PoNo='+PoNo+'&datefrom='+datefrom+'&dateto='+dateto;
		var xmlhttp_obj	  = $.ajax({url:url,async:false});

		var XMLSCNo                  = xmlhttp_obj.responseXML.getElementsByTagName("SCNo");
		var XMLBuyer                 = xmlhttp_obj.responseXML.getElementsByTagName("Buyer");
		var XMLPoNo                  = xmlhttp_obj.responseXML.getElementsByTagName("PoNo");
		var XMLCtnMes                = xmlhttp_obj.responseXML.getElementsByTagName("CtnMes");
		var XMLNet                   = xmlhttp_obj.responseXML.getElementsByTagName("Net");
		var XMLGrs                   = xmlhttp_obj.responseXML.getElementsByTagName("Grs");
		var XMLQty                   = xmlhttp_obj.responseXML.getElementsByTagName("Qty");
		var XMLDesc                  = xmlhttp_obj.responseXML.getElementsByTagName("Desc");
		var XMLFabric                = xmlhttp_obj.responseXML.getElementsByTagName("Fabric");
        var XMLStyleNo               = xmlhttp_obj.responseXML.getElementsByTagName("StyleNo");
		var XMLCountry               = xmlhttp_obj.responseXML.getElementsByTagName("Country");
		var XMLCBM      	         = xmlhttp_obj.responseXML.getElementsByTagName("CBM");
		var XMLUnitPrice	   	     = xmlhttp_obj.responseXML.getElementsByTagName("UnitPrice");
		var XMLFactory               = xmlhttp_obj.responseXML.getElementsByTagName("Factory");
		var XMLGSP                   = xmlhttp_obj.responseXML.getElementsByTagName("GSP");
		var XMLUpLdDate              = xmlhttp_obj.responseXML.getElementsByTagName("UpLdDate");
		var XMLColor                 = xmlhttp_obj.responseXML.getElementsByTagName("Color");
		var XMLRetecNo               = xmlhttp_obj.responseXML.getElementsByTagName("RetecNo");
		var XMLPackType              = xmlhttp_obj.responseXML.getElementsByTagName("PackType");
		var XMLUnite	             = xmlhttp_obj.responseXML.getElementsByTagName("Unite");
		var XMLshipmentID            = xmlhttp_obj.responseXML.getElementsByTagName("shipmentID");
		var XMLSeason                = xmlhttp_obj.responseXML.getElementsByTagName("Season");
		var XMLStatus                = xmlhttp_obj.responseXML.getElementsByTagName("Status");
		var XMLPossibility           = xmlhttp_obj.responseXML.getElementsByTagName("Possibility");
		var XMLPossibleQty           = xmlhttp_obj.responseXML.getElementsByTagName("PossibleQty");
		var XMLPossibleDate          = xmlhttp_obj.responseXML.getElementsByTagName("PossibleDate");
		var XMLFactoryDate           = xmlhttp_obj.responseXML.getElementsByTagName("FactoryDate");
		var XMLUserName				 = xmlhttp_obj.responseXML.getElementsByTagName("UserName");

		var detailGrid=document.getElementById("tblDescription");
		
		for(var loop=0;loop<XMLSCNo.length;loop++)
		{	
		//alert(Color[loop].childNodes[0].nodeValue);
		
		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		
/*		row.onmouseover=change;
		row.onmouseout=defaultcolor;
		row.onclick=selectcolor;*/

		var Style = XMLStyleNo[loop].childNodes[0].nodeValue;
		var Desc = XMLDesc[loop].childNodes[0].nodeValue;
		var Fabric = XMLFabric[loop].childNodes[0].nodeValue;
		
		row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLSCNo[loop].childNodes[0].nodeValue + "</div>";	
		
		var cellDelete = row.insertCell(1); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLBuyer[loop].childNodes[0].nodeValue + "</div>";
					
		
		var cellDelete = row.insertCell(2); 
				cellDelete.className ="normalfntMid";
				if(Style[11]){
					cellDelete.innerHTML = "<div class=\"setdata\" title=\" " + Style + " \">" + Style[0] + Style[1]+ Style[2]+ Style[3]+ Style[4]+ Style[5]+ Style[6]+ Style[7]+ Style[8]+ Style[9]+ Style[10] + "..." + "</div>";
					}else{
						cellDelete.innerHTML = "<div class=\"setdata\" title=\" " + Style + " \">" + Style + "</div>";
					}
				
		var cellDelete = row.insertCell(3); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLPoNo[loop].childNodes[0].nodeValue + "</div>";

		var cellDelete = row.insertCell(4); 
				cellDelete.className ="normalfntMid";
				if(Desc[10]){
					cellDelete.innerHTML = "<div class=\"setdata\" title=\" " + Desc + " \">" + Desc[0] + Desc[1] + Desc[2] + Desc[3] + Desc[4] + Desc[5] + Desc[6] + Desc[7] + Desc[8] + Desc[9] + Desc[10] + "..." + "</div>";
					}else{
						cellDelete.innerHTML = "<div class=\"setdata\" title=\" " + Desc + " \">" + Desc + "</div>";
					}
					
		var cellDelete = row.insertCell(5); 
				cellDelete.className ="normalfntMid";
				if(XMLPossibility[loop].childNodes[0].nodeValue == "Y"){
					cellDelete.innerHTML = "<div class=\"getsetdata\" ><input type=\"checkbox\" class=\"txtbox\" id=\"chkapproval"+[loop]+"\" checked=\"checked\" /></div>";
				}else{
					cellDelete.innerHTML = "<div class=\"getsetdata\" ><input type=\"checkbox\" class=\"txtbox\" id=\"chkapproval"+[loop]+"\" /></div>";
					}
		var cellDelete = row.insertCell(6); 
				cellDelete.className ="normalfntMid";
				if(XMLPossibleQty[loop].childNodes[0].nodeValue == "" || XMLPossibleQty[loop].childNodes[0].nodeValue == "0"){
					cellDelete.innerHTML = "<div class=\"getsetgetdata\" ><input name=\"txtPossibleQty\" type=\"text\" class=\"txtbox\" id=\"txtPossibleQty"+[loop]+"\" style=\"width:110px; height:23px; text-align:center;\" value=\""+ XMLQty[loop].childNodes[0].nodeValue +"\" /></div>";
					}else{
				cellDelete.innerHTML = "<div class=\"getsetgetdata\" ><input name=\"txtPossibleQty\" type=\"text\" class=\"txtbox\" id=\"txtPossibleQty"+[loop]+"\" style=\"width:110px; height:23px; text-align:center;\" value=\""+ XMLPossibleQty[loop].childNodes[0].nodeValue +"\" /></div>";
					}
		var cellDelete = row.insertCell(7); 
				cellDelete.className ="normalfntMid";
				if(XMLPossibleDate[loop].childNodes[0].nodeValue == "" || XMLPossibleDate[loop].childNodes[0].nodeValue == "00/00/0000"){
					cellDelete.innerHTML = "<div class=\"getsetgetdata\" ><input name=\"txtPossibledate\" type=\"text\" class=\"txtbox\" id=\"txtPossibledate"+[loop]+"\" style=\"width:118px; height:23px; text-align:center;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\" value=\""+ XMLFactoryDate[loop].childNodes[0].nodeValue +"\" onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\"\" /></div>";
				
					}else{
				cellDelete.innerHTML = "<div class=\"getsetgetdata\" ><input name=\"txtPossibledate\" type=\"text\" class=\"txtbox\" id=\"txtPossibledate"+[loop]+"\" style=\"width:118px; height:23px; text-align:center;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\" value=\""+ XMLPossibleDate[loop].childNodes[0].nodeValue +"\" onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\"\" /></div>";
					}
		var cellDelete = row.insertCell(8); 
				cellDelete.className ="normalfntMid";
				if(Fabric[10]){
					cellDelete.innerHTML = "<div class=\"setdata\" title=\" " + Fabric + " \">" + Fabric[0] + Fabric[1]+ Fabric[2]+ Fabric[3]+ Fabric[4]+ Fabric[5]+ Fabric[6]+ Fabric[7]+ Fabric[8]+ Fabric[9]+ Fabric[10] + "..." + "</div>";
				}else{
					cellDelete.innerHTML = "<div class=\"setdata\" title=\" " + Fabric + " \">" + Fabric + "</div>";
					}
		var cellDelete = row.insertCell(9); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLColor[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(10); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLSeason[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(11); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLUnitPrice[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(12); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLFactory[loop].childNodes[0].nodeValue +  "</div>";
				
		var cellDelete = row.insertCell(13); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLCtnMes[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(14); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLQty[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(15); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLNet[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(16); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLGrs[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";
				if(XMLGSP[loop].childNodes[0].nodeValue == "Y"){
					cellDelete.innerHTML = "<div class=\"getdata\" >" + "YES" + "</div>";
					}else{
						cellDelete.innerHTML = "<div class=\"getdata\" >" + "NO" + "</div>";
					}
				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLRetecNo[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata mouse\" >" + XMLUnite[loop].childNodes[0].nodeValue + "</div>";
				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";
				cellDelete.innerHTML = "<div class=\"getdata mouse\" >" + XMLshipmentID[loop].childNodes[0].nodeValue + "</div>";
		
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";
				if(XMLStatus[loop].childNodes[0].nodeValue == "0"){
					cellDelete.innerHTML = "<div class=\"getdata\" >" + "Not Transfer" + "</div>";
				}else{
					cellDelete.innerHTML = "<div class=\"getdata\" >" + "Transfered" + "</div>";
					}
		var cellDelete = row.insertCell(22); 
				cellDelete.className ="normalfntMid";
				
					cellDelete.innerHTML = "<div class=\"getdata\" >" + XMLUserName[loop].childNodes[0].nodeValue + "</div>";
				
				
		}
	//alert (item);
	}
		
}
	
function buyeredit(value, x){
	//alert(value);
	var buyer = document.getElementById('cboBuyer').value;
	if(buyer == "Select One" ){
		jQuery.noticeAdd({
				text: 'Please select the buyer',
				stay: false
			});
		}
	if(buyer == "M AND S"){
		MANDSadd(value, x);
		}
	if(buyer == "NEXT"){
		Nextadd(value, x);
		}
	if(buyer == "TESCO"){
		Tescoadd(value, x);
		}
	if(buyer == "DECATHLON"){
		Decathlonadd(value, x);
		}
	if(buyer == "ASDA"){
		Asdaadd(value, x);
		}
	if(buyer == "FASHION LAB"){
		FasionLabadd(value, x);
		}
	if(buyer == "LEVIS"){
		Levisadd(value, x);
		}
	if(buyer == "SAINSBURY"){
		Sainsburyadd(value, x);
		}
	if(buyer == "FEILDING"){
		Feildingadd(value, x);
		}
	if(buyer == "ORIGINAL MARINES"){
		OriginaMarinesadd(value, x);
		}
	if(buyer == "NIKE"){
		Nikeadd(value, x);
		}
	if(buyer == "BLUES"){
		Bluesadd(value, x);
		}
	}
	
function deleterows(tableName)
	{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}			
}


function getDecathlondata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtIMANCode').value = htmlobj.responseXML.getElementsByTagName("strIMAN_Code")[0].childNodes[0].nodeValue;
document.getElementById('txtCriterion').value = htmlobj.responseXML.getElementsByTagName("strCriterion_No")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
	
}
	
function editDecathlon(){
	
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "DECATHLON";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var IMANCode 	= document.getElementById('txtIMANCode').value;
var Criterion 	= document.getElementById('txtCriterion').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Decathlon   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Decathlon   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Decathlon   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Decathlon   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&IMANCode="+IMANCode;
	Decathlon   += "&Criterion="+Criterion+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Decathlon,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
function getMANDSdata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtReference').value = htmlobj.responseXML.getElementsByTagName("strOther_Ref")[0].childNodes[0].nodeValue;
document.getElementById('txtPackType').value = htmlobj.responseXML.getElementsByTagName("strPackType")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
	
}

function editMANDS(){
	
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "M AND S";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtReference').value;
var packType	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var MANDS   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	MANDS   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	MANDS   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	MANDS   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	MANDS   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	MANDS   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&packType="+packType+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:MANDS,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
function getTescodata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtReference').value = htmlobj.responseXML.getElementsByTagName("strOther_Ref")[0].childNodes[0].nodeValue;
document.getElementById('txtPackType').value = htmlobj.responseXML.getElementsByTagName("strPackType")[0].childNodes[0].nodeValue;
document.getElementById('txtSeason').value = htmlobj.responseXML.getElementsByTagName("strSeason")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editTesco(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "TESCO";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtReference').value;
var packType	= document.getElementById('txtPackType').value;
var Season		= document.getElementById('txtSeason').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
var RetekNo		= document.getElementById('txtRetekNo').value;
	
var Tesco   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Tesco   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Tesco   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Tesco   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Tesco   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Tesco   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&packType="+packType+"&Season="+Season+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate+"&RetekNo="+RetekNo;

var htmlobj = $.ajax({url:Tesco,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getNextdata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtNSLDNO').value = htmlobj.responseXML.getElementsByTagName("strOther_Ref")[0].childNodes[0].nodeValue;
document.getElementById('txtItemNo').value = htmlobj.responseXML.getElementsByTagName("strItemNo")[0].childNodes[0].nodeValue;
document.getElementById('txtContractNo').value = htmlobj.responseXML.getElementsByTagName("strContractva")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editNext(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "NEXT";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtNSLDNO').value;
var ItemNo		= document.getElementById('txtItemNo').value;
var ContractNo	= document.getElementById('txtContractNo').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Next   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Next   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Next   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Next   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Next   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Next   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&ItemNo="+ItemNo+"&ContractNo="+ContractNo+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Next,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getSainsburydata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtColor').value = htmlobj.responseXML.getElementsByTagName("strItem_Color")[0].childNodes[0].nodeValue;
document.getElementById('txtTuPoNo').value = htmlobj.responseXML.getElementsByTagName("strTu_PoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtTuStyle').value = htmlobj.responseXML.getElementsByTagName("strTu_Style")[0].childNodes[0].nodeValue;
document.getElementById('txtPackType').value = htmlobj.responseXML.getElementsByTagName("strPackType")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editSainsbury(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "SAINSBURY";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo		= document.getElementById('txtTuPoNo').value;
var TuStyle		= document.getElementById('txtTuStyle').value;
var PackType	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Sainsbury   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Sainsbury   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Sainsbury   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Sainsbury   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Sainsbury   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Sainsbury   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Sainsbury,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getFasionLabdata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtColor').value = htmlobj.responseXML.getElementsByTagName("strItem_Color")[0].childNodes[0].nodeValue;
document.getElementById('txtTuPoNo').value = htmlobj.responseXML.getElementsByTagName("strTu_PoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtTuStyle').value = htmlobj.responseXML.getElementsByTagName("strTu_Style")[0].childNodes[0].nodeValue;
document.getElementById('txtPackType').value = htmlobj.responseXML.getElementsByTagName("strPackType")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editFasionLab(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "FASHION LAB";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo		= document.getElementById('txtTuPoNo').value;
var TuStyle		= document.getElementById('txtTuStyle').value;
var PackType	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var FasionLab   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	FasionLab   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	FasionLab   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	FasionLab   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	FasionLab   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	FasionLab   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:FasionLab,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getOriginaMarinesdata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtColor').value = htmlobj.responseXML.getElementsByTagName("strItem_Color")[0].childNodes[0].nodeValue;
document.getElementById('txtTuPoNo').value = htmlobj.responseXML.getElementsByTagName("strTu_PoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtTuStyle').value = htmlobj.responseXML.getElementsByTagName("strTu_Style")[0].childNodes[0].nodeValue;
document.getElementById('txtPackType').value = htmlobj.responseXML.getElementsByTagName("strPackType")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editOriginaMarines(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "ORIGINAL MARINES";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo		= document.getElementById('txtTuPoNo').value;
var TuStyle		= document.getElementById('txtTuStyle').value;
var PackType	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var OriginaMarines   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	OriginaMarines   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	OriginaMarines   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	OriginaMarines   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	OriginaMarines   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	OriginaMarines   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:OriginaMarines,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getBluesdata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtColor').value = htmlobj.responseXML.getElementsByTagName("strItem_Color")[0].childNodes[0].nodeValue;
document.getElementById('txtTuPoNo').value = htmlobj.responseXML.getElementsByTagName("strTu_PoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtTuStyle').value = htmlobj.responseXML.getElementsByTagName("strTu_Style")[0].childNodes[0].nodeValue;
document.getElementById('txtPackType').value = htmlobj.responseXML.getElementsByTagName("strPackType")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editBlues(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "BLUES";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo		= document.getElementById('txtTuPoNo').value;
var TuStyle		= document.getElementById('txtTuStyle').value;
var PackType	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Blues   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Blues   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Blues   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Blues   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Blues   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Blues   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Blues,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getFeildingdata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtColor').value = htmlobj.responseXML.getElementsByTagName("strItem_Color")[0].childNodes[0].nodeValue;
document.getElementById('txtTuPoNo').value = htmlobj.responseXML.getElementsByTagName("strTu_PoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtTuStyle').value = htmlobj.responseXML.getElementsByTagName("strTu_Style")[0].childNodes[0].nodeValue;
document.getElementById('txtPackType').value = htmlobj.responseXML.getElementsByTagName("strPackType")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editFeilding(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "FEILDING";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Color		= document.getElementById('txtColor').value;
var TuPoNo		= document.getElementById('txtTuPoNo').value;
var TuStyle		= document.getElementById('txtTuStyle').value;
var PackType	= document.getElementById('txtPackType').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Feilding   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Feilding   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Feilding   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Feilding   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Feilding   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Feilding   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Color="+Color+"&TuPoNo="+TuPoNo+"&TuStyle="+TuStyle+"&PackType="+PackType+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Feilding,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getNikedata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtNETWTPPC').value = htmlobj.responseXML.getElementsByTagName("strNetWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtGRSWTPPc').value = htmlobj.responseXML.getElementsByTagName("strGrsWT_Ppcs")[0].childNodes[0].nodeValue;
document.getElementById('txtNSLDNO').value = htmlobj.responseXML.getElementsByTagName("strOther_Ref")[0].childNodes[0].nodeValue;
document.getElementById('txtItemNo').value = htmlobj.responseXML.getElementsByTagName("strItemNo")[0].childNodes[0].nodeValue;
document.getElementById('txtContractNo').value = htmlobj.responseXML.getElementsByTagName("strContractva")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editNike(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "NIKE";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var NETWTPPC	= document.getElementById('txtNETWTPPC').value;
var GRSWTPPc	= document.getElementById('txtGRSWTPPc').value;
var Reference	= document.getElementById('txtNSLDNO').value;
var ItemNo		= document.getElementById('txtItemNo').value;
var ContractNo	= document.getElementById('txtContractNo').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Nike   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Nike   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Nike   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Nike   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Nike   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS;
	Nike   += "&NETWTPPC="+NETWTPPC+"&GRSWTPPc="+GRSWTPPc+"&Reference="+Reference+"&ItemNo="+ItemNo+"&ContractNo="+ContractNo+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Nike,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
	function getLevisdata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editLevis(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "LEVIS";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Levis   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Levis   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Levis   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Levis   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Levis   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Levis,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
		function getAsdadata(value){
	var url     = "Shipmentforcastdb.php?REQUEST=editdata&value="+value;
	var htmlobj = $.ajax({url:url,async:false});
	var SCNO 		= document.getElementById('txtSCNo').value;

document.getElementById('txtSCNo').value = htmlobj.responseXML.getElementsByTagName("strSC_No")[0].childNodes[0].nodeValue;	
abc_PONo();
document.getElementById('txtDelivery').value = htmlobj.responseXML.getElementsByTagName("strDrop_No")[0].childNodes[0].nodeValue;
document.getElementById('txtBuyerPoNo').value = htmlobj.responseXML.getElementsByTagName("strPoNo")[0].childNodes[0].nodeValue;
document.getElementById('txtStyleNO').value = htmlobj.responseXML.getElementsByTagName("strStyleNo")[0].childNodes[0].nodeValue;
document.getElementById('txtDeptNo').value = htmlobj.responseXML.getElementsByTagName("strDeptNo")[0].childNodes[0].nodeValue;
document.getElementById('txtGOH').value = htmlobj.responseXML.getElementsByTagName("strGOH_No")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNS').value = htmlobj.responseXML.getElementsByTagName("intNOF_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtQty').value = htmlobj.responseXML.getElementsByTagName("strQty")[0].childNodes[0].nodeValue;
document.getElementById('txtNetWeight').value = htmlobj.responseXML.getElementsByTagName("intNetWt")[0].childNodes[0].nodeValue;
document.getElementById('txtGrossWeight').value = htmlobj.responseXML.getElementsByTagName("intGrsWt")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNL').value = htmlobj.responseXML.getElementsByTagName("intCtnsL")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNW').value = htmlobj.responseXML.getElementsByTagName("intCtnsW")[0].childNodes[0].nodeValue;
document.getElementById('txtCTNH').value = htmlobj.responseXML.getElementsByTagName("intCtnsH")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value = htmlobj.responseXML.getElementsByTagName("intUnitPrice")[0].childNodes[0].nodeValue;
if(htmlobj.responseXML.getElementsByTagName("intGSP_status")[0].childNodes[0].nodeValue == "Y"){
	document.getElementById('GSPApproval').checked=true;
	}else{
		document.getElementById('GSPApproval').checked=false;
		} 
document.getElementById('txtDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
document.getElementById('txtFabric').value = htmlobj.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue;
document.getElementById('txtCountry').value = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;
document.getElementById('txtFactory').value = htmlobj.responseXML.getElementsByTagName("strFactory")[0].childNodes[0].nodeValue;
document.getElementById('txtShipMode').value = htmlobj.responseXML.getElementsByTagName("strShipMode")[0].childNodes[0].nodeValue;
document.getElementById('txtEXFTY').value = htmlobj.responseXML.getElementsByTagName("dtmEX_FTY_Date")[0].childNodes[0].nodeValue;
document.getElementById('txtPordNo').value = htmlobj.responseXML.getElementsByTagName("strOrms_Pord_No")[0].childNodes[0].nodeValue;
document.getElementById('txtPODescription').value = htmlobj.responseXML.getElementsByTagName("strPo_des")[0].childNodes[0].nodeValue;
document.getElementById('txtKnitWoven').value = htmlobj.responseXML.getElementsByTagName("strknit_woven")[0].childNodes[0].nodeValue;
document.getElementById('txtFCLLCL').value = htmlobj.responseXML.getElementsByTagName("strFcl_Lcl")[0].childNodes[0].nodeValue;
document.getElementById('txtUnitPCSSETS').value = htmlobj.responseXML.getElementsByTagName("strUnite")[0].childNodes[0].nodeValue;
document.getElementById('txtDestination').value = htmlobj.responseXML.getElementsByTagName("strDestination")[0].childNodes[0].nodeValue;
document.getElementById('txtCBM').value = htmlobj.responseXML.getElementsByTagName("dblCBM")[0].childNodes[0].nodeValue;
document.getElementById('txtPCSPerCTNS').value = htmlobj.responseXML.getElementsByTagName("strPcs_Per_Ctns")[0].childNodes[0].nodeValue;
document.getElementById('txtFactoryDate').value = htmlobj.responseXML.getElementsByTagName("FactoryDate")[0].childNodes[0].nodeValue;
ShipmentID = htmlobj.responseXML.getElementsByTagName("intID")[0].childNodes[0].nodeValue;
}

function editAsda(){
var SCNO 		= document.getElementById('txtSCNo').value;
var Buyer 		= "ASDA";
var Delivery 	= document.getElementById('txtDelivery').value;
var PoNo 		= document.getElementById('txtBuyerPoNo').value;
var StyleNo		= document.getElementById('txtStyleNO').value;
var DeptNo 		= document.getElementById('txtDeptNo').value;
var GOH 		= document.getElementById('txtGOH').value;
var CTNS 		= document.getElementById('txtCTNS').value;
var QTY 		= document.getElementById('txtQty').value;
var NetWeight 	= document.getElementById('txtNetWeight').value;
var GrossWeight = document.getElementById('txtGrossWeight').value;
var CTNL 		= document.getElementById('txtCTNL').value;
var CTNW 		= document.getElementById('txtCTNW').value;
var CTNH		= document.getElementById('txtCTNH').value;
var UnitPrice 	= document.getElementById('txtUnitPrice').value;
if(document.getElementById('GSPApproval').checked == true){
	var GSPApproval = "Y";
	}else{
		var GSPApproval = "N";
		} 
var Description = document.getElementById('txtDescription').value;
var Fabric 		= document.getElementById('txtFabric').value;
var Country	 	= document.getElementById('txtCountry').value;
var Factory 	= document.getElementById('txtFactory').value;
var ShipMode 	= document.getElementById('txtShipMode').value;
var EXFTY 		= document.getElementById('txtEXFTY').value;
var PordNo 		= document.getElementById('txtPordNo').value;
var PODesc	 	= document.getElementById('txtPODescription').value;
var KnitWoven 	= document.getElementById('txtKnitWoven').value;
var FCLLCL 		= document.getElementById('txtFCLLCL').value;
var UnitPCSSETS = document.getElementById('txtUnitPCSSETS').value;
var Destination = document.getElementById('txtDestination').value;
var CBM 		= document.getElementById('txtCBM').value;
var PCSPerCTNS	= document.getElementById('txtPCSPerCTNS').value;
var FactoryDate = document.getElementById('txtFactoryDate').value;
	
var Asda   = "Shipmentforcastdb.php?REQUEST=editforcast&SCNO="+SCNO+"&Buyer="+Buyer+"&Delivery="+Delivery;
	Asda   += "&PoNo="+PoNo+"&StyleNo="+StyleNo+"&DeptNo="+DeptNo+"&GOH="+GOH+"&CTNS="+CTNS+"&QTY="+QTY+"&NetWeight="+NetWeight;
	Asda   += "&GrossWeight="+GrossWeight+"&CTNL="+CTNL+"&CTNW="+CTNW+"&CTNH="+CTNH+"&UnitPrice="+UnitPrice+"&GSPApproval="+GSPApproval+"&Description="+Description;
	Asda   += "&Fabric="+Fabric+"&Country="+Country+"&Factory="+Factory+"&ShipMode="+ShipMode+"&EXFTY="+EXFTY+"&PordNo="+PordNo+"&PODesc="+PODesc;
	Asda   += "&KnitWoven="+KnitWoven+"&FCLLCL="+FCLLCL+"&UnitPCSSETS="+UnitPCSSETS+"&Destination="+Destination+"&CBM="+CBM+"&PCSPerCTNS="+PCSPerCTNS+"&ShipmentID="+ShipmentID+"&FactoryDate="+FactoryDate;

var htmlobj = $.ajax({url:Asda,async:false});
jQuery.noticeAdd({
				text: htmlobj.responseText,
				stay: false,
				type: 'success'
			});
	}
	
function approvaldetails()
{
	
	var tbl 			= document.getElementById('tblDescription');
	var count="0";
	var getBuyer;
	var ShipmentArray=new Array();
	
	for (var loop=1;loop<tbl.rows.length;loop++)
		{
				
			var row= tbl.rows[loop];
			if(document.getElementById("chkapproval"+[loop-1]).checked==true){
			
				
				var SCNO			=row.cells[0].childNodes[0].innerHTML;
				var Buyer			=row.cells[1].childNodes[0].innerHTML;
				var BuyerPONo		=row.cells[3].childNodes[0].innerHTML;
				var ShipmentID		=row.cells[20].childNodes[0].innerHTML;
				var PossibleQty		=document.getElementById("txtPossibleQty"+[loop-1]).value;
				var PossibleDate	=document.getElementById("txtPossibledate"+[loop-1]).value;
				getBuyer			=row.cells[1].childNodes[0].innerHTML;
				
				
				var url			='Shipmentforcastdb.php?REQUEST=save_approval_details&SCNO=' + URLEncode(SCNO) +'&Buyer='+URLEncode(Buyer)+ '&BuyerPONo='+URLEncode(BuyerPONo) 
				+'&ShipmentID='+URLEncode(ShipmentID)+ '&PossibleQty='+URLEncode(PossibleQty)+ '&PossibleDate='+URLEncode(PossibleDate);
				htmlobj			=$.ajax({url:url,async:false});
				
				ShipmentArray[count]=SCNO+"/"+Buyer+"/"+BuyerPONo+"/"+ShipmentID;
				count++;
			}else{
				
				var SCNO			=row.cells[0].childNodes[0].innerHTML;
				var Buyer			=row.cells[1].childNodes[0].innerHTML;
				var BuyerPONo		=row.cells[3].childNodes[0].innerHTML;
				var ShipmentID		=row.cells[20].childNodes[0].innerHTML;
				
				var url			='Shipmentforcastdb.php?REQUEST=save_notapproval_details&SCNO=' + URLEncode(SCNO) +'&Buyer='+URLEncode(Buyer)+ '&BuyerPONo='+URLEncode(BuyerPONo) 
				+'&ShipmentID='+URLEncode(ShipmentID);
				htmlobj			=$.ajax({url:url,async:false});
				
				}
						
		}

		var lengthcount="0";
		for(var x=0;x<ShipmentArray.length;x++){
			var str   = ShipmentArray[x];
			var value = str.split("/");
			var url			='Shipmentforcastdb.php?REQUEST=getEmail&SCNO=' + URLEncode(value[0]) +'&Buyer='+URLEncode(value[1])+ '&BuyerPONo='+URLEncode(value[2])+'&ShipmentID='+URLEncode(value[3]);
			htmlobj			=$.ajax({url:url,async:false});
			if(htmlobj.responseText != ""){
				if(checkEmail(htmlobj.responseText) != "Available"){
					emailAddress[lengthcount] = htmlobj.responseText;
					lengthcount++;
				}
			}
		}
		
		for(var x=0;x<emailAddress.length;x++){
				if(getBuyer == 'NEXT'){
					emailAccount = 'dulip@helaclothing.com';
					}else if(getBuyer == 'DECATHLON'){
						emailAccount = 'dilhanis@helaclothing.com';
						}else if(getBuyer == 'TESCO'){
							emailAccount = 'prasadn@helaclothing.com';
						}else if(getBuyer == 'M AND S'){
							emailAccount = 'sureshr@helaclothing.com';
						}else if(getBuyer == 'LEVIS'){
							emailAccount = 'krishanthak@helaclothing.com';
						}else if(getBuyer == 'ASDA'){
							emailAccount = 'nirodana@helaclothing.com';
						}else{
							emailAccount = 'test@helaclothing.com';
							}
				var Email = emailAddress[x];
				var url='http://172.23.1.136/eshippin/mail.php?REQUEST=Approved&Buyer=' + URLEncode(Buyer)+'&FactoryManager='+URLEncode(Email)+'&emailAccount='+URLEncode(emailAccount);
				htmlobj			=$.ajax({url:url,async:false});
			}
		
		
		
		jQuery.noticeAdd({
				text: 'Successfully Approved',
				stay: false,
				type: 'success'
			});
	SearchBuyers();
	
	/*document.getElementById('txtHsCode').value="";*/
}

function checkEmail(Email){

	for(var x=0;x<emailAddress.length;x++){
			
		if(emailAddress[x] == Email){
			return "Available";
			break;
			}else{
				continue;
				}
		}
	}

function emailsend(){
	updateshipment();
	var Buyer=document.getElementById("cboBuyerSelect").value;
	var From=document.getElementById("txtmailfrom").value;
	var To=document.getElementById("txtmailto").value;
	var FactoryManager=document.getElementById("cboFactoryManager").value;
	if(Buyer == "Select One"){
		alert("Please select the Buyer");
		}
		else if(From == ""){
		alert("Please select the From Date");
		}
		else if(To == ""){
		alert("Please select the To Date");
		}
		else if(FactoryManager == "Select One"){
		alert("Please select the FactoryManager");
		}else{
	var url='http://172.23.1.136/eshippin/mail.php?REQUEST=SendEmail&Buyer=' + URLEncode(Buyer) +'&From='+URLEncode(From)+ '&To='+URLEncode(To)+'&FactoryManager='+URLEncode(FactoryManager);
	
	htmlobj			=$.ajax({url:url,async:false});
	
		
			jQuery.noticeAdd({
				text: 'Successfully Send',
				stay: false,
				type: 'success'
			});

		
			
		}
			
			
	}
function updateshipment()
{
	
	var tbl 	= document.getElementById('tblDescription');
	var From	= document.getElementById("txtmailfrom").value;
	var To		= document.getElementById("txtmailto").value;
	for (var loop=1;loop<tbl.rows.length;loop++)
		{
				
			var row= tbl.rows[loop];
			
			
				
				var SCNO			=row.cells[0].childNodes[0].innerHTML;
				var Buyer			=row.cells[1].childNodes[0].innerHTML;
				var BuyerPONo		=row.cells[3].childNodes[0].innerHTML;
				var ShipmentID		=row.cells[20].childNodes[0].innerHTML;

				
				var url			='Shipmentforcastdb.php?REQUEST=updateDates&SCNO=' + URLEncode(SCNO) +'&Buyer='+URLEncode(Buyer)+ '&BuyerPONo='+URLEncode(BuyerPONo) 
				+'&ShipmentID='+URLEncode(ShipmentID)+ '&From='+URLEncode(From)+ '&To='+URLEncode(To);
				htmlobj			=$.ajax({url:url,async:false});
						
		}
		
}