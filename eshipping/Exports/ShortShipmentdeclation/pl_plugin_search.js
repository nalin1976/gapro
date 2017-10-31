




/*$(document).ready(function() 
{
		$('#btnSearch').click(function()
		{
			
			load_pl_grid();				
		});
		
		var url					='pl_plugin_search_db.php?request=load_po_str';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtPONo" ).autocomplete({
			source: pub_po_arr
		});

  

});*/

function loadCBO()
{
	var url					='pl_plugin_search_db.php?request=load_po_str';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtPONo" ).autocomplete({
			source: pub_po_arr
		});
}

function clickBtn()
{
	load_pl_grid();	
}

function del_tbl_reset()
{
	$('#tblPL tr:gt(0)').remove()
}

function load_pl_grid()
{
	
	var  plno			=$('#cmbPL').val();
	var  ponumber		=$('#txtPONo').val();
	var  style			=$('#cmbStyle').val();
	var  ISD			=$('#cmbISD').val();
	var  DO				=$('#cmbDO').val();
	del_tbl_reset();	
	pl_fix_header();
	var url				='pl_plugin_search_db.php?request=load_pl_grid&plno='+plno+'&ponumber='+ponumber+'&style='+style+'&ISD='+ISD+'&DO='+DO;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_pl			=xml_http_obj.responseXML.getElementsByTagName('PLNo');
	var xml_pldate		=xml_http_obj.responseXML.getElementsByTagName('pldate');
	var xml_po			=xml_http_obj.responseXML.getElementsByTagName('po');
	var xml_style		=xml_http_obj.responseXML.getElementsByTagName('ProductCode');
	var xml_isd			=xml_http_obj.responseXML.getElementsByTagName('ISDno');
	var xml_do 			=xml_http_obj.responseXML.getElementsByTagName('DO');
	var xml_Fabric 		=xml_http_obj.responseXML.getElementsByTagName('Fabric');
	var xml_Item 		=xml_http_obj.responseXML.getElementsByTagName('Item');
	
	var tbl				=$('#tblPL tbody')
	for(var r_loop=0; r_loop<xml_pl.length;r_loop++)
	{
		var lastRow 		= $('#tblPL tbody tr').length;
		var row 			= tbl[0].insertRow(lastRow);
		row.className		='bcgcolor-tblrowWhite';
		
		var rowCell 	  	= row.insertCell(0);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	= "<input type='radio' name='rdo1' onclick='setPL(this)'/>";
		rowCell.height	  	="25"
		
		var rowCell 	  	= row.insertCell(1);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_pl[r_loop].childNodes[0].nodeValue;
		rowCell.height	  	="25"
		
		var rowCell 	  	= row.insertCell(2);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_pldate[r_loop].childNodes[0].nodeValue;
						
		var rowCell 	  	= row.insertCell(3);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_po[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
		
		var rowCell 	  	= row.insertCell(4);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_style[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(5);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_isd[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(6);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_do[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(7);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Item[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(8);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Fabric[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(9);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	="<a href='../../shipmentpackinglist/shipmentpackinglist.php?plno="+xml_pl[r_loop].childNodes[0].nodeValue+"' target='_balnk'><img class=\"noborderforlink\" tabindex=\"26\" src=\"../../images/view.png\"  id=\"btnView\" /></a>";		
				
	}
	
	//grid_event_setter();
	pl_fix_header();
}

/*function grid_event_setter()
{
	$('.btnVW').click(function()
		{
			load_pl_window(this);				
		});
}*/

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

