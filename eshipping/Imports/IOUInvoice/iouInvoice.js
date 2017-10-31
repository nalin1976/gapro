var xmlHttp =[];
var totShortage=0;
var totActual=0;
var totEstimate=0;
var actual=0;
var shortage=0;
var btn="";
var cnt=0;
var customerid;
var totinvoice=0
 
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

function setbydelivery(cbo)
{	
		
		document.getElementById("cboDelivery").disabled=true;
		document.getElementById("cboiouno").disabled=true;
		document.getElementById("cboiouno").value=cbo.value;
		document.getElementById("cboDelivery").value=cbo.value ;	
	//	alert(document.getElementById("cbocreateReporDelivery").value);
	if (document.getElementById("cboiouno").value!="")
	{
	var deliveryno=cbo.value
		
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'iouInvoicedb.php?REQUEST=getData&deliveryno=' + deliveryno,true);
	xmlHttp[0].send(null);
	}
	
	else
	{clearForm();}
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=getIOUdetail;
	xmlHttp[1].open("GET",'iouInvoicedb.php?REQUEST=ioudetail&deliveryno=' + deliveryno,true);
	xmlHttp[1].send(null);			
	
	
}

function stateChanged() 
{ 
	if(xmlHttp[0].readyState == 4) 
    {
        if(xmlHttp[0].status == 200) 
        {  
     //  alert(xmlHttp[0].responseText);
        		var blno = xmlHttp[0].responseXML.getElementsByTagName("blno")[0].childNodes[0].nodeValue;
        		document.getElementById("txtBL").value = blno;
   			var consignee = xmlHttp[0].responseXML.getElementsByTagName("Consignee")[0].childNodes[0].nodeValue;
        		document.getElementById("txtConsignee").value = consignee;
 	      	var Frowader = xmlHttp[0].responseXML.getElementsByTagName("Frowader")[0].childNodes[0].nodeValue;
        		document.getElementById("txtForwader").value = Frowader;
        		var Clerk = xmlHttp[0].responseXML.getElementsByTagName("Clerk")[0].childNodes[0].nodeValue;
        		document.getElementById("txtClerk").value = Clerk	;
				var Exportar = xmlHttp[0].responseXML.getElementsByTagName("Exportar")[0].childNodes[0].nodeValue;
        		document.getElementById("txtExporter").value = Exportar;        			
				var Vessel = xmlHttp[0].responseXML.getElementsByTagName("Vessel")[0].childNodes[0].nodeValue;
        		document.getElementById("txtVessel").value = Vessel	;
        		var noOfPkg = xmlHttp[0].responseXML.getElementsByTagName("noOfPkg")[0].childNodes[0].nodeValue;
        		document.getElementById("txtPKGS").value = noOfPkg	;
        		var Merchandiser = xmlHttp[0].responseXML.getElementsByTagName("Merchandiser")[0].childNodes[0].nodeValue;
        		document.getElementById("txtMerchandiser").value = Merchandiser	;
        		var reason = xmlHttp[0].responseXML.getElementsByTagName("reason")[0].childNodes[0].nodeValue;
        		document.getElementById("txtReason").value = reason;
     			customerid = xmlHttp[0].responseXML.getElementsByTagName("CustomerID")[0].childNodes[0].nodeValue;
        
        }
    }
}

function rowclickColorChangeIou()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tbliou');
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


function checkpass(tt)
{
if(tt.checked==true){
//alert(tt.parentNode.parentNode.cells[2].childNodes[0].nodeValue);
//tt.parentNode.parentNode.childNodes[0].childNodes[0].checked=false;

}
}


function getIOUdetail()
{

if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
		{
		
				
		if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
		{
			
			//alert(xmlHttp[1].responseText);
			var XMLExpensesID	= xmlHttp[1].responseXML.getElementsByTagName('ExpensesID');
			var XMLExpenceType	= xmlHttp[1].responseXML.getElementsByTagName('ExpenceType');
			var XMLEstimate		= xmlHttp[1].responseXML.getElementsByTagName('Estimate');
			var XMLActual		= xmlHttp[1].responseXML.getElementsByTagName('Actual');
			var XMLInvoice		= xmlHttp[1].responseXML.getElementsByTagName('Invoice');
			var tblIou			= document.getElementById('tbliou');
			var no	=1;
			
			deleterows('tbliou');			
			
			for(var loop=0;loop<XMLExpensesID.length;loop++)
			{
				var lastRow 		= tblIou.rows.length;	
				var row 			= tblIou.insertRow(lastRow);
				
				if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow";
				else
					row.className ="bcgcolor-tblrowWhite";			
				
				row.onclick	= rowclickColorChangeIou;
				
				var rowCell = row.insertCell(0);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"checkbox\"name=\"status\"checked=\"true;\"onchange=\"checkpass(this);\"/>";				
				
				var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =no;
				
				var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";	
				rowCell.id=XMLExpensesID[loop].childNodes[0].nodeValue;
				rowCell.innerHTML =XMLExpenceType[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";	
				//alert(XMLEstimate[loop].childNodes[0].vlaue);		
				//rowCell.innerHTML =XMLEstimate[loop].childNodes[0].nodeValue;
				rowCell.innerHTML ="<input name=\"txtEstimate\"type=\"text\"class=\"txtbox\"readonly=\"readonly\"id=\"txtEstimate\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"12\" maxlength=\"20\" height=\"10\" style=\"text-align:right\" value=\"" +XMLEstimate[loop].childNodes[0].nodeValue+ "\"/>";
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				//rowCell.innerHTML =XMLActual[loop].childNodes[0].nodeValue;
				rowCell.innerHTML	= "<input name=\"txtActual\" type=\"text\" readonly=\"readonly\" class=\"txtbox\" id=\"txtActual\" onkeyup=\" calshortage(this);\" size=\"12\" maxlength=\"20\" height=\"10\" style=\"text-align:right\" value=\""+XMLActual[loop].childNodes[0].nodeValue+"\"/>";
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntRite";
				//var shortage=row.Cell[3].childNodes[0].nodeValue;;
				//shortage.onkeyup=calshortage(shortage);	
				//rowCell.innerHTML="<input name=\"txtShort\" class=\"txtbox\" id=\"txtShort\" onkeyup=\" calshortage(this);\" size=\"12\" maxlength=\"20\" height=\"10\" style=\"text-align:right\" value=\""+XMLEstimate[loop].childNodes[0].nodeValue-XMLActual[loop].childNodes[0].nodeValue+"\"/>";
				rowCell.innerHTML =parseFloat(XMLEstimate[loop].childNodes[0].nodeValue-XMLActual[loop].childNodes[0].nodeValue);
				//rowCell.innerHTML="</style>"					
				
				var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				//rowCell.innerHTML =XMLInvoice[loop].childNodes[0].nodeValue;
				rowCell.innerHTML	= "<input name=\"txtFreight\" type=\"text\" class=\"txtbox\" id=\"txtFreight\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"12\" maxlength=\"20\" height=\"5\" style=\"text-align:right\" value=\""+XMLInvoice[loop].childNodes[0].nodeValue+"\"/>";
				no++;
				}

			}
		}

}

function calshortage(str)
{
	var rw = str.parentNode.parentNode;
	if (str.value=="")
	var tot=parseFloat(rw.cells[3].childNodes[0].value-0 );
	else
	var tot=parseFloat(rw.cells[3].childNodes[0].value-parseFloat(str.value) );
	rw.cells[5].childNodes[0].nodeValue= tot;
}





function updateiou(bttn)
{	btn=bttn;
	//var iouno=document.getElementById('cboiou').value;
	var tblioudtl=document.getElementById("tbliou");
	var length=tblioudtl.rows.length;
	
	cnt=1;
	totShortage=0;
	totActual=0;
	totEstimate=0;	
	
	if(length>1)
	{
	drawPopupArea(201,55,'rptconfirm');	
	document.getElementById("rptconfirm").innerHTML =document.getElementById('confirmReport').innerHTML;
	for(var j=1; j<length; j++)
		{
		var iouno=document.getElementById("cboiouno").value;
		var id=tblioudtl.rows[j].cells[1].childNodes[0].nodeValue;
		var invoice= tblioudtl.rows[j].cells[6].childNodes[0].value;
		totinvoice+=parseFloat(invoice);
		//totShortage+=parseFloat(estimate-actual);		
		//alert(iouno+" "+ id+" "+invoice); 
		if (tblioudtl.rows[j].cells[0].childNodes[0].checked==false)
		{
			var checked=0;			
		}
		else
			var checked=1;
		
		createNewXMLHttpRequest(2);
		xmlHttp[2].onreadystatechange=function()
			{
			if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)
			{
				if(xmlHttp[2].responseText=='updated')
					{	
						
							
					}			
			}
		
			}
						cnt++;
						if(cnt==length)
						{
							//alert(customerid);
						//totShortage=totEstimate-totActual;
						 generateInvoice();
						}
			
		xmlHttp[2].open("GET",'iouInvoicedb.php?REQUEST=updateiou&iouno=' + iouno + '&id=' + id +  '&invoice=' +invoice+  '&checked=' +checked,true);
		xmlHttp[2].send(null);			
		}

		
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


function printthis()
{	if(document.getElementById("cboiouno").value!="")
{
		
		window.open("../../Reports/rptInvoice.php?iouNo=" + document.getElementById("cboiouno").value);
/*
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=getIOUdetail;
	xmlHttp[2].open("GET",'ioudb.php?REQUEST=ioudetail&deliveryno=' + deliveryno,true);
	xmlHttp[2].send(null);		
	alert("priented sucessfully");
	*/
	
}
}




function frmReload()
{
setTimeout("location.reload(true);",100);	

}

function clearForm()
{
	document.getElementById("txtConsignee").value ="";
	document.getElementById("txtForwader").value ="";
	document.getElementById("txtClerk").value ="";
	document.getElementById("txtExporter").value ="";
	document.getElementById("txtVessel").value = "";
	document.getElementById("txtPKGS").value ="";
	document.getElementById("txtMerchandiser").value ="";
	document.getElementById("txtReason").value ="";
	deleterows('tbliou'); 
}


function generateInvoice()
{
		var invoiceno=document.getElementById("txtinvoiceNO").value;
		var iouno=document.getElementById("cboiouno").value;
		var invoicedate=document.getElementById("txtCurrentDate").value;
		var se=1000;
		
		//alert(totinvoice);
		//alert(invoicedate);
		createNewXMLHttpRequest(4);
		xmlHttp[4].onreadystatechange=function()
			{
			if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
				{
								
						alert(xmlHttp[4].responseText);
						closeWindow();	
							
				}
		
			}
						
			
		xmlHttp[4].open("GET",'iouInvoicedb.php?REQUEST=iouinvoice&iouno=' + iouno + '&customerid='+customerid+ '&totInvoice=' + totinvoice + '&invdate='+invoicedate+ '&invoiceno=' +invoiceno,true);
		xmlHttp[4].send(null);			
		


}