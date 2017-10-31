//COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON
var  xmlHttp=[];

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

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 1) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

//COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON

function rowclickColorChangetbl()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById(this.id);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		   
		
		
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
		else tbl.rows[i].className="bcgcolor-tblrowWhite";		
	}
	
}


function viewIOU()
{
	
	var customerid=document.getElementById("cmbCustomer").value;	
	if(customerid!="")
		{	
			RomoveData("cmbIOU");
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
						if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
						{
							var XMLiou=xmlHttp[0].responseXML.getElementsByTagName('IOUNo');
							for (var loop=0; loop<XMLiou.length;loop++)
							{
									var opt 	= document.createElement("option");
									opt.text 	= XMLiou[loop].childNodes[0].nodeValue;
									opt.value 	= XMLiou[loop].childNodes[0].nodeValue;
									document.getElementById("cmbIOU").options.add(opt);
							}
						}	
			}
			xmlHttp[0].open("GET",'creditdebitnotedb.php?request=getIOU&customerid='+customerid,true);
			xmlHttp[0].send(null);	
		
		}

}


function addtogrid()
{
	if(document.getElementById("txtTotal").value!="")
	{
			var tbl=document.getElementById("tblDetail");
			var lastrow=tbl.rows.length;
			var row=tbl.insertRow(lastrow);
			
			row.className="bcgcolor-tblrowWhite";		
			row.onclick=rowclickColorChangetbl;
			row.id="tblDetail";
			
			var rowcell=row.insertCell(0);
			rowcell.align="center";
			rowcell.innerHTML="<img src=\"../../../images/del.png\"onclick=\"removeRow(this)\"class=\"mouseover\"id=\""+lastrow+"\"width=\"15\"height=\"15\"/>";
			rowcell.height='15';
			
			var rowcell=row.insertCell(1);
			rowcell.innerHTML=document.getElementById("cmbIOU").value+" "+document.getElementById("txtDescription").value;
			rowcell.id=document.getElementById('cmbIOU').value;
			
			var rowcell=row.insertCell(2);
			rowcell.className='normalfntRite';
			rowcell.innerHTML=document.getElementById("txtAmount").value;
			
			var rowcell=row.insertCell(3);
			rowcell.innerHTML=document.getElementById("txtVat").value;
			rowcell.className='normalfntRite';
			
			var rowcell=row.insertCell(4);
			rowcell.innerHTML=document.getElementById("txtTotal").value;
			rowcell.className='normalfntRite';
			
			cleardetails();
			
	}
}


function setvat()
{
	if(document.getElementById("txtAmount").value!="" && parseFloat(document.getElementById("txtAmount").value)>0)
	document.getElementById("txtVat").value=parseFloat(document.getElementById("txtAmount").value)*parseFloat(document.getElementById("amtVat").value)/100;
}

function settotal()
{	if(document.getElementById("txtAmount").value!="" && parseFloat(document.getElementById("txtAmount").value)>0)
	document.getElementById("txtTotal").value=parseFloat(document.getElementById("txtAmount").value)+parseFloat(document.getElementById("txtVat").value);
}

function removeRow(dz)
{
	var rw=dz.parentNode.parentNode.rowIndex;
	var tbl=document.getElementById("tblDetail");
	tbl.deleteRow(rw);
}


function NewNo()
{
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
	{
		if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
		{
			if (document.getElementById("rdoCredit").checked==true)
			document.getElementById("txtSerail").value="CRN-"+xmlHttp[1].responseText;
			else if(document.getElementById("rdoDebit").checked==true)
			document.getElementById("txtSerail").value="DN-"+xmlHttp[1].responseText;
		}
		
	}
	xmlHttp[1].open("GET",'creditdebitnotedb.php?request=newNo',true);
	xmlHttp[1].send(null);	
}

function cleardetails()
{
	document.getElementById("cmbIOU").value="";
	document.getElementById("txtDescription").value="";
	document.getElementById("txtAmount").value="";
	document.getElementById("txtVat").value="";
	document.getElementById("txtTotal").value="";
}

function saveForm()
{	
	if (formValidate())
	{
		document.getElementById("cellsave").innerHTML="<img src=\"../../../images/save-confirm_fade.png\"/>";
		saveHeader();
	}
}

function formValidate()
{
		if(document.getElementById("txtSerail").value=="" ){
			alert("Please select the note type.");
			return false;
		}
		if(document.getElementById("cmbCustomer").value=="" ){
			alert("Please select a customer.");
			document.getElementById("cmbCustomer").focus();
			return false;
		}
		if(document.getElementById("tblDetail").rows.length<2 ){
			alert("There are no records in the grid.");
			return false;
		}		
		else 
			return true;
}


function saveHeader()
{
	var formDate=document.getElementById("txtDate").value;
	var customer=document.getElementById("cmbCustomer").value;
	var formSerial=document.getElementById("txtSerail").value;
	if (document.getElementById("rdoCredit").checked==true)
	var notetype="C";
	else if(document.getElementById("rdoDebit").checked==true)
	var notetype="D";
			//document.getElementById("cellsave").innerHTML="<img src=\"../../../images/save-confirm_fade.png\"/>";
			showBackGroundBalck();	
			createNewXMLHttpRequest(9);
			xmlHttp[9].onreadystatechange=function()
					{
						if(xmlHttp[9].readyState==4 && xmlHttp[9].status==200)
							{
								if(xmlHttp[9].responseText!="")
								{
									 saveDetails();
								
								}
							}
						
					}	
			xmlHttp[9].open("GET",'creditdebitnotedb.php?request=saveHeader&customer='+customer+'&formDate='+formDate+'&formSerial='+formSerial+'&notetype='+notetype,true);
			xmlHttp[9].send(null);	

}


function saveDetails()
{
	var tbl=document.getElementById("tblDetail"); 
	var length=tbl.rows.length;
	
	
	
	for(var loop=1; loop<length; loop++)
	{
				
		
		var receiptSerialNo=document.getElementById("txtSerail").value;
		var amount=tbl.rows[loop].cells[2].childNodes[0].nodeValue;
		var iouno=tbl.rows[loop].cells[1].id;
		var description=tbl.rows[loop].cells[1].childNodes[0].nodeValue;
		var vat=tbl.rows[loop].cells[3].childNodes[0].nodeValue;
		var total=tbl.rows[loop].cells[4].childNodes[0].nodeValue;
		if (document.getElementById("rdoCredit").checked==true)
		var notetype="C";
		else if(document.getElementById("rdoDebit").checked==true)
		var notetype="D";	
						createNewXMLHttpRequest(10);
						
						xmlHttp[10].onreadystatechange=function()
						{
							if(xmlHttp[10].readyState==4 && xmlHttp[10].status==200)
								{
									
										
								}
							
						}	
						xmlHttp[10].open("GET","creditdebitnotedb.php?request=saveDetail&receiptSerialNo="+receiptSerialNo+'&amount='+amount+'&iouno='+iouno+'&vat='+vat+'&total='+total+'&description='+description+'&notetype='+notetype,true);
						xmlHttp[10].send(null);		
						
			
	
	}
		
		hideBackGroundBalck();										
		alert("Successfully saved!");
		
}


function printNote()
{
	var noteno=document.getElementById("txtSerail").value;
	window.open('rptcreditdebitnote.php?noteno='+noteno);
	
}