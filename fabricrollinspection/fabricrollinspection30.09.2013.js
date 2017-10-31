function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 1) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function fillgrid()
{
	var tbl=document.getElementById("tbl_roll_details");
	var lastrow=tbl.rows.length;
	var row=tbl.insertRow(lastrow);
	row.className ="bcgcolor-tblrowWhite";	
	var vla=1;
	
	var rowcell=row.insertCell(0);
	rowcell.innerHTML="<div onClick=\"RemoveItem(this);\" align=\"center\"><img src=\"../images/del.png\" /></div>"; 	
			
	var rowcell=row.insertCell(1);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"text\" class=\"txtbox\"maxlength=\"20\" style=\"text-align:left;width:80px\"/>";
	
	var rowcell=row.insertCell(2);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\"maxlength=\"20\" style=\"text-align:right;width:80px\"/>";
	
	var rowcell=row.insertCell(3);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"text\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"maxlength=\"20\" style=\"text-align:right;width:80px\"/>";
	
	var rowcell=row.insertCell(4);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"text\"maxlength=\"20\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"text-align:right;width:90px\"/>";
	
	var rowcell=row.insertCell(5);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"text\"maxlength=\"20\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"text-align:right;width:80px\"/>";
	
	var rowcell=row.insertCell(6);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"maxlength=\"10\"text\" class=\"txtbox\" style=\"text-align:center;width:80px\"/>";
	
	var rowcell=row.insertCell(7);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"text\"onblur=\"pattern_validation(this)\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"maxlength=\"20\" onfocus=\"pattern_gen(this)\" class=\"txtbox\" style=\"text-align:right;width:80px\"/>";
		
	var rowcell=row.insertCell(8);
	rowcell.className='normalfntMid';
	rowcell.innerHTML="<input type=\"text\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"maxlength=\"20\" style=\"text-align:right;width:80px\"/>";
	
	var rowcell=row.insertCell(9);
	rowcell.className='normalfntMid';
	rowcell.innerHTML=innerHTML ="<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"maxlength=\"20\" class=\"txtbox\" style=\"text-align:right;width:80px\"onblur=\"arrange_grid();\"/>";
	
	tbl.rows[lastrow].cells[1].childNodes[0].focus();
	
}

function RemoveItem(obj)
{
	var num_row=obj.parentNode.parentNode.rowIndex;
	document.getElementById("tbl_roll_details").deleteRow(num_row);
}


function get_matitem_list()
{
	get_supplier();
	if(document.getElementById("cboInvoice").value=="")
		return false;
	RomoveData("cboItem");
	var invoice=document.getElementById("cboInvoice").value;
	var url="fabricrollinspectiondb.php?request=matlist&invoice="+invoice;
	htmlobj=$.ajax({url:url,async:false});
	var item_id=htmlobj.responseXML.getElementsByTagName('MatDetailID');
	var item_desc=htmlobj.responseXML.getElementsByTagName('ItemDescription');
	for (var loop=0; loop<item_id.length;loop++)
			{
					var opt 		= document.createElement("option");
					opt.value	 	= item_id[loop].childNodes[0].nodeValue;
					opt.text 		= item_desc[loop].childNodes[0].nodeValue;
					document.getElementById("cboItem").options.add(opt);
			}
	
}

function get_color_list()
{
	if(document.getElementById("cboInvoice").value=="")
		return false;
	if(document.getElementById("cboItem").value=="")
		return false;
	
	RomoveData("cboColor");
	var invoice	=document.getElementById("cboInvoice").value;
	var matid	=document.getElementById("cboItem").value;
	var url		="fabricrollinspectiondb.php?request=colorlist&invoice="+invoice+"&matid="+matid;
	htmlobj		=$.ajax({url:url,async:false});
	var xml_color	=htmlobj.responseXML.getElementsByTagName('Color');	
	for (var loop=0; loop<xml_color.length;loop++)
			{
					var opt 		= document.createElement("option");
					opt.value	 	= xml_color[loop].childNodes[0].nodeValue;
					opt.text 		= xml_color[loop].childNodes[0].nodeValue;
					document.getElementById("cboColor").options.add(opt);
			}
	
}

function refreshgrid()
{
	RemoveAllRows("tbl_roll_details")
	fillgrid();
}


function get_supplier()
{
	if(document.getElementById("cboInvoice").value=="")
		return false;
		
	RomoveData("cboSupplier");
	var invoice	=document.getElementById("cboInvoice").value;
	var url		="fabricrollinspectiondb.php?request=supplierlist&invoice="+invoice;
	htmlobj		=$.ajax({url:url,async:false});
	var supplierId	=htmlobj.responseXML.getElementsByTagName('supplierId');	
	var supplier	=htmlobj.responseXML.getElementsByTagName('supplier');	
	for (var loop=0; loop<supplierId.length;loop++)
			{
					var opt 		= document.createElement("option");
					opt.value	 	= supplierId[loop].childNodes[0].nodeValue;
					opt.text 		= supplier[loop].childNodes[0].nodeValue;
					document.getElementById("cboSupplier").options.add(opt);
			}
	
}

function SeachStyle(obj)
{	
	document.getElementById("cboStyleId").value =obj.value;
	document.getElementById("cboScNo").value =obj.value;
}

function SaveValidation()
{
	if(document.getElementById("cboInvoice").value==""){		
		alert("Please select the Invoice.");
		document.getElementById("cboInvoice").focus();
		return false;
	}
	if(document.getElementById("cboItem").value==""){		
		alert("Please select the Item.");
		document.getElementById("cboItem").focus();
		return false;
	}
	if(document.getElementById("cboColor").value==""){		
		alert("Please select the Color.");
		document.getElementById("cboColor").focus();
		return false;
	}
	
	if(document.getElementById("tbl_roll_details").rows.length==1){		
		alert("Please enter details.");
		fillgrid();
		return false;
	}
	saveHeader();
}

function saveHeader()
{
	var invoice=document.getElementById("cboInvoice").value;
	var matitem=document.getElementById("cboItem").value;
	var color=document.getElementById("cboColor").value;
	var style=document.getElementById("cboStyleId").value;
	var supplier=document.getElementById("cboSupplier").value;
	var date=document.getElementById("txtDate").value;
	var WashType=document.getElementById("txtWashType").value;
	var Remarks=document.getElementById("txtRemarks").value;
	var stores=document.getElementById("stores").value;
	var url="fabricrollinspectiondb.php?request=save_header&invoice="+invoice+"&matitem="+matitem+"&color="+color+"&style="+style+"&supplier="+supplier+"&date="+date+"&WashType="+WashType+"&Remarks="+Remarks+"&stores="+stores;
	
	httpobj=$.ajax({url:url,async:false});
	
	document.getElementById("fabric_serial_year").value=httpobj.responseXML.getElementsByTagName('year')[0].childNodes[0].nodeValue;
	document.getElementById("fabric_serial").value=httpobj.responseXML.getElementsByTagName('serialno')[0].childNodes[0].nodeValue;
	save_detail();
}

function pattern_gen(obj)
{
	var tblrow=document.getElementById("tbl_roll_details").rows[obj.parentNode.parentNode.rowIndex];
	if(tblrow.cells[4].childNodes[0].value=="" || tblrow.cells[5].childNodes[0].value=="")
	return false;
	var length=parseFloat(tblrow.cells[4].childNodes[0].value);
	var width=parseFloat(tblrow.cells[5].childNodes[0].value);
	var p_length=parseInt(length);
	var p_width=parseInt(width);
	length=(length>p_length?p_length+1:length);
	width=(width>p_width?p_width+1:width);
	
	obj.value=length+""+width;
}

function sortNumber(a, b)
{
return a - b;
}

function sortgrid()
{
	var row_index=document.getElementById("tbl_roll_details").rows.length;
	var tbl=document.getElementById("tbl_roll_details");
	alert(tbl.innerHTML);
	var current_ptrn=parseInt(tbl.rows[row_index-1].cells[7].childNodes[0].value);
	var previous_ptrn=parseInt(tbl.rows[row_index-2].cells[7].childNodes[0].value);
	
	if(previous_ptrn>current_ptrn)
			{
				var changable_row=tbl.rows[row_index-1].innerHTML;
				var chaging_row=tbl.rows[row_index-2].innerHTML;
				/*tbl.rows[row_index-2].innerHTML=chaging_row;
				tbl.rows[row_index-1].innerHTML=changable_row;*/
				alert(chaging_row);
			}	
	
}

function arrange_grid()
{
//sortgrid();	
fillgrid();
}

function shrinkageReport()
{
	window.open("rptshrikreport.php",'shrink');
}

function save_detail()
{	
	var year	=document.getElementById("fabric_serial_year").value;
	var seral	=document.getElementById("fabric_serial").value;
	var tbl=document.getElementById("tbl_roll_details");
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var rollnumber			=tbl.rows[loop].cells[1].childNodes[0].value;
		var yards				=tbl.rows[loop].cells[2].childNodes[0].value;
		var width				=tbl.rows[loop].cells[3].childNodes[0].value;
		var shrink_length		=tbl.rows[loop].cells[4].childNodes[0].value;
		var shrink_width		=tbl.rows[loop].cells[5].childNodes[0].value;
		var shade				=tbl.rows[loop].cells[6].childNodes[0].value;
		var pattern				=tbl.rows[loop].cells[7].childNodes[0].value;
		var skewness			=tbl.rows[loop].cells[8].childNodes[0].value;
		var elongation			=tbl.rows[loop].cells[9].childNodes[0].value;
		if(rollnumber!="")
		{
			var url		="fabricrollinspectiondb.php?request=save_detail&rollnumber="+rollnumber+"&yards="+yards+"&width="+width+"&shrink_length="+shrink_length+"&shrink_width="+shrink_width+"&shade="+shade+"&pattern="+pattern+"&skewness="+skewness+"&year="+year+"&seral="+seral+"&elongation="+elongation;
			httpobj[loop]		=$.ajax({url:url,async:false});
		}
	}alert("Saved successfully.");location.reload();
}

function pattern_validation(obj)
{
	
	var tblrow	=document.getElementById("tbl_roll_details").rows[obj.parentNode.parentNode.rowIndex];
	var length	=parseFloat(tblrow.cells[4].childNodes[0].value);
	var width	=parseFloat(tblrow.cells[5].childNodes[0].value);
	var pattern	=parseFloat(tblrow.cells[7].childNodes[0].value);
	if(tblrow.cells[4].childNodes[0].value=="" || tblrow.cells[5].childNodes[0].value=="")
	return false;
	var p_length=parseInt(length);
	var p_width	=parseInt(width);
	p_length=(length>p_length?p_length+1:length);
	p_width=(width>p_width?p_width+1:width);
	var pattern_array=[];
	var no=0
	//var pattern_array=[p_length+""+p_width,p_length+1+""+p_width,p_length-1+""+p_widt,p_length+1+""+p_width+1]
	var lengtn_array=[p_length-1,p_length,p_length+1];
	var width_array	=[p_width-1,p_width,p_width+1];
	for(var l_loop=0;l_loop<lengtn_array.length;l_loop++)
		{
			for(var w_loop=0;w_loop<width_array.length;w_loop++)
				{	
					//alert(lengtn_array[l_loop]+""+width_array[w_loop])
					pattern_array[no]=lengtn_array[l_loop]+""+width_array[w_loop];
					no++
				}
		}
		var messsage="Sorry! The pattern must be one of following.\n"
		for(var loop=0;loop<pattern_array.length;loop++)
		{	if (loop!=0)
				messsage+=", ";
			if(pattern==pattern_array[loop])
				return false;
			else
				messsage+=pattern_array[loop];
		}
		
		alert(messsage);
		pattern_gen(tblrow.cells[7].childNodes[0]);
		tblrow.cells[7].childNodes[0].focus();
}