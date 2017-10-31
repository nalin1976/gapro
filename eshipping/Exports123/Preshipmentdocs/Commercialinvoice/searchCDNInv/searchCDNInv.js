
$(document).ready(function() 
{
		$('#btnSearch').click(function()
		{
			load_Inv_grid();				
		});
		
		var url					='searchCDNInvDB.php?request=load_po_no';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtPONo" ).autocomplete({
			source: pub_po_arr
		});
		
		var url1					='searchCDNInvDB.php?request=load_style_no';
		var pub_xml_http_obj1	    =$.ajax({url:url,async:false});
		var pub_style_arr1			=pub_xml_http_obj1.responseText.split("|");
		
		$( "#txtStyleNo" ).autocomplete({
			source: pub_style_arr1
		});
  

});
function del_tbl_reset()
{
	$('#tblPL tr:gt(0)').remove()
}

function load_Inv_grid()
{
	var  invNo			=$('#cmbInv').val();
	var  ponumber		=$('#txtPONo').val();
	var  style			=$('#txtStyleNo').val();
	var  manuId			=$('#cmbManu').val();
	var invoiceType=$('#cmbDocType').val();
	//var  DO				=$('#cmbDO').val();
	//alert(invoiceType);
	del_tbl_reset();	
	pl_fix_header();
	var url				='searchCDNInvDB.php?request=load_inv_grid&invNo='+invNo+'&ponumber='+ponumber+'&invoiceType='+invoiceType+'&style='+style+'&manuId='+manuId;
	var xml_http_obj	=$.ajax({url:url,async:false});
	//alert (xml_http_obj.responseText);
	
	var xml_Inv			=xml_http_obj.responseXML.getElementsByTagName('InvNo');
	var xml_Date		=xml_http_obj.responseXML.getElementsByTagName('InvDate');
	var xml_Style		=xml_http_obj.responseXML.getElementsByTagName('StyleId');
	var xml_Po			=xml_http_obj.responseXML.getElementsByTagName('PoNo');
	var xml_Qty			=xml_http_obj.responseXML.getElementsByTagName('Qty');
	var xml_Ctns 		=xml_http_obj.responseXML.getElementsByTagName('Ctns');
	var xml_Manu 		=xml_http_obj.responseXML.getElementsByTagName('Manu');
	var xml_Dest 		=xml_http_obj.responseXML.getElementsByTagName('Dest');
	var xml_Mode 		=xml_http_obj.responseXML.getElementsByTagName('Mode');
	var xml_Status		=xml_http_obj.responseXML.getElementsByTagName('Status');
	//alert(xml_Inv);
	var tbl				=$('#tblPL tbody')
	for(var r_loop=0; r_loop<xml_Inv.length;r_loop++)
	{
		var lastRow 		= $('#tblPL tbody tr').length;
		var row 			= tbl[0].insertRow(lastRow);
		row.className		='bcgcolor-tblrowWhite';
		
		var rowCell 	  	= row.insertCell(0);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Inv[r_loop].childNodes[0].nodeValue;
		rowCell.height	  	="25"
		
		var rowCell 	  	= row.insertCell(1);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Date[r_loop].childNodes[0].nodeValue;
						
		var rowCell 	  	= row.insertCell(2);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Po[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
		
		var rowCell 	  	= row.insertCell(3);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Style[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(4);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Ctns[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(5);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Qty[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(6);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Manu[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(7);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Dest[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(8);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Mode[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(9);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Status[r_loop].childNodes[0].nodeValue;			
				
	}
	//alert(xml_Status[r_loop].childNodes[0].nodeValue);
	//grid_event_setter();
	pl_fix_header();
}

function grid_event_setter()
{
	$('.btnVW').click(function()
		{
			load_pl_window(this);				
		});
}


function load_pl_window(obj)
{
		var plno=obj.parentNode.parentNode.cells[0].childNodes[0].nodeValue;
		
		window.open("../shipmentpackinglist.php?plno="+plno,"plw");	
}


function pl_fix_header()
{
	$("#tblPL").fixedHeader({
	width: 950,height: 300
	});	
}


function loadDoctype(obj)
{

	var invoiceType=$('#cmbDocType').val();

	 var url		    = 'searchCDNInvDB.php?request=loadDoctype&InvoiceType='+invoiceType;
	 var xml_http_obj   =$.ajax({url:url,async:false});
	//alert(xml_http_obj.responseText);
	document.getElementById('cmbInv').innerHTML=xml_http_obj.responseText;
	

}