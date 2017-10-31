var pub_date_from='';
var pub_date_to  ='';
var pub_bg_olor_over="";
var pub_bg_color_click='';
var prev_row_no=-99;

$(document).ready(function() 
{
		var url5				='exportregistrydb.php?request=loadCDNPo';
		var pub_xml_http_obj5	=$.ajax({url:url5,async:false});
		var pub_po_arr			=pub_xml_http_obj5.responseText.split("|");
		
		$( "#txtCDNBuyerPO" ).autocomplete({
			source: pub_po_arr
		});
		
		
		var url2				='exportregistrydb.php?request=loadCDNInv';
		var pub_xml_http_obj2	=$.ajax({url:url2,async:false});
		var pub_in_arr			=pub_xml_http_obj2.responseText.split("|");
		
		$( "#txtCDNInvNo" ).autocomplete({
			source: pub_in_arr
		});
		
		
		var url10				='exportregistrydb.php?request=loadCDNstyle';
		var pub_xml_http_obj10	=$.ajax({url:url10,async:false});
		var pub_in_arr			=pub_xml_http_obj10.responseText.split("|");
		
		$( "#txtStyleNo" ).autocomplete({
			source: pub_in_arr
		});
		
		var url11				='exportregistrydb.php?request=loadbuyer';
		var pub_xml_http_obj11	=$.ajax({url:url11,async:false});
		var pub_in_arr			=pub_xml_http_obj11.responseText.split("|");
		
		$( "#txtbuyer" ).autocomplete({
			source: pub_in_arr
		});
		
//		
//		var ur2				='cdndb.php?request=loadpendingCDNToInvUsingPo';
//		var pub_xml_http_obj5	=$.ajax({url:url5,async:false});
//		var pub_pending_arr		=pub_xml_http_obj5.responseText.split("|");
//		
//		$( "#txtpendingCDNInvNo" ).autocomplete({
//			source: pub_pending_arr
//		});
		
		
		
		
	
	
		$('#btnSearch').click(function()
		{
			load_pl_grid();				
		});
		
		$('#cbxSetDate').change(function()
		{
			
			if($('#cbxSetDate').attr('checked'))
			{
				$("#txtDateFrom").removeAttr("disabled", "disabled"); 
                $("#txtDateTo").removeAttr("disabled", "disabled"); 
				$("#txtDateFrom").val(pub_date_from);
				$("#txtDateTo").val(pub_date_to);
			}
			else
			{
				
				$("#txtDateFrom").attr("disabled", "disabled"); 
                $("#txtDateTo").attr("disabled", "disabled"); 
				pub_date_from=$("#txtDateFrom").val();
				pub_date_to=$("#txtDateTo").val();
				$("#txtDateFrom").val('');
				$("#txtDateTo").val('');
				
			}
						
		});
		
		pl_fix_header();		
});

function del_tbl_reset()
{
	$('#tblER tr:gt(1)').remove()
}
//function abc(obj)
//{
//	alert(obj);
//}
function load_pl_grid(invoice_No,abc)
{	
//alert(poNo);
//alert(invoice_No);
//alert(StyleID);
var filter=0;

	if (abc==1)
		{
			filter=1;
		}
	 if(abc==2)
		{
			filter=2;
		}
	
	 if(abc==3)
		{
			filter=3;
		}
	 if(abc==4)
		{
			filter=4;
		}
		//alert(filter);
			//alert(invoice_No);
	
	var  Reg_type		=$('#cboInvoiceType').val();
	var  dateFrom			=$('#txtDateFrom').val();
	var  dateTo				=$('#txtDateTo').val();	
	del_tbl_reset();
	showPleaseWait();
	
	var url				  ='exportregistrydb.php?request=load_er_grid&dateFrom='+dateFrom+
							'&dateTo='+dateTo+'&Reg_type='+Reg_type+'&filter='+filter+'&invoice_No='+invoice_No;
	var xml_http_obj	  =$.ajax({url:url,async:false});
	
	var xml_InvoiceNo	  =xml_http_obj.responseXML.getElementsByTagName('InvoiceNo');
	var xml_Value		  =xml_http_obj.responseXML.getElementsByTagName('Value');
	var xml_BuyerAName	  =xml_http_obj.responseXML.getElementsByTagName('BuyerAName');
	var xml_TransportMode =xml_http_obj.responseXML.getElementsByTagName('TransportMode');
	var xml_Vessel		  =xml_http_obj.responseXML.getElementsByTagName('Vessel');
	var xml_ETD		   	  =xml_http_obj.responseXML.getElementsByTagName('ETD');
	var xml_ETA			  =xml_http_obj.responseXML.getElementsByTagName('ETA');
	var xml_PONo		  =xml_http_obj.responseXML.getElementsByTagName('PONo');
	var xml_Meterial	  =xml_http_obj.responseXML.getElementsByTagName('Meterial');
	var xml_ISDNo	 	  =xml_http_obj.responseXML.getElementsByTagName('ISDNo');
	var xml_GarmentType	  =xml_http_obj.responseXML.getElementsByTagName('GarmentType');
	var xml_NoOfCtn		  =xml_http_obj.responseXML.getElementsByTagName('NoOfCtn');
	var xml_Qty		 	  =xml_http_obj.responseXML.getElementsByTagName('Qty');
	var xml_Fabric	 	  =xml_http_obj.responseXML.getElementsByTagName('Fabric');
	var xml_BL	 		  =xml_http_obj.responseXML.getElementsByTagName('BL');
	var xml_HAWB	 	  =xml_http_obj.responseXML.getElementsByTagName('HAWB');
	var xml_ContNo		  =xml_http_obj.responseXML.getElementsByTagName('ContNo');
	var xml_ContSize	  =xml_http_obj.responseXML.getElementsByTagName('ContSize');
	var xml_FreightPay	  =xml_http_obj.responseXML.getElementsByTagName('FreightPay');
	var xml_PayTerm	 	  =xml_http_obj.responseXML.getElementsByTagName('PayTerm');
	var xml_DesCountry	  =xml_http_obj.responseXML.getElementsByTagName('DesCountry');
	var xml_DesPort		  =xml_http_obj.responseXML.getElementsByTagName('DesPort');
	var xml_Agent		  =xml_http_obj.responseXML.getElementsByTagName('Agent');
	var xml_FreightPay	  =xml_http_obj.responseXML.getElementsByTagName('FreightPay');
	var xml_ExFTY		  =xml_http_obj.responseXML.getElementsByTagName('ExFTY');
	var xml_DateOfExport  =xml_http_obj.responseXML.getElementsByTagName('DateOfExport');
	var xml_Month		  =xml_http_obj.responseXML.getElementsByTagName('Month');
	
	var xml_DocumentDueDate		  =xml_http_obj.responseXML.getElementsByTagName('DocumentDueDate');
	var xml_DocumentSubDate		  =xml_http_obj.responseXML.getElementsByTagName('DocumentSubDate');
	var xml_PaymentDueDate		  =xml_http_obj.responseXML.getElementsByTagName('PaymentDueDate');
	var xml_PaymentSubDate		  =xml_http_obj.responseXML.getElementsByTagName('PaymentSubDate');
	var xml_FileNo		  		  =xml_http_obj.responseXML.getElementsByTagName('FileNo');
	var xml_ExportNo		      =xml_http_obj.responseXML.getElementsByTagName('ExportNo');
	var xml_EntryNo		          =xml_http_obj.responseXML.getElementsByTagName('EntryNo');
	var xml_CBM	     			  =xml_http_obj.responseXML.getElementsByTagName('CBM');
	
	
	
	var prev_color		='#E4EAF9';
	var	nw_color		='#FBFCFE';
	var row_color		='#FBFCFE';
	var nw_INV			="";
	var prev_INV		="";
	
	
	var tbl				=$('#tblER tbody')
	for(var r_loop=0; r_loop<xml_InvoiceNo.length;r_loop++)
	{
		
		
			if(xml_DocumentSubDate[r_loop].childNodes[0].nodeValue==""||xml_PaymentSubDate[r_loop].childNodes[0].nodeValue=="")
		{
			var cls_status="inv-state-not-ok"
			//var inv_status="&times;"
			var inv_status="Pending"
		}
		else
		{
			var cls_status="inv-state-ok"
			//var inv_status="&radic;"
			var inv_status="Complete"
		}
		
		
		var inv_no			=xml_InvoiceNo[r_loop].childNodes[0].nodeValue
		prev_INV			=(r_loop==0?inv_no:prev_INV);
		nw_INV				=inv_no;
		
		if(prev_INV!=nw_INV)
		{
			row_color	=nw_color;
			nw_color	=prev_color;
			prev_color	=row_color;
		}
		
		var lastRow 		= $('#tblER tbody tr').length;
		var row 			= tbl[0].insertRow(lastRow);
		//row.className		='bcgcolor-tblrowWhite';
		//row.bgColor			='#F6E8D7'
		row.bgColor			=nw_color
		
		var rowCell 	  	= row.insertCell(0);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_InvoiceNo[r_loop].childNodes[0].nodeValue;
		rowCell.height	  	="25"
		rowCell.noWrap		='noWrap';
		
		var rowCell 	  	= row.insertCell(1);
		rowCell.className 	= "normalfntRite";
		rowCell.innerHTML 	=xml_Value[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(2);
		rowCell.className 	= cls_status;
		rowCell.innerHTML 	= inv_status;
						
		var rowCell 	  	= row.insertCell(3);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_BuyerAName[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
		
		var rowCell 	  	= row.insertCell(4);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_TransportMode[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(5);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Vessel[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
		
		var rowCell 	  	= row.insertCell(6);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_CBM[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(7);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_ETD[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(8);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_ETA[r_loop].childNodes[0].nodeValue;
		
		
		var rowCell 	  	= row.insertCell(9);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_EntryNo[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(10);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_ExportNo[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(11);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	="<input name=\"txtFileNo\" type=\"text\" maxlength=\"100\" id=\"txtFileNo\" size=\"25\" value=\""+xml_FileNo[r_loop].childNodes[0].nodeValue+"\"/>";
		//rowCell.innerHTML 	=xml_FileNo[r_loop].childNodes[0].nodeValue;		
		//<input name="txtFileNo" type="text" maxlength="100" id="txtFileNo" size="25" />
		
		var rowCell 	  	= row.insertCell(12);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_PONo[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(13);
		rowCell.className 	= "normalfntMid";
		rowCell.noWrap	  	="nowrap"
		rowCell.innerHTML 	=xml_Meterial[r_loop].childNodes[0].nodeValue;
						
		var rowCell 	  	= row.insertCell(14);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_ISDNo[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
		
		var rowCell 	  	= row.insertCell(15);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_GarmentType[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(16);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_NoOfCtn[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(17);
		rowCell.className 	= "normalfntRite";
		rowCell.innerHTML 	=xml_Qty[r_loop].childNodes[0].nodeValue;
		
		
		
		var rowCell 	  	= row.insertCell(18);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Fabric[r_loop].childNodes[0].nodeValue;
		//rowCell.noWrap	  	="nowrap"
		
		
		
		
		var rowCell 	  	= row.insertCell(19);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=(xml_BL[r_loop].childNodes[0].nodeValue.trim()==""?xml_HAWB[r_loop].childNodes[0].nodeValue:xml_BL[r_loop].childNodes[0].nodeValue);
		
		var rowCell 	  	= row.insertCell(20);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_ContNo[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(21);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_ContSize[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(22);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_FreightPay[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(23);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_PayTerm[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(24);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_DesCountry[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(25);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_DesPort[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(26);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Agent[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(27);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_ExFTY[r_loop].childNodes[0].nodeValue;
		rowCell.noWrap	  	="nowrap"
				
		var rowCell 	  	= row.insertCell(28);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_DateOfExport[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(29);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_DocumentDueDate[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(30);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_DocumentSubDate[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(31);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_PaymentDueDate[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(32);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_PaymentSubDate[r_loop].childNodes[0].nodeValue;		
				
		var rowCell 	  	= row.insertCell(33);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	=xml_Month[r_loop].childNodes[0].nodeValue;
		
		var rowCell 	  	= row.insertCell(34);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	="<img class=\"mouseover btnVW\"onclick=\"view_cinv(this)\" tabindex=\"26\" src=\"../../images/view.png\"  id=\"btnView\" />";		
		prev_INV=nw_INV;
		
	}
	
	hidePleaseWait();
	pl_fix_header();
	set_selective()
	
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
	$("#tblER").fixedHeader({
	width: 950,height: 500
	});	
}

function view_cinv(obj)
{
	var invno=obj.parentNode.parentNode.cells[0].innerHTML;	
	window.open("../Preshipmentdocs/Commercialinvoice/Commercialinvoice.php?invno="+invno,"final_inv")
}


function set_selective()
{
	/*$('#tblER tbody tr').mouseover(function(){
			if($(this).attr('bgColor')!='#D2E355'){
			pub_bg_olor_over=$(this).attr('bgColor')
			$(this).attr('bgColor','#D2E3B7')}
	})
	$('#tblER tbody tr').mouseout(function(){
			if($(this).attr('bgColor')!='#D2E355'){
			$(this).attr('bgColor',pub_bg_olor_over)}
			//$(this).removeAttr('bgColor')
	})*/
	
	$('#tblER tbody tr').click(function(){
		if($(this).attr('bgColor')!='#D2E355'){
			var color=$(this).attr('bgColor')
			$(this).attr('bgColor','#D2E355')	
			if(prev_row_no!=-99){
			$('#tblER tbody')[0].rows[prev_row_no].bgColor=pub_bg_color_click;	
			}
			if(prev_row_no==$(this).index())
			{
				prev_row_no=-99
			}
			else
			prev_row_no=$(this).index()			
			pub_bg_color_click=color
			
			}
			
			
	})
}

function export_to_excel(){
	
	var  Reg_type			=$('#cboInvoiceType').val();
	var  dateFrom			=$('#txtDateFrom').val();
	var  dateTo				=$('#txtDateTo').val();	
	del_tbl_reset();	
	
	var url				  ='exportregistry_excel.php?request=load_er_grid&dateFrom='+dateFrom+'&dateTo='+dateTo+'&Reg_type='+Reg_type;
	
	window.open(url,'excl')
}


function changeCDNInvCombo(obj,evt)
{
		document.getElementById('txtbuyer').value ='';
		document.getElementById('txtCDNBuyerPO').value ='';
		//document.getElementById('txtCDNInvNo').value ='';
		document.getElementById('txtStyleNo').value ='';
	
	
	if (evt.keyCode == 13)
	{
		var invoice_No=document.getElementById('txtCDNInvNo').value;
		
		var url     = "exportregistrydb.php?request=loadInv&invoice_No="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		var invoice_No=htmlobj.responseText;
		load_pl_grid(invoice_No,1);

	}
}



function changeCDNPoCombo(obj,evt)
{
			
		document.getElementById('txtbuyer').value ='';
		//document.getElementById('txtCDNBuyerPO').value ='';
		document.getElementById('txtCDNInvNo').value ='';
		document.getElementById('txtStyleNo').value ='';
	
	if (evt.keyCode == 13)
	{
		var po_No=document.getElementById('txtCDNBuyerPO').value;
		
		var url     = "exportregistrydb.php?request=loadpo_No&po_No="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		var poNo=htmlobj.responseText;
		//alert(poNo);
		load_pl_grid(poNo,2);

	}
}

function changeStyleNoCombo(obj,evt)
{
	//
	
	if (evt.keyCode == 13)
	{
		document.getElementById('txtbuyer').value ='';
		document.getElementById('txtCDNBuyerPO').value ='';
		document.getElementById('txtCDNInvNo').value ='';
		
		
		var StyleNo=document.getElementById('txtStyleNo').value;
		
		var url     = "exportregistrydb.php?request=loadtxtStyleNo&StyleNo="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		var StyleID=htmlobj.responseText;
		//alert(StyleID);
		load_pl_grid(StyleID,3);

	}
}


function changetxtbuyerCombo(obj,evt)
{
		//document.getElementById('txtbuyer').value ='';
		document.getElementById('txtCDNBuyerPO').value ='';
		document.getElementById('txtCDNInvNo').value ='';
		document.getElementById('txtStyleNo').value ='';
	
	if (evt.keyCode == 13)
	{
		var Buyername=document.getElementById('txtbuyer').value;
		
		var url     = "exportregistrydb.php?request=loadbuyer&Buyername="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		var StyleID=htmlobj.responseText;
		//alert(Buyername);
		load_pl_grid(Buyername,4);
		

	}
}