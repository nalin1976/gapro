// JavaScript Document
var pl_combo="<select name=\"txtPLNo\"  class=\"txtbox\" style=\"width:148px\" id=\"txtPLNo\"onchange=\"get_pl_header_data()\"  tabindex=\"1\">";
var start_auto_cell =7;
var bool_edit		=0;

$(document).ready(function() 
{
	$('#btnSave').click(function()
		{
			save_pl_header();			
		});
	
	$('#btnPrint').click(function()
		{
			print_pl();			
		});
	
	$('#btnNew').click(function()
		{
			if(bool_edit==1)
				{	
					var pl_ele		=$('#plno_cell').html();	
					$('#plno_cell').html(pl_combo);	
					pl_combo=pl_ele;	
					bool_edit		=0;
				}
			$('#pl_header')[0].reset();							
		});
		
	$('#cmbStyle').change(function()
		{
			load_pl_grid();				
		});
		
	$('#btnView').click(function()
		{		
			if(bool_edit==0)
			{	
				$('#pl_header')[0].reset();
				var pl_ele		=$('#plno_cell').html();	
				$('#plno_cell').html(pl_combo);	
				pl_combo		=pl_ele;	
				loadCombo('SELECT strPLNo, strPLNo FROM shipmentplheader order by strPLNo ASC','txtPLNo');	
				bool_edit		=1;
			}
		
		});

});

function deleterows(tableName)
{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 0 ; loop -- )
		{
		tbl.deleteRow(loop);
		}		

}	

function  pl_validate()
{
	if($('#tblPL tbody tr').length<2)
		return false;
	else
		return true;
}

function save_pl_header()
{
	if(!pl_validate())
	return;
	save_pl_size_index()
	
	var PLNo				=$('#txtPLNo').val();
	var Factory				=$('#cboFactory').val();
	var Style				=$('#cmbStyle').val();
	var CTNS				=$('#txtCTNS').val();
	var ManufactOrderNo		=$('#txtManufactOrderNo').val();
	var ManufactStyle		=$('#txtManufactStyle').val();
	var InvoiceNo			=$('#txtInvoiceNo').val();
	var ProductCode			=$('#txtProductCode').val();
	var Fabric				=$('#txtFabric').val();
	var Lable				=$('#txtLable').val();
	var TotalQty			=$('#txtTotalQty').val();
	var Vessel				=$('#txtVessel').val();
	var SailingDate			=$('#txtSailingDate').val();
	var OrginCountry		=$('#txtOrginCountry').val();
	var Container			=$('#txtContainer').val();
	var Seal				=$('#txtSeal').val();
	var BL					=$('#txtBL').val();
	var Gross				=$('#txtGross').val();
	var Net					=$('#txtNet').val();
	var TotalShipQty		=$('#txtTotalShipQty').val();
	var Cartoon				=$('#txtCartoon').val();
	var LCNO				=$('#txtLCNO').val();
	var Bank				=$('#txtBank').val();
	var SortingType			=$('#txtSortingType').val();
	var PrePackCode			=$('#txtPrePackCode').val();
	var WashCode			=$('#txtWashCode').val();
	var Color				=$('#txtColor').val();
	var Article				=$('#txtArticle').val();
	
	var url					='shipmentpackinglistdb.php?request=save_pl_header&PLNo='+URLEncode(PLNo.trim())+'&Factory='+URLEncode(Factory.trim())+'&Style='+Style+'&CTNS='+CTNS+'&ManufactOrderNo='+ManufactOrderNo+'&ManufactStyle='+ManufactStyle+'&InvoiceNo='+InvoiceNo+'&ProductCode='+ProductCode+'&Fabric='+Fabric+'&Lable='+Lable+'&TotalQty='+TotalQty+'&Vessel='+Vessel+'&SailingDate='+SailingDate+'&OrginCountry='+OrginCountry+'&Container='+Container+'&Seal='+Seal+'&BL='+BL+'&Gross='+Gross+'&Net='+Net+'&TotalShipQty='+TotalShipQty+'&Cartoon='+Cartoon+'&LCNO='+LCNO+'&Bank='+Bank+'&SortingType='+SortingType+'&PrePackCode='+PrePackCode+'&WashCode='+WashCode+'&Color='+Color+'&Article='+Article;
	var xml_http_obj		=$.ajax({url:url,async:false});
	alert("Saved successfully. ");
}


function save_pl_details()
{	
	var row 			= $('#tblPL tbody tr');
	var plno			=$('#txtPLNo').val();
	for(var loop_row=1;loop_row<row.length;loop_row++)
	{
		var ctns_no_from		 =row[loop_row].cells[1].childNodes[0].value;
		var ctns_no_to   		 =row[loop_row].cells[2].childNodes[0].value;
		var color				 =row[loop_row].cells[3].childNodes[0].value;
		var pcs					 =row[loop_row].cells[start_auto_cell].childNodes[0].value;
		var ctns				 =row[loop_row].cells[start_auto_cell+1].childNodes[0].value;
		var qty_pcs				 =row[loop_row].cells[start_auto_cell+2].childNodes[0].value;
		var qty_doz				 =row[loop_row].cells[start_auto_cell+3].childNodes[0].value;
		var gross				 =row[loop_row].cells[start_auto_cell+4].childNodes[0].value;
		var net					 =row[loop_row].cells[start_auto_cell+5].childNodes[0].value;
		var net_net				 =row[loop_row].cells[start_auto_cell+6].childNodes[0].value;
		var tot_gross		 	 =row[loop_row].cells[start_auto_cell+7].childNodes[0].value;
		var tot_net				 =row[loop_row].cells[start_auto_cell+8].childNodes[0].value;
		var tot_net_net			 =row[loop_row].cells[start_auto_cell+9].childNodes[0].value;
		
		if(ctns_no_from=='')
			continue;
		
		var url					 ='shipmentpackinglistdb.php?request=save_pl_details&plno='+plno+'&row_index='+loop_row+'&ctns_no_from='+ctns_no_from+'&ctns_no_to='+ctns_no_to+'&color='+color+'&pcs='+pcs+'&ctns='+ctns+'&qty_pcs='+qty_pcs+'&qty_doz='+qty_doz+'&gross='+gross+'&net='+net+'&net_net='+net_net+'&tot_gross='+tot_gross+'&tot_net='+tot_net+'&tot_net_net='+tot_net_net+'&qty_pcs='+qty_pcs;
		var xml_http_obj		 =$.ajax({url:url,async:false});
	}
}

function save_pl_size_index()
{
	var row 			= $('#tblPL tbody tr')[0];
	var colm_index		=0;
	var plno			=$('#txtPLNo').val();
	for(var loop=4;loop<start_auto_cell;loop++)
	{
		var size				=row.cells[loop].childNodes[0].nodeValue;
		var url					='shipmentpackinglistdb.php?request=save_pl_size_index&size='+size+'&colm_index='+colm_index+'&plno='+plno;
		var xml_http_obj		=$.ajax({url:url,async:false});
		colm_index++;
	}
	save_pl_subdetails()
}

function save_pl_subdetails()
{
	var row 			= $('#tblPL tbody tr');
	var plno			=$('#txtPLNo').val();
	for(var loop_row=1;loop_row<row.length;loop_row++)
	{
		var colm_index		=0;
		for(var loop_col=4;loop_col<start_auto_cell;loop_col++)
		{
			var pcs				=row[loop_row].cells[loop_col].childNodes[0].value;
			var url					='shipmentpackinglistdb.php?request=save_pl_subdetails&pcs='+pcs+'&colm_index='+colm_index+'&plno='+plno+'&row_index='+loop_row;
			var xml_http_obj		=$.ajax({url:url,async:false});
			colm_index++;
		}
	}
	save_pl_details()
}

function load_pl_grid()
{	
	var plno			=$('#txtPLNo').val();
	var style			=$('#cmbStyle').val();
	var url				='shipmentpackinglistdb.php?request=load_pl_grid&style='+style+'&bool_edit='+bool_edit+'&plno='+plno;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_size		=xml_http_obj.responseXML.getElementsByTagName('Size');
	var cell_width		=""+Math.round(90/(xml_size.length+13))+"%"
	var tbl				=$('#tblPL tbody')
	deleterows('tblPL');
	var lastRow 		= $('#tblPL tr').length;	
	var row 			= tbl[0].insertRow(lastRow);										

	row.className 		="mainHeading4";					
	
	var rowCell 		= row.insertCell(0);
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   =' ';
	
	var rowCell 		= row.insertCell(1);
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN # From';
	
	var rowCell 		= row.insertCell(2);
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN # To';
	
	var rowCell			= row.insertCell(3);
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="Color";
	
	for(var loop=4;loop<xml_size.length+4;loop++)
	{						
			
		var rowCell = row.insertCell(loop);
		rowCell.width	  =cell_width;
		rowCell.bgColor	  ='#66CCFF'
		rowCell.innerHTML =xml_size[loop-4].childNodes[0].nodeValue;
	
	}
	start_auto_cell	  =loop;
	var rowCell 	  =row.insertCell(loop);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="# of PCS";
	
	var rowCell 	  =row.insertCell(loop+1);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="# of CTNS";
	
	var rowCell 	  =row.insertCell(loop+2);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="QTY PCS";
	
	var rowCell 	  =row.insertCell(loop+3);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="QTY DOZ";
	
	var rowCell 	  =row.insertCell(loop+4);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Gross";
	
	var rowCell 	  =row.insertCell(loop+5);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net";
	
	var rowCell 	  =row.insertCell(loop+6);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net Net";
	
	var rowCell 	  =row.insertCell(loop+7);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Grs.";
	
	var rowCell 	  =row.insertCell(loop+8);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Net";
	
	var rowCell 	  =row.insertCell(loop+9);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Net Net";
	
	fill_pl_grid_data(0);
			
}

function fill_pl_grid_data(obj)
{
						
	var tbl				=$('#tblPL tbody')
	var lastRow 		= $('#tblPL tbody tr').length;
	if(obj==0)
		var row=0;
	else if(obj.parentNode.parentNode.rowIndex < lastRow-1)
		return;
	var row 			= tbl[0].insertRow(lastRow);		
	row.className 		="bcgcolor-tblrowWhite";
	for(var loop=0;loop<start_auto_cell+10;loop++)
	{	
		switch(loop)
		{	
			case 0:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<img src=\"../images/del.png\"onclick=\"remove_detail_from_grid(this);\"alt=\"del\"width=\"15\"height=\"15\"maxlength=\"15\"/>";;	
			break;
			
			case 3:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox\" style=\"width:150px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case start_auto_cell+9:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\"onblur=\"fill_pl_grid_data(this)\" style=\"width:80px;text-align:right;\"maxlength=\"15\"  />";	
			break;
			
			default	:
			var rowCell = row.insertCell(loop);
			if(loop>0 && loop<3)
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox\" style=\"width:80px;text-align:right;\"maxlength=\"15\"  />";
			
			else if(loop>3 && loop<start_auto_cell)			
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox\" style=\"width:80px;text-align:right;\"maxlength=\"8\"  />";
			
			else if((loop>=start_auto_cell+4 && loop<start_auto_cell+7)	)
				rowCell.innerHTML ="<input type=\"text\"onblur=\"cal_amounts(this)\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" style=\"width:80px;text-align:right;\"maxlength=\"15\"  />";
			
			else
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" style=\"width:80px;text-align:right;\"maxlength=\"15\"  />";
								
			break;
		}
	}	
	$('#tblPL tbody tr')[lastRow].cells[1].childNodes[0].focus();
}

function remove_detail_from_grid(obj)
{	
	var rowindex	=obj.parentNode.parentNode.rowIndex
	if(rowindex<=1)
		return
	$('#tblPL tbody')[0].deleteRow(rowindex);
}



function cal_amounts(obj)
{
	var row			= obj.parentNode.parentNode;
	var ctns		=parseFloat(emty_handle_dbl(row.cells[2].childNodes[0].value))-parseFloat(emty_handle_dbl(row.cells[1].childNodes[0].value))+1;
	ctns			=(ctns<=0?1:ctns);						
	row.cells[start_auto_cell+1].childNodes[0].value		=ctns;	
	var totpcs	=0;
	
	for(var loop=4; loop<start_auto_cell;loop++)
	{	
			totpcs	+=parseFloat(emty_handle_dbl(row.cells[loop].childNodes[0].value))
	}
	
	var totgross	=parseFloat(emty_handle_dbl(row.cells[start_auto_cell+4].childNodes[0].value))*ctns;
	var totnet		=parseFloat(emty_handle_dbl(row.cells[start_auto_cell+5].childNodes[0].value))*ctns;
	var totnetnet	=parseFloat(emty_handle_dbl(row.cells[start_auto_cell+6].childNodes[0].value))*ctns;
	
	row.cells[start_auto_cell].childNodes[0].value			=totpcs;
	row.cells[start_auto_cell+2].childNodes[0].value		=totpcs*ctns.toFixed(2);
	row.cells[start_auto_cell+3].childNodes[0].value		=(totpcs*ctns/12).toFixed(2);
	row.cells[start_auto_cell+7].childNodes[0].value		=totgross.toFixed(2);
	row.cells[start_auto_cell+8].childNodes[0].value		=totnet.toFixed(2);
	row.cells[start_auto_cell+9].childNodes[0].value		=totnetnet.toFixed(2);
}



function emty_handle_dbl(obj)
{
	return (obj==""?0:obj);
}

function emty_handle_str(obj)
{
	return (obj==""?'n/a':obj);
}


function get_pl_header_data()
{
	var plno			=$('#txtPLNo').val();
	var url				='shipmentpackinglistdb.php?request=get_pl_header_data&plno='+plno;
	$.ajax
	({
		url: url,success: function(obj)
		{
			$(obj).find("pldata").each(function()
			{			
				$('#cboFactory').val($(this).find("Factory").text());
				$('#cmbStyle').val($(this).find("Style").text());
				$('#txtCTNS').val($(this).find("CTNS").text());
				$('#txtManufactOrderNo').val($(this).find("ManufactOrderNo").text());
				$('#txtManufactStyle').val($(this).find("ManufactStyle").text());
				$('#txtInvoiceNo').val($(this).find("InvoiceNo").text());
				$('#txtProductCode').val($(this).find("ProductCode").text());
				$('#txtFabric').val($(this).find("Fabric").text());
				$('#txtLable').val($(this).find("Lable").text());
				$('#txtTotalQty').val($(this).find("TotalQty").text());
				$('#txtVessel').val($(this).find("Vessel").text());
				$('#txtSailingDate').val($(this).find("SailingDate").text());
				$('#txtOrginCountry').val($(this).find("OrginCountry").text());
				$('#txtContainer').val($(this).find("Container").text());
				$('#txtSeal').val($(this).find("Seal").text());
				$('#txtBL').val($(this).find("BL").text());
				$('#txtGross').val($(this).find("Gross").text());
				$('#txtNet').val($(this).find("Net").text());
				$('#txtTotalShipQty').val($(this).find("TotalShipQty").text());
				$('#txtCartoon').val($(this).find("Cartoon").text());
				$('#txtLCNO').val($(this).find("LCNO").text());
				$('#txtBank').val($(this).find("Bank").text());
				$('#txtSortingType').val($(this).find("SortingType").text());
				$('#txtPrePackCode').val($(this).find("PrePackCode").text());
				$('#txtWashCode').val($(this).find("WashCode").text());
				$('#txtColor').val($(this).find("Color").text());
				$('#txtArticle').val($(this).find("Article").text());
				load_saved_pl_details()
			});				
		}
	});			
}

function print_pl()
{
	var plno			=$('#txtPLNo').val();
	if(plno=="")
		return; 
	window.open("packinglist_formats/pl_levis_newyork.php?plno="+plno,'pl');
	
}

function load_saved_pl_details()
{
	var plno			=$('#txtPLNo').val();
	var url				='shipmentpackinglistdb.php?request=load_saved_pl_details&plno='+plno;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_size		=xml_http_obj.responseXML.getElementsByTagName('Size');
	var cell_width		=""+Math.round(90/(xml_size.length+13))+"%"
	var tbl				=$('#tblPL tbody')
	deleterows('tblPL');
	var lastRow 		= $('#tblPL tr').length;	
	var row 			= tbl[0].insertRow(lastRow);										

	row.className 		="mainHeading4";					
	
	var rowCell 		= row.insertCell(0);
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   =' ';
	
	var rowCell 		= row.insertCell(1);
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN # From';
	
	var rowCell 		= row.insertCell(2);
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN # To';
	
	var rowCell			= row.insertCell(3);
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="Color";
	
	for(var loop=4;loop<xml_size.length+4;loop++)
	{						
			
		var rowCell = row.insertCell(loop);
		rowCell.width	  =cell_width;
		rowCell.bgColor	  ='#66CCFF'
		rowCell.innerHTML =xml_size[loop-4].childNodes[0].nodeValue;
	
	}
	start_auto_cell	  =loop;
	var rowCell 	  =row.insertCell(loop);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="# of PCS";
	
	var rowCell 	  =row.insertCell(loop+1);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="# of CTNS";
	
	var rowCell 	  =row.insertCell(loop+2);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="QTY PCS";
	
	var rowCell 	  =row.insertCell(loop+3);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="QTY DOZ";
	
	var rowCell 	  =row.insertCell(loop+4);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Gross";
	
	var rowCell 	  =row.insertCell(loop+5);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net";
	
	var rowCell 	  =row.insertCell(loop+6);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net Net";
	
	var rowCell 	  =row.insertCell(loop+7);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Grs.";
	
	var rowCell 	  =row.insertCell(loop+8);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Net";
	
	var rowCell 	  =row.insertCell(loop+9);
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Net Net";
}

function load_saved_pl_data()
{
	var plno			=$('#txtPLNo').val();
	var url				='shipmentpackinglistdb.php?request=load_saved_pl_details&plno='+plno;
}