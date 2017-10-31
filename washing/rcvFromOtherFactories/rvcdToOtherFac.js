// JavaScript Document
function loadStyles()
{
	var conId=document.getElementById('wasOther_txtFromFactoryS').value.trim();
	if(conId=="")
	{
		//ClearForm('new');
		document.getElementById("wasOther_cboPOS").value="";
		document.getElementById("wasOther_cboStyleS").value="";
		return false;
	}
	
	var path  = "issuedToOtherFacWash_xml.php?req=loadStyle&comId="+conId;
	htmlobj=$.ajax({url:path,async:false});
	$("#wasOther_cboStyleS").html(htmlobj.responseXML.getElementsByTagName("styleNo")[0].childNodes[0].nodeValue);
	$("#wasOther_cboPOS").html(htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue);
	
}

function loadTofactory (obj){
	var path  = "rvcdToOtherFacWash_xml.php?req=loadCompany&serial="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById("wasOther_txtFromFactoryS").value=htmlobj.responseXML.getElementsByTagName("CompanyId")[0].childNodes[0].nodeValue;
	document.getElementById("wasOther_txtSFactoryS").value=htmlobj.responseXML.getElementsByTagName("SId")[0].childNodes[0].nodeValue;
	var po=htmlobj.responseXML.getElementsByTagName("PONo")[0].childNodes[0].nodeValue;
	var id=htmlobj.responseXML.getElementsByTagName("StyleId")[0].childNodes[0].nodeValue;
	var Style=htmlobj.responseXML.getElementsByTagName("Style")[0].childNodes[0].nodeValue;
	var XMLRemarks=htmlobj.responseXML.getElementsByTagName("Remarks");
	var XMLReason=htmlobj.responseXML.getElementsByTagName("Reason");
	
	$("#wasOther_cboPOS").html("<option value=\"\">Select One</option><option value=\""+id+"\">"+po+"</option>");
	$("#wasOther_cboStyleS").html("<option value=\"\">Select One</option><option value=\""+id+"\">"+Style+"</option>");
	
	document.getElementById('wasOther_cboPOS').selectedIndex=1;
	document.getElementById('wasOther_cboPOS').onchange();
	if(XMLRemarks.length > 0){
		document.getElementById('wasOther_txtRemarks').value=XMLRemarks[0].childNodes[0].nodeValue;
	}
	
	if(XMLReason.length > 0){
		document.getElementById('wasOther_cboReason').value=XMLReason[0].childNodes[0].nodeValue;
	}
}
function loadColor(obj){
	document.getElementById('wasOther_cboStyleS').value=obj.value;
	var path  = "rvcdToOtherFacWash_xml.php?req=loadColor&orderNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor=htmlobj.responseXML.getElementsByTagName('Color');
	document.getElementById('wasOther_cboColorS').innerHTML="";
	for(var i=0;i<XMLColor.length;i++){
		$('#wasOther_cboColorS').append("<option value=\""+XMLColor[i].childNodes[0].nodeValue+"\">"+XMLColor[i].childNodes[0].nodeValue+"</option>");
	}
	//loadDetails(obj)
	loadQty(obj);
}

function loadPO(sNo)
{
	var sId=document.getElementById('wasOther_cboStyleS').value.trim();
	document.getElementById("wasOther_cboPOS").value=sId;
	document.getElementById("wasOther_cboPOS").onchange();
}

function setStyle(con1,con2){
	document.getElementById(con2).value=document.getElementById(con1).value;
}

function loadQty(obj){

	var color=document.getElementById('wasOther_cboColorS').value.trim();	
	var path  = "rvcdToOtherFacWash_xml.php?req=loadQty&orderNo="+document.getElementById('wasOther_cboPOS').value.trim()+"&color="+URLEncode(color)+"&factory="+document.getElementById('wasOther_txtToFactoryS').value.trim()+"&serial="+document.getElementById('wasOther_cboGPNoR').value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLRCVDQty=htmlobj.responseXML.getElementsByTagName('RCVDQty');
	var XMLORDERQty=htmlobj.responseXML.getElementsByTagName('ORDERQty');
	var XMLIQty=htmlobj.responseXML.getElementsByTagName('IQty');
	//var XMLIssuedQty=htmlobj.responseXML.getElementsByTagName('IssuedQty');
	
	document.getElementById('wasOther_txtRecvQty').value=XMLRCVDQty[0].childNodes[0].nodeValue;
 	document.getElementById('wasOther_txtOderQty').value=XMLORDERQty[0].childNodes[0].nodeValue;
	document.getElementById('wasOther_txtAVLQty').value=XMLIQty[0].childNodes[0].nodeValue;
	/*document.getElementById('wasOther_txtIssueQty').value=XMLIQty[0].childNodes[0].nodeValue;
	
	document.getElementById('wasOther_txtIssuedQty').value=XMLIssuedQty[0].childNodes[0].nodeValue;*/
}

//save send details

function Save_receive(){
	if(!formValidation()){
		return false;	
	}
	var serial=document.getElementById('wasOther_txtSerialNoR').value.trim();	
	var req="";
	if(serial=="")
		req="saveDet";
	else
		req="updateDet";
	var GPNoR=document.getElementById('wasOther_cboGPNoR').value.trim();	
	var po=document.getElementById('wasOther_cboPOS').value.trim();
	var color=document.getElementById('wasOther_cboColorS').value.trim();
	var rcvQty=document.getElementById('wasOther_txtSQty').value.trim();
	var fFactory=document.getElementById('wasOther_txtFromFactoryS').value.trim();
	var tFactory=document.getElementById('wasOther_txtToFactoryS').value.trim();	
	var sFactory=document.getElementById('wasOther_txtSFactoryS').value.trim();
	var remarks=document.getElementById('wasOther_txtRemarks').value.trim();	
	var reason = document.getElementById('wasOther_cboReason').value.trim();
	
	var path="rvcdToOtherFac_db.php?req="+req+"&GPNo="+GPNoR+"&fFactory="+fFactory+"&PONo="+po+"&color="+URLEncode(color)+"&rcvQty="+rcvQty+"&toFactory="+tFactory+"&sFactory="+sFactory+"&remarks="+remarks+"&reason="+reason;

	htmlobj=$.ajax({url:path,async:false});
	var XMLRes=htmlobj.responseXML.getElementsByTagName('Res');
	var XMLGPNo=htmlobj.responseXML.getElementsByTagName('serial');
	if(XMLRes[0].childNodes[0].nodeValue==1){
		alert("Saved successfully.");
		document.getElementById('wasOther_txtSerialNoR').value=XMLGPNo[0].childNodes[0].nodeValue;
		document.getElementById('Save').style.display='none';
		document.getElementById('butReport').style.display='inline';
		return false;
		}
	else{
		alert("Saving fail");
		return false;
	}
}

function loadCompayPor(obj){
	if(obj.value=="")
	{
		//ClearForm('new');
		document.getElementById("wasOther_cboPOR").value="";
		document.getElementById("wasOther_cboStyleR").value="";
		return false;
	}
	
	var path  = "issuedToOtherFacWash_xml.php?req=loadRPOs&comId="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	
	var styleId=htmlobj.responseXML.getElementsByTagName("styleId")[0].childNodes[0].nodeValue;
	var poNo=htmlobj.responseXML.getElementsByTagName("orderNo")[0].childNodes[0].nodeValue
	var style=htmlobj.responseXML.getElementsByTagName("StyleNo")[0].childNodes[0].nodeValue
	
	$("#wasOther_cboPOR").html("<option value=\"\">Select One</option><option value=\""+styleId+"\">"+poNo+"</option>");
	$("#wasOther_cboStyleR").html("<option value=\"\">Select One</option><option value=\""+styleId+"\">"+style+"</option>");
}

function rcvColors(obj){
	var comId=document.getElementById('wasOther_cboFromFactoryR').value.trim();
	var path="issuedToOtherFacWash_xml.php?req=rcvColors&poNo="+obj.value.trim()+"&comId="+comId;
	htmlobj=$.ajax({url:path,async:false});	
	var Color=htmlobj.responseXML.getElementsByTagName('Color');
	
	$("#wasOther_cboColorR").html("<option value=\"\">Select One</option><option value=\""+Color[0].childNodes[0].nodeValue+"\">"+Color[0].childNodes[0].nodeValue+"</option>");
	document.getElementById('wasOther_cboColorR').selectedIndex=1;
	document.getElementById('wasOther_cboColorR').onchange();
}

function loadRCVQty(obj){
	var poNo=document.getElementById('wasOther_cboPOR').value.trim();
	var color=obj.value.trim();
	var path="issuedToOtherFacWash_xml.php?req=rcvQtys&color="+color+"&poNo="+poNo+"&comId="+document.getElementById('wasOther_cboFromFactoryR').value.trim();
	htmlobj=$.ajax({url:path,async:false});	
    var orderQty=htmlobj.responseXML.getElementsByTagName('orderQty');
	var RcvdQty =htmlobj.responseXML.getElementsByTagName('RcvdQty');
	document.getElementById("wasOther_txtQrderQtyR").value=orderQty[0].childNodes[0].nodeValue;
	document.getElementById("wasOther_txtRcvQtyR").value=RcvdQty[0].childNodes[0].nodeValue;
}

function ClearForm(){
	document.getElementById('frmWasOtherFacory_send').reset();	
	document.getElementById('wasOther_cboPOS').innerHTML=""; 
	document.getElementById('wasOther_cboColorS').innerHTML=""; 
	document.getElementById('Save').style.display='inline';
	document.getElementById('butReport').style.display='none'
}

function checkBalance(obj){
	var AQty = document.getElementById('wasOther_txtAVLQty').value.trim();
	if(Number(obj.value) > Number(AQty)){
		obj.value=AQty;
	}
	else if(Number(obj.value)==0){
		obj.value=AQty;
	}
}

function formValidation(){
	if(document.getElementById('wasOther_cboGPNoR').value.trim()==""){
		alert("Please select 'GatePass No'.");
		document.getElementById('wasOther_cboGPNoR').focus();
		return false;
	}
	else if(document.getElementById('wasOther_cboPOS').value.trim()==""){
		alert("Please select 'PO No'.");
		document.getElementById('wasOther_cboPOS').focus();
		return false;
		
	}
	else if(document.getElementById('wasOther_txtSQty').value.trim()==""){
		alert("Please enter 'Receiving Qty'.");
		document.getElementById('wasOther_txtSQty').focus();
		return false;	
	}
	else if(Number(document.getElementById('wasOther_txtAVLQty').value.trim())==0){
		document.getElementById('wasOther_txtSQty').focus();
		return false;
	}
	else return true;
}

function showRpt(){

	var serial=document.getElementById('wasOther_txtSerialNoR').value.trim();
	if(serial.trim()==''){
		return false;
	}
	window.open("rptrvcdToOther.php?req="+serial,'SNTO');

}