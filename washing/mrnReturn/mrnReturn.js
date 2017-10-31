///js
///start Load Data
function LoadIssueDetails(obj){
	if(obj.value.trim()==""){
		clearFrom();
		return false;
	}
	else{
		var path='mrnReturn_xml.php?RequestType=loadDets&ino='+obj.value.trim();
		htmlobj=$.ajax({url:path,async:false});
		document.getElementById('cboOrderNo').innerHTML=htmlobj.responseXML.getElementsByTagName('poNo')[0].childNodes[0].nodeValue;
		document.getElementById('cboStyleNo').innerHTML=htmlobj.responseXML.getElementsByTagName('style')[0].childNodes[0].nodeValue;
		document.getElementById('cboColor').innerHTML=htmlobj.responseXML.getElementsByTagName('color')[0].childNodes[0].nodeValue;
		document.getElementById('cboStore').value=htmlobj.responseXML.getElementsByTagName('store')[0].childNodes[0].nodeValue;
		document.getElementById('cboDepartment').value=htmlobj.responseXML.getElementsByTagName('Department')[0].childNodes[0].nodeValue;
		document.getElementById('wasIssue_txtSFactoryS').value=htmlobj.responseXML.getElementsByTagName('SFac')[0].childNodes[0].nodeValue;
		document.getElementById('txtIssueQty').value=htmlobj.responseXML.getElementsByTagName('iQty')[0].childNodes[0].nodeValue;
		document.getElementById('txtOrderQty').value=htmlobj.responseXML.getElementsByTagName('oQty')[0].childNodes[0].nodeValue;
		document.getElementById('txtAvlQty').value=htmlobj.responseXML.getElementsByTagName('aQty')[0].childNodes[0].nodeValue; 
	}
}

//end load Data
//start check balance
function setBalance(obj){
	var IQty=document.getElementById('txtAvlQty').value.trim();
	if( Number(IQty) < Number(obj.value.trim())){
		obj.value=IQty;
		return false;
	}
}
//end check balance

//clear From
function clearFrom(){
	document.getElementById('frmProductionIssueReturn').reset();	
	document.getElementById('cboOrderNo').innerHTML=""; 
	document.getElementById('cboStyleNo').innerHTML=""; 
	document.getElementById('cboColor').innerHTML=""; 
	document.getElementById('Save').style.display='inline';
}

/////////
//Start Save data
function saveData(){
	if(validateForm()){	
		var iNo=document.getElementById('cboIssue').value.trim()
		var store=document.getElementById('cboStore').value.trim();
		var dep=document.getElementById('cboDepartment').value.trim();
		var poNo=document.getElementById('cboOrderNo').value.trim();
		var color=document.getElementById('cboColor').value.trim();
		var qty=document.getElementById('txtRtnQty').value.trim();
		var sFAC=document.getElementById('wasIssue_txtSFactoryS').value.trim();
		var remarks=document.getElementById('wasMrn_txtRemarks').value.trim();
		
		var path='mrnReturn_db.php?RequestType=saveDets&ino='+iNo+'&store='+store+'&dep='+dep+'&poNo='+poNo+'&color='+color+'&sFAC='+sFAC+'&remarks='+remarks+'&qty='+qty;
		htmlobj=$.ajax({url:path,async:false});
		var res=htmlobj.responseXML.getElementsByTagName('R')[0].childNodes[0].nodeValue;
		var RN=htmlobj.responseXML.getElementsByTagName('RN')[0].childNodes[0].nodeValue;
		if(res){
			alert('Successfully saved.');
			document.getElementById('txtRtnSerial').value=RN;
			document.getElementById('Save').style.display='none';
			return false;
		}
		else{
			alert('Saving fail.');
			return false
		}
	}
}

function validateForm(){
	if(document.getElementById('cboIssue').value.trim()==""){
		alert("Please select 'Issue No'.");
		document.getElementById('cboIssue').focus();
		return false;
	}
	if(document.getElementById('txtRtnQty').value.trim()==""){
		alert("Please enter 'Return Qty'.");
		document.getElementById('txtRtnQty').focus();
		return false;
	}
	if(Number(document.getElementById('txtRtnQty').value.trim()) == 0){
		alert("'Return Qty' Not available.");
		document.getElementById('txtRtnQty').focus();
		return false;
	}
	return true;
}
//end save Data

function showReports(){
		var issueNo=document.getElementById('cboIssue').value.trim();
	if(issueNo=="")
		return false
	else
		window.open('../mrnReturnList/rptWasingMRNIssueReturnReport.php?issueNo='+issueNo,'washMrnIssueReturn');
}