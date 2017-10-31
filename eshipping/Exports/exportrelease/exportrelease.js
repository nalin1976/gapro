$(document).ready(function(){
	
	$('#btnNew').click(function(){
		$('.txtbox').val('')
	})	
	
	$('#btnSave').click(function(){
		save_export_release()
	})
	
	$('#cboInvoiceNo').change(function(){
		
		get_preshipment_data()
		
	});		
})


function get_preshipment_data()
{
	var invoiceno		  =$('#cboInvoiceNo').val();
	var url				  ='exportreleasedb.php?request=get_preshipment_data&invoiceno='+invoiceno;
	var xml_http_obj	  =$.ajax({url:url,async:false});
	
	$('#txtEntry').val(xml_http_obj.responseXML.getElementsByTagName('EntryNo')[0].childNodes[0].nodeValue);
	$('#txtShippedQty').val(xml_http_obj.responseXML.getElementsByTagName('ShippedQty')[0].childNodes[0].nodeValue);
	$('#txtDate').val(xml_http_obj.responseXML.getElementsByTagName('Date')[0].childNodes[0].nodeValue);
	$('#txtPlannedQty').val(xml_http_obj.responseXML.getElementsByTagName('palnnedQuantity')[0].childNodes[0].nodeValue);
	$('#txtRemarks').val(xml_http_obj.responseXML.getElementsByTagName('Remarks')[0].childNodes[0].nodeValue);
}

function save_export_release()
{
	var invoiceno		  =$('#cboInvoiceNo').val();
	var ShippedQty		  =$('#txtShippedQty').val();
	var Remarks			  =$('#txtRemarks').val();
	var release_Date 	  =$('#txtDate').val();
	var EntryNo			  =$('#txtEntry').val();

	var url				  ='exportreleasedb.php?request=save_export_release&invoiceno='+invoiceno+'&ShippedQty='+ShippedQty+'&Remarks='+Remarks+'&release_Date='+release_Date+'&EntryNo='+EntryNo;
	var xml_http_obj	  =$.ajax({url:url,async:false});
	if(xml_http_obj.responseText=='saved')
	{
		alert("Saved successfully.")
	}
}