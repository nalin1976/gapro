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

function submitForm()
{
	document.frmcomplete.submit();
}

function changeInspection(obj)
{
	createXMLHttpRequest();
	var status = 0;
	var catID = obj.id;
	if (obj.checked)
	{
		status = 1;
	}
	else
	{
		status = 0;
	}
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET", 'wizardmiddle.php?str=changeInspection&catID=' + catID + '&status=' + status, true);
   xmlHttp.send(null);
}

function changeAdditionalAllowed(obj)
{
	createXMLHttpRequest();
	var status = 0;
	var catID = obj.id;
	if (obj.checked)
	{
		status = 1;
	}
	else
	{
		status = 0;
	}
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET", 'wizardmiddle.php?str=changeAdditional&catID=' + catID + '&status=' + status, true);
   xmlHttp.send(null);
}

function stateChanged() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
        		if(xmlHttp.responseText.indexOf("connect") > -1)
				{
					alert("Sorry your session has been timed out. No changes will be applied.\nPlease try again with new session.");
				}
        }
    }
}