//lasantha-09-07-2011
//to auto arange the grid Values

var checkAllShadeGrid=0;
var msgNo=0;

function autoArrangeQtys(obj){
	var tblSG=document.getElementById('tblMainInvGrid').tBodies[0];
	var lenSG=tblSG.rows.length;
	
	var sVal=obj.parentNode.parentNode.cells[3].childNodes[0].value.trim();
	var pr=obj.parentNode.parentNode;	
	var bundleNo=pr.cells[2].id.split('~');	
	var bundleSerial=pr.cells[1].id.split('~');	
	var rVal=sVal;
	var tbl=document.getElementById('tblSecond');
	
	if(obj.checked){
		
		for(var i=1;i<tbl.rows.length;i++){
			var bS=tbl.rows[i].cells[8].childNodes[0].value.trim();
			var bN=tbl.rows[i].cells[2].id.trim();
			for(var a=0;a<bundleNo.length;a++){
				if(bS==bundleSerial[a] && bN==bundleNo[a]){
					var cVal=tbl.rows[i].cells[5].id;
					if(Number(rVal) >= Number(cVal)){
						tbl.rows[i].cells[6].childNodes[0].value=cVal;
						tbl.rows[i].cells[7].childNodes[0].checked=true;
						rVal=rVal-cVal;
					}
					else{
						if(rVal <= 0){
					 		tbl.rows[i].cells[6].childNodes[0].value=0;
					 		tbl.rows[i].cells[7].childNodes[0].checked=false;
					 	}
						else{
					    	tbl.rows[i].cells[6].childNodes[0].value=rVal;
					    	tbl.rows[i].cells[7].childNodes[0].checked=true;
					 		rVal=rVal-cVal;
						}
					}
					 
				}
			}
		}
		/*checkAllShadeGrid++;
		if(checkAllShadeGrid==lenSG){
			document.getElementById('chkSG').checked=true;
			checkAllShadeGrid=0;
		}*/	
	}
	else{
		for(var i=1;i<tbl.rows.length;i++){
			var bS=tbl.rows[i].cells[8].childNodes[0].value.trim();
			var bN=tbl.rows[i].cells[2].id.trim();
			for(var a=0;a<bundleNo.length;a++){
				if(bS==bundleSerial[a] && bN==bundleNo[a]){
					tbl.rows[i].cells[6].childNodes[0].value=tbl.rows[i].cells[5].id;
					tbl.rows[i].cells[7].childNodes[0].checked=false;
				}
			}	
		}
		document.getElementById('chkSG').checked=false;
	}
	getTotQty();
	
}

function changeGPValue(obj){
		
	var pr=obj.parentNode.parentNode;
	
	pr.cells[4].childNodes[0].click();
	pr.cells[4].childNodes[0].checked=false;
	
	var val=Number(pr.cells[2].innerHTML);
	if(val < obj.value){
		obj.value=pr.cells[2].innerHTML;
		pr.cells[4].childNodes[0].click();
		pr.cells[4].childNodes[0].checked=true;
		return false;
	}
	if((obj.value!=0) && (val >= obj.value)){
		pr.cells[4].childNodes[0].click();
		pr.cells[4].childNodes[0].checked=true;	
	}
}

function checkAllShadeInvCols(obj){
	var tbl=document.getElementById('tblMainInvGrid');
	var len=tbl.rows.length;
	if(obj.checked){
		for(var i=1;i<len;i++){
			tbl.rows[i].cells[4].childNodes[0].click();
			tbl.rows[i].cells[4].childNodes[0].checked=true;	
		}
	}
	else{
		for(var i=1;i<len;i++){
			tbl.rows[i].cells[4].childNodes[0].click();
			tbl.rows[i].cells[4].childNodes[0].checked=false;	
		}
	}
}

/*var totGPQty=document.getElementById('txtTotGpQty').value.trim();
	var avlQty=document.getElementById('txtAvlQty').value.trim();
	if(totGPQty>avlQty){
		obj.value=0;
	}*/
	
function cancelGP(){
	var gpNo=document.getElementById('txtGPass').value.trim();
	var gpYear=document.getElementById('txtSearchYear').value.trim();
	
	
	if(confirm("Do you want to cancel GatePass No:-"+gpYear+'/'+gpNo+".")){
	var cancelReason = prompt("Please Enter 'Gatepass Cancel Reason.'");
		if(cancelReason==null){//cancel=null
			return false	
		}
		else{
			var path="db.php?RequestType=cancelGP&gpYear="+gpYear+"&gpNo="+gpNo+"&cancelReason="+cancelReason;
			htmlObj=$.ajax({url:path,async:false});
			
			if(htmlObj.responseText==1)	{
				var tbl				=	document.getElementById('tblSecond');
				var tblRowsLength	=	tbl.rows.length;
				var gpNo=document.getElementById('txtGPass').value.trim();	
				var gpYear=document.getElementById('txtSearchYear').value.trim();
	
				for(var i=1;i<tblRowsLength;i++){
					var bundleNo 		= tbl.rows[i].cells[2].id;
					var cutBundleSerial = tbl.rows[i].cells[8].childNodes[0].value;
					var qty				= tbl.rows[i].cells[6].childNodes[0].value;
					
					var pathDet="db.php?RequestType=cancelGatePassDet&gpNo="+gpNo+"&gpYear="+gpYear+"&bundleNo="+bundleNo+"&cutBundleSerial="+cutBundleSerial+"&qty="+qty;
					htmlObj_det=$.ajax({url:pathDet,async:false});
					msgNo=msgNo+parseInt(htmlObj_det.responseText);
					
				}
				if(msgNo==(tblRowsLength-1))
				{
					alert("GatePass No:-"+gpYear+'/'+gpNo+" Canceled successfully.");
					document.getElementById('btnCancel').style.display='none';				
					document.getElementById('btnConfirm').style.display='none';	
					document.getElementById('btnRpt').style.display='inline';	
					return false;
				}
			}
		}
	}
}	


function loadGPNoDetail(obj){
	var path='fg_xml.php?req=loadGPDets&gp='+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLFComCode= htmlobj.responseXML.getElementsByTagName('FComCode');
	var XMLPO	   = htmlobj.responseXML.getElementsByTagName('PO');
	//document.getElementById('cboToFactory').value=XMLFComCode[0].childNodes[0].nodeValue;
	document.getElementById('cboPoNo').value=XMLPO[0].childNodes[0].nodeValue;
	document.getElementById('cboStyle').value=XMLPO[0].childNodes[0].nodeValue;
	document.getElementById('cboPoNo').onchange();
	
}