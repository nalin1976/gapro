//MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMcommonMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
var  xmlHttp=[];
var pub_records=0;
var pub_response_count=0;
var number_range=0;
var pub_total_quantity=0;
var pub_bundle_no=0;
var pub_bundles=0;
var pub_edit=0;
var pub_text_box="<input name=\"txtCutNo\" type=\"text\" class=\"txtbox\" id=\"txtCutNo\" style=\"width:180px\"  maxlength=\"40\" tabindex=\"8\"/>";
var pub_combo_box="<select name=\"txtCutNo\" class=\"txtbox\" style=\"width:180px;\" id=\"txtCutNo\"  tabindex=\"5\"  onchange=\"ViewSizinGrid();\"><option></option></select>";

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}

function deleterows(tableName)
	{	
		var tbl = document.getElementById(tableName);
		for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	

function rowclickColorChangetbl()
{
	var rowIndex = this.rowIndex;
	var tablez=this.id;
	var tbl = document.getElementById(tablez);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)	
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function colorSetter(tablez)
{
	
	
	var tbl = document.getElementById(tablez);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		
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



//ENDCOMMONMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM

function filterStyle()
{
	
	var buyer=document.getElementById("cboBuyer").value;	
			RomoveData("cmbStyle");
			createNewXMLHttpRequest(3);
			xmlHttp[3].onreadystatechange=function()
			{
						if(xmlHttp[3].readyState==4 && xmlHttp[3].status==200)
						{
							var XMLstyleno=xmlHttp[3].responseXML.getElementsByTagName('StyleId');
							var XMLstylename=xmlHttp[3].responseXML.getElementsByTagName('Style');
							for (var loop=0; loop<XMLstyleno.length;loop++)
							{
									var opt 		= document.createElement("option");
									opt.text 	= XMLstylename[loop].childNodes[0].nodeValue;
									opt.value 	= XMLstyleno[loop].childNodes[0].nodeValue;
									document.getElementById("cmbStyle").options.add(opt);
							}
						}	
			}
			xmlHttp[3].open("GET",'cuttingdataentrydb.php?request=filter&buyer='+buyer,true);
			xmlHttp[3].send(null);	
				
	
}




function get_size_Qtys()
{
	
	var cuttype=document.getElementById("cbo_cut_type").value;
	var style=document.getElementById("cmbStyle").value;
	var url="cuttingdataentrydb.php?request=getStyleQtys&style="+style+'&cuttype='+cuttype;
	htmlobj1=$.ajax({url:url,async:false});
	try{
	var xmlcutqty=htmlobj1.responseXML.getElementsByTagName('cutqty');
	var xmlorderqty=htmlobj1.responseXML.getElementsByTagName('orderqty');
	var xmlExPercentage=htmlobj1.responseXML.getElementsByTagName('ExPercentage');
	var xmlaccumulated=htmlobj1.responseXML.getElementsByTagName('accumulated');	
	document.getElementById("txtOrderQty").value=xmlorderqty[0].childNodes[0].nodeValue;
	document.getElementById("exPercentage").value=xmlExPercentage[0].childNodes[0].nodeValue;
	document.getElementById("txtAccumulated").value=xmlaccumulated[0].childNodes[0].nodeValue;
	document.getElementById("initAccumilateQty").value=Number(xmlaccumulated[0].childNodes[0].nodeValue);
	document.getElementById("txtTotalCut").value=0;
	}
	catch(err){
		document.getElementById("txtOrderQty").value=0;
		document.getElementById("txtAccumulated").value=0;
		document.getElementById("txtTotalCut").value=0;
		document.getElementById("exPercentage").value=0;	
		
		}
	
}





function LoadColor()
{
		
	var Style		=document.getElementById("cmbStyle").value;
	var url			='cuttingdataentrydb.php?request=check_fabric&style='+Style;
	var xmlhttpobj	=$.ajax({url:url,async:false});
	if(xmlhttpobj.responseText.trim()!="exist")
	{
		alert("Fabric not issued to proceed the cut.")
		RomoveData("cmbColor");
		RomoveData("cboSize");
		deleterows('tblLayer');	
		deleterows('tblSizes');	
		$("#txtOrderQty").val("");
		$("#exPercentage").val("0");
		$("#txtAccumulated").val("");
		$("#txtTotalCut").val("");
		$("#txtSWQty").val("");
		$("#txtSWCutQty").val("");
		return;
	}
	
	document.getElementById("txtSWQty").value="";
	document.getElementById("txtSWCutQty").value="";
	set_Buyer();
	get_size_Qtys();
	if(Style!="")
			{
				
			if(pub_edit==1)
			pop_edit_cutnos()
			RomoveData("cmbColor");
			createNewXMLHttpRequest(4);
			xmlHttp[4].onreadystatechange=function()
				{
							if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
									{
										var XMLColor=xmlHttp[4].responseXML.getElementsByTagName('Color');
									
										for (var loop=0; loop<XMLColor.length;loop++)
												{
														var opt 		= document.createElement("option");
														opt.text 	= XMLColor[loop].childNodes[0].nodeValue;
														opt.value 	= XMLColor[loop].childNodes[0].nodeValue;
														document.getElementById("cmbColor").options.add(opt);
														document.getElementById("cmbColor").value=XMLColor[loop].childNodes[0].nodeValue;
														loadLayers();
												}
									}	
				}
			xmlHttp[4].open("GET",'cuttingdataentrydb.php?request=filterColor&Style='+Style,true);
			xmlHttp[4].send(null);	
		
		}
	
	
}



function loadLayers()
{
	var tblComponent		= document.getElementById('tblLayer');

	deleterows('tblLayer');	
	deleterows('tblSizes');		
	var no=1;								
	for(var loop=0;loop<22;loop++)
	{
		var lastRow 		= tblComponent.rows.length;	
		var row 			= tblComponent.insertRow(lastRow);
		
		if(loop % 2 ==0)
			row.className ="bcgcolor-tblrowWhite";				
		else
			row.className ="bcgcolor-tblrow";
		
		row.onclick	= rowclickColorChangetbl;
		row.id='tblLayer';
		
		var rowCell = row.insertCell(0);
		rowCell.className ="normalfntMid";			
		rowCell.innerHTML =no;
		
		
		var rowCell = row.insertCell(1);
		rowCell.className ="normalfntMid";			
		rowCell.innerHTML ="<input name=\"txtEstimate\"type=\"text\"class=\"txtbox keymove\"onblur=\"cal_current_tot(this)\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"12\" maxlength=\"20\" height=\"10\" style=\"text-align:right\" />";
		
		
		var rowCell = row.insertCell(2);
		rowCell.className ="normalfntMid";			
		rowCell.innerHTML ="<input type=\"text\"style=\"text-align:center\"class=\"txtbox keymove\" maxlength=\"20\"size=\"10\"/>";
		no++;
		
	}
loadsize();
//BEGIN - 11-06-2011 - Move row cells using arrow keys
	BundleEntryEventSetter_layer();
//END - 11-06-2011 - Move row cells using arrow keys
}


function loadsize()
{
	
	var Style=document.getElementById("cmbStyle").value;
	var color=document.getElementById("cmbColor").value;
	if(Style!="" && color!="")
		{	
			RomoveData("cboSize");
			createNewXMLHttpRequest(5);
			xmlHttp[5].onreadystatechange=function()
				{
							if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
									{
										var XMLSize=xmlHttp[5].responseXML.getElementsByTagName('Size');
									
										for (var loop=0; loop<XMLSize.length;loop++)
												{		
														var opt 	= document.createElement("option");
														opt.text 	= XMLSize[loop].childNodes[0].nodeValue;
														opt.value 	= XMLSize[loop].childNodes[0].nodeValue;
														document.getElementById("cboSize").options.add(opt);
												}
									}	
				}
			xmlHttp[5].open("GET",'cuttingdataentrydb.php?request=filterSize&Style='+Style+'&color='+URLEncode(color),true);
			xmlHttp[5].send(null);	
		
		}
	
	}

function addSiztoGrid()
{
	if(!emptyFields())
	{
		alert("Please Select the Cut Type !");
	}
	else
	{
		if(document.getElementById("cboSize").value.trim()!="")
		{
			var tbl=document.getElementById("tblSizes");
			var edge=parseFloat(document.getElementById("txtGarments").value);
			document.getElementById("txtGarments").value=""
			for(var loop=0;loop<edge;loop++)
			{
				var lastRow 		= tbl.rows.length;	
				var row 			= tbl.insertRow(lastRow);
																		
				if(lastRow % 2 ==0)
					row.className ="bcgcolor-tblrow";			
				else
					row.className ="bcgcolor-tblrowWhite";				
				
				row.onclick	= rowclickColorChangetbl;
				row.id='tblSizes';
				
				var rowCell = row.insertCell(0);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<img src=\"../../../images/del.png\"onclick=\"remove_size_from_grid(this);\"alt=\"del\"width=\"15\"height=\"15\"/>";
				
				var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =document.getElementById("cboSize").value;
				
				var rowCell = row.insertCell(2);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"text\"style=\"text-align:center\"class=\"txtbox keymove_size\" maxlength=\"10\"size=\"10\"/>";												
			}
					cal_current_tot(0);
		}
		else
			deleterows("tblSizes");
			
	BundleEntryEventSetter_Size();
	}
}

function emptyFields()
{
	var cutType=$("#cbo_cut_type").val();	 
	
	if(cutType=="")
	{
		return false;
	}
	else
		return true;
}


function clearForm()
{
		document.getElementById("cboBuyer").value="";
		document.getElementById("txtCutDate").value="";
		document.getElementById("cmbStyle").value="";
		document.getElementById("txtPatternNo").value="";
		document.getElementById("cboToFactory").value="";
		document.getElementById("cmbColor").value="";
		document.getElementById("cboCompany").value="";
		document.getElementById("txtShift").value="";
		document.getElementById("txtCutNo").value="";
		document.getElementById("cboSize").value="";
		document.getElementById("txtGarments").value="";
		document.getElementById("txtPlyHeight").value="";
		document.getElementById("txtPcs").value="";
		document.getElementById("txtMarkerLength").value="";
		document.getElementById("txtInvoiceNo").value="";
		document.getElementById("txtSWQty").value="";
		document.getElementById("txtSWCutQty").value="";	
		document.getElementById("txtSWQty").value=0;
		document.getElementById("txtSWCutQty").value=0;
}


function saveForm()
{
	
}


function validateForm()
{
	/*if(document.getElementById("cboBuyer").value.trim()=="")
		{
			alert ("Please select a Buyer");
			document.getElementById("cboBuyer").focus();
			return false;
		}*/
	 if(document.getElementById("cboFromFactory").value.trim()=="")
		{
			alert ("Please enter the From Factory");
			document.getElementById("cboFromFactory").focus();
			return false;
		}	
	 else if(document.getElementById("cboToFactory").value.trim()=="")
		{
			alert ("Please enter the To Factory");
			document.getElementById("cboToFactory").focus();
			return false;
		}
	else if(document.getElementById("txtShift").value.trim()=="")
		{
			alert ("Please select the shift");
			document.getElementById("txtShift").focus();
			return false;
		}
	else if(document.getElementById("cbo_cut_type").value.trim()=="")
		{
			alert ("Please select the Cut type");
			document.getElementById("cbo_cut_type").focus();
			return false;
		}
	else if(document.getElementById("cmbStyle").value.trim()=="")
		{
			alert ("Please select a Style");
			document.getElementById("cmbStyle").focus();
			return false;
		}
	else if(document.getElementById("cmbColor").value.trim()=="")
		{
			alert ("Please select a Color");
			document.getElementById("cmbColor").focus();
			return false;
		}
	else if(document.getElementById("txtPatternNo").value.trim()=="")
		{
			alert ("Please Enter a Pattern Number");
			document.getElementById("txtPatternNo").focus();
			return false;
		}
	else if(document.getElementById("txtCutNo").value.trim()=="")
		{
			alert ("Please enter the Cut Number");
			document.getElementById("txtCutNo").focus();
			return false;
		}
	else if(document.getElementById("txtCutDate").value.trim()=="")
		{
			alert ("Please enter the Cut Date");
			document.getElementById("txtCutDate").focus();
			return false;
		}
	else if (document.getElementById("tblSizes").rows.length<=1)
		{
			alert ("Sorry, there is no record to save");
			return false;
		}
	
	else		
			return true;
	
}

function saveHeader()
{
	
	if(validateForm())
	{
		var buyer=document.getElementById("cboBuyer").value;
		var cutdate=document.getElementById("txtCutDate").value;
		var style=document.getElementById("cmbStyle").value;
		var patternno=document.getElementById("txtPatternNo").value.trim();
		var tofactory=document.getElementById("cboToFactory").value;
		var color=document.getElementById("cmbColor").value;
		var from_factory=document.getElementById("cboFromFactory").value;
		var shifts=document.getElementById("txtShift").value;
		
		var cut_type=document.getElementById("cbo_cut_type").value;
		
		
		if(pub_edit==0)
		{	
			if(!check_cutno())
				{
					alert ("Sorry, the cut number entered is already exist");
					document.getElementById("txtCutNo").focus();
					return false;
				}
			var cutno=document.getElementById("txtCutNo").value.trim();
		}
		else
		{
			var cutno=document.getElementById("txtCutNo").options[document.getElementById("txtCutNo").selectedIndex].text;
			del_before_save();
		}		
		var size=document.getElementById("cboSize").value;
		var garment=document.getElementById("txtGarments").value;
		var plyheight=document.getElementById("txtPlyHeight").value;
		var pcs="1";
		var markerlength=document.getElementById("txtMarkerLength").value;
		var invoiceno=document.getElementById("txtInvoiceNo").value;
		var bundle_serial=document.getElementById("bundleSerial").value;
		var spreader=document.getElementById("cmbSpreader").value;
		var totpcs=calTot();
		
		
		showBackGroundBalck();
		createNewXMLHttpRequest(6);
		xmlHttp[6].onreadystatechange=function()
			{
						if(xmlHttp[6].readyState==4 && xmlHttp[6].status==200)
								{
									
									var str=xmlHttp[6].responseXML.getElementsByTagName('resultz')[0].childNodes[0].nodeValue;
									
									
									
									if(str=="ok"){
									var serial=xmlHttp[6].responseXML.getElementsByTagName('serial')[0].childNodes[0].nodeValue;
									var bundleno=xmlHttp[6].responseXML.getElementsByTagName('bundleno')[0].childNodes[0].nodeValue;
									var range=xmlHttp[6].responseXML.getElementsByTagName('numrange')[0].childNodes[0].nodeValue;
									document.getElementById("bundleSerial").value=serial;
									document.getElementById("bundleno").value=bundleno;
									document.getElementById("numberrange").value=range;	
										
									saveDetail();}
									else
									hideBackGroundBalck();
									
										
								}	
			}
		xmlHttp[6].open("GET",'cuttingdataentrydb.php?request=saveHeader&buyer='+buyer+'&cutdate='+URLEncode(cutdate)+'&style='+style+'&patternno='+URLEncode(patternno)+'&tofactory='+tofactory+'&color='+URLEncode(color)+'&from_factory='+from_factory+'&shifts='+shifts+'&cutno='+URLEncode(cutno)+'&size='+size+'&garment='+garment+'&plyheight='+URLEncode(plyheight)+'&pcs='+pcs+'&markerlength='+URLEncode(markerlength)+'&invoiceno='+URLEncode(invoiceno)+'&bundle_serial='+bundle_serial+'&totpcs='+totpcs+'&bundles='+pub_bundles+'&cut_type='+cut_type,true);
		xmlHttp[6].send(null);			
		
	}

}


function saveDetail()
{
	var tblSizes=document.getElementById("tblSizes");
	var tblLayer=document.getElementById("tblLayer");
	var bundleno=document.getElementById("bundleno").value;
	number_range=document.getElementById("numberrange").value;
	
	p_number=number_range;
	n_number=0;
	var pcs_in_layer=0;
	if(tblSizes.rows.length>1 && tblLayer.rows.length>1)
	{
		for(var loopsize=1;loopsize<tblSizes.rows.length;loopsize++)
		{
			for (var looplayers=1;looplayers<tblLayer.rows.length;looplayers++)
				{
					if(tblLayer.rows[looplayers].cells[1].childNodes[0].value!="")
						{
							var size=tblSizes.rows[loopsize].cells[1].childNodes[0].nodeValue+"-"+tblSizes.rows[loopsize].cells[2].childNodes[0].value;
							var layno=tblLayer.rows[looplayers].cells[0].childNodes[0].nodeValue;
							var shade=tblLayer.rows[looplayers].cells[2].childNodes[0].value;
							var pcs=tblLayer.rows[looplayers].cells[1].childNodes[0].value;
							n_number=parseFloat(p_number)+parseFloat(pcs);
							var n_m_number=parseFloat(p_number)+parseFloat(pcs)-1;
							var str_numberrange=p_number+"-"+n_m_number;
							pub_records++;
							bundleno++;
							do_save_detail(size,shade,pcs,str_numberrange,bundleno,layno);
							p_number=n_number;
						}
				}
		}
			bundleno++;
			number_range=n_number;
			pub_bundle_no=bundleno;
			save_verify();
	}	
}

function do_save_detail(size,shade,pcs,num_range,bundleno,layno)
{	
	var bundle_serial=document.getElementById("bundleSerial").value;
	var style=document.getElementById("cmbStyle").value;
	createNewXMLHttpRequest(7);
	xmlHttp[7].onreadystatechange=function()
			{
						if(xmlHttp[7].readyState==4 && xmlHttp[7].status==200)
								{
									
								}	
			}
		xmlHttp[7].open("GET",'cuttingdataentrydb.php?request=saveDetail&size='+URLEncode(size)+'&shade='+URLEncode(shade)+'&pcs='+URLEncode(pcs)+'&bundle_serial='+bundle_serial+'&num_range='+num_range+'&bundleno='+bundleno+'&style='+URLEncode(style)+'&layno='+layno,true);
		xmlHttp[7].send(null);	
	
	
}

function save_verify()
{
	createNewXMLHttpRequest(8);	
	var bundle_serial=document.getElementById("bundleSerial").value;
	xmlHttp[8].onreadystatechange=function()
			{			
							
						if(xmlHttp[8].readyState==4 && xmlHttp[8].status==200)
								{
									var str=xmlHttp[8].responseText;
									if(str=="ok"){
											alert("Saved successfully.");pub_records=0;syscontrol();
											hideBackGroundBalck();
											new_cut();
											}
									else 
											setTimeout("save_verify()",1000);
									
								}	
			}
	xmlHttp[8].open("GET",'cuttingdataentrydb.php?request=saveVerify&pub_records='+pub_records+'&bundle_serial='+bundle_serial,true);
	xmlHttp[8].send(null);	
}

function calTot()
{
	var tblSizes=document.getElementById("tblSizes");
	var tblLayer=document.getElementById("tblLayer");
	var garments=0;
	var pcs_in_layer=0;
	var pcs=0;
	var cnt=0;
	
	for (var looplayers=1;looplayers<tblLayer.rows.length;looplayers++)
		{
			if(tblLayer.rows[looplayers].cells[1].childNodes[0].value!="")
						{	
							pcs=tblLayer.rows[looplayers].cells[1].childNodes[0].value;
							pcs_in_layer+=parseFloat(pcs);
							cnt++;
						}
		}
		var totpcs=pcs_in_layer*(tblSizes.rows.length-1);
		pub_bundles=cnt*(tblSizes.rows.length-1);
		return totpcs;
}

function syscontrol()
{	
	
	createNewXMLHttpRequest(9);	
	var bundle_serial=document.getElementById("bundleSerial").value;
	var styleid=document.getElementById("bundleSerial").value;
	xmlHttp[9].onreadystatechange=function()
			{			
							
						if(xmlHttp[9].readyState==4 && xmlHttp[9].status==200)
								{
									
								}	
			}
	xmlHttp[9].open("GET",'cuttingdataentrydb.php?request=syscontrol&number_range='+number_range+'&pub_bundle_no='+pub_bundle_no,true);
	xmlHttp[9].send(null);
	
}


function print_form()
{
	showBackGround('divBG',0);	
	var bundle_serial=document.getElementById("bundleSerial").value;
	var url = 'popPrint.php?request=syscontrol';
	var htmlobj=$.ajax({url:url,async:false});
	drawPopupArea(450,440,'frmNewOrganize');
	document.getElementById("frmNewOrganize").innerHTML=htmlobj.responseText;
	document.getElementById("cmbpopStyle").value=document.getElementById("cmbStyle").value;
	pop_cutnos();
}

function pop_cutnos()
{	load_com_to_print();
	createNewXMLHttpRequest(11);	
	var style=document.getElementById("cmbpopStyle").value;
		
	loadCombo( "select intCutBundleSerial,strCutNo from productionbundleheader where intStyleId='"+style+"' order by strCutNo ","cmbpopCutNo");
	
}

function bundlesummery()
{
	if (document.getElementById("cmbpopStyle").value=="")
	{
		alert("Please select the style.");
		document.getElementById("cmbpopStyle").focus()
		return false;
	}
	if (document.getElementById("cmbpopCutNo").value=="")
	{
		alert("Please select the cut number.");
		document.getElementById("cmbpopCutNo").focus()
		return false;
	}
	var cutno=document.getElementById("cmbpopCutNo").options[document.getElementById("cmbpopCutNo").selectedIndex].text;
	var style=document.getElementById("cmbpopStyle").value;
	var size=document.getElementById("cmbPopBundleSizes").value;
	tbl=document.getElementById("tblpopprintSizes")
			var count=0;
			var query_cat = "";
			var query_com = "";
			for(var loop=1;loop<tbl.rows.length;loop++)
				{	
				if(tbl.rows[loop].cells[0].childNodes[0].checked==true)
					{
					count++;
						 if (count==1){var query_cat=tbl.rows[loop].cells[0].id;var query_com=tbl.rows[loop].cells[1].id;}
						 else{
						 query_cat+=","+tbl.rows[loop].cells[0].id;
						 query_com+=","+tbl.rows[loop].cells[1].id;}
					}
			
				}
	if(document.getElementById("rpt1").checked==true)
	window.open('rptBundleSummary.php?cutno='+cutno+'&style='+style,'name');
		else if(document.getElementById("rpt2").checked==true)
		window.open('bundleSticker.php?cutno='+cutno+'&style='+style+ '&Size='+size,'name');
	else if(document.getElementById("rpt4").checked==true)
		window.open('a4bundleSticker.php?cutno='+cutno+'&style='+style+'&query_com='+query_com+'&query_cat='+query_cat+ '&Size='+size,'name');
	else if(document.getElementById("rpt3").checked==true)
	{				
		window.open('bundleSticker.php?cutno='+cutno+'&style='+style+'&query_com='+query_com+'&query_cat='+query_cat+ '&Size='+size,'name');
		window.focus;
	}
}

function popfilterStyle()
{
	
	var buyer=document.getElementById("cbopopBuyer").value;	
	if(buyer!="")
		{	
			RomoveData("cmbpopStyle");
			createNewXMLHttpRequest(12);
			xmlHttp[12].onreadystatechange=function()
			{
						if(xmlHttp[12].readyState==4 && xmlHttp[12].status==200)
						{
							var XMLstyleno=xmlHttp[12].responseXML.getElementsByTagName('StyleId');
							var XMLstylename=xmlHttp[12].responseXML.getElementsByTagName('Style');
							for (var loop=0; loop<XMLstyleno.length;loop++)
							{
									var opt 		= document.createElement("option");
									opt.text 	= XMLstylename[loop].childNodes[0].nodeValue;
									opt.value 	= XMLstyleno[loop].childNodes[0].nodeValue;
									document.getElementById("cmbpopStyle").options.add(opt);
							}
						}	
			}
			xmlHttp[12].open("GET",'cuttingdataentrydb.php?request=filter&buyer='+buyer,true);
			xmlHttp[12].send(null);	
		
		}
		
		
}

function remove_size_from_grid(obj)
{
	//alert(obj.parentNode.parentNode.parentNode.innerHTML);
	obj.parentNode.parentNode.parentNode.deleteRow(obj.parentNode.parentNode.rowIndex);
}

function new_cut()
{
	pub_edit=0;
	loadLayers();
	/*BEGIN - 22-06-2011 Some cut no's are too long therefore user cannot type cut no again and again
	document.getElementById("cut_no_cell").innerHTML=pub_text_box; 
	END - 22-06-2011 Some cut no's are too long therefore user cannot type cut no again and again*/
	deleterows('tblSizes');
	//document.getElementById("txtCutNo").value="";
	document.getElementById("txtSWQty").value="";
	document.getElementById("txtSWCutQty").value="";
	document.getElementById("txtCutNo").focus();	
}

function popEdit()
{
	var url="popEdit.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupArea(450,330,'frmPopEdit');
	document.getElementById("frmPopEdit").innerHTML=htmlobj.responseText;
	document.getElementById("cmbpopStyle").value=document.getElementById("cmbStyle").value;
	pop_edit_cutnos();
}

function load_edit_size_grid()
{
	var serial=document.getElementById("cmbpopEditCut").value;
	var url="cuttingdataentrydb.php?request=getsizetoedit&serial="+serial;
	htmlobj=$.ajax({url:url,async:false});
	var tbl=document.getElementById("tblChangeSizes");
	var xmlSize=htmlobj.responseXML.getElementsByTagName('size');
	deleterows('tblChangeSizes');			
	for(var loop=0;loop<xmlSize.length;loop++)
		{
			var lastRow 		= tbl.rows.length;	
			var row 			= tbl.insertRow(lastRow);
																	
			if(lastRow % 2 ==0)
				row.className ="bcgcolor-tblrow";			
			else
				row.className ="bcgcolor-tblrowWhite";	
				
			
			row.onclick	= rowclickColorChangetbl;
			row.id='tblChangeSizes';
			
			var rowCell = row.insertCell(0);
			rowCell.className ="normalfntMid";			
			rowCell.innerHTML ="<img src=\"../../../images/del.png\"onclick=\"remove_size_from_grid(this);\"alt=\"del\"width=\"15\"height=\"15\"/>";
			
			var rowCell = row.insertCell(1);
			rowCell.className ="normalfntMid";			
			rowCell.innerHTML =xmlSize[loop].childNodes[0].nodeValue;
			
			var rowCell = row.insertCell(2);
			rowCell.className ="normalfntMid";			
			rowCell.innerHTML ="<input type=\"text\"style=\"text-align:center;width=100px;\"class=\"txtbox\"maxlength=\"20\"value="+xmlSize[loop].childNodes[0].nodeValue;+"\"/>";
		}
}

function pop_edit_cutnos()
{
	loadCombo( "SELECT intCutBundleSerial, strCutNo FROM productionbundleheader where intStyleId='"+document.getElementById("cmbStyle").value+"' order by strCutNo ","txtCutNo");

}

function del_before_save()
{
	var serial=document.getElementById("txtCutNo").value;
	var url="cuttingdataentrydb.php?request=delallcut&serial="+serial;
	htmlobj=$.ajax({url:url,async:false});
}


function delete_cut()
{	if(document.getElementById("txtCutNo").value=="")
	return false;
	if(!confirm("Are you sure you want to delete?"))
	return false;
	var serial=document.getElementById("txtCutNo").value;
	var url="cuttingdataentrydb.php?request=delallcut&serial="+serial;
	htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseText);
	loadCombo( "SELECT intCutBundleSerial, strCutNo FROM productionbundleheader where intStyleId='"+document.getElementById("cmbStyle").value+"' order by strCutNo ","txtCutNo");
	clear_header()
	
}

function save_cut_change()
{
	if(!confirm("Are you sure you want to save changes?"))
	return false;
	var serial=document.getElementById("cmbpopEditCut").value;
	var tbl=document.getElementById("tblChangeSizes");
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var size=tbl.rows[loop].cells[1].childNodes[0].nodeValue;
		var newsize=tbl.rows[loop].cells[2].childNodes[0].value;
		url="cuttingdataentrydb.php?request=saveSizeChange&serial="+serial+"&newsize="+newsize+"&size="+size;
		htmlobj[loop]=$.ajax({url:url,async:false});
	}
	alert ("Saved successfully");
	document.getElementById("cmbpopEditCut").value="";
	deleterows('tblChangeSizes');	
}

function view_for_edit()
{
	pub_edit=1;
	document.getElementById("cut_no_cell").innerHTML=pub_combo_box;
	pop_edit_cutnos();
	
}


function ViewSizinGrid()
{
	load_header();
	ViewLayerGrid();
	var tbl=document.getElementById("tblSizes");
	var serial=document.getElementById("txtCutNo").value;
	var url="cuttingdataentrydb.php?request=getsizetoedit&serial="+serial;
	htmlobj1=$.ajax({url:url,async:false});
	var xmlSize=htmlobj1.responseXML.getElementsByTagName('size');
	var xmlshade=htmlobj1.responseXML.getElementsByTagName('shade');
	deleterows('tblSizes');		
	for(var loop=0;loop<xmlSize.length;loop++)
			{
														var lastRow 		= tbl.rows.length;	
														var row 			= tbl.insertRow(lastRow);
																												
														if(lastRow % 2 ==0)
															row.className ="bcgcolor-tblrow";			
														else
															row.className ="bcgcolor-tblrowWhite";	
															
														
														row.onclick	= rowclickColorChangetbl;
														row.id='tblSizes';
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<img src=\"../../../images/del.png\"onclick=\"remove_size_from_grid(this);\"alt=\"del\"width=\"15\"height=\"15\"/>";
														
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML =rowCell.innerHTML =xmlSize[loop].childNodes[0].nodeValue;
														
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<input type=\"text\"style=\"text-align:center;\"class=\"txtbox\"size=\"10\"maxlength=\"20\"value=\""+xmlshade[loop].childNodes[0].nodeValue+"\"/>";
									
														
			}

	
}

function ViewLayerGrid()
{
	deleterows('tblLayer');
	var tblComponent		= document.getElementById('tblLayer');
	var serial=document.getElementById("txtCutNo").value;
	var url="cuttingdataentrydb.php?request=getlayertoedit&serial="+serial;
	htmlobj2=$.ajax({url:url,async:false});
	var xmlshade=htmlobj2.responseXML.getElementsByTagName('shade');
	var xmlPcs=htmlobj2.responseXML.getElementsByTagName('Pcs');
	
	var no=1;
	for(var p_loop=0;p_loop<xmlshade.length;p_loop++)
			{
														var lastRow 		= tblComponent.rows.length;	
														var row 			= tblComponent.insertRow(lastRow);
														
														if(p_loop % 2 ==0)
															row.className ="bcgcolor-tblrowWhite";				
														else
															row.className ="bcgcolor-tblrow";
														
														row.onclick	= rowclickColorChangetbl;
														row.id='tblLayer';
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML =no;
														
														
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<input name=\"txtEstimate\"type=\"text\"class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"12\" maxlength=\"20\"height=\"10\"onblur=\"cal_current_tot(this)\" style=\"text-align:right\"value=\""+xmlPcs[p_loop].childNodes[0].nodeValue+"\" />";
														
														
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<input type=\"text\"style=\"text-align:center\"class=\"txtbox\" maxlength=\"20\"size=\"10\"value=\""+xmlshade[p_loop].childNodes[0].nodeValue+"\"/>";
														no++;
									
														
			}
			for(var c_loop=p_loop;c_loop<22;c_loop++)
			{
														var lastRow 		= tblComponent.rows.length;	
														var row 			= tblComponent.insertRow(lastRow);
														
														if(c_loop % 2 ==0)
															row.className ="bcgcolor-tblrowWhite";				
														else
															row.className ="bcgcolor-tblrow";
														
														row.onclick	= rowclickColorChangetbl;
														row.id='tblLayer';
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML =no;
														
														
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<input name=\"txtEstimate\"type=\"text\"class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"12\" maxlength=\"20\"onblur=\"cal_current_tot(this)\" height=\"10\" style=\"text-align:right\" />";
														
														
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<input type=\"text\"style=\"text-align:center\"class=\"txtbox\" maxlength=\"20\"size=\"10\"/>";
														no++;
									
														
			}

	
}

function load_header()
{
	
	var serial=document.getElementById("txtCutNo").value;
	var url="cuttingdataentrydb.php?request=getHeaderdata&serial="+serial;
	htmlobj1=$.ajax({url:url,async:false});
	try{
	var FromFactory=htmlobj1.responseXML.getElementsByTagName('FromFactory');
	var ToFactory=htmlobj1.responseXML.getElementsByTagName('ToFactory');
	var Shift=htmlobj1.responseXML.getElementsByTagName('Shift');	
	var cutdate=htmlobj1.responseXML.getElementsByTagName('cutdate');
	var PatternNo=htmlobj1.responseXML.getElementsByTagName('PatternNo');
	var Color=htmlobj1.responseXML.getElementsByTagName('Color');
	var PlyHeight=htmlobj1.responseXML.getElementsByTagName('PlyHeight');	
	var MarkerLength=htmlobj1.responseXML.getElementsByTagName('MarkerLength');	
	var Spreader=htmlobj1.responseXML.getElementsByTagName('Spreader');
	var InvoiceNo=htmlobj1.responseXML.getElementsByTagName('InvoiceNo');	
	var cut_type=htmlobj1.responseXML.getElementsByTagName('cut_type');	
		document.getElementById("txtCutDate").value=cutdate[0].childNodes[0].nodeValue;
		document.getElementById("txtPatternNo").value=PatternNo[0].childNodes[0].nodeValue;
		document.getElementById("cboToFactory").value=ToFactory[0].childNodes[0].nodeValue;
		document.getElementById("cmbColor").value=Color[0].childNodes[0].nodeValue;
		document.getElementById("cboFromFactory").value=FromFactory[0].childNodes[0].nodeValue;
		document.getElementById("txtShift").value=Shift[0].childNodes[0].nodeValue;
		document.getElementById("txtPlyHeight").value=PlyHeight[0].childNodes[0].nodeValue;
		document.getElementById("txtMarkerLength").value=MarkerLength[0].childNodes[0].nodeValue;
		document.getElementById("txtInvoiceNo").value=InvoiceNo[0].childNodes[0].nodeValue;
		document.getElementById("cmbSpreader").value=Spreader[0].childNodes[0].nodeValue;
		document.getElementById("cbo_cut_type").value=cut_type[0].childNodes[0].nodeValue;
		document.getElementById("txtSWQty").value="";
		document.getElementById("txtSWCutQty").value="";
	}
	catch(err){clear_header();
		}
}

function clear_header()
{
		document.getElementById("txtCutDate").value="";
		document.getElementById("txtPatternNo").value="";
		document.getElementById("cboToFactory").value="";
		document.getElementById("cmbColor").value="";
		document.getElementById("cboFromFactory").value="";
		document.getElementById("txtShift").value="";
		document.getElementById("txtPlyHeight").value="";
		document.getElementById("txtMarkerLength").value="";
		document.getElementById("txtInvoiceNo").value="";
		document.getElementById("cmbSpreader").value="";
		deleterows('tblLayer');
		deleterows('tblSizes');	
		document.getElementById("txtSWQty").value="";
		document.getElementById("txtSWCutQty").value="";
}

function load_SW_Qtys()
{
	var size =document.getElementById("cboSize").value;
	var color=document.getElementById("cmbColor").value;
	if(size=="")
	return false;
	var style=document.getElementById("cmbStyle").value;
	var url="cuttingdataentrydb.php?request=load_SW_Qtys&style="+style+"&size="+size+"&color="+color;
	httpobj=$.ajax({url:url,async:false});
	try{
		document.getElementById("txtSWQty").value=(httpobj.responseXML.getElementsByTagName('SW_Order_Qty')[0].childNodes[0].nodeValue==""?0:httpobj.responseXML.getElementsByTagName('SW_Order_Qty')[0].childNodes[0].nodeValue);
		document.getElementById("txtSWCutQty").value=(httpobj.responseXML.getElementsByTagName('SW_Cut_Qty')[0].childNodes[0].nodeValue==""?0:httpobj.responseXML.getElementsByTagName('SW_Cut_Qty')[0].childNodes[0].nodeValue);
		
	}
	catch(err){
		document.getElementById("txtSWQty").value=0;
		document.getElementById("txtSWCutQty").value=0;
					}	
}

function cal_current_tot(obj)
{
	document.getElementById("txtTotalCut").value=calTot();
	var initAccumilateQty = Number(document.getElementById("initAccumilateQty").value);
	document.getElementById("txtAccumulated").value= (initAccumilateQty + calTot());
	
	//qty_validate();
	
	var cuttype=document.getElementById("cbo_cut_type").value;
	if(obj!=0 && (cuttype=='1' || cuttype=='6' || cuttype=='7' || cuttype=='10' || cuttype=='11')){ // 1,6,10,11,7
		if(!qty_validate())
		{
			alert("Total cut quantity cannot exceed the order qty.")
			obj.value='';
			document.getElementById("txtTotalCut").value=calTot();
			document.getElementById("txtAccumulated").value= (initAccumilateQty + calTot());
			obj.focus();
			return false
		}
		
	}
	
}

function load_sizes_to_print(obj)
{
	loadCombo( "SELECT strSize, strSize FROM productionbundledetails where  intCutBundleSerial='"+obj.value+"'group by strSize order by strSize ","cmbPopBundleSizes");
	
}

function load_com_to_print()
{
	
	var style=document.getElementById("cmbpopStyle").value;
	var url	 ='cuttingdataentrydb.php?request=getcomponents&style='+style;
	htmlobj=$.ajax({url:url,async:false});
	var XMLcomponentId	=htmlobj.responseXML.getElementsByTagName('componentid');
	var XMLcomponent	=htmlobj.responseXML.getElementsByTagName('component');
	var XMLcatid		=htmlobj.responseXML.getElementsByTagName('catid');
	deleterows('tblpopprintSizes');
	tbl=document.getElementById("tblpopprintSizes")
	for(var loop=0;loop<XMLcomponentId.length;loop++)
	{
					var lastRow 		= tbl.rows.length;	
					var row 			= tbl.insertRow(lastRow);
																			
					if(lastRow % 2 ==0)
						row.className ="bcgcolor-tblrow";			
					else
						row.className ="bcgcolor-tblrowWhite";	
						
					
					row.onclick	= rowclickColorChangetbl;
					row.id='tblSizes';
					
					var rowCell = row.insertCell(0);
					rowCell.className ="normalfntMid";
					rowCell.height="18"
					rowCell.id=XMLcatid[loop].childNodes[0].nodeValue;
					rowCell.innerHTML ="<input type=\"checkbox\"class=\"txtbox\"/>"
					
					var rowCell = row.insertCell(1);
					rowCell.className ="normalfnt";	
					rowCell.id=XMLcomponentId[loop].childNodes[0].nodeValue;
					rowCell.innerHTML =XMLcomponent[loop].childNodes[0].nodeValue;																											
			
	}	

	
}

function set_Buyer()
{
	var style=document.getElementById("cmbStyle").value;
	document.getElementById("cboBuyer").value=""
	var url='cuttingdataentrydb.php?request=get_style_buyer&style='+style;
	var xmlhttpobj=$.ajax({url:url,async:false});
	document.getElementById("cboBuyer").value=xmlhttpobj.responseText;
}

function check_cutno()
{
	var style=document.getElementById("cmbStyle").value;
	var cut=document.getElementById("txtCutNo").value;
	var url='cuttingdataentrydb.php?request=check_cutno&style='+style+'&cutno='+cut.trim();
	var xmlhttpobj=$.ajax({url:url,async:false});
	if(xmlhttpobj.responseText=='exist')
		return false;
	else 
		return true;
}

function ClosePOPrintWindow()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

//BEGIN - 11-06-2011
function BundleEntryEventSetter_layer()
{
	$('.txtbox.keymove').live('keydown', function(e) {
		var tbl 			= document.getElementById('tblLayer');
		var rw				= tbl.parentNode.parentNode.parentNode;
		var keyCode 		= e.keyCode || e.which;
		var row_cell		= this.parentNode.cellIndex;
		var row_index		= this.parentNode.parentNode.rowIndex;
		$no=1;
		switch(keyCode)
		{			
			case 37: //left
				if(row_cell=='1')
					return;
				row_cell  	= row_cell - $no; 
				break; 	
				
			case 38: //up
				row_index  	= row_index - $no; 
				break; 	
				
			case 39: //right
				if(row_cell=='2')
					return;
				row_cell  	= row_cell + $no; 
				break; 		
				
			case 40: //down
				row_index 	= row_index + $no; 
				break; 	
		}
		var val_row = tbl.rows.length;
			/*if(row_cell<1||row_cell>=start_auto_cell+10||row_index<0||row_index>=val_row)
				return;	*/
		if(row_index<1 || row_index>=val_row)
			return;
		if(keyCode==37 || keyCode==38 || keyCode==39 || keyCode==40)
		{
			tbl.rows[row_index].cells[row_cell].childNodes[0].focus();		
			tbl.rows[row_index].cells[row_cell].childNodes[0].select();
		}
	});

}

function BundleEntryEventSetter_Size()
{
	$('.txtbox.keymove_size').live('keydown', function(e) {
		var tbl 			= document.getElementById('tblSizes');
		var rw				= tbl.parentNode.parentNode.parentNode;
		var keyCode 		= e.keyCode || e.which;
		var row_cell		= this.parentNode.cellIndex;
		var row_index		= this.parentNode.parentNode.rowIndex;
		$no=1;
		switch(keyCode)
		{			
			case 37: //left
				if(row_cell=='2')
					return;
				break; 	
				
			case 38: //up
				row_index  	= row_index - $no; 
				break; 	
				
			case 39: //right
				if(row_cell=='2')
					return;
				break; 		
				
			case 40: //down
				row_index 	= row_index + $no; 
				break; 	
		}
		var val_row = tbl.rows.length;

		if(row_index<1 || row_index>=val_row)
			return;
		if(keyCode==37 || keyCode==38 || keyCode==39 || keyCode==40)
		{
			tbl.rows[row_index].cells[row_cell].childNodes[0].focus();		
			tbl.rows[row_index].cells[row_cell].childNodes[0].select();
		}
	});
}


function qty_validate()
{

	//return false;
	/*var settingexcess=(parseFloat($("#exSettingPercentage").val()))
	var accumulated=parseFloat($("#txtAccumulated").val());
	var ord_qty=parseFloat($("#txtOrderQty").val()*((100+settingexcess+parseFloat($("#exPercentage").val()))/100))
	ord_qty= parseInt(ord_qty);	
	var cut_qty=parseFloat($("#txtTotalCut").val())
	if(cut_qty>ord_qty-accumulated)
	return false;
	else
	return true;*/
	
	var orderQty=parseFloat($("#txtOrderQty").val());
	var accumulated=parseInt($("#txtAccumulated").val());
	var exPercentage=parseFloat($("#exPercentage").val());
	
	//alert("Order"+orderQty);
	//alert("accu"+accumulated);
	//alert("%"+exPercentage);
	
	var maxOrderQty = (orderQty + (orderQty*parseFloat(exPercentage/100)));
	maxOrderQty =  parseInt(maxOrderQty);
	
	//alert("max ordr"+maxOrderQty);
	
	//if(maxOrderQty<accumulated)
	//{
		//alert("True");
	//}
	
	if(maxOrderQty<accumulated)
	return false;
	else
	return true;
	
}

function get_filtered()
{
	var cuttype=document.getElementById("cbo_cut_type").value;
	var style=document.getElementById("cmbStyle").value;
	if(cuttype!='' && style!='')
	get_size_Qtys()
	
}