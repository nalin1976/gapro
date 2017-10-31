//
function loadToEdit(Serial){
	//window.open('../issuedToOtherFactories/mrnDetails.php?gp='+gp,'gp')
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

function loadReport(Serial){

	if(Serial=="")
		return false
	else
		window.open('../rcvFromOtherFactories/rptrvcdToOther.php?req='+Serial,'gpRcvd');
}