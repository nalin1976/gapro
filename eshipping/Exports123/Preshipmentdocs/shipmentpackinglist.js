// JavaScript Document
var prew_length	="";
var prew_color	="";
var ctn_wt		="";
var prew_ctn_no	=0;
var pub_ratio	=[];
var pub_ratio_wt=[];
var pl_combo	="<select name=\"txtPLNo\"  class=\"txtbox\" style=\"width:148px\" id=\"txtPLNo\"onchange=\"get_pl_header_data()\"  tabindex=\"1\">";
var pl_textbx="<input name=\"txtPLNo\"  type=\"text\" class=\"txtbox\" id=\"txtPLNo\" tabindex=\"1\" style=\"width:146px\" disabled=\"disabled\" />";
var start_auto_cell =7;
var bool_edit		=0;
var menu_rowindex	=0;
var start_sizes		=8
///////////////////////////////////////

/*var pub_col = 10; //number of 'cells' in a row
var current;
var next;
document.onkeydown = check;
function check(e){
	alert(this.parentNode.parentNode.rowIndex);
	return;
	if (!e) var e = window.event;
		(e.keyCode) ? key = e.keyCode : key = e.which;
	var num = document.getElementById("tblPL").getElementsByTagName("input").length;
	
		switch(key){
			case 37: next = current - 1; break; 		//left
			case 38: next = current - pub_col; break; 		//up
			case 39: next = (1*current) + 1; break; 	//right
			case 40: next = (1*current) + pub_col; break; 	//down
		}
		if (key==37|key==38|key==39|key==40){
			/* Submit etc.
			var code=document.getElementById("tblPL").elements['c' + current].value;
			//if(code!=""){alert(code);}
			document.getElementById("tblPL").elements['c' + next].focus();
			current = next;
		}		
	
}*/
////////////////////////////////////////////

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
			window.location.href="shipmentpackinglist.php";
								
		});
		
		$('#cmbStyle').change(function()
		{
			load_pl_grid();				
		});
		
		$('#btnView').click(function()
		{		
			view_pl();
		
		});
		
		$('#insert_above').click(function()
		{
			insert_row(menu_rowindex);			
		});
		
		$('#insert_bellow').click(function()
		{
			insert_row(menu_rowindex+1);			
		});
		
		$('#auto_cal_ctns').click(function()
		{
			auto_cal_ctns();			
		});
		
		$('#auto_cal_weight').click(function()
		{
			auto_cal_weight();			
		});
		
		$('#del_rows').click(function()
		{
			$("#grid_menu").hide();
			remove_detail_from_grid(menu_rowindex);	
		});
		
		$('#btn_save_as').click(function()
		{
				if(confirm("Are you sure you want to save?"))
				{
					$('#plno_cell').html(pl_textbx);	
					save_pl_header();
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
	/*if($('#txtPLNo').val()=="")
	{
		alert("Please enter the PL number.");
		$('#txtPLNo').select();
		return false;
		
	}*/
	if($('#tblPL tbody tr').length<1)
		return false;
	
	else if($('#tblPL tbody tr')[0].cells[1].childNodes[0].value==""||$('#tblPL tbody tr')[0].cells[2].childNodes[0].value=="")
		return false;
	
	else
		return true;
}

function save_pl_header()
{
		if($('#txtUnit').val()=="")
	{
		alert("Please select the unit.");
		$('#txtUnit').focus();
		return;
		
	}
	
	if(!pl_validate())
	{
		alert("Sorry, there is no record to save.")
		return;
	}
	showPleaseWait();
	
	var PLNo				=$('#txtPLNo').val();
	var SailingDate			=$('#txtSailingDate').val();
	var Style				=$('#cmbStyle').val();
	var ProductCode			=$('#txtProductCode').val();
	var material			=$('#txtMaterialNo').val();
	var Fabric				=$('#txtFabric').val();
	var Lable				=$('#txtLable').val();
	var Color				=$('#txtColor').val();
	var isdno				=$('#txtISD').val();
	var PrePackCode			=$('#txtPrePackCode').val();
	var season				=$('#txtSeason').val();
	var division			=$('#txtDivision').val();
	var ctnsvolume			=$('#txtCTNS').val();
	var WashCode			=$('#txtWashCode').val();
	var Article				=$('#txtArticle').val();
	var CBM					=$('#txtCBM').val();
	var ItemNo				=$('#txtItemNo').val();
	var Item				=$('#txtItem').val();
	var ManufactOrderNo		=$('#txtManufactOrderNo').val();
	var ManufactStyle		=$('#txtManufactStyle').val();
	var DO					=$('#txtDO').val();
	var SortingType			=$('#txtSortingType').val();
	var Factory				=$('#cboFactory').val();
	var Unit				=$('#txtUnit').val();
	var container			=$('#txtContainer').val();
	var trnsmode			=$('#cboTransMode').val();
	var destination			=$('#cboDestination').val();
	var dc					=$('#txtDC').val();
	
	
	var url					='shipmentpackinglistdb.php?request=save_pl_header&PLNo='+URLEncode(PLNo.trim())+'&SailingDate='+SailingDate+'&Style='+URLEncode(Style)+'&ProductCode='+URLEncode(ProductCode)+'&material='+URLEncode(material)+'&Fabric='+URLEncode(Fabric)+'&Lable='+URLEncode(Lable)+'&Color='+URLEncode(Color)+'&isdno='+URLEncode(isdno)+'&PrePackCode='+URLEncode(PrePackCode)+'&season='+URLEncode(season)+'&division='+URLEncode(division)+'&ctnsvolume='+URLEncode(ctnsvolume)+'&WashCode='+URLEncode(WashCode)+'&Article='+URLEncode(Article)+'&CBM='+URLEncode(CBM)+'&ItemNo='+URLEncode(ItemNo)+'&Item='+URLEncode(Item)+'&ManufactOrderNo='+URLEncode(ManufactOrderNo)+'&ManufactStyle='+URLEncode(ManufactStyle)+'&DO='+URLEncode(DO)+'&Factory='+Factory+'&SortingType='+URLEncode(SortingType)+'&Unit='+Unit+'&container='+container+'&trnsmode='+URLEncode(trnsmode)+'&destination='+destination+'&dc='+URLEncode(dc);
	var xml_http_obj		=$.ajax({url:url,async:false});
	if(xml_http_obj.responseText!='fail')
	{
		$('#plno_cell').html(pl_textbx);
		$('#txtPLNo').val(xml_http_obj.responseText)
		save_pl_size_index();
	}
	
	else
	{
		alert("Sorry, please try again later.");
		hideBackGroundBalck();
	}
	
}


function save_pl_details()
{	
	var row 			= $('#tblPL tbody tr');
	var plno			=$('#txtPLNo').val();
	var row_count		=1;
	for(var loop_row=0;loop_row<row.length;loop_row++)
	{
		
		var ctns_no_from		 =row[loop_row].cells[1].childNodes[0].value;
		var ctns_no_to   		 =row[loop_row].cells[2].childNodes[0].value;
		var CTNWeight			 =URLEncode(row[loop_row].cells[3].childNodes[0].value);
		var tag_no				 =URLEncode(row[loop_row].cells[4].childNodes[0].value);
		var shade				 =URLEncode(row[loop_row].cells[5].childNodes[0].value);
		var color				 =URLEncode(row[loop_row].cells[6].childNodes[0].value);
		var lengths				 =URLEncode(row[loop_row].cells[7].childNodes[0].value);
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
		if(ctns_no_from==''||ctns_no_to==''){ 
			continue;}
			
			var colm_index		=0;
		for(var loop_col=start_sizes;loop_col<start_auto_cell;loop_col++)
		{
			var size_pcs					=row[loop_row].cells[loop_col].childNodes[0].value;
			if(size_pcs!=""||size_pcs!=0){
				
			var url					='shipmentpackinglistdb.php?request=save_pl_subdetails&pcs='+size_pcs+'&colm_index='+colm_index+'&plno='+plno+'&row_index='+row_count;
			var xml_http_obj		=$.ajax({url:url,async:false});}
			colm_index++;
		}
		
		var url					 ='shipmentpackinglistdb.php?request=save_pl_details&plno='+plno+'&row_index='+row_count+'&ctns_no_from='+ctns_no_from+'&ctns_no_to='+ctns_no_to+'&shade='+shade+'&color='+color+'&lengths='+lengths+'&pcs='+pcs+'&ctns='+ctns+'&qty_pcs='+qty_pcs+'&qty_doz='+qty_doz+'&gross='+gross+'&net='+net+'&net_net='+net_net+'&tot_gross='+tot_gross+'&tot_net='+tot_net+'&tot_net_net='+tot_net_net+'&qty_pcs='+qty_pcs+'&tag_no='+tag_no+'&CTNWeight='+CTNWeight;
		var xml_http_obj		 =$.ajax({url:url,async:false});
		row_count++;
	}
	alert("Saved successfully.");
	hidePleaseWait();
}

function save_pl_size_index()
{
	var row 			= $('#tblPL thead tr')[0];
	var colm_index		=0;
	var plno			=$('#txtPLNo').val();
	var Style			=$('#cmbStyle').val();
	for(var loop=start_sizes;loop<start_auto_cell;loop++)
	{
		var size				=row.cells[loop].childNodes[0].nodeValue;
		var url					='shipmentpackinglistdb.php?request=save_pl_size_index&size='+size+'&colm_index='+colm_index+'&plno='+plno+'&Style='+Style;
		var xml_http_obj		=$.ajax({url:url,async:false});
		colm_index++;
	}
	save_pl_details()
}

/*function save_pl_subdetails()
{
	var row 			= $('#tblPL tbody tr');
	var plno			=$('#txtPLNo').val();
	for(var loop_row=1;loop_row<row.length;loop_row++)
	{
		var colm_index		=0;
		for(var loop_col=6;loop_col<start_auto_cell;loop_col++)
		{
			var pcs					=row[loop_row].cells[loop_col].childNodes[0].value;
			if(pcs!=""||pcs!=0){
				
			var url					='shipmentpackinglistdb.php?request=save_pl_subdetails&pcs='+pcs+'&colm_index='+colm_index+'&plno='+plno+'&row_index='+loop_row;
			var xml_http_obj		=$.ajax({url:url,async:false});}
			colm_index++;
		}
	}
	save_pl_details()
}*/

function load_pl_grid()
{	
	var plno			=$('#txtPLNo').val();
	var style			=$('#cmbStyle').val();
	var url				='shipmentpackinglistdb.php?request=load_pl_grid&style='+style+'&bool_edit='+bool_edit+'&plno='+plno;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_size		=xml_http_obj.responseXML.getElementsByTagName('Size');
	var xml_net_wt		=xml_http_obj.responseXML.getElementsByTagName('Net');
	var cell_width		=""+Math.round(90/(xml_size.length+13))+"%"
	var tbl				=$('#tblPL')
	pub_ratio_wt=[];
	deleterows('tblPL');
	var row_thead 		=document.createElement("thead");
	tbl[0].appendChild(row_thead);
	var tbl				=$('#tblPL thead')
	var lastRow 		= $('#tblPL thead tr').length;	
	var row 			= tbl[0].insertRow(lastRow);										

	row.className 		="normaltxtmidb2";	
	row.bgColor			="#498CC2";					
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='#';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN_F.';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN_To';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN WT';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='TAG#';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="SH";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="Color";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="Length";
	row.appendChild(rowCell);
	
	for(var loop=start_sizes;loop<xml_size.length+start_sizes;loop++)
	{						
			
		var rowCell 		=document.createElement("th");
		rowCell.width	  	=cell_width;
		rowCell.bgColor	  	='#020061'
		rowCell.innerHTML 	=xml_size[loop-start_sizes].childNodes[0].nodeValue;
		pub_ratio[loop]		=xml_size[loop-start_sizes].childNodes[0].nodeValue;
		pub_ratio_wt[loop-start_sizes]=xml_net_wt[loop-start_sizes].childNodes[0].nodeValue
		row.appendChild(rowCell);
	}
	start_auto_cell	  =loop;
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="#PCS";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="#CTNS";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="QTY";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="DOZ";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Gross";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net Net";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Grs.";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Net";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot N.N.";
	row.appendChild(rowCell);
		
	fill_pl_grid_data(0);
	pl_fix_header()			
}

function fill_pl_grid_data(obj)
{
	var tbl				=$('#tblPL tbody')
	var lastRow 		= $('#tblPL tbody tr').length;
	if(obj==0)
		var row=0;
	else if(obj< lastRow)
		return;
	var row 			= tbl[0].insertRow(lastRow);		
	row.className		='trclass';
	pub_col=start_auto_cell+10;
	for(var loop=0;loop<start_auto_cell+10;loop++)
	{	
		switch(loop)
		{	
			case 0:			
			var rowCell = row.insertCell(loop);
			rowCell.className = "normalfnt_num";
			rowCell.innerHTML =lastRow+1;	
			break;
			
			case 3:	
			case 4:		
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 5:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:50px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 6:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 7:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case start_auto_cell+9:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox lastcellz keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";	
			break;
			
			default	:
			var rowCell = row.insertCell(loop);
			if(loop>0 && loop<3)
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";
			
			else if(loop>7 && loop<start_auto_cell)			
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox keymove \" style=\"width:50px;text-align:right;background-color:#C2E2B8\"maxlength=\"8\"title=\""+pub_ratio[loop]+"\"  />";
			
			else if((loop>=start_auto_cell+4 && loop<start_auto_cell+7)	)
				rowCell.innerHTML ="<input type=\"text\"onblur=\"cal_amounts(this)\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;background-color:#F3EDD8;\"maxlength=\"15\"  />";
			
			else
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";
								
			break;
		}
	}
	if(obj==0)
	pl_fix_header()
	$('#tblPL tbody tr')[lastRow].cells[7].childNodes[0].value=prew_length;
	$('#tblPL tbody tr')[lastRow].cells[6].childNodes[0].value=prew_color;
	$('#tblPL tbody tr')[lastRow].cells[3].childNodes[0].value=ctn_wt;
	$('#tblPL tbody tr')[lastRow].cells[1].childNodes[0].value=(prew_ctn_no!=""?parseFloat(prew_ctn_no)+1:"");	
	eventsetter();
	$('#tblPL tbody tr')[lastRow].cells[1].childNodes[0].focus();
		
}

function remove_detail_from_grid(obj)
{	
	if(confirm("Are you sure, you want to delete this record?"))
	$('#tblPL tbody')[0].deleteRow(obj-1);
	countsetter();
}



function cal_amounts(obj)
{
	var row			= obj.parentNode.parentNode;
	var ctns		=parseFloat(emty_handle_dbl(row.cells[2].childNodes[0].value))-parseFloat(emty_handle_dbl(row.cells[1].childNodes[0].value))+1;
	ctns			=(ctns<=0?1:ctns);						
	row.cells[start_auto_cell+1].childNodes[0].value		=ctns;	
	var totpcs	=0;
	
	for(var loop=start_sizes; loop<start_auto_cell;loop++)
	{	
			totpcs	+=parseFloat(emty_handle_dbl(row.cells[loop].childNodes[0].value))
	}
	
	var totgross	=parseFloat(emty_handle_dbl(row.cells[start_auto_cell+4].childNodes[0].value))*ctns;
	var totnet		=parseFloat(emty_handle_dbl(row.cells[start_auto_cell+5].childNodes[0].value))*ctns;
	var nettocal	=parseFloat(emty_handle_dbl(row.cells[start_auto_cell+5].childNodes[0].value));
	var totnet		=nettocal*ctns;
	var auto_netnet	=(nettocal>0?nettocal-.4:0);
	
	
	row.cells[start_auto_cell].childNodes[0].value			=totpcs;
	row.cells[start_auto_cell+2].childNodes[0].value		=totpcs*ctns.toFixed(2);
	row.cells[start_auto_cell+3].childNodes[0].value		=(totpcs*ctns/12).toFixed(2);
	row.cells[start_auto_cell+6].childNodes[0].value		=auto_netnet.toFixed(2);
	row.cells[start_auto_cell+7].childNodes[0].value		=totgross.toFixed(2);
	row.cells[start_auto_cell+8].childNodes[0].value		=totnet.toFixed(2);
	var totnetnet	=parseFloat(emty_handle_dbl(row.cells[start_auto_cell+6].childNodes[0].value))*ctns;
	row.cells[start_auto_cell+9].childNodes[0].value		=totnetnet.toFixed(2);
	prew_length	=row.cells[7].childNodes[0].value;
	prew_color	=row.cells[6].childNodes[0].value;
	prew_ctn_no	=row.cells[2].childNodes[0].value;
	ctn_wt		=row.cells[3].childNodes[0].value;
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
	if(plno=="")
		window.location.href="shipmentpackinglist.php";
	showPleaseWait();
	var url				='shipmentpackinglistdb.php?request=get_pl_header_data&plno='+plno;
	$.ajax
	({
		url: url,success: function(obj)
		{
			$(obj).find("pldata").each(function()
			{			
				$('#txtPLNo').val($(this).find("PLNo").text());
				$('#txtSailingDate').val($(this).find("SailingDate").text());
				$('#cmbStyle').val($(this).find("Style").text());
				$('#txtProductCode').val($(this).find("ProductCode").text());
				$('#txtMaterialNo').val($(this).find("Material").text());
				$('#txtFabric').val($(this).find("Fabric").text());
				$('#txtLable').val($(this).find("Lable").text());
				$('#txtColor').val($(this).find("Color").text());
				$('#txtISD').val($(this).find("ISDno").text());
				$('#txtPrePackCode').val($(this).find("PrePackCode").text());
				$('#txtSeason').val($(this).find("Season").text());
				$('#txtDivision').val($(this).find("Division").text());
				$('#txtCTNS').val($(this).find("CTNsvolume").text());
				$('#txtWashCode').val($(this).find("WashCode").text());
				$('#txtArticle').val($(this).find("Article").text());
				$('#txtCBM').val($(this).find("CBM").text());
				$('#txtItemNo').val($(this).find("ItemNo").text());
				$('#txtItem').val($(this).find("Item").text());
				$('#txtManufactOrderNo').val($(this).find("ManufactOrderNo").text());
				$('#txtManufactStyle').val($(this).find("ManufactStyle").text());
				$('#txtDO').val($(this).find("DO").text());
				$('#txtSortingType').val($(this).find("SortingType").text());
				$('#cboFactory').val($(this).find("Factory").text());
				$('#txtUnit').val($(this).find("Unit").text());
				$('#txt_l').val($(this).find("ctn_length").text());
				$('#txt_h').val($(this).find("ctn_height").text());
				$('#txt_w').val($(this).find("ctn_width").text());
				$('#txtArticle').val($(this).find("Article").text());
				$('#txtContainer').val($(this).find("Container").text());
				$('#cboTransMode').val($(this).find("TrnsportMode").text());
				$('#cboDestination').val($(this).find("Destination").text());
				$('#txtDC').val($(this).find("Dc").text());
				load_saved_pl_details()
			});				
		}
	});			
}

function print_pl()
{
		var plno			=$('#txtPLNo').val();			
		var url				='pop_printer.php';
		var xml_http_obj	=$.ajax({url:url,async:false});
				//window.open("packinglist_formats/pl_levis_newyork.php?plno="+plno,'pl');
				drawPopupArea(360,125,'frmPrinter');
				document.getElementById('frmPrinter').innerHTML=xml_http_obj.responseText;
				$('#cboPLnumber').val(plno)
				load_pl_format();
}

function do_print()
{
	var plno			=$('#cboPLnumber').val();
	var url_format				=$('#cboRptFormat').val();
	if(plno=="")
		{
			alert("Please select a PL number");
			return;	
		}
	if(url=="")
		{
			alert("Please select a PL format");
			return;	
		}
	url		=url_format+ "?plno="+plno
	window.open(url,'pl')
	var url				='shipmentpackinglistdb.php?request=save_pl_format&plno='+plno+'&pl_report='+url_format;
	var xml_http_obj	=$.ajax({url:url,async:false});
}

function load_saved_pl_details()
{
	var plno			=$('#txtPLNo').val();
	var url				='shipmentpackinglistdb.php?request=load_saved_pl_details&plno='+plno;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_size		=xml_http_obj.responseXML.getElementsByTagName('Size');
	var xml_net_wt		=xml_http_obj.responseXML.getElementsByTagName('Net');
	var cell_width		=""+Math.round(90/(xml_size.length+13))+"%"
	var tbl				=$('#tblPL')
	deleterows('tblPL');
	pub_ratio_wt=[];
	var row_thead 		=document.createElement("thead");
	tbl[0].appendChild(row_thead);
	var tbl				=$('#tblPL thead')
	var lastRow 		= $('#tblPL thead tr').length;	
	var row 			= tbl[0].insertRow(lastRow);										

	row.className 		="normaltxtmidb2";	
	row.bgColor			="#498CC2";					
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='#';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN_F.';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN_To';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='CTN WT';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	= cell_width;
	rowCell.height	  	='20';
	rowCell.innerHTML   ='TAG#';
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="SH";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="Color";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  	='10%';
	rowCell.innerHTML 	="Length";
	row.appendChild(rowCell);
	
	for(var loop=start_sizes;loop<xml_size.length+start_sizes;loop++)
	{						
			
		var rowCell 		=document.createElement("th");
		rowCell.width	  	=cell_width;
		rowCell.bgColor	  	='#020061'
		rowCell.innerHTML 	=xml_size[loop-start_sizes].childNodes[0].nodeValue;
		pub_ratio[loop]		=xml_size[loop-start_sizes].childNodes[0].nodeValue;
		pub_ratio_wt[loop-start_sizes]=xml_net_wt[loop-start_sizes].childNodes[0].nodeValue
		row.appendChild(rowCell);
	}
	start_auto_cell	  =loop;
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="#PCS";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="#CTNS";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="QTY";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="DOZ";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Gross";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Net Net";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Grs.";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot Net";
	row.appendChild(rowCell);
	
	var rowCell 		=document.createElement("th");
	rowCell.width	  =cell_width;
	rowCell.innerHTML ="Tot N.N.";
	row.appendChild(rowCell);
	
	load_saved_pl_data();
}

function load_saved_pl_data()
{
	var plno			=$('#txtPLNo').val();
	pub_col=start_auto_cell+10;
	var url				='shipmentpackinglistdb.php?request=load_saved_pl_data&plno='+plno;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_row_no		=xml_http_obj.responseXML.getElementsByTagName('RowNo').length;
	var tbl				=$('#tblPL tbody')
	for(var r_loop=0; r_loop<xml_row_no;r_loop++)
	{
		var lastRow 		= $('#tblPL tbody tr').length;
		var row 			= tbl[0].insertRow(lastRow);
		row.className		='trclass';
		//row.className 		="bcgcolor-tblrowWhite";
		for(var loop=0;loop<start_auto_cell+10;loop++)
		{	
			switch(loop)
			{	
			case 0:			
			var rowCell = row.insertCell(loop);
			rowCell.className = "normalfnt_num";
			rowCell.innerHTML =lastRow+1;	
			break;
			
			case 3:	
			case 4:		
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 5:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:50px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 6:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 7:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case start_auto_cell+9:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox lastcellz keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";	
			break;
			
			default	:
			var rowCell = row.insertCell(loop);
			if(loop>0 && loop<3)
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";
			
			else if(loop>7 && loop<start_auto_cell)			
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox keymove \" style=\"width:50px;text-align:right;background-color:#C2E2B8\"maxlength=\"8\"title=\""+pub_ratio[loop]+"\"  />";
			
			else if((loop>=start_auto_cell+4 && loop<start_auto_cell+7)	)
				rowCell.innerHTML ="<input type=\"text\"onblur=\"cal_amounts(this)\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;background-color:#F3EDD8;\"maxlength=\"15\"  />";
			
			else
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";
								
			break;
			}
		}	
	
	}	
	set_values_to_grid()
}


function set_values_to_grid()
{
	var plno			=$('#txtPLNo').val();
	var url				='shipmentpackinglistdb.php?request=load_saved_pl_data&plno='+plno;
	var xml_http_obj	=$.ajax({url:url,async:false});
		
		var xml_row_no			=xml_http_obj.responseXML.getElementsByTagName('RowNo');
		var xml_PLNoFrom		=xml_http_obj.responseXML.getElementsByTagName('PLNoFrom');
		var xml_PlNoTo			=xml_http_obj.responseXML.getElementsByTagName('PlNoTo');
		var xml_CTNWeight		=xml_http_obj.responseXML.getElementsByTagName('CTNWeight');
		var xml_tag_no			=xml_http_obj.responseXML.getElementsByTagName('TagNo');
		var xml_shade			=xml_http_obj.responseXML.getElementsByTagName('Shade');
		var xml_Color			=xml_http_obj.responseXML.getElementsByTagName('Color');
		var xml_length			=xml_http_obj.responseXML.getElementsByTagName('Length');
		var xml_NoofPCZ			=xml_http_obj.responseXML.getElementsByTagName('NoofPCZ');
		var xml_NoofCTNS		=xml_http_obj.responseXML.getElementsByTagName('NoofCTNS');
		var xml_QtyPcs			=xml_http_obj.responseXML.getElementsByTagName('QtyPcs');
		var xml_QtyDoz			=xml_http_obj.responseXML.getElementsByTagName('QtyDoz');
		var xml_Gorss			=xml_http_obj.responseXML.getElementsByTagName('Gorss');
		var xml_Net				=xml_http_obj.responseXML.getElementsByTagName('Net');
		var xml_NetNet			=xml_http_obj.responseXML.getElementsByTagName('NetNet');
		var xml_TotGross		=xml_http_obj.responseXML.getElementsByTagName('TotGross');
		var xml_TotNet			=xml_http_obj.responseXML.getElementsByTagName('TotNet');
		var xml_TotNetNet		=xml_http_obj.responseXML.getElementsByTagName('TotNetNet');
		
	var tr				=$('#tblPL tbody tr')
	for(var r_loop=0; r_loop<xml_row_no.length;r_loop++)
	{
		var row_index												=xml_row_no[r_loop].childNodes[0].nodeValue-1;
		tr[row_index].cells[1].childNodes[0].value					=xml_PLNoFrom[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[2].childNodes[0].value					=xml_PlNoTo[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[3].childNodes[0].value					=xml_CTNWeight[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[4].childNodes[0].value					=xml_tag_no[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[5].childNodes[0].value					=xml_shade[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[6].childNodes[0].value					=xml_Color[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[7].childNodes[0].value					=xml_length[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+0].childNodes[0].value	=xml_NoofPCZ[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+1].childNodes[0].value	=xml_NoofCTNS[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+2].childNodes[0].value	=xml_QtyPcs[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+3].childNodes[0].value	=xml_QtyDoz[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+4].childNodes[0].value	=xml_Gorss[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+5].childNodes[0].value	=xml_Net[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+6].childNodes[0].value	=xml_NetNet[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+7].childNodes[0].value	=xml_TotGross[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+8].childNodes[0].value	=xml_TotNet[r_loop].childNodes[0].nodeValue;
		tr[row_index].cells[start_auto_cell+9].childNodes[0].value	=xml_TotNetNet[r_loop].childNodes[0].nodeValue;
	}
	
	set_value_subdetails();
}
 
function set_value_subdetails()
{
		var plno			=$('#txtPLNo').val();
		var url				='shipmentpackinglistdb.php?request=set_value_subdetails&plno='+plno;
		var xml_http_obj	=$.ajax({url:url,async:false});
		
			
			var xml_ColumnNo		=xml_http_obj.responseXML.getElementsByTagName('ColumnNo');
			var xml_Pcs				=xml_http_obj.responseXML.getElementsByTagName('Pcs');
			
		var xml_row_no		=xml_http_obj.responseXML.getElementsByTagName('RowNo');
		var tr				=$('#tblPL tbody tr')
	for(var r_loop=0; r_loop<xml_row_no.length;r_loop++)
	{
		var row_index												=xml_row_no[r_loop].childNodes[0].nodeValue-1;
		var cell_no													=parseFloat(xml_ColumnNo[r_loop].childNodes[0].nodeValue)+start_sizes;
		tr[row_index].cells[cell_no].childNodes[0].value			=xml_Pcs[r_loop].childNodes[0].nodeValue;
		
	}
	eventsetter();
	hidePleaseWait();
	pl_fix_header()
}

function insert_row(no)
{
	row_number=no-1;
	if(row_number>=0)
	{
		
		var tbl				=$('#tblPL tbody')
		var lastRow 		= row_number;
		var row 			= tbl[0].insertRow(lastRow);		
		row.className		='trclass';
		for(var loop=0;loop<start_auto_cell+10;loop++)
		{	
			switch(loop)
			{	
				case 0:			
			var rowCell = row.insertCell(loop);
			rowCell.className = "normalfnt_num";
			rowCell.innerHTML =lastRow+1;	
			break;
			
			case 3:	
			case 4:		
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 5:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:50px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 6:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case 7:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\" class=\"txtbox keymove\" style=\"width:110px;text-align:center;\"maxlength=\"30\"  />";	
			break;
			
			case start_auto_cell+9:			
			var rowCell = row.insertCell(loop);
			rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox lastcellz keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";	
			break;
			
			default	:
			var rowCell = row.insertCell(loop);
			if(loop>0 && loop<3)
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";
			
			else if(loop>7 && loop<start_auto_cell)			
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"onblur=\"cal_amounts(this)\" class=\"txtbox keymove \" style=\"width:50px;text-align:right;background-color:#C2E2B8\"maxlength=\"8\"title=\""+pub_ratio[loop]+"\"  />";
			
			else if((loop>=start_auto_cell+4 && loop<start_auto_cell+7)	)
				rowCell.innerHTML ="<input type=\"text\"onblur=\"cal_amounts(this)\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;background-color:#F3EDD8;\"maxlength=\"15\"  />";
			
			else
				rowCell.innerHTML ="<input type=\"text\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox keymove\" style=\"width:50px;text-align:right;\"maxlength=\"15\"  />";
								
			break;
			}
		}
		countsetter();
		eventsetter();
		$('#tblPL tbody tr')[lastRow].cells[1].childNodes[0].focus();
	}
	
}

function save_pl_format()
{
		var plno			=$('#cboPLnumber').val();
		var pl_report			=$('#cboRptFormat').val();
		if(plno=="")
		{
			alert("Please select a Packing List Number.");
			return;
		}
		if(pl_report=="")
		{
			alert("Please select a Packing List Format.");
			return;
		}
		var url				='shipmentpackinglistdb.php?request=save_pl_format&plno='+plno+'&pl_report='+pl_report;
		var xml_http_obj	=$.ajax({url:url,async:false});
		if(xml_http_obj.responseText=='saved')
			alert("Saved successfully.");
		if(xml_http_obj.responseText=='failed')
			alert("Sorry, please try again later.");
	
}

function load_pl_format()
{
			var plno			=$('#cboPLnumber').val();
			var url				='shipmentpackinglistdb.php?request=load_pl_format&plno='+plno;
			var xml_http_obj	=$.ajax({url:url,async:false});
			$('#cboRptFormat').val(xml_http_obj.responseText);
}

function eventsetter()
{
	$('.txtbox.lastcellz').live('keydown', function(e) { 
	  var keyCode = e.keyCode || e.which; 
	  if (keyCode == 9) {	  
		//e.preventDefault(); 
				fill_pl_grid_data(this.parentNode.parentNode.rowIndex)
	   // call custom function here
	  } 
	});
	
	$('.txtbox.keymove').live('keydown', function(e) { 
	   var keyCode = e.keyCode || e.which;
	   var row_cell=this.parentNode.cellIndex;
	   var row_index=this.parentNode.parentNode.rowIndex-1
			switch(keyCode)
			{
				case 37: row_cell  = row_cell - 1; break;   //left
				case 38: row_index = row_index - 1; break; 	//up
				case 39: row_cell  = row_cell + 1; break; 	//right
				case 40: row_index = row_index + 1; break;  //down
				default: return; 
					
			}
			var val_row=$("#tblPL tbody").attr('rows').length;
			if(row_cell<1||row_cell>=start_auto_cell+10||row_index<0||row_index>=val_row)
				return;		
			$('#tblPL tbody tr')[row_index].cells[row_cell].childNodes[0].focus();
				
	});
	
	
	$(".trclass").bind("contextmenu", function(e) {
		menu_rowindex =this.rowIndex;
		$('#grid_menu').css({
			top: e.pageY+'px',
			left: e.pageX+'px'
		}).show();
		return false;
	});
	
	$(document).click(function() {
		$("#grid_menu").hide();
	});	
}


function countsetter()
{
	var row 			= $('#tblPL tbody tr');
	for(var loop_row=0;loop_row<row.length;loop_row++)
	{		
		row[loop_row].cells[0].innerHTML=loop_row+1;
	}
}

function cal_cbm()
{
	var ctn_length=parseFloat(emty_handle_dbl($("#txt_l").val()));
	var ctn_height=parseFloat(emty_handle_dbl($("#txt_h").val()));
	var ctn_width =parseFloat(emty_handle_dbl($("#txt_w").val()));
	$("#txtCTNS").val(ctn_length+"X"+ctn_height+"X"+ctn_width);
	//alert($("#txtCTNS").val())
}

function check_between_tabs()
{
	if($('#cmbStyle').val()==""){
		alert("Please fill the header data first.");
		window.location.href=window.location.href;
	}
	
}

function pl_fix_header()
{
	$("#tblPL").fixedHeader({
	width: 950,height: 300
	});	
}

function view_pl()
{

	$('#pl_header')[0].reset();
	$('#plno_cell').html(pl_combo);	
	loadCombo('SELECT strPLNo, concat(strPLNo,\'-\',strStyle,\'-\',strSailingDate,\'-\',strISDno,\'\',strDO)as pldesc FROM shipmentplheader order by strPLNo desc','txtPLNo');	
			
}

function auto_cal_ctns()
{
	
	var row 			= $('#tblPL tbody tr');
	for(var loop_row=0;loop_row<row.length;loop_row++)
	{		
		var ctn_frm	=parseFloat(row[loop_row].cells[1].childNodes[0].value==""?0:row[loop_row].cells[1].childNodes[0].value);
		var ctns	=parseFloat(row[loop_row].cells[start_auto_cell+1].childNodes[0].value==""?0:row[loop_row].cells[start_auto_cell+1].childNodes[0].value);
		row[loop_row].cells[2].childNodes[0].value=ctn_frm+ctns-1;
		try{
		row[loop_row+1].cells[1].childNodes[0].value=ctn_frm+ctns;
		}
		catch(e){}
	}
}

function auto_cal_weight()
{
		
	var row 			= $('#tblPL tbody tr');
	for(var loop_row=0;loop_row<row.length;loop_row++)
	{		
		var net_wt	=0
		var gross_wt=0
		//alert(pub_ratio_wt.length);
		for(var loop_col=0;loop_col<pub_ratio_wt.length;loop_col++)
		{
			var size_qty=parseFloat(row[loop_row].cells[loop_col+start_sizes].childNodes[0].value==""?0:row[loop_row].cells[loop_col+start_sizes].childNodes[0].value)
			
			//alert(loop_col +" ->"+size_qty)
			net_wt+=size_qty*pub_ratio_wt[loop_col]
			
			
		}
		var ctn_wt=parseFloat(row[loop_row].cells[3].childNodes[0].value==""?0:row[loop_row].cells[3].childNodes[0].value)
		var no_ctn=parseFloat(row[loop_row].cells[start_auto_cell+1].childNodes[0].value==""?0:row[loop_row].cells[start_auto_cell+1].childNodes[0].value)
		gross_wt+=net_wt+(ctn_wt)
		var net_net_wt=(net_wt>0?(net_wt-.4):0)		
		row[loop_row].cells[start_auto_cell+9].childNodes[0].value=(net_net_wt*no_ctn).toFixed(2)
		row[loop_row].cells[start_auto_cell+8].childNodes[0].value=(net_wt*no_ctn).toFixed(2)
		row[loop_row].cells[start_auto_cell+7].childNodes[0].value=(gross_wt*no_ctn).toFixed(2)
		row[loop_row].cells[start_auto_cell+6].childNodes[0].value=net_net_wt.toFixed(2)
		row[loop_row].cells[start_auto_cell+5].childNodes[0].value=net_wt.toFixed(2)
		row[loop_row].cells[start_auto_cell+4].childNodes[0].value=gross_wt.toFixed(2)
	}
}