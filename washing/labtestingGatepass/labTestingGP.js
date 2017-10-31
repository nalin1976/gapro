//js lab Testing GP -last program For Washing Stores- 18-08-2011

function loadStyle(obj){
	if(obj.value.trim() == ""){
		clearForm();
		return false;
	}
	var path="labTestingGP_xml.php?req=loadStyle&po="+obj.value.trim(); 
	htmlobj=$.ajax({url:path,async:false});
	var XMLStyle=htmlobj.responseXML.getElementsByTagName('style');
	var XMLFromFactory=htmlobj.responseXML.getElementsByTagName('FromFactory');
	var XMLOQty	=	htmlobj.responseXML.getElementsByTagName('OQty');
	if(XMLStyle.length > 0){
		document.getElementById('cboStyle').value=XMLStyle[0].childNodes[0].nodeValue;
		document.getElementById('cboSFac').value=XMLFromFactory[0].childNodes[0].nodeValue;
		document.getElementById('txtOrderQty').value=XMLOQty[0].childNodes[0].nodeValue;
		loadColor(obj.value);
	}
		
	
}

function loadPO(obj){
	if(obj.value.trim() == ""){
		clearForm();
		return false;
	}
	var path="labTestingGP_xml.php?req=loadPo&style="+obj.value.trim(); 
	htmlobj=$.ajax({url:path,async:false});
	var XMLPo=htmlobj.responseXML.getElementsByTagName('po');
	var XMLFromFactory=htmlobj.responseXML.getElementsByTagName('FromFactory');
	var XMLOQty	=	htmlobj.responseXML.getElementsByTagName('OQty');
	if(XMLPo.length>0){
		document.getElementById('cboPO').value=XMLPo[0].childNodes[0].nodeValue;
		document.getElementById('cboSFac').value=XMLFromFactory[0].childNodes[0].nodeValue;	
		document.getElementById('txtOrderQty').value=XMLOQty[0].childNodes[0].nodeValue;
		loadColor(document.getElementById('cboPO').value)
	}
}

function loadColor(po){
	
	var path="labTestingGP_xml.php?req=loadColor&po="+po; 
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor=htmlobj.responseXML.getElementsByTagName('color');
	var XMLRNos=htmlobj.responseXML.getElementsByTagName('MRN');
	
	document.getElementById('cboColor').innerHTML= XMLColor[0].childNodes[0].nodeValue;	
	if(XMLRNos.length > 0)
		document.getElementById('cboRNo').innerHTML  = XMLRNos[0].childNodes[0].nodeValue;
	else
		document.getElementById('cboRNo').innerHTML  = "<option value=\"\">Select One</option>";
}

function getMRNQty(obj){
	var path="labTestingGP_xml.php?req=URLLoadMRNDetails&MrnNo="+obj.value.trim(); 
	htmlobj=$.ajax({url:path,async:false});
	var XMLMRNQty=htmlobj.responseXML.getElementsByTagName('MRNQty');
	
	document.getElementById('cboAvQty').value = XMLMRNQty[0].childNodes[0].nodeValue;	
}

function setBalance(obj){
	var avb=document.getElementById('cboAvQty').value.trim();
	if(Number(obj.value)>Number(avb)){
		//alert(obj.value>avb);
		obj.value=avb;
	}	
}

function saveDet(){
	if(formValidation()){
		var po=document.getElementById('cboPO').value.trim();
		var color=URLEncode(document.getElementById('cboColor').value);
		var vNo=document.getElementById('txtVNo').value.trim();
		var rqNo=document.getElementById('cboRNo').value.trim();
		var qty=document.getElementById('txtSendQty').value.trim();
		var fFac=document.getElementById('cboFFac').value.trim();
		var sFac=document.getElementById('cboSFac').value.trim();
		var toFac=document.getElementById('cboTFac').value.trim();
		var remarks=document.getElementById('txtRemarks').value.trim();
		
		var path="labTestingGP_db.php?req=saveDet&po="+po+"&color="+color+"&vNo="+vNo+"&rqNo="+rqNo+"&qty="+qty+"&fFac="+fFac+"&sFac="+sFac+"&toFac="+toFac+"&remarks="+remarks; 
		htmlobj=$.ajax({url:path,async:false});
		var Res=htmlobj.responseText
		if(Res.split('~')[0]!=0){
			document.getElementById('txtGPNo').value=Res.split('~')[0];
			document.getElementById('rpt').style.display='inline';
			document.getElementById('save').style.display='none';
		}
		
		alert(Res.split('~')[1]);
	}
}

function formValidation(){
	if(document.getElementById('cboPO').value.trim()==''){
		alert("Please select 'PO No'.");
		document.getElementById('cboPO').focus();
		return false
	}
	if(document.getElementById('cboRNo').value.trim()==''){
		alert("Please enter 'Request No'.");
		document.getElementById('cboRNo').focus();
		return false
	}
	if(document.getElementById('cboTFac').value.trim()==''){
		alert("Please select 'To Factory'.");
		document.getElementById('cboTFac').focus();
		return false
	}
	if(document.getElementById('txtSendQty').value.trim()==''){
		alert("Please enter 'Send Qty'.");
		document.getElementById('txtSendQty').focus();
		return false
	}
	return true;
}

function loadReport(){
	window.open('rptLabTestingGP.php?req='+document.getElementById('txtGPNo').value,'new');
}

function clearForm(){
	document.getElementById('frm').reset();
	document.getElementById('cboRNo').innerHTML  = "<option value=\"\">Select One</option>";
	document.getElementById('cboColor').innerHTML  = "<option value=\"\">Select One</option>";
	document.getElementById('save').style.display='inline';
}