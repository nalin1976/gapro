//COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON
var  xmlHttp=[];
var delcell="";
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

//COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON>>COMMON



function addtogrid()
{
	if(document.getElementById("txtAmount").value!="")
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
			rowcell.innerHTML=document.getElementById("txtAccountName").value;;
			rowcell.id=document.getElementById('cmbWharf').value;
			
			var rowcell=row.insertCell(2);
			rowcell.className='normalfntRite';
			rowcell.innerHTML=document.getElementById("txtAccountNo").value;
			
			var rowcell=row.insertCell(3);
			rowcell.innerHTML=document.getElementById("txtAmount").value;
			rowcell.className='normalfntRite';
			
			document.getElementById("txtTotal").value=parseFloat(document.getElementById("txtTotal").value)+parseFloat(document.getElementById("txtAmount").value);0		
			cleardetails();
			
	}
}

function cleardetails()
{
	document.getElementById("cmbWharf").value="";
	document.getElementById("txtAccountName").value="";
	document.getElementById("txtAccountNo").value="";
	document.getElementById("txtAmount").value="";
}

function removeRow(dz)
{
	var rw=dz.parentNode.parentNode.rowIndex;
	var tbl=document.getElementById("tblDetail");
	tbl.deleteRow(rw);
	document.getElementById("txtTotal").value=parseFloat(document.getElementById("txtTotal").value)-parseFloat(dz.parentNode.parentNode.childNodes[3].childNodes[0].nodeValue);
}

function newFrm()
{
	newno();
	deleterows("tblDetail");
	cleardetails();
	document.getElementById("cmbBank").value="";
			var currentTime = new Date();
			var month = currentTime.getMonth() + 1;
			var day = currentTime.getDate();
			var year = currentTime.getFullYear();
	document.getElementById("txtDate").value= day+ "/" + month + "/" + year;
	document.getElementById("txtTotal").value="";
	document.getElementById("cellsave").innerHTML=delcell;
}

 function newno()
{
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
	{
		if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
		{
			
			document.getElementById("txtSerail").value="TRF-"+xmlHttp[1].responseText;
		}
		
	}
	xmlHttp[1].open("GET",'fundtransferdb.php?request=newNo',true);
	xmlHttp[1].send(null);	
}

function deleterows(tableName)
	{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	
	

function saveForm()
{	
	if (formValidate())
	{
		delcell=document.getElementById("cellsave").innerHTML;
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
		if(document.getElementById("cmbBank").value=="" ){
			alert("Please select a Bank.");
			document.getElementById("cmbBank").focus();
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
	var bank=document.getElementById("cmbBank").value;
	var formSerial=document.getElementById("txtSerail").value;
	var totamt=document.getElementById("txtTotal").value;
	
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
			xmlHttp[9].open("GET",'fundtransferdb.php?request=saveHeader&bank='+bank+'&formDate='+formDate+'&totamt='+totamt+'&formSerial='+formSerial,true);
			xmlHttp[9].send(null);	

}

function saveDetails()
{
	var tbl=document.getElementById("tblDetail"); 
	var length=tbl.rows.length;
	
	
	
	for(var loop=1; loop<length; loop++)
	{
				
		
		var frmSerial=document.getElementById("txtSerail").value;
		var amount=tbl.rows[loop].cells[3].childNodes[0].nodeValue;
		var warfclerk=tbl.rows[loop].cells[1].id;
		var accountname=tbl.rows[loop].cells[1].childNodes[0].nodeValue;
		var accountno=tbl.rows[loop].cells[2].childNodes[0].nodeValue;
				
						createNewXMLHttpRequest(10);
						
						xmlHttp[10].onreadystatechange=function()
						{
							if(xmlHttp[10].readyState==4 && xmlHttp[10].status==200)
								{
									
										
								}
							
						}	
						xmlHttp[10].open("GET","fundtransferdb.php?request=saveDetail&frmSerial="+frmSerial+'&amount='+amount+'&warfclerk='+warfclerk+'&accountno='+accountno+'&accountname='+accountname,true);
						xmlHttp[10].send(null);		
						
			
	
	}
		
		hideBackGroundBalck();										
		alert("Successfully saved!");
		
}

function printNote()
{
	var frmserial=document.getElementById("txtSerail").value;
	window.open("rptfundtransfer.php?frmserial="+frmserial);	
	
}