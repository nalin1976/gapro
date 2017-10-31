//js

function clearFrom(){
	document.getElementById('frmWetQc').reset();
}
function getEpfNoDet(obj){
	var path="qc_finish_xml.php?req=getOpDet&opId="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	
	document.getElementById('txtEpfNo').value=htmlobj.responseXML.getElementsByTagName("EpfNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboShift').value=htmlobj.responseXML.getElementsByTagName("Shift")[0].childNodes[0].nodeValue;
}

function getColor(obj){
	var path="qc_finish_xml.php?req=getColorDet&poNo="+obj.value.trim();
	htmlObj=$.ajax({url:path,async:false});
	document.getElementById('txtColor').value=htmlObj.responseXML.getElementsByTagName("Color")[0].childNodes[0].nodeValue;
	document.getElementById('cboSewingFactory').value=htmlObj.responseXML.getElementsByTagName("FromFactory")[0].childNodes[0].nodeValue; 
}

function setBalance(obj){		
	var chkQty = document.getElementById('CheckedQty').value.trim();
	var dmgQty = document.getElementById('DamagedQty').value.trim();
	if(parseInt(dmgQty) > parseInt(chkQty)){
		document.getElementById('DamagedQty').value=parseInt(chkQty);
		document.getElementById('CheckFinishQty').value=0;
		return false;
	}
	else
		document.getElementById('CheckFinishQty').value=parseInt(chkQty)-parseInt(dmgQty);
		
	if(isNaN(document.getElementById('CheckFinishQty').value))
	{
		document.getElementById('CheckFinishQty').value=0;
	}
}

function saveCheckFinish(){
	if(validateForm()){
		var poNo= document.getElementById('cboOrderNo').value.trim();
		var lineRec=document.getElementById('cboLineRecoder').value.trim();
		var color=URLEncode(document.getElementById('txtColor').value.trim());
		var SewingFac=document.getElementById('cboSewingFactory').value.trim();
		var epfNo=document.getElementById('txtEpfNo').value.trim();
		var Shift=document.getElementById('cboShift').value.trim();
		var chkQty=document.getElementById('CheckedQty').value.trim();
		var dmgQty=document.getElementById('DamagedQty').value.trim();
		
		var path="qc_finish_db.php?req=saveDet&poNo="+poNo+"&lineRec="+lineRec+"&color="+color+"&SewingFac="+SewingFac+"&epfNo="+epfNo+"&Shift="+Shift+"&chkQty="+chkQty+"&dmgQty="+dmgQty;
		htmlObj=$.ajax({url:path,async:false});
		if(htmlObj.responseText==2){
			if(confirm("Do you want to update 'QC Details.' ")){
				
			}	
		}
		
	}
}

function validateForm(){
	if(document.getElementById('cboOrderNo').value.trim()==''){
		alert("Please select 'Order No'.");
		document.getElementById('cboOrderNo').focus();
		return false;	
	}
	if(document.getElementById('cboLineRecoder').value.trim()==''){
		alert("Please select 'Line Recoder'.");
		document.getElementById('cboLineRecoder').focus();
		return false;
	}
	if(document.getElementById('CheckedQty').value.trim()==''){
		alert("Please enter 'Checked Qty'.");
		document.getElementById('CheckedQty').focus();
		return false;
	}
	if(document.getElementById('DamagedQty').value.trim()==''){
		alert("Please enter 'Damaged Qty'.");
		document.getElementById('DamagedQty').focus();
		return false;
	}
	return true;
}