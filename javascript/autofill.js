var xmlHttpFill;
var requiredElement = null;

function createAutoFillXMLHttpRequest()
{
    if (window.ActiveXObject) 
    {
        xmlHttpFill = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpFill = new XMLHttpRequest();
    }
}

function GetAutoComplete(evt,text,url,element)
{
	
	requiredElement = element;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode == 40)
	{
		document.getElementById("lstItems").focus();
		return ;
	}
	RemoveCurrentItems();
	if (trim(text) == "" || trim(text) == null ||  charCode == 27 )
	{
		closeList();
		return;
	}
	
	createAutoFillXMLHttpRequest();
   xmlHttpFill.onreadystatechange = HandleItemList;
   xmlHttpFill.open("GET", url + 'Input=' + URLEncode(text), true);
   xmlHttpFill.send(null);     
   
}

function HandleItemList()
{
	if(xmlHttpFill.readyState == 4) 
    {
        if(xmlHttpFill.status == 200) 
        {  
			
			if (document.getElementById("lstItems") == null)
			{
				var html = "<div id=\"listDiv\" style=\"width:200px; height:150px\">" +
							"<select name=\"select\" size=\"1\" onblur=\"closeList();\" id=\"lstItems\" class=\"txtbox\" onkeydown=\"ItemListKeyEventHandler(event)\" onchange=\"AddSetlectedItemToBox();\" style=\"width:200px; height:150px\" multiple=\"multiple\"></select></div>";
				
				var popupbox = document.createElement("div");
				 popupbox.id = "items";
				 popupbox.style.position = 'absolute';
				 popupbox.style.zIndex = 15;
				 popupbox.style.left = curLeft(document.getElementById(requiredElement)) + "px";
				 popupbox.style.top = eval(curTop(document.getElementById(requiredElement)) + document.getElementById(requiredElement).offsetHeight) + "px"; 
				 popupbox.innerHTML = html;     
				 popupbox.ondblclick = closeList;
				 document.body.appendChild(popupbox);
			}
			 
			 //var available = false;
			 var XMLVals = xmlHttpFill.responseXML.getElementsByTagName("Value");
 			 var XMLText = xmlHttpFill.responseXML.getElementsByTagName("Text");
			 
			 if(XMLVals.length==0)
			 	closeList();	
			 //alert(XMLVals.length);
			 for ( var loop = 0; loop < XMLVals.length; loop ++)
			 {
				 //available = true;
				 var opt = document.createElement("option");
				opt.text = XMLText[loop].childNodes[0].nodeValue;
				opt.value = XMLVals[loop].childNodes[0].nodeValue;
				document.getElementById("lstItems").options.add(opt);				
			 }
			 
			 //if (available == false)
			 	//closeList();			
		}
	}
}

function curLeft(obj){
	toreturn = 0;
	while(obj){
		toreturn += obj.offsetLeft;
		obj = obj.offsetParent;
	}
	return toreturn;
}

function curTop(obj){
	toreturn = 0;
	while(obj){
		toreturn += obj.offsetTop;
		obj = obj.offsetParent;
	}
	return toreturn;
}

function AddSetlectedItemToBox()
{
	document.getElementById(requiredElement).value = document.getElementById("lstItems").options[document.getElementById("lstItems").selectedIndex].text;
}

function closeList()
{
	try
	{
		var box = document.getElementById('items');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function RemoveCurrentItems()
{
	if (document.getElementById("lstItems") == null) return;
	document.getElementById("lstItems").options.length = 0;
	while(document.getElementById("lstItems").options.length > 0) 
	{
		index --;
		document.getElementById("lstItems").options[index] = null;
	}
}

function ItemListKeyEventHandler(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode == 8)
	{
		document.getElementById(requiredElement).focus();
	}
	//alert("charCode"+charCode);
	if(charCode == 13||charCode == 9) closeList();
}