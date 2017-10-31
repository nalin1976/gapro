
function loadColor(obj){
	document.getElementById('wasMrn_cboStyles').value=obj.value;
	var path  = "wasMrn_xml.php?req=loadColor&orderNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor=htmlobj.responseXML.getElementsByTagName('Color');
	document.getElementById('wasMrn_cboColor').innerHTML="";
	for(var i=0;i<XMLColor.length;i++){
		$('#wasMrn_cboColor').append("<option value=\""+XMLColor[i].childNodes[0].nodeValue+"\">"+XMLColor[i].childNodes[0].nodeValue+"</option>");
	}
	//loadDetails(obj)
	loadQty(obj);
	getStylewiseOrderNos(obj);
}

function setStyle(con1,con2){
	document.getElementById(con2).value=document.getElementById(con1).value;
}

function loadQty(obj){

	var color=document.getElementById('wasMrn_cboColor').value.trim();	
	var path  = "wasMrn_xml.php?req=loadQty&orderNo="+obj.value.trim()+"&color="+URLEncode(color);
	htmlobj=$.ajax({url:path,async:false});

	var XMLORDERQty=htmlobj.responseXML.getElementsByTagName('ORDERQty');
	var XMLIQty=htmlobj.responseXML.getElementsByTagName('IQty');
	
	if(XMLORDERQty.length>0)
 		document.getElementById('wasMrn_txtOderQty').value=XMLORDERQty[0].childNodes[0].nodeValue;
	else
		document.getElementById('wasMrn_txtOderQty').value='';
	
	if(XMLIQty.length>0)
		document.getElementById('wasOther_txtAVLQty').value=XMLIQty[0].childNodes[0].nodeValue;
	else
		document.getElementById('wasOther_txtAVLQty').value=XMLIQty[0].childNodes[0].nodeValue;
	
	 document.getElementById('wasMrn_txtMrnQty').value='';
}

function Save_Mrn(){
	var saveDet="saveDet";
	if(document.getElementById('wasMrn_txtMrnNo').value!=""){
		saveDet="updateDet&mrnNo="+document.getElementById('wasMrn_txtMrnNo').value.trim();
	}
	if(document.getElementById('wasMrn_cboStore').value.trim()==""){
		alert("Please select the 'Store'");
		document.getElementById('wasMrn_cboStore').focus();
		return false;	
	}
	if(document.getElementById('wasMrn_cboDepartment').value.trim()==""){
		alert("Please select the 'Department'");
		document.getElementById('wasMrn_cboDepartment').focus();
		return false;	
	}
	if(document.getElementById('wasMrn_cboPOS').value.trim()==""){
		alert("Please select the 'PO No'");
		document.getElementById('wasMrn_cboPOS').focus();
		return false;	
	}
	if(document.getElementById('wasMrn_txtMrnQty').value.trim()==""){
		alert("Please enter 'Mrn Qty'");
		document.getElementById('wasMrn_txtMrnQty').focus();
		return false;	
	}
	
	var mrnDate=document.getElementById('wasMrn_txtMrnDate').value.trim();
	var store=document.getElementById('wasMrn_cboStore').value.trim();
	var department=document.getElementById('wasMrn_cboDepartment').value.trim();
	var PO=document.getElementById('wasMrn_cboPOS').value.trim();
	var color=document.getElementById('wasMrn_cboColor').value.trim();	
	var qty=document.getElementById('wasMrn_txtMrnQty').value.trim();
	var remarks=document.getElementById('wasMrn_txtRemarks').value.trim();
	
	var path  = "wasMrn_db.php?req="+saveDet+"&orderNo="+PO+"&color="+URLEncode(color)+"&mrnDate="+mrnDate+"&store="+store+"&department="+department+"&qty="+qty+"&remarks="+URLEncode(remarks);
	htmlobj=$.ajax({url:path,async:false});
	var res=htmlobj.responseText.split('~');
	if(res[0]==1){
		alert('Saved successfully.');
			document.getElementById('wasMrn_txtMrnNo').value=res[1];
			holdForm();
			document.getElementById('Save').style.display='none';
			document.getElementById('butRpt').style.display='inline';
			return false;
		}
	else{
		alert('Saving fail');
		return false;
	}
}

function setBalance(obj){
	//var avb=document.getElementById('wasOther_txtAVLQty').value.trim();
	var avb=document.getElementById('wasMrn_txtOderQty').value.trim();
	if(Number(obj.value)>Number(avb)){
		//alert(obj.value>avb);
		obj.value=avb;
	}	
}

function holdForm(){
	document.getElementById('wasMrn_cboStore').disabled=true;
	document.getElementById('wasMrn_cboDepartment').disabled=true;
	document.getElementById('wasMrn_cboPOS').disabled=true;
	document.getElementById('wasMrn_cboStyles').disabled=true;
	document.getElementById('wasMrn_cboColor').disabled=true;
	document.getElementById('wasMrn_txtMrnQty').disabled='disabled';
	document.getElementById('wasMrn_txtRemarks').readonly='readonly';
}

function clearFormN(){
	//document.getElementById('wasMrn_txtMrnNo').value="";
	document.getElementById('wasMrn_cboStore').disabled=false;
	document.getElementById('wasMrn_cboDepartment').disabled=false;
	document.getElementById('wasMrn_cboPOS').disabled=false;
	//document.getElementById('wasMrn_cboPOS').innerHTML="";
	document.getElementById('wasMrn_cboStyles').disabled=false;
	//document.getElementById('wasMrn_cboStyles').innerHTML="";
	document.getElementById('wasMrn_cboColor').disabled=false;
	document.getElementById('wasMrn_cboColor').innerHTML="";
	//document.getElementById('wasMrn_txtOderQty').value="";
	//document.getElementById('wasOther_txtAVLQty').value="";
	document.getElementById('wasMrn_txtMrnQty').readonly=false;
	//document.getElementById('wasMrn_txtRemarks').value="";
	document.getElementById('Save').style.display='inline';
	document.getElementById('butRpt').style.display='none';
	document.getElementById('frmWasOtherFacory_send').reset();

}

function showReports(){
	var mrnNo=document.getElementById('wasMrn_txtMrnNo').value.trim();
	if(mrnNo=="")
		return false
	else
		window.open('../mrnList/rptWasingMRNReport.php?mrn='+mrnNo,'WASMRN');
}

function checkDecimals(obj){
	var d=obj.value.trim();	
	if(d.indexOf('.') > -1){
		//var c=d.charAt(d.indexOf('.'));
		obj.value=d.replace(/\./g,' ');
		obj.value=obj.value.trim();
	}
}

function loadPos(obj){
	var path="wasMrn_xml.php?req=loadPo&style="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('wasMrn_cboPOS').value=htmlobj.responseXML.getElementsByTagName('StyleId')[0].childNodes[0].nodeValue; 
	loadColor(document.getElementById('wasMrn_cboPOS'))
}

function getStylewiseOrderNos(obj){
	var path="wasMrn_xml.php?req=loadStyle&po="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('wasMrn_cboStyles').value=htmlobj.responseXML.getElementsByTagName('StyleNo')[0].childNodes[0].nodeValue; 
		
}

function clearBLoad(){
	document.getElementById('wasMrn_cboColor').innerHTML="";
	document.getElementById('wasMrn_txtOderQty').value="";
	document.getElementById('wasOther_txtAVLQty').value="";	
}

function setMaxLength(obj){
	var len=obj.value.trim().length;
	if(len > 255){
		obj.value=obj.value.substr(0,255);
		return false;
	}
}