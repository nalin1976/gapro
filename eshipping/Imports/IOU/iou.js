var xmlHttp =[];
var totShortage=0;
var totActual=0;
var totEstimate=0;
var actual=0;
var shortage=0;
var btn="";
var cnt=0;
 
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
		
	
		
		document.getElementById("cboiouno").value=cbo.value;
		document.getElementById("cboDelivery").value=cbo.value ;	
		document.getElementById("cboiouno").disabled=true;
		document.getElementById("cboDelivery").disabled=true;
	//	alert(document.getElementById("cboDelivery").value);
	if (document.getElementById("cboiouno").value!="")
	{
	var deliveryno=cbo.value
		
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'ioudb.php?REQUEST=getData&deliveryno=' + deliveryno,true);
	xmlHttp[0].send(null);
	}
	
	else
	{clearForm();}
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=getIOUdetail;
	xmlHttp[1].open("GET",'ioudb.php?REQUEST=ioudetail&deliveryno=' + deliveryno,true);
	xmlHttp[1].send(null);			
	
	
}

function stateChanged() 
{ 
	if(xmlHttp[0].readyState == 4) 
    {
        if(xmlHttp[0].status == 200) 
        {  
       // alert(xmlHttp[0].responseText);
        		
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
        		var lcno = xmlHttp[0].responseXML.getElementsByTagName("lcno")[0].childNodes[0].nodeValue;
        		document.getElementById("txtLC").value = lcno;
        		var reason = xmlHttp[0].responseXML.getElementsByTagName("reason")[0].childNodes[0].nodeValue;
        		document.getElementById("txtReason").value = reason;
       
      	 
        
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
				rowCell.innerHTML =no;
				
				var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";	
				rowCell.id=XMLExpensesID[loop].childNodes[0].nodeValue;
				rowCell.innerHTML =XMLExpenceType[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(2);
				rowCell.className ="normalfntMid";	
				//alert(XMLEstimate[loop].childNodes[0].vlaue);		
				//rowCell.innerHTML =XMLEstimate[loop].childNodes[0].nodeValue;
				rowCell.innerHTML ="<input name=\"txtEstimate\"type=\"text\"class=\"txtbox\"readonly=\"readonly\"id=\"txtEstimate\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" size=\"12\" maxlength=\"20\" height=\"10\" style=\"text-align:right\" value=\"" +XMLEstimate[loop].childNodes[0].nodeValue+ "\"/>";
				
				var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				//rowCell.innerHTML =XMLActual[loop].childNodes[0].nodeValue;
				rowCell.innerHTML	= "<input name=\"txtActual\" type=\"text\" class=\"txtbox\" id=\"txtActual\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\" calshortage(this);return CheckforValidDecimal(this.value, 4,event);\" size=\"12\" maxlength=\"20\" height=\"10\" style=\"text-align:right\" value=\""+XMLActual[loop].childNodes[0].nodeValue+"\"/>";
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntRite";
				//var shortage=row.Cell[3].childNodes[0].nodeValue;;
				//shortage.onkeyup=calshortage(shortage);	
				//rowCell.innerHTML="<input name=\"txtShort\" class=\"txtbox\" id=\"txtShort\" onkeyup=\" calshortage(this);\" size=\"12\" maxlength=\"20\" height=\"10\" style=\"text-align:right\" value=\""+XMLEstimate[loop].childNodes[0].nodeValue-XMLActual[loop].childNodes[0].nodeValue+"\"/>";
				rowCell.innerHTML =parseFloat(XMLActual[loop].childNodes[0].nodeValue)-parseFloat(XMLEstimate[loop].childNodes[0].nodeValue);
				//rowCell.innerHTML="</style>"					
				
				var rowCell = row.insertCell(5);
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
	var tot=parseFloat(rw.cells[2].childNodes[0].value-0 );
	else
	var tot=parseFloat(str.value)-parseFloat(rw.cells[2].childNodes[0].value);
	rw.cells[4].childNodes[0].nodeValue= tot;
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
	for(var j=1; j<length; j++)
		{
		var iouno=document.getElementById("cboiouno").value;
		var id=tblioudtl.rows[j].cells[0].childNodes[0].nodeValue;
		var invoice= tblioudtl.rows[j].cells[5].childNodes[0].value;
		var actual= tblioudtl.rows[j].cells[3].childNodes[0].value;
		var estimate=tblioudtl.rows[j].cells[2].childNodes[0].value;
		totActual+=	parseFloat(actual);
		totEstimate+=parseFloat(estimate);
		//totShortage+=parseFloat(estimate-actual);		
		//alert(iouno+" "+ id+" "+actual+ " "+shortage+ " "+invoice); 
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
						totShortage=totEstimate-totActual;
						if (btn=='settle')
							popSelect();
						else							
							alert("Successfully saved.");												
						}
		//alert (cnt+ ' ' +length);
		/*
		if(cnt==length-1)
		{
			alert("successfully updated.");
		}	
		*/
		xmlHttp[2].open("GET",'ioudb.php?REQUEST=updateiou&iouno=' + iouno + '&id=' + id + '&actual=' + actual + '&invoice=' +invoice,true);
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
		
		window.open("../../Reports/rptIOU.php?iouNo=" + document.getElementById("cboiouno").value);
/*
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=getIOUdetail;
	xmlHttp[2].open("GET",'ioudb.php?REQUEST=ioudetail&deliveryno=' + deliveryno,true);
	xmlHttp[2].send(null);		
	alert("priented sucessfully");
	*/
	
}
}

function popSelect()
{
	var balanceto="";
	drawPopupArea(528,112,'rptconfirm');	
	document.getElementById("rptconfirm").innerHTML =document.getElementById('confirmReport').innerHTML;
	document.getElementById('confirmReport').innerHTML = "";
	document.getElementById("txtBalance").value=totShortage.toFixed(2);
	document.getElementById("txtEstim").value=totEstimate.toFixed(2);
	document.getElementById("txtAct").value=totActual.toFixed(2);
	document.getElementById("divbalance").innerHTML=balanceto;
	if(totShortage>0)
		balanceto="from wharf clerk.";
	else if(totShortage<0)
		balanceto="to wharf clerk.";
	document.getElementById("divbalance").innerHTML=balanceto;
	var settingdate=new Date()
	var stday=settingdate.getDate();
	var stmonth=settingdate.getMonth()+1;
	var styear=settingdate.getFullYear();
	var CurrentDate=stday+"/"+stmonth+"/"+styear;
	document.getElementById("txtSettingDate").value=CurrentDate;
	
 //document.getElementById('confirmReport').style.visibility="";  

}

function closePOP()
{
	document.getElementById('confirmReport').innerHTML = document.getElementById("rptconfirm").innerHTML;
	closeWindow();
	closeWindow();
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
	document.getElementById("txtLC").value ="";
	document.getElementById("txtReason").value ="";
	 
}

function dosettle()
{
drawPopupArea(201,55,'prgss');	
	document.getElementById("prgss").innerHTML =document.getElementById('savingprogress').innerHTML;

createNewXMLHttpRequest(3);
var iouno =document.getElementById("cboiouno").value;
xmlHttp[3].onreadystatechange=function()
			{
			if(xmlHttp[3].readyState==4 && xmlHttp[2].status==200)
			{
				if(xmlHttp[3].responseText=='settled')
					{	
						
						alert("Successfully settled.");
						closePOP();	
						//setTimeout("location.reload(true);",100);	
						document.getElementById("butSave").style.visibility="hidden";	
						document.getElementById("butSettle").style.visibility="hidden";
						document.getElementById("divstl").style.visibility="hidden";	
					}			
			}
			}
	
	xmlHttp[3].open("GET",'ioudb.php?REQUEST=settleiou&iouno=' + iouno ,true);
	xmlHttp[3].send(null);			
	
		

}

function frmReload()
{
setTimeout("location.reload(true);",100);	

}
