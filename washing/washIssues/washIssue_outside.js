function loadIFData(obj){
	clearFields();
	var control="washIssue_cboPoNo";
	if(obj.value==0){
		var sqls="SELECT distinct orders.intStyleId,orders.strOrderNo FROM orders INNER JOIN was_actualcostheader ON orders.intStyleId=was_actualcostheader.intStyleId WHERE was_actualcostheader.intStatus=1 ORDER BY orders.strStyle;";
		loadCombo(sqls,control);
		
	}
	else{
		var sqls="SELECT DISTINCT was_outsidepo.intId,was_outsidepo.intPONo FROM was_machineloadingheader AS ws Inner Join was_outsidepo ON was_outsidepo.intId = ws.intStyleId WHERE ws.intStatus =1 ORDER BY was_outsidepo.intPONo;";
		loadCombo(sqls,control);
	}
}

function clearFields(){
	document.getElementById('washIssue_txtIssueNo').value="";
	document.getElementById('washIssue_date').value="";
	document.getElementById('washIssue_cboPoNo').innerHTML="";
	document.getElementById('washIssue_txtColor').innerHTML="";
	document.getElementById('washIssue_txtDivision').value="";
	document.getElementById('washIssue_txtFactory').value="";
	document.getElementById('washIssue_txtStyle').value="";
	document.getElementById('washIssue_txtPoQty').value="";
	document.getElementById('washIssue_txtReceiveQty').value="";
	document.getElementById('washIssue_txtWashQty').value="";
	document.getElementById('washIssue_txtIssueQty').value="";
}