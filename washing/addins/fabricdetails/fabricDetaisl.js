//addins/fabricdetails/
$(document).ready(function() 
{
	var url					='fabricDetailsdb.php?req=load_fab_str';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtFabId" ).autocomplete({
			source: pub_po_arr
		});
});
function loadBuyerDivision(obj){
	var sql = "select distinct intDivisionId,strDivision from buyerdivisions where intBuyerID='"+obj.value.trim()+"' order by strDivision;";
	var control = "cboDivision";
	loadCombo(sql,control);
}
function loadData(obj){
	var path="fabricDetailsdb.php?req=loadDet&fabUId="+obj.value.trim();
		htmlobj=$.ajax({url:path,async:false});
		var XMLBuyer	=	htmlobj.responseXML.getElementsByTagName('Buyer');
		var XMLFabId	=	htmlobj.responseXML.getElementsByTagName('FabId');
		var XMLFabDes	=	htmlobj.responseXML.getElementsByTagName('FabDes');
		var XMLStyle 	=	htmlobj.responseXML.getElementsByTagName('Style');
		var XMLContent	=	htmlobj.responseXML.getElementsByTagName('Content');
		var XMLDivision	=	htmlobj.responseXML.getElementsByTagName('Division');
		var XMLMill		=	htmlobj.responseXML.getElementsByTagName('Mill');
		var XMLColor	=	htmlobj.responseXML.getElementsByTagName('Color');
		var XMLWashType	=	htmlobj.responseXML.getElementsByTagName('WashType');
		var XMLGarment	=	htmlobj.responseXML.getElementsByTagName('Garment');
		var XMLFactory	=	htmlobj.responseXML.getElementsByTagName('Factory');
		var XMLStatus	=	htmlobj.responseXML.getElementsByTagName('Status');
	if(!XMLFabId.length>0){
		ClearForm();
		return false;
	}
	document.getElementById('cboBuyer').value=XMLBuyer[0].childNodes[0].nodeValue;
	document.getElementById('cboBuyer').onchange();
	document.getElementById('txtFabId').value=XMLFabId[0].childNodes[0].nodeValue;
	document.getElementById('txtDescription').value=XMLFabDes[0].childNodes[0].nodeValue;
	document.getElementById('txtStyle').value=XMLStyle[0].childNodes[0].nodeValue;
	document.getElementById('txtFabContent').value=XMLContent[0].childNodes[0].nodeValue;
	document.getElementById('cboDivision').value=XMLDivision[0].childNodes[0].nodeValue;
	document.getElementById('cboMill').value=XMLMill[0].childNodes[0].nodeValue;
	document.getElementById('cboColor').value=XMLColor[0].childNodes[0].nodeValue;
	document.getElementById('cboWashType').value=XMLWashType[0].childNodes[0].nodeValue;
	document.getElementById('cboGarment').value=XMLGarment[0].childNodes[0].nodeValue;
	document.getElementById('cboFactory').value=XMLFactory[0].childNodes[0].nodeValue;
	if(XMLStatus[0].childNodes[0].nodeValue==1){
		document.getElementById('chkStatus').checked=true;
	}
	else{
		document.getElementById('chkStatus').checked=false;
	}
}
function checkDet(){
	var Buyer=document.getElementById('cboBuyer');
	var chkId=document.getElementById('cboFabId');
	var FabId = document.getElementById('txtFabId');
	var FabDSC= document.getElementById('txtDescription');
	var Style=document.getElementById('txtStyle');
	var FabContent=document.getElementById('txtFabContent');
	var Division=document.getElementById('cboDivision');
	var Mill=document.getElementById('cboMill');
	var Color=document.getElementById('cboColor');
	var WashType=document.getElementById('cboWashType');
	var Garment=document.getElementById('cboGarment');
	var Factory=document.getElementById('cboFactory');
	
	if(Buyer.value.trim()==""){
		alert("Please enter 'Buyer ID'.");
		Buyer.focus();
		return false;
	}
	if(FabId.value.trim()==""){
		alert("Please enter 'Fabric ID'.");
		FabId.focus();
		return false;
	}	
	if(FabDSC.value.trim()=="")
	{
		alert("Please enter 'Fabric Description'.");
		FabDSC.focus();
		return false;
	}
	if(Style.value.trim()==""){
		alert("Please enter 'Style Name '.");
		Style.focus();
		return false;
	}
	if(FabContent.value.trim()==""){
		alert("Please enter 'Fabric Content'.");
		FabContent.focus();
		return false;
	}	
	if(Division.value.trim()==""){
		alert("Please enter 'Division'.");
		Division.focus();
		return false;
	}
	if(Mill.value.trim()==""){
		alert("Please enter 'Mill'.");
		Mill.focus();
		return false;
	}	
	if(Color.value.trim()==""){
		alert("Please enter 'Color'.");
		Color.focus();
		return false;
	}	
	if(WashType.value.trim()==""){
		alert("Please select 'Wash Type'.");
		WashType.focus();
		return false;
	}	
	if(Garment.value.trim()==""){
		alert("Please select 'Garment'.");
		Garment.focus();
		return false;
	}	
	if(Factory.value.trim()==""){
		alert("Please select 'Factory'.");
		Factory.focus();
		return false;
	}
	var Status=0;
	if(document.getElementById('chkStatus').checked==true){
		Status= 1;
	}
	
	if(chkId.value.trim()==""){
		saveDatails(Buyer,FabId,FabDSC,Style,FabContent,Division,Mill,Color,WashType,Garment,Factory,Status);
	}
	else{
		updateDatails(chkId,Buyer,FabId,FabDSC,Style,FabContent,Division,Mill,Color,WashType,Garment,Factory,Status);
	}
}
function saveDatails(Buyer,FabId,FabDSC,Style,FabContent,Division,Mill,Color,WashType,Garment,Factory,Status){
	
	var path="fabricDetailsdb.php?req=saveDet&Buyer="+Buyer.value.trim()+"&FabId="+URLEncode(FabId.value.trim())+"&FabDSC="+URLEncode(FabDSC.value.trim())+"&Style="+URLEncode(Style.value.trim())+"&FabContent="+URLEncode(FabContent.value.trim())+"&Division="+URLEncode(Division.value.trim())+"&Mill="+URLEncode(Mill.value.trim())+"&Color="+URLEncode(Color.value.trim())+"&WashType="+WashType.value.trim()+"&Garment="+Garment.value.trim()+"&Factory="+Factory.value.trim()+"&Status="+Status;
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLStatus	=	htmlobj.responseXML.getElementsByTagName('Status');
	var XMLMSG		=	htmlobj.responseXML.getElementsByTagName('MSG');
	
	if(XMLStatus[0].childNodes[0].nodeValue){
		alert(XMLMSG[0].childNodes[0].nodeValue);
		loadCmb();
		ClearForm();
		return false;
	}
	else{
		alert(XMLMSG[0].childNodes[0].nodeValue);
		return false;
	}
	
}

function updateDatails(chkId,Buyer,FabId,FabDSC,Style,FabContent,Division,Mill,Color,WashType,Garment,Factory,Status){

	var path="fabricDetailsdb.php?req=updateDet&fabUId="+chkId.value.trim()+"&Buyer="+Buyer.value.trim()+"&FabId="+URLEncode(FabId.value.trim())+"&FabDSC="+URLEncode(FabDSC.value.trim())+"&Style="+URLEncode(Style.value.trim())+"&FabContent="+URLEncode(FabContent.value.trim())+"&Division="+URLEncode(Division.value.trim())+"&Mill="+URLEncode(Mill.value.trim())+"&Color="+URLEncode(Color.value.trim())+"&WashType="+WashType.value.trim()+"&Garment="+Garment.value.trim()+"&Factory="+Factory.value.trim()+"&Status="+Status;
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLStatus	=	htmlobj.responseXML.getElementsByTagName('Status');
	var XMLMSG		=	htmlobj.responseXML.getElementsByTagName('MSG');
	
	if(XMLStatus[0].childNodes[0].nodeValue){
		alert(XMLMSG[0].childNodes[0].nodeValue);
		loadCmb();
		ClearForm();
		return false;
	}
	else{
		alert(XMLMSG[0].childNodes[0].nodeValue);
		return false;
	}
	
}
function loadCmb(){
	var sql = "select intId,strFabricId from was_outsidewash_fabdetails order by strFabricId;";
	var control = "cboFabId";
	loadCombo(sql,control);
}
function ConfirmDelete(){
	var FabId = document.getElementById('cboFabId');
	if(FabId.value.trim()==""){
		alert("Please select 'Fabric ID'.");
		FabId.focus();
		return false;
	}
	if(confirm("Do you want to delete 'Fabric ID'.")){
	var path="fabricDetailsdb.php?req=delDet&fabUId="+FabId.value.trim();
		htmlobj=$.ajax({url:path,async:false});
		var XMLStatus	=	htmlobj.responseXML.getElementsByTagName('Status');
		var XMLMSG		=	htmlobj.responseXML.getElementsByTagName('MSG');
	
		if(XMLStatus[0].childNodes[0].nodeValue){
			alert(XMLMSG[0].childNodes[0].nodeValue);
			loadCmb();
			ClearForm();
			return false;
		}
	}
}

function ClearForm(){
	document.getElementById('frmFabricDet').reset();	
}

function ViewFabricDesreport(){
	 window.open('fabricDetailsReport.php','FabricDetails')	
}