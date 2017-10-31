//
function loadToEdit(gp){
	window.open('../issuedToOtherFactories/issuedToOther.php?gp='+gp,'gp')
}

/*function loadMrnDets(gp){
	if(mrn==''){
		return false;
	}
	else{
		
		document.getElementById('wasMrn_txtMrnNo').value=gpNo;
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
}*/

function loadReport(gp){

	if(gp=="")
		return false
	else
		window.open('../issuedToOtherFactories/rptOtherFactoryReport.php?req='+gp,'gp');
}

function showListReport(){
	var url='?req=report';
	if(document.getElementById('cboFactory').value.trim()!='')
		url+='&fac='+document.getElementById('cboFactory').value.trim();
	if(document.getElementById('cboOrderNo').value.trim()!='')
		url+='&oNo='+document.getElementById('cboOrderNo').value.trim();
	if(document.getElementById('cboStyle').value.trim()!='')
		url+='&sNo='+document.getElementById('cboStyle').value.trim();
	if(document.getElementById('txtDfrom').value.trim()!='')
		url+='&Dfrom='+document.getElementById('txtDfrom').value.trim();
	if(document.getElementById('txtDto').value.trim()!='')
		url+='&Dto='+document.getElementById('txtDto').value.trim();
	if(document.getElementById('cboReason').value.trim()!='')
		url+='&R='+document.getElementById('cboReason').value.trim();

			
	window.open('listReport.php'+url,'new');
}

function clearForm(){
	document.getElementById('cboFactory').value=""
	document.getElementById('cboOrderNo').value=""
	document.getElementById('cboStyle').value=""
	document.getElementById('txtDfrom').value=""
	document.getElementById('txtDto').value =""
	document.getElementById('cboReason').value =""
	//document.getElementById('frmissuedWashList').reset();
	document.getElementById('frmissuedWashList').submit();
}