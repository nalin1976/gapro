//js
function loadMLData(obj){
	var control="machineLoading_cboPoNo";
	if(obj.value==0){
		var sqls="SELECT distinct orders.intStyleId,orders.strOrderNo FROM orders INNER JOIN was_actualcostheader ON orders.intStyleId=was_actualcostheader.intStyleId WHERE was_actualcostheader.intStatus=1 ORDER BY orders.strStyle;";
		loadCombo(sqls,control);
		
	}
	else{
		var sqls="SELECT distinct was_outsidepo.intId,was_outsidepo.intPoNo FROM was_outsidepo INNER JOIN was_actualcostheader ON was_outsidepo.intId=was_actualcostheader.intStyleId WHERE was_actualcostheader.intStatus=1 ORDER BY was_outsidepo.intPoNo;";
		loadCombo(sqls,control);
	}
}

function loadLoatNumber(obj){
 var po=document.getElementById('machineLoading_cboPoNo').value.trim();
 var costId=document.getElementById('machineLoading_cboCostId').value.trim();
 var mcnCat=document.getElementById('machineLoading_cboMachineType').value.trim();
 var mcnID=obj.value.trim();
 
 var path="machineLoading-xml.php?id=loadLotNumber&po="+po+"&costId="+costId+"&mcnCat="+mcnCat+"&mcnID="+mcnID;
 htmlobj=$.ajax({url:path,async:false});
 var XMLLotNo=htmlobj.responseXML.getElementsByTagName('LotNo');
 if(XMLLotNo.length>0){
 	document.getElementById('machineLoading_txtLotNo').value=XMLLotNo[0].childNodes[0].nodeValue;
 }
 else{
	 document.getElementById('machineLoading_txtLotNo').value=1;
	}
	
}