// JavaScript Document
function loadGrid()
{
	showPleaseWait();
	var tbl_fcrDetails=document.getElementById('tbl_fcrDetails');
	for(var i=tbl_fcrDetails.rows.length;i>1;i--)
		tbl_fcrDetails.deleteRow(i-1);
	
	var forwaderId  = document.getElementById('cboForwader').value;
	
	var carrierName = document.getElementById('cboCarrier').value;
	
	if(forwaderId!=0 || carrierName!='')
	{
		var url="fcr-db.php?id=loadGrid";
		   url+="&forwaderId="+forwaderId;
		   url+="&carrierName="+carrierName;
		   
		var xmlhttp_obj	  = $.ajax({url:url,async:false})
		//alert(xmlhttp_obj.responseText);
		var forwader 	  = xmlhttp_obj.responseXML.getElementsByTagName("Forwader");
		var cusdecNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("CusdecNo");
		var XMLBPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("BPONo");
		var XMLInvNo	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		
		
		for(var x=0;x<cusdecNo.length;x++)
		{	
			
			var newRow			 	  = tbl_fcrDetails.insertRow(x+1);
		
			
			var newCellSelectPl       = tbl_fcrDetails.rows[x+1].insertCell(0);
			newCellSelectPl.className = "normalfntMid";	
			newCellSelectPl.width	  = "4%";
			newCellSelectPl.align 	  = "center";
			newCellSelectPl.innerHTML = "<input type=\"checkbox\" align=\"center\" id=\""+forwader[0].childNodes[0].nodeValue+"\"/>";
			
			
			var newCellCusdecNo       = tbl_fcrDetails.rows[x+1].insertCell(1);
			newCellCusdecNo.className = "normalfntMid";
			newCellCusdecNo.align     = "center";
			newCellCusdecNo.innerHTML = cusdecNo[x].childNodes[0].nodeValue;
			
			
			var newCellBPONo          = tbl_fcrDetails.rows[x+1].insertCell(2);
			newCellBPONo.className    = "normalfntMid";
			newCellBPONo.align        = "center";
			newCellBPONo.innerHTML    = XMLBPONo[x].childNodes[0].nodeValue;
			
			var newCellInvNo          = tbl_fcrDetails.rows[x+1].insertCell(3);
			newCellInvNo.className    = "normalfntMid";
			newCellInvNo.align        = "center";
			newCellInvNo.innerHTML    = XMLInvNo[x].childNodes[0].nodeValue;
			
		}
	
	}
	
	//deleteExists();
	hidePleaseWait();
}

function deleteExists()
{
	var tbl_fcrDetails = document.getElementById('tbl_fcrDetails');
	var forwaderId     = document.getElementById('cboForwader').value;
	
	var url ="fcr-db.php?id=checkExists";
		url+="&forwaderId="+forwaderId;
		   
	var xmlhttp_obj	  = $.ajax({url:url,async:false})
	
	var XMLBPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("BPONo");
	for(var x=0;x<XMLBPONo.length;x++)
	{
		for(var i=1;i<tbl_fcrDetails.rows.length;i++)
		{
			if(tbl_fcrDetails.rows[i].cells[2].innerHTML==XMLBPONo[x].childNodes[0].nodeValue)
				tbl_fcrDetails.deleteRow(i);
		}
	}
}


function validateData()
{
	var tbl_fcrDetails=document.getElementById('tbl_fcrDetails');
	
	//alert(tbl_fcrDetails.rows[1].cells[0].childNodes[0].id);
	//var fcrNo       = document.getElementById('txtFcrNo').value;
	var forwaderId  = document.getElementById('cboForwader').value;
	var carrierName = document.getElementById('cboCarrier').value;
	var fcrDate     = document.getElementById('txtDate').value;
	var selectCount = 0;
	
	if(forwaderId==0)
		alert("Please Select a Forwader");
	else
	{
		if(tbl_fcrDetails.rows.length>1)
			{
				for(var x=1;x<tbl_fcrDetails.rows.length;x++)
				{
					if((tbl_fcrDetails.rows[x].cells[0].childNodes[0].checked)==true)
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
	var tbl_fcrDetails = document.getElementById('tbl_fcrDetails');
	
	//var fcrNo          = document.getElementById('txtFcrNo').value;
	var forwaderId     = document.getElementById('cboForwader').value;
	var carrierName    = document.getElementById('cboCarrier').value;
	var fcrDate        = document.getElementById('txtDate').value;
	
	
	
	/*var url ="fcr-db.php?id=saveHeader";
		url+="&forwaderId="+forwaderId;
		url+="&carrierName="+carrierName;
		url+="&fcrNo="+fcrNo;
		url+="&fcrDate="+fcrDate;
		   
	var html_httpobj	  = $.ajax({url:url,async:false})
	//alert(html_httpobj.responseText);
	
	if(html_httpobj.responseText==1)
	{*/
		for(var x=1;x<tbl_fcrDetails.rows.length;x++)
		{
			var cusdecNo            = tbl_fcrDetails.rows[x].cells[1].innerHTML;
			var bpoNo    		    = tbl_fcrDetails.rows[x].cells[2].innerHTML;
			var commercialInvoiceNo = tbl_fcrDetails.rows[x].cells[3].innerHTML;
		
			if((tbl_fcrDetails.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url ="fcr-db.php?id=saveDetail";
					/*url+="&forwaderId="+forwaderId;
					url+="&cusdecNo="+cusdecNo;
					url+="&bpoNo="+bpoNo;*/
					url+="&commercialInvoiceNo="+commercialInvoiceNo;
					url+="&fcrDate="+fcrDate;
				var html_obj	  = $.ajax({url:url,async:false});
				//alert(html_obj.responseText);
			}
		}

	alert("Saved Successfully!!!");
	clearForm();		
	//}
	/*else
		alert("Saving Failed");*/
}

function clearForm()
{
	window.location.reload();
}