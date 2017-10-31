//
var prvMrnValue='';
function loadToEdit(mrn){
	window.open('../mrn/mrnDetails.php?mrn='+mrn,'mrn')
}

function loadMrnDets(mrn){
	if(mrn==''){
		return false;
	}
	else{
		 prvMrnValue='';
		document.getElementById('wasMrn_txtMrnNo').value=mrn;
		var path="../mrnList/mrnList_xml.php?req=loadDets&mrn="+mrn;
		htmlobj=$.ajax({url:path,async:false});

		document.getElementById('wasMrn_cboPOS').value=htmlobj.responseXML.getElementsByTagName('intStyleId')[0].childNodes[0].nodeValue;
		
		document.getElementById('wasMrn_cboStore').value=htmlobj.responseXML.getElementsByTagName('intStore')[0].childNodes[0].nodeValue; 
		document.getElementById('wasMrn_cboDepartment').value=htmlobj.responseXML.getElementsByTagName('intDepartment')[0].childNodes[0].nodeValue;
		document.getElementById('wasMrn_cboColor').innerHTML=htmlobj.responseXML.getElementsByTagName('strColor')[0].childNodes[0].nodeValue; 
		document.getElementById('wasMrn_txtRemarks').value=htmlobj.responseXML.getElementsByTagName('strRemarks')[0].childNodes[0].nodeValue; 
		prvMrnValue=htmlobj.responseXML.getElementsByTagName('dblQty')[0].childNodes[0].nodeValue;
		 	
		if(htmlobj.responseXML.getElementsByTagName('dblBalQty')[0].childNodes[0].nodeValue!=prvMrnValue){
			document.getElementById('Save').style.display='none';
			document.getElementById('butRpt').style.display='inline';
			holdForm();
		}
		document.getElementById('wasMrn_cboPOS').onchange();
		document.getElementById('wasMrn_txtMrnQty').value=prvMrnValue;
	}
}

function loadReport(mrnNo){

	if(mrnNo=="")
		return false
	else
		window.open('../mrnList/rptWasingMRNReport.php?mrn='+mrnNo,'WASMRN');
}

function getStylewiseOrderNo(obj){
	var path="../mrnList/mrnList_xml.php?req=loadPo&style="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboOrderNo').value=htmlobj.responseXML.getElementsByTagName('StyleId')[0].childNodes[0].nodeValue; 
}

function getStyle(obj){
	var path="../mrnList/mrnList_xml.php?req=loadStyle&po="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboStyleNo').value=htmlobj.responseXML.getElementsByTagName('StyleNo')[0].childNodes[0].nodeValue; 
}

function clearForm(){
	document.getElementById("cboStyleNo").value='';
	document.getElementById("cboOrderNo").value='';
	document.getElementById("cbomMrnNofrom").value='';
	document.getElementById("cboMrnNoTo").value='';
	document.getElementById("txtDfrom").value='';
	document.getElementById("txtDto").value='';
	document.getElementById("wasMrn_cboStore").value='';
	document.getElementById("wasMrn_cboDepartment").value='';
	
}