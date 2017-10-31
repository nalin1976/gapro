function writeTo_tblDispatchNote()
{	
	if(document.getElementById('cbo_dispatch').value=='')
	{
	var buyerId		  = document.getElementById('cbo_buyerName').value;
	var tblDispatchNote    = document.getElementById("tblDispatchNote");
			
	if(tblDispatchNote.rows.length>1)
	{	
		for(var x=tblDispatchNote.rows.length;x>1;x--)
		{							
			tblDispatchNote.deleteRow(x-1);
		}
	}
	
	if(buyerId=='')
	{
		
	}
	else
	{
	var url 	      ="DispathNote-db.php?id=loadGrid&buyerId1="+buyerId;
	var xmlhttp_obj	  = $.ajax({url:url,async:false})
	
	
	var XMLPLNo  	  = xmlhttp_obj.responseXML.getElementsByTagName("PLNo");
	var XMLStyle 	  = xmlhttp_obj.responseXML.getElementsByTagName("Style");
	var XMLPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("PONo");
	var XMLUnit 	  = xmlhttp_obj.responseXML.getElementsByTagName("Unit");
	var XMLOrderQty   = xmlhttp_obj.responseXML.getElementsByTagName("OrderQty");
	var XMLPLQty 	  = xmlhttp_obj.responseXML.getElementsByTagName("PLQty");
	
	 var innerString="<tr colspan=\"9\">";
			  innerString+="<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">&nbsp;</td>";
              innerString+="<td width=\"14%\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">P/L No</td>";
              innerString+="<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No</td>";
			  innerString+="<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>";
              innerString+="<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>";
              innerString+="<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Order Qty</td>";
			  innerString+="<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">P/L Qty</td>";
              innerString+="<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance Qty</td>";
              innerString+="<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gate Pass Qty</td>";
			  innerString+="<td width=\"3%\" bgcolor=\"#498CC2\" height=\"25\" class=\"normaltxtmidb2\">Order Complete</td>"	
			innerString+="</tr>";
		
			tblDispatchNote.innerHTML=innerString;
			for(var x=0;x<XMLPLNo.length;x++)
			{	
					var newRow			 	  = tblDispatchNote.insertRow(x+1);
					
					newRow.className ="bcgcolor-tblrow";
				
					
					var newCellSelectPl       = tblDispatchNote.rows[x+1].insertCell(0);
					newCellSelectPl.className ="normalfntMid";	
					newCellSelectPl.width	  ="4%";
					newCellSelectPl.align 	  ="center";
					newCellSelectPl.innerHTML = "<input type=\"checkbox\" align=\"center\" />";
					
					
					var newCellPLNo        = tblDispatchNote.rows[x+1].insertCell(1);
					newCellPLNo.className ="normalfntMid";
					newCellPLNo.width      ="14%";
					newCellPLNo.align      ="center";
					newCellPLNo.innerHTML  = XMLPLNo[x].childNodes[0].nodeValue;
					
					
					var newCellStyle       = tblDispatchNote.rows[x+1].insertCell(2);
					newCellStyle.className ="normalfntMid";
					newCellStyle.width     ="15%";
					newCellStyle.align     ="center";
					newCellStyle.innerHTML = XMLStyle[x].childNodes[0].nodeValue;
					
					var newCellPONo        = tblDispatchNote.rows[x+1].insertCell(3);
					newCellPONo.className ="normalfntMid";
					newCellPONo.width      ="15%";
					newCellPONo.align      ="center";
					newCellPONo.innerHTML  = XMLPONo[x].childNodes[0].nodeValue;
					
					var newCellUnit        = tblDispatchNote.rows[x+1].insertCell(4);
					newCellUnit.className ="normalfntMid";
					newCellUnit.width      ="12%";
					newCellUnit.align      ="center";
					newCellUnit.innerHTML  = XMLUnit[x].childNodes[0].nodeValue;
					
					var newCellOrderQty    = tblDispatchNote.rows[x+1].insertCell(5);
					newCellOrderQty.className ="normalfntMid";
					newCellOrderQty.width  ="11%";
					newCellOrderQty.align  ="center";
					newCellOrderQty.innerHTML  = XMLOrderQty[x].childNodes[0].nodeValue;
					
					var newCellPLQty       = tblDispatchNote.rows[x+1].insertCell(6);
					newCellPLQty.className ="normalfntMid";
					newCellPLQty.width     ="11%";
					newCellPLQty.align     ="center";
					newCellPLQty.innerHTML = XMLPLQty[x].childNodes[0].nodeValue;
					
					var newCellBalanceQty     = tblDispatchNote.rows[x+1].insertCell(7);
					newCellBalanceQty.className ="normalfntMid";
					newCellBalanceQty.width   ="10%";
					newCellBalanceQty.align   ="center";
					newCellBalanceQty.innerHTML  =  XMLOrderQty[x].childNodes[0].nodeValue- XMLPLQty[x].childNodes[0].nodeValue ;
					
					var newCellGatePassQty     = tblDispatchNote.rows[x+1].insertCell(8);
					newCellGatePassQty.className ="normalfntMid";
					newCellGatePassQty.width   ="12%";
					newCellGatePassQty.align   ="center";
					newCellGatePassQty.innerHTML = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center\" value=\""+ XMLPLQty[x].childNodes[0].nodeValue+"\" maxlength=\"8\" />";
					
					
					var newCellOrderComplete    = tblDispatchNote.rows[x+1].insertCell(9);
					newCellOrderComplete.className ="normalfntMid";
					newCellOrderComplete.width  ="4%";
					newCellOrderComplete.align  ="center";
					if(parseFloat(XMLOrderQty[x].childNodes[0].nodeValue) == parseFloat(XMLPLQty[x].childNodes[0].nodeValue))
						newCellOrderComplete.innerHTML = "<input type=\"checkbox\" align=\"center\" checked=\"checked\" />";
					else
						newCellOrderComplete.innerHTML = "<input type=\"checkbox\" align=\"center\" />";

			}
	}
	
	}


}


function validateData()
{
	var savedDispatchNo=document.getElementById('cbo_dispatch').value;
	//alert(savedDispatchNo);
	if(document.getElementById('cbo_buyerName').value=='')
		alert("Please select a Buyer");
	else if(document.getElementById('cboForwader').value=='')
			alert("Please select a Forwader");
	else if(savedDispatchNo=='')
	{
		var selectCount=0;
		var tblDispatchNote=document.getElementById('tblDispatchNote');
			if(tblDispatchNote.rows.length>1)
			{
				for(var x=1;x<tblDispatchNote.rows.length;x++)
				{
					if((tblDispatchNote.rows[x].cells[0].childNodes[0].checked)==true)
					{
						selectCount=1;
						break;
					}
				}
			}
		if(selectCount==0)
			alert("Please select a P/L No");
			
		else
			saveData();
	}
	else
		updateDispatchData();
}

function saveData()
{
	var tblDispatchNote=document.getElementById('tblDispatchNote');
	//var savedDispatchNo=document.getElementById('cbo_dispatch').value;
	//alert(savedDispatchNo);
	var buyerId=document.getElementById('cbo_buyerName').value;
	var dateDispatch=document.getElementById('txtDate').value;
	var remarks=document.getElementById('txtRemarks').value;
	var forwaderId=document.getElementById('cboForwader').value;
	
	var url="DispathNote-db.php?id=saveDispatchHeader";
		url+="&buyerId="+buyerId;
		url+="&dateDispatch="+dateDispatch;
		url+="&remarks="+remarks;
		url+="&forwaderId="+forwaderId;
	
	var html_obj	  = $.ajax({url:url,async:false})	
	var dispatchNo	  = html_obj.responseText;
	//alert(dispatchNo);
	if(dispatchNo!=0)
	{
		for(var x=1;x<tblDispatchNote.rows.length;x++)
		{
			var plNo=tblDispatchNote.rows[x].cells[1].innerHTML;
			var styleNo=tblDispatchNote.rows[x].cells[2].innerHTML;
			var orderNo=tblDispatchNote.rows[x].cells[3].innerHTML;
			var dispatchQty=tblDispatchNote.rows[x].cells[8].childNodes[0].value;
		
			if((tblDispatchNote.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url="DispathNote-db.php?id=saveDispatchDetail";
					url+="&dispatchNo="+dispatchNo;
					url+="&plNo="+plNo;
					url+="&styleNo="+styleNo;
					url+="&orderNo="+orderNo;
					url+="&dispatchQty="+dispatchQty;
				var html_obj	  = $.ajax({url:url,async:false});
				//alert(html_obj.responseText);
			}
		}

	alert("Saved Successfully!!!");
	window.location.reload();
	}
	else
		alert("Saving Failed!!!");
	
}

function updateDispatchData()
{
	var tblDispatchNote=document.getElementById('tblDispatchNote');
	var savedDispatchNo=document.getElementById('cbo_dispatch').value;
	//alert(savedDispatchNo);
	var buyerId=document.getElementById('cbo_buyerName').value;
	var dateDispatch=document.getElementById('txtDate').value;
	var remarks=document.getElementById('txtRemarks').value;
	var forwaderId=document.getElementById('cboForwader').value;
	var tblDispatchNote=document.getElementById('tblDispatchNote');
	
	var url="DispathNote-db.php?id=updateDispatchHeader";
		url+="&dispatchNo="+savedDispatchNo;
		url+="&buyerId="+buyerId;
		url+="&dateDispatch="+dateDispatch;
		url+="&remarks="+remarks;
		url+="&forwaderId="+forwaderId;
	
	var html_obj	  = $.ajax({url:url,async:false})	
	//alert(html_obj.responseText);
	if(html_obj.responseText==1)
	{
	for(var x=1;x<tblDispatchNote.rows.length;x++)
		{
			var plNo=tblDispatchNote.rows[x].cells[0].innerHTML;
			var styleNo=tblDispatchNote.rows[x].cells[1].innerHTML;
			var orderNo=tblDispatchNote.rows[x].cells[2].innerHTML;
			var dispatchQty=tblDispatchNote.rows[x].cells[6].childNodes[0].value;
		
		var url1="DispathNote-db.php?id=updateDispatchDetail";
				url1+="&dispatchNo="+savedDispatchNo;
				url1+="&plNo="+plNo;
				url1+="&styleNo="+styleNo;
				url1+="&orderNo="+orderNo;
				url1+="&dispatchQty="+dispatchQty;
			var html_obj1= $.ajax({url:url1,async:false});
				//alert(html_obj.responseText);
		}
	
	alert("Successfully Updated");
	}
	else
		alert("Saving Failed");
}

function clearForm()
{
	window.open("DispathNote.php");
	//window.location.reload();
}

function checkChkbox()
{
	var tblDispatchNote=document.getElementById('tblDispatchNote');
	
	for(var x=1;x<tblDispatchNote.rows.length;x++)
	{
		alert(tblDispatchNote.rows[x].cells[0].childNodes[0].checked);
	}
			
}  //document.getElementById('').value;

function setSearchValues(dispatchNo)
{
	if(dispatchNo>=0)
	{	
		document.getElementById('cbo_dispatch').value=dispatchNo;
		//document.getElementById('cbo_dispatch').disabled=false;
		
		var url="DispathNote-db.php?id=loadDispatchDetails&dispatchNo="+dispatchNo;
		var xmlhttp_obj	  = $.ajax({url:url,async:false})
	
	
		var XMLBuyerCode  	  = xmlhttp_obj.responseXML.getElementsByTagName("BuyerCode");
		var XMLRemarks 	  	  = xmlhttp_obj.responseXML.getElementsByTagName("Remarks");
		var XMLDispatchDate   = xmlhttp_obj.responseXML.getElementsByTagName("DispatchDate");
		var XMLStyle 	      = xmlhttp_obj.responseXML.getElementsByTagName("Style");
		var XMLOrderNo        = xmlhttp_obj.responseXML.getElementsByTagName("OrderNo");
		var XMLDispatchQty 	  = xmlhttp_obj.responseXML.getElementsByTagName("DispatchQty");
		var XMLPLNo 	      = xmlhttp_obj.responseXML.getElementsByTagName("PLNo");
		var XMLUnit 	      = xmlhttp_obj.responseXML.getElementsByTagName("Unit");
		var XMLOrderQty 	  = xmlhttp_obj.responseXML.getElementsByTagName("OrderQty");
		var XMLSumPLQty 	  = xmlhttp_obj.responseXML.getElementsByTagName("PLQty");
		var XMLForwarderId		  = xmlhttp_obj.responseXML.getElementsByTagName("ForwarderId");
		
		var tblDispatchNote=document.getElementById('tblDispatchNote');
		
		document.getElementById('cbo_buyerName').value=XMLBuyerCode[0].childNodes[0].nodeValue;
		document.getElementById('txtRemarks').value=XMLRemarks[0].childNodes[0].nodeValue;
		document.getElementById('txtDate').value=XMLDispatchDate[0].childNodes[0].nodeValue;
		document.getElementById('cboForwader').value=XMLForwarderId[0].childNodes[0].nodeValue;
		
		 var innerString="<tr>";
			
             innerString+="<td width=\"14%\" height=\"30\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">P/L No</td>";
             innerString+="<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No</td>";
			 innerString+="<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>";
             innerString+="<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>";
             innerString+="<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Order Qty</td>";
			 innerString+="<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">P/L Qty</td>";
             innerString+="<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gate Pass Qty</td>";
             innerString+="<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance Qty</td>";
				
			innerString+="</tr>";
			
			tblDispatchNote.innerHTML=innerString;
		
			for(var x=0;x<XMLPLNo.length;x++)
			{	
					var newRow			 	  = tblDispatchNote.insertRow(x+1);
					newRow.className 		  ="bcgcolor-tblrow";
					
					var newCellSelectPl       = tblDispatchNote.rows[x+1].insertCell(0);
					newCellSelectPl.className ="normalfntMid";
					newCellSelectPl.width	  ="14%";
					newCellSelectPl.align 	  ="center";
					newCellSelectPl.innerHTML =XMLPLNo[x].childNodes[0].nodeValue;
					
					
					var newCellPLNo        = tblDispatchNote.rows[x+1].insertCell(1);
					newCellPLNo.className ="normalfntMid";
					newCellPLNo.width      ="15%";
					newCellPLNo.align      ="center";
					newCellPLNo.innerHTML  =XMLStyle[x].childNodes[0].nodeValue;
					
					
					var newCellStyle       = tblDispatchNote.rows[x+1].insertCell(2);
					newCellStyle.className ="normalfntMid";
					newCellStyle.width     ="15%";
					newCellStyle.align     ="center";
					newCellStyle.innerHTML =  XMLOrderNo[x].childNodes[0].nodeValue;
					
					
					var newCellUnit       = tblDispatchNote.rows[x+1].insertCell(3);
					newCellUnit.className ="normalfntMid";
					newCellUnit.width     ="12%";
					newCellUnit.align     ="center";
					newCellUnit.innerHTML = XMLUnit[x].childNodes[0].nodeValue;
					
					var newCellOrderQty       = tblDispatchNote.rows[x+1].insertCell(4);
					newCellOrderQty.className ="normalfntMid";
					newCellOrderQty.width     ="12%";
					newCellOrderQty.align     ="center";
					newCellOrderQty.innerHTML = XMLOrderQty[x].childNodes[0].nodeValue;
					
					var newCellPLQty       = tblDispatchNote.rows[x+1].insertCell(5);
					newCellPLQty.className ="normalfntMid";
					newCellPLQty.width     ="12%";
					newCellPLQty.align     ="center";
					newCellPLQty.innerHTML = XMLSumPLQty[x].childNodes[0].nodeValue;
					
					var newCellGatePassQty       = tblDispatchNote.rows[x+1].insertCell(6);
					newCellGatePassQty.className ="normalfntMid";
					newCellGatePassQty.width     ="12%";
					newCellGatePassQty.align     ="center";
					newCellGatePassQty.innerHTML = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" id=\""+x+"\" style=\"text-align:center\" value=\""+XMLDispatchQty[x].childNodes[0].nodeValue+"\" maxlength=\"8\" onkeyup=\"writeNewBalQty(this);\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"/>";
					
					var newCellBalanceQty       = tblDispatchNote.rows[x+1].insertCell(7);
					newCellBalanceQty.className ="normalfntMid";
					newCellBalanceQty.width     ="12%";
					newCellBalanceQty.align     ="center";
					newCellBalanceQty.innerHTML = XMLSumPLQty[x].childNodes[0].nodeValue-XMLDispatchQty[x].childNodes[0].nodeValue;
			}
		
	}
}

function showReport()
{
	 var dispatchNo=document.getElementById('cbo_dispatch').value;
	if(document.getElementById('cbo_dispatch').value!='')
		window.open("DispathNoteReport.php?dispatchNo="+dispatchNo);
	else
		alert("Please Select Dispatch No");	
}

function enableCbo_Dispatch()
{
	document.getElementById('cbo_dispatch').disabled=false;
}

function writeNewBalQty(obj)
{
	var rowIndex=Number(obj.id)+1;
	var tblDispatchNote=document.getElementById('tblDispatchNote');
	tblDispatchNote.rows[rowIndex].cells[7].childNodes[0].nodeValue=tblDispatchNote.rows[rowIndex].cells[5].childNodes[0].nodeValue-obj.value;
	
	//alert(tblDispatchNote.rows[rowIndex].cells[5].childNodes[0].nodeValue-obj.value);
}

function deleteRows(dispatchNo)
{
	var tblDispatchNote=document.getElementById('tblDispatchNote');
	document.getElementById('txtRemarks').value='';
	document.getElementById('cboForwader').value='';
	document.getElementById('cbo_buyerName').value='';
	//document.getElementById('').value='';
	
	if(tblDispatchNote.rows.length>1)
	{
		for(var x=tblDispatchNote.rows.length;x>1;x--)
			tblDispatchNote.deleteRow(x-1)
	}
	if(dispatchNo=='')
	{
			 var innerString="<tr colspan=\"9\">";
			  innerString+="<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">&nbsp;</td>";
              innerString+="<td width=\"14%\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">P/L No</td>";
              innerString+="<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No</td>";
			  innerString+="<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>";
              innerString+="<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>";
              innerString+="<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Order Qty</td>";
			  innerString+="<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">P/L Qty</td>";
              innerString+="<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance Qty</td>";
              innerString+="<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gate Pass Qty</td>";
			  innerString+="<td width=\"3%\" bgcolor=\"#498CC2\" height=\"25\" class=\"normaltxtmidb2\">Order Complete</td>"	
			innerString+="</tr>";
		
			tblDispatchNote.innerHTML=innerString;
	}
	else
		setSearchValues(dispatchNo);
}