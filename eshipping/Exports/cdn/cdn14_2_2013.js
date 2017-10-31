// JavaScript Document
var pub_invNo = 0;
var pub_cdnNo = 0;
var pub_loadCDNNo = 0;

var xmlHttp =[];
var position=0;
var count=0;

var item=0;
var verpos=0;
var prev_hs		="";
var prev_desc	="";
var prev_fabric	="";
var ctn_combo = "";
//gen_ctns_combo();

$(document).ready(function() 
{
		
		var url					='cdndb.php?request=loadDriverName';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		//alert(pub_po_arr);
		
		$( "#txtDriver" ).autocomplete({
			source: pub_po_arr
		});

		var url1				='cdndb.php?request=loadCleanerName';
		var pub_xml_http_obj1	=$.ajax({url:url1,async:false});
		var pub_Cl_arr			=pub_xml_http_obj1.responseText.split("|");
		
		$( "#txtCleaner" ).autocomplete({
			source: pub_Cl_arr
		});
		

		
		var url3				='cdndb.php?request=loadCDNInvDesc';
		var pub_xml_http_obj3	=$.ajax({url:url3,async:false});
		var pub_dec_arr			=pub_xml_http_obj3.responseText.split("|");
		
		$( "#txtareaDisc" ).autocomplete({
			source: pub_dec_arr
		});
		
		var url4				='cdndb.php?request=loadCDNInvFab';
		var pub_xml_http_obj4	=$.ajax({url:url4,async:false});
		var pub_fb_arr			=pub_xml_http_obj4.responseText.split("|");
		
		$( "#txtFabric" ).autocomplete({
			source: pub_fb_arr
		});

});


function abc_pre()
{
	clearPage();
	//Pen_cdn();
	var url6	='cdndb.php?request=loadpendingCDNToInvUsingPo';
			var pub_xml_http_obj6	=$.ajax({url:url6,async:false});
			//alert(pub_xml_http_obj6.responseText);
			var pub_pending_arr		=pub_xml_http_obj6.responseText.split("|");
		
			$( "#txtpendingCDNInvNo" ).autocomplete({
			source: pub_pending_arr
			//	alert(pub_xml_http_obj.responseText);
		});	
//Pen_cdn();
		
}


//function Pen_cdn()
//{
//	var chkVal=$('#Pending_Cdn').is(':checked');
//		
//	  if(chkVal)
//	  	var chkCdn=1;
//	  else
//	  	var chkCdn=0;
//		
//		//alert(chkCdn);
//		
//		if(chkCdn==1)
//		{
//			//alert("AS");
//			var url7	='cdndb.php?request=loadpending';
//			var pub_xml_http_obj7	=$.ajax({url:url7,async:false});
//			//alert(pub_xml_http_obj6.responseText);
//			var pub_pending_arr		=pub_xml_http_obj7.responseText.split("|");
//		
//			$( "#txtpendingCDNInvNo" ).autocomplete({
//			source: pub_pending_arr
//			//	alert(pub_xml_http_obj.responseText);
//		});	
//		}
//					
//}

//function cdn_cersh()
//{
////var ctn_srch     = ($('#ctn_measure')[0].checked==true?1:0);
//	alert("oi");
//}




function abc_InvNo()
{
var url2				='cdndb.php?request=loadCDNInv';
		var pub_xml_http_obj2	=$.ajax({url:url2,async:false});
		var pub_in_arr			=pub_xml_http_obj2.responseText.split("|");
		
		$( "#txtCDNInvNo" ).autocomplete({
			source: pub_in_arr
		});		
}


function abc_BuyerPO()
{
var url5				='cdndb.php?request=loadCDNPo';
		var pub_xml_http_obj5	=$.ajax({url:url5,async:false});
		var pub_po_arr			=pub_xml_http_obj5.responseText.split("|");
		
		$( "#txtCDNBuyerPO" ).autocomplete({
			source: pub_po_arr
			
		});		
}




function gen_ctns_combo()
{
	
	var url				='cdndb.php?request=gen_ctns_combo';
	var xml_http_obj	=$.ajax({url:url,async:false});
	//alert(xml_http_obj.responseText);
	var xml_CartonId	=xml_http_obj.responseXML.getElementsByTagName('CartonId');
	var xml_Carton		=xml_http_obj.responseXML.getElementsByTagName('Carton');
	var xml_Weight		=xml_http_obj.responseXML.getElementsByTagName('Weight');
	ctn_combo			="<select class=\"txtbox keymove\" style=\"width:170px\"><option value=''></option>";	
	for(var i=0;i<xml_CartonId.length;i++) 
	{
		var id				=xml_CartonId[i].childNodes[0].nodeValue;
		var Carton			=xml_Carton[i].childNodes[0].nodeValue;
		var Weight			=xml_Weight[i].childNodes[0].nodeValue;
		//pub_ctns_wt[id]		=Weight
		ctn_combo		  	+="<option value=\""+Carton+"\">"+Carton+"</option>";
				  
		
	}
	ctn_combo		   +="</select>";
}

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

function changeCDNInvCombo(obj,evt)
{
	if (evt.keyCode == 13)
	{
		var url     = "cdndb.php?request=loadCDNToInv&invCDN="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		
		document.getElementById('cboCDNNo').value = htmlobj.responseText;
		if(htmlobj.responseText!="fail")
			loadHeaderData(htmlobj.responseText);
	}
}


function changeCDNPoCombo(obj,evt)
{
	if (evt.keyCode == 13)
	{
		//alert(invCDN);
		var url     = "cdndb.php?request=loadCDNToInvUsingPo&invCDN="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		
		document.getElementById('cboCDNNo').value = htmlobj.responseText;
		if(htmlobj.responseText!="fail")
			loadHeaderData(htmlobj.responseText);
	}
}


function changependingCDNvCombo(obj,evt)
{
	if (evt.keyCode == 13)
	{//alert(obj.value);
		var url     = "cdndb.php?request=loadPreInvoiceDataToCombo&invCDN="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		document.getElementById('cboInvoiceNo').value =htmlobj.responseText;
		if(htmlobj.responseText!="fail")
			loadInvoiceData(htmlobj.responseText);
	}
	
}


function loadInvoiceData(invoiceNo)
{
	pub_invNo = invoiceNo;
	if(pub_invNo=="")
	{
		clearPage();
		return;
	}
	var url     = "cdndb.php?request=loadInvoiceData&invoiceNo="+URLEncode(pub_invNo);
	var htmlobj = $.ajax({url:url,async:false});
	/*clearPage();
	document.getElementById("cboInvoiceNo").value = pub_invNo;*/
	
	document.getElementById("cboConsignee").value = htmlobj.responseXML.getElementsByTagName("BuyerID")[0].childNodes[0].nodeValue;	
	document.getElementById("cboShipper").value   = htmlobj.responseXML.getElementsByTagName("CompanyID")[0].childNodes[0].nodeValue;
	document.getElementById("txtVessel").value    = htmlobj.responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;	
	document.getElementById("txtVoyageNo").value  = htmlobj.responseXML.getElementsByTagName("VoyegeNo")[0].childNodes[0].nodeValue;
	document.getElementById("txtVoyegeDate").value = htmlobj.responseXML.getElementsByTagName("SailingDate")[0].childNodes[0].nodeValue;		
	document.getElementById("cboPortOfDischarge").value  = htmlobj.responseXML.getElementsByTagName("FinalDest")[0].childNodes[0].nodeValue;
	document.getElementById("txtBLNo").value  = htmlobj.responseXML.getElementsByTagName("BLNo")[0].childNodes[0].nodeValue;
	document.getElementById("txtSLPANo").value  = htmlobj.responseXML.getElementsByTagName("SLPANo")[0].childNodes[0].nodeValue;
	document.getElementById("txtCustomesEntry").value  = htmlobj.responseXML.getElementsByTagName("CustomEntryNo")[0].childNodes[0].nodeValue;
	
	document.getElementById("txtCNTCode").value  = htmlobj.responseXML.getElementsByTagName("CtnOprCode")[0].childNodes[0].nodeValue;
	document.getElementById("txtVSLCode").value  = htmlobj.responseXML.getElementsByTagName("VslOprCode")[0].childNodes[0].nodeValue;
	//document.getElementById("txtCustomesEntry").value  = htmlobj.responseXML.getElementsByTagName("CustomEntryNo")[0].childNodes[0].nodeValue;
	
	loadInvDetailsGrid();	
}
function clearPage()
{
	//location.reload();
	//document.getElementById("cboInvoiceNo").value==""
	document.frmCargoDispatch.reset();
	//var cdnNo='';
}
function saveData()
{
	if(document.getElementById("cboInvoiceNo").value=="")
	{
		alert("Please select a Invoice No.");
		document.getElementById("cboInvoiceNo").focus();
		return;
	}
	var cdnNo 	  = $('#cboCDNNo').val();
	if(cdnNo=="")				
		{
			getcdnNo();
			saveHeader(0);	
		}
	else
		{
			pub_cdnNo=cdnNo;
			saveHeader(1);
		}
}
function getcdnNo()
{
	var url = "cdndb.php?request=getcdnNo";
	var htmlobj = $.ajax({url:url,async:false});
	var xmlCdnNo = htmlobj.responseText;
	pub_cdnNo = xmlCdnNo;
}
////////////confirm CDN///////////////////////////////////////////////////////////////////////////
function pageConfom()
{
	
	var conformcdn = confirm("Are You Sure You Want To Confirm This CDN?");
	if(conformcdn==true)
		{
			updateCdn();
		}
}

function updateCdn()
{
	var conf=1;
	var cdn				= $('#cboCDNNo').val();
	document.getElementById('txtStatus').value="Shipped";
	//alert(cdn);
	
	var url = 'cdndb.php?request=updateDataConfirm&cdnNo='+URLEncode(cdn)+'&conform='+URLEncode(conf);
	htmlobj = $.ajax({url:url,async:false});
	alert(htmlobj.responseText);
}

///////////////cancel CDN////////////////////////////////////////////////////////////
function cancelPages()
{
	
	var cancel = confirm("Are You Sure You Want To Cancel This CDN?");
	if(cancel==true)
	{
		
		cancelCdn();
		location.reload();
	}
	
}

function cancelCdn()
{
	var abc=1;
	var cdn				= $('#cboCDNNo').val();
	//alert(cdn);
	
	var url = 'cdndb.php?request=updateCdnCancel&cdnNo='+URLEncode(cdn)+'&cancel='+URLEncode(abc);
	htmlobj = $.ajax({url:url,async:false});
	alert(htmlobj.responseText);
}




function saveHeader(status)
{
	//alert(status);
	var invoiceNo 		= $('#cboInvoiceNo').val();
	var consignee 		= $('#cboConsignee').val();
	var shipper 		= $('#cboShipper').val();
	var vessel 			= $('#txtVessel').val();
	var exVessel 		= $('#txtExVessel').val();
	var VoyageNo 		= $('#txtVoyageNo').val();
	var sailingDate	 	= $('#txtVoyegeDate').val();
	var PortOfDischarge = $('#cboPortOfDischarge').val();
	//var LorryNo 		= $('#txtLorryNo').val();
	var BLNo 			= $('#txtBLNo').val();
	var TaraWt 			= $('#txtTaraWt').val();
	var CustomesEntry 	= $('#txtCustomesEntry').val();
	var SealNo 			= $('#txtSealNo').val();
	var Declarent 		= $('#cboDeclarentName').val();
	var Driver 			= $('#txtDriver').val();
	var Cleaner 		= $('#txtCleaner').val();
	var Signator 		= $('#cboSignator').val();
	var Temoerature 	= $('#txtTemoerature').val();
	var CNTCode 		= $('#txtCNTCode').val();
	var VSLCode 		= $('#txtVSLCode').val();
	var ContainerH 		= $('#txtContainerH').val();
	var ContainerL 		= $('#txtContainerL').val();
	var CotainerType 	= $('#cboCotainerType').val();
	var date		 	= $('#txtDate').val();
	var exportDate		 	= $('#exportDate').val();
	var cdn				= $('#cboCDNNo').val();
	var containerNo     = $('#txtContainerNo').val();
	var ctn_measure     = ($('#ctn_measure')[0].checked==true?1:0);
	var cdnDocNo		= $('#txtCDNDocNo').val();
	var SLPANo			= $('#txtSLPANo').val();
	
	//alert(exportDate);
	
	var url = 'cdndb.php?request=saveHeaderData&invoiceNo='+URLEncode(invoiceNo)+'&cdnNo='+URLEncode(pub_cdnNo)+'&consignee='+consignee+'&shipper='+shipper+'&vessel='+URLEncode(vessel)+'&exVessel='+URLEncode(exVessel)+'&VoyageNo='+URLEncode(VoyageNo)+'&sailingDate='+URLEncode(sailingDate)+'&PortOfDischarge='+PortOfDischarge+'&BLNo='+URLEncode(BLNo)+'&TaraWt='+TaraWt+'&CustomesEntry='+URLEncode(CustomesEntry)+'&SealNo='+URLEncode(SealNo)+'&Declarent='+Declarent+'&Driver='+URLEncode(Driver)+'&Cleaner='+URLEncode(Cleaner)+'&Signator='+Signator+'&Temoerature='+Temoerature+'&CNTCode='+URLEncode(CNTCode)+'&VSLCode='+URLEncode(VSLCode)+'&ContainerH='+ContainerH+'&ContainerL='+ContainerL+'&CotainerType='+CotainerType+'&date='+date+'&exportDate='+exportDate+'&containerNo='+containerNo+'&ctn_measure='+ctn_measure+'&cdnDocNo='+cdnDocNo+'&SLPANo='+SLPANo;
	htmlobj = $.ajax({url:url,async:false});
	
	//alert(htmlobj.responseText);
	if(htmlobj.responseText=="HeaderSaved")
	{
		if(status==0)
		{
		var opt = document.createElement("option");
		opt.text = pub_cdnNo+"->"+invoiceNo;
		opt.value = pub_cdnNo;
		opt.selected = 'selected';
		document.getElementById("cboCDNNo").options.add(opt);
		ClearTable('tblDescription_po');
		
		}
		if(status==1)
		
		{
			loadCombo('select intCDNNo,CONCAT(intCDNNo,\'->\',strInvoiceNo) from cdn_header order by intCDNNo desc;','cboCDNNo');
			document.getElementById("cboCDNNo").value=pub_cdnNo;
		}
		
		var grd = document.getElementById('tblDescription_po1');
		var grCTN = document.getElementById('tblDescriptionCTN');
		//if(grd.rows[1].cells[1].childNodes[0].value!="")
		//{
			
			var urlNewDel = "cdndb.php?request=deleteLorryDetail&cdn="+URLEncode(cdn);
			$.ajax({url:urlNewDel,async:false});
			
			var urlNewDelCTN = "cdndb.php?request=deleteCTNDetail&cdn="+URLEncode(cdn);
			$.ajax({url:urlNewDelCTN,async:false});
			
			for(var x=1;x<grd.rows.length;x++)
			{
				var urlNew = "cdndb.php?request=saveLorryDetail&cdn="+URLEncode(cdn)+"&lorryNo="+URLEncode(grd.rows[x].cells[1].childNodes[0].value)+"&cbm="+URLEncode(grd.rows[x].cells[2].childNodes[0].value);
				
				htmlobjNew = $.ajax({url:urlNew,async:false});
				
			}
			
			for(var x=1;x<grCTN.rows.length;x++)
			{
				var urlNewCTN = "cdndb.php?request=saveCTNDetail&cdn="+URLEncode(cdn)+"&ctnNo="+URLEncode(grCTN.rows[x].cells[1].childNodes[0].value)+"&qty="+URLEncode(grCTN.rows[x].cells[2].childNodes[0].value);
				
				htmlobjNew = $.ajax({url:urlNewCTN,async:false});
				
			}
		//}
		
		alert("Saved Successfully.");
		
	}
	else
	{
		alert("Error in Saving.");	
	}
}
function loadHeaderData(cdnNo)
{
	gen_ctns_combo();
	//alert("abc");
	/*var tblDescription_po1 = document.getElementById('tblDescription_po1');
	
	for(var t=tblDescription_po1.rows.length-1;t>0;t--)
	{
		tblDescription_po1.deleteRow(t);
	}*/
	
	var url_combo="cdndb.php?request=loadInvoiceCombo&cdnNo="+cdnNo;
	var htmlobj_combo = $.ajax({url:url_combo,async:false});
	document.getElementById('cboInvoiceNo').innerHTML=htmlobj_combo.responseText;
	
	if(cdnNo=="")
	{
		clearPage();
		ClearTable('tblDescriptionOfGood');
		var url_combo="cdndb.php?request=loadInvoiceCombo&cdnNo="+cdnNo;
		var htmlobj_combo = $.ajax({url:url_combo,async:false});
		document.getElementById('cboInvoiceNo').innerHTML=htmlobj_combo.responseText;
		return;
	}
	pub_loadCDNNo = cdnNo;
	
	var grd = document.getElementById('tblDescription_po1');
	
			for(var t=grd.rows.length-1;t>0;t--)
			{
				grd.deleteRow(t);
			}
	
	addRow();
	var url     	  = 'cdndb.php?request=loadLorryDetail&cdnNo='+cdnNo;
	var xml_http_obj1 = $.ajax({url:url,async:false});
	//alert(xml_http_obj1.responseText);
	var lorryno = xml_http_obj1.responseXML.getElementsByTagName('LorryNo');
	var cbm     = xml_http_obj1.responseXML.getElementsByTagName('CBM');
	//alert()
	if(lorryno[0])
	{
		
			for(var t=grd.rows.length-1;t>0;t--)
			{
				grd.deleteRow(t);
			}
			
			
	
		
	}
	for(var e=0;e<lorryno.length;e++)
	{
		var lastRow 		= grd.rows.length;	
		var row 			= grd.insertRow(lastRow);
		row.className 		= "bcgcolor-tblrowWhite";
		
		var rowCell 	  	= row.insertCell(0);
		rowCell.className 	= "normalfntMid";
		rowCell.innerHTML 	= "<img style='cursor:pointer' maxlength='15' alt='del' onclick='delRow(this);' src='../../images/del.png'/></td>";	
		//alert(lorryno[e].childNodes[0].nodeValue);
		var rowCell		 	= row.insertCell(1);
		rowCell.className 	= "normalfnt";
		rowCell.innerHTML 	= "<input type='text' value='"+lorryno[e].childNodes[0].nodeValue+"' style='width:158px; text-align:center;' onblur='checkExist(this);'/>";
		
		var rowCell		 	= row.insertCell(2);
		rowCell.className 	= "normalfnt";
		rowCell.innerHTML 	= "<input type='text' value='"+cbm[e].childNodes[0].nodeValue+"' style='width:158px; text-align:center;' onkeypress='addR(this,event); return CheckforValidDecimal(this.value,4,event)'/>";
	}
	
	var url     	 = 'cdndb.php?request=LoadHeaderData&cdnNo='+cdnNo;
	var xml_http_obj = $.ajax({url:url,async:false});
	clearPage();
	
	$('#cboCDNNo').val(pub_loadCDNNo);
	//alert(xml_http_obj.responseXML.getElementsByTagName('InvoiceNo')[0].childNodes[0].nodeValue);
	$('#cboInvoiceNo').val(xml_http_obj.responseXML.getElementsByTagName('InvoiceNo')[0].childNodes[0].nodeValue);
     $('#cboConsignee').val(xml_http_obj.responseXML.getElementsByTagName('Consignee')[0].childNodes[0].nodeValue);
	 $('#cboShipper').val(xml_http_obj.responseXML.getElementsByTagName('Shipper')[0].childNodes[0].nodeValue);
	 $('#txtVessel').val(xml_http_obj.responseXML.getElementsByTagName('Vessel')[0].childNodes[0].nodeValue);
	 $('#txtExVessel').val(xml_http_obj.responseXML.getElementsByTagName('ExVesel')[0].childNodes[0].nodeValue);
	 $('#txtVoyageNo').val(xml_http_obj.responseXML.getElementsByTagName('VoyageNo')[0].childNodes[0].nodeValue);
	 $('#txtVoyegeDate').val(xml_http_obj.responseXML.getElementsByTagName('VoyageDate')[0].childNodes[0].nodeValue);
	 $('#cboPortOfDischarge').val(xml_http_obj.responseXML.getElementsByTagName('PortOfDischarge')[0].childNodes[0].nodeValue);
	 //$('#txtLorryNo').val(xml_http_obj.responseXML.getElementsByTagName('LorryNo')[0].childNodes[0].nodeValue);
	 $('#txtBLNo').val(xml_http_obj.responseXML.getElementsByTagName('BLNo')[0].childNodes[0].nodeValue);
	 $('#txtTaraWt').val(xml_http_obj.responseXML.getElementsByTagName('TareWt')[0].childNodes[0].nodeValue);
	 $('#txtCustomesEntry').val(xml_http_obj.responseXML.getElementsByTagName('CustomesEntry')[0].childNodes[0].nodeValue);
	 
	 $('#txtSealNo').val(xml_http_obj.responseXML.getElementsByTagName('SealNo')[0].childNodes[0].nodeValue);
	 $('#cboDeclarentName').val(xml_http_obj.responseXML.getElementsByTagName('DeclarentName')[0].childNodes[0].nodeValue);
	 $('#txtDriver').val(xml_http_obj.responseXML.getElementsByTagName('DriverName')[0].childNodes[0].nodeValue);
	 $('#txtCleaner').val(xml_http_obj.responseXML.getElementsByTagName('CleanerName')[0].childNodes[0].nodeValue);
	 $('#cboSignator').val(xml_http_obj.responseXML.getElementsByTagName('Signatory')[0].childNodes[0].nodeValue);
	 $('#txtTemoerature').val(xml_http_obj.responseXML.getElementsByTagName('Temperature')[0].childNodes[0].nodeValue);
	 $('#txtCNTCode').val(xml_http_obj.responseXML.getElementsByTagName('CNTOPRCode')[0].childNodes[0].nodeValue);
	 $('#txtVSLCode').val(xml_http_obj.responseXML.getElementsByTagName('VSLOPRCode')[0].childNodes[0].nodeValue);
	 $('#txtContainerH').val(xml_http_obj.responseXML.getElementsByTagName('Hieght')[0].childNodes[0].nodeValue);
	 $('#txtContainerL').val(xml_http_obj.responseXML.getElementsByTagName('Length')[0].childNodes[0].nodeValue);
	 $('#cboCotainerType').val(xml_http_obj.responseXML.getElementsByTagName('ContainerType')[0].childNodes[0].nodeValue);
	 $('#txtDate').val(xml_http_obj.responseXML.getElementsByTagName('Date')[0].childNodes[0].nodeValue);
	 $('#txtContainerNo').val(xml_http_obj.responseXML.getElementsByTagName('ContainerNo')[0].childNodes[0].nodeValue);
	 $('#txtCDNDocNo').val(xml_http_obj.responseXML.getElementsByTagName('CDNDocNo')[0].childNodes[0].nodeValue);
	 $('#txtStatus').val(xml_http_obj.responseXML.getElementsByTagName('Status')[0].childNodes[0].nodeValue);
	 
	  $('#exportDate').val(xml_http_obj.responseXML.getElementsByTagName('exportDate')[0].childNodes[0].nodeValue);
	  
	 document.getElementById("txtSLPANo").value  = xml_http_obj.responseXML.getElementsByTagName("SLPANo")[0].childNodes[0].nodeValue;
	 
	 if(xml_http_obj.responseXML.getElementsByTagName('CTNMeasure')[0].childNodes[0].nodeValue==1)
	 	document.getElementById('ctn_measure').checked=true;
	else
		document.getElementById('ctn_measure').checked=false;
	 
	var tblMain    = document.getElementById("tblDescription_po");
	var url_detail = "cdndb.php?request=LoadMainDetailData&cdnNo="+cdnNo;
	var http_obj    = $.ajax({url:url_detail,async:false});
	ClearTable('tblDescriptionOfGood');
	
	var detailGrid=document.getElementById("tblDescriptionOfGood");	
	var invdtlno=http_obj.responseXML.getElementsByTagName('InvoiceNo');
	var StyleID=http_obj.responseXML.getElementsByTagName('StyleID');
	var PL=http_obj.responseXML.getElementsByTagName('PL');
	var ItemNo=http_obj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=http_obj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=http_obj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=http_obj.responseXML.getElementsByTagName('Quantity');
	var UnitID=http_obj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice=http_obj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP=http_obj.responseXML.getElementsByTagName('lCMP');
	var Amount=http_obj.responseXML.getElementsByTagName('Amount');	
	var HSCode=http_obj.responseXML.getElementsByTagName('HSCode');
	var GrossMass=http_obj.responseXML.getElementsByTagName('GrossMass');
	var NetMass=http_obj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=http_obj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=http_obj.responseXML.getElementsByTagName('NoOfCTns');
	var Category=http_obj.responseXML.getElementsByTagName('Category');
	var ProcedureCode=http_obj.responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=http_obj.responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=http_obj.responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=http_obj.responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=http_obj.responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=http_obj.responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=http_obj.responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=http_obj.responseXML.getElementsByTagName('ISD');
	var Fabrication=http_obj.responseXML.getElementsByTagName('Fabrication');
	var Color=http_obj.responseXML.getElementsByTagName('Color');
	var CBM=http_obj.responseXML.getElementsByTagName('CBM');
	//alert(xmlHttp[4].responseText);
	//alert(invdtlno.length);
	
	
	
	var pos=detailGrid.rows.length-1;
		for(var loop=0;loop<StyleID.length;loop++)
		{	
		
		
			
			var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
		if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
			var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\"/>";	
				cellDelete.id=1;
				
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =invdtlno[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		
		
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(StyleID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(BuyerPONo[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(PL[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(DescOfGoods[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabrication[loop].childNodes[0].nodeValue);
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(Fabrication[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =Color[loop].childNodes[0].nodeValue;
		if(Color[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
		if(UnitPrice[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}						
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;		
		if(PriceUnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		if(Quantity[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
		if(UnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
		if(Amount[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
		if(GrossMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
		if(NetMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
		if(HSCode[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		if(NoOfCTns[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
		if(dblUMOnQty1[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
		if(dblUMOnQty2[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}					
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		if(dblUMOnQty3[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD[loop].childNodes[0].nodeValue;
		if(ISD[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM[loop].childNodes[0].nodeValue;
		if(CBM[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "0";
		}
		
		}
		ctnDetails(cdnNo);
}


function ctnDetails(cdnNo)
{
	//alert("Bhagya");
	var url="cdndb.php?request=loadctndetail&cdnNo="+cdnNo;
	var htmlobj = $.ajax({url:url,async:false});
	
	//alert(htmlobj.responseText);
	var XMLCTN 		= htmlobj.responseXML.getElementsByTagName("CTNMeasurement");
	var XMLQTY		= htmlobj.responseXML.getElementsByTagName("Quantity");
	
	var ctntbl = document.getElementById('tblDescriptionCTN');
	for(var i=ctntbl.rows.length-1;i>0;i--)
	{
		ctntbl.deleteRow(i);
	}
	
	if(XMLCTN.length<1)
		addRowCTN();
	else
	{
		for(var e=0;e<XMLCTN.length;e++)
		{
			var lastRow 		= ctntbl.rows.length;	
			
			//Inserting a row
			var row 			= ctntbl.insertRow(lastRow);
			//Add a class for that row
			row.className 		= "bcgcolor-tblrowWhite";
			
			//Add a new cell
			var rowCell 	  	= row.insertCell(0);
			rowCell.className 	= "normalfntMid";
			rowCell.innerHTML 	= "<img style='cursor:pointer' maxlength='15' alt='del' onclick='delRow(this);' src='../../images/del.png'/></td>";	
			//alert(lorryno[e].childNodes[0].nodeValue);
			var rowCell		 	= row.insertCell(1);
			rowCell.className 	= "normalfnt";
			rowCell.innerHTML 	= ctn_combo;
			//alert(XMLCTN[e].childNodes[0].nodeValue);
			ctntbl.rows[lastRow].cells[1].childNodes[0].value=XMLCTN[e].childNodes[0].nodeValue;
			//alert(ctntbl.rows[lastRow].cells[1].childNodes[0].value;
			var rowCell		 	= row.insertCell(2);
			rowCell.className 	= "normalfnt";
			rowCell.innerHTML 	= "<input type='text' style='width:158px; text-align:center;' onkeypress='addRo(this,event); return CheckforValidDecimal(this.value,4,event)' value='"+XMLQTY[e].childNodes[0].nodeValue+"'/>";
				
		}
		
	}
}










function checkInvoiceNo()
{
	if (document.getElementById("cboCDNNo").value=="")
		{
			alert("Please fill header data first."); 
			window.location.href='cdn.php';
			return;
		}	
}
function AddDataFromPopUp()
{
	var url			= 'cdnpopup.php'
	var http_obj	= $.ajax({url:url,async:false});
	drawPopupArea(760,360,'frmAddInd');
	$('#frmAddInd').html(http_obj.responseText)
}
function searchDetailData()
{
	
	if(document.getElementById("popcboInvoiceNo").value=="")
	{
		alert("Please select a Invoice No.");
		document.getElementById("popcboInvoiceNo").focus();
		return;
	}
	var tbl 	 = document.getElementById('tblInvoiceDetails');
	var invNo    = $('#popcboInvoiceNo').val();
	var url      ='cdndb.php?request=LoadDetailData&invNo='+invNo;
	var htmlobj  = $.ajax({url:url,async:false});
	ClearTable('tblInvoiceDetails');
	
	var XMLInvoiceNo 		= htmlobj.responseXML.getElementsByTagName("InvoiceNo");
	var XMLPONo		  		= htmlobj.responseXML.getElementsByTagName("BuyerPONo");
	var XMLStyle		  	= htmlobj.responseXML.getElementsByTagName("StyleID");
	var XMLPLNO 			= htmlobj.responseXML.getElementsByTagName("PLNO");
	var XMLNoOfCTns		  	= htmlobj.responseXML.getElementsByTagName("NoOfCTns");
	var XMLQty		  		= htmlobj.responseXML.getElementsByTagName("Quantity");
	var XMLUnitPrice 		= htmlobj.responseXML.getElementsByTagName("UnitPrice");
	var XMLNetMass		  	= htmlobj.responseXML.getElementsByTagName("NetMass");
	var XMLGrossMass		= htmlobj.responseXML.getElementsByTagName("GrossMass");
	
	for(loop=0;loop<XMLInvoiceNo.length;loop++)
	{
		var InvoiceNo 		= XMLInvoiceNo[loop].childNodes[0].nodeValue;
		var PONo   	  		= XMLPONo[loop].childNodes[0].nodeValue;
		var Style	      	= XMLStyle[loop].childNodes[0].nodeValue;
		var PLNO 		  	= XMLPLNO[loop].childNodes[0].nodeValue;
		var NoOfCTns   	  	= XMLNoOfCTns[loop].childNodes[0].nodeValue;
		var Qty	      		= XMLQty[loop].childNodes[0].nodeValue;
		var UnitPrice 		= XMLUnitPrice[loop].childNodes[0].nodeValue;
		var NetMass   	  	= XMLNetMass[loop].childNodes[0].nodeValue;
		var GrossMass	    = XMLGrossMass[loop].childNodes[0].nodeValue;
		
		createMainGrid(InvoiceNo,PONo,Style,PLNO,NoOfCTns,Qty,UnitPrice,NetMass,GrossMass,0,tbl,'pop',loop);
	}
	
}
function createMainGridMain(InvoiceNo,PONo,Style,PLNO,NoOfCTns,Qty,UnitPrice,NetMass,GrossMass,CBM,tbl,status,loop)
{
		
		var lastRow 		= tbl.rows.length;	
		var row 			= tbl.insertRow(lastRow);
		row.className 		= "bcgcolor-tblrowWhite";
		
		if(status=='main')
		{
			if(loop%2==0)
					row.className ="bcgcolor-tblrow";
			else
					row.className ="bcgcolor-tblrowWhite";
		}
		
		var rowCell 	  	= row.insertCell(0);
		rowCell.className 	= "normalfntMid";
		if(status=='pop')
		{
			rowCell.innerHTML 	= "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" /> ";	
		}
		else
		{
			rowCell.innerHTML 	= "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this.parentNode.parentNode.rowIndex);\" class=\"mouseover\" /> ";	
		}
		rowCell.nowrap      = "nowrap";
		
		var rowCell		 	= row.insertCell(1);
		rowCell.setAttribute('height','20');
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.id 		    = InvoiceNo;
		rowCell.innerHTML 	= InvoiceNo;
		
		var rowCell		 	= row.insertCell(2);
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.innerHTML 	= PONo;
		
		var rowCell		 	= row.insertCell(3);
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.innerHTML 	= Style;
		
		var rowCell		 	= row.insertCell(4);
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.innerHTML 	= (PLNO==""?'n/a':PLNO);
		
		var rowCell		 	= row.insertCell(5);
		rowCell.className 	= "normalfntMid";
		rowCell.nowrap 		= "nowrap";
		rowCell.innerHTML 	= "<img src='../../images/add.png' onclick='viewPOPUPDetail(this)' style='cursor:pointer' title='Click to add PL#'/>";
		
		
		var rowCell		 	= row.insertCell(6);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= NoOfCTns;
		
		var rowCell		 	= row.insertCell(7);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= Qty;
		
		var rowCell		 	= row.insertCell(8);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= UnitPrice;
		
		var rowCell		 	= row.insertCell(9);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= NetMass;
		
		var rowCell		 	= row.insertCell(10);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= GrossMass;
		
		var rowCell		 	= row.insertCell(11);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= CBM;
}


function createMainGrid(InvoiceNo,PONo,Style,PLNO,NoOfCTns,Qty,UnitPrice,NetMass,GrossMass,CBM,tbl,status,loop)
{
		
		var lastRow 		= tbl.rows.length;	
		var row 			= tbl.insertRow(lastRow);
		row.className 		= "bcgcolor-tblrowWhite";
		
		if(status=='main')
		{
			if(loop%2==0)
					row.className ="bcgcolor-tblrow";
			else
					row.className ="bcgcolor-tblrowWhite";
		}
		
		var rowCell 	  	= row.insertCell(0);
		rowCell.className 	= "normalfntMid";
		if(status=='pop')
		{
			rowCell.innerHTML 	= "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" /> ";	
		}
		else
		{
			rowCell.innerHTML 	= "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this.parentNode.parentNode.rowIndex);\" class=\"mouseover\" /> ";	
		}
		rowCell.nowrap      = "nowrap";
		
		var rowCell		 	= row.insertCell(1);
		rowCell.setAttribute('height','20');
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.id 		    = InvoiceNo;
		rowCell.innerHTML 	= InvoiceNo;
		
		var rowCell		 	= row.insertCell(2);
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.innerHTML 	= PONo;
		
		var rowCell		 	= row.insertCell(3);
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.innerHTML 	= Style;
		
		var rowCell		 	= row.insertCell(4);
		rowCell.className 	= "normalfnt";
		rowCell.nowrap 		= "nowrap";
		rowCell.innerHTML 	= (PLNO==""?'n/a':PLNO);
		
		
		var rowCell		 	= row.insertCell(5);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= NoOfCTns;
		
		var rowCell		 	= row.insertCell(6);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= Qty;
		
		var rowCell		 	= row.insertCell(7);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= UnitPrice;
		
		var rowCell		 	= row.insertCell(8);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= NetMass;
		
		var rowCell		 	= row.insertCell(9);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= GrossMass;
		
		var rowCell		 	= row.insertCell(10);
		rowCell.className 	= "normalfntRite";
		rowCell.nowrap 		= "nowrap";
		if(status=='main')
		rowCell.ondblclick 	= changeToStyleTextBox;
		rowCell.innerHTML 	= CBM;
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function checkAll(obj)
{
	var tblpop = document.getElementById("tblInvoiceDetails");
	if(obj.checked)
		var check = true;
	else
		var check = false;
		
	for(loop=1;loop<tblpop.rows.length;loop++)
	{
		tblpop.rows[loop].cells[0].childNodes[0].checked = check;		
	}
}
function sendData()
{
	var poptbl  = document.getElementById("tblInvoiceDetails");
	var mailtbl = document.getElementById("tblDescriptionOfGood");
	var boolCheck = 0;
	for(var i=1;i<poptbl.rows.length;i++)
	{
		if(poptbl.rows[i].cells[0].childNodes[0].checked == true)
		{
			var invNo	   = poptbl.rows[i].cells[1].childNodes[0].nodeValue;
			var poNo	   = poptbl.rows[i].cells[2].childNodes[0].nodeValue;
			var StyleId    = poptbl.rows[i].cells[3].childNodes[0].nodeValue;
			var PLNo	   = poptbl.rows[i].cells[4].childNodes[0].nodeValue;
			var CTNS	   = poptbl.rows[i].cells[5].childNodes[0].nodeValue;
			var Qty 	   = poptbl.rows[i].cells[6].childNodes[0].nodeValue;
			var Price	   = poptbl.rows[i].cells[7].childNodes[0].nodeValue;
			var Net 	   = poptbl.rows[i].cells[8].childNodes[0].nodeValue;
			var Gross 	   = poptbl.rows[i].cells[9].childNodes[0].nodeValue;
			var CBM 	   = poptbl.rows[i].cells[10].childNodes[0].nodeValue;
			boolCheck = 1;
			for(var j=1;j <mailtbl.rows.length;j++)
			{
				
				if(mailtbl.rows[j].cells[1].id==invNo && mailtbl.rows[j].cells[3].childNodes[0].nodeValue==StyleId && mailtbl.rows[j].cells[2].childNodes[0].nodeValue==poNo)
				{
					boolCheck = 2;	
					alert("Record already exist.");	
				}
			}
		//	if(boolCheck==1)
				//createMainGridMain(invNo,poNo,StyleId,PLNo,CTNS,Qty,Price,Net,Gross,CBM,mailtbl,'main',loop);
			
		}
		
	}
	if(boolCheck==0)
	{
		alert("Please select a Invoice.");
		return;
	}
}
function RemoveItem(cell)
{
	var item=cell.parentNode.parentNode.childNodes[15].id;
	var invoiceno=document.getElementById("txtInvoiceDetail").value;
	var tbl = document.getElementById('tblDescriptionOfGood');
	//alert (cell.parentNode.parentNode.rowIndex);	
		
	if (confirm("Are you sure you want to delete?" ))
	{
		tbl.deleteRow(cell.parentNode.parentNode.rowIndex);
		InsertDetail();
	}
}

function deleteAll()
{
	var tbl = document.getElementById('tblDescriptionOfGood');
	if(confirm("Are you sure you want to delete?"))
	{
		for(var x=tbl.rows.length-1; x>0; x--)
		{
			tbl.deleteRow(x);
		}
		var cdn 			= document.getElementById('cboCDNNo').value;
		var url1	 		=	'cdndb.php?request=delData&cdn='+cdn;
		var url_pl=$.ajax({url:url1,async:false});
	}
}


function saveDetailData()
{
	var tbl = document.getElementById("tblDescription_po");
	if(tbl.rows.length==1)
	{
		alert("No records to save.");
		return;
	}
	var cdnNo = $('#cboCDNNo').val();
	
	var url   = "cdndb.php?request=deleteDetailData&cdnNo="+cdnNo;
	var htmlobj  = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="DeleteError")
	{
		alert("Error in saving.");
		return;
	}
	
	for(var i=1;i<tbl.rows.length;i++)
	{
			var checkSave = false;
			var invNo	   = tbl.rows[i].cells[1].childNodes[0].nodeValue;
			var poNo	   = tbl.rows[i].cells[2].childNodes[0].nodeValue;
			var StyleId    = tbl.rows[i].cells[3].childNodes[0].nodeValue;
			var PLNo	   = tbl.rows[i].cells[4].childNodes[0].nodeValue;
			var CTNS	   = tbl.rows[i].cells[6].childNodes[0].nodeValue;
			var Qty 	   = tbl.rows[i].cells[7].childNodes[0].nodeValue;
			var Price	   = tbl.rows[i].cells[8].childNodes[0].nodeValue;
			var Net 	   = tbl.rows[i].cells[9].childNodes[0].nodeValue;
			var Gross 	   = tbl.rows[i].cells[10].childNodes[0].nodeValue;
			var CBM 	   = tbl.rows[i].cells[11].childNodes[0].nodeValue;
		
			var url = "cdndb.php?request=saveDetailData&cdnNo="+cdnNo+"&invNo="+URLEncode(invNo)+"&poNo="+URLEncode(poNo)+"&StyleId="+URLEncode(StyleId)+"&PLNo="+URLEncode(PLNo)+"&CTNS="+CTNS+"&Qty="+Qty+"&Price="+Price+"&Net="+Net+"&Gross="+Gross+"&CBM="+URLEncode(CBM);
			var htmlobj  = $.ajax({url:url,async:false});
			if(htmlobj.responseText=="detailSaved")
				checkSave = true;
	}
		if(checkSave)
		{
			alert("Saved successfully.");
			//document.getElementById("butReport").style.display="inline";
			//document.getElementById("butReportDetail").style.display="inline";

		}
		else
		{
			alert("Error in saving.");
			//document.getElementById("butReport").style.display="none";
			//document.getElementById("butReportDetail").style.display="none";
			return;
		}
	
}
function changeToStyleTextBox()
{
	var obj = this;
	var value = obj.childNodes[0].nodeValue;
	obj.align = "Left";
	obj.innerHTML ="<input type=\"text\" name=\"txtGLID\" id=\"txtGLID\" class=\"txtbox\" value =\""+value+"\" size=\"13\" onblur=\"setValue(this,this.parentNode.parentNode.rowIndex)\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" >";
	
	obj.childNodes[0].focus();
}
function setValue(obj,rowIndex)
{
	if(obj.value=="")
	{
		obj.parentNode.innerHTML = 0;
		return;
	}
	obj.parentNode.innerHTML = obj.value;
	
}




function printReport()
{
	var chkVal=$('#Print_Co').is(':checked');
		
	  if(chkVal)
	  	var CoVal=1;
	  else
	  	var CoVal=0;
	  //alert(CoVal);
	
	if (document.getElementById("cboCDNNo").value!="" )
	{
		var CDNNo = document.getElementById("cboCDNNo").value;
		
		var url="cdndb.php?request=checkMultipleInv&cdnNo="+CDNNo;
		var htmlobj  = $.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		if(htmlobj.responseText==1)
			var newwindow=window.open('cdnrpt.php?CDNNo='+CDNNo,'cdn');
		else
			var newwindow=window.open('multipleInvRpt.php?CDNNo='+CDNNo,'cdn_multiple');
		window.open('shortShipmentDeclarationReport.php?cdnNo='+CDNNo,'declaration');
		window.open('certificateOfExportCargo.php?cdnNo='+CDNNo,'certificate');
		window.open('rptpreshipmentinvoice.php?cdnNo='+CDNNo,'commercial');
		
		if(CoVal==1)
		{
		//alert(CoVal);
		window.open('co_boi.php?cdnNo='+CDNNo,'co');
		}
		if (window.focus) {newwindow.focus();}
	}
	else
	{
		alert("Please select a CDN No.");
		document.getElementById("cboCDNNo").focus();
	}
}

function addR(obj,evt)
{
	var detailGrid = document.getElementById('tblDescription_po1');
	
	if (evt.keyCode == 9)
	{
		if(obj.parentNode.parentNode.rowIndex==(detailGrid.rows.length-1))
		{
			addRow();
		}
	}
}

function addRo(obj,evt)
{
	var detailGrid = document.getElementById('tblDescriptionCTN');
	
	if (evt.keyCode == 9)
	{
		if(obj.parentNode.parentNode.rowIndex==(detailGrid.rows.length-1))
		{
			addRowCTN();
		}
	}
}

function addRowCTN()
{
	var detailGrid = document.getElementById('tblDescriptionCTN');
	var lastRow    = detailGrid.rows.length;
	
	var row 	   = detailGrid.insertRow(lastRow);
	row.className       = "bcgcolor-tblrowWhite";
	var str           = "<td style='text-align:center'><img style='cursor:pointer' maxlength='15' alt='del' onclick='delRow(this);'"; 
        str+=" src='../../images/del.png' /></td>";
		str+="<td style='text-align:center'>"+ctn_combo+"</td>";
        str+="<td style='text-align:center'><input type='text' style='width:158px; text-align:center;' onkeypress='addRo(this,event); ";
		str+="return CheckforValidDecimal(this.value,4,event)'/></td>";
	row.innerHTML = str;
}



function checkLorry(obj) 
{	
	if(obj.parentNode.parentNode.cells[1].childNodes[0].value=="")
	{
		
		alert("Enter The Lorry Number !");
		obj.value = "";
	}
}

function addRow()
{
	var detailGrid = document.getElementById('tblDescription_po1');
	var lastRow    = detailGrid.rows.length;
	
	var row 	   = detailGrid.insertRow(lastRow);
	row.className       = "bcgcolor-tblrowWhite";
	var str           = "<td style='text-align:center'><img style='cursor:pointer' maxlength='15' alt='del' onclick='delRow(this);'"; 
        str+=" src='../../images/del.png' /></td>";
		str+="<td style='text-align:center'><input type='text' onblur='checkExist(this);' style='width:158px; text-align:center;' /></td>";
        str+="<td style='text-align:center'><input type='text' style='width:158px; text-align:center;' onkeypress='addR(this,event); ";
		str+="return CheckforValidDecimal(this.value,4,event)'/></td>";
	row.innerHTML = str;	
}

function delRow(obj)
{
	var detailGrid = document.getElementById('tblDescription_po1');
	
	detailGrid.deleteRow(obj.parentNode.parentNode.rowIndex);
}

function checkExist(obj)
{
	if(obj.value!="")
	{
	var grd = document.getElementById('tblDescription_po1');
	for(var i=1;i<grd.rows.length;i++)
	{
		//alert(obj.parentNode.parentNode.rowIndex);
		//alert(i);
		if(grd.rows[i].cells[1].childNodes[0].value==obj.value && i!=obj.parentNode.parentNode.rowIndex)
		{
			
			alert("Lorry Number : "+obj.value+" Already Exist !");
			obj.value = "";
			obj.focus();
			break;
		}
	}
	}
}

function viewPOPUPDetail()
{
		createNewXMLHttpRequest(15);
		xmlHttp[15].onreadystatechange=function()
		{	
			if(xmlHttp[15].readyState==4 && xmlHttp[15].status==200)
   		 {
        		
				drawPopupArea(950,390,'frmNewOrganize');
				document.getElementById('frmNewOrganize').innerHTML=xmlHttp[15].responseText;
						
		 }
			
		}
		
		var invoiceNo = document.getElementById('cboInvoiceNo').value;
		xmlHttp[15].open("GET",'pl_plugin_search.php?invoiceNo='+invoiceNo,true);
		xmlHttp[15].send(null);
		
}

function setPL(obj)
{
	if(obj.checked)
	{
		var pl = obj.parentNode.parentNode.cells[1].innerHTML.trim();
		var po = obj.parentNode.parentNode.cells[3].innerHTML.trim();
		
		closeWindow();	
		
		//document.getElementById('txtPLno').value = pl;
		//document.getElementById('txtPLno').onchange();
		var url	 		=	"cdndb.php?request=addSizePrice&plno="+pl+"&po="+po;
		var http_obj	=	$.ajax({url:url,async:false})
		
	var detailGrid=document.getElementById("tblDescriptionOfGood");	
	var invdtlno=document.getElementById("cboInvoiceNo").value;
	var StyleID=http_obj.responseXML.getElementsByTagName('StyleID');
	var PL=http_obj.responseXML.getElementsByTagName('PL');
	var ItemNo=http_obj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=http_obj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=http_obj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=http_obj.responseXML.getElementsByTagName('Quantity');
	var UnitID=http_obj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice=http_obj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP=http_obj.responseXML.getElementsByTagName('lCMP');
	var Amount=http_obj.responseXML.getElementsByTagName('Amount');	
	var HSCode=http_obj.responseXML.getElementsByTagName('HSCode');
	var GrossMass=http_obj.responseXML.getElementsByTagName('GrossMass');
	var NetMass=http_obj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=http_obj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=http_obj.responseXML.getElementsByTagName('NoOfCTns');
	var Category=http_obj.responseXML.getElementsByTagName('Category');
	var ProcedureCode=http_obj.responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=http_obj.responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=http_obj.responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=http_obj.responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=http_obj.responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=http_obj.responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=http_obj.responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=http_obj.responseXML.getElementsByTagName('ISD');
	var Fabrication=http_obj.responseXML.getElementsByTagName('Fabrication');
	var Color=http_obj.responseXML.getElementsByTagName('Color');
	var CBM=http_obj.responseXML.getElementsByTagName('CBM');
	//alert(xmlHttp[4].responseText);
	//alert(invdtlno.length);
	//alert(Fabrication);
	
	
	var pos=detailGrid.rows.length-1;
		for(var loop=0;loop<StyleID.length;loop++)
		{	
		
		var existData=0;
	
			for(var t=1;t<detailGrid.rows.length;t++)
			{
				if((detailGrid.rows[t].cells[4].childNodes[0].nodeValue==PL[loop].childNodes[0].nodeValue) && (detailGrid.rows[t].cells[7].childNodes[0].nodeValue==Color[loop].childNodes[0].nodeValue))
				{
					existData=1;
					break;
				}
			}
		if(existData==0)
		{
			
			var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
		//if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				//else
					//row.className ="bcgcolorred mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\"/>";	
				cellDelete.id=1;
				
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =invdtlno;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		
		
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(StyleID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(BuyerPONo[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(PL[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
				
		if(DescOfGoods[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabrication[loop].childNodes[0].nodeValue);
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(Fabrication[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =Color[loop].childNodes[0].nodeValue;
		if(Color[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
		if(UnitPrice[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}						
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;		
		if(PriceUnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		if(Quantity[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
		if(UnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
		if(Amount[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
		if(GrossMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
		if(NetMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
		if(HSCode[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		if(NoOfCTns[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
		if(dblUMOnQty1[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
		if(dblUMOnQty2[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}					
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		if(dblUMOnQty3[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD[loop].childNodes[0].nodeValue;
		if(ISD[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM[loop].childNodes[0].nodeValue;
		if(CBM[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "0";
		}
		
		}
		}
		
	}
	 loadHsDsFab()
}
function loadPL(po,pl)
{
	var tblGrd = document.getElementById('tblDescription_po');
	var rowInd = 0;
	for(var r=1;r<tblGrd.rows.length;r++)
	{
		if(tblGrd.rows[r].cells[2].innerHTML.trim()==po)
		{
			rowInd = r;
			//alert(r);
			//alert(tblGrd.rows[r].cells[2].innerHTML.trim());
		}
	}
	//alert(r);
	tblGrd.rows[rowInd].cells[4].innerHTML = ""+pl;
	
	var url      ='cdndb.php?request=LoadPLDetails&pl='+pl;
	var htmlobj  = $.ajax({url:url,async:false});
	//alert(pl);
	var XMLCTNS 	= htmlobj.responseXML.getElementsByTagName("CTNS");
	var XMLQTY		= htmlobj.responseXML.getElementsByTagName("QTY");
	var XMLNET		= htmlobj.responseXML.getElementsByTagName("NET");
	var XMLGROSS 	= htmlobj.responseXML.getElementsByTagName("GROSS");
	var XMLCBM		= htmlobj.responseXML.getElementsByTagName("CBM");
	if(XMLCTNS[0])
	{
		tblGrd.rows[rowInd].cells[6].innerHTML  = XMLCTNS[0].childNodes[0].nodeValue;
		tblGrd.rows[rowInd].cells[7].innerHTML  = XMLQTY[0].childNodes[0].nodeValue;
		tblGrd.rows[rowInd].cells[9].innerHTML  = XMLNET[0].childNodes[0].nodeValue;
		tblGrd.rows[rowInd].cells[10].innerHTML = XMLGROSS[0].childNodes[0].nodeValue;
		if(XMLCBM[0].childNodes[0].nodeValue=="")
		{
			tblGrd.rows[rowInd].cells[11].innerHTML = "0";
		}
		else
		{
			tblGrd.rows[rowInd].cells[11].innerHTML = XMLCBM[0].childNodes[0].nodeValue;
		}
	}
	
	
}

function closeCross()
{
	closeWindow();	
}

function getInvoiceDetail()
{
	document.getElementById("txtInvoiceDetail").value=document.getElementById("cboInvoiceNo").value;
	if(document.getElementById("txtInvoiceDetail").value!="")
	{
		
		var invoiceno=document.getElementById("txtInvoiceDetail").value; 
		createNewXMLHttpRequest(4);
		xmlHttp[4].onreadystatechange=addToDetailGrid;
		xmlHttp[4].open("GET",'invoiceDbDetail.php?REQUEST=getDetailData&invoiceno=' + invoiceno,true);
		xmlHttp[4].send(null);
	}
	else
	{
		alert("Please select an invoice number.");
		pageReload();
	//addToDetailGrid();
	
	}
}

function addToDetailGrid()
{

    if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
	{
		cleardata();
	deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	//alert(detailGrid.rows.length);
	var invdtlno=xmlHttp[4].responseXML.getElementsByTagName('InvoiceNo');
	var StyleID=xmlHttp[4].responseXML.getElementsByTagName('StyleID');
	var PL=xmlHttp[4].responseXML.getElementsByTagName('PL');
	var ItemNo=xmlHttp[4].responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=xmlHttp[4].responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=xmlHttp[4].responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=xmlHttp[4].responseXML.getElementsByTagName('Quantity');
	var UnitID=xmlHttp[4].responseXML.getElementsByTagName('UnitID');
	var UnitPrice=xmlHttp[4].responseXML.getElementsByTagName('UnitPrice');
	var lCMP=xmlHttp[4].responseXML.getElementsByTagName('lCMP');
	var Amount=xmlHttp[4].responseXML.getElementsByTagName('Amount');	
	var HSCode=xmlHttp[4].responseXML.getElementsByTagName('HSCode');
	var GrossMass=xmlHttp[4].responseXML.getElementsByTagName('GrossMass');
	var NetMass=xmlHttp[4].responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=xmlHttp[4].responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=xmlHttp[4].responseXML.getElementsByTagName('NoOfCTns');
	var Category=xmlHttp[4].responseXML.getElementsByTagName('Category');
	var ProcedureCode=xmlHttp[4].responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=xmlHttp[4].responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=xmlHttp[4].responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=xmlHttp[4].responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=xmlHttp[4].responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=xmlHttp[4].responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=xmlHttp[4].responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=xmlHttp[4].responseXML.getElementsByTagName('ISD');
	var Fabrication=xmlHttp[4].responseXML.getElementsByTagName('Fabrication');
	var Color=xmlHttp[4].responseXML.getElementsByTagName('Color');
	var CBM=xmlHttp[4].responseXML.getElementsByTagName('CBM');
	//alert(xmlHttp[4].responseText);
	var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
		if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
				
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(StyleID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(BuyerPONo[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(PL[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(DescOfGoods[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabrication[loop].childNodes[0].nodeValue);
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(Fabrication[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =Color[loop].childNodes[0].nodeValue;
		if(Color[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
		if(UnitPrice[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}						
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;		
		if(PriceUnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		if(Quantity[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
		if(UnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
		if(Amount[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
		if(GrossMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
		if(NetMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
		if(HSCode[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		if(NoOfCTns[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var cellDelete = row.insertCell(16); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
		if(dblUMOnQty1[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
		if(dblUMOnQty2[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		if(dblUMOnQty3[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD[loop].childNodes[0].nodeValue;;
		if(ISD[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM[loop].childNodes[0].nodeValue;;
		if(CBM[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "0";
		}
		}
	//alert (item);
	}
	
	//rowupdater();

}

function loadInvDetailsGrid()
{
	var invno = document.getElementById('cboInvoiceNo').value;
	
	var url      = 'cdndb.php?request=LoadInvDetailGrid&inv='+invno;
	var htmlobj  = $.ajax({url:url,async:false});
	
	cleardata();
	deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	//alert(detailGrid.rows.length);
	var invdtlno=htmlobj.responseXML.getElementsByTagName('InvoiceNo');
	var StyleID=htmlobj.responseXML.getElementsByTagName('StyleID');
	var PL=htmlobj.responseXML.getElementsByTagName('PL');
	var ItemNo=htmlobj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=htmlobj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=htmlobj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=htmlobj.responseXML.getElementsByTagName('Quantity');
	var UnitID=htmlobj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice=htmlobj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP=htmlobj.responseXML.getElementsByTagName('lCMP');
	var Amount=htmlobj.responseXML.getElementsByTagName('Amount');	
	var HSCode=htmlobj.responseXML.getElementsByTagName('HSCode');
	var GrossMass=htmlobj.responseXML.getElementsByTagName('GrossMass');
	var NetMass=htmlobj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=htmlobj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=htmlobj.responseXML.getElementsByTagName('NoOfCTns');
	var Category=htmlobj.responseXML.getElementsByTagName('Category');
	var ProcedureCode=htmlobj.responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=htmlobj.responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=htmlobj.responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=htmlobj.responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=htmlobj.responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=htmlobj.responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=htmlobj.responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=htmlobj.responseXML.getElementsByTagName('ISD');
	var Fabrication=htmlobj.responseXML.getElementsByTagName('Fabrication');
	var Color=htmlobj.responseXML.getElementsByTagName('Color');
	var CBM=htmlobj.responseXML.getElementsByTagName('CBM');
	//alert(xmlHttp[4].responseText);
	var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
		if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =invdtlno[loop].childNodes[0].nodeValue;
				rowCell.id=invdtlno[loop].childNodes[0].nodeValue;
		if(invdtlno[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(StyleID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(BuyerPONo[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(PL[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(DescOfGoods[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabrication[loop].childNodes[0].nodeValue);
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(Fabrication[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =Color[loop].childNodes[0].nodeValue;
		if(Color[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
		if(UnitPrice[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}						
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;		
		if(PriceUnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		if(Quantity[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
		if(UnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
		if(Amount[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
		if(GrossMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
		if(NetMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
		if(HSCode[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		if(NoOfCTns[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
		if(dblUMOnQty1[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
		if(dblUMOnQty2[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		if(dblUMOnQty3[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD[loop].childNodes[0].nodeValue;;
		if(ISD[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM[loop].childNodes[0].nodeValue;;
		if(CBM[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "0";
		}
		}
}

function cleardata()
{
	
	
	document.getElementById('txtStyle').value="";
	//document.getElementById('txtValue').value="";
	document.getElementById('txtareaDisc').value="";
	document.getElementById('txtUnit').value="";
	document.getElementById('txtUnitPrice').value="";
	document.getElementById('txtGross').value="";
	document.getElementById('txtCtns').value="";
	document.getElementById('txtNet').value="";
	document.getElementById('txtBuyerPO').value="";
	document.getElementById('txtHS').value="";
	document.getElementById('txtQty').value="";
	document.getElementById('txtQtyUnit').value="";
	document.getElementById('txtCM').value="";
	document.getElementById('txtProcedureCode').value="";
	document.getElementById('cboCategory').value="";
	document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').value="";
	document.getElementById('txtUmoQty1').value="";
	document.getElementById('txtUmoQty2').value="";
	document.getElementById('txtUmoQty3').value="";
	document.getElementById('cboUmoQty1').value="";
	document.getElementById('cboUmoQty2').value="";
	document.getElementById('cboUmoQty3').value="";
	document.getElementById('txtISDNo').value="";
	document.getElementById('txtFabric').value="";
	document.getElementById('txtCBM').value="";
	


	//document.getElementById('txtCBM').value="";
	document.getElementById('txtCBM').disabled=true;
	document.getElementById('txtStyle').disabled=true;
	document.getElementById('txtPLno').disabled=true;
	document.getElementById('txtareaDisc').disabled=true;
	document.getElementById('txtUnit').disabled=true;
	document.getElementById('txtUnitPrice').disabled=true;
	document.getElementById('txtGross').disabled=true;
	document.getElementById('txtCtns').disabled=true;
	document.getElementById('txtNet').disabled=true;
	document.getElementById('txtBuyerPO').disabled=true;
	document.getElementById('txtHS').disabled=true;
	document.getElementById('txtQty').disabled=true;
	document.getElementById('txtQtyUnit').disabled=true;
	document.getElementById('txtCM').disabled=true;
	document.getElementById('txtProcedureCode').disabled=true;
	document.getElementById('cboCategory').disabled=true;
	document.getElementById('txtValue').disabled=true;
	document.getElementById('txtUmoQty1').disabled=true;
	document.getElementById('txtUmoQty2').disabled=true;
	document.getElementById('txtUmoQty3').disabled=true;
	document.getElementById('cboUmoQty1').disabled=true;
	document.getElementById('cboUmoQty2').disabled=true;
	document.getElementById('cboUmoQty3').disabled=true;
	document.getElementById('txtISDNo').disabled=true;
	document.getElementById('txtFabric').disabled=true;
	//document.getElementById('imgADD').style.visibility="hidden";
}
function getItemVal()
{
	var txtQty		 = parseFloat(document.getElementById('txtQty').value);
	var txtUnitPrice = parseFloat(document.getElementById('txtUnitPrice').value);
	
	document.getElementById('txtValue').value = (txtQty*txtUnitPrice).toFixed(2);
}


function	deleterows(tableName)
{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
			 tbl.deleteRow(loop);
	}		
	
}	

function editItems()
{
newDettail();
document.getElementById('txtStyle').value=this.cells[2].childNodes[0].nodeValue;
var Prcode=this.cells[5].id;
if(Prcode=="")
{
	Prcode="0000.000";
}
document.getElementById('txtProcedureCode').value=Prcode;

document.getElementById('txtareaDisc').value=this.cells[5].childNodes[0].nodeValue;
document.getElementById('txtUnit').value=this.cells[11].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value=this.cells[8].childNodes[0].nodeValue;
document.getElementById('txtGross').value=this.cells[13].childNodes[0].nodeValue;
document.getElementById('txtCtns').value=this.cells[16].childNodes[0].nodeValue;
document.getElementById('txtNet').value=this.cells[14].childNodes[0].nodeValue;
document.getElementById('txtBuyerPO').value=this.cells[3].childNodes[0].nodeValue;
document.getElementById('txtHS').value=this.cells[15].childNodes[0].nodeValue;
document.getElementById('txtQty').value=this.cells[10].childNodes[0].nodeValue;
document.getElementById('txtQtyUnit').value=this.cells[11].childNodes[0].nodeValue;
document.getElementById('txtCM').value=0;
document.getElementById('txtValue').value=calValue(this.cells[8].childNodes[0].nodeValue,this.cells[11].childNodes[0].nodeValue,this.cells[10].childNodes[0].nodeValue,this.cells[9].childNodes[0].nodeValue,1);
document.getElementById('cboCategory').value=this.cells[2].id;
document.getElementById('txtUmoQty1').value=this.cells[17].childNodes[0].nodeValue;
document.getElementById('txtUmoQty2').value=this.cells[18].childNodes[0].nodeValue;
document.getElementById('txtUmoQty3').value=this.cells[19].childNodes[0].nodeValue;
document.getElementById('cboUmoQty1').value=this.cells[17].id;
document.getElementById('cboUmoQty2').value=this.cells[18].id;
document.getElementById('cboUmoQty3').value=this.cells[19].id;
document.getElementById('txtISDNo').value=this.cells[20].childNodes[0].nodeValue;
document.getElementById('txtCBM').value=this.cells[21].childNodes[0].nodeValue;
document.getElementById('txtFabric').value=empty_handle_str(this.cells[6].childNodes[0].nodeValue);
document.getElementById('txtColor').value=this.cells[7].childNodes[0].nodeValue;
document.getElementById('txtPL').value=this.cells[4].childNodes[0].nodeValue;
document.getElementById('txtInv').value=this.cells[1].childNodes[0].nodeValue;
var editgrid=document.getElementById('tblDescriptionOfGood');
editgrid.deleteRow(this.rowIndex);

//position=this.cells[15].id;
//verpos=this.cells[1].childNodes[0].nodeValue;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////alert(position);
//addDetailsToGrid()
}

function empty_handle_str(str)
{	
	return(str==""?"n/a":str);	
}

function newDettail()
{
	document.getElementById('txtStyle').disabled=false;
	document.getElementById('txtCBM').disabled=false;
	document.getElementById('txtareaDisc').disabled=false;
	document.getElementById('txtUnit').disabled=false;
	document.getElementById('txtUnitPrice').disabled=false;
	document.getElementById('txtGross').disabled=false;
	document.getElementById('txtCtns').disabled=false;
	document.getElementById('txtNet').disabled=false;
	document.getElementById('txtBuyerPO').disabled=false;
	document.getElementById('txtHS').disabled=false;
	document.getElementById('txtQty').disabled=false;
	document.getElementById('txtQtyUnit').disabled=false;
	document.getElementById('txtCM').disabled=false;
	document.getElementById('txtProcedureCode').disabled=false;
	document.getElementById('cboCategory').disabled=false;
	document.getElementById('txtValue').disabled=false;
	document.getElementById('txtUmoQty1').disabled=false;
	document.getElementById('txtUmoQty2').disabled=false;
	document.getElementById('txtUmoQty3').disabled=false;
	document.getElementById('cboUmoQty1').disabled=false;
	document.getElementById('cboUmoQty2').disabled=false;
	document.getElementById('cboUmoQty3').disabled=false;
	document.getElementById('txtISDNo').disabled=false;
	document.getElementById('txtFabric').disabled=false;
	//document.getElementById('imgADD').style.visibility="visible";
	document.getElementById('txtStyle').value="";
	//document.getElementById('txtValue').value="";
	document.getElementById('txtareaDisc').value=prev_desc;
	document.getElementById('txtUnit').value="";
	document.getElementById('txtUnitPrice').value="0000.000";
	document.getElementById('txtGross').value="";
	document.getElementById('txtCtns').value="";
	document.getElementById('txtNet').value="";
	document.getElementById('txtBuyerPO').value="";
	document.getElementById('txtHS').value=prev_hs;
	document.getElementById('txtQty').value="";
	document.getElementById('txtQtyUnit').value="";
	document.getElementById('txtCBM').value="";
	document.getElementById('txtCM').value="0";
	document.getElementById('txtProcedureCode').value="3054.950";
	document.getElementById('cboCategory').value="";
	document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').value="";
	document.getElementById('txtUmoQty1').value="";
	document.getElementById('txtUmoQty2').value="";
	document.getElementById('txtUmoQty3').value="";
	document.getElementById('cboUmoQty1').value="PCS";
	document.getElementById('cboUmoQty2').value="";
	document.getElementById('cboUmoQty3').value="DZN";
	document.getElementById('txtISDNo').value="";
	document.getElementById('txtFabric').value=prev_fabric;
	

}

function calValue(p,pu,qty,qtyu,cm)
{
	if(p!="" && qty!="")
	{
		var actp=0;
		var aqty=0; 
		if (pu=="DZN")
		{
			actp=parseFloat(p/12);
		}
		else 	
			actp=parseFloat(p);
		
			aqty=parseFloat(qty);
		var final=actp*aqty;
		var formatnum=final.toFixed([2]);
		return formatnum;
	}
	else 
	return 0;
	/*if(p!="" && qty!="")
	{
		var actp=0;
		var aqty=0; 
		if (pu=="DZN")
		{
			actp=parseFloat(p/12);
		}
		else 	
			actp=parseFloat(p);
		if (qtyu=='DZN')
			aqty=parseFloat(qty*12);
		else 
			aqty=parseFloat(qty);
		var final=parseFloat(actp*aqty)
		var formatnum=RoundNumbers(final,2);
		return formatnum;
	}
	else 
	return 0;		 */
}

//function addToGrid()
//{
//
//var cdn         = document.getElementById("cboCDNNo").value;
//var qty         = document.getElementById("txtQty").value;
//				
//var url1	 		=	'cdndb.php?request=chkqty&cdn='+cdn+'&qty='+qty;
//var url_pl=$.ajax({url:url1,async:false});
//var PreQty=url_pl.responseText;
////alert(PreQty);
//if(PreQty==1)
//{
//					
//					if(document.getElementById('txtQty').value<=0)
//					{
//						alert("Please enter the quantity");
//					}
//					else
//					{
//									
//				
//											
//						
//					if(document.getElementById('txtProcedureCode').disabled==false) 	
//					{	
//					if(inputvalidation())
//					{
//						
//						var checkpc=document.getElementById('txtProcedureCode').value;
//						if(validateprocedure(checkpc)==true)
//						{
//						var editgrid=document.getElementById('tblDescriptionOfGood');
//						var prevpos=0;
//						var verprepos=0;
//							var dsc=document.getElementById('txtareaDisc').value;
//							var style=document.getElementById('txtStyle').value;
//							var unit1=document.getElementById('txtUnit').value;
//							var unitprice=document.getElementById('txtUnitPrice').value;
//							var gross=document.getElementById('txtGross').value;
//							var ctns=document.getElementById('txtCtns').value;
//							var net=document.getElementById('txtNet').value;
//							var bpo=document.getElementById('txtBuyerPO').value;
//							var unitqty=document.getElementById('txtQtyUnit').value;
//							var cm=document.getElementById('txtCM').value;
//							var qty=document.getElementById('txtQty').value;
//							var category=document.getElementById('cboCategory').value;		
//							var hs=document.getElementById('txtHS').value;
//							var value=calValue(unitprice,unit1,qty,unitqty,1);
//							var procedurecode=document.getElementById('txtProcedureCode').value;
//							var umoUnit1=document.getElementById('cboUmoQty1').value;
//							var umoUnit2=document.getElementById('cboUmoQty2').value;
//							var umoUnit3=document.getElementById('cboUmoQty3').value;
//							var ISD=document.getElementById('txtISDNo').value;
//							var PL=document.getElementById('txtPL').value;
//							var fabric=document.getElementById('txtFabric').value;
//							var color=document.getElementById('txtColor').value;
//							var uqty1=document.getElementById('txtUmoQty1').value;
//							var uqty2=document.getElementById('txtUmoQty2').value;
//							var uqty3=document.getElementById('txtUmoQty3').value;
//							var CBM=document.getElementById('txtCBM').value;
//							var inv =document.getElementById('txtInv').value;
//							//var PL=document.getElementById('txtPL').value;
//								//verprepos=verpos;
//								//prevpos=position;
//								
//							var lastRow 		= editgrid.rows.length;	
//							var row 			= editgrid.insertRow(lastRow);
//									
//							row.ondblclick=editItems;
//							row.className ="bcgcolor-tblrow mouseover";
//						var cellDelete = row.insertCell(0); 
//								cellDelete.className ="normalfntMid";	
//								cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
//						
//						
//						var rowCell = row.insertCell(1);
//								rowCell.className ="normalfnt";			
//								rowCell.innerHTML =inv;
//								rowCell.id=category;
//						if(inv=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}
//								
//						var rowCell = row.insertCell(2);
//								rowCell.className ="normalfnt";			
//								rowCell.innerHTML =style;
//								rowCell.id=category;
//						if(style=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}
//								
//						var rowCell = row.insertCell(3);
//								rowCell.className ="normalfntMid";			
//								rowCell.innerHTML =bpo;
//								rowCell.id=category;
//						if(bpo=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}		
//								
//								var rowCell = row.insertCell(4);
//								rowCell.className ="normalfntMid";			
//								rowCell.innerHTML =PL;
//								rowCell.id=procedurecode;
//						if(PL=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}
//								
//								var rowCell = row.insertCell(5);
//								rowCell.className ="normalfntMid";			
//								rowCell.innerHTML =dsc;
//								rowCell.id=procedurecode;
//						if(dsc=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}				
//								
//						var rowCell = row.insertCell(6);
//								rowCell.className ="normalfntMid";			
//								rowCell.innerHTML =fabric;
//								rowCell.id=procedurecode;
//						if(fabric=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}				
//								
//						var rowCell = row.insertCell(7);
//								rowCell.className ="normalfntMid";			
//								rowCell.innerHTML =color;
//						if(color=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}
//						var rowCell = row.insertCell(8);
//								rowCell.className ="normalfntRite";			
//								rowCell.innerHTML =unitprice;
//						if(unitprice=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}						
//						var rowCell = row.insertCell(9);
//								rowCell.className ="normalfntMid";			
//								rowCell.innerHTML =unitqty;		
//						if(unitqty=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}					
//						var rowCell = row.insertCell(10);
//								rowCell.className ="normalfntRite";			
//								rowCell.innerHTML =qty;
//						if(qty=="")
//						{
//							rowCell.innerHTML = "0";
//						}			
//						var rowCell = row.insertCell(11);
//								rowCell.className ="normalfntRite";			
//								rowCell.innerHTML =unit1;		
//						if(unit1=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}					
//						var rowCell = row.insertCell(12);
//								rowCell.className ="normalfntRite";			
//								rowCell.innerHTML =value;
//						if(value=="")
//						{
//							rowCell.innerHTML = "0";
//						}					
//						var rowCell = row.insertCell(13);
//								rowCell.className ="normalfntRite";			
//							rowCell.innerHTML =gross;				
//						if(gross=="")
//						{
//							rowCell.innerHTML = "0";
//						}					
//						var rowCell = row.insertCell(14);
//								rowCell.className ="normalfntRite";			
//								rowCell.innerHTML =net;
//						if(net=="")
//						{
//							rowCell.innerHTML = "0";
//						}					
//						var rowCell = row.insertCell(15);
//								rowCell.className ="normalfntRite";			
//								rowCell.innerHTML =hs;	
//						if(hs=="")
//						{
//							rowCell.innerHTML = "n/a";
//						}				
//						var rowCell = row.insertCell(16);
//								rowCell.className ="normalfntRite";			
//								rowCell.innerHTML =ctns;
//								
//						
//						if(ctns=="")
//						{
//							rowCell.innerHTML = "0";
//						}			
//						var cellDelete = row.insertCell(17); 
//								cellDelete.className ="normalfntMid";	
//								cellDelete.innerHTML = uqty1;
//								cellDelete.id=umoUnit1;
//						if(uqty1=="")
//						{
//							cellDelete.innerHTML = "0";
//						}				
//						var cellDelete = row.insertCell(18); 
//								cellDelete.className ="normalfntMid";	
//								cellDelete.innerHTML = uqty2;
//								cellDelete.id=umoUnit2;
//						if(uqty2=="")
//						{
//							cellDelete.innerHTML = "0";
//						}					
//						var cellDelete = row.insertCell(19); 
//								cellDelete.className ="normalfntMid";	
//								cellDelete.innerHTML = uqty3;
//								cellDelete.id=umoUnit3;
//						if(uqty3=="")
//						{
//							cellDelete.innerHTML = "0";
//						}				
//						var cellDelete = row.insertCell(20); 
//								cellDelete.className ="normalfntMid";	
//								cellDelete.innerHTML = ISD;
//						if(ISD=="")
//						{
//							cellDelete.innerHTML = "n/a";
//						}
//						var cellDelete = row.insertCell(21); 
//								cellDelete.className ="normalfntMid";	
//								cellDelete.innerHTML = CBM;
//						if(CBM=="")
//						{
//							cellDelete.innerHTML = "0";
//						}
//							}
//
//	
//						cleardata();
//						InsertDetail();
//						}
//							else
//							alert("Procedure code format should be like 0000.000");
//						}
//						}
//}
//else
//{
//	alert("CDN Quntity not Accepted!");
//}
//}
//
////else
//	//{
//	//	alert("Qty not accepted");
//	//}
////}

function inputvalidation()
{

if(document.getElementById('txtStyle').value=="")
	{
		alert("Please enter a style number.");
		document.getElementById('txtStyle').focus();	
		return false;
	}
if(document.getElementById('txtQty').value=="")
	{
		alert("Please enter the quantity.");
		document.getElementById('txtQty').focus();	
		return false;
	}
if(document.getElementById('txtQtyUnit').value=="")
	{
		alert("Please select the price unit.");
		return false;
	}
if(document.getElementById('txtUnitPrice').value=="")
	{
		alert("Please enter the unit price.");
		document.getElementById('txtUnitPrice').focus();	
		return false;
	}
	
if(document.getElementById('txtUnit').value=="")
	{
		alert("Please select the qty unit.");
		return false;
	}
	
if(document.getElementById('txtCM').value=="")
	{
		alert("Please Enter CM.");
		document.getElementById('txtCM').focus();
		return false;
	}	
	
if(document.getElementById('txtHS').value=="")
	{
		alert("Please enter the HS code.");
		document.getElementById('txtHS').focus();
		return false;
	}
if(document.getElementById('txtCtns').value=="")
	{
		alert("Please enter number of cartoons.");
		document.getElementById('txtCtns').focus();
		return false;
	}
if(document.getElementById('txtareaDisc').value=="")
	{
		alert("Please enter the description.");
		document.getElementById('txtareaDisc').focus();	
		return false;
	}
else 
return true;

}

function validateprocedure(checkpc)
{
	//var objRegExp = "^\d{4}.\d{3}$";
   	//return objRegExp.test(checkpc);
	var objRegExp  =/^\d{4}\.\d{3}$/;

  //check for valid us phone with or without space between
  //area code
  return objRegExp.test(checkpc);
}


function InsertDetail()
{
	
		var tblData     = document.getElementById("tblDescriptionOfGood");
	//var invoiceno   = document.getElementById("cboInvoiceNo").value;
	var cdn         = document.getElementById("cboCDNNo").value;
	
	var url1	 		=	'cdndb.php?request=delData&cdn='+cdn;
	var url_pl=$.ajax({url:url1,async:false});
	//alert (url_pl.responseText);
	
	for(var x=1;x<tblData.rows.length;x++)
	{	
		var invoiceno   = URLEncode(tblData.rows[x].cells[1].childNodes[0].nodeValue);
		var url	 		=	'cdndb.php?request=saveData&invoiceno='+invoiceno+'&cdn='+cdn;
			
			var desc			= URLEncode(tblData.rows[x].cells[5].childNodes[0].nodeValue);
			var style			= URLEncode(tblData.rows[x].cells[2].childNodes[0].nodeValue);
			var unit1			= URLEncode(tblData.rows[x].cells[11].childNodes[0].nodeValue);
			var unitprice		= URLEncode(tblData.rows[x].cells[8].childNodes[0].nodeValue);
			var gross			= URLEncode(tblData.rows[x].cells[13].childNodes[0].nodeValue);
			var ctns			= URLEncode(tblData.rows[x].cells[16].childNodes[0].nodeValue);
			var net				= URLEncode(tblData.rows[x].cells[14].childNodes[0].nodeValue);
			var bpo				= URLEncode(tblData.rows[x].cells[3].childNodes[0].nodeValue);
			var unitqty			= URLEncode(tblData.rows[x].cells[9].childNodes[0].nodeValue);
			var qty				= URLEncode(tblData.rows[x].cells[10].childNodes[0].nodeValue);		
			var hs				= URLEncode(tblData.rows[x].cells[15].childNodes[0].nodeValue);
			var category		= URLEncode(tblData.rows[x].cells[2].id);
			var procedurecode	= URLEncode(tblData.rows[x].cells[5].id);
			var umoqty1			= URLEncode(tblData.rows[x].cells[17].childNodes[0].nodeValue);
			var umoqty2			= URLEncode(tblData.rows[x].cells[18].childNodes[0].nodeValue);
			var umoqty3			= URLEncode(tblData.rows[x].cells[19].childNodes[0].nodeValue);
			var val				= URLEncode(calValue(unitprice,unit1,qty,unitqty,1));
			var umoUnit1		= URLEncode(tblData.rows[x].cells[17].id);
			var umoUnit2		= URLEncode(tblData.rows[x].cells[18].id);
			var umoUnit3		= URLEncode(tblData.rows[x].cells[19].id);
			var ISDNo			= URLEncode(tblData.rows[x].cells[20].childNodes[0].nodeValue);
			var fabrication		= URLEncode(tblData.rows[x].cells[6].childNodes[0].nodeValue);
			var PL				= URLEncode(tblData.rows[x].cells[4].childNodes[0].nodeValue);
			var Color			= URLEncode(tblData.rows[x].cells[7].childNodes[0].nodeValue);
			var CBM			    = URLEncode(tblData.rows[x].cells[21].childNodes[0].nodeValue);
			
			url+='&dsc='+desc+ '&style='+style+'&value='+val+ '&unit=' +unit1+ '&unitprice='+unitprice;
			url+='&gross=' +gross+ '&ctns=' +ctns+  '&net=' +net+'&bpo=' +bpo+ '&unitqty=' +unitqty;
			url+='&procedurecode=' +procedurecode+'&hs=' +hs;
			url+='&qty=' +qty+ '&category=' +category+ '&umoqty1='+umoqty1+ '&umoqty2='+umoqty2+'&umoqty3='+umoqty3;
			url+='&PL='+PL+ '&umoUnit1='+umoUnit1+ '&umoUnit2='+umoUnit2+ '&umoUnit3='+umoUnit3+ '&ISDNo='+ISDNo;
			url+='&fabrication='+fabrication+'&Color='+Color+'&cbm='+CBM;
		

		var http_obj	=	$.ajax({url:url,async:false});
		//ChkQty();
		
	}
	saveData();
	alert("Data Saved Successfully !");
}

function loadCDNno()
{
	if(document.getElementById("cboCDNNo").value=="")
	{
		alert("Save header first !");
		document.getElementById("hrtab").href="#";
		//window.location.href="cdn.php";
	}
	else
	{
		document.getElementById("hrtab").href="#tabs-2";
		//window.location.href = "";
		document.getElementById("txtInvoiceDetail").value = document.getElementById("cboCDNNo").value;
		
		
		//var url      = 'cdndb.php?request=LoadInvCombo';
		//var htmlobj  = $.ajax({url:url,async:false});
		//document.getElementById("cboInvoiceNoOther").innerHTML = htmlobj.responseText;
	}
	calTot();
}

function popAddCtn()
{
	var cdnNo			=$('#txtPLNo').val();			
	var url				='pop_printer.php';
	var xml_http_obj	=$.ajax({url:url,async:false});
				//window.open("packinglist_formats/pl_levis_newyork.php?plno="+plno,'pl');
	drawPopupArea(360,125,'frmPrinter');
	document.getElementById('frmPrinter').innerHTML=xml_http_obj.responseText;
}

function loadInvDetailsGridOtherRow()
{
	
	var invno = document.getElementById('cboInvoiceNoOther').value;
	
	var url      = 'cdndb.php?request=LoadInvDetailGrid&inv='+invno;
	var htmlobj  = $.ajax({url:url,async:false});
	
	cleardata();
	//deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	//alert(detailGrid.rows.length);
	var invdtlno=htmlobj.responseXML.getElementsByTagName('InvoiceNo');
	var StyleID=htmlobj.responseXML.getElementsByTagName('StyleID');
	var PL=htmlobj.responseXML.getElementsByTagName('PL');
	var ItemNo=htmlobj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=htmlobj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=htmlobj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=htmlobj.responseXML.getElementsByTagName('Quantity');
	var UnitID=htmlobj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice=htmlobj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP=htmlobj.responseXML.getElementsByTagName('lCMP');
	var Amount=htmlobj.responseXML.getElementsByTagName('Amount');	
	var HSCode=htmlobj.responseXML.getElementsByTagName('HSCode');
	var GrossMass=htmlobj.responseXML.getElementsByTagName('GrossMass');
	var NetMass=htmlobj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=htmlobj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=htmlobj.responseXML.getElementsByTagName('NoOfCTns');
	var Category=htmlobj.responseXML.getElementsByTagName('Category');
	var ProcedureCode=htmlobj.responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=htmlobj.responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=htmlobj.responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=htmlobj.responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=htmlobj.responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=htmlobj.responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=htmlobj.responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=htmlobj.responseXML.getElementsByTagName('ISD');
	var Fabrication=htmlobj.responseXML.getElementsByTagName('Fabrication');
	var Color=htmlobj.responseXML.getElementsByTagName('Color');
	var CBM=htmlobj.responseXML.getElementsByTagName('CBM');
	//alert(xmlHttp[4].responseText);
	var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{	
		for(var loop=0;loop<StyleID.length;loop++)
		{	
		
		var existData=0;
	
			for(var t=1;t<detailGrid.rows.length;t++)
			{
				if((detailGrid.rows[t].cells[4].childNodes[0].nodeValue==PL[loop].childNodes[0].nodeValue) && (detailGrid.rows[t].cells[7].childNodes[0].nodeValue==Color[loop].childNodes[0].nodeValue))
				{
					existData=1;
					break;
				}
			}
		if(existData==0)
		{
			
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
		//if(loop % 2 ==0)
				row.className ="bcgcolor-tblrow mouseover";
				//else
					//row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =invdtlno[loop].childNodes[0].nodeValue;
				rowCell.id=invdtlno[loop].childNodes[0].nodeValue;
		if(invdtlno[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(StyleID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(BuyerPONo[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(PL[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(DescOfGoods[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabrication[loop].childNodes[0].nodeValue);
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(Fabrication[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =Color[loop].childNodes[0].nodeValue;
		if(Color[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
		if(UnitPrice[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}						
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;		
		if(PriceUnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		if(Quantity[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
		if(UnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
		if(Amount[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
		if(GrossMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
		if(NetMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
		if(HSCode[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		if(NoOfCTns[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
		if(dblUMOnQty1[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
		if(dblUMOnQty2[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		if(dblUMOnQty3[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD[loop].childNodes[0].nodeValue;;
		if(ISD[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM[loop].childNodes[0].nodeValue;;
		if(CBM[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "0";
		}
		}
		}
		}
		
		loadHsDsFab();
}


function loadHsDsFab()
{
	var tblDesOfGood = document.getElementById('tblDescriptionOfGood');
	for(var i=1; i<tblDesOfGood.rows.length; i++)
	{
	
	var invoiceno   = URLEncode(tblDesOfGood.rows[i].cells[1].childNodes[0].nodeValue);
	var Color	= URLEncode(tblDesOfGood.rows[i].cells[7].childNodes[0].nodeValue);
	//alert(Color);

		var url	 		=	'cdndb.php?request=loaData&invoiceno='+invoiceno+'&Color='+Color;
		var http_obj=$.ajax({url:url,async:false});
		
	var XML_Fabrication		=http_obj.responseXML.getElementsByTagName('Fabrication');
	var XML_HSCode			=http_obj.responseXML.getElementsByTagName('HSCode');
	var XML_DescOfGoods		=http_obj.responseXML.getElementsByTagName('DescOfGoods');
	
	//tblDesOfGood.rows[i].cells[5].innerHTML=xml_DescOfGoods[0].childNodes[0].nodeValue;
	//tblDesOfGood.rows[i].cells[6].innerHTML=xml_Fabrication[0].childNodes[0].nodeValue;
	//tblDesOfGood.rows[i].cells[15].innerHTML=xml_HSCode[0].childNodes[0].nodeValue;
	tblDesOfGood.rows[i].cells[5].innerHTML  = XML_DescOfGoods[0].childNodes[0].nodeValue;
	tblDesOfGood.rows[i].cells[15].innerHTML  = XML_HSCode[0].childNodes[0].nodeValue;
	tblDesOfGood.rows[i].cells[6].innerHTML  = XML_Fabrication[0].childNodes[0].nodeValue;
		//alert(xml_HSCode);
		
	}	
}



function addDetailsToGrid()
{
	var dsc=document.getElementById('txtareaDisc').value;
	var HsCode=document.getElementById('txtHS').value;
	var Fabric=document.getElementById('txtFabric').value;
	var PoNo=document.getElementById('txtBuyerPO').value;
	var UnitPrice=document.getElementById('txtUnitPrice').value;
	
			//var url_Details ='cdndb.php?request=loaDetails&dsc='+dsc+'&hs='+hs+'&fabrication'+fabrication+'&PoNo'+PoNo+'&UnitPrice'+UnitPrice;
		//	var http_obj=$.ajax({url:url,async:false});

	
		var tblDesOfGood = document.getElementById('tblDescriptionOfGood');
	for(var x=1; x<tblDesOfGood.rows.length; x++)
	{
		

			var poNum	   = tblDesOfGood.rows[x].cells[3].childNodes[0].nodeValue;
			var Price	   = tblDesOfGood.rows[x].cells[8].childNodes[0].nodeValue;
				//alert(PoNo);
				//alert("grid "+poNum);
				//alert(Color);
			//var url_grid =	'cdndb.php?request=loaDetails&poNo='+poNum+'&poNum='+Price;
			//var http_obj=$.ajax({url:url,async:false});
	//alert(Discription );
	
		
		if(PoNo==poNum && UnitPrice==Price)
		{
			//alert("if test..");
			tblDesOfGood.rows[x].cells[15].innerHTML  = HsCode
			tblDesOfGood.rows[x].cells[6].innerHTML  = Fabric
			tblDesOfGood.rows[x].cells[5].innerHTML  = dsc
				
				
				
		}
		
		
		
	}
	InsertDetail();	
	addToGrid();
	cleardata();
}



function calTot()
{
	
	
		var tblData     = document.getElementById("tblDescription");
	var invoiceno   = document.getElementById("txtInvoiceDetail").value;
	
	var unitprice=0;
	var qty=0;
	var val=0;
	
for(var x=1;x<tblData.rows.length;x++)
	{

		
			unitprice=unitprice+parseFloat(tblData.rows[x].cells[8].childNodes[0].nodeValue);
			qty=qty+parseFloat(tblData.rows[x].cells[10].childNodes[0].nodeValue);
			val=val+parseFloat(tblData.rows[x].cells[12].childNodes[0].nodeValue);
		
	}
	
	//tblDiscountData.rows[lastRow].cells[1].innerHTML=fullInvAmt;
	//tblDiscountData.rows[lastRow].cells[2].innerHTML=fullDisAmt;
	//tblDiscountData.rows[lastRow].cells[3].innerHTML=fullNetAmt;
	
	document.getElementById('txtTotalPrice').value=unitprice.toFixed(2);
	document.getElementById('txtTotalQty').value=qty.toFixed(2);
	document.getElementById('txtTotalAmount').value=val.toFixed(2);
	
		
}




function gotoCdn()
//eshippingeam//Exports/Preshipmentdocs/forwaderInstruction/forInstruction.php
{	
		window.open("../Preshipmentdocs/forwaderInstruction/forInstruction.php?InvoiceNo=" + URLEncode(document.getElementById("cboInvoiceNo").value)+'&CDNDocNo='+document.getElementById("txtCDNDocNo").value);
		//window.open("shippingnotes.php");
		//alert (document.getElementById("cboInvoiceNo").value);
		//alert (document.getElementById("txtCDNDocNo").value);
		var txtDocNo=document.getElementById("cboInvoiceNo").value;
		var CDNDocNo=document.getElementById("txtCDNDocNo").value;
		//alert(CDNDocNo);
		//alert(document.getElementById("txtCDNNo").value);
		document.getElementById("txtDocNo").value=txtDocNo;
		//document.getElementById("txtCDNNo").value=CDNDocNo;
}



function load_Hdetail(cdnNo)
{
	//alert("Hi..");
	var invCDN=document.getElementById('cboCDNNo').value;
	//var pendingCDN=document.getElementById('cboInvoiceNo').value; 
	//alert(invCDN);
	//=htmlobj_combo.responseText;
	//var XML_invoice		=http_obj.responseXML.getElementsByTagName('Fabrication');
	//alert(invCDN);
	//txtCDNInvNo
	//loadHeaderData();
	var url     = "cdndb.php?request=loadCDNToInv&invCDN="+invCDN;
		var htmlobj = $.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		
		document.getElementById('cboCDNNo').value = htmlobj.responseText;
		if(htmlobj.responseText!="fail")
			loadHeaderData(htmlobj.responseText);
}

function revisestatus()
{
var x;
var r=confirm("Are you sure change Status ?");
var status=document.getElementById("txtStatus").value;
var invNo=document.getElementById('cboCDNNo').value;
if (r==true)
  {
	   if(status=='Shipped')
	  	  {
		  		var url     = "cdndb.php?request=changestatus&invNo="+invNo;
				var htmlobj = $.ajax({url:url,async:false});
				alert("Status Successfully Revise.");
				location.reload(); 			
		  }
	  else if(status=='Pending')
		  {
				alert("Status alredy Pending.");
		  }
	 else
	 	  {
		 		alert("Cancelled Invoice.");
		  }
  
  }
else
  {
  		alert("Status revise fail !");
  }	

}

function ChkQty()
{
		var cdn         = document.getElementById("cboCDNNo").value;
		var qty         = document.getElementById("txtQty").value;
	//alert(qty);
	var url1	 		=	'cdndb.php?request=chkqty&cdn='+cdn;
	var url_pl=$.ajax({url:url1,async:false});
	var PreQty=url_pl.responseText;
	
		if(qty>PreQty)
			{
				alert("Qty not accepted");
			}
		else
			{
				
				//alert(cdn);
				
				InsertDetail();
			}
	
	//alert(PreQty);
}


function reload()
{
	location.reload();
}


function addToGrid()
{
	if(document.getElementById('txtProcedureCode').disabled==false) 	
	{	
	if(inputvalidation())
	{
		var checkpc=document.getElementById('txtProcedureCode').value;
		if(validateprocedure(checkpc)==true)
		{
		var editgrid=document.getElementById('tblDescriptionOfGood');
		var prevpos=0;
		var verprepos=0;
			var dsc=document.getElementById('txtareaDisc').value;
			var style=document.getElementById('txtStyle').value;
			var unit1=document.getElementById('txtUnit').value;
			var unitprice=document.getElementById('txtUnitPrice').value;
			var gross=document.getElementById('txtGross').value;
			var ctns=document.getElementById('txtCtns').value;
			var net=document.getElementById('txtNet').value;
			var bpo=document.getElementById('txtBuyerPO').value;
			var unitqty=document.getElementById('txtQtyUnit').value;
			var cm=document.getElementById('txtCM').value;
			var qty=document.getElementById('txtQty').value;
			var category=document.getElementById('cboCategory').value;		
			var hs=document.getElementById('txtHS').value;
			var value=calValue(unitprice,unit1,qty,unitqty,1);
			var procedurecode=document.getElementById('txtProcedureCode').value;
			var umoUnit1=document.getElementById('cboUmoQty1').value;
			var umoUnit2=document.getElementById('cboUmoQty2').value;
			var umoUnit3=document.getElementById('cboUmoQty3').value;
			var ISD=document.getElementById('txtISDNo').value;
			var PL=document.getElementById('txtPL').value;
			var fabric=document.getElementById('txtFabric').value;
			var color=document.getElementById('txtColor').value;
			var uqty1=document.getElementById('txtUmoQty1').value;
			var uqty2=document.getElementById('txtUmoQty2').value;
			var uqty3=document.getElementById('txtUmoQty3').value;
			var CBM=document.getElementById('txtCBM').value;
			var inv =document.getElementById('txtInv').value;
			//var PL=document.getElementById('txtPL').value;
				//verprepos=verpos;
				//prevpos=position;
				
			var lastRow 		= editgrid.rows.length;	
			var row 			= editgrid.insertRow(lastRow);
					
			row.ondblclick=editItems;
			row.className ="bcgcolor-tblrow mouseover";
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =inv;
				rowCell.id=category;
		if(inv=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =style;
				rowCell.id=category;
		if(style=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =bpo;
				rowCell.id=category;
		if(bpo=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL;
				rowCell.id=procedurecode;
		if(PL=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =dsc;
				rowCell.id=procedurecode;
		if(dsc=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =fabric;
				rowCell.id=procedurecode;
		if(fabric=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =color;
		if(color=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =unitprice;
		if(unitprice=="")
		{
			rowCell.innerHTML = "n/a";
		}						
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =unitqty;		
		if(unitqty=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =qty;
		if(qty=="")
		{
			rowCell.innerHTML = "0";
		}			
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =unit1;		
		if(unit1=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =value;
		if(value=="")
		{
			rowCell.innerHTML = "0";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =gross;				
		if(gross=="")
		{
			rowCell.innerHTML = "0";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =net;
		if(net=="")
		{
			rowCell.innerHTML = "0";
		}					
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =hs;	
		if(hs=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =ctns;
				
		
		if(ctns=="")
		{
			rowCell.innerHTML = "0";
		}			
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = uqty1;
				cellDelete.id=umoUnit1;
		if(uqty1=="")
		{
			cellDelete.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = uqty2;
				cellDelete.id=umoUnit2;
		if(uqty2=="")
		{
			cellDelete.innerHTML = "0";
		}					
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = uqty3;
				cellDelete.id=umoUnit3;
		if(uqty3=="")
		{
			cellDelete.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD;
		if(ISD=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM;
		if(CBM=="")
		{
			cellDelete.innerHTML = "0";
		}
		cleardata();
		InsertDetail();
		}
		else
		alert("Procedure code format should be like 0000.000");
	}
	}
	
}
