// JavaScript Document
var pub_invoiceId = 0;
var pub_InvNo = 0;
var pub_InvNo_arry ="";
var pub_invoiceforminvNo = 0;
var mainRow = 0;
var weeklySheduleNo = 0;
function loadComInvData(SDPNo)
{
	if(SDPNo=="")
	{
		clearLoadSDP();
		return;
	}
	pub_invoiceId = SDPNo;
	clearLoadSDP();
	document.getElementById("cboSDP").value=pub_invoiceId;
	var url = 'commercialinvoicedb.php?Request=loadComInvData&SDPNo='+SDPNo;
	var xml_http_obj  = $.ajax({url:url,async:false});
	
	$('#cboConsignee').val(xml_http_obj.responseXML.getElementsByTagName('Consignee')[0].childNodes[0].nodeValue);
	$('#cboDestination').val(xml_http_obj.responseXML.getElementsByTagName('Destination')[0].childNodes[0].nodeValue);
	$('#cboTransportMode').val(xml_http_obj.responseXML.getElementsByTagName('TransportMode')[0].childNodes[0].nodeValue);
	$('#cboIncoterm').val(xml_http_obj.responseXML.getElementsByTagName('Incoterm')[0].childNodes[0].nodeValue);
	$('#cboPaymentTerm').val(xml_http_obj.responseXML.getElementsByTagName('PaymentTerm')[0].childNodes[0].nodeValue);
	$('#cboBank').val(xml_http_obj.responseXML.getElementsByTagName('Bank')[0].childNodes[0].nodeValue);
	$('#cboPortOfLoading').val(xml_http_obj.responseXML.getElementsByTagName('PortOfLoading')[0].childNodes[0].nodeValue);
	$('#cboExporter').val(xml_http_obj.responseXML.getElementsByTagName('Exporter')[0].childNodes[0].nodeValue);
	$('#cboManufacturer').val(xml_http_obj.responseXML.getElementsByTagName('Manufacturer')[0].childNodes[0].nodeValue);	
}
function clearLoadSDP()
{
	document.getElementById("cboConsignee").value = "";
	document.getElementById("cboDestination").value = "";
	document.getElementById("cboTransportMode").value = "";
	document.getElementById("cboIncoterm").value = "";
	document.getElementById("cboPaymentTerm").value = "";
	document.getElementById("cboBank").value = "";
	document.getElementById("cboPortOfLoading").value = "";
	document.getElementById("cboExporter").value = "";
	document.getElementById("cboManufacturer").value = "";	
}
function clearFormData()
{
	document.frmShipmentData.reset();
}
function saveData()
{
	if(!validateInterface())
		return;
	var invoiceNo = $('#cboInvoiceNo').val();
	var invoiceNoText = $("#cboInvoiceNo option:selected").text();
	if(invoiceNo=="")				
		{
			getInvNo();
			saveHeader(0);	
		}
	else
		{
			pub_InvNo=invoiceNoText;
			saveHeader(1);
		}
}
function getInvNo()
{
	var url = "commercialinvoicedb.php?Request=getInvNo";
	htmlobj = $.ajax({url:url,async:false});
	pub_InvNo = htmlobj.responseText;
}
function saveHeader(status)
{
	var invDate	 		 = $('#txtInvoiceDate').val();
	var SDPNo 		 	 = $('#cboSDP').val();
	var Consignee		 = $('#cboConsignee').val();
	var Exporter	 	 = $('#cboExporter').val();
	var Manufacturer	 = $('#cboManufacturer').val();
	var PortOfLoading	 = $('#cboPortOfLoading').val();
	var TransportMode 	 = $('#cboTransportMode').val();
	var Destination 	 = $('#cboDestination').val();
	var Incoterm 	 	 = $('#cboIncoterm').val();
	var PaymentTerm		 = $('#cboPaymentTerm').val();
	var Bank		 	 = $('#cboBank').val();
	var Declaration		 = $('#cboDeclaration').val();
	var OfficeEntry   	 = $('#cboOfficeEntry').val();
	var Carrier 	 	 = $('#txtCarrier').val();
	var Voyage 	 		 = $('#txtVoyage').val();
	var ETDDate			 = $('#txtETD').val();
	var ETADate		 	 = $('#txtETA').val();
	var Currency		 = $('#cboCurrency').val();
	var LocalCurrency    = $('#cboLocalCurrency').val();
	var Insurance		 = $('#txtInsurance').val();
	var Freight		 	 = $('#txtFreight').val();
	var Other		 	 = $('#txtOther').val();
	var WharfClerk    	 = $('#cboWharfClerk').val();
	
	var url ='commercialinvoicedb.php?Request=saveHeaderData&invoiceNo='+URLEncode(pub_InvNo)+'&invDate='+URLEncode(invDate)+'&SDPNo='+URLEncode(SDPNo)+'&Consignee='+URLEncode(Consignee)+'&Exporter='+URLEncode(Exporter)+'&Manufacturer='+URLEncode(Manufacturer)+'&PortOfLoading='+URLEncode(PortOfLoading)+'&TransportMode='+URLEncode(TransportMode)+'&Destination='+URLEncode(Destination)+'&Incoterm='+URLEncode(Incoterm)+'&PaymentTerm='+URLEncode(PaymentTerm)+'&Bank='+URLEncode(Bank)+'&Declaration='+URLEncode(Declaration)+'&OfficeEntry='+URLEncode(OfficeEntry)+'&Carrier='+URLEncode(Carrier)+'&Voyage='+URLEncode(Voyage)+'&ETDDate='+URLEncode(ETDDate)+'&ETADate='+URLEncode(ETADate)+'&Currency='+URLEncode(Currency)+'&LocalCurrency='+URLEncode(LocalCurrency)+'&Insurance='+URLEncode(Insurance)+'&Freight='+URLEncode(Freight)+'&Other='+URLEncode(Other)+'&WharfClerk='+URLEncode(WharfClerk);
	htmlobj = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="HeaderSaved")
	{
		if(status==0)
		{
		pub_InvNo_arry = pub_InvNo.split('/');
		var opt = document.createElement("option");
		opt.text = pub_InvNo;
		opt.value = pub_InvNo_arry[2];
		opt.selected = 'selected';
		document.getElementById("cboInvoiceNo").options.add(opt);
		}
		if(status==1)
		{
			pub_InvNo_arry = pub_InvNo.split('/');
			loadCombo('select intInvoiceNo,strInvoice from shipping_pre_inv_header order by strInvoice','cboInvoiceNo');
			document.getElementById("cboInvoiceNo").value=pub_InvNo_arry[2];
		}
		alert("Saved Successfully.");
		
	}
	else
	{
		alert("Error in Saving.");	
		//document.getElementById("butSave").style.display='inline';
		//hidePleaseWait();
	}
}
function validateInterface()
{
	if(document.getElementById("txtInvoiceDate").value=="")
		{
			alert("Please enter a invoice date.");
			document.getElementById("txtInvoiceDate").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	
	if(document.getElementById("cboSDP").value=="")
		{
			alert("Please select a invoice format.");
			document.getElementById("cboSDP").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
		
	if(document.getElementById("cboConsignee").value=="")
		{
			alert("Please select a consignee.");
			document.getElementById("cboConsignee").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
		
	if(document.getElementById("cboExporter").value=="")
		{
			alert("Please select a exporter.");
			document.getElementById("cboExporter").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboManufacturer").value=="")
		{
			alert("Please select a manufacturer.");
			document.getElementById("cboManufacturer").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboPortOfLoading").value=="")
		{
			alert("Please select a port of loading.");
			document.getElementById("cboPortOfLoading").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboTransportMode").value=="")
		{
			alert("Please select a transport mode.");
			document.getElementById("cboTransportMode").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboDestination").value=="")
		{
			alert("Please select a destination.");
			document.getElementById("cboDestination").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboIncoterm").value=="")
		{
			alert("Please select a incoterm.");
			document.getElementById("cboIncoterm").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboPaymentTerm").value=="")
		{
			alert("Please select a payment term.");
			document.getElementById("cboPaymentTerm").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboBank").value=="")
		{
			alert("Please select a bank.");
			document.getElementById("cboBank").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("txtCarrier").value=="")
		{
			alert("Please enter carrier.");
			document.getElementById("txtCarrier").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("txtETD").value=="")
		{
			alert("Please enter ETD.");
			document.getElementById("txtETD").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("txtETA").value=="")
		{
			alert("Please enter ETA.");
			document.getElementById("txtETA").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboCurrency").value=="")
		{
			alert("Please select currency.");
			document.getElementById("cboCurrency").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	if(document.getElementById("cboLocalCurrency").value=="")
		{
			alert("Please select local currency.");
			document.getElementById("cboLocalCurrency").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}	
		else
		{
			return true;
		}
}
function loadData(invoiceNo)
{
	if(invoiceNo=="")
	{
		clearFormData();
		return;
	}
	pub_invoiceforminvNo = invoiceNo;
	clearFormData();
	document.getElementById("cboInvoiceNo").value=pub_invoiceforminvNo;
	var url  	  	  = "commercialinvoicedb.php?Request=loadData&invoiceNo="+invoiceNo;
	var xml_http_obj  = $.ajax({url:url,async:false});
	
	 $('#txtInvoiceDate').val(xml_http_obj.responseXML.getElementsByTagName('InvoiceDate')[0].childNodes[0].nodeValue);
     $('#cboSDP').val(xml_http_obj.responseXML.getElementsByTagName('SDPNo')[0].childNodes[0].nodeValue);
	 $('#cboConsignee').val(xml_http_obj.responseXML.getElementsByTagName('Consignee')[0].childNodes[0].nodeValue);
	 $('#cboExporter').val(xml_http_obj.responseXML.getElementsByTagName('Exporter')[0].childNodes[0].nodeValue);
	 $('#cboManufacturer').val(xml_http_obj.responseXML.getElementsByTagName('Manufacturer')[0].childNodes[0].nodeValue);
	 $('#cboPortOfLoading').val(xml_http_obj.responseXML.getElementsByTagName('PortOfLoading')[0].childNodes[0].nodeValue);
	 $('#cboTransportMode').val(xml_http_obj.responseXML.getElementsByTagName('ShipmentMode')[0].childNodes[0].nodeValue);
	 $('#cboDestination').val(xml_http_obj.responseXML.getElementsByTagName('Destination')[0].childNodes[0].nodeValue);
	 $('#cboIncoterm').val(xml_http_obj.responseXML.getElementsByTagName('IncoTerm')[0].childNodes[0].nodeValue);
	 $('#cboPaymentTerm').val(xml_http_obj.responseXML.getElementsByTagName('PayTerm')[0].childNodes[0].nodeValue);
	 $('#cboBank').val(xml_http_obj.responseXML.getElementsByTagName('Bank')[0].childNodes[0].nodeValue);
	 $('#cboDeclaration').val(xml_http_obj.responseXML.getElementsByTagName('Declaration')[0].childNodes[0].nodeValue);
	 $('#cboOfficeEntry').val(xml_http_obj.responseXML.getElementsByTagName('OfficeOfEntry')[0].childNodes[0].nodeValue);
	 $('#txtCarrier').val(xml_http_obj.responseXML.getElementsByTagName('Carrier')[0].childNodes[0].nodeValue);
	 $('#txtVoyage').val(xml_http_obj.responseXML.getElementsByTagName('Voyage')[0].childNodes[0].nodeValue);
	 $('#txtETD').val(xml_http_obj.responseXML.getElementsByTagName('ETD')[0].childNodes[0].nodeValue);
	 $('#txtETA').val(xml_http_obj.responseXML.getElementsByTagName('ETA')[0].childNodes[0].nodeValue);
	 $('#cboCurrency').val(xml_http_obj.responseXML.getElementsByTagName('Currency')[0].childNodes[0].nodeValue);
	 $('#cboLocalCurrency').val(xml_http_obj.responseXML.getElementsByTagName('LocalCurrcy')[0].childNodes[0].nodeValue);
	 $('#txtInsurance').val(xml_http_obj.responseXML.getElementsByTagName('Insurancy')[0].childNodes[0].nodeValue);
	 $('#txtFreight').val(xml_http_obj.responseXML.getElementsByTagName('Freight')[0].childNodes[0].nodeValue);
	 $('#txtOther').val(xml_http_obj.responseXML.getElementsByTagName('Other')[0].childNodes[0].nodeValue);
	 $('#txtETA').val(xml_http_obj.responseXML.getElementsByTagName('ETA')[0].childNodes[0].nodeValue);
	 $('#cboWharfClerk').val(xml_http_obj.responseXML.getElementsByTagName('WharfClerk')[0].childNodes[0].nodeValue);
	
	var url  	  	  = "commercialinvoicedb.php?Request=loadDetailData&invoiceNo="+invoiceNo;
	var htmlobj  = $.ajax({url:url,async:false});
	ClearTable('tblDescription');
	var XMLPONo 			= htmlobj.responseXML.getElementsByTagName("PONo");
	var XMLHSCode		  	= htmlobj.responseXML.getElementsByTagName("HSCode");
	var XMLStyle		  	= htmlobj.responseXML.getElementsByTagName("Style");
	var XMLQty 				= htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLFOB		  		= htmlobj.responseXML.getElementsByTagName("FOB");
	var XMLNetNet		  	= htmlobj.responseXML.getElementsByTagName("NetNet");
	var XMLNet 				= htmlobj.responseXML.getElementsByTagName("Net");
	var XMLGross		  	= htmlobj.responseXML.getElementsByTagName("Gross");
	var XMLpackage		  	= htmlobj.responseXML.getElementsByTagName("package");
	var XMLstyleNo		  	= htmlobj.responseXML.getElementsByTagName("styleNo");
	var XMLweeklyShID		= htmlobj.responseXML.getElementsByTagName("weeklyShID");
	var XMLCBM				= htmlobj.responseXML.getElementsByTagName("CBM");
	var XMLPLNo				= htmlobj.responseXML.getElementsByTagName("PLNo");
	var recordExist			= htmlobj.responseXML.getElementsByTagName("recordExist")[0].childNodes[0].nodeValue;
	if(recordExist=="TRUE")
	{
		document.getElementById("butReport").style.display="inline";
		document.getElementById("butReportDetail").style.display="inline";
	}
	else
	{
		document.getElementById("butReport").style.display="none";
		document.getElementById("butReportDetail").style.display="none";
	}
	
	for(loop=0;loop<XMLPONo.length;loop++)
	{
		var PONo 		  = XMLPONo[loop].childNodes[0].nodeValue;
		var HSCode   	  = XMLHSCode[loop].childNodes[0].nodeValue;
		var Style	      = XMLStyle[loop].childNodes[0].nodeValue;
		var Qty 		  = XMLQty[loop].childNodes[0].nodeValue;
		var FOB   	  	  = XMLFOB[loop].childNodes[0].nodeValue;
		var NetNet	      = XMLNetNet[loop].childNodes[0].nodeValue;
		var Net 		  = XMLNet[loop].childNodes[0].nodeValue;
		var Gross   	  = XMLGross[loop].childNodes[0].nodeValue;
		var package	      = XMLpackage[loop].childNodes[0].nodeValue;
		var styleNo	      = XMLstyleNo[loop].childNodes[0].nodeValue;
		var weeklySheduId = XMLweeklyShID[loop].childNodes[0].nodeValue;
		var CBM 		  = XMLCBM[loop].childNodes[0].nodeValue;
		var PLNo 		  = (XMLPLNo[loop].childNodes[0].nodeValue==""?'n/a':XMLPLNo[loop].childNodes[0].nodeValue);
		
		createMainGrid(weeklySheduId,PONo,Style,HSCode,Qty,FOB,NetNet,Net,Gross,CBM,package,PLNo,styleNo);
	}
}
function deleteData()
{
	var invNo = $('#cboInvoiceNo').val();
	var deleteInvtxt = $("#cboInvoiceNo option:selected").text();
	if(invNo=="")
	{
		alert("Please select a Invoice Format.");
		document.getElementById("cboInvoiceNo").focus();
		return;
	}
	var ans=confirm("Are you sure you want to  delete '" +deleteInvtxt+ "' ?"); 
	if(ans)
	{		
		var url = 'commercialinvoicedb.php?Request=deleteData&invNo='+invNo;
		var http_obj = $.ajax({url:url,async:false});
		if(http_obj.responseText=="Deleted")
		{
			alert("Deleted Successfully.");
			window.location.href='commercialinvoice.php';
			
		}
		else
		{
			alert("Error in Deleting.");
		
		}
	}	
	else
	{
		return;
	}
}
function loadPOpup()
{
	
	showBackGround('divBG',0);
	var url = "polistpop.php?";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(700,260,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
}
function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function loadPOData()
{
	if(document.getElementById("cboWeeklyShedNo").value=="")
	{
		alert("Please select a weekly shedule No.");
		document.getElementById("cboWeeklyShedNo").focus();
		return;
	}
	var weeklyShedNo = $('#cboWeeklyShedNo').val();
	var destination  = $('#cbopopDestination').val();
	var mode         = $('#cbopopMode').val();
	
	var url = "commercialinvoicedb.php?Request=loadPOData&weeklyShedNo="+weeklyShedNo+"&destination="+destination+"&mode="+mode;
	var htmlobj  = $.ajax({url:url,async:false});
	ClearTable('popupPOSearch');
	
	var XMLPONo 			  = htmlobj.responseXML.getElementsByTagName("PONo");
	var XMLDestination  	  = htmlobj.responseXML.getElementsByTagName("cityName");
	var XMLStyleId		  	  = htmlobj.responseXML.getElementsByTagName("styleId");
	var XMLWkScheduleDetailId = htmlobj.responseXML.getElementsByTagName("WkScheduleDetailId");
	
	for(loop=0;loop<XMLPONo.length;loop++)
	{
		var PONo 		  	   = XMLPONo[loop].childNodes[0].nodeValue;
		var Destination   	   = XMLDestination[loop].childNodes[0].nodeValue;
		var styleId	      	   = XMLStyleId[loop].childNodes[0].nodeValue;
		var WkScheduleDetailId = XMLWkScheduleDetailId[loop].childNodes[0].nodeValue;
		
		var tbl 		= document.getElementById('popupPOSearch');
		
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
			
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.id = styleId;
		cell.innerHTML = "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" /> ";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.id = WkScheduleDetailId;
		cell.innerHTML = PONo;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML = Destination;
	}
}
function checkAll(obj)
{
	var tbl = document.getElementById("popupPOSearch");
	if(obj.checked)
		var check = true;
	else
		var check = false;
		
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = check;		
	}
}
function addToMainGrid()
{
	var tbl_pop   = document.getElementById("popupPOSearch");
	var tbl_mgrid = document.getElementById("tblDescription");

	var booCheck = 0;
	for(var i =1;i<tbl_pop.rows.length;i++)
	{
		if(tbl_pop.rows[i].cells[0].childNodes[0].checked==true)
		{
			var stleNo	= tbl_pop.rows[i].cells[0].id;
			var PONo   	= tbl_pop.rows[i].cells[1].childNodes[0].nodeValue;
			var weekliShId = tbl_pop.rows[i].cells[1].id;
			booCheck = 1;
			for(var j=1;j <tbl_mgrid.rows.length; j++ )
			{
				
				if(tbl_mgrid.rows[j].cells[1].id==stleNo && tbl_mgrid.rows[j].cells[0].childNodes[0].nodeValue==PONo)
				{
					booCheck = 2;
						
				}
			}
			if(booCheck==1)
				createMainGridStucture(stleNo,PONo,weekliShId);
		}
	}
	if(booCheck==0)
	{
		alert("Please select a PO No.");
		return;
	}
	if(booCheck==2)
	{
		alert("Record already exist.");
		return;
	}
}
function createMainGridStucture(stleNo,PONo,weekliShId)
{
	
	var url = "commercialinvoicedb.php?Request=loadDataToMainGrid&stleNo="+stleNo;
	var htmlobj  = $.ajax({url:url,async:false});
	
	
	var XMLHSCode 			= htmlobj.responseXML.getElementsByTagName("HSCode");
	var XMLFOB			  	= htmlobj.responseXML.getElementsByTagName("FOB");
	var XMLStyle		  	= htmlobj.responseXML.getElementsByTagName("Style");
	
	for(loop=0;loop<XMLStyle.length;loop++)
	{
		var HSCode 		  = XMLHSCode[loop].childNodes[0].nodeValue;
		var FOB   		  = XMLFOB[loop].childNodes[0].nodeValue;
		var Style	      = XMLStyle[loop].childNodes[0].nodeValue;
		
		createMainGrid(weekliShId,PONo,Style,HSCode,'',FOB,'','','','','','n/a',stleNo)
	}
	CloseOSPopUp('popupLayer1');
}
function AddNewPl(stlyeId,row)
{
	var tbl = document.getElementById("tblDescription");
	var weeklySheduId = tbl.rows[row].cells[0].id;
	showBackGround('divBG',0);
	var url = "packinglistpop.php?stlyeId="+stlyeId+"&weeklySheduId="+weeklySheduId;
	mainRow = row;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(550,260,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	
}
function createMainGrid(weekShdNo,PONo,Style,HSCode,Qty,FOB,NetNet,Net,Gross,CBM,Package,PlNo,styleNo)
{
	var tbl 		= document.getElementById('tblDescription');
		
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cellDelete = row.insertCell(0);   
		cellDelete.innerHTML = "<div align=\"center\"><img src=\"../../../images/del.png\" id=\"" + weekShdNo + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";	
		
		var cell = row.insertCell(1);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.id = weekShdNo;
		cell.innerHTML = PONo;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.id = styleNo;
		cell.innerHTML = Style;
		
		var cell = row.insertCell(3);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML ="<input name=\"txtQty\" id=\"txtQty\" size=\"11\" value=\""+HSCode+"\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\" />";
		
		var cell = row.insertCell(4);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML ="<input name=\"txtQty\" id=\"txtQty\" size=\"11\" value=\""+Qty+"\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\" />";
		
		var cell = row.insertCell(5);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML =(FOB==""?0.00:FOB);
		
		var cell = row.insertCell(6);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML ="<input name=\"txtNetNet\" id=\"txtNetNet\" size=\"11\" value=\""+NetNet+"\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\"/>";
		
		var cell = row.insertCell(7);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML ="<input name=\"txtNet\" id=\"txtNet\" size=\"11\" value=\""+Net+"\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\"/>";
		
		var cell = row.insertCell(8);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML ="<input name=\"txtGross\" id=\"txtGross\" size=\"11\" value=\""+Gross+"\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\"/>";
		
		var cell = row.insertCell(9);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML ="<input name=\"txtCBM\" id=\"txtCBM\" size=\"11\" value=\""+CBM+"\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\"/>";
		
		var cell = row.insertCell(10);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML ="<input name=\"txtPackage\" id=\"txtPackage\" size=\"11\" value=\""+Package+"\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\"/>";
		
		var cell = row.insertCell(11);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.innerHTML =PlNo;
		
		var cell = row.insertCell(12);
		cell.className ="normalfnt";
		cell.nowrap = "nowrap";
		cell.id     = styleNo;
		cell.innerHTML ="<img alt=\"add\" src=\"../../../images/add.png\" id=\""+styleNo+"\" onClick=\"AddNewPl(this.id,this.parentNode.parentNode.rowIndex);\" >";
}
function addPLToMainGrid(stlyeId,weeklySheduId)
{
	var tbl = document.getElementById("popupPLSearch");
	var boolCheck = true;
	for(var x =0;x<tbl.rows.length;x++)
	{
		
		if(tbl.rows[x].cells[0].childNodes[0].checked==true)
		{
			boolCheck = false;
			var PLNo = tbl.rows[x].cells[1].childNodes[0].nodeValue;
			var CBM = tbl.rows[x].cells[4].childNodes[0].nodeValue;
			addToMainGridByPlNo(PLNo,CBM,weeklySheduId);
			
		}
		
	}
	if(boolCheck)
	{
		alert("Please select a PL No.");
		document.getElementById("rdoPLNo").focus();
	}
	
}
function addToMainGridByPlNo(PLNo,CBM,weeklySheduId)
{
	
	var tbl = document.getElementById("tblDescription");
	var url = "commercialinvoicedb.php?Request=loadPLDataToGridByPLPop&PLNo="+PLNo;
	var htmlobj  = $.ajax({url:url,async:false});
	tbl.deleteRow(mainRow);
	
	var XMLPONo 			= htmlobj.responseXML.getElementsByTagName("PONo");
	var XMLHSCode		  	= htmlobj.responseXML.getElementsByTagName("HSCode");
	var XMLStyle		  	= htmlobj.responseXML.getElementsByTagName("Style");
	var XMLQty 				= htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLFOB		  		= htmlobj.responseXML.getElementsByTagName("FOB");
	var XMLNetNet		  	= htmlobj.responseXML.getElementsByTagName("NetNet");
	var XMLNet 				= htmlobj.responseXML.getElementsByTagName("Net");
	var XMLGross		  	= htmlobj.responseXML.getElementsByTagName("Gross");
	var XMLpackage		  	= htmlobj.responseXML.getElementsByTagName("package");
	var XMLstyleNo		  	= htmlobj.responseXML.getElementsByTagName("styleNo");
	
	for(loop=0;loop<XMLPONo.length;loop++)
	{
		var PONo 		  = XMLPONo[loop].childNodes[0].nodeValue;
		var HSCode   	  = XMLHSCode[loop].childNodes[0].nodeValue;
		var Style	      = XMLStyle[loop].childNodes[0].nodeValue;
		var Qty 		  = XMLQty[loop].childNodes[0].nodeValue;
		var FOB   	  	  = XMLFOB[loop].childNodes[0].nodeValue;
		var NetNet	      = XMLNetNet[loop].childNodes[0].nodeValue;
		var Net 		  = XMLNet[loop].childNodes[0].nodeValue;
		var Gross   	  = XMLGross[loop].childNodes[0].nodeValue;
		var package	      = XMLpackage[loop].childNodes[0].nodeValue;
		var styleNo	      = XMLstyleNo[loop].childNodes[0].nodeValue;
		
		createMainGrid(weeklySheduId,PONo,Style,HSCode,Qty,FOB,NetNet,Net,Gross,CBM,package,PLNo,styleNo);
	}
	CloseOSPopUp('popupLayer1');
}
function checkInvoiceNo()
{
	if (document.getElementById("cboInvoiceNo").value=="")
		{
			alert("Please fill header data first."); 
			window.location.href='commercialinvoice.php';
			return;
		}		
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function saveDetailData()
{
	var invoiceNo = $('#cboInvoiceNo').val();
	var checkSave = false;
	if(!validateDetailGrid())
		return;
	var url = "commercialinvoicedb.php?Request=deleteDetailData&invoiceNo="+invoiceNo;
	var htmlobj  = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="DeleteError")
	{
		alert("Error in saving.");
		return;
	}
	
	var tbl = document.getElementById("tblDescription");
	
	for(var i=1;i<tbl.rows.length;i++)
	{
		
		var styleId = tbl.rows[i].cells[1].id;
		var weeklyShedNo = tbl.rows[i].cells[0].id;
		var HSCode = tbl.rows[i].cells[2].childNodes[0].value;
		var Qty = tbl.rows[i].cells[3].childNodes[0].value;
		var price = tbl.rows[i].cells[4].childNodes[0].nodeValue;
		var NetNetWeight = tbl.rows[i].cells[5].childNodes[0].value;
		var NetWeight = tbl.rows[i].cells[6].childNodes[0].value;
		var GrossWeight = tbl.rows[i].cells[7].childNodes[0].value;
		var CBM = tbl.rows[i].cells[8].childNodes[0].value;
		var package = tbl.rows[i].cells[9].childNodes[0].value;
		var PLNo = tbl.rows[i].cells[10].childNodes[0].nodeValue;
		
		var url = "commercialinvoicedb.php?Request=saveDetailData&invoiceNo="+invoiceNo+"&styleId="+styleId+"&weeklyShedNo="+weeklyShedNo+"&HSCode="+HSCode+"&Qty="+Qty+"&price="+price+"&NetNetWeight="+NetNetWeight+"&NetWeight="+NetWeight+"&GrossWeight="+GrossWeight+"&CBM="+CBM+"&package="+package+"&PLNo="+PLNo;
		var htmlobj  = $.ajax({url:url,async:false});
		if(htmlobj.responseText=="detailSaved")
			checkSave = true;
	}
	if(checkSave)
	{
		alert("Saved successfully.");
		document.getElementById("butReport").style.display="inline";
		document.getElementById("butReportDetail").style.display="inline";
		ClearTable('tblDescription');
	}
	else
		alert("Error in saving.");
		document.getElementById("butReport").style.display="none";
		document.getElementById("butReportDetail").style.display="none";
		return;
	
}
function validateDetailGrid()
{
	var tbl = document.getElementById("tblDescription");
	if(tbl.rows.length==1)
	{
		alert("No records to save.");
		return;
	}
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[3].childNodes[0].value=="")
		{
			alert("please enter a Qty.");
			tbl.rows[loop].cells[3].childNodes[0].focus();
			return;
		}
		if(tbl.rows[loop].cells[5].childNodes[0].value=="")
		{
			alert("please enter a Net Net weight.");
			tbl.rows[loop].cells[5].childNodes[0].focus();
			return;
		}
		if(tbl.rows[loop].cells[6].childNodes[0].value=="")
		{
			alert("please enter a Net weight.");
			tbl.rows[loop].cells[6].childNodes[0].focus();
			return;
		}
		if(tbl.rows[loop].cells[7].childNodes[0].value=="")
		{
			alert("please enter a Gross weight.");
			tbl.rows[loop].cells[7].childNodes[0].focus();
			return;
		}
		if(tbl.rows[loop].cells[8].childNodes[0].value=="")
		{
			alert("please enter a CBM.");
			tbl.rows[loop].cells[8].childNodes[0].focus();
			return;
		}
		if(tbl.rows[loop].cells[9].childNodes[0].value=="")
		{
			alert("please enter a package.");
			tbl.rows[loop].cells[9].childNodes[0].focus();
			return;
		}
		
	}
	return true;
		
}
function deleteDetailData()
{
	var invoiceNo = $("#cboInvoiceNo").val();
	var invoiceNoTextDetail = $("#cboInvoiceNo option:selected").text();
	var tbl = document.getElementById("tblDescription");
	if(tbl.rows.length<=1)
	{
		alert("No record to delete.");
		return;
	}
	
	var ans=confirm("Are you sure you want to  delete '" +invoiceNoTextDetail+ "' details ?"); 
	if(ans)
	{		
		var url = "commercialinvoicedb.php?Request=deleteDetailData&invoiceNo="+invoiceNo;
		var htmlobj  = $.ajax({url:url,async:false});
		if(htmlobj.responseText=="deleted")
		{
			alert("Deleted successfully.");
			document.getElementById("butReport").style.display="none";
			document.getElementById("butReportDetail").style.display="none";
			ClearTable('tblDescription');
			
		}
		if(htmlobj.responseText=="DeleteError")
		{
			alert("Error in Deleting.");
			return;
		}
	}	
	else
	{
		return;
	}	
}
function rptButtonDis()
{
	document.getElementById("butReport").style.display="none";
	document.getElementById("butReportDetail").style.display="none";
}
function expCusReport()
{
	var InvoiceNo = $('#cboInvoiceNo').val();
	newwindow=window.open('export_cusdec.php?invoiceNo=' +InvoiceNo,'cusdec');
	if (window.focus) {newwindow.focus();}
}
function RemoveItem(obj)
{
	if(confirm("Are you sure you want to remove this item?\n* temporally delete from the form"))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);		
	}
}