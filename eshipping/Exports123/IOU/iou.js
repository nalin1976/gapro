var xmlHttp3 				= [];
var pub_validateIOUCount	= 0 ;
function createXMLHttpRequest3(index){
    if (window.ActiveXObject) 
    {
        xmlHttp3[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp3[index] = new XMLHttpRequest();
    }
}

function rowclickColorChangeIou()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblIou');
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

function getIOUheaderdata()
{
		var invoice=document.getElementById('cboInvoice').value;
		if (invoice=="")
		 invoice=document.getElementById('cboInvoiceNo').value;
		createXMLHttpRequest3(12);
		xmlHttp3[12].onreadystatechange=function()
		{
		if(xmlHttp3[12].readyState==4 && xmlHttp3[12].status==200){
			if (document.getElementById('cboInvoice').value!=""){			
			document.getElementById('tdIouNo').innerHTML = xmlHttp3[12].responseXML.getElementsByTagName("IOUNo")[0].childNodes[0].nodeValue;
			document.getElementById('txtIOUNo').value=xmlHttp3[12].responseXML.getElementsByTagName("IOUNo")[0].childNodes[0].nodeValue;			
			}removeOption('cboSearchConsignee');
			removeOption('cboBuyer');
			removeOption('cboInvoiceNo');
			var buyer=xmlHttp3[12].responseXML.getElementsByTagName("buyer")[0].childNodes[0].nodeValue;
			var customer=xmlHttp3[12].responseXML.getElementsByTagName("customer")[0].childNodes[0].nodeValue;
			var InvoiceNo=xmlHttp3[12].responseXML.getElementsByTagName("InvoiceNo")[0].childNodes[0].nodeValue;
				var opt 		= document.createElement("option");
				opt.text 	=customer;
				opt.value 	= customer;
				document.getElementById("cboSearchConsignee").options.add(opt);
				var opt 		= document.createElement("option");
				opt.text 	=InvoiceNo;
				opt.value 	= InvoiceNo;
				document.getElementById('cboInvoiceNo').options.add(opt);
				var opt 		= document.createElement("option");
				opt.text 	=buyer;
				opt.value 	= buyer;
				document.getElementById("cboBuyer").options.add(opt);
			}
		}
		xmlHttp3[12].open("GET",'ioudb.php?RequestType=LoadIOUheader&invoice=' +invoice ,true);
		xmlHttp3[12].send(null);

}



function removeOption(slct)
{
  var elSel = document.getElementById(slct);
  var i;
  for (i = elSel.length - 1; i>=0; i--)
   {
    
      elSel.remove(i);
    
  }
}


function	deleterows(tableName)
	{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	


function RemoveIOUItem(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;				
		tro.parentNode.removeChild(tro);			
		DeleteIOURow(obj);
	}
}

function DeleteIOURow(obj){
	var iouNo 		= document.getElementById('tdIouNo').innerHTML;
	var rw			= obj.parentNode.parentNode;	
	var expenceID 	= rw.cells[1].childNodes[0].nodeValue;		
	
	createXMLHttpRequest1(1);
	xmlHttp1[1].open("GET",'cusdecdb.php?RequestType=DeleteIOURow&iouNo=' +iouNo+ '&expenceID=' +expenceID ,true);
	xmlHttp1[1].send(null);
}

function LoadExpenceType()
{	getIOUheaderdata()
	var invoiceNo	= document.getElementById('cboInvoice').value;
	var invoice=document.getElementById('cboInvoiceNo').value;
	if(invoiceNo=="" && invoice==""){alert("Cannot load IOU without invoiceNo No");return;}
	//document.getElementById('txtDocNo').value = document.getElementById('txtPreviousDoc').value;
	createXMLHttpRequest3(1);
	xmlHttp3[1].onreadystatechange=LoadExpenceTypeRequest;
	xmlHttp3[1].open("GET",'ioudb.php?RequestType=LoadExpenceType&deliveryNo=' +invoiceNo ,true);
	xmlHttp3[1].send(null);
}
	function LoadExpenceTypeRequest()
	{
	var invoiceNo	= document.getElementById('cboInvoice').value;
		if(xmlHttp3[1].readyState==4 && xmlHttp3[1].status==200)
		{		if(invoiceNo!=""){
				//removeOption('cboInvoiceNo');
	 			/*var opt 		= document.createElement("option");
				opt.text 	=document.getElementById('cboInvoice').value;
				opt.value 	= document.getElementById('cboInvoice').value;
				document.getElementById("cboInvoiceNo").options.add(opt);*/}
    
			deleterows('tblIou');
			
			var XMLExpensesID	= xmlHttp3[1].responseXML.getElementsByTagName('ExpensesID');
			var XMLExpenceType	= xmlHttp3[1].responseXML.getElementsByTagName('ExpenceType');
			var XMLEstimate		= xmlHttp3[1].responseXML.getElementsByTagName('Estimate');
			var XMLActual		= xmlHttp3[1].responseXML.getElementsByTagName('Actual');
			var XMLInvoice		= xmlHttp3[1].responseXML.getElementsByTagName('Invoice');
			var tblIou			= document.getElementById('tblIou');
			var no	=1;
			
			for(var loop=0;loop<XMLExpensesID.length;loop++)
			{
				var lastRow 		= tblIou.rows.length;	
				var row 			= tblIou.insertRow(lastRow);
				
				if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow";
				else
					row.className ="bcgcolor-tblrowWhite";			
				
				row.onclick	= rowclickColorChangeIou;
				
				var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveIOUItem(this);\"/>";
				
				var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =no;
				
				var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";	
				rowCell.id=XMLExpensesID[loop].childNodes[0].nodeValue;
				rowCell.innerHTML =XMLExpenceType[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";
				rowCell.innerHTML ="<input name=\"txtFreight\" type=\"text\" class=\"txtbox\" id=\"txtFreight\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"17\" maxlength=\"20\" height=\"10\" onkeyup=\"CulculateVarianse(this)\" style=\"text-align:right\" value=\""+XMLEstimate[loop].childNodes[0].nodeValue+"\"/>";
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";
				rowCell.innerHTML	= "<input name=\"txtFreight\" type=\"text\" class=\"txtbox\" id=\"txtFreight\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"17\" maxlength=\"20\"readonly=\"readonly\" height=\"10\" onkeyup=\"CulculateVarianse(this)\" style=\"text-align:right\" value=\""+XMLActual[loop].childNodes[0].nodeValue+"\"/>";
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =(XMLActual[loop].childNodes[0].nodeValue-XMLEstimate[loop].childNodes[0].nodeValue);
				
				var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";
				rowCell.innerHTML	= "<input name=\"txtFreight\" type=\"text\"readonly=\"readonly\" class=\"txtbox\" id=\"txtFreight\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"17\" maxlength=\"20\" height=\"5\" style=\"text-align:right\" value=\""+XMLInvoice[loop].childNodes[0].nodeValue+"\"/>";
				no++;
				
			}
		}
	}
	
function ValidateIOU()
{
	var tblIOU	= document.getElementById('tblIou');
	var iouNo	= document.getElementById('tdIouNo').innerHTML;
	if(tblIOU.rows.length<=1){alert("Sorry..\nNO details appear to save in the IOU form.");return;}
	if(iouNo=="0")
		GetNewIOUNo();
	else
		SaveIOU(iouNo);
}

function GetNewIOUNo()
{	
	createXMLHttpRequest3(1);	
	xmlHttp3[1].onreadystatechange = GetNewIOUNoRequest;
	xmlHttp3[1].open("GET" ,'ioudb.php?RequestType=GetNewIOUNo' ,true);
	xmlHttp3[1].send(null);	
}
	function GetNewIOUNoRequest()
	{	
    	if(xmlHttp3[1].readyState == 4 && xmlHttp3[1].status == 200) 
        	{  
        		var XMLAdmin	= xmlHttp3[1].responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
        		if(XMLAdmin=="TRUE"){		 
			 	var XMLNo = xmlHttp3[1].responseXML.getElementsByTagName("No");	
			    var iouNo 	= parseInt(XMLNo[0].childNodes[0].nodeValue);				 
				
						document.getElementById('tdIouNo').innerHTML =iouNo;			
						SaveIOU(iouNo);
				}				
				else{
					alert("Please contact system administrator to Assign New Delivery No....");
				}
			}
	}
function saveIOUheader()
{		var update=0;
	if (document.getElementById('cboInvoice').value=="")
		update=1;
		pub_validateIOUCount	= 0;
		var iouNo					= document.getElementById('txtIOUNo').value;
		var invoice =document.getElementById("cboInvoiceNo").value;
		createXMLHttpRequest3(19);
		xmlHttp3[19].open("GET" ,'ioudb.php?RequestType=SaveIOUHeader&iouNo=' +iouNo+ '&invoice=' +invoice+ '&update=' +update ,true);
		xmlHttp3[19].send(null);
		pub_validateIOUCount++;

}

function SaveIOU()
{
	saveIOUheader();
	pub_validateIOUCount	= 0;
	var tblIOU					= document.getElementById('tblIou');
	var iouNo					= document.getElementById('txtIOUNo').value;
	var invoiceno =document.getElementById("cboInvoiceNo").value;
		
	
	for(loop=1;loop<tblIOU.rows.length;loop++)
	{
		
		var expenceID	=  tblIOU.rows[loop].cells[2].id;
		var estimate	=  (tblIOU.rows[loop].cells[3].childNodes[0].value=="" ? 0:tblIOU.rows[loop].cells[3].childNodes[0].value);
		var actual		=  (tblIOU.rows[loop].cells[4].childNodes[0].value=="" ? 0:tblIOU.rows[loop].cells[4].childNodes[0].value);
		var invoice		=  (tblIOU.rows[loop].cells[6].childNodes[0].value=="" ? 0:tblIOU.rows[loop].cells[6].childNodes[0].value);
		
		createXMLHttpRequest3(loop);
		xmlHttp3[loop].onreadystatechange=function(){if(xmlHttp3[1].readyState == 4 && xmlHttp3[1].status == 200) pub_validateIOUCount++;}
		xmlHttp3[loop].open("GET" ,'ioudb.php?RequestType=SaveIOUDetails&iouNo=' +iouNo+ '&expenceID=' +expenceID+ '&estimate=' +estimate+ '&actual=' +actual+ '&invoice=' +invoice ,true);
		xmlHttp3[loop].send(null);
		
	}
	
	//SaveIOUValidate(recType);
}

function SaveIOUValidate(recType)
{		
	var iouNo = document.getElementById('tdIouNo').innerHTML;
	createXMLHttpRequest3(1);
	xmlHttp3[1].index = iouNo;
	xmlHttp3[1].onreadystatechange = SaveIOUValidateRequest;
	xmlHttp3[1].open("GET",'ioudb.php?RequestType=SaveIOUValidate&iouNo=' +iouNo+ '&validateIOUCount=' +pub_validateIOUCount+ '&recType=' +recType ,true);
	xmlHttp3[1].send(null);
}
	function SaveIOUValidateRequest()
	{
		if(xmlHttp3[1].readyState == 4) 
		{
			if(xmlHttp3[1].status == 200)
			{				
				var XMLCountHeader= xmlHttp3[1].responseXML.getElementsByTagName("recCountIouHeader")[0].childNodes[0].nodeValue;
				var XMLCountDetails= xmlHttp3[1].responseXML.getElementsByTagName("recCountIouDetails")[0].childNodes[0].nodeValue;
				
					if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE"))
					{
						alert ("IUO No : "+xmlHttp3[1].index+" saved successfully.");				
						
					}
					else 
					{
						SaveIOUValidate();											
					}			
			}
		}
	}
	
function CulculateVarianse(obj,status)
{				        
	var rw = obj.parentNode.parentNode;
	
		var variance = parseFloat(rw.cells[4].childNodes[0].value)-parseFloat(rw.cells[3].childNodes[0].value);		
		
	rw.cells[5].childNodes[0].nodeValue = isNaN(variance) ? 0:variance;
}

function PrintIOU()
{
	var No = document.getElementById('txtIOUNo').value;
	if(No=="" || No=="0"){	alert("No IOU no appear to view..");return;}
	
	newwindow=window.open('rptIOU.php?iouNo='+No ,'name');
	if (window.focus) {newwindow.focus()}
}