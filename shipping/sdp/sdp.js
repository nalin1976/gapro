// JavaScript Document
var pub_comInvNo = 0;
var pub_invoiceId = 0;
function loadBuyerBranch(buyerId)
{
	var url = 'sdpxml.php?Request=loadBuyerBranch&buyerId='+buyerId;
	htmlobj = $.ajax({url:url,async:false});
	var XMLBuyerBranch = htmlobj.responseText;
	document.getElementById('cboBuyerBranch').innerHTML = XMLBuyerBranch;
	if(document.getElementById('cboBuyerBranch').value=="")
		loadNotify(0);
}
function loadNotify(buyerBranchId)
{
	if(buyerBranchId==0)
	{
		document.getElementById('cboNotify1').innerHTML = "";
		document.getElementById('cboNotify2').innerHTML = "";
		document.getElementById('cboNotify3').innerHTML = "";
		document.getElementById('cboNotify4').innerHTML = "";
		return;
	}
	var url = 'sdpxml.php?Request=loadNotify&buyerBranchId='+buyerBranchId;
	htmlobj = $.ajax({url:url,async:false});
	var XMLNotify = htmlobj.responseText;
	document.getElementById('cboNotify1').innerHTML = XMLNotify;
	document.getElementById('cboNotify2').innerHTML = XMLNotify;
	document.getElementById('cboNotify3').innerHTML = XMLNotify;
	document.getElementById('cboNotify4').innerHTML = XMLNotify;
}
function saveData(strCommand)
{
	showPleaseWait();
	if(strCommand!="copyInv")
	document.getElementById("butSave").style.display='none';
	if(!validateform())
		return;
		
	if(!ValidateCommercialInvoiceBeforeSave())	
		return;
	
	var commercialid = $('#cboInvoiceFormat').val();
	if(commercialid=="")				
		{
			getComInvNo();
			saveHeader(0);	
		}
	else if(strCommand=="copyInv")
		{
			var comInvtxt = $("#cboInvoiceFormat option:selected").text();
			var invTitle = $('#txtTitle').val();
			if(comInvtxt==invTitle)
			{
				document.getElementById("txtTitle").value="";
				document.getElementById("txtTitle").focus();
				hidePleaseWait();
				return;
			}
			getComInvNo();
			saveHeader(0);	
		}
	else
		{
			pub_comInvNo=commercialid;
			saveHeader(1);
		}
	
}
function ValidateCommercialInvoiceBeforeSave()
{	
	var x_id = document.getElementById("cboInvoiceFormat").value;
	var x_name = document.getElementById("txtTitle").value;
	
	var x_find = checkInField('shipping_sdp','strSDP_Title',x_name,'intSDPID',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtTitle").focus();
		document.getElementById("butSave").style.display='inline';
		hidePleaseWait();
		return false;
	}
	return true;
}
function validateform()
{
	if(document.getElementById("txtTitle").value=="")
		{
			alert("Please enter a format name .");
			document.getElementById("txtTitle").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
	
	if(document.getElementById("cboBuyer").value=="")
		{
			alert("Please select the buyer.");
			document.getElementById("cboBuyer").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
		
	if(document.getElementById("cboDestination").value=="")
		{
			alert("Please select the destination.");
			document.getElementById("cboDestination").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
		
	if(document.getElementById("cboTransportMode").value=="")
		{
			alert("Please select the tranport mode.");
			document.getElementById("cboTransportMode").focus();
			document.getElementById("butSave").style.display='inline';
			hidePleaseWait();
			return false;
		}
		
		else
		{
			return true;
		}
}
function getComInvNo()
{
	var url = "sdpxml.php?Request=getComInvNo";
	htmlobj = $.ajax({url:url,async:false});
	pub_comInvNo	 = htmlobj.responseText;
}
function saveHeader(status)
{
	var commercialid 	 = $('#cboInvoiceFormat').val();
	var commercial	 	 = $('#txtTitle').val();
	var buyer 		 	 = $('#cboBuyer').val();
	var buyerBranch		 = $('#cboBuyerBranch').val();
	var destination	 	 = $('#cboDestination').val();
	var transport	 	 = $('#cboTransportMode').val();
	var notify1		 	 = $('#cboNotify1').val();
	var notify2 	 	 = $('#cboNotify2').val();
	var notify3 	 	 = $('#cboNotify3').val();
	var notify4 	 	 = $('#cboNotify4').val();
	var incoterm		 = $('#cboIncoterm').val();
	var IncoDesc		 = $('#txtTermDes').val();
	var paymentterm		 = $('#cboPaymentTerm').val();
	var paytermDes   	 = $('#txtPaymentDes').val();
	var Bank 	 	 	 = $('#cboBank').val();
	var BuyerBank 	 	 = $('#cboBuyerBank').val();
	var VAT				 = $('#txtVAT').val();
	var forwader		 = $('#cboForwader').val();
	var mline1		 	 = $('#txtMMLine1').val();
	var mline2 			 = $('#txtMMLine2').val();
	var mline3			 = $('#txtMMLine3').val();
	var mline4			 = $('#txtMMLine4').val();
	var mline5			 = $('#txtMMLine5').val();
	var mline6			 = $('#txtMMLine6').val();
	var mline7			 = $('#txtMMLine7').val();
	var sline1			 = $('#txtSMLine1').val();
	var sline2			 = $('#txtSMLine2').val();
	var sline3			 = $('#txtSMLine3').val();
	var sline4			 = $('#txtSMLine4').val();
	var sline5			 = $('#txtSMLine5').val();
	var sline6			 = $('#txtSMLine6').val();
	var sline7			 = $('#txtSMLine7').val();
	var buyerTitle		 = $('#txtBuyerTitle').val();
	var notify1Title	 = $('#txtNotify1').val();
	var notify2Title 	 = $('#txtNotify2').val();
	var notify3Title 	 = $('#txtNotify3').val();
	var notify4Title 	 = $('#txtNotify4').val();
	
	var portOfLoading 	 = $('#cboPortOfLoading').val();
	var exporter 		 = $('#cboExporter').val();
	var manufacturer 	 = $('#cboManufacturer').val();

	var url ='sdpxml.php?Request=saveHeaderData&commercialid='+URLEncode(pub_comInvNo)+'&commercial='+URLEncode(commercial)+'&buyer='+URLEncode(buyer)+'&buyerBranch='+URLEncode(buyerBranch)+'&destination='+URLEncode(destination)+'&transport='+URLEncode(transport)+'&notify1='+URLEncode(notify1)+'&notify2='+URLEncode(notify2)+'&notify3='+URLEncode(notify3)+'&notify4='+URLEncode(notify4)+'&incoterm='+URLEncode(incoterm)+'&paymentterm='+URLEncode(paymentterm)+'&paytermDes='+URLEncode(paytermDes)+'&Bank='+URLEncode(Bank)+'&BuyerBank='+URLEncode(BuyerBank)+'&VAT='+URLEncode(VAT)+'&forwader='+URLEncode(forwader)+'&mline1='+URLEncode(mline1)+'&mline2='+URLEncode(mline2)+'&mline3='+URLEncode(mline3)+'&mline4='+URLEncode(mline4)+'&mline5='+URLEncode(mline5)+'&mline6='+URLEncode(mline6)+'&mline7='+URLEncode(mline7)+'&sline1='+URLEncode(sline1)+'&sline2='+URLEncode(sline2)+'&sline3='+URLEncode(sline3)+'&sline4='+URLEncode(sline4)+'&sline5='+URLEncode(sline5)+'&sline6='+URLEncode(sline6)+'&sline7='+URLEncode(sline7)+'&buyerTitle='+URLEncode(buyerTitle)+'&notify1Title='+URLEncode(notify1Title)+'&notify2Title='+URLEncode(notify2Title)+'&notify3Title='+URLEncode(notify3Title)+'&notify4Title='+URLEncode(notify4Title)+'&IncoDesc='+URLEncode(IncoDesc)+'&portOfLoading='+URLEncode(portOfLoading)+'&exporter='+URLEncode(exporter)+'&manufacturer='+URLEncode(manufacturer);
	
	htmlobj = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="HeaderSaved")
	{
		if(status==0)
		{
		var opt = document.createElement("option");
		opt.text = commercial;
		opt.value = pub_comInvNo;
		opt.selected = 'selected';
		document.getElementById("cboInvoiceFormat").options.add(opt);
		}
		if(status==1)
		{
			loadCombo('select intSDPID,strSDP_Title from shipping_sdp order by strSDP_Title','cboInvoiceFormat');
			document.getElementById("cboInvoiceFormat").value=pub_comInvNo;
		}
		saveDetails();
	}
	else
	{
		alert("Error in Saving.");	
		document.getElementById("butSave").style.display='inline';
		hidePleaseWait();
	}
}
function  saveDetails()
{
	
	var tbl = document.getElementById("tblDescription");
	var format_id = $('#cboInvoiceFormat').val();
	for(var i=1;i<tbl.rows.length;i++)
	{
		 if(tbl.rows[i].cells[0].childNodes[0].checked==true)
		 {
			 var doc_id = tbl.rows[i].cells[0].childNodes[0].id;	
			 var path   = "sdpxml.php?Request=savedetailData&doc_id="+doc_id+"&format_id="+format_id;
			 var xml_http_obj = $.ajax({url:path,async:false});
		}
	}
	alert("Saved successfully.");
	document.getElementById("butSave").style.display='inline';
	hidePleaseWait();
	
		
}
function loadInvoiceFormats(invoiceId)
{
	if(invoiceId=="")
	{
		clearPage();
		return;
	}
	pub_invoiceId = invoiceId;
	clearPage();
	document.getElementById("cboInvoiceFormat").value=pub_invoiceId;
	 var url  	  = "sdpxml.php?Request=loadDetails&invoiceId="+invoiceId;
	 var xml_http_obj  = $.ajax({url:url,async:false});
	 
	 $('#txtTitle').val(xml_http_obj.responseXML.getElementsByTagName('Commercial')[0].childNodes[0].nodeValue);
	 $('#cboBuyer').val(xml_http_obj.responseXML.getElementsByTagName('Buyer')[0].childNodes[0].nodeValue);
	 loadBuyerBranch(xml_http_obj.responseXML.getElementsByTagName('Buyer')[0].childNodes[0].nodeValue);
	 loadNotify(xml_http_obj.responseXML.getElementsByTagName('Buyer')[0].childNodes[0].nodeValue);
     $('#txtBuyerTitle').val(xml_http_obj.responseXML.getElementsByTagName('BuyerTitle')[0].childNodes[0].nodeValue);
     $('#cboBuyerBranch').val(xml_http_obj.responseXML.getElementsByTagName('BuyerBranch')[0].childNodes[0].nodeValue);
	 $('#cboDestination').val(xml_http_obj.responseXML.getElementsByTagName('Destination')[0].childNodes[0].nodeValue);
	 $('#cboTransportMode').val(xml_http_obj.responseXML.getElementsByTagName('Transport')[0].childNodes[0].nodeValue);
	 $('#cboNotify1').val(xml_http_obj.responseXML.getElementsByTagName('Notify1')[0].childNodes[0].nodeValue);
	 $('#cboNotify2').val(xml_http_obj.responseXML.getElementsByTagName('Notify2')[0].childNodes[0].nodeValue);
	 $('#cboNotify3').val(xml_http_obj.responseXML.getElementsByTagName('Notify3')[0].childNodes[0].nodeValue);
	 $('#cboNotify4').val(xml_http_obj.responseXML.getElementsByTagName('Notify4')[0].childNodes[0].nodeValue);
	 $('#txtNotify1').val(xml_http_obj.responseXML.getElementsByTagName('Notify1Title')[0].childNodes[0].nodeValue);
	 $('#txtNotify2').val(xml_http_obj.responseXML.getElementsByTagName('Notify2Title')[0].childNodes[0].nodeValue);
	 $('#txtNotify3').val(xml_http_obj.responseXML.getElementsByTagName('Notify3Title')[0].childNodes[0].nodeValue);
	 $('#txtNotify4').val(xml_http_obj.responseXML.getElementsByTagName('Notify4Title')[0].childNodes[0].nodeValue);
	 $('#cboIncoterm').val(xml_http_obj.responseXML.getElementsByTagName('Incoterm')[0].childNodes[0].nodeValue);
	 $('#txtTermDes').val(xml_http_obj.responseXML.getElementsByTagName('IncotermDescription')[0].childNodes[0].nodeValue);
	 $('#cboPaymentTerm').val(xml_http_obj.responseXML.getElementsByTagName('PaymentTerm')[0].childNodes[0].nodeValue);
	 $('#txtPaymentDes').val(xml_http_obj.responseXML.getElementsByTagName('PayTermDescription')[0].childNodes[0].nodeValue);
	 $('#cboBank').val(xml_http_obj.responseXML.getElementsByTagName('Bank')[0].childNodes[0].nodeValue);
	 $('#cboBuyerBank').val(xml_http_obj.responseXML.getElementsByTagName('BuyerBank')[0].childNodes[0].nodeValue);
	 $('#txtVAT').val(xml_http_obj.responseXML.getElementsByTagName('VAT')[0].childNodes[0].nodeValue);
	 $('#cboForwader').val(xml_http_obj.responseXML.getElementsByTagName('Forwader')[0].childNodes[0].nodeValue);
	 $('#txtMMLine1').val(xml_http_obj.responseXML.getElementsByTagName('MMline1')[0].childNodes[0].nodeValue);
	 $('#txtMMLine2').val(xml_http_obj.responseXML.getElementsByTagName('MMline2')[0].childNodes[0].nodeValue);
	 $('#txtMMLine3').val(xml_http_obj.responseXML.getElementsByTagName('MMline3')[0].childNodes[0].nodeValue);
	 $('#txtMMLine4').val(xml_http_obj.responseXML.getElementsByTagName('MMline4')[0].childNodes[0].nodeValue);
	 $('#txtMMLine5').val(xml_http_obj.responseXML.getElementsByTagName('MMline5')[0].childNodes[0].nodeValue);
	 $('#txtMMLine6').val(xml_http_obj.responseXML.getElementsByTagName('MMline6')[0].childNodes[0].nodeValue);
	 $('#txtMMLine7').val(xml_http_obj.responseXML.getElementsByTagName('MMline7')[0].childNodes[0].nodeValue);
	 $('#txtSMLine1').val(xml_http_obj.responseXML.getElementsByTagName('SMline1')[0].childNodes[0].nodeValue);
	 $('#txtSMLine2').val(xml_http_obj.responseXML.getElementsByTagName('SMline2')[0].childNodes[0].nodeValue);
	 $('#txtSMLine3').val(xml_http_obj.responseXML.getElementsByTagName('SMline3')[0].childNodes[0].nodeValue);
	 $('#txtSMLine4').val(xml_http_obj.responseXML.getElementsByTagName('SMline4')[0].childNodes[0].nodeValue);
	 $('#txtSMLine5').val(xml_http_obj.responseXML.getElementsByTagName('SMline5')[0].childNodes[0].nodeValue);
	 $('#txtSMLine6').val(xml_http_obj.responseXML.getElementsByTagName('SMline6')[0].childNodes[0].nodeValue);
	 $('#txtSMLine7').val(xml_http_obj.responseXML.getElementsByTagName('SMline7')[0].childNodes[0].nodeValue);
	 $('#cboPortOfLoading').val(xml_http_obj.responseXML.getElementsByTagName('PortOfLoading')[0].childNodes[0].nodeValue);
	 $('#cboExporter').val(xml_http_obj.responseXML.getElementsByTagName('Exporter')[0].childNodes[0].nodeValue);
	 $('#cboManufacturer').val(xml_http_obj.responseXML.getElementsByTagName('Manufacturer')[0].childNodes[0].nodeValue);
	 
	 load_format_details();
}
function  load_format_details()
{
		var tbl				= document.getElementById('tblDescription');
		var format_id	    = $('#cboInvoiceFormat').val();
		var url		        = "sdpxml.php?Request=load_format_details&format_id="+format_id;
		var xml_http_obj    = $.ajax({url:url,async:false});
		var xml_document_id = xml_http_obj.responseXML.getElementsByTagName("DocumentId");
		
		for(var j=0;j<xml_document_id.length;j++)
		{
			var documentId = xml_document_id[j].childNodes[0].nodeValue;
			
			if(tbl.rows[j+1].cells[0].childNodes[0].id==documentId)
			{
				
				tbl.rows[j+1].cells[0].childNodes[0].checked = true;
				//tbl.rows[j+1].cells[0].childNodes[0].disabled ='disabled';
			}
		}
}
function deleteData()
{
	showPleaseWait();
	document.getElementById("butDelete").style.display="none";
	var comInvId = $('#cboInvoiceFormat').val();
	var deletecomInvtxt = $("#cboInvoiceFormat option:selected").text();
	if(comInvId=="")
	{
		alert("Please select a Invoice Format.");
		document.getElementById("cboInvoiceFormat").focus();
		document.getElementById("butDelete").style.display="inline";
		hidePleaseWait();	
		return;
	}
	var ans=confirm("Are you sure you want to  delete '" +deletecomInvtxt+ "' ?"); 
	if(ans)
	{		
		var url = 'sdpxml.php?Request=deleteData&comInvId='+comInvId;
		var http_obj = $.ajax({url:url,async:false});
		if(http_obj.responseText=="Deleted")
		{
			alert("Deleted Successfully.");
			document.getElementById("butDelete").style.display="inline";
			window.location.href='sdp.php';
			hidePleaseWait();
		}
		else
		{
			alert("Error in Deleting.");
			document.getElementById("butDelete").style.display="inline";
			hidePleaseWait();
		}
	}							
	else
	{
		document.getElementById("butDelete").style.display="inline";
		hidePleaseWait();
		return;
	}
	
}
function clearPage()
{
	document.frmSDP.reset();
}