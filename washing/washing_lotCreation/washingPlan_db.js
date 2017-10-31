//js
var gLength=0;
var gLotLength=0;
var pub_planNo = 0;
var pub_batcId = 0;
var boolCheckLot = true;
function savePlan()
{
	var boolcheck = false;
	var tblLot = document.getElementById('tblmid');
	
	if(document.getElementById('txtPlanNo').value != '')
	{
		pub_planNo = document.getElementById('txtPlanNo').value;
	}
	if(document.getElementById('machineLoading_txtTimeIn').value=="")
	{
		alert("Please select a shift.");
		document.getElementById('machineLoading_txtTimeIn').focus();
		return;
	}
	for(var i=0;i<tblLot.rows.length;i++)
	{
		var mRow    = tblLot.rows[i].cells[1].id;
		var lots    = $('#'+mRow).children(i).length;
		if(lots>0)
			boolcheck = true;
	}
	if(!boolcheck)
	{
		alert("No record to save.");
		return;
	}
	var lotPoolLen = $("#lot_StripPool").children(0).length;
	for(var x=0;x<lotPoolLen;x++)
	{
		var poNew = $($("#lot_StripPool").children(x)[x]).attr("id");
		var planQtyNew = $($($("#"+poNew).children(0)).children(0)[10]).text();
		if(planQtyNew=="")
		{
			boolCheckLot = false;	
		}
	}
	if(!boolCheckLot)
	{
		alert("Please plan all the POs in the Lot Pool.");
		return;
	}

	var date   = document.getElementById('wasOther_txtDateS').value.trim();
	var shiftX = document.getElementById('machineLoading_txtTimeIn').value.trim();
	var hPath="washingPlan_db.php?req=saveHeader&date="+date+"&shiftX="+shiftX+"&pub_planNo="+pub_planNo;
	hobj=$.ajax({url:hPath,async:false});	
	var r=hobj.responseText.split('~');
	if(r[0]==1)
	{
		document.getElementById('txtPlanNo').value=r[1];
		var poolLength=$("#lot_StripPool").children().length;
		gLength=poolLength;
		for(var p=0;p<poolLength;p++){
			var po=$($("#lot_StripPool").children(p)[p]).attr("id");
				po	   = po.substr(4,po.length);
			var planQty= $($("#"+po).children(0)[10]).text();
			
			var path="washingPlan_db.php?req=savePOPool&serial="+r[1]+"&po="+po+"&planQty="+planQty+"&date="+date+"&shift="+shiftX;
			htmlobj=$.ajax({url:path,async:false});	
			var res=htmlobj.responseText;
			
			if(res==1){
				gLength=gLength-1;
				if(gLength==0){
					//document.getElementById('txtPlanNo').value=res[1];
					saveMachineAllcatedLots(r[1]);
				}
				
			}
			else{
				alert(res);
				return false;
			}
		}
	}else{
		alert(r[1]);
		return false;
	}
	
}

function saveMachineAllcatedLots(serial)
{
	var LotNo = 0;
	var tbl=document.getElementById('tblmid');
	var len=tbl.rows.length;
	var boolCheck = false;
	for(var i=0;i<len;i++)
	{
		var machine = tbl.rows[i].cells[0].id.split('/')[0];
		var mRow    = tbl.rows[i].cells[1].id;
		var lots    = $('#'+mRow).children(i).length;
		
		gLotLength=lots;
		for(var a=0;a<lots;a++)
		{
			var url     = "washingPlan_db.php?req=saveMachineLotsHeader&serial="+serial+"&pub_batcId="+pub_batcId;
			htmlobj = $.ajax({url:url,async:false});
			var batchId = htmlobj.responseText;
			if(batchId=="error")
			{
				alert("Error in saving process.");
				return;
			}
			
			var node        = $('#'+mRow).children(a)[a];
			var mergeArray  = $(node).attr("alter").split('~');
			var LotNoArray  = $(node).children(0).attr("id").split('/');
			var lotQtyArray = $(node).children(0).attr("alter").split('~');
			var styleIdArry	= $(node).attr("alter").split('~');
			
			if(mergeArray.length==1)
				LotNo 		= $(node).attr("id");
				
			
			for(var x=0;x<mergeArray.length;x++)
			{
				var styleId = styleIdArry[x].split('|')[0];
				var Machine = machine;//$(node).children(a).attr("id");
				var CostNo  = $(node).attr("class").split('~')[x];
				if(LotNoArray.length>1)
					LotNo   = LotNoArray[1];
				var LotQty  = lotQtyArray[x].split('-')[0];
				
				var path="washingPlan_db.php?req=saveMachineLotsDetail&serial="+serial+"&styleId="+styleId+"&Machine="+Machine+"&CostNo="+CostNo+"&LotNo="+LotNo+"&LotQty="+LotQty+"&batchId="+batchId;
		   		htmlobj = $.ajax({url:path,async:false});
				var res = htmlobj.responseText.split('~');
				if(res[0]==1)
				{
					 boolCheck = true;
				}
				else
				{
					alert(res[1]);
					return false;
				}
			}
				
		}
			
					 
	} 
	if(boolCheck==true)
	{
		alert("Save successfully.");
		loadCombo("select concat(intPlanYear,'/',intPlanNo) as PLANID,concat(intPlanYear,'/',intPlanNo) as PLANID from was_planheader order by PLANID DESC","cboSearch");
		return;
	}
}