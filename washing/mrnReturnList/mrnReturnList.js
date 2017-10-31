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

function showReports(obj){
		var issueNo=obj.parentNode.parentNode.cells[1].innerHTML;
		window.open('../mrnReturnList/rptWasingMRNIssueReturnReport.php?issueNo='+issueNo,'washMrnIssueReturn');
}

function getStylewiseOrderNo(obj){
	var path="mrnReturnList_xml.php?req=loadPo&style="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboOrderNo').value=htmlobj.responseXML.getElementsByTagName('StyleId')[0].childNodes[0].nodeValue; 
}

function getStyle(obj){
	var path="mrnReturnList_xml.php?req=loadStyle&po="+URLEncode(obj.value.trim());
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