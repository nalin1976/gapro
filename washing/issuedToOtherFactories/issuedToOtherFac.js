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

function loadColor(obj){
	document.getElementById('wasOther_cboStyleS').value=obj.value;
	var path  = "issuedToOtherFacWash_xml.php?req=loadColor&orderNo="+obj.value.trim();
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
	var sFac=document.getElementById('wasOther_txtSewingFactoryS').value.trim();
	var path  = "issuedToOtherFacWash_xml.php?req=loadQty&orderNo="+obj.value.trim()+"&color="+URLEncode(color)+"&sFac="+sFac;
	htmlobj=$.ajax({url:path,async:false});
	var XMLRCVDQty=htmlobj.responseXML.getElementsByTagName('RCVDQty');
	var XMLORDERQty=htmlobj.responseXML.getElementsByTagName('ORDERQty');
	var XMLIQty=htmlobj.responseXML.getElementsByTagName('IQty');
	var XMLGPQty=htmlobj.responseXML.getElementsByTagName('GPQty');
	//var XMLIssuedQty=htmlobj.responseXML.getElementsByTagName('IssuedQty');
	
	document.getElementById('wasOther_txtRecvQty').value=XMLGPQty[0].childNodes[0].nodeValue;
 	document.getElementById('wasOther_txtOderQty').value=XMLORDERQty[0].childNodes[0].nodeValue;
	document.getElementById('wasOther_txtAVLQty').value=XMLIQty[0].childNodes[0].nodeValue;
	/*document.getElementById('wasOther_txtIssueQty').value=XMLIQty[0].childNodes[0].nodeValue;
	
	document.getElementById('wasOther_txtIssuedQty').value=XMLIssuedQty[0].childNodes[0].nodeValue;*/
	
	var XMLNr=htmlobj.responseXML.getElementsByTagName("Nr");
	var XMLCompany=htmlobj.responseXML.getElementsByTagName("cName");
	
	if(XMLNr.length>0){
		//alert(XMLNr[0].childNodes[0].nodeValue)
		if(XMLNr[0].childNodes[0].nodeValue==1){
			document.getElementById('wasOther_txtSewingFactoryS').innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			document.getElementById('wasOther_txtSewingFactoryS').disabled=true;
			//loadColor(obj);
		}
		else{
			document.getElementById('wasOther_txtSewingFactoryS').innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			alert("Please select 'Sewing Factory'.");
			document.getElementById('wasOther_txtSewingFactoryS').disabled=false
			return false;
		}
	}
}

//save send details

function Save_Send()
{
	if(!fromValidation()){
		return false;	
	}
	var GPNoS=document.getElementById('wasOther_txtGPNoS').value.trim();
	var req="";
	if(GPNoS=="")
		req="saveDet";
	else
		req="updateDet";
	
	var dameges = document.getElementById('chkDamages').checked;	
	var po=document.getElementById('wasOther_cboPOS').value.trim();
	var color=document.getElementById('wasOther_cboColorS').value.trim();
	var sQty=document.getElementById('wasOther_txtSQty').value.trim();
	var tFactory=document.getElementById('wasOther_OutFactoryS').value.trim();
	var sFactory=document.getElementById('wasOther_txtSewingFactoryS').value.trim();
	var remarks=document.getElementById('wasOther_txtRemarks').value.trim();	
	var reason=document.getElementById('wasOther_cboReason').value.trim();
	
	var path="issuedToOtherFac_db.php?req="+req+"&PONo="+po+"&color="+URLEncode(color)+"&sendQty="+sQty+"&toFactory="+tFactory+"&sFactory="+sFactory+"&remarks="+remarks+"&vNo="+document.getElementById('wasOther_txtvNo').value.trim()+"&reason="+reason+"&dameges="+dameges;
	
	htmlobj=$.ajax({url:path,async:false});
	var XMLRes=htmlobj.responseXML.getElementsByTagName('Res');
	var XMLGPNo=htmlobj.responseXML.getElementsByTagName('GP');
	if(XMLRes[0].childNodes[0].nodeValue==1){
		alert("Saved successfully.");
		document.getElementById('wasOther_txtGPNoS').value=XMLGPNo[0].childNodes[0].nodeValue;
		document.getElementById('Save').style.display='none';
		document.getElementById('butReport').style.display='inline';
		document.getElementById('butCancel').style.display='inline';
		document.getElementById('butConfirm').style.display='inline';
		holdForm();
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
	var path="issuedToOtherFacWash_xml.php?req=rcvQtys&color="+color+"&poNo="+poNo+"&comId="+document.getElementById('wasOther_cboFromFactoryR').value.trim();;
	htmlobj=$.ajax({url:path,async:false});	
    var orderQty=htmlobj.responseXML.getElementsByTagName('orderQty');
	var RcvdQty =htmlobj.responseXML.getElementsByTagName('RcvdQty');
	document.getElementById("wasOther_txtQrderQtyR").value=orderQty[0].childNodes[0].nodeValue;
	document.getElementById("wasOther_txtRcvQtyR").value=RcvdQty[0].childNodes[0].nodeValue;
}

function showaReport(){
	var serial=document.getElementById('wasOther_txtGPNoS').value.trim();
	if(serial!=""){
		window.open("rptOtherFactoryReport.php?req="+serial,'SNTO');
	}
}
// public array for form fields
	var arrOpts=['wasOther_txtGPNoS','wasOther_cboPOS','wasOther_cboStyleS','wasOther_cboColorS','wasOther_txtOderQty','wasOther_txtRecvQty','wasOther_txtAVLQty','wasOther_txtSQty','wasOther_OutFactoryS','wasOther_txtRemarks'];
	
function clearForm(){
	for(var i=0;i<arrOpts.length;i++){
		if(i==3){
			document.getElementById(arrOpts[i]).innerHTML="";
		}else {
			document.getElementById(arrOpts[i]).value="";
		}
	}
	for(var i=0;i<arrOpts.length;i++){
		if(i==1 || i==2 || i==3 || i==8){
			document.getElementById(arrOpts[i]).disabled=false;
		}else {
			document.getElementById(arrOpts[i]).readonly=false;
		}
	}
	document.getElementById('wasOther_txtSewingFactoryS').innerHTML="<option value=\"\">Select One</option>";
	document.getElementById('frmWasOtherFacory_send').reset();
	document.getElementById('Save').style.display='inline';
	document.getElementById('butReport').style.display='none';
	document.getElementById('butCancel').style.display='none';
    document.getElementById('butConfirm').style.display='none';
}

function holdForm(){
	for(var i=0;i<arrOpts.length;i++){
		if(i==1 || i==2 || i==3 || i==8){
			document.getElementById(arrOpts[i]).disabled=true;
		}else {
			document.getElementById(arrOpts[i]).readonly='readonly';
		}
	}
		//
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

function fromValidation(){
		if(document.getElementById('wasOther_cboPOS').value.trim()==""){
			alert("Please select 'PO No'.");
			document.getElementById('wasOther_cboPOS').focus();
			return false;
		}
		else if(document.getElementById('wasOther_cboColorS').value.trim()==""){
			alert("Please select 'Color'.");
			document.getElementById('wasOther_cboColorS').focus();
			return false;	
		}
		else if(document.getElementById('wasOther_txtSQty').value.trim()==""){
			alert("Please enter 'Send Qty'.");
			document.getElementById('wasOther_txtSQty').focus();
			return false;
		}
		else if(document.getElementById('wasOther_txtSewingFactoryS').value.trim()==""){
			alert("Please select 'Sewing Factory'.");
			document.getElementById('wasOther_txtSewingFactoryS').focus();
			return false;
		}
		else if(document.getElementById('wasOther_OutFactoryS').value.trim()==""){
			alert("Please select 'To Factory '.");
			document.getElementById('wasOther_OutFactoryS').focus();
			return false;
		}
		else return true;
}
function cancelDet(){
	var gpno	=	document.getElementById('wasOther_txtGPNoS').value.trim();
	if(gpno==''){
			return false;	
	}
	if(confirm("Do you want to cancel GatePass No:-"+gpno+".")){
	var cancelReason = prompt("Please Enter 'Gatepass Cancel Reason.'");
		if(cancelReason==null){//cancel=null
			return false	
		}
		else{
			var path="issuedToOtherFac_db.php?req=cancelDet&gpno="+gpno+"&reason="+cancelReason;
			htmlobj=$.ajax({url:path,async:false});	
			var XMLRes=htmlobj.responseXML.getElementsByTagName('Res');
			if(XMLRes[0].childNodes[0].nodeValue==1){
				alert('Succussfully canceled.');
				document.getElementById('butCancel').style.display='none';
				document.getElementById('butConfirm').style.display='none';
				return false;
			}
			else{
				alert('Fail.');
				return false;	
			}
		}
	}
}

function confirmDet(){
	var gpno	=	document.getElementById('wasOther_txtGPNoS').value.trim();
	if(gpno==''){
			return false;	
	}
	var path="issuedToOtherFac_db.php?req=confirmDet&gpno="+gpno;
		htmlobj=$.ajax({url:path,async:false});	
		var XMLRes=htmlobj.responseXML.getElementsByTagName('Res');
			if(XMLRes[0].childNodes[0].nodeValue==1){
				alert('Succussfully confirmed.');
				document.getElementById('butCancel').style.display='none';
				document.getElementById('butConfirm').style.display='none';
				return false;
			}
			else{
				alert('Fail.');
				return false;	
			}
}

function loadDets(gp){
	if(gp!=''){
		document.getElementById('wasOther_txtGPNoS').value=gp;
		htmlObj=$.ajax({url:"issuedToOtherFacWash_xml.php?req=loadDets&gp="+gp,async:false});
		var XMLOrderNo = htmlObj.responseXML.getElementsByTagName("po");
		var XMLVNo	   = htmlObj.responseXML.getElementsByTagName("vNo");
		var XMLGPQty   = htmlObj.responseXML.getElementsByTagName('gpQty');
		var XMLToFac   = htmlObj.responseXML.getElementsByTagName('ToFac'); 
		var XMLReason  = htmlObj.responseXML.getElementsByTagName('Reason');
		var XmlRemarks = htmlObj.responseXML.getElementsByTagName('Remarks');  
		var XMLStatus  = htmlObj.responseXML.getElementsByTagName('Status');
		var XMLDamages = htmlObj.responseXML.getElementsByTagName('Damages');
		 
		document.getElementById('wasOther_cboPOS').value=XMLOrderNo[0].childNodes[0].nodeValue;
		document.getElementById('wasOther_cboPOS').onchange();
		document.getElementById('wasOther_txtvNo').value=XMLVNo[0].childNodes[0].nodeValue;
		document.getElementById('wasOther_OutFactoryS').value=XMLToFac[0].childNodes[0].nodeValue;
		document.getElementById('wasOther_cboReason').value=XMLReason[0].childNodes[0].nodeValue;
		document.getElementById('wasOther_txtRemarks').value=XmlRemarks[0].childNodes[0].nodeValue;
		if(XMLDamages[0].childNodes[0].nodeValue==1)
			document.getElementById('chkDamages').checked = true;
		else
			document.getElementById('chkDamages').checked = false;
		
		document.getElementById('wasOther_txtAVLQty').value = document.getElementById('wasOther_txtSQty').value
		document.getElementById('wasOther_txtSQty').value=XMLGPQty[0].childNodes[0].nodeValue;
		if(XMLStatus[0].childNodes[0].nodeValue==10){
			document.getElementById('wasOther_txtAVLQty').value = (parseInt(document.getElementById('wasOther_txtRecvQty').value)+parseInt(XMLGPQty[0].childNodes[0].nodeValue));
		}
		if(XMLStatus[0].childNodes[0].nodeValue==0){
			document.getElementById('wasOther_txtAVLQty').value = (parseInt(document.getElementById('wasOther_txtRecvQty').value)+parseInt(XMLGPQty[0].childNodes[0].nodeValue));
		}
		else{
		document.getElementById('wasOther_txtAVLQty').value = (parseInt(document.getElementById('wasOther_txtRecvQty').value)-parseInt(XMLGPQty[0].childNodes[0].nodeValue));
		}
		document.getElementById('wasOther_txtRecvQty').value=(parseInt(document.getElementById('wasOther_txtRecvQty').value)+parseInt(XMLGPQty[0].childNodes[0].nodeValue))
		
		if(XMLStatus[0].childNodes[0].nodeValue==0){
			document.getElementById('butCancel').style.display='inline';
			document.getElementById('butConfirm').style.display='inline';
			document.getElementById('Save').style.display='none'; 
			document.getElementById('butReport').style.display='inline'; 
		}
		else{
			document.getElementById('Save').style.display='none'; 
			document.getElementById('butReport').style.display='inline'; 
			
		}
		
	}	
}

//
function LoadQtyWhenChangeSewFactory(){

	var color	= document.getElementById('wasOther_cboColorS').value.trim();
	var sFac	= document.getElementById('wasOther_txtSewingFactoryS').value.trim();
	var styleId	= document.getElementById('wasOther_cboPOS').value.trim();
	
	var path  = "issuedToOtherFacWash_xml.php?req=URLLoadQtyWhenChangeSewFactory&orderNo="+styleId+"&color="+URLEncode(color)+"&sFac="+sFac;
	htmlobj = $.ajax({url:path,async:false});
	
	var XMLRCVDQty	= htmlobj.responseXML.getElementsByTagName('RCVDQty');
	var XMLORDERQty	= htmlobj.responseXML.getElementsByTagName('ORDERQty');
	var XMLIQty		= htmlobj.responseXML.getElementsByTagName('IQty');
	var XMLGPQty	= htmlobj.responseXML.getElementsByTagName('GPQty');
	
	document.getElementById('wasOther_txtRecvQty').value = XMLGPQty[0].childNodes[0].nodeValue;
 	document.getElementById('wasOther_txtOderQty').value = XMLORDERQty[0].childNodes[0].nodeValue;
	document.getElementById('wasOther_txtAVLQty').value = XMLIQty[0].childNodes[0].nodeValue;
}
//