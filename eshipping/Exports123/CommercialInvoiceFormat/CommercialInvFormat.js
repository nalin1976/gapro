$(document).ready(function() 
{
		$('#btnSave').click(function()
		{
			
			saveData();			
		});
		
		$('#btnDelete').click(function()
		{
			deleteData();
			

		});
		
		$('#btnNew').click(function()
		{
				
				clearData();
				combodisable();
				
		});
		
		$('#btnView').click(function()
		{
				 $('.chkbx').removeAttr('disabled');
		   		  $('.txtbox').removeAttr('disabled');
				

				
		});
});

function loadDetails()
{
	
	$('.chkbx').removeAttr('checked');
	$('.chkbx').attr('disabled','disabled');
	$('.txtbox').attr('disabled','disabled');
	 $('#cboView').removeAttr('disabled');
	if($('#cboView').val()=="" )
	{
		clearData();
	}
	else
	{
	var cboview =  $('#cboView').val();
	 
	 var path  = "CommercialInvFormat_middle.php?request=loadDetails&cboview="+cboview;
	 var xml_http_obj=$.ajax({url:path,async:false});
	 
	 $('#txtCommercialInv').val(xml_http_obj.responseXML.getElementsByTagName('Commercial')[0].childNodes[0].nodeValue);
	 $('#cboBuyer').val(xml_http_obj.responseXML.getElementsByTagName('Buyer')[0].childNodes[0].nodeValue);
	 $('#cboDestination').val(xml_http_obj.responseXML.getElementsByTagName('Destination')[0].childNodes[0].nodeValue);
	 $('#cboTransport').val(xml_http_obj.responseXML.getElementsByTagName('Transport')[0].childNodes[0].nodeValue);
	 $('#txtLine1').val(xml_http_obj.responseXML.getElementsByTagName('PTline1')[0].childNodes[0].nodeValue);
	 $('#txtLine2').val(xml_http_obj.responseXML.getElementsByTagName('PTline2')[0].childNodes[0].nodeValue);
	 $('#txtLine3').val(xml_http_obj.responseXML.getElementsByTagName('PTline3')[0].childNodes[0].nodeValue);
	 $('#cboNotify1').val(xml_http_obj.responseXML.getElementsByTagName('PTnotify1')[0].childNodes[0].nodeValue);
	 $('#cboNotify2').val(xml_http_obj.responseXML.getElementsByTagName('PTnotify2')[0].childNodes[0].nodeValue);
	 $('#cboNotify3').val(xml_http_obj.responseXML.getElementsByTagName('PTnotify3')[0].childNodes[0].nodeValue);
	 $('#cboAccountee').val(xml_http_obj.responseXML.getElementsByTagName('Accountee')[0].childNodes[0].nodeValue);
	 $('#cboCsc').val(xml_http_obj.responseXML.getElementsByTagName('CSC')[0].childNodes[0].nodeValue);
	 $('#cboSold').val(xml_http_obj.responseXML.getElementsByTagName('Deliveryto')[0].childNodes[0].nodeValue);
	 $('#cboIncoTerm').val(xml_http_obj.responseXML.getElementsByTagName('Incoterm')[0].childNodes[0].nodeValue);
	 $('#cboAuthorised').val(xml_http_obj.responseXML.getElementsByTagName('Authorise')[0].childNodes[0].nodeValue);
	 $('#txtMLine1').val(xml_http_obj.responseXML.getElementsByTagName('MMline1')[0].childNodes[0].nodeValue);
	 $('#txtMLine2').val(xml_http_obj.responseXML.getElementsByTagName('MMline2')[0].childNodes[0].nodeValue);
	 $('#txtMLine3').val(xml_http_obj.responseXML.getElementsByTagName('MMline3')[0].childNodes[0].nodeValue);
	 $('#txtMLine4').val(xml_http_obj.responseXML.getElementsByTagName('MMline4')[0].childNodes[0].nodeValue);
	 $('#txtMLine5').val(xml_http_obj.responseXML.getElementsByTagName('MMline5')[0].childNodes[0].nodeValue);
	 $('#txtMLine6').val(xml_http_obj.responseXML.getElementsByTagName('MMline6')[0].childNodes[0].nodeValue);
	 $('#txtMLine7').val(xml_http_obj.responseXML.getElementsByTagName('MMline7')[0].childNodes[0].nodeValue);
	 $('#txtSLine1').val(xml_http_obj.responseXML.getElementsByTagName('SMline1')[0].childNodes[0].nodeValue);
	 $('#txtSLine2').val(xml_http_obj.responseXML.getElementsByTagName('SMline2')[0].childNodes[0].nodeValue);
	 $('#txtSLine3').val(xml_http_obj.responseXML.getElementsByTagName('SMline3')[0].childNodes[0].nodeValue);
	 $('#txtSLine4').val(xml_http_obj.responseXML.getElementsByTagName('SMline4')[0].childNodes[0].nodeValue);
	 $('#txtSLine5').val(xml_http_obj.responseXML.getElementsByTagName('SMline5')[0].childNodes[0].nodeValue);
	 $('#txtSLine6').val(xml_http_obj.responseXML.getElementsByTagName('SMline6')[0].childNodes[0].nodeValue);
	 $('#txtSLine7').val(xml_http_obj.responseXML.getElementsByTagName('SMline7')[0].childNodes[0].nodeValue);
	 
	 $('#txtBuyerTitle').val(xml_http_obj.responseXML.getElementsByTagName('strBuyerTitle')[0].childNodes[0].nodeValue);
	 $('#txtBrokerTitle').val(xml_http_obj.responseXML.getElementsByTagName('strBrokerTitle')[0].childNodes[0].nodeValue);
	 $('#txtAccounteeTitle').val(xml_http_obj.responseXML.getElementsByTagName('strAccounteeTitle')[0].childNodes[0].nodeValue);
	 $('#txtNotify1Title').val(xml_http_obj.responseXML.getElementsByTagName('strNotify1Title')[0].childNodes[0].nodeValue);
	 $('#txtNotify2Title').val(xml_http_obj.responseXML.getElementsByTagName('strNotify2Title')[0].childNodes[0].nodeValue);
	 $('#txtCSCTitle').val(xml_http_obj.responseXML.getElementsByTagName('strCSCTitle')[0].childNodes[0].nodeValue);
	 $('#txtSoldTitle').val(xml_http_obj.responseXML.getElementsByTagName('strSoldTitle')[0].childNodes[0].nodeValue);
	  $('#txtBuyerBank').val(xml_http_obj.responseXML.getElementsByTagName('BuyerBank')[0].childNodes[0].nodeValue);
	  $('#txtIncoDesc').val(xml_http_obj.responseXML.getElementsByTagName('IncoDesc')[0].childNodes[0].nodeValue);
	  $('#cboForwader').val(xml_http_obj.responseXML.getElementsByTagName('Forwader')[0].childNodes[0].nodeValue);
	 
	 
	}
	 
	 load_format_details();
	 
}

function view_detail()
{
	
	var commercial_combo	="<select name=\"cboView\" class=\"txtbox\" style=\"width:308px\" id=\"cboView\"onchange=\"loadDetails()\" tabindex=\"1\">";

	$('#commercialInv').html(commercial_combo);	
	loadCombo('SELECT intCommercialInvId,strCommercialInv FROM commercialinvformat order by strCommercialInv','cboView');	
	
	
}

function clearData()
{
		
		  document.frmCommercialInvoice.reset();
		  $('.chkbx').removeAttr('disabled');
		  $('.txtbox').removeAttr('disabled');
}

function combodisable()
{
	var commercial_combo1	="<select name=\"cboView\" class=\"txtbox\" disabled=\"disabled\" style=\"width:308px\" 		id=\"cboView\"onchange=\"loadDetails()\" tabindex=\"1\">";
	$('#commercialInv').html(commercial_combo1);
}

function saveData()
{
	
	if(validateform())
	{	showPleaseWait();
		var commercialid 	 = $('#cboView').val();
		var commercial	 	 = $('#txtCommercialInv').val();
		var buyer 		 	 = $('#cboBuyer').val();
		var destination	 	 = $('#cboDestination').val();
		var transport	 	 = $('#cboTransport').val();
		var ptline1		 	 = $('#txtLine1').val();
		var ptline2 	 	 = $('#txtLine2').val();
		var ptline3 	 	 = $('#txtLine3').val();
		var BuyerBank 	 	 = $('#txtBuyerBank').val();
		var ptnotify1	 	 = $('#cboNotify1').val();
		var ptnotify2 	 	 = $('#cboNotify2').val();
		var ptnotify3	 	 = $('#cboNotify3').val();
		var ptnotify4	 	 = $('#cboNotify4').val();
		var ptnotify5	 	 = $('#cboNotify5').val();
		var acountee 	 	 = $('#cboAccountee').val();
		var csc			 	 = $('#cboCsc').val();
		var sold		 	 = $('#cboSold').val();
		var incoterm	 	 = $('#cboIncoTerm').val();
		var authorise	 	 = $('#cboAuthorised').val();
		var mline1		 	 = $('#txtMLine1').val();
		var mline2 			 = $('#txtMLine2').val();
		var mline3			 = $('#txtMLine3').val();
		var mline4			 = $('#txtMLine4').val();
		var mline5			 = $('#txtMLine5').val();
		var mline6			 = $('#txtMLine6').val();
		var mline7			 = $('#txtMLine7').val();
		var sline1			 = $('#txtSLine1').val();
		var sline2			 = $('#txtSLine2').val();
		var sline3			 = $('#txtSLine3').val();
		var sline4			 = $('#txtSLine4').val();
		var sline5			 = $('#txtSLine5').val();
		var sline6			 = $('#txtSLine6').val();
		var sline7			 = $('#txtSLine7').val();
		var buyerTitle		 = $('#txtBuyerTitle').val();
		var brokerTitle		 = $('#txtBrokerTitle').val();
		var accounteeTitle	 = $('#txtAccounteeTitle').val();
		var notify1Title	 = $('#txtNotify1Title').val();
		var notify2Title	 = $('#txtNotify2Title').val();
		var CSCTitle	 	 = $('#txtCSCTitle').val();
		var soldTitle		 = $('#txtSoldTitle').val();
		var IncoDesc		 = $('#txtIncoDesc').val();
		var forwader		 = $('#cboForwader').val();
		
		
		
		if(document.getElementById("cboView").value!="")
		{
		var url	='CommercialInvFormatdb.php?request=updateData&commercialid='+URLEncode(commercialid)+'&commercial='+URLEncode(commercial)+'&buyer='+URLEncode(buyer)+'&destination='+URLEncode(destination)+'&transport='+URLEncode(transport)+'&ptline1='+URLEncode(ptline1)+'&ptline2='+URLEncode(ptline2)+'&ptline3='+URLEncode(ptline3)+'&ptnotify1='+URLEncode(ptnotify1)+'&ptnotify2='+URLEncode(ptnotify2)+'&ptnotify3='+URLEncode(ptnotify3)+'&acountee='+URLEncode(acountee)+'&csc='+URLEncode(csc)+'&sold='+URLEncode(sold)+'&incoterm='+URLEncode(incoterm)+'&authorise='+URLEncode(authorise)+'&mline1='+URLEncode(mline1)+'&mline2='+URLEncode(mline2)+'&mline3='+URLEncode(mline3)+'&mline4='+URLEncode(mline4)+'&mline5='+URLEncode(mline5)+'&mline6='+URLEncode(mline6)+'&mline7='+URLEncode(mline7)+'&sline1='+URLEncode(sline1)+'&sline2='+URLEncode(sline2)+'&sline3='+URLEncode(sline3)+'&sline4='+URLEncode(sline4)+'&sline5='+URLEncode(sline5)+'&sline6='+URLEncode(sline6)+'&sline7='+URLEncode(sline7)+'&buyerTitle='+URLEncode(buyerTitle)+'&brokerTitle='+URLEncode(brokerTitle)+'&accounteeTitle='+URLEncode(accounteeTitle)+'&notify1Title='+URLEncode(notify1Title)+'&notify2Title='+URLEncode(notify2Title)+'&CSCTitle='+URLEncode(CSCTitle)+'&soldTitle='+URLEncode(soldTitle)+'&BuyerBank='+URLEncode(BuyerBank)+'&IncoDesc='+URLEncode(IncoDesc)+'&forwader='+URLEncode(forwader);
		}
		else
		{
			var url	='CommercialInvFormatdb.php?request=saveData&commercial='+URLEncode(commercial)+'&buyer='+URLEncode(buyer)+'&destination='+URLEncode(destination)+'&transport='+URLEncode(transport)+'&ptline1='+URLEncode(ptline1)+'&ptline2='+URLEncode(ptline2)+'&ptline3='+URLEncode(ptline3)+'&ptnotify1='+URLEncode(ptnotify1)+'&ptnotify2='+URLEncode(ptnotify2)+'&ptnotify3='+URLEncode(ptnotify3)+'&acountee='+URLEncode(acountee)+'&csc='+URLEncode(csc)+'&sold='+URLEncode(sold)+'&incoterm='+URLEncode(incoterm)+'&authorise='+URLEncode(authorise)+'&mline1='+URLEncode(mline1)+'&mline2='+URLEncode(mline2)+'&mline3='+URLEncode(mline3)+'&mline4='+URLEncode(mline4)+'&mline5='+URLEncode(mline5)+'&mline6='+URLEncode(mline6)+'&mline7='+URLEncode(mline7)+'&sline1='+URLEncode(sline1)+'&sline2='+URLEncode(sline2)+'&sline3='+URLEncode(sline3)+'&sline4='+URLEncode(sline4)+'&sline5='+URLEncode(sline5)+'&sline6='+URLEncode(sline6)+'&sline7='+URLEncode(sline7)+'&buyerTitle='+URLEncode(buyerTitle)+'&brokerTitle='+URLEncode(brokerTitle)+'&accounteeTitle='+URLEncode(accounteeTitle)+'&notify1Title='+URLEncode(notify1Title)+'&notify2Title='+URLEncode(notify2Title)+'&CSCTitle='+URLEncode(CSCTitle)+'&soldTitle='+URLEncode(soldTitle)+'&BuyerBank='+URLEncode(BuyerBank)+'&IncoDesc='+URLEncode(IncoDesc)+'&forwader='+URLEncode(forwader);
		}
		
		var xml_http_obj =$.ajax({url:url,async:false});
		
		
		if(xml_http_obj.responseText!="error")
		
		{		
			view_detail();
			$('#cboView').val(xml_http_obj.responseText);
			savedetails()	
			
		}
				
		else
		{
			alert("Operation failed to save.");
			hidePleaseWait();
		}
	}
	else
	{
		return false;
	}
  
}

function deleteData()
{
	if(document.getElementById("cboView").value=="")
	{
		var commercial_combo	="<select name=\"cboView\" class=\"txtbox\" style=\"width:308px\" id=\"cboView\"onchange=\"loadDetails()\" tabindex=\"1\">";

	$('#commercialInv').html(commercial_combo);	
	loadCombo('SELECT intCommercialInvId,strCommercialInv FROM commercialinvformat order by strCommercialInv','cboView');	
	alert("please select a commercial invoice.");
	document.getElementById("cboView").focus();
		
	}
	
	else
	{
		var deletecmi =  $('#cboView').val();
		var deletecmitxt = $("#cboView option:selected").text();
		
		var url='CommercialInvFormatdb.php?request=deleteData&deletecmi='+deletecmi;
		var xml_http_obj =$.ajax({url:url,async:false});
		
		if(xml_http_obj.responseText=="delete")
		{
			var ans=confirm("Are you sure you want to  delete '" +deletecmitxt+ "' ?");        		       	
        		 	if(ans)
					{		alert("Deleted successfully.")
							clearData();
							view_detail();
							
					}								
				
		}
		else 
		{
				
			alert("Error.");
			
													
		}
		
	}
}
function validateform()
{
	if(document.getElementById("txtCommercialInv").value=="")
		{
			alert("Please enter a format name .");
			document.getElementById("txtCommercialInv").focus();
			return false;
		}
	
	if(document.getElementById("cboBuyer").value=="")
		{
			alert("Please select the buyer.");
			document.getElementById("cboBuyer").focus();
			return false;
		}
		
	if(document.getElementById("cboDestination").value=="")
		{
			alert("Please select the destination.");
			document.getElementById("cboDestination").focus();
			return false;
		}
		
	if(document.getElementById("cboTransport").value=="")
		{
			alert("Please select the tranport mode.");
			document.getElementById("cboTransport").focus();
			return false;
		}
		
		else
		{
			return true;
		}
}

function  savedetails()
{
	
	var tbl=$("#tblDescriptionOfGood")[0];
	var format_id=$('#cboView').val();
	var tr_length=$("#tblDescriptionOfGood")[0].rows.length;
	for(var i=1;i<tr_length;i++)
	{
		 if(tbl.rows[i].cells[0].childNodes[0].checked==true){
		 var doc_id=tbl.rows[i].cells[0].childNodes[0].id;	
		 var path  = "CommercialInvFormatdb.php?request=savedetails&doc_id="+doc_id+"&format_id="+format_id;
		 var xml_http_obj=$.ajax({url:path,async:false});
		}
	}
	alert("Saved successfully.")
	hidePleaseWait();
		
}


function load_format_details()
{
	 var format_id	    =$('#cboView').val();
	 var url		    = "CommercialInvFormat_middle.php?request=load_format_details&format_id="+format_id;
	 var xml_http_obj   =$.ajax({url:url,async:false});
	 var xml_document_id=xml_http_obj.responseXML.getElementsByTagName('DocumentId');
	 for(var j=0;j<xml_document_id.length;j++)
	 	{
			$('#'+xml_document_id[j].childNodes[0].nodeValue).attr('checked','checked');
		}
		
}

function copy_format()
{
	$('#cboView').val("");
	$('.chkbx').removeAttr('disabled');
	$('.txtbox').removeAttr('disabled');
}