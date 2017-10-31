$(document).ready(function(){
	
	$('#cboStyles').change(function(){
			
	});
	
	$('.ordercls').change(function(){
		
		$('.ordercls').val(($(this).val()))	
	
	});	
	
	$('#btn_fill_size_grid').click(function(){
		
		fill_sizeratio_grid()
	
	});	
	
	$('#butNext').click(function(){
		
		//window.location.href="../../shipmentpackinglist.php?orderno="+$('#cboOrder option:selected').text()+"&orderId="+document.getElementById('cboOrder').value;
	window.location.href="../../packinglistWizard.php";
	});	
	
	$('#butSave').click(function(){
				
		save_sizeratio_grid();
	
	});
	
	$('#checkBoxAll').click(function(){
				
		checkAllCheckBoxes();
	
	});
		
});

function checkAllCheckBoxes()
{
	var sizeratio_grid=document.getElementById('sizeratio_grid');
	if(document.getElementById('sizeratio_grid').rows.length>1)
	{
		if(document.getElementById('checkBoxAll').checked==true)
		{
			for(var x=1;x<sizeratio_grid.rows.length;x++)
			{
				//alert(x);
				sizeratio_grid.rows[x].cells[0].childNodes[0].checked=true;
			}
		}
		else
		{
			for(var x=1;x<sizeratio_grid.rows.length;x++)
				sizeratio_grid.rows[x].cells[0].childNodes[0].checked=false;
		}
	}
}


function fill_sizeratio_grid()
{
	delect_table_content("sizeratio_grid")
	var tbl_sizeratio_grid	=$("#sizeratio_grid tbody");
	var orderid				=$('#cboOrder option:selected').text();
	var url					='stylerato_plugin_db.php?request=fill_sizeratio_grid&orderid='+orderid;
	var xml_http_obj		=$.ajax({url:url,async:false});
	var xml_sizes			=xml_http_obj.responseXML.getElementsByTagName('size');	
	var xml_weight			=xml_http_obj.responseXML.getElementsByTagName('weight');
	var style			=xml_http_obj.responseXML.getElementsByTagName('style')[0].childNodes[0].nodeValue;	
	
	for(var i=0;i<xml_sizes.length;i++)
	{
		var lastRow 		= $('#sizeratio_grid tbody tr').length;	
		var row 			= tbl_sizeratio_grid[0].insertRow(lastRow);	
		row.className 		= "bcgcolor-tblrowWhite";
				
		var rowCell 		=document.createElement("td");
		rowCell.innerHTML   ="<input type=\"checkbox\" id=\"checkBoxAll\" name=\"checkBoxAll\" />";
		rowCell.className	="normalfntMid"
		row.appendChild(rowCell);
		
		var rowCell 		=document.createElement("td");
		rowCell.innerHTML   =xml_sizes[i].childNodes[0].nodeValue;
		rowCell.className	="normalfntMid"
		row.appendChild(rowCell);
		
		var rowCell 		=document.createElement("td");
		rowCell.height	  	='20';
		rowCell.innerHTML   ="<input  type=\"text\" class=\"txtbox\" style=\"text-align:center; width:85px; \" id=\"txtGarments\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\""+xml_weight[i].childNodes[0].nodeValue+"\"  maxlength=\"10\"  />";
		rowCell.className	="normalfntMid"
		row.appendChild(rowCell);
	}
	
	var url					='stylerato_plugin_db.php?request=fill_prevSizeRatio_grid&styleId='+style;
	var xml_http_obj		=$.ajax({url:url,async:false});
	var xml_order			=xml_http_obj.responseXML.getElementsByTagName('OrderId');
	
	var string = "<option value=\"Select One\">Select One</option>";
	
	for(var i=0;i<xml_order.length;i++)
	{
		string +="<option value=\""+xml_order[i].childNodes[0].nodeValue+"\">"+xml_order[i].childNodes[0].nodeValue+"</option>";
	}
	
	document.getElementById('cboPreOrder').innerHTML=string;
	$("#sizeratio_grid").tableDnD();
}

function delect_table_content(obj)
{
	$('#'+ obj+' tbody' ).html("")
}

function grid_fix_header()
{
	$("#sizeratio_grid").fixedHeader({
	width: 400,height: 400
	});	
}

function save_sizeratio_grid()
{
	var orderid					=$('#cboOrder option:selected').text();
	var url						='stylerato_plugin_db.php?request=delete_before_save_sizeratio_grid&orderid='+orderid;
	var xml_http_obj			=$.ajax({url:url,async:false});
	if(xml_http_obj.responseText=="Error")
	{
		return;	
	}	
	var tbl_sizeratio_grid		=$("#sizeratio_grid tbody");
	var tbl_sizeratio_grid_row	=$("#sizeratio_grid tbody tr");
	for(var loop=0;loop<tbl_sizeratio_grid_row.length;loop++)
	{
		
		if(tbl_sizeratio_grid_row[loop].cells[0].childNodes[0].checked==true)
		{
			var size				=URLEncode(tbl_sizeratio_grid_row[loop].cells[1].childNodes[0].nodeValue);
			var url					='stylerato_plugin_db.php?request=save_sizeratio_grid&orderid='+orderid+'&size='+size;
			var xml_http_obj		=$.ajax({url:url,async:false});
		
		}
		
	
	}
	save_garment_weight()
}


function save_garment_weight()
{
	var orderid					=$('#cboOrder option:selected').text();
	var url						='stylerato_plugin_db.php?request=delete_before_save_garment_weight&orderid='+orderid;
	var xml_http_obj			=$.ajax({url:url,async:false});
	if(xml_http_obj.responseText=="Error")
	{
		return;	
	}	
	var tbl_sizeratio_grid		=$("#sizeratio_grid tbody");
	var tbl_sizeratio_grid_row	=$("#sizeratio_grid tbody tr");
	for(var loop=0;loop<tbl_sizeratio_grid_row.length;loop++)
	{
		
		
			var size				=URLEncode(tbl_sizeratio_grid_row[loop].cells[1].childNodes[0].nodeValue);
			var weight				=URLEncode(tbl_sizeratio_grid_row[loop].cells[2].childNodes[0].value);
			var url					='stylerato_plugin_db.php?request=save_garment_weight&orderid='+orderid+'&size='+size+'&weight='+weight;
			var xml_http_obj		=$.ajax({url:url,async:false});
		
	
		
	
	}

	alert("Saved successfully.")
}

function fill_prevSizeRatio_grid(obj)
{
	var sizeratio_grid=document.getElementById('sizeratio_grid');
	if(obj.value!='Select One')
	{
		var url='stylerato_plugin_db.php?request=fill_sizeratio_grid&orderid='+obj.value;
		var xml_http_obj		=$.ajax({url:url,async:false});
		var xml_sizes			=xml_http_obj.responseXML.getElementsByTagName('size');	
		var xml_weight			=xml_http_obj.responseXML.getElementsByTagName('weight');
		
		for(var i=0;i<xml_sizes.length;i++)
		{
			var size=xml_sizes[i].childNodes[0].nodeValue;
			var weight=xml_weight[i].childNodes[0].nodeValue;
			
			for(var x=1; x<sizeratio_grid.rows.length; x++)
			{
				var tblSize=sizeratio_grid.rows[x].cells[1].childNodes[0].nodeValue;
				//var tblWeight=sizeratio_grid.rows[x].cells[1].childNodes[0].nodeValue;
				
				if(size==tblSize)
					sizeratio_grid.rows[x].cells[2].childNodes[0].value=weight;
			}
		}
	}	
}