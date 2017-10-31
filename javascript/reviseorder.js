// JavaScript Document
var xmlHttp;
function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}
function GetPendingPreOders()
{    
	
	var CompanyID = document.getElementById('cboFactory').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePreoderApprove;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=ToBeRevise&companyID=' + CompanyID, true);
    xmlHttp.send(null);     
}

function HandlePreoderApprove()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLStyleID = xmlHttp.responseXML.getElementsByTagName("StyleID");
			 var XMLDescription = xmlHttp.responseXML.getElementsByTagName("Description");
			 var XMLDate = xmlHttp.responseXML.getElementsByTagName("Date");
			 var XMLAppDate = xmlHttp.responseXML.getElementsByTagName("AppDate");
			 var XMLDoneBy = xmlHttp.responseXML.getElementsByTagName("DoneBy");
			 var XMLApproveBy = xmlHttp.responseXML.getElementsByTagName("ApproveBy");
			 
			 RemoveAllRows();
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var styleID = XMLStyleID[loop].childNodes[0].nodeValue;
				var description = XMLDescription[loop].childNodes[0].nodeValue;
				var date = XMLDate[loop].childNodes[0].nodeValue;
				var appdate = XMLAppDate[loop].childNodes[0].nodeValue;
				var doneby = XMLDoneBy[loop].childNodes[0].nodeValue;
				var approvedby = XMLApproveBy[loop].childNodes[0].nodeValue;
				
				
				var tbl = document.getElementById('tblPreOders');
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				
				var cellConPc = row.insertCell(0);
				cellConPc.innerHTML = styleID;
				
				var cellConPc = row.insertCell(1);
				cellConPc.innerHTML = appdate;
				
				var cellConPc = row.insertCell(2);
				cellConPc.innerHTML = doneby;
				
				var cellConPc = row.insertCell(3);
				cellConPc.innerHTML = approvedby;
				
				var cellDelete = row.insertCell(4);     
				var delImage = new Image(); 
				delImage.src = "images/revise.png";
				delImage.id = styleID;
				delImage.onclick = viewReport;
				cellDelete.appendChild(delImage);

				
				
			 }
			
		}
	}
}

function viewReport()
{
	var styleID = this.id;
	location="ReviceConfirm.php?styleID=" + URLEncode(styleID);
}

function GetTargetPreOders()
{    
	
	var styleNo = document.getElementById('txtstyle').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePreoderApprove;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=ToBeRevise&styleID=' + URLEncode(styleNo), true);
    xmlHttp.send(null);     
}


function RemoveAllRows()
{
	var tbl = document.getElementById('tblPreOders');
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function ConfirmReviceOrder(obj)
{
	var styleID = obj.id;
	var reason =document.getElementById('txtRemarks').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleReviceOrder;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=UpdateRevice&styleID=' + URLEncode(styleID) + '&ReviseReason=' + URLEncode(reason), true);
    xmlHttp.send(null);  	
}

function HandleReviceOrder()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("The style is ready for revision.");
				window.location = "editpreorder.php?StyleNo=" + URLEncode(currentStyleNo);
			}
			else
			{
				alert("Order process failed. Confirmed Invoice Costing available for this style.");
				return;
			}
		}
	}
}