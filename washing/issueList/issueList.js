//
function loadToEdit(mrn){
	window.open('../mrn/mrnDetails.php?mrn='+mrn,'mrn')
}

function loadMrnDets(mrn){
	if(mrn==''){
		return false;
	}
	else{
		
		document.getElementById('wasMrn_txtMrnNo').value=mrn;
		var path="../mrnList/mrnList_xml.php?req=loadDets&mrn="+mrn;
		htmlobj=$.ajax({url:path,async:false});

		document.getElementById('wasMrn_cboPOS').value=htmlobj.responseXML.getElementsByTagName('intStyleId')[0].childNodes[0].nodeValue;
		
		document.getElementById('wasMrn_cboStore').value=htmlobj.responseXML.getElementsByTagName('intStore')[0].childNodes[0].nodeValue; 
		document.getElementById('wasMrn_cboDepartment').value=htmlobj.responseXML.getElementsByTagName('intDepartment')[0].childNodes[0].nodeValue;
		document.getElementById('wasMrn_cboColor').innerHTML=htmlobj.responseXML.getElementsByTagName('strColor')[0].childNodes[0].nodeValue; 
		document.getElementById('wasMrn_txtMrnQty').value=htmlobj.responseXML.getElementsByTagName('dblQty')[0].childNodes[0].nodeValue; 	
		if(htmlobj.responseXML.getElementsByTagName('dblBalQty')[0].childNodes[0].nodeValue==0){
			document.getElementById('Save').style.display='none';
		}
		document.getElementById('wasMrn_cboPOS').onchange();
	}
}

function loadReport(mrnNo){

	if(mrnNo=="")
		return false
	else
		window.open('../issueList/rptWasingMRNIssueReport.php?issueNo='+mrnNo,'WASMRN');
}

function getStylewiseOrderNo(obj){
	var path="issueLis_xml.php?req=loadPo&style="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboOrderNo').value=htmlobj.responseXML.getElementsByTagName('StyleId')[0].childNodes[0].nodeValue; 
}

function getStyle(obj){
	var path="issueLis_xml.php?req=loadStyle&po="+URLEncode(obj.value.trim());
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

function loadDet(iNo){
	if(iNo.trim != ''){
		document.getElementById('txtIssueNo').value=iNo;
		var path="../issueList/issueLis_xml.php?req=loadIssueDet&iNo="+iNo;
		htmlobj=$.ajax({url:path,async:false});
		var XMLMrn=htmlobj.responseXML.getElementsByTagName("MRN");
		var XMLQty=htmlobj.responseXML.getElementsByTagName("Qty");
		var XMLRemarks=htmlobj.responseXML.getElementsByTagName("Remarks");
		//alert(XMLMrn[0].childNodes[0].nodeValue);
		
		document.getElementById('cboMrn').value=XMLMrn[0].childNodes[0].nodeValue;
		document.getElementById('cboMrn').onchange();
		document.getElementById('txtIssueQty').value=XMLQty[0].childNodes[0].nodeValue; 
		document.getElementById('wasMrn_txtRemarks').value=XMLRemarks[0].childNodes[0].nodeValue; 
	}
}

function loadDetToEdit(iNo){
	window.open("../issue/issuedetails.php?iNo="+iNo,'Issue');
}