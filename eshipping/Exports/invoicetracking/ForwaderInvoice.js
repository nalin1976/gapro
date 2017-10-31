function loadGrid()
{
	showPleaseWait();
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	for(var i=tbl_forwaderInvDetails.rows.length;i>1;i--)
		tbl_forwaderInvDetails.deleteRow(i-1);
	
	var forwaderId=document.getElementById('cboForwader').value;
	
	var carrierName=document.getElementById('cboCarrier').value;
	
	if(forwaderId!=0 || carrierName!='')
	{
		var url="ForwaderInvoice-db.php?id=loadGrid";
		   url+="&forwaderId="+forwaderId;
		   url+="&carrierName="+carrierName;
		   
		var xmlhttp_obj	  = $.ajax({url:url,async:false})
		//alert(xmlhttp_obj.responseText);
		
		var cusdecNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("CusdecNo");
		var XMLBPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("BPONo");
		var XMLInvNo	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		
		
		for(var x=0;x<cusdecNo.length;x++)
		{	
			
			var newRow			 	  = tbl_forwaderInvDetails.insertRow(x+1);
		
			
			var newCellSelectPl       = tbl_forwaderInvDetails.rows[x+1].insertCell(0);
			newCellSelectPl.className ="normalfntMid";	
			newCellSelectPl.width	  ="4%";
			newCellSelectPl.align 	  ="center";
			newCellSelectPl.innerHTML = "<input type=\"checkbox\" align=\"center\" />";
			
			
			var newCellCusdecNo        = tbl_forwaderInvDetails.rows[x+1].insertCell(1);
			newCellCusdecNo.className ="normalfntMid";
			newCellCusdecNo.align      ="center";
			newCellCusdecNo.innerHTML  = cusdecNo[x].childNodes[0].nodeValue;
			
			
			var newCellBPONo       = tbl_forwaderInvDetails.rows[x+1].insertCell(2);
			newCellBPONo.className ="normalfntMid";
			newCellBPONo.align     ="center";
			newCellBPONo.innerHTML = XMLBPONo[x].childNodes[0].nodeValue;
			
			var newCellInvNo        = tbl_forwaderInvDetails.rows[x+1].insertCell(3);
			newCellInvNo.className ="normalfntMid";
			newCellInvNo.align      ="center";
			newCellInvNo.innerHTML  = XMLInvNo[x].childNodes[0].nodeValue;
			
		}
	
	}
	
	deleteExists();
	hidePleaseWait();
}

function deleteExists()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	var forwaderId=document.getElementById('cboForwader').value;
	
	var url="ForwaderInvoice-db.php?id=checkExists";
		url+="&forwaderId="+forwaderId;
		   
	var xmlhttp_obj	  = $.ajax({url:url,async:false})
	
	var XMLBPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("BPONo");
	for(var x=0;x<XMLBPONo.length;x++)
	{
		for(var i=1;i<tbl_forwaderInvDetails.rows.length;i++)
		{
			if(tbl_forwaderInvDetails.rows[i].cells[2].innerHTML==XMLBPONo[x].childNodes[0].nodeValue)
				tbl_forwaderInvDetails.deleteRow(i);
		}
	}
}


function validateData()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	
	var forwaderInvNo=document.getElementById('txtForInvNo').value;
	var forwaderId=document.getElementById('cboForwader').value;
	var carrierName=document.getElementById('cboCarrier').value;
	var amount=document.getElementById('txtAmount').value;
	var forInvDate=document.getElementById('txtDate').value;
	var selectCount=0;
	
	if(forwaderId==0 && carrierName=='')
		alert("Please Select a Forwader or a Carrier");
	else if(forwaderInvNo=='')
		alert("Please specify a Forwader Invoice Number");
	else if(amount=='')
		alert("Please Specify Amount");
	else
	{
		if(tbl_forwaderInvDetails.rows.length>1)
			{
				for(var x=1;x<tbl_forwaderInvDetails.rows.length;x++)
				{
					if((tbl_forwaderInvDetails.rows[x].cells[0].childNodes[0].checked)==true)
					{
						selectCount=1;
						break;
					}
				}
			}
		if(selectCount==0)
			alert("Please select a row");
			
		else
			saveData();
	}
}

function saveData()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	
	var forwaderInvNo=document.getElementById('txtForInvNo').value;
	var forwaderId=document.getElementById('cboForwader').value;
	var carrierName=document.getElementById('cboCarrier').value;
	var amount=document.getElementById('txtAmount').value;
	var forInvDate=document.getElementById('txtDate').value;
	
	
	
	var url="ForwaderInvoice-db.php?id=saveHeader";
		url+="&forwaderId="+forwaderId;
		url+="&carrierName="+carrierName;
		url+="&forwaderInvNo="+forwaderInvNo;
		url+="&amount="+amount;
		url+="&forInvDate="+forInvDate;
		   
	var html_httpobj	  = $.ajax({url:url,async:false})
	//alert(html_httpobj.responseText);
	
	if(html_httpobj.responseText==1)
	{
		for(var x=1;x<tbl_forwaderInvDetails.rows.length;x++)
		{
			var cusdecNo           =tbl_forwaderInvDetails.rows[x].cells[1].innerHTML;
			var bpoNo    		   =tbl_forwaderInvDetails.rows[x].cells[2].innerHTML;
			var commercialInvoiceNo=tbl_forwaderInvDetails.rows[x].cells[3].innerHTML;
		
			if((tbl_forwaderInvDetails.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url="ForwaderInvoice-db.php?id=saveDetail";
					url+="&forwaderId="+forwaderId;
					url+="&forwaderInvNo="+forwaderInvNo;
					url+="&cusdecNo="+cusdecNo;
					url+="&bpoNo="+bpoNo;
					url+="&commercialInvoiceNo="+commercialInvoiceNo;
				var html_obj	  = $.ajax({url:url,async:false});
				//alert(html_obj.responseText);
			}
		}

	alert("Saved Successfully!!!");
	clearForm();		
	}
	else
		alert("Saving Failed");
}

function clearForm()
{
	window.location.reload();
}