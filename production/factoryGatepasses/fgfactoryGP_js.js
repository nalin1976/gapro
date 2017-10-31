//03-08-2011-wtc-lasantha
var msgNo=0;
function cancelGatepass(){
var gpNo=document.getElementById('txtGPass').value.trim();	
var gpYear=document.getElementById('txtSearchYear').value.trim();
if(confirm("Do you want to cancel GatePass No:-"+gpYear+'/'+gpNo+".")){
	var cancelReason = prompt("Please Enter 'Gatepass Cancel Reason.'");
		if(cancelReason==null){//cancel=null
			return false	
		}
		else{
			var path="fgfactoryGP_db.php?req=cancelGatePass&gpNo="+gpNo+"&gpYear="+gpYear+"&cancelReason="+cancelReason;
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
					
					var pathDet="fgfactoryGP_db.php?req=cancelGatePassDet&gpNo="+gpNo+"&gpYear="+gpYear+"&bundleNo="+bundleNo+"&cutBundleSerial="+cutBundleSerial+"&qty="+qty;
					htmlObj_det=$.ajax({url:pathDet,async:false});
					msgNo=msgNo+parseInt(htmlObj_det.responseText);
					
				}
				if(msgNo==(tblRowsLength-1))
				{
					alert("GatePass No:-"+gpYear+'/'+gpNo+" Canceled successfully.");
					document.getElementById('btnCancel').style.display='none';				
					
					return false;
				}
			}
		}
	}
}