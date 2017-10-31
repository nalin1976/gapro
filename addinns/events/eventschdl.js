
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

function validateEvent()
{
	if (document.getElementById('txtevent').value == "" )	
	{
		alert("Please enter the Event Eame");
		return false;
	}
	return true;
}

function AddEvents()
{
	if (validateEvent())
	{
		var eventName = document.getElementById('txtevent').value;
		createXMLHttpRequest();
    	xmlHttp.onreadystatechange = HandleSaving;
    	xmlHttp.open("GET", 'eventSchdlGet.php?RequestType=SaveEvent&EventName=' + encodeURIComponent(eventName) , true);
    	xmlHttp.send(null);
	}
}

function HandleSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
				AddNameToTable(document.getElementById('txtevent').value);
				alert("The event saved successfully.");	
				document.getElementById('txtevent').value = "";
				document.getElementById('txtevent').focus();
			}
			else
			{
				alert("The event name already exists.");	
				document.getElementById('txtevent').focus();
			}
		}		
	}
}

function AddNameToTable(name)
{
	var tbl = document.getElementById('tblEvents');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellEvents = row.insertCell(0);     
	cellEvents.className="normalfntSM";
	cellEvents.innerHTML = name;
}

			
	//--------------------------------------report------------------------------------------
	
	function loadReport(){ 
		window.open("EventShedReport.php?cbogrn"); 
   }
