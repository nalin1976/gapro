$(document).ready(function(){
	
	$('#btnNew').click(function(){
		location.reload();
		
		})
	$('#btnSave').click(function(){
			var styleid=$("#cmbStyle").val();
			var date=$("#txtCutDate").val();
			var productionProcess=$("#cboProcess").val()
			var url="nonValuedDb.php?request=savedata&styleid="+styleid+'&date='+date+'&productionProcess='+productionProcess;
			var httprequest=$.ajax({url:url,async:false})
			save_detail(httprequest.responseText)
		})
	
	
})

function save_detail(obj)
{
	var cellength=$('#tblLayer tbody tr')[1].cells.length;
	var tblRow=$('#tblLayer tbody tr')[1]
	for(var i=0;i<cellength;i++){
		var id=tblRow.cells[i].childNodes[0].id;
		var qty=tblRow.cells[i].childNodes[0].value;
		if(qty==''||qty==0)
			continue;
		var url="nonValuedDb.php?request=savedetail&id="+id+'&serial='+obj+'&qty='+qty;
		var httprequest=$.ajax({url:url,async:false})
	}
	alert("Saved Successfully.")
}