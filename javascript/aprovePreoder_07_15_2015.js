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
	document.getElementById('txtstyle').value = "";
	document.getElementById('frmstyles').submit();
	return;
	var CompanyID = document.getElementById('cboFactory').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePreoderApprove;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetApproved&CompanyID=' + CompanyID, true);
    xmlHttp.send(null);     
}

function HandlePreoderApprove()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLStyleID = xmlHttp.responseXML.getElementsByTagName("StyleID");
			 var XMLDate = xmlHttp.responseXML.getElementsByTagName("Date");
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("Name");
			 RemoveAllRows();
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var styleID = XMLStyleID[loop].childNodes[0].nodeValue;
				var date = XMLDate[loop].childNodes[0].nodeValue;
				var doneby = XMLName[loop].childNodes[0].nodeValue;
				
				
				var tbl = document.getElementById('tblPreOders');
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				
				var cellConPc = row.insertCell(0);
				cellConPc.innerHTML = styleID;
				
				var cellConPc = row.insertCell(1);
				cellConPc.innerHTML = date;
				
				var cellConPc = row.insertCell(2);
				cellConPc.innerHTML = doneby;
				
				var cellDelete = row.insertCell(3);     
				var delImage = new Image(); 
				delImage.src = "images/view.png";
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
	location=reportName + "?styleID=" + URLEncode(styleID);
}

function GetTargetPreOders()
{    
	document.getElementById('frmstyles').submit();
	return;
	var styleNo = document.getElementById('txtstyle').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePreoderApprove;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetTargetStyle&StyleNo=' + URLEncode(styleNo), true);
    xmlHttp.send(null);     
}

function ApprovePreOders(styleID,UserID, prmCMUM, prmOrderNo)
{
	var styleID=styleID;
	var UserID=UserID;
	var Remarks=document.getElementById('txtRemarks').value;
	
	if(prmCMUM.toFixed(4) < 0.0511){
		alert(" CM/UM value is less than 0.0511 for style " + prmOrderNo);	
	}
	
	location="approvedResult.php?StyleID="+ URLEncode(styleID) +"&UesrID="+UserID+"&Remarks="+ URLEncode(Remarks) +"&AppState=1";	
}
function FirstApprovePreOders(styleID,UserID)
{
	var styleID=styleID;
	var UserID=UserID;
	var Remarks=document.getElementById('txtRemarks').value;
	location="approvedResult.php?StyleID="+ URLEncode(styleID) +"&UesrID="+UserID+"&Remarks="+ URLEncode(Remarks) +"&AppState=2";	
}
function RejectPreOders(styleID,UserID)
{
	var styleID=styleID;
	var UserID=UserID;
	var Remarks=document.getElementById('txtRemarks').value;
	location="approvedResult.php?StyleID="+ URLEncode(styleID) +"&UesrID="+UserID+"&Remarks="+ URLEncode(Remarks) +"&AppState=0";
}

function RemoveAllRows()
{
	var tbl = document.getElementById('tblPreOders');
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}
	
}