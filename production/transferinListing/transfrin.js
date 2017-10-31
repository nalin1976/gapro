
$(document).ready(function() 
{
	var url					='transfrin_xml.php?RequestType=loadOrderNo';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#txtOrderNo" ).autocomplete({
		source: pub_po_arr
	});
});

function loadOrderNo(style)
{
	var url					='transfrin_xml.php?RequestType=loadOrderNo&style='+style;
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#txtOrderNo" ).autocomplete({
		source: pub_po_arr
	});
}

